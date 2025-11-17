<?php
// ===============================================
// File: index.php (root)
// Deskripsi: Routing utama untuk tampilan publik aplikasi peminjaman alat
// ===============================================

// Load path, konfigurasi, dan koneksi
require_once __DIR__ . '/includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';

// Mulai sesi untuk kebutuhan login peminjam
session_start();

// Ambil parameter 'hal' dari URL (misal: ?hal=kategori)
$halaman = isset($_GET['hal']) ? trim($_GET['hal']) : 'home';

// Bersihkan nama file dari karakter berbahaya
$halaman = basename(str_replace('.php', '', $halaman));

// Tentukan file konten view berdasarkan parameter
switch ($halaman) {

    case '':
    case 'home':
        $file_view = VIEWS_PATH . 'landing/home.php';
        break;

    case 'kategori':
        $file_view = VIEWS_PATH . 'landing/kategori.php';
        break;

    case 'detilalat':
        $file_view = VIEWS_PATH . 'landing/detilalat.php';
        break;

    case 'tentang':
        $file_view = VIEWS_PATH . 'landing/tentang.php';
        break;

    case 'kontak':
        $file_view = VIEWS_PATH . 'landing/kontak.php';
        break;

    // 🔓 Halaman login untuk peminjam/publik
    case 'login':
        $file_view = VIEWS_PATH . 'otentikasipeminjam/login.php';
        break;

    // Jika halaman tidak ditemukan
    default:
        $file_view = VIEWS_PATH . 'landing/404.php';
        break;
}

// ===============================================
// TEMPLATE LANDING
// header + navbar + content + footer
// ===============================================
include PAGES_PATH . 'landing/header.php';
include PAGES_PATH . 'landing/navbar.php';

// Muat konten jika file ada
if (file_exists($file_view)) {
    include $file_view;
} else {
    include VIEWS_PATH . 'landing/404.php';
}

include PAGES_PATH . 'landing/footer.php';
