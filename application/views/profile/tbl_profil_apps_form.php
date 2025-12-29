<style>
    .profile-form {
        background: #f4f7fb;
    }

    .profile-form-card {
        border-radius: 18px;
        border: 1px solid #e3ebf3;
        box-shadow: 0 12px 24px rgba(21, 43, 66, 0.08);
        overflow: hidden;
    }

    .profile-form-card .box-header {
        background: linear-gradient(135deg, #1f644d 0%, #2a7f62 100%);
        color: #ffffff;
        padding: 18px 24px;
        border-bottom: none;
    }

    .profile-form-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .profile-form-title__icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2);
        font-size: 18px;
    }

    .profile-form-subtitle {
        margin: 4px 0 0;
        color: rgba(255, 255, 255, 0.8);
        font-size: 13px;
    }

    .profile-form-card .box-title {
        font-weight: 600;
        letter-spacing: 0.4px;
    }

    .profile-form-card .box-body {
        padding: 24px;
    }

    .profile-form-card .form-control {
        border-radius: 10px;
        border-color: #d7e2db;
        box-shadow: none;
    }

    .profile-form-card .form-control:focus {
        border-color: #2a7f62;
        box-shadow: 0 0 0 3px rgba(42, 127, 98, 0.12);
    }

    .profile-logo-preview {
        display: flex;
        gap: 12px;
        align-items: center;
        padding: 12px;
        border-radius: 12px;
        border: 1px dashed #cfe0d6;
        background: #f6faf7;
        margin-bottom: 12px;
    }

    .profile-logo-preview img {
        width: 72px;
        height: 72px;
        object-fit: contain;
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e6eee8;
        padding: 6px;
    }

    .profile-logo-preview--empty .profile-logo-placeholder {
        width: 72px;
        height: 72px;
        border-radius: 12px;
        background: #ffffff;
        border: 1px solid #e6eee8;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2a7f62;
        font-size: 24px;
    }

    .profile-logo-title {
        font-weight: 600;
        color: #1f2d3d;
    }

    .profile-logo-caption {
        color: #6b7c89;
        font-size: 12px;
    }

    .profile-form-footer {
        padding: 16px 24px;
        background: #f9fbfd;
        border-top: 1px solid #e3ebf3;
    }

    .profile-form-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .profile-form-actions .btn {
        border-radius: 10px;
        padding: 8px 18px;
    }
</style>

<div class="content-wrapper profile-form">
    <section class="content">
        <div class="box profile-form-card">
            <div class="box-header with-border">
                <div class="profile-form-title">
                    <div class="profile-form-title__icon">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h3 class="box-title">FORMULIR PROFIL APLIKASI</h3>
                        <div class="profile-form-subtitle">Perbarui identitas aplikasi dan logo</div>
                    </div>
                </div>
            </div>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="nama_apps">Nama Apps <?php echo form_error('nama_apps') ?></label>
                                <input type="text" class="form-control" name="nama_apps" id="nama_apps"
                                    placeholder="Nama Aplikasi" value="<?php echo $nama_apps; ?>" />
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="logo">Logo <?php echo form_error('logo') ?></label>
                                <?php if ($logo) { ?>
                                    <div class="profile-logo-preview">
                                        <img src="<?php echo base_url('assets/foto_profil/' . $logo); ?>" alt="Current Logo">
                                        <div>
                                            <div class="profile-logo-title">Logo saat ini</div>
                                            <div class="profile-logo-caption">Unggah file baru untuk mengganti logo.</div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="profile-logo-preview profile-logo-preview--empty">
                                        <div class="profile-logo-placeholder">
                                            <i class="fa fa-image" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                            <div class="profile-logo-title">Belum ada logo</div>
                                            <div class="profile-logo-caption">Pilih gambar untuk menambah logo.</div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <input type="file" class="form-control" name="logo" id="logo" />
                                <span class="help-block">Biarkan kosong jika tidak ingin mengubah logo.</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="judul">Judul <?php echo form_error('judul') ?></label>
                        <textarea class="form-control" rows="3" name="judul" id="judul"
                            placeholder="Judul / Deskripsi Singkat"><?php echo $judul; ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="info_aplikasi">Informasi Aplikasi <?php echo form_error('info_aplikasi') ?></label>
                                <textarea class="form-control" rows="4" name="info_aplikasi" id="info_aplikasi"
                                    placeholder="Ringkasan informasi aplikasi"><?php echo $info_aplikasi; ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tujuan_sistem">Tujuan Sistem <?php echo form_error('tujuan_sistem') ?></label>
                                <textarea class="form-control" rows="4" name="tujuan_sistem" id="tujuan_sistem"
                                    placeholder="Tujuan sistem"><?php echo $tujuan_sistem; ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="metode">Metode <?php echo form_error('metode') ?></label>
                                <textarea class="form-control" rows="4" name="metode" id="metode"
                                    placeholder="Metode yang digunakan"><?php echo $metode; ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pengembang">Pengembang / Institusi <?php echo form_error('pengembang') ?></label>
                                <textarea class="form-control" rows="4" name="pengembang" id="pengembang"
                                    placeholder="Nama pengembang atau institusi"><?php echo $pengembang; ?></textarea>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="id" value="<?php echo $id; ?>" />
                </div>

                <div class="box-footer profile-form-footer">
                    <div class="profile-form-actions">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i>
                            <?php echo $button ?></button>
                        <a href="<?php echo site_url('profile') ?>" class="btn btn-default"><i class="fa fa-reply"></i>
                            Kembali</a>
                    </div>
                </div>

            </form>
        </div>
    </section>
</div>
