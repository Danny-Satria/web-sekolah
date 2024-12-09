-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 09, 2024 at 11:00 PM
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
-- Database: `db_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id_post` int NOT NULL,
  `tgl_post` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `judul` varchar(255) NOT NULL,
  `artikel` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `penulis` varchar(100) NOT NULL,
  `views` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id_post`, `tgl_post`, `judul`, `artikel`, `gambar`, `penulis`, `views`) VALUES
(15, '2024-12-09 18:32:27', 'Rehan Wangsaf Nyatakan Mengundurkan Diri Dari Dunia Perjomokan', 'jdsaodj osdjaosdjasodjas odjaos djasodjasdjasdoasdoasd asdasdasidasidhasoidhaisdhaiso haisdhaishdasdhas hasi dhasdhaisdhasidh ashdaisdhasihd iashdaishdaisdhashdaish iashdaishdasihdasihdasi hsaidhsadhasdhashd iashdaishdsaihdashdasi hasidhasdhashdash dasidhsadhasdhas dhasidhasdhasohd ashdaishdsahdasi hasdhasdhasdhasi dhas dhasdhasdhasidhasihdsa', '../assets/upload/furina ajg.png', 'Esteh', 39),
(16, '2024-12-09 18:35:31', 'Rekomendasi 10 Makanan Khas Ngawi', 'aasguag uasdg ausdgasudgaus gdsaudgasudgasudgausdg uasgdasgdasugdausgdausdg asudgasudgasdgasu dgasudgasdgasdasyudgasydgasy dgasydgasyudgasydgays gdasyudgaysdgasdgasydgayusdg asydgasydgasydgasydgaysdg aysgdaysdgasydgasy dgasydgasdgasdygasydg asdgasdgasydg asdgasdgasydgasydgashdgasydgas dgasydg asdgasdgasydg asyudgasydashdasdg aysd asdyuasgyudasydg asydsayd gasydasyd gasydgasydasy dgsa', '../assets/upload/WhatsApp Image 2024-03-01 at 20.03.03_e1771e79.jpg', 'Somay', 27);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id_profile` int NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `role` varchar(255) NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `foto_profile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `kontak` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tgl_dibuat` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id_profile`, `nama`, `role`, `deskripsi`, `foto_profile`, `kontak`, `tgl_dibuat`) VALUES
(61, 'Zidane', 'Frontend Dev', 'halo sajsaosjaosjaosj aojs aosjaojs aojsao jsao sjao ao jaos jaos jao jsaosjaos jaos jaos jao jao jasjao sjao jsao a osa sa sa salam kenal', '6756d47955fca_arisu hand punch.jpeg', 'dfasdasdasdadasdsaddadasd', '2024-12-09 11:28:57');

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_admin` int NOT NULL,
  `nama_admin` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `nama_admin`, `password`) VALUES
(2, 'admin', '81dc9bdb52d04dc20036dbd8313ed055'),
(3, 'zidane', '81dc9bdb52d04dc20036dbd8313ed055');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id_post`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id_profile`);

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id_post` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id_profile` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
