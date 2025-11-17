<?php
// ===============================================
// SIDEBAR KANAN FINAL – Aplikasi Peminjaman Alat RPL
// ===============================================

// OPTIONAL: jika ingin data dinamis, aktifkan koneksi DB
// include __DIR__ . "/../includes/koneksi.php";

// Contoh data statis (aman & ringan)
$kategori = [
    "Elektronik",
    "Jaringan",
    "Tools",
    "Multimedia",
    "Robotik"
];

?>

<div class="sidebar-right p-3 bg-white shadow-sm rounded">

    <!-- INFORMASI APLIKASI -->
    <h5 class="fw-bold">Informasi</h5>
    <p class="text-muted small">
        Sistem Peminjaman Alat RPL SMK.<br>
        Pastikan alat dikembalikan tepat waktu.
    </p>

    <hr>

    <!-- KATEGORI ALAT -->
    <h6 class="fw-bold mt-3">Kategori Alat</h6>
    <div class="tag-cloud">
        <?php foreach ($kategori as $kat): ?>
            <span class="badge bg-primary mb-1"><?= $kat ?></span>
        <?php endforeach; ?>
    </div>

    <hr>

    <!-- INFORMASI STATUS -->
    <h6 class="fw-bold mt-3">Status Layanan</h6>
    <p class="small">
        <span class="badge bg-success">Aktif</span> Layanan peminjaman buka.
    </p>

    <p class="small text-muted">
        Jam operasional: 07.00 – 16.00 WIB
    </p>

</div>
