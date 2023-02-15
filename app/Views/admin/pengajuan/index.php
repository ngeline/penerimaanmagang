<?php $this->extend('layouts/portal') ?>

<?php $this->section('content') ?>
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
                        <input type="text" class="form-control" id="detailNama" readonly>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Institusi Pemohon</label>
                        <input type="text" class="form-control" id="detailIntitusi" readonly>
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
                        <a id="fileProposal" class="btn btn-primary w-100 text-white" download>Unduh</a>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">File Surat Rekomendasi</label>
                        <a id="fileSurat" class="btn btn-primary w-100 text-white" download>Unduh</a>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Status Pengajuan</label>
                        <input type="text" class="form-control" id="detailStatus" readonly>
                    </div>
                    <div class="mb-3 col-md-6" id="hideShowBalasan">
                        <label class="form-label">File Surat Balasan</label>
                        <a id="fileBalasan" class="btn btn-primary w-100 text-white" download>Unduh</a>
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

<h1 class="app-page-title">Kelola Pengajuan Magang</h1>

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
                                <th>Nama Pemohon</th>
                                <th>Institusi Pemohon</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Status Pengajuan</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($pengajuan as $row) : ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?= $row['nama'] ?></td>
                                        <td><?= (($row['jenjang'] == 'SLTA') ? $row['asal_sekolah'] : $row['perguruan']) ?></td>
                                        <td><?= date_format(new DateTime($row['created_at']), 'd/m/Y H:i:s'); ?></td>
                                        <td><?= $row['status_pengajuan'] ?></td>
                                        <td>
                                            <button type="button" class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target="#Validasi<?php echo $no ?>">
                                                Validasi
                                            </button>
                                            <button type="button" class="btn btn-info text-white" id="detail" data-id="<?= $row['id_pengajuan'] ?>">
                                                Detail
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal Validasi -->
                                    <div class="modal fade" id="Validasi<?php echo $no ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header bg-warning">
                                                    <h5 class="modal-title text-white" id="staticBackdropLabel">Form Validasi Data</h5>
                                                </div>
                                                <form action="<?= base_url('admin/pengajuan/validasi') ?>" method="POST" enctype="multipart/form-data" id="formValidasi">
                                                    <?= csrf_field() ?>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" value="<?= $row['id_pengajuan'] ?>">
                                                        <div class="row">
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Nama Pemohon</label>
                                                                <input type="text" class="form-control" value="<?= $row['nama'] ?>" readonly>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Institusi Pemohon</label>
                                                                <input type="text" class="form-control" value="<?= ($row['jenjang'] == 'SLTA') ? $row['asal_sekolah'] : $row['perguruan'] ?>" readonly>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">File Surat Balasan</label>
                                                                <input id="suratBalasan" name="suratBalasan" type="file" class="form-control">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Status Pengajuan</label>
                                                                <select name="validasiStatus" id="validasiStatus" class="form-select">
                                                                    <option value="">--Pilih Status--</option>
                                                                    <option value="diproses" <?= ($row['status_pengajuan'] == 'diproses') ? 'selected' : '' ?>>Diproses</option>
                                                                    <option value="diterima" <?= ($row['status_pengajuan'] == 'diterima') ? 'selected' : '' ?>>Diterima</option>
                                                                    <option value="ditolak" <?= ($row['status_pengajuan'] == 'ditolak') ? 'selected' : '' ?>>Ditolak</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3 col-md-12">
                                                                <label class="form-label">Catatan</label>
                                                                <textarea name="validasiCatatan" id="validasiCatatan" rows="10" class="form-control"><?= $row['catatan'] ?></textarea>
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
                url: "<?= base_url('admin/pengajuan/detail') ?>",
                data: {
                    id: this_id,
                },
                success: function(response) {
                    $('#detailModal').modal('show');
                    $('#detailNama').val(response.data[0].nama);
                    if (response.data[0].jenjang == 'SLTA') {
                        $('#detailIntitusi').val(response.data[0].asal_sekolah);
                    } else {
                        $('#detailIntitusi').val(response.data[0].perguruan);
                    }
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