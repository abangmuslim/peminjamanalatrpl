<?php
include "koneksi.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aplikasi Peminjaman Alat RPL</title>

  <!-- AdminLTE & Bootstrap -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

  <style>
    body {
      background-color: #f4f6f9;
    }
    .hero {
      position: relative;
      background: url('foto/smkn1karangbaru.jpg') no-repeat center center/cover;
      height: 300px;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
    }
    .hero::after {
      content: "";
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.4);
    }
    .hero-content {
      position: relative;
      z-index: 1;
    }
    .hero h1 {
      font-weight: bold;
    }
    .navbar-custom {
      background-color: #1e3a8a; /* biru tua */
    }
    .navbar-custom .nav-link {
      color: #fff !important;
    }
    .btn-login {
      border-radius: 30px;
      font-weight: bold;
    }
    .card-alat img {
      height: 200px;
      object-fit: cover;
    }
    footer {
      background-color: #1e3a8a;
      color: white;
      text-align: center;
      padding: 15px 0;
      margin-top: 30px;
    }
  </style>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
      <a class="navbar-brand text-white font-weight-bold" href="#">PEMINJAMAN ALAT RPL</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon text-white"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a href="#" class="nav-link">Home</a></li>
          <li class="nav-item"><a href="#" class="nav-link">Tentang</a></li>
          <li class="nav-item"><a href="#" class="nav-link">Kontak</a></li>
          <!-- Login diarahkan ke folder views -->
          <li class="nav-item">
            <a href="views/admin/loginadmin.php" class="btn btn-light btn-sm mx-2 btn-login">
              <i class="fas fa-user-shield"></i> Login Admin
            </a>
          </li>
          <li class="nav-item">
            <a href="views/peminjam/loginpeminjam.php" class="btn btn-warning btn-sm btn-login">
              <i class="fas fa-user"></i> Login Peminjam
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <div class="hero">
    <div class="hero-content">
      <h1>Koleksi Alat Terlengkap</h1>
      <p>Ratusan alat siap digunakan untuk pembelajaran dan proyek praktik siswa</p>
      <a href="#katalog" class="btn btn-primary btn-lg mt-2">Lihat Katalog</a>
    </div>
  </div>

  <!-- Katalog Alat -->
  <section id="katalog" class="container mt-5">
    <div class="text-center mb-4">
      <h2><b>Katalog Alat</b></h2>
      <p class="text-muted">Temukan alat yang tersedia untuk dipinjam</p>
    </div>

    <div class="row">
      <?php
      $query = mysqli_query($koneksi, "
        SELECT alat.*, kategori.namakategori 
        FROM alat 
        LEFT JOIN kategori ON alat.idkategori = kategori.idkategori
      ");
      while ($data = mysqli_fetch_assoc($query)) {
        $foto = !empty($data['foto']) ? "foto/" . $data['foto'] : "dist/img/noimage.jpg";
      ?>
        <div class="col-md-3 mb-4">
          <div class="card card-alat h-100">
            <img src="<?php echo $foto; ?>" class="card-img-top" alt="Foto Alat">
            <div class="card-body">
              <h5 class="card-title text-center"><?php echo $data['namaalat']; ?></h5>
              <p>
                <b>Kondisi:</b> <?php echo $data['kondisi']; ?><br>
                <b>Rak:</b> <?php echo $data['rak']; ?><br>
                <b>Kategori:</b> <?php echo $data['namakategori']; ?><br>
                <b>Tanggal Pembelian:</b> <?php echo $data['tanggalpembelian']; ?>
              </p>
            </div>
            <div class="card-footer text-center">
              <a href="#" class="btn btn-primary btn-sm">Lihat Selengkapnya</a>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <p>© <?php echo date("Y"); ?> Aplikasi Peminjaman Alat RPL SMKN 1 Karang Baru</p>
  </footer>

  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="dist/js/adminlte.min.js"></script>
</body>
</html>
