<div class="card card-primary card-outline">
  <div class="card-header bg-primary text-white">
    <h4 class="mb-0">Form Tambah Peminjaman Alat</h4>
  </div>

  <form action="db/dbpeminjaman.php?proses=tambah" method="POST">
    <div class="card-body">
      <div class="row">

        <!-- KOLOM KIRI: PEMINJAM -->
        <div class="col-md-7">
          <div class="mb-3">
            <label class="font-weight-bold bg-warning p-1">Nama Peminjam</label>
            <input type="text" id="cariPeminjam" class="form-control form-control-sm mb-2" placeholder="Cari Peminjam Terdaftar...">

            <table class="table table-sm table-bordered table-hover">
              <thead class="table-light">
                <tr>
                  <th>Nama</th>
                  <th>Asal</th>
                  <th class="text-center">Pilih</th>
                </tr>
              </thead>
              <tbody id="daftarPeminjam">
                <?php
                $qPeminjam = mysqli_query($koneksi, "
                  SELECT p.idpeminjam, p.namapeminjam, a.namaasal 
                  FROM peminjam p 
                  JOIN asal a ON p.idasal = a.idasal
                  ORDER BY p.namapeminjam ASC
                ");
                while ($d = mysqli_fetch_assoc($qPeminjam)) {
                ?>
                  <tr>
                    <td><?= htmlspecialchars($d['namapeminjam']) ?></td>
                    <td><?= htmlspecialchars($d['namaasal']) ?></td>
                    <td class="text-center">
                      <input type="radio" name="idpeminjam" value="<?= $d['idpeminjam'] ?>" required>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- KOLOM KANAN: TANGGAL -->
        <div class="col-md-5">
          <div class="form-group">
            <label class="bg-warning p-1">Tanggal Pinjam</label>
            <input type="date" name="tanggalpinjam" id="tanggalPinjam" class="form-control" required>
          </div>

          <div class="form-group">
            <label class="bg-warning p-1">Tanggal Pengembalian</label>
            <input type="date" name="tanggalkembali" id="tanggalKembali" class="form-control" required>
          </div>

          <div class="form-group">
            <label class="bg-warning p-1">Durasi Peminjaman</label>
            <input type="text" id="durasi" class="form-control" readonly placeholder="-- hari --">
          </div>

          <div class="form-group">
            <label class="bg-warning p-1">Denda Jika Terlambat</label>
            <input type="text" class="form-control" readonly value="Rp 1000,- / hari">
          </div>

          <!-- ID ADMIN dari sesi login -->
          <input type="hidden" name="idadmin" value="<?= $_SESSION['idadmin'] ?>">
        </div>
      </div>

      <hr>

      <!-- DAFTAR ALAT -->
      <div class="mt-3">
        <label class="font-weight-bold bg-warning p-1">Daftar Alat yang Dipinjam</label>
        <div id="listAlat">
          <div class="row align-items-center mb-2 alat-item">
            <div class="col-md-6">
              <select name="idalat[]" class="form-control" required>
                <option value="">-- Pilih Alat --</option>
                <?php
                $qAlat = mysqli_query($koneksi, "SELECT idalat, namaalat FROM alat ORDER BY namaalat ASC");
                while ($a = mysqli_fetch_assoc($qAlat)) {
                  echo "<option value='{$a['idalat']}'>{$a['namaalat']}</option>";
                }
                ?>
              </select>
            </div>
            <div class="col-md-3">
              <input type="number" name="jumlah[]" class="form-control" min="1" value="1" required>
            </div>
            <div class="col-md-2">
              <button type="button" class="btn btn-danger btn-sm btnHapusAlat">
                <i class="fas fa-trash"></i> Hapus
              </button>
            </div>
          </div>
        </div>

        <button type="button" class="btn btn-sm btn-danger mt-2" id="btnTambahAlat">
          <i class="fas fa-plus"></i> Tambah Alat
        </button>
      </div>
    </div>

    <div class="card-footer text-right">
      <button type="reset" class="btn btn-warning"><i class="fas fa-undo"></i> Reset</button>
      <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
      <a href="index.php?halaman=daftarpeminjaman" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
  </form>
</div>

<!-- SCRIPT -->
<script>
  // Hitung durasi otomatis
  const tglPinjam = document.getElementById("tanggalPinjam");
  const tglKembali = document.getElementById("tanggalKembali");
  const durasi = document.getElementById("durasi");

  function hitungDurasi() {
    if (tglPinjam.value && tglKembali.value) {
      const start = new Date(tglPinjam.value);
      const end = new Date(tglKembali.value);
      const diff = (end - start) / (1000 * 60 * 60 * 24);
      durasi.value = diff + " hari";
    }
  }

  tglPinjam.addEventListener("change", hitungDurasi);
  tglKembali.addEventListener("change", hitungDurasi);

  // Tambah baris alat baru
  document.getElementById("btnTambahAlat").addEventListener("click", function() {
    const newItem = document.querySelector(".alat-item").cloneNode(true);
    newItem.querySelectorAll("input, select").forEach(el => el.value = "");
    document.getElementById("listAlat").appendChild(newItem);
  });

  // Hapus baris alat
  document.addEventListener("click", function(e) {
    if (e.target.classList.contains("btnHapusAlat")) {
      const row = e.target.closest(".alat-item");
      if (document.querySelectorAll(".alat-item").length > 1) row.remove();
    }
  });

  // Filter pencarian peminjam
  document.getElementById("cariPeminjam").addEventListener("keyup", function() {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll("#daftarPeminjam tr");
    rows.forEach(row => {
      const nama = row.querySelector("td:first-child").textContent.toLowerCase();
      row.style.display = nama.includes(filter) ? "" : "none";
    });
  });
</script>
