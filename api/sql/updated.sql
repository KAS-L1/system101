-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 26, 2024 at 11:43 AM
-- Server version: 10.3.39-MariaDB-0ubuntu0.20.04.2
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `logi_hotel_crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `budget_approval`
--

CREATE TABLE `budget_approval` (
  `approval_id` int(11) NOT NULL,
  `requisition_id` int(11) NOT NULL,
  `approved_amount` decimal(15,2) NOT NULL,
  `approval_status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `approval_comments` text DEFAULT NULL,
  `approved_by` varchar(100) DEFAULT NULL,
  `approval_date` datetime DEFAULT current_timestamp(),
  `remarks` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'kupal');

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `contract_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `contract_terms` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('Active','Terminated','Expired') DEFAULT 'Active',
  `renewal_date` date DEFAULT NULL,
  `last_synced` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `remarks` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_payments`
--

CREATE TABLE `invoice_payments` (
  `invoice_id` int(11) NOT NULL,
  `po_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `payment_terms` varchar(50) NOT NULL,
  `payment_status` enum('Paid','Pending') DEFAULT 'Pending',
  `due_date` date NOT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `po_sync`
--

CREATE TABLE `po_sync` (
  `sync_id` int(11) NOT NULL,
  `po_id` int(11) NOT NULL,
  `sync_status` varchar(20) DEFAULT 'Pending',
  `sync_attempts` int(11) DEFAULT 0,
  `last_sync_attempt` datetime DEFAULT NULL,
  `vendor_response` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `contract_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorder`
--

CREATE TABLE `purchaseorder` (
  `po_id` int(11) NOT NULL,
  `vendor_name` varchar(255) DEFAULT NULL,
  `items` text DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `delivery_method` int(50) DEFAULT NULL,
  `tracking_link` int(50) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `total_cost` decimal(10,2) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `status` enum('Ordered','Delivered','Cancelled','Shipped','In_transit') DEFAULT 'Ordered',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `sync_status` varchar(20) DEFAULT 'Pending',
  `sync_attempts` int(11) DEFAULT 0,
  `vendor_response` text DEFAULT NULL,
  `last_sync_attempt` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchaserequisition`
--

CREATE TABLE `purchaserequisition` (
  `requisition_id` int(11) NOT NULL,
  `department` text NOT NULL,
  `item_description` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_of_measure` text NOT NULL,
  `priority_level` enum('Low','High','Medium') NOT NULL,
  `requested_date` date NOT NULL,
  `required_date` date NOT NULL,
  `status` enum('Pending','Approve','Decline') NOT NULL,
  `remarks` text DEFAULT NULL,
  `budget_status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `budget_approved_amount` decimal(15,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rfqs`
--

CREATE TABLE `rfqs` (
  `rfq_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `requested_quantity` int(11) NOT NULL,
  `quoted_price` float DEFAULT NULL,
  `rfq_status` enum('Pending','Approved','Rejected','Responded','') NOT NULL,
  `response_date` datetime DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` char(32) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact` text NOT NULL,
  `address` varchar(250) NOT NULL,
  `about_me` text DEFAULT NULL,
  `status` enum('Active','Inactive','Pending','Deactivated') NOT NULL,
  `login_token` char(50) DEFAULT NULL,
  `login_last` datetime DEFAULT NULL,
  `role` enum('ADMIN','LOGISTIC','FINANCE','STAFF','VENDOR','KITCHEN') NOT NULL,
  `forgot_token` varchar(100) DEFAULT NULL,
  `forgot_token_updated` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `username`, `password`, `firstname`, `lastname`, `email`, `contact`, `address`, `about_me`, `status`, `login_token`, `login_last`, `role`, `forgot_token`, `forgot_token_updated`, `created_at`, `updated_at`, `profile_pic`) VALUES
(1, 123456, 'webmaster', 'bc92620f484b20dd4a86744189f83b3a', 'Web', 'Master', 'kasl.54370906@gmail.com', '1234567890', '123 Developer Lane, Code City, Webland 56789', 'I am a passionate web developer with over 5 years of experience...', 'Active', 'MTIzNDU2.50a9c7dbf0fa09e8969978317dca12e8', '2024-10-26 13:23:51', 'ADMIN', '2049e5f56a0dad4ed3570d461020b9e2ce40e64ba6ceaa80d8a0eb4161b54dca', '2024-10-11 16:09:17', '2024-10-05 10:04:58', '2024-10-09 14:10:28', '671b48b1b5254.jpg'),
(18, 820909241, 'logisticS', 'e4aabbb7c2c84a3d732aa9214f336801', 'logistic', 'logistic', 'valkyrievee00@gmail.com', '6516511651651', 'kupal ka ba boss streetS', '', 'Active', 'ODIwOTA5MjQx.1e15f256bcbf4e3d8a9a3c6262a64401', '2024-10-11 22:22:29', 'LOGISTIC', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2024-10-11 22:17:34', ''),
(19, 306112906, 'kitchen', '7179d51fa0c8c248cba47b80258a0b6c', 'kitchen', 'kitchen', 'dump41863@gmail.com', '090964714545', 'kupal ka ba boss street', 'lupak ako\r\n', 'Active', 'MzA2MTEyOTA2.09228dac155633b13780552bc01dc2e0', '2024-10-15 13:55:16', 'KITCHEN', '', '2024-10-12 09:45:31', '0000-00-00 00:00:00', '2024-10-12 09:14:02', ''),
(20, 306112907, 'vendor01', 'df96220fa161767c5cbb95567855c86b', 'vendor', 'vendor', 'dump41863@gmail.com', '090964714545', 'kupal ka ba boss street', 'lupak ako\r\n', 'Active', 'MzA2MTEyOTA3.fdf04ed5fd0049590b2da8ab82cfc62c', '2024-10-26 15:11:26', 'VENDOR', '', '2024-10-12 09:45:31', '0000-00-00 00:00:00', '2024-10-12 09:14:02', ''),
(21, 379357825, 'valerie', 'fa96b1acc3e377beb2671c6dd4f8a393', 'Valerie', 'Conwi', 'mheeraannvalerieconwi@gmail.com', '09564197592', 'North Fairview Quezon City', 'Pogandang Document Specialist', 'Active', 'Mzc5MzU3ODI1.6818bab4da85a3a138cdfa35cfc7a64f', '2024-10-17 12:50:21', 'LOGISTIC', NULL, NULL, NULL, '2024-10-16 07:06:44', '670ef92d3acb9.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `vendor_id` int(11) NOT NULL,
  `vendor_name` varchar(255) NOT NULL,
  `contact_info` varchar(255) NOT NULL,
  `vendor_rating` int(11) NOT NULL,
  `preferred_status` enum('Yes','No') NOT NULL,
  `contract_status` enum('Active','Inactive') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendor_products`
--

CREATE TABLE `vendor_products` (
  `product_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `unit_price` float NOT NULL,
  `availability` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `budget_approval`
--
ALTER TABLE `budget_approval`
  ADD PRIMARY KEY (`approval_id`),
  ADD KEY `requisition_id` (`requisition_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`contract_id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `invoice_payments`
--
ALTER TABLE `invoice_payments`
  ADD PRIMARY KEY (`invoice_id`),
  ADD KEY `po_id` (`po_id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `po_sync`
--
ALTER TABLE `po_sync`
  ADD PRIMARY KEY (`sync_id`),
  ADD KEY `po_id` (`po_id`),
  ADD KEY `fk_contract_id` (`contract_id`);

--
-- Indexes for table `purchaseorder`
--
ALTER TABLE `purchaseorder`
  ADD PRIMARY KEY (`po_id`);

--
-- Indexes for table `purchaserequisition`
--
ALTER TABLE `purchaserequisition`
  ADD PRIMARY KEY (`requisition_id`);

--
-- Indexes for table `rfqs`
--
ALTER TABLE `rfqs`
  ADD PRIMARY KEY (`rfq_id`),
  ADD KEY `vendor_id` (`vendor_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`vendor_id`);

--
-- Indexes for table `vendor_products`
--
ALTER TABLE `vendor_products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `vendor_id` (`vendor_id`),
  ADD KEY `fk_category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `budget_approval`
--
ALTER TABLE `budget_approval`
  MODIFY `approval_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2126001371;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `contract_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `invoice_payments`
--
ALTER TABLE `invoice_payments`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `po_sync`
--
ALTER TABLE `po_sync`
  MODIFY `sync_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchaseorder`
--
ALTER TABLE `purchaseorder`
  MODIFY `po_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2009047924;

--
-- AUTO_INCREMENT for table `purchaserequisition`
--
ALTER TABLE `purchaserequisition`
  MODIFY `requisition_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1996385550;

--
-- AUTO_INCREMENT for table `rfqs`
--
ALTER TABLE `rfqs`
  MODIFY `rfq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=875631955;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2079845344;

--
-- AUTO_INCREMENT for table `vendor_products`
--
ALTER TABLE `vendor_products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140436554;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
