<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Laporan Data Pengunjung
            <small>Export PDF / Excel</small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <form class="form-inline" method="get" action="<?php echo site_url('laporan/pengunjung'); ?>">
                            <div class="form-group">
                                <label for="month">Filter Bulan</label>
                                <input type="month" id="month" name="month" class="form-control"
                                    value="<?php echo $month; ?>">
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa fa-filter"></i> Filter
                            </button>
                            <a href="<?php echo site_url('laporan/pengunjung'); ?>" class="btn btn-default btn-sm">
                                Reset
                            </a>
                            <div class="pull-right">
                                <a href="<?php echo site_url('laporan/pengunjung_excel?month=' . $month); ?>"
                                    class="btn btn-success btn-sm">
                                    <i class="fa fa-file-excel-o"></i> Excel
                                </a>
                                <a href="<?php echo site_url('laporan/pengunjung_pdf?month=' . $month); ?>"
                                    class="btn btn-danger btn-sm">
                                    <i class="fa fa-file-pdf-o"></i> PDF
                                </a>
                            </div>
                        </form>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Nama Pengunjung</th>
                                    <th>Institusi</th>
                                    <th>Tipe</th>
                                    <th>Tujuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($rows as $row): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo tgl_indo($row->visit_date); ?></td>
                                        <td><?php echo $row->visit_time; ?></td>
                                        <td><?php echo $row->visitor_name; ?></td>
                                        <td><?php echo $row->institution; ?></td>
                                        <td><?php echo $row->membership_type; ?></td>
                                        <td><?php echo $row->room_name; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php if (empty($rows)): ?>
                            <div class="alert alert-warning">Data pengunjung belum ada.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
