<?php
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';
require_once __DIR__ . '/../../../includes/fungsiupload.php';

$db = $koneksi;
$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';

//
// ========== TAMBAH PEMINJAM ==========
if ($aksi === 'tambah') {
    $nama = htmlspecialchars($_POST['namapeminjam']);
    $asal = $_POST['idasal'];
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Upload foto
    $foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== 4) {
        $upload = upload_gambar($_FILES['foto'], 'peminjam');
        if ($upload['status'] === 'success') $foto = $upload['filename'];
    }

    // Set status default 'pending'
    $status = 'pending';

    $stmt = $db->prepare("
        INSERT INTO peminjam(idasal, namapeminjam, username, password, foto, status)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("isssss", $asal, $nama, $username, $password, $foto, $status);
    $stmt->execute();

    header("Location: ../../../dashboard.php?hal=peminjam/daftarpeminjam&msg=sukses_tambah");
    exit;
}

//
// ========== EDIT PEMINJAM ==========
if ($aksi === 'edit') {
    $id = $_POST['idpeminjam'];
    $nama = htmlspecialchars($_POST['namapeminjam']);
    $asal = $_POST['idasal'];
    $username = htmlspecialchars($_POST['username']);

    $password = !empty($_POST['password']) 
        ? password_hash($_POST['password'], PASSWORD_BCRYPT) 
        : null;

    $fotoBaru = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== 4) {
        $upload = upload_gambar($_FILES['foto'], 'peminjam');
        if ($upload['status'] === 'success') {
            $fotoBaru = $upload['filename'];
            $fotoLama = $_POST['fotolama'] ?? '';
            if ($fotoLama && file_exists(__DIR__ . "/../../../uploads/peminjam/$fotoLama")) {
                unlink(__DIR__ . "/../../../uploads/peminjam/$fotoLama");
            }
        }
    }

    $fotoFinal = $fotoBaru ?? $_POST['fotolama'];

    if ($password) {
        $stmt = $db->prepare("
            UPDATE peminjam SET idasal=?, namapeminjam=?, username=?, password=?, foto=?
            WHERE idpeminjam=?
        ");
        $stmt->bind_param("issssi", $asal, $nama, $username, $password, $fotoFinal, $id);
    } else {
        $stmt = $db->prepare("
            UPDATE peminjam SET idasal=?, namapeminjam=?, username=?, foto=?
            WHERE idpeminjam=?
        ");
        $stmt->bind_param("isssi", $asal, $nama, $username, $fotoFinal, $id);
    }
    $stmt->execute();

    header("Location: ../../../dashboard.php?hal=peminjam/daftarpeminjam&msg=sukses_edit");
    exit;
}

//
// ========== HAPUS PEMINJAM ==========
if ($aksi === 'hapus') {
    $id = $_GET['id'];

    $foto = $db->query("SELECT foto FROM peminjam WHERE idpeminjam=$id")->fetch_assoc()['foto'];
    if ($foto && file_exists(__DIR__ . "/../../../uploads/peminjam/$foto")) {
        unlink(__DIR__ . "/../../../uploads/peminjam/$foto");
    }

    $db->query("DELETE FROM peminjam WHERE idpeminjam=$id");

    header("Location: ../../../dashboard.php?hal=peminjam/daftarpeminjam&msg=sukses_hapus");
    exit;
}
?>
