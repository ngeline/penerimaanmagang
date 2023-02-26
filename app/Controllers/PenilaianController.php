<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MagangModel;
use App\Models\SiswaModel;
use App\Models\PembimbingModel;
use App\Models\PengajuanModel;
use App\Models\PengajuanAnggotaModel;
use App\Models\PenilaianKategoriModel;
use App\Models\PenilaianModel;

class PenilaianController extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session']);
    }

    public function index()
    {
        $data['activePage'] = 'siswaPenilaian';

        $id = session()->get('id');

        $siswa = new SiswaModel();
        $siswaDetail = $siswa->where('users_id', $id)->where('status_hapus', 'tidak')->first();

        $pengajuan = new PengajuanModel();
        $pengajuanDetail = $pengajuan->where('siswa_id', $siswaDetail['id'])->first();

        $magang = new MagangModel();
        $dataMagang = $magang->where('siswa_id', $siswaDetail['id'])->where('status_hapus', 'tidak')->findAll();

        if ($dataMagang) {
            $arrId = [];

            foreach ($dataMagang as $value) {
                array_push($arrId, $value['id']);
            }
        } else {
            $arrId = ['0'];
        }

        $penilaian = new PenilaianModel();
        $data['list'] = $penilaian->select('penilaian.magang_id, pengajuan.tanggal_mulai, pengajuan.tanggal_selesai')
            ->selectSum('nilai', 'total_sum')
            ->join('magang', 'penilaian.magang_id = magang.id')
            ->join('pengajuan', 'magang.pengajuan_id = pengajuan.id')
            ->whereIn('penilaian.magang_id', $arrId)
            ->groupBy('penilaian.magang_id')
            ->get()->getResultArray();

        $kategori = new PenilaianKategoriModel();
        $data['kategori'] = $kategori->where('status_hapus', 'tidak')->orderBy('updated_at', 'desc')->findAll();

        $data['count'] = count($data['kategori']);

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
                            return view('siswa/penilaian/index', $data);
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
                                        return view('siswa/penilaian/index', $data);
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

    public function indexPembimbing()
    {
        $data['activePage'] = 'pembimbingPenilaian';

        $id = session()->get('id');

        $pembimbing = new PembimbingModel();
        $pembimbingDetail = $pembimbing->where('users_id', $id)->where('status_hapus', 'tidak')->first();

        $magang = new MagangModel();
        $dataMagang = $magang->where('pembimbing_id', $pembimbingDetail['id'])->where('status_hapus', 'tidak')->findAll();

        if ($dataMagang) {
            $arrId = [];

            foreach ($dataMagang as $value) {
                array_push($arrId, $value['id']);
            }
        } else {
            $arrId = ['0'];
        }

        $penilaian = new PenilaianModel();
        $data['list'] = $penilaian->select('penilaian.magang_id, siswa.nama, pengajuan.tanggal_mulai, pengajuan.tanggal_selesai')
            ->selectSum('nilai', 'total_sum')
            ->join('magang', 'penilaian.magang_id = magang.id')
            ->join('siswa', 'magang.siswa_id = siswa.id')
            ->join('pengajuan', 'magang.pengajuan_id = pengajuan.id')
            ->whereIn('penilaian.magang_id', $arrId)
            ->groupBy('penilaian.magang_id')
            ->get()->getResultArray();

        if ($dataMagang) {
            $arrSiswa = [];

            foreach ($dataMagang as $value) {
                array_push($arrSiswa, $value['siswa_id']);
            }
        } else {
            $arrSiswa = ['0'];
        }

        $siswa = new SiswaModel();
        $data['siswa'] = $siswa->whereIn('id', $arrSiswa)->where('status_hapus', 'tidak')->findAll();

        $kategori = new PenilaianKategoriModel();
        $data['kategori'] = $kategori->where('status_hapus', 'tidak')->orderBy('nama_kategori', 'asc')->findAll();

        $data['count'] = count($data['kategori']);

        return view('pembimbing/penilaian/index', $data);
    }

    public function storePembimbing()
    {
        $data = $this->request->getPost();

        $validation =  \Config\Services::validation();
        $validation->setRules([
            'siswa' => [
                'label' => 'Siswa Magang',
                'rules' => 'required'
            ],
            'nilaiKategori.*' => [
                'label' => 'Nilai',
                'rules' => 'required|is_natural_no_zero|less_than_equal_to[100]|greater_than_equal_to[0]'
            ],
        ]);

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('pembimbing/penilaian'));
        }

        $id = session()->get('id');

        $pembimbing = new PembimbingModel();
        $pembimbingDetail = $pembimbing->where('users_id', $id)->where('status_hapus', 'tidak')->first();

        $magang = new MagangModel();
        $dataMagang = $magang->where('pembimbing_id', $pembimbingDetail['id'])
            ->where('siswa_id', $data['siswa'])
            ->where('status_hapus', 'tidak')
            ->where('status_magang', 'berjalan')
            ->first();

        $penilaian = new PenilaianModel();
        $kondisi = $penilaian->where('magang_id', $dataMagang['id'])->findAll();

        if ($kondisi) {
            session()->setFlashdata("warning", 'Siswa yang Anda pilih sudah diberikan nilai');
            return redirect()->to(base_url('pembimbing/penilaian'));
        }

        $idKategori = $data['idKategori'];
        $nilaiKategori = $data['nilaiKategori'];

        for ($i = 0; $i < count($idKategori); $i++) {
            $nilai = $nilaiKategori[$i];

            if ($nilai >= 90 && $nilai <= 100) {
                $grade = 'A';
            } elseif ($nilai >= 75 && $nilai < 90) {
                $grade = 'B';
            } elseif ($nilai >= 65 && $nilai < 75) {
                $grade = 'C';
            } elseif ($nilai >= 50 && $nilai < 65) {
                $grade = 'D';
            } else {
                $grade = 'E';
            }

            $data = [
                'magang_id' => $dataMagang['id'],
                'kategori_id' => $idKategori[$i],
                'huruf' => $grade,
                'nilai' => $nilai
            ];

            $model = new PenilaianModel();
            $model->insertPenilaian($data);
        }

        $dataMagangUpdate = [
            'status_magang' => 'selesai'
        ];
        $magang->updateMagang($dataMagangUpdate, $dataMagang['id']);

        session()->setFlashdata("success", 'Berhasil menambahkan data!');
        return redirect()->to(base_url('pembimbing/penilaian'));
    }

    public function editPembimbing()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $magang = new MagangModel();
            $dataMagang = $magang->select('siswa.nama, pengajuan.tanggal_mulai, pengajuan.tanggal_selesai')
                ->join('siswa', 'magang.siswa_id = siswa.id')
                ->join('pengajuan', 'magang.pengajuan_id = pengajuan.id')
                ->where('magang.id', $id)->where('magang.status_hapus', 'tidak')
                ->first();

            $penilaian = new PenilaianModel();
            $dataPenilaian = $penilaian->select('penilaian.id, penilaian.nilai, penilaian.huruf, kategori_penilaian.nama_kategori, kategori_penilaian.keterangan')
                ->join('kategori_penilaian', 'penilaian.kategori_id = kategori_penilaian.id')
                ->where('penilaian.magang_id', $id)
                ->orderBy('kategori_penilaian.nama_kategori', 'asc')
                ->get()->getResultArray();

            $data = [
                'status' => 'success',
                'siswa' => $dataMagang['nama'],
                'penilaian' => $dataPenilaian,
                'periodeMulai' => $dataMagang['tanggal_mulai'],
                'periodeSelesai' => $dataMagang['tanggal_selesai']
            ];

            return $this->response->setJSON($data);
        }
    }

    public function updatePembimbing()
    {
        $data = $this->request->getPost();

        $validation =  \Config\Services::validation();
        $validation->setRules([
            'editNilaiKategori.*' => [
                'label' => 'Nilai',
                'rules' => 'required|is_natural_no_zero|less_than_equal_to[100]|greater_than_equal_to[0]'
            ],
        ]);

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('pembimbing/penilaian'));
        }

        $idPenilaian = $data['editId'];
        $nilaiKategori = $data['editNilaiKategori'];

        for ($i = 0; $i < count($idPenilaian); $i++) {
            $nilai = $nilaiKategori[$i];
            $id = $idPenilaian[$i];

            if ($nilai >= 90 && $nilai <= 100) {
                $grade = 'A';
            } elseif ($nilai >= 75 && $nilai < 90) {
                $grade = 'B';
            } elseif ($nilai >= 65 && $nilai < 75) {
                $grade = 'C';
            } elseif ($nilai >= 50 && $nilai < 65) {
                $grade = 'D';
            } else {
                $grade = 'E';
            }

            $data = [
                'huruf' => $grade,
                'nilai' => $nilai
            ];

            $model = new PenilaianModel();
            $model->updatePenilaian($data, $id);
        }

        session()->setFlashdata("success", 'Berhasil memperbarui data!');
        return redirect()->to(base_url('pembimbing/penilaian'));
    }
}
