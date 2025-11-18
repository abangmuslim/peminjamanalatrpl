<?php
// ===============================================
// File: pages/user/header.php
// Layout Header Dashboard Backend (Admin/Petugas)
// ===============================================

// Pastikan path & konfigurasi tersedia
require_once __DIR__ . '/../../includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php'; // memastikan user login

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($site_name) ?> — Dashboard</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/dist/css/adminlte.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/plugins/fontawesome-free/css/all.min.css">

    <!-- Google Fonts -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700">

    <!-- Custom CSS (opsional) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/dist/css/custom.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
