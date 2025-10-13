<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card text-xs">
    <div class="card-header bg-primary">
      <h2 class="card-title">Tambah Alat</h2>
    </div>

    <div class="card-body">
      <!-- general form elements -->
      <div class="card card-warning">
        <form action="db/dbalat.php?proses=tambah" method="POST">
          <div class="card-body-sm ml-2">

            <!-- Kategori -->
            <?php
            include "koneksi.php"; // <-- path relatif ke root, sesuai struktur proyek
            $sqlkategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY namakategori ASC");

            echo "
            <div class='form-group'>
              <label>Select Kategori</label>
              <select class='form-control' name='idkategori'>
                <option value='' disabled selected>-- Pilih Kategori --</option>";
            while ($datakat = mysqli_fetch_array($sqlkategori)) {
              echo "<option value='{$datakat['idkategori']}'>{$datakat['namakategori']}</option>";
            }
            echo "
              </select>
            </div>";
            ?>

            <!-- Nama Alat -->
            <div class="form-group">
              <label for="namaalat">Nama Alat</label>
              <input type="text" class="form-control" id="namaalat" name="namaalat" placeholder="Masukkan nama alat" required>
            </div>

            <!-- Kondisi -->
            <div class="form-group">
              <label for="kondisi">Kondisi</label>
              <input type="text" class="form-control" id="kondisi" name="kondisi" placeholder="Masukkan kondisi alat">
            </div>

            <!-- Posisi -->
            <div class="form-group">
              <label for="posisi">Posisi</label>
              <input type="text" class="form-control" id="posisi" name="posisi" placeholder="Masukkan posisi alat">
            </div>

            <!-- Tanggal Pembelian -->
            <div class="form-group">
              <label for="tanggalpembelian">Tanggal Pembelian</label>
              <input type="date" class="form-control" id="tanggalpembelian" name="tanggalpembelian">
            </div>

            <div class="card-footer">
              <button type="submit" class="btn btn-primary float-right ml-3"><i class="fa fa-save"></i> Simpan</button>
              <button type="reset" class="btn btn-warning float-right"><i class="fa fa-retweet"></i> Reset</button>
            </div>

        </form>
      </div>
      <!-- /.card -->
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      Footer
    </div>
  </div>
  <!-- /.card -->

</section>
<!-- /.content -->
