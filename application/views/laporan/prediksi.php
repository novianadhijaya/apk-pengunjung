<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Laporan Hasil Prediksi
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
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Filter Periode Data</h3>
                        </div>
                        <div class="box-body">
                            <form class="form-inline" method="get" action="<?php echo site_url('laporan/prediksi'); ?>">
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
                                <a href="<?php echo site_url('laporan/prediksi'); ?>" class="btn btn-default btn-sm"
                                    title="Reset Filter"><i class="fa fa-refresh"></i></a>

                                <div class="pull-right">
                                    <a href="<?php echo site_url('laporan/prediksi_pdf?start_month=' . $start_month . '&start_year=' . $start_year . '&end_month=' . $end_month . '&end_year=' . $end_year); ?>"
                                        class="btn btn-danger btn-sm" target="_blank" title="Export PDF">
                                        <i class="fa fa-file-pdf-o"></i> PDF
                                    </a>
                                    <a href="<?php echo site_url('laporan/prediksi_excel?start_month=' . $start_month . '&start_year=' . $start_year . '&end_month=' . $end_month . '&end_year=' . $end_year); ?>"
                                        class="btn btn-success btn-sm" target="_blank" title="Export Excel">
                                        <i class="fa fa-file-excel-o"></i> Excel
                                    </a>
                                </div>
                            </form>
                        </div>

                        <div class="box-body">
                            <?php if (!empty($notice)): ?>
                                <div class="alert alert-warning"><?php echo $notice; ?></div>
                            <?php endif; ?>

                            <?php if (!empty($target)): ?>
                                <div class="alert alert-info">
                                    <h4><i class="icon fa fa-bar-chart"></i> Prediksi Bulan Depan
                                        (<?php echo $target['month']; ?>)</h4>
                                    Angka Prediksi: <b><?php echo number_format($target['y_pred'], 0, ',', '.'); ?></b>
                                </div>
                                <hr>
                            <?php endif; ?>

                            <p><b>ΣX</b> = <?php echo $fit['sum_x']; ?></p>
                            <p><b>ΣY</b> = <?php echo $fit['sum_y']; ?></p>
                            <p><b>ΣX²</b> = <?php echo $fit['sum_x2']; ?></p>
                            <p><b>ΣXY</b> = <?php echo $fit['sum_xy']; ?></p>
                            <p><b>a</b> = <?php echo round($fit['a'], 6); ?></p>
                            <p><b>b</b> = <?php echo round($fit['b'], 6); ?></p>
                            <p><b>Rumus Regresi:</b> Yhat = a + bX</p>
                        </div>
                    </div>

                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Data X, Y, dan Yhat</h3>
                        </div>
                        <div class="box-body table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>X (Periode)</th>
                                        <th>Bulan</th>
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
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>