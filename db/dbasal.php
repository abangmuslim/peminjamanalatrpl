<?php
$proses = $_GET['proses'];
include "../koneksi.php";

session_start();

// include "../library/liblogin.php";
// if (ceklogin()) {
//     header("location:login.php");

if ($proses == 'tambah') {
    $namaasal = $_POST['namaasal'];

    mysqli_query($koneksi, "insert INTO asal SET namaasal='$namaasal'");

} elseif ($proses == 'edit') {
    $namaasal = $_POST['namaasal'];
    $id       = $_POST['idasal'];

    mysqli_query($koneksi, "UPDATE asal SET namaasal='$namaasal' WHERE idasal='$id'");

} elseif ($proses == 'hapus') {
    $id = $_GET['idasal'];
    mysqli_query($koneksi, "DELETE FROM asal WHERE idasal='$id'");
}

header("location:../index.php?halaman=asal");
// } else {
//     header("location: ../login.php");
// }
?>
