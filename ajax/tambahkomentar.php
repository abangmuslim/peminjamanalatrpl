<?php
include __DIR__ . '/../includes/koneksi.php';
include __DIR__ . '/../includes/fungsivalidasi.php';

header('Content-Type: application/json');

$id = intval($_POST['idalat'] ?? 0);
$namakomentar = bersihkan($_POST['namakomentar'] ?? '');
$email = bersihkan($_POST['email'] ?? '');
$isikomentar = bersihkan($_POST['isikomentar'] ?? '');

$errors = [];
if (!wajib($namakomentar)) $errors[] = "Nama wajib diisi.";
if (!wajib($email) || !valid_email($email)) $errors[] = "Email tidak valid.";
if (!wajib($isikomentar)) $errors[] = "Komentar wajib diisi.";

if (empty($errors)) {
    $stmt = $koneksi->prepare("
        INSERT INTO komentar (idalat, namakomentar, email, isikomentar, status)
        VALUES (?, ?, ?, ?, 'tampil')
    ");
    $stmt->bind_param('isss', $id, $namakomentar, $email, $isikomentar);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Komentar berhasil ditambahkan!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan komentar.']);
    }
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => implode('<br>', $errors)]);
}
