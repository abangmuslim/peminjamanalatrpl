<?php
// Sidebar — peminjamanalatrpl

$role = $_SESSION['role'];
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="<?= $base_url ?>?hal=dashboard" class="brand-link">
        <img src="<?= $base_url ?>assets/img/logo_rpl.png"
             alt="Logo"
             class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light"><?= $site_name ?></span>
    </a>

    <div class="sidebar">

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block">
                    <?= $_SESSION['nama'] ?> <br>
                    <small>(<?= ucfirst($role) ?>)</small>
                </a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column">

                <li class="nav-item">
                    <a href="<?= $base_url ?>?hal=dashboard" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <?php if ($role == 'admin'): ?>
                    <li class="nav-item">
                        <a href="<?= $base_url ?>?hal=kelolauser" class="nav-link">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>Kelola User</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= $base_url ?>?hal=kategori" class="nav-link">
                            <i class="nav-icon fas fa-tags"></i>
                            <p>Kelola Kategori</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= $base_url ?>?hal=alat" class="nav-link">
                            <i class="nav-icon fas fa-toolbox"></i>
                            <p>Kelola Alat</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= $base_url ?>?hal=komentar" class="nav-link">
                            <i class="nav-icon fas fa-comments"></i>
                            <p>Komentar</p>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($role == 'petugas'): ?>
                    <li class="nav-item">
                        <a href="<?= $base_url ?>?hal=peminjaman" class="nav-link">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>Peminjaman</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= $base_url ?>?hal=pengembalian" class="nav-link">
                            <i class="nav-icon fas fa-undo-alt"></i>
                            <p>Pengembalian</p>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($role == 'peminjam'): ?>
                    <li class="nav-item">
                        <a href="<?= $base_url ?>?hal=peminjamanuser" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Peminjaman Saya</p>
                        </a>
                    </li>
                <?php endif; ?>

                <li class="nav-item mt-3">
                    <a href="<?= $base_url ?>logout.php" class="nav-link text-danger">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
