-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2025 at 08:03 PM
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
-- Database: `foodbank`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin'),
(2, 'ware', '9c9b056bc0c11c3fb0d74085188e2499ec7e8c18', 'warehouse'),
(3, 'prog', '7abf1cbd0bb673b82b54ad0a008667d99058c734', 'program'),
(4, 'proc', 'fb0aff6ba5e1940db2ce5fd06d988760aa10ffe4', 'procurement');

-- --------------------------------------------------------

--
-- Table structure for table `distributor`
--

CREATE TABLE `distributor` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `distributor`
--

INSERT INTO `distributor` (`id`, `name`, `address`) VALUES
(1, 'Al-Rahma', 'july23 - Abbasiya Square'),
(2, 'Al-Aswaq', 'Al-Gomhouria Street - Assiut'),
(3, 'Emdad', 'Saad Zaghloul Street - Fayoum'),
(4, 'Rawabi', 'Corniche Street - Aswan'),
(5, 'Al-Meera', 'Al-Galaa Street - Tanta');

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `id` int(10) UNSIGNED NOT NULL,
  `donor_id` int(10) UNSIGNED NOT NULL,
  `total_cost` float UNSIGNED NOT NULL,
  `donation_date` date NOT NULL,
  `method` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`id`, `donor_id`, `total_cost`, `donation_date`, `method`) VALUES
(1, 8, 500, '2024-06-28', 'visa'),
(2, 1, 2500, '2024-06-28', 'visa'),
(3, 5, 4000, '2024-06-28', 'fawry'),
(4, 6, 1655, '2024-06-30', 'Visa'),
(5, 3, 1165, '2024-06-30', 'Visa');

-- --------------------------------------------------------

--
-- Table structure for table `donation_details`
--

CREATE TABLE `donation_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `donation_id` int(10) UNSIGNED NOT NULL,
  `item_id` int(10) UNSIGNED NOT NULL,
  `Qty` int(10) UNSIGNED NOT NULL,
  `price` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donation_details`
--

INSERT INTO `donation_details` (`id`, `donation_id`, `item_id`, `Qty`, `price`) VALUES
(1, 1, 1, 1, 500),
(2, 2, 1, 3, 500),
(3, 2, 3, 2, 500),
(4, 3, 1, 3, 500),
(5, 3, 3, 5, 500),
(6, 4, 1, 2, 500),
(7, 4, 3, 1, 500),
(8, 4, 7, 1, 150),
(9, 5, 7, 1, 150),
(10, 5, 1, 2, 500);

-- --------------------------------------------------------

--
-- Table structure for table `donor`
--

CREATE TABLE `donor` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(128) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `phone_number` varchar(128) DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donor`
--

INSERT INTO `donor` (`id`, `username`, `birthdate`, `email`, `password`, `phone_number`, `gender`) VALUES
(1, 'Aya', '1992-08-25', 'aya17@hotmail.com', '35e9a3f0dab724451bd956db409c2c9e96f795c9', '01098765432', 1),
(2, 'Youssef', '1985-12-10', 'youssefH@gmail.com', '85aa942b709a86f6b5d8a572444a09d993fbf266', '01198765432', 0),
(3, 'Nour', '1998-04-03', 'nourBassel22@gmail.com', 'f3e7bf682ec4c9f04bbc29f2c884dea9d2b30cb5', '01298765432', 1),
(4, 'Ahmed', '1990-05-15', 'ahmedelwazeer90@hotmail.com', 'cbfdac6008f9cab4083784cbd1874f76618d2a97', '01012345678', 0),
(5, 'Fatma', '1988-10-20', 'fatmawaked19@gmail.com', '5e927503d30f50bd44c9a31c6625984c442b78ae', '01123456789', 1),
(6, 'Mohamed', '1995-03-08', 'mohamed6677@gmail.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', '01234567890', 0),
(7, 'Alaa', '2003-10-18', 'alaay318@gmail.com', '551dcdc16748c3db1bb1f97136622d048d855186', '01099155389', 1),
(8, 'Omar', '2004-03-21', 'omar@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '01000000003', 0);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id` int(10) UNSIGNED NOT NULL,
  `item_name` varchar(128) DEFAULT NULL,
  `item_cost` float UNSIGNED DEFAULT NULL,
  `amount` mediumint(128) UNSIGNED DEFAULT NULL,
  `program_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `item_name`, `item_cost`, `amount`, `program_id`) VALUES
(1, 'Monthly Carton', 500, 600, 1),
(2, 'Orphan meal', 100, 2000, 2),
(3, 'Gaza family box', 500, 1080, 5),
(4, 'kafara meal', 65, 1000, 4),
(5, 'Sheep', 8500, 200, 3),
(6, 'Calf', 20000, 170, 3),
(7, 'Weekly Carton', 150, 500, 1);

-- --------------------------------------------------------

--
-- Table structure for table `program`
--

CREATE TABLE `program` (
  `id` int(10) UNSIGNED NOT NULL,
  `program_name` varchar(128) DEFAULT NULL,
  `description` varchar(1024) NOT NULL,
  `hash` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program`
--

INSERT INTO `program` (`id`, `program_name`, `description`, `hash`) VALUES
(1, 'Feed', 'Provides dry food to eligible cases and families, they receive the carton on a monthly basis.', 'a80425472d94ae02c836da5b6f205b7b'),
(2, 'Feed an Orphan', 'Enhance the growth of orphan children by providing healthy food to improve their mental and physical abilities.', 'c5365d0c333f3c1be3bf727b49efeb45'),
(3, 'Fido', 'For the newborn, the purchase of a new asset such as a car or something else.', '8c9d6ab4e40ea7fdd314d6f2f9f65341'),
(4, 'Al-Kafara', 'The Egyptian Food Bank accepts the Kafara, and distributes it in the form of a meal', 'ac76f9ba68f5325a93ae1efb2629f515'),
(5, 'Help', 'The Egyptian Food Bank launches an urgent humanitarian relief campaign to help our affected families in the Gaza.', '6a26f548831e6a8c26bfbbd9f6ec61e0');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `name`, `address`) VALUES
(1, 'Hay Day', 'European countryside - Cairo'),
(2, 'Sunshine Acres', 'Helmeyat Al-zaytoon'),
(3, 'AlBaik', 'Juhayna Square - Cairo'),
(4, 'Al-Hassan and Al-Hus', 'Saad Zaghloul - Tanta'),
(5, 'Sheikh Al-Mandi', 'Al-Andalus - 5th settelment');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `admin_id` int(10) UNSIGNED NOT NULL,
  `message` varchar(255) NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`admin_id`) REFERENCES `admin`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `distributor`
--
ALTER TABLE `distributor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `donor_id` (`donor_id`);

--
-- Indexes for table `donation_details`
--
ALTER TABLE `donation_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `donation_id` (`donation_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `donor`
--
ALTER TABLE `donor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `program_id` (`program_id`);

--
-- Indexes for table `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `distributor`
--
ALTER TABLE `distributor`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `donation_details`
--
ALTER TABLE `donation_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `donor`
--
ALTER TABLE `donor`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `program`
--
ALTER TABLE `program`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`donor_id`) REFERENCES `donor` (`id`);

--
-- Constraints for table `donation_details`
--
ALTER TABLE `donation_details`
  ADD CONSTRAINT `donation_details_ibfk_1` FOREIGN KEY (`donation_id`) REFERENCES `donations` (`id`),
  ADD CONSTRAINT `donation_details_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`);

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`program_id`) REFERENCES `program` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
