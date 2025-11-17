<?php
include "koneksi.php";
$id = $_GET['idjabatan'];
$sql = mysqli_query($koneksi, "SELECT * FROM jabatan WHERE idjabatan='$id'");
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
            <h5 style="font-family:Arial, Helvetica, sans-serif;">Halaman Edit jabatan</h5>
          </strong>
        </div>
        <div class="col">
          <a href="index.php?halaman=tambahjabatan" class="btn btn-light float-right btn-sm">
            <i class="fas fa-plus-circle"></i> Tambah jabatan
          </a>
        </div>
      </div>
    </div>

    <div class="card-body">
      <!-- general form elements -->
      <div class="card text-xs">
        <!-- form start -->
        <form action="db/dbjabatan.php?proses=edit" method="POST" enctype="multipart/form-data">
          <input type="hidden" value="<?= $data['idjabatan'] ?>" name="idjabatan" id="idjabatan">

          <div class="card-body-sm ml-2">
            <div class="form-group">
              <label for="namajabatan">Nama jabatan</label>
              <input type="text" class="form-control" id="namajabatan" name="namajabatan"
                     placeholder="Masukkan nama jabatan"
                     value="<?= $data['namajabatan'] ?>" required>
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
