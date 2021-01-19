-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 19, 2021 at 08:55 AM
-- Server version: 5.7.30
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `BestStore`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `isadmin` tinyint(1) NOT NULL DEFAULT '0',
  `username` varchar(16) NOT NULL,
  `pass` varchar(256) NOT NULL,
  `Aname` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `isadmin`, `username`, `pass`, `Aname`) VALUES
(4, 1, 'Ariel', '$2y$10$wiStA44bwhMDHExRQY1FFOz4wMsZO7ROUy03mEFPEnsNqGCDts6J.', 'Ariel'),
(5, 0, 'mor', '$2y$10$j9HsNYGYY8CeMkuPy56jx.JaTl4MiyXky4FhqHrDTNvv/8089HK7i', 'mor'),
(7, 0, 'lilya', '$2y$10$WvFGKDhwFGxGhfOf30YrpulWjyxrJ4BrcB/JfS6irVhVoXbC1nf9u', 'lilya');

-- --------------------------------------------------------

--
-- Table structure for table `orders_id`
--

CREATE TABLE `orders_id` (
  `id` int(11) NOT NULL,
  `accountid` int(11) NOT NULL,
  `dateoforder` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders_id`
--

INSERT INTO `orders_id` (`id`, `accountid`, `dateoforder`, `address`) VALUES
(12, 7, '2021-01-19 08:40:43', 'Akko');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `productID`, `quantity`, `order_id`) VALUES
(19, 3, 5, 12),
(20, 7, 1, 12);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `detail` text NOT NULL,
  `price` int(11) NOT NULL,
  `img` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `supplierid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `title`, `detail`, `price`, `img`, `quantity`, `supplierid`) VALUES
(3, 'Test', 'Shirthhh', 200, '/uploads/Test/Screen-Shot-2021-01-10-at-13.00.34.png', 0, 4),
(7, 'TEST', 'sfs', 123123, '/uploads/TEST/Screen-Shot-2021-01-04-at-11.23.27.png', 2, 2),
(8, 'Lilya item', 'iPhone 11', 1000, '/uploads/Lilya item/iPhone-11.jpg', 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `Suppliers`
--

CREATE TABLE `Suppliers` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `company` text NOT NULL,
  `phone` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Suppliers`
--

INSERT INTO `Suppliers` (`id`, `name`, `company`, `phone`) VALUES
(2, 'Moshe', 'Moshe', '0500000002'),
(4, 'Mor Ben Shushan', 'Test Company', '05475623'),
(5, 'Lilya', 'Braude', '0500000000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `orders_id`
--
ALTER TABLE `orders_id`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_id_ibfk_1` (`accountid`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productID` (`productID`),
  ADD KEY `orders_ibfk_1` (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `product_ibfk_1` (`supplierid`);

--
-- Indexes for table `Suppliers`
--
ALTER TABLE `Suppliers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders_id`
--
ALTER TABLE `orders_id`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `Suppliers`
--
ALTER TABLE `Suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders_id`
--
ALTER TABLE `orders_id`
  ADD CONSTRAINT `orders_id_ibfk_1` FOREIGN KEY (`accountid`) REFERENCES `accounts` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders_id` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `product` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`supplierid`) REFERENCES `Suppliers` (`id`);
