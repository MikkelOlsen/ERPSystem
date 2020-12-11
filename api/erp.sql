-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2020 at 12:23 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `erp`
--

-- --------------------------------------------------------

--
-- Table structure for table `estimations`
--

CREATE TABLE `estimations` (
  `id` int(11) NOT NULL,
  `item` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `estimations`
--

INSERT INTO `estimations` (`id`, `item`, `price`) VALUES
(1, 'VVS', 50),
(2, 'ELECTRICITY', 60);

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `invoiceID` int(11) DEFAULT NULL,
  `company` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `billedTo` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `invoiceID`, `company`, `date`, `billedTo`, `approved`) VALUES
(16, 1045, 'Virksomhed X', '2020-12-02', 'Mikkel Olsen', 0),
(17, 1099, 'Test Company', '2020-12-04', 'Mark Cederborg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `id` int(11) NOT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hours` int(11) DEFAULT NULL,
  `rate` int(11) DEFAULT NULL,
  `invoiceId` int(11) DEFAULT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`id`, `name`, `hours`, `rate`, `invoiceId`, `approved`) VALUES
(1, 'VVS', 5, 300, 16, 1),
(2, 'ELECTRICITY', 10, 200, 16, 1),
(3, 'COFFEE BEANS', 10, 150, 17, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `estimations`
--
ALTER TABLE `estimations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `invoiceFK_idx` (`invoiceId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `estimations`
--
ALTER TABLE `estimations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `invoiceFK` FOREIGN KEY (`invoiceId`) REFERENCES `invoice` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
