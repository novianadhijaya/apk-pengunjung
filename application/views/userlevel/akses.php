<div class="content-wrapper">
	    <section class="content">
	        <div class="row">
	            <div class="col-xs-12">
	                <?php echo alert('alert-info', 'Perhatian', 'Silahkan Cheklist Pada Menu Yang Akan Diberikan Akses') ?>
	                <div id="akses-notif" class="alert alert-success" style="display:none; margin-top:10px;">
	                    <strong>Berhasil</strong> simpan perubahan.
	                </div>
	                <div class="box box-warning box-solid">

                    <div class="box-header">
                        <h3 class="box-title">KELOLA HAK AKSES UNTUK LEVEL :  <b><?php echo $level['nama_level'] ?></b></h3>
                        <a href="<?php echo site_url('userlevel'); ?>" class="btn btn-danger btn-sm pull-right"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>

                    <div class="box-body">
                        <div style="padding-bottom: 10px;">
                            <table class="table table-bordered table-striped" id="mytable">
                                <thead>
                                    <tr>
                                        <th width="30px">No</th>
                                        <th>Nama Modul</th>
                                        <th width="100px">Beri Akses</th>
                                    </tr>
                                    <?php
                                    $no = 1;
                                    foreach ($menu as $m) {
                                        echo "<tr>
                        <td>$no</td>
                        <td>$m->title</td>
                        <td align='center'><input type='checkbox' ".  checked_akses($this->uri->segment(3), $m->id_menu)." onClick='kasi_akses($m->id_menu)'></td>
                        </tr>";
                                        $no++;
                                    }
                                    ?>
                                </thead>
                                <!--<tr><td></td><td colspan="2">
                                        <button type="submit" class="btn btn-danger btn-sm">Simpan Perubahan</button>
                                    </td></tr>-->

                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>

	<script type="text/javascript">
	    var aksesNotifTimer = null;
	    function showAksesNotif(message, type) {
	        var $notif = $('#akses-notif');
	        $notif
	            .removeClass('alert-success alert-danger alert-info alert-warning')
	            .addClass(type || 'alert-success')
	            .html(message || '<strong>Berhasil</strong> simpan perubahan.')
	            .stop(true, true)
	            .fadeIn(150);

	        if (aksesNotifTimer) {
	            clearTimeout(aksesNotifTimer);
	        }
	        aksesNotifTimer = setTimeout(function () {
	            $notif.fadeOut(200);
	        }, 2000);
	    }

	    function kasi_akses(id_menu){
	        //alert(id_menu);
	        var id_menu = id_menu;
	        var level = '<?php echo $this->uri->segment(3); ?>';
	        //alert(level);
	        $.ajax({
	            url:"<?php echo base_url()?>index.php/userlevel/kasi_akses_ajax",
	            data:"id_menu=" + id_menu + "&level="+ level ,
	            success: function(html)
	            { 
	                //load();
	                //alert('sukses');
	                showAksesNotif('<strong>Berhasil</strong> simpan perubahan.', 'alert-success');
	            },
	            error: function () {
	                showAksesNotif('<strong>Gagal</strong> simpan perubahan. Coba lagi.', 'alert-danger');
	            }
	        });
	    }    
	</script>
