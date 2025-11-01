-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 01, 2025 at 02:40 AM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `idadmin` int NOT NULL,
  `idjabatan` int DEFAULT NULL,
  `namaadmin` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`idadmin`, `idjabatan`, `namaadmin`, `username`, `password`, `foto`) VALUES
(1, NULL, 'Budi Santoso', 'budi', '12345', 'budi.jpg'),
(2, NULL, 'Siti Rahma', 'siti', '12345', 'siti.jpg'),
(3, NULL, 'Agus Prasetyo', 'agus', '12345', 'agus.jpg'),
(4, NULL, 'Dewi Lestari', 'dewi', '12345', 'dewi.jpg'),
(5, NULL, 'Rudi Hartono', 'rudi', '12345', 'rudi.jpg'),
(6, NULL, 'Nina Amelia', 'nina', '12345', 'nina.jpg'),
(7, NULL, 'Dian Putra', 'dian', '12345', 'dian.jpg'),
(8, NULL, 'Fajar Hidayat', 'fajar', '12345', 'fajar.jpg'),
(9, NULL, 'Mega Sari', 'mega', '12345', 'mega.jpg'),
(10, NULL, 'Andi Kurniawan', 'andi', '12345', 'andi.jpg');

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
  `foto` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `alat`
--

INSERT INTO `alat` (`idalat`, `idkategori`, `idmerk`, `namaalat`, `kondisi`, `idposisi`, `tanggalpembelian`, `foto`) VALUES
(14, 6, 4, 'LCD Epson', 'Baik', 1, '2025-10-27', '1761632215_9 P a ahmadi (5).png'),
(15, 2, 2, 'Laptop LOQ', 'Baik', 1, '2025-10-28', '1761632229_8 P C ahmadi (15).png'),
(16, 2, 7, 'LCD Epson', 'Baik', 2, '2025-10-21', '1761632280_9 P a ahmadi (5).png');

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
(10, 'Akuntansi dan Keuangan Lembaga'),
(15, 'Dewan Guru'),
(16, 'Pihak Luar'),
(17, 'Kepsek');

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

--
-- Dumping data for table `detilpeminjaman`
--

INSERT INTO `detilpeminjaman` (`iddetilpeminjaman`, `idpeminjaman`, `idalat`, `tanggalpinjam`, `tanggalkembali`, `tanggaldikembalikan`, `durasipeminjaman`, `jumlahharitelat`, `status`, `keterangan`, `denda`) VALUES
(2, 12, 15, '2025-10-30', '2025-11-08', NULL, 0, 0, 'tidakterlambat', 'belumkembali', '0.00'),
(3, 13, 14, '2025-10-30', '2025-11-05', NULL, 0, 0, 'tidakterlambat', 'belumkembali', '0.00'),
(4, 14, 15, '2025-10-30', '2025-11-08', NULL, 0, 0, 'tidakterlambat', 'belumkembali', '0.00'),
(5, 15, 15, '2025-10-30', '2025-11-08', NULL, 0, 0, 'tidakterlambat', 'belumkembali', '0.00'),
(6, 15, 14, '2025-10-30', '2025-11-08', NULL, 0, 0, 'tidakterlambat', 'belumkembali', '0.00'),
(7, 15, 16, '2025-10-30', '2025-11-08', NULL, 0, 0, 'tidakterlambat', 'belumkembali', '0.00'),
(8, 16, 15, '2025-10-30', '2025-11-06', NULL, 7, 0, 'tidakterlambat', 'belumkembali', '0.00');

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
(4, 'Tamu');

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
(10, 'Alat Pertukangan'),
(12, 'Alat Toilet');

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
(2, 'Lenovo'),
(3, 'Acer'),
(4, 'Asus'),
(5, 'HP'),
(7, 'Epson');

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
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `peminjam`
--

INSERT INTO `peminjam` (`idpeminjam`, `idasal`, `namapeminjam`, `username`, `password`, `foto`) VALUES
(1, 2, 'Ahmadi Muslim Peminjam', 'ahmadipeminjam', 'd71c2ea2075d94c637080622b9d13b4f', '20251013055501_Gemini_Generated_Image_1jgvc71jgvc71jgv.png'),
(29, 2, 'Shandra Dini', 'smkn1kb19', '12345', 'andre.jpg'),
(30, 3, 'Shelsy Olivia Blezinsky', 'smkn1kb20', '12345', 'rika.jpg'),
(31, 4, 'Sri Wahyunah', 'smkn1kb21', '12345', 'rika.jpg'),
(44, 1, 'Ahmadi Muslim coba', 'ahmadipeminjamcoba', '202cb962ac59075b964b07152d234b70', '20251013050227_Gemini_Generated_Image_2b0qnu2b0qnu2b0q.png'),
(45, 1, 'sriwahyunah', 'sriwahyunah', '10cc11dc13b56b4f861028db7d6cd200', '20251027062506_Gemini_Generated_Image_1jgvc71jgvc71jgv.png');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `idpeminjaman` int NOT NULL,
  `idadmin` int NOT NULL,
  `idpeminjam` int NOT NULL,
  `foto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`idpeminjaman`, `idadmin`, `idpeminjam`, `foto`) VALUES
(12, 1, 29, NULL),
(13, 1, 31, NULL),
(14, 1, 30, NULL),
(15, 1, 1, NULL),
(16, 1, 1, NULL);

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
(2, 'Kantor Guru RPL');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`idadmin`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_admin_jabatan` (`idjabatan`);

--
-- Indexes for table `alat`
--
ALTER TABLE `alat`
  ADD PRIMARY KEY (`idalat`),
  ADD KEY `fk_alat_kategori` (`idkategori`),
  ADD KEY `fk_alat_merk` (`idmerk`),
  ADD KEY `fk_alat_posisi` (`idposisi`);

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
  ADD KEY `fk_peminjam_asal` (`idasal`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `idadmin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `alat`
--
ALTER TABLE `alat`
  MODIFY `idalat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `asal`
--
ALTER TABLE `asal`
  MODIFY `idasal` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `detilpeminjaman`
--
ALTER TABLE `detilpeminjaman`
  MODIFY `iddetilpeminjaman` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `idjabatan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `idkategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `merk`
--
ALTER TABLE `merk`
  MODIFY `idmerk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `peminjam`
--
ALTER TABLE `peminjam`
  MODIFY `idpeminjam` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `idpeminjaman` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `posisi`
--
ALTER TABLE `posisi`
  MODIFY `idposisi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `fk_admin_jabatan` FOREIGN KEY (`idjabatan`) REFERENCES `jabatan` (`idjabatan`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `alat`
--
ALTER TABLE `alat`
  ADD CONSTRAINT `fk_alat_kategori` FOREIGN KEY (`idkategori`) REFERENCES `kategori` (`idkategori`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_alat_merk` FOREIGN KEY (`idmerk`) REFERENCES `merk` (`idmerk`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_alat_posisi` FOREIGN KEY (`idposisi`) REFERENCES `posisi` (`idposisi`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `detilpeminjaman`
--
ALTER TABLE `detilpeminjaman`
  ADD CONSTRAINT `detilpeminjaman_ibfk_1` FOREIGN KEY (`idpeminjaman`) REFERENCES `peminjaman` (`idpeminjaman`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detilpeminjaman_ibfk_2` FOREIGN KEY (`idalat`) REFERENCES `alat` (`idalat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `peminjam`
--
ALTER TABLE `peminjam`
  ADD CONSTRAINT `fk_peminjam_asal` FOREIGN KEY (`idasal`) REFERENCES `asal` (`idasal`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`idadmin`) REFERENCES `admin` (`idadmin`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`idpeminjam`) REFERENCES `peminjam` (`idpeminjam`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
