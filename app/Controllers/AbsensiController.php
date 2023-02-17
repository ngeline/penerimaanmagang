<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AbsensiModel;
use App\Models\MagangModel;
use App\Models\SiswaModel;
use App\Models\PengajuanModel;
use App\Models\PengajuanAnggotaModel;

class AbsensiController extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session']);
    }

    public function index()
    {
        $data['activePage'] = 'siswaAbsensi';

        $id = session()->get('id');

        $siswa = new SiswaModel();
        $siswaDetail = $siswa->where('users_id', $id)->first();

        $pengajuan = new PengajuanModel();
        $pengajuanDetail = $pengajuan->where('siswa_id', $siswaDetail['id'])->first();

        $magang = new MagangModel();
        $dataMagang = $magang->where('siswa_id', $siswaDetail['id'])->findAll();

        if ($dataMagang) {
            $arrId = [];

            foreach ($dataMagang as $value) {
                array_push($arrId, $value['id']);

                if ($value['status_magang'] == 'berjalan') {
                    $dataId = $value['id'];
                }
            }
        } else {
            $arrId = ['0'];
            $dataId = 0;
        }

        $data['id_magang'] = $dataId;

        $absensi = new AbsensiModel();
        $data['list'] = $absensi->whereIn('magang_id', $arrId)->findAll();

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
                            return view('siswa/absensi/index', $data);
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
                                        return view('siswa/absensi/index', $data);
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

        $tanggal = date('Y-m-d');

        $model = new AbsensiModel();
        $kondisi = $model->where('magang_id', $data['id'])->where('tanggal', $tanggal)->first();

        if ($kondisi) {
            session()->setFlashdata("warning", 'Absensi hari ini sudah Anda isi');
            return redirect()->to(base_url('siswa/absensi'));
        }

        $validation =  \Config\Services::validation();

        if ($data['absensi'] == 'hadir') {
            $validation->setRules([
                'absensi' => [
                    'label' => 'Absensi',
                    'rules' => 'required'
                ],
                'foto' => [
                    'label' => 'Foto Absensi',
                    'rules' => 'uploaded[foto]|max_size[foto,5120]|ext_in[foto,jpg,jpeg,png]'
                ],
            ]);
        } else if ($data['absensi'] == 'izin') {
            $validation->setRules([
                'absensi' => [
                    'label' => 'Absensi',
                    'rules' => 'required'
                ],
                'izin' => [
                    'label' => 'Surat Izin',
                    'rules' => 'uploaded[izin]|max_size[izin,5120]|ext_in[izin,jpg,jpeg,png]'
                ],
            ]);
        } else {
            session()->setFlashdata("warning", 'Input anda tidak sesuai');
            return redirect()->to(base_url('siswa/absensi'));
        }

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('siswa/absensi'));
        }

        if ($data['absensi'] == 'hadir') {
            $file = $this->request->getFile('foto');

            // Check if the file was uploaded successfully
            if ($file->isValid() && !$file->hasMoved()) {
                // Move the file to a new location
                $nameFile =  time() . $file->getName();

                $file->move(FCPATH . 'assets/file/absensi', $nameFile);
            }

            $data = [
                'magang_id' => $data['id'],
                'tanggal' => $tanggal,
                'absen' => $data['absensi'],
                'foto_absensi' => $nameFile,
            ];
        } else if ($data['absensi'] == 'izin') {
            $file = $this->request->getFile('izin');

            // Check if the file was uploaded successfully
            if ($file->isValid() && !$file->hasMoved()) {
                // Move the file to a new location
                $nameFile =  time() . $file->getName();

                $file->move(FCPATH . 'assets/file/absensi', $nameFile);
            }

            $data = [
                'magang_id' => $data['id'],
                'tanggal' => $tanggal,
                'absen' => $data['absensi'],
                'file_surat_izin' => $nameFile,
            ];
        }

        $model->insertAbsensi($data);

        session()->setFlashdata("success", 'Berhasil menambahkan data!');
        return redirect()->to(base_url('siswa/absensi'));
    }

    public function indexAdmin()
    {
        $data['activePage'] = 'adminAbsensi';

        $absensi = new AbsensiModel();
        $data['list'] = $absensi->select('absensi.*, magang.*, siswa.*, absensi.id AS id_absensi')
            ->join('magang', 'absensi.magang_id = magang.id')
            ->join('siswa', 'magang.siswa_id = siswa.id')
            ->get()->getResultArray();

        return view('admin/absensi/index', $data);
    }

    public function updateAdmin()
    {
        $data = $this->request->getPost();

        $id = $data['id'];

        $validation =  \Config\Services::validation();

        $validation->setRules([
            'validasiStatus' => [
                'label' => 'Status Validasi Absensi',
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
            return redirect()->to(base_url('admin/absensi'));
        }

        $data = [
            'status_absen' => $data['validasiStatus'],
            'catatan' => $data['validasiCatatan'],
        ];

        $model = new AbsensiModel();
        $model->updateAbsensi($data, $id);

        session()->setFlashdata("success", 'Berhasil menambahkan data!');
        return redirect()->to(base_url('admin/absensi'));
    }
}
