-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2024 at 08:17 AM
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
-- Database: `hl_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `id` int(11) NOT NULL,
  `id_number` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `id_number`, `name`, `address`, `phone`, `email`) VALUES
(1, '1', '1320400104879', 'นาย ทดสอบ  ระบบ1', '0978784512', 'kkl@gmail.com'),
(2, '2', '1320400104871', 'นาย ทดสอบ  ระบบ2', '0894556124', 'mtb25@gmail.com'),
(3, '3', '1320400104872', 'นาย ทดสอบ  ระบบ3', '0954545454', 'r23@gmail.com'),
(4, '4', '1320400104873', 'นาย ทดสอบ  ระบบ4', '0978784512', 'na@gmail.com'),
(5, '5', '1320400104874', 'นาย ทดสอบ  ระบบ5', '0894556124', 'ma@gmail.com'),
(6, '6', '1320400104875', 'นาย ทดสอบ  ระบบ6', '0954545454', 'na@gmail.com'),
(7, '7', '1320400104876', 'นาย ทดสอบ  ระบบ7', '0978784512', 'ma@gmail.com'),
(8, '8', '1320400104877', 'นาย ทดสอบ  ระบบ8', '0894556124', 'na@gmail.com'),
(9, '9', '1320400104878', 'นาย ทดสอบ  ระบบ9', '0954545454', 'ma@gmail.com'),
(10, '10', '1320400104810', 'นาย ทดสอบ  ระบบ10', '0978784512', 'na@gmail.com'),
(11, '11', '1320400104811', 'นาย ทดสอบ  ระบบ11', '0894556124', 'ma@gmail.com'),
(12, '12', '1320400104812', 'นาย ทดสอบ  ระบบ12', '0954545454', 'na@gmail.com'),
(13, '13', '1320400104813', 'นาย ทดสอบ  ระบบ13', '0978784512', 'ma@gmail.com'),
(14, '14', '1320400104814', 'นาย ทดสอบ  ระบบ14', '0894556124', 'na@gmail.com'),
(15, '15', '1320400104815', 'นาย ทดสอบ  ระบบ15', '0954545454', 'ma@gmail.com'),
(16, '16', '1320400104816', 'นาย ทดสอบ  ระบบ16', '0978784512', 'na@gmail.com'),
(17, '17', '1320400104817', 'นาย ทดสอบ  ระบบ17', '0894556124', 'ma@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `id` int(11) NOT NULL,
  `cid` varchar(13) NOT NULL,
  `checkup_date` date NOT NULL,
  `result` text NOT NULL,
  `doctor` varchar(100) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `cid` varchar(13) NOT NULL,
  `password` varchar(32) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `cid`, `password`, `role`, `phone`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', '0844545454'),
(2, '1234567891011', '81dc9bdb52d04dc20036dbd8313ed055', 'user', '0845781223');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
