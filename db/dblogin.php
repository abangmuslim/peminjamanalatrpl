<?php
session_start();
include "../koneksi.php";

// ====================================
// CEK ROLE LOGIN
// ====================================
if (!isset($_GET['role'])) {
    echo "<script>alert('Role login tidak diketahui!'); window.location='../index.php';</script>";
    exit;
}

$role = $_GET['role'];

// ====================================
// VALIDASI INPUT
// ====================================
if (empty($_POST['username']) || empty($_POST['password'])) {
    echo "<script>alert('Data login tidak lengkap!'); window.history.back();</script>";
    exit;
}

$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = mysqli_real_escape_string($koneksi, $_POST['password']);

// ====================================
// LOGIN ADMIN / PETUGAS
// ====================================
if ($role === 'admin') {
    $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username' LIMIT 1");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        // COCOKKAN PASSWORD BIASA (TIDAK HASH)
        if ($password === $data['password']) {
            // Simpan sesi
            $_SESSION['id'] = $data['idadmin'];
            $_SESSION['nama'] = $data['namaadmin'];
            $_SESSION['role'] = $data['role']; // admin / petugas

            // Arahkan ke dashboard sesuai role
            if ($data['role'] === 'admin') {
                header("Location: ../views/admin/dashboardadmin.php");
            } else {
                header("Location: ../views/admin/dashboardpetugas.php");
            }
            exit;
        } else {
            echo "<script>alert('Password salah!'); window.location='../views/admin/loginadmin.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Username tidak ditemukan!'); window.location='../views/admin/loginadmin.php';</script>";
        exit;
    }

    // ====================================
    // LOGIN PEMINJAM
    // ====================================
} elseif ($role === 'peminjam') {
    $query = mysqli_query($koneksi, "SELECT * FROM peminjam WHERE username='$username' LIMIT 1");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        // COCOKKAN PASSWORD BIASA
        if ($password === $data['password']) {
            if ($data['status'] === 'disetujui') {
                $_SESSION['id'] = $data['idpeminjam'];
                $_SESSION['nama'] = $data['namapeminjam'];
                $_SESSION['role'] = 'peminjam';

                header("Location: ../views/peminjam/dashboardpeminjam.php");
                exit;
            } else {
                echo "<script>alert('Akun Anda belum disetujui oleh admin.'); window.location='../views/peminjam/loginpeminjam.php';</script>";
                exit;
            }
        } else {
            echo "<script>alert('Password salah!'); window.location='../views/peminjam/loginpeminjam.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Username tidak ditemukan!'); window.location='../views/peminjam/loginpeminjam.php';</script>";
        exit;
    }

    // ====================================
    // ROLE TIDAK VALID
    // ====================================
} else {
    echo "<script>alert('Role login tidak valid!'); window.location='../index.php';</script>";
    exit;
}
?>
