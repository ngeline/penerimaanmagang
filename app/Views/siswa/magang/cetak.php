<!DOCTYPE html>
<html>

<head>
    <title>Laporan Sertifikat Magang</title>
    <style type="text/css">
        html,
        body {
            margin: 0;
            padding: 0;
        }

        .bg-image {
            background-image: url('assets/img/bg-sertif.jpeg');
            background-repeat: no-repeat;
            background-size: cover;
            height: 100%;
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
            font-size: 25px;
            font-weight: 700;
        }

        .sub-judul {
            text-align: center;
            font-size: 16px;
            font-weight: 300;
        }

        .guedi {
            border: 2px solid black;
            padding: 0px;
            margin: 0px;
        }

        .isi {
            font-size: 16px;
            padding-right: 5%;
        }

        .typetext {
            font-family: 'TimesNewRoman';
            src: url('assets/font/timesnewroman.ttf') format('truetype');
        }

        .nilai {
            font-size: 13px;
            padding: 3%;
        }

        .kiri {
            text-align: center;
            padding-left: 65%;
        }

        .tengah {
            text-align: center;
        }

        .nilai-bordered,
        th,
        td {
            border: 1px solid;
            border-collapse: collapse;
            padding: 0px;
            margin: 1px;
        }

        .nilai-less {
            border: 0px solid;
            border-collapse: none;
            padding: 0px;
            margin: 1px;
        }
    </style>
</head>

<body class="typetext">
    <div class="sertif bg-image">
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
                <dd class="typetext">
                    Yang bertanda tangan dibawah ini Kepala Dinas Pendidikan Kota Kediri, menerangkan bahwa
                    <?= ($siswa['jenjang'] == 'SLTA') ? 'siswa ' . $siswa['asal_sekolah'] : 'mahasiswa ' . $siswa['perguruan'] ?>
                </dd>
                <pre><table style="padding-left: 10%;"class="typetext">
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
                    Kepala Dinas Pendidkan<br>
                    Kota Kediri
                    <br>
                    <img src="assets/file/ttd/<?= $kepDinas['ttd'] ?>">
                    <br>
                    <b><?= $kepDinas['kepala_dinas'] ?></b><br>
                    Pembina Utama Muda<br>
                    NIP. <?= $kepDinas['nip'] ?>
                </div>
            </div>
        </div>
    </div>
    <div class="nilai">
        <center>
            <h2>DAFTAR NILAI</h2>
        </center>
        <table>
            <tbody>
                <tr>
                    <td class="nilai-less"><b>Nama</b></td>
                    <td class="nilai-less">: <?= $siswa['nama'] ?></td>
                </tr>
                <tr>
                    <td class="nilai-less"><b>Kompetensi Keahlian</b></td>
                    <td class="nilai-less">: <?= $siswa['jurusan'] ?></td>
                </tr>
                <tr>
                    <td class="nilai-less"><b>Sekolah</b></td>
                    <td class="nilai-less">: <?= ($siswa['jenjang'] == 'SLTA') ? $siswa['asal_sekolah'] : $siswa['perguruan'] ?></td>
                </tr>
            </tbody>
        </table>
        <hr>
        <br>
        <div class="row">
            <div class="col-md-12">
            </div>
        </div>
        <div class="container-fluid">
            <table class="table nilai-bordered" style="width:100%">
                <thead>
                    <tr class="tengah">
                        <th>No</th>
                        <th>Aspek Yang Dinilai</th>
                        <th>Predikat</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($list as $row) : ?>
                        <tr style="line-height: 0; align-items: center; align-content: center; vertical-align: middle;">
                            <td class="tengah"><?php echo $no++ ?></td>
                            <td style="width: 80%; padding-left: 5px; padding-right: 5px;">
                                <p><?= $row['nama_kategori'] ?> -
                                    <span style="font-size: 11px; line-height: normal;"><?= $row['keterangan'] ?></span>
                                </p>
                            </td>
                            <td class="tengah"><?= $row['huruf'] ?></td>
                            <td class="tengah"><?= $row['nilai'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <th colspan="3">Total Rata-Rata</th>
                        <td class="tengah"><?= $total ?></td>
                    </tr>
                </tbody>
            </table>
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