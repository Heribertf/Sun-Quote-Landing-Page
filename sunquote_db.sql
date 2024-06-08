-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 02, 2024 at 09:23 PM
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
-- Database: `sunquote_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `client_email` varchar(100) NOT NULL,
  `client_phone` varchar(15) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `booking_date` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `client_name`, `client_email`, `client_phone`, `company`, `booking_date`, `status`) VALUES
(1, 'Felix Muimi', 'muimifelix19@gmail.com', NULL, 'TechBloom', '2024-05-10 07:00:00', 0),
(2, 'Felix Muimi', 'muimifelix19@gmail.com', NULL, 'TechBloom', '2024-05-10 07:00:00', 0),
(3, 'Felix Muimi', 'muimifelix19@gmail.com', NULL, 'TechBloom', '2024-04-28 07:00:00', 0),
(4, 'Felix Muimi', 'muimifelix19@gmail.com', NULL, 'TechBloom', '2024-04-28 07:00:00', 0),
(5, 'Dev Felix', 'muimifelix69@gmail.com', NULL, 'TechBloom', '2024-04-29 07:00:00', 0),
(6, 'Felix Muimi', 'muimifelix19@gmail.com', NULL, 'TechBloom', '2024-04-19 07:00:00', 1),
(7, 'Felix Muimi', 'muimifelix19@gmail.com', NULL, 'TechBloom', '2024-04-24 19:00:00', 0),
(8, 'Felix Muimi', 'muimifelix19@gmail.com', NULL, 'TechBloom', '2024-04-24 08:19:00', 0),
(9, 'Felix Muimi', 'muimifelix19@gmail.com', NULL, 'TechBloom', '2024-04-24 08:19:00', 0),
(10, 'Felix Muimi', 'muimifelix19@gmail.com', NULL, 'TechBloom', '2024-04-24 08:19:00', 0),
(11, 'test n', 'heribertfel20@gmail.com', NULL, 'none', '2024-04-27 06:36:00', 0),
(12, 'Felix Muimi', 'muimifelix19@gmail.com', NULL, 'TechBloom', '2024-06-26 09:00:00', 0),
(13, 'Felix Muimi', 'muimifelix69@gmail.com', NULL, 'TechBloom', '2024-06-18 11:00:00', 0),
(14, 'Felix Muimi', 'muimifelix69@gmail.com', NULL, 'TechBloom', '2024-06-22 11:00:00', 0),
(15, 'Felix Muimi', 'muimifelix19@gmail.com', NULL, 'TechBloom', '2024-06-20 05:00:00', 0),
(16, 'Felix Muimi', 'muimifelix19@gmail.com', NULL, 'TechBloom', '2024-06-21 05:00:00', 0),
(17, 'Felix Muimi', 'muimifelix19@gmail.com', NULL, 'TechBloom', '2024-06-03 05:00:00', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
