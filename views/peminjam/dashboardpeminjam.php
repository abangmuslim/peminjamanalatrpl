<?php
require_once __DIR__ . '/../../includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';
session_start();

// Cek login peminjam
if (!isset($_SESSION['idpeminjam'])) {
    header("Location: ?hal=otentikasipeminjam/loginpeminjam");
    exit;
}

$idpeminjam = $_SESSION['idpeminjam'];

// Ambil data peminjam
$peminjam = null;
if ($idpeminjam) {
    $stmt = $koneksi->prepare("SELECT * FROM peminjam WHERE idpeminjam = ? LIMIT 1");
    $stmt->bind_param("i", $idpeminjam);
    $stmt->execute();
    $peminjam = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

// Ambil jumlah peminjaman & alat belum dikembalikan
$totalPinjam = $koneksi->prepare("SELECT COUNT(*) AS totalpinjam FROM peminjaman WHERE idpeminjam = ?");
$totalPinjam->bind_param("i", $idpeminjam);
$totalPinjam->execute();
$totalPinjam = $totalPinjam->get_result()->fetch_assoc()['totalpinjam'] ?? 0;

$belumKembali = $koneksi->prepare("
    SELECT COUNT(*) AS belumkembali
    FROM detilpeminjaman dp
    JOIN peminjaman p ON dp.idpeminjaman = p.idpeminjaman
    WHERE p.idpeminjam = ? AND dp.keterangan = 'belumkembali'
");
$belumKembali->bind_param("i", $idpeminjam);
$belumKembali->execute();
$belumKembali = $belumKembali->get_result()->fetch_assoc()['belumkembali'] ?? 0;
?>

<?php include PAGES_PATH . 'peminjam/header.php'; ?>
<?php include PAGES_PATH . 'peminjam/navbar.php'; ?>

<div class="container mt-4">
    <h2>Selamat Datang, <?= htmlspecialchars($peminjam['namapeminjam'] ?? 'Peminjam') ?>!</h2>
    <p>Status akun: <strong><?= htmlspecialchars($peminjam['status'] ?? '-') ?></strong></p>

    <div class="row mt-3">
        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5>Total Peminjaman</h5>
                    <p class="display-4"><?= $totalPinjam ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5>Alat Belum Dikembalikan</h5>
                    <p class="display-4"><?= $belumKembali ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5>Tambah Peminjaman</h5>
                    <a href="<?= BASE_URL ?>dashboard.php?hal=peminjam/peminjaman/tambahpeminjaman" class="btn btn-success mt-2">+ Peminjaman Baru</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include PAGES_PATH . 'peminjam/footer.php'; ?>
