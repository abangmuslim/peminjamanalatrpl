<?php
// ======================================================================
// File: views/user/dashboarduser.php
// Deskripsi: Dashboard gabungan semua role (admin, petugas, peminjam)
// ======================================================================

require_once '../../includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';

// Pastikan role terdefinisi
$role = $_SESSION['role'] ?? '';

// Title halaman
$title_page = "Dashboard " . ucfirst($role);

// Include template header + navbar
include PAGES_PATH . 'user/header.php';
include PAGES_PATH . 'user/navbar.php';
?>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <h3 class="mb-0"><?= $title_page ?></h3>
            <small>Selamat datang, <b><?= htmlspecialchars($_SESSION['username']) ?></b></small>
            <hr>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <?php if ($role === 'admin'): ?>
                <!-- DASHBOARD ADMIN -->
                <div class="alert alert-primary">
                    <h5><i class="fas fa-user-shield"></i> Admin Panel</h5>
                    Anda memiliki akses penuh untuk mengelola data user, alat, kategori, peminjaman, dll.
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="small-box bg-info text-white">
                            <div class="inner">
                                <h3>Manajemen Alat</h3>
                                <p>Mengelola seluruh data alat</p>
                            </div>
                            <a href="<?= BASE_URL ?>?hal=alat" class="small-box-footer">Masuk <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="small-box bg-success text-white">
                            <div class="inner">
                                <h3>Peminjaman</h3>
                                <p>Proses dan pantau transaksi peminjaman</p>
                            </div>
                            <a href="<?= BASE_URL ?>?hal=peminjaman" class="small-box-footer">Masuk <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>

            <?php elseif ($role === 'petugas'): ?>
                <!-- DASHBOARD PETUGAS -->
                <div class="alert alert-success">
                    <h5><i class="fas fa-user-cog"></i> Petugas Panel</h5>
                    Anda bertugas mengelola peminjaman alat & pengembalian.
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>Peminjaman</h3>
                                <p>Kelola peminjaman alat</p>
                            </div>
                            <a href="<?= BASE_URL ?>?hal=peminjaman" class="small-box-footer">Masuk <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>

            <?php else: ?>
                <!-- DASHBOARD PEMINJAM -->
                <div class="alert alert-info">
                    <h5><i class="fas fa-user"></i> Dashboard Peminjam</h5>
                    Selamat datang di sistem peminjaman alat RPL.
                </div>

                <div class="row">

                    <div class="col-md-4">
                        <div class="small-box bg-primary text-white">
                            <div class="inner">
                                <h3>Cari Alat</h3>
                                <p>Lihat daftar alat yang tersedia</p>
                            </div>
                            <a href="<?= BASE_URL ?>?hal=kategori" class="small-box-footer">Lihat Alat <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="small-box bg-success text-white">
                            <div class="inner">
                                <h3>Peminjaman Saya</h3>
                                <p>Lihat status peminjaman</p>
                            </div>
                            <a href="<?= BASE_URL ?>?hal=riwayatpeminjam" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                </div>
            <?php endif; ?>

        </div>
    </section>

</div>

<?php include PAGES_PATH . 'user/footer.php'; ?>
