<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card">
    <div class="card-header bg-gradient-primary mb-3">
      <div class="row">
        <div class="col tekstebal">
          <strong>
            <h5 style="font-family:Arial, Helvetica, sans-serif;">Halaman Data Asal</h5>
          </strong>
        </div>
      </div>
    </div>

    <div class="card-body">

      <!-- FORM TAMBAH ASAL -->
      <div class="card card-warning mb-4 text-xs">
        <div class="card-header bg-gradient-warning">
          <h6 class="card-title text-white"><i class="fas fa-plus-circle"></i> Tambah Asal</h6>
        </div>
        <div class="card-body">
          <form action="db/dbasal.php?proses=tambah" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label for="namaasal">Nama Asal</label>
              <input type="text" class="form-control" id="namaasal" name="namaasal" placeholder="Masukkan nama asal" required>
            </div>
            <div class="card-footer text-right">
              <button type="reset" class="btn btn-warning btn-sm"><i class="fa fa-retweet"></i> Reset</button>
              <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Simpan</button>
            </div>
          </form>
        </div>
      </div>
      <!-- END FORM TAMBAH -->

      <!-- TABEL DATA ASAL -->
       <div class="card-header bg-gradient-warning">
          <h6 class="card-title text-white"><i class="fas fa-plus-circle"></i> Daftar Asal</h6>
        </div>
      <table id="example1" class="table table-bordered table-striped text-sm">
        <thead class="bg-light">
          <tr>
            <th>No</th>
            <th>Nama Asal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          include "koneksi.php";
          $no = 1;

          $sql = mysqli_query($koneksi, "SELECT * FROM asal ORDER BY idasal DESC");
          while ($data = mysqli_fetch_array($sql)) {
            echo "
              <tr>
                <td>$no</td>
                <td>$data[namaasal]</td>
                <td>
                  <a href='index.php?halaman=editasal&idasal=$data[idasal]' class='btn btn-sm btn-success' title='Edit'><i class='fa fa-pencil-alt'></i></a>
                  <a href='db/dbasal.php?proses=hapus&idasal=$data[idasal]' class='btn btn-sm btn-danger' title='Hapus' onclick=\"return confirm('Yakin ingin menghapus data ini?')\"><i class='fa fa-trash'></i></a>
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
      <small>Data Asal - Aplikasi Peminjaman Alat RPL</small>
    </div>
    <!-- /.card-footer-->
  </div>
  <!-- /.card -->

</section>
<!-- /.content -->
