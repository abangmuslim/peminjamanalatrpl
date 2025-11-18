<?php
// =======================================================
// File: includes/konfig.php
// Deskripsi: Variabel global & pengaturan aplikasi Peminjaman Alat RPL
// =======================================================

// Base URL (hanya dibuat jika belum didefinisikan di path.php)
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/peminjamanalatrpl/');
}

$base_url     = BASE_URL;
$site_name    = "Aplikasi Peminjaman Alat RPL";
$site_desc    = "Sistem peminjaman alat laboratorium RPL";
$site_version = "1.0.0";
$penulis      = "Ahmadi Enam";

// Timezone Indonesia
date_default_timezone_set('Asia/Jakarta');

// =======================================================
// Fungsi Helper (mengikuti CMSMAHDI)
// =======================================================

// Generate URL dengan path tambahan
function url($path = '') {
    return BASE_URL . ltrim($path, '/');
}
?>
