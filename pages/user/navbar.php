<?php
// ===============================================
// NAVBAR UTAMA (Front Office)
// Menu publik: Home, Kategori, Tentang, Kontak, Login
// ===============================================
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= $base_url ?>">CMSMAHDI</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarLanding">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarLanding">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="<?= $base_url ?>" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="<?= $base_url ?>/?page=kategori" class="nav-link">Kategori</a></li>
                <li class="nav-item"><a href="<?= $base_url ?>/?page=tentang" class="nav-link">Tentang</a></li>
                <li class="nav-item"><a href="<?= $base_url ?>/?page=kontak" class="nav-link">Kontak</a></li>
                <li class="nav-item"><a href="<?= $base_url ?>/?page=login" class="nav-link">Login</a></li>
            </ul>
        </div>
    </div>
</nav>
