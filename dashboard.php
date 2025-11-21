<?php
// =======================================
// File: dashboard.php - Routing Backend PEMINJAMANALATRPL (FINAL STABLE)
// =======================================

require_once __DIR__ . '/includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'fungsivalidasi.php';

session_start();

// =======================================
// 1️⃣ Tentukan Role & View Folder Dasar
// =======================================
$role = $_SESSION['role'] ?? '';

switch ($role) {
    case 'petugas':
        $viewFolder = 'views/user';
        $defaultPage = 'dashboardpetugas';
        break;

    case 'peminjam':
        $viewFolder = 'views/peminjam';
        $defaultPage = 'dashboardpeminjam';
        break;

    default: // admin atau role lain
        $viewFolder = 'views/user';
        $defaultPage = 'dashboardadmin';
        break;
}

// =======================================
// 2️⃣ Halaman yang diminta
// =======================================
$hal = $_GET['hal'] ?? $defaultPage;
$halPath = explode('/', $hal);

// =======================================
// 3️⃣ Role Protection (FINAL)
// =======================================
// Petugas dibatasi (hanya boleh kelola peminjam & dashboard)
$blockedForPetugas = [
    'user',
    'jabatan',
    'merk',
    'kategori',
    'alat',
    'peminjaman',
    'pengembalian',
    'laporan'
];

if ($role === 'petugas') {
    $requestedModule = $halPath[0] ?? '';

    if (in_array($requestedModule, $blockedForPetugas)) {
        header("Location: dashboard.php?hal=notfound");
        exit;
    }
}

// =======================================
// 4️⃣ Build Path sesuai struktur folder
// =======================================
if (count($halPath) > 1) {

    $module = $halPath[0];
    $page   = $halPath[1];

    // Lokasi file calon target
    $fileCandidate = BASE_PATH . "/{$viewFolder}/{$module}/{$page}.php";

    if (file_exists($fileCandidate)) {
        $file = $fileCandidate;

    } else {
        // fallback otomatis pada module
        $fallbacks = [
            'user'         => 'user/daftaruser',
            'jabatan'      => 'jabatan/daftarjabatan',
            'kategori'     => 'kategori/daftarkategori',
            'merk'         => 'merk/daftarmerk',
            'alat'         => 'alat/daftaralat',
            'peminjam'     => 'peminjam/daftarpeminjam',
            'peminjaman'   => 'peminjaman/daftarpeminjaman',
            'pengembalian' => 'pengembalian/daftarpengembalian',
            'komentar'     => 'komentar/daftarkomentar',
            'asal'         => 'asal/daftarasal',
            'laporan'      => 'laporan/daftarlaporan'
        ];

        if (isset($fallbacks[$module])) {
            $file = BASE_PATH . "/{$viewFolder}/" . $fallbacks[$module] . ".php";
        } else {
            $file = BASE_PATH . "/views/notfound.php";
        }
    }

} else {
    // Jika hanya hal=dashboardadmin dll
    $simpleFile = BASE_PATH . "/{$viewFolder}/{$hal}.php";
    $file = file_exists($simpleFile)
        ? $simpleFile
        : BASE_PATH . "/views/notfound.php";
}

// =======================================
// 5️⃣ Fallback jika file benar-benar tidak ada
// =======================================
if (!file_exists($file)) {
    if (in_array($role, ['admin','petugas','user','peminjam'])) {
        $file = BASE_PATH . "/views/notfound.php";
    } else {
        header("Location: " . BASE_URL . "?hal=otentikasipeminjam/loginpeminjam");
        exit;
    }
}

// =======================================
// 6️⃣ Load View
// =======================================
include $file;
