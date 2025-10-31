<?php
// =========================
//  ROUTE SENTRAL (index.php)
// =========================

// Definisikan path root agar semua include konsisten
define('BASE_PATH', __DIR__);

// Koneksi global (cukup sekali)
require_once BASE_PATH . '/koneksi.php';

// Optional: contoh uji koneksi
// $query = mysqli_query($koneksi, "SELECT * FROM admin");
// while ($data = mysqli_fetch_assoc($query)) {
//     echo $data['namaadmin'] . "<br>";
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include BASE_PATH . '/pages/header.php'; ?>
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-collapse">

  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
      <?php include BASE_PATH . '/pages/navbar.php'; ?>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <?php include BASE_PATH . '/pages/sidebar.php'; ?>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">

      <!-- Content Header -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard v2</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php?halaman=dashboard">Home</a></li>
                <li class="breadcrumb-item active">Dashboard v2</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <!-- /.content-header -->

      <!-- Main Content -->
      <section class="content">
        <?php
        // ROUTER — semua navigasi dikontrol di sini
        if (isset($_GET['halaman'])) {
          switch ($_GET['halaman']) {

              // ===== ADMIN =====
            case "admin":
              include BASE_PATH . "/views/admin/admin.php";
              break;
            case "tambahadmin":
              include BASE_PATH . "/views/admin/tambahadmin.php";
              break;
            case "editadmin":
              include BASE_PATH . "/views/admin/editadmin.php";
              break;

              // ===== ASAL =====
            case "asal":
              include BASE_PATH . "/views/asal/asal.php";
              break;
            case "tambahasal":
              include BASE_PATH . "/views/asal/tambahasal.php";
              break;
            case "editasal":
              include BASE_PATH . "/views/asal/editasal.php";
              break;

              // ===== ASAL =====
            case "jabatan":
              include BASE_PATH . "/views/jabatan/jabatan.php";
              break;
            case "tambahjabatan":
              include BASE_PATH . "/views/jabatan/tambahjabatan.php";
              break;
            case "editjabatan":
              include BASE_PATH . "/views/jabatan/editjabatan.php";
              break;

              // ===== PEMINJAM =====
            case "peminjam":
              include BASE_PATH . "/views/peminjam/peminjam.php";
              break;
            case "tambahpeminjam":
              include BASE_PATH . "/views/peminjam/tambahpeminjam.php";
              break;
            case "editpeminjam":
              include BASE_PATH . "/views/peminjam/editpeminjam.php";
              break;

              // ===== KATEGORI =====
            case "kategori":
              include BASE_PATH . "/views/kategori/kategori.php";
              break;
            case "tambahkategori":
              include BASE_PATH . "/views/kategori/tambahkategori.php";
              break;
            case "editkategori":
              include BASE_PATH . "/views/kategori/editkategori.php";
              break;
              
              // ===== merk =====
            case "merk":
              include BASE_PATH . "/views/merk/merk.php";
              break;
            case "tambahmerk":
              include BASE_PATH . "/views/merk/tambahmerk.php";
              break;
            case "editmerk":
              include BASE_PATH . "/views/merk/editmerk.php";
              break;

              // ===== posisi =====
            case "posisi":
              include BASE_PATH . "/views/posisi/posisi.php";
              break;
            case "tambahposisi":
              include BASE_PATH . "/views/posisi/tambahposisi.php";
              break;
            case "editposisi":
              include BASE_PATH . "/views/posisi/editposisi.php";
              break;

              // ===== ALAT =====
            case "alat":
              include BASE_PATH . "/views/alat/alat.php";
              break;
            case "tambahalat":
              include BASE_PATH . "/views/alat/tambahalat.php";
              break;
            case "editalat":
              include BASE_PATH . "/views/alat/editalat.php";
              break;

              // ===== peminjaman =====
            case "daftarpeminjaman":
              include BASE_PATH . "/views/peminjaman/daftarpeminjaman.php";
              break;
            case "tambahpeminjaman":
              include BASE_PATH . "/views/peminjaman/tambahpeminjaman.php";
              break;
            case "daftarpengembalian":
              include BASE_PATH . "/views/peminjaman/daftarpengembalian.php";
              break;
            case "prosespengembalian":
              include BASE_PATH . "/views/peminjaman/prosespengembalian.php";
              break;


              
              // ===== DASHBOARD / DEFAULT =====
            case "dashboard":
            case "home":
              include BASE_PATH . "/views/dashboard.php";
              break;

              
            default:
              include BASE_PATH . "/pages/notfound.php";
              break;
          }
        } else {
          include BASE_PATH . "/views/dashboard.php"; // default tampilan awal
        }
        ?>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark"></aside>

    <!-- Main Footer -->
    <footer class="main-footer">
      <?php include BASE_PATH . '/pages/footer.php'; ?>
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <script src="dist/js/adminlte.js"></script>

  <!-- PAGE PLUGINS -->
  <script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
  <script src="plugins/raphael/raphael.min.js"></script>
  <script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
  <script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
  <script src="plugins/chart.js/Chart.min.js"></script>

  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <script src="dist/js/pages/dashboard2.js"></script>
</body>

</html>
