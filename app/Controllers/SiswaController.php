<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MagangModel;
use App\Models\PembimbingModel;
use App\Models\UsersModel;
use App\Models\SiswaModel;

class SiswaController extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session']);
    }

    public function index()
    {
        $data['activePage'] = 'adminSiswa';

        $siswa = new SiswaModel();

        $data['list'] = $siswa->select('siswa.*, siswa.id as id_siswa, users.*, users.id as id_users')
            ->join('users', 'siswa.users_id = users.id')
            ->where('siswa.status_hapus', 'tidak')
            ->get()->getResultArray();

        return view('admin/siswa/index', $data);
    }

    public function update()
    {
        $data = $this->request->getPost();

        $id = $data['id'];

        $model = new SiswaModel();

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
            'kelas' => $data['kelas'],
            'asal_sekolah' => $data['sekolah'],
            'nisn' => $data['nisn'],
        ];

        $model->updateSiswa($data, $id);

        session()->setFlashdata("success", 'Berhasil memperbarui data!');
        return redirect()->to(base_url('admin/siswa'));
    }

    public function delete($id_siswa, $id_users)
    {
        $siswa = new SiswaModel();
        $dataSiswa = [
            'status_hapus' => 'hapus'
        ];

        $siswa->updateSiswa($dataSiswa, $id_siswa);

        $user = new UsersModel();

        $dataUser = [
            'status' => 'nonaktif'
        ];

        $user->updateUser($dataUser, $id_users);

        session()->setFlashdata("success", 'File Anda telah dihapus!');
        return redirect()->to(base_url('admin/siswa'));
    }

    public function indexPembimbing()
    {
        $data['activePage'] = 'pembimbingSiswa';

        $id = session()->get('id');

        $pembimbing = new PembimbingModel();
        $dataPembimbing = $pembimbing->where('users_id', $id)->first();

        $magang = new MagangModel();
        $dataMagang = $magang->where('pembimbing_id', $dataPembimbing['id'])->where('status_hapus', 'tidak')->findAll();

        if ($dataMagang) {
            $arrId = [];

            foreach ($dataMagang as $value) {
                array_push($arrId, $value['siswa_id']);
            }
        } else {
            $arrId = ['0'];
        }

        $siswa = new SiswaModel();
        $data['list'] = $siswa->whereIn('id', $arrId)->where('status_hapus', 'tidak')->findAll();

        return view('pembimbing/siswa/index', $data);
    }
}
