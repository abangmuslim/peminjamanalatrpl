<?php
// Ambil parameter 'hal' untuk menentukan menu aktif
$hal = isset($_GET['hal']) ? $_GET['hal'] : 'home';
?>

<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">

        <!-- Brand -->
        <a href="<?= BASE_URL ?>" class="navbar-brand">
            <img src="<?= BASE_URL ?>assets/img/logo_rpl.png"
                alt="Logo"
                class="brand-image img-circle elevation-3"
                style="opacity:.9;width:35px;">
            <span class="brand-text font-weight-bold"><?= $site_name ?></span>
        </a>

        <!-- Burger -->
        <button class="navbar-toggler" type="button"
            data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- MENU -->
        <div class="collapse navbar-collapse" id="navbarCollapse">

            <!-- LEFT MENU -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>?hal=home"
                        class="nav-link <?= ($hal == 'home') ? 'active' : '' ?>">
                        Beranda
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>?hal=kategori"
                        class="nav-link <?= ($hal == 'kategori') ? 'active' : '' ?>">
                        Kategori Alat
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>?hal=tentang"
                        class="nav-link <?= ($hal == 'tentang') ? 'active' : '' ?>">
                        Tentang
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>?hal=kontak"
                        class="nav-link <?= ($hal == 'kontak') ? 'active' : '' ?>">
                        Kontak
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>?hal=hashbycrypt"
                        class="nav-link <?= ($hal == 'hashbycrypt') ? 'active' : '' ?>">
                        Hash BCRYPT
                    </a>
                </li>
            </ul>

            <!-- RIGHT MENU -->
            <ul class="navbar-nav ml-auto">

                <!-- LOGIN PEMINJAM -->
                <li class="nav-item mr-2">
                    <a href="<?= BASE_URL ?>?hal=loginpeminjam" class="btn btn-primary btn-sm <?= ($hal == 'loginpeminjam') ? 'active' : '' ?>">
                        <i class="fas fa-user"></i> Login Peminjam
                    </a>
                </li>

                <!-- LOGIN USER -->
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>?hal=loginuser"
                        class="btn btn-danger btn-sm <?= ($hal == 'loginuser') ? 'active' : '' ?>">
                        <i class="fas fa-user-shield"></i> Login User
                    </a>
                </li>

            </ul>

        </div>
    </div>
</nav>
