<?php $this->extend('layouts/portal') ?>

<?php $this->section('content') ?>
<!-- Modal Create -->
<div class="modal fade" id="tambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="staticBackdropLabel">Form Tambah Data</h5>
            </div>
            <form action="<?= base_url('siswa/pengajuan/store') ?>" method="POST" enctype="multipart/form-data" files="true" id="form">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="id" value="<?= $siswa['id'] ?>">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Nama Pemohon</label>
                            <input id="nama" name="nama" type="text" class="form-control" value="<?= $siswa['nama'] ?>" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Institusi Pemohon</label>
                            <input id="sekol" name="sekol" type="text" class="form-control" value="<?= (($siswa['jenjang'] == 'SLTA') ? $siswa['asal_sekolah'] : $siswa['perguruan']) ?>" readonly>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Tanggal Mulai Magang</label>
                            <input id="mulai" name="mulai" type="date" class="form-control">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Tanggal Selesai Magang</label>
                            <input id="selesai" name="selesai" type="date" class="form-control">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">File Proposal</label>
                            <input id="proposal" name="proposal" type="file" class="form-control">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">File Surat Rekomendasi</label>
                            <input id="surat" name="surat" type="file" class="form-control">
                        </div>
                        <div class="mb-3 col-md-12">
                            <table class="table table-bordered p-2" id="AnggotaTables">
                                <thead>
                                    <tr>
                                        <th style="width: 2%">No</th>
                                        <th>Nama Anggota</th>
                                        <th>Jenis Kelamin</th>
                                        <th style="width: 5%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td><input type="text" class="form-control" id="nama_anggota" name="nama_anggota[]"></td>
                                        <td>
                                            <select name="jk[]" id="jk" class="form-select">
                                                <option value="">--Pilih Status--</option>
                                                <option value="l">Laki-laki</option>
                                                <option value="p">Perempuan</option>
                                            </select>
                                        </td>
                                        <td><button type="button" name="addRows" id="addRows" class="btn btn-sm btn-primary"><i class="fas fa-plus text-white"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
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

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="staticBackdropLabel">Form Detail Data</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Nama Pemohon</label>
                        <input type="text" class="form-control" value="<?= $siswa['nama'] ?>" readonly>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Institusi Pemohon</label>
                        <input type="text" class="form-control" value="<?= (($siswa['jenjang'] == 'SLTA') ? $siswa['asal_sekolah'] : $siswa['perguruan']) ?>" readonly>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Tanggal Mulai Magang</label>
                        <input type="text" class="form-control" id="detailMulai" readonly>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Tanggal Selesai Magang</label>
                        <input type="text" class="form-control" id="detailSelesai" readonly>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">File Proposal</label>
                        <a id="fileProposal" class="btn btn-warning w-100 text-white" download>Unduh</a>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">File Surat Rekomendasi</label>
                        <a id="fileSurat" class="btn btn-warning w-100 text-white" download>Unduh</a>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Status Pengajuan</label>
                        <input type="text" class="form-control" id="detailStatus" readonly>
                    </div>
                    <div class="mb-3 col-md-6" id="hideShowBalasan">
                        <label class="form-label">File Surat Balasan</label>
                        <a id="fileBalasan" class="btn btn-warning w-100 text-white" download>Unduh</a>
                    </div>
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Catatan</label>
                        <textarea rows="4" class="form-control" id="detailCatatan" readonly></textarea>
                    </div>
                    <div class="mb-3 col-md-12" id="hideShowAnggota">
                        <label class="form-label">Anggota</label>
                        <textarea rows="4" class="form-control" id="detailAnggota" readonly></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<h1 class="app-page-title">Pengajuan Magang</h1>

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
                                <th>Tanggal Pengajuan</th>
                                <th>Status Pengajuan</th>
                                <th>Catatan</th>
                                <th data-orderable="false">Aksi</th>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($pengajuan as $row) : ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?= date_format(new DateTime($row['created_at']), 'd/m/Y H:i:s'); ?></td>
                                        <td><?= $row['status_pengajuan'] ?></td>
                                        <td><?= ($row['status_pengajuan'] == 'diproses') ? 'tidak ada catatan' : $row['catatan'] ?></td>
                                        <td>
                                            <button type="button" class="btn btn-info text-white" id="detail" data-id="<?= $row['id'] ?>">
                                                Detail
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

        $('body').on('click', '#detail', function() {
            var this_id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "<?= base_url('siswa/pengajuan/detail') ?>",
                data: {
                    id: this_id,
                },
                success: function(response) {
                    $('#detailModal').modal('show');
                    $('#detailMulai').val(response.data[0].tanggal_mulai);
                    $('#detailSelesai').val(response.data[0].tanggal_selesai);
                    $('#fileProposal').attr('href', '<?= base_url('assets/file/pengajuan') ?>' + '/' + response.data[0].file_proposal);
                    $('#fileSurat').attr('href', '<?= base_url('assets/file/pengajuan') ?>' + '/' + response.data[0].file_surat_pengajuan);
                    $('#detailStatus').val(response.data[0].status_pengajuan);
                    if (response.data[0].catatan !== null) {
                        $('#detailCatatan').val(response.data[0].catatan);
                    } else {
                        $('#detailCatatan').val('tidak ada');
                    }
                    if (response.jmlAnggota >= 1) {
                        $("#hideShowAnggota").show();
                        $('#detailAnggota').val(response.anggota.join(', '));
                    } else {
                        $("#hideShowAnggota").hide();
                        $('#detailAnggota').val('');
                    }
                    if (response.data[0].file_surat_balasan !== null) {
                        $("#hideShowBalasan").show();
                        $('#fileBalasan').attr('href', '<?= base_url('assets/file/pengajuan') ?>' + '/' + response.data[0].file_surat_balasan);
                    } else {
                        $("#hideShowBalasan").hide();
                        $('#fileBalasan').attr('href', '');
                    }
                }
            });
        });

        $(function() {
            $("#hideShowBalasan").hide();
            $("#hideShowAnggota").hide();
        });

        /* Dynamic field */
        $(function() {
            function numberRows($t) {
                var c = 0;
                $t.find("tbody tr").each(function(ind, el) {
                    $(el).find("td:eq(0)").html(++c + ".");
                });
            }
            $("#addRows").click(function(e) {
                e.preventDefault();
                var $row = $("<tr>");
                $row.append($("<td>"));
                $row.append($("<td>").html(
                    "<input type='text' name='nama_anggota[]' class='form-control' />"
                ));
                $row.append($("<td>").html(
                    "<select name='jk[]' id='jk' class='form-select'><option value=''>--Pilih Status--</option><option value='l'>Laki-laki</option><option value='p'>Perempuan</option></select>"
                ));
                $row.append($("<td>").html(
                    "<button class='btn btn-sm btn-danger' id='rmRows'><i class='fas fa-minus'></button>"
                ));
                $row.appendTo($("#AnggotaTables tbody"));
                numberRows($("#AnggotaTables"));
            });
            $("#AnggotaTables").on("click", "#rmRows", function(e) {
                e.preventDefault();
                var $row = $(this).parent().parent();
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
                        $row.remove();
                        numberRows($("#AnggotaTables"));
                    }
                });
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