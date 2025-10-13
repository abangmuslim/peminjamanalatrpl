<?php
include 'koneksi.php'; // atau sesuaikan path

$query = mysqli_query($koneksi, "SELECT * FROM admin");
// while ($data = mysqli_fetch_assoc($query)) {
//     echo $data['namaadmin'] . "<br>";
// }
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'pages/header.php'; ?>
</head>


<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-collapse">

  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
      <?php include 'pages/navbar.php'; ?>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <?php include 'pages/sidebar.php'; ?>
    </aside>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard v2</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard v2</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <?php

        if (isset($_GET['halaman'])) {
          switch ($_GET['halaman']) {

            // bagian admin
            case "admin";
              include("views/admin/admin.php");
              break;
            case "tambahadmin";
              include("views/admin/tambahadmin.php");
              break;
            case "editadmin";
              include("views/admin/editadmin.php");
              break;

            // bagian peminjam
            case "peminjam";
              include("views/peminjam/peminjam.php");
              break;
            case "tambahpeminjam";
              include("views/peminjam/tambahpeminjam.php");
              break;
            case "editpeminjam";
              include("views/peminjam/editpeminjam.php");
              break;

              // bagian alat
            case "alat";
              include("views/alat/alat.php");
              break;
            case "tambahalat";
              include("views/alat/tambahalat.php");
              break;
            case "editalat";
              include("views/alat/editalat.php");
              break;


            case "dashboard";
              include("views/dashboard.php");
              break;
            case "home";
              include("views/dashboard.php");
              break;
            case "default";
              include("views/notfound.php");
          }

        } else {
          include("pages/notfound.php");
        }
        ?>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <?php include 'pages/footer.php'; ?>
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>

  <!-- PAGE PLUGINS -->
  <!-- jQuery Mapael -->
  <script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
  <script src="plugins/raphael/raphael.min.js"></script>
  <script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
  <script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>

  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="dist/js/pages/dashboard2.js"></script>
</body>

</html>