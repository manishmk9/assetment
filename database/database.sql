-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2020 at 01:56 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `railway_reservation`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `Id` int(11) NOT NULL,
  `book_seat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `coach`
--

CREATE TABLE `coach` (
  `Id` int(11) NOT NULL,
  `coach_type_id` int(11) NOT NULL,
  `coach_type_total_seat` int(11) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `coach`
--

INSERT INTO `coach` (`Id`, `coach_type_id`, `coach_type_total_seat`, `type`) VALUES
(1001, 1, 80, 'sleeper');

-- --------------------------------------------------------

--
-- Table structure for table `coach_type`
--

CREATE TABLE `coach_type` (
  `Id` int(11) NOT NULL,
  `coach_type` varchar(50) NOT NULL,
  `total_seat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `coach_type`
--

INSERT INTO `coach_type` (`Id`, `coach_type`, `total_seat`) VALUES
(1, 'sleeper', 80);

-- --------------------------------------------------------

--
-- Table structure for table `engine`
--

CREATE TABLE `engine` (
  `Id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `power` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `engine`
--

INSERT INTO `engine` (`Id`, `type`, `power`) VALUES
(101, 'Diesel', 1500);

-- --------------------------------------------------------

--
-- Table structure for table `engine_type`
--

CREATE TABLE `engine_type` (
  `Id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `power_cc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `engine_type`
--

INSERT INTO `engine_type` (`Id`, `type`, `power_cc`) VALUES
(1, 'Diesel', 1500);

-- --------------------------------------------------------

--
-- Table structure for table `train`
--

CREATE TABLE `train` (
  `Id` int(11) NOT NULL,
  `coach_id` int(11) NOT NULL,
  `total_seat` int(11) NOT NULL,
  `avail_seat` int(11) NOT NULL
) ;

--
-- Dumping data for table `train`
--

INSERT INTO `train` (`Id`, `coach_id`, `total_seat`, `avail_seat`) VALUES
(12624, 1001, 80, 80);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `coach`
--
ALTER TABLE `coach`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `coach_type_id` (`coach_type_id`),
  ADD KEY `type` (`type`),
  ADD KEY `coach_type_total_seat` (`coach_type_total_seat`);

--
-- Indexes for table `coach_type`
--
ALTER TABLE `coach_type`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `coach_type` (`coach_type`,`total_seat`);

--
-- Indexes for table `engine`
--
ALTER TABLE `engine`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `type` (`type`),
  ADD KEY `power` (`power`);

--
-- Indexes for table `engine_type`
--
ALTER TABLE `engine_type`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `type` (`type`,`power_cc`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `coach`
--
ALTER TABLE `coach`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1002;

--
-- AUTO_INCREMENT for table `coach_type`
--
ALTER TABLE `coach_type`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `engine`
--
ALTER TABLE `engine`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `engine_type`
--
ALTER TABLE `engine_type`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `train`
--
ALTER TABLE `train`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `coach`
--
ALTER TABLE `coach`
  ADD CONSTRAINT `coach_ibfk_1` FOREIGN KEY (`coach_type_id`) REFERENCES `coach_type` (`Id`),
  ADD CONSTRAINT `coach_ibfk_2` FOREIGN KEY (`type`) REFERENCES `coach_type` (`coach_type`),
  ADD CONSTRAINT `coach_ibfk_3` FOREIGN KEY (`coach_type_total_seat`) REFERENCES `coach_type` (`total_seat`);

--
-- Constraints for table `engine`
--
ALTER TABLE `engine`
  ADD CONSTRAINT `engine_ibfk_1` FOREIGN KEY (`type`) REFERENCES `engine_type` (`type`),
  ADD CONSTRAINT `engine_ibfk_2` FOREIGN KEY (`power`) REFERENCES `engine_type` (`power_cc`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
