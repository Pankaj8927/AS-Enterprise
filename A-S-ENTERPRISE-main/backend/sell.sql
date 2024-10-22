-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2024 at 05:31 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asenterprise`
--

-- --------------------------------------------------------

--
-- Table structure for table `sell`
--

CREATE TABLE `sell` (
  `id` int(11) NOT NULL,
  `barcodeNumber` varchar(255) NOT NULL,
  `goodsName` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `goodsAmount` varchar(255) NOT NULL,
  `goodsQuantity` varchar(255) NOT NULL,
  `discount` varchar(255) NOT NULL,
  `buyerName` varchar(255) NOT NULL,
  `buyerAdd` varchar(255) NOT NULL,
  `contactNumber` varchar(255) NOT NULL,
  `stateNameCode` varchar(255) NOT NULL,
  `invoiceMakerName` varchar(255) NOT NULL,
  `dateTime` varchar(255) NOT NULL,
  `invoiceFiles` varchar(255) NOT NULL,
  `invoiceNumber` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sell`
--

INSERT INTO `sell` (`id`, `barcodeNumber`, `goodsName`, `description`, `brand`, `goodsAmount`, `goodsQuantity`, `discount`, `buyerName`, `buyerAdd`, `contactNumber`, `stateNameCode`, `invoiceMakerName`, `dateTime`, `invoiceFiles`, `invoiceNumber`) VALUES
(31, '123', 'Battery', '', '', '40000', '2', '20', 'Mamun SK', 'DALKOLA SBHASPALLY, PIN 733201', '07319589678', 'West Bengal - 19', 'Arif SK', '20240719-044850', '', 0),
(32, '234', 'Battery Motor cycle', '', '', '150000', '1', '20', 'Mamun SK', 'DALKOLA SBHASPALLY, PIN 733201', '07319589678', 'West Bengal - 19', 'Arif SK', '20240719-044850', '', 0),
(33, '345', 'Tyre of Bike', '', '', '10000', '1', '20', 'Mamun SK', 'DALKOLA SBHASPALLY, PIN 733201', '07319589678', 'West Bengal - 19', 'Arif SK', '20240719-044850', '', 0),
(34, '678', 'Tire', '', '', '300000', '2', '20', 'Mamun SK', 'DALKOLA SBHASPALLY, PIN 733201', '07319589678', 'West Bengal - 19', 'Arif SK', '20240719-044850', '', 0),
(35, '890', 'Helmet', '', '', '75000', '1', '20', 'Mamun SK', 'DALKOLA SBHASPALLY, PIN 733201', '07319589678', 'West Bengal - 19', 'Arif SK', '20240719-044850', '', 0),
(36, '900', 'Battery', '', '', '25981.12', '2', '20', 'Mamun SK', 'DALKOLA SBHASPALLY, PIN 733201', '07319589678', 'West Bengal - 19', 'Arif SK', '20240719-044850', 'invoice_20240719-044850.pdf', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sell`
--
ALTER TABLE `sell`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `barcodeNumber` (`barcodeNumber`),
  ADD UNIQUE KEY `barcodeNumber_3` (`barcodeNumber`),
  ADD UNIQUE KEY `barcodeNumber_4` (`barcodeNumber`);
ALTER TABLE `sell` ADD FULLTEXT KEY `barcodeNumber_2` (`barcodeNumber`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sell`
--
ALTER TABLE `sell`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
