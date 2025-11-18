<?php
// ==============================================
// File: views/otentikasiuser/prosesloginuser.php
// Deskripsi: Proses backend login admin/petugas
// ==============================================

// Session sudah dijalankan di index.php, tidak perlu session_start()

$ROOT = realpath(__DIR__ . '/../../') . DIRECTORY_SEPARATOR;
require_once $ROOT . 'includes/konfig.php';
require_once $ROOT . 'includes/koneksi.php';
require_once $ROOT . 'includes/fungsivalidasi.php';

// Ambil & bersihkan input
$username = bersihkan($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    header("Location: " . BASE_URL . "views/otentikasiuser/login.php?pesan=" . urlencode("Isi semua kolom"));
    exit;
}

// Query user
$stmt = $koneksi->prepare("SELECT * FROM user WHERE username = ? LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        $_SESSION['login']    = true;
        $_SESSION['iduser']   = $user['iduser'];
        $_SESSION['idjabatan']= $user['idjabatan'];
        $_SESSION['namauser'] = $user['namauser'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['foto']     = $user['foto'] ?? '';
        $_SESSION['role']     = $user['role'];

        // Redirect dashboard
        $hal = $user['role'] === 'admin' ? 'dashboardadmin' : 'dashboardpetugas';
        header("Location: " . BASE_URL . "dashboard.php?hal={$hal}");
        exit;
    }
}

// Login gagal
header("Location: " . BASE_URL . "views/otentikasiuser/login.php?pesan=" . urlencode("Username atau password salah"));
exit;
