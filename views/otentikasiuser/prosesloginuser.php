<?php
// ============================================================
// File: views/otentikasiuser/proseslogin.php
// Proses backend login aplikasi peminjamanalatrpl
// Struktur mengikuti CMSMAHDI (dengan path safe)
// ============================================================

// Pastikan hanya diakses lewat POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: " . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : BASE_URL . '?hal=login'));
    exit;
}

// Gunakan __DIR__/realpath untuk menemukan root project secara andal
$ROOT = realpath(__DIR__ . '/../../') . DIRECTORY_SEPARATOR;

// include path & libs menggunakan path absolut
require_once $ROOT . 'includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'fungsivalidasi.php';

// Mulai session jika belum
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// =======================================================
// 1. Ambil & bersihkan input
// =======================================================
$username = bersihkan($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// Validasi input wajib
if ($username === '' || $password === '') {
    header("Location: " . BASE_URL . "?hal=login&pesan=" . urlencode("Isi semua kolom"));
    exit;
}

// =======================================================
// 2. Coba login sebagai user (admin/petugas)
// =======================================================
$q_user = $koneksi->prepare("SELECT * FROM user WHERE username = ? LIMIT 1");
if ($q_user) {
    $q_user->bind_param("s", $username);
    $q_user->execute();
    $r_user = $q_user->get_result();

    if ($r_user && $r_user->num_rows === 1) {
        $data = $r_user->fetch_assoc();

        if (password_verify($password, $data['password'])) {
            // Set session untuk admin/petugas
            $_SESSION['login']      = true;
            $_SESSION['iduser']     = $data['iduser'];
            $_SESSION['idjabatan']  = $data['idjabatan'] ?? null;
            $_SESSION['namauser']   = $data['namauser'];
            $_SESSION['username']   = $data['username'];
            $_SESSION['email']      = $data['email'] ?? '';
            $_SESSION['foto']       = $data['foto'] ?? '';
            $_SESSION['role']       = $data['role'];   // admin / petugas

            // Redirect ke dashboard pusat (router dashboard.php akan menampilkan sesuai role)
            header("Location: " . BASE_URL . "dashboard.php");
            exit;
        }
    }

    // tutup statement user
    $q_user->close();
}

// =======================================================
// 3. Coba login sebagai peminjam
// =======================================================
$q_peminjam = $koneksi->prepare("SELECT * FROM peminjam WHERE username = ? LIMIT 1");
if ($q_peminjam) {
    $q_peminjam->bind_param("s", $username);
    $q_peminjam->execute();
    $r_peminjam = $q_peminjam->get_result();

    if ($r_peminjam && $r_peminjam->num_rows === 1) {
        $data = $r_peminjam->fetch_assoc();

        if (password_verify($password, $data['password'])) {
            // Set session untuk peminjam
            $_SESSION['login']       = true;
            $_SESSION['idpeminjam']  = $data['idpeminjam'];
            $_SESSION['idasal']      = $data['idasal'] ?? null;
            $_SESSION['namalengkap'] = $data['namapeminjam'];
            $_SESSION['username']    = $data['username'];
            $_SESSION['foto']        = $data['foto'] ?? '';
            $_SESSION['role']        = "peminjam";

            header("Location: " . BASE_URL . "dashboard.php");
            exit;
        }
    }

    // tutup statement peminjam
    $q_peminjam->close();
}

// =======================================================
// Jika tidak ditemukan / verifikasi gagal
// =======================================================
header("Location: " . BASE_URL . "?hal=login&pesan=" . urlencode("Username atau password salah"));
exit;
