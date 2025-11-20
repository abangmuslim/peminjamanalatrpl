-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 20, 2025 at 02:19 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `peminjamanalatrpl`
--

-- --------------------------------------------------------

--
-- Table structure for table `alat`
--

CREATE TABLE `alat` (
  `idalat` int NOT NULL,
  `idkategori` int DEFAULT NULL,
  `idmerk` int DEFAULT NULL,
  `namaalat` varchar(100) NOT NULL,
  `kondisi` varchar(50) DEFAULT NULL,
  `idposisi` int DEFAULT NULL,
  `tanggalpembelian` date DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `deskripsi` text,
  `tanggalbuat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `alat`
--

INSERT INTO `alat` (`idalat`, `idkategori`, `idmerk`, `namaalat`, `kondisi`, `idposisi`, `tanggalpembelian`, `foto`, `deskripsi`, `tanggalbuat`) VALUES
(1, 1, 1, 'Pensil', 'Baik', 1, '2025-10-01', 'pensil.jpg', 'Pensil warna hitam', '2025-11-18 11:16:32'),
(2, 2, 2, 'Laptop Lenovo', 'Baik', 2, '2025-10-02', 'laptop.jpg', 'Laptop Intel Core i5', '2025-11-18 11:16:32'),
(3, 3, 3, 'Tabung Reaksi', 'Baik', 3, '2025-10-03', 'tabung.jpg', 'Tabung reaksi kimia', '2025-11-18 11:16:32'),
(4, 4, 4, 'Bola Basket', 'Baik', 4, '2025-10-04', 'bola.jpg', 'Bola basket ukuran resmi', '2025-11-18 11:16:32'),
(5, 5, 5, 'Gitar Akustik', 'Baik', 5, '2025-10-05', 'gitar.jpg', 'Gitar akustik standar', '2025-11-18 11:16:32'),
(6, 6, 6, 'Sapu', 'Baik', 6, '2025-10-06', 'sapu.jpg', 'Sapu plastik', '2025-11-18 11:16:32'),
(7, 7, 7, 'Kompor Gas', 'Baik', 7, '2025-10-07', 'kompor.jpg', 'Kompor gas 2 tungku', '2025-11-18 11:16:32'),
(8, 8, 8, 'Kursi Kantor', 'Baik', 8, '2025-10-08', 'kursi.jpg', 'Kursi ergonomis', '2025-11-18 11:16:32'),
(9, 9, 9, 'Termometer', 'Baik', 9, '2025-10-09', 'termometer.jpg', 'Termometer digital', '2025-11-18 11:16:32'),
(10, 10, 10, 'Palu', 'Baik', 10, '2025-10-10', 'palu.jpg', 'Palu kayu', '2025-11-18 11:16:32');

-- --------------------------------------------------------

--
-- Table structure for table `asal`
--

CREATE TABLE `asal` (
  `idasal` int NOT NULL,
  `namaasal` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `asal`
--

INSERT INTO `asal` (`idasal`, `namaasal`) VALUES
(1, 'Rekayasa Perangkat Lunak'),
(2, 'Teknik Komputer dan Jaringan'),
(3, 'Multimedia'),
(4, 'Desain Komunikasi Visual'),
(5, 'Teknik Otomotif'),
(6, 'Teknik Elektronika Industri'),
(7, 'Teknik Pendingin dan Tata Udara'),
(8, 'Teknik Mesin'),
(9, 'Administrasi Perkantoran'),
(10, 'Akuntansi dan Keuangan Lembaga');

-- --------------------------------------------------------

--
-- Table structure for table `detilpeminjaman`
--

CREATE TABLE `detilpeminjaman` (
  `iddetilpeminjaman` int NOT NULL,
  `idpeminjaman` int NOT NULL,
  `idalat` int NOT NULL,
  `tanggalpinjam` date DEFAULT NULL,
  `tanggalkembali` date DEFAULT NULL,
  `tanggaldikembalikan` date DEFAULT NULL,
  `durasipeminjaman` int DEFAULT '0',
  `jumlahharitelat` int DEFAULT '0',
  `status` enum('terlambat','tidakterlambat') DEFAULT 'tidakterlambat',
  `keterangan` enum('sudahkembali','belumkembali') DEFAULT 'belumkembali',
  `denda` decimal(10,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `idjabatan` int NOT NULL,
  `namajabatan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`idjabatan`, `namajabatan`) VALUES
(1, 'Siswa'),
(2, 'Guru'),
(3, 'TU'),
(4, 'Tamu'),
(5, 'Admin'),
(6, 'Petugas'),
(7, 'Lainnya'),
(8, 'Koordinator'),
(9, 'Kepsek'),
(10, 'Wali Kelas');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `idkategori` int NOT NULL,
  `namakategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`idkategori`, `namakategori`) VALUES
(1, 'Alat Tulis'),
(2, 'Alat Elektronik'),
(3, 'Alat Laboratorium'),
(4, 'Alat Olahraga'),
(5, 'Alat Musik'),
(6, 'Alat Kebersihan'),
(7, 'Alat Memasak'),
(8, 'Alat Kantor'),
(9, 'Alat Kesehatan'),
(10, 'Alat Pertukangan');

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

CREATE TABLE `komentar` (
  `idkomentar` int NOT NULL,
  `idalat` int DEFAULT NULL,
  `idparent` int DEFAULT NULL,
  `namakomentar` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `isikomentar` text NOT NULL,
  `tanggalbuat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('tampil','sembunyi') DEFAULT 'tampil'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `komentar`
--

INSERT INTO `komentar` (`idkomentar`, `idalat`, `idparent`, `namakomentar`, `email`, `isikomentar`, `tanggalbuat`, `status`) VALUES
(1, 1, NULL, 'Ahmadi', 'ahmadi@example.com', 'Alat ini bagus', '2025-11-18 11:16:33', 'tampil'),
(2, 2, NULL, 'Shandra', 'shandra@example.com', 'Laptop cepat', '2025-11-18 11:16:33', 'tampil'),
(3, 3, NULL, 'Shelsy', 'shelsy@example.com', 'Tabung reaksi aman', '2025-11-18 11:16:33', 'tampil'),
(4, 4, NULL, 'Sri', 'sri@example.com', 'Bola basket oke', '2025-11-18 11:16:33', 'tampil'),
(5, 5, NULL, 'Rizka', 'rizka@example.com', 'Gitar bagus', '2025-11-18 11:16:33', 'tampil'),
(6, 6, NULL, 'Dewi', 'dewi@example.com', 'Sapu bersih', '2025-11-18 11:16:33', 'tampil'),
(7, 7, NULL, 'Fajar', 'fajar@example.com', 'Kompor berfungsi', '2025-11-18 11:16:33', 'tampil'),
(8, 8, NULL, 'Mega', 'mega@example.com', 'Kursi nyaman', '2025-11-18 11:16:33', 'tampil'),
(9, 9, NULL, 'Andi', 'andi@example.com', 'Termometer akurat', '2025-11-18 11:16:33', 'tampil'),
(10, 10, NULL, 'Nina', 'nina@example.com', 'Palu mantap', '2025-11-18 11:16:33', 'tampil');

-- --------------------------------------------------------

--
-- Table structure for table `merk`
--

CREATE TABLE `merk` (
  `idmerk` int NOT NULL,
  `namamerk` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `merk`
--

INSERT INTO `merk` (`idmerk`, `namamerk`) VALUES
(1, 'Lenovo'),
(2, 'Acer'),
(3, 'Asus'),
(4, 'HP'),
(5, 'Epson'),
(6, 'Canon'),
(7, 'Samsung'),
(8, 'Panasonic'),
(9, 'Dell'),
(10, 'LG');

-- --------------------------------------------------------

--
-- Table structure for table `peminjam`
--

CREATE TABLE `peminjam` (
  `idpeminjam` int NOT NULL,
  `idasal` int DEFAULT NULL,
  `namapeminjam` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `tanggalbuat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('disetujui','pending','ditolak') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `peminjam`
--

INSERT INTO `peminjam` (`idpeminjam`, `idasal`, `namapeminjam`, `username`, `password`, `foto`, `tanggalbuat`, `status`) VALUES
(1, 1, 'Peminjam Satu', 'peminjam1', '$2y$10$EKhsLrlRVujhyaZ0jmifKuNCCzjZUk/zjazN8YA6e38DT1r7lS56C', 'default.png', '2025-11-19 01:16:22', 'disetujui'),
(2, 1, 'Peminjam Dua', 'peminjam2', '$2y$10$k.v9cuEKIYl39hQZTugce.5BOJglKwcaVHXlqAs6ngq9d2DS/KcQC', 'default.png', '2025-11-19 01:16:22', 'disetujui'),
(3, 1, 'Peminjam Tiga', 'peminjam3', '$2y$10$N9qo8uLOickgx2ZMRZo5i.uWZsv8ZqZX9/7w0Z3i0hE/nm49KcT4i', 'default.png', '2025-11-19 01:16:22', 'disetujui'),
(4, 1, 'Peminjam Empat', 'peminjam4', '$2y$10$N9qo8uLOickgx2ZMRZo5i.uWZsv8ZqZX9/7w0Z3i0hE/nm49KcT4i', 'default.png', '2025-11-19 01:16:22', 'disetujui'),
(5, 1, 'Peminjam Lima', 'peminjam5', '$2y$10$N9qo8uLOickgx2ZMRZo5i.uWZsv8ZqZX9/7w0Z3i0hE/nm49KcT4i', 'default.png', '2025-11-19 01:16:22', 'disetujui'),
(6, 1, 'Peminjam Enam', 'peminjam6', '$2y$10$N9qo8uLOickgx2ZMRZo5i.uWZsv8ZqZX9/7w0Z3i0hE/nm49KcT4i', 'default.png', '2025-11-19 01:16:22', 'disetujui'),
(7, 1, 'Peminjam Tujuh', 'peminjam7', '$2y$10$N9qo8uLOickgx2ZMRZo5i.uWZsv8ZqZX9/7w0Z3i0hE/nm49KcT4i', 'default.png', '2025-11-19 01:16:22', 'disetujui'),
(8, 1, 'Peminjam Delapan', 'peminjam8', '$2y$10$N9qo8uLOickgx2ZMRZo5i.uWZsv8ZqZX9/7w0Z3i0hE/nm49KcT4i', 'default.png', '2025-11-19 01:16:22', 'disetujui'),
(9, 1, 'Peminjam Sembilan', 'peminjam9', '$2y$10$N9qo8uLOickgx2ZMRZo5i.uWZsv8ZqZX9/7w0Z3i0hE/nm49KcT4i', 'default.png', '2025-11-19 01:16:22', 'disetujui'),
(10, 1, 'Peminjam Sepuluh', 'peminjam10', '$2y$10$N9qo8uLOickgx2ZMRZo5i.uWZsv8ZqZX9/7w0Z3i0hE/nm49KcT4i', 'default.png', '2025-11-19 01:16:22', 'disetujui');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `idpeminjaman` int NOT NULL,
  `idadmin` int NOT NULL,
  `idpeminjam` int NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `tanggalbuat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posisi`
--

CREATE TABLE `posisi` (
  `idposisi` int NOT NULL,
  `namaposisi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `posisi`
--

INSERT INTO `posisi` (`idposisi`, `namaposisi`) VALUES
(1, 'Lab RPL'),
(2, 'Kantor Guru'),
(3, 'Gudang'),
(4, 'Ruang Multimedia'),
(5, 'Ruang BK'),
(6, 'Ruang Olahraga'),
(7, 'Ruang Musik'),
(8, 'Ruang Komputer'),
(9, 'Ruang Administrasi'),
(10, 'Laboratorium');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `iduser` int NOT NULL,
  `idjabatan` int DEFAULT NULL,
  `namauser` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `tanggalbuat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` enum('admin','petugas') NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`iduser`, `idjabatan`, `namauser`, `username`, `email`, `password`, `foto`, `tanggalbuat`, `role`) VALUES
(1, 1, 'Admin Satu', 'admin1', 'admin1@example.com', '$2y$10$WwhnM/GTnDf5zsb7VEGGC.bXgDK0/cnYDtCnDg.NQHiKqUjb4PPAm', '', '2025-11-18 20:04:08', 'admin'),
(2, 1, 'Admin Dua', 'admin2', 'admin2@example.com', '$2y$10$WwhnM/GTnDf5zsb7VEGGC.bXgDK0/cnYDtCnDg.NQHiKqUjb4PPAm', '', '2025-11-18 20:04:08', 'admin'),
(3, 1, 'Admin Tiga', 'admin3', 'admin3@example.com', '$2y$10$WwhnM/GTnDf5zsb7VEGGC.bXgDK0/cnYDtCnDg.NQHiKqUjb4PPAm', '', '2025-11-18 20:04:08', 'admin'),
(4, 1, 'Admin Empat', 'admin4', 'admin4@example.com', '$2y$10$f.mkQGdqYPISAz741GZVFeSvqfWgYVNspixLREerTk5wmPzbcbHGK', '', '2025-11-18 20:04:08', 'admin'),
(5, 1, 'Admin Lima', 'admin5', 'admin5@example.com', '$2y$10$a4zX/xm2GEdOpaPvc5YBGecNyMFQoAHQZ50aPDUGy3D5OA0WaPDci', '', '2025-11-18 20:04:08', 'admin'),
(6, 2, 'Petugas Satu', 'petugas1', 'petugas1@example.com', '$2y$10$oPYp4Nm5VZ3ivsUT0WHmoO82dzjkhbnYrFtT35hoZZo.15BK6giSK', '', '2025-11-18 20:04:08', 'petugas'),
(7, 2, 'Petugas Dua', 'petugas2', 'petugas2@example.com', '$2y$10$oPYp4Nm5VZ3ivsUT0WHmoO82dzjkhbnYrFtT35hoZZo.15BK6giSK', '', '2025-11-18 20:04:08', 'petugas'),
(8, 2, 'Petugas Tiga', 'petugas3', 'petugas3@example.com', '$2y$10$oPYp4Nm5VZ3ivsUT0WHmoO82dzjkhbnYrFtT35hoZZo.15BK6giSK', '', '2025-11-18 20:04:08', 'petugas'),
(9, 2, 'Petugas Empat', 'petugas4', 'petugas4@example.com', '$2y$10$mTANo4OOLl5FJQrpbJd6VO6fvCbRPk45QJ1AGV0oY2KV.B7p3ST2m', '', '2025-11-18 20:04:08', 'petugas'),
(10, 2, 'Petugas Lima', 'petugas5', 'petugas5@example.com', '$2y$10$mTANo4OOLl5FJQrpbJd6VO6fvCbRPk45QJ1AGV0oY2KV.B7p3ST2m', '', '2025-11-18 20:04:08', 'petugas');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alat`
--
ALTER TABLE `alat`
  ADD PRIMARY KEY (`idalat`),
  ADD KEY `idkategori` (`idkategori`),
  ADD KEY `idmerk` (`idmerk`),
  ADD KEY `idposisi` (`idposisi`);

--
-- Indexes for table `asal`
--
ALTER TABLE `asal`
  ADD PRIMARY KEY (`idasal`);

--
-- Indexes for table `detilpeminjaman`
--
ALTER TABLE `detilpeminjaman`
  ADD PRIMARY KEY (`iddetilpeminjaman`),
  ADD KEY `idpeminjaman` (`idpeminjaman`),
  ADD KEY `idalat` (`idalat`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`idjabatan`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`idkategori`);

--
-- Indexes for table `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`idkomentar`),
  ADD KEY `idalat` (`idalat`),
  ADD KEY `idparent` (`idparent`);

--
-- Indexes for table `merk`
--
ALTER TABLE `merk`
  ADD PRIMARY KEY (`idmerk`);

--
-- Indexes for table `peminjam`
--
ALTER TABLE `peminjam`
  ADD PRIMARY KEY (`idpeminjam`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idasal` (`idasal`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`idpeminjaman`),
  ADD KEY `idadmin` (`idadmin`),
  ADD KEY `idpeminjam` (`idpeminjam`);

--
-- Indexes for table `posisi`
--
ALTER TABLE `posisi`
  ADD PRIMARY KEY (`idposisi`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`iduser`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idjabatan` (`idjabatan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alat`
--
ALTER TABLE `alat`
  MODIFY `idalat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `asal`
--
ALTER TABLE `asal`
  MODIFY `idasal` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `detilpeminjaman`
--
ALTER TABLE `detilpeminjaman`
  MODIFY `iddetilpeminjaman` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `idjabatan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `idkategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `komentar`
--
ALTER TABLE `komentar`
  MODIFY `idkomentar` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `merk`
--
ALTER TABLE `merk`
  MODIFY `idmerk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `peminjam`
--
ALTER TABLE `peminjam`
  MODIFY `idpeminjam` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `idpeminjaman` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `posisi`
--
ALTER TABLE `posisi`
  MODIFY `idposisi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `iduser` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alat`
--
ALTER TABLE `alat`
  ADD CONSTRAINT `alat_ibfk_1` FOREIGN KEY (`idkategori`) REFERENCES `kategori` (`idkategori`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `alat_ibfk_2` FOREIGN KEY (`idmerk`) REFERENCES `merk` (`idmerk`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `alat_ibfk_3` FOREIGN KEY (`idposisi`) REFERENCES `posisi` (`idposisi`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `detilpeminjaman`
--
ALTER TABLE `detilpeminjaman`
  ADD CONSTRAINT `detilpeminjaman_ibfk_1` FOREIGN KEY (`idpeminjaman`) REFERENCES `peminjaman` (`idpeminjaman`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detilpeminjaman_ibfk_2` FOREIGN KEY (`idalat`) REFERENCES `alat` (`idalat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `komentar`
--
ALTER TABLE `komentar`
  ADD CONSTRAINT `komentar_ibfk_1` FOREIGN KEY (`idalat`) REFERENCES `alat` (`idalat`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `komentar_ibfk_2` FOREIGN KEY (`idparent`) REFERENCES `komentar` (`idkomentar`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `peminjam`
--
ALTER TABLE `peminjam`
  ADD CONSTRAINT `peminjam_ibfk_1` FOREIGN KEY (`idasal`) REFERENCES `asal` (`idasal`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`idadmin`) REFERENCES `user` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`idpeminjam`) REFERENCES `peminjam` (`idpeminjam`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`idjabatan`) REFERENCES `jabatan` (`idjabatan`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
