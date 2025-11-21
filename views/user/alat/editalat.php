<?php
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';

// Ambil ID alat
if (!isset($_GET['id'])) {
    die("ID alat tidak ditemukan.");
}

$idalat = intval($_GET['id']);

// Ambil data alat
$q = mysqli_query($koneksi, "SELECT * FROM alat WHERE idalat = $idalat");
$data = mysqli_fetch_assoc($q);
if (!$data) {
    die("Data alat tidak ditemukan.");
}

// Ambil dropdown
$kategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY namakategori ASC");
$merk     = mysqli_query($koneksi, "SELECT * FROM merk ORDER BY namamerk ASC");
$posisi   = mysqli_query($koneksi, "SELECT * FROM posisi ORDER BY namaposisi ASC");
?>

<?php include PAGES_PATH . 'user/header.php'; ?>
<?php include PAGES_PATH . 'user/navbar.php'; ?>
<?php include PAGES_PATH . 'user/sidebar.php'; ?>

<div class="content">

    <section class="content-header">
        <h1>Edit Alat</h1>
    </section>

    <section class="content">

        <!-- ====== CARD BOX BEGIN ====== -->
        <div class="card shadow-sm">
            <div class="card-body">

                <form method="POST" action="<?= BASE_URL ?>views/user/alat/prosesalat.php" enctype="multipart/form-data">
                    <input type="hidden" name="aksi" value="edit">
                    <input type="hidden" name="idalat" value="<?= $idalat ?>">
                    <!-- Ubah nama input menjadi fotolama agar sesuai prosesalat.php -->
                    <input type="hidden" name="fotolama" value="<?= $data['foto'] ?>">

                    <div class="row">

                        <!-- ================= COL KIRI ================= -->
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Nama Alat</label>
                                <input type="text" name="namaalat" class="form-control" value="<?= htmlspecialchars($data['namaalat']) ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Kategori</label>
                                <select name="idkategori" class="form-control" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php while ($k = mysqli_fetch_assoc($kategori)): ?>
                                        <option value="<?= $k['idkategori'] ?>" 
                                            <?= ($k['idkategori'] == $data['idkategori']) ? 'selected' : '' ?> >
                                            <?= htmlspecialchars($k['namakategori']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Merk</label>
                                <select name="idmerk" class="form-control" required>
                                    <option value="">-- Pilih Merk --</option>
                                    <?php while ($m = mysqli_fetch_assoc($merk)): ?>
                                        <option value="<?= $m['idmerk'] ?>"
                                            <?= ($m['idmerk'] == $data['idmerk']) ? 'selected' : '' ?> >
                                            <?= htmlspecialchars($m['namamerk']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <!-- Deskripsi -->
                            <div class="form-group">
                                <label>Deskripsi Alat</label>
                                <textarea name="deskripsi" class="form-control" rows="3"><?= htmlspecialchars($data['deskripsi']) ?></textarea>
                            </div>

                        </div>

                        <!-- ================= COL KANAN ================= -->
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Posisi</label>
                                <select name="idposisi" class="form-control" required>
                                    <option value="">-- Pilih Posisi --</option>
                                    <?php while ($p = mysqli_fetch_assoc($posisi)): ?>
                                        <option value="<?= $p['idposisi'] ?>"
                                            <?= ($p['idposisi'] == $data['idposisi']) ? 'selected' : '' ?> >
                                            <?= htmlspecialchars($p['namaposisi']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Kondisi</label>
                                <select name="kondisi" class="form-control" required>
                                    <option value="baru"        <?= ($data['kondisi'] == 'baru') ? 'selected' : '' ?>>Baru</option>
                                    <option value="baik"        <?= ($data['kondisi'] == 'baik') ? 'selected' : '' ?>>Baik</option>
                                    <option value="kurangbaik"  <?= ($data['kondisi'] == 'kurangbaik') ? 'selected' : '' ?>>Kurang Baik</option>
                                    <option value="rusak"       <?= ($data['kondisi'] == 'rusak') ? 'selected' : '' ?>>Rusak</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Pembelian</label>
                                <input type="date" name="tanggalpembelian" 
                                       value="<?= $data['tanggalpembelian'] ?>" 
                                       class="form-control">
                            </div>

                            <!-- Upload Foto -->
                            <div class="form-group">
                                <label>Foto Alat (Opsional)</label>
                                <input type="file" name="foto" class="form-control" accept="image/*" onchange="previewFoto(event)">
                            </div>

                            <!-- Preview Foto Lama / Baru -->
                            <div class="mb-3">
                                <img id="previewImg"
                                     src="<?= BASE_URL ?>uploads/alat/<?= $data['foto'] ?>"
                                     alt="Preview Foto"
                                     class="img-thumbnail"
                                     style="width:150px; <?= $data['foto'] ? '' : 'display:none;' ?>">
                            </div>

                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary mt-2">Update</button>

                </form>

            </div>
        </div>
        <!-- ====== CARD BOX END ====== -->

    </section>

</div>

<?php include PAGES_PATH . 'user/footer.php'; ?>

<script>
function previewFoto(event) {
    const img = document.getElementById('previewImg');
    img.src = URL.createObjectURL(event.target.files[0]);
    img.style.display = 'block';
}
</script>
