<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;
use App\Models\SiswaModel;

class RegisterController extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url', 'validation']);
    }

    public function index()
    {
        return view('auth/register');
    }

    public function register()
    {
        // Get form data
        $data = $this->request->getPost();
        $role = 'siswa';

        $validation =  \Config\Services::validation();

        $validation->setRules([
            'username' => [
                'label' => 'Nama Pengguna',
                'rules' => 'required|alpha_numeric|min_length[5]|max_length[20]|is_unique[users.username]|regex_match[/^\S*$/]'
            ],
            'password' => [
                'label' => 'Kata Sandi',
                'rules' => 'required|min_length[8]|max_length[20]'
            ],
            'kode' => [
                'label' => 'Kode Verifikasi',
                'rules' => 'required|matches[validKode]'
            ],
            'validKode' => [
                'label' => 'Kode Valid',
                'rules' => 'required'
            ],
        ]);

        if (!$validation->run($_POST)) {
            return view('auth/register', [
                'validation' => $validation,
            ]);
        }

        $user = new UsersModel();
        $siswa = new SiswaModel();

        $dataUser = [
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role' => $role,
        ];

        $user->insertUser($dataUser);
        $user_id = $user->getInsertID();

        $dataSiswa = [
            'users_id' => $user_id,
            'telepon' => $data['telepon']
        ];

        $siswa->insertSiswa($dataSiswa);

        return redirect()->to(base_url('login'))->with('success', 'Pendaftaran berhasil!');
    }

    public function kode()
    {
        if ($this->request->isAJAX()) {
            $telepon = $this->request->getVar('no_telp');

            $kode = random_int(11111, 99999);

            // $wa = new waController;
            // $wa->sendMessage($request->no_telp, $kode);

            // do something with the data
            $response = [
                'status' => 'success',
                'message' => $kode
            ];

            return $this->response->setJSON($response);
        }
    }
}
