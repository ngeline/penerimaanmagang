<!DOCTYPE html>
<html>

<head>
    <title>Laporan Penilaian Magang 2023</title>
</head>
<style>
    .table-bordered,
    th,
    td {
        border: 1px solid;
        border-collapse: collapse;
        padding: 0px;
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

    .tengah {
        text-align: center;
    }
</style>

<body>
    <center>
        <p></p>
        <h2>DAFTAR NILAI</h2>
    </center>
    <table>
        <tbody>
            <tr>
                <td class="table-less"><b>Nama</b></td>
                <td class="table-less">: <?= $siswa['nama'] ?></td>
            </tr>
            <tr>
                <td class="table-less"><b>Kompetensi Keahlian</b></td>
                <td class="table-less">: <?= $siswa['jurusan'] ?></td>
            </tr>
            <tr>
                <td class="table-less"><b>Sekolah</b></td>
                <td class="table-less">: <?= ($siswa['jenjang'] == 'SLTA') ? $siswa['asal_sekolah'] : $siswa['perguruan'] ?></td>
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
        <table class="table table-bordered" style="width:100%">
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
                    <tr>
                        <td class="tengah"><?php echo $no++ ?></td>
                        <td style="width: 80%; padding-left: 5px; padding-right: 5px;">
                            <p><?= $row['nama_kategori'] ?><br>
                                <span style="font-size: 13px;"><?= $row['keterangan'] ?></span>
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
</body>

</html>