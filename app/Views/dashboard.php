<?php $this->extend('layouts/portal') ?>

<?php $this->section('content') ?>
<h1 class="app-page-title">Overview</h1>

<div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">
    <div class="inner">
        <div class="app-card-body p-3 p-lg-4">
            <h3 class="mb-3">Selamat datang, <?= session()->get('username') ?>!</h3>
            <div class="row gx-5 gy-3">
                <div><b><u>SIMAGANG</u></b> merupakan salah satu sistem informasi dari <b>DISPENDIK Kota Kediri</b> yang menaungi pengelolaan magang di lingkungan dinas pendidikan.</div>
            </div><!--//row-->
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div><!--//app-card-body-->
    </div><!--//inner-->
</div><!--//app-card-->

<div class="row g-4 mb-4">
    <div class="col-6 col-lg-3">
        <div class="app-card app-card-stat shadow-sm h-100">
            <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-4">Jumlah Siswa</h4>
                <div class="stats-figure"><?= $t1 ?></div>
                <div class="stats-meta">
                    Siswa</div>
            </div><!--//app-card-body-->
        </div><!--//app-card-->
    </div><!--//col-->

    <div class="col-6 col-lg-3">
        <div class="app-card app-card-stat shadow-sm h-100">
            <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-4">Jumlah Pembimbing</h4>
                <div class="stats-figure"><?= $t2 ?></div>
                <div class="stats-meta">
                    Pembimbing</div>
            </div><!--//app-card-body-->
        </div><!--//app-card-->
    </div><!--//col-->

    <div class="col-6 col-lg-3">
        <div class="app-card app-card-stat shadow-sm h-100">
            <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-1">Total Pengajuan Magang</h4>
                <div class="stats-figure"><?= $t3 ?></div>
                <div class="stats-meta">
                    Pengajuan</div>
            </div><!--//app-card-body-->
        </div><!--//app-card-->
    </div><!--//col-->

    <div class="col-6 col-lg-3">
        <div class="app-card app-card-stat shadow-sm h-100">
            <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-4">Total Siswa Magang</h4>
                <div class="stats-figure"><?= $t4 ?></div>
                <div class="stats-meta">
                    Siswa Magang</div>
            </div><!--//app-card-body-->
        </div><!--//app-card-->
    </div><!--//col-->
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-lg-12">
        <div class="app-card app-card-chart h-100 shadow-sm">
            <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <h4 class="app-card-title">Grafik Total Siswa Magang Pertahun</h4>
                    </div>
                </div>
            </div><!--//app-card-header-->
            <div class="app-card-body p-3 p-lg-4">
                <div class="mb-3 d-flex">
                    <input type="text" class="form-control form-control-sm ms-auto d-inline-flex w-auto" id="yearPicker" placeholder="Pilih Tahun">
                </div>
                <div class="chart-container">
                    <canvas id="barChart"></canvas>
                </div>
            </div><!--//app-card-body-->
        </div><!--//app-card-->
    </div>
</div>

<?php $this->endSection() ?>

<?php $this->section('js') ?>
<link rel="stylesheet" href="<?= base_url('assets/template/bs-datepicker/bootstrap-datepicker.min.css') ?>">
<script src="<?= base_url('assets/template/bs-datepicker/bootstrap-datepicker.min.js') ?>"></script>

<script src="<?= base_url('assets/template/chartjs/chart.min.js') ?>"></script>
<script src="<?= base_url('assets/template/chartjs/chartjs-plugin-datalabels@2.0.0-rc') ?>"></script>
<script>
    function initializeChart(data) {
        var ctx = document.getElementById('barChart');
        Chart.register(ChartDataLabels);
        Chart.defaults.set('plugins.datalabels', {
            color: '#FE777B'
        });
        var myChart = new Chart(ctx, {
            type: 'bar',
            plugins: [ChartDataLabels],
            data: {
                labels: data.labels,
                datasets: [{
                    data: data.values,
                    label: 'Total Siswa Magang Perbulan Pada Tahun ' + data.tahun,
                    backgroundColor: '#75c181',
                    borderColor: '#75c181',
                    borderWidth: 1,
                    maxBarThickness: 25,
                    datalabels: {
                        color: '#FFCE56'
                    }

                }],
            },
            options: {
                responsive: true,
                aspectRatio: 3.5,
                plugins: {
                    datalabels: {
                        labels: {
                            value: {
                                color: 'white'
                            }
                        }
                    }
                },
            }
        });

        // Return the chart instance
        return myChart;
    }

    $(document).ready(function() {
        var myChart;

        $('#yearPicker').datepicker({
            format: 'yyyy',
            startView: 'years',
            minViewMode: 'years',
            autoclose: true
        }).on('changeDate', function(e) {
            var selectedYear = e.date.getFullYear();
            $.ajax({
                url: 'chart-magang-year',
                type: 'GET',
                data: {
                    year: selectedYear
                },
                success: function(data) {
                    myChart.data.datasets[0].data = data.values;
                    myChart.data.datasets[0].label = 'Total Siswa Magang Tahun ' + data.tahun;
                    myChart.update();
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });

        $.ajax({
            url: '<?= base_url('chart-magang') ?>',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                myChart = initializeChart(data);
                console.log(data);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });
</script>
<?php $this->endSection() ?>