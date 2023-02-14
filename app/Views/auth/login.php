<!DOCTYPE html>
<html lang="en">

<head>
    <title>Penerimaan Magang</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Portal - Bootstrap 5 Admin Dashboard Template For Developers">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">
    <link rel="shortcut icon" href="<?= base_url('logo.ico')?>">

    <!-- FontAwesome JS-->
    <script defer src="<?= base_url('assets/template/portal-theme-bs5-v2.1/assets/plugins/fontawesome/js/all.min.js') ?>"></script>

    <!-- App CSS -->
    <link id="theme-style" rel="stylesheet" href="<?= base_url('assets/template/portal-theme-bs5-v2.1/assets/css/portal.css') ?>">

</head>

<body class="app app-login p-0">
    <div class="row g-0 app-auth-wrapper">
        <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
            <div class="d-flex flex-column align-content-end">
                <div class="app-auth-body mx-auto">
                    <div class="app-auth-branding mb-4"><a class="app-logo" href="index.html"><img class="logo-icon me-2" src="<?=base_url('assets/img/logo.png')?>" alt="logo"></a></div>
                    <h2 class="auth-heading text-center mb-5">Log in to siMagang</h2>
                    <!-- Display success message -->
                    <?php if (session('success')) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong> <?= session('success') ?></strong>
                            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
                        </div>
                    <?php endif; ?>
                    <?php if (session('error')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong> <?= session('error') ?></strong>
                            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
                        </div>
                    <?php endif; ?>
                    <div class="auth-form-container text-start">
                        <form class="auth-form auth-signup-form" action="<?= base_url('login') ?>" method="POST">
                            <?= csrf_field() ?>
                            <div class="email mb-3">
                                <label class="sr-only" for="signin-email">Username</label>
                                <input id="username" name="username" type="text" class="form-control signin-email" placeholder="Username" required="required">
                            </div><!--//form-group-->
                            <div class="password mb-3">
                                <label class="sr-only" for="signin-password">Password</label>
                                <input id="password" name="password" type="password" class="form-control signin-password" placeholder="Password" required="required">
                            </div><!--//form-group-->
                            <div class="text-center">
                                <button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">Log In</button>
                            </div>
                        </form>

                        <div class="auth-option text-center pt-5">Belum punya akun? Daftar <a class="text-link" href="<?= base_url('register') ?>">di sini</a>.</div>
                    </div><!--//auth-form-container-->

                </div><!--//auth-body-->

                <footer class="app-auth-footer">
                    <div class="container text-center py-3">
                        <!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
                        <!-- <small class="copyright">Designed with <span class="sr-only">love</span><i class="fas fa-heart" style="color: #fb866a;"></i> by <a class="app-link" href="http://themes.3rdwavemedia.com" target="_blank">Xiaoying Riley</a> for developers</small> -->

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
                        <h5 class="mb-3 overlay-title">DINAS PENDIDIKAN KOTA KEDIRI</h5>
                        <div>Website Penerimaan Magang Dinas Pendidikan Kota Kediri</div>
                    </div>
                </div>
            </div><!--//auth-background-overlay-->
        </div><!--//auth-background-col-->

    </div><!--//row-->


</body>

</html>