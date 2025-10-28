<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card">
    <div class="card-header bg-gradient-primary mb-3">
      <div class="row">
        <div class="col tekstebal">
          <strong>
            <h5 style="font-family:Arial, Helvetica, sans-serif;">Halaman Data jabatan</h5>
          </strong>
        </div>
      </div>
    </div>

    <div class="card-body">

      <!-- FORM TAMBAH jabatan -->
      <div class="card card-warning mb-4 text-xs">
        <div class="card-header bg-gradient-warning">
          <h6 class="card-title text-white"><i class="fas fa-plus-circle"></i> Tambah jabatan</h6>
        </div>
        <div class="card-body">
          <form action="db/dbjabatan.php?proses=tambah" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label for="namajabatan">Nama jabatan</label>
              <input type="text" class="form-control" id="namajabatan" name="namajabatan" placeholder="Masukkan nama jabatan" required>
            </div>
            <div class="card-footer text-right">
              <button type="reset" class="btn btn-warning btn-sm"><i class="fa fa-retweet"></i> Reset</button>
              <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Simpan</button>
            </div>
          </form>
        </div>
      </div>
      <!-- END FORM TAMBAH -->

      <!-- TABEL DATA jabatan -->
       <div class="card-header bg-gradient-warning">
          <h6 class="card-title text-white"><i class="fas fa-plus-circle"></i> Daftar jabatan</h6>
        </div>
      <table id="example1" class="table table-bordered table-striped text-sm">
        <thead class="bg-light">
          <tr>
            <th>No</th>
            <th>Nama jabatan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          include "koneksi.php";
          $no = 1;

          $sql = mysqli_query($koneksi, "SELECT * FROM jabatan ORDER BY idjabatan DESC");
          while ($data = mysqli_fetch_array($sql)) {
            echo "
              <tr>
                <td>$no</td>
                <td>$data[namajabatan]</td>
                <td>
                  <a href='index.php?halaman=editjabatan&idjabatan=$data[idjabatan]' class='btn btn-sm btn-success' title='Edit'><i class='fa fa-pencil-alt'></i></a>
                  <a href='db/dbjabatan.php?proses=hapus&idjabatan=$data[idjabatan]' class='btn btn-sm btn-danger' title='Hapus' onclick=\"return confirm('Yakin ingin menghapus data ini?')\"><i class='fa fa-trash'></i></a>
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
      <small>Data jabatan - Aplikasi Peminjaman Alat RPL</small>
    </div>
    <!-- /.card-footer-->
  </div>
  <!-- /.card -->

</section>
<!-- /.content -->
