<?php
$imgFile = (isset($user->images) && $user->images) ? $user->images : 'default.png';
$imgPath = base_url('assets/foto_profil/'.$imgFile);
$levelName = isset($level->nama_level) ? $level->nama_level : '-';
$statusText = ($user->is_aktif === 'y' || $user->is_aktif == 1) ? 'Aktif' : 'Nonaktif';
?>

<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <?php if ($this->session->flashdata('message')): ?>
                    <div class="alert alert-info"><?php echo $this->session->flashdata('message'); ?></div>
                <?php endif; ?>

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Profil Pengguna</h3>
                    </div>
                    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                        <div class="box-body" style="display:flex; gap:20px; align-items:flex-start; flex-wrap:wrap;">
                            <div style="flex:0 0 140px; text-align:center;">
                                <div style="width:120px; height:120px; margin:0 auto 10px; border-radius:50%; overflow:hidden; border:1px solid #eee; background:#f7f7f7;">
                                    <img src="<?php echo $imgPath; ?>" alt="Foto profil" style="width:100%; height:100%; object-fit:cover;">
                                </div>
                                <div class="form-group" style="text-align:left;">
                                    <label>Ganti Foto</label>
                                    <input type="file" name="images" class="form-control" accept=".jpg,.jpeg,.png,.gif">
                                    <small class="text-muted">Opsional. Biarkan kosong jika tidak diganti.</small>
                                </div>
                            </div>
                            <div style="flex:1 1 240px;">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" class="form-control" value="<?php echo $user->full_name; ?>" readonly>
                                    <small class="text-muted">Hubungi admin untuk mengubah nama.</small>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" value="<?php echo $user->email; ?>" readonly>
                                    <small class="text-muted">Hubungi admin untuk mengubah email.</small>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Isi jika ingin mengganti password">
                                    <?php echo form_error('password'); ?>
                                </div>
                                <div class="form-group">
                                    <label>Level</label>
                                    <input type="text" class="form-control" value="<?php echo $levelName; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <input type="text" class="form-control" value="<?php echo $statusText; ?>" readonly>
                                    <small class="text-muted">Status hanya bisa diubah oleh admin.</small>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="<?php echo site_url('welcome'); ?>" class="btn btn-default">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
