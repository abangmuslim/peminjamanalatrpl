<?php
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';
require_once __DIR__ . '/../../../includes/fungsiupload.php';

$db = $koneksi;
$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';

//
// ======================== TAMBAH ALAT ========================
if ($aksi === 'tambah') {

    $idkategori = $_POST['idkategori'];
    $idmerk = $_POST['idmerk'];
    $namaalat = htmlspecialchars($_POST['namaalat']);
    $kondisi = htmlspecialchars($_POST['kondisi']);
    $idposisi = $_POST['idposisi'];
    $tanggalpembelian = $_POST['tanggalpembelian'] ?: null;
    $deskripsi = htmlspecialchars($_POST['deskripsi']);

    // Upload foto
    $foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== 4) {
        $upload = upload_gambar($_FILES['foto'], 'alat');
        if ($upload['status'] === 'success') $foto = $upload['filename'];
    }

    $stmt = $db->prepare("
        INSERT INTO alat(idkategori, idmerk, namaalat, kondisi, idposisi, tanggalpembelian, foto, deskripsi)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("iississs", 
        $idkategori, $idmerk, $namaalat, $kondisi, $idposisi, 
        $tanggalpembelian, $foto, $deskripsi
    );
    $stmt->execute();

    header("Location: ../../../dashboard.php?hal=alat/daftaralat&msg=sukses_tambah");
    exit;
}

//
// ======================== EDIT ALAT ========================
if ($aksi === 'edit') {

    $id = $_POST['idalat'];

    $idkategori = $_POST['idkategori'];
    $idmerk = $_POST['idmerk'];
    $namaalat = htmlspecialchars($_POST['namaalat']);
    $kondisi = htmlspecialchars($_POST['kondisi']);
    $idposisi = $_POST['idposisi'];
    $tanggalpembelian = $_POST['tanggalpembelian'] ?: null;
    $deskripsi = htmlspecialchars($_POST['deskripsi']);

    // Foto baru?
    $fotoBaru = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== 4) {
        $upload = upload_gambar($_FILES['foto'], 'alat');
        if ($upload['status'] === 'success') {
            $fotoBaru = $upload['filename'];

            // Hapus foto lama hanya jika ada
            $fotoLama = $_POST['fotolama'] ?? '';
            if ($fotoLama && file_exists(__DIR__ . "/../../../uploads/alat/$fotoLama")) {
                unlink(__DIR__ . "/../../../uploads/alat/$fotoLama");
            }
        }
    }

    // Jika tidak ada foto baru, tetap pakai foto lama
    $fotoFinal = $fotoBaru ?: ($_POST['fotolama'] ?? null);

    $stmt = $db->prepare("
        UPDATE alat SET 
            idkategori=?, idmerk=?, namaalat=?, kondisi=?, idposisi=?, 
            tanggalpembelian=?, foto=?, deskripsi=?
        WHERE idalat=?
    ");

    $stmt->bind_param("iississsi",
        $idkategori, $idmerk, $namaalat, $kondisi, $idposisi,
        $tanggalpembelian, $fotoFinal, $deskripsi, $id
    );
    $stmt->execute();

    header("Location: ../../../dashboard.php?hal=alat/daftaralat&msg=sukses_edit");
    exit;
}

//
// ======================== HAPUS ALAT ========================
if ($aksi === 'hapus') {
    $id = $_GET['id'];

    // Hapus foto
    $foto = $db->query("SELECT foto FROM alat WHERE idalat=$id")->fetch_assoc()['foto'];
    if ($foto && file_exists(__DIR__ . "/../../../uploads/alat/$foto")) {
        unlink(__DIR__ . "/../../../uploads/alat/$foto");
    }

    $db->query("DELETE FROM alat WHERE idalat=$id");

    header("Location: ../../../dashboard.php?hal=alat/daftaralat&msg=sukses_hapus");
    exit;
}
?>
