<?php
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';

// Ambil data asal untuk dropdown
$asal = mysqli_query($koneksi, "SELECT * FROM asal ORDER BY namaasal ASC");
?>

<?php include PAGES_PATH . 'user/header.php'; ?>
<?php include PAGES_PATH . 'user/navbar.php'; ?>
<?php include PAGES_PATH . 'user/sidebar.php'; ?>

<div class="content">
    <section class="content-header"><h1>Tambah Peminjam</h1></section>
    <section class="content">

        <form method="POST" action="<?= BASE_URL ?>views/user/peminjam/prosespeminjam.php" enctype="multipart/form-data">
            <input type="hidden" name="aksi" value="tambah">

            <div class="form-group">
                <label>Nama Peminjam</label>
                <input type="text" name="namapeminjam" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Asal</label>
                <select name="idasal" class="form-control" required>
                    <option value="">-- Pilih Asal --</option>
                    <?php while ($a = mysqli_fetch_assoc($asal)): ?>
                        <option value="<?= $a['idasal'] ?>"><?= htmlspecialchars($a['namaasal']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Foto</label>
                <input type="file" name="foto" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>

    </section>
</div>

<?php include PAGES_PATH . 'user/footer.php'; ?>
