<!DOCTYPE html>
<html lang="en">

<head>
    <title>SiMagang</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Portal - Bootstrap 5 Admin Dashboard Template For Developers">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">
    <link rel="shortcut icon" href="logo.ico">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- FontAwesome JS-->
    <script defer src="<?= base_url('assets/template/portal-theme-bs5-v2.1/assets/plugins/fontawesome/js/all.min.js') ?>"></script>

    <link rel="stylesheet" href="<?= base_url('assets/template/dataTables/datatables.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/template/sweetalert2/sweetalert2.min.css') ?>">

    <!-- App CSS -->
    <link id="theme-style" rel="stylesheet" href="<?= base_url('assets/template/portal-theme-bs5-v2.1/assets/css/portal.css') ?>">

    <link id="theme-style" rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">

</head>

<body class="app">
    <header class="app-header fixed-top">

        <!-- Navbar -->
        <?= $this->include('layouts/navbar') ?>
        <!-- END Navbar -->

        <!-- Sidebar -->
        <?= $this->include('layouts/sidebar') ?>
        <!-- END Sidebar -->

    </header><!--//app-header-->

    <div class="app-wrapper">

        <div class="app-content pt-3 p-md-3 p-lg-4">
            <div class="container-xl">

                <!-- Content -->
                <?= $this->renderSection('content') ?>
                <!-- End Content -->

            </div><!--//container-fluid-->
        </div><!--//app-content-->

        <!-- Footer -->
        <?= $this->include('layouts/footer') ?>
        <!-- END Footer -->

    </div><!--//app-wrapper-->

    <!-- Javascript -->
    <script src="<?= base_url('assets/template/jQuery/jquery-3.6.3.js') ?>"></script>

    <script src="<?= base_url('assets/template/portal-theme-bs5-v2.1/assets/plugins/popper.min.js') ?>"></script>
    <script src="<?= base_url('assets/template/portal-theme-bs5-v2.1/assets/plugins/bootstrap/js/bootstrap.min.js') ?>"></script>

    <!-- Charts JS -->
    <script src="<?= base_url('assets/template/portal-theme-bs5-v2.1/assets/plugins/chart.js/chart.min.js') ?>"></script>
    <script src="<?= base_url('assets/template/portal-theme-bs5-v2.1/assets/js/index-charts.js') ?>"></script>

    <!-- Page Specific JS -->
    <script src="<?= base_url('assets/template/portal-theme-bs5-v2.1/assets/js/app.js') ?>"></script>

    <script src="<?= base_url('assets/template/dataTables/datatables.min.js') ?>"></script>
    <script src="<?= base_url('assets/template/sweetalert2/sweetalert2.min.js') ?>"></script>

    <?= $this->renderSection('js') ?>

</body>

</html>