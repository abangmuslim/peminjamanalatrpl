<?php
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: " . BASE_URL . "dashboard.php?hal=peminjam/daftarpeminjam");
    exit;
}

// Ambil data peminjam
$stmt = $koneksi->prepare("SELECT p.*, a.namaasal FROM peminjam p LEFT JOIN asal a ON p.idasal = a.idasal WHERE idpeminjam = ? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$peminjam = $result->fetch_assoc();

if (!$peminjam) {
    header("Location: " . BASE_URL . "dashboard.php?hal=peminjam/daftarpeminjam");
    exit;
}

// Proses Approve / Tolak
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['approve'])) {
        $statusBaru = 'disetujui';
    } elseif (isset($_POST['reject'])) {
        $statusBaru = 'ditolak';
    }

    if (isset($statusBaru)) {
        $stmt = $koneksi->prepare("UPDATE peminjam SET status=? WHERE idpeminjam=?");
        $stmt->bind_param("si", $statusBaru, $id);
        $stmt->execute();

        // Refresh data setelah update
        $stmt = $koneksi->prepare("SELECT p.*, a.namaasal FROM peminjam p LEFT JOIN asal a ON p.idasal = a.idasal WHERE idpeminjam = ? LIMIT 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $peminjam = $result->fetch_assoc();
    }
}

include PAGES_PATH . 'user/header.php';
include PAGES_PATH . 'user/navbar.php';
include PAGES_PATH . 'user/sidebar.php';
?>

<div class="content">
    <section class="content-header">
        <h1>Detail Peminjam</h1>
    </section>

    <section class="content">
        <div class="card shadow-sm">
            <div class="card-body row">

                <!-- Foto -->
                <div class="col-md-6 text-center">
                    <?php if (!empty($peminjam['foto'])): ?>
                        <img src="<?= BASE_URL ?>uploads/peminjam/<?= $peminjam['foto'] ?>" class="img-thumbnail" width="450">
                    <?php else: ?>
                        <img src="<?= BASE_URL ?>assets/img/default-profile.png" class="img-thumbnail" width="450">
                    <?php endif; ?>
                    <h5 class="mt-2"><?= htmlspecialchars($peminjam['namapeminjam']) ?></h5>
                    <span class="badge <?= $peminjam['status'] == 'pending' ? 'bg-warning' : ($peminjam['status'] == 'disetujui' ? 'bg-success' : 'bg-danger') ?>">
                        <?= ucfirst($peminjam['status']) ?>
                    </span>
                </div>

                <!-- Detail info -->
                <div class="col-md-3">
                    <p><strong>ID Peminjam:</strong> <?= $peminjam['idpeminjam'] ?></p>
                    <p><strong>Nama:</strong> <?= htmlspecialchars($peminjam['namapeminjam']) ?></p>
                    <p><strong>Username:</strong> <?= htmlspecialchars($peminjam['username']) ?></p>
                    <p><strong>Asal:</strong> <?= htmlspecialchars($peminjam['namaasal'] ?? '-') ?></p>
                    <p><strong>Tanggal Buat:</strong> <?= date('d M Y H:i', strtotime($peminjam['tanggalbuat'])) ?></p>
                    <p><strong>Status:</strong>
                        <span class="badge <?= $peminjam['status'] == 'pending' ? 'bg-warning' : ($peminjam['status'] == 'disetujui' ? 'bg-success' : 'bg-danger') ?>">
                            <?= ucfirst($peminjam['status']) ?>
                        </span>
                    </p>
                </div>


                <!-- Aksi -->
                <div class="col-md-3">
                    <h5>Aksi</h5>
                    <?php if ($peminjam['status'] == 'pending'): ?>
                        <form method="POST" class="mb-1">
                            <button type="submit" name="approve" class="btn btn-success btn-block">
                                <i class="fas fa-check"></i> Setujui
                            </button>
                        </form>
                        <form method="POST" class="mb-1">
                            <button type="submit" name="reject" class="btn btn-danger btn-block">
                                <i class="fas fa-times"></i> Tolak
                            </button>
                        </form>
                    <?php endif; ?>

                    <a href="<?= BASE_URL ?>dashboard.php?hal=peminjam/editpeminjam&id=<?= $peminjam['idpeminjam'] ?>" class="btn btn-warning btn-block">
                        <i class="fas fa-edit"></i> Edit
                    </a>

                    <a href="<?= BASE_URL ?>dashboard.php?hal=peminjam/daftarpeminjam" class="btn btn-secondary btn-block">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>

            </div>
        </div>
    </section>
</div>

<?php include PAGES_PATH . 'user/footer.php'; ?>