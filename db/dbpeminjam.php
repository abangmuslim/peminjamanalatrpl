<?php
$proses = isset($_GET['proses']) ? $_GET['proses'] : '';
include "../koneksi.php";
session_start();

if ($proses == 'tambah') {

    $namaasal = $_POST['namaasal'];

    mysqli_query($koneksi, "INSERT INTO asal SET 
        namaasal = '$namaasal'
    ");

} elseif ($proses == 'edit') {

    $idasal   = $_POST['idasal'];
    $namaasal = $_POST['namaasal'];

    mysqli_query($koneksi, "UPDATE asal SET 
        namaasal = '$namaasal'
        WHERE idasal = '$idasal'
    ");

} elseif ($proses == 'hapus') {

    $idasal = $_GET['idasal'];

    mysqli_query($koneksi, "DELETE FROM asal WHERE idasal = '$idasal'");
}

// redirect ke halaman asal
header("location:../index.php?halaman=asal");
?>
