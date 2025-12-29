<div class="content-wrapper">
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">DETAIL PROFIL APLIKASI</h3>
            </div>

            <div class="box-body">
                <table class="table">
                    <tr>
                        <td>Nama Apps</td>
                        <td><?php echo $nama_apps; ?></td>
                    </tr>
                    <tr>
                        <td>Judul</td>
                        <td><?php echo $judul; ?></td>
                    </tr>
                    <tr>
                        <td>Logo</td>
                        <td><img src="<?php echo base_url('assets/foto_profil/' . $logo); ?>" width="100px"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><a href="<?php echo site_url('profile') ?>" class="btn btn-default">Kembali</a></td>
                    </tr>
                </table>
            </div>
        </div>
    </section>
</div>