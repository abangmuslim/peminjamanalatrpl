<?php
// =======================================
// File: dashboard.php - Routing Backend PEMINJAMANALATRPL
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

    default: // admin, user, atau lainnya
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
// 3️⃣ Build Path sesuai struktur folder Anda
// =======================================
if (count($halPath) > 1) {
    // contoh: ?hal=user/daftaruser
    $module = $halPath[0];   // folder di dalam views/user/
    $page   = $halPath[1];   // file di dalam folder modul
    $file = BASE_PATH . "/{$viewFolder}/{$module}/{$page}.php";

} else {
    // contoh: ?hal=dashboardadmin
    $file = BASE_PATH . "/{$viewFolder}/{$hal}.php";
}

// =======================================
// 4️⃣ Fallback jika file tidak ditemukan
// =======================================
if (!file_exists($file)) {

    // fallback modul (hanya role admin, user, petugas)
    if (in_array($role, ['admin','user','petugas'])) {

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

        $parent = $halPath[0] ?? '';

        if (isset($fallbacks[$parent])) {
            $file = BASE_PATH . "/{$viewFolder}/" . $fallbacks[$parent] . ".php";
        } else {
            $file = BASE_PATH . "/{$viewFolder}/{$defaultPage}.php";
        }
    }

    // fallback peminjam
    elseif ($role === 'peminjam') {
        $file = BASE_PATH . "/{$viewFolder}/{$defaultPage}.php";
    }

    // belum login → wajib login peminjam
    else {
        header("Location: " . BASE_URL . "?hal=otentikasipeminjam/loginpeminjam");
        exit;
    }
}

// =======================================
// 5️⃣ Load View
// =======================================
include $file;
