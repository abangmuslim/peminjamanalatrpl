<?php
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: " . BASE_URL . "dashboard.php?hal=alat/daftaralat");
    exit;
}

// Ambil data alat + join kategori, merk, posisi
$stmt = $koneksi->prepare("
    SELECT a.*, 
           k.namakategori,
           m.namamerk,
           p.namaposisi
    FROM alat a
    LEFT JOIN kategori k ON a.idkategori = k.idkategori
    LEFT JOIN merk m ON a.idmerk = m.idmerk
    LEFT JOIN posisi p ON a.idposisi = p.idposisi
    WHERE a.idalat = ?
    LIMIT 1
");

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$alat = $result->fetch_assoc();

if (!$alat) {
    header("Location: " . BASE_URL . "dashboard.php?hal=alat/daftaralat");
    exit;
}

include PAGES_PATH . 'user/header.php';
include PAGES_PATH . 'user/navbar.php';
include PAGES_PATH . 'user/sidebar.php';
?>

<div class="content">
    <section class="content-header">
        <h1>Detail Alat</h1>
    </section>

    <section class="content">
        <div class="card shadow-sm">
            <div class="card-body row">

                <!-- FOTO ALAT -->
                <div class="col-md-6 text-center">
                    <?php if (!empty($alat['foto'])): ?>
                        <img src="<?= BASE_URL ?>uploads/alat/<?= $alat['foto'] ?>" 
                             class="img-thumbnail" width="450">
                    <?php else: ?>
                        <img src="<?= BASE_URL ?>assets/img/no-image.webp" 
                             class="img-thumbnail" width="450">
                    <?php endif; ?>

                    <h4 class="mt-2"><?= htmlspecialchars($alat['namaalat']) ?></h4>

                    <span class="badge 
                        <?= $alat['kondisi'] == 'baik' ? 'bg-success' : 
                           ($alat['kondisi'] == 'baru' ? 'bg-primary' : 
                           ($alat['kondisi'] == 'kurangbaik' ? 'bg-warning' : 'bg-danger')) ?>">
                        <?= ucfirst($alat['kondisi']) ?>
                    </span>
                </div>

                <!-- DETAIL ALAT -->
                <div class="col-md-3">
                    <p><strong>ID Alat:</strong> <?= $alat['idalat'] ?></p>
                    <p><strong>Nama Alat:</strong> <?= htmlspecialchars($alat['namaalat']) ?></p>
                    <p><strong>Kategori:</strong> <?= htmlspecialchars($alat['namakategori']) ?></p>
                    <p><strong>Merk:</strong> <?= htmlspecialchars($alat['namamerk']) ?></p>
                    <p><strong>Posisi:</strong> <?= htmlspecialchars($alat['namaposisi']) ?></p>
                    <p><strong>Kondisi:</strong> <?= htmlspecialchars(ucfirst($alat['kondisi'])) ?></p>
                    <p><strong>Tanggal Pembelian:</strong> 
                        <?= $alat['tanggalpembelian'] ? date('d M Y', strtotime($alat['tanggalpembelian'])) : '-' ?>
                    </p>
                    <p><strong>Deskripsi:</strong><br>
                        <?= nl2br(htmlspecialchars($alat['deskripsi'] ?: '-')) ?>
                    </p>
                </div>

                <!-- AKSI -->
                <div class="col-md-3">
                    <h5>Aksi</h5>

                    <a href="<?= BASE_URL ?>dashboard.php?hal=alat/editalat&id=<?= $alat['idalat'] ?>" 
                       class="btn btn-warning btn-block mb-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>

                    <a href="<?= BASE_URL ?>dashboard.php?hal=alat/daftaralat" 
                       class="btn btn-secondary btn-block">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>

            </div>
        </div>
    </section>
</div>

<?php include PAGES_PATH . 'user/footer.php'; ?>
