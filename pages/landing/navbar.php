<?php
// ambil parameter halaman untuk kebutuhan menu aktif
$hal = isset($_GET['hal']) ? $_GET['hal'] : 'home';
?>

<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">

        <!-- Brand -->
        <a href="<?= $base_url ?>" class="navbar-brand">
            <img src="<?= $base_url ?>/assets/img/logo_rpl.png"
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
                    <a href="<?= $base_url ?>/?hal=home"
                       class="nav-link <?= ($hal=='home')?'active':'' ?>">Beranda</a>
                </li>

                <li class="nav-item">
                    <a href="<?= $base_url ?>/?hal=kategori"
                       class="nav-link <?= ($hal=='kategori')?'active':'' ?>">Kategori Alat</a>
                </li>

                <li class="nav-item">
                    <a href="<?= $base_url ?>/?hal=tentang"
                       class="nav-link <?= ($hal=='tentang')?'active':'' ?>">Tentang</a>
                </li>

                <li class="nav-item">
                    <a href="<?= $base_url ?>/?hal=kontak"
                       class="nav-link <?= ($hal=='kontak')?'active':'' ?>">Kontak</a>
                </li>
            </ul>

            <!-- RIGHT MENU -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="<?= $base_url ?>/?hal=login"
                       class="btn btn-primary btn-sm <?= ($hal=='login')?'active':'' ?>">
                       <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                </li>
            </ul>

        </div>
    </div>
</nav>
