<?php
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';

/* ============================
   AMBIL DATA PEMINJAM + ASAL
=============================== */

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

<!-- Header Card -->
<div class="card mb-3 w-100">
    <div class="card-header" style="background-color:#1B03A3; color:white;">
        <div class="d-flex justify-content-between align-items-center">

            <!-- Judul -->
            <h4 class="mb-0">Daftar Peminjam</h4>

            <!-- Tombol kanan -->
            <a href="<?= BASE_URL ?>dashboard.php?hal=peminjam/tambahpeminjam" 
               class="btn btn-light btn-sm">
               <i class="fas fa-plus"></i> Tambah Peminjam
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
                        <th>Asal</th>
                        <th>Foto</th>
                        <th>Tanggal Buat</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($peminjams as $i => $p): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>

                            <td><?= htmlspecialchars($p['namapeminjam'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($p['username'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($p['namaasal'] ?? '-') ?></td>

                            <td class="text-center">
                                <?php 
                                    $foto = $p['foto'] ?? '';
                                    $path = __DIR__ . "/../../../uploads/peminjam/" . $foto;
                                ?>

                                <?php if (!empty($foto) && file_exists($path)): ?>
                                    <img src="<?= BASE_URL ?>uploads/peminjam/<?= htmlspecialchars($foto) ?>" 
                                         width="50" class="img-thumbnail">
                                <?php else: ?>
                                    <span class="text-muted">No foto</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php 
                                    $tgl = $p['tanggalbuat'] ?? '';
                                    echo $tgl ? date('d M Y H:i', strtotime($tgl)) : '-';
                                ?>
                            </td>

                            <td>
                                <?php
                                    $status = $p['status'] ?? 'unknown';
                                    $badge = ($status === 'pending') ? 'bg-warning' 
                                          : (($status === 'disetujui') ? 'bg-success' : 'bg-danger');
                                ?>
                                <span class="badge <?= $badge ?>">
                                    <?= ucfirst($status) ?>
                                </span>
                            </td>

                            <td class="text-center">

                                <!-- Lihat -->
                                <a href="<?= BASE_URL ?>dashboard.php?hal=peminjam/tampilpeminjam&id=<?= intval($p['idpeminjam']) ?>"
                                    class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <!-- Edit -->
                                <a href="<?= BASE_URL ?>dashboard.php?hal=peminjam/editpeminjam&id=<?= intval($p['idpeminjam']) ?>"
                                    class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Hapus -->
                                <form action="<?= BASE_URL ?>views/user/peminjam/prosespeminjam.php?aksi=hapus&id=<?= intval($p['idpeminjam']) ?>"
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin hapus peminjam ini?')">

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
