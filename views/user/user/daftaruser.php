<?php
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';

/* ============================
   AMBIL DATA USER + JABATAN
   (Paksa aman — prepared stmt)
=============================== */

$sql = "SELECT u.*, j.namajabatan 
        FROM user u 
        LEFT JOIN jabatan j ON u.idjabatan = j.idjabatan
        ORDER BY u.iduser DESC";

$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$users = ($result) ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];


include PAGES_PATH . 'user/header.php';
include PAGES_PATH . 'user/navbar.php';
include PAGES_PATH . 'user/sidebar.php';
?>

<div class="content">

<!-- Header Card -->
<div class="card mb-3 w-100">
    <div class="card-header" style="background-color:#1B03A3; color:white;">
        <div class="d-flex justify-content-between align-items-center">

            <!-- Judul kiri -->
            <h4 class="mb-0">Daftar User</h4>

            <!-- Tombol kanan -->
            <a href="<?= BASE_URL ?>dashboard.php?hal=user/tambahuser" 
               class="btn btn-light btn-sm">
               <i class="fas fa-plus"></i> Tambah User
            </a>

        </div>
    </div>
</div>



    <section class="content">

        <div class="card shadow-sm">
            <div class="card-body table-responsive">

                <table class="table table-bordered table-striped" id="datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Jabatan</th>
                            <th>Role</th>
                            <th>Foto</th>
                            <th>Tanggal Buat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($users as $i => $u): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>

                                <td><?= htmlspecialchars($u['namauser'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($u['username'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($u['email'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($u['namajabatan'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($u['role'] ?? '-') ?></td>

                                <td class="text-center">
                                    <?php 
                                        $foto = $u['foto'] ?? '';
                                        $fotoPath = __DIR__ . "/../../../uploads/user/" . $foto;
                                    ?>

                                    <?php if (!empty($foto) && file_exists($fotoPath)): ?>
                                        <img src="<?= BASE_URL ?>uploads/user/<?= htmlspecialchars($foto) ?>" 
                                             width="50" class="img-thumbnail">
                                    <?php else: ?>
                                        <span class="text-muted">No foto</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php
                                        $tgl = $u['tanggalbuat'] ?? '';
                                        echo $tgl ? date('d M Y H:i', strtotime($tgl)) : '-';
                                    ?>
                                </td>

                                <td class="text-center">

                                    <!-- Lihat -->
                                    <a href="<?= BASE_URL ?>dashboard.php?hal=user/tampiluser&id=<?= intval($u['iduser']) ?>"
                                        class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <!-- Edit -->
                                    <a href="<?= BASE_URL ?>dashboard.php?hal=user/edituser&id=<?= intval($u['iduser']) ?>"
                                        class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Hapus -->
                                    <form action="<?= BASE_URL ?>views/user/user/prosesuser.php?aksi=hapus&id=<?= intval($u['iduser']) ?>"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin hapus user ini?')">

                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>

            </div>
        </div>

    </section>
</div>

<?php include PAGES_PATH . 'user/footer.php'; ?>
