<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Perhitungan Prediksi dan Pengujian
            <small>Regresi linier + visualisasi</small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <?php if (!$fit): ?>
                    <div class="alert alert-warning">
                        Data preprocessing belum ada atau kurang dari 2 bulan. Jalankan preprocessing dulu.
                    </div>
                <?php else: ?>
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Grafik dan Visualisasi</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="chart">
                                        <canvas id="chartActual" style="height: 260px;"></canvas>
                                    </div>
                                    <p class="text-center text-muted small">Grafik jumlah pengunjung aktual</p>
                                </div>
                                <div class="col-md-6">
                                    <div class="chart">
                                        <canvas id="chartPred" style="height: 260px;"></canvas>
                                    </div>
                                    <p class="text-center text-muted small">Grafik hasil prediksi</p>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-md-12">
                                    <div class="chart">
                                        <canvas id="chartCompare" style="height: 280px;"></canvas>
                                    </div>
                                    <p class="text-center text-muted small">Grafik perbandingan aktual vs prediksi</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Data X dan Y</h3>
                        </div>
                        <div class="box-body table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Periode (X)</th>
                                        <th>Label Bulan</th>
                                        <th>Y (Aktual)</th>
                                        <th>Yhat (Prediksi)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rows as $i => $r): ?>
                                        <tr>
                                            <td><?php echo $r['x_period']; ?></td>
                                            <td><?php echo sprintf('%04d-%02d', $r['year'], $r['month']); ?></td>
                                            <td><?php echo (int) $r['y_total']; ?></td>
                                            <td><?php echo round($fit['yhat'][$i], 2); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Perhitungan Prediksi</h3>
                        </div>
                        <div class="box-body">
                            <p><b>ΣX</b> = <?php echo $fit['sum_x']; ?></p>
                            <p><b>ΣY</b> = <?php echo $fit['sum_y']; ?></p>
                            <p><b>ΣX²</b> = <?php echo $fit['sum_x2']; ?></p>
                            <p><b>ΣXY</b> = <?php echo $fit['sum_xy']; ?></p>
                            <hr>
                            <p><b>a</b> = <?php echo round($fit['a'], 6); ?></p>
                            <p><b>b</b> = <?php echo round($fit['b'], 6); ?></p>
                            <p><b>Rumus Regresi:</b> Yhat = a + bX</p>
                        </div>
                    </div>

                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Perhitungan Pengujian</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>R²</th>
                                            <td><?php echo round($eval['R2'], 6); ?></td>
                                        </tr>
                                        <tr>
                                            <th>MAE</th>
                                            <td><?php echo round($eval['MAE'], 6); ?></td>
                                        </tr>
                                        <tr>
                                            <th>MSE</th>
                                            <td><?php echo round($eval['MSE'], 6); ?></td>
                                        </tr>
                                        <tr>
                                            <th>RMSE</th>
                                            <td><?php echo round($eval['RMSE'], 6); ?></td>
                                        </tr>
                                        <tr>
                                            <th>MAPE</th>
                                            <td><?php echo round($eval['MAPE'], 2); ?>% (<?php echo $eval['cat_mape']; ?>)
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>SD(Y) Populasi</th>
                                            <td><?php echo round($eval['sd_pop'], 6); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Kategori SD</th>
                                            <td><?php echo $eval['cat_sd']; ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>SST</th>
                                            <td><?php echo round($eval['SST'], 6); ?></td>
                                        </tr>
                                        <tr>
                                            <th>SSR</th>
                                            <td><?php echo round($eval['SSR'], 6); ?></td>
                                        </tr>
                                        <tr>
                                            <th>SSE</th>
                                            <td><?php echo round($eval['SSE'], 6); ?></td>
                                        </tr>
                                    </table>
                                    <div class="text-muted small">R² = 1 - (SSE / SST)</div>
                                </div>
                            </div>
                        </div>
                    </div>


                <?php endif; ?>
            </div>
        </div>
    </section>
</div>

<?php if ($fit): ?>
    <script src="<?php echo base_url('assets/js/chart.js'); ?>"></script>
    <script>
        var labels = <?php echo $labels; ?>;
        var yActual = <?php echo $y_actual; ?>;
        var yPred = <?php echo $y_pred; ?>;

        var chartActual = new Chart(document.getElementById('chartActual').getContext('2d'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Aktual',
                    data: yActual,
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
                scales: { yAxes: [{ ticks: { beginAtZero: true } }] }
            }
        });

        var chartPred = new Chart(document.getElementById('chartPred').getContext('2d'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Prediksi',
                    data: yPred,
                    backgroundColor: 'rgba(0, 166, 90, 0.2)',
                    borderColor: '#00a65a',
                    borderWidth: 2,
                    pointRadius: 4,
                    pointBackgroundColor: '#00a65a'
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                scales: { yAxes: [{ ticks: { beginAtZero: true } }] }
            }
        });

        var chartCompare = new Chart(document.getElementById('chartCompare').getContext('2d'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Aktual',
                        data: yActual,
                        backgroundColor: 'rgba(60, 141, 188, 0.2)',
                        borderColor: '#3c8dbc',
                        borderWidth: 2,
                        pointRadius: 3,
                        pointBackgroundColor: '#3c8dbc'
                    },
                    {
                        label: 'Prediksi',
                        data: yPred,
                        backgroundColor: 'rgba(0, 166, 90, 0.2)',
                        borderColor: '#00a65a',
                        borderWidth: 2,
                        pointRadius: 3,
                        pointBackgroundColor: '#00a65a'
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                scales: { yAxes: [{ ticks: { beginAtZero: true } }] }
            }
        });
    </script>
<?php endif; ?>