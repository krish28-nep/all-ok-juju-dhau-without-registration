-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Database: `juju-dhau`
CREATE DATABASE IF NOT EXISTS `juju-dhau`;
USE `juju-dhau`;

-- Table structure for table `cart_details`
CREATE TABLE `cart_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `option` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `userid` (`userid`),
  CONSTRAINT `cart_details_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  CONSTRAINT `cart_details_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `contact_us`
CREATE TABLE `contact_us` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `orders`
CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `address` text NOT NULL,
  `payment_method` varchar(50) NOT NULL DEFAULT 'Cash on Delivery',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'Pending',
  PRIMARY KEY (`order_id`),
  KEY `userid` (`userid`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `order_details`
CREATE TABLE `order_details` (
  `order_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `option` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`order_detail_id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `products`
CREATE TABLE `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `list_title` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `base_price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `background_color` varchar(20) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `product_options` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `product_options`
CREATE TABLE `product_options` (
  `option_id` int(11) NOT NULL AUTO_INCREMENT,
  `option_name` varchar(50) NOT NULL,
  PRIMARY KEY (`option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `user`
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `number` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- Insert data into `cart_details`
INSERT INTO `cart_details` (`id`, `product_id`, `userid`, `option`) VALUES
(51, 1, 1, 1);

-- Insert data into `contact_us`
INSERT INTO `contact_us` (`contact_id`, `name`, `email`, `message`, `submitted_at`) VALUES
(1, 'John Doe', 'john.doe@example.com', 'Interested in your products.', '2024-12-20 16:30:00');

-- Insert data into `orders`
INSERT INTO `orders` (`order_id`, `userid`, `total_amount`, `address`, `payment_method`, `order_date`, `status`) VALUES
(1, 1, 1000.00, 'Bhaktapur, Chamasign', 'Cash on Delivery', '2024-12-20 16:44:54', 'Pending');

-- Insert data into `order_details`
INSERT INTO `order_details` (`order_detail_id`, `order_id`, `product_id`, `option`, `price`) VALUES
(8, 1, 2, 4.00, 250.00);

-- Insert data into `products`
INSERT INTO `products` (`product_id`, `list_title`, `title`, `base_price`, `description`, `image_path`, `background_color`, `date_added`, `product_options`) VALUES
(1, 'Matka-Dhau', 'Matka-Dhau', 300.00, 'A traditional clay pot yogurt with a rich and creamy texture.', 'matka-dhau.png', 'green', '2024-10-27 08:36:57', '1,2,3'),
(2, 'Kalla-Dhau', 'Kalla-Dhau', 250.00, 'A delicious and thick yogurt made from cow\'s milk.', 'kalla-dhau.png', 'rebeccapurple', '2024-10-27 08:36:57', '1,2,3'),
(3, 'Cup-Dhau', 'Cup-Dhau', 60.00, 'A convenient cup of yogurt, perfect for on-the-go consumption.', 'cup.png', 'teal', '2024-10-27 08:36:57', '1'),
(4, 'Plastic-Dhau', 'Plastic-Dhau', 200.00, 'A modern packaging option for your favorite yogurt.', 'plastic.png', 'cornflowerblue', '2024-10-27 08:36:57', '1,2,3'),
(5, 'Special Combo', 'Combo Kalla-Dhau + Cup-Dhau', 300.00, 'Enjoy the best of both worlds with this combo pack.', 'combo.png', 'goldenrod', '2024-10-27 08:36:57', '1,2,3');

-- Insert data into `product_options`
INSERT INTO `product_options` (`option_id`, `option_name`) VALUES
(1, '1'),
(2, '3'),
(3, '4');

-- Insert data into `user`
INSERT INTO `user` (`id`, `name`, `email`, `password`, `number`, `address`) VALUES
(1, 'Luffy', 'qwe@gmail.com', '123456', 2147483647, 'sfbaf dfbg dfbe dfb');

COMMIT;
