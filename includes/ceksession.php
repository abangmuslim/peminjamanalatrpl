<?php
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: index.php?page=login");
    exit;
}

// keamanan tambahan
$role = $_SESSION['role'] ?? null;

// jika role tidak dikenali, paksa logout
if (!in_array($role, ['admin', 'petugas', 'peminjam'])) {
    session_destroy();
    header("Location: index.php?page=login");
    exit;
}
