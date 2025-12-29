<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Akses Ditolak | <?php echo getInfoRS('nama_apps') ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet"
        href="<?php echo base_url(); ?>assets/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="<?php echo base_url(); ?>assets/adminlte/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">
    <style>
        :root {
            --primary: #1b6cc5;
            --dark: #0f2847;
            --danger: #dc3545;
        }

        body {
            min-height: 100vh;
            margin: 0;
            background: radial-gradient(circle at 20% 20%, rgba(220, 53, 69, 0.15), transparent 30%),
                radial-gradient(circle at 80% 0%, rgba(15, 40, 71, 0.25), transparent 35%),
                linear-gradient(120deg, #0f2847 0%, #123a64 40%, #0f2847 100%);
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .error-container {
            text-align: center;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 50px;
            border-radius: 24px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .error-icon {
            font-size: 80px;
            color: var(--danger);
            margin-bottom: 20px;
            text-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
        }

        h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        h3 {
            font-size: 18px;
            font-weight: 500;
            color: #aebfd6;
            margin-bottom: 30px;
        }

        p {
            color: #8da2bf;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .btn-home {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #1b6cc5, #1557a0);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 10px 20px -5px rgba(27, 108, 197, 0.4);
        }

        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px -5px rgba(27, 108, 197, 0.5);
            color: white;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.3);
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="error-icon">
            <i class="fa fa-ban"></i>
        </div>
        <h1>Akses Ditolak</h1>
        <h3>403 Access Denied</h3>
        <p>
            Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.<br>
            Silakan hubungi Administrator jika Anda yakin ini adalah kesalahan.
        </p>
            <a href="<?php echo site_url('auth') ?>" class="btn-home">
                <i class="fa fa-dashboard"></i> Ke Dashboard
            </a>

        <div class="footer">
            <?php echo date('Y'); ?> &copy; <?php echo getInfoRS('nama_apps'); ?>
        </div>
    </div>
</body>

</html>