<?php
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';

/* ============================
   AMBIL DATA ALAT + RELASI
=============================== */

$sql = "SELECT a.*, 
        k.namakategori, 
        m.namamerk, 
        s.namaposisi
        FROM alat a
        LEFT JOIN kategori k ON a.idkategori = k.idkategori
        LEFT JOIN merk m ON a.idmerk = m.idmerk
        LEFT JOIN posisi s ON a.idposisi = s.idposisi
        ORDER BY a.idalat DESC";

$result = mysqli_query($koneksi, $sql);
$alats = mysqli_fetch_all($result, MYSQLI_ASSOC);

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
            <h4 class="mb-0">Daftar Alat</h4>

            <!-- Tombol kanan -->
            <a href="<?= BASE_URL ?>dashboard.php?hal=alat/tambahalat" 
               class="btn btn-light btn-sm">
               <i class="fas fa-plus"></i> Tambah Alat
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
                        <th>Nama Alat</th>
                        <th>Kategori</th>
                        <th>Merk</th>
                        <th>Posisi</th>
                        <th>Kondisi</th>
                        <th>Foto</th>
                        <th>Tgl Pembelian</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($alats as $i => $a): ?>
                        <tr>
                            <td><?= $i+1 ?></td>

                            <td><?= htmlspecialchars($a['namaalat']) ?></td>
                            <td><?= htmlspecialchars($a['namakategori'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($a['namamerk'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($a['namaposisi'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($a['kondisi']) ?></td>

                            <td class="text-center">
                                <?php 
                                    $foto = $a['foto'] ?? '';
                                    $fotoPath = __DIR__ . "/../../../uploads/alat/" . $foto;
                                ?>

                                <?php if (!empty($foto) && file_exists($fotoPath)): ?>
                                    <img src="<?= BASE_URL ?>uploads/alat/<?= htmlspecialchars($foto) ?>" 
                                        width="50" class="img-thumbnail">
                                <?php else: ?>
                                    <span class="text-muted">No foto</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?= $a['tanggalpembelian'] 
                                        ? date('d M Y', strtotime($a['tanggalpembelian'])) 
                                        : '-' ?>
                            </td>

                            <td class="text-center">

                                <!-- Lihat -->
                                <a href="<?= BASE_URL ?>dashboard.php?hal=alat/tampilalat&id=<?= intval($a['idalat']) ?>"
                                    class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <!-- Edit -->
                                <a href="<?= BASE_URL ?>dashboard.php?hal=alat/editalat&id=<?= intval($a['idalat']) ?>"
                                    class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Hapus -->
                                <form action="<?= BASE_URL ?>views/user/alat/prosesalat.php?aksi=hapus&id=<?= intval($a['idalat']) ?>"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin hapus alat ini?')">

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
