<?php
// =======================================
// File: pages/user/sidebarpetugas.php
// Sidebar untuk PETUGAS (sama seperti admin, TAPI tanpa menu kelola user)
// =======================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../includes/path.php';
require_once __DIR__ . '/../../includes/koneksi.php';

// DATA USER LOGIN
$iduser = $_SESSION['iduser'] ?? 0;
$dataUser = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE iduser='$iduser'"));
$namaUser = $dataUser['namauser'] ?? 'Petugas';
$fotoUser = $dataUser['foto'] ?? 'default.png';
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="dashboard.php?hal=dashboardpetugas" class="brand-link text-center">
    <span class="brand-text font-weight-bold">PeminjamanAlatRPL</span>
  </a>

  <div class="sidebar">

    <!-- Panel User -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?= BASE_URL ?>uploads/user/<?= htmlspecialchars($fotoUser) ?>" 
             class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?= htmlspecialchars($namaUser) ?> (Petugas)</a>
      </div>
    </div>

    <!-- MENU -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">

        <li class="nav-item">
          <a href="dashboard.php?hal=dashboardpetugas" class="nav-link">
            <i class="nav-icon fas fa-home"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- ASAL -->
        <li class="nav-item">
          <a href="dashboard.php?hal=asal/daftarasal" class="nav-link">
            <i class="nav-icon fas fa-map"></i>
            <p>Kelola Asal</p>
          </a>
        </li>

        <!-- JABATAN -->
        <li class="nav-item">
          <a href="dashboard.php?hal=jabatan/daftarjabatan" class="nav-link">
            <i class="nav-icon fas fa-id-card"></i>
            <p>Kelola Jabatan</p>
          </a>
        </li>

        <!-- KATEGORI -->
        <li class="nav-item">
          <a href="dashboard.php?hal=kategori/daftarkategori" class="nav-link">
            <i class="nav-icon fas fa-folder"></i>
            <p>Kelola Kategori</p>
          </a>
        </li>

        <!-- MERK -->
        <li class="nav-item">
          <a href="dashboard.php?hal=merk/daftarmerk" class="nav-link">
            <i class="nav-icon fas fa-tags"></i>
            <p>Kelola Merk</p>
          </a>
        </li>

        <!-- ALAT -->
        <li class="nav-item">
          <a href="dashboard.php?hal=alat/daftaralat" class="nav-link">
            <i class="nav-icon fas fa-toolbox"></i>
            <p>Kelola Alat</p>
          </a>
        </li>

        <!-- PEMINJAM -->
        <li class="nav-item">
          <a href="dashboard.php?hal=peminjam/daftarpeminjam" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>Kelola Peminjam</p>
          </a>
        </li>

        <!-- PEMINJAMAN -->
        <li class="nav-item">
          <a href="dashboard.php?hal=peminjaman/daftarpeminjaman" class="nav-link">
            <i class="nav-icon fas fa-handshake"></i>
            <p>Kelola Peminjaman</p>
          </a>
        </li>

        <!-- PENGEMBALIAN -->
        <li class="nav-item">
          <a href="dashboard.php?hal=pengembalian/daftarpengembalian" class="nav-link">
            <i class="nav-icon fas fa-undo"></i>
            <p>Pengembalian</p>
          </a>
        </li>

        <!-- LAPORAN -->
        <li class="nav-item">
          <a href="dashboard.php?hal=laporan/daftarlaporan" class="nav-link">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>Laporan</p>
          </a>
        </li>

      </ul>
    </nav>

  </div>
</aside>
