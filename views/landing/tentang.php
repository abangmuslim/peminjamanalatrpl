<?php
// ===============================================
// File: views/landing/tentang.php
// Deskripsi: Halaman tentang CMS atau aplikasi peminjaman alat
// ===============================================
?>

<div class="container-fluid my-4 px-4">
  <div class="row justify-content-center">

    <!-- Konten utama -->
    <div class="col-lg-10">
      <h3 class="mb-4 border-bottom pb-2">Tentang Aplikasi</h3>

      <div class="card shadow-sm mb-3">
        <div class="card-body">
          <p>
            Selamat datang di portal <strong>Peminjaman Alat RPL</strong>.  
            Aplikasi ini dibuat untuk mempermudah proses peminjaman dan pengelolaan alat di laboratorium RPL SMK.
          </p>
          <p>
            Fitur yang tersedia antara lain:
          </p>
          <ul>
            <li>Daftar alat lengkap dengan kategori dan kondisi</li>
            <li>Peminjaman dan pengembalian alat</li>
            <li>Monitoring alat terbaru dan laporan kegiatan</li>
            <li>Halaman publik dengan informasi alat dan kategori</li>
          </ul>
        </div>
      </div>
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
