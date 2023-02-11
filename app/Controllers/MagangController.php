<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\PengajuanModel;

class MagangController extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session']);
    }

    public function index()
    {
        $data['activePage'] = 'siswaMagang';

        $id = session()->get('id');

        $siswa = new SiswaModel();
        $siswaDetail = $siswa->where('users_id', $id)->first();

        $pengajuan = new PengajuanModel();
        $pengajuanDetail = $pengajuan->where('siswa_id', $siswaDetail['id'])->first();

        if ($siswaDetail['status_lengkap'] == 'tidak') {
            return view('siswa/error/profilError', $data);
        } else {
            if (empty($pengajuanDetail)) {
                return view('siswa/error/pengajuanError', $data);
            } else {
                return view('siswa/magang/index', $data);
            }
        }
    }
}
