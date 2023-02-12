<?php

namespace App\Controllers;

use App\Controllers\BaseController;
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

        $model = new SiswaModel();;

        $validation =  \Config\Services::validation();

        if ($data['jenjang'] == 'SLTA') {
            $validation->setRules([
                'nama' => 'required',
                'jk' => 'required',
                'email' => 'required',
                'telepon' => 'required|is_natural_no_zero',
                'alamat' => 'required',
                'jenjang' => 'required',
                'jurusan' => 'required',
                'kelas' => 'is_natural_no_zero',
                'sekolah' => 'required',
                'nisn' => 'is_natural_no_zero',
            ]);
        } else if ($data['jenjang'] == 'Perguruan Tinggi') {
            $validation->setRules([
                'nama' => 'required',
                'jk' => 'required',
                'email' => 'required',
                'telepon' => 'required|is_natural_no_zero',
                'alamat' => 'required',
                'jenjang' => 'required',
                'prodi' => 'required',
                'jurusan' => 'required',
                'perguruan' => 'required',
                'tingkat' => 'is_natural_no_zero',
                'nim' => 'is_natural_no_zero',
            ]);
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
}
