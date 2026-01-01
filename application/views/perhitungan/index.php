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
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">Filter Periode Data</h3>
                        </div>
                        <div class="box-body">
                            <form class="form-inline" method="get" action="<?php echo site_url('perhitungan'); ?>">
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
                                <a href="<?php echo site_url('perhitungan'); ?>" class="btn btn-default btn-sm"
                                    title="Reset Filter"><i class="fa fa-refresh"></i></a>

                                <div class="pull-right">
                                    <button type="button" onclick="submitExportPdf()" class="btn btn-danger btn-sm"
                                        title="Export PDF">
                                        <i class="fa fa-file-pdf-o"></i> PDF
                                    </button>
                                    <!-- Excel still uses GET because no charts needed -->
                                    <a href="<?php echo site_url('perhitungan/export_excel?start_month=' . $start_month . '&start_year=' . $start_year . '&end_month=' . $end_month . '&end_year=' . $end_year); ?>"
                                        class="btn btn-success btn-sm" target="_blank" title="Export Excel">
                                        <i class="fa fa-file-excel-o"></i> Excel
                                    </a>
                                </div>
                            </form>

                            <!-- Hidden Form for PDF Export (Moved outside to avoid nesting) -->
                            <form id="formExportPdf" method="post"
                                action="<?php echo site_url('perhitungan/export_pdf'); ?>" target="_blank"
                                style="display:none;">
                                <input type="hidden" name="start_month" value="<?php echo $start_month; ?>">
                                <input type="hidden" name="start_year" value="<?php echo $start_year; ?>">
                                <input type="hidden" name="end_month" value="<?php echo $end_month; ?>">
                                <input type="hidden" name="end_year" value="<?php echo $end_year; ?>">
                                <input type="hidden" name="img_actual" id="inputImgActual">
                                <input type="hidden" name="img_pred" id="inputImgPred">
                                <input type="hidden" name="img_compare" id="inputImgCompare">
                            </form>
                        </div>
                    </div>
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
                                    <?php if (isset($next_month_pred) && isset($next_month_pred['x'])): ?>
                                        <tr class="success" style="font-weight:bold; border-top: 2px solid #00a65a;">
                                            <td><?php echo $next_month_pred['x']; ?></td>
                                            <td><?php echo $next_month_pred['label']; ?> (Bulan Depan)</td>
                                            <td>-</td>
                                            <td>
                                                <b><?php echo number_format($next_month_pred['val'], 2); ?></b>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Perhitungan Prediksi</h3>
                        </div>
                        <div class="box-body">
                            <?php
                            $n = $fit['n'];
                            $sumX = $fit['sum_x'];
                            $sumY = $fit['sum_y'];
                            $sumX2 = $fit['sum_x2'];
                            $sumXY = $fit['sum_xy'];
                            $den = ($n * $sumX2) - ($sumX * $sumX);
                            $numB = ($n * $sumXY) - ($sumX * $sumY);
                            $numA = ($sumY * $sumX2) - ($sumX * $sumXY);
                            ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <h4 class="text-muted" style="margin-top:0;">Ringkasan Nilai</h4>
                                    <p><b>&Sigma;X</b> = <?php echo $sumX; ?></p>
                                    <p><b>&Sigma;Y</b> = <?php echo $sumY; ?></p>
                                    <p><b>&Sigma;X<sup>2</sup></b> = <?php echo $sumX2; ?></p>
                                    <p><b>&Sigma;XY</b> = <?php echo $sumXY; ?></p>
                                    <p><b>n</b> = <?php echo $n; ?></p>
                                </div>
                                <div class="col-md-8">
                                    <h4 class="text-muted" style="margin-top:0;">Perhitungan Koefisien</h4>
                                    <p>
                                        <b>b</b> =
                                        <span class="text-muted">(n&Sigma;XY - &Sigma;X&Sigma;Y) / (n&Sigma;X<sup>2</sup> - (&Sigma;X)<sup>2</sup>)</span><br>
                                        = (<?php echo $n; ?> &times; <?php echo $sumXY; ?> - <?php echo $sumX; ?> &times; <?php echo $sumY; ?>) / (<?php echo $n; ?> &times; <?php echo $sumX2; ?> - <?php echo $sumX; ?><sup>2</sup>)<br>
                                        = <?php echo $numB; ?> / <?php echo $den; ?> = <b><?php echo round($fit['b'], 6); ?></b>
                                    </p>
                                    <p>
                                        <b>a</b> =
                                        <span class="text-muted">(&Sigma;Y&Sigma;X<sup>2</sup> - &Sigma;X&Sigma;XY) / (n&Sigma;X<sup>2</sup> - (&Sigma;X)<sup>2</sup>)</span><br>
                                        = (<?php echo $sumY; ?> &times; <?php echo $sumX2; ?> - <?php echo $sumX; ?> &times; <?php echo $sumXY; ?>) / <?php echo $den; ?><br>
                                        = <b><?php echo round($fit['a'], 6); ?></b>
                                    </p>
                                    <p><b>Rumus Regresi:</b> Yhat = a + bX</p>
                                </div>
                            </div>
                            <hr>
                            <?php if (isset($next_month_pred)): ?>
                                <div class="alert alert-info">
                                    <h4><i class="icon fa fa-bar-chart"></i> Prediksi Bulan Depan
                                        (<?php echo $next_month_pred['label']; ?>)</h4>
                                    <p style="margin-bottom:4px;">
                                        Yhat = a + bX = <?php echo round($fit['a'], 6); ?>
                                        + (<?php echo round($fit['b'], 6); ?> &times; <?php echo $next_month_pred['x']; ?>)
                                    </p>
                                    Angka Prediksi: <b><?php echo number_format($next_month_pred['val'], 2); ?></b>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Perhitungan Pengujian</h3>
                        </div>
                        <div class="box-body">
                            <?php
                            $mae_num = $eval['MAE'] * $fit['n']; // total |error|
                            $mse_num = $eval['MSE'] * $fit['n']; // total squared error == SSE
                            $sst = $eval['SST'];
                            $sse = $eval['SSE'];
                            $nonZeroCount = 0;
                            foreach ($rows as $r) {
                                if (abs((float) $r['y_total']) > 1e-12) {
                                    $nonZeroCount++;
                                }
                            }
                            $mape_num = ($nonZeroCount > 0) ? ($eval['MAPE'] / 100.0 * $nonZeroCount) : 0; // total |(err)/Y|
                            ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="180">R<sup>2</sup></th>
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
                                            <td><?php echo round($eval['MAPE'], 2); ?>% (<?php echo $eval['cat_mape']; ?>)</td>
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
                                    <div class="text-muted small">R<sup>2</sup> = 1 - (SSE / SST)</div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="text-muted" style="margin-top:0;">Notasi hitung</h4>
                                    <table class="table table-bordered table-condensed" style="font-size:12px;">
                                        <tr><th width="120">n (jumlah data)</th><td><?php echo $fit['n']; ?></td></tr>
                                        <tr><th>k (Y &ne; 0)</th><td><?php echo $nonZeroCount; ?></td></tr>
                                        <tr><th>&Sigma;|e|</th><td><?php echo round($mae_num, 6); ?></td></tr>
                                        <tr><th>&Sigma;e<sup>2</sup> (SSE)</th><td><?php echo round($sse, 6); ?></td></tr>
                                        <tr><th>&Sigma;(|e|/Y)</th><td><?php echo round($mape_num, 6); ?></td></tr>
                                        <tr><th>SST</th><td><?php echo round($sst, 6); ?></td></tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-muted" style="margin-bottom:6px;">Rumus dan substitusi:</p>
                                    <ul style="margin-left:18px; padding-left:0; font-size:13px;">
                                        <li>R<sup>2</sup> = 1 - (SSE / SST) = 1 - (<?php echo round($sse, 6); ?> / <?php echo round($sst, 6); ?>) = <?php echo round($eval['R2'], 6); ?></li>
                                        <li>MAE = &Sigma;|e| / n = <?php echo round($mae_num, 6); ?> / <?php echo $fit['n']; ?> = <?php echo round($eval['MAE'], 6); ?></li>
                                        <li>MSE = &Sigma;e<sup>2</sup> / n = <?php echo round($sse, 6); ?> / <?php echo $fit['n']; ?> = <?php echo round($eval['MSE'], 6); ?></li>
                                        <li>RMSE = sqrt(MSE) = sqrt(<?php echo round($eval['MSE'], 6); ?>) = <?php echo round($eval['RMSE'], 6); ?></li>
                                        <li>MAPE = (1 / k) &Sigma;(|e| / Y) &times; 100%. Dengan k = <?php echo $nonZeroCount; ?> dan &Sigma;(|e|/Y) = <?php echo round($mape_num, 6); ?>, hasilnya <?php echo round($eval['MAPE'], 2); ?>% (<?php echo $eval['cat_mape']; ?>).</li>
                                        <li>SD(Y) Populasi = sqrt(SST / n) = sqrt(<?php echo round($sst, 6); ?> / <?php echo $fit['n']; ?>) = <?php echo round($eval['sd_pop'], 6); ?></li>
                                    </ul>
                                </div>
                            </div>
                            <hr>
                            <?php
                            $mape_val = $eval['MAPE'];
                            if ($mape_val < 10) {
                                $badge = 'bg-green';
                                $label = 'SANGAT BAIK';
                                $desc = 'Error sangat kecil (< 10%), model sangat layak dipakai.';
                            } elseif ($mape_val < 20) {
                                $badge = 'bg-blue';
                                $label = 'BAIK';
                                $desc = 'Error 10-20%, model layak dipakai dengan pengawasan.';
                            } elseif ($mape_val < 50) {
                                $badge = 'bg-yellow';
                                $label = 'CUKUP';
                                $desc = 'Error 20-50%, gunakan sebagai referensi saja.';
                            } else {
                                $badge = 'bg-red';
                                $label = 'BURUK';
                                $desc = 'Error > 50%, tidak disarankan untuk keputusan utama.';
                            }
                            ?>
                            <div class="alert alert-default" style="border: 1px solid #ddd; background-color: #f9f9f9; margin-bottom:12px;">
                                <p class="lead" style="margin:0 0 6px 0;">
                                    MAPE: <span class="badge <?php echo $badge; ?>" style="font-size:100%;"><?php echo number_format($mape_val, 2); ?>%</span>
                                    &nbsp;&rarr;&nbsp; <strong><?php echo $label; ?></strong>
                                </p>
                                <div class="text-muted"><?php echo $desc; ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="box box-info collapsed-box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Detail Perhitungan Matematika (Langkah demi Langkah)</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <?php
                            // Salin rows agar tabel utama tidak berubah
                            $detail_rows = $rows;
                            $total_abs_error = 0;
                            $total_sq_error = 0;
                            $total_pct_error = 0;
                            foreach ($detail_rows as $i => $row) {
                                $x = $row['x_period'];
                                $y_act = $row['y_total'];
                                $y_pred = $fit['a'] + ($fit['b'] * $x);
                                $error = $y_act - $y_pred;
                                $abs_error = abs($error);
                                $sq_error = pow($error, 2);
                                $pct_error = ($y_act != 0) ? ($abs_error / $y_act) * 100 : 0;

                                $detail_rows[$i]['_y_pred'] = $y_pred;
                                $detail_rows[$i]['_error'] = $error;
                                $detail_rows[$i]['_abs_error'] = $abs_error;
                                $detail_rows[$i]['_sq_error'] = $sq_error;
                                $detail_rows[$i]['_pct_error'] = $pct_error;

                                $total_abs_error += $abs_error;
                                $total_sq_error += $sq_error;
                                $total_pct_error += $pct_error;
                            }
                            ?>

                            <h4>Langkah 1: Tabel bantu X, Y, XY, X&sup2;</h4>
                            <table class="table table-bordered table-striped table-hover table-condensed" style="font-size: 0.9em;">
                                <thead>
                                    <tr class="bg-info">
                                        <th class="text-center">No</th>
                                        <th class="text-center">Bulan</th>
                                        <th class="text-center">X (Periode)</th>
                                        <th class="text-center">Y (Aktual)</th>
                                        <th class="text-center">X . Y</th>
                                        <th class="text-center">X&sup2;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($detail_rows as $i => $row): ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i + 1; ?></td>
                                            <td><?php echo date('M Y', mktime(0, 0, 0, $row['month'], 1, $row['year'])); ?></td>
                                            <td class="text-center"><?php echo $row['x_period']; ?></td>
                                            <td class="text-right"><?php echo number_format($row['y_total']); ?></td>
                                            <td class="text-right"><?php echo number_format($row['x_period'] * $row['y_total']); ?></td>
                                            <td class="text-right"><?php echo number_format($row['x_period'] * $row['x_period']); ?></td>
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
                                </tfoot>
                            </table>

                            <hr>
                            <h4>Langkah 2: Menghitung a dan b</h4>
                            <p>Rumus: Y' = a + bX</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="well" style="padding:12px;">
                                        <strong>Slope (b)</strong><br>
                                        <small>(n&Sigma;XY - &Sigma;X.&Sigma;Y) / (n&Sigma;X&sup2; - (&Sigma;X)&sup2;)</small><br><br>
                                        b = ((<?php echo $fit['n']; ?> * <?php echo $fit['sum_xy']; ?>) - (<?php echo $fit['sum_x']; ?> * <?php echo $fit['sum_y']; ?>)) / ((<?php echo $fit['n']; ?> * <?php echo $fit['sum_x2']; ?>) - (<?php echo $fit['sum_x']; ?>)&sup2;)<br><br>
                                        <strong>b = <?php echo number_format($fit['b'], 6); ?></strong>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="well" style="padding:12px;">
                                        <strong>Intercept (a)</strong><br>
                                        <small>(&Sigma;Y - b.&Sigma;X) / n</small><br><br>
                                        a = (<?php echo $fit['sum_y']; ?> - (<?php echo number_format($fit['b'], 6); ?> * <?php echo $fit['sum_x']; ?>)) / <?php echo $fit['n']; ?><br><br>
                                        <strong>a = <?php echo number_format($fit['a'], 6); ?></strong>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <h4>Langkah 3: Prediksi per data & error</h4>
                            <table class="table table-bordered table-striped table-hover table-condensed" style="font-size: 0.9em;">
                                <thead>
                                    <tr class="bg-warning">
                                        <th class="text-center">No</th>
                                        <th class="text-center">X</th>
                                        <th class="text-center">Y (Aktual)</th>
                                        <th class="text-center">Y' (Prediksi)</th>
                                        <th class="text-center">Error (Y - Y')</th>
                                        <th class="text-center">|e|</th>
                                        <th class="text-center">e&sup2;</th>
                                        <th class="text-center">% Error (MAPE)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($detail_rows as $i => $row): ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i + 1; ?></td>
                                            <td class="text-center"><?php echo $row['x_period']; ?></td>
                                            <td class="text-right"><?php echo number_format($row['y_total']); ?></td>
                                            <td class="text-right" style="font-weight:bold; color:#0073b7;"><?php echo number_format($row['_y_pred'], 2); ?></td>
                                            <td class="text-right"><?php echo number_format($row['_error'], 2); ?></td>
                                            <td class="text-right"><?php echo number_format($row['_abs_error'], 2); ?></td>
                                            <td class="text-right"><?php echo number_format($row['_sq_error'], 2); ?></td>
                                            <td class="text-right"><?php echo number_format($row['_pct_error'], 2); ?>%</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr style="font-weight:bold; background-color:#eaeaea;">
                                        <td colspan="5" class="text-center">&Sigma;</td>
                                        <td class="text-right"><?php echo number_format($total_abs_error, 2); ?></td>
                                        <td class="text-right"><?php echo number_format($total_sq_error, 2); ?></td>
                                        <td class="text-right"><?php echo number_format($total_pct_error, 2); ?>%</td>
                                    </tr>
                                </tfoot>
                            </table>

                            <hr>
                            <h4>Langkah 4: Ringkasan metrik</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="callout callout-danger" style="background:white; color:black; border:1px solid #ddd; margin-bottom:10px;">
                                        <strong>MAE</strong><br>
                                        &Sigma;|e| / n = <?php echo number_format($total_abs_error, 2); ?> / <?php echo $fit['n']; ?><br>
                                        = <strong><?php echo number_format($eval['MAE'], 4); ?></strong>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="callout callout-danger" style="background:white; color:black; border:1px solid #ddd; margin-bottom:10px;">
                                        <strong>MSE</strong><br>
                                        &Sigma;e&sup2; / n = <?php echo number_format($total_sq_error, 2); ?> / <?php echo $fit['n']; ?><br>
                                        = <strong><?php echo number_format($eval['MSE'], 4); ?></strong>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="callout callout-success" style="background:#eaffea; color:black; border:1px solid #00a65a; margin-bottom:10px;">
                                        <strong>MAPE</strong><br>
                                        &Sigma;%Error / n = <?php echo number_format($total_pct_error, 2); ?> / <?php echo $fit['n']; ?><br>
                                        = <strong><?php echo number_format($eval['MAPE'], 2); ?>%</strong> (<?php echo $eval['cat_mape']; ?>)
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

<?php if ($fit): ?>
    <script src="<?php echo base_url('assets/js/chart.js'); ?>"></script>
    <script>
        // Pastikan data grafik selalu terisi dan bertipe array numerik
        var labels = <?php echo !empty($labels) ? $labels : '[]'; ?>;
        var yActual = <?php echo !empty($y_actual) ? $y_actual : '[]'; ?>;
        var yPred = <?php echo isset($fit['yhat']) ? json_encode(array_values(array_map('floatval', $fit['yhat']))) : (!empty($y_pred) ? $y_pred : '[]'); ?>;

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
                scales: { yAxes: [{ ticks: { beginAtZero: true } }] },
                animation: {
                    onComplete: function () {
                        // Animation complete, charts are ready to be captured
                    }
                }
            }
        });

        function submitExportPdf() {
            // Capture chart images using standard Canvas API
            document.getElementById('inputImgActual').value = document.getElementById('chartActual').toDataURL('image/png');
            document.getElementById('inputImgPred').value = document.getElementById('chartPred').toDataURL('image/png');
            document.getElementById('inputImgCompare').value = document.getElementById('chartCompare').toDataURL('image/png');

            // Submit form
            document.getElementById('formExportPdf').submit();
        }
    </script>
<?php endif; ?>

