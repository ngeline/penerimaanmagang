<?php

namespace App\Controllers;

use App\Controllers\BaseController;
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
        $data['users'] = $model->where('status', 'aktif')->findAll();
        return view('admin/users/index', $data);
    }

    public function update()
    {
        $data = $this->request->getPost();

        $id = $data['id'];

        $model = new UsersModel();
        $data['users'] = $model->where('status', 'aktif')->findAll();

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

        $model->updateUser($data, $id);

        session()->setFlashdata("success", 'Berhasil memperbarui data!');
        return redirect()->to(base_url('admin/users'));
    }

    public function delete($id)
    {
        $model = new UsersModel();

        $data = [
            'status' => 'nonaktif'
        ];

        $model->updateUser($data, $id);

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
