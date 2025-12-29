<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Master Data Kunjungan</h3>
                    </div>

                    <div class="box-body">
                        <div class="row" style="margin-bottom: 20px">
                            <div class="col-md-4">
                                <div id="message">
                                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                                </div>
                            </div>
                            <div class="col-md-8 text-right">
                                <form action="<?php echo site_url('master_pengunjung/index'); ?>" class="form-inline"
                                    method="get">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="month" class="form-control" name="month"
                                                value="<?php echo $month; ?>" onchange="this.form.submit()">
                                        </div>
                                    </div>

                                    <div class="input-group">
                                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>"
                                            placeholder="Cari data...">
                                        <span class="input-group-btn">
                                            <?php if ($q <> '' || $month <> '') { ?>
                                                <a href="<?php echo site_url('master_pengunjung'); ?>"
                                                    class="btn btn-default">Reset</a>
                                            <?php } ?>
                                            <button class="btn btn-primary" type="submit">Search</button>
                                        </span>
                                    </div>

                                    <div class="btn-group">
                                        <a href="<?php echo site_url('master_pengunjung/excel?month=' . $month); ?>"
                                            class="btn btn-success"><i class="fa fa-file-excel-o"></i> Excel</a>
                                        <a href="<?php echo site_url('master_pengunjung/pdf?month=' . $month); ?>"
                                            class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> PDF</a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" style="margin-bottom: 10px">
                                <thead>
                                    <tr>
                                        <th width="50px">No</th>
                                        <th>Tanggal</th>
                                        <th>Jam</th>
                                        <th>Nama Pengunjung</th>
                                        <th>Institusi</th>
                                        <th>Tipe</th>
                                        <th>Tujuan</th>
                                        <th width="150px" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pengunjung_data as $visit) { ?>
                                        <tr>
                                            <td width="50px"><?php echo ++$start ?></td>
                                            <td><?php echo tgl_indo($visit->visit_date) ?></td>
                                            <td><?php echo $visit->visit_time ?></td>
                                            <td><?php echo $visit->visitor_name ?></td>
                                            <td><?php echo $visit->institution ?></td>
                                            <td>
                                                <span
                                                    class="label <?php echo $visit->membership_type == 'Anggota' ? 'label-success' : ($visit->membership_type == 'Umum' ? 'label-primary' : 'label-default'); ?>">
                                                    <?php echo $visit->membership_type ?>
                                                </span>
                                            </td>
                                            <td><?php echo $visit->room_name ?></td>
                                            <td class="text-center" width="150px">
                                                <?php
                                                echo anchor(site_url('master_pengunjung/read/' . $visit->id), '<i class="fa fa-eye"></i>', 'class="btn btn-info btn-xs"');
                                                echo '&nbsp;';
                                                echo anchor(site_url('master_pengunjung/delete/' . $visit->id), '<i class="fa fa-trash"></i>', 'class="btn btn-danger btn-xs" onclick="javascript: return confirm(\'Are You Sure ?\')"');
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
                            </div>
                            <div class="col-md-6 text-right">
                                <?php echo $pagination ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>