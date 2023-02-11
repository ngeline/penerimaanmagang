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
            'password' => 'required|min_length[8]|max_length[20]',
        ]);

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('users'));
        }

        $data = [
            'password' => password_hash($data['password'], PASSWORD_DEFAULT)
        ];

        $model->updateUser($data, $id);

        session()->setFlashdata("success", 'Successfully Updating Data');
        return redirect()->to(base_url('users'));
    }

    public function delete($id)
    {
        $model = new UsersModel();

        $data = [
            'status' => 'nonaktif'
        ];

        $model->updateUser($data, $id);

        session()->setFlashdata("success", 'Your file has been deleted');
        return redirect()->to(base_url('users'));
    }

    public function updateSiswaUsers()
    {
        $data = $this->request->getPost();
        $id = $data['id'];

        $model = new UsersModel();

        $validation =  \Config\Services::validation();
        $validation->setRules([
            'username' => 'min_length[5]|max_length[20]',
            'password' => 'min_length[8]|max_length[20]',
        ]);

        if (!isset($data['username']) || !isset($data['password'])) {
            if (!$validation->run($_POST)) {
                $errors = $validation->getErrors();
                $arr = implode("<br>", $errors);
                session()->setFlashdata("warning", $arr);
                return redirect()->to(base_url('profile'));
            }
        }

        if (!empty($data['username'])) {
            $data = [
                'username' => $data['username'],
            ];

            $model->updateUser($data, $id);
        }

        if (!empty($data['password'])) {
            $data = [
                'password' => password_hash($data['password'], PASSWORD_DEFAULT)
            ];

            $model->updateUser($data, $id);
        }

        session()->setFlashdata("success", 'Successfully Updating Data');
        return redirect()->to(base_url('profile'));
    }
}
