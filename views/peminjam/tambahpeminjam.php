<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card text-xs">
    <div class="card-header bg-primary">
      <h2 class="card-title">Tambah Peminjam</h2>
    </div>

    <div class="card-body">
      <!-- general form elements -->
      <div class="card card-warning">
        <form action="db/dbpeminjam.php?proses=tambah" method="POST" enctype="multipart/form-data">
          <div class="card-body-sm ml-2">

            <div class="form-group">
              <label for="namapeminjam">Nama Peminjam</label>
              <input type="text" class="form-control" id="namapeminjam" name="namapeminjam" placeholder="Masukkan nama peminjam" required>
            </div>

            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
              <small class="text-muted">Username harus unik.</small>
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
            </div>

            <input type="checkbox" onclick="togglePassword()"> Tampilkan Password

            <script>
              function togglePassword() {
                var x = document.getElementById("password");
                if (x.type === "password") {
                  x.type = "text";
                } else {
                  x.type = "password";
                }
              }
            </script>

            <!-- koneksi untuk input references -->
            <?php
            include("koneksi.php");
            $sqlasal = mysqli_query($koneksi, "SELECT * FROM asal ORDER BY namaasal ASC");

            echo "
            <div class='form-group'>
              <label>Select Asal</label>
              <select class='form-control' name='idasal'>
                <option value='' disabled selected>-- Pilih Asal --</option>";
            while ($dataasal = mysqli_fetch_array($sqlasal)) {
              echo "<option value='{$dataasal['idasal']}'>{$dataasal['namaasal']}</option>";
            }
            echo "
              </select>
            </div>";
            ?>

            <div class="form-group">
              <label for="foto">Upload Foto Peminjam</label>
              <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
              <small class="text-muted">Upload foto (opsional)</small>
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
