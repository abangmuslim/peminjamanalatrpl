<?php
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';
require_once __DIR__ . '/../../../includes/fungsiupload.php';

$idpeminjaman = $_GET['id'] ?? null;
if (!$idpeminjaman) {
    header("Location: " . BASE_URL . "dashboard.php?hal=peminjaman/daftarpeminjaman");
    exit;
}

// Ambil data peminjaman
$peminjaman = $koneksi->query("SELECT * FROM peminjaman WHERE idpeminjaman = $idpeminjaman")->fetch_assoc();
if (!$peminjaman) {
    header("Location: " . BASE_URL . "dashboard.php?hal=peminjaman/daftarpeminjaman");
    exit;
}

// Ambil peminjam
$peminjamQuery = $koneksi->query("SELECT * FROM peminjam ORDER BY namapeminjam ASC");

// Ambil semua alat
$alatQueryAll = $koneksi->query("SELECT * FROM alat ORDER BY namaalat ASC");

// Ambil detail alat peminjaman
$detilQuery = $koneksi->query("
    SELECT d.*, a.namaalat 
    FROM detilpeminjaman d 
    LEFT JOIN alat a ON d.idalat = a.idalat
    WHERE d.idpeminjaman = $idpeminjaman
");
$detilItems = $detilQuery->fetch_all(MYSQLI_ASSOC);

include PAGES_PATH . 'user/header.php';
include PAGES_PATH . 'user/navbar.php';
include PAGES_PATH . 'user/sidebar.php';
?>

<div class="content">
    <div class="card mb-3">
        <div class="card-header bg-primary text-white">
            <h4>Edit Peminjaman</h4>
        </div>
        <div class="card-body">
            <form action="<?= BASE_URL ?>views/user/peminjaman/prosespeminjaman.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="aksi" value="edit">
                <input type="hidden" name="idpeminjaman" value="<?= intval($peminjaman['idpeminjaman']) ?>">
                <input type="hidden" name="fotolama" value="<?= htmlspecialchars($peminjaman['foto']) ?>">

                <!-- Peminjam -->
                <div class="mb-3">
                    <label for="idpeminjam" class="form-label">Peminjam</label>
                    <select name="idpeminjam" id="idpeminjam" class="form-control" required>
                        <option value="">-- Pilih Peminjam --</option>
                        <?php while($p = $peminjamQuery->fetch_assoc()): ?>
                            <option value="<?= $p['idpeminjam'] ?>" <?= $p['idpeminjam'] == $peminjaman['idpeminjam'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($p['namapeminjam']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Foto Dokumen -->
                <div class="mb-3">
                    <label for="foto" class="form-label">Upload Dokumen / Foto (opsional)</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                    <?php if (!empty($peminjaman['foto']) && file_exists(__DIR__ . "/../../../uploads/peminjaman/{$peminjaman['foto']}")): ?>
                        <img src="<?= BASE_URL ?>uploads/peminjaman/<?= htmlspecialchars($peminjaman['foto']) ?>" 
                             width="100" class="img-thumbnail mt-2">
                    <?php endif; ?>
                </div>

                <hr>
                <h5>Alat yang Dipinjam</h5>
                <div id="alat-container">
                    <?php foreach($detilItems as $detil): ?>
                    <div class="row mb-2 alat-item">
                        <input type="hidden" name="iddetilpeminjaman[]" value="<?= $detil['iddetilpeminjaman'] ?>">
                        <div class="col-md-4">
                            <label>Alat</label>
                            <select name="idalat[]" class="form-control" required>
                                <option value="">-- Pilih Alat --</option>
                                <?php
                                $alatQueryAll = $koneksi->query("SELECT * FROM alat ORDER BY namaalat ASC");
                                while($a = $alatQueryAll->fetch_assoc()):
                                ?>
                                    <option value="<?= $a['idalat'] ?>" <?= $a['idalat'] == $detil['idalat'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($a['namaalat']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Tanggal Pinjam</label>
                            <input type="date" name="tanggalpinjam[]" class="form-control" 
                                   value="<?= $detil['tanggalpinjam'] ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label>Tanggal Kembali</label>
                            <input type="date" name="tanggalkembali[]" class="form-control" 
                                   value="<?= $detil['tanggalkembali'] ?>" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-danger remove-alat">Hapus</button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <button type="button" id="add-alat" class="btn btn-secondary mb-3">Tambah Alat</button>
                <br>
                <button type="submit" class="btn btn-primary">Update Peminjaman</button>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('add-alat').addEventListener('click', function(){
    const container = document.getElementById('alat-container');
    const first = container.querySelector('.alat-item');
    const clone = first.cloneNode(true);
    
    // Reset semua value
    clone.querySelectorAll('select, input').forEach(el => {
        if(el.type === 'hidden') el.value = ''; // iddetilpeminjaman kosong agar insert baru
        else el.value = '';
    });
    
    container.appendChild(clone);
});

// Hapus item alat
document.addEventListener('click', function(e){
    if(e.target.classList.contains('remove-alat')){
        const item = e.target.closest('.alat-item');
        if(item) item.remove();
    }
});
</script>

<?php include PAGES_PATH . 'user/footer.php'; ?>
