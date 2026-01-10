<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Laporan Pengujian
            <small>Evaluasi model regresi</small>
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
                            <form class="form-inline" method="get" action="<?php echo site_url('laporan/pengujian'); ?>">
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
                                <a href="<?php echo site_url('laporan/pengujian'); ?>" class="btn btn-default btn-sm"
                                    title="Reset Filter"><i class="fa fa-refresh"></i></a>

                                <div class="pull-right">
                                    <a href="<?php echo site_url('laporan/pengujian_pdf?start_month=' . $start_month . '&start_year=' . $start_year . '&end_month=' . $end_month . '&end_year=' . $end_year); ?>"
                                        class="btn btn-danger btn-sm" target="_blank" title="Export PDF">
                                        <i class="fa fa-file-pdf-o"></i> PDF
                                    </a>
                                    <a href="<?php echo site_url('laporan/pengujian_excel?start_month=' . $start_month . '&start_year=' . $start_year . '&end_month=' . $end_month . '&end_year=' . $end_year); ?>"
                                        class="btn btn-success btn-sm" target="_blank" title="Export Excel">
                                        <i class="fa fa-file-excel-o"></i> Excel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

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
                                            <th>SD(Y) Sample</th>
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