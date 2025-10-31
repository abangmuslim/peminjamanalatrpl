<?php
include "koneksi.php";

// pastikan ada idpeminjaman yang dikirim
if (!isset($_GET['idpeminjaman'])) {
    echo "<div class='alert alert-danger'>ID Peminjaman tidak ditemukan.</div>";
    exit;
}

$idpeminjaman = $_GET['idpeminjaman'];

// Ambil data peminjam berdasarkan idpeminjaman
$qPeminjam = mysqli_query($koneksi, "
    SELECT p.idpeminjam, pm.namapeminjam 
    FROM peminjaman p
    JOIN peminjam pm ON p.idpeminjam = pm.idpeminjam
    WHERE p.idpeminjaman = '$idpeminjaman'
");
$dPeminjam = mysqli_fetch_assoc($qPeminjam);

// Ambil daftar alat yang sedang dipinjam (belum dikembalikan)
$qPeminjaman = mysqli_query($koneksi, "
    SELECT dp.iddetilpeminjaman, a.namaalat, dp.tanggalpinjam, dp.durasipeminjaman, 
           dp.tanggalkembali, dp.keterangan
    FROM detilpeminjaman dp
    JOIN alat a ON dp.idalat = a.idalat
    WHERE dp.idpeminjaman = '$idpeminjaman' AND dp.keterangan = 'belumkembali'
");

$no = 1;
$totalDenda = 0;
?>

<div class="card card-outline card-primary">
  <div class="card-header bg-warning">
    <h5 class="mb-0">Proses Pengembalian - 
      <b><?= htmlspecialchars($dPeminjam['namapeminjam']) ?></b>
    </h5>
  </div>

  <div class="card-body">
    <form action="db/dbpeminjaman.php?proses=kembalikan" method="POST">
      <input type="hidden" name="idpeminjaman" value="<?= $idpeminjaman ?>">

      <table class="table table-bordered table-hover">
        <thead class="bg-info text-white text-center">
          <tr>
            <th>No</th>
            <th>Nama Alat</th>
            <th>Tanggal Pinjam</th>
            <th>Durasi</th>
            <th>Harus Kembali</th>
            <th>Tanggal Dikembalikan</th>
            <th>Status</th>
            <th>Terlambat (hari)</th>
            <th>Denda</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($d = mysqli_fetch_assoc($qPeminjaman)): 
            $tglHariIni = date('Y-m-d');
            $harusKembali = $d['tanggalkembali'];

            // hitung keterlambatan
            $terlambat = (strtotime($tglHariIni) - strtotime($harusKembali)) / (60 * 60 * 24);
            $terlambat = ($terlambat > 0) ? $terlambat : 0;

            $denda = $terlambat * 1000;
            $totalDenda += $denda;
          ?>
          <tr class="text-center">
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($d['namaalat']) ?></td>
            <td><?= $d['tanggalpinjam'] ?></td>
            <td><?= $d['durasipeminjaman'] ?> hari</td>
            <td><?= $d['tanggalkembali'] ?></td>
            <td>
              <input type="date" 
                     name="tanggalpengembalian[<?= $d['iddetilpeminjaman'] ?>]" 
                     value="<?= date('Y-m-d') ?>" 
                     class="form-control form-control-sm" required>
            </td>
            <td>
              <?php if ($terlambat > 0): ?>
                <span class="badge bg-danger">Terlambat</span>
              <?php else: ?>
                <span class="badge bg-success">Tepat Waktu</span>
              <?php endif; ?>
            </td>
            <td><?= $terlambat ?></td>
            <td>Rp<?= number_format($denda, 0, ',', '.') ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>

      <hr>
      <div class="row text-center align-items-center">
        <div class="col-md-3">
          <label class="bg-info text-white w-100 p-2">Total Denda</label>
          <div class="bg-info text-white p-2 rounded">
            Rp<?= number_format($totalDenda, 0, ',', '.') ?>
          </div>
          <input type="hidden" name="totaldenda" id="totaldenda" value="<?= $totalDenda ?>">
        </div>

        <div class="col-md-2">
          <label>Bayar</label>
          <input type="number" name="dibayar" id="dibayar" class="form-control" value="0" min="0">
        </div>

        <div class="col-md-3">
          <label class="bg-danger text-white w-100 p-2">Tunggakan</label>
          <div id="tunggakan" class="bg-danger text-white p-2 rounded">
            Rp<?= number_format($totalDenda, 0, ',', '.') ?>
          </div>
        </div>

        <div class="col-md-3">
          <label class="bg-success text-white w-100 p-2">Kembalian</label>
          <div id="kembalian" class="bg-success text-white p-2 rounded">Rp0</div>
        </div>
      </div>

      <div class="mt-4 text-center">
        <a href="index.php?halaman=daftarpengembalian" class="btn btn-primary">
          <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <button type="reset" class="btn btn-warning">
          <i class="fas fa-undo"></i> Reset
        </button>
        <button type="submit" class="btn btn-success">
          <i class="fas fa-save"></i> Simpan
        </button>
      </div>
    </form>
  </div>
</div>

<script>
// Hitung tunggakan & kembalian otomatis
document.getElementById('dibayar').addEventListener('input', function() {
  let dibayar = parseInt(this.value) || 0;
  let total = parseInt(document.getElementById('totaldenda').value) || 0;
  let tunggakanEl = document.getElementById('tunggakan');
  let kembalianEl = document.getElementById('kembalian');

  if (dibayar >= total) {
    tunggakanEl.textContent = "Rp0";
    kembalianEl.textContent = "Rp" + (dibayar - total).toLocaleString('id-ID');
  } else {
    tunggakanEl.textContent = "Rp" + (total - dibayar).toLocaleString('id-ID');
    kembalianEl.textContent = "Rp0";
  }
});
</script>
