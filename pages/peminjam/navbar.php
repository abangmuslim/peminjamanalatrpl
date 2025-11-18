<?php
// ==============================================
// File: pages/peminjam/navbar.php
// Deskripsi: Navbar + Breadcrumb otomatis + Logout Peminjam
// ==============================================

$namapeminjam = $_SESSION['namapeminjam'] ?? 'Peminjam';
$foto         = $_SESSION['foto'] ?? 'default.png';

// Logout URL untuk peminjam
$logout_url = BASE_URL . '?hal=logoutpeminjam';

/**
 * =====================================================
 * Fungsi otomatis membentuk breadcrumb
 * =====================================================
 */
if (!function_exists('buat_breadcrumb_otomatis')) {
    function buat_breadcrumb_otomatis()
    {
        $hal = $_GET['hal'] ?? 'dashboardpeminjam';

        // Dashboard utama
        if ($hal === 'dashboardpeminjam') {
            echo '<ol class="breadcrumb float-sm-right"><li class="breadcrumb-item active">Dashboard</li></ol>';
            return;
        }

        $parts = explode('/', $hal);
        $breadcrumb = [];

        // Tambahkan Dashboard sebagai awal
        $breadcrumb[] = '<li class="breadcrumb-item"><a href="' . BASE_URL . '?hal=dashboardpeminjam">Dashboard</a></li>';

        // Fallback menu otomatis (opsional)
        for ($i = 0; $i < count($parts); $i++) {
            $segment = htmlspecialchars(ucfirst(str_replace(['_', '-'], ' ', $parts[$i])));
            if ($i < count($parts) - 1) {
                $suburl = BASE_URL . '?hal=' . implode('/', array_slice($parts, 0, $i + 1));
                $breadcrumb[] = '<li class="breadcrumb-item"><a href="' . $suburl . '">' . $segment . '</a></li>';
            } else {
                $breadcrumb[] = '<li class="breadcrumb-item active">' . $segment . '</li>';
            }
        }

        echo '<ol class="breadcrumb float-sm-right">' . implode('', $breadcrumb) . '</ol>';
    }
}

/**
 * =====================================================
 * Fungsi otomatis membuat judul halaman
 * =====================================================
 */
if (!function_exists('judul_halaman_otomatis')) {
    function judul_halaman_otomatis()
    {
        $hal = $_GET['hal'] ?? 'dashboardpeminjam';
        if ($hal === 'dashboardpeminjam') return 'Dashboard';
        $parts = explode('/', $hal);
        return ucfirst(str_replace(['_', '-'], ' ', end($parts)));
    }
}
?>

<!-- ============================================== -->
<!-- NAVBAR ATAS DASHBOARD PEMINJAM -->
<!-- ============================================== -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">

  <!-- Kiri: home -->
  <ul class="navbar-nav">
    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?= BASE_URL ?>?hal=dashboardpeminjam" class="nav-link">Beranda</a>
    </li>
  </ul>

  <!-- Kanan: user menu -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown user-menu">
      <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
        <img src="<?= BASE_URL ?>uploads/peminjam/<?= $foto ?>"
             class="img-circle elevation-2" style="width:30px;height:30px;object-fit:cover;">
        <?= htmlspecialchars($namapeminjam); ?> (Peminjam)
      </a>
      <ul class="dropdown-menu dropdown-menu-right">
        <li><a class="dropdown-item" href="#"><i class="fas fa-id-card mr-2"></i> Profil</a></li>
        <li><a class="dropdown-item text-danger" href="<?= $logout_url ?>"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a></li>
      </ul>
    </li>
  </ul>

</nav>

<!-- ============================================== -->
<!-- HEADER + BREADCRUMB OTOMATIS -->
<!-- ============================================== -->
<div class="content-header">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <h5 class="m-0"><?= judul_halaman_otomatis(); ?></h5>
    <?php buat_breadcrumb_otomatis(); ?>
  </div>
</div>
