<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card">
    <div class="card-header bg-gradient-primary mb-3">
      <div class="row">
        <div class="col tekstebal">
          <strong>
            <h5 style="font-family:Arial, Helvetica, sans-serif;">Halaman Tampil Alat</h5>
          </strong>
        </div>
        <div class="col">
          <a href="index.php?halaman=tambahalat" class="btn btn-light float-right btn-sm">
            <i class="fas fa-plus"></i> Tambah Alat
          </a>
        </div>
      </div>
    </div>

    <table id="example1" class="table table-bordered table-striped text-sm ml-2">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Alat</th>
          <th>Kategori</th>
          <th>Kondisi</th>
          <th>Posisi</th>
          <th>Tanggal Pembelian</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        include __DIR__ . '/../../koneksi.php'; // <-- path sudah diperbaiki
        $no = 1;

        $sqlalat = mysqli_query($koneksi, "SELECT * FROM alat ORDER BY idalat ASC");
        while ($dataalat = mysqli_fetch_array($sqlalat)) {

          // Ambil nama kategori dari tabel kategori
          $idkategori = $dataalat['idkategori'];
          $sqlkategori = mysqli_query($koneksi, "SELECT * FROM kategori WHERE idkategori='$idkategori'");
          $datakategori = mysqli_fetch_array($sqlkategori);

          echo "
            <tr>
              <td>$no</td>
              <td>{$dataalat['namaalat']}</td>
              <td>{$datakategori['namakategori']}</td>
              <td>{$dataalat['kondisi']}</td>
              <td>{$dataalat['posisi']}</td>
              <td>{$dataalat['tanggalpembelian']}</td>
              <td>
                <a href='index.php?halaman=editalat&idalat={$dataalat['idalat']}' class='btn btn-sm btn-warning' title='edit'><i class='fa fa-edit'></i></a>
                <a href='db/dbalat.php?proses=hapus&idalat={$dataalat['idalat']}' class='btn btn-sm btn-danger' title='hapus' onclick=\"return confirm('Yakin ingin menghapus data ini?');\"><i class='fa fa-trash'></i></a>
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
