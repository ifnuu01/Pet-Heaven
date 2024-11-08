-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 31, 2024 at 09:35 AM
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
-- Database: `pet_haven`
--

-- --------------------------------------------------------

--
-- Table structure for table `alamat`
--

CREATE TABLE `alamat` (
  `id` int NOT NULL,
  `id_pengguna` int NOT NULL,
  `provinsi` varchar(100) NOT NULL,
  `kota_kabupaten` varchar(100) NOT NULL,
  `kecamatan` varchar(100) NOT NULL,
  `kelurahan` varchar(100) NOT NULL,
  `jalan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `alamat`
--

INSERT INTO `alamat` (`id`, `id_pengguna`, `provinsi`, `kota_kabupaten`, `kecamatan`, `kelurahan`, `jalan`) VALUES
(16, 6, 'Jawa Barat', 'Bandung', 'Coblong', 'Cidadap', 'Jl. Sangkuriang No.1'),
(17, 7, 'Jawa Timur', 'Surabaya', 'Gubeng', 'Genteng', 'Jl. Diponegoro No.2'),
(18, 8, 'DKI Jakarta', 'Jakarta', 'Kebayoran Baru', 'Gunung', 'Jl. Jendral Sudirman No.3'),
(19, 9, 'Bali', 'Denpasar', 'Denpasar Selatan', 'Kesiman', 'Jl. Mahendradatta No.4'),
(20, 10, 'Yogyakarta', 'Yogyakarta', 'Gamping', 'Gamping', 'Jl. Raya Gamping No.5');

-- --------------------------------------------------------

--
-- Table structure for table `hewan`
--

CREATE TABLE `hewan` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `path_poto` varchar(255) NOT NULL,
  `tahap_usia` enum('Larva','Bibit','Anakan','Muda','Dewasa','Tua') DEFAULT NULL,
  `berat` decimal(5,2) DEFAULT NULL,
  `jenis_kelamin` enum('Jantan','Betina') DEFAULT NULL,
  `warna` varchar(100) NOT NULL,
  `jenis` enum('Kucing','Anjing','Reptil','Hamster','Burung','Serangga','Ikan Hias') NOT NULL,
  `spesies` varchar(100) DEFAULT NULL,
  `harga_hewan` decimal(20,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hewan`
--

INSERT INTO `hewan` (`id`, `nama`, `path_poto`, `tahap_usia`, `berat`, `jenis_kelamin`, `warna`, `jenis`, `spesies`, `harga_hewan`, `status`) VALUES
(6, 'Kucing Persia', 'assets/img/hewan/kucing_persia.jpg', 'Dewasa', '4.50', 'Betina', 'Putih', 'Kucing', 'Persia', '1500000.00', 1),
(7, 'Anjing Golden Retriever', 'assets/img/hewan/anjing_golden.jpg', 'Muda', '25.00', 'Jantan', 'Emas', 'Anjing', 'Golden Retriever', '5000000.00', 1),
(8, 'Ikan Hias Guppy', 'assets/img/hewan/ikan_guppy.jpg', 'Bibit', '0.50', 'Betina', 'Biru', 'Ikan Hias', 'Guppy', '10000.00', 1),
(9, 'Hamster Winter White', 'assets/img/hewan/hamster.jpg', 'Anakan', '0.20', 'Jantan', 'Putih', 'Hamster', 'Winter White', '50000.00', 1),
(10, 'Burung Kenari', 'assets/img/hewan/burung_kenari.jpg', 'Dewasa', '0.15', 'Betina', 'Kuning', 'Burung', 'Kenari', '300000.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` int NOT NULL,
  `id_pengguna` int NOT NULL,
  `message` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id`, `id_pengguna`, `message`) VALUES
(6, 1, 'Selamat datang di platform kami!'),
(7, 2, 'Pesanan Anda telah diproses.'),
(8, 3, 'Pemberitahuan: Kunjungi akun Anda untuk update.'),
(9, 4, 'Pesanan Anda sedang dalam pengiriman.'),
(10, 5, 'Terdapat diskon menarik untuk Anda!');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int NOT NULL,
  `nama_depan` varchar(50) NOT NULL,
  `nama_belakang` varchar(50) DEFAULT NULL,
  `path_poto` varchar(255) NOT NULL DEFAULT 'assets/img/profiles/profile.jpg',
  `email` varchar(100) NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('Pria','Wanita') DEFAULT NULL,
  `nomor_hp` varchar(15) DEFAULT NULL,
  `role` enum('Pembeli','Admin') NOT NULL DEFAULT 'Pembeli',
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `nama_depan`, `nama_belakang`, `path_poto`, `email`, `tanggal_lahir`, `jenis_kelamin`, `nomor_hp`, `role`, `password`) VALUES
(6, 'Budi', 'Santoso', 'assets/img/profiles/profile1.jpg', 'budi@example.com', '1990-01-01', 'Pria', '081234567890', 'Pembeli', 'password1'),
(7, 'Siti', 'Aisyah', 'assets/img/profiles/profile2.jpg', 'siti@example.com', '1992-02-02', 'Wanita', '081234567891', 'Pembeli', 'password2'),
(8, 'Joko', 'Widodo', 'assets/img/profiles/profile3.jpg', 'joko@example.com', '1985-03-03', 'Pria', '081234567892', 'Admin', 'password3'),
(9, 'Ayu', 'Lestari', 'assets/img/profiles/profile4.jpg', 'ayu@example.com', '1995-04-04', 'Wanita', '081234567893', 'Pembeli', 'password4'),
(10, 'Rudi', 'Hartono', 'assets/img/profiles/profile5.jpg', 'rudi@example.com', '1988-05-05', 'Pria', '081234567894', 'Pembeli', 'password5');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `no_pembelian` varchar(10) NOT NULL,
  `id_pengguna` int NOT NULL,
  `id_hewan` int NOT NULL,
  `path_bukti_pembayaran` varchar(255) NOT NULL,
  `biaya_pengiriman` decimal(20,2) DEFAULT '20000.00',
  `pajak` decimal(20,2) DEFAULT '2000.00',
  `status` enum('Menunggu','Berhasil','Ditolakk') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`no_pembelian`, `id_pengguna`, `id_hewan`, `path_bukti_pembayaran`, `biaya_pengiriman`, `pajak`, `status`) VALUES
('0348524988', 8, 8, 'assets/bukti/bukti3.jpg', '20000.00', '2000.00', NULL),
('0393116873', 10, 10, 'assets/bukti/bukti5.jpg', '20000.00', '2000.00', NULL),
('0618295537', 7, 7, 'assets/bukti/bukti2.jpg', '20000.00', '2000.00', NULL),
('0887738361', 9, 9, 'assets/bukti/bukti4.jpg', '20000.00', '2000.00', NULL),
('0914317577', 6, 6, 'assets/bukti/bukti1.jpg', '20000.00', '2000.00', NULL);

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `hewan`
--
ALTER TABLE `hewan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alamat`
--
ALTER TABLE `alamat`
  ADD CONSTRAINT `alamat_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
