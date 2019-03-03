-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2019 at 10:13 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `furniture`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_quantity` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `category_status`) VALUES
(1, 'Tables', 1),
(2, 'Chairs', 1),
(3, 'Sofas', 1),
(4, 'Beds', 1),
(5, 'Plants', 1),
(6, 'Outdoor', 1),
(7, 'Office', 1),
(8, 'Kids', 1),
(9, 'Pets', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `customer_id` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `product_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `brand_soundex` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_soundex` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `brand`, `brand_soundex`, `name`, `name_soundex`, `description`, `price`, `quantity`, `product_status`) VALUES
(1, 1, 'ikea', 'I200', 'luxury sofa', 'L260 S100', 'luxury sofa', 82000, 46, 1),
(2, 1, 'ikea', 'I200', 'flower pot', 'F460 P300', 'flower pot', 8200, 46, 1),
(3, 2, 'ikea', 'I200', 'luxury sofa', 'L260 S100', 'luxury sofa', 82000, 46, 1),
(4, 2, 'ikea', 'I200', 'flower pot', 'F460 P300', 'flower pot', 8200, 46, 1),
(5, 3, 'ikea', 'I200', 'luxury sofa', 'L260 S100', 'luxury sofa', 82000, 46, 1),
(6, 3, 'ikea', 'I200', 'flower pot', 'F460 P300', 'flower pot', 8200, 46, 1),
(7, 4, 'ikea', 'I200', 'luxury sofa', 'L260 S100', 'luxury sofa', 82000, 46, 1),
(8, 4, 'ikea', 'I200', 'flower pot', 'F460 P300', 'flower pot', 8200, 46, 1),
(9, 5, 'ikea', 'I200', 'flower pot', 'F460 P300', 'flower pot', 8200, 46, 1),
(10, 5, 'ikea', 'I200', 'luxury sofa', 'L260 S100', 'luxury sofa', 82000, 46, 1),
(11, 6, 'ikea', 'I200', 'flower pot', 'F460 P300', 'flower pot', 8200, 46, 1),
(12, 6, 'ikea', 'I200', 'luxury sofa', 'L260 S100', 'luxury sofa', 82000, 46, 1),
(14, 7, 'ikea', 'I200', 'luxury sofa', 'L260 S100', 'luxury sofa', 82000, 46, 1),
(15, 7, 'ikea', 'I200', 'flower pot', 'F460 P300', 'flower pot', 8200, 46, 1),
(16, 8, 'ikea', 'I200', 'flower pot', 'F460 P300', 'flower pot', 8200, 46, 1),
(17, 8, 'ikea', 'I200', 'luxury sofa', 'L260 S100', 'luxury sofa', 82000, 46, 1),
(18, 9, 'ikea', 'I200', 'flower pot', 'F460 P300', 'flower pot', 8200, 46, 1),
(19, 9, 'ikea', 'I200', 'luxury sofa', 'L260 S100', 'luxury sofa', 82000, 46, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `image_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_name`, `image_number`) VALUES
(1, 1, 'prd1_01.jpeg', 0),
(2, 1, 'prd1_02.jpg', 1),
(3, 1, 'prd1_03.jpg', 2),
(4, 1, 'prd1_04.jpg', 3),
(5, 2, 'prd2_01.jpg', 0),
(6, 2, 'prd2_02.jpg', 1),
(7, 2, 'prd2_03.jpg', 2),
(8, 2, 'prd2_04.jpg', 3),
(9, 3, 'prd1_01.jpeg', 0),
(10, 3, 'prd1_02.jpg', 1),
(11, 3, 'prd1_03.jpg', 2),
(12, 3, 'prd1_04.jpg', 3),
(13, 4, 'prd2_01.jpg', 0),
(14, 4, 'prd2_02.jpg', 1),
(15, 4, 'prd2_03.jpg', 2),
(16, 4, 'prd2_04.jpg', 3),
(17, 5, 'prd1_01.jpeg', 0),
(18, 5, 'prd1_02.jpg', 1),
(19, 5, 'prd1_03.jpg', 2),
(20, 5, 'prd1_04.jpg', 3),
(21, 6, 'prd2_01.jpg', 0),
(22, 6, 'prd2_02.jpg', 1),
(23, 6, 'prd2_03.jpg', 2),
(24, 6, 'prd2_04.jpg', 3),
(25, 7, 'prd1_01.jpeg', 0),
(26, 7, 'prd1_02.jpg', 1),
(27, 7, 'prd1_03.jpg', 2),
(28, 7, 'prd1_04.jpg', 3),
(29, 8, 'prd2_01.jpg', 0),
(30, 8, 'prd2_02.jpg', 1),
(31, 8, 'prd2_03.jpg', 2),
(32, 8, 'prd2_04.jpg', 3),
(33, 9, 'prd2_01.jpg', 0),
(34, 9, 'prd2_02.jpg', 1),
(35, 9, 'prd2_03.jpg', 2),
(36, 9, 'prd2_04.jpg', 3),
(37, 10, 'prd1_01.jpeg', 0),
(38, 10, 'prd1_02.jpg', 1),
(39, 10, 'prd1_03.jpg', 2),
(40, 10, 'prd1_04.jpg', 3),
(41, 11, 'prd1_01.jpeg', 0),
(42, 11, 'prd1_02.jpg', 1),
(43, 11, 'prd1_03.jpg', 2),
(44, 11, 'prd1_04.jpg', 3),
(45, 12, 'prd1_01.jpeg', 0),
(46, 12, 'prd1_02.jpg', 1),
(47, 12, 'prd1_03.jpg', 2),
(48, 12, 'prd1_04.jpg', 3),
(49, 14, 'prd1_01.jpeg', 0),
(50, 14, 'prd1_02.jpg', 1),
(51, 14, 'prd1_03.jpg', 2),
(52, 14, 'prd1_04.jpg', 3),
(53, 15, 'prd2_01.jpg', 0),
(54, 15, 'prd2_02.jpg', 1),
(55, 15, 'prd2_03.jpg', 2),
(56, 15, 'prd2_04.jpg', 3),
(57, 16, 'prd1_01.jpeg', 0),
(58, 16, 'prd1_02.jpg', 1),
(59, 16, 'prd1_03.jpg', 2),
(60, 16, 'prd1_04.jpg', 3),
(61, 17, 'prd1_01.jpeg', 0),
(62, 17, 'prd1_02.jpg', 1),
(63, 17, 'prd1_03.jpg', 2),
(64, 17, 'prd1_04.jpg', 3),
(65, 18, 'prd1_01.jpeg', 0),
(66, 18, 'prd1_02.jpg', 1),
(67, 18, 'prd1_03.jpg', 2),
(68, 18, 'prd1_04.jpg', 3),
(69, 19, 'prd1_01.jpeg', 0),
(70, 19, 'prd1_02.jpg', 1),
(71, 19, 'prd1_03.jpg', 2),
(72, 19, 'prd1_04.jpg', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_type` int(11) NOT NULL DEFAULT '1',
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_type`, `name`, `email`, `contact`, `address`, `city`, `password`, `status`) VALUES
(1, 0, 'admin', '0@gmail.com', '012345678912', '59 k1 valencia town', 'lahore', '4531e8924edde928f341f7df3ab36c70', 1),
(2, 1, 'customer', '1@gmail.com', '012345678912', '59 k1 valencia town', 'lahore', '4531e8924edde928f341f7df3ab36c70', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
