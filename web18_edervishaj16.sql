-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 31, 2019 at 02:36 AM
-- Server version: 5.5.62-0ubuntu0.14.04.1
-- PHP Version: 7.2.14-1+ubuntu14.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web18_edervishaj16`
--

-- --------------------------------------------------------

--
-- Table structure for table `completed_orders`
--

CREATE TABLE `completed_orders` (
  `ID` int(11) NOT NULL,
  `_order_` varchar(300) NOT NULL,
  `price` int(6) NOT NULL,
  `client` varchar(30) NOT NULL,
  `address_1` varchar(40) NOT NULL,
  `address_2` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `completed_orders`
--

INSERT INTO `completed_orders` (`ID`, `_order_`, `price`, `client`, `address_1`, `address_2`) VALUES
(1, '1 Item_3,', 300, 'Ergi Dervishaj', 'Ali Demi', 'Shemsi Haka');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `_order_` varchar(500) NOT NULL,
  `price` int(6) NOT NULL,
  `client` varchar(50) NOT NULL,
  `city` varchar(20) NOT NULL,
  `address_1` varchar(20) NOT NULL,
  `address_2` varchar(20) NOT NULL,
  `telephone` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `_order_`, `price`, `client`, `city`, `address_1`, `address_2`, `telephone`) VALUES
(1, 'prova', 200, 'Alba Brozi', 'Tirane', 'Xhanfize Keko', '', '123456789'),
(13, '1 Item_3,', 300, 'Ergi Dervishaj', 'tirana', 'Ali Demi', 'Shemsi Haka', ''),
(14, '1 Item_4,', 300, 'Ergi Dervishaj', 'tirana', 'Ali Demi', 'Shemsi Haka', ''),
(15, '2 Item_3,', 600, 'Ergi Dervishaj', 'tirana', 'Ali Demi', 'Shemsi Haka', ''),
(16, '1 Item_5,', 300, 'Alba Brozi', 'Tirane', 'Rruga Xhanfize Keko', '', ''),
(17, '2 Item_1,', 600, 'Alba Brozi', 'Tirane', 'Rruga Xhanfize Keko', '', '123456789'),
(18, '1 Item_1,1 Item_3,1 Item_20,', 900, 'Ergi Dervishaj', 'tirana', 'Ali Demi', 'Shemsi Haka', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(5) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(40) NOT NULL,
  `_level_` int(2) NOT NULL,
  `_name_` varchar(30) NOT NULL,
  `surname` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `card_no` varchar(40) NOT NULL,
  `ex_date` date NOT NULL,
  `csc` varchar(40) NOT NULL,
  `city` varchar(30) NOT NULL,
  `address_1` varchar(30) NOT NULL,
  `address_2` varchar(30) NOT NULL,
  `phone_number` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `username`, `password`, `_level_`, `_name_`, `surname`, `email`, `card_no`, `ex_date`, `csc`, `city`, `address_1`, `address_2`, `phone_number`) VALUES
(0, 'admin', '21232f297a57a5a743894a0e4a801fc3', 0, 'admin', 'admin', 'admin@admin.com', '81dc9bdb52d04dc20036dbd8313ed055', '2022-02-01', '202cb962ac59075b964b07152d234b70', 'admin', 'admin', 'admin', '0673560804'),
(1, 'eDervishaj16', '1dcc0594ec8bb9aacccd1076ae9de048', 2, 'Ergi', 'Dervishaj', 'dervishajergi377@yahoo.com', '1234 1234 1234 1234', '2022-12-01', '123', 'tirana', 'Ali Demi', 'Shemsi Haka', '+355673560804'),
(8, 'restaurantOwner', '5e5a3a5816250406547e6ba7d8e17dd6', 1, 'Restaurant', 'Owner', 'restaurant@owner.com', '', '0000-00-00', '', 'Tirana', 'Rr. \"Bardhyl\"', '', '06744557869'),
(10, 'aBrozi16', '16a129564f72e27f4437276631c70650', 2, 'Alba', 'Brozi', 'abrozi16@epoka.edu.al', 'cfe95b64ac715d64275365ede690ee7c', '2019-01-19', '202cb962ac59075b964b07152d234b70', 'Tirane', 'Rruga Xhanfize Keko', '', '123456789');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `completed_orders`
--
ALTER TABLE `completed_orders`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `completed_orders`
--
ALTER TABLE `completed_orders`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
