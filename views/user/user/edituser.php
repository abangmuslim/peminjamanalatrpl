<?php
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';
require_once INCLUDES_PATH . 'fungsiupload.php';

// Ambil ID user
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: " . BASE_URL . "dashboard.php?hal=user/daftaruser&msg=user_tidak_ditemukan");
    exit;
}

// Ambil data user
$result = mysqli_query($koneksi, "SELECT * FROM user WHERE iduser=$id");
$user = mysqli_fetch_assoc($result);
if (!$user) {
    header("Location: " . BASE_URL . "dashboard.php?hal=user/daftaruser&msg=user_tidak_ditemukan");
    exit;
}

// Ambil data jabatan
$result_jabatan = mysqli_query($koneksi, "SELECT * FROM jabatan ORDER BY namajabatan ASC");
$jabatan = mysqli_fetch_all($result_jabatan, MYSQLI_ASSOC);
?>

<?php include PAGES_PATH . 'user/header.php'; ?>
<?php include PAGES_PATH . 'user/navbar.php'; ?>
<?php include PAGES_PATH . 'user/sidebar.php'; ?>

<!-- =============================== -->
<!-- WRAPPER KONTEN FIX TANPA SPASI -->
<!-- =============================== -->
<div class="content p-3">

    <section class="content-header pb-2">
        <h1>Edit User</h1>
    </section>

    <section class="content">

        <form action="<?= BASE_URL ?>views/user/user/prosesuser.php"
              method="POST"
              enctype="multipart/form-data"
              class="mt-3">

            <input type="hidden" name="aksi" value="edit">
            <input type="hidden" name="iduser" value="<?= $user['iduser'] ?>">
            <input type="hidden" name="fotolama" value="<?= htmlspecialchars($user['foto']) ?>">

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="namauser" class="form-control"
                       value="<?= htmlspecialchars($user['namauser']) ?>" required>
            </div>

            <div class="form-group">
                <label>Jabatan</label>
                <select name="idjabatan" class="form-control" required>
                    <option value="">-- Pilih Jabatan --</option>
                    <?php foreach ($jabatan as $j): ?>
                        <option value="<?= $j['idjabatan'] ?>" 
                            <?= $j['idjabatan'] == $user['idjabatan'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($j['namajabatan']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control"
                       value="<?= htmlspecialchars($user['username']) ?>" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                       value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>

            <div class="form-group">
                <label>Password <small>(kosongkan jika tidak ingin diubah)</small></label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>Admin</option>
                    <option value="petugas" <?= $user['role']=='petugas'?'selected':'' ?>>Petugas</option>
                </select>
            </div>

            <div class="form-group">
                <label>Foto</label>
                <?php if (!empty($user['foto']) && file_exists(UPLOAD_USER.$user['foto'])): ?>
                    <div class="mb-2">
                        <img src="<?= BASE_URL ?>uploads/user/<?= $user['foto'] ?>" width="80" style="border-radius:4px;">
                    </div>
                <?php endif; ?>
                <input type="file" name="foto" class="form-control">
            </div>

            <button class="btn btn-primary">Simpan</button>
            <a href="<?= BASE_URL ?>dashboard.php?hal=user/daftaruser" class="btn btn-secondary">Kembali</a>

        </form>

    </section>
</div>

<?php include PAGES_PATH . 'user/footer.php'; ?>
