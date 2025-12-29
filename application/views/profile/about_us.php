<style>
    .profile-page {
        background: #f4f7fb;
    }

    .profile-header__inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    .profile-title {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        color: #1f2d3d;
    }

    .profile-subtitle {
        margin: 4px 0 0;
        color: #6b7c89;
    }

    .profile-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 14px;
        border-radius: 999px;
        background: #ffffff;
        border: 1px solid #dfe7f0;
        color: #1f644d;
        font-weight: 600;
        font-size: 12px;
        letter-spacing: 0.3px;
    }

    .profile-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e3ebf3;
        box-shadow: 0 12px 24px rgba(21, 43, 66, 0.08);
        padding: 24px;
        position: relative;
        overflow: hidden;
    }

    .profile-card::before {
        content: "";
        position: absolute;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: rgba(42, 127, 98, 0.08);
        top: -40px;
        right: -40px;
    }

    .profile-card__header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 16px;
        position: relative;
        z-index: 1;
    }

    .profile-logo {
        width: 78px;
        height: 78px;
        border-radius: 18px;
        background: #f4f7fb;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e3ebf3;
    }

    .profile-logo img {
        max-width: 60px;
        max-height: 60px;
        object-fit: contain;
    }

    .profile-logo__placeholder {
        font-size: 28px;
        color: #2a7f62;
    }

    .profile-name {
        font-size: 18px;
        font-weight: 700;
        color: #1f2d3d;
        margin: 0;
    }

    .profile-tagline {
        color: #6b7c89;
        margin: 4px 0 0;
    }

    .profile-desc {
        color: #4d5b67;
        line-height: 1.6;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    .profile-info-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e3ebf3;
        box-shadow: 0 10px 20px rgba(21, 43, 66, 0.06);
        padding: 18px 20px;
        display: flex;
        gap: 14px;
        align-items: flex-start;
        margin-bottom: 16px;
    }

    .profile-info-card__icon {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex: 0 0 auto;
    }

    .profile-info-card--teal .profile-info-card__icon {
        background: rgba(42, 127, 98, 0.16);
        color: #1f644d;
    }

    .profile-info-card--amber .profile-info-card__icon {
        background: rgba(255, 176, 87, 0.22);
        color: #b96500;
    }

    .profile-info-card--navy .profile-info-card__icon {
        background: rgba(33, 96, 150, 0.16);
        color: #1a4a73;
    }

    .profile-info-card h3 {
        margin: 0 0 6px;
        font-size: 16px;
        font-weight: 600;
        color: #1f2d3d;
    }

    .profile-info-card p {
        margin: 0;
        color: #4d5b67;
        line-height: 1.6;
    }

    @media (max-width: 991px) {
        .profile-card {
            margin-bottom: 18px;
        }
    }
</style>

<div class="content-wrapper profile-page">
    <section class="content-header profile-header">
        <div class="profile-header__inner">
            <div>
                <h1 class="profile-title">About Us</h1>
                <p class="profile-subtitle">Informasi aplikasi</p>
            </div>
            <div class="profile-badge">
                <i class="fa fa-leaf" aria-hidden="true"></i>
                Profil Aplikasi
            </div>
        </div>
    </section>

    <section class="content profile-content">
        <div class="row">
            <div class="col-md-4">
                <div class="profile-card">
                    <div class="profile-card__header">
                        <div class="profile-logo">
                            <?php if (!empty($app) && !empty($app->logo)): ?>
                                <img src="<?php echo base_url('assets/foto_profil/' . $app->logo); ?>" alt="Logo">
                            <?php else: ?>
                                <div class="profile-logo__placeholder">
                                    <i class="fa fa-book" aria-hidden="true"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div>
                            <div class="profile-name">
                                <?php echo !empty($app->nama_apps) ? $app->nama_apps : 'Aplikasi Prediksi Pengunjung'; ?>
                            </div>
                            <div class="profile-tagline">
                                <?php echo !empty($app->judul) ? $app->judul : 'Prediksi pengunjung perpustakaan'; ?>
                            </div>
                        </div>
                    </div>
                    <p class="profile-desc"><?php echo $info_aplikasi; ?></p>
                </div>
            </div>

            <div class="col-md-8">
                <div class="profile-info-card profile-info-card--teal">
                    <div class="profile-info-card__icon">
                        <i class="fa fa-bullseye" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h3>Tujuan Sistem</h3>
                        <p><?php echo $tujuan_sistem; ?></p>
                    </div>
                </div>

                <div class="profile-info-card profile-info-card--amber">
                    <div class="profile-info-card__icon">
                        <i class="fa fa-cogs" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h3>Metode yang Digunakan</h3>
                        <p><?php echo $metode; ?></p>
                    </div>
                </div>

                <div class="profile-info-card profile-info-card--navy">
                    <div class="profile-info-card__icon">
                        <i class="fa fa-users" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h3>Nama Pengembang / Institusi</h3>
                        <p><?php echo $pengembang; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
