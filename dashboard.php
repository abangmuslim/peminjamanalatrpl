<?php
// ==================================================
// File: dashboard.php (ROOT)
// Routing halaman backend setelah login peminjamanalatrpl
// ==================================================

require_once __DIR__ . '/includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';

session_start();

// ==================================================
// 1️⃣ Validasi Role Login
// ==================================================
$role = $_SESSION['role'] ?? '';

if (!$role) {
    header("Location: index.php?hal=login");
    exit;
}

// Default layout (AdminLTE)
$layoutPath = 'pages/user';

// Tentukan folder views berdasarkan role
if ($role === 'admin') {
    $viewFolder = 'views/user';
    $defaultPage = 'dashboardadmin';
}
elseif ($role === 'petugas') {
    $viewFolder = 'views/petugas';
    $defaultPage = 'dashboardpetugas';
}
elseif ($role === 'peminjam') {
    $viewFolder = 'views/peminjam';
    $defaultPage = 'dashboardpeminjam';
}
else {
    header("Location: index.php");
    exit;
}

// ==================================================
// 2️⃣ Tentukan halaman yang diminta
// ==================================================
$hal = $_GET['hal'] ?? $defaultPage;
$hal = trim($hal);

// ==================================================
// 3️⃣ Batasi Akses Berdasarkan Role
// ==================================================
//
// ADMIN = akses semua
// PETUGAS = akses data alat, transaksi, laporan
// PEMINJAM = akses dashboard + riwayat + peminjaman
//

$allowed_petugas = [
    'dashboardpetugas',
    'alat/daftaralat', 'alat/tambahalat', 'alat/editalat', 'alat/prosesalat',
    'peminjaman/daftarpeminjaman', 'peminjaman/prosespeminjaman',
    'laporan/daftarlaporan'
];

$allowed_peminjam = [
    'dashboardpeminjam',
    'peminjaman/riwayat',
    'peminjaman/pinjam',
    'peminjaman/prosespinjam'
];

if ($role === 'petugas') {
    if (!in_array($hal, $allowed_petugas)) {
        $hal = $defaultPage;
    }
}

if ($role === 'peminjam') {
    if (!in_array($hal, $allowed_peminjam)) {
        $hal = $defaultPage;
    }
}

// ==================================================
// 4️⃣ Tentukan lokasi file tampilan
// ==================================================
$halParts = explode('/', $hal);

if (count($halParts) > 1) {
    $file = BASE_PATH . "/{$viewFolder}/" . implode('/', $halParts) . ".php";
} else {
    $file = BASE_PATH . "/{$viewFolder}/{$hal}.php";
}

// ==================================================
// 5️⃣ Jika file tidak ditemukan → fallback dashboard
// ==================================================
if (!file_exists($file)) {
    $file = BASE_PATH . "/{$viewFolder}/{$defaultPage}.php";
}

// ==================================================
// 6️⃣ LOAD TEMPLATE (AdminLTE) + HALAMAN TUJUAN
// ==================================================

include BASE_PATH . "/{$layoutPath}/header.php";
include BASE_PATH . "/{$layoutPath}/navbar.php";

// Sidebar berdasarkan role
if ($role === 'petugas') {
    include BASE_PATH . "/{$layoutPath}/sidebarpetugas.php";
}
elseif ($role === 'peminjam') {
    include BASE_PATH . "/{$layoutPath}/sidebarpeminjam.php";
}
else {
    include BASE_PATH . "/{$layoutPath}/sidebar.php"; // admin
}

include $file;

include BASE_PATH . "/{$layoutPath}/footer.php";
?>
