<?php
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';

// Ambil semua peminjaman yang belum dikembalikan
$sql = "SELECT pm.*, p.namapeminjam 
        FROM peminjaman pm
        LEFT JOIN peminjam p ON pm.idpeminjam = p.idpeminjam
        ORDER BY pm.idpeminjaman DESC";
$result = mysqli_query($koneksi, $sql);
$peminjamans = mysqli_fetch_all($result, MYSQLI_ASSOC);

include PAGES_PATH . 'user/header.php';
include PAGES_PATH . 'user/navbar.php';
include PAGES_PATH . 'user/sidebar.php';
?>

<div class="content">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Daftar Peminjaman yang Belum Dikembalikan</h4>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped" id="datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Alat</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($peminjamans as $i => $pm): ?>
                        <?php
                        // Ambil detail alat yang belum dikembalikan
                        $detil = $koneksi->query("
                            SELECT d.*, a.namaalat 
                            FROM detilpeminjaman d
                            LEFT JOIN alat a ON d.idalat = a.idalat
                            WHERE d.idpeminjaman = " . intval($pm['idpeminjaman']) . "
                              AND d.keterangan = 'belumkembali'
                        ")->fetch_all(MYSQLI_ASSOC);
                        if (!$detil) continue;
                        ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= htmlspecialchars($pm['namapeminjam'] ?? '-') ?></td>
                            <td>
                                <ul class="mb-0">
                                    <?php foreach($detil as $d): ?>
                                        <li><?= htmlspecialchars($d['namaalat'] ?? '-') ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </td>
                            <td>
                                <ul class="mb-0">
                                    <?php foreach($detil as $d): ?>
                                        <li><?= $d['tanggalpinjam'] ?? '-' ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </td>
                            <td>
                                <ul class="mb-0">
                                    <?php foreach($detil as $d): ?>
                                        <li><?= $d['tanggalkembali'] ?? '-' ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </td>
                            <td>
                                <ul class="mb-0">
                                    <?php foreach($detil as $d): ?>
                                        <?php
                                        $badge = ($d['keterangan'] === 'belumkembali') ? 'bg-warning' : 'bg-success';
                                        ?>
                                        <li><span class="badge <?= $badge ?>"><?= ucfirst($d['keterangan']) ?></span></li>
                                    <?php endforeach; ?>
                                </ul>
                            </td>
                            <td class="text-center">
                                <a href="<?= BASE_URL ?>dashboard.php?hal=pengembalian/tambahpengembalian&idpeminjaman=<?= intval($pm['idpeminjaman']) ?>"
                                   class="btn btn-success btn-sm">
                                   <i class="fas fa-undo"></i> Kembalikan
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#datatable').DataTable();
});
</script>

<?php include PAGES_PATH . 'user/footer.php'; ?>
