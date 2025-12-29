<div class="content-wrapper">
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $button ?> Data Anggota</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="varchar">Kode Anggota <?php echo form_error('kode_anggota') ?></label>
                        <input type="text" class="form-control" name="kode_anggota" id="kode_anggota"
                            placeholder="Kode Anggota" value="<?php echo $kode_anggota; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="varchar">Nama Anggota <?php echo form_error('nama_anggota') ?></label>
                        <input type="text" class="form-control" name="nama_anggota" id="nama_anggota"
                            placeholder="Nama Anggota" value="<?php echo $nama_anggota; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="varchar">Institusi <?php echo form_error('institusi') ?></label>
                        <input type="text" class="form-control" name="institusi" id="institusi" placeholder="Institusi"
                            value="<?php echo $institusi; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="varchar">No Telp <?php echo form_error('no_telp') ?></label>
                        <input type="text" class="form-control" name="no_telp" id="no_telp" placeholder="No Telp"
                            value="<?php echo $no_telp; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="text">Alamat <?php echo form_error('alamat') ?></label>
                        <textarea class="form-control" rows="3" name="alamat" id="alamat"
                            placeholder="Alamat"><?php echo $alamat; ?></textarea>
                    </div>
                    <input type="hidden" name="id_anggota" value="<?php echo $id_anggota; ?>" />
                    <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                    <a href="<?php echo site_url('anggota') ?>" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</div>