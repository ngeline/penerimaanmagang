<?php $this->extend('layouts/portal') ?>

<?php $this->section('content') ?>
<h1 class="app-page-title">Kelola Pengguna</h1>

<div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-3 p-lg-4">
            <!-- <h3 class="mb-3">Welcome, developer!</h3> -->
            <div class="row gx-5 gy-3">
                <div class="col-12 col-lg-12">
                    <div class="table-responsive ">
                        <table class="table table-striped w-100" id="Tables">
                            <thead class="table-light">
                                <th style="width: 2%;">No</th>
                                <th>Nama Pengguna</th>
                                <th>Wewenang</th>
                                <th data-orderable="false" style="width: 17%;">Aksi</th>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($users as $user) : ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?= $user['username'] ?></td>
                                        <td><?= $user['role'] ?></td>
                                        <td>
                                            <button type="button" class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target="#Edit<?php echo $no ?>">
                                                Edit
                                            </button>
                                            <button id="confirm-button-<?= $user['id'] ?>" class="btn btn-danger text-white" data-id="<?= base_url('admin/users/delete/' . $user['id']) ?>">Hapus</button>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="Edit<?php echo $no ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header bg-warning">
                                                    <h5 class="modal-title text-white" id="staticBackdropLabel">Form Edit Data</h5>
                                                </div>
                                                <form action="<?= base_url('admin/users/update') ?>" method="POST">
                                                    <?= csrf_field() ?>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                                        <div class="mb-3">
                                                            <label class="form-label">Kata Sandi</label>
                                                            <input id="password-<?= $user['id'] ?>" name="password" type="password" class="form-control" value="<?php echo set_value('password'); ?>" required="required">
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