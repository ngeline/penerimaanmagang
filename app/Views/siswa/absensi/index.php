<?php

use PhpParser\Node\Expr\New_;

$this->extend('layouts/portal') ?>

<?php $this->section('content') ?>
<!-- Modal Create -->
<div class="modal fade" id="tambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="staticBackdropLabel">Form Tambah Data</h5>
            </div>
            <form action="<?= base_url('siswa/absensi/store') ?>" method="POST" enctype="multipart/form-data" files="true" id="form">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="id" value="<?= $id_magang ?>">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Tanggal Hari Ini</label>
                            <input type="text" class="form-control" value="<?php echo (new DateTime('now'))->format('d/m/Y') ?>" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Absensi</label>
                            <select name="absensi" id="absensi" class="form-select">
                                <option value="0">--Pilih Status--</option>
                                <option value="hadir">Hadir</option>
                                <option value="izin">Izin</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-6" id="fotoToggle">
                            <label class="form-label">Foto Absensi</label>
                            <input id="foto" name="foto" type="file" class="form-control">
                        </div>
                        <div class="mb-3 col-md-6" id="izinToggle">
                            <label class="form-label">Surat Izin</label>
                            <input id="izin" name="izin" type="file" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-success text-white" onclick="confirmSubmit()">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<h1 class="app-page-title">Data Absensi</h1>

<div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3 p-lg-4">
            <!-- <h3 class="mb-3">Welcome, developer!</h3> -->
            <div class="row gx-5 gy-3">
                <div class="col-12 col-lg-12">
                    <div class="mb-3 d-flex flex-row-reverse">
                        <button type="button" class="btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#tambah">
                            Tambah Data
                        </button>
                    </div>
                    <div class="table-responsive ">
                        <table class="table table-striped w-100" id="Tables">
                            <thead class="table-light">
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Absensi</th>
                                <th>Status Validasi Absensi</th>
                                <th>Catatan</th>
                                <th data-orderable="false">Aksi</th>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($list as $row) : ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?= date_format(new DateTime($row['tanggal']), 'd/m/Y'); ?></td>
                                        <td><?= $row['absen'] ?></td>
                                        <td><?= $row['status_absen'] ?></td>
                                        <td><?= ($row['status_absen'] == 'diproses') ? 'tidak ada catatan' : $row['catatan'] ?></td>
                                        <td>
                                            <button type="button" class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#Detail<?php echo $no ?>">
                                                Detail
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal Detail -->
                                    <div class="modal fade" id="Detail<?php echo $no ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header bg-info">
                                                    <h5 class="modal-title text-white" id="staticBackdropLabel">Detail Data</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Tanggal</label>
                                                            <input type="text" class="form-control" value="<?= date_format(new DateTime($row['tanggal']), 'd/m/Y'); ?>" readonly>
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Absensi</label>
                                                            <input type="text" class="form-control" value="<?= $row['absen'] ?>" readonly>
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Status Validasi Absensi</label>
                                                            <input type="text" class="form-control" value="<?= $row['status_absen'] ?>" readonly>
                                                        </div>
                                                        <?php if ($row['absen'] == 'hadir') : ?>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Foto Absensi</label>
                                                                <a class="btn btn-warning text-white w-100" id="fotoBtn" data-id="<?= base_url('assets/file/absensi/' . $row['foto_absensi']) ?>">Lihat</a>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if ($row['absen'] == 'izin') : ?>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Surat Izin</label>
                                                                <a href="<?= base_url('assets/file/absensi/' . $row['file_surat_izin']) ?>" class="btn btn-warning text-white w-100" download>Unduh</a>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="mb-3 col-md-12">
                                                            <label class="form-label">Catatan</label>
                                                            <textarea rows="4" class="form-control" readonly><?= ($row['status_absen'] == 'diproses') ? 'tidak ada catatan' : $row['catatan'] ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!--//row-->
        </div><!--//app-card-body-->

    </div><!--//inner-->
</div><!--//app-card-->
<?php $this->endSection() ?>

<?php $this->section('js') ?>
<script>
    function confirmSubmit() {
        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Anda tidak akan dapat mengembalikan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, serahkan!',
            cancelButtonText: 'Kembali',
        }).then((result) => {
            if (result.value) {
                document.getElementById("form").submit();
            }
        });
    }
</script>
<script>
    $(document).ready(function() {
        /* Get data table */
        var table = $('#Tables').DataTable({
            oLanguage: {
                sUrl: "<?= base_url('assets/template/dataTables/indonesian.json') ?>"
            }
        })

        $('#fotoBtn').click(function() {
            var this_id = $(this).data('id');
            const myGallery = GLightbox({
                elements: [{
                    'href': this_id,
                    'type': 'image',
                }]
            });
            myGallery.open();
        });

        $("#fotoToggle").hide();
        $("#izinToggle").hide();

        $("#absensi").change(function() {
            if ($("#absensi").val() == "hadir") {
                $("#fotoToggle").show();
                $("#izinToggle").hide();
            } else if ($("#absensi").val() == "izin") {
                $("#fotoToggle").hide();
                $("#izinToggle").show();
            } else {
                $("#fotoToggle").hide();
                $("#izinToggle").hide();
            }
        });

        <?php if (session()->has("success")) { ?>
            Swal.fire({
                icon: 'success',
                title: 'Bagus!',
                text: '<?= session("success") ?>'
            })
        <?php } ?>

        <?php if (session()->has("warning")) { ?>
            Swal.fire({
                icon: 'warning',
                title: 'Tunggu!',
                html: '<?= session("warning") ?>'
            })
        <?php } ?>
    });
</script>
<?php $this->endSection() ?>