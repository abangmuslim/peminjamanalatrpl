<?php
// =======================================
// File: views/otentikasipeminjam/logoutpeminjam.php
// Deskripsi: Logout peminjam & redirect ke halaman login
// =======================================

// Mulai session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load konfigurasi & path
require_once __DIR__ . '/../../includes/path.php';
require_once __DIR__ . '/../../includes/koneksi.php';

// Hapus semua session
$_SESSION = [];
session_destroy();

// Redirect ke halaman login peminjam
header("Location: " . BASE_URL . "?hal=loginpeminjam");
exit;
