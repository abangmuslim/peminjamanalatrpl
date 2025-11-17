<!-- Daftar Peminjaman -->
<div class="card card-solid">
  <div class="card-header">
    <h3 class="card-title">Daftar Peminjaman Alat</h3>
    <a href="index.php?halaman=tambahpeminjaman" class="btn btn-primary btn-sm float-right">
      <i class="fas fa-plus"></i> Tambah Peminjaman
    </a>
  </div>

  <div class="card-body">
    <table class="table table-bordered table-striped">
      <thead class="thead-dark">
        <tr>
          <th width="5%">No</th>
          <th>Peminjam</th>
          <th>Asal</th>
          <th>Admin</th>
          <th>Alat yang Dipinjam</th>
          <th>Tanggal Pinjam</th>
          <th>Tanggal Kembali</th>
          <th width="15%">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;

        // Ambil data utama dari tabel peminjaman + relasi
        $query = mysqli_query($koneksi, "
          SELECT 
            p.idpeminjaman,
            pm.namapeminjam,
            a.namaadmin,
            s.namaasal,
            MIN(dp.tanggalpinjam) AS tanggalpinjam,
            MAX(dp.tanggalkembali) AS tanggalkembali
          FROM peminjaman p
          JOIN peminjam pm ON p.idpeminjam = pm.idpeminjam
          JOIN asal s ON pm.idasal = s.idasal
          JOIN admin a ON p.idadmin = a.idadmin
          JOIN detilpeminjaman dp ON p.idpeminjaman = dp.idpeminjaman
          GROUP BY p.idpeminjaman, pm.namapeminjam, a.namaadmin, s.namaasal
          ORDER BY p.idpeminjaman DESC
        ");

        while ($data = mysqli_fetch_assoc($query)) {
          $idpeminjaman = $data['idpeminjaman'];

          // Ambil daftar alat
          $alatList = [];
          $qAlat = mysqli_query($koneksi, "
            SELECT al.namaalat 
            FROM detilpeminjaman dp
            JOIN alat al ON dp.idalat = al.idalat
            WHERE dp.idpeminjaman = '$idpeminjaman'
          ");
          while ($rowAlat = mysqli_fetch_assoc($qAlat)) {
            $alatList[] = $rowAlat['namaalat'];
          }
        ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($data['namapeminjam']) ?></td>
            <td><?= htmlspecialchars($data['namaasal']) ?></td>
            <td><?= htmlspecialchars($data['namaadmin']) ?></td>
            <td><?= implode(", ", $alatList) ?></td>
            <td><?= date('d-m-Y', strtotime($data['tanggalpinjam'])) ?></td>
            <td><?= date('d-m-Y', strtotime($data['tanggalkembali'])) ?></td>
            <td>
              <a href="index.php?halaman=tampilpeminjaman&idpeminjaman=<?= $idpeminjaman ?>" class="btn btn-info btn-sm">
                <i class="fas fa-eye"></i>
              </a>
              <a href="index.php?halaman=editpeminjaman&idpeminjaman=<?= $idpeminjaman ?>" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i>
              </a>
              <a href="db/dbpeminjaman.php?proses=hapus&idpeminjaman=<?= $idpeminjaman ?>"
                 onclick="return confirm('Yakin ingin menghapus data ini?')"
                 class="btn btn-danger btn-sm">
                <i class="fas fa-trash"></i>
              </a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
