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
                        <h3 class="box-title">Filter Periode Data</h3>
                    </div>
                    <div class="box-body">
                        <form class="form-inline" method="get" action="<?php echo site_url('laporan/pengunjung'); ?>">
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
                            <a href="<?php echo site_url('laporan/pengunjung'); ?>" class="btn btn-default btn-sm"
                                title="Reset Filter"><i class="fa fa-refresh"></i></a>

                            <div class="pull-right">
                                <a href="<?php echo site_url('laporan/pengunjung_pdf?start_month=' . $start_month . '&start_year=' . $start_year . '&end_month=' . $end_month . '&end_year=' . $end_year); ?>"
                                    class="btn btn-danger btn-sm" target="_blank" title="Export PDF">
                                    <i class="fa fa-file-pdf-o"></i> PDF
                                </a>
                                <a href="<?php echo site_url('laporan/pengunjung_excel?start_month=' . $start_month . '&start_year=' . $start_year . '&end_month=' . $end_month . '&end_year=' . $end_year); ?>"
                                    class="btn btn-success btn-sm" target="_blank" title="Export Excel">
                                    <i class="fa fa-file-excel-o"></i> Excel
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
                                <?php $no = 1;
                                foreach ($rows as $row): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo tgl_indo($row->visit_date); ?></td>
                                        <td><?php echo $row->visit_time; ?></td>
                                        <td><?php echo htmlspecialchars($row->visitor_name, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($row->institution, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($row->membership_type, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($row->room_name, ENT_QUOTES, 'UTF-8'); ?></td>
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