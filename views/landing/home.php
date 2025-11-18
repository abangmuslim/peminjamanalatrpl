<?php
// ===============================================
// File: views/landing/home.php
// Deskripsi: Halaman utama landing portal peminjaman alat
// ===============================================

// Ambil 12 alat terbaru berdasarkan tanggal pembelian
$query = "
  SELECT a.*, k.namakategori
  FROM alat a
  LEFT JOIN kategori k ON a.idkategori = k.idkategori
  ORDER BY a.tanggalpembelian DESC
  LIMIT 12
";
$alat = $koneksi->query($query);

// Include Hero Section (hanya sekali)
$heroFile = PAGES_PATH . 'landing/hero.php';
if (file_exists($heroFile)) {
    include_once $heroFile; // include_once untuk menghindari duplikasi
}
?>

<div class="container-fluid my-4 px-4">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <h3 class="mb-4 border-bottom pb-2">Daftar Alat Terbaru</h3>

      <?php if ($alat && $alat->num_rows > 0): ?>
        <?php while ($a = $alat->fetch_assoc()): ?>
          <div class="card mb-3 shadow-sm">
            <div class="row g-0 align-items-center">
              <div class="col-md-3">
                <?php 
                $fotoPath = __DIR__ . '/../../uploads/alat/' . ($a['foto'] ?? '');
                if (!empty($a['foto']) && file_exists($fotoPath)): ?>
                  <img src="<?= $base_url . 'uploads/alat/' . $a['foto']; ?>"
                       class="img-fluid rounded-start"
                       alt="<?= htmlspecialchars($a['namaalat']); ?>">
                <?php else: ?>
                  <img src="<?= $base_url . 'assets/dist/img/placeholder.png'; ?>"
                       class="img-fluid rounded-start"
                       alt="No Image">
                <?php endif; ?>
              </div>

              <div class="col-md-9">
                <div class="card-body">
                  <h5 class="card-title mb-1"><?= htmlspecialchars($a['namaalat']); ?></h5>
                  <p class="text-muted small mb-2">
                    <?php if (!empty($a['namakategori'])): ?>
                      [Kategori: <?= htmlspecialchars($a['namakategori']); ?>]
                    <?php endif; ?>
                    [Ditambahkan: <?= !empty($a['tanggalpembelian']) ? date('d M Y', strtotime($a['tanggalpembelian'])) : '-'; ?>]
                  </p>
                  <p class="card-text mb-3"><?= substr(strip_tags($a['deskripsi'] ?? ''), 0, 120); ?>...</p>
                  <a href="<?= $base_url . '?hal=detilalat&id=' . $a['idalat']; ?>" class="btn btn-sm btn-success">Lihat Detail</a>
                </div>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p class="text-muted">Belum ada alat yang tersedia.</p>
      <?php endif; ?>
    </div>

    <!-- Sidebar kanan -->
    <div class="col-lg-2">
      <?php 
      $sidebarFile = PAGES_PATH . 'landing/sidebar-right.php';
      if (file_exists($sidebarFile)) {
          include_once $sidebarFile; // include_once untuk menghindari ganda
      } else {
          echo '<div class="text-muted small">Sidebar kanan belum tersedia.</div>';
      }
      ?>
    </div>
  </div>
</div>
