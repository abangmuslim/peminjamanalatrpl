<?php
$proses = isset($_GET['proses']) ? $_GET['proses'] : '';
include "../koneksi.php";
session_start();

if ($proses == 'tambah') {

    $namaadmin  = $_POST['namaadmin'];
    $username   = $_POST['username'];
    $password   = md5($_POST['password']);
    $idjabatan  = $_POST['idjabatan'];

    $foto       = $_FILES['foto']['name'];
    $tmp_foto   = $_FILES['foto']['tmp_name'];

    if (!empty($foto)) {
        $namafilebaru = date('YmdHis') . '_' . $foto;
        move_uploaded_file($tmp_foto, '../foto/' . $namafilebaru);
    } else {
        $namafilebaru = '';
    }

    mysqli_query($koneksi, "INSERT INTO admin SET 
        idjabatan='$idjabatan',
        namaadmin='$namaadmin',
        username='$username',
        password='$password',
        foto='$namafilebaru'
    ");

} elseif ($proses == 'edit') {

    $idadmin   = $_POST['idadmin'];
    $namaadmin = $_POST['namaadmin'];
    $username  = $_POST['username'];
    $password  = $_POST['password']; // opsional
    $idjabatan = $_POST['idjabatan'];

    $foto       = $_FILES['foto']['name'];
    $tmp_foto   = $_FILES['foto']['tmp_name'];

    // Ambil data lama
    $queryShow  = "SELECT * FROM admin WHERE idadmin='$idadmin'";
    $sqlShow    = mysqli_query($koneksi, $queryShow);
    $result     = mysqli_fetch_assoc($sqlShow);

    if (!empty($foto)) {
        // hapus foto lama jika ada
        if (!empty($result['foto']) && file_exists("../foto/" . $result['foto'])) {
            unlink("../foto/" . $result['foto']);
        }
        $namafilebaru = date('YmdHis') . '_' . $foto;
        move_uploaded_file($tmp_foto, '../foto/' . $namafilebaru);
    } else {
        $namafilebaru = $result['foto'];
    }

    if (!empty($password)) {
        $password = md5($password);
        mysqli_query($koneksi, "UPDATE admin SET 
            idjabatan='$idjabatan',
            namaadmin='$namaadmin',
            username='$username',
            password='$password',
            foto='$namafilebaru'
            WHERE idadmin='$idadmin'
        ");
    } else {
        mysqli_query($koneksi, "UPDATE admin SET 
            idjabatan='$idjabatan',
            namaadmin='$namaadmin',
            username='$username',
            foto='$namafilebaru'
            WHERE idadmin='$idadmin'
        ");
    }

} elseif ($proses == 'hapus') {

    $idadmin = $_GET['idadmin'];

    // hapus foto lama jika ada
    $queryShow  = "SELECT foto FROM admin WHERE idadmin='$idadmin'";
    $sqlShow    = mysqli_query($koneksi, $queryShow);
    $result     = mysqli_fetch_assoc($sqlShow);

    if (!empty($result['foto']) && file_exists("../foto/" . $result['foto'])) {
        unlink("../foto/" . $result['foto']);
    }

    mysqli_query($koneksi, "DELETE FROM admin WHERE idadmin='$idadmin'");
}

// redirect ke halaman admin
header("location:../index.php?halaman=admin");
?>
