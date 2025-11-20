<?php
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';

// Ambil semua user
$sql = "
    SELECT u.*, j.namajabatan 
    FROM user u 
    LEFT JOIN jabatan j ON u.idjabatan = j.idjabatan
    ORDER BY u.iduser DESC
";
$result = mysqli_query($koneksi, $sql);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<?php include PAGES_PATH . 'user/header.php'; ?>
<?php include PAGES_PATH . 'user/navbar.php'; ?>
<?php include PAGES_PATH . 'user/sidebar.php'; ?>

<!-- ======================================== -->
<!-- FIX WRAPPER TANPA JARAK (seperti admin) -->
<!-- ======================================== -->

    <div class="content">
        <section class="content-header">
            <h1>Daftar User</h1>
        </section>

        <section class="content">

            <!-- Tombol Tambah User -->
            <a href="<?= BASE_URL ?>dashboard.php?hal=user/tambahuser" 
               class="btn btn-primary mb-3">
               Tambah User
            </a>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="40">ID</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Jabatan</th>
                        <th>Role</th>
                        <th>Foto</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= $u['iduser'] ?></td>
                        <td><?= htmlspecialchars($u['namauser']) ?></td>
                        <td><?= htmlspecialchars($u['username']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td><?= htmlspecialchars($u['namajabatan']) ?></td>
                        <td><?= htmlspecialchars($u['role']) ?></td>
                        <td>
                            <?php if (!empty($u['foto'])): ?>
                                <img src="<?= BASE_URL ?>uploads/user/<?= $u['foto'] ?>" 
                                     width="50" style="border-radius:4px;">
                            <?php else: ?> - <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>dashboard.php?hal=user/edituser&id=<?= $u['iduser'] ?>"
                               class="btn btn-sm btn-warning">Edit</a>

                            <a href="<?= BASE_URL ?>views/user/user/prosesuser.php?aksi=hapus&id=<?= $u['iduser'] ?>"
                               onclick="return confirm('Yakin hapus user ini?')"
                               class="btn btn-sm btn-danger">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>

            </table>

        </section>
    </div>

<?php include PAGES_PATH . 'user/footer.php'; ?>
