<?php
// ============================================================
// File: views/user/pengembalian/tambahpengembalian.php
// Final — tampil rapi (mirip pengembalian buku perpustakaan)
// ============================================================
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';

date_default_timezone_set('Asia/Jakarta');

// Validasi idpeminjaman
$idpeminjaman = intval($_GET['idpeminjaman'] ?? 0);
if ($idpeminjaman <= 0) {
    echo "<script>alert('ID peminjaman tidak ditemukan!'); window.location='" . BASE_URL . "dashboard.php?hal=pengembalian/daftarpengembalian';</script>";
    exit;
}

// Ambil data peminjaman + peminjam
$sql = "
    SELECT p.*, pm.namapeminjam
    FROM peminjaman p
    JOIN peminjam pm ON p.idpeminjam = pm.idpeminjam
    WHERE p.idpeminjaman = " . $idpeminjaman . " 
    LIMIT 1
";
$res = $koneksi->query($sql);
if (!$res || $res->num_rows === 0) {
    echo "<script>alert('Data peminjaman tidak ditemukan!'); window.location='" . BASE_URL . "dashboard.php?hal=pengembalian/daftarpengembalian';</script>";
    exit;
}
$peminjaman = $res->fetch_assoc();

// Ambil detail peminjaman (alat)
$qDetil = $koneksi->query("
    SELECT d.*, a.namaalat
    FROM detilpeminjaman d
    LEFT JOIN alat a ON d.idalat = a.idalat
    WHERE d.idpeminjaman = $idpeminjaman
    ORDER BY d.iddetilpeminjaman ASC
");

// Tarif denda per hari
$tarifDenda = 1000;

include PAGES_PATH . 'user/header.php';
include PAGES_PATH . 'user/navbar.php';
include PAGES_PATH . 'user/sidebar.php';
?>

<style>
/* sedikit styling agar rapi seperti tampilan perpustakaan */
.badge-small { padding: .35rem .5rem; font-size: .85rem; }
.summary-card { padding: 18px; border-radius: 8px; color: #fff; }
.summary-title { font-size: .9rem; opacity: .9; }
.summary-value { font-weight: 700; font-size: 1.4rem; margin-top:6px; }
.table-fixed td, .table-fixed th { vertical-align: middle; }
</style>

<div class="content">
  <div class="card mb-3">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">Proses Pengembalian — <?= htmlspecialchars($peminjaman['namapeminjam']) ?></h4>
    </div>

    <div class="card-body">
      <form method="POST" action="<?= BASE_URL ?>dashboard.php?hal=pengembalian/prosespengembalian">
        <input type="hidden" name="idpeminjaman" value="<?= $idpeminjaman ?>">
        <input type="hidden" name="tanggalbayar" id="tanggalbayar" value="<?= date('Y-m-d') ?>">

        <div class="table-responsive">
          <table class="table table-bordered table-striped table-fixed w-100">
            <thead class="bg-light text-center">
              <tr>
                <th style="width:50px">No</th>
                <th>Nama Alat</th>
                <th style="width:120px">Tanggal Pinjam</th>
                <th style="width:90px">Durasi</th>
                <th style="width:140px">Harus Kembali</th>
                <th style="width:160px">Tanggal Dikembalikan</th>
                <th style="width:110px">Status</th>
                <th style="width:120px">Keterangan</th>
                <th style="width:110px">Terlambat (hari)</th>
                <th style="width:140px">Denda</th>
              </tr>
            </thead>
            <tbody>
<?php
$no = 1;
$rows_exist = false;
while ($d = $qDetil->fetch_assoc()):
    $rows_exist = true;
    // safe values
    $iddetil = (int)$d['iddetilpeminjaman'];
    $namaalat = $d['namaalat'] ?? '-';
    $tanggalpinjam = $d['tanggalpinjam'] ?? '';
    $tanggalkembali = $d['tanggalkembali'] ?? '';
    $durasipeminjaman = (int)$d['durasipeminjaman'];
    // default tanggal dikembalikan = today
    $tglToday = date('Y-m-d');
?>
              <tr data-iddetil="<?= $iddetil ?>">
                <td class="text-center"><?= $no++ ?></td>
                <td><?= htmlspecialchars($namaalat) ?></td>
                <td class="text-center"><?= $tanggalpinjam ?></td>
                <td class="text-center"><?= $durasipeminjaman ?> hari</td>
                <td class="text-center tgl-kembali-asli"><?= $tanggalkembali ?></td>

                <!-- tanggal dikembalikan (input) -->
                <td class="text-center">
                  <?php if ($d['keterangan'] === 'sudahkembali'): ?>
                    <input type="date" class="form-control" value="<?= $d['tanggaldikembalikan'] ?>" readonly>
                  <?php else: ?>
                    <input type="date" name="tgl_kembali[<?= $iddetil ?>]" class="form-control tgl-kembali" value="<?= $tglToday ?>">
                  <?php endif; ?>
                </td>

                <td class="text-center status">
                  <span class="badge bg-secondary badge-small">Belum dihitung</span>
                </td>

                <td class="text-center">
                  <?php if ($d['keterangan'] === 'sudahkembali'): ?>
                    <span class="badge bg-primary badge-small">Sudah Kembali</span>
                  <?php else: ?>
                    <span class="badge bg-warning text-dark badge-small">Belum Kembali</span>
                  <?php endif; ?>
                </td>

                <td class="text-center hari-terlambat">0</td>
                <td class="text-center denda">Rp0</td>

                <!-- hidden fields sesuai prosespengembalian.php -->
                <input type="hidden" name="detail[<?= $iddetil ?>][jumlahharitelat]" class="input-terlambat">
                <input type="hidden" name="detail[<?= $iddetil ?>][denda]" class="input-denda">
                <input type="hidden" name="detail[<?= $iddetil ?>][status]" class="input-status">
              </tr>
<?php endwhile; ?>

            </tbody>
          </table>
        </div>

        <?php if (!$rows_exist): ?>
          <div class="alert alert-info">Tidak ada detail peminjaman untuk ID ini.</div>
        <?php endif; ?>

        <!-- Ringkasan & aksi -->
        <div class="row mt-4 align-items-center text-center">
          <div class="col-md-3 mb-3">
            <div class="summary-card bg-info">
              <div class="summary-title">Total Denda</div>
              <div id="total-denda" class="summary-value">Rp0</div>
              <input type="hidden" name="totaldenda" id="input-total-denda" value="0">
            </div>
          </div>

          <div class="col-md-3 mb-3">
            <label class="fw-bold d-block">Dibayar</label>
            <input type="number" name="dibayar" id="uang-bayar" class="form-control text-center form-control-lg" value="0" min="0">
            <div class="mt-2"><span id="badge-bayar" class="badge bg-warning text-dark">Rp0</span></div>
          </div>

          <div class="col-md-3 mb-3">
            <div class="summary-card bg-danger">
              <div class="summary-title">Tunggakan</div>
              <div id="tunggakan" class="summary-value">Rp0</div>
              <input type="hidden" id="input-tunggakan" name="tunggakan" value="0">
            </div>
          </div>

          <div class="col-md-3 mb-3">
            <div class="summary-card bg-success">
              <div class="summary-title">Kembalian</div>
              <div id="kembalian" class="summary-value">Rp0</div>
            </div>
          </div>
        </div>

        <div class="mt-4 text-end">
          <a href="<?= BASE_URL ?>dashboard.php?hal=pengembalian/daftarpengembalian" class="btn btn-secondary">Kembali</a>
          <button type="reset" class="btn btn-warning">Reset</button>
          <button type="submit" class="btn btn-danger">Simpan Pengembalian</button>
        </div>

      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const rows = Array.from(document.querySelectorAll('tbody tr[data-iddetil]'));
    const totalDendaEl = document.getElementById('total-denda');
    const inputTotalDenda = document.getElementById('input-total-denda');
    const inputTunggakan = document.getElementById('input-tunggakan');
    const uangBayarEl = document.getElementById('uang-bayar');
    const kembalianEl = document.getElementById('kembalian');
    const tunggakanEl = document.getElementById('tunggakan');
    const badgeBayar = document.getElementById('badge-bayar');

    const tarif = <?= intval($tarifDenda) ?? 1000 ?>;

    const formatRupiah = num => 'Rp' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

    function toDateYMD(s) {
        // expects 'YYYY-MM-DD'
        return new Date(s + 'T00:00:00');
    }

    function hitungDenda() {
        let totalDenda = 0;

        rows.forEach(row => {
            const iddetil = row.getAttribute('data-iddetil');
            const tglKembaliAsliEl = row.querySelector('.tgl-kembali-asli');
            const inputTgl = row.querySelector('.tgl-kembali');
            const statusEl = row.querySelector('.status');
            const hariTerlambatEl = row.querySelector('.hari-terlambat');
            const dendaEl = row.querySelector('.denda');
            const inputTerlambat = row.querySelector('.input-terlambat');
            const inputDenda = row.querySelector('.input-denda');
            const inputStatus = row.querySelector('.input-status');

            if (!tglKembaliAsliEl) return;

            const asli = tglKembaliAsliEl.textContent.trim();
            // if no input (already returned), skip calculation
            if (!inputTgl) return;

            // parse dates
            const tanggalKembaliAsli = toDateYMD(asli);
            const tanggalDikembalikan = toDateYMD(inputTgl.value);

            // difference in days
            const msPerDay = 1000 * 60 * 60 * 24;
            const diff = Math.floor((tanggalDikembalikan - tanggalKembaliAsli) / msPerDay);
            const selisihHari = Math.max(0, diff);
            const denda = selisihHari * tarif;

            // update UI
            statusEl.innerHTML = selisihHari > 0
                ? '<span class="badge bg-danger badge-small">Terlambat</span>'
                : '<span class="badge bg-success badge-small">Tepat Waktu</span>';

            hariTerlambatEl.textContent = selisihHari;
            dendaEl.textContent = formatRupiah(denda);

            inputTerlambat.value = selisihHari;
            inputDenda.value = denda;
            inputStatus.value = selisihHari > 0 ? 'terlambat' : 'tidakterlambat';

            totalDenda += denda;
        });

        const dibayar = parseInt(uangBayarEl.value, 10) || 0;
        const tunggakan = Math.max(totalDenda - dibayar, 0);
        const kembalian = Math.max(dibayar - totalDenda, 0);

        inputTotalDenda.value = totalDenda;
        inputTunggakan.value = tunggakan;

        totalDendaEl.textContent = formatRupiah(totalDenda);
        tunggakanEl.textContent = formatRupiah(tunggakan);
        kembalianEl.textContent = formatRupiah(kembalian);
        badgeBayar.textContent = formatRupiah(dibayar);
    }

    // attach change listeners to each date input
    rows.forEach(row => {
        const input = row.querySelector('.tgl-kembali');
        if (input) input.addEventListener('change', hitungDenda);
    });

    uangBayarEl.addEventListener('input', hitungDenda);

    // initial calculation on load
    hitungDenda();
});
</script>

<?php include PAGES_PATH . 'user/footer.php'; ?>
