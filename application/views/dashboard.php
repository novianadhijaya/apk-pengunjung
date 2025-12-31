<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            <small>Overview & Analytics</small>
        </h1>
    </section>

    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="ion ion-ios-people-outline"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Pengunjung Perpustakaan</span>
                        <span class="info-box-number"><?php echo number_format($total_visits); ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="ion ion-ios-personadd-outline"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Pengunjung Hari Ini</span>
                        <span class="info-box-number"><?php echo number_format($today_visits); ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Anggota</span>
                        <span class="info-box-number"><?php echo number_format($total_anggota); ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="ion ion-arrow-graph-up-right"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Prediksi Bulan Depan</span>
                        <?php if (is_array($prediction_next_month) && $prediction_next_month['count'] > 0): ?>
                            <span
                                class="info-box-number"><?php echo number_format($prediction_next_month['count']); ?></span>
                            <small><?php echo $prediction_next_month['label']; ?></small>
                        <?php else: ?>
                            <span class="info-box-number">-</span>
                            <small>Belum ada model</small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tren Kunjungan (12 Bulan Terakhir)</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="visitorChart" style="height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tipe Pengunjung</h3>
                    </div>
                    <div class="box-body">
                        <canvas id="pieChart" style="height:250px"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Pengunjung Terbaru</h3>
                    </div>
                    <div class="box-body">
                        <ul class="products-list product-list-in-box">
                            <?php foreach ($recent_visits as $visit): ?>
                                <li class="item">
                                    <div class="product-img">
                                        <div
                                            style="width: 50px; height: 50px; background: #eee; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #666; font-weight: bold;">
                                            <?php echo substr($visit->visitor_name, 0, 1); ?>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <a href="javascript:void(0)"
                                            class="product-title"><?php echo $visit->visitor_name; ?>
                                            <span
                                                class="label label-<?php echo ($visit->membership_type == 'Member') ? 'success' : 'warning'; ?> pull-right"><?php echo $visit->membership_type; ?></span>
                                        </a>
                                        <span class="product-description">
                                            <?php echo $visit->visit_date . ' ' . $visit->visit_time; ?> |
                                            <?php echo $visit->room_name; ?>
                                        </span>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="box-footer text-center">
                        <a href="<?php echo site_url('master_pengunjung'); ?>" class="uppercase">Lihat Semua
                            Kunjungan</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- ChartJS -->
<script src="<?php echo base_url(); ?>assets/js/chart.js"></script>
<script>
    var ctx = document.getElementById('visitorChart').getContext('2d');
    var visitorChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [<?php foreach ($monthly_stats as $stat)
                echo '"' . $stat->label . '",'; ?>],
            datasets: [{
                label: 'Jumlah Pengunjung',
                data: [<?php foreach ($monthly_stats as $stat)
                    echo $stat->count . ','; ?>],
                backgroundColor: 'rgba(60, 141, 188, 0.2)',
                borderColor: '#3c8dbc',
                borderWidth: 2,
                pointRadius: 4,
                pointBackgroundColor: '#3c8dbc'
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    // Pie Chart
    var pieCtx = document.getElementById('pieChart').getContext('2d');
    var pieChart = new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: [<?php foreach ($visitor_types as $type)
                echo '"' . $type->membership_type . '",'; ?>],
            datasets: [{
                data: [<?php foreach ($visitor_types as $type)
                    echo $type->count . ','; ?>],
                backgroundColor: ['#00a65a', '#f39c12'], // Success (Member), Warning (Non-Anggota)
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                position: 'bottom'
            }
        }
    });
</script>