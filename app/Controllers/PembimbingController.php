<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Database\Migrations\Kegiatan;
use App\Models\AbsensiModel;
use App\Models\BidangModel;
use App\Models\KegiatanModel;
use App\Models\MagangModel;
use App\Models\UsersModel;
use App\Models\PembimbingModel;
use App\Models\PenilaianModel;

class PembimbingController extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session']);
    }

    public function index()
    {
        $data['activePage'] = 'adminPembimbing';

        $pembimbing = new PembimbingModel();

        $listBidang = new BidangModel();
        $data['bidang'] = $listBidang->where('status_hapus', 'tidak')->findAll();

        $data['list'] = $pembimbing->select('bidang.*, pembimbing.*, pembimbing.id as id_pembimbing, users.*, users.id as id_users')
            ->join('users', 'pembimbing.users_id = users.id')
            ->join('bidang', 'pembimbing.bidang_id = bidang.id')
            ->where('pembimbing.status_hapus', 'tidak')
            ->orderBy('pembimbing.updated_at', 'desc')
            ->get()->getResultArray();

        return view('admin/pembimbing/index', $data);
    }

    public function store()
    {
        $data = $this->request->getPost();

        $validation =  \Config\Services::validation();
        $validation->setRules([
            'bidang' => [
                'label' => 'Bidang Pekerjaan',
                'rules' => 'required'
            ],
            'nip' => [
                'label' => 'NIP',
                'rules' => 'required|is_natural_no_zero|is_unique[pembimbing.nip]'
            ],
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
                'rules' => 'required|is_unique[pembimbing.email]'
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
            return redirect()->to(base_url('admin/pembimbing'));
        }

        $users = new UsersModel();
        $dataUsers = [
            'username' => $data['nip'],
            'password' => password_hash($data['nip'], PASSWORD_DEFAULT),
            'role' => 'pembimbing'
        ];
        $users->insertUser($dataUsers);
        $user_id = $users->getInsertID();

        $pembimbing = new PembimbingModel();
        $dataPembimbing = [
            'users_id' => $user_id,
            'bidang_id' => $data['bidang'],
            'nip' => $data['nip'],
            'nama' => $data['nama'],
            'jenis_kelamin' => $data['jk'],
            'email' => $data['email'],
            'telepon' => $data['telepon'],
            'alamat' => $data['alamat'],
        ];
        $pembimbing->insertPembimbing($dataPembimbing);

        session()->setFlashdata("success", 'Berhasil menambahkan data!');
        return redirect()->to(base_url('admin/pembimbing'));
    }

    public function update()
    {
        $data = $this->request->getPost();

        $id = $data['id'];

        $validation =  \Config\Services::validation();
        $validation->setRules([
            'bidang' => [
                'label' => 'Bidang Pekerjaan',
                'rules' => 'required'
            ],
            'nip' => [
                'label' => 'NIP',
                'rules' => 'required|is_natural_no_zero'
            ],
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
            return redirect()->to(base_url('admin/pembimbing'));
        }

        $pembimbing = new PembimbingModel();
        $dataPembimbing = [
            'bidang_id' => $data['bidang'],
            'nip' => $data['nip'],
            'nama' => $data['nama'],
            'jenis_kelamin' => $data['jk'],
            'email' => $data['email'],
            'telepon' => $data['telepon'],
            'alamat' => $data['alamat'],
        ];
        $pembimbing->updatePembimbing($dataPembimbing, $id);

        session()->setFlashdata("success", 'Berhasil memperbarui data!');
        return redirect()->to(base_url('admin/pembimbing'));
    }

    public function delete($id_pembimbing, $id_users)
    {
        $magang = new MagangModel();
        $dataMagang = $magang->where('pembimbing_id', $id_pembimbing)->findAll();

        $absensi = new AbsensiModel();
        $kegiatan = new KegiatanModel();
        $penilaian = new PenilaianModel();

        foreach ($dataMagang as $value) {
            $absensi->where('magang_id', $value['id'])->delete();
            $kegiatan->where('magang_id', $value['id'])->delete();
            $penilaian->where('magang_id', $value['id'])->delete();
        }

        $magang->where('pembimbing_id', $id_pembimbing)->delete();

        $pembimbing = new PembimbingModel();
        $pembimbing->deletePembimbing($id_pembimbing);

        $user = new UsersModel();
        $user->deleteUser($id_users);

        session()->setFlashdata("success", 'File Anda telah dihapus!');
        return redirect()->to(base_url('admin/pembimbing'));
    }
}
