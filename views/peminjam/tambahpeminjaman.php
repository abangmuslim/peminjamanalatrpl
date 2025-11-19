<?php
// ============================================================
// File: views/peminjam/tambahpeminjaman.php
// Deskripsi: Form tambah peminjaman untuk peminjam
// ============================================================

session_start();
require_once __DIR__ . '/../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';

// Cek login peminjam
if (!isset($_SESSION['idpeminjam'])) {
    header("Location: ?hal=loginpeminjam");
    exit;
}

$idpeminjam = $_SESSION['idpeminjam'];

// Ambil daftar alat yang tersedia
$sql = "SELECT a.idalat, a.namaalat, k.namakategori, m.namamerk, p.namaposisi, a.kondisi
        FROM alat a
        JOIN kategori k ON a.idkategori = k.idkategori
        JOIN merk m ON a.idmerk = m.idmerk
        JOIN posisi p ON a.idposisi = p.idposisi
        WHERE a.kondisi = 'baik'";
$stmt = $koneksi->prepare($sql);
$stmt->execute();
$alat_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include PAGES_PATH . 'peminjam/header.php'; ?>

<div class="container mt-4">
    <h2>Tambah Peminjaman</h2>
    <form action="?hal=prosespeminjaman" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="idpeminjam" value="<?= htmlspecialchars($idpeminjam) ?>">

        <div class="mb-3">
            <label for="alat" class="form-label">Pilih Alat</label>
            <select name="idalat[]" id="alat" class="form-select" multiple required>
                <?php foreach($alat_list as $alat): ?>
                    <option value="<?= $alat['idalat'] ?>">
                        <?= htmlspecialchars($alat['namaalat']) ?> 
                        (<?= htmlspecialchars($alat['namakategori']) ?> - <?= htmlspecialchars($alat['namamerk']) ?> - <?= htmlspecialchars($alat['namaposisi']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <small class="form-text text-muted">Tekan Ctrl/Cmd untuk pilih lebih dari satu alat.</small>
        </div>

        <div class="mb-3">
            <label for="tanggalpinjam" class="form-label">Tanggal Pinjam</label>
            <input type="date" name="tanggalpinjam" id="tanggalpinjam" class="form-control" value="<?= date('Y-m-d') ?>" required>
        </div>

        <div class="mb-3">
            <label for="tanggalkembali" class="form-label">Tanggal Kembali</label>
            <input type="date" name="tanggalkembali" id="tanggalkembali" class="form-control" value="<?= date('Y-m-d', strtotime('+1 day')) ?>" required>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto (Opsional)</label>
            <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Pinjam Sekarang</button>
        <a href="?hal=dashboardpeminjam" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php include PAGES_PATH . 'peminjam/footer.php'; ?>
