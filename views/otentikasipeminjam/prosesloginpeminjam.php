<?php
// ==============================================
// File: views/otentikasipeminjam/prosesloginpeminjam.php
// Deskripsi: Proses backend login peminjam (hanya yang disetujui)
// Versi final siap pakai
// ==============================================

$ROOT = realpath(__DIR__ . '/../../') . DIRECTORY_SEPARATOR;
require_once $ROOT . 'includes/konfig.php';
require_once $ROOT . 'includes/koneksi.php';
require_once $ROOT . 'includes/fungsivalidasi.php';

// =======================================
// Mulai session jika belum
// =======================================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// =======================================
// Ambil & bersihkan input
// =======================================
$username = bersihkan($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// =======================================
// Validasi input kosong
// =======================================
if (empty($username) || empty($password)) {
    header("Location: " . BASE_URL . "?hal=loginpeminjam&pesan=" . urlencode("Isi semua kolom"));
    exit;
}

// =======================================
// Query peminjam berdasarkan username
// =======================================
$stmt = $koneksi->prepare("SELECT * FROM peminjam WHERE username = ? LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// =======================================
// Cek hasil query
// =======================================
if ($result->num_rows === 1) {
    $peminjam = $result->fetch_assoc();

    // =======================================
    // Cek password hash
    // =======================================
    if (password_verify($password, $peminjam['password'])) {

        // =======================================
        // Cek status akun
        // =======================================
        if ($peminjam['status'] !== 'disetujui') {
            $pesan = $peminjam['status'] === 'pending'
                ? "Akun Anda masih pending, tunggu persetujuan admin"
                : "Akun Anda ditolak admin";
            header("Location: " . BASE_URL . "?hal=loginpeminjam&pesan=" . urlencode($pesan));
            exit;
        }

        // =======================================
        // Set session peminjam
        // =======================================
        $_SESSION['login']        = true;
        $_SESSION['idpeminjam']   = $peminjam['idpeminjam'];
        $_SESSION['namapeminjam'] = $peminjam['namapeminjam'];
        $_SESSION['username']     = $peminjam['username'];
        $_SESSION['foto']         = $peminjam['foto'] ?? '';
        $_SESSION['role']         = 'peminjam';

        // =======================================
        // Redirect ke dashboard peminjam
        // =======================================
        header("Location: " . BASE_URL . "dashboard.php?hal=dashboardpeminjam");
        exit;
    }
}

// =======================================
// Login gagal (username tidak ditemukan atau password salah)
// =======================================
header("Location: " . BASE_URL . "?hal=loginpeminjam&pesan=" . urlencode("Username atau password salah"));
exit;
