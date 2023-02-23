<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AbsensiModel;
use App\Models\MagangModel;
use App\Models\PembimbingModel;

class AbsensiPembimbingController extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session']);
    }

    public function index()
    {
        $data['activePage'] = 'pembimbingAbsensi';

        $id = session()->get('id');

        $pembimbing = new PembimbingModel();
        $pembimbingDetail = $pembimbing->where('users_id', $id)->where('status_hapus', 'tidak')->first();

        $magang = new MagangModel();
        $dataMagang = $magang->where('pembimbing_id', $pembimbingDetail['id'])->where('status_hapus', 'tidak')->findAll();

        if ($dataMagang) {
            $arrId = [];

            foreach ($dataMagang as $value) {
                array_push($arrId, $value['id']);

                if ($value['status_magang'] == 'berjalan') {
                    $dataId = $value['id'];
                } else {
                    $dataId = 0;
                }
            }
        } else {
            $arrId = ['0'];
            $dataId = 0;
        }

        $data['id_magang'] = $dataId;

        $absensi = new AbsensiModel();
        $data['list'] = $absensi
            ->join('magang', 'absensi.magang_id = magang.id')
            ->join('siswa', 'magang.siswa_id = siswa.id')
            ->whereIn('absensi.magang_id', $arrId)
            ->where('absensi.status_absen !=', 'diproses')
            ->orderBy('absensi.updated_at', 'desc')
            ->get()->getResultArray();

        return view('pembimbing/absensi/index', $data);
    }
}
