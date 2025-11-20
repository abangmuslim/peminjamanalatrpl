<?php
// ==============================================
// File: pages/user/sidebar.php (FIX FINAL)
// Sidebar Admin - versi MySQLi (bukan PDO)
// ==============================================

// Ambil sesi
$foto_user = 'default.png';
$nama_user = $_SESSION['namauser'] ?? 'Pengguna';
$role_user = $_SESSION['role'] ?? 'Guest';
$iduser    = $_SESSION['userlogin'] ?? 0;

// Ambil foto user (MySQLi)
if ($iduser) {
    $q = mysqli_query($koneksi, "SELECT foto FROM user WHERE iduser = '$iduser' LIMIT 1");
    $d = mysqli_fetch_assoc($q);

    if ($d && !empty($d['foto']) && file_exists(__DIR__ . '/../../uploads/user/' . $d['foto'])) {
        $foto_user = $d['foto'];
    }
}
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="<?= BASE_URL ?>?hal=dashboardadmin" class="brand-link text-center">
        <span class="brand-text font-weight-bold">PeminjamanAlatRPL</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- User Panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
            <div class="image">
                <img src="<?= BASE_URL ?>uploads/user/<?= htmlspecialchars($foto_user) ?>"
                     class="img-circle elevation-2"
                     style="width:35px;height:35px;object-fit:cover;">
            </div>
            <div class="info">
                <a href="<?= BASE_URL ?>?hal=user/profil" class="d-block">
                    <?= htmlspecialchars($nama_user) ?>
                </a>
                <small class="text-muted"><?= ucfirst($role_user) ?></small>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" role="menu">

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>?hal=dashboardadmin" class="nav-link">
                        <i class="nav-icon fas fa-home"></i><p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>?hal=user/daftaruser" class="nav-link">
                        <i class="nav-icon fas fa-users"></i><p>Kelola User</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>?hal=jabatan/daftarjabatan" class="nav-link">
                        <i class="nav-icon fas fa-briefcase"></i><p>Jabatan</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>?hal=alat/daftaralat" class="nav-link">
                        <i class="nav-icon fas fa-tools"></i><p>Alat</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>?hal=kategori/daftarkategori" class="nav-link">
                        <i class="nav-icon fas fa-folder"></i><p>Kategori</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>?hal=peminjaman/daftarpeminjaman" class="nav-link">
                        <i class="nav-icon fas fa-handshake"></i><p>Peminjaman</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= BASE_URL ?>?hal=laporan/daftarlaporan" class="nav-link">
                        <i class="fas fa-chart-line nav-icon"></i><p>Laporan</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
