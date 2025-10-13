<?php
$proses = isset($_GET['proses']) ? $_GET['proses'] : '';
include "../koneksi.php";
session_start();

if ($proses == 'tambah') {

    $namapeminjam  = $_POST['namapeminjam'];
    $username      = $_POST['username'];
    $password      = md5($_POST['password']);
    $idasal        = $_POST['idasal'];

    $foto          = $_FILES['foto']['name'];
    $tmp_foto      = $_FILES['foto']['tmp_name'];

    if (!empty($foto)) {
        $namafilebaru = date('YmdHis') . '_' . $foto;
        move_uploaded_file($tmp_foto, '../foto/' . $namafilebaru);
    } else {
        $namafilebaru = '';
    }

    mysqli_query($koneksi, "INSERT INTO peminjam SET 
        idasal='$idasal',
        namapeminjam='$namapeminjam',
        username='$username',
        password='$password',
        foto='$namafilebaru'
    ");

} elseif ($proses == 'edit') {

    $idpeminjam    = $_POST['idpeminjam'];
    $namapeminjam  = $_POST['namapeminjam'];
    $username      = $_POST['username'];
    $password      = $_POST['password']; // opsional
    $idasal        = $_POST['idasal'];

    $foto          = $_FILES['foto']['name'];
    $tmp_foto      = $_FILES['foto']['tmp_name'];

    // Ambil data lama
    $queryShow  = "SELECT * FROM peminjam WHERE idpeminjam='$idpeminjam'";
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
        mysqli_query($koneksi, "UPDATE peminjam SET 
            idasal='$idasal',
            namapeminjam='$namapeminjam',
            username='$username',
            password='$password',
            foto='$namafilebaru'
            WHERE idpeminjam='$idpeminjam'
        ");
    } else {
        mysqli_query($koneksi, "UPDATE peminjam SET 
            idasal='$idasal',
            namapeminjam='$namapeminjam',
            username='$username',
            foto='$namafilebaru'
            WHERE idpeminjam='$idpeminjam'
        ");
    }

} elseif ($proses == 'hapus') {

    $idpeminjam = $_GET['idpeminjam'];

    // hapus foto lama jika ada
    $queryShow  = "SELECT foto FROM peminjam WHERE idpeminjam='$idpeminjam'";
    $sqlShow    = mysqli_query($koneksi, $queryShow);
    $result     = mysqli_fetch_assoc($sqlShow);

    if (!empty($result['foto']) && file_exists("../foto/" . $result['foto'])) {
        unlink("../foto/" . $result['foto']);
    }

    mysqli_query($koneksi, "DELETE FROM peminjam WHERE idpeminjam='$idpeminjam'");

}

// redirect ke halaman peminjam
header("location:../index.php?halaman=peminjam");
?>
