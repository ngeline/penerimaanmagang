<?php $this->extend('layouts/portal') ?>

<?php $this->section('content') ?>
<h1 class="app-page-title">Kelola Siswa Magang</h1>

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
                                <th>Nama Pengguna</th>
                                <th>Nama Lengkap</th>
                                <th>Jenjang</th>
                                <th>Jurusan</th>
                                <th>Telepon</th>
                                <th data-orderable="false">Aksi</th>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($list as $row) : ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?= $row['username'] ?></td>
                                        <td><?= ($row['nama'] == '') ? '<mark>Pengguna belum melengkapi profil</mark>' : $row['nama'] ?></td>
                                        <td><?= ($row['jenjang'] == '') ? '<mark>Pengguna belum melengkapi profil</mark>' : $row['jenjang'] ?></td>
                                        <td><?= ($row['jurusan'] == '') ? '<mark>Pengguna belum melengkapi profil</mark>' : $row['jurusan'] ?></td>
                                        <td><?= ($row['telepon'] == '') ? '<mark>Pengguna belum melengkapi profil</mark>' : $row['telepon'] ?></td>
                                        <td>
                                            <button type="button" class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target="#Edit<?php echo $no ?>">
                                                Edit
                                            </button>
                                            <button id="confirm-button-<?= $row['id_siswa'] ?>" class="btn btn-danger text-white" data-id="<?= base_url('admin/siswa/delete/' . $row['id_siswa'] . '/' . $row['id_users']) ?>">Hapus</button>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="Edit<?php echo $no ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header bg-warning">
                                                    <h5 class="modal-title text-white" id="staticBackdropLabel">Form Edit Data</h5>
                                                </div>
                                                <form action="<?= base_url('admin/siswa/update') ?>" method="POST">
                                                    <?= csrf_field() ?>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" value="<?= $row['id_siswa'] ?>">
                                                        <div class="row">
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Nama Lengkap</label>
                                                                <input id="nama" name="nama" type="text" class="form-control" value="<?= $row['nama']; ?>">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Jenis Kelamin</label>
                                                                <select name="jk" id="jk" class="form-select">
                                                                    <option value="">--Pilih Status--</option>
                                                                    <option value="l" <?= ($row['jenis_kelamin'] == 'l') ? 'selected' : '' ?>>Laki-laki</option>
                                                                    <option value="p" <?= ($row['jenis_kelamin'] == 'p') ? 'selected' : '' ?>>Perempuan</option>
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
                                                            <div class="mb-3 col-md-12">
                                                                <label class="form-label">Alamat</label>
                                                                <textarea name="alamat" id="alamat" rows="10" class="form-control"><?= $row['alamat']; ?></textarea>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Jenjang Pendidikan</label>
                                                                <select name="jenjang" id="jenjang" class="form-select" required>
                                                                    <option value="">--Pilih Status--</option>
                                                                    <option value="Perguruan Tinggi" <?= ($row['jenjang'] == 'Perguruan Tinggi') ? 'selected' : '' ?>>Perguruan Tinggi</option>
                                                                    <option value="SLTA" <?= ($row['jenjang'] == 'SLTA') ? 'selected' : '' ?>>SLTA Sederajat</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Prodi <span class="text-danger" style="font-size: 9pt;">*bagi perguruan tinggi</span></label>
                                                                <input id="prodi" name="prodi" type="text" class="form-control" value="<?= $row['prodi']; ?>">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Jurusan</label>
                                                                <input id="jurusan" name="jurusan" type="text" class="form-control" value="<?= $row['jurusan']; ?>">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Kelas <span class="text-danger" style="font-size: 9pt;">*bagi SLTA</span></label>
                                                                <input id="kelas" name="kelas" type="number" class="form-control" value="<?= $row['kelas']; ?>">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Semester <span class="text-danger" style="font-size: 9pt;">*bagi perguruan tinggi</span></label>
                                                                <input id="tingkat" name="tingkat" type="number" class="form-control" value="<?= $row['tingkat']; ?>">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Asal Sekolah <span class="text-danger" style="font-size: 9pt;">*bagi SLTA</span></label>
                                                                <input id="sekolah" name="sekolah" type="text" class="form-control" value="<?= $row['asal_sekolah']; ?>">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Perguruan Tinggi <span class="text-danger" style="font-size: 9pt;">*bagi perguruan tinggi</span></label>
                                                                <input id="perguruan" name="perguruan" type="text" class="form-control" value="<?= $row['perguruan']; ?>">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">NISN <span class="text-danger" style="font-size: 9pt;">*bagi SLTA</span></label>
                                                                <input id="nisn" name="nisn" type="number" class="form-control" value="<?= $row['nisn']; ?>">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">NIM <span class="text-danger" style="font-size: 9pt;">*bagi perguruan tinggi</span></label>
                                                                <input id="nim" name="nim" type="number" class="form-control" value="<?= $row['nim']; ?>">
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