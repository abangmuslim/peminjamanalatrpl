<?php
// ============================
// DASHBOARD ADMIN
// ============================
session_start();
include "../../koneksi.php";

// Cegah akses tanpa login
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../peminjam/loginpeminjam.php");
  exit();
}

$idadmin = $_SESSION['id'];
$namaadmin = $_SESSION['nama'];
$fotoadmin = !empty($_SESSION['foto']) ? $_SESSION['foto'] : 'default.png';

// ============================
// RINGKASAN DATA UTAMA
// ============================
$totalAdmin     = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM admin"))['total'];
$totalPeminjam  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM peminjam"))['total'];
$totalKategori  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM kategori"))['total'];
$totalAlat      = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM alat"))['total'];

// ============================
// STATISTIK DENDA
// ============================
$totalDenda     = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(jumlahdenda) AS total FROM denda"))['total'] ?? 0;
$totalDibayar   = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(jumlahdenda) AS total FROM denda WHERE status='sudah dibayar'"))['total'] ?? 0;
$totalTunggakan = $totalDenda - $totalDibayar;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Admin - Aplikasi Peminjaman Alat RPL</title>

  <!-- CSS -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- =========================
       NAVBAR
  ========================== -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
          <img src="../../foto/<?= htmlspecialchars($fotoadmin) ?>" class="user-image img-circle elevation-2" alt="User Image">
          <span class="d-none d-md-inline"><?= htmlspecialchars($namaadmin) ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <li class="user-header bg-primary">
            <img src="../../foto/<?= htmlspecialchars($fotoadmin) ?>" class="img-circle elevation-2" alt="User Image">
            <p><?= htmlspecialchars($namaadmin) ?><small>Admin</small></p>
          </li>
          <li class="user-footer">
            <a href="../../logout.php" class="btn btn-danger btn-sm float-right">
              <i class="fas fa-sign-out-alt"></i> Logout
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </nav>

  <!-- =========================
       SIDEBAR (dari sidebar.php)
  ========================== -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="dashboardadmin.php" class="brand-link text-center">
      <img src="../../dist/img/AdminLTELogo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity:.8">
      <span class="brand-text font-weight-light">Admin RPL</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../../foto/<?= htmlspecialchars($fotoadmin) ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?= htmlspecialchars($namaadmin) ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="index.php?halaman=dashboard" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>


          <!-- BAGIAN ADMIN -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-plus"></i>
              <p>
                Data Admin
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="index.php?halaman=admin" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>index Admin</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="index.php?halaman=tambahadmin" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tambah Admin</p>
                </a>
              </li>              
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="index.php?halaman=jabatan" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>index jabatan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="index.php?halaman=tambahjabatan" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tambah jabatan</p>
                </a>
              </li>              
            </ul>
          </li>

          <!-- BAGIAN PEMINJAM -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Data peminjam
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="index.php?halaman=peminjam" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>index peminjam</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="index.php?halaman=tambahpeminjam" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tambah peminjam</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="index.php?halaman=asal" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>index asal</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="index.php?halaman=tambahasal" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tambah asal</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="index.php?halaman=peminjambermasalah" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>peminjam Bermasalah</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- BAGIAN peminjaman -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-utensils"></i>
              <p>
                Data alat
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="index.php?halaman=alat" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>index alat</p>
                </a>
              </li>              
              <li class="nav-item">
                <a href="index.php?halaman=tambahalat" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>tambah alat</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="index.php?halaman=kategori" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>index kategori</p>
                </a>
              </li>                           
            </ul>
            
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="index.php?halaman=merk" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>index merk</p>
                </a>
              </li>                           
            </ul>
            
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="index.php?halaman=posisi" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>index posisi</p>
                </a>
              </li>                           
            </ul>

          </li>
          
          <!-- BAGIAN peminjaman -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-utensils"></i>
              <p>
                Data peminjaman
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="index.php?halaman=daftarpeminjaman" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>daftar peminjaman</p>
                </a>
              </li>              
              <li class="nav-item">
                <a href="index.php?halaman=tambahpeminjaman" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>tambah peminjaman</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="index.php?halaman=daftarpengembalian" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>daftar pengembalian</p>
                </a>
              </li>                           
            </ul>
            

          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- =========================
       CONTENT
  ========================== -->
  <div class="content-wrapper">
    <section class="content pt-3">
      <div class="container-fluid">

        <div class="card card-solid shadow-sm">
          <div class="card-header bg-gradient-primary text-white">
            <h4 class="mb-0"><i class="fas fa-tachometer-alt"></i> Dashboard Admin</h4>
          </div>
          <div class="card-body">
            <div class="row text-center mb-4">
              <div class="col-md-3"><div class="small-box bg-info text-white p-3 rounded-lg"><h4><?= $totalAdmin ?></h4><p>Admin</p></div></div>
              <div class="col-md-3"><div class="small-box bg-danger text-white p-3 rounded-lg"><h4><?= $totalPeminjam ?></h4><p>Peminjam</p></div></div>
              <div class="col-md-3"><div class="small-box bg-success text-white p-3 rounded-lg"><h4><?= $totalKategori ?></h4><p>Kategori</p></div></div>
              <div class="col-md-3"><div class="small-box bg-warning text-white p-3 rounded-lg"><h4><?= $totalAlat ?></h4><p>Alat</p></div></div>
            </div>

            <div class="row text-center mb-4">
              <div class="col-md-4"><div class="small-box bg-info p-3"><h4>Rp <?= number_format($totalDenda,0,',','.') ?></h4><p>Total Denda</p></div></div>
              <div class="col-md-4"><div class="small-box bg-success p-3"><h4>Rp <?= number_format($totalDibayar,0,',','.') ?></h4><p>Denda Dibayar</p></div></div>
              <div class="col-md-4"><div class="small-box bg-warning p-3"><h4>Rp <?= number_format($totalTunggakan,0,',','.') ?></h4><p>Tunggakan</p></div></div>
            </div>

            <div class="row mt-3">
              <div class="col-md-6">
                <div class="card shadow-sm">
                  <div class="card-header bg-info text-white"><b>Grafik Jumlah Data</b></div>
                  <div class="card-body chart-container" style="height:300px;">
                    <canvas id="chart1"></canvas>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

      </div>
    </section>
  </div>

  <footer class="main-footer text-center">
    <strong>&copy; 2025 Aplikasi Peminjaman Alat RPL</strong>
  </footer>
</div>

<!-- JS -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="../../plugins/chart.js/Chart.min.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>

<script>
const ctx = document.getElementById('chart1').getContext('2d');
new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ['Admin', 'Peminjam', 'Kategori', 'Alat'],
    datasets: [{
      label: 'Jumlah',
      data: [<?= $totalAdmin ?>, <?= $totalPeminjam ?>, <?= $totalKategori ?>, <?= $totalAlat ?>],
      backgroundColor: ['#17a2b8','#dc3545','#28a745','#ffc107']
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    scales: { y: { beginAtZero: true } },
    plugins: { legend: { display: false } }
  }
});
</script>
</body>
</html>
