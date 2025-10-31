<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "koneksi.php";
?>

<div class="card card-primary card-outline">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Daftar Seluruh PEMINJAM yang Sedang Meminjam Alat</h5>
    </div>
    <div class="card-body">
        <table id="tabelpengembalian" class="table table-bordered table-striped">
            <thead class="table-primary text-center">
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Peminjam</th>
                    <th width="15%">Jumlah Alat</th>
                    <th width="15%">Lebih Detil</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;

                // Ambil daftar peminjam yang masih memiliki alat "belumkembali"
                $sql = mysqli_query($koneksi, "
                    SELECT 
                        p.idpeminjaman, 
                        pm.namapeminjam, 
                        COUNT(dp.idalat) AS jumlah_alat
                    FROM peminjaman p
                    JOIN peminjam pm ON p.idpeminjam = pm.idpeminjam
                    JOIN detilpeminjaman dp ON p.idpeminjaman = dp.idpeminjaman
                    WHERE dp.keterangan = 'belumkembali'
                    GROUP BY p.idpeminjaman, pm.namapeminjam
                    ORDER BY pm.namapeminjam ASC
                ");

                if (!$sql) {
                    echo '<tr><td colspan="5" class="text-danger text-center">Query Error: ' . mysqli_error($koneksi) . '</td></tr>';
                } elseif (mysqli_num_rows($sql) == 0) {
                    echo "<tr><td colspan='5' class='text-center'>Tidak ada peminjaman aktif saat ini</td></tr>";
                } else {
                    while ($data = mysqli_fetch_assoc($sql)) {
                ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= htmlspecialchars($data['namapeminjam']) ?></td>
                            <td class="text-center"><?= $data['jumlah_alat'] ?></td>
                            <td class="text-center">
                                <a href="index.php?halaman=tampilpeminjaman&id=<?= $data['idpeminjaman'] ?>" 
                                   class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Detil
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="index.php?halaman=prosespengembalian&idpeminjaman=<?= $data['idpeminjaman'] ?>" 
                                   class="btn btn-success btn-sm"
                                   onclick="return confirm('Yakin ingin memproses pengembalian alat ini?')">
                                    <i class="fas fa-undo"></i> Kembalikan
                                </a>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- DataTables -->
<script>
$(document).ready(function() {
    $('#tabelpengembalian').DataTable({
        responsive: true,
        autoWidth: false,
        lengthChange: true,
        pageLength: 10,
        buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
        language: {
            lengthMenu: "Tampilkan _MENU_ entri",
            zeroRecords: "Tidak ada data ditemukan",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            infoEmpty: "Tidak ada entri yang tersedia",
            infoFiltered: "(difilter dari _MAX_ total entri)",
            search: "Cari:",
            paginate: {
                previous: "Sebelumnya",
                next: "Berikutnya"
            }
        }
    }).buttons().container().appendTo('#tabelpengembalian_wrapper .col-md-6:eq(0)');
});
</script>
