<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MagangModel;
use App\Models\PenilaianModel;
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

        // Output the generated PDF to the browser
        $dompdf->stream('document.pdf', ['Attachment' => false]);
    }

    public function generateSertifikat()
    {
        // Load the Dompdf library
        $options = new Options();
        $options->setChroot('');

        $dompdf = new Dompdf();
        $dompdf->setOptions($options);

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
