-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2019 at 01:11 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `malasngoding`
--

-- --------------------------------------------------------

--
-- Table structure for table `upload`
--

CREATE TABLE `upload` (
  `id_file` int(11) NOT NULL,
  `isi_file` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `upload`
--

INSERT INTO `upload` (`id_file`, `isi_file`) VALUES
(53, 'Tokoh politik dari berbagai partai mengadakan rapat untuk membahas koalisi baru\r\n menjelang pemilu 2014 dan beberapa pilkada 2012 dan 2013.'),
(54, 'Partai politik sudah tidak dapat dipercaya. Sebagian besar partai mengutamakan \r\n kepentingan partai daripada kebutuhan rakyat'),
(55, 'Partai demokrat memenangkan pemilu 2009 karena figur SBY. Partai Golkar\r\n berusaha menang pada 2012. Pertandingan 2 partai ini akan seru.'),
(56, 'Pertandingan pertama antara Persema dan Persebaya diadakan di Malang. Ini akan\r\n menguntungkan tuan rumah'),
(57, 'Beberapa pertandingan sepakbola yang dilakoni persebaya pada masa kampanye\r\n Pilkada 2010 Kota surabaya akan ditunda.'),
(58, 'Sepakbola Indonesia memang belum bangkit. Manajemen tim, pertandingan dan\r\n tiket perlu ditingkatkan, bukan hanya fokus pada kemenangan tim.'),
(59, 'Beberapa pertandingan sepakbola yang dilakoni persebaya pada masa kampanye\r\n Pilkada 2010 Kota surabaya akan ditunda.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `upload`
--
ALTER TABLE `upload`
  ADD PRIMARY KEY (`id_file`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `upload`
--
ALTER TABLE `upload`
  MODIFY `id_file` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
