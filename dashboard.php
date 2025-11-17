<?php
// ===============================================
// File : dashboard.php  
// Routing Backend untuk Admin, Petugas, Peminjam
// ===============================================

require_once __DIR__ . '/includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';


// ==================================================
// 1️⃣ Ambil role login
// ==================================================
$role = $_SESSION['role'] ?? '';


// ==================================================
// 2️⃣ Tentukan layout + view folder + halaman default
// ==================================================
$layoutPath = 'pages/user';       // default layout: admin/petugas
$viewFolder = 'views/user';
$defaultPage = 'dashboardadmin';  // default admin

if ($role === 'admin') {

    $defaultPage = 'dashboardadmin';

} elseif ($role === 'petugas') {

    $defaultPage = 'dashboardpetugas';

} elseif ($role === 'peminjam') {

    $layoutPath  = 'pages/peminjam'; 
    $viewFolder  = 'views/peminjam';
    $defaultPage = 'dashboardpeminjam';

} else {
    header("Location: index.php");
    exit;
}


// ==================================================
// 3️⃣ Ambil parameter halaman (?hal=...)
// ==================================================
$hal = $_GET['hal'] ?? $defaultPage;


// ==================================================
// 4️⃣ Batasi akses berdasarkan role
// ==================================================
$allowed_petugas = [
    'dashboardpetugas',
    'alat/daftaralat', 'alat/tambahalat', 'alat/editalat', 'alat/prosesalat',
    'peminjam/daftarpeminjam', 'peminjam/detailpeminjam',
    'peminjaman/daftarpeminjaman', 'peminjaman/tambahpeminjaman',
    'peminjaman/editpeminjaman', 'peminjaman/prosespeminjaman',
    'pengembalian/daftarpengembalian', 'pengembalian/prosespengembalian',
    'komentar/daftarkomentar', 'komentar/editkomentar', 'komentar/proseskomentar',
    'laporan/daftarlaporan'
];

$allowed_peminjam = [
    'dashboardpeminjam',
    'alat/daftaralat', 'alat/detailalat',
    'peminjaman/pengajuan', 'peminjaman/prosespengajuan',
    'peminjaman/riwayat'
];


if ($role === 'petugas') {
    if (!in_array($hal, $allowed_petugas) && !str_starts_with($hal, 'dashboard')) {
        $hal = $defaultPage;
    }
}

if ($role === 'peminjam') {
    if (!in_array($hal, $allowed_peminjam) && !str_starts_with($hal, 'dashboard')) {
        $hal = $defaultPage;
    }
}


// ==================================================
// 5️⃣ Bangun path file view berdasarkan URL
// ==================================================
$ex = explode('/', $hal);
if (count($ex) > 1) {
    $file = BASE_PATH . "/{$viewFolder}/" . implode('/', $ex) . ".php";
} else {
    $file = BASE_PATH . "/{$viewFolder}/{$hal}.php";
}


// ==================================================
// 6️⃣ Fallback otomatis berdasarkan folder (modul)
// ==================================================
if (!file_exists($file)) {

    $parent = $ex[0] ?? '';

    $fallback = [
        'user'         => 'user/daftaruser',
        'jabatan'      => 'jabatan/daftarjabatan',
        'merk'         => 'merk/daftarmerk',
        'kategori'     => 'kategori/daftarkategori',
        'alat'         => 'alat/daftaralat',
        'komentar'     => 'komentar/daftarkomentar',
        'asal'         => 'asal/daftarasal',
        'peminjam'     => 'peminjam/daftarpeminjam',
        'peminjaman'   => 'peminjaman/daftarpeminjaman',
        'pengembalian' => 'pengembalian/daftarpengembalian',
        'laporan'      => 'laporan/daftarlaporan'
    ];

    if (isset($fallback[$parent])) {
        $file = BASE_PATH . "/{$viewFolder}/" . $fallback[$parent] . ".php";
    }
}


// ==================================================
// 7️⃣ Validasi terakhir
// ==================================================
if (!file_exists($file)) {
    $file = BASE_PATH . "/{$viewFolder}/{$defaultPage}.php";
}


// ==================================================
// 8️⃣ Tampilkan layout
// ==================================================
include BASE_PATH . "/{$layoutPath}/header.php";
include BASE_PATH . "/{$layoutPath}/navbar.php";

// sidebar berbeda antara admin/petugas vs peminjam
if ($role !== 'peminjam') {
    include BASE_PATH . "/{$layoutPath}/sidebar.php";
} else {
    include BASE_PATH . "/{$layoutPath}/sidebar.php";
}

include $file;

include BASE_PATH . "/{$layoutPath}/footer.php";
