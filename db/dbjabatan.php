<?php
$proses = $_GET['proses'];
include "../koneksi.php";

session_start();

// include "../library/liblogin.php";
// if (ceklogin()) {
//     header("location:login.php");

if ($proses == 'tambah') {
    $namajabatan = $_POST['namajabatan'];

    mysqli_query($koneksi, "insert INTO jabatan SET namajabatan='$namajabatan'");

} elseif ($proses == 'edit') {
    $namajabatan = $_POST['namajabatan'];
    $id       = $_POST['idjabatan'];

    mysqli_query($koneksi, "UPDATE jabatan SET namajabatan='$namajabatan' WHERE idjabatan='$id'");

} elseif ($proses == 'hapus') {
    $id = $_GET['idjabatan'];
    mysqli_query($koneksi, "DELETE FROM jabatan WHERE idjabatan='$id'");
}

header("location:../index.php?halaman=jabatan");
// } else {
//     header("location: ../login.php");
// }
?>
