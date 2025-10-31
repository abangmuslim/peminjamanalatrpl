<?php
$proses = isset($_GET['proses']) ? $_GET['proses'] : '';
include "../koneksi.php";

// sementara belum ada login, isi manual ID admin
$idadmin_default = 1; // ganti sesuai ID admin yang ada di tabel admin

// ============================
// PROSES TAMBAH PEMINJAMAN
// ============================
if ($proses == 'tambah') {
    $idpeminjam = $_POST['idpeminjam'];
    $tanggalpinjam = $_POST['tanggalpinjam'];
    $tanggalkembali = $_POST['tanggalkembali'];
    $daftar_alat = $_POST['idalat']; // array alat dari checkbox / select multiple

    // Hitung durasi peminjaman (dalam hari)
    $tgl_pinjam = new DateTime($tanggalpinjam);
    $tgl_kembali = new DateTime($tanggalkembali);
    $durasipeminjaman = $tgl_pinjam->diff($tgl_kembali)->days;

    // Simpan data ke tabel peminjaman (MASTER)
    mysqli_query($koneksi, "INSERT INTO peminjaman (idpeminjam, idadmin)
                            VALUES ('$idpeminjam', '$idadmin_default')");

    // Ambil ID peminjaman terakhir
    $idpeminjaman = mysqli_insert_id($koneksi);

    // Simpan data detail peminjaman (DETAIL)
    foreach ($daftar_alat as $idalat) {
        mysqli_query($koneksi, "INSERT INTO detilpeminjaman 
            (idpeminjaman, idalat, tanggalpinjam, tanggalkembali, durasipeminjaman, jumlahharitelat, status, keterangan, denda)
            VALUES 
            ('$idpeminjaman', '$idalat', '$tanggalpinjam', '$tanggalkembali', 
             '$durasipeminjaman', '0', 'tidakterlambat', 'belumkembali', '0')");
    }

    header("location:../index.php?halaman=daftarpeminjaman");
    exit;
}

// ============================
// PROSES EDIT PEMINJAMAN
// ============================
elseif ($proses == 'edit') {
    $idpeminjaman = $_POST['idpeminjaman'];
    $idpeminjam = $_POST['idpeminjam'];
    $tanggalpinjam = $_POST['tanggalpinjam'];
    $tanggalkembali = $_POST['tanggalkembali'];
    $daftar_alat = $_POST['idalat'];

    // Hitung durasi peminjaman baru
    $tgl_pinjam = new DateTime($tanggalpinjam);
    $tgl_kembali = new DateTime($tanggalkembali);
    $durasipeminjaman = $tgl_pinjam->diff($tgl_kembali)->days;

    // Update data master
    mysqli_query($koneksi, "UPDATE peminjaman SET 
                                idpeminjam='$idpeminjam',
                                idadmin='$idadmin_default'
                             WHERE idpeminjaman='$idpeminjaman'");

    // Hapus detail lama
    mysqli_query($koneksi, "DELETE FROM detilpeminjaman WHERE idpeminjaman='$idpeminjaman'");

    // Tambahkan detail baru
    foreach ($daftar_alat as $idalat) {
        mysqli_query($koneksi, "INSERT INTO detilpeminjaman 
            (idpeminjaman, idalat, tanggalpinjam, tanggalkembali, durasipeminjaman, jumlahharitelat, status, keterangan, denda)
            VALUES 
            ('$idpeminjaman', '$idalat', '$tanggalpinjam', '$tanggalkembali', 
             '$durasipeminjaman', '0', 'tidakterlambat', 'belumkembali', '0')");
    }

    header("location:../index.php?halaman=daftarpeminjaman");
    exit;
}

// ============================
// PROSES HAPUS PEMINJAMAN
// ============================
elseif ($proses == 'hapus') {
    $idpeminjaman = $_GET['idpeminjaman'];

    mysqli_query($koneksi, "DELETE FROM detilpeminjaman WHERE idpeminjaman='$idpeminjaman'");
    mysqli_query($koneksi, "DELETE FROM peminjaman WHERE idpeminjaman='$idpeminjaman'");

    header("location:../index.php?halaman=daftarpeminjaman");
    exit;
}

// ============================
// PROSES PENGEMBALIAN
// ============================
elseif ($proses == 'kembalikan') {
    $idpeminjaman = $_POST['idpeminjaman'];
    $tanggalpengembalian = $_POST['tanggalpengembalian']; // array: iddetilpeminjaman => tgl
    $dibayar = isset($_POST['dibayar']) ? $_POST['dibayar'] : 0;

    // Inisialisasi total denda keseluruhan
    $totalDenda = 0;

    foreach ($tanggalpengembalian as $iddetil => $tglKembaliAktual) {
        // Ambil data lama untuk hitung keterlambatan
        $q = mysqli_query($koneksi, "SELECT tanggalkembali FROM detilpeminjaman WHERE iddetilpeminjaman='$iddetil'");
        $data = mysqli_fetch_assoc($q);
        $tanggalkembali_seharusnya = $data['tanggalkembali'];

        // Hitung jumlah hari terlambat
        $terlambat = (strtotime($tglKembaliAktual) - strtotime($tanggalkembali_seharusnya)) / (60 * 60 * 24);
        $terlambat = ($terlambat > 0) ? $terlambat : 0;

        // Hitung denda per hari = 1000
        $denda = $terlambat * 1000;
        $totalDenda += $denda;

        $status = ($terlambat > 0) ? 'terlambat' : 'tidakterlambat';
        $keterangan = 'sudahkembali';

        // Update tabel detilpeminjaman
        mysqli_query($koneksi, "UPDATE detilpeminjaman SET 
            tanggalpengembalian='$tglKembaliAktual',
            jumlahharitelat='$terlambat',
            denda='$denda',
            status='$status',
            keterangan='$keterangan'
            WHERE iddetilpeminjaman='$iddetil'");
    }

    // Hitung tunggakan & kembalian
    $tunggakan = ($dibayar < $totalDenda) ? ($totalDenda - $dibayar) : 0;

    // Simpan info pembayaran di tabel peminjaman
    mysqli_query($koneksi, "UPDATE peminjaman SET 
        totaldenda='$totalDenda',
        dibayar='$dibayar',
        tunggakan='$tunggakan',
        tanggalbayar=NOW()
        WHERE idpeminjaman='$idpeminjaman'");

    header("location:../index.php?halaman=daftarpengembalian");
    exit;
}
?>
