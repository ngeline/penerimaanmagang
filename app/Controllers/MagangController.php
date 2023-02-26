<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MagangModel;
use App\Models\PembimbingModel;
use App\Models\SiswaModel;
use App\Models\PengajuanModel;
use App\Models\PengajuanAnggotaModel;

class MagangController extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session']);
    }

    public function index()
    {
        $data['activePage'] = 'siswaMagang';

        $id = session()->get('id');

        $siswa = new SiswaModel();
        $siswaDetail = $siswa->where('users_id', $id)->where('status_hapus', 'tidak')->first();

        $pengajuan = new PengajuanModel();
        $pengajuanDetail = $pengajuan->where('siswa_id', $siswaDetail['id'])->first();

        $magang = new MagangModel();
        $data['list'] = $magang->select('bidang.*, pembimbing.*, pengajuan.*, magang.*, magang.id AS id_magang')
            ->join('pengajuan', 'magang.pengajuan_id = pengajuan.id')
            ->join('pembimbing', 'magang.pembimbing_id = pembimbing.id')
            ->join('bidang', 'pembimbing.bidang_id = bidang.id')
            ->where('magang.siswa_id', $siswaDetail['id'])
            ->where('magang.status_hapus', 'tidak')
            ->orderBy('magang.updated_at', 'desc')
            ->get()->getResultArray();

        // Jika Profil tidak lengkap
        if ($siswaDetail['status_lengkap'] == 'tidak') {
            return view('siswa/error/profilError', $data);
        } else {
            // Jika belum mengajukan && belum diterima
            if (!empty($pengajuanDetail) && $pengajuanDetail['status_pengajuan'] == 'diterima') {
                $magang = new MagangModel();
                $magangDetail = $magang->where('pengajuan_id', $pengajuanDetail['id'])->where('status_hapus', 'tidak')->findAll();

                // Jika belum ada data dimagang
                if ($magangDetail) {
                    foreach ($magangDetail as $value) {
                        if ($value['siswa_id'] == $siswaDetail['id']) {
                            return view('siswa/magang/index', $data);
                        }
                    }
                } else {
                    return view('siswa/error/magangError', $data);
                }
            } else {
                $anggota = new PengajuanAnggotaModel();
                $anggotaDetail = $anggota->where('siswa_id', $siswaDetail['id'])->findAll();

                if ($anggotaDetail) {
                    foreach ($anggotaDetail as $value) {
                        $cekPengajuan = new PengajuanModel();
                        $cekPengajuanDetail = $cekPengajuan->where('id', $value['pengajuan_id'])->first();

                        if (!empty($cekPengajuanDetail) && $cekPengajuanDetail['status_pengajuan'] == 'diterima') {
                            $magang = new MagangModel();
                            $magangDetail = $magang->where('pengajuan_id', $cekPengajuanDetail['id'])->where('status_hapus', 'tidak')->findAll();

                            // Jika belum ada data dimagang
                            if ($magangDetail) {
                                foreach ($magangDetail as $value) {
                                    if ($value['siswa_id'] == $siswaDetail['id']) {
                                        return view('siswa/magang/index', $data);
                                    }
                                }
                            } else {
                                return view('siswa/error/magangError', $data);
                            }
                        } else {
                            return view('siswa/error/pengajuanError', $data);
                        }
                    }
                } else {
                    return view('siswa/error/pengajuanError', $data);
                }
            }
        }
    }

    public function indexAdmin()
    {
        $data['activePage'] = 'adminMagang';

        $magang = new MagangModel();
        $data['list'] = $magang->select('magang.*, magang.id AS id_magang, pengajuan.*, pengajuan.id AS id_pengajuan, siswa.*, siswa.id AS id_siswa, siswa.nama AS nama_siswa, pembimbing.*, pembimbing.id AS id_pembimbing, s.*, s.id AS id_s, s.nama AS s_nama, pembimbing.nama AS nama_pembimbing')
            ->join('pengajuan', 'magang.pengajuan_id = pengajuan.id')
            ->join('siswa', 'magang.siswa_id = siswa.id')
            ->join('pembimbing', 'magang.pembimbing_id = pembimbing.id')
            ->join('siswa AS s', 'pengajuan.siswa_id = s.id')
            ->join('bidang', 'pembimbing.bidang_id = bidang.id')
            ->where('magang.status_hapus', 'tidak')
            ->orderBy('magang.updated_at', 'desc')
            ->get()->getResultArray();

        $pembimbing = new PembimbingModel();
        $data['pembimbing'] = $pembimbing->select('pembimbing.*, bidang.*, pembimbing.id AS id, bidang.id AS id_bidang')
            ->join('bidang', 'pembimbing.bidang_id = bidang.id')
            ->where('pembimbing.status_hapus', 'tidak')
            ->orderBy('pembimbing.nama', 'asc')
            ->get()->getResultArray();

        $pengajuan = new PengajuanModel();
        $data['pengajuan'] = $pengajuan->select('pengajuan.id AS id_pengajuan, pengajuan.created_at, siswa.nama AS nama_siswa, pengajuan.tanggal_mulai, pengajuan.tanggal_selesai')
            ->join('siswa', 'pengajuan.siswa_id = siswa.id')
            ->where('pengajuan.status_pengajuan', 'diterima')
            ->orderBy('pengajuan.tanggal_mulai', 'desc')
            ->get()->getResultArray();

        return view('admin/magang/index', $data);
    }

    public function storeAdmin()
    {
        $data = $this->request->getPost();

        $validation =  \Config\Services::validation();
        $validation->setRules([
            'pengajuan' => [
                'label' => 'List Pengajuan',
                'rules' => 'required'
            ],
            'daftarSiswa' => [
                'label' => 'Siswa Magang',
                'rules' => 'required'
            ],
            'pembimbing' => [
                'label' => 'Pembimbing Magang',
                'rules' => 'required'
            ],
        ]);

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('admin/magang'));
        }

        $magang = new MagangModel();
        $kondisi = $magang->where('pengajuan_id', $data['pengajuan'])->where('siswa_id', $data['daftarSiswa'])->where('status_hapus', 'tidak')->first();

        if ($kondisi) {
            session()->setFlashdata("warning", 'Pengajuan dan siswa yang dipilih sudah ada sebelumnya');
            return redirect()->to(base_url('admin/magang'));
        }

        $dataMagang = [
            'pengajuan_id' => $data['pengajuan'],
            'siswa_id' => $data['daftarSiswa'],
            'pembimbing_id' => $data['pembimbing']
        ];
        $magang->insertMagang($dataMagang);

        session()->setFlashdata("success", 'Berhasil menambahkan data!');
        return redirect()->to(base_url('admin/magang'));
    }

    public function updateAdmin()
    {
        $data = $this->request->getPost();

        $id = $data['id'];

        $validation =  \Config\Services::validation();
        $validation->setRules([
            'editPembimbing' => [
                'label' => 'Pembimbing Magang',
                'rules' => 'required'
            ],
            'editStatus' => [
                'label' => 'Status Magang',
                'rules' => 'required'
            ],
        ]);

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('admin/magang'));
        }

        $magang = new MagangModel();
        $dataMagang = [
            'pembimbing_id' => $data['editPembimbing'],
            'status_magang' => $data['editStatus'],
            'sertifikat' => $data['editSertifikat']
        ];
        $magang->updateMagang($dataMagang, $id);

        session()->setFlashdata("success", 'Berhasil memperbarui data!');
        return redirect()->to(base_url('admin/magang'));
    }

    public function deleteAdmin($id)
    {
        $magang = new MagangModel();

        $dataMagang = [
            'status_hapus' => 'hapus'
        ];

        $magang->updateMagang($dataMagang, $id);

        session()->setFlashdata("success", 'File Anda telah dihapus!');
        return redirect()->to(base_url('admin/magang'));
    }

    public function listSiswa()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            if ($id == 0) {
                $data = [
                    'status' => 'success',
                    'anggota' => '0',
                    'listSiswa' => '0'
                ];

                return $this->response->setJSON($data);
            }

            $pengajuan = new PengajuanModel();
            $dataPengajuan = $pengajuan->select('pengajuan.*,siswa.*')
                ->join('siswa', 'pengajuan.siswa_id = siswa.id')
                ->where('pengajuan.id', $id)
                ->get()->getResultArray();

            $anggota = new PengajuanAnggotaModel();
            $dataAnggota = $anggota->select('pengajuan_anggota.*,siswa.*')
                ->join('siswa', 'pengajuan_anggota.siswa_id = siswa.id')
                ->where('pengajuan_id', $id)
                ->get()->getResultArray();

            $arrNama = [];
            $arrId = [];

            $siswaPemohon = $dataPengajuan['0']['nama'];
            array_push($arrNama, $siswaPemohon);
            foreach ($dataAnggota as $value) {
                array_push($arrNama, $value['nama']);
            }

            $siswaPemohonId = $dataPengajuan['0']['siswa_id'];
            array_push($arrId, $siswaPemohonId);
            foreach ($dataAnggota as $value) {
                array_push($arrId, $value['siswa_id']);
            }

            $listSiswa = new SiswaModel();
            $getListSiswa = $listSiswa->select('siswa.id, siswa.nama')
                ->whereIn('id', $arrId)
                ->orderBy('nama', 'asc')
                ->get()->getResultArray();

            $data = [
                'status' => 'success',
                'anggota' => $arrNama,
                'listSiswa' => $getListSiswa
            ];

            return $this->response->setJSON($data);
        }
    }

    public function indexPembimbing()
    {
        $data['activePage'] = 'pembimbingMagang';

        $id = session()->get('id');

        $pembimbing = new PembimbingModel();
        $dataPembimbing = $pembimbing->where('users_id', $id)->where('status_hapus', 'tidak')->first();

        $magang = new MagangModel();
        $data['list'] = $magang->select('magang.*, magang.id AS id_magang, pengajuan.*, pengajuan.id AS id_pengajuan, siswa.*, siswa.id AS id_siswa, siswa.nama AS nama_siswa, pembimbing.nama AS nama_pembimbing')
            ->join('pengajuan', 'magang.pengajuan_id = pengajuan.id')
            ->join('siswa', 'magang.siswa_id = siswa.id')
            ->join('pembimbing', 'magang.pembimbing_id = pembimbing.id')
            ->where('pembimbing_id', $dataPembimbing['id'])
            ->where('magang.status_hapus', 'tidak')
            ->orderBy('magang.updated_at', 'desc')
            ->get()->getResultArray();

        return view('pembimbing/magang/index', $data);
    }
}
