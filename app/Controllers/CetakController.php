<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KepalaDinasModel;
use App\Models\MagangModel;
use App\Models\PenilaianModel;
use DateTime;
use DateTimeZone;
use Dompdf\Dompdf;
use Dompdf\Options;

class CetakController extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session']);
    }

    public function generateNilai($id)
    {
        $magang = new MagangModel();
        $data['siswa'] = $magang->select('magang.*, siswa.*, pembimbing.*, bidang.*, bidang.nip AS kepala_nip, siswa.nama AS nama')
            ->join('siswa', 'magang.siswa_id = siswa.id')
            ->join('pembimbing', 'magang.pembimbing_id = pembimbing.id')
            ->join('bidang', 'pembimbing.bidang_id = bidang.id')
            ->where('magang.id', $id)
            ->first();

        $penilaian = new PenilaianModel();
        $data['list'] = $penilaian
            ->join('kategori_penilaian', 'penilaian.kategori_id = kategori_penilaian.id')
            ->where('magang_id', $id)
            ->orderBy('kategori_penilaian.nama_kategori', 'asc')
            ->get()->getResultArray();

        $arr = [];

        for ($i = 0; $i < count($data['list']); $i++) {
            array_push($arr, $data['list'][$i]['nilai']);
        }

        $data['total'] = number_format(array_sum($arr) / count($data['list']), 2, ',', '');

        $options = new Options();
        $options->setChroot('');

        $dompdf = new Dompdf();
        $dompdf->setOptions($options);

        // Load HTML into Dompdf
        $dompdf->loadHtml(view('siswa/penilaian/cetak', $data));

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        $namaFile = 'document-' . time();

        // Output the generated PDF to the browser
        $dompdf->stream($namaFile, ['Attachment' => false]);
    }

    public function generateSertifikat($id)
    {
        $magang = new MagangModel();
        $data['siswa'] = $magang->select('magang.*, siswa.*, pembimbing.*, bidang.*, pengajuan.*, bidang.nip AS kepala_nip, siswa.nama AS nama')
            ->join('siswa', 'magang.siswa_id = siswa.id')
            ->join('pembimbing', 'magang.pembimbing_id = pembimbing.id')
            ->join('bidang', 'pembimbing.bidang_id = bidang.id')
            ->join('pengajuan', 'magang.pengajuan_id = pengajuan.id')
            ->where('magang.id', $id)
            ->first();

        $penilaian = new PenilaianModel();
        $data['list'] = $penilaian
            ->join('kategori_penilaian', 'penilaian.kategori_id = kategori_penilaian.id')
            ->where('magang_id', $id)
            ->orderBy('kategori_penilaian.nama_kategori', 'asc')
            ->get()->getResultArray();

        $arr = [];

        for ($i = 0; $i < count($data['list']); $i++) {
            array_push($arr, $data['list'][$i]['nilai']);
        }

        $data['total'] = number_format(array_sum($arr) / count($data['list']), 2, ',', '');

        $kepDinas = new KepalaDinasModel();
        $data['kepDinas'] = $kepDinas->first();

        $mulai = $data['siswa']['tanggal_mulai'];
        $selesai = $data['siswa']['tanggal_selesai'];

        setlocale(LC_ALL, 'IND');
        $data['mulai'] = strftime("%d %B", strtotime($mulai));
        $data['selesai'] = strftime("%d %B %Y", strtotime($selesai));

        $penilaian = new PenilaianModel();
        $dataNilai = $penilaian->where('magang_id', $id)->get()->getResultArray();

        $arr = [];

        for ($i = 0; $i < count($dataNilai); $i++) {
            array_push($arr, $dataNilai[$i]['nilai']);
        }

        $total = round(array_sum($arr) / count($dataNilai));

        if ($total >= 80 && $total <= 100) {
            $data['hasil'] = 'SANGAT BAIK';
        } elseif ($total >= 75 && $total < 80) {
            $data['hasil'] = 'BAIK';
        } elseif ($total >= 65 && $total < 75) {
            $data['hasil'] = 'CUKUP';
        } elseif ($total >= 50 && $total < 65) {
            $data['hasil'] = 'KURANG';
        } else {
            $data['hasil'] = 'SANGAT KURANG';
        }

        $options = new Options();
        $options->setChroot('');

        $dompdf = new Dompdf();
        $dompdf->setOptions($options);

        // Load HTML into Dompdf
        $dompdf->loadHtml(view('siswa/magang/cetak', $data));

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        $namaFile = 'document-' . time();

        // Output the generated PDF to the browser
        $dompdf->stream($namaFile, ['Attachment' => false]);
    }
}
