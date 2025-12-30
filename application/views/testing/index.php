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
                        <h3 class="box-title">Filter Tahun</h3>
                    </div>
                    <div class="box-body">
                        <form class="form-inline" method="get" action="<?php echo site_url('testing'); ?>">
                            <div class="form-group">
                                <label for="filter_year">Pilih Tahun</label>
                                <select class="form-control" name="filter_year" onchange="this.form.submit()">
                                    <option value="">-- Semua Data --</option>
                                    <?php foreach ($available_years as $yr): ?>
                                        <option value="<?php echo $yr['year']; ?>" <?php echo ($filter_year == $yr['year']) ? 'selected' : ''; ?>>
                                            <?php echo $yr['year']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?php if ($filter_year): ?>
                                <a href="<?php echo site_url('testing'); ?>" class="btn btn-default">Reset</a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>

                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Uji Bulan Tertentu</h3>
                    </div>
                    <div class="box-body">
                        <form class="form-inline" method="get" action="<?php echo site_url('testing'); ?>">
                            <div class="form-group">
                                <label for="test_month">Pilih Bulan Uji</label>
                                <input type="month" class="form-control" name="test_month"
                                    value="<?php echo isset($test_month) ? $test_month : ''; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-success"><i class="fa fa-flask"></i> Uji</button>
                        </form>

                        <?php if (isset($single_test) && $single_test): ?>
                            <hr>
                            <h4>Hasil Uji: <?php echo $single_test['month']; ?></h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Data Latih</th>
                                    <td><?php echo $single_test['train_count']; ?> bulan sebelumnya</td>
                                </tr>
                                <tr>
                                    <th>Aktual (Y)</th>
                                    <td><?php echo $single_test['actual'] !== null ? $single_test['actual'] : 'Data belum ada'; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Prediksi (Yhat)</th>
                                    <td><?php echo number_format($single_test['predicted'], 2); ?></td>
                                </tr>
                                <?php if ($single_test['actual'] !== null): ?>
                                    <tr>
                                        <th>Error (Selisih)</th>
                                        <td><?php echo number_format($single_test['error'], 2); ?></td>
                                    </tr>
                                    <tr>
                                        <th>MAPE (Akurasi)</th>
                                        <td
                                            style="font-weight: bold; <?php echo ($single_test['mape'] > 50) ? 'color:red;' : 'color:green;'; ?>">
                                            <?php echo number_format($single_test['mape'], 2); ?>%
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if (!$fit && empty($single_test)): ?>
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
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>