<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "peminjamanalatrpl"; // nama database kamu

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Set charset UTF-8
mysqli_set_charset($koneksi, "utf8");
