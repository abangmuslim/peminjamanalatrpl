<?php
$server = "localhost";
$user   = "root";
$pass   = "";
$db     = "peminjamanalatrpl";

// Membuat koneksi
$koneksi = mysqli_connect($server, $user, $pass, $db);

// Mengecek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
// else {
//     echo "Koneksi berhasil!";
// }
?>
