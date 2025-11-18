<?php
// =======================================================
// File: views/otentikasiuser/logout.php
// Deskripsi: Logout dan hapus semua session
// =======================================================

require_once '../../includes/path.php';
session_start();

// Hapus semua session
session_unset();
session_destroy();

// Redirect kembali ke landing
header("Location: " . BASE_URL);
exit;
?>
