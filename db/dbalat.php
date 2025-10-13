<?php
$proses = isset($_GET['proses']) ? $_GET['proses'] : '';
include "../koneksi.php"; // <-- path relatif dari db/ ke root
session_start();

if ($proses == 'tambah') {

    $idkategori        = $_POST['idkategori'];
    $namaalat          = $_POST['namaalat'];
    $kondisi           = $_POST['kondisi'];
    $posisi            = $_POST['posisi'];
    $tanggalpembelian  = $_POST['tanggalpembelian'];

    mysqli_query($koneksi, "INSERT INTO alat SET 
        idkategori='$idkategori',
        namaalat='$namaalat',
        kondisi='$kondisi',
        posisi='$posisi',
        tanggalpembelian='$tanggalpembelian'
    ");

} elseif ($proses == 'edit') {

    $idalat            = $_POST['idalat'];
    $idkategori        = $_POST['idkategori'];
    $namaalat          = $_POST['namaalat'];
    $kondisi           = $_POST['kondisi'];
    $posisi            = $_POST['posisi'];
    $tanggalpembelian  = $_POST['tanggalpembelian'];

    mysqli_query($koneksi, "UPDATE alat SET 
        idkategori='$idkategori',
        namaalat='$namaalat',
        kondisi='$kondisi',
        posisi='$posisi',
        tanggalpembelian='$tanggalpembelian'
        WHERE idalat='$idalat'
    ");

} elseif ($proses == 'hapus') {

    $idalat = $_GET['idalat'];

    mysqli_query($koneksi, "DELETE FROM alat WHERE idalat='$idalat'");

}

// redirect ke halaman alat
header("location:../index.php?halaman=alat");
?>
