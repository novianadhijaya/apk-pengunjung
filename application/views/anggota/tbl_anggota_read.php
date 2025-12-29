<div class="content-wrapper">
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Detail Data Anggota</h3>
            </div>
            <div class="box-body">
                <table class="table">
                    <tr>
                        <td>Kode Anggota</td>
                        <td><?php echo $kode_anggota; ?></td>
                    </tr>
                    <tr>
                        <td>Nama Anggota</td>
                        <td><?php echo $nama_anggota; ?></td>
                    </tr>
                    <tr>
                        <td>Institusi</td>
                        <td><?php echo $institusi; ?></td>
                    </tr>
                    <tr>
                        <td>No Telp</td>
                        <td><?php echo $no_telp; ?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td><?php echo $alamat; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><a href="<?php echo site_url('anggota') ?>" class="btn btn-default">Kembali</a></td>
                    </tr>
                </table>
            </div>
        </div>
    </section>
</div>