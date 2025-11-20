<?php
// ============================================================
// File: views/otentikasiuser/login.php
// Login aplikasi peminjamanalatrpl
// ============================================================

// Include path & konfigurasi
require_once __DIR__ . '/../../includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';

// Pastikan sesi aktif
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Jika user sudah login, redirect sesuai role
if (isset($_SESSION['role'])) {
  if ($_SESSION['role'] === 'admin') {
    header("Location: " . BASE_URL . "?hal=dashboardadmin");
    exit();
  } elseif ($_SESSION['role'] === 'petugas') {
    header("Location: " . BASE_URL . "?hal=dashboardpetugas");
    exit();
  } elseif ($_SESSION['role'] === 'peminjam') {
    header("Location: " . BASE_URL . "?hal=dashboardpeminjam");
    exit();
  }
}

// Ambil pesan error dari redirect prosesloginuser.php
$error = $_GET['pesan'] ?? '';
?>

<style>
  .login-wrapper {
    min-height: calc(100vh - 100px);
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .toggle-password {
    position: absolute;
    right: 15px;
    top: 38px;
    cursor: pointer;
    color: #777;
  }
</style>

<div class="login-wrapper">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card shadow-lg border-0">

          <!-- HEADER BIRU -->
          <div class="card-header bg-danger text-white text-center py-3">
            <h3 class="m-0 fw-bold">Login User</h3>
            <small class="text-light" style="opacity: 0.9;">(admin / petugas)</small>
          </div>

          <div class="card-body p-4">

            <?php if (!empty($error)): ?>
              <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="?hal=prosesloginuser">
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
              </div>

              <div class="mb-3 position-relative">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
                <span class="toggle-password" onclick="togglePassword()">👁️</span>
              </div>

              <div class="d-grid">
                <button type="submit" class="btn btn-danger">Login</button>
              </div>
            </form>

            <div class="text-center mt-3">
              <a href="<?= BASE_URL ?>">← Kembali ke Beranda</a>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
  function togglePassword() {
    const pass = document.getElementById('password');
    pass.type = pass.type === 'password' ? 'text' : 'password';
  }
</script>