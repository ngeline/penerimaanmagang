<?php $this->extend('layouts/portal') ?>

<?php $this->section('content') ?>
<!-- Modal Create -->
<div class="modal fade" id="tambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="staticBackdropLabel">Form Tambah Data</h5>
            </div>
            <form action="<?= base_url('siswa/kegiatan/store') ?>" method="POST" enctype="multipart/form-data" files="true" id="form">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="id" value="<?= $id_magang ?>">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Tanggal Kegiatan</label>
                            <input name="tanggal" type="date" <?= ($periodeMulai == 0) ? '' : 'min="' . $periodeMulai . '" max="' . $periodeSelesai . '"' ?> class="form-control" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Foto Kegiatan</label>
                            <input name="foto" type="file" class="form-control" required>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label class="form-label">Kegiatan</label>
                            <textarea name="kegiatan" rows="10" class="form-control" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success text-white">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<h1 class="app-page-title">Data Kegiatan</h1>

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
                                <th>Kegiatan</th>
                                <th>Status Validasi Kegiatan</th>
                                <th>Catatan</th>
                                <th data-orderable="false">Aksi</th>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($list as $row) : ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?= date_format(new DateTime($row['tanggal']), 'd/m/Y'); ?></td>
                                        <td><?= $row['kegiatan'] ?></td>
                                        <td><?= $row['status_kegiatan'] ?></td>
                                        <td><?= ($row['status_kegiatan'] == 'diproses') ? 'tidak ada catatan' : $row['catatan'] ?></td>
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
                                                            <label class="form-label">Kegiatan</label>
                                                            <textarea rows="10" class="form-control" readonly><?= $row['kegiatan'] ?></textarea>
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Status Validasi Kegiatan</label>
                                                            <input type="text" class="form-control" value="<?= $row['status_kegiatan'] ?>" readonly>
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Foto Kegiatan</label>
                                                            <a class="btn btn-warning text-white w-100 image-btn" data-image-url="<?= base_url('assets/file/kegiatan/' . $row['foto_kegiatan']) ?>">Lihat</a>
                                                        </div>
                                                        <div class="mb-3 col-md-12">
                                                            <label class="form-label">Catatan</label>
                                                            <textarea rows="4" class="form-control" readonly><?= ($row['status_kegiatan'] == 'diproses') ? 'tidak ada catatan' : $row['catatan'] ?></textarea>
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
    const form = document.getElementById('form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
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
                form.submit();
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        /* Get data table */
        var table = $('#Tables').DataTable({
            oLanguage: {
                sUrl: "<?= base_url('assets/template/dataTables/indonesian.json') ?>"
            }
        })

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