<?php $this->extend('layouts/portal') ?>

<?php $this->section('content') ?>
<!-- Modal Create -->
<div class="modal fade" id="tambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="staticBackdropLabel">Form Tambah Data</h5>
            </div>
            <form action="<?= base_url('admin/pembimbing/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input id="nama" name="nama" type="text" class="form-control">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">NIP</label>
                            <input id="nip" name="nip" type="number" class="form-control">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Bidang Pekerjaan</label>
                            <select name="bidang" id="bidang" class="form-select">
                                <option value="">--Pilih Status--</option>
                                <?php foreach ($bidang as $item) : ?>
                                    <option value="<?= $item['id'] ?>"><?= $item['nama_bidang'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Email</label>
                            <input id="email" name="email" type="email" class="form-control">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Telepon</label>
                            <input id="telepon" name="telepon" type="number" class="form-control">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jk" id="jk" class="form-select">
                                <option value="">--Pilih Status--</option>
                                <option value="l">Laki-laki</option>
                                <option value="p">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamat" rows="10" class="form-control"></textarea>
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

<h1 class="app-page-title">Kelola Pembimbing Lapangan</h1>

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
                                <th>NIP</th>
                                <th>Nama Lengkap</th>
                                <th>Bidang</th>
                                <th>Telepon</th>
                                <th data-orderable="false">Aksi</th>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($list as $row) : ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?= $row['nip'] ?></td>
                                        <td><?= $row['nama'] ?></td>
                                        <td><?= $row['nama_bidang'] ?></td>
                                        <td><?= $row['telepon'] ?></td>
                                        <td>
                                            <button type="button" class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target="#Edit<?php echo $no ?>">
                                                Edit
                                            </button>
                                            <button id="confirm-button-<?= $row['id_pembimbing'] ?>" class="btn btn-danger text-white" data-id="<?= base_url('admin/pembimbing/delete/' . $row['id_pembimbing'] . '/' . $row['id_users']) ?>">Hapus</button>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="Edit<?php echo $no ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header bg-warning">
                                                    <h5 class="modal-title text-white" id="staticBackdropLabel">Form Edit Data</h5>
                                                </div>
                                                <form action="<?= base_url('admin/pembimbing/update') ?>" method="POST">
                                                    <?= csrf_field() ?>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" value="<?= $row['id_pembimbing'] ?>">
                                                        <div class="row">
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Nama Lengkap</label>
                                                                <input id="nama" name="nama" type="text" class="form-control" value="<?= $row['nama']; ?>">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">NIP</label>
                                                                <input id="nip" name="nip" type="number" class="form-control" value="<?= $row['nip']; ?>">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Bidang Pekerjaan</label>
                                                                <select name="bidang" id="bidang" class="form-select">
                                                                    <option value="">--Pilih Status--</option>
                                                                    <?php foreach ($bidang as $item) : ?>
                                                                        <option value="<?= $item['id'] ?>" <?= ($row['bidang_id'] == $item['id']) ? 'selected' : '' ?>><?= $item['nama_bidang'] ?></option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Email</label>
                                                                <input id="email" name="email" type="email" class="form-control" value="<?= $row['email']; ?>">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Telepon</label>
                                                                <input id="telepon" name="telepon" type="number" class="form-control" value="<?= $row['telepon']; ?>">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Jenis Kelamin</label>
                                                                <select name="jk" id="jk" class="form-select">
                                                                    <option value="">--Pilih Status--</option>
                                                                    <option value="l" <?= ($row['jenis_kelamin'] == 'l') ? 'selected' : '' ?>>Laki-laki</option>
                                                                    <option value="p" <?= ($row['jenis_kelamin'] == 'p') ? 'selected' : '' ?>>Perempuan</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3 col-md-12">
                                                                <label class="form-label">Alamat</label>
                                                                <textarea name="alamat" id="alamat" rows="10" class="form-control"><?= $row['alamat']; ?></textarea>
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

        $(".btn-danger").click(function() {
            var id = $(this).data('id');

            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Kembali',
            }).then((result) => {
                if (result.value) {
                    window.location.href = id;
                }
            });
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