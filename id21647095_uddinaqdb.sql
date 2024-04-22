-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 09, 2023 at 05:12 PM
-- Server version: 10.5.20-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id21647095_uddinaqdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `available_seats`
--

CREATE TABLE `available_seats` (
  `id` int(11) NOT NULL,
  `time_slot` varchar(255) DEFAULT NULL,
  `available_seats` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `available_seats`
--

INSERT INTO `available_seats` (`id`, `time_slot`, `available_seats`) VALUES
(1, '4/19/2070, 6:00 PM – 7:00 PM', 5),
(2, '4/19/2070, 7:00 PM – 8:00 PM', 6),
(3, '4/19/2070, 8:00 PM – 9:00 PM', 6),
(4, '5/19/2070, 6:00 PM – 7:00 PM', 6),
(5, '5/19/2070, 7:00 PM – 8:00 PM', 6),
(6, '5/19/2070, 8:00 PM – 9:00 PM', 6);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `UMID` int(11) NOT NULL,
  `FirstName` varchar(255) DEFAULT NULL,
  `LastName` varchar(255) DEFAULT NULL,
  `ProjectTitle` varchar(255) DEFAULT NULL,
  `EmailAddress` varchar(255) DEFAULT NULL,
  `PhoneNumber` varchar(15) DEFAULT NULL,
  `TimeSlot` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`UMID`, `FirstName`, `LastName`, `ProjectTitle`, `EmailAddress`, `PhoneNumber`, `TimeSlot`) VALUES
(34324324, 'Uddin', 'AQ', 'AI Model Robot', 'Uddin@gmai.com', '999-999-9999', '4/19/2070, 6:00 PM – 7:00 PM');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `available_seats`
--
ALTER TABLE `available_seats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `time_slot` (`time_slot`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`UMID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `available_seats`
--
ALTER TABLE `available_seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
