<div class="content-wrapper">
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Detail Kunjungan</h3>
            </div>
            <div class="box-body">
                <table class="table">
                    <tr>
                        <td>Tanggal</td>
                        <td><?php echo $visit_date; ?></td>
                    </tr>
                    <tr>
                        <td>Jam</td>
                        <td><?php echo $visit_time; ?></td>
                    </tr>
                    <tr>
                        <td>Nama Pengunjung</td>
                        <td><?php echo $visitor_name; ?></td>
                    </tr>
                    <tr>
                        <td>Institusi</td>
                        <td><?php echo $institution; ?></td>
                    </tr>
                    <tr>
                        <td>Tipe Keanggotaan</td>
                        <td><?php echo $membership_type; ?></td>
                    </tr>
                    <tr>
                        <td>ID Anggota</td>
                        <td><?php echo $member_id; ?></td>
                    </tr>
                    <tr>
                        <td>Tujuan</td>
                        <td><?php echo $room_name; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><a href="<?php echo site_url('master_pengunjung') ?>" class="btn btn-default">Kembali</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </section>
</div>