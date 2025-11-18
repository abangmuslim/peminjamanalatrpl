<?php
// ============================================================
// File: views/otentikasipeminjam/registerpeminjam.php
// Form pendaftaran akun peminjam
// ============================================================

require_once __DIR__ . '/../../includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect jika sudah login peminjam
if (isset($_SESSION['role']) && $_SESSION['role'] === 'peminjam') {
    header("Location: " . BASE_URL . "?hal=dashboardpeminjam");
    exit();
}

$error = $_GET['pesan'] ?? '';
?>

<style>
.register-wrapper {
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

<div class="register-wrapper">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-lg border-0">
          <div class="card-body p-4">
            <h3 class="text-center mb-4">Daftar Akun Peminjam</h3>

            <?php if (!empty($error)): ?>
              <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="?hal=prosesregisterpeminjam" enctype="multipart/form-data">
              
              <div class="mb-3">
                <label for="namapeminjam" class="form-label">Nama Lengkap</label>
                <input type="text" name="namapeminjam" id="namapeminjam" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
              </div>

              <div class="mb-3 position-relative">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
                <span class="toggle-password" onclick="togglePassword()">👁️</span>
              </div>

              <div class="mb-3">
                <label for="foto" class="form-label">Foto Profil</label>
                <input type="file" name="foto" id="foto" class="form-control">
              </div>

              <div class="mb-3">
                <label for="idasal" class="form-label">Asal</label>
                <select name="idasal" id="idasal" class="form-control" required>
                  <option value="">-- Pilih Asal --</option>
                  <?php
                  $asalList = $koneksi->query("SELECT * FROM asal ORDER BY namaasal ASC");
                  while($a = $asalList->fetch_assoc()) {
                      echo "<option value='{$a['idasal']}'>{$a['namaasal']}</option>";
                  }
                  ?>
                </select>
              </div>

              <!-- Status default pending -->
              <input type="hidden" name="status" value="pending">

              <div class="d-grid">
                <button type="submit" class="btn btn-primary">Daftar</button>
              </div>
            </form>

            <div class="text-center mt-3">
              <a href="?hal=loginpeminjam">← Kembali ke Login</a>
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
