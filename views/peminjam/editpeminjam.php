<?php
include "koneksi.php";
$id = $_GET['idpeminjam'];
$sql = mysqli_query($koneksi, "SELECT * FROM peminjam WHERE idpeminjam='$id'");
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
            <h5 style="font-family:Arial, Helvetica, sans-serif;">Edit Peminjam</h5>
          </strong>
        </div>
        <div class="col">
          <a href="index.php?halaman=tampilpeminjam" class="btn btn-light float-right btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
      </div>
    </div>

    <div class="card-body">
      <div class="card text-xs">
        <form action="db/dbpeminjam.php?proses=edit" method="POST" enctype="multipart/form-data">
          <input type="hidden" value="<?= $data['idpeminjam'] ?>" name="idpeminjam" id="idpeminjam">

          <div class="card-body-sm ml-2">
            <div class="form-group">
              <label for="namapeminjam">Nama Peminjam</label>
              <input type="text" class="form-control" id="namapeminjam" name="namapeminjam" value="<?= $data['namapeminjam'] ?>" required>
            </div>

            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" name="username" value="<?= $data['username'] ?>" required>
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak ingin diganti">
            </div>

            <div class="form-group">
              <label>Select Asal</label>
              <select class="form-control" name="idasal">
                <option value="" disabled>-- Pilih Asal --</option>
                <?php
                $sqlasal = mysqli_query($koneksi, "SELECT * FROM asal ORDER BY namaasal ASC");
                while ($dataasal = mysqli_fetch_array($sqlasal)) {
                    $selected = ($data['idasal'] == $dataasal['idasal']) ? "selected" : "";
                    echo "<option value='{$dataasal['idasal']}' $selected>{$dataasal['namaasal']}</option>";
                }
                ?>
              </select>
            </div>

            <div class="form-group">
              <label for="foto">Upload Foto Peminjam</label>
              <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
            </div>
          </div>

          <div class="card-footer float-right">
            <?php if(!empty($data['foto'])) { ?>
              <div class="col-sm-12">
                <img src="foto/<?= $data['foto']; ?>" width="100px" class="rounded float-right mb-2">
              </div>
            <?php } ?>
            <button type="reset" class="btn-sm btn-warning"><i class="fa fa-retweet"></i> Reset</button>
            <button type="submit" class="btn-sm btn-primary"><i class="fa fa-save"></i> Submit</button>
          </div>
        </form>
      </div>
    </div>

    <div class="card-footer">
      Footer
    </div>
  </div>

</section>
