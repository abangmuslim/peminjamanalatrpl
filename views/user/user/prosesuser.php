<?php
// ============================================================
// File: views/user/user/prosesuser.php
// Deskripsi: Proses tambah, edit, hapus user
// ============================================================

require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';
require_once __DIR__ . '/../../../includes/fungsiupload.php';

// Pastikan $db siap untuk prepare
$db = $koneksi;

$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';

//
// ========== AKSI TAMBAH USER ==========
//
if ($aksi === 'tambah') {
    $nama = htmlspecialchars($_POST['namauser']);
    $jabatan = $_POST['idjabatan'];
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    // Upload foto
    $foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== 4) {
        $upload = upload_gambar($_FILES['foto'], 'user');
        if ($upload['status'] === 'success') {
            $foto = $upload['filename'];
        }
    }

    $stmt = $db->prepare("
        INSERT INTO user(idjabatan, namauser, username, email, password, role, foto, tanggalbuat)
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
    ");
    $stmt->bind_param("issssss", $jabatan, $nama, $username, $email, $password, $role, $foto);
    $stmt->execute();

    header("Location: ../../../dashboard.php?hal=user/daftaruser&msg=sukses_tambah");
    exit;
}

//
// ========== AKSI EDIT USER ==========
//
if ($aksi === 'edit') {
    $id = $_POST['iduser'];
    $nama = htmlspecialchars($_POST['namauser']);
    $jabatan = $_POST['idjabatan'];
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $role = $_POST['role'];

    $password = !empty($_POST['password'])
        ? password_hash($_POST['password'], PASSWORD_BCRYPT)
        : null;

    // Upload foto baru
    $fotoBaru = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== 4) {
        $upload = upload_gambar($_FILES['foto'], 'user');
        if ($upload['status'] === 'success') {
            $fotoBaru = $upload['filename'];

            // Hapus foto lama
            $fotoLama = $_POST['fotolama'] ?? '';
            if ($fotoLama && file_exists(__DIR__ . "/../../../uploads/user/$fotoLama")) {
                unlink(__DIR__ . "/../../../uploads/user/$fotoLama");
            }
        }
    }

    $fotoFinal = $fotoBaru ?? $_POST['fotolama'];

    if ($password) {
        $stmt = $db->prepare("
            UPDATE user SET idjabatan=?, namauser=?, username=?, email=?, password=?, role=?, foto=?
            WHERE iduser=?
        ");
        $stmt->bind_param("issssssi", $jabatan, $nama, $username, $email, $password, $role, $fotoFinal, $id);
    } else {
        $stmt = $db->prepare("
            UPDATE user SET idjabatan=?, namauser=?, username=?, email=?, role=?, foto=?
            WHERE iduser=?
        ");
        $stmt->bind_param("isssssi", $jabatan, $nama, $username, $email, $role, $fotoFinal, $id);
    }
    $stmt->execute();

    header("Location: ../../../dashboard.php?hal=user/daftaruser&msg=sukses_edit");
    exit;
}

//
// ========== AKSI HAPUS USER ==========
//
if ($aksi === 'hapus') {
    $id = $_GET['id'];

    // Hapus foto lama
    $foto = $db->query("SELECT foto FROM user WHERE iduser=$id")->fetch_assoc()['foto'];
    if ($foto && file_exists(__DIR__ . "/../../../uploads/user/$foto")) {
        unlink(__DIR__ . "/../../../uploads/user/$foto");
    }

    // Hapus user
    $db->query("DELETE FROM user WHERE iduser=$id");

    header("Location: ../../../dashboard.php?hal=user/daftaruser&msg=sukses_hapus");
    exit;
}
?>
