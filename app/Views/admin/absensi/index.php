<?php $this->extend('layouts/portal') ?>

<?php $this->section('content') ?>
<h1 class="app-page-title">Kelola Absensi Magang</h1>

<div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3 p-lg-4">
            <!-- <h3 class="mb-3">Welcome, developer!</h3> -->
            <div class="row gx-5 gy-3">
                <div class="col-12 col-lg-12">
                    <div class="table-responsive ">
                        <table class="table table-striped w-100" id="Tables">
                            <thead class="table-light">
                                <th>No</th>
                                <th>Tanggal Absensi</th>
                                <th>Nama Siswa Magang</th>
                                <th>Absensi</th>
                                <th>Status Validasi Absensi</th>
                                <th data-orderable="false">Aksi</th>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($list as $row) : ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?= date_format(new DateTime($row['tanggal']), 'd/m/Y'); ?></td>
                                        <td><?= $row['nama'] ?></td>
                                        <td><?= $row['absen'] ?></td>
                                        <td><?= $row['status_absen'] ?></td>
                                        <td>
                                            <button type="button" class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target="#Validasi<?php echo $no ?>">
                                                Validasi
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal Validasi -->
                                    <div class="modal fade" id="Validasi<?php echo $no ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header bg-warning">
                                                    <h5 class="modal-title text-white" id="staticBackdropLabel">Form Validasi Data</h5>
                                                </div>
                                                <form action="<?= base_url('admin/absensi/update') ?>" method="POST">
                                                    <?= csrf_field() ?>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" value="<?= $row['id_absensi'] ?>">
                                                        <div class="row">
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Nama Siswa Magang</label>
                                                                <input type="text" class="form-control" value="<?= $row['nama']; ?>" readonly>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Tanggal</label>
                                                                <input type="text" class="form-control" value="<?= date_format(new DateTime($row['tanggal']), 'd/m/Y'); ?>" readonly>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Absensi</label>
                                                                <input type="text" class="form-control" value="<?= $row['absen'] ?>" readonly>
                                                            </div>
                                                            <?php if ($row['absen'] == 'hadir') : ?>
                                                                <div class="mb-3 col-md-6">
                                                                    <label class="form-label">Foto Absensi</label>
                                                                    <a class="btn btn-warning text-white w-100 image-btn" data-image-url="<?= base_url('assets/file/absensi/' . $row['foto_absensi']) ?>">Lihat</a>
                                                                </div>
                                                            <?php endif; ?>
                                                            <?php if ($row['absen'] == 'izin') : ?>
                                                                <div class="mb-3 col-md-6">
                                                                    <label class="form-label">Surat Izin</label>
                                                                    <a href="<?= base_url('assets/file/absensi/' . $row['file_surat_izin']) ?>" class="btn btn-warning text-white w-100" download>Unduh</a>
                                                                </div>
                                                            <?php endif; ?>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Status Validasi Absensi</label>
                                                                <select name="validasiStatus" id="validasiStatus" class="form-select" required>
                                                                    <option value="diproses" <?= ($row['status_absen'] == 'diproses') ? 'selected' : '' ?>>Diproses</option>
                                                                    <option value="diterima" <?= ($row['status_absen'] == 'diterima') ? 'selected' : '' ?>>Diterima</option>
                                                                    <option value="ditolak" <?= ($row['status_absen'] == 'ditolak') ? 'selected' : '' ?>>Ditolak</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Catatan</label>
                                                                <textarea name="validasiCatatan" rows="4" class="form-control" required><?= ($row['status_absen'] == 'diproses') ? '' : $row['catatan'] ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-warning text-white">Simpan</button>
                                                    </div>
                                                </form>
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
    $(document).ready(function() {
        /* Get data table */
        var table = $('#Tables').DataTable({
            oLanguage: {
                sUrl: "<?= base_url('assets/template/dataTables/indonesian.json') ?>"
            }
        });

        $('.image-btn').click(function() {
            var this_id = $(this).data('image-url');
            const myGallery = GLightbox({
                elements: [{
                    'href': this_id,
                    'type': 'image',
                }]
            });
            myGallery.open();
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