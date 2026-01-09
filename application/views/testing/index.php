<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Pengujian Model
            <small>Evaluasi regresi linier</small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Filter Periode Data</h3>
                    </div>
                    <div class="box-body">
                        <form class="form-inline" method="get" action="<?php echo site_url('testing'); ?>">
                            <div class="form-group" style="margin-right: 15px;">
                                <label>Dari Periode:</label>
                                <select name="start_month" class="form-control input-sm">
                                    <?php
                                    $months = [
                                        1 => 'Jan',
                                        2 => 'Feb',
                                        3 => 'Mar',
                                        4 => 'Apr',
                                        5 => 'Mei',
                                        6 => 'Jun',
                                        7 => 'Jul',
                                        8 => 'Agu',
                                        9 => 'Sep',
                                        10 => 'Okt',
                                        11 => 'Nov',
                                        12 => 'Des'
                                    ];
                                    foreach ($months as $num => $name) {
                                        $selected = ($start_month == $num) ? 'selected' : '';
                                        echo "<option value='$num' $selected>$name</option>";
                                    }
                                    ?>
                                </select>
                                <select name="start_year" class="form-control input-sm">
                                    <?php
                                    $current_year = date('Y');
                                    for ($y = 2018; $y <= $current_year + 5; $y++) {
                                        $selected = ($start_year == $y) ? 'selected' : '';
                                        echo "<option value='$y' $selected>$y</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group" style="margin-right: 15px;">
                                <label>Sampai Periode:</label>
                                <select name="end_month" class="form-control input-sm">
                                    <?php foreach ($months as $num => $name) {
                                        $selected = ($end_month == $num) ? 'selected' : '';
                                        echo "<option value='$num' $selected>$name</option>";
                                    } ?>
                                </select>
                                <select name="end_year" class="form-control input-sm">
                                    <?php
                                    for ($y = 2018; $y <= $current_year + 5; $y++) {
                                        $selected = ($end_year == $y) ? 'selected' : '';
                                        echo "<option value='$y' $selected>$y</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa fa-filter"></i> Terapkan
                            </button>
                            <a href="<?php echo site_url('testing'); ?>" class="btn btn-default btn-sm">Reset</a>
                        </form>
                    </div>
                </div>



                <?php if (!$fit): ?>
                    <div class="alert alert-warning">
                        Data preprocessing belum ada atau kurang dari 2 bulan. Jalankan preprocessing dulu.
                    </div>
                <?php else: ?>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Hasil Pengujian</h3>
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
                                    <div class="text-muted small">
                                        R² = 1 - (SSE / SST)
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Analisis Hasil (Kesimpulan)</h3>
                        </div>
                        <div class="box-body">
                            <?php
                            $mape = $eval['MAPE'];
                            $kesimpulan = "";
                            $class_badge = "";
                            $deskripsi = "";

                            if ($mape < 10) {
                                $kesimpulan = "SANGAT BAIK (Highly Accurate)";
                                $class_badge = "bg-green";
                                $deskripsi = "Model memiliki tingkat error yang sangat kecil (< 10%). Sangat layak digunakan untuk prediksi masa depan.";
                            } elseif ($mape < 20) {
                                $kesimpulan = "BAIK (Good)";
                                $class_badge = "bg-blue";
                                $deskripsi = "Model memiliki akurasi yang baik (Error 10-20%). Layak digunakan dengan pengawasan.";
                            } elseif ($mape < 50) {
                                $kesimpulan = "CUKUP / WAJAR (Reasonable)";
                                $class_badge = "bg-yellow";
                                $deskripsi = "Model memiliki error yang cukup terasa (20-50%). Sebaiknya gunakan sebagai pembanding saja, bukan penentu utama.";
                            } else {
                                $kesimpulan = "BURUK (Inaccurate)";
                                $class_badge = "bg-red";
                                $deskripsi = "Model tidak akurat (Error > 50%). Pola data pengunjung sangat acak atau tidak linier. Tidak disarankan untuk forecasting.";
                            }
                            ?>
                            <p class="lead">
                                Tingkat Akurasi (MAPE): <span class="badge <?php echo $class_badge; ?>"
                                    style="font-size:100%;"><?php echo number_format($mape, 2); ?>%</span>
                                &nbsp; &rightarrow; &nbsp; <strong><?php echo $kesimpulan; ?></strong>
                            </p>
                            <div class="alert alert-default" style="border: 1px solid #ddd; background-color: #f9f9f9;">
                                <i class="fa fa-info-circle"></i> <?php echo $deskripsi; ?>
                            </div>
                        </div>
                    </div>

                    <div class="box box-info collapsed-box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Detail Perhitungan Matematika (Langkah demi Langkah)</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="box-body">

                            <!-- LANGKAH 1: TABEL BANTU -->
                            <h4>Langkah 1: Menyiapkan Data & Variabel (X dan Y)</h4>
                            <p>Kita ubah periode bulan menjadi angka urut (X) dan jumlah pengunjung menjadi Y.</p>
                            <table class="table table-bordered table-striped table-hover table-condensed">
                                <thead>
                                    <tr class="bg-info">
                                        <th class="text-center">No</th>
                                        <th class="text-center">Bulan</th>
                                        <th class="text-center">X (Periode)</th>
                                        <th class="text-center">Y (Pengunjung)</th>
                                        <th class="text-center">X . Y</th>
                                        <th class="text-center">X&sup2;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rows as $i => $row): ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i + 1; ?></td>
                                            <td><?php echo date('M Y', mktime(0, 0, 0, $row['month'], 1, $row['year'])); ?>
                                            </td>
                                            <td class="text-center"><?php echo $row['x_period']; ?></td>
                                            <td class="text-right"><?php echo number_format($row['y_total']); ?></td>
                                            <td class="text-right">
                                                <?php echo number_format($row['x_period'] * $row['y_total']); ?>
                                            </td>
                                            <td class="text-right">
                                                <?php echo number_format($row['x_period'] * $row['x_period']); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr style="font-weight:bold; background-color:#eaeaea;">
                                        <td colspan="2" class="text-center">TOTAL (&Sigma;)</td>
                                        <td class="text-center"><?php echo number_format($fit['sum_x']); ?></td>
                                        <td class="text-right"><?php echo number_format($fit['sum_y']); ?></td>
                                        <td class="text-right"><?php echo number_format($fit['sum_xy']); ?></td>
                                        <td class="text-right"><?php echo number_format($fit['sum_x2']); ?></td>
                                    </tr>
                                    <tr style="font-weight:bold; color:blue;">
                                        <td colspan="2" class="text-center">Notasi</td>
                                        <td class="text-center">&Sigma;X</td>
                                        <td class="text-right">&Sigma;Y</td>
                                        <td class="text-right">&Sigma;XY</td>
                                        <td class="text-right">&Sigma;X&sup2;</td>
                                    </tr>
                                </tfoot>
                            </table>

                            <br>
                            <hr>

                            <!-- LANGKAH 2: CARI A DAN B -->
                            <h4>Langkah 2: Menghitung Koefisien Regresi (a & b)</h4>
                            <p>Rumus Regresi Linier: <code>Y' = a + bX</code></p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="well">
                                        <strong>Mencari Slope (b) - Kemiringan Garis</strong><br>
                                        <small>Rumus: (n.&Sigma;XY - &Sigma;X.&Sigma;Y) / (n.&Sigma;X&sup2; -
                                            (&Sigma;X)&sup2;)</small>
                                        <br><br>
                                        n = <?php echo $fit['n']; ?> (Jumlah Data)<br>
                                        b = ((<?php echo $fit['n']; ?> * <?php echo $fit['sum_xy']; ?>) -
                                        (<?php echo $fit['sum_x']; ?> * <?php echo $fit['sum_y']; ?>)) / <br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ((<?php echo $fit['n']; ?> *
                                        <?php echo $fit['sum_x2']; ?>) - (<?php echo $fit['sum_x']; ?>)&sup2;)
                                        <br><br>
                                        <strong>b = <?php echo number_format($fit['b'], 6); ?></strong>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="well">
                                        <strong>Mencari Intercept (a) - Titik Potong</strong><br>
                                        <small>Rumus: (&Sigma;Y - b.&Sigma;X) / n</small>
                                        <br><br>
                                        a = (<?php echo $fit['sum_y']; ?> - (<?php echo number_format($fit['b'], 6); ?>
                                        * <?php echo $fit['sum_x']; ?>)) / <?php echo $fit['n']; ?>
                                        <br><br><br>
                                        <strong>a = <?php echo number_format($fit['a'], 6); ?></strong>
                                    </div>
                                </div>
                            </div>
                            <p class="alert alert-info">
                                <strong>Persamaan Model:</strong><br>
                                Y' = <?php echo number_format($fit['a'], 2); ?> +
                                (<?php echo number_format($fit['b'], 4); ?> * X)
                            </p>

                            <br>
                            <hr>

                            <!-- LANGKAH 3: TABEL ERROR -->
                            <h4>Langkah 3: Menghitung Prediksi & Error (Selisih)</h4>
                            <p>Disini kita bandingkan <strong>Y (Aktual)</strong> dengan <strong>Y' (Hasil Rumus)</strong>
                                untuk mencari error.</p>
                            <table class="table table-bordered table-striped table-hover table-condensed"
                                style="font-size: 0.9em;">
                                <thead>
                                    <tr class="bg-warning">
                                        <th class="text-center">No</th>
                                        <th class="text-center">X</th>
                                        <th class="text-center">Y (Aktual)</th>
                                        <th class="text-center">Y' (Prediksi)</th>
                                        <th class="text-center">Error (Y-Y')</th>
                                        <th class="text-center">Abs Error |e|</th>
                                        <th class="text-center">Square Error e&sup2;</th>
                                        <th class="text-center">% Error (Mape)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_abs_error = 0;
                                    $total_sq_error = 0;
                                    $total_pct_error = 0;
                                    foreach ($rows as $i => $row):
                                        $x = $row['x_period'];
                                        $y_act = $row['y_total'];
                                        $y_pred = $fit['a'] + ($fit['b'] * $x);
                                        $error = $y_act - $y_pred;
                                        $abs_error = abs($error);
                                        $sq_error = pow($error, 2);
                                        $pct_error = ($y_act != 0) ? ($abs_error / $y_act) * 100 : 0;

                                        $total_abs_error += $abs_error;
                                        $total_sq_error += $sq_error;
                                        $total_pct_error += $pct_error;
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i + 1; ?></td>
                                            <td class="text-center"><?php echo $x; ?></td>
                                            <td class="text-right"><?php echo number_format($y_act); ?></td>
                                            <td class="text-right" style="font-weight:bold; color:#0073b7;">
                                                <?php echo number_format($y_pred, 2); ?>
                                            </td>
                                            <td class="text-right"><?php echo number_format($error, 2); ?></td>
                                            <td class="text-right"><?php echo number_format($abs_error, 2); ?></td>
                                            <td class="text-right"><?php echo number_format($sq_error, 2); ?></td>
                                            <td class="text-right"><?php echo number_format($pct_error, 2); ?>%</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr style="font-weight:bold; background-color:#eaeaea;">
                                        <td colspan="5" class="text-center">TOTAL JUMLAH (&Sigma;)</td>
                                        <td class="text-right"><?php echo number_format($total_abs_error, 2); ?></td>
                                        <td class="text-right"><?php echo number_format($total_sq_error, 2); ?></td>
                                        <td class="text-right"><?php echo number_format($total_pct_error, 2); ?>%</td>
                                    </tr>
                                </tfoot>
                            </table>

                            <h4>Langkah 3A: Menghitung SSE (Sum of Squared Error)</h4>
                            <p>SSE adalah jumlah kuadrat error dari tabel sebelumnya.</p>
                            <div class="well" style="margin-bottom: 10px;">
                                <strong>Rumus:</strong> <code>SSE = &Sigma;e&sup2;</code><br>
                                SSE = <?php echo number_format($total_sq_error, 6); ?><br>
                                <span class="text-muted small">Sama dengan SSE di tabel hasil pengujian:
                                    <?php echo number_format($eval['SSE'], 6); ?></span>
                            </div>

                            <br>
                            <hr>

                            <!-- LANGKAH 3B: HITUNG SSR -->
                            <h4>Langkah 3B: Menghitung SSR (Sum of Squares Regression)</h4>
                            <p>
                                SSR digunakan untuk mengukur variasi hasil prediksi terhadap rata-rata data aktual.
                                <br>
                                <strong>Rumus:</strong> <code>SSR = &Sigma;(Y' - Ȳ)&sup2;</code>
                                &nbsp;dengan&nbsp; <code>Ȳ = &Sigma;Y / n</code>
                            </p>
                            <div class="well" style="margin-bottom: 10px;">
                                Ȳ = <?php echo number_format($eval['ybar'], 6); ?>
                                (<?php echo number_format($fit['sum_y'], 0); ?> / <?php echo $fit['n']; ?>)
                            </div>
                            <table class="table table-bordered table-striped table-hover table-condensed"
                                style="font-size: 0.9em;">
                                <thead>
                                    <tr class="bg-info">
                                        <th class="text-center">No</th>
                                        <th class="text-center">X</th>
                                        <th class="text-center">Y' (Prediksi)</th>
                                        <th class="text-center">Ȳ (Rata-rata)</th>
                                        <th class="text-center">(Y' - Ȳ)</th>
                                        <th class="text-center">(Y' - Ȳ)&sup2;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ybar = (float) $eval['ybar'];
                                    $total_ssr = 0.0;
                                    foreach ($rows as $i => $row):
                                        $x = (float) $row['x_period'];
                                        $y_pred = (float) ($fit['a'] + ($fit['b'] * $x));
                                        $dev = $y_pred - $ybar;
                                        $ssr_i = $dev * $dev;
                                        $total_ssr += $ssr_i;
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i + 1; ?></td>
                                            <td class="text-center"><?php echo number_format($x, 0); ?></td>
                                            <td class="text-right" style="font-weight:bold; color:#0073b7;">
                                                <?php echo number_format($y_pred, 6); ?>
                                            </td>
                                            <td class="text-right"><?php echo number_format($ybar, 6); ?></td>
                                            <td class="text-right"><?php echo number_format($dev, 6); ?></td>
                                            <td class="text-right"><?php echo number_format($ssr_i, 6); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr style="font-weight:bold; background-color:#eaeaea;">
                                        <td colspan="5" class="text-center">TOTAL SSR (&Sigma;)</td>
                                        <td class="text-right"><?php echo number_format($total_ssr, 6); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <p class="alert alert-info" style="margin-top: 10px;">
                                <strong>Hasil:</strong> SSR = <?php echo number_format($total_ssr, 6); ?>
                                (harus sama dengan SSR di tabel hasil pengujian: <?php echo number_format($eval['SSR'], 6); ?>)
                            </p>

                            <br>
                            <hr>

                            <!-- LANGKAH 4: HITUNG FINAL METRICS -->
                            <h4>Langkah 4: Menghitung Rata-rata Error (Final Metric)</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="callout callout-danger"
                                        style="background:white; color:black; border:1px solid #ddd;">
                                        <strong>MAE (Mean Absolute Error)</strong><br>
                                        Rata-rata kesalahan mutlak.<br>
                                        <code>&Sigma;|e| / n</code><br>
                                        <?php echo number_format($total_abs_error, 2); ?> / <?php echo $fit['n']; ?><br>
                                        = <strong><?php echo number_format($eval['MAE'], 4); ?></strong>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="callout callout-danger"
                                        style="background:white; color:black; border:1px solid #ddd;">
                                        <strong>MSE (Mean Squared Error)</strong><br>
                                        Rata-rata kuadrat kesalahan.<br>
                                        <code>&Sigma;e&sup2; / n</code><br>
                                        <?php echo number_format($total_sq_error, 2); ?> / <?php echo $fit['n']; ?><br>
                                        = <strong><?php echo number_format($eval['MSE'], 4); ?></strong>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="callout callout-success"
                                        style="background:#eaffea; color:black; border:1px solid #00a65a;">
                                        <strong>MAPE (Mean Abs % Error)</strong><br>
                                        Rata-rata persentase kesalahan.<br>
                                        <code>&Sigma;%Error / n</code><br>
                                        <?php echo number_format($total_pct_error, 2); ?> / <?php echo $fit['n']; ?><br>
                                        = <strong><?php echo number_format($eval['MAPE'], 2); ?>%</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>
