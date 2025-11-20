<?php
// ============================================================
// File: views/otentikasipeminjam/registerpeminjam.php
// Form registrasi peminjam baru
// ============================================================

require_once __DIR__ . '/../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'konfig.php';

// Pastikan sesi aktif
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Ambil daftar asal
$asalResult = mysqli_query($koneksi, "SELECT * FROM asal ORDER BY namaasal ASC");
$asalList = mysqli_fetch_all($asalResult, MYSQLI_ASSOC);

// Ambil pesan error / success
$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
?>

<style>
  .login-wrapper {
    min-height: calc(100vh - 100px);
    display: flex;
    justify-content: center;
    align-items: center;
  }
</style>

<div class="login-wrapper">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card shadow-lg border-0">

          <!-- HEADER KUNING -->
          <div class="card-header bg-warning text-center py-3">
            <h3 class="m-0 fw-bold">Register Peminjam Baru</h3>
          </div>

          <div class="card-body p-4">

            <?php if ($error): ?>
              <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php elseif ($success): ?>
              <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <form method="POST" action="?hal=otentikasipeminjam/prosesregisterpeminjam" enctype="multipart/form-data">

              <div class="mb-3">
                <label for="namapeminjam" class="form-label">Nama Lengkap</label>
                <input type="text" name="namapeminjam" id="namapeminjam" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                  <input type="password" name="password" id="password" class="form-control" required>
                  <span class="input-group-text toggle-password" onclick="togglePassword()" style="cursor:pointer;">👁️</span>
                </div>
              </div>

              <div class="mb-3">
                <label for="idasal" class="form-label">Asal</label>
                <select name="idasal" id="idasal" class="form-control">
                  <option value="">-- Pilih Asal --</option>
                  <?php foreach ($asalList as $a): ?>
                    <option value="<?= $a['idasal'] ?>"><?= htmlspecialchars($a['namaasal']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="mb-3">
                <label for="foto" class="form-label">Foto (opsional)</label>
                <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
              </div>

              <div class="d-grid mb-2">
                <button type="submit" class="btn btn-primary">Register</button>
              </div>
            </form>

            <div class="text-center mt-1">
              <a href="<?= BASE_URL ?>?hal=otentikasipeminjam/loginpeminjam">← Kembali ke Login</a>
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