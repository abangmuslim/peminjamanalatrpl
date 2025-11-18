<?php
// ============================================================
// File: hashbycrypt.php
// Deskripsi: Generator hash password BCRYPT
// ============================================================

$hash = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = trim($_POST['password'] ?? '');

    if ($password === "") {
        $error = "Password tidak boleh kosong.";
    } else {
        // Hasil hash bcrypt
        $hash = password_hash($password, PASSWORD_BCRYPT);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Generate Hash BCRYPT</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow">
                <div class="card-body">
                    <h3 class="text-center mb-4">Generate BCRYPT Hash</h3>

                    <?php if ($error): ?>
                        <div class="alert alert-warning"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Masukkan Password</label>
                            <input type="text" name="password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Generate Hash</button>
                    </form>

                    <?php if ($hash): ?>
                        <hr>
                        <h5>Hasil Hash:</h5>
                        <div class="alert alert-success" style="word-break: break-all;">
                            <?= htmlspecialchars($hash) ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
