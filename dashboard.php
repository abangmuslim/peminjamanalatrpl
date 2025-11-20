<?php
// =======================================
// File: dashboard.php - Pusat Routing Backend PEMINJAMANALATRPL
// =======================================

require_once __DIR__ . '/includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'fungsivalidasi.php';

session_start();

// =======================================
// 1️⃣ Tentukan Role & Layout
// =======================================
$role = $_SESSION['role'] ?? '';
$layoutPath = 'pages/user';
$viewFolder = 'views/user';
$defaultPage = 'dashboardadmin';

// === (PATCH) Tambahan role PETUGAS ===
if ($role === 'petugas') {
    $layoutPath = 'pages/user';
    $viewFolder = 'views/user';
    $defaultPage = 'dashboardpetugas';
}

// === Role PEMINJAM tetap seperti semula ===
if ($role === 'peminjam') {
    $layoutPath = 'pages/peminjam';
    $viewFolder = 'views/peminjam';
    $defaultPage = 'dashboardpeminjam';
}

// =======================================
// 2️⃣ Halaman yang Diminta
// =======================================
$hal = $_GET['hal'] ?? $defaultPage;

// =======================================
// 3️⃣ Bangun Path File View
// =======================================
$halPath = explode('/', $hal);

if (count($halPath) > 1) {
    $file = BASE_PATH . "/{$viewFolder}/" . implode('/', $halPath) . ".php";
} else {
    $file = BASE_PATH . "/{$viewFolder}/{$hal}.php";
}

// =======================================
// 4️⃣ Fallback Otomatis jika File Tidak Ada
// =======================================
if (!file_exists($file)) {

    // Admin & Petugas (role user panel)
    if ($role === 'admin' || $role === 'user' || $role === 'petugas') {
        $fallbacks = [
            'user'     => 'user/daftaruser',
            'jabatan'  => 'jabatan/daftarjabatan',
            'kategori' => 'kategori/daftarkategori',
            'merk'     => 'merk/daftarmerk',
            'alat'     => 'alat/daftaralat',
            'peminjam' => 'peminjam/daftarpeminjam',
            'peminjaman'=> 'peminjaman/daftarpeminjaman',
            'pengembalian'=> 'pengembalian/daftarpengembalian',
            'laporan'  => 'laporan/daftarlaporan'
        ];

        $parent = $halPath[0] ?? '';

        if (isset($fallbacks[$parent])) {
            $file = BASE_PATH . "/{$viewFolder}/" . $fallbacks[$parent] . ".php";
        } else {
            $file = BASE_PATH . "/{$viewFolder}/{$defaultPage}.php";
        }

    } elseif ($role === 'peminjam') {
        // Default peminjam
        $file = BASE_PATH . "/{$viewFolder}/{$defaultPage}.php";

    } else {
        // Belum login → redirect login peminjam
        header("Location: " . BASE_URL . "?hal=otentikasipeminjam/loginpeminjam");
        exit;
    }
}

// =======================================
// 5️⃣ Include Layout (UNCHANGED)
// =======================================
include $file;
