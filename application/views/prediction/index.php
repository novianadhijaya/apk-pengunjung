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
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Pilih Bulan Prediksi</h3>
                        </div>
                        <div class="box-body">
                            <form class="form-inline" method="get" action="<?php echo site_url('prediction'); ?>">
                                <div class="form-group">
                                    <label for="month">Bulan</label>
                                    <input type="month" id="month" name="month" class="form-control"
                                        value="<?php echo htmlspecialchars($target_month); ?>">
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i> Prediksi
                                </button>
                            </form>

                            <?php if (!empty($notice)): ?>
                                <div class="alert alert-warning" style="margin-top: 10px;">
                                    <?php echo $notice; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if (!empty($target)): ?>
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">Hasil Prediksi</h3>
                            </div>
                            <div class="box-body">
                                <p><b>Persamaan:</b> Yhat = a + bX</p>
                                <p><b>a</b> = <?php echo round($fit['a'], 6); ?></p>
                                <p><b>b</b> = <?php echo round($fit['b'], 6); ?></p>
                                <hr>
                                <p><b>Bulan Target:</b> <?php echo $target['month']; ?></p>
                                <p><b>X Target:</b> <?php echo $target['x']; ?></p>
                                <p><b>Prediksi (Yhat):</b> <?php echo number_format($target['y_pred'], 0, ',', '.'); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>

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
