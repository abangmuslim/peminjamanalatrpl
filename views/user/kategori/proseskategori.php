<?php
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';

$aksi = $_POST['aksi'] ?? '';

if ($aksi === 'tambah') {

    $namakategori = trim($_POST['namakategori']);
    if ($namakategori === '') {
        header("Location: " . BASE_URL . "dashboard.php?hal=kategori/daftarkategori&msg=empty");
        exit;
    }

    $stmt = $koneksi->prepare("INSERT INTO kategori (namakategori) VALUES (?)");
    $stmt->bind_param("s", $namakategori);
    $stmt->execute();

    header("Location: " . BASE_URL . "dashboard.php?hal=kategori/daftarkategori&msg=added");
    exit;

} elseif ($aksi === 'edit') {

    $idkategori   = $_POST['idkategori'];
    $namakategori = trim($_POST['namakategori']);

    $stmt = $koneksi->prepare("UPDATE kategori SET namakategori=? WHERE idkategori=?");
    $stmt->bind_param("si", $namakategori, $idkategori);
    $stmt->execute();

    header("Location: " . BASE_URL . "dashboard.php?hal=kategori/daftarkategori&msg=updated");
    exit;

} elseif (isset($_GET['hapus'])) {

    $id = $_GET['hapus'];

    $stmt = $koneksi->prepare("DELETE FROM kategori WHERE idkategori=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: " . BASE_URL . "dashboard.php?hal=kategori/daftarkategori&msg=deleted");
    exit;

} else {
    header("Location: " . BASE_URL . "dashboard.php?hal=kategori/daftarkategori&msg=invalid");
    exit;
}
