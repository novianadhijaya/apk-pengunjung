<div class="content-wrapper">
	    <section class="content">
	        <div class="row">
	            <div class="col-xs-12">
	                <?php echo alert('alert-info', 'Perhatian', 'Silahkan Cheklist Pada Menu Yang Akan Diberikan Akses') ?>
	                <style>
	                    #akses-notif-modal .modal-dialog {
	                        position: fixed;
	                        top: 50%;
	                        left: 50%;
	                        transform: translate(-50%, -50%);
	                        margin: 0;
	                        width: 92%;
	                        max-width: 420px;
	                    }

	                    #akses-notif-modal .modal-header {
	                        border-bottom: 0;
	                    }

	                    #akses-notif-modal .modal-body {
	                        padding-top: 0;
	                    }

	                    #akses-notif-modal.akses-modal-success .modal-header {
	                        background: #00a65a;
	                        color: #fff;
	                        border-radius: 4px 4px 0 0;
	                    }

	                    #akses-notif-modal.akses-modal-danger .modal-header {
	                        background: #dd4b39;
	                        color: #fff;
	                        border-radius: 4px 4px 0 0;
	                    }
	                </style>

	                <div class="modal fade" id="akses-notif-modal" tabindex="-1" role="dialog" aria-labelledby="aksesNotifTitle">
	                    <div class="modal-dialog" role="document">
	                        <div class="modal-content">
	                            <div class="modal-header">
	                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                                <h4 class="modal-title" id="aksesNotifTitle">Notifikasi</h4>
	                            </div>
	                            <div class="modal-body" id="akses-notif-message">...</div>
	                        </div>
	                    </div>
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
	        var $modal = $('#akses-notif-modal');
	        var $message = $('#akses-notif-message');

	        $modal.removeClass('akses-modal-success akses-modal-danger');
	        if (type === 'danger' || type === 'error') {
	            $modal.addClass('akses-modal-danger');
	            $('#aksesNotifTitle').text('Gagal');
	        } else {
	            $modal.addClass('akses-modal-success');
	            $('#aksesNotifTitle').text('Berhasil');
	        }
	        $message.html(message || 'Berhasil simpan perubahan.');

	        $modal.modal({backdrop: true, keyboard: true, show: true});

	        if (aksesNotifTimer) {
	            clearTimeout(aksesNotifTimer);
	        }
	        aksesNotifTimer = setTimeout(function () {
	            $modal.modal('hide');
	        }, 120000);
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
	                showAksesNotif('Berhasil simpan perubahan.', 'success');
	            },
	            error: function () {
	                showAksesNotif('Gagal simpan perubahan. Coba lagi.', 'danger');
	            }
	        });
	    }    
	</script>
