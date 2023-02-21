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
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Periode Magang</label>
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
            </div>
        </div>
    </div>
</div>

<h1 class="app-page-title">Data Penilaian</h1>

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
                                <th>Total Rata-Rata Penilaian</th>
                                <th data-orderable="false" style="width: 17%;">Aksi</th>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($list as $row) : ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?= date_format(new DateTime($row['tanggal_mulai']), 'd/m/Y'); ?> - <?= date_format(new DateTime($row['tanggal_selesai']), 'd/m/Y'); ?></td>
                                        <td><?= number_format(($row['total_sum'] / $count), 2, ',', '') ?></td>
                                        <td>
                                            <button type="button" class="btn btn-info text-white" id="detailBtn" data-id="<?= $row['magang_id'] ?>">
                                                Detail
                                            </button>
                                            <a href="<?= base_url('siswa/generate-nilai/' . $row['magang_id'])  ?>" class="btn btn-warning text-white">Cetak</a>
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
    $(document).ready(function() {
        /* Get data table */
        var table = $('#Tables').DataTable({
            oLanguage: {
                sUrl: "<?= base_url('assets/template/dataTables/indonesian.json') ?>"
            }
        })

        $('body').on('click', '#detailBtn', function() {
            var this_id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "<?= base_url('siswa/penilaian/detail') ?>",
                data: {
                    id: this_id,
                },
                success: function(response) {
                    $('#detailModal').modal('show');
                    var mulai = new Date(response.periodeMulai);
                    var mulaiDate = ('0' + mulai.getDate()).slice(-2) + '/' + ('0' + (mulai.getMonth() + 1)).slice(-2) + '/' + mulai.getFullYear();
                    var selesai = new Date(response.periodeSelesai);
                    var selesaiDate = ('0' + selesai.getDate()).slice(-2) + '/' + ('0' + (selesai.getMonth() + 1)).slice(-2) + '/' + selesai.getFullYear();
                    $('#editSiswa').val(mulaiDate + ' - ' + selesaiDate);
                    $('#myTableBody').empty();
                    $.each(response.penilaian, function(i, item) {
                        var row = '<tr>' +
                            '<td><label class="form-label">' + item.nama_kategori + '</label><br>' +
                            '<p style="font-size: 13px;">' + item.keterangan + '</p>' +
                            '<td><input type="number" min="0" max="100" class="form-control" value="' + item.nilai + '" readonly></td>' +
                            '</tr>';
                        $('#myTableBody').append(row);
                    });
                }
            });
        });
    });
</script>
<?php $this->endSection() ?>