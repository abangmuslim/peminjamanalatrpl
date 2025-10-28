<?php
$proses = isset($_GET['proses']) ? $_GET['proses'] : '';
include "../koneksi.php";
session_start();

// Pastikan folder upload foto tersedia
$folder_foto = "../foto/alat/";
if (!file_exists($folder_foto)) {
    mkdir($folder_foto, 0777, true);
}

if ($proses == 'tambah') {

    $idkategori       = $_POST['idkategori'];
    $idmerk           = $_POST['idmerk'];
    $namaalat         = $_POST['namaalat'];
    $kondisi          = $_POST['kondisi'];
    $idposisi         = $_POST['idposisi'];
    $tanggalpembelian = $_POST['tanggalpembelian'];

    // Proses upload foto (jika ada)
    $foto = "";
    if (!empty($_FILES['foto']['name'])) {
        $foto_name = basename($_FILES['foto']['name']);
        $target_file = $folder_foto . time() . "_" . $foto_name;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
            $foto = basename($target_file);
        }
    }

    mysqli_query($koneksi, "INSERT INTO alat SET 
        idkategori = '$idkategori',
        idmerk = '$idmerk', 
        namaalat = '$namaalat',
        kondisi = '$kondisi',
        idposisi = '$idposisi', 
        tanggalpembelian = '$tanggalpembelian',
        foto = '$foto'
    ");

} elseif ($proses == 'edit') {

    $idalat           = $_POST['idalat'];
    $idkategori       = $_POST['idkategori'];
    $idmerk           = $_POST['idmerk'];
    $namaalat         = $_POST['namaalat'];
    $kondisi          = $_POST['kondisi'];
    $idposisi         = $_POST['idposisi'];
    $tanggalpembelian = $_POST['tanggalpembelian'];

    // Cek foto lama
    $sql_lama = mysqli_query($koneksi, "SELECT foto FROM alat WHERE idalat='$idalat'");
    $data_lama = mysqli_fetch_assoc($sql_lama);
    $foto_lama = $data_lama['foto'];

    // Upload foto baru jika ada
    $foto = $foto_lama;
    if (!empty($_FILES['foto']['name'])) {
        $foto_name = basename($_FILES['foto']['name']);
        $target_file = $folder_foto . time() . "_" . $foto_name;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
            // Hapus foto lama jika ada
            if ($foto_lama && file_exists($folder_foto . $foto_lama)) {
                unlink($folder_foto . $foto_lama);
            }
            $foto = basename($target_file);
        }
    }

    mysqli_query($koneksi, "UPDATE alat SET 
        idkategori = '$idkategori',
        idmerk = '$idmerk',
        namaalat = '$namaalat',
        kondisi = '$kondisi',
        idposisi = '$idposisi',
        tanggalpembelian = '$tanggalpembelian',
        foto = '$foto'
        WHERE idalat = '$idalat'
    ");

} elseif ($proses == 'hapus') {

    $idalat = $_GET['idalat'];

    // Hapus foto juga
    $sql_foto = mysqli_query($koneksi, "SELECT foto FROM alat WHERE idalat='$idalat'");
    $data = mysqli_fetch_assoc($sql_foto);
    if ($data && $data['foto'] && file_exists($folder_foto . $data['foto'])) {
        unlink($folder_foto . $data['foto']);
    }

    mysqli_query($koneksi, "DELETE FROM alat WHERE idalat = '$idalat'");
}

// redirect kembali ke halaman alat
header("location:../index.php?halaman=alat");
?>
