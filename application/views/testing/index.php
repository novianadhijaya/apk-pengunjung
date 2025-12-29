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
                                        <tr><th>R²</th><td><?php echo round($eval['R2'], 6); ?></td></tr>
                                        <tr><th>MAE</th><td><?php echo round($eval['MAE'], 6); ?></td></tr>
                                        <tr><th>MSE</th><td><?php echo round($eval['MSE'], 6); ?></td></tr>
                                        <tr><th>RMSE</th><td><?php echo round($eval['RMSE'], 6); ?></td></tr>
                                        <tr><th>MAPE</th><td><?php echo round($eval['MAPE'], 2); ?>% (<?php echo $eval['cat_mape']; ?>)</td></tr>
                                        <tr><th>SD(Y) Populasi</th><td><?php echo round($eval['sd_pop'], 6); ?></td></tr>
                                        <tr><th>Kategori SD</th><td><?php echo $eval['cat_sd']; ?></td></tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr><th>SST</th><td><?php echo round($eval['SST'], 6); ?></td></tr>
                                        <tr><th>SSR</th><td><?php echo round($eval['SSR'], 6); ?></td></tr>
                                        <tr><th>SSE</th><td><?php echo round($eval['SSE'], 6); ?></td></tr>
                                    </table>
                                    <div class="text-muted small">
                                        R² = 1 - (SSE / SST)
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
