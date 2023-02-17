<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BidangModel;
use App\Models\UsersModel;
use App\Models\SiswaModel;
use App\Models\PembimbingModel;

class ProfileController extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session']);
    }

    public function index()
    {
        $data['activePage'] = 'profile';

        $id = session()->get('id');
        $role = session()->get('role');

        $model = new UsersModel();
        $data['users'] = $model->getUser($id);

        $siswa = new SiswaModel();
        $data['siswa'] = $siswa->where('users_id', $id)->first();

        $pembimbing = new PembimbingModel();
        $data['pembimbing'] = $pembimbing->where('users_id', $id)->first();

        if (!empty($data['pembimbing'])) {
            $bidang = new BidangModel();
            $data['bidang'] = $bidang->where('id', $data['pembimbing']['bidang_id'])->first();
        }

        if ($role == 'siswa') {
            return view('siswa/profile/index', $data);
        } else if ($role == 'pembimbing') {
            return view('pembimbing/profile/index', $data);
        } else {
            return view('errors');
        }
    }

    public function updateProfileSiswa()
    {
        $data = $this->request->getPost();

        $id = $data['id'];

        $model = new SiswaModel();

        $validation =  \Config\Services::validation();

        if ($data['jenjang'] == 'SLTA') {
            $validation->setRules([
                'nama' => [
                    'label' => 'Nama Lengkap',
                    'rules' => 'required'
                ],
                'jk' => [
                    'label' => 'Jenis Kelamin',
                    'rules' => 'required'
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required'
                ],
                'telepon' => [
                    'label' => 'Telepon',
                    'rules' => 'required|is_natural_no_zero'
                ],
                'alamat' => [
                    'label' => 'Alamat',
                    'rules' => 'required'
                ],
                'jenjang' => [
                    'label' => 'Jenjang Pendidikan',
                    'rules' => 'required'
                ],
                'jurusan' => [
                    'label' => 'Jurusan',
                    'rules' => 'required'
                ],
                'kelas' => [
                    'label' => 'Kelas',
                    'rules' => 'is_natural_no_zero'
                ],
                'sekolah' => [
                    'label' => 'Sekolah',
                    'rules' => 'required'
                ],
                'nisn' => [
                    'label' => 'NISN',
                    'rules' => 'is_natural_no_zero'
                ],
            ]);
        } else if ($data['jenjang'] == 'Perguruan Tinggi') {
            $validation->setRules([
                'nama' => [
                    'label' => 'Nama Lengkap',
                    'rules' => 'required'
                ],
                'jk' => [
                    'label' => 'Jenis Kelamin',
                    'rules' => 'required'
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required'
                ],
                'telepon' => [
                    'label' => 'Telepon',
                    'rules' => 'required|is_natural_no_zero'
                ],
                'alamat' => [
                    'label' => 'Alamat',
                    'rules' => 'required'
                ],
                'jenjang' => [
                    'label' => 'Jenjang Pendidikan',
                    'rules' => 'required'
                ],
                'prodi' => [
                    'label' => 'Prodi',
                    'rules' => 'required'
                ],
                'jurusan' => [
                    'label' => 'Jurusan',
                    'rules' => 'required'
                ],
                'perguruan' => [
                    'label' => 'Perguruan Tinggi',
                    'rules' => 'required'
                ],
                'tingkat' => [
                    'label' => 'Tingkat',
                    'rules' => 'is_natural_no_zero'
                ],
                'nim' => [
                    'label' => 'NIM',
                    'rules' => 'is_natural_no_zero'
                ],
            ]);
        } else {
            session()->setFlashdata("warning", 'Input anda tidak sesuai');
            return redirect()->to(base_url('profile'));
        }

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('profile'));
        }

        if ($data['jenjang'] == 'SLTA') {
            $data = [
                'nama' => $data['nama'],
                'jenis_kelamin' => $data['jk'],
                'email' => $data['email'],
                'telepon' => $data['telepon'],
                'alamat' => $data['alamat'],
                'jenjang' => $data['jenjang'],
                'jurusan' => $data['jurusan'],
                'kelas' => $data['kelas'],
                'asal_sekolah' => $data['sekolah'],
                'nisn' => $data['nisn'],
                'status_lengkap' => 'lengkap'
            ];
        } else if ($data['jenjang'] == 'Perguruan Tinggi') {
            $data = [
                'nama' => $data['nama'],
                'jenis_kelamin' => $data['jk'],
                'email' => $data['email'],
                'telepon' => $data['telepon'],
                'alamat' => $data['alamat'],
                'jenjang' => $data['jenjang'],
                'prodi' => $data['prodi'],
                'jurusan' => $data['jurusan'],
                'tingkat' => $data['tingkat'],
                'perguruan' => $data['perguruan'],
                'nim' => $data['nim'],
                'status_lengkap' => 'lengkap'
            ];
        }

        $model->updateSiswa($data, $id);

        session()->setFlashdata("success", 'Berhasil memperbarui data!');
        return redirect()->to(base_url('profile'));
    }

    public function updateProfilePembimbing()
    {
        $data = $this->request->getPost();

        $id = $data['id'];

        $model = new PembimbingModel();

        $validation =  \Config\Services::validation();

        $validation->setRules([
            'nama' => [
                'label' => 'Nama Lengkap',
                'rules' => 'required'
            ],
            'jk' => [
                'label' => 'Jenis Kelamin',
                'rules' => 'required'
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required'
            ],
            'telepon' => [
                'label' => 'Telepon',
                'rules' => 'required|is_natural_no_zero'
            ],
            'alamat' => [
                'label' => 'Alamat',
                'rules' => 'required'
            ],
        ]);

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('profile'));
        }

        $data = [
            'nama' => $data['nama'],
            'jenis_kelamin' => $data['jk'],
            'email' => $data['email'],
            'telepon' => $data['telepon'],
            'alamat' => $data['alamat'],
        ];

        $model->updatePembimbing($data, $id);

        session()->setFlashdata("success", 'Berhasil memperbarui data!');
        return redirect()->to(base_url('profile'));
    }
}
