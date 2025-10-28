<?php
$proses = $_GET['proses'];
include "../koneksi.php";

session_start();

// include "../library/liblogin.php";
// if (ceklogin()) {
//     header("location:login.php");

if ($proses == 'tambah') {
    $namamerk = $_POST['namamerk'];

    mysqli_query($koneksi, "insert INTO merk SET namamerk='$namamerk'");

} elseif ($proses == 'edit') {
    $namamerk = $_POST['namamerk'];
    $id       = $_POST['idmerk'];

    mysqli_query($koneksi, "UPDATE merk SET namamerk='$namamerk' WHERE idmerk='$id'");

} elseif ($proses == 'hapus') {
    $id = $_GET['idmerk'];
    mysqli_query($koneksi, "DELETE FROM merk WHERE idmerk='$id'");
}

header("location:../index.php?halaman=merk");
// } else {
//     header("location: ../login.php");
// }
?>
