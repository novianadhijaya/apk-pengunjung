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
                            <form class="form-inline" method="get" action="<?php echo site_url('laporan/prediksi'); ?>">
                                <div class="form-group">
                                    <label for="month">Bulan Target</label>
                                    <input type="month" id="month" name="month" class="form-control"
                                        value="<?php echo $target_month; ?>">
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa fa-search"></i> Tampilkan
                                </button>
                                <div class="pull-right">
                                    <a href="<?php echo site_url('laporan/prediksi_excel?month=' . $target_month); ?>"
                                        class="btn btn-success btn-sm">
                                        <i class="fa fa-file-excel-o"></i> Excel
                                    </a>
                                    <a href="<?php echo site_url('laporan/prediksi_pdf?month=' . $target_month); ?>"
                                        class="btn btn-danger btn-sm">
                                        <i class="fa fa-file-pdf-o"></i> PDF
                                    </a>
                                </div>
                            </form>
                        </div>
                        <div class="box-body">
                            <?php if (!empty($notice)): ?>
                                <div class="alert alert-warning"><?php echo $notice; ?></div>
                            <?php endif; ?>

                            <?php if (!empty($target)): ?>
                                <p><b>Bulan Target:</b> <?php echo $target['month']; ?></p>
                                <p><b>Prediksi (Yhat):</b> <?php echo number_format($target['y_pred'], 0, ',', '.'); ?></p>
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
                                            <td><?php echo (int)$r['y_total']; ?></td>
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
