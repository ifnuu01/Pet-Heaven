-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 10, 2024 at 12:59 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pet_heaven`
--

-- --------------------------------------------------------

--
-- Table structure for table `alamat`
--

CREATE TABLE `alamat` (
  `id` int NOT NULL,
  `id_pengguna` int NOT NULL,
  `provinsi` varchar(200) NOT NULL,
  `kota_kabupaten` varchar(200) NOT NULL,
  `kecamatan` varchar(200) NOT NULL,
  `kelurahan` varchar(200) NOT NULL,
  `jalan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `alamat`
--

INSERT INTO `alamat` (`id`, `id_pengguna`, `provinsi`, `kota_kabupaten`, `kecamatan`, `kelurahan`, `jalan`) VALUES
(1, 1, 'Jawa Barat', 'Bandung', 'Cidadap', 'Sukajadi', 'Jl. Merdeka No. 5'),
(2, 2, 'DKI Jakarta', 'Jakarta Selatan', 'Cilandak', 'Cipete', 'Jl. Raya Cipete No. 12'),
(3, 3, 'Bali', 'Denpasar', 'Denpasar Selatan', 'Padangsambian', 'Jl. Sunset Road No. 8');

-- --------------------------------------------------------

--
-- Table structure for table `hewan`
--

CREATE TABLE `hewan` (
  `id` int NOT NULL,
  `nama_hewan` varchar(100) NOT NULL,
  `jenis_hewan` int NOT NULL,
  `warna` varchar(100) NOT NULL,
  `berat` decimal(10,2) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `jenis_kelamin` enum('Jantan','Betina') NOT NULL,
  `tahapan_usia` varchar(100) NOT NULL,
  `path_poto` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `tanggal_ditambahkan` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hewan`
--

INSERT INTO `hewan` (`id`, `nama_hewan`, `jenis_hewan`, `warna`, `berat`, `harga`, `jenis_kelamin`, `tahapan_usia`, `path_poto`, `status`, `tanggal_ditambahkan`) VALUES
(1, 'Bella', 1, 'Putih', '4.50', '1500000.00', 'Betina', 'Dewasa', '/assets/img/hewan/bella.jpg', 1, '2024-11-09 13:53:28'),
(2, 'Max', 2, 'Coklat', '8.20', '2000000.00', 'Jantan', 'Dewasa', '/assets/img/hewan/max.jpg', 1, '2024-11-09 13:53:28'),
(3, 'Goldfish', 3, 'Emas', '0.30', '50000.00', 'Betina', 'Bibit', '/assets/img/hewan/goldfish.jpg', 1, '2024-11-09 13:53:28'),
(4, 'Tweety', 4, 'Kuning', '0.05', '250000.00', 'Betina', 'Dewasa', '/assets/img/hewan/tweety.jpg', 1, '2024-11-09 13:53:28');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_hewan`
--

CREATE TABLE `jenis_hewan` (
  `id` int NOT NULL,
  `jenis_hewan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jenis_hewan`
--

INSERT INTO `jenis_hewan` (`id`, `jenis_hewan`) VALUES
(1, 'Kucing'),
(2, 'Anjing'),
(3, 'Ikan Hias'),
(4, 'Burung'),
(5, 'Reptil'),
(6, 'Hamster'),
(7, 'Serangga');

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` int NOT NULL,
  `id_pengguna` int NOT NULL,
  `no_pembelian` varchar(10) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id`, `id_pengguna`, `no_pembelian`, `message`) VALUES
(4, 1, '0509863556', 'Pembelian Anda sedang diproses.'),
(5, 2, '0478827355', 'Pembelian Anda telah dikonfirmasi.'),
(6, 3, '0112835747', 'Pembelian Anda ditolak karena pembayaran gagal.');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `nama_depan` varchar(50) NOT NULL,
  `nama_belakang` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `path_poto` varchar(255) DEFAULT '/assets/img/profiles/profile.jpg',
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('Pria','Wanita') DEFAULT NULL,
  `nomor_hp` varchar(13) DEFAULT NULL,
  `role` enum('User','Admin') DEFAULT 'User',
  `tanggal_dibuat` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `username`, `nama_depan`, `nama_belakang`, `email`, `password`, `path_poto`, `tanggal_lahir`, `jenis_kelamin`, `nomor_hp`, `role`, `tanggal_dibuat`) VALUES
(1, 'john_doe', 'John', 'Doe', 'john.doe@example.com', 'password123', '/assets/img/profiles/profile.jpg', '1990-01-01', 'Pria', '081234567890', 'User', '2024-11-09 13:52:26'),
(2, 'jane_smith', 'Jane', 'Smith', 'jane.smith@example.com', 'password456', '/assets/img/profiles/profile.jpg', '1995-05-15', 'Wanita', '081298765432', 'Admin', '2024-11-09 13:52:26'),
(3, 'michael_jones', 'Michael', 'Jones', 'michael.jones@example.com', 'password789', '/assets/img/profiles/profile.jpg', '1988-07-30', 'Pria', '082134567890', 'User', '2024-11-09 13:52:26'),
(4, 'zamzam', 'zam', 'zam', 'zam@gmail.com', '$2y$10$JDErS1kBOoZPxE0TLnPXzeI1bdFnK6HyXw.Nz7Q2VW0Zz/RQZYJLC', '/assets/img/profiles/profile.jpg', NULL, NULL, NULL, 'User', '2024-11-09 18:27:27'),
(5, 'Admin', 'Ifnu', 'Umar', 'Ifnuu01@gmail.com', '$2y$10$TwqsM.g5Iltcnrjvb4GDhOzFSSDHSdfplF8VgMpIsP/3GVVt5rJuq', '/assets/img/profiles/profile.jpg', NULL, NULL, NULL, 'Admin', '2024-11-10 09:59:13');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `no_pembelian` varchar(10) NOT NULL,
  `id_pengguna` int NOT NULL,
  `id_hewan` int NOT NULL,
  `biaya_pengiriman` decimal(10,2) NOT NULL DEFAULT '20000.00',
  `pajak` decimal(10,2) NOT NULL DEFAULT '2000.00',
  `bukti_pembayaran` varchar(255) NOT NULL,
  `status` enum('Menunggu','Dikonfirmasi','Ditolak') DEFAULT 'Menunggu',
  `waktu_pembayaran` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`no_pembelian`, `id_pengguna`, `id_hewan`, `biaya_pengiriman`, `pajak`, `bukti_pembayaran`, `status`, `waktu_pembayaran`) VALUES
('0112835747', 3, 3, '20000.00', '2000.00', '/assets/img/bukti_pembayaran/michael_jones.jpg', 'Ditolak', '2024-11-09 13:55:39'),
('0478827355', 1, 1, '20000.00', '2000.00', '/assets/img/bukti_pembayaran/john_doe.jpg', 'Menunggu', '2024-11-09 13:55:39'),
('0509863556', 2, 2, '20000.00', '2000.00', '/assets/img/bukti_pembayaran/jane_smith.jpg', 'Dikonfirmasi', '2024-11-09 13:55:39');

--
-- Triggers `transaksi`
--
DELIMITER $$
CREATE TRIGGER `before_insert_transaksi` BEFORE INSERT ON `transaksi` FOR EACH ROW BEGIN
    DECLARE new_no_pembelian VARCHAR(10);
    DECLARE random_no INT;

    -- Menghasilkan nomor acak 9 digit
    SET random_no = FLOOR(RAND() * 1000000000); -- Menghasilkan 9 digit
    SET new_no_pembelian = LPAD(random_no, 10, '0'); -- Menjadikan 10 digit dengan padding nol

    -- Memastikan bahwa no_pembelian yang dihasilkan unik
    WHILE EXISTS (SELECT 1 FROM transaksi WHERE no_pembelian = new_no_pembelian) DO
        SET random_no = FLOOR(RAND() * 1000000000); -- Menghasilkan 9 digit
        SET new_no_pembelian = LPAD(random_no, 10, '0'); -- Menjadikan 10 digit dengan padding nol
    END WHILE;

    SET NEW.no_pembelian = new_no_pembelian; -- Menyimpan nilai baru ke dalam kolom no_pembelian
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alamat`
--
ALTER TABLE `alamat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `hewan`
--
ALTER TABLE `hewan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jenis_hewan` (`jenis_hewan`);

--
-- Indexes for table `jenis_hewan`
--
ALTER TABLE `jenis_hewan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `no_pembelian` (`no_pembelian`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`no_pembelian`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `id_hewan` (`id_hewan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alamat`
--
ALTER TABLE `alamat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hewan`
--
ALTER TABLE `hewan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jenis_hewan`
--
ALTER TABLE `jenis_hewan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alamat`
--
ALTER TABLE `alamat`
  ADD CONSTRAINT `alamat_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hewan`
--
ALTER TABLE `hewan`
  ADD CONSTRAINT `hewan_ibfk_1` FOREIGN KEY (`jenis_hewan`) REFERENCES `jenis_hewan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifikasi_ibfk_2` FOREIGN KEY (`no_pembelian`) REFERENCES `transaksi` (`no_pembelian`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_hewan`) REFERENCES `hewan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
