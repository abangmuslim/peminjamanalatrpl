<?php
// ===============================================
// File: pages/user/navbar.php
// ===============================================

require_once __DIR__ . '/../../includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'ceksession.php';

// Ambil info user login
$nama = $_SESSION['namauser'] ?? $_SESSION['namalengkap'] ?? 'User';
$foto = $_SESSION['foto'] ?? 'default.png';
$role = $_SESSION['role'] ?? 'user';

// Tentukan logout berdasarkan role
$logout_url = BASE_URL . '?hal=' . (
    $role === 'peminjam' ? 'logoutpeminjam' : 'logoutuser'
);
?>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">

  <!-- Left navbar -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">
        <i class="fas fa-bars"></i>
      </a>
    </li>
  </ul>

  <!-- Right navbar -->
  <ul class="navbar-nav ml-auto">

    <!-- User Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <img src="<?= BASE_URL ?>uploads/user/<?= $foto ?>"
             class="img-circle elevation-2"
             style="width:30px;height:30px;object-fit:cover;">
        <span class="ml-1"><?= htmlspecialchars($nama) ?></span>
      </a>

      <div class="dropdown-menu dropdown-menu-right">
        <a href="#" class="dropdown-item disabled">
          <i class="fas fa-user mr-2"></i> <?= htmlspecialchars(ucwords($role)) ?>
        </a>

        <div class="dropdown-divider"></div>

        <!-- LOGOUT SESUAI ROUTING BARU -->
        <a href="<?= $logout_url ?>" class="dropdown-item text-danger">
          <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </a>
      </div>
    </li>

  </ul>
</nav>
