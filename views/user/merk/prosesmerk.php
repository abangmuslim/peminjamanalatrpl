<?php
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';

$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';

/* ===========================
   A K S I   T A M B A H
=========================== */
if ($aksi === "tambah") {
    $namamerk = trim($_POST['namamerk']);

    $stmt = $koneksi->prepare("INSERT INTO merk (namamerk) VALUES (?)");
    $stmt->bind_param("s", $namamerk);
    $stmt->execute();

    header("Location: " . BASE_URL . "dashboard.php?hal=merk/daftarmerk&msg=added");
    exit;
}

/* ===========================
   A K S I   E D I T
=========================== */
if ($aksi === "edit") {
    $idmerk   = $_POST['idmerk'];
    $namamerk = trim($_POST['namamerk']);

    $stmt = $koneksi->prepare("UPDATE merk SET namamerk = ? WHERE idmerk = ?");
    $stmt->bind_param("si", $namamerk, $idmerk);
    $stmt->execute();

    header("Location: " . BASE_URL . "dashboard.php?hal=merk/daftarmerk&msg=updated");
    exit;
}

/* ===========================
   A K S I   H A P U S
=========================== */
if ($aksi === "hapus") {
    $id = $_GET['id'];

    $stmt = $koneksi->prepare("DELETE FROM merk WHERE idmerk = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: " . BASE_URL . "dashboard.php?hal=merk/daftarmerk&msg=deleted");
    exit;
}

header("Location: " . BASE_URL . "dashboard.php?hal=merk/daftarmerk");
exit;
