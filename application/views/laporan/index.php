<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Laporan
            <small>Data pengunjung, prediksi, dan pengujian</small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Laporan Data Pengunjung</h3>
                    </div>
                    <div class="box-body">
                        <p>Menampilkan daftar kunjungan dan export PDF/Excel.</p>
                        <a href="<?php echo site_url('laporan/pengunjung'); ?>" class="btn btn-primary btn-sm">
                            Lihat Laporan
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Laporan Hasil Prediksi</h3>
                    </div>
                    <div class="box-body">
                        <p>Menampilkan hasil regresi dan prediksi bulan target.</p>
                        <a href="<?php echo site_url('laporan/prediksi'); ?>" class="btn btn-success btn-sm">
                            Lihat Laporan
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Laporan Pengujian</h3>
                    </div>
                    <div class="box-body">
                        <p>Menampilkan R2, MAE, MSE, RMSE, MAPE, dan SD.</p>
                        <a href="<?php echo site_url('laporan/pengujian'); ?>" class="btn btn-warning btn-sm">
                            Lihat Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
