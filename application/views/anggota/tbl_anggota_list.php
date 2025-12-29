<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Kelola Data Anggota</h3>
                        <div class="box-tools pull-right">
                            <?php echo anchor(site_url('anggota/create'), '<i class="fa fa-plus"></i> Tambah Anggota', 'class="btn btn-primary btn-sm"'); ?>
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="row" style="margin-bottom: 20px">
                            <div class="col-md-4">
                                <div id="message">
                                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <!-- Optional: Center content or Spacer -->
                            </div>
                            <div class="col-md-4 text-right">
                                <form action="<?php echo site_url('anggota/index'); ?>" class="form-inline"
                                    method="get">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>"
                                            placeholder="Cari data...">
                                        <span class="input-group-btn">
                                            <?php if ($q <> '') { ?>
                                                <a href="<?php echo site_url('anggota'); ?>"
                                                    class="btn btn-default">Reset</a>
                                            <?php } ?>
                                            <button class="btn btn-primary" type="submit">Search</button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" style="margin-bottom: 10px">
                                <thead>
                                    <tr>
                                        <th width="50px">No</th>
                                        <th>Kode Anggota</th>
                                        <th>Nama Anggota</th>
                                        <th>Institusi</th>
                                        <th>No Telp</th>
                                        <th>Alamat</th>
                                        <th width="200px" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($anggota_data as $anggota) { ?>
                                        <tr>
                                            <td width="50px"><?php echo ++$start ?></td>
                                            <td><?php echo $anggota->kode_anggota ?></td>
                                            <td><?php echo $anggota->nama_anggota ?></td>
                                            <td><?php echo $anggota->institusi ?></td>
                                            <td><?php echo $anggota->no_telp ?></td>
                                            <td><?php echo $anggota->alamat ?></td>
                                            <td class="text-center" width="200px">
                                                <?php
                                                echo anchor(site_url('anggota/read/' . $anggota->id_anggota), '<i class="fa fa-eye"></i>', 'class="btn btn-info btn-xs"');
                                                echo '&nbsp;';
                                                echo anchor(site_url('anggota/update/' . $anggota->id_anggota), '<i class="fa fa-pencil"></i>', 'class="btn btn-warning btn-xs"');
                                                echo '&nbsp;';
                                                echo anchor(site_url('anggota/delete/' . $anggota->id_anggota), '<i class="fa fa-trash"></i>', 'class="btn btn-danger btn-xs" onclick="javascript: return confirm(\'Are You Sure ?\')"');
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