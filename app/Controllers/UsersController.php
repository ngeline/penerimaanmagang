<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AbsensiModel;
use App\Models\KegiatanModel;
use App\Models\MagangModel;
use App\Models\PembimbingModel;
use App\Models\PengajuanAnggotaModel;
use App\Models\PengajuanModel;
use App\Models\PenilaianModel;
use App\Models\SiswaModel;
use App\Models\UsersModel;

class UsersController extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session']);
    }

    public function index()
    {
        $data['activePage'] = 'adminUser';
        $model = new UsersModel();
        $data['users'] = $model->where('status', 'aktif')->orderBy('updated_at', 'desc')->findAll();
        return view('admin/users/index', $data);
    }

    public function update()
    {
        $data = $this->request->getPost();

        $id = $data['id'];

        $validation =  \Config\Services::validation();
        $validation->setRules([
            'password' => [
                'label' => 'Kata Sandi',
                'rules' => 'required|min_length[8]|max_length[20]'
            ],
        ]);

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('admin/users'));
        }

        $data = [
            'password' => password_hash($data['password'], PASSWORD_DEFAULT)
        ];

        $model = new UsersModel();
        $model->updateUser($data, $id);

        session()->setFlashdata("success", 'Berhasil memperbarui data!');
        return redirect()->to(base_url('admin/users'));
    }

    public function delete($id)
    {
        $siswa = new SiswaModel();
        $pembimbing = new PembimbingModel();
        $magang = new MagangModel();
        $absensi = new AbsensiModel();
        $kegiatan = new KegiatanModel();
        $penilaian = new PenilaianModel();
        $anggota = new PengajuanAnggotaModel();
        $pengajuan = new PengajuanModel();


        $cekSiswa = $siswa->where('users_id', $id)->first();
        $cekPembimbing = $pembimbing->where('users_id', $id)->first();

        if ($cekSiswa) {
            $dataMagang = $magang->where('siswa_id', $cekSiswa['id'])->findAll();

            foreach ($dataMagang as $value) {
                $absensi->where('magang_id', $value['id'])->delete();
                $kegiatan->where('magang_id', $value['id'])->delete();
                $penilaian->where('magang_id', $value['id'])->delete();
            }

            $magang->where('siswa_id', $cekSiswa['id'])->delete();

            $anggota->where('siswa_id', $cekSiswa['id'])->delete();

            $dataPengajuan = $pengajuan->where('siswa_id', $cekSiswa['id'])->first();

            if ($dataPengajuan) {
                $anggota->where('pengajuan_id', $dataPengajuan['id'])->delete();
            }

            $pengajuan->where('siswa_id', $cekSiswa['id'])->delete();

            $siswa->deleteSiswa($cekSiswa['id']);
        } else if ($cekPembimbing) {
            $dataMagang = $magang->where('pembimbing_id', $cekPembimbing['id'])->findAll();

            foreach ($dataMagang as $value) {
                $absensi->where('magang_id', $value['id'])->delete();
                $kegiatan->where('magang_id', $value['id'])->delete();
                $penilaian->where('magang_id', $value['id'])->delete();
            }

            $magang->where('pembimbing_id', $cekPembimbing['id'])->delete();

            $pembimbing->deletePembimbing($cekPembimbing['id']);
        }

        $user = new UsersModel();
        $user->deleteUser($id);

        session()->setFlashdata("success", 'File Anda telah dihapus!');
        return redirect()->to(base_url('admin/users'));
    }

    public function updateSiswaUsers()
    {
        $data = $this->request->getPost();
        $id = $data['id'];

        $model = new UsersModel();

        $validation =  \Config\Services::validation();
        $validation->setRules([
            'username' => [
                'label' => 'Nama Pengguna',
                'rules' => 'min_length[5]|max_length[20]'
            ],
            'password' => [
                'label' => 'Kata Sandi',
                'rules' => 'min_length[8]|max_length[20]'
            ],
        ]);

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('profile'));
        }

        $data = [
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT)
        ];

        $model->updateUser($data, $id);

        session()->setFlashdata("success", 'Berhasil memperbarui data!');
        return redirect()->to(base_url('profile'));
    }

    public function updatePembimbingUsers()
    {
        $data = $this->request->getPost();
        $id = $data['id'];

        $model = new UsersModel();

        $validation =  \Config\Services::validation();
        $validation->setRules([
            'username' => [
                'label' => 'Nama Pengguna',
                'rules' => 'min_length[5]|max_length[20]'
            ],
            'password' => [
                'label' => 'Kata Sandi',
                'rules' => 'min_length[8]|max_length[20]'
            ],
        ]);

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('profile'));
        }

        $data = [
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT)
        ];

        $model->updateUser($data, $id);

        session()->setFlashdata("success", 'Berhasil memperbarui data!');
        return redirect()->to(base_url('profile'));
    }
}
