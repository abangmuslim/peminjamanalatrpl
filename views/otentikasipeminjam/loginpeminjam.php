<?php
// ============================================================
// File: views/otentikasipeminjam/loginpeminjam.php
// Login aplikasi peminjamanalatrpl untuk role peminjam
// ============================================================

// Include path & konfigurasi
require_once __DIR__ . '/../../includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';

// Pastikan sesi aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Jika peminjam sudah login, redirect ke dashboard
if (isset($_SESSION['role']) && $_SESSION['role'] === 'peminjam') {
    header("Location: " . BASE_URL . "?hal=dashboardpeminjam");
    exit();
}

// Ambil pesan error dari redirect prosesloginpeminjam.php
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
          <div class="card-body p-4">
            <h3 class="text-center mb-4">Login Peminjam</h3>

            <?php if (!empty($error)): ?>
              <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="?hal=prosesloginpeminjam">
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
                <button type="submit" class="btn btn-warning">Login</button>
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
