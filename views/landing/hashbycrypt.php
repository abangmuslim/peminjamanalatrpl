<?php
// ============================================================
// File: hashbcrypt.php (Bebas akses, tanpa login)
// ============================================================

$hash = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['reset'])) {
        $hash = "";
        $_POST['password'] = "";
    } else {
        $password = trim($_POST['password'] ?? '');

        if ($password === "") {
            $error = "Password tidak boleh kosong.";
        } else {
            $hash = password_hash($password, PASSWORD_BCRYPT);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Bcrypt Hash Generator</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<style>
    .textarea-box {
        height: 120px;
        resize: vertical;
    }
    .output-box {
        background: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
        min-height: 80px;
        font-family: monospace;
        word-break: break-all;
        border: 1px solid #dee2e6;
    }
</style>

<script>
function copyHash() {
    let text = document.getElementById("outputHash").innerText;
    if (text.trim() === "") {
        alert("Tidak ada hash untuk disalin.");
        return;
    }
    navigator.clipboard.writeText(text);
    alert("Hash berhasil disalin!");
}
</script>
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow border-0">
                <div class="card-body">

                    <h2 class="text-center mb-4">Bcrypt Hash Generator</h2>

                    <?php if ($error): ?>
                        <div class="alert alert-warning"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Plain Text Input</label>
                            <textarea name="password" class="form-control textarea-box" placeholder="Masukkan teks untuk di-hash..."><?= htmlspecialchars($_POST['password'] ?? '') ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary w-100">Generate Hash</button>
                            </div>
                            <div class="col-6">
                                <button type="submit" name="reset" class="btn btn-secondary w-100">Reset Form</button>
                            </div>
                        </div>
                    </form>

                    <?php if ($hash): ?>
                        <hr class="my-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="mb-0">Output</h5>
                            <button class="btn btn-outline-dark btn-sm" onclick="copyHash()">COPY</button>
                        </div>

                        <div id="outputHash" class="output-box"><?= htmlspecialchars($hash) ?></div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
