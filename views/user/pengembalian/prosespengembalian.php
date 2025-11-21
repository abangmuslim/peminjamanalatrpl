<?php
// ============================================================
// File: prosespengembalian.php (Final Fix)
// ============================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';

// Validasi request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Error: Akses tidak diperbolehkan.");
}

// Ambil data
$idpeminjaman = $_POST['idpeminjaman'] ?? '';
$detail = $_POST['detail'] ?? [];
$tanggalbayar = $_POST['tanggalbayar'] ?? date('Y-m-d');

if (empty($idpeminjaman) || empty($detail)) {
    die("Error: Data pengembalian tidak lengkap.");
}

// proses update detilpeminjaman
foreach ($detail as $iddetail => $d) {

    $tgl_kembali_input = $_POST['tgl_kembali'][$iddetail] ?? date('Y-m-d');
    $jumlahharitelat = intval($d['jumlahharitelat'] ?? 0);
    $denda = floatval($d['denda'] ?? 0);
    $status = $d['status'] ?? 'tidakterlambat';
    $keterangan = 'sudahkembali';

    // NAMA KOLOM YANG BENAR
    $sql = "
        UPDATE detilpeminjaman 
        SET tanggaldikembalikan = ?, 
            jumlahharitelat = ?, 
            denda = ?, 
            status = ?, 
            keterangan = ?
        WHERE iddetilpeminjaman = ?
    ";

    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("sidssi", 
        $tgl_kembali_input, 
        $jumlahharitelat, 
        $denda, 
        $status, 
        $keterangan, 
        $iddetail
    );
    $stmt->execute();
    $stmt->close();
}

// Redirect berhasil
header("Location: " . BASE_URL . "dashboard.php?hal=pengembalian/daftarpengembalian&status=sukses");
exit;
