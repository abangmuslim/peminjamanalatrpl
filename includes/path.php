<?php
// ===============================================
// File: includes/path.php
// Deskripsi: Menyimpan constant path untuk seluruh aplikasi
// ===============================================

// Root folder aplikasi peminjamanalatrpl
define('BASE_PATH', __DIR__ . '/../');

// Folder includes (konfig, koneksi, fungsi)
define('INCLUDES_PATH', BASE_PATH . 'includes/');

// Folder views (file halaman konten)
define('VIEWS_PATH', BASE_PATH . 'views/');

// Folder layout tampilan landing
define('PAGES_PATH', BASE_PATH . 'pages/');

// Base URL (opsional — jika sudah ada di konfig, boleh hapus)
$base_url = "http://localhost/peminjamanalatrpl/";
