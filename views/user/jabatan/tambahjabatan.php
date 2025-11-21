<?php
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';
?>

<?php include PAGES_PATH . 'user/header.php'; ?>
<?php include PAGES_PATH . 'user/navbar.php'; ?>
<?php include PAGES_PATH . 'user/sidebar.php'; ?>

<div class="content">
    <section class="content-header">
        <h1>Tambah Jabatan</h1>
    </section>

    <section class="content">

        <form method="POST" action="<?= BASE_URL ?>views/user/jabatan/prosesjabatan.php">
            <input type="hidden" name="aksi" value="tambah">

            <div class="form-group">
                <label>Nama Jabatan</label>
                <input type="text" name="namajabatan" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary mt-2">Simpan</button>
        </form>

    </section>
</div>

<?php include PAGES_PATH . 'user/footer.php'; ?>
