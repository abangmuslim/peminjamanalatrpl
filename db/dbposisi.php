<?php
$proses = $_GET['proses'];
include "../koneksi.php";

session_start();

// include "../library/liblogin.php";
// if (ceklogin()) {
//     header("location:login.php");

if ($proses == 'tambah') {
    $namaposisi = $_POST['namaposisi'];

    mysqli_query($koneksi, "insert INTO posisi SET namaposisi='$namaposisi'");

} elseif ($proses == 'edit') {
    $namaposisi = $_POST['namaposisi'];
    $id       = $_POST['idposisi'];

    mysqli_query($koneksi, "UPDATE posisi SET namaposisi='$namaposisi' WHERE idposisi='$id'");

} elseif ($proses == 'hapus') {
    $id = $_GET['idposisi'];
    mysqli_query($koneksi, "DELETE FROM posisi WHERE idposisi='$id'");
}

header("location:../index.php?halaman=posisi");
// } else {
//     header("location: ../login.php");
// }
?>
