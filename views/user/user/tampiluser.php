<?php
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: " . BASE_URL . "dashboard.php?hal=user/daftaruser");
    exit;
}

// Ambil data user dengan join ke jabatan
$stmt = $koneksi->prepare("
    SELECT u.*, j.namajabatan 
    FROM user u 
    LEFT JOIN jabatan j ON u.idjabatan = j.idjabatan 
    WHERE iduser = ? 
    LIMIT 1
");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    header("Location: " . BASE_URL . "dashboard.php?hal=user/daftaruser");
    exit;
}

include PAGES_PATH . 'user/header.php';
include PAGES_PATH . 'user/navbar.php';
include PAGES_PATH . 'user/sidebar.php';
?>

<div class="content">
    <section class="content-header">
        <h1>Detail User</h1>
    </section>

    <section class="content">
        <div class="card shadow-sm">
            <div class="card-body row">

                <!-- Foto -->
                <div class="col-md-6 text-center">
                    <?php if (!empty($user['foto'])): ?>
                        <img src="<?= BASE_URL ?>uploads/user/<?= $user['foto'] ?>" class="img-thumbnail" width="450">
                    <?php else: ?>
                        <img src="<?= BASE_URL ?>assets/img/default-profile.png" class="img-thumbnail" width="450">
                    <?php endif; ?>
                    <h5 class="mt-2"><?= htmlspecialchars($user['namauser']) ?></h5>
                    <span class="badge bg-info"><?= ucfirst($user['role']) ?></span>
                </div>

                <!-- Detail info -->
                <div class="col-md-3">
                    <p><strong>ID User:</strong> <?= $user['iduser'] ?></p>
                    <p><strong>Nama:</strong> <?= htmlspecialchars($user['namauser']) ?></p>
                    <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($user['email'] ?? '-') ?></p>
                    <p><strong>Jabatan:</strong> <?= htmlspecialchars($user['namajabatan'] ?? '-') ?></p>
                    <p><strong>Tanggal Buat:</strong> <?= date('d M Y H:i', strtotime($user['tanggalbuat'])) ?></p>
                    <p><strong>Role:</strong> <?= ucfirst($user['role']) ?></p>
                </div>

                <!-- Aksi -->
                <div class="col-md-3">
                    <h5>Aksi</h5>
                    <a href="<?= BASE_URL ?>dashboard.php?hal=user/edituser&id=<?= $user['iduser'] ?>" class="btn btn-warning btn-block">
                        <i class="fas fa-edit"></i> Edit
                    </a>

                    <a href="<?= BASE_URL ?>dashboard.php?hal=user/daftaruser" class="btn btn-secondary btn-block">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>

            </div>
        </div>
    </section>
</div>

<?php include PAGES_PATH . 'user/footer.php'; ?>
