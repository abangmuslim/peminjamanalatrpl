<?php
// ===========================================================
// File: includes/path.php
// Deskripsi: Definisi path absolut dan BASE_URL aplikasi
// ===========================================================

// Gunakan realpath untuk mendukung Windows & Linux
$root_path = realpath(__DIR__ . '/..') . DIRECTORY_SEPARATOR;

// PATH absolut (filesystem)
define('BASE_PATH', $root_path);
define('INCLUDES_PATH', BASE_PATH . 'includes' . DIRECTORY_SEPARATOR);
define('PAGES_PATH', BASE_PATH . 'pages' . DIRECTORY_SEPARATOR);
define('VIEWS_PATH', BASE_PATH . 'views' . DIRECTORY_SEPARATOR);
define('UPLOADS_PATH', BASE_PATH . 'uploads' . DIRECTORY_SEPARATOR);

// BASE_URL — hanya didefinisikan jika belum ada
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/peminjamanalatrpl/'); // SELALU akhiri dengan slash
}

// Upload folder spesifik peminjaman
define('UPLOAD_ALAT', UPLOADS_PATH . 'alat' . DIRECTORY_SEPARATOR);
define('UPLOAD_KOMENTAR', UPLOADS_PATH . 'komentar' . DIRECTORY_SEPARATOR);

// Tambahan jika nanti ada foto user
define('UPLOAD_USER', UPLOADS_PATH . 'user' . DIRECTORY_SEPARATOR);
?>
