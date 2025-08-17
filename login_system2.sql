-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 09, 2025 at 09:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `login_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `hasil_defuzzifikasi`
--

CREATE TABLE `hasil_defuzzifikasi` (
  `id` int(11) NOT NULL,
  `peserta_id` int(11) NOT NULL,
  `nama_peserta` varchar(255) NOT NULL,
  `hasil_defuzzifikasi` float NOT NULL,
  `kelulusan` enum('Lulus','Tidak Lulus') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hasil_defuzzifikasi`
--

INSERT INTO `hasil_defuzzifikasi` (`id`, `peserta_id`, `nama_peserta`, `hasil_defuzzifikasi`, `kelulusan`, `created_at`) VALUES
(1, 3, 'Ahmad', 58.33, 'Tidak Lulus', '2025-02-08 09:17:47'),
(2, 12, 'Vergiawan', 67, 'Lulus', '2025-02-08 09:17:47'),
(3, 13, 'Ratna', 55.72, 'Tidak Lulus', '2025-02-08 09:17:47'),
(4, 14, 'Regina', 67, 'Lulus', '2025-02-08 09:17:47'),
(5, 15, 'Salsa', 67, 'Lulus', '2025-02-08 09:17:47'),
(6, 16, 'Windra', 67, 'Lulus', '2025-02-08 09:17:47'),
(7, 17, 'Afrizal', 65.67, 'Lulus', '2025-02-08 09:17:47'),
(8, 18, 'Chintya', 67, 'Lulus', '2025-02-08 09:17:47'),
(9, 19, 'Rifqi', 67, 'Lulus', '2025-02-08 09:17:47'),
(10, 20, 'Dyana', 55.72, 'Tidak Lulus', '2025-02-08 09:17:47'),
(11, 21, 'Arilla', 67, 'Lulus', '2025-02-08 09:17:47'),
(12, 22, 'Afifah', 50, 'Tidak Lulus', '2025-02-08 09:17:47'),
(13, 23, 'Maharani', 67, 'Lulus', '2025-02-08 09:17:47'),
(14, 24, 'Rida', 67, 'Lulus', '2025-02-08 09:17:47'),
(15, 25, 'Zhafran', 50, 'Tidak Lulus', '2025-02-08 09:17:47'),
(16, 26, 'Jihan', 67, 'Lulus', '2025-02-08 09:17:47'),
(17, 27, 'Wahyudi', 50, 'Tidak Lulus', '2025-02-08 09:17:47'),
(18, 28, 'Rofifah', 67, 'Lulus', '2025-02-08 09:17:47'),
(19, 29, 'Aisyah', 51.37, 'Tidak Lulus', '2025-02-08 09:17:47'),
(20, 30, 'Miranda ', 67, 'Lulus', '2025-02-08 09:17:47'),
(21, 31, 'Nadia ', 67, 'Lulus', '2025-02-08 09:17:47'),
(22, 32, 'Fajrani', 67, 'Lulus', '2025-02-08 09:17:47'),
(23, 33, 'Nurul ', 67, 'Lulus', '2025-02-08 09:17:47'),
(24, 34, 'Riva ', 63.16, 'Tidak Lulus', '2025-02-08 09:17:47'),
(25, 35, 'Rahmat ', 67, 'Lulus', '2025-02-08 09:17:47'),
(26, 36, 'Novi ', 67, 'Lulus', '2025-02-08 09:17:47'),
(27, 37, 'Rio H', 67, 'Lulus', '2025-02-08 09:17:47'),
(28, 38, 'Rais ', 63.16, 'Tidak Lulus', '2025-02-08 09:17:47'),
(29, 39, 'SUFIRA', 67, 'Lulus', '2025-02-08 09:17:47'),
(30, 40, 'Firdaus', 61.43, 'Tidak Lulus', '2025-02-08 09:17:47'),
(31, 41, 'Rida', 63.77, 'Tidak Lulus', '2025-02-08 09:17:47'),
(32, 42, 'Aurellia', 67, 'Lulus', '2025-02-08 09:17:47'),
(33, 43, 'Syafrudin ', 61.75, 'Tidak Lulus', '2025-02-08 09:17:47'),
(34, 44, 'Jumarinda', 67, 'Lulus', '2025-02-08 09:17:47'),
(35, 45, 'Andi ', 50, 'Tidak Lulus', '2025-02-08 09:17:47'),
(36, 46, 'Arvi ', 51.08, 'Tidak Lulus', '2025-02-08 09:17:47');

-- --------------------------------------------------------

--
-- Table structure for table `konversi_peserta`
--

CREATE TABLE `konversi_peserta` (
  `id` int(11) NOT NULL,
  `peserta_id` int(11) NOT NULL,
  `ipk` float NOT NULL,
  `konversi_ipk` float NOT NULL,
  `wawancara` int(11) NOT NULL,
  `konversi_wawancara` float NOT NULL,
  `skor` int(11) NOT NULL,
  `konversi_skor` float NOT NULL,
  `defuzzifikasi` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `konversi_peserta`
--

INSERT INTO `konversi_peserta` (`id`, `peserta_id`, `ipk`, `konversi_ipk`, `wawancara`, `konversi_wawancara`, `skor`, `konversi_skor`, `defuzzifikasi`) VALUES
(617, 12, 3.8, 1, 90, 1, 100, 1, 67),
(618, 14, 3.89, 1, 80, 0.75, 70, 0.75, 67),
(619, 15, 3.5, 1, 70, 0.75, 100, 1, 67),
(620, 16, 3.5, 1, 100, 1, 100, 1, 67),
(621, 17, 3.47, 0.75, 90, 1, 70, 0.75, 65.67),
(622, 18, 3.89, 1, 100, 1, 70, 0.75, 67),
(623, 19, 3.68, 1, 90, 1, 100, 1, 67),
(624, 21, 3.88, 1, 70, 0.75, 70, 0.75, 67),
(625, 23, 3.88, 1, 90, 1, 100, 1, 67),
(626, 24, 3.57, 1, 90, 1, 100, 1, 67),
(627, 26, 3.62, 1, 100, 1, 70, 0.75, 67),
(628, 28, 3.78, 1, 90, 1, 100, 1, 67),
(629, 30, 3.7, 1, 75, 0.75, 80, 0.75, 67),
(630, 31, 3.92, 1, 75, 0.75, 95, 1, 67),
(631, 32, 3.86, 1, 80, 0.75, 95, 1, 67),
(632, 33, 3.74, 1, 70, 0.75, 70, 0.75, 67),
(633, 35, 3.53, 1, 90, 1, 90, 1, 67),
(634, 36, 3.79, 1, 100, 1, 80, 0.75, 67),
(635, 37, 3.53, 1, 70, 0.75, 90, 1, 67),
(636, 39, 3.78, 1, 100, 1, 80, 0.75, 67),
(637, 42, 3.8, 1, 100, 1, 70, 0.75, 67),
(638, 44, 3.58, 1, 100, 1, 80, 0.75, 67);

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `bobot` varchar(50) DEFAULT NULL,
  `jenis` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id`, `nama`, `deskripsi`, `bobot`, `jenis`) VALUES
(10, 'ipk', 'opsi1', 'pilih2', 'pil1'),
(11, 'wawancara', 'opsi2', 'pilih1', 'pil1'),
(12, 'skor', 'opsi3', 'pilih3', 'pil1');

-- --------------------------------------------------------

--
-- Table structure for table `normalisasi_saw`
--

CREATE TABLE `normalisasi_saw` (
  `id` int(11) NOT NULL,
  `peserta_id` int(11) NOT NULL,
  `normalisasi_ipk` float NOT NULL,
  `normalisasi_wawancara` float NOT NULL,
  `normalisasi_skor` float NOT NULL,
  `defuzzifikasi` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `normalisasi_saw`
--

INSERT INTO `normalisasi_saw` (`id`, `peserta_id`, `normalisasi_ipk`, `normalisasi_wawancara`, `normalisasi_skor`, `defuzzifikasi`) VALUES
(577, 12, 1, 1, 1, 67),
(578, 14, 1, 0.75, 0.75, 67),
(579, 15, 1, 0.75, 1, 67),
(580, 16, 1, 1, 1, 67),
(581, 17, 0.75, 1, 0.75, 65.67),
(582, 18, 1, 1, 0.75, 67),
(583, 19, 1, 1, 1, 67),
(584, 21, 1, 0.75, 0.75, 67),
(585, 23, 1, 1, 1, 67),
(586, 24, 1, 1, 1, 67),
(587, 26, 1, 1, 0.75, 67),
(588, 28, 1, 1, 1, 67),
(589, 30, 1, 0.75, 0.75, 67),
(590, 31, 1, 0.75, 1, 67),
(591, 32, 1, 0.75, 1, 67),
(592, 33, 1, 0.75, 0.75, 67),
(593, 35, 1, 1, 1, 67),
(594, 36, 1, 1, 0.75, 67),
(595, 37, 1, 0.75, 1, 67),
(596, 39, 1, 1, 0.75, 67),
(597, 42, 1, 1, 0.75, 67),
(598, 44, 1, 1, 0.75, 67);

-- --------------------------------------------------------

--
-- Table structure for table `perengkingan_saw`
--

CREATE TABLE `perengkingan_saw` (
  `id` int(11) NOT NULL,
  `peserta_id` int(11) NOT NULL,
  `nama_peserta` varchar(255) NOT NULL,
  `skor_total` float NOT NULL,
  `ranking` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `perengkingan_saw`
--

INSERT INTO `perengkingan_saw` (`id`, `peserta_id`, `nama_peserta`, `skor_total`, `ranking`) VALUES
(1, 12, 'Vergiawan', 1, 1),
(2, 16, 'Windra', 1, 2),
(3, 19, 'Rifqi', 1, 3),
(4, 23, 'Maharani', 1, 4),
(5, 24, 'Rida', 1, 5),
(6, 28, 'Rofifah', 1, 6),
(7, 35, 'Rahmat ', 1, 7),
(8, 18, 'Chintya', 0.9375, 8),
(9, 26, 'Jihan', 0.9375, 9),
(10, 36, 'Novi ', 0.9375, 10),
(11, 39, 'SUFIRA', 0.9375, 11),
(12, 42, 'Aurellia', 0.9375, 12),
(13, 44, 'Jumarinda', 0.9375, 13),
(14, 15, 'Salsa', 0.9, 14),
(15, 31, 'Nadia ', 0.9, 15),
(16, 32, 'Fajrani', 0.9, 16),
(17, 37, 'Rio H', 0.9, 17),
(18, 17, 'Afrizal', 0.85, 18),
(19, 14, 'Regina', 0.8375, 19),
(20, 21, 'Arilla', 0.8375, 20),
(21, 30, 'Miranda ', 0.8375, 21),
(22, 33, 'Nurul ', 0.8375, 22);

-- --------------------------------------------------------

--
-- Table structure for table `peserta`
--

CREATE TABLE `peserta` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jurusan` varchar(50) DEFAULT NULL,
  `universitas` varchar(50) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peserta`
--

INSERT INTO `peserta` (`id`, `nama`, `jurusan`, `universitas`, `no_hp`) VALUES
(5, 'zikri', 'teknik informatika', 'universitas putra indonesia yptk padang', '085763064361'),
(6, 'edi', 'teknik informatika', 'UI', '085763064390');

-- --------------------------------------------------------

--
-- Table structure for table `peserta_kriteria`
--

CREATE TABLE `peserta_kriteria` (
  `id` int(11) NOT NULL,
  `nama_peserta` varchar(100) NOT NULL,
  `ipk` decimal(3,2) DEFAULT NULL,
  `wawancara` int(11) DEFAULT NULL,
  `skor` int(11) DEFAULT NULL,
  `jurusan` varchar(50) DEFAULT NULL,
  `universitas` varchar(50) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peserta_kriteria`
--

INSERT INTO `peserta_kriteria` (`id`, `nama_peserta`, `ipk`, `wawancara`, `skor`, `jurusan`, `universitas`, `no_hp`) VALUES
(3, 'Ahmad', 3.27, 100, 100, 'Akuntansi', 'UNIVERSITAS ANDALAS', '085763064372'),
(12, 'Vergiawan', 3.80, 90, 100, 'Desain Komunikasi Visual', 'UNIVERSITAS NEGERI PADANG', '085763064372'),
(13, 'Ratna', 3.94, 60, 100, 'D-4 Sanitasi Lingkungan', 'Politeknik Kesehatan Kementerian Kesehatan Padang', '085763064361'),
(14, 'Regina', 3.89, 80, 70, 'Kesehatan Masyarakat', 'UNIVERSITAS ANDALAS', '085763064372'),
(15, 'Salsa', 3.50, 70, 100, 'Kimia', 'UNIVERSITAS ANDALAS', '085763064361'),
(16, 'Windra', 3.50, 100, 100, 'Manajemen', 'UNIVERSITAS NEGERI PADANG', '085763064372'),
(17, 'Afrizal', 3.47, 90, 70, 'Marketing', 'UNIVERSITAS BUNG HATTA', '085763064361'),
(18, 'Chintya', 3.89, 100, 70, 'Sistem Informasi', 'Universitas Putra Indonesia YPTK Padang', '085763064390'),
(19, 'Rifqi', 3.68, 90, 100, 'Teknik Elektro', 'UNIVERSITAS ANDALAS', '085763064372'),
(20, 'Dyana', 3.59, 100, 60, 'Teknik Geologi', 'INSTITUT TEKNOLOGI BANDUNG', '085763064361'),
(21, 'Arilla', 3.88, 70, 70, 'Teknik Industri', 'Universitas Putra Indonesia YPTK Padang', '085763064361'),
(22, 'Afifah', 3.97, 50, 100, 'Teknik Informatika', 'Kun Shan University', '085763064390'),
(23, 'Maharani', 3.88, 90, 100, 'Teknik Kimia', 'UNIVERSITAS SRIWIJAYA', '085763064372'),
(24, 'Rida', 3.57, 90, 100, 'Teknik Lingkungan', 'UNIVERSITAS ANDALAS', '085763064372'),
(25, 'Zhafran', 3.71, 50, 60, 'Teknik Mesin', 'INSTITUT TEKNOLOGI PADANG', '085763064361'),
(26, 'Jihan', 3.62, 100, 70, 'Teknik Pertambangan', 'UNIVERSITAS JAMBI', '085763064372'),
(27, 'Wahyudi', 3.66, 50, 60, 'Teknik Pertambangan', 'UNIVERSITAS NEGERI PADANG', '085763064361'),
(28, 'Rofifah', 3.78, 90, 100, 'Teknik Sipil', 'INSTITUT TEKNOLOGI PADANG', '085763064390'),
(29, 'Aisyah', 3.78, 65, 55, 'Akuntansi', 'UNIVERSITAS ANDALAS', '085763064372'),
(30, 'Miranda ', 3.70, 75, 80, 'Desain Komunikasi Visual', 'UNIVERSITAS NEGERI PADANG', '085763064390'),
(31, 'Nadia ', 3.92, 75, 95, 'D-4 Sanitasi Lingkungan', 'Politeknik Kesehatan Kementerian Kesehatan Padang', '085763064390'),
(32, 'Fajrani', 3.86, 80, 95, 'Kesehatan Masyarakat', 'UNIVERSITAS ANDALAS', '085763064361'),
(33, 'Nurul ', 3.74, 70, 70, 'Kimia', 'UNIVERSITAS ANDALAS', '085763064372'),
(34, 'Riva ', 3.54, 65, 70, 'Manajemen', 'UNIVERSITAS ANDALAS', '085763064390'),
(35, 'Rahmat ', 3.53, 90, 90, 'Marketing', 'UNIVERSITAS NEGERI PADANG', '085763064390'),
(36, 'Novi ', 3.79, 100, 80, 'Sistem Informasi', 'Universitas Metamedia', '085763064361'),
(37, 'Rio H', 3.53, 70, 90, 'Teknik Elektro', 'UNIVERSITAS ANDALAS', '085763064361'),
(38, 'Rais ', 3.53, 70, 65, 'Teknik Geologi', 'UNIVERSITAS SYIAH KUALA', '085763064372'),
(39, 'SUFIRA', 3.78, 100, 80, 'Teknik Industri', 'UNIVERSITAS ISLAM NEGERI SULTAN SYARIF KASIM RIAU', '085763064390'),
(40, 'Firdaus', 3.37, 80, 80, 'Teknik Informatika', 'INSTITUT TEKNOLOGI SEPULUH NOPEMBER', '085763064361'),
(41, 'Rida', 3.42, 95, 85, 'Teknik Kimia', 'UNIVERSITAS SYIAH KUALA', '085763064372'),
(42, 'Aurellia', 3.80, 100, 70, 'Teknik Lingkungan', 'UNIVERSITAS ANDALAS', '085763064361'),
(43, 'Syafrudin ', 3.41, 65, 90, 'Teknik Mesin', 'UNIVERSITAS ANDALAS', '085763064390'),
(44, 'Jumarinda', 3.58, 100, 80, 'Teknik Pertambangan', 'UNIVERSITAS NEGERI PADANG', '085763064372'),
(45, 'Andi ', 3.12, 50, 90, 'Teknik Pertambangan', 'UNIVERSITAS SRIWIJAYA', '085763064352'),
(46, 'Arvi ', 3.62, 60, 55, 'Teknik Sipil', 'UNIVERSITAS ANDALAS', '085763064390');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Kepala') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(6, 'edi', 'jatimhecker@gmail.com', '0192023a7bbd73250516f069df18b500', 'Admin'),
(20, 'kepala', 'zikrihabibullaah601@gmail.com', '836b1f7f9b7f9bf98f1f645302defc59', 'Kepala'),
(22, 'zikri habibullah', 'ganti@gmail.com', 'af66c56c5f90d5a10a77f5a56d43a812', 'Admin'),
(23, 'yoga', 'prayoga@gmail.com', '45a73564aacc33cff0bf8bf9e72370f5', 'Kepala');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hasil_defuzzifikasi`
--
ALTER TABLE `hasil_defuzzifikasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peserta_id` (`peserta_id`);

--
-- Indexes for table `konversi_peserta`
--
ALTER TABLE `konversi_peserta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `peserta_id` (`peserta_id`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `normalisasi_saw`
--
ALTER TABLE `normalisasi_saw`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peserta_id` (`peserta_id`);

--
-- Indexes for table `perengkingan_saw`
--
ALTER TABLE `perengkingan_saw`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peserta_id` (`peserta_id`);

--
-- Indexes for table `peserta`
--
ALTER TABLE `peserta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peserta_kriteria`
--
ALTER TABLE `peserta_kriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hasil_defuzzifikasi`
--
ALTER TABLE `hasil_defuzzifikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `konversi_peserta`
--
ALTER TABLE `konversi_peserta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1079;

--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `normalisasi_saw`
--
ALTER TABLE `normalisasi_saw`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=599;

--
-- AUTO_INCREMENT for table `perengkingan_saw`
--
ALTER TABLE `perengkingan_saw`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `peserta`
--
ALTER TABLE `peserta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `peserta_kriteria`
--
ALTER TABLE `peserta_kriteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hasil_defuzzifikasi`
--
ALTER TABLE `hasil_defuzzifikasi`
  ADD CONSTRAINT `hasil_defuzzifikasi_ibfk_1` FOREIGN KEY (`peserta_id`) REFERENCES `peserta_kriteria` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `konversi_peserta`
--
ALTER TABLE `konversi_peserta`
  ADD CONSTRAINT `konversi_peserta_ibfk_1` FOREIGN KEY (`peserta_id`) REFERENCES `peserta_kriteria` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `normalisasi_saw`
--
ALTER TABLE `normalisasi_saw`
  ADD CONSTRAINT `normalisasi_saw_ibfk_1` FOREIGN KEY (`peserta_id`) REFERENCES `konversi_peserta` (`peserta_id`);

--
-- Constraints for table `perengkingan_saw`
--
ALTER TABLE `perengkingan_saw`
  ADD CONSTRAINT `perengkingan_saw_ibfk_1` FOREIGN KEY (`peserta_id`) REFERENCES `peserta_kriteria` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
