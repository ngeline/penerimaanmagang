<?php $this->extend('layouts/portal') ?>

<?php $this->section('content') ?>
<!-- Modal Create -->
<div class="modal fade" id="tambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="staticBackdropLabel">Form Tambah Data</h5>
            </div>
            <form action="<?= base_url('pembimbing/penilaian/store') ?>" method="POST" id="form">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label class="form-label">Siswa Magang</label>
                            <select name="siswa" id="siswa" class="form-select" required>
                                <?php foreach ($siswa as $row) : ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3 col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered w-100">
                                    <thead>
                                        <th>Kategori</th>
                                        <th>Nilai</th>
                                    </thead>
                                    <tbody>
                                        <?php $noKategori = 1;
                                        $idKategori = 1; ?>
                                        <?php foreach ($kategori as $row) : ?>
                                            <tr>
                                                <td>
                                                    <label class="form-label"><?= $row['nama_kategori'] ?></label><br>
                                                    <p style="font-size: 13px;"><?= $row['keterangan'] ?></p>
                                                    <input type="hidden" name="idKategori[]" value="<?= $row['id'] ?>">
                                                </td>
                                                <td><input type="number" name="nilaiKategori[]" min="0" max="100" class="form-control"></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-success text-white" onclick="confirmSubmit()">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="edtiModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white" id="staticBackdropLabel">Form Edit Data</h5>
            </div>
            <form action="<?= base_url('pembimbing/penilaian/update') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label class="form-label">Siswa Magang</label>
                            <input type="text" id="editSiswa" class="form-control" readonly>
                        </div>
                        <div class="mb-3 col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered w-100">
                                    <thead>
                                        <th>Kategori</th>
                                        <th>Nilai</th>
                                    </thead>
                                    <tbody id="myTableBody">
                                    </tbody>
                                </table>
                            </div>
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

<h1 class="app-page-title">Kelola Data Penilaian</h1>

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
                                <th>Nama Siswa</th>
                                <th>Periode Magang</th>
                                <th>Total Rata-Rata Penilaian</th>
                                <th data-orderable="false">Aksi</th>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($list as $row) : ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?= $row['nama'] ?></td>
                                        <td><?= date_format(new DateTime($row['tanggal_mulai']), 'd/m/Y'); ?> - <?= date_format(new DateTime($row['tanggal_selesai']), 'd/m/Y'); ?></td>
                                        <td><?= number_format(($row['total_sum'] / $count), 2, ',', '') ?></td>
                                        <td>
                                            <button type="button" class="btn btn-warning text-white" id="editBtn" data-id="<?= $row['magang_id'] ?>">
                                                Edit
                                            </button>
                                        </td>
                                    </tr>
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
    function confirmSubmit() {
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
                document.getElementById("form").submit();
            }
        });
    }
</script>
<script>
    $(document).ready(function() {
        /* Get data table */
        var table = $('#Tables').DataTable({
            oLanguage: {
                sUrl: "<?= base_url('assets/template/dataTables/indonesian.json') ?>"
            }
        })

        $('body').on('click', '#editBtn', function() {
            var this_id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "<?= base_url('pembimbing/penilaian/edit') ?>",
                data: {
                    id: this_id,
                },
                success: function(response) {
                    $('#edtiModal').modal('show');
                    $('#editSiswa').val(response.siswa);
                    $('#myTableBody').empty();
                    $.each(response.penilaian, function(i, item) {
                        var row = '<tr>' +
                            '<td><label class="form-label">' + item.nama_kategori + '</label><br>' +
                            '<p style="font-size: 13px;">' + item.keterangan + '</p>' +
                            '<input type="hidden" name="editId[]" value="' + item.id + '"></td>' +
                            '<td><input type="number" name="editNilaiKategori[]" min="0" max="100" class="form-control" value="' + item.nilai + '"></td>' +
                            '</tr>';
                        $('#myTableBody').append(row);
                    });
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