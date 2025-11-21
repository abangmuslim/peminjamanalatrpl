<?php
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';

$aksi = $_POST['aksi'] ?? '';

if ($aksi === 'tambah') {

    $namaasal = trim($_POST['namaasal']);
    if ($namaasal === '') {
        header("Location: " . BASE_URL . "dashboard.php?hal=asal/daftarasal&msg=empty");
        exit;
    }

    $stmt = $koneksi->prepare("INSERT INTO asal (namaasal) VALUES (?)");
    $stmt->bind_param("s", $namaasal);
    $stmt->execute();

    header("Location: " . BASE_URL . "dashboard.php?hal=asal/daftarasal&msg=added");
    exit;

} elseif ($aksi === 'edit') {

    $idasal   = $_POST['idasal'];
    $namaasal = trim($_POST['namaasal']);

    $stmt = $koneksi->prepare("UPDATE asal SET namaasal=? WHERE idasal=?");
    $stmt->bind_param("si", $namaasal, $idasal);
    $stmt->execute();

    header("Location: " . BASE_URL . "dashboard.php?hal=asal/daftarasal&msg=updated");
    exit;

} elseif (isset($_GET['hapus'])) {

    $id = $_GET['hapus'];

    $stmt = $koneksi->prepare("DELETE FROM asal WHERE idasal=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: " . BASE_URL . "dashboard.php?hal=asal/daftarasal&msg=deleted");
    exit;

} else {
    header("Location: " . BASE_URL . "dashboard.php?hal=asal/daftarasal&msg=invalid");
    exit;
}
