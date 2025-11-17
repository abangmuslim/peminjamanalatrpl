<?php
// ===============================================
// SIDEBAR KIRI (Opsional)
// Biasanya berisi daftar kategori, berita populer
// ===============================================

// Contoh data kategori (nanti diambil dari database)
$kategori = ["Teknologi", "Pendidikan", "Bisnis", "Olahraga"];
?>

<div class="sidebar-left p-3 bg-white shadow-sm rounded">
    <h5>Kategori</h5>
    <ul class="list-unstyled">
        <?php foreach ($kategori as $k): ?>
            <li><a href="<?= $base_url ?>/?page=kategori&nama=<?= strtolower($k) ?>"><?= $k ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>
