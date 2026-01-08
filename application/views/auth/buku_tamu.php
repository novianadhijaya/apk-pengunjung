<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Buku Tamu | <?php echo getInfoRS('nama_apps') ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet"
        href="<?php echo base_url(); ?>assets/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="<?php echo base_url(); ?>assets/adminlte/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet"
        href="<?php echo base_url(); ?>assets/adminlte/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/plugins/iCheck/square/blue.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&display=swap">
    <style>
        :root {
            --ink: #0b3d2e;
            --ink-soft: #355348;
            --accent: #2a7f62;
            --accent-dark: #1f644d;
            --cream: #f5f0e6;
            --mint: #e2efe6;
            --panel: #ffffff;
            --stroke: #d4e3d9;
        }

        * {
            font-family: 'Sora', 'Source Sans Pro', system-ui, sans-serif;
        }

	        body {
	            min-height: 100vh;
	            min-height: 100svh;
	            background: radial-gradient(circle at top, #fff2d9 0%, var(--cream) 45%, var(--mint) 100%);
	            display: flex;
	            align-items: center;
	            justify-content: center;
	            padding: 30px 15px;
            position: relative;
            overflow-x: hidden;
        }

        body::before,
        body::after {
            content: "";
            position: fixed;
            border-radius: 50%;
            z-index: 0;
        }

        body::before {
            width: 240px;
            height: 240px;
            background: radial-gradient(circle, rgba(42, 127, 98, 0.28), rgba(42, 127, 98, 0));
            top: -60px;
            right: -60px;
        }

        body::after {
            width: 320px;
            height: 320px;
            background: radial-gradient(circle, rgba(255, 182, 102, 0.3), rgba(255, 182, 102, 0));
            bottom: -120px;
            left: -100px;
        }

        .auth-shell {
            width: 100%;
            max-width: 980px;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(8, 58, 45, 0.12);
            border-radius: 24px;
            box-shadow: 0 24px 60px rgba(17, 52, 41, 0.22);
            overflow: hidden;
            position: relative;
            z-index: 1;
            animation: rise 0.6s ease both;
        }

        .auth-row {
            display: grid;
            grid-template-columns: minmax(260px, 44%) 1fr;
        }

        .auth-visual {
            min-height: 320px;
            background: linear-gradient(155deg, #0b3d2e 0%, #20674d 55%, #2a7f62 100%);
            color: #fef8ee;
            padding: 40px 36px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .auth-visual .tag {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.25);
            letter-spacing: 0.5px;
            font-weight: 600;
            font-size: 12px;
        }

        .auth-visual h1 {
            font-weight: 700;
            margin: 18px 0 10px;
            line-height: 1.2;
            font-size: 30px;
        }

        .auth-visual p {
            opacity: 0.9;
            margin-bottom: 0;
            font-size: 15px;
        }

        .auth-visual::before {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.15);
            top: -80px;
            right: -60px;
        }

        .auth-visual::after {
            content: "";
            position: absolute;
            width: 140px;
            height: 140px;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.08);
            bottom: -40px;
            left: 40px;
            transform: rotate(18deg);
        }

        .auth-highlights {
            list-style: none;
            padding: 0;
            margin: 18px 0 0;
        }

        .auth-highlights li {
            display: flex;
            align-items: center;
            font-size: 13px;
            margin-bottom: 10px;
            opacity: 0.9;
        }

        .auth-highlights li span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 22px;
            height: 22px;
            margin-right: 10px;
            border-radius: 7px;
            background: rgba(255, 255, 255, 0.18);
            font-weight: 700;
            font-size: 12px;
        }

        .auth-form {
            background: var(--panel);
            padding: 38px 36px;
        }

        .brand {
            text-align: center;
            margin-bottom: 24px;
        }

        .brand img {
            width: 92px;
            height: 92px;
            object-fit: contain;
            border-radius: 20px;
            box-shadow: 0 12px 30px rgba(17, 52, 41, 0.18);
            background: #fff;
        }

        .brand .name {
            margin-top: 12px;
            font-size: 21px;
            font-weight: 700;
            color: var(--ink);
        }

        .login-box-msg {
            text-align: center;
            margin-bottom: 20px;
            color: var(--ink-soft);
        }

        .form-control {
            height: 46px;
            border-radius: 12px;
            border: 1px solid var(--stroke);
            box-shadow: none;
        }

        .form-control:focus {
            border-color: rgba(42, 127, 98, 0.6);
            box-shadow: 0 0 0 3px rgba(42, 127, 98, 0.12);
        }

        .input-group-addon {
            border-radius: 12px 0 0 12px;
            background: rgba(42, 127, 98, 0.08);
            color: var(--ink);
            border-color: var(--stroke);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            border: none;
            border-radius: 14px;
            font-weight: 600;
            box-shadow: 0 12px 28px rgba(42, 127, 98, 0.35);
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .btn-success:hover {
            transform: translateY(-1px);
            box-shadow: 0 16px 32px rgba(42, 127, 98, 0.4);
        }

        .auth-tabs {
            display: flex;
            border: 1px solid var(--stroke);
            border-radius: 14px;
            background: #f7fbf8;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .auth-tabs li {
            width: 50%;
            text-align: center;
            margin: 0;
        }

        .auth-tabs li a {
            border: none;
            border-radius: 0;
            font-weight: 600;
            font-size: 15px;
            color: var(--ink-soft);
            padding: 10px 0;
        }

        .auth-tabs li.active a,
        .auth-tabs li a:hover {
            background: #ffffff;
            color: var(--ink);
            border: none;
        }

        .auth-meta {
            margin-top: auto;
            padding-top: 18px;
            font-size: 12px;
            opacity: 0.75;
        }

        .footer-meta {
            margin-top: 18px;
            text-align: center;
            color: #6b7c74;
            font-size: 13px;
        }

        @keyframes rise {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 900px) {
            body {
                padding: 20px 10px;
            }

            .auth-row {
                grid-template-columns: 1fr;
            }

            .auth-visual {
                min-height: 220px;
                padding: 32px;
            }
        }

	        @media (max-width: 560px) {
	            body {
	                align-items: flex-start;
	                padding: 16px 12px;
	            }

	            .auth-form {
	                padding: 30px 24px;
	            }

	            .auth-visual {
	                min-height: initial;
	                padding: 28px 24px;
	            }

	            .auth-visual h1 {
	                font-size: 24px;
	            }

	            .auth-highlights,
	            .auth-meta {
	                display: none;
	            }

	            .brand img {
	                width: 78px;
	                height: 78px;
	            }
	        }
	    </style>
</head>

<body class="hold-transition">
    <?php
    $uploadedLogo = getInfoRS('logo');
    $logoPath = 'assets/foto_profil/' . ($uploadedLogo ? $uploadedLogo : 'logo2.png');
    if ($uploadedLogo && !file_exists(FCPATH . $logoPath)) {
        $logoPath = 'assets/foto_profil/logo2.png';
    }
    ?>

    <div class="auth-shell">
        <div class="auth-row">
            <div class="auth-visual">
                <span class="tag">BUKU TAMU</span>
                <div class="visual-copy">
                    <h1>Selamat Datang<br>Pengunjung</h1>
                    <p>Silahkan isi buku tamu sebelum memasuki area perpustakaan. Terima kasih atas kunjungan Anda.</p>
                </div>
                <ul class="auth-highlights">
                    <li><span>01</span> Check-in cepat dalam hitungan detik</li>
                    <li><span>02</span> Data pengunjung tersimpan rapi</li>
                    <li><span>03</span> Riwayat kunjungan mudah dipantau</li>
                </ul>
                <div class="auth-meta">Perpustakaan Digital v1.0</div>
            </div>
            <div class="auth-form">
                <div class="brand">
                    <img src="<?php echo base_url($logoPath); ?>" alt="Logo">
                    <div class="name">Buku Tamu</div>
                </div>

                <!-- Nav tabs -->
                <ul class="nav auth-tabs">
                    <li role="presentation">
                        <a href="<?php echo site_url('auth'); ?>">Login Admin</a>
                    </li>
                    <li role="presentation" class="active">
                        <a href="#">Buku Tamu</a>
                    </li>
                </ul>

                <p class="login-box-msg">Check-in Pengunjung</p>

                <?php echo form_open('bukutamu/checkin'); ?>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control" name="visitor_name" placeholder="Nama Lengkap" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-building"></i></span>
                        <input type="text" class="form-control" name="institution" placeholder="Institusi / Asal"
                            required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                        <input type="text" class="form-control" name="member_id" placeholder="ID Anggota (Opsional)">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                        <select class="form-control" name="room_name">
                            <option value="">-- Pilih Tujuan / Ruangan --</option>
                            <?php if (isset($ruangan_list)): ?>
                                <?php foreach ($ruangan_list as $r): ?>
                                    <option value="<?php echo $r->nama_ruangan; ?>"><?php echo $r->nama_ruangan; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div style="margin-top: 10px;">
                         <input type="text" class="form-control" name="room_name_custom" placeholder="Atau ketik Tujuan / Ruangan lainnya (Opsional)">
                    </div>
                </div>
                <button type="submit" class="btn btn-success btn-block btn-lg"><i class="fa fa-check-circle"></i> Check
                    In</button>
                <?php echo form_close(); ?>

                <div class="footer-meta">
                    © <?php echo date('Y'); ?> <?php echo getInfoRS('nama_apps'); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery 3 -->
    <script src="<?php echo base_url(); ?>assets/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script
        src="<?php echo base_url(); ?>/assets/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        <?php if ($this->session->flashdata('status_login')): ?>
            Swal.fire({
                title: 'Info',
                text: '<?php echo $this->session->flashdata("status_login"); ?>',
                icon: '<?php echo strpos($this->session->flashdata("status_login"), "Error") !== false ? "error" : "success"; ?>',
                confirmButtonText: 'OK',
                confirmButtonColor: '#2a7f62'
            });
        <?php endif; ?>
    </script>
</body>

</html>
