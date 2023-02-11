<?php $this->extend('layouts/portal') ?>

<?php $this->section('content') ?>
<div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">
    <div class="inner">
        <div class="app-card-body p-3 p-lg-4">
            <h3 class="mb-3">Oops, your internship application has not been approved!</h3>
            <div class="row gx-5 gy-3">
                <div class="col-12 col-lg-9">
                    <div>
                        Once the apprenticeship application is approved, this feature will be usable immediately.
                    </div>
                </div><!--//col-->
                <div class="col-12 col-lg-3">
                    <a class="btn app-btn-primary" href="<?= base_url('siswa/pengajuan') ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z" />
                        </svg>Check Now
                    </a>
                </div><!--//col-->
            </div><!--//row-->
        </div><!--//app-card-body-->

    </div><!--//inner-->
</div><!--//app-card-->

<?php $this->endSection() ?>

<?php $this->section('js') ?>
<script>
    $(document).ready(function() {});
</script>
<?php $this->endSection() ?>