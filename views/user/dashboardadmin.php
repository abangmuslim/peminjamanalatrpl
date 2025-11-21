<?php
// =======================================
// File: views/user/dashboardadmin.php
// Deskripsi: Dashboard Admin PeminjamanAlatRPL (versi final lengkap)
// =======================================

// Statistik ringkas
$totalAlat      = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) AS jumlah FROM alat"))['jumlah'];
$totalPinjam    = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) AS jumlah FROM peminjaman"))['jumlah'];
$totalUser      = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) AS jumlah FROM user"))['jumlah'];
$totalKategori  = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) AS jumlah FROM kategori"))['jumlah'];

// Grafik: Peminjaman per kategori
$hasilKategori = mysqli_query($koneksi, "
    SELECT k.namakategori, COUNT(dp.idpeminjaman) AS jumlah
    FROM kategori k
    LEFT JOIN alat a ON a.idkategori = k.idkategori
    LEFT JOIN detilpeminjaman dp ON dp.idalat = a.idalat
    GROUP BY k.idkategori
");
$labelKategori = [];
$jumlahPeminjaman = [];
while ($row = mysqli_fetch_assoc($hasilKategori)) {
    $labelKategori[] = $row['namakategori'];
    $jumlahPeminjaman[] = $row['jumlah'];
}

// 🔥 PEMINJAM TERBARU (5 data)
$peminjamTerbaru = mysqli_query($koneksi, "
    SELECT idpeminjam, namapeminjam, foto, status
    FROM peminjam
    ORDER BY tanggalbuat DESC
    LIMIT 5
");

// 🔥 PEMINJAMAN TERBARU (5 data)
$peminjamanTerbaru = mysqli_query($koneksi, "
    SELECT dp.idpeminjaman, pm.namapeminjam, a.namaalat, dp.tanggalpinjam
    FROM detilpeminjaman dp
    LEFT JOIN peminjaman p ON p.idpeminjaman = dp.idpeminjaman
    LEFT JOIN peminjam pm ON pm.idpeminjam = p.idpeminjam
    LEFT JOIN alat a ON a.idalat = dp.idalat
    ORDER BY dp.tanggalpinjam DESC
    LIMIT 5
");

// 🔥 USER TERBARU (5 data)
$userTerbaru = mysqli_query($koneksi, "
    SELECT iduser, namauser, username, email
    FROM user
    ORDER BY iduser DESC
    LIMIT 5
");

// Include layout
include PAGES_PATH . 'user/header.php';
include PAGES_PATH . 'user/navbar.php';
include PAGES_PATH . 'user/sidebar.php';
?>

<!-- WRAPPER -->
<div class="content p-3">
  <section class="content">
    <div class="container-fluid">

      <!-- Statistik Ringkas -->
      <div class="row">
        <?php
        $statistik = [
            ['warna'=>'info','jumlah'=>$totalAlat,'label'=>'Total Alat','ikon'=>'tools','link'=>'alat/daftaralat'],
            ['warna'=>'success','jumlah'=>$totalPinjam,'label'=>'Total Peminjaman','ikon'=>'handshake','link'=>'peminjaman/daftarpeminjaman'],
            ['warna'=>'warning','jumlah'=>$totalUser,'label'=>'User Terdaftar','ikon'=>'users','link'=>'user/daftaruser'],
            ['warna'=>'danger','jumlah'=>$totalKategori,'label'=>'Kategori Alat','ikon'=>'folder','link'=>'kategori/daftarkategori'],
        ];
        foreach($statistik as $item){ ?>
          <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
            <div class="small-box bg-<?= $item['warna'] ?> text-white p-3 shadow-sm">
              <div class="inner">
                <h3><?= $item['jumlah'] ?></h3>
                <p><?= $item['label'] ?></p>
              </div>
              <div class="icon"><i class="fas fa-<?= $item['ikon'] ?> fa-2x"></i></div>
              <a href="dashboard.php?hal=<?= $item['link'] ?>" class="small-box-footer text-white">
                Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
        <?php } ?>
      </div>

      <!-- Grafik + Tabel -->
      <div class="row">

        <!-- Grafik -->
        <div class="col-lg-6 col-12 mb-3">
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white"><h6 class="m-0">Peminjaman per Kategori</h6></div>
            <div class="card-body"><canvas id="grafikKategori" height="180"></canvas></div>
          </div>
        </div>

        <!-- Kolom Kanan – 2 Kotak Terbaru -->
        <div class="col-lg-6 col-12">

          <!-- 🔥 PEMINJAM TERBARU -->
          <div class="card shadow-sm mb-3">
            <div class="card-header bg-success text-white"><h6 class="m-0">Peminjam Terbaru</h6></div>
            <div class="card-body p-2">

              <table class="table table-sm table-striped mb-0">
                <thead>
                  <tr>
                    <th>No</th><th>Nama</th><th>Foto</th><th>Status</th>
                  </tr>
                </thead>
                <tbody>
                <?php $no=1; while($pm=mysqli_fetch_assoc($peminjamTerbaru)){ ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($pm['namapeminjam']) ?></td>

                    <td>
                      <?php if(!empty($pm['foto'])){ ?>
                        <img src="uploads/peminjam/<?= htmlspecialchars($pm['foto']) ?>"
                             style="width:40px;height:40px;object-fit:cover;border-radius:50%;">
                      <?php } else { ?>
                        <span class="text-muted">-</span>
                      <?php } ?>
                    </td>

                    <td>
                      <?php
                        $warna = [
                          'pending'    => 'secondary',
                          'disetujui'  => 'success',
                          'ditolak'    => 'danger'
                        ];
                      ?>
                      <span class="badge bg-<?= $warna[$pm['status']] ?? 'secondary' ?>">
                        <?= htmlspecialchars($pm['status']) ?>
                      </span>
                    </td>
                  </tr>
                <?php } ?>
                </tbody>
              </table>

            </div>
          </div>

          <!-- 🔥 USER TERBARU -->
          <div class="card shadow-sm">
            <div class="card-header bg-warning text-white"><h6 class="m-0">User Terbaru</h6></div>
            <div class="card-body p-2">
              <table class="table table-sm table-striped mb-0">
                <thead><tr><th>Nama</th><th>Username</th><th>Email</th></tr></thead>
                <tbody>
                <?php while($user=mysqli_fetch_assoc($userTerbaru)){ ?>
                  <tr>
                    <td><?= htmlspecialchars($user['namauser']) ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                  </tr>
                <?php } ?>
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>

      <!-- 🔥 PEMINJAMAN TERBARU (SESUAI GAMBAR, BARIS FULL) -->
      <div class="row mt-3">
        <div class="col-12">
          <div class="card shadow-sm">
            <div class="card-header bg-danger text-white"><h6 class="m-0">Peminjaman Terbaru</h6></div>
            <div class="card-body p-2">

              <table class="table table-sm table-striped mb-0">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Peminjam</th>
                    <th>Nama Alat</th>
                    <th>Tanggal Pinjam</th>
                  </tr>
                </thead>
                <tbody>
                <?php $no=1; while($p=mysqli_fetch_assoc($peminjamanTerbaru)){ ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($p['namapeminjam']) ?></td>
                    <td><?= htmlspecialchars($p['namaalat']) ?></td>
                    <td><?= date('d/m/Y',strtotime($p['tanggalpinjam'])) ?></td>
                  </tr>
                <?php } ?>
                </tbody>
              </table>

            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<?php include PAGES_PATH . 'user/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('grafikKategori').getContext('2d');
new Chart(ctx,{
  type:'bar',
  data:{
    labels: <?= json_encode($labelKategori) ?>,
    datasets:[{
      label:'Jumlah Peminjaman',
      data: <?= json_encode($jumlahPeminjaman) ?>,
      backgroundColor:'rgba(54,162,235,0.6)',
      borderColor:'rgba(54,162,235,1)',
      borderWidth:1
    }]
  },
  options:{
    responsive:true,
    maintainAspectRatio:false,
    scales:{ y:{ beginAtZero:true } }
  }
});
</script>
