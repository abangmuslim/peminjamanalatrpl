<?php
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';

// Ambil semua peminjam beserta asalnya
$sql = "SELECT p.*, a.namaasal 
        FROM peminjam p 
        LEFT JOIN asal a ON p.idasal = a.idasal
        ORDER BY p.idpeminjam DESC";
$result = mysqli_query($koneksi, $sql);
$peminjams = mysqli_fetch_all($result, MYSQLI_ASSOC);

include PAGES_PATH . 'user/header.php';
include PAGES_PATH . 'user/navbar.php';
include PAGES_PATH . 'user/sidebar.php';
?>

<div class="content">
  <section class="content-header">
    <h1>Daftar Peminjam</h1>
  </section>

  <section class="content">

    <div class="row mb-3">
        <div class="col-md-6">
            <a href="<?= BASE_URL ?>dashboard.php?hal=peminjam/tambahpeminjam" class="btn btn-primary">+ Tambah Peminjam</a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped" id="datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Asal</th>
                        <th>Foto</th>
                        <th>Tanggal Buat</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($peminjams as $i => $p): ?>
                    <tr>
                        <td><?= $i+1 ?></td>
                        <td><?= htmlspecialchars($p['namapeminjam']) ?></td>
                        <td><?= htmlspecialchars($p['username']) ?></td>
                        <td><?= htmlspecialchars($p['namaasal'] ?? '-') ?></td>
                        <td class="text-center">
                            <?php if (!empty($p['foto'])): ?>
                                <img src="<?= BASE_URL ?>uploads/peminjam/<?= $p['foto'] ?>" width="50" class="img-thumbnail">
                            <?php else: ?>
                                <span class="text-muted">No foto</span>
                            <?php endif; ?>
                        </td>
                        <td><?= date('d M Y H:i', strtotime($p['tanggalbuat'] ?? '')) ?></td>
                        <td>
                            <span class="badge <?= $p['status'] == 'pending' ? 'bg-warning' : ($p['status'] == 'disetujui' ? 'bg-success' : 'bg-danger') ?>">
                                <?= ucfirst($p['status'] ?? '-') ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <!-- Lihat detail -->
                            <a href="<?= BASE_URL ?>dashboard.php?hal=peminjam/tampilpeminjam&id=<?= $p['idpeminjam'] ?>" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>

                            <!-- Edit -->
                            <a href="<?= BASE_URL ?>dashboard.php?hal=peminjam/editpeminjam&id=<?= $p['idpeminjam'] ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>

                            <!-- Hapus -->
                            <form action="<?= BASE_URL ?>views/user/peminjam/prosespeminjam.php?aksi=hapus&id=<?= $p['idpeminjam'] ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus peminjam ini?')">
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
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
