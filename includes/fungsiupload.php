<?php

function upload_gambar($file, $folder)
{
    // Lokasi folder upload
    $target_dir = "uploads/$folder/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Data file
    $nama_file = basename($file["name"]);
    $tmp_name  = $file["tmp_name"];
    $ukuran    = $file["size"];
    $error     = $file["error"];

    // Jika tidak ada file
    if ($error === 4) {
        return null;
    }

    // Validasi ekstensi
    $ekstensi_valid = ['jpg', 'jpeg', 'png'];
    $ekstensi_file  = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

    if (!in_array($ekstensi_file, $ekstensi_valid)) {
        return "error:format";
    }

    // Validasi ukuran (max 3MB)
    if ($ukuran > 3 * 1024 * 1024) {
        return "error:ukuran";
    }

    // Nama unik
    $nama_baru = uniqid() . '.' . $ekstensi_file;

    // Cegah upload file berbahaya
    if (mime_content_type($tmp_name) === 'text/x-php'
        || preg_match('/\.(php|exe|js|sh)$/i', $nama_file)) {
        return "error:bahaya";
    }

    // Upload file
    if (move_uploaded_file($tmp_name, $target_dir . $nama_baru)) {
        return $nama_baru;
    } else {
        return "error:gagal";
    }
}
