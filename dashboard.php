<?php
// =======================================
// File: dashboard.php - ROOT PeminjamanAlatRPL
// Pusat routing backend sesuai role (admin, petugas, peminjam)
// =======================================

require_once __DIR__ . '/includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';

// Layout default
$layoutPath = 'pages/user';
$viewFolder = 'views/user';

// =======================================
// 1️⃣ Tentukan role & halaman default
// =======================================
$role = $_SESSION['role'] ?? '';

switch($role) {
    case 'admin':
        $defaultPage = 'dashboardadmin';
        break;
    case 'petugas':
        $defaultPage = 'dashboardpetugas';
        $viewFolder = 'views/petugas';
        break;
    case 'peminjam':
        $defaultPage = 'dashboardpeminjam';
        $viewFolder = 'views/peminjam';
        break;
    default:
        header("Location: index.php?hal=loginuser");
        exit;
}

// =======================================
// 2️⃣ Halaman yang diminta
// =======================================
$hal = $_GET['hal'] ?? $defaultPage;

// =======================================
// 3️⃣ Batasi akses berdasarkan role
// =======================================
$allowed_petugas = [
    'dashboardpetugas',
    'alat/daftaralat','alat/tambahalat','alat/editalat','alat/prosesalat',
    'peminjaman/daftarpeminjaman','peminjaman/prosespeminjaman',
    'laporan/daftarlaporan'
];

$allowed_peminjam = [
    'dashboardpeminjam',
    'peminjaman/riwayat','peminjaman/pinjam','peminjaman/prosespinjam'
];

if ($role === 'petugas' && !in_array($hal, $allowed_petugas)) {
    $hal = $defaultPage;
}
if ($role === 'peminjam' && !in_array($hal, $allowed_peminjam)) {
    $hal = $defaultPage;
}

// =======================================
// 4️⃣ Bangun path file view secara dinamis
// =======================================
$halParts = explode('/', $hal);
$file = (count($halParts) > 1)
    ? BASE_PATH . "/{$viewFolder}/" . implode('/', $halParts) . ".php"
    : BASE_PATH . "/{$viewFolder}/{$hal}.php";

// =======================================
// 5️⃣ Fallback otomatis
// =======================================
if (!file_exists($file)) {
    $file = BASE_PATH . "/{$viewFolder}/{$defaultPage}.php";
}

// =======================================
// 6️⃣ Load template AdminLTE + view
// =======================================
include BASE_PATH . "/{$layoutPath}/header.php";
include BASE_PATH . "/{$layoutPath}/navbar.php";

if ($role === 'petugas') {
    include BASE_PATH . "/{$layoutPath}/sidebarpetugas.php";
} elseif ($role === 'peminjam') {
    include BASE_PATH . "/{$layoutPath}/sidebarpeminjam.php";
} else {
    include BASE_PATH . "/{$layoutPath}/sidebar.php"; // admin
}

include $file;

include BASE_PATH . "/{$layoutPath}/footer.php";
