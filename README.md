# Aplikasi Peminjaman Alat RPL (CMSMAHDI)

Aplikasi ini digunakan untuk manajemen peminjaman alat laboratorium RPL.
Project dikembangkan menggunakan PHP Native dengan struktur modular seperti CMSMAHDI.

## Fitur Utama
- Otentikasi Admin, Petugas, Peminjam
- CRUD User, Jabatan, Merk, Kategori, Asal
- CRUD Alat
- Peminjaman & Pengembalian
- Komentar
- Dashboard role-based
- Landing page publik
- Upload gambar alat & user

## Struktur Folder Utama
Lihat di file `struktur.txt` untuk struktur lengkap.

## Persyaratan Server
- PHP 7.4+
- MySQL
- Apache (disarankan)

## Instalasi
1. Import database `cmsmahdi.sql`
2. Pastikan `includes/koneksi.php` benar.
3. Akses:
   - Backend: `dashboard.php`
   - Landing: `index.php`
