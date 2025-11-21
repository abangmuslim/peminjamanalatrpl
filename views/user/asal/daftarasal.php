<?php
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';

// Ambil semua asal
$hasil = mysqli_query($koneksi, "SELECT * FROM asal ORDER BY idasal DESC");
?>

<?php include PAGES_PATH . 'user/header.php'; ?>
<?php include PAGES_PATH . 'user/navbar.php'; ?>
<?php include PAGES_PATH . 'user/sidebar.php'; ?>

<!-- ==================== KONTEN UTAMA ==================== -->
<div class="content p-3">
  <section class="content">
    <div class="container-fluid">
      <div class="row">

        <!-- ==================== FORM TAMBAH ==================== -->
        <div class="col-md-4">
          <div class="card card-success">
            <div class="card-header bg-gradient-success">
              <h3 class="card-title"><i class="fas fa-plus-circle"></i> Tambah Asal</h3>
            </div>

            <form action="<?= BASE_URL ?>views/user/asal/prosesasal.php" method="POST">
              <div class="card-body">
                <input type="hidden" name="aksi" value="tambah">

                <div class="form-group">
                  <label>Nama Asal</label>
                  <input type="text" name="namaasal" class="form-control" required>
                </div>
              </div>

              <div class="card-footer text-right">
                <button type="reset" class="btn btn-warning btn-sm">
                  <i class="fas fa-retweet"></i> Reset
                </button>

                <button type="submit" class="btn btn-primary btn-sm">
                  <i class="fas fa-save"></i> Simpan
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- ==================== DAFTAR ASAL ==================== -->
        <div class="col-md-8">
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
              <h5 class="m-0">Daftar Asal</h5>

              <a href="<?= BASE_URL ?>dashboard.php?hal=asal/daftarasal"
                 class="btn btn-light btn-sm text-primary fw-bold">
                <i class="fa fa-sync"></i> Refresh
              </a>
            </div>

            <div class="card-body table-responsive">
              <table class="table table-bordered table-striped">
                <thead class="text-center bg-light">
                  <tr>
                    <th style="width: 5%;">No</th>
                    <th>Nama Asal</th>
                    <th style="width: 15%;">Aksi</th>
                  </tr>
                </thead>

                <tbody>
                  <?php $no = 1; while ($a = mysqli_fetch_assoc($hasil)): ?>
                    <tr>
                      <td class="text-center"><?= $no++; ?></td>
                      <td><?= htmlspecialchars($a['namaasal']); ?></td>

                      <td class="text-center">
                        <a href="<?= BASE_URL ?>dashboard.php?hal=asal/editasal&id=<?= $a['idasal'] ?>"
                           class="btn btn-warning btn-sm">
                          <i class="fa fa-edit"></i>
                        </a>

                        <a onclick="return confirm('Hapus data asal ini?')"
                           href="<?= BASE_URL ?>views/user/asal/prosesasal.php?hapus=<?= $a['idasal'] ?>"
                           class="btn btn-danger btn-sm">
                          <i class="fa fa-trash"></i>
                        </a>
                      </td>

                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </div>

          </div>
        </div>

      </div>
    </div>
  </section>
</div>

<?php include PAGES_PATH . 'user/footer.php'; ?>
