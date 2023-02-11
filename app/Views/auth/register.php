<!DOCTYPE html>
<html lang="en">

<head>
    <title>Portal - Bootstrap 5 Admin Dashboard Template For Developers</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Portal - Bootstrap 5 Admin Dashboard Template For Developers">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="favicon.ico">

    <!-- FontAwesome JS-->
    <script defer src="<?= base_url('vendor/portal-theme-bs5-v2.1/assets/plugins/fontawesome/js/all.min.js') ?>"></script>

    <!-- App CSS -->
    <link id="theme-style" rel="stylesheet" href="<?= base_url('vendor/portal-theme-bs5-v2.1/assets/css/portal.css') ?>">

    <link rel="stylesheet" href="<?= base_url('vendor/sweetalert2/sweetalert2.min.css') ?>">

</head>

<body class="app app-signup p-0">
    <div class="row g-0 app-auth-wrapper">
        <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
            <div class="d-flex flex-column align-content-end">
                <div class="app-auth-body mx-auto">
                    <div class="app-auth-branding mb-4"><a class="app-logo" href="index.html"><img class="logo-icon me-2" src="assets/images/app-logo.svg" alt="logo"></a></div>
                    <h2 class="auth-heading text-center mb-4">Sign up to Portal</h2>

                    <div class="auth-form-container text-start mx-auto">
                        <form class="auth-form auth-signup-form" action="<?= base_url('register') ?>" method="POST">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label class="sr-only">Username</label>
                                <input id="username" name="username" type="text" placeholder="Username" class="form-control" value="<?php echo set_value('username'); ?>" required="required">
                                <!-- Tambahkan pesan validasi -->
                                <?php if (isset($validation)) : ?>
                                    <small style="color: red;">
                                        <?= $validation->getError('username'); ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label class="sr-only">Password</label>
                                <input id="password" name="password" type="password" placeholder="Password" class="form-control" value="<?php echo set_value('password'); ?>" required="required">
                                <!-- Tambahkan pesan validasi -->
                                <?php if (isset($validation)) : ?>
                                    <small style="color: red;">
                                        <?= $validation->getError('password'); ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-8 mt-1">
                                        <label class="sr-only">Telepon</label>
                                        <input id="telepon" name="telepon" type="text" placeholder="Telepon" class="form-control" value="<?php echo set_value('telepon'); ?>" required="required">
                                        <!-- Tambahkan pesan validasi -->
                                        <?php if (isset($validation)) : ?>
                                            <small style="color: red;">
                                                <?= $validation->getError('telepon'); ?>
                                            </small>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-4 mt-1">
                                        <button class="btn btn-info text-white w-100" id="koderhs">Kirim Kode</button>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="sr-only">Kode Verifikasi</label>
                                <input id="kode" name="kode" type="text" class="form-control" placeholder="Kode" value="<?php echo set_value('kode'); ?>" required="required">
                                <!-- Tambahkan pesan validasi -->
                                <?php if (isset($validation)) : ?>
                                    <small style="color: red;">
                                        <?= $validation->getError('kode'); ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                            <input type="hidden" name="validKode" id="validKode">
                            <div class="text-center">
                                <button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">Sign Up</button>
                            </div>
                        </form><!--//auth-form-->

                        <div class="auth-option text-center pt-5">Already have an account? <a class="text-link" href="<?= base_url('login') ?>">Log in</a></div>
                    </div><!--//auth-form-container-->



                </div><!--//auth-body-->

                <footer class="app-auth-footer">
                    <div class="container text-center py-3">
                        <!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
                        <small class="copyright">Designed with <span class="sr-only">love</span><i class="fas fa-heart" style="color: #fb866a;"></i> by <a class="app-link" href="http://themes.3rdwavemedia.com" target="_blank">Xiaoying Riley</a> for developers</small>

                    </div>
                </footer><!--//app-auth-footer-->
            </div><!--//flex-column-->
        </div><!--//auth-main-col-->
        <div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
            <div class="auth-background-holder">
            </div>
            <div class="auth-background-mask"></div>
            <div class="auth-background-overlay p-3 p-lg-5">
                <div class="d-flex flex-column align-content-end h-100">
                    <div class="h-100"></div>
                    <div class="overlay-content p-3 p-lg-4 rounded">
                        <h5 class="mb-3 overlay-title">Explore Portal Admin Template</h5>
                        <div>Portal is a free Bootstrap 5 admin dashboard template. You can download and view the template license <a href="https://themes.3rdwavemedia.com/bootstrap-templates/admin-dashboard/portal-free-bootstrap-admin-dashboard-template-for-developers/">here</a>.</div>
                    </div>
                </div>
            </div><!--//auth-background-overlay-->
        </div><!--//auth-background-col-->

    </div><!--//row-->

    <script src="<?= base_url('vendor/jQuery/jquery-3.6.3.js') ?>"></script>
    <script src="<?= base_url('vendor/sweetalert2/sweetalert2.min.js') ?>"></script>

    <script>
        $(document).ready(function() {
            /* Ajax Token */
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            // timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        $("#koderhs").click(function(e) {
            e.preventDefault();
            let no_telp = $("#telepon").val();
            if (no_telp == '' || no_telp == null) {
                Toast.fire({
                    icon: 'warning',
                    title: 'Isi Telepon terlebih dahulu.'
                });
            } else {
                $.ajax({
                    type: "GET",
                    url: "<?= base_url('koderhs') ?>",
                    data: {
                        no_telp: no_telp,
                    },
                    success: function(response) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Berhasil Mengirimkan Kode.'
                        });
                        $("#validKode").val(response.message);
                    }
                });
            }
        });
    </script>

</body>

</html>