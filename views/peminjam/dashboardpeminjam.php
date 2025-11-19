<?php
// ============================================================
// Dashboard peminjam (plug-and-play)
// ============================================================

require_once __DIR__ . '/../../includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';
session_start();

// ===============================
// Cek login peminjam
// ===============================
if (!isset($_SESSION['idpeminjam'])) {
    header("Location: " . BASE_URL . "?hal=otentikasipeminjam/loginpeminjam");
    exit;
}

$idpeminjam = $_SESSION['idpeminjam'];

// ===============================
// Ambil data peminjam
// ===============================
$stmt = $koneksi->prepare("SELECT * FROM peminjam WHERE idpeminjam = ? LIMIT 1");
$stmt->bind_param("i", $idpeminjam);
$stmt->execute();
$peminjam = $stmt->get_result()->fetch_assoc();
$stmt->close();

// ===============================
// Statistik peminjaman
// ===============================
$stmt1 = $koneksi->prepare("SELECT COUNT(*) AS totalpinjam FROM peminjaman WHERE idpeminjam = ?");
$stmt1->bind_param("i", $idpeminjam);
$stmt1->execute();
$totalPinjam = $stmt1->get_result()->fetch_assoc()['totalpinjam'] ?? 0;
$stmt1->close();

$stmt2 = $koneksi->prepare("
    SELECT COUNT(*) AS belumkembali
    FROM detilpeminjaman dp
    JOIN peminjaman p ON dp.idpeminjaman = p.idpeminjaman
    WHERE p.idpeminjam = ? AND dp.keterangan = 'belumkembali'
");
$stmt2->bind_param("i", $idpeminjam);
$stmt2->execute();
$belumKembali = $stmt2->get_result()->fetch_assoc()['belumkembali'] ?? 0;
$stmt2->close();

// ===============================
// 5 peminjaman terbaru
// ===============================
$stmt3 = $koneksi->prepare("
    SELECT p.idpeminjaman, dp.tanggalpinjam, dp.tanggalkembali, dp.keterangan, a.namaalat
    FROM peminjaman p
    JOIN detilpeminjaman dp ON dp.idpeminjaman = p.idpeminjaman
    JOIN alat a ON a.idalat = dp.idalat
    WHERE p.idpeminjam = ?
    ORDER BY dp.tanggalpinjam DESC
    LIMIT 5
");
$stmt3->bind_param("i", $idpeminjam);
$stmt3->execute();
$latestPinjam = $stmt3->get_result();
$stmt3->close();

// ===============================
// Include layout
// ===============================
include PAGES_PATH . 'peminjam/header.php';
include PAGES_PATH . 'peminjam/navbar.php';
?>

<div class="container mt-4">
    <h2>Selamat Datang, <?= htmlspecialchars($peminjam['namapeminjam']) ?>!</h2>
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
                    <a href="<?= BASE_URL ?>dashboard.php?hal=peminjam/tambahpeminjaman" class="btn btn-success mt-2">+ Peminjaman Baru</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <h4>Peminjaman Terbaru</h4>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Alat</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($latestPinjam && $latestPinjam->num_rows > 0): ?>
                            <?php $no=1; while($row = $latestPinjam->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row['namaalat']) ?></td>
                                    <td><?= htmlspecialchars($row['tanggalpinjam']) ?></td>
                                    <td><?= htmlspecialchars($row['tanggalkembali']) ?></td>
                                    <td><?= htmlspecialchars($row['keterangan']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center">Belum ada peminjaman</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include PAGES_PATH . 'peminjam/footer.php'; ?>
