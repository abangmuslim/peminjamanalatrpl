<?php
// =======================================
// File: views/user/dashboardpetugas.php
// Dashboard Petugas PeminjamanAlatRPL
// =======================================

// Statistik ringkas
$totalAlat      = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) AS jumlah FROM alat"))['jumlah'];
$totalPinjam    = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) AS jumlah FROM peminjaman"))['jumlah'];
$totalKategori  = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) AS jumlah FROM kategori"))['jumlah'];

// Grafik kategori
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

// Peminjaman terbaru
$peminjamanTerbaru = mysqli_query($koneksi, "
    SELECT dp.idpeminjaman, p.idpeminjam, pm.namapeminjam, a.namaalat, dp.tanggalpinjam
    FROM detilpeminjaman dp
    LEFT JOIN peminjaman p ON p.idpeminjaman = dp.idpeminjaman
    LEFT JOIN peminjam pm ON pm.idpeminjam = p.idpeminjam
    LEFT JOIN alat a ON a.idalat = dp.idalat
    ORDER BY dp.tanggalpinjam DESC
    LIMIT 5
");

// Include layout
include PAGES_PATH . 'user/header.php';
include PAGES_PATH . 'user/navbar.php';
include PAGES_PATH . 'user/sidebarpetugas.php';
?>

<!-- FIX: hilangkan content-wrapper kedua -->
<div class="content p-3">
  <section class="content">
    <div class="container-fluid">

      <!-- Statistik Ringkas -->
      <div class="row">
        <?php
        $statistik = [
            ['warna'=>'info','jumlah'=>$totalAlat,'label'=>'Total Alat','ikon'=>'tools','link'=>'alat/daftaralat'],
            ['warna'=>'success','jumlah'=>$totalPinjam,'label'=>'Total Peminjaman','ikon'=>'handshake','link'=>'peminjaman/daftarpeminjaman'],
            ['warna'=>'danger','jumlah'=>$totalKategori,'label'=>'Kategori Alat','ikon'=>'folder','link'=>'kategori/daftarkategori'],
        ];
        foreach($statistik as $item){ ?>
          <div class="col-xl-4 col-md-6 col-sm-12 mb-3">
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

      <!-- Grafik & Tabel -->
      <div class="row">
        <div class="col-lg-6 col-12 mb-3">
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white"><h6 class="m-0">Peminjaman per Kategori</h6></div>
            <div class="card-body"><canvas id="grafikKategori" height="180"></canvas></div>
          </div>
        </div>

        <div class="col-lg-6 col-12">
          <div class="card shadow-sm mb-3">
            <div class="card-header bg-success text-white"><h6 class="m-0">Peminjaman Terbaru</h6></div>
            <div class="card-body p-2">
              <table class="table table-sm table-striped mb-0">
                <thead><tr><th>Peminjam</th><th>Alat</th><th>Tanggal</th></tr></thead>
                <tbody>
                <?php while($pinjam=mysqli_fetch_assoc($peminjamanTerbaru)){ ?>
                  <tr>
                    <td><?= htmlspecialchars($pinjam['namapeminjam']) ?></td>
                    <td><?= htmlspecialchars($pinjam['namaalat']) ?></td>
                    <td><?= date('d/m/Y',strtotime($pinjam['tanggalpinjam'])) ?></td>
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
const ctx=document.getElementById('grafikKategori').getContext('2d');
new Chart(ctx,{
  type:'bar',
  data:{
    labels:<?= json_encode($labelKategori) ?>,
    datasets:[{
      label:'Jumlah Peminjaman',
      data:<?= json_encode($jumlahPeminjaman) ?>,
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
