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
            ->orderBy('siswa.updated_at', 'desc')
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
        $magang = new MagangModel();
        $dataMagang = $magang->where('siswa_id', $id_siswa)->findAll();

        $absensi = new AbsensiModel();
        $kegiatan = new KegiatanModel();
        $penilaian = new PenilaianModel();

        foreach ($dataMagang as $value) {
            $absensi->where('magang_id', $value['id'])->delete();
            $kegiatan->where('magang_id', $value['id'])->delete();
            $penilaian->where('magang_id', $value['id'])->delete();
        }

        $magang->where('siswa_id', $id_siswa)->delete();

        $anggota = new PengajuanAnggotaModel();
        $anggota->where('siswa_id', $id_siswa)->delete();

        $pengajuan = new PengajuanModel();
        $dataPengajuan = $pengajuan->where('siswa_id', $id_siswa)->first();

        if ($dataPengajuan) {
            $anggota->where('pengajuan_id', $dataPengajuan['id'])->delete();
        }

        $pengajuan->where('siswa_id', $id_siswa)->delete();

        $siswa = new SiswaModel();
        $siswa->deleteSiswa($id_siswa);

        $user = new UsersModel();
        $user->deleteUser($id_users);

        session()->setFlashdata("success", 'File Anda telah dihapus!');
        return redirect()->to(base_url('admin/siswa'));
    }

    public function indexPembimbing()
    {
        $data['activePage'] = 'pembimbingSiswa';

        $id = session()->get('id');

        $pembimbing = new PembimbingModel();
        $dataPembimbing = $pembimbing->where('users_id', $id)->where('status_hapus', 'tidak')->first();

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
        $data['list'] = $siswa->whereIn('id', $arrId)->where('status_hapus', 'tidak')->orderBy('updated_at', 'desc')->findAll();

        return view('pembimbing/siswa/index', $data);
    }
}
