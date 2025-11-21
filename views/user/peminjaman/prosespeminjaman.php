<?php
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';
require_once __DIR__ . '/../../../includes/fungsiupload.php';

$db = $koneksi;
$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';

//
// ================= TAMBAH PEMINJAMAN =================
if ($aksi === 'tambah') {
    $idadmin = $_SESSION['iduser']; // admin/petugas
    $idpeminjam = $_POST['idpeminjam'];

    // Upload foto dokumen
    $foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== 4) {
        $upload = upload_gambar($_FILES['foto'], 'peminjaman');
        if ($upload['status'] === 'success') $foto = $upload['filename'];
    }

    // Insert peminjaman
    $stmt = $db->prepare("INSERT INTO peminjaman (idadmin, idpeminjam, foto) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $idadmin, $idpeminjam, $foto);
    $stmt->execute();

    $idpeminjaman = $stmt->insert_id;

    // Insert detil peminjaman
    if (!empty($_POST['idalat'])) {
        foreach ($_POST['idalat'] as $i => $idalat) {
            $tanggalpinjam = $_POST['tanggalpinjam'][$i] ?? date('Y-m-d');
            $tanggalkembali = $_POST['tanggalkembali'][$i] ?? date('Y-m-d', strtotime('+1 day'));

            $stmtDetil = $db->prepare("
                INSERT INTO detilpeminjaman 
                (idpeminjaman, idalat, tanggalpinjam, tanggalkembali, keterangan, status, denda)
                VALUES (?, ?, ?, ?, 'belumkembali', 'tidakterlambat', 0)
            ");
            $stmtDetil->bind_param("iiss", $idpeminjaman, $idalat, $tanggalpinjam, $tanggalkembali);
            $stmtDetil->execute();
        }
    }

    header("Location: ../../../dashboard.php?hal=peminjaman/daftarpeminjaman&msg=sukses_tambah");
    exit;
}

//
// ================= EDIT PEMINJAMAN =================
if ($aksi === 'edit') {
    $idpeminjaman = $_POST['idpeminjaman'];
    $idpeminjam = $_POST['idpeminjam'];

    // Upload foto baru
    $fotoBaru = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== 4) {
        $upload = upload_gambar($_FILES['foto'], 'peminjaman');
        if ($upload['status'] === 'success') {
            $fotoBaru = $upload['filename'];
            $fotoLama = $_POST['fotolama'] ?? '';
            if ($fotoLama && file_exists(__DIR__ . "/../../../uploads/peminjaman/$fotoLama")) {
                unlink(__DIR__ . "/../../../uploads/peminjaman/$fotoLama");
            }
        }
    }
    $fotoFinal = $fotoBaru ?? $_POST['fotolama'];

    // Update peminjaman
    $stmt = $db->prepare("UPDATE peminjaman SET idpeminjam=?, foto=? WHERE idpeminjaman=?");
    $stmt->bind_param("isi", $idpeminjam, $fotoFinal, $idpeminjaman);
    $stmt->execute();

    // ===== Update / Insert detil peminjaman =====
    $idalatArr = $_POST['idalat'] ?? [];
    $tanggalpinjamArr = $_POST['tanggalpinjam'] ?? [];
    $tanggalkembaliArr = $_POST['tanggalkembali'] ?? [];
    $iddetilArr = $_POST['iddetilpeminjaman'] ?? [];

    foreach ($idalatArr as $i => $idalat) {
        $tanggalpinjam = $tanggalpinjamArr[$i] ?? date('Y-m-d');
        $tanggalkembali = $tanggalkembaliArr[$i] ?? date('Y-m-d', strtotime('+1 day'));
        $iddetil = $iddetilArr[$i] ?? null;

        if ($iddetil) {
            // Update detil lama
            $stmtDetil = $db->prepare("
                UPDATE detilpeminjaman 
                SET idalat=?, tanggalpinjam=?, tanggalkembali=? 
                WHERE iddetilpeminjaman=?
            ");
            $stmtDetil->bind_param("issi", $idalat, $tanggalpinjam, $tanggalkembali, $iddetil);
            $stmtDetil->execute();
        } else {
            // Insert alat baru
            $stmtDetil = $db->prepare("
                INSERT INTO detilpeminjaman
                (idpeminjaman, idalat, tanggalpinjam, tanggalkembali, keterangan, status, denda)
                VALUES (?, ?, ?, ?, 'belumkembali', 'tidakterlambat', 0)
            ");
            $stmtDetil->bind_param("iiss", $idpeminjaman, $idalat, $tanggalpinjam, $tanggalkembali);
            $stmtDetil->execute();
        }
    }

    header("Location: ../../../dashboard.php?hal=peminjaman/daftarpeminjaman&msg=sukses_edit");
    exit;
}

//
// ================= HAPUS PEMINJAMAN =================
if ($aksi === 'hapus') {
    $id = $_GET['id'];

    // Hapus foto
    $foto = $db->query("SELECT foto FROM peminjaman WHERE idpeminjaman=$id")->fetch_assoc()['foto'];
    if ($foto && file_exists(__DIR__ . "/../../../uploads/peminjaman/$foto")) {
        unlink(__DIR__ . "/../../../uploads/peminjaman/$foto");
    }

    // Hapus detil peminjaman
    $db->query("DELETE FROM detilpeminjaman WHERE idpeminjaman=$id");

    // Hapus peminjaman
    $db->query("DELETE FROM peminjaman WHERE idpeminjaman=$id");

    header("Location: ../../../dashboard.php?hal=peminjaman/daftarpeminjaman&msg=sukses_hapus");
    exit;
}
?>
