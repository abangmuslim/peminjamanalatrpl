<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card text-xs">
    <div class="card-header bg-gradient-warning">
      <h2 class="card-title text-white"><i class="fas fa-edit"></i> Edit Alat</h2>
    </div>

    <div class="card-body">
      <div class="card card-warning shadow-sm">
        <?php
        include("koneksi.php");
        $idalat = $_GET['idalat'];
        $sql = mysqli_query($koneksi, "
          SELECT * FROM alat 
          WHERE idalat = '$idalat'
        ");
        $data = mysqli_fetch_assoc($sql);

        // Ambil data dropdown
        $sqlkategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY namakategori ASC");
        $sqlmerk = mysqli_query($koneksi, "SELECT * FROM merk ORDER BY namamerk ASC");
        $sqlposisi = mysqli_query($koneksi, "SELECT * FROM posisi ORDER BY namaposisi ASC");
        ?>

        <!-- ✅ FORM AKSI -->
        <form action="db/dbalat.php?proses=edit" method="POST" enctype="multipart/form-data">
          <div class="card-body ml-2">

            <input type="hidden" name="idalat" value="<?= $data['idalat']; ?>">

            <!-- Input Nama Alat -->
            <div class="form-group">
              <label for="namaalat"><strong>Nama Alat</strong></label>
              <input type="text" class="form-control" id="namaalat" name="namaalat"
                value="<?= htmlspecialchars($data['namaalat']); ?>" required>
            </div>

            <!-- Dropdown Kategori -->
            <div class="form-group">
              <label><strong>Pilih Kategori</strong></label>
              <select class="form-control" name="idkategori" required>
                <option value="" disabled>-- Pilih Kategori --</option>
                <?php while ($kat = mysqli_fetch_array($sqlkategori)) { ?>
                  <option value="<?= $kat['idkategori']; ?>" <?= $kat['idkategori'] == $data['idkategori'] ? 'selected' : ''; ?>>
                    <?= $kat['namakategori']; ?>
                  </option>
                <?php } ?>
              </select>
            </div>

            <!-- Dropdown Merk -->
            <div class="form-group">
              <label><strong>Pilih Merk</strong></label>
              <select class="form-control" name="idmerk" required>
                <option value="" disabled>-- Pilih Merk --</option>
                <?php while ($merk = mysqli_fetch_array($sqlmerk)) { ?>
                  <option value="<?= $merk['idmerk']; ?>" <?= $merk['idmerk'] == $data['idmerk'] ? 'selected' : ''; ?>>
                    <?= $merk['namamerk']; ?>
                  </option>
                <?php } ?>
              </select>
            </div>

            <!-- Dropdown Posisi -->
            <div class="form-group">
              <label><strong>Pilih Posisi / Lokasi Alat</strong></label>
              <select class="form-control" name="idposisi" required>
                <option value="" disabled>-- Pilih Posisi --</option>
                <?php while ($pos = mysqli_fetch_array($sqlposisi)) { ?>
                  <option value="<?= $pos['idposisi']; ?>" <?= $pos['idposisi'] == $data['idposisi'] ? 'selected' : ''; ?>>
                    <?= $pos['namaposisi']; ?>
                  </option>
                <?php } ?>
              </select>
            </div>

            <!-- Input Kondisi -->
            <div class="form-group">
              <label for="kondisi"><strong>Kondisi</strong></label>
              <select class="form-control" name="kondisi" id="kondisi" required>
                <option value="" disabled>-- Pilih Kondisi --</option>
                <option value="Baik" <?= $data['kondisi'] == 'Baik' ? 'selected' : ''; ?>>Baik</option>
                <option value="Cukup" <?= $data['kondisi'] == 'Cukup' ? 'selected' : ''; ?>>Cukup</option>
                <option value="Rusak" <?= $data['kondisi'] == 'Rusak' ? 'selected' : ''; ?>>Rusak</option>
              </select>
            </div>

            <!-- Input Tanggal Pembelian -->
            <div class="form-group">
              <label for="tanggalpembelian"><strong>Tanggal Pembelian</strong></label>
              <input type="date" class="form-control" id="tanggalpembelian" name="tanggalpembelian"
                value="<?= $data['tanggalpembelian']; ?>" required>
            </div>

            <!-- Input Foto -->
            <div class="form-group">
              <label for="foto"><strong>Foto Alat</strong></label><br>
              <?php if (!empty($data['foto']) && file_exists("foto/alat/" . $data['foto'])) { ?>
                <img src="foto/alat/<?= $data['foto']; ?>" alt="Foto Alat" width="120" class="img-thumbnail mb-2">
                <br>
              <?php } else { ?>
                <span class="text-muted">Belum ada foto</span><br>
              <?php } ?>

              <input type="file" name="foto" id="foto" class="form-control mt-2" accept="image/*">
              <small class="text-muted">Upload foto baru (opsional). Kosongkan jika tidak ingin mengubah foto.</small>
            </div>

          </div>

          <!-- Tombol Aksi -->
          <div class="card-footer bg-light">
            <button type="submit" class="btn btn-warning float-right ml-3">
              <i class="fa fa-save"></i> Update
            </button>
            <a href="index.php?halaman=alat" class="btn btn-secondary float-right">
              <i class="fa fa-arrow-left"></i> Kembali
            </a>
          </div>

        </form>
      </div>
    </div>

    <div class="card-footer text-center text-muted">
      <small>© 2025 - Sistem Peminjaman Alat RPL</small>
    </div>
  </div>
</section>
