-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 24, 2024 at 07:22 AM
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

--
-- Dumping data for table `budget_approval`
--

INSERT INTO `budget_approval` (`approval_id`, `requisition_id`, `approved_amount`, `approval_status`, `approval_comments`, `approved_by`, `approval_date`, `remarks`) VALUES
(1949730657, 4, 60000.00, 'Approved', 'Approved for IT equipment', 'James King', '2024-10-13 12:34:36', 'Approval complete'),
(1949730656, 3, 15000.00, 'Pending', 'Pending review', NULL, '2024-10-13 12:34:36', 'Waiting for approval'),
(1949730655, 2, 20000.00, 'Rejected', 'Insufficient funds', 'Jane Smith', '2024-10-13 12:34:36', 'Rejected due to low budget'),
(1949730654, 1, 50000.00, 'Approved', 'Approved as per budget', 'John Doe', '2024-10-13 12:34:36', 'Approval complete'),
(1949730658, 5, 30000.00, 'Rejected', 'Project postponed', 'Laura Martin', '2024-10-13 12:34:36', 'Rejected for now'),
(1949730659, 6, 25000.00, 'Approved', 'Approved as per contract', 'Kevin Roy', '2024-10-13 12:34:36', 'Approved under terms'),
(1949730660, 7, 80000.00, 'Approved', 'Approved for marketing', 'Chris Evans', '2024-10-13 12:34:36', 'Budget allocated'),
(1949730661, 8, 10000.00, 'Rejected', 'Not necessary', 'Sandra Adams', '2024-10-13 12:34:36', 'No budget allocation'),
(1949730662, 9, 45000.00, 'Approved', 'Approved for finance tools', 'Michael Dean', '2024-10-13 12:34:36', 'Approved on review'),
(1949730663, 10, 5000.00, 'Pending', 'Waiting for final approval', NULL, '2024-10-13 12:34:36', 'Pending finalization'),
(1949730664, 11, 55000.00, 'Approved', 'Approved for software', 'Roger Blake', '2024-10-13 12:34:36', 'Approved after meeting'),
(1949730665, 12, 25000.00, 'Rejected', 'Exceeded budget limit', 'Anne Woods', '2024-10-13 12:34:36', 'Cannot approve at this time'),
(1949730666, 13, 70000.00, 'Approved', 'Approved for hardware', 'Patrick Green', '2024-10-13 12:34:36', 'Allocation approved'),
(1949730667, 14, 20000.00, 'Pending', 'Under review', NULL, '2024-10-13 12:34:36', 'Awaiting confirmation'),
(1949730668, 15, 120000.00, 'Approved', 'Approved as planned', 'Emma Price', '2024-10-13 12:34:36', 'Approval complete');

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

--
-- Dumping data for table `contracts`
--

INSERT INTO `contracts` (`contract_id`, `vendor_id`, `contract_terms`, `start_date`, `end_date`, `status`, `renewal_date`, `last_synced`, `remarks`) VALUES
(1, 101, 'Delivery within 30 days, 50% advance payment', '2024-01-01', '2024-12-31', 'Active', '2024-12-01', '2024-10-14 15:01:00', 'High-priority vendor'),
(2, 102, 'On-demand supply, Net 30 payment terms', '2023-06-15', '2024-06-15', 'Active', '2024-05-15', '2024-10-14 15:01:00', 'Regular supplier, preferred vendor'),
(3, 103, 'Quarterly review, delivery on request', '2022-10-01', '2024-10-01', 'Expired', '2023-09-01', '2024-10-14 15:01:00', 'Pending renewal decision'),
(4, 104, 'Monthly shipments, Net 15 payment terms', '2023-03-01', '2024-03-01', 'Terminated', '2023-02-15', '2024-10-14 15:01:00', 'Contract terminated due to issues'),
(5, 105, 'Exclusive supplier for electronics', '2023-05-01', '2025-05-01', 'Active', '2024-04-01', '2024-10-14 15:13:19', 'Long-term contract.');

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

--
-- Dumping data for table `invoice_payments`
--

INSERT INTO `invoice_payments` (`invoice_id`, `po_id`, `vendor_id`, `amount`, `payment_terms`, `payment_status`, `due_date`, `remarks`) VALUES
(1, 1001, 1, 50000.00, 'Net 30', 'Paid', '2024-10-10', 'Payment for Q3 supplies'),
(2, 1002, 2, 150000.00, 'Net 60', 'Pending', '2024-11-15', 'Awaiting payment approval'),
(3, 1003, 3, 300000.00, 'Net 45', 'Paid', '2024-10-20', 'Payment processed successfully'),
(4, 1004, 4, 120000.00, 'Net 30', 'Pending', '2024-12-01', 'Delayed due to budget constraints'),
(5, 1005, 5, 20000.00, 'Net 15', 'Paid', '2024-09-30', 'Paid early for discount');

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

--
-- Dumping data for table `po_sync`
--

INSERT INTO `po_sync` (`sync_id`, `po_id`, `sync_status`, `sync_attempts`, `last_sync_attempt`, `vendor_response`, `created_at`, `contract_id`) VALUES
(1, 1001, 'Pending', 0, NULL, NULL, '2024-10-13 04:35:02', NULL),
(2, 1002, 'Pending', 0, NULL, NULL, '2024-10-13 04:35:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorder`
--

CREATE TABLE `purchaseorder` (
  `po_id` int(11) NOT NULL,
  `vendor_name` varchar(255) DEFAULT NULL,
  `items` text DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `total_cost` decimal(10,2) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `status` enum('Ordered','Delivered','Cancelled') DEFAULT 'Ordered',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `sync_status` varchar(20) DEFAULT 'Pending',
  `sync_attempts` int(11) DEFAULT 0,
  `vendor_response` text DEFAULT NULL,
  `last_sync_attempt` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchaseorder`
--

INSERT INTO `purchaseorder` (`po_id`, `vendor_name`, `items`, `quantity`, `unit_price`, `total_cost`, `order_date`, `delivery_date`, `status`, `remarks`, `created_at`, `updated_at`, `sync_status`, `sync_attempts`, `vendor_response`, `last_sync_attempt`) VALUES
(1158885253, 'TechSupply', 'POS System', 5, 10000.00, 50000.00, '2024-01-10', '2024-01-12', 'Delivered', '', '2024-10-13 02:35:02', '2024-10-17 12:43:37', 'Pending', 0, NULL, NULL),
(1158885238, 'KitchenPro', 'Refrigerator', 2, 30000.00, 60000.00, '2024-01-12', '2024-01-25', 'Delivered', 'Delivered and installed', '2024-10-13 02:35:02', '2024-10-13 02:35:02', 'Pending', 0, NULL, NULL),
(1158885237, 'Chef Suppliers', 'Oven', 3, 50000.00, 150000.00, '2024-01-10', '2024-01-20', 'Cancelled', 'Urgent replacement needed', '2024-10-13 02:35:02', '2024-10-17 13:00:37', 'Pending', 0, NULL, NULL),
(1158885254, 'ChefTools', 'Grill', 2, 45000.00, 90000.00, '2024-01-08', NULL, 'Cancelled', 'Cancelled by hotel management', '2024-10-13 02:35:02', '2024-10-13 02:35:02', 'Pending', 0, NULL, NULL),
(1158885255, 'ComfortRest', 'Mattresses', 50, 8000.00, 400000.00, '2024-01-03', '2024-01-10', 'Delivered', 'For guest room upgrade', '2024-10-13 02:35:02', '2024-10-13 02:35:02', 'Pending', 0, NULL, NULL),
(1158885256, 'Floral Decor', 'Flower Arrangements', 20, 1000.00, 20000.00, '2024-01-09', '2024-01-12', 'Delivered', 'For hotel event decoration', '2024-10-13 02:35:02', '2024-10-13 02:35:02', 'Pending', 0, NULL, NULL),
(1158885239, 'FurnishHub', 'Dining Chairs', 50, 1200.00, 60000.00, '2024-01-15', '2024-01-18', 'Ordered', 'For restaurant refurbishing', '2024-10-13 02:35:02', '2024-10-13 02:35:02', 'Pending', 0, NULL, NULL),
(1158885240, 'BarCo', 'Bar Counter', 1, 75000.00, 75000.00, '2024-01-05', NULL, 'Cancelled', 'Cancelled by vendor', '2024-10-13 02:35:02', '2024-10-13 02:35:02', 'Pending', 0, NULL, NULL),
(1158885241, 'Chef Essentials', 'Chef Knives', 100, 250.00, 25000.00, '2024-01-08', '2024-01-14', 'Ordered', 'Delivered for kitchen upgrade', '2024-10-13 02:35:02', '2024-10-13 02:35:02', 'Pending', 0, NULL, NULL),
(1158885242, 'Hotel Furnishers', 'Bed Sheets', 200, 800.00, 160000.00, '2024-01-03', '2024-01-10', 'Delivered', 'Delivered and in use', '2024-10-13 02:35:02', '2024-10-13 02:35:02', 'Pending', 0, NULL, NULL),
(1158885243, 'BeveragePro', 'Juice Machine', 5, 12000.00, 60000.00, '2024-01-18', '2024-01-25', 'Ordered', 'Urgent requirement for bar', '2024-10-13 02:35:02', '2024-10-13 02:35:02', 'Pending', 0, NULL, NULL),
(1158885244, 'EventGear', 'Projector', 2, 35000.00, 70000.00, '2024-01-10', '2024-01-12', 'Delivered', 'Delivered on time', '2024-10-13 02:35:02', '2024-10-13 02:35:02', 'Pending', 0, NULL, NULL),
(1158885245, 'SpaWorld', 'Massage Chairs', 4, 15000.00, 60000.00, '2024-01-15', '2024-01-18', 'Ordered', 'For spa refurbishment', '2024-10-13 02:35:02', '2024-10-13 02:35:02', 'Pending', 0, NULL, NULL),
(1158885246, 'OutdoorWorks', 'Patio Furniture', 20, 2500.00, 50000.00, '2024-01-12', NULL, 'Ordered', 'For outdoor seating area', '2024-10-13 02:35:02', '2024-10-13 02:35:02', 'Pending', 0, NULL, NULL),
(1158885247, 'Luxury Linens', 'Towels', 500, 100.00, 50000.00, '2024-01-09', '2024-01-16', 'Delivered', 'Delivered for guest rooms', '2024-10-13 02:35:02', '2024-10-13 02:35:02', 'Pending', 0, NULL, NULL),
(1158885248, 'GourmetKitchen', 'Food Processor', 10, 5000.00, 50000.00, '2024-01-20', NULL, 'Delivered', 'Pending delivery', '2024-10-13 02:35:02', '2024-10-18 03:47:08', 'Pending', 0, NULL, NULL),
(1158885249, 'CleanPro', 'Cleaning Supplies', 100, 200.00, 20000.00, '2024-01-05', '2024-01-07', 'Delivered', 'Supplies for cleaning crew', '2024-10-13 02:35:02', '2024-10-13 02:35:02', 'Pending', 0, NULL, NULL),
(1158885250, 'DécorMaster', 'Wall Art', 15, 3000.00, 45000.00, '2024-01-14', '0212-02-21', 'Ordered', 'For lobby decoration', '2024-10-13 02:35:02', '2024-10-18 03:41:09', 'Pending', 0, NULL, NULL),
(1158885251, 'Lighting Solutions', 'Chandeliers', 3, 20000.00, 60000.00, '2024-01-07', '2024-01-14', 'Delivered', 'Delivered and installed', '2024-10-13 02:35:02', '2024-10-13 02:35:02', 'Pending', 0, NULL, NULL),
(1485423040, 'Vendor Cp', 'Sabon', 2, 15.00, 30.00, '2024-10-17', '2024-10-31', 'Cancelled', 'kupal_ka_ba_boss', '2024-10-14 10:36:00', '2024-10-17 12:40:27', 'Pending', 0, NULL, NULL),
(1485423041, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ordered', '\"AKJSDAJSKDNA\"', '2024-10-17 13:22:49', '2024-10-17 13:22:49', 'Pending', 0, NULL, NULL),
(1707284293, 'john ', 'chicken', 45, 45.00, 2025.00, '2024-10-24', '2024-10-24', 'Delivered', 'sarap', '2024-10-24 07:21:13', '2024-10-24 07:21:37', 'Pending', 0, NULL, NULL),
(2009047923, 'Jay', 'Book', 54, 150.00, 8100.00, '2024-10-22', '2024-10-23', 'Delivered', 'Penge ako mga list ng libro ', '2024-10-22 11:13:37', '2024-10-22 11:14:05', 'Pending', 0, NULL, NULL),
(1485424284, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cancelled', 'kupal ka boi xxxx', '2024-10-17 13:43:59', '2024-10-17 13:43:59', 'Pending', 0, NULL, NULL),
(1485424285, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cancelled', 'kupal ka boi xxxx', '2024-10-17 13:43:59', '2024-10-17 13:43:59', 'Pending', 0, NULL, NULL),
(1485424282, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cancelled', 'kupal ka boi xxxx', '2024-10-17 13:43:58', '2024-10-17 13:43:58', 'Pending', 0, NULL, NULL),
(1485424283, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cancelled', 'kupal ka boi xxxx', '2024-10-17 13:43:58', '2024-10-17 13:43:58', 'Pending', 0, NULL, NULL),
(1485424280, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cancelled', 'kupal ka boi xxxx', '2024-10-17 13:43:57', '2024-10-17 13:43:57', 'Pending', 0, NULL, NULL),
(1485424281, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cancelled', 'kupal ka boi xxxx', '2024-10-17 13:43:57', '2024-10-17 13:43:57', 'Pending', 0, NULL, NULL),
(1485424278, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cancelled', 'kupal ka boi xxxx', '2024-10-17 13:43:56', '2024-10-17 13:43:56', 'Pending', 0, NULL, NULL),
(1485424279, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cancelled', 'kupal ka boi xxxx', '2024-10-17 13:43:57', '2024-10-17 13:43:57', 'Pending', 0, NULL, NULL),
(1485424275, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cancelled', 'kupal ka boi xxxx', '2024-10-17 13:43:55', '2024-10-17 13:43:55', 'Pending', 0, NULL, NULL),
(1485424276, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cancelled', 'kupal ka boi xxxx', '2024-10-17 13:43:56', '2024-10-17 13:43:56', 'Pending', 0, NULL, NULL),
(1485424277, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cancelled', 'kupal ka boi xxxx', '2024-10-17 13:43:56', '2024-10-17 13:43:56', 'Pending', 0, NULL, NULL),
(1485424274, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cancelled', 'kupal ka boi xxxx', '2024-10-17 13:43:55', '2024-10-17 13:43:55', 'Pending', 0, NULL, NULL),
(1485424272, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cancelled', 'kupal ka boi xxxx', '2024-10-17 13:43:54', '2024-10-17 13:43:54', 'Pending', 0, NULL, NULL),
(1485424273, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cancelled', 'kupal ka boi xxxx', '2024-10-17 13:43:55', '2024-10-17 13:43:55', 'Pending', 0, NULL, NULL),
(1485424269, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cancelled', 'kupal ka boi xxxx', '2024-10-17 13:43:53', '2024-10-17 13:43:53', 'Pending', 0, NULL, NULL),
(1485424270, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cancelled', 'kupal ka boi xxxx', '2024-10-17 13:43:53', '2024-10-17 13:43:53', 'Pending', 0, NULL, NULL),
(1485424271, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cancelled', 'kupal ka boi xxxx', '2024-10-17 13:43:54', '2024-10-17 13:43:54', 'Pending', 0, NULL, NULL),
(1485424267, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cancelled', 'kupal ka boi xxxx', '2024-10-17 13:43:52', '2024-10-17 13:43:52', 'Pending', 0, NULL, NULL),
(1485424268, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cancelled', 'kupal ka boi xxxx', '2024-10-17 13:43:52', '2024-10-17 13:43:52', 'Pending', 0, NULL, NULL),
(1485424265, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cancelled', 'kupal ka boi xxxx', '2024-10-17 13:43:51', '2024-10-17 13:43:51', 'Pending', 0, NULL, NULL),
(1485424266, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cancelled', 'kupal ka boi xxxx', '2024-10-17 13:43:52', '2024-10-17 13:43:52', 'Pending', 0, NULL, NULL),
(1485424264, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cancelled', 'kupal ka boi xxxx', '2024-10-17 13:43:51', '2024-10-17 13:43:51', 'Pending', 0, NULL, NULL),
(1485424262, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cancelled', 'kupal ka boi xxxx', '2024-10-17 13:43:39', '2024-10-17 13:43:39', 'Pending', 0, NULL, NULL),
(1485424263, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cancelled', 'kupal ka boi xxxx', '2024-10-17 13:43:39', '2024-10-17 13:43:39', 'Pending', 0, NULL, NULL),
(1485424260, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cancelled', 'kupal ka boi xxxx', '2024-10-17 13:43:38', '2024-10-17 13:43:38', 'Pending', 0, NULL, NULL),
(1485424261, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cancelled', 'kupal ka boi xxxx', '2024-10-17 13:43:39', '2024-10-17 13:43:39', 'Pending', 0, NULL, NULL),
(1485424258, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cancelled', 'kupal ka boi xxxx', '2024-10-17 13:43:35', '2024-10-17 13:43:35', 'Pending', 0, NULL, NULL),
(1485424259, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cancelled', 'kupal ka boi xxxx', '2024-10-17 13:43:36', '2024-10-17 13:43:36', 'Pending', 0, NULL, NULL),
(1485424256, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cancelled', 'kupal ka boi', '2024-10-17 13:43:26', '2024-10-17 13:43:26', 'Pending', 0, NULL, NULL),
(1485424257, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cancelled', 'kupal ka boi xxxx', '2024-10-17 13:43:34', '2024-10-17 13:43:34', 'Pending', 0, NULL, NULL);

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

--
-- Dumping data for table `purchaserequisition`
--

INSERT INTO `purchaserequisition` (`requisition_id`, `department`, `item_description`, `quantity`, `unit_of_measure`, `priority_level`, `requested_date`, `required_date`, `status`, `remarks`, `budget_status`, `budget_approved_amount`) VALUES
(1981911004, 'Maintenance', 'Cleaning Equipment', 5, 'Units', 'High', '2024-01-10', '2024-01-18', 'Approve', 'Awaiting approval', 'Pending', NULL),
(1981911003, 'Restaurant', 'Dining Tables', 20, 'Units', 'High', '2024-01-08', '2024-01-15', 'Approve', 'For restaurant expansion', 'Approved', 150000.00),
(1981911002, 'Kitchen', 'Blenders', 10, 'Units', 'Medium', '2024-01-05', '2024-01-12', 'Approve', 'Required for bar', 'Approved', 30000.00),
(1981911001, 'Spa', 'Massage Oils', 200, 'Bottles', 'Low', '2024-01-03', '2024-01-10', 'Decline', 'Budget constraints', 'Rejected', NULL),
(1981911000, 'Housekeeping', 'Laundry Detergents', 100, 'Liters', 'Medium', '2024-01-02', '2024-01-08', 'Approve', 'For guest laundry services', 'Approved', 15000.00),
(1981910999, 'Kitchen', 'New Stove', 5, 'Units', 'High', '2024-01-01', '2024-01-10', 'Approve', 'Needed for increased orders', 'Approved', 500000.00),
(1981911005, 'Spa', 'New Towel Sets', 100, 'Sets', 'Medium', '2024-01-12', '2024-01-20', 'Approve', 'For spa services', 'Approved', 25000.00),
(1981911006, 'Bar', 'Wine Glasses', 200, 'Units', 'Low', '2024-01-15', '2024-01-20', 'Decline', 'Not needed this season', 'Rejected', NULL),
(1981911007, 'Banquet', 'Stage Lights', 15, 'Units', 'High', '2024-01-17', '2024-01-25', 'Approve', 'For upcoming events', 'Approved', 50000.00),
(1981911008, 'Kitchen', 'Deep Fryers', 3, 'Units', 'High', '2024-01-20', '2024-01-30', 'Approve', 'Pending final approval', 'Pending', NULL),
(1981911009, 'Restaurant', 'Crockery Set', 500, 'Sets', 'Medium', '2024-01-22', '2024-01-30', 'Approve', 'Required for new menu', 'Approved', 75000.00),
(1981911010, 'Spa', 'Essential Oils', 200, 'Bottles', 'Low', '2024-01-25', '2024-02-01', 'Decline', 'Budget exceeded', 'Rejected', NULL),
(1981911011, 'Kitchen', 'Microwave Ovens', 4, 'Units', 'High', '2024-01-28', '2024-02-05', 'Approve', 'For catering services', 'Approved', 20000.00),
(1981911012, 'Housekeeping', 'Vacuum Cleaners', 10, 'Units', 'Medium', '2024-10-24', '2024-02-07', 'Approve', 'For hotel room cleaning', 'Approved', 15000.00),
(1345999612, 'Finance', '545', 54, '545', 'Low', '0004-05-04', '0545-04-05', 'Pending', '45', 'Pending', NULL),
(1981911014, 'Kitchen', 'Refrigerators', 2, 'Units', 'High', '2024-02-03', '2024-02-12', 'Approve', 'Required for cold storage', 'Approved', 50000.00),
(1981911015, 'Maintenance', 'Janitorial Supplies', 50, 'Units', 'Low', '2024-02-05', '2024-02-10', 'Approve', 'Budget cut', 'Rejected', NULL),
(1981911016, 'Bar', 'Bar Stools', 20, 'Units', 'Medium', '2024-02-07', '2024-02-15', 'Approve', 'For bar renovation', 'Approved', 30000.00),
(1981911017, 'Restaurant', 'Table Linens', 100, 'Sets', 'Medium', '2024-02-10', '2024-02-18', 'Decline', 'Required for fine dining', 'Approved', 20000.00),
(1981911018, 'Kitchen', 'Dishwashers', 3, 'Units', 'High', '2024-02-12', '2024-02-20', 'Approve', 'Final review pending', 'Pending', NULL);

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

--
-- Dumping data for table `rfqs`
--

INSERT INTO `rfqs` (`rfq_id`, `vendor_id`, `product_id`, `requested_quantity`, `quoted_price`, `rfq_status`, `response_date`, `remarks`) VALUES
(66, 2079845343, 25522043, 20, 40000, 'Approved', '2024-02-15 00:00:00', ''),
(65, 2079845342, 25522042, 10, 100000, 'Approved', '2024-10-22 20:00:29', ''),
(64, 2079845341, 25522041, 2, 90000, 'Approved', '2024-02-10 00:00:00', ''),
(63, 2079845340, 25522040, 5, 75000, 'Pending', NULL, ''),
(62, 2079845339, 25522024, 1000, 50000, 'Approved', '2024-02-08 00:00:00', ''),
(61, 2079845337, 25522025, 15, 45000, 'Approved', '2024-02-05 00:00:00', ''),
(60, 2079845338, 25522026, 2, 50000, 'Pending', NULL, ''),
(59, 2079845336, 25522027, 250, 50000, 'Rejected', '2024-02-03 00:00:00', ''),
(58, 2079845334, 25522029, 300, 30000, 'Approved', '2024-02-01 00:00:00', ''),
(56, 2079845333, 25522030, 10, 50000, 'Approved', '2024-01-28 00:00:00', ''),
(55, 2079845332, 25522031, 100, 15000, 'Pending', NULL, ''),
(54, 2079845331, 25522032, 2, 70000, 'Approved', '2024-10-22 19:56:22', ''),
(53, 2079845330, 25522033, 5, 50000, 'Rejected', '2024-01-22 00:00:00', ''),
(52, 2079845329, 25522034, 500, 400000, 'Approved', '2024-01-20 00:00:00', ''),
(51, 2079845328, 25522035, 25, 12500, 'Approved', '2024-01-18 00:00:00', ''),
(50, 2079845327, 25522036, 1, 45000, 'Rejected', '2024-01-15 00:00:00', ''),
(49, 2079845326, 25522037, 1, 60000, 'Pending', NULL, ''),
(48, 2079845324, 25522039, 2, 160000, 'Approved', '2024-01-12 00:00:00', ''),
(47, 2079845325, 25522038, 8, 96000, 'Approved', '2024-01-10 00:00:00', ''),
(875631954, 1, 25522024, 121, 12154, 'Approved', '2024-10-22 00:00:00', 'dadad'),
(229516131, 1, 25522024, 10, 456, 'Responded', '2024-10-22 20:35:56', 'eto na qoute mo .');

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
(1, 123456, 'webmaster', 'bc92620f484b20dd4a86744189f83b3a', 'Web', 'Master', 'kasl.54370906@gmail.com', '1234567890', '123 Developer Lane, Code City, Webland 56789', 'I am a passionate web developer with over 5 years of experience...', 'Active', 'MTIzNDU2.50a9c7dbf0fa09e8969978317dca12e8', '2024-10-23 08:50:43', 'ADMIN', '2049e5f56a0dad4ed3570d461020b9e2ce40e64ba6ceaa80d8a0eb4161b54dca', '2024-10-11 16:09:17', '2024-10-05 10:04:58', '2024-10-09 14:10:28', '670c93726fcb9.jpg'),
(18, 820909241, 'logisticS', 'e4aabbb7c2c84a3d732aa9214f336801', 'logistic', 'logistic', 'valkyrievee00@gmail.com', '6516511651651', 'kupal ka ba boss streetS', '', 'Active', 'ODIwOTA5MjQx.1e15f256bcbf4e3d8a9a3c6262a64401', '2024-10-11 22:22:29', 'LOGISTIC', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2024-10-11 22:17:34', ''),
(19, 306112906, 'kitchen', '7179d51fa0c8c248cba47b80258a0b6c', 'kitchen', 'kitchen', 'dump41863@gmail.com', '090964714545', 'kupal ka ba boss street', 'lupak ako\r\n', 'Active', 'MzA2MTEyOTA2.09228dac155633b13780552bc01dc2e0', '2024-10-15 13:55:16', 'KITCHEN', '', '2024-10-12 09:45:31', '0000-00-00 00:00:00', '2024-10-12 09:14:02', ''),
(20, 306112907, 'vendor01', '7a703fe858a974853b62a597668e86f1', 'vendor', 'vendor', 'dump41863@gmail.com', '090964714545', 'kupal ka ba boss street', 'lupak ako\r\n', 'Active', 'MzA2MTEyOTA3.fdf04ed5fd0049590b2da8ab82cfc62c', '2024-10-22 20:33:00', 'VENDOR', '', '2024-10-12 09:45:31', '0000-00-00 00:00:00', '2024-10-12 09:14:02', ''),
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

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`vendor_id`, `vendor_name`, `contact_info`, `vendor_rating`, `preferred_status`, `contract_status`) VALUES
(2079845339, 'Fresh Produce', 'freshproduce@hotel.com, +456987123', 5, 'Yes', 'Active'),
(2079845337, 'DécorMaster', 'decormaster@hotel.com, +789123654', 3, 'Yes', 'Active'),
(2079845338, 'Lighting Solutions', 'lightingsolutions@hotel.com, +321456789', 4, 'No', 'Inactive'),
(2079845336, 'CleanPro', 'cleanpro@hotel.com, +951753456', 5, 'Yes', 'Active'),
(2079845335, 'GourmetKitchen', 'gourmetkitchen@hotel.com, +123789456', 4, 'No', 'Inactive'),
(2079845334, 'Luxury Linens', 'luxurylinens@hotel.com, +852741963', 5, 'Yes', 'Active'),
(2079845333, 'OutdoorWorks', 'outdoorworks@hotel.com, +258147963', 4, 'No', 'Inactive'),
(2079845332, 'SpaWorld', 'spaworld@hotel.com, +963852741', 3, 'Yes', 'Active'),
(2079845330, 'BeveragePro', 'beveragepro@hotel.com, +456123789', 4, 'No', 'Inactive'),
(2079845329, 'Hotel Furnishers', 'hotelfurnishers@hotel.com, +321654987', 5, 'Yes', 'Active'),
(2079845328, 'Chef Essentials', 'chefessentials@hotel.com, +456789123', 3, 'Yes', 'Active'),
(2079845327, 'BarCo', 'barco@hotel.com, +987654321', 4, 'No', 'Inactive'),
(2079845326, 'KitchenPro', 'kitchenpro@hotel.com, +56781234', 5, 'Yes', 'Active'),
(2079845325, 'FurnishHub', 'furnishhub@hotel.com, +987654321', 4, 'No', 'Inactive'),
(2079845324, 'Chef Suppliers', 'chefsuppliers@hotel.com, +123456789', 5, 'Yes', 'Active'),
(2079845340, 'TechSupply', 'techsupply@hotel.com, +963741258', 4, 'No', 'Inactive'),
(2079845341, 'ChefTools', 'cheftools@hotel.com, +654789123', 5, 'Yes', 'Active'),
(2079845342, 'ComfortRest', 'comfortrest@hotel.com, +852963741', 4, 'No', 'Inactive'),
(2079845343, 'Floral Decor', 'floraldecor@hotel.com, +951456123', 5, 'Yes', 'Active'),
(101, 'Vendor A Supplies', 'email: a@vendor.com', 5, 'Yes', 'Active'),
(102, 'Vendor B Logistics', 'email: b@vendor.com', 4, 'Yes', 'Active'),
(103, 'Vendor C Limited', 'email: c@vendor.com', 3, 'No', 'Inactive'),
(104, 'Vendor D Services', 'email: d@vendor.com', 2, 'No', 'Inactive'),
(105, 'Vendor E Electronics', 'email: e@vendor.com', 5, 'Yes', 'Active'),
(1, 'ABC Supplies', 'abc@supplies.com, +1234567890', 5, 'Yes', 'Active'),
(2, 'XYZ Logistics', 'xyz@logistics.com, +9876543210', 4, 'No', 'Active'),
(3, 'Global Tech', 'globaltech@company.com, +1122334455', 5, 'Yes', 'Active'),
(4, 'Delta Tools', 'delta@tools.com, +4433221100', 3, 'No', 'Active'),
(5, 'Prime Materials', 'prime@materials.com, +6655443322', 4, 'Yes', 'Active'),
(1945532275, 'Kupal', '92827272', 5, 'Yes', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_products`
--

CREATE TABLE `vendor_products` (
  `product_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `unit_price` float NOT NULL,
  `availability` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor_products`
--

INSERT INTO `vendor_products` (`product_id`, `vendor_id`, `product_name`, `description`, `unit_price`, `availability`) VALUES
(25522038, 2079845325, 'Dining Table', 'Wooden dining tables for restaurant', 120001, 10),
(25522039, 2079845324, 'Commercial Oven', 'High-capacity oven for kitchen', 80000, 5),
(25522037, 2079845326, 'Industrial Refrigerator', 'Large refrigerator for kitchen', 60000, 3),
(25522036, 2079845327, 'Bar Counter', 'Stylish bar counter for hotel lounge', 450002, 2),
(25522034, 2079845329, 'Bed Sheets', 'Luxury bed sheets for hotel rooms', 800, 500),
(25522033, 2079845330, 'Juice Dispenser', 'Large juice dispenser for breakfast buffet', 10000, 10),
(25522032, 2079845331, 'Event Projector', 'High-definition projector for conference rooms', 35000, 3),
(25522031, 2079845332, 'Massage Oils', 'Essential oils for spa use', 150, 250),
(25522030, 2079845333, 'Outdoor Patio Furniture', 'Durable furniture for outdoor seating', 5000, 15),
(25522028, 2079845335, 'Commercial Blender', 'High-speed blender for kitchen use', 15000, 8),
(25522029, 2079845334, 'Luxury Towels', 'Soft, high-quality towels for guests', 100, 300),
(25522027, 2079845336, 'Cleaning Supplies', 'Various cleaning chemicals and tools', 200, 500),
(25522026, 2079845338, 'Chandelier', 'Luxury crystal chandelier for dining area', 25000, 5),
(25522025, 2079845337, 'Wall Art', 'Modern decorative art for hotel rooms', 3000, 20),
(25522024, 2079845339, 'Fresh Vegetables', 'Organic fresh vegetables for kitchen use', 50, 1000),
(25522040, 2079845340, 'POS System', 'Point-of-sale system for restaurant', 15000, 7),
(25522041, 2079845341, 'Grill Station', 'Professional grilling station for kitchen', 45000, 3),
(25522042, 2079845342, 'King Size Mattress', 'Luxury mattresses for hotel rooms', 10000, 25),
(25522043, 2079845343, 'Flower Arrangement', 'Fresh flower arrangements for events', 2000, 50);

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
  ADD KEY `vendor_id` (`vendor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `budget_approval`
--
ALTER TABLE `budget_approval`
  MODIFY `approval_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1949730669;

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
  MODIFY `requisition_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1981911019;

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
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25522044;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
