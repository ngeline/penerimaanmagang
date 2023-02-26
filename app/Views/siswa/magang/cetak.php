<!DOCTYPE html>
<html>

<head>
    <title>Laporan Sertifikat Magang</title>
    <style type="text/css">
        @font-face {
            font-family: 'Arial';
            src: url('assets/font/arial.ttf') format('truetype');
        }

        html,
        body {
            background-image: url('assets/img/bg-sertif.jpeg');
            background-repeat: no-repeat;
            background-size: cover;
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .table-bordered th td {
            border: 1px solid;
            border-collapse: collapse;
            padding: 0;
            margin: 1px;
        }

        .table-less {
            border: 0px solid;
            border-collapse: none;
            padding: 0px;
            margin: 1px;
        }

        .kiri {
            text-align: center;
            padding-left: 65%;
        }

        .borderless tr td {
            border: 0px solid;
            border-collapse: none;
            line-height: 0.5;
        }

        .content {
            padding-top: 1%;
            padding-left: 5%;
            padding-right: 5%;
            padding-bottom: 5%;
        }

        .judul {
            text-align: center;
            font-size: 23px;
            font-weight: 700;
        }

        .sub-judul {
            text-align: center;
            font-size: 14px;
            font-weight: 300;
        }

        .guedi {
            border: 2px solid black;
            padding: 0px;
            margin: 0px;
        }

        .isi {
            font-size: 14px;
            /* padding-left: 1%; */
            padding-right: 5%;
        }
    </style>
</head>

<body>
    <div class="content">
        <table class="borderless" style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 18%; text-align: center;">
                        <img src="assets/img/logo-pemkot.png" style="width: 130px; height: 130px;" alt="logo">
                    </td>
                    <td style="padding-right: 22%;">
                        <div class="judul">
                            <p style="padding-top: 8px;">
                                PEMERINTAH KOTA KEDIRI <br><br>
                                <span class="judul">
                                    DINAS PENDIDIKAN
                                </span><br><br>
                                <span class="sub-judul">
                                    JALAN MAYOR BISMO NO. 10-12 TELP. (0354) 689923 FAX. (0354) 690556
                                </span><br><br>
                                <span class="sub-judul">
                                    SITUS: DISPENDIK.KEDIRIKOTA.GO.ID EMAIL:DISPENDIK@KEDIRIKOTA.GO.ID
                                </span><br><br>
                                <span class="sub-judul">
                                    KEDIRI
                                </span>
                            </p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr>
                        <hr class="guedi">
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="isi">
            <center style="padding-top: 5px; padding-left: 5%;">
                <b style="font-size: 15px;"><u>SURAT KETERANGAN</u></b>
                <p style="margin: 0;">No. <?= $siswa['sertifikat'] ?></p>
            </center><br>
            <dd>
                Yang bertanda tangan dibawah ini Kepala Dinas Pendidikan Kota Kediri, menerangkan bahwa
                <?= ($siswa['jenjang'] == 'SLTA') ? 'siswa ' . $siswa['asal_sekolah'] : 'mahasiswa ' . $siswa['perguruan'] ?>
            </dd>
            <pre><table style="padding-left: 10%;">
                <tbody>
                    <tr>
                        <td class="table-less"><b>Nama</b></td>
                        <td class="table-less">: <?= $siswa['nama'] ?></td>
                    </tr>
                    <?php if ($siswa['jenjang'] == 'SLTA') : ?>
                    <tr>
                        <td class="table-less"><b>Sekolah</b></td>
                        <td class="table-less">: <?= $siswa['asal_sekolah'] ?></td>
                    </tr>
                    <tr>
                        <td class="table-less"><b>Jurusan</b></td>
                        <td class="table-less">: <?= $siswa['jurusan'] ?></td>
                    </tr>
                    <tr>
                        <td class="table-less"><b>Kelas</b></td>
                        <td class="table-less">: <?= $siswa['kelas'] ?></td>
                    </tr>
                    <tr>
                        <td class="table-less"><b>Nomor Induk Siswa Nasional (NISN)</b></td>
                        <td class="table-less">: <?= $siswa['nisn'] ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if ($siswa['jenjang'] == 'Perguruan Tinggi') : ?>
                    <tr>
                        <td class="table-less"><b>Universitas</b></td>
                        <td class="table-less">: <?= $siswa['perguruan'] ?></td>
                    </tr>
                    <tr>
                        <td class="table-less"><b>Prodi</b></td>
                        <td class="table-less">: <?= $siswa['prodi'] ?></td>
                    </tr>
                    <tr>
                        <td class="table-less"><b>Jurusan</b></td>
                        <td class="table-less">: <?= $siswa['jurusan'] ?></td>
                    </tr>
                    <tr>
                        <td class="table-less"><b>Semester</b></td>
                        <td class="table-less">: <?= $siswa['tingkat'] ?></td>
                    </tr>
                    <tr>
                        <td class="table-less"><b>Nomor Induk Mahasiswa (NIM)</b></td>
                        <td class="table-less">: <?= $siswa['nim'] ?></td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table></pre>
            <br>
            <dd>
                Telah mengikuti Program Praktik Kerja Industri/Praktik Pengalaman Kerja dalam Praktik Kerja
                Lapangan (PKL). Pada tanggal <b><?= $mulai ?> sampai dengan <?= $selesai ?></b> dengan
                hasil <?= $hasil ?> (daftar nilai tertera dibalik ini).
            </dd>
            <div class="kiri">
                <br>
                Kediri, <?php
                        setlocale(LC_ALL, 'IND');
                        $date = strftime("%d %B %Y");
                        echo $date;
                        ?><br>
                Ka. Sub. <?= $siswa['singkatan_bidang'] ?><br>
                Dinas Pendidikan Kota Kediri
                <br>
                <img src="assets/file/ttd/<?= $siswa['ttd'] ?>">
                <br>
                <b><?= $siswa['kepala_bidang'] ?></b><br>
                NIP. <?= $siswa['kepala_nip'] ?>
            </div>
        </div>
    </div>
</body>

</html>