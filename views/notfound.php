<?php
// =======================================
// File: views/notfound.php
// Halaman Error 404 Custom
// =======================================
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>404 - Halaman Tidak Ditemukan</title>

    <!-- AdminLTE (jika sudah ada di layout global Anda) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/dist/css/adminlte.min.css">

    <style>
        body {
            background: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .error-box {
            text-align: center;
            padding: 40px 50px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.1);
            animation: fadeIn 0.4s ease-out;
        }
        .error-code {
            font-size: 80px;
            font-weight: 800;
            color: #dc3545;
        }
        .error-message {
            font-size: 22px;
            margin-top: -10px;
            margin-bottom: 20px;
            color: #555;
        }
        .btn-back {
            padding: 10px 25px;
            border-radius: 30px;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>

<div class="error-box">
    <div class="error-code">404</div>
    <div class="error-message">Halaman yang Anda cari tidak ditemukan</div>
    
    <p class="text-muted" style="font-size:14px; margin-bottom:25px;">
        URL tidak valid atau Anda tidak memiliki akses.
    </p>

    <a href="dashboard.php" class="btn btn-danger btn-back">
        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
    </a>
</div>

</body>
</html>
