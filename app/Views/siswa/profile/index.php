<?php $this->extend('layouts/portal') ?>

<?php $this->section('content') ?>
<h1 class="app-page-title">Profil Siswa Magang</h1>

<div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3 p-lg-4">
            <!-- <h3 class="mb-3">Welcome, developer!</h3> -->
            <div class="row gx-5 gy-3">
                <div class="col-12 col-lg-12">
                    <h5>Form Perbarui Data Diri</h5>
                    <hr>
                    <form action="<?= base_url('siswa/profile/update') ?>" method="POST" id="form-profile">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id" value="<?= $siswa['id']; ?>">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <input id="nama" name="nama" type="text" class="form-control" value="<?= $siswa['nama']; ?>" required="required">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jk" id="jk" class="form-select" required>
                                    <option value="">--Pilih Status--</option>
                                    <option value="l" <?= ($siswa['jenis_kelamin'] == 'l') ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="p" <?= ($siswa['jenis_kelamin'] == 'p') ? 'selected' : '' ?>>Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Email</label>
                                <input id="email" name="email" type="email" class="form-control" value="<?= $siswa['email']; ?>" required="required">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Telepon</label>
                                <input id="telepon" name="telepon" type="number" class="form-control" value="<?= $siswa['telepon']; ?>" required="required">
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat" id="alamat" rows="10" class="form-control" required><?= $siswa['alamat']; ?></textarea>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Jenjang Pendidikan</label>
                                <select name="jenjang" id="jenjang" class="form-select" required>
                                    <option value="0">--Pilih Status--</option>
                                    <option value="Perguruan Tinggi" <?= ($siswa['jenjang'] == 'Perguruan Tinggi') ? 'selected' : '' ?>>Perguruan Tinggi</option>
                                    <option value="SLTA" <?= ($siswa['jenjang'] == 'SLTA') ? 'selected' : '' ?>>SLTA Sederajat</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6" id="divProdi">
                                <label class="form-label">Prodi</label>
                                <input id="prodi" name="prodi" type="text" class="form-control" value="<?= $siswa['prodi']; ?>" required="required">
                            </div>
                            <div class="mb-3 col-md-6" id="divJurusan">
                                <label class="form-label">Jurusan</label>
                                <input id="jurusan" name="jurusan" type="text" class="form-control" value="<?= $siswa['jurusan']; ?>" required="required">
                            </div>
                            <div class="mb-3 col-md-6" id="divKelas">
                                <label class="form-label">Kelas</label>
                                <input id="kelas" name="kelas" type="number" class="form-control" value="<?= $siswa['kelas']; ?>" required="required">
                            </div>
                            <div class="mb-3 col-md-6" id="divTingkat">
                                <label class="form-label">Semester</label>
                                <input id="tingkat" name="tingkat" type="number" class="form-control" value="<?= $siswa['tingkat']; ?>" required="required">
                            </div>
                            <div class="mb-3 col-md-6" id="divSekolah">
                                <label class="form-label">Asal Sekolah</label>
                                <input id="sekolah" name="sekolah" type="text" class="form-control" value="<?= $siswa['asal_sekolah']; ?>" required="required">
                            </div>
                            <div class="mb-3 col-md-6" id="divPerguruan">
                                <label class="form-label">Perguruan Tinggi</label>
                                <input id="perguruan" name="perguruan" type="text" class="form-control" value="<?= $siswa['perguruan']; ?>" required="required">
                            </div>
                            <div class="mb-3 col-md-6" id="divNisn">
                                <label class="form-label">NISN</label>
                                <input id="nisn" name="nisn" type="number" class="form-control" value="<?= $siswa['nisn']; ?>" required="required">
                            </div>
                            <div class="mb-3 col-md-6" id="divNim">
                                <label class="form-label">NIM</label>
                                <input id="nim" name="nim" type="number" class="form-control" value="<?= $siswa['nim']; ?>" required="required">
                            </div>
                            <div class="col-md-12">
                                <div class="mt-3 d-flex flex-row-reverse">
                                    <button type="submit" class="btn btn-primary text-white">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <h5 class="mt-4">Form Perbarui Nama Pengguna & Kata Sandi</h5>
                    <hr>
                    <form action="<?= base_url('siswa/users/update') ?>" method="POST">
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
                                    <button type="submit" class="btn btn-primary text-white button-container">Simpan</button>
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
    const form = document.getElementById('form-profile');
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

        function sembunyi() {
            $("#divNim").hide();
            $("#divNisn").hide();
            $("#divPerguruan").hide();
            $("#divSekolah").hide();
            $("#divTingkat").hide();
            $("#divKelas").hide();
            $("#divJurusan").hide();
            $("#divProdi").hide();

            $("#nim").prop("readonly", true);
            $("#nisn").prop("readonly", true);
            $("#perguruan").prop("readonly", true);
            $("#sekolah").prop("readonly", true);
            $("#tingkat").prop("readonly", true);
            $("#kelas").prop("readonly", true);
            $("#jurusan").prop("readonly", true);
            $("#prodi").prop("readonly", true);
        }

        function PerguruanSembunyi() {
            $("#divNim").hide();
            $("#divPerguruan").hide();
            $("#divTingkat").hide();
            $("#divProdi").hide();

            $("#nim").prop("readonly", true);
            $("#perguruan").prop("readonly", true);
            $("#tingkat").prop("readonly", true);
            $("#prodi").prop("readonly", true);
        }

        function SltaSembunyi() {
            $("#divNisn").hide();
            $("#divSekolah").hide();
            $("#divKelas").hide();

            $("#nisn").prop("readonly", true);
            $("#sekolah").prop("readonly", true);
            $("#kelas").prop("readonly", true);
        }

        $(function() {
            <?= ($siswa['status_lengkap'] == 'tidak') ? 'sembunyi();' : '' ?>
            <?= ($siswa['status_lengkap'] == 'lengkap' && $siswa['jenjang'] == 'SLTA') ? 'PerguruanSembunyi();' : '' ?>
            <?= ($siswa['status_lengkap'] == 'lengkap' && $siswa['jenjang'] == 'Perguruan Tinggi') ? 'SltaSembunyi();' : '' ?>
        });

        $("#jenjang").change(function() {
            if ($("#jenjang").val() == "SLTA") {
                $("#divNisn").show();
                $("#divSekolah").show();
                $("#divKelas").show();
                $("#divJurusan").show();

                $("#nisn").prop("readonly", false);
                $("#sekolah").prop("readonly", false);
                $("#kelas").prop("readonly", false);
                $("#jurusan").prop("readonly", false);

                PerguruanSembunyi();
            } else if ($("#jenjang").val() == "Perguruan Tinggi") {
                $("#divNim").show();
                $("#divPerguruan").show();
                $("#divTingkat").show();
                $("#divJurusan").show();
                $("#divProdi").show();

                $("#nim").prop("readonly", false);
                $("#perguruan").prop("readonly", false);
                $("#tingkat").prop("readonly", false);
                $("#jurusan").prop("readonly", false);
                $("#prodi").prop("readonly", false);

                SltaSembunyi();
            } else {
                sembunyi();
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