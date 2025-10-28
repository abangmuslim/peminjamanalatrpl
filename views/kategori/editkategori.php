<?php
include "koneksi.php";
$id = $_GET['idkategori'];
$sql = mysqli_query($koneksi, "SELECT * FROM kategori WHERE idkategori='$id'");
$data = mysqli_fetch_array($sql);
?>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card">
    <div class="card-header bg-gradient-primary mb-3">
      <div class="row">
        <div class="col tekstebal">
          <strong>
            <h5 style="font-family:Arial, Helvetica, sans-serif;">Halaman Edit kategori</h5>
          </strong>
        </div>
        <div class="col">
          <a href="index.php?halaman=tambahkategori" class="btn btn-light float-right btn-sm">
            <i class="fas fa-plus-circle"></i> Tambah kategori
          </a>
        </div>
      </div>
    </div>

    <div class="card-body">
      <!-- general form elements -->
      <div class="card text-xs">
        <!-- form start -->
        <form action="db/dbkategori.php?proses=edit" method="POST" enctype="multipart/form-data">
          <input type="hidden" value="<?= $data['idkategori'] ?>" name="idkategori" id="idkategori">

          <div class="card-body-sm ml-2">
            <div class="form-group">
              <label for="namakategori">Nama kategori</label>
              <input type="text" class="form-control" id="namakategori" name="namakategori"
                     placeholder="Masukkan nama kategori"
                     value="<?= $data['namakategori'] ?>" required>
            </div>
          </div>
          <!-- /.card-body -->

          <div class="card-footer float-right">
            <button type="reset" class="btn-sm btn-warning"><i class="fa fa-retweet"></i> Reset</button>
            <button type="submit" class="btn-sm btn-primary"><i class="fa fa-save"></i> Simpan</button>
          </div>
        </form>
      </div>
      <!-- /.card -->
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
      Footer
    </div>
    <!-- /.card-footer-->
  </div>
  <!-- /.card -->

</section>
<!-- /.content -->
