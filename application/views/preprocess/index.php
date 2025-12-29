<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Preprocessing Data
            <small>Agregasi bulanan untuk regresi</small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Langkah Preprocessing</h3>
                        <div class="box-tools pull-right">
                            <a href="<?php echo site_url('preprocess/run'); ?>" class="btn btn-primary btn-sm"
                                onclick="return confirm('Jalankan preprocessing data sekarang?')">
                                <i class="fa fa-cogs"></i> Proses Preprocessing
                            </a>
                        </div>
                    </div>
                    <div class="box-body">
                        <div id="message">
                            <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                        </div>
                        <ol>
                            <li>Pembersihan data: abaikan data kosong (tanggal/nama) dan data duplikat.</li>
                            <li>Transformasi data ke numerik: X = urutan bulan, Y = total pengunjung per bulan.</li>
                            <li>Penentuan variabel: X (waktu) dan Y (jumlah pengunjung).</li>
                            <li>Tombol proses untuk membangun tabel hasil preprocessing.</li>
                        </ol>
                        <div class="text-muted small">
                            Catatan: data duplikat dihitung berdasarkan kombinasi identitas dan waktu kunjungan.
                        </div>
                    </div>
                </div>

                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Hasil Preprocessing</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <?php if (empty($monthly)): ?>
                            <div class="alert alert-warning">Belum ada data hasil preprocessing.</div>
                        <?php else: ?>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="60">No</th>
                                        <th>Tahun</th>
                                        <th>Bulan</th>
                                        <th>X (Periode)</th>
                                        <th>Y (Jumlah)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($monthly as $row): ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $row['year']; ?></td>
                                            <td><?php echo $row['month']; ?></td>
                                            <td><?php echo $row['x_period']; ?></td>
                                            <td><?php echo $row['y_total']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
