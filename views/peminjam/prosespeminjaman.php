<?php
// ============================================================
// File: views/peminjam/prosespeminjaman.php
// Deskripsi: Proses tambah peminjaman untuk peminjam
// ============================================================

session_start();
require_once __DIR__ . '/../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';

// Cek login peminjam
if (!isset($_SESSION['idpeminjam'])) {
    header("Location: ?hal=loginpeminjam");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idpeminjam = $_POST['idpeminjam'];
    $idalat_list = $_POST['idalat'] ?? [];
    $tanggalpinjam = $_POST['tanggalpinjam'];
    $tanggalkembali = $_POST['tanggalkembali'];

    // Validasi input
    if (empty($idalat_list) || empty($tanggalpinjam) || empty($tanggalkembali)) {
        $_SESSION['error'] = "Semua field wajib diisi!";
        header("Location: ?hal=tambahpeminjaman");
        exit;
    }

    // Upload foto jika ada
    $foto_filename = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto_filename = 'peminjaman_' . time() . '.' . $ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], __DIR__ . '/uploads/' . $foto_filename);
    }

    try {
        $koneksi->beginTransaction();

        // 1. Insert ke tabel peminjaman
        $sql = "INSERT INTO peminjaman (idadmin, idpeminjam, foto) VALUES (NULL, :idpeminjam, :foto)";
        $stmt = $koneksi->prepare($sql);
        $stmt->execute([
            ':idpeminjam' => $idpeminjam,
            ':foto' => $foto_filename
        ]);

        $idpeminjaman = $koneksi->lastInsertId();

        // 2. Insert ke detilpeminjaman untuk tiap alat
        foreach ($idalat_list as $idalat) {
            $durasi = (strtotime($tanggalkembali) - strtotime($tanggalpinjam)) / (60*60*24); // durasi dalam hari

            $sql2 = "INSERT INTO detilpeminjaman 
                     (idpeminjaman, idalat, tanggalpinjam, tanggalkembali, durasipeminjaman, status, keterangan, denda)
                     VALUES (:idpeminjaman, :idalat, :tanggalpinjam, :tanggalkembali, :durasi, 'tidakterlambat', 'belumkembali', 0)";
            $stmt2 = $koneksi->prepare($sql2);
            $stmt2->execute([
                ':idpeminjaman' => $idpeminjaman,
                ':idalat' => $idalat,
                ':tanggalpinjam' => $tanggalpinjam,
                ':tanggalkembali' => $tanggalkembali,
                ':durasi' => $durasi
            ]);
        }

        $koneksi->commit();
        $_SESSION['success'] = "Peminjaman berhasil dibuat!";
        header("Location: ?hal=dashboardpeminjam");
        exit;

    } catch (Exception $e) {
        $koneksi->rollBack();
        $_SESSION['error'] = "Terjadi kesalahan: " . $e->getMessage();
        header("Location: ?hal=tambahpeminjaman");
        exit;
    }
} else {
    header("Location: ?hal=dashboardpeminjam");
    exit;
}
