<?php $this->extend('layouts/portal') ?>

<?php $this->section('content') ?>
<h1 class="app-page-title">Profil Pembimbing Lapangan</h1>

<div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3 p-lg-4">
            <!-- <h3 class="mb-3">Welcome, developer!</h3> -->
            <div class="row gx-5 gy-3">
                <div class="col-12 col-lg-12">
                    <h5>Form Perbarui Data Diri</h5>
                    <hr>
                    <form action="<?= base_url('pembimbing/profile/update') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id" value="<?= $pembimbing['id']; ?>">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <input id="nama" name="nama" type="text" class="form-control" value="<?= $pembimbing['nama']; ?>" required="required">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">NIP</label>
                                <input id="nip" name="nip" type="text" class="form-control" value="<?= $pembimbing['nip']; ?>" readonly>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Bidang Pekerjaan</label>
                                <input id="bidang" name="bidang" type="text" class="form-control" value="<?= $bidang['nama_bidang']; ?>" readonly>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jk" id="jk" class="form-select" required>
                                    <option value="">--Pilih Status--</option>
                                    <option value="l" <?= ($pembimbing['jenis_kelamin'] == 'l') ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="p" <?= ($pembimbing['jenis_kelamin'] == 'p') ? 'selected' : '' ?>>Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Email</label>
                                <input id="email" name="email" type="email" class="form-control" value="<?= $pembimbing['email']; ?>" required="required">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Telepon</label>
                                <input id="telepon" name="telepon" type="number" class="form-control" value="<?= $pembimbing['telepon']; ?>" required="required">
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat" id="alamat" rows="10" class="form-control" required><?= $pembimbing['alamat']; ?></textarea>
                            </div>
                            <div class="col-md-12">
                                <div class="mt-3 d-flex flex-row-reverse">
                                    <button type="submit" class="btn btn-primary text-white">Simpan Data Diri</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <h5 class="mt-4">Form Perbarui Nama Pengguna & Kata Sandi</h5>
                    <hr>
                    <form action="<?= base_url('pembimbing/users/update') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id" value="<?= $users['id']; ?>">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Nama Pengguna</label>
                                <input id="username" name="username" type="text" class="form-control" value="<?= $users['username']; ?>">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Kata Sandi</label>
                                <input id="password" name="password" type="password" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <div class="mt-3 d-flex flex-row-reverse">
                                    <button type="submit" class="btn btn-primary text-white button-container">Simpan Pengguna & Sandi</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr>
                </div>
            </div><!--//row-->
        </div><!--//app-card-body-->

    </div><!--//inner-->
</div><!--//app-card-->
<?php $this->endSection() ?>

<?php $this->section('js') ?>
<script>
    $(document).ready(function() {
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