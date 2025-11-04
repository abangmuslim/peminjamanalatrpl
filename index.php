<?php
// =========================
//  ROUTE SENTRAL (index.php)
// =========================

define('BASE_PATH', __DIR__);
require_once BASE_PATH . '/koneksi.php';

// Mulai session
session_start();

// =========================
// CEK LOGIN & REDIREKSI
// =========================

// Jika belum login, arahkan ke login sesuai role
if (!isset($_SESSION['role'])) {
  header("Location: views/peminjam/loginpeminjam.php"); // default ke login peminjam
  exit();
}

$halaman = isset($_GET['halaman']) ? $_GET['halaman'] : 'dashboardadmin';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Peminjaman Alat RPL</title>

  <!-- ============ CSS ============ -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- =========================
       PRELOADER
  ========================== -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="Logo" height="60" width="60">
  </div>

  <!-- =========================
       NAVBAR
  ========================== -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <?php include BASE_PATH . '/pages/navbar.php'; ?>
  </nav>

  <!-- =========================
       SIDEBAR
  ========================== -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <?php include BASE_PATH . '/pages/sidebar.php'; ?>
  </aside>

  <!-- =========================
       CONTENT WRAPPER
  ========================== -->
  <div class="content-wrapper">
    <section class="content pt-3">
      <div class="container-fluid">
        <?php
        // =========================
        // ROUTER HALAMAN
        // =========================
        if (isset($_GET['halaman'])) {
          switch ($_GET['halaman']) {

            // ===== ADMIN =====
            case "admin": include BASE_PATH . "/views/admin/admin.php"; break;
            case "tambahadmin": include BASE_PATH . "/views/admin/tambahadmin.php"; break;
            case "editadmin": include BASE_PATH . "/views/admin/editadmin.php"; break;

            // ===== PEMINJAM =====
            case "peminjam": include BASE_PATH . "/views/peminjam/peminjam.php"; break;
            case "tambahpeminjam": include BASE_PATH . "/views/peminjam/tambahpeminjam.php"; break;
            case "editpeminjam": include BASE_PATH . "/views/peminjam/editpeminjam.php"; break;

            // ===== ALAT =====
            case "alat": include BASE_PATH . "/views/alat/alat.php"; break;
            case "tambahalat": include BASE_PATH . "/views/alat/tambahalat.php"; break;
            case "editalat": include BASE_PATH . "/views/alat/editalat.php"; break;

            // ===== DASHBOARD =====
            case "dashboardadmin": include BASE_PATH . "/views/admin/dashboardadmin.php"; break;
            case "dashboardpeminjam": include BASE_PATH . "/views/peminjam/dashboardpeminjam.php"; break;
            case "dashboard": // fallback universal
              if ($_SESSION['role'] === 'admin') {
                include BASE_PATH . "/views/admin/dashboardadmin.php";
              } else {
                include BASE_PATH . "/views/peminjam/dashboardpeminjam.php";
              }
              break;

            // ===== DEFAULT =====
            default:
              include BASE_PATH . "/pages/notfound.php";
              break;
          }
        } else {
          // Jika tidak ada parameter, tampilkan dashboard sesuai role
          if ($_SESSION['role'] === 'admin') {
            include BASE_PATH . "/views/admin/dashboardadmin.php";
          } else {
            include BASE_PATH . "/views/peminjam/dashboardpeminjam.php";
          }
        }
        ?>
      </div>
    </section>
  </div>

  <!-- =========================
       FOOTER
  ========================== -->
  <footer class="main-footer text-center">
    <strong>&copy; 2025 Aplikasi Peminjaman Alat RPL</strong>
  </footer>

</div> <!-- ./wrapper -->

<!-- ============ JAVASCRIPT ============ -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
