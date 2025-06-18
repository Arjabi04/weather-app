-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 01, 2024 at 03:41 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Weather_App`
--

-- --------------------------------------------------------

--
-- Table structure for table `past_data`
--

CREATE TABLE `past_data` (
  `city_id` int(11) NOT NULL,
  `city` varchar(50) DEFAULT NULL,
  `day_and_date` varchar(50) DEFAULT NULL,
  `weather_condition` varchar(50) DEFAULT NULL,
  `weather_icon` varchar(50) DEFAULT NULL,
  `temp` int(11) DEFAULT NULL,
  `pressure` int(11) DEFAULT NULL,
  `wind_speed` decimal(5,1) DEFAULT NULL,
  `humidity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `past_data`
--

INSERT INTO `past_data` (`city_id`, `city`, `day_and_date`, `weather_condition`, `weather_icon`, `temp`, `pressure`, `wind_speed`, `humidity`) VALUES
(1, 'Aligarh', '1705860350', 'Clear ', '01d', 10, 1017, 5.1, 55),
(2, 'Aligarh', '1705909402', 'Clear', '01d', 18, 1014, 1.4, 57),
(3, 'Aligarh', '1705995802', 'Few clouds', '02d', 10, 1017, 9.2, 63),
(4, 'Aligarh', '1706082202', 'Clear ', '01d', 21, 1017, 10.2, 35),
(5, 'Aligarh', '1706168602', 'Scattered clouds', '03d', 15, 1020, 5.5, 60),
(6, 'Aligarh', '1706255002', 'Rain', '10d', 6, 1016, 10.5, 50),
(7, 'Aligarh', '1706395018', 'Few clouds', '02d', 16, 1013, 5.1, 61),
(8, 'Aligarh', '1706481418', 'Clouds', '04d', 20, 1015, 7.1, 80),
(9, 'Aligarh', '1706654218', 'Rain', '10d', 14, 1017, 6.1, 40),
(10, 'London', '1706654218', 'Few Clouds', '02d', 10, 1030, 2.5, 60),
(11, 'London', '1706768692', 'Clouds', '04n', 5, 1031, 2.6, 83),
(12, 'London', '1706768692', 'Clouds', '04n', 5, 1031, 2.6, 83),
(13, 'New York', '1706798047', 'Clouds', '04d', 3, 1018, 4.1, 79),
(14, 'Kathmandu', '1706798115', 'Mist', '50n', 10, 1021, 1.5, 81);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `past_data`
--
ALTER TABLE `past_data`
  ADD PRIMARY KEY (`city_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `past_data`
--
ALTER TABLE `past_data`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
