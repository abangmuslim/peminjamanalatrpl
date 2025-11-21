<?php
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';

// Ambil ID
$id = $_GET['id'] ?? 0;

// Ambil data untuk diedit
$stmt = $koneksi->prepare("SELECT * FROM merk WHERE idmerk = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$merk = $result->fetch_assoc();

if (!$merk) {
    header("Location: " . BASE_URL . "dashboard.php?hal=merk/daftarmerk&msg=notfound");
    exit;
}

// Ambil semua data untuk ditampilkan di tabel
$hasil = mysqli_query($koneksi, "SELECT * FROM merk ORDER BY idmerk DESC");
?>

<?php include PAGES_PATH . 'user/header.php'; ?>
<?php include PAGES_PATH . 'user/navbar.php'; ?>
<?php include PAGES_PATH . 'user/sidebar.php'; ?>

<div class="content p-3">
  <section class="content">
    <div class="container-fluid">
      <div class="row">

        <!-- ========== FORM EDIT MERK ========== -->
        <div class="col-md-4">
          <div class="card card-warning">
            <div class="card-header bg-gradient-warning">
              <h3 class="card-title"><i class="fas fa-edit"></i> Edit Merk</h3>
            </div>

            <form action="<?= BASE_URL ?>views/user/merk/prosesmerk.php" method="POST">
              <input type="hidden" name="aksi" value="edit">
              <input type="hidden" name="idmerk" value="<?= $merk['idmerk'] ?>">

              <div class="card-body">
                <div class="form-group">
                  <label>Nama Merk</label>
                  <input type="text" class="form-control"
                         name="namamerk"
                         value="<?= htmlspecialchars($merk['namamerk']); ?>"
                         required>
                </div>
              </div>

              <div class="card-footer text-right">
                <a href="<?= BASE_URL ?>dashboard.php?hal=merk/daftarmerk"
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

        <!-- ========== DAFTAR MERK ========== -->
        <div class="col-md-8">
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
              <h5 class="m-0">Daftar Merk</h5>
            </div>

            <div class="card-body table-responsive">
              <table class="table table-bordered table-striped">
                <thead class="text-center bg-light">
                  <tr>
                    <th style="width:5%;">No</th>
                    <th>Nama Merk</th>
                    <th style="width:15%;">Aksi</th>
                  </tr>
                </thead>

                <tbody>
                <?php $no = 1; while ($m = mysqli_fetch_assoc($hasil)): ?>
                  <tr>
                    <td class="text-center"><?= $no++; ?></td>
                    <td><?= htmlspecialchars($m['namamerk']); ?></td>

                    <td class="text-center">
                      <a href="<?= BASE_URL ?>dashboard.php?hal=merk/editmerk&id=<?= $m['idmerk'] ?>"
                         class="btn btn-warning btn-sm">
                        <i class="fa fa-edit"></i>
                      </a>

                      <a onclick="return confirm('Hapus merk ini?')"
                         href="<?= BASE_URL ?>views/user/merk/prosesmerk.php?aksi=hapus&id=<?= $m['idmerk'] ?>"
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
