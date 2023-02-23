<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MagangModel;
use App\Models\PengajuanAnggotaModel;
use App\Models\PengajuanModel;
use App\Models\SiswaModel;
use App\Models\UsersModel;

class PengajuanController extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session']);
    }

    public function index()
    {
        $data['activePage'] = 'siswaPengajuan';

        $id = session()->get('id');

        $siswa = new SiswaModel();
        $siswaDetail = $siswa->where('users_id', $id)->where('status_hapus', 'tidak')->first();

        $data['siswa'] = $siswaDetail;

        $pengajuan = new PengajuanModel();
        $data['pengajuan'] = $pengajuan->where('siswa_id', $siswaDetail['id'])->findAll();

        if ($siswaDetail['status_lengkap'] == 'tidak') {
            return view('siswa/error/profilError', $data);
        } else {
            return view('siswa/pengajuan/index', $data);
        }
    }

    public function store()
    {
        $data = $this->request->getPost();

        $validation =  \Config\Services::validation();
        $validation->setRules([
            'mulai' => [
                'label' => 'Tanggal Mulai',
                'rules' => 'required'
            ],
            'selesai' => [
                'label' => 'Tanggal Selesai',
                'rules' => 'required'
            ],
            'proposal' => [
                'label' => 'File Proposal',
                'rules' => 'uploaded[proposal]|max_size[proposal,5120]|ext_in[proposal,pdf]'
            ],
            'surat' => [
                'label' => 'File Surat',
                'rules' => 'uploaded[surat]|max_size[surat,5120]|ext_in[surat,pdf]'
            ],
        ]);

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('siswa/pengajuan'));
        }

        $getPengajuan = new PengajuanModel();
        $kondisi = $getPengajuan->where('siswa_id', $data['id'])->findAll();

        if ($kondisi) {
            foreach ($kondisi as $value) {
                if ($value['status_pengajuan'] == 'diproses') {
                    session()->setFlashdata("warning", 'Pengajuan magang anda masih diproses. Mohon tunggu hingga dikonfirmasi oleh admin, sebelum mengajukan kembali.');
                    return redirect()->to(base_url('siswa/pengajuan'));
                } else if ($value['status_pengajuan'] == 'diterima') {
                    $cekMagang = new MagangModel();
                    $cekKondisiMagang = $cekMagang->where('pengajuan_id', $value['id'])->where('status_hapus', 'tidak')->first();
                    if (!$cekKondisiMagang) {
                        session()->setFlashdata("warning", 'Pengajuan anda sudah diterima dan belum ditindaklanjuti oleh admin. Mohon tunggu hingga ditindaklanjuti oleh admin, sebelum mengajukan kembali.');
                        return redirect()->to(base_url('siswa/pengajuan'));
                    }
                }
            }
        }

        $getMagang = new MagangModel();
        $kondisiMagang = $getMagang->where('siswa_id', $data['id'])->where('status_hapus', 'tidak')->findAll();

        if ($kondisiMagang) {
            foreach ($kondisiMagang as $value) {
                if ($value['status_magang'] == 'berjalan') {
                    session()->setFlashdata("warning", 'Anda sudah diterima magang dan sedang dalam masa magang. Mohon tunggu hingga magang selesai, sebelum mengajukan kembali.');
                    return redirect()->to(base_url('siswa/pengajuan'));
                }
            }
        }

        //Get the uploaded file
        $proposal = $this->request->getFile('proposal');
        $surat = $this->request->getFile('surat');

        // Check if the file was uploaded successfully
        if ($proposal->isValid() && !$proposal->hasMoved() || $surat->isValid() && !$surat->hasMoved()) {
            // Move the file to a new location
            $nameProposal =  time() . $proposal->getName();
            $nameSurat =  time() . $surat->getName();

            $proposal->move(FCPATH . 'assets/file/pengajuan', $nameProposal);
            $surat->move(FCPATH . 'assets/file/pengajuan', $nameSurat);
        }

        $dataPengajuan = [
            'siswa_id' => $data['id'],
            'tanggal_mulai' => $data['mulai'],
            'tanggal_selesai' => $data['selesai'],
            'file_proposal' => $nameProposal,
            'file_surat_pengajuan' => $nameSurat
        ];

        $pengajuan = new PengajuanModel();
        $pengajuan->insertPengajuan($dataPengajuan);
        $pengajuan_id = $pengajuan->getInsertID();

        for ($count = 0; $count < count($data['nama_anggota']); $count++) {
            if (isset($data['nama_anggota'][$count]) && trim($data['nama_anggota'][$count]) !== '') {

                $nama = $data['nama_anggota'][$count];
                $jk = $data['jk'][$count];

                $words = explode(" ", $nama);
                $first_word = $words[0] . random_int(11111, 99999);

                // Insert User
                $dataUser = [
                    'username' => $first_word,
                    'password' => password_hash($first_word, PASSWORD_DEFAULT),
                    'role' => 'siswa',
                    'status' => 'nonaktif'
                ];
                $user = new UsersModel();
                $user->insertUser($dataUser);
                $user_id = $user->getInsertID();

                // Insert Siswa
                $dataSiswa = [
                    'users_id' => $user_id,
                    'nama' => $nama,
                    'jenis_kelamin' => $jk,
                ];
                $siswa = new SiswaModel();
                $siswa->insertSiswa($dataSiswa);
                $siswa_id = $siswa->getInsertID();

                // Insert Anggota
                $dataAnggota = [
                    'pengajuan_id' => $pengajuan_id,
                    'siswa_id' => $siswa_id
                ];
                $anggota = new PengajuanAnggotaModel();
                $anggota->insertPengajuanAnggota($dataAnggota);
            } else {
                break;
            }
        }

        session()->setFlashdata("success", 'Berhasil mengajukan magang!');
        return redirect()->to(base_url('siswa/pengajuan'));
    }

    public function detail()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

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

            foreach ($dataAnggota as $value) {
                array_push($arrNama, $value['nama']);
            }

            $count = count($arrNama);

            $data = [
                'status' => 'success',
                'data' => $dataPengajuan,
                'anggota' => $arrNama,
                'jmlAnggota' => $count
            ];

            return $this->response->setJSON($data);
        }
    }

    public function indexAdmin()
    {
        $data['activePage'] = 'adminPengajuan';

        $pengajuan = new PengajuanModel();
        $data['pengajuan'] = $pengajuan->select('pengajuan.*, pengajuan.id AS id_pengajuan, siswa.*, siswa.id AS id_siswa')
            ->join('siswa', 'pengajuan.siswa_id = siswa.id')
            ->get()->getResultArray();

        return view('admin/pengajuan/index', $data);
    }

    public function validasiAdmin()
    {
        $data = $this->request->getPost();

        $id = $data['id'];

        $validation =  \Config\Services::validation();

        if ($data['validasiStatus'] == 'diterima') {
            $validation->setRules([
                'validasiStatus' => [
                    'label' => 'Status Pengajuan',
                    'rules' => 'required'
                ],
                'validasiCatatan' => [
                    'label' => 'Catatan',
                    'rules' => 'required'
                ],
                'suratBalasan' => [
                    'label' => 'File Surat Balasan',
                    'rules' => 'uploaded[suratBalasan]|max_size[suratBalasan,5120]|ext_in[suratBalasan,pdf]'
                ],
            ]);
        } else {
            $validation->setRules([
                'validasiStatus' => [
                    'label' => 'Status Pengajuan',
                    'rules' => 'required'
                ],
                'validasiCatatan' => [
                    'label' => 'Catatan',
                    'rules' => 'required'
                ]
            ]);
        }

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('admin/pengajuan'));
        }

        //Get the uploaded file
        $surat = $this->request->getFile('suratBalasan');

        // Check if the file was uploaded successfully
        if ($surat->isValid() && !$surat->hasMoved()) {
            // Move the file to a new location
            $nameSurat =  time() . $surat->getName();

            $surat->move(FCPATH . 'assets/file/pengajuan', $nameSurat);
        }

        $pengajuan = new PengajuanModel();
        if ($data['validasiStatus'] == 'diterima') {
            $dataPengajuan = [
                'file_surat_balasan' => $nameSurat,
                'status_pengajuan' => $data['validasiStatus'],
                'catatan' => $data['validasiCatatan'],
            ];
        } else {
            $dataPengajuan = [
                'status_pengajuan' => $data['validasiStatus'],
                'catatan' => $data['validasiCatatan'],
            ];
        }
        $pengajuan->updatePengajuan($dataPengajuan, $id);

        $anggota = new PengajuanAnggotaModel();
        $dataAnggota = $anggota->where('pengajuan_id', $id)->findAll();

        if ($data['validasiStatus'] == 'diterima') {
            if ($dataAnggota) {
                foreach ($dataAnggota as $value) {
                    $siswa = new SiswaModel();
                    $dataSiswa = $siswa->getSiswa($value['siswa_id']);

                    $user = new UsersModel();
                    $dataUser = [
                        'status' => 'aktif'
                    ];
                    $user->updateUser($dataUser, $dataSiswa['users_id']);
                }
            }
        }

        // PESAN WA

        session()->setFlashdata("success", 'Berhasil memperbarui data!');
        return redirect()->to(base_url('admin/pengajuan'));
    }
}
