<?php
// ============================================================
// File: includes/ceksession.php
// Deskripsi: Mengecek session login untuk backend admin/petugas
// ============================================================

// Pastikan session sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ============================================================
// 1. Cek apakah user sudah login
// ============================================================
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // Belum login → redirect ke halaman login user
    header("Location: " . BASE_URL . "?hal=loginuser");
    exit;
}

// ============================================================
// 2. Cek role, hanya admin & petugas yang boleh akses backend
// ============================================================
$role = $_SESSION['role'] ?? null;

if (!in_array($role, ['admin', 'petugas'])) {
    // Role tidak dikenal → logout paksa
    session_destroy();
    header("Location: " . BASE_URL . "?hal=loginuser");
    exit;
}

// ============================================================
// 3. (Opsional) Set variabel global untuk akses mudah di backend
// ============================================================
$iduser     = $_SESSION['iduser'] ?? null;
$idjabatan  = $_SESSION['idjabatan'] ?? null;
$namauser   = $_SESSION['namauser'] ?? null;
$username   = $_SESSION['username'] ?? null;
$email      = $_SESSION['email'] ?? null;
$foto       = $_SESSION['foto'] ?? null;

// ============================================================
// Backend aman untuk admin/petugas
// ============================================================
