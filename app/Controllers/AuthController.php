<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MagangModel;
use App\Models\PembimbingModel;
use App\Models\PengajuanModel;
use App\Models\SiswaModel;
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
                return redirect()->to(base_url('login'))->with('error', 'Nama pengguna atau password tidak cocok');
            } else {
                if ($user['status'] === 'nonaktif') {
                    return redirect()->to(base_url('login'))->with('error', 'Nama pengguna atau password kadaluarsa');
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
            return redirect()->to(base_url('login'))->with('error', 'Nama pengguna atau password tidak cocok');
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

        $siswa = new SiswaModel();
        $data['t1'] = $siswa->countAllResults();

        $pembimbing = new PembimbingModel();
        $data['t2'] = $pembimbing->countAllResults();

        $pengajuan = new PengajuanModel();
        $data['t3'] = $pengajuan->countAllResults();

        $magang = new MagangModel();
        $data['t4'] = $magang->countAllResults();

        return view('dashboard', $data);
    }

    public function chartMagang()
    {
        $year = date('Y');

        $data['labels'] = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $arr = [];
        $magang = new MagangModel();
        for ($i = 1; $i < 13; $i++) {
            $getData = $magang->join('pengajuan', 'magang.pengajuan_id = pengajuan.id')
                ->where("YEAR(pengajuan.tanggal_mulai)", $year)->where("MONTH(pengajuan.tanggal_mulai)", [$i])->countAllResults();
            array_push($arr, $getData);
        }

        $data['values'] = $arr;

        $data['tahun'] = $year;

        return $this->response->setJSON($data);
    }

    public function chartMagangYear()
    {
        $year = $this->request->getVar('year');

        $arr = [];
        $magang = new MagangModel();
        for ($i = 1; $i < 13; $i++) {
            $getData = $magang->join('pengajuan', 'magang.pengajuan_id = pengajuan.id')
                ->where("YEAR(pengajuan.tanggal_mulai)", $year)->where("MONTH(pengajuan.tanggal_mulai)", [$i])->countAllResults();
            array_push($arr, $getData);
        }

        $data['values'] = $arr;

        $data['tahun'] = $year;

        return $this->response->setJSON($data);
    }

    public function errors()
    {
        return view('errors');
    }
}
