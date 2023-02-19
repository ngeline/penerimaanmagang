<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Dompdf\Dompdf;

class CetakController extends BaseController
{
    public function generateNilai()
    {
        // Load the Dompdf library
        $dompdf = new Dompdf();

        // Load HTML into Dompdf
        $dompdf->loadHtml(view('siswa/penilaian/cetak'));

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

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
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to the browser
        $dompdf->stream('document.pdf', ['Attachment' => false]);
    }
}
