<div class="content-wrapper">
	    <section class="content">
	        <div class="row">
	            <div class="col-xs-12">
	                <?php echo alert('alert-info', 'Perhatian', 'Silahkan Cheklist Pada Menu Yang Akan Diberikan Akses') ?>
	                <style>
	                    #akses-notif-modal {
	                        pointer-events: none;
	                    }

	                    #akses-notif-modal .modal-dialog {
	                        position: fixed;
	                        top: 50%;
	                        left: 50%;
	                        transform: translate(-50%, -50%);
	                        margin: 0;
	                        width: 92%;
	                        max-width: 420px;
	                    }

	                    #akses-notif-modal .modal-content {
	                        border: 0;
	                        border-radius: 14px;
	                        box-shadow: 0 18px 55px rgba(0, 0, 0, 0.28);
	                        overflow: hidden;
	                    }

	                    #akses-notif-modal .akses-toast {
	                        display: flex;
	                        gap: 14px;
	                        align-items: center;
	                        padding: 16px 18px;
	                        background: #fff;
	                    }

	                    #akses-notif-modal .akses-toast-icon {
	                        width: 40px;
	                        height: 40px;
	                        border-radius: 12px;
	                        display: inline-flex;
	                        align-items: center;
	                        justify-content: center;
	                        color: #fff;
	                        flex: 0 0 auto;
	                    }

	                    #akses-notif-modal .akses-toast-title {
	                        font-weight: 700;
	                        font-size: 16px;
	                        margin-bottom: 2px;
	                    }

	                    #akses-notif-modal .akses-toast-message {
	                        color: #556;
	                        font-size: 13px;
	                    }

	                    #akses-notif-modal.akses-modal-success .akses-toast-icon {
	                        background: #00a65a;
	                    }

	                    #akses-notif-modal.akses-modal-danger .akses-toast-icon {
	                        background: #dd4b39;
	                    }

	                    #akses-notif-modal.akses-modal-success .akses-toast-title {
	                        color: #0b3d2e;
	                    }

	                    #akses-notif-modal.akses-modal-danger .akses-toast-title {
	                        color: #3d0b0b;
	                    }

	                    .modal-backdrop.akses-notif-backdrop {
	                        display: none !important;
	                    }
	                </style>

	                <div class="modal fade" id="akses-notif-modal" tabindex="-1" role="dialog" aria-hidden="true">
	                    <div class="modal-dialog" role="document">
	                        <div class="modal-content">
	                            <div class="akses-toast">
	                                <div class="akses-toast-icon">
	                                    <i class="fa fa-check" id="akses-notif-icon" aria-hidden="true"></i>
	                                </div>
	                                <div class="akses-toast-text">
	                                    <div class="akses-toast-title" id="aksesNotifTitle">Berhasil</div>
	                                    <div class="akses-toast-message" id="akses-notif-message">...</div>
	                                </div>
	                            </div>
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
	        var $icon = $('#akses-notif-icon');

	        $modal.removeClass('akses-modal-success akses-modal-danger');
	        if (type === 'danger' || type === 'error') {
	            $modal.addClass('akses-modal-danger');
	            $('#aksesNotifTitle').text('Gagal');
	            $icon.removeClass('fa-check').addClass('fa-times');
	        } else {
	            $modal.addClass('akses-modal-success');
	            $('#aksesNotifTitle').text('Berhasil');
	            $icon.removeClass('fa-times').addClass('fa-check');
	        }
	        $message.html(message || 'Berhasil simpan perubahan.');

	        $modal.modal({backdrop: false, keyboard: true, show: true});
	        $('.modal-backdrop').addClass('akses-notif-backdrop');

	        if (aksesNotifTimer) {
	            clearTimeout(aksesNotifTimer);
	        }
	        aksesNotifTimer = setTimeout(function () {
	            $modal.modal('hide');
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
	                showAksesNotif('Berhasil simpan perubahan.', 'success');
	            },
	            error: function () {
	                showAksesNotif('Gagal simpan perubahan. Coba lagi.', 'danger');
	            }
	        });
	    }    
	</script>
