<!-- Main content -->
<section class="content">

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
          <th>Foto</th>
          <th>Nama Alat</th>
          <th>Kategori</th>
          <th>Merk</th>
          <th>Kondisi</th>
          <th>Posisi</th>
          <th>Tanggal Pembelian</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        include "koneksi.php";
        $no = 1;

        // ✅ JOIN semua relasi + ambil kolom foto
        $sql = "
          SELECT 
            alat.idalat,
            alat.namaalat,
            alat.kondisi,
            alat.tanggalpembelian,
            alat.foto,
            kategori.namakategori,
            merk.namamerk,
            posisi.namaposisi
          FROM alat
          LEFT JOIN kategori ON alat.idkategori = kategori.idkategori
          LEFT JOIN merk ON alat.idmerk = merk.idmerk
          LEFT JOIN posisi ON alat.idposisi = posisi.idposisi
          ORDER BY alat.idalat ASC
        ";

        $result = mysqli_query($koneksi, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
          // Format tanggal pembelian
          $tglbeli = !empty($row['tanggalpembelian'])
            ? date("d-m-Y", strtotime($row['tanggalpembelian']))
            : "<span class='text-muted'>-</span>";

          // Tampilkan foto alat
          $fotoPath = "foto/alat/" . $row['foto'];
          $fotoHtml = (!empty($row['foto']) && file_exists($fotoPath))
            ? "<img src='$fotoPath' alt='Foto Alat' width='60' height='60' class='rounded shadow-sm'>"
            : "<span class='text-muted'>Tidak ada foto</span>";

          echo "
            <tr>
              <td>{$no}</td>
              <td>{$fotoHtml}</td>
              <td>{$row['namaalat']}</td>
              <td>" . (!empty($row['namakategori']) ? $row['namakategori'] : '-') . "</td>
              <td>" . (!empty($row['namamerk']) ? $row['namamerk'] : '-') . "</td>
              <td>{$row['kondisi']}</td>
              <td>" . (!empty($row['namaposisi']) ? $row['namaposisi'] : '-') . "</td>
              <td>{$tglbeli}</td>
              <td class='text-center'>
                <a href='index.php?halaman=editalat&idalat={$row['idalat']}' class='btn btn-sm btn-warning' title='Edit'><i class='fa fa-edit'></i></a>
                <a href='db/dbalat.php?proses=hapus&idalat={$row['idalat']}' class='btn btn-sm btn-danger' title='Hapus' onclick=\"return confirm('Yakin ingin menghapus data ini?');\"><i class='fa fa-trash'></i></a>
              </td>
            </tr>
          ";
          $no++;
        }
        ?>
      </tbody>
    </table>

  </div>

  <div class="card-footer text-center text-muted">
    <small>© 2025 - Sistem Peminjaman Alat RPL</small>
  </div>
</section>
