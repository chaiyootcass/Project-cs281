-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2018 at 02:18 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cd`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(2) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `last_log` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`, `last_log`) VALUES
(1, 'gas', 'e10adc3949ba59abbe56e057f20f883e', '2018-04-19 20:04:32');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(10) NOT NULL,
  `mem_id` int(10) NOT NULL,
  `cart` text NOT NULL,
  `total` varchar(7) NOT NULL,
  `quantity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `mem_id`, `cart`, `total`, `quantity`) VALUES
(1, 13, '42', '32', 1),
(6, 11, '41,41,44,45,44', '173.98', 5);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(10) NOT NULL,
  `msg_name` varchar(100) NOT NULL,
  `msg_email` varchar(80) NOT NULL,
  `msg_subject` varchar(50) NOT NULL,
  `msg` mediumtext NOT NULL,
  `msg_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `CNIC_number` varchar(15) NOT NULL,
  `verify_code` int(15) NOT NULL,
  `products` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `paid_amount` int(11) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `email`, `phone_number`, `CNIC_number`, `verify_code`, `products`, `user_id`, `paid_amount`, `status`) VALUES
(13, 'abc@adwdc.com', '03999999', '12345612313232', 1234, '41,41,42,42,44,44', 11, 7360, '0'),
(14, 'wqeqwe@weqwe.com', '131303213', '12312313213', 1234, '42,41', 11, 71, '0'),
(15, 'gggg@gggg.g', '0919191991', '44544', 4848, '42,42', 11, 64, '0'),
(16, 'gggg@gggg.g', '0919191991', '44544', 4848, '42,42,45', 11, 88, '0'),
(17, 'gggg@gggg.g', '0919191991', '44544', 4848, '42', 11, 32, '0'),
(18, 'gggg@gggg.g', '0919191991', '44544', 4848, '42', 11, 32, '0'),
(19, 'gggg@gggg.g', '0919191991', '44544', 4848, '42', 11, 32, '0'),
(20, 'gggg@gggg.g', '0919191991', '44544', 4848, '42', 11, 32, '0'),
(21, 'gggg@gggg.g', '0919191991', '44544', 4848, '41', 11, 39, '0'),
(22, 'gggg@gggg.g', '0919191991', '44544', 4848, '41', 11, 39, '0'),
(23, 'gggg@gggg.g', '0919191991', '44544', 4848, '41,41,41,41', 11, 156, '0'),
(24, 'gggg@gggg.g', '0919191991', '44544', 4848, '41,42', 11, 71, '0'),
(25, 'gggg@gggg.g', '0919191991', '44544', 4848, '42,42,42,42,42,44,45,43,43,43,44,44,41', 11, 451, '0');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(7) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` varchar(5) NOT NULL,
  `quantity` int(7) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `date_added` datetime NOT NULL,
  `category` varchar(20) NOT NULL,
  `sales` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `price`, `quantity`, `status`, `date_added`, `category`, `sales`) VALUES
(41, 'Blue Shirt', 'Color: Blue \r\nSize: L\r\n\r\n-100% Cotton\r\n\r\n-Imported\r\n\r\n-Machine wash\r\n\r\n-This classic, versatile shirt provides a clean, buttoned-up \r\nlook with a special wash for a soft feel and maximum comfort\r\n\r\n-Model is 6\'1\" and wearing a size Medium\r\n\r\n-Slim fit: closer-fitting in the chest, slightly tapered \r\nthrough the waist for a tailored look\r\n\r\n-Our Slim Fit is comparable to slim-fit shirts from J.Crew \r\nand Banana Republic; if you like the fit of Van Heusen \r\nbrand shirts, size up\r\n', '39', 91, '1', '2018-04-19 20:16:51', 'shirts', 8),
(42, 'Men\'s Blackbird', 'Color: Black \r\nSize: L\r\n\r\n-100% Cotton\r\n\r\n-Imported\r\n\r\n-Pull On closure\r\n\r\n-Machine Wash\r\n\r\n-Contrast trefoil logo graphic on front\r\n\r\n-Regular fit\r\n\r\n-Crewneck', '32', 70, '1', '2018-04-19 20:18:09', 'shirts', 9),
(43, 'Dress Chino Pant', 'Color: Olive\r\nSize: 30W x 29L\r\n\r\n-98% Cotton, 2% Spandex\r\n\r\n-Imported\r\n\r\n-Machine Wash\r\n\r\n-A classic dress chino in a modern straight fit, \r\nthis non-iron Goodthreads trouser is as easy to \r\ncare for as it is stylish to wear\r\n\r\n-Wrinkle-free, easy-care flat front dress chino \r\nin cotton stretch twill with besom button-through back pockets\r\n\r\n-Sits at waist; zip fly with button closure\r\n\r\n-Model is 6\'1\" and wearing a size 32 x 32\r\n\r\n-If you like J.Crew or Banana Republic pants, \r\ncheck out Goodthreads’ selection of effortlessly stylish pants', '40', 108, '1', '2018-04-19 20:19:42', 'pants', 3),
(44, 'Polo Shirt', 'Color: White\r\nSize: L\r\n\r\n-100% Cotton\r\n-Embroidered Pony Logo\r\n-Slim Fit\r\n-Ribbed Foldover Collar\r\n-Two-button placket\r\n-Pique Cotton', '35.99', 75, '1', '2018-04-20 12:34:10', 'shirts', 6),
(45, 'Assist Short', 'Color: Black\r\nSize: M\r\n-100% Polyester\r\n-Durable, soft hand mesh short provides superior ventilation.\r\n-Perfect for all team activities.\r\n-Color blocked side panels.\r\n-Open hand pockets.\r\n-10\" inseam.', '24', 67, '1', '2018-04-20 12:40:19', 'pants', 3);

-- --------------------------------------------------------

--
-- Table structure for table `promocode`
--

CREATE TABLE `promocode` (
  `code` char(5) NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `promocode`
--

INSERT INTO `promocode` (`code`, `used`) VALUES
('ASDSA', 0),
('ASDSA', 0),
('ASKKK', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `product_id` int(10) NOT NULL,
  `review` text NOT NULL,
  `review_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(9) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `country` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(32) NOT NULL,
  `address` text NOT NULL,
  `ip` varchar(15) NOT NULL,
  `last_log` datetime NOT NULL,
  `signup` date NOT NULL,
  `activated` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `country`, `city`, `state`, `phone`, `email`, `password`, `address`, `ip`, `last_log`, `signup`, `activated`) VALUES
(11, 'peerapong chirdchaweewan', 'Thailand', 'Kanchanaburi', '', '0916081055', 'gggg@gggg.g', 'e10adc3949ba59abbe56e057f20f883e', 'wdawddiweqwe', '::1', '0000-00-00 00:00:00', '2018-04-18', '0'),
(12, 'Gas Peerapong', 'Thailand', 'Kanchanaburi', '', '0123456789', 'admin@admin.com', 'e10adc3949ba59abbe56e057f20f883e', 'wqdqwdqwdqwdqwqwfqwf', '::1', '0000-00-00 00:00:00', '2018-04-18', '0'),
(13, 'humnight', 'Thailand', 'bangkok', 'tiw', '0919191991', 'hum_night69@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'SomeoneonMARs', '::1', '0000-00-00 00:00:00', '2018-05-10', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mem_id` (`mem_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_name` (`user_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`mem_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
