<?php
// ===============================================
// File: views/peminjam/tambahpeminjaman.php
// Deskripsi: Form tambah peminjaman untuk peminjam
// ===============================================
require_once __DIR__ . '/../../includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'peminjam') {
    header("Location: " . BASE_URL . "?hal=loginpeminjam");
    exit;
}

$pesan = $_GET['pesan'] ?? '';

// Ambil daftar alat dari database
require_once INCLUDES_PATH . 'koneksi.php';
$alat_result = $koneksi->query("SELECT idalat, namaalat FROM alat ORDER BY namaalat ASC");
?>

<div class="container mt-4">
    <h3>Tambah Peminjaman</h3>

    <?php if (!empty($pesan)): ?>
        <div class="alert alert-warning"><?= htmlspecialchars($pesan) ?></div>
    <?php endif; ?>

    <form action="?hal=prosespeminjamanpeminjam" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="idalat" class="form-label">Pilih Alat</label>
            <select name="idalat" id="idalat" class="form-control" required>
                <option value="">-- Pilih Alat --</option>
                <?php while ($row = $alat_result->fetch_assoc()): ?>
                    <option value="<?= $row['idalat'] ?>"><?= htmlspecialchars($row['namaalat']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="tanggalpinjam" class="form-label">Tanggal Pinjam</label>
            <input type="date" name="tanggalpinjam" id="tanggalpinjam" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="tanggalkembali" class="form-label">Tanggal Kembali</label>
            <input type="date" name="tanggalkembali" id="tanggalkembali" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto (opsional)</label>
            <input type="file" name="foto" id="foto" class="form-control" accept=".jpg,.jpeg,.png">
        </div>

        <button type="submit" class="btn btn-primary">Ajukan Peminjaman</button>
        <a href="<?= BASE_URL ?>?hal=dashboardpeminjam" class="btn btn-secondary">Batal</a>
    </form>
</div>
