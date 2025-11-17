<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card">
    <div class="card-header bg-gradient-primary mb-3">
      <div class="row">
        <div class="col tekstebal">
          <strong>
            <h5 style="font-family:Arial, Helvetica, sans-serif;">Halaman Tampil Peminjam</h5>
          </strong>
        </div>
        <div class="col">
          <a href="index.php?halaman=tambahpeminjam" class="btn btn-light float-right btn-sm">
            <i class="fas fa-user-plus"></i> Tambah Peminjam
          </a>
        </div>
      </div>
    </div>

    <table id="example1" class="table table-bordered table-striped text-sm ml-2">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Peminjam</th>
          <th>Username</th>
          <th>Asal</th>
          <th>Foto</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        include "koneksi.php";
        $no = 1;

        $sqlpeminjam = mysqli_query($koneksi, "SELECT * FROM peminjam");
        while ($datapeminjam = mysqli_fetch_array($sqlpeminjam)) {

          // Ambil nama asal dari tabel asal
          $idasal = $datapeminjam['idasal'];
          $sqlasal = mysqli_query($koneksi, "SELECT * FROM asal WHERE idasal='$idasal'");
          $dataasal = mysqli_fetch_array($sqlasal);

          // Menampilkan foto jika ada
          if (!empty($datapeminjam['foto']) && file_exists("foto/" . $datapeminjam['foto'])) {
              $foto = "<img src='foto/{$datapeminjam['foto']}' width='60' height='60' class='rounded'>";
          } else {
              $foto = "<span class='text-muted'>-</span>";
          }

          echo "
            <tr>
              <td>$no</td>
              <td>{$datapeminjam['namapeminjam']}</td>
              <td>{$datapeminjam['username']}</td>
              <td>{$dataasal['namaasal']}</td>
              <td>$foto</td>
              <td>
                <a href='index.php?halaman=editpeminjam&idpeminjam={$datapeminjam['idpeminjam']}' class='btn btn-sm btn-warning' title='edit'><i class='fa fa-edit'></i></a>
                <a href='db/dbpeminjam.php?proses=hapus&idpeminjam={$datapeminjam['idpeminjam']}' class='btn btn-sm btn-danger' title='hapus' onclick=\"return confirm('Yakin ingin menghapus data ini?');\"><i class='fa fa-trash'></i></a>
              </td>
            </tr>
          ";
          $no++;
        }
        ?>
      </tbody>
    </table>

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
