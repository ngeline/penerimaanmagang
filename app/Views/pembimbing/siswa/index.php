<?php $this->extend('layouts/portal') ?>

<?php $this->section('content') ?>
<h1 class="app-page-title">Data Siswa Magang</h1>

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
                                <th>Nama Lengkap</th>
                                <th>Jenjang</th>
                                <th>Jurusan</th>
                                <th>Telepon</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($list as $row) : ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?= $row['nama'] ?></td>
                                        <td><?= $row['jenjang'] ?></td>
                                        <td><?= $row['jurusan'] ?></td>
                                        <td><?= $row['telepon'] ?></td>
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
                                                    <h5 class="modal-title text-white" id="staticBackdropLabel">Form Detail Data</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Nama Lengkap</label>
                                                            <input type="text" class="form-control" value="<?= $row['nama']; ?>" readonly>
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Jenis Kelamin</label>
                                                            <input type="text" class="form-control" value="<?= ($row['jenis_kelamin'] == 'l') ? 'Laki-laki' : 'Perempuan'; ?>" readonly>
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Email</label>
                                                            <input type="email" class="form-control" value="<?= $row['email']; ?>" readonly>
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Telepon</label>
                                                            <input type="number" class="form-control" value="<?= $row['telepon']; ?>" readonly>
                                                        </div>
                                                        <div class="mb-3 col-md-12">
                                                            <label class="form-label">Alamat</label>
                                                            <textarea rows="10" class="form-control" readonly><?= $row['alamat']; ?></textarea>
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Jenjang Pendidikan</label>
                                                            <input type="text" class="form-control" value="<?= $row['jenjang']; ?>" readonly>
                                                        </div>
                                                        <?php if ($row['jenjang'] === 'SLTA') : ?>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Jurusan</label>
                                                                <input id="jurusan" type="text" class="form-control" value="<?= $row['jurusan']; ?>" readonly>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Kelas</label>
                                                                <input id="kelas" type="number" class="form-control" value="<?= $row['kelas']; ?>" readonly>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Asal Sekolah</label>
                                                                <input id="sekolah" type="text" class="form-control" value="<?= $row['asal_sekolah']; ?>" readonly>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">NISN</label>
                                                                <input id="nisn" type="number" class="form-control" value="<?= $row['nisn']; ?>" readonly>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if ($row['jenjang'] === 'Perguruan Tinggi') : ?>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Prodi</label>
                                                                <input id="prodi" type="text" class="form-control" value="<?= $row['prodi']; ?>" readonly>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Jurusan</label>
                                                                <input id="jurusan" type="text" class="form-control" value="<?= $row['jurusan']; ?>" readonly>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Tingkat</label>
                                                                <input id="tingkat" type="number" class="form-control" value="<?= $row['tingkat']; ?>" readonly>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Perguruan Tinggi</label>
                                                                <input id="perguruan" type="text" class="form-control" value="<?= $row['perguruan']; ?>" readonly>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">NIM</label>
                                                                <input id="nim" type="number" class="form-control" value="<?= $row['nim']; ?>" readonly>
                                                            </div>
                                                        <?php endif; ?>
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
        /* Get data table */
        var table = $('#Tables').DataTable({
            oLanguage: {
                sUrl: "<?= base_url('assets/template/dataTables/indonesian.json') ?>"
            }
        })
    });
</script>
<?php $this->endSection() ?>