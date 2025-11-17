<?php
// ===============================================
// File: views/landing/kategori.php
// Deskripsi: Halaman daftar kategori alat
// ===============================================

// Ambil semua kategori
$query = "SELECT * FROM kategori ORDER BY namakategori ASC";
$kategori = $koneksi->query($query);
?>

<div class="container-fluid my-4 px-4">
  <div class="row justify-content-center">

    <!-- Konten utama -->
    <div class="col-lg-10">
      <h3 class="mb-4 border-bottom pb-2">
        Daftar Kategori Alat
      </h3>

      <?php if ($kategori && $kategori->num_rows > 0): ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
          <?php while ($k = $kategori->fetch_assoc()): ?>
            <div class="col">
              <div class="card h-100 shadow-sm">
                <div class="card-body">
                  <h5 class="card-title"><?= htmlspecialchars($k['namakategori']); ?></h5>
                  <a href="<?= $base_url . '?hal=home&kategori=' . $k['idkategori']; ?>"
                     class="btn btn-sm btn-primary">
                    Lihat Alat
                  </a>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
      <?php else: ?>
        <p class="text-muted">Belum ada kategori tersedia.</p>
      <?php endif; ?>
    </div>

    <!-- Sidebar kanan -->
    <div class="col-lg-2">
      <?php 
      $sidebarFile = PAGES_PATH . 'landing/sidebar-right.php';
      if (file_exists($sidebarFile)) {
          include $sidebarFile;
      } else {
          echo '<div class="text-muted small">Sidebar kanan belum tersedia.</div>';
      }
      ?>
    </div>

  </div>
</div>
