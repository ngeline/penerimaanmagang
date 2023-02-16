<?php $this->extend('layouts/portal') ?>

<?php $this->section('content') ?>
<!-- Modal Create -->
<div class="modal fade" id="tambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="staticBackdropLabel">Form Tambah Data</h5>
            </div>
            <form action="<?= base_url('admin/magang/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label class="form-label">List Pengajuan Diterima</label>
                            <select name="pengajuan" id="pengajuan" class="form-select">
                                <option value="0">--Pilih List Pengajuan--</option>
                                <?php foreach ($pengajuan as $item) : ?>
                                    <option value="<?= $item['id_pengajuan'] ?>"><?= $item['nama_siswa'] ?> | Periode magang : <?= date_format(new DateTime($item['tanggal_mulai']), 'd/m/Y'); ?> - <?= date_format(new DateTime($item['tanggal_selesai']), 'd/m/Y'); ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label class="form-label">Daftar Siswa Sesuai List Pengajuan</label>
                            <textarea id="daftar" rows="10" class="form-control" readonly></textarea>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Pilih Siswa Magang</label>
                            <select name="daftarSiswa" id="daftarSiswa" class="form-select">
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Pilih Pembimbing Magang</label>
                            <select name="pembimbing" id="pembimbing" class="form-select">
                                <option value="">--Pilih Pembimbing--</option>
                                <?php foreach ($pembimbing as $item) : ?>
                                    <option value="<?= $item['id'] ?>"><?= $item['nama'] ?></option>
                                <?php endforeach ?>
                            </select>
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

<h1 class="app-page-title">Kelola Magang</h1>

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
                                <th>Nama Pemohon</th>
                                <th>Nama Siswa Magang</th>
                                <th>Nama Pembimbing</th>
                                <th>Periode Magang</th>
                                <th data-orderable="false">Aksi</th>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($list as $row) : ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?= $row['s_nama'] ?></td>
                                        <td><?= $row['nama_siswa'] ?></td>
                                        <td><?= $row['nama_pembimbing'] ?></td>
                                        <td><?= date_format(new DateTime($row['tanggal_mulai']), 'd/m/Y'); ?> - <?= date_format(new DateTime($row['tanggal_selesai']), 'd/m/Y'); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target="#Edit<?php echo $no ?>">
                                                Edit
                                            </button>
                                            <button id="confirm-button-<?= $row['id_magang'] ?>" class="btn btn-danger text-white" data-id="<?= base_url('admin/magang/delete/' . $row['id_magang']) ?>">Hapus</button>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="Edit<?php echo $no ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header bg-warning">
                                                    <h5 class="modal-title text-white" id="staticBackdropLabel">Form Edit Data</h5>
                                                </div>
                                                <form action="<?= base_url('admin/magang/update') ?>" method="POST">
                                                    <?= csrf_field() ?>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" value="<?= $row['id_magang'] ?>">
                                                        <div class="row">
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Siswa Magang</label>
                                                                <input type="text" class="form-control" value="<?= $row['nama_siswa']; ?>" readonly>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Pembimbing Magang</label>
                                                                <select name="editPembimbing" id="editPembimbing" class="form-select">
                                                                    <option value="">--Pilih Pembimbing--</option>
                                                                    <?php foreach ($pembimbing as $item) : ?>
                                                                        <option value="<?= $item['id'] ?>" <?= ($row['id_pembimbing'] == $item['id']) ? 'selected' : '' ?>><?= $item['nama'] ?></option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Status Magang</label>
                                                                <select name="editStatus" id="editStatus" class="form-select">
                                                                    <option value="">--Pilih Status--</option>
                                                                    <option value="berjalan" <?= ($row['status_magang'] == 'berjalan') ? 'selected' : '' ?>>Berjalan</option>
                                                                    <option value="selesai" <?= ($row['status_magang'] == 'selesai') ? 'selected' : '' ?>>Selesai</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">No. Sertifikat Magang</label>
                                                                <input type="text" id="editSertifikat" name="editSertifikat" class="form-control" value="<?= $row['sertifikat']; ?>">
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

        // Add an onchange event listener to the select element
        $('#pengajuan').on('change', function() {

            // Get the selected value
            const selectedValue = $('#pengajuan').val();

            // Make an AJAX request using the selected value
            $.ajax({
                url: '<?= base_url('admin/magang/list-siswa') ?>',
                type: 'GET',
                data: {
                    id: selectedValue
                },
                success: function(response) {
                    if (response.anggota == 0) {
                        $('#daftar').val('');
                    } else {
                        $('#daftar').val(response.anggota.join(', '));
                    }
                    if (response.listSiswa == 0) {
                        $('#daftarSiswa').empty();
                    } else {
                        $('#daftarSiswa').empty();
                        $.each(response.listSiswa, function(index, item) {
                            $('#daftarSiswa').append('<option value="' + item.id + '">' + item.nama + '</option>');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Code to handle the AJAX error
                }
            });
        });

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