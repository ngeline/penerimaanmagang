<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MagangModel;
use App\Models\PenilaianModel;
use Dompdf\Dompdf;

class CetakController extends BaseController
{
    public function generateNilai($id)
    {
        $magang = new MagangModel();
        $data['siswa'] = $magang
            ->join('siswa', 'magang.siswa_id = siswa.id')
            ->where('magang.id', $id)
            ->first();

        $penilaian = new PenilaianModel();
        $data['list'] = $penilaian
            ->join('kategori_penilaian', 'penilaian.kategori_id = kategori_penilaian.id')
            ->where('magang_id', $id)
            ->get()->getResultArray();

        $arr = [];

        for ($i = 0; $i < count($data['list']); $i++) {
            array_push($arr, $data['list'][$i]['nilai']);
        }

        $data['total'] = number_format(array_sum($arr) / count($data['list']), 2, ',', '');

        // Load the Dompdf library
        $dompdf = new Dompdf();

        // Load HTML into Dompdf
        $dompdf->loadHtml(view('siswa/penilaian/cetak', $data));

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to the browser
        $dompdf->stream('document.pdf', ['Attachment' => false]);
    }

    public function generateSertifikat()
    {
        // Load the Dompdf library
        $dompdf = new Dompdf();

        // Load HTML into Dompdf
        $dompdf->loadHtml(view('siswa/magang/cetak'));

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to the browser
        $dompdf->stream('document.pdf', ['Attachment' => false]);
    }
}
