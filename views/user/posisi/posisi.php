<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card">
    <div class="card-header bg-gradient-primary mb-3">
      <div class="row">
        <div class="col tekstebal">
          <strong>
            <h5 style="font-family:Arial, Helvetica, sans-serif;">Halaman Data posisi</h5>
          </strong>
        </div>
      </div>
    </div>

    <div class="card-body">

      <!-- FORM TAMBAH posisi -->
      <div class="card card-warning mb-4 text-xs">
        <div class="card-header bg-gradient-warning">
          <h6 class="card-title text-white"><i class="fas fa-plus-circle"></i> Tambah posisi</h6>
        </div>
        <div class="card-body">
          <form action="db/dbposisi.php?proses=tambah" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label for="namaposisi">Nama posisi</label>
              <input type="text" class="form-control" id="namaposisi" name="namaposisi" placeholder="Masukkan nama posisi" required>
            </div>
            <div class="card-footer text-right">
              <button type="reset" class="btn btn-warning btn-sm"><i class="fa fa-retweet"></i> Reset</button>
              <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Simpan</button>
            </div>
          </form>
        </div>
      </div>
      <!-- END FORM TAMBAH -->

      <!-- TABEL DATA posisi -->
       <div class="card-header bg-gradient-warning">
          <h6 class="card-title text-white"><i class="fas fa-plus-circle"></i> Daftar posisi</h6>
        </div>
      <table id="example1" class="table table-bordered table-striped text-sm">
        <thead class="bg-light">
          <tr>
            <th>No</th>
            <th>Nama posisi</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          include "koneksi.php";
          $no = 1;

          $sql = mysqli_query($koneksi, "SELECT * FROM posisi ORDER BY idposisi DESC");
          while ($data = mysqli_fetch_array($sql)) {
            echo "
              <tr>
                <td>$no</td>
                <td>$data[namaposisi]</td>
                <td>
                  <a href='index.php?halaman=editposisi&idposisi=$data[idposisi]' class='btn btn-sm btn-success' title='Edit'><i class='fa fa-pencil-alt'></i></a>
                  <a href='db/dbposisi.php?proses=hapus&idposisi=$data[idposisi]' class='btn btn-sm btn-danger' title='Hapus' onclick=\"return confirm('Yakin ingin menghapus data ini?')\"><i class='fa fa-trash'></i></a>
                </td>
              </tr>
            ";
            $no++;
          }
          ?>
        </tbody>
      </table>
      <!-- END TABEL -->

    </div>
    <!-- /.card-body -->

    <div class="card-footer">
      <small>Data posisi - Aplikasi Peminjaman Alat RPL</small>
    </div>
    <!-- /.card-footer-->
  </div>
  <!-- /.card -->

</section>
<!-- /.content -->
