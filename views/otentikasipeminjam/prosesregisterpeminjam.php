<?php
// ============================================================
// File: views/otentikasipeminjam/prosesregisterpeminjam.php
// Proses registrasi peminjam baru
// ============================================================

require_once __DIR__ . '/../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: " . BASE_URL . "?hal=registerpeminjam");
    exit;
}

// Ambil input
$namapeminjam = trim($_POST['namapeminjam']);
$username = trim($_POST['username']);
$password = $_POST['password'];
$idasal = $_POST['idasal'] ?: null;

// Validasi username unik
$stmt = $koneksi->prepare("SELECT idpeminjam FROM peminjam WHERE username=? LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    header("Location: " . BASE_URL . "?hal=registerpeminjam&error=Username sudah digunakan");
    exit;
}
$stmt->close();

// Hash password
$hashPassword = password_hash($password, PASSWORD_DEFAULT);

// Proses upload foto
$fotoFile = null;
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $fotoFile = 'peminjam_' . time() . '.' . $ext;
    move_uploaded_file($_FILES['foto']['tmp_name'], __DIR__ . '/../../uploads/peminjam/' . $fotoFile);
}

// Insert ke database
$stmt = $koneksi->prepare("INSERT INTO peminjam (idasal, namapeminjam, username, password, foto, status) VALUES (?, ?, ?, ?, ?, 'pending')");
$stmt->bind_param("issss", $idasal, $namapeminjam, $username, $hashPassword, $fotoFile);
$success = $stmt->execute();
$stmt->close();

if ($success) {
    header("Location: " . BASE_URL . "?hal=loginpeminjam&success=Registrasi berhasil! Silakan login.");
} else {
    header("Location: " . BASE_URL . "?hal=registerpeminjam&error=Terjadi kesalahan, coba lagi.");
}
exit;
