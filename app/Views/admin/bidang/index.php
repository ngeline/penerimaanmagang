<?php $this->extend('layouts/portal') ?>

<?php $this->section('content') ?>
<h1 class="app-page-title">Kelola Bidang Pegawai</h1>

<div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3 p-lg-4">
            <!-- <h3 class="mb-3">Welcome, developer!</h3> -->
            <div class="row gx-5 gy-3">
                <div class="col-12 col-lg-12">
                    <div class="table-responsive ">
                        <table class="table table-striped w-100" id="Tables">
                            <thead class="table-light">
                                <th style="width: 2%;">No</th>
                                <th>Nama Bidang</th>
                                <th>Singkatan Bidang</th>
                                <th>Kepala Bidang</th>
                                <th>Keterangan</th>
                                <th data-orderable="false" style="width: 10%;">Aksi</th>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($list as $row) : ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?= $row['nama_bidang'] ?></td>
                                        <td><?= $row['singkatan_bidang'] ?></td>
                                        <td><?= $row['kepala_bidang'] ?></td>
                                        <td><?= $row['keterangan'] ?></td>
                                        <td>
                                            <button type="button" class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target="#Edit<?php echo $no ?>">
                                                Edit
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="Edit<?php echo $no ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header bg-warning">
                                                    <h5 class="modal-title text-white" id="staticBackdropLabel">For Edit Data</h5>
                                                </div>
                                                <form action="<?= base_url('admin/bidang/update') ?>" method="POST" enctype="multipart/form-data" files="true">
                                                    <?= csrf_field() ?>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                        <div class="row">
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Nama Bidang</label>
                                                                <input type="text" class="form-control" value="<?= $row['nama_bidang'] ?>" readonly>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Singkatan Bidang</label>
                                                                <input type="text" name="singkatan" class="form-control" value="<?= $row['singkatan_bidang'] ?>">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Kepala Bidang</label>
                                                                <input type="text" name="kepala" class="form-control" value="<?= $row['kepala_bidang'] ?>">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">NIP Kepala Bidang</label>
                                                                <input type="text" name="nip" class="form-control" value="<?= $row['nip'] ?>">
                                                            </div>
                                                            <div class="mb-3 col-md-12">
                                                                <label class="form-label">Tanda Tangan Kepala Bidang <span style="color: red; font-size: 11px;">*tipe file png, ukuran max 1mb</span></label>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <a class="btn btn-warning text-white w-100 image-btn" data-image-url="<?= base_url('assets/file/ttd/' . $row['ttd']) ?>">Lihat Tanda Tangan Sebelumnya</a>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <input type="file" name="ttd" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 col-md-12">
                                                                <label class="form-label">Keterangan</label>
                                                                <textarea name="keterangan" rows="10" class="form-control" required><?= $row['keterangan'] ?></textarea>
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