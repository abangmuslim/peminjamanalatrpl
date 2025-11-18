<?php
// ============================================================
// File: includes/fungsiupload.php
// Deskripsi: Fungsi upload file dengan validasi tipe & ukuran
// Siap pakai untuk semua modul (user, peminjam, landing)
// ============================================================

/**
 * Upload file ke folder tertentu
 * @param array $file $_FILES['input_name']
 * @param string $folder nama folder di dalam uploads/
 * @param int $maxSize ukuran maksimum dalam byte (default 2MB)
 * @param array $allowedTipe daftar ekstensi yang diperbolehkan
 * @return array ['status'=>'success|error','filename'=>'','pesan'=>'']
 */
function upload_gambar($file, $folder = 'default', $maxSize = 2*1024*1024, $allowedTipe = ['jpg','jpeg','png'])
{
    // Folder target absolut
    $target_dir = __DIR__ . "/../uploads/$folder/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0755, true);

    // Data file
    $nama_file = basename($file["name"]);
    $tmp_name  = $file["tmp_name"];
    $ukuran    = $file["size"];
    $error     = $file["error"];

    // Tidak ada file
    if ($error === 4) return ['status'=>'error','filename'=>'','pesan'=>'Tidak ada file yang diunggah'];

    // Validasi ekstensi
    $ekstensi_file = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
    if (!in_array($ekstensi_file, $allowedTipe)) {
        return ['status'=>'error','filename'=>'','pesan'=>'Format file tidak diperbolehkan'];
    }

    // Validasi ukuran
    if ($ukuran > $maxSize) {
        return ['status'=>'error','filename'=>'','pesan'=>'Ukuran file terlalu besar'];
    }

    // Validasi MIME type & hindari file berbahaya
    $mime = mime_content_type($tmp_name);
    if (preg_match('/\.(php|exe|js|sh)$/i', $nama_file) || strpos($mime, 'php') !== false) {
        return ['status'=>'error','filename'=>'','pesan'=>'File berbahaya tidak diperbolehkan'];
    }

    // Nama file unik
    $nama_baru = time() . '_' . bin2hex(random_bytes(5)) . '.' . $ekstensi_file;

    // Upload file
    if (move_uploaded_file($tmp_name, $target_dir . $nama_baru)) {
        return ['status'=>'success','filename'=>$nama_baru,'pesan'=>'Upload berhasil'];
    } else {
        return ['status'=>'error','filename'=>'','pesan'=>'Gagal memindahkan file'];
    }
}
