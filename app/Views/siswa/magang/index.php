<?php $this->extend('layouts/portal') ?>

<?php $this->section('content') ?>

<h1 class="app-page-title">Data Magang</h1>

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
                                <th>Periode Magang</th>
                                <th>Tempat Magang</th>
                                <th>Nama Pembimbing</th>
                                <th>Status Magang</th>
                                <th>Status Sertifikat</th>
                                <th data-orderable="false">Aksi</th>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($list as $row) : ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?= date_format(new DateTime($row['tanggal_mulai']), 'd/m/Y'); ?> - <?= date_format(new DateTime($row['tanggal_selesai']), 'd/m/Y'); ?></td>
                                        <td><?= $row['nama_bidang'] ?></td>
                                        <td><?= $row['nama'] ?></td>
                                        <td><?= $row['status_magang'] ?></td>
                                        <td><?= ($row['sertifikat']) ? 'sudah' : 'belum' ?></td>
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
                                                            <label class="form-label">Tempat Magang</label>
                                                            <input type="text" class="form-control" value="<?= $row['nama_bidang'] ?>" readonly>
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Periode Magang</label>
                                                            <input type="text" class="form-control" value="<?= date_format(new DateTime($row['tanggal_mulai']), 'd/m/Y'); ?> - <?= date_format(new DateTime($row['tanggal_selesai']), 'd/m/Y'); ?>" readonly>
                                                        </div>
                                                        <div class="mb-3 col-md-12">
                                                            <label class="form-label">Keterangan</label>
                                                            <textarea rows="4" class="form-control" readonly><?= $row['keterangan'] ?></textarea>
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Status Magang</label>
                                                            <input type="text" class="form-control" value="<?= $row['status_magang'] ?>" readonly>
                                                        </div>
                                                        <?php if ($row['sertifikat']) : ?>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Sertifikat</label>
                                                                <a href="<?= base_url('siswa/generate-sertifikat/' . $row['id_magang']) ?>" class="btn btn-warning text-white w-100">Cetak</a>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Nama Pembimbing</label>
                                                            <input type="text" class="form-control" value="<?= $row['nama'] ?>" readonly>
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Nomor Telepon</label>
                                                            <input type="text" class="form-control" value="<?= $row['telepon'] ?>" readonly>
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
    $(document).ready(function() {
        /* Ajax Token */
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /* Get data table */
        var table = $('#Tables').DataTable({
            oLanguage: {
                sUrl: "<?= base_url('assets/template/dataTables/indonesian.json') ?>"
            }
        });
    });
</script>
<?php $this->endSection() ?>