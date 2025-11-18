<?php
// ============================================================
// File: includes/ceksessionpeminjam.php
// Deskripsi: Mengecek session login khusus peminjam
// ============================================================

// Pastikan session sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah peminjam sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || ($_SESSION['role'] ?? '') !== 'peminjam') {
    // Belum login atau bukan peminjam → redirect ke halaman login peminjam
    header("Location: " . BASE_URL . "?hal=loginpeminjam");
    exit;
}

// (Opsional) Set variabel global peminjam
$idpeminjam   = $_SESSION['idpeminjam'] ?? null;
$namapeminjam = $_SESSION['namapeminjam'] ?? null;
$username     = $_SESSION['username'] ?? null;
$foto         = $_SESSION['foto'] ?? null;
$role         = $_SESSION['role'] ?? null;
