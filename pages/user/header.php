<?php
// ===============================================
// HEADER LAYOUT (Front Office)
// Berisi tag <head>, meta SEO, link CSS, dan judul situs
// File ini di-include pada setiap tampilan landing
// ===============================================
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO -->
    <meta name="description" content="Portal berita dan informasi terbaru CMSMAHDI">
    <meta name="keywords" content="berita, artikel, informasi, cmsmahdi">
    <meta name="author" content="CMSMAHDI">

    <title><?= $site_name ?> - Portal Berita</title>

    <!-- CSS utama -->
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/style.css">

    <!-- Bootstrap (opsional jika dipakai) -->
    <link rel="stylesheet" href="<?= $base_url ?>/assets/vendor/bootstrap/bootstrap.min.css">

</head>
<body>
