<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Peminjam | Peminjaman Alat RPL</title>

  <!-- Path asset relatif -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../plugins/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">

  <style>
    body {
      background-color: #f4f6f9;
    }
    .login-logo img {
      max-width: 120px;
    }
    .login-card-body {
      border-radius: 6px;
    }
  </style>
</head>
<body class="hold-transition login-page">

<div class="login-box">
  <div class="login-logo text-center">
    <img src="../../dist/img/AdminLTELogo.png" alt="Logo"><br>
    <b>Peminjaman</b> Alat RPL
  </div>

  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Masuk ke Akun <b>Peminjam</b></p>

      <!-- Arahkan ke dblogin dengan role peminjam -->
      <form action="../../db/dblogin.php?role=peminjam" method="post">
        <div class="input-group mb-3">
          <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-user"></span></div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-success btn-block">Masuk</button>
          </div>
        </div>
      </form>

      <p class="mt-3 mb-0 text-center">
        <a href="../../index.php" class="text-primary">
          <i class="fas fa-arrow-left"></i> Kembali ke Beranda
        </a>
      </p>
    </div>
  </div>
</div>

<!-- JS -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>
</body>
</html>
