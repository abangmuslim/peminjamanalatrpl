<?php
$proses = $_GET['proses'];
include "../koneksi.php";

session_start();

// include "../library/liblogin.php";
// if (ceklogin()) {
//     header("location:login.php");

if ($proses == 'tambah') {
    $namakategori = $_POST['namakategori'];

    mysqli_query($koneksi, "insert INTO kategori SET namakategori='$namakategori'");

} elseif ($proses == 'edit') {
    $namakategori = $_POST['namakategori'];
    $id       = $_POST['idkategori'];

    mysqli_query($koneksi, "UPDATE kategori SET namakategori='$namakategori' WHERE idkategori='$id'");

} elseif ($proses == 'hapus') {
    $id = $_GET['idkategori'];
    mysqli_query($koneksi, "DELETE FROM kategori WHERE idkategori='$id'");
}

header("location:../index.php?halaman=kategori");
// } else {
//     header("location: ../login.php");
// }
?>
