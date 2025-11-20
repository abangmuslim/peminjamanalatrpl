<?php
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';

// Ambil data jabatan
$sql = "SELECT * FROM jabatan ORDER BY namajabatan ASC";
$result = mysqli_query($koneksi, $sql);
$jabatan = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<?php include PAGES_PATH . 'user/header.php'; ?>
<?php include PAGES_PATH . 'user/navbar.php'; ?>
<?php include PAGES_PATH . 'user/sidebar.php'; ?>

<!-- =============================== -->
<!-- WRAPPER KONTEN FIX TANPA SPASI -->
<!-- =============================== -->
<div class="content p-3">

    <section class="content-header pb-2">
        <h1>Tambah User</h1>
    </section>

    <section class="content">

        <form action="<?= BASE_URL ?>views/user/user/prosesuser.php" 
              method="POST" 
              enctype="multipart/form-data"
              class="mt-3">

            <input type="hidden" name="aksi" value="tambah">

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="namauser" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Jabatan</label>
                <select name="idjabatan" class="form-control" required>
                    <option value="">-- Pilih Jabatan --</option>
                    <?php foreach ($jabatan as $j): ?>
                        <option value="<?= $j['idjabatan'] ?>">
                            <?= htmlspecialchars($j['namajabatan']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input name="username" type="text" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input name="email" type="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input name="password" type="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="admin">Admin</option>
                    <option value="petugas">Petugas</option>
                </select>
            </div>

            <div class="form-group">
                <label>Foto</label>
                <input type="file" name="foto" class="form-control">
            </div>

            <button class="btn btn-primary">Simpan</button>

            <a href="<?= BASE_URL ?>dashboard.php?hal=user/daftaruser" 
               class="btn btn-secondary">
               Kembali
            </a>

        </form>

    </section>
</div>

<?php include PAGES_PATH . 'user/footer.php'; ?>
