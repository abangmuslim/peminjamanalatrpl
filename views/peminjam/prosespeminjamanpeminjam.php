<?php
// ===============================================
// File: views/peminjam/prosespeminjamanpeminjam.php
// Proses backend tambah peminjaman untuk peminjam
// ===============================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'peminjam') {
    header("Location: " . BASE_URL . "?hal=loginpeminjam");
    exit;
}

$ROOT = realpath(__DIR__ . '/../../') . DIRECTORY_SEPARATOR;
require_once $ROOT . 'includes/konfig.php';
require_once $ROOT . 'includes/koneksi.php';
require_once $ROOT . 'includes/fungsivalidasi.php';
require_once $ROOT . 'includes/fungsiupload.php'; // helper final

$idpeminjam     = $_SESSION['idpeminjam'];
$idalat         = bersihkan($_POST['idalat'] ?? '');
$tanggalpinjam  = bersihkan($_POST['tanggalpinjam'] ?? '');
$tanggalkembali = bersihkan($_POST['tanggalkembali'] ?? '');

if (empty($idalat) || empty($tanggalpinjam) || empty($tanggalkembali)) {
    header("Location: " . BASE_URL . "?hal=tambahpeminjaman&pesan=" . urlencode("Semua kolom wajib diisi"));
    exit;
}

// Upload foto opsional
$fotoPath = '';
if (isset($_FILES['foto']) && $_FILES['foto']['name'] !== '') {
    $upload = upload_gambar($_FILES['foto'], 'peminjaman'); // pakai helper final
    if ($upload['status'] === 'error') {
        header("Location: " . BASE_URL . "?hal=tambahpeminjaman&pesan=" . urlencode($upload['pesan']));
        exit;
    }
    $fotoPath = $upload['filename'];
}

// Mulai transaksi DB
$koneksi->begin_transaction();
try {
    // Insert ke tabel peminjaman
    $stmt = $koneksi->prepare("INSERT INTO peminjaman (idpeminjam, foto) VALUES (?, ?)");
    $stmt->bind_param("is", $idpeminjam, $fotoPath);
    $stmt->execute();
    $idpeminjaman = $stmt->insert_id;

    // Insert ke detilpeminjaman
    $stmt2 = $koneksi->prepare("
        INSERT INTO detilpeminjaman 
        (idpeminjaman, idalat, tanggalpinjam, tanggalkembali, keterangan, status)
        VALUES (?, ?, ?, ?, 'belumkembali', 'tidakterlambat')
    ");
    $stmt2->bind_param("iiss", $idpeminjaman, $idalat, $tanggalpinjam, $tanggalkembali);
    $stmt2->execute();

    $koneksi->commit();

    header("Location: " . BASE_URL . "?hal=dashboardpeminjam&pesan=" . urlencode("Peminjaman berhasil diajukan"));
    exit;
} catch (Exception $e) {
    $koneksi->rollback();
    header("Location: " . BASE_URL . "?hal=tambahpeminjaman&pesan=" . urlencode("Gagal menambahkan peminjaman: " . $e->getMessage()));
    exit;
}
