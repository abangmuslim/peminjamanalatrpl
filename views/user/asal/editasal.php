<?php
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';

// Ambil ID
$id = $_GET['id'] ?? 0;

// Ambil data asal untuk diedit
$stmt = $koneksi->prepare("SELECT * FROM asal WHERE idasal = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$asal = $result->fetch_assoc();

if (!$asal) {
    header("Location: " . BASE_URL . "dashboard.php?hal=asal/daftarasal&msg=notfound");
    exit;
}

// Ambil semua data asal untuk tabel
$hasil = mysqli_query($koneksi, "SELECT * FROM asal ORDER BY idasal DESC");
?>

<?php include PAGES_PATH . 'user/header.php'; ?>
<?php include PAGES_PATH . 'user/navbar.php'; ?>
<?php include PAGES_PATH . 'user/sidebar.php'; ?>

<div class="content p-3">
  <section class="content">
    <div class="container-fluid">
      <div class="row">

        <!-- ========== FORM EDIT ASAL ========== -->
        <div class="col-md-4">
          <div class="card card-warning">
            <div class="card-header bg-gradient-warning">
              <h3 class="card-title"><i class="fas fa-edit"></i> Edit Asal</h3>
            </div>

            <form action="<?= BASE_URL ?>views/user/asal/prosesasal.php" method="POST">
              <input type="hidden" name="aksi" value="edit">
              <input type="hidden" name="idasal" value="<?= $asal['idasal'] ?>">

              <div class="card-body">
                <div class="form-group">
                  <label>Nama Asal</label>
                  <input type="text" class="form-control"
                         name="namaasal"
                         value="<?= htmlspecialchars($asal['namaasal']); ?>"
                         required>
                </div>
              </div>

              <div class="card-footer text-right">
                <a href="<?= BASE_URL ?>dashboard.php?hal=asal/daftarasal"
                   class="btn btn-secondary btn-sm">
                  <i class="fas fa-arrow-left"></i> Batal
                </a>

                <button type="submit" class="btn btn-primary btn-sm">
                  <i class="fas fa-save"></i> Update
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- ========== DAFTAR ASAL ========== -->
        <div class="col-md-8">
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
              <h5 class="m-0">Daftar Asal</h5>
            </div>

            <div class="card-body table-responsive">
              <table class="table table-bordered table-striped">
                <thead class="text-center bg-light">
                  <tr>
                    <th style="width:5%;">No</th>
                    <th>Nama Asal</th>
                    <th style="width:15%;">Aksi</th>
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

                      <a onclick="return confirm('Hapus asal ini?')"
                         href="<?= BASE_URL ?>views/user/asal/prosesasal.php?aksi=hapus&id=<?= $a['idasal'] ?>"
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
