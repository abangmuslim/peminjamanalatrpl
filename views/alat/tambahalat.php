<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card text-xs">
    <div class="card-header bg-gradient-primary">
      <h2 class="card-title text-white"><i class="fas fa-plus-circle"></i> Tambah Alat</h2>
    </div>

    <div class="card-body">
      <!-- general form elements -->
      <div class="card card-warning shadow-sm">
        <!-- ✅ FORM AKSI -->
        <form action="db/dbalat.php?proses=tambah" method="POST" enctype="multipart/form-data">
          <div class="card-body ml-2">

            <?php
            include("koneksi.php");
            // Ambil data kategori
            $sqlkategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY namakategori ASC");
            // Ambil data merk
            $sqlmerk = mysqli_query($koneksi, "SELECT * FROM merk ORDER BY namamerk ASC");
            // Ambil data posisi
            $sqlposisi = mysqli_query($koneksi, "SELECT * FROM posisi ORDER BY namaposisi ASC");
            ?>

            <!-- Input Nama Alat -->
            <div class="form-group">
              <label for="namaalat"><strong>Nama Alat</strong></label>
              <input type="text" class="form-control" id="namaalat" name="namaalat" placeholder="Masukkan nama alat" required>
            </div>

            <!-- Dropdown Kategori -->
            <div class="form-group">
              <label><strong>Pilih Kategori</strong></label>
              <select class="form-control" name="idkategori" required>
                <option value="" disabled selected>-- Pilih Kategori --</option>
                <?php while ($datakat = mysqli_fetch_array($sqlkategori)) { ?>
                  <option value="<?= $datakat['idkategori']; ?>"><?= $datakat['namakategori']; ?></option>
                <?php } ?>
              </select>
            </div>

            <!-- Dropdown Merk -->
            <div class="form-group">
              <label><strong>Pilih Merk</strong></label>
              <select class="form-control" name="idmerk" required>
                <option value="" disabled selected>-- Pilih Merk --</option>
                <?php while ($datamerk = mysqli_fetch_array($sqlmerk)) { ?>
                  <option value="<?= $datamerk['idmerk']; ?>"><?= $datamerk['namamerk']; ?></option>
                <?php } ?>
              </select>
            </div>

            <!-- Dropdown Posisi -->
            <div class="form-group">
              <label><strong>Pilih Posisi / Lokasi Alat</strong></label>
              <select class="form-control" name="idposisi" required>
                <option value="" disabled selected>-- Pilih Posisi --</option>
                <?php while ($datapos = mysqli_fetch_array($sqlposisi)) { ?>
                  <option value="<?= $datapos['idposisi']; ?>"><?= $datapos['namaposisi']; ?></option>
                <?php } ?>
              </select>
            </div>

            <!-- Input Kondisi -->
            <div class="form-group">
              <label for="kondisi"><strong>Kondisi</strong></label>
              <select class="form-control" name="kondisi" id="kondisi" required>
                <option value="" disabled selected>-- Pilih Kondisi --</option>
                <option value="Baik">Baik</option>
                <option value="Cukup">Cukup</option>
                <option value="Rusak">Rusak</option>
              </select>
            </div>

            <!-- Input Tanggal Pembelian -->
            <div class="form-group">
              <label for="tanggalpembelian"><strong>Tanggal Pembelian</strong></label>
              <input type="date" class="form-control" id="tanggalpembelian" name="tanggalpembelian" required>
            </div>

            <!-- Input Foto -->
            <div class="form-group">
              <label for="foto"><strong>Upload Foto Alat</strong></label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" name="foto" id="foto" class="custom-file-input" accept="image/*">
                  <label class="custom-file-label" for="foto">Pilih file foto...</label>
                </div>
              </div>
              <small class="text-muted">Format foto: JPG, JPEG, PNG (maks. 2MB)</small>
            </div>

          </div>

          <!-- Tombol Aksi -->
          <div class="card-footer bg-light">
            <button type="submit" class="btn btn-primary float-right ml-3">
              <i class="fa fa-save"></i> Simpan
            </button>
            <button type="reset" class="btn btn-warning float-right">
              <i class="fa fa-retweet"></i> Reset
            </button>
          </div>

        </form>
      </div>
      <!-- /.card -->
    </div>

    <div class="card-footer text-center text-muted">
      <small>© 2025 - Sistem Peminjaman Alat RPL</small>
    </div>
  </div>
</section>
