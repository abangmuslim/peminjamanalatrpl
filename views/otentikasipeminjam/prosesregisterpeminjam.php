<?php
// ============================================================
// File: views/otentikasipeminjam/prosesregisterpeminjam.php
// Proses simpan data register peminjam
// ============================================================

$ROOT = realpath(__DIR__ . '/../../') . DIRECTORY_SEPARATOR;
require_once $ROOT . 'includes/koneksi.php';
require_once $ROOT . 'includes/fungsivalidasi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: " . BASE_URL . "?hal=registerpeminjam");
    exit;
}

// Ambil input
$namapeminjam = bersihkan($_POST['namapeminjam'] ?? '');
$username     = bersihkan($_POST['username'] ?? '');
$password     = $_POST['password'] ?? '';
$idasal       = (int) ($_POST['idasal'] ?? 0);
$status       = $_POST['status'] ?? 'pending';

// Validasi sederhana
if (!$namapeminjam || !$username || !$password || !$idasal) {
    header("Location: " . BASE_URL . "?hal=registerpeminjam&pesan=" . urlencode("Isi semua kolom"));
    exit;
}

// Cek username sudah ada?
$stmt = $koneksi->prepare("SELECT * FROM peminjam WHERE username = ? LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
if ($stmt->get_result()->num_rows > 0) {
    header("Location: " . BASE_URL . "?hal=registerpeminjam&pesan=" . urlencode("Username sudah terpakai"));
    exit;
}

// Upload foto (opsional)
$fotoPath = null;
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $fotoTmp = $_FILES['foto']['tmp_name'];
    $fotoName = time() . "_" . basename($_FILES['foto']['name']);
    $target = $ROOT . 'uploads/peminjam/' . $fotoName;
    if (move_uploaded_file($fotoTmp, $target)) {
        $fotoPath = $fotoName;
    }
}

// Insert ke DB
$stmt = $koneksi->prepare("INSERT INTO peminjam (idasal, namapeminjam, username, password, foto, status) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssss", $idasal, $namapeminjam, $username, $password, $fotoPath, $status);
if ($stmt->execute()) {
    header("Location: " . BASE_URL . "?hal=loginpeminjam&pesan=" . urlencode("Registrasi berhasil, menunggu persetujuan"));
    exit;
} else {
    header("Location: " . BASE_URL . "?hal=registerpeminjam&pesan=" . urlencode("Gagal registrasi, coba lagi"));
    exit;
}
