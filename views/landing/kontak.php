<?php
// ===============================================
// File: views/landing/kontak.php
// Deskripsi: Halaman kontak untuk pengunjung
// ===============================================
?>

<div class="container-fluid my-4 px-4">
  <div class="row justify-content-center">

    <!-- Konten utama -->
    <div class="col-lg-10">
      <h3 class="mb-4 border-bottom pb-2">Kontak Kami</h3>

      <div class="card shadow-sm mb-3">
        <div class="card-body">
          <p>Silakan hubungi kami melalui informasi berikut:</p>
          <ul>
            <li>Email: <a href="mailto:admin@smk-rpl.sch.id">admin@smk-rpl.sch.id</a></li>
            <li>Telepon/WA: +62 812 3456 7890</li>
            <li>Alamat: Jl. Contoh No.123, Kota Contoh, Indonesia</li>
          </ul>

          <p>Atau gunakan formulir kontak (opsional) untuk mengirim pesan langsung.</p>
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
