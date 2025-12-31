<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Prediksi Pengunjung
            <small>Regresi linier sederhana</small>
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
                    <?php if (isset($next_month_pred)): ?>
                        <div class="callout callout-info">
                            <h4><i class="icon fa fa-bullhorn"></i> Prediksi Pengunjung Bulan Depan
                                (<?php echo $next_month_pred['label']; ?>)</h4>
                            <p style="font-size: 18px;">Estimasi jumlah pengunjung adalah
                                <b><?php echo number_format($next_month_pred['val'], 0, ',', '.'); ?></b> orang.
                            </p>
                        </div>
                    <?php endif; ?>

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Pilih Bulan Prediksi</h3>
                        </div>
                        <div class="box-body">
                            <form class="form-inline" method="get" action="<?php echo site_url('prediction'); ?>">
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
                                    <i class="fa fa-search"></i> Hitung
                                </button>
                            </form>

                            <?php if (!empty($notice)): ?>
                                <div class="alert alert-warning" style="margin-top: 10px;">
                                    <?php echo $notice; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>




                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Data X dan Y + Yhat</h3>
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
                                    <?php // Historical rows removed as per request ?>
                                    <?php if (!empty($targets)): ?>
                                        <?php foreach ($targets as $target): ?>
                                            <tr style="background-color: #e8f5e9; font-weight: bold;">
                                                <td><?php echo $target['x']; ?></td>
                                                <td><?php echo $target['month_label']; ?></td>
                                                <td><?php echo isset($target['y_actual']) ? number_format($target['y_actual'], 0, ',', '.') : '-'; ?>
                                                </td>
                                                <td>
                                                    <?php echo number_format($target['y_pred'], 0, ',', '.'); ?>
                                                    <small style="color: #777;">(pengunjung)</small>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <?php if (!empty($targets)): ?>
                        <div class="box box-default collapsed-box">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-calculator"></i> Detail & Rumus Perhitungan</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                                <ul>
                                    <li><b>X</b>: Variabel independen (Periode waktu/bulan ke-n)</li>
                                    <li><b>a</b>: Konstanta (Intersep Y) = <?php echo round($fit['a'], 4); ?></li>
                                    <li><b>b</b>: Koefisien Regresi (Slope) = <?php echo round($fit['b'], 4); ?></li>
                                </ul>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="well well-sm">
                                            <b>Rumus & Substitusi b (Slope):</b><br>
                                            <code>b = [n(ΣXY) - (ΣX)(ΣY)] / [n(ΣX²) - (ΣX)²]</code><br>
                                            <?php
                                            $n = $fit['n'];
                                            $sum_x = $fit['sum_x'];
                                            $sum_y = $fit['sum_y'];
                                            $sum_x2 = $fit['sum_x2'];
                                            $sum_xy = $fit['sum_xy'];
                                            $b_numerator = ($n * $sum_xy) - ($sum_x * $sum_y);
                                            $b_denominator = ($n * $sum_x2) - ($sum_x * $sum_x);
                                            ?>
                                            <small>
                                                n=<?php echo $n; ?>, ΣX=<?php echo $sum_x; ?>, ΣY=<?php echo $sum_y; ?>,
                                                ΣX²=<?php echo $sum_x2; ?>, ΣXY=<?php echo $sum_xy; ?>
                                            </small><br>
                                            <code>b = <?php echo $b_numerator; ?> / <?php echo $b_denominator; ?></code><br>
                                            <code>b = <?php echo round($fit['b'], 6); ?></code>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="well well-sm">
                                            <b>Rumus & Substitusi a (Intercept):</b><br>
                                            <code>a = (ΣY - b(ΣX)) / n</code><br>
                                            <?php
                                            $b_val = $fit['b'];
                                            $a_numerator = $sum_y - ($b_val * $sum_x);
                                            ?>
                                            <br>
                                            <code>a = (<?php echo $sum_y; ?> - (<?php echo round($b_val, 4); ?> * <?php echo $sum_x; ?>)) / <?php echo $n; ?></code><br>
                                            <code>a = <?php echo round($a_numerator, 2); ?> / <?php echo $n; ?></code><br>
                                            <code>a = <?php echo round($fit['a'], 6); ?></code>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <h4>Proses Perhitungan Prediksi (Yhat) per Bulan:</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr class="info">
                                                <th>Label Bulan</th>
                                                <th>Periode (X)</th>
                                                <th>Rumus (Yhat = a + bX)</th>
                                                <th>Hasil (Yhat)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $a = $fit['a'];
                                            $b = $fit['b'];
                                            foreach ($targets as $t):
                                                $x = $t['x'];
                                                $calc_b_x = $b * $x;
                                                $result = $a + $calc_b_x;
                                                ?>
                                                <tr>
                                                    <td><b><?php echo $t['month_label']; ?></b></td>
                                                    <td><?php echo $x; ?></td>
                                                    <td>
                                                        <code><?php echo round($a, 2); ?> + (<?php echo round($b, 2); ?> * <?php echo $x; ?>)</code>
                                                    </td>
                                                    <td>
                                                        <code><?php echo number_format($result, 2); ?></code>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <?php if (isset($next_month_pred) && isset($next_month_pred['x'])): ?>
                                                <tr class="success" style="font-weight:bold; border-top: 2px solid #00a65a;">
                                                    <td><b><?php echo $next_month_pred['label']; ?> (Bulan Depan)</b></td>
                                                    <td><?php echo $next_month_pred['x']; ?></td>
                                                    <td>
                                                        <code><?php echo round($a, 2); ?> + (<?php echo round($b, 2); ?> * <?php echo $next_month_pred['x']; ?>)</code>
                                                    </td>
                                                    <td>
                                                        <code><?php echo number_format($next_month_pred['val'], 2); ?></code>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <p class="text-muted small">
                                    <i class="fa fa-info-circle"></i> Nilai hasil di tabel atas (Data X dan Y) dibulatkan
                                    menjadi bilangan bulat, sedangkan di sini ditampilkan dengan desimal untuk transparansi
                                    perhitungan.
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>