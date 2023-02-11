<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;

class AuthController extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session']);
    }

    public function login()
    {
        return view('auth/login');
    }

    public function postLogin()
    {
        //ambil data dari form
        $data = $this->request->getPost();

        //ambil data user di database yang usernamenya sama 
        $usersModel = new UsersModel();
        $user = $usersModel->where('username', $data['username'])->first();

        //cek apakah username ditemukan
        if ($user) {
            //cek password
            //jika salah arahkan lagi ke halaman login
            if (!password_verify($data['password'], $user['password'])) {
                return redirect()->to(base_url('login'))->with('error', 'Invalid username or password');
            } else {
                if ($user['status'] === 'nonaktif') {
                    return redirect()->to(base_url('login'))->with('error', 'Username or password is expired');
                }
                //jika benar, arahkan user masuk ke aplikasi 
                $sessLogin = [
                    'isLogin' => true,
                    'username' => $user['username'],
                    'role' => $user['role']
                ];

                $session = session();
                $session->set('logged_in', true);
                $session->set('username', $user['username']);
                $session->set('role', $user['role']);
                $session->set('id', $user['id']);

                return redirect()->to(base_url('dashboard'));
            }
        } else {
            return redirect()->to(base_url('login'))->with('error', 'Invalid username or password');
        }
    }

    public function logout()
    {
        // Destroy the user's session
        $session = session();
        $session->destroy();

        // Redirect the user to the login page
        return redirect()->to(base_url('login'));
    }

    public function dashboard()
    {
        $data['activePage'] = 'dashboard';
        return view('dashboard', $data);
    }

    public function errors()
    {
        return view('errors');
    }
}
