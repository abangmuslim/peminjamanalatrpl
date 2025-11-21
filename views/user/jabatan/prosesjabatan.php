<?php
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';

$db = $koneksi;
$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';

//
// ===================== TAMBAH JABATAN =====================
//
if ($aksi === 'tambah') {
    $nama = htmlspecialchars($_POST['namajabatan']);

    $stmt = $db->prepare("INSERT INTO jabatan(namajabatan) VALUES (?)");
    $stmt->bind_param("s", $nama);
    $stmt->execute();

    header("Location: ../../../dashboard.php?hal=jabatan/daftarjabatan&msg=sukses_tambah");
    exit;
}

//
// ===================== EDIT JABATAN =====================
//
if ($aksi === 'edit') {
    $id  = $_POST['idjabatan'];
    $nama = htmlspecialchars($_POST['namajabatan']);

    $stmt = $db->prepare("UPDATE jabatan SET namajabatan=? WHERE idjabatan=?");
    $stmt->bind_param("si", $nama, $id);
    $stmt->execute();

    header("Location: ../../../dashboard.php?hal=jabatan/daftarjabatan&msg=sukses_edit");
    exit;
}

//
// ===================== HAPUS JABATAN =====================
//
if ($aksi === 'hapus') {
    $id = $_GET['id'];

    $stmt = $db->prepare("DELETE FROM jabatan WHERE idjabatan=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: ../../../dashboard.php?hal=jabatan/daftarjabatan&msg=sukses_hapus");
    exit;
}
?>
