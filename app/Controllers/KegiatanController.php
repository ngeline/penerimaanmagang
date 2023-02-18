<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KegiatanModel;
use App\Models\MagangModel;
use App\Models\SiswaModel;
use App\Models\PembimbingModel;
use App\Models\PengajuanModel;
use App\Models\PengajuanAnggotaModel;

class KegiatanController extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session']);
    }

    public function index()
    {
        $data['activePage'] = 'siswaKegiatan';

        $id = session()->get('id');

        $siswa = new SiswaModel();
        $siswaDetail = $siswa->where('users_id', $id)->first();

        $pengajuan = new PengajuanModel();
        $pengajuanDetail = $pengajuan->where('siswa_id', $siswaDetail['id'])->first();

        $magang = new MagangModel();
        $dataMagang = $magang->where('siswa_id', $siswaDetail['id'])->where('status_hapus', 'tidak')->findAll();

        if ($dataMagang) {
            $arrId = [];

            foreach ($dataMagang as $value) {
                array_push($arrId, $value['id']);

                if ($value['status_magang'] == 'berjalan') {
                    $dataId = $value['id'];
                } else {
                    $dataId = 0;
                }
            }
        } else {
            $arrId = ['0'];
            $dataId = 0;
        }

        $data['id_magang'] = $dataId;

        $kegiatan = new KegiatanModel();
        $data['list'] = $kegiatan->whereIn('magang_id', $arrId)->findAll();

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
                            return view('siswa/kegiatan/index', $data);
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
                                        return view('siswa/kegiatan/index', $data);
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

    public function store()
    {
        $data = $this->request->getPost();

        $validation =  \Config\Services::validation();

        $validation->setRules([
            'tanggal' => [
                'label' => 'Tanggal',
                'rules' => 'required'
            ],
            'kegiatan' => [
                'label' => 'Kegiatan',
                'rules' => 'required'
            ],
            'foto' => [
                'label' => 'Foto Kegiatan',
                'rules' => 'uploaded[foto]|max_size[foto,5120]|ext_in[foto,jpg,jpeg,png]'
            ],
        ]);

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('siswa/kegiatan'));
        }

        if ($data['id'] == 0) {
            session()->setFlashdata("warning", 'Anda tidak dapat menambahkan kegiatan dikarenakan status magang Anda sudah selesai');
            return redirect()->to(base_url('siswa/kegiatan'));
        }

        $model = new KegiatanModel();
        $kondisi = $model->where('magang_id', $data['id'])->where('tanggal', $data['tanggal'])->first();

        if ($kondisi) {
            session()->setFlashdata("warning", 'Kegiatan pada hari terpilih sudah Anda isi');
            return redirect()->to(base_url('siswa/kegiatan'));
        }

        $file = $this->request->getFile('foto');

        // Check if the file was uploaded successfully
        if ($file->isValid() && !$file->hasMoved()) {
            // Move the file to a new location
            $nameFile =  time() . $file->getName();

            $file->move(FCPATH . 'assets/file/kegiatan', $nameFile);
        }

        $data = [
            'magang_id' => $data['id'],
            'tanggal' => $data['tanggal'],
            'kegiatan' => $data['kegiatan'],
            'foto_kegiatan' => $nameFile,
        ];

        $model->insertKegiatan($data);

        session()->setFlashdata("success", 'Berhasil menambahkan data!');
        return redirect()->to(base_url('siswa/kegiatan'));
    }

    public function indexPembimbing()
    {
        $data['activePage'] = 'pembimbingKegiatan';

        $id = session()->get('id');

        $pembimbing = new PembimbingModel();
        $pembimbingDetail = $pembimbing->where('users_id', $id)->first();

        $magang = new MagangModel();
        $dataMagang = $magang->where('pembimbing_id', $pembimbingDetail['id'])->findAll();

        if ($dataMagang) {
            $arrId = [];

            foreach ($dataMagang as $value) {
                array_push($arrId, $value['id']);
            }
        } else {
            $arrId = ['0'];
        }

        $kegiatan = new KegiatanModel();
        $data['list'] = $kegiatan->select('kegiatan.*, magang.*, siswa.*, kegiatan.id AS id_kegiatan')
            ->join('magang', 'kegiatan.magang_id = magang.id')
            ->join('siswa', 'magang.siswa_id = siswa.id')
            ->whereIn('kegiatan.magang_id', $arrId)
            ->get()->getResultArray();

        return view('pembimbing/kegiatan/index', $data);
    }

    public function updatePembimbing()
    {
        $data = $this->request->getPost();

        $id = $data['id'];

        $validation =  \Config\Services::validation();

        $validation->setRules([
            'validasiStatus' => [
                'label' => 'Status Validasi Kegiatan',
                'rules' => 'required'
            ],
            'validasiCatatan' => [
                'label' => 'Catatan',
                'rules' => 'required'
            ],
        ]);

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('pembimbing/kegiatan'));
        }

        $data = [
            'status_kegiatan' => $data['validasiStatus'],
            'catatan' => $data['validasiCatatan'],
        ];

        $model = new KegiatanModel();
        $model->updateKegiatan($data, $id);

        session()->setFlashdata("success", 'Berhasil menambahkan data!');
        return redirect()->to(base_url('pembimbing/kegiatan'));
    }
}
