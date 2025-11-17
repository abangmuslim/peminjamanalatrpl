<?php
// ==============================================
// File: views/landing/proseskomentar.php
// Deskripsi: Logika simpan komentar / balasan AJAX
// ==============================================

include __DIR__ . '/../../includes/fungsivalidasi.php';
include __DIR__ . '/../../includes/koneksi.php';

// Response default
$response = ['status' => 'error', 'message' => 'Terjadi kesalahan.'];

// Ambil data dari POST
$idalat    = intval($_POST['idalat'] ?? 0);
$idparent  = intval($_POST['idparent'] ?? 0); // 0 artinya top-level
$nama      = bersihkan($_POST['namakomentar'] ?? '');
$email     = bersihkan($_POST['email'] ?? '');
$komentar  = bersihkan($_POST['isikomentar'] ?? '');

// Validasi sederhana
if ($idalat <= 0) {
    $response['message'] = 'Alat tidak valid.';
    echo json_encode($response);
    exit;
}
if (!wajib($nama)) {
    $response['message'] = 'Nama wajib diisi.';
    echo json_encode($response);
    exit;
}
if (!wajib($email) || !valid_email($email)) {
    $response['message'] = 'Email tidak valid.';
    echo json_encode($response);
    exit;
}
if (!wajib($komentar)) {
    $response['message'] = 'Komentar wajib diisi.';
    echo json_encode($response);
    exit;
}

// Simpan ke DB
$stmt = $koneksi->prepare("
    INSERT INTO komentar (idalat, idparent, namakomentar, email, isikomentar, status, tanggalbuat)
    VALUES (?, ?, ?, ?, ?, 'tampil', NOW())
");

if ($stmt) {
    $stmt->bind_param("iisss", $idalat, $idparent, $nama, $email, $komentar);
    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Komentar berhasil dikirim!';
    } else {
        $response['message'] = 'Gagal menyimpan komentar.';
    }
    $stmt->close();
} else {
    $response['message'] = 'Query gagal disiapkan.';
}

// Kembalikan JSON
header('Content-Type: application/json');
echo json_encode($response);
exit;
