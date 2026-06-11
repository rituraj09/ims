-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 11, 2026 at 04:30 AM
-- Server version: 9.1.0
-- PHP Version: 8.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ims`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `user_name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Snapshot of user name',
  `action` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'created, updated, deleted, assigned, transferred, etc.',
  `module` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'assets, departments, employees, vendors, settings',
  `subject_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Model class name',
  `subject_id` bigint UNSIGNED DEFAULT NULL COMMENT 'Model ID',
  `subject_label` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Human readable subject e.g., Asset Tag or name',
  `old_values` json DEFAULT NULL COMMENT 'Previous data snapshot',
  `new_values` json DEFAULT NULL COMMENT 'New data snapshot',
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `activity_logs_module_subject_type_subject_id_index` (`module`,`subject_type`,`subject_id`),
  KEY `activity_logs_user_id_created_at_index` (`user_id`,`created_at`),
  KEY `activity_logs_action_index` (`action`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `user_name`, `action`, `module`, `subject_type`, `subject_id`, `subject_label`, `old_values`, `new_values`, `ip_address`, `user_agent`, `description`, `created_at`) VALUES
(1, 1, 'Super Administrator', 'updated', 'users', 'App\\Models\\User', 2, 'Abhinandan Hazarika', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-08 06:14:20'),
(2, 1, 'Super Administrator', 'updated', 'users', 'App\\Models\\User', 108, 'Atikur Rahman', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-08 06:22:27'),
(3, 1, 'Super Administrator', 'updated', 'roles', 'App\\Models\\Role', 3, 'IT admin', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Permissions updated for role: IT admin', '2026-06-08 06:23:02'),
(4, 1, 'Super Administrator', 'logout', 'auth', NULL, NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-08 06:23:20'),
(5, 108, 'Atikur Rahman', 'login', 'auth', NULL, NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Logged in from IP: ::1', '2026-06-08 06:23:26'),
(6, 1, 'Super Administrator', 'login', 'auth', NULL, NULL, NULL, NULL, NULL, '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Logged in from IP: 10.177.132.59', '2026-06-08 06:26:13'),
(7, 1, 'Super Administrator', 'logout', 'auth', NULL, NULL, NULL, NULL, NULL, '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-08 06:47:32'),
(8, 108, 'Atikur Rahman', 'logout', 'auth', NULL, NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-08 06:50:34'),
(9, 1, 'Super Administrator', 'login', 'auth', NULL, NULL, NULL, NULL, NULL, '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Logged in from IP: 10.177.132.59', '2026-06-08 06:57:43'),
(10, 1, 'Super Administrator', 'updated', 'users', 'App\\Models\\User', 32, 'Pratyush Parasar Sarma', NULL, NULL, '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-08 06:58:37'),
(11, 1, 'Super Administrator', 'logout', 'auth', NULL, NULL, NULL, NULL, NULL, '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-08 07:01:45'),
(12, 108, 'Atikur Rahman', 'login', 'auth', NULL, NULL, NULL, NULL, NULL, '10.177.132.242', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Logged in from IP: 10.177.132.242', '2026-06-08 07:03:25'),
(13, 1, 'Super Administrator', 'login', 'auth', NULL, NULL, NULL, NULL, NULL, '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Logged in from IP: 10.177.132.59', '2026-06-08 07:10:33'),
(14, 1, 'Super Administrator', 'updated', 'departments', 'App\\Models\\Department', 1, 'Nazarat', '{\"id\": 1, \"city\": null, \"code\": \"NAZ\", \"name\": \"Nazarat\", \"block\": null, \"email\": null, \"floor\": \"First Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": null, \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-08T11:13:11.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-08T11:13:11.000000Z\", \"head_user_id\": null}', '{\"id\": 1, \"city\": null, \"code\": \"NAZ\", \"name\": \"Nazarat\", \"block\": null, \"email\": null, \"floor\": \"Second Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": null, \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-08T11:13:11.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-08T12:56:30.000000Z\", \"head_user_id\": null}', '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-08 07:26:30'),
(15, 1, 'Super Administrator', 'logout', 'auth', NULL, NULL, NULL, NULL, NULL, '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-08 07:26:59'),
(16, 1, 'Super Administrator', 'login', 'auth', NULL, NULL, NULL, NULL, NULL, '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Logged in from IP: 10.177.132.59', '2026-06-08 23:13:29'),
(17, 1, 'Super Administrator', 'updated', 'users', 'App\\Models\\User', 1, 'Super Administrator', NULL, NULL, '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-08 23:14:22'),
(18, 1, 'Super Administrator', 'login', 'auth', NULL, NULL, NULL, NULL, NULL, '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Logged in from IP: 10.177.132.59', '2026-06-09 01:51:30'),
(19, 1, 'Super Administrator', 'login', 'auth', NULL, NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Logged in from IP: ::1', '2026-06-09 02:11:58'),
(20, 1, 'Super Administrator', 'updated', 'users', 'App\\Models\\User', 56, 'Rituraj Borgohain', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-09 02:12:34'),
(21, 1, 'Super Administrator', 'updated', 'categories', 'App\\Models\\AssetCategory', 1, 'IT Equipment', '{\"id\": 1, \"code\": \"IT\", \"icon\": \"fas fa-laptop\", \"name\": \"IT Equipment\", \"status\": \"active\", \"created_at\": \"2026-06-08T11:13:12.000000Z\", \"created_by\": null, \"deleted_at\": null, \"updated_at\": \"2026-06-08T11:13:12.000000Z\", \"updated_by\": null, \"description\": \"Computers, laptops, servers and other IT devices\", \"sub_categories\": [{\"id\": \"c9e3497f-db73-4c9b-bd6d-0464f95a6fe6\", \"code\": \"DKT\", \"name\": \"Desktop Computer\", \"status\": \"active\"}, {\"id\": \"d42e9ad5-fd71-429a-ae01-b87e1c6e9edb\", \"code\": \"LAP\", \"name\": \"Laptop\", \"status\": \"active\"}, {\"id\": \"6ba2185f-7af2-4c2c-8193-7669c71b1633\", \"code\": \"SRV\", \"name\": \"Server\", \"status\": \"active\"}, {\"id\": \"4eca864a-86ec-420b-9fad-34221626b983\", \"code\": \"PRN\", \"name\": \"Printer\", \"status\": \"active\"}, {\"id\": \"5921958b-6b37-4aa2-8cfb-15f6ee65fcd2\", \"code\": \"SCN\", \"name\": \"Scanner\", \"status\": \"active\"}, {\"id\": \"2f8e2c02-5d38-4b23-8dba-f369941c20d9\", \"code\": \"UPS\", \"name\": \"UPS\", \"status\": \"active\"}, {\"id\": \"ae89a32c-2d70-412f-b124-07d85dc22db8\", \"code\": \"PRJ\", \"name\": \"Projector\", \"status\": \"active\"}, {\"id\": \"a60c22f3-dd12-4725-a988-9d1329d3bcb3\", \"code\": \"NSW\", \"name\": \"Network Switch\", \"status\": \"active\"}, {\"id\": \"13668c08-ca57-4a22-8186-b5625aa49170\", \"code\": \"WFR\", \"name\": \"Wi-Fi Router\", \"status\": \"active\"}, {\"id\": \"773db5ec-0bc6-4f3f-9447-976e57d30613\", \"code\": \"CTV\", \"name\": \"CCTV Camera\", \"status\": \"active\"}], \"depreciation_rate\": \"33.33\"}', '{\"id\": 1, \"code\": \"IT\", \"icon\": \"fas fa-laptop\", \"name\": \"IT Equipment\", \"status\": \"active\", \"created_at\": \"2026-06-08T11:13:12.000000Z\", \"created_by\": null, \"deleted_at\": null, \"updated_at\": \"2026-06-09T08:14:17.000000Z\", \"updated_by\": 1, \"description\": \"Computers, laptops, servers and other IT devices\", \"sub_categories\": [{\"id\": \"c9e3497f-db73-4c9b-bd6d-0464f95a6fe6\", \"code\": \"DKT\", \"name\": \"Desktop Computer\", \"status\": \"active\"}, {\"id\": \"d42e9ad5-fd71-429a-ae01-b87e1c6e9edb\", \"code\": \"LAP\", \"name\": \"Laptop\", \"status\": \"active\"}, {\"id\": \"6ba2185f-7af2-4c2c-8193-7669c71b1633\", \"code\": \"SRV\", \"name\": \"Server\", \"status\": \"active\"}, {\"id\": \"4eca864a-86ec-420b-9fad-34221626b983\", \"code\": \"PRN\", \"name\": \"Printer\", \"status\": \"active\"}, {\"id\": \"5921958b-6b37-4aa2-8cfb-15f6ee65fcd2\", \"code\": \"SCN\", \"name\": \"Scanner\", \"status\": \"active\"}, {\"id\": \"2f8e2c02-5d38-4b23-8dba-f369941c20d9\", \"code\": \"UPS\", \"name\": \"UPS\", \"status\": \"active\"}, {\"id\": \"ae89a32c-2d70-412f-b124-07d85dc22db8\", \"code\": \"PRJ\", \"name\": \"Projector\", \"status\": \"active\"}, {\"id\": \"a60c22f3-dd12-4725-a988-9d1329d3bcb3\", \"code\": \"NSW\", \"name\": \"Network Switch\", \"status\": \"active\"}, {\"id\": \"13668c08-ca57-4a22-8186-b5625aa49170\", \"code\": \"WFR\", \"name\": \"Wi-Fi Router\", \"status\": \"active\"}, {\"id\": \"773db5ec-0bc6-4f3f-9447-976e57d30613\", \"code\": \"CTV\", \"name\": \"CCTV Camera\", \"status\": \"active\"}, {\"id\": \"1780992855618\", \"code\": \"MNT\", \"name\": \"Monitor\", \"status\": \"active\", \"description\": \"\"}], \"depreciation_rate\": \"33.33\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-09 02:44:17'),
(22, 1, 'Super Administrator', 'updated', 'categories', 'App\\Models\\AssetCategory', 3, 'Electrical Equipment', '{\"id\": 3, \"code\": \"ELE\", \"icon\": \"fas fa-plug\", \"name\": \"Electrical Equipment\", \"status\": \"active\", \"created_at\": \"2026-06-08T11:13:12.000000Z\", \"created_by\": null, \"deleted_at\": null, \"updated_at\": \"2026-06-08T11:13:12.000000Z\", \"updated_by\": null, \"description\": \"Air conditioners, fans and electrical appliances\", \"sub_categories\": [{\"id\": \"492940f8-3751-4a7f-8615-f4d05f6bc230\", \"code\": \"ACU\", \"name\": \"Air Conditioner\", \"status\": \"active\"}, {\"id\": \"82947680-c753-4eff-b705-e4b59b940b0e\", \"code\": \"CFN\", \"name\": \"Ceiling Fan\", \"status\": \"active\"}, {\"id\": \"58db0b20-7113-4e5c-b118-6561f0e28e69\", \"code\": \"RFG\", \"name\": \"Refrigerator\", \"status\": \"active\"}, {\"id\": \"f7d6508d-137e-407f-8189-762387fbb2aa\", \"code\": \"WPR\", \"name\": \"Water Purifier\", \"status\": \"active\"}, {\"id\": \"3cd25154-a9c0-49f4-8b83-9bc906c44643\", \"code\": \"ARC\", \"name\": \"Air Condition\", \"status\": \"active\"}], \"depreciation_rate\": \"15.00\"}', '{\"id\": 3, \"code\": \"ELE\", \"icon\": \"fas fa-plug\", \"name\": \"Electrical Equipment\", \"status\": \"active\", \"created_at\": \"2026-06-08T11:13:12.000000Z\", \"created_by\": null, \"deleted_at\": null, \"updated_at\": \"2026-06-09T08:17:07.000000Z\", \"updated_by\": 1, \"description\": \"Air conditioners, fans and electrical appliances\", \"sub_categories\": [{\"id\": \"492940f8-3751-4a7f-8615-f4d05f6bc230\", \"code\": \"ACU\", \"name\": \"Air Conditioner\", \"status\": \"active\"}, {\"id\": \"82947680-c753-4eff-b705-e4b59b940b0e\", \"code\": \"CFN\", \"name\": \"Ceiling Fan\", \"status\": \"active\"}, {\"id\": \"58db0b20-7113-4e5c-b118-6561f0e28e69\", \"code\": \"RFG\", \"name\": \"Refrigerator\", \"status\": \"active\"}, {\"id\": \"f7d6508d-137e-407f-8189-762387fbb2aa\", \"code\": \"WPR\", \"name\": \"Water Purifier\", \"status\": \"active\"}], \"depreciation_rate\": \"15.00\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-09 02:47:07'),
(23, 1, 'Super Administrator', 'updated', 'categories', 'App\\Models\\AssetCategory', 1, 'IT Equipment', '{\"id\": 1, \"code\": \"IT\", \"icon\": \"fas fa-laptop\", \"name\": \"IT Equipment\", \"status\": \"active\", \"created_at\": \"2026-06-08T11:13:12.000000Z\", \"created_by\": null, \"deleted_at\": null, \"updated_at\": \"2026-06-09T08:14:17.000000Z\", \"updated_by\": 1, \"description\": \"Computers, laptops, servers and other IT devices\", \"sub_categories\": [{\"id\": \"c9e3497f-db73-4c9b-bd6d-0464f95a6fe6\", \"code\": \"DKT\", \"name\": \"Desktop Computer\", \"status\": \"active\"}, {\"id\": \"d42e9ad5-fd71-429a-ae01-b87e1c6e9edb\", \"code\": \"LAP\", \"name\": \"Laptop\", \"status\": \"active\"}, {\"id\": \"6ba2185f-7af2-4c2c-8193-7669c71b1633\", \"code\": \"SRV\", \"name\": \"Server\", \"status\": \"active\"}, {\"id\": \"4eca864a-86ec-420b-9fad-34221626b983\", \"code\": \"PRN\", \"name\": \"Printer\", \"status\": \"active\"}, {\"id\": \"5921958b-6b37-4aa2-8cfb-15f6ee65fcd2\", \"code\": \"SCN\", \"name\": \"Scanner\", \"status\": \"active\"}, {\"id\": \"2f8e2c02-5d38-4b23-8dba-f369941c20d9\", \"code\": \"UPS\", \"name\": \"UPS\", \"status\": \"active\"}, {\"id\": \"ae89a32c-2d70-412f-b124-07d85dc22db8\", \"code\": \"PRJ\", \"name\": \"Projector\", \"status\": \"active\"}, {\"id\": \"a60c22f3-dd12-4725-a988-9d1329d3bcb3\", \"code\": \"NSW\", \"name\": \"Network Switch\", \"status\": \"active\"}, {\"id\": \"13668c08-ca57-4a22-8186-b5625aa49170\", \"code\": \"WFR\", \"name\": \"Wi-Fi Router\", \"status\": \"active\"}, {\"id\": \"773db5ec-0bc6-4f3f-9447-976e57d30613\", \"code\": \"CTV\", \"name\": \"CCTV Camera\", \"status\": \"active\"}, {\"id\": \"1780992855618\", \"code\": \"MNT\", \"name\": \"Monitor\", \"status\": \"active\", \"description\": \"\"}], \"depreciation_rate\": \"33.33\"}', '{\"id\": 1, \"code\": \"IT\", \"icon\": \"fas fa-laptop\", \"name\": \"IT Equipment\", \"status\": \"active\", \"created_at\": \"2026-06-08T11:13:12.000000Z\", \"created_by\": null, \"deleted_at\": null, \"updated_at\": \"2026-06-09T08:17:54.000000Z\", \"updated_by\": 1, \"description\": \"Computers, laptops, servers and other IT devices\", \"sub_categories\": [{\"id\": \"c9e3497f-db73-4c9b-bd6d-0464f95a6fe6\", \"code\": \"DKT\", \"name\": \"Desktop Computer\", \"status\": \"active\"}, {\"id\": \"d42e9ad5-fd71-429a-ae01-b87e1c6e9edb\", \"code\": \"LAP\", \"name\": \"Laptop\", \"status\": \"active\"}, {\"id\": \"6ba2185f-7af2-4c2c-8193-7669c71b1633\", \"code\": \"SRV\", \"name\": \"Server\", \"status\": \"active\"}, {\"id\": \"4eca864a-86ec-420b-9fad-34221626b983\", \"code\": \"PRN\", \"name\": \"Printer\", \"status\": \"active\"}, {\"id\": \"5921958b-6b37-4aa2-8cfb-15f6ee65fcd2\", \"code\": \"SCN\", \"name\": \"Scanner\", \"status\": \"active\"}, {\"id\": \"2f8e2c02-5d38-4b23-8dba-f369941c20d9\", \"code\": \"UPS\", \"name\": \"UPS\", \"status\": \"active\"}, {\"id\": \"ae89a32c-2d70-412f-b124-07d85dc22db8\", \"code\": \"PRJ\", \"name\": \"Projector\", \"status\": \"active\"}, {\"id\": \"a60c22f3-dd12-4725-a988-9d1329d3bcb3\", \"code\": \"NSW\", \"name\": \"Network Switch\", \"status\": \"active\"}, {\"id\": \"13668c08-ca57-4a22-8186-b5625aa49170\", \"code\": \"WFR\", \"name\": \"Wi-Fi Router\", \"status\": \"active\"}, {\"id\": \"773db5ec-0bc6-4f3f-9447-976e57d30613\", \"code\": \"CTV\", \"name\": \"CCTV Camera\", \"status\": \"active\"}, {\"id\": \"1780992855618\", \"code\": \"MNT\", \"name\": \"Monitor\", \"status\": \"active\", \"description\": \"\"}, {\"id\": \"1780993050658\", \"code\": \"OPS\", \"name\": \"OPS\", \"status\": \"active\", \"description\": \"\"}, {\"id\": \"1780993072826\", \"code\": \"SMART TV\", \"name\": \"Smart TV\", \"status\": \"active\", \"description\": \"\"}], \"depreciation_rate\": \"33.33\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-09 02:47:54'),
(24, 1, 'Super Administrator', 'created', 'vendors', 'App\\Models\\Vendor', 1, 'Brihaspathi Technologies Pvt. Ltd.', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-09 02:51:38'),
(25, 108, 'Atikur Rahman', 'login', 'auth', NULL, NULL, NULL, NULL, NULL, '10.177.132.242', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Logged in from IP: 10.177.132.242', '2026-06-09 03:49:56'),
(26, 1, 'Super Administrator', 'created', 'users', 'App\\Models\\User', 109, 'Suraj Chanda', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-09 03:57:18'),
(27, 1, 'Super Administrator', 'logout', 'auth', NULL, NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-09 03:57:49'),
(28, 74, 'Suraj Chanda', 'login', 'auth', NULL, NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Logged in from IP: ::1', '2026-06-09 03:57:54'),
(29, 74, 'Suraj Chanda', 'logout', 'auth', NULL, NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-09 03:58:14'),
(30, 1, 'Super Administrator', 'login', 'auth', NULL, NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Logged in from IP: ::1', '2026-06-09 03:58:26'),
(31, 1, 'Super Administrator', 'deleted', 'users', 'App\\Models\\User', 109, 'Suraj Chanda', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-09 03:58:45'),
(32, 1, 'Super Administrator', 'updated', 'users', 'App\\Models\\User', 74, 'Suraj Chanda', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-09 03:59:07'),
(33, 1, 'Super Administrator', 'logout', 'auth', NULL, NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-09 03:59:12'),
(34, 74, 'Suraj Chanda', 'login', 'auth', NULL, NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Logged in from IP: ::1', '2026-06-09 03:59:17'),
(35, 1, 'Super Administrator', 'login', 'auth', NULL, NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', 'Logged in from IP: ::1', '2026-06-09 03:59:43'),
(36, 1, 'Super Administrator', 'updated', 'roles', 'App\\Models\\Role', 4, 'author', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', 'Permissions updated for role: author', '2026-06-09 04:00:02'),
(37, 74, 'Suraj Chanda', 'logout', 'auth', NULL, NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-09 04:00:28'),
(38, 74, 'Suraj Chanda', 'login', 'auth', NULL, NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Logged in from IP: ::1', '2026-06-09 04:00:34'),
(39, 1, 'Super Administrator', 'updated', 'users', 'App\\Models\\User', 74, 'Suraj Chanda', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', NULL, '2026-06-09 04:00:59'),
(40, 1, 'Super Administrator', 'updated', 'users', 'App\\Models\\User', 74, 'Suraj Chanda', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', NULL, '2026-06-09 04:01:11'),
(41, 1, 'Super Administrator', 'updated', 'users', 'App\\Models\\User', 74, 'Suraj Chanda', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', NULL, '2026-06-09 04:01:23'),
(42, 74, 'Suraj Chanda', 'logout', 'auth', NULL, NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-09 04:01:55'),
(43, 74, 'Suraj Chanda', 'login', 'auth', NULL, NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Logged in from IP: ::1', '2026-06-09 04:02:00'),
(44, 1, 'Super Administrator', 'updated', 'roles', 'App\\Models\\Role', 2, 'admin', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', 'Permissions updated for role: admin', '2026-06-09 04:03:53'),
(45, 74, 'Suraj Chanda', 'created', 'departments', 'App\\Models\\Department', 2, 'e-Governance', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-09 04:05:57'),
(46, 74, 'Suraj Chanda', 'updated', 'users', 'App\\Models\\User', 74, 'Suraj Chanda', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-09 04:06:13'),
(47, 1, 'Super Administrator', 'logout', 'auth', NULL, NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', NULL, '2026-06-09 04:07:36'),
(48, 74, 'Suraj Chanda', 'logout', 'auth', NULL, NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-09 04:15:30'),
(49, 74, 'Suraj Chanda', 'login', 'auth', NULL, NULL, NULL, NULL, NULL, '10.177.132.233', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Logged in from IP: 10.177.132.233', '2026-06-09 05:01:23'),
(50, 1, 'Super Administrator', 'login', 'auth', NULL, NULL, NULL, NULL, NULL, '10.177.132.243', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Logged in from IP: 10.177.132.243', '2026-06-09 05:02:27'),
(51, 74, 'Suraj Chanda', 'login', 'auth', NULL, NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', 'Logged in from IP: ::1', '2026-06-09 05:03:23'),
(52, 1, 'Super Administrator', 'updated', 'users', 'App\\Models\\User', 74, 'Suraj Chanda', NULL, NULL, '10.177.132.243', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-09 05:03:53'),
(53, 74, 'Suraj Chanda', 'assigned', 'assets', 'App\\Models\\Asset', 31, 'GOV-IT-2022-0030', NULL, NULL, '10.177.132.233', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Handover form: HO-202606-0001', '2026-06-09 05:04:41'),
(54, 74, 'Suraj Chanda', 'assigned', 'assets', 'App\\Models\\Asset', 106, 'GOV-IT-2022-0105', NULL, NULL, '10.177.132.233', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Handover form: HO-202606-0002', '2026-06-09 05:06:35'),
(55, 1, 'Super Administrator', 'logout', 'auth', NULL, NULL, NULL, NULL, NULL, '10.177.132.243', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-09 05:10:36'),
(56, 1, 'Super Administrator', 'login', 'auth', NULL, NULL, NULL, NULL, NULL, '10.177.132.243', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Logged in from IP: 10.177.132.243', '2026-06-09 05:11:11'),
(57, 1, 'Super Administrator', 'updated', 'users', 'App\\Models\\User', 56, 'Rituraj Borgohain', NULL, NULL, '10.177.132.243', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-09 05:12:00'),
(58, 74, 'Suraj Chanda', 'logout', 'auth', NULL, NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', NULL, '2026-06-09 05:12:07'),
(59, 56, 'Rituraj Borgohain', 'login', 'auth', NULL, NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', 'Logged in from IP: ::1', '2026-06-09 05:12:13'),
(60, 74, 'Suraj Chanda', 'created', 'departments', 'App\\Models\\Department', 3, 'Development', NULL, NULL, '10.177.132.233', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, '2026-06-09 05:12:49'),
(61, 1, 'Super Administrator', 'updated', 'roles', 'App\\Models\\Role', 2, 'admin', NULL, NULL, '10.177.132.243', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Permissions updated for role: admin', '2026-06-09 05:12:59'),
(62, 1, 'Super Administrator', 'updated', 'roles', 'App\\Models\\Role', 2, 'admin', NULL, NULL, '10.177.132.243', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Permissions updated for role: admin', '2026-06-09 05:13:09'),
(63, 74, 'Suraj Chanda', 'updated', 'departments', 'App\\Models\\Department', 3, 'Development', '{\"id\": 3, \"city\": \"Golaghat\", \"code\": null, \"name\": \"Development\", \"block\": null, \"email\": null, \"floor\": null, \"notes\": null, \"phone\": null, \"state\": \"Assam\", \"status\": \"active\", \"address\": null, \"pincode\": \"785621\", \"room_no\": null, \"building\": null, \"parent_id\": null, \"created_at\": \"2026-06-09T10:42:49.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-09T10:42:49.000000Z\", \"head_user_id\": null}', '{\"id\": 3, \"city\": \"Golaghat\", \"code\": null, \"name\": \"Development\", \"block\": null, \"email\": null, \"floor\": \"Second Floor\", \"notes\": null, \"phone\": null, \"state\": \"Assam\", \"status\": \"active\", \"address\": null, \"pincode\": \"785621\", \"room_no\": \"B-5\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T10:42:49.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-09T10:46:23.000000Z\", \"head_user_id\": null}', '10.177.132.233', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, '2026-06-09 05:16:23'),
(64, 74, 'Suraj Chanda', 'updated', 'departments', 'App\\Models\\Department', 1, 'Nazarat', '{\"id\": 1, \"city\": null, \"code\": \"NAZ\", \"name\": \"Nazarat\", \"block\": null, \"email\": null, \"floor\": \"Second Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": null, \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-08T11:13:11.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-08T12:56:30.000000Z\", \"head_user_id\": null}', '{\"id\": 1, \"city\": null, \"code\": \"NAZ\", \"name\": \"Nazarat\", \"block\": null, \"email\": null, \"floor\": \"Second Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": \"B-3\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-08T11:13:11.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-09T10:46:40.000000Z\", \"head_user_id\": null}', '10.177.132.233', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, '2026-06-09 05:16:40'),
(65, 74, 'Suraj Chanda', 'updated', 'departments', 'App\\Models\\Department', 2, 'e-Governance', '{\"id\": 2, \"city\": null, \"code\": null, \"name\": \"e-Governance\", \"block\": null, \"email\": null, \"floor\": null, \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": null, \"building\": null, \"parent_id\": null, \"created_at\": \"2026-06-09T09:35:57.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-09T09:35:57.000000Z\", \"head_user_id\": null}', '{\"id\": 2, \"city\": null, \"code\": null, \"name\": \"e-Governance\", \"block\": null, \"email\": null, \"floor\": \"Second Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": null, \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T09:35:57.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-09T10:48:38.000000Z\", \"head_user_id\": null}', '10.177.132.233', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, '2026-06-09 05:18:38'),
(66, 1, 'Super Administrator', 'updated', 'users', 'App\\Models\\User', 56, 'Rituraj Borgohain', NULL, NULL, '10.177.132.243', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-09 05:18:50'),
(67, 74, 'Suraj Chanda', 'created', 'departments', 'App\\Models\\Department', 4, 'PFC', NULL, NULL, '10.177.132.233', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, '2026-06-09 05:19:46'),
(68, 74, 'Suraj Chanda', 'created', 'departments', 'App\\Models\\Department', 5, 'Personnel', NULL, NULL, '10.177.132.233', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, '2026-06-09 05:20:30'),
(69, 74, 'Suraj Chanda', 'created', 'departments', 'App\\Models\\Department', 6, 'Administration', NULL, NULL, '10.177.132.233', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, '2026-06-09 05:21:16'),
(70, 74, 'Suraj Chanda', 'created', 'departments', 'App\\Models\\Department', 7, 'Sub Registrar', NULL, NULL, '10.177.132.233', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, '2026-06-09 05:24:23'),
(71, 74, 'Suraj Chanda', 'created', 'departments', 'App\\Models\\Department', 8, 'FPD & CA', NULL, NULL, '10.177.132.233', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, '2026-06-09 05:24:48'),
(72, 74, 'Suraj Chanda', 'created', 'departments', 'App\\Models\\Department', 9, 'DCP Branch', NULL, NULL, '10.177.132.233', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, '2026-06-09 05:30:12'),
(73, 74, 'Suraj Chanda', 'created', 'departments', 'App\\Models\\Department', 10, 'Magistracy Branch', NULL, NULL, '10.177.132.233', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, '2026-06-09 05:30:43'),
(74, 74, 'Suraj Chanda', 'created', 'departments', 'App\\Models\\Department', 11, 'Census/ Bakijai', NULL, NULL, '10.177.132.233', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, '2026-06-09 05:31:12'),
(75, 74, 'Suraj Chanda', 'created', 'departments', 'App\\Models\\Department', 12, 'Election', NULL, NULL, '10.177.132.233', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, '2026-06-09 05:31:38'),
(76, 74, 'Suraj Chanda', 'created', 'departments', 'App\\Models\\Department', 13, 'DDMA', NULL, NULL, '10.177.132.233', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, '2026-06-09 05:31:58'),
(77, 74, 'Suraj Chanda', 'created', 'departments', 'App\\Models\\Department', 14, 'PA to DC', NULL, NULL, '10.177.132.233', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, '2026-06-09 05:35:46'),
(78, 74, 'Suraj Chanda', 'created', 'departments', 'App\\Models\\Department', 15, 'Excise', NULL, NULL, '10.177.132.233', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, '2026-06-09 05:37:08'),
(79, 74, 'Suraj Chanda', 'created', 'departments', 'App\\Models\\Department', 16, 'Registrar Kanungo Branch (RKG)', NULL, NULL, '10.177.132.233', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, '2026-06-09 05:37:52'),
(80, 74, 'Suraj Chanda', 'created', 'departments', 'App\\Models\\Department', 17, 'Revenue Branch', NULL, NULL, '10.177.132.233', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, '2026-06-09 05:38:23'),
(81, 74, 'Suraj Chanda', 'created', 'departments', 'App\\Models\\Department', 18, 'Land Acquisition Branch', NULL, NULL, '10.177.132.233', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, '2026-06-09 05:38:58'),
(82, 74, 'Suraj Chanda', 'created', 'departments', 'App\\Models\\Department', 19, 'NRC', NULL, NULL, '10.177.132.233', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, '2026-06-09 05:39:15'),
(83, 74, 'Suraj Chanda', 'created', 'departments', 'App\\Models\\Department', 20, 'NIC', NULL, NULL, '10.177.132.233', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', NULL, '2026-06-09 05:40:40'),
(84, 1, 'Super Administrator', 'updated', 'roles', 'App\\Models\\Role', 2, 'admin', NULL, NULL, '10.177.132.243', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Permissions updated for role: admin', '2026-06-09 06:38:06'),
(85, 1, 'Super Administrator', 'updated', 'users', 'App\\Models\\User', 74, 'Suraj Chanda', NULL, NULL, '10.177.132.243', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-09 06:38:57'),
(86, 1, 'Super Administrator', 'updated', 'roles', 'App\\Models\\Role', 3, 'IT admin', NULL, NULL, '10.177.132.243', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Permissions updated for role: IT admin', '2026-06-09 06:39:30'),
(87, 1, 'Super Administrator', 'updated', 'roles', 'App\\Models\\Role', 4, 'author', NULL, NULL, '10.177.132.243', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Permissions updated for role: author', '2026-06-09 06:40:01'),
(88, 1, 'Super Administrator', 'updated', 'roles', 'App\\Models\\Role', 3, 'IT admin', NULL, NULL, '10.177.132.243', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Permissions updated for role: IT admin', '2026-06-09 07:08:19'),
(89, 1, 'Super Administrator', 'updated', 'users', 'App\\Models\\User', 74, 'Suraj Chanda', NULL, NULL, '10.177.132.243', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-09 07:08:31'),
(90, 56, 'Rituraj Borgohain', 'logout', 'auth', NULL, NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', NULL, '2026-06-09 07:08:49'),
(91, 74, 'Suraj Chanda', 'login', 'auth', NULL, NULL, NULL, NULL, NULL, '10.177.132.243', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', 'Logged in from IP: 10.177.132.243', '2026-06-09 07:09:09'),
(92, 74, 'Suraj Chanda', 'logout', 'auth', NULL, NULL, NULL, NULL, NULL, '10.177.132.243', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', NULL, '2026-06-09 07:11:16'),
(93, 1, 'Super Administrator', 'updated', 'users', 'App\\Models\\User', 107, 'Pankaj Medhi', NULL, NULL, '10.177.132.243', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-09 07:12:37'),
(94, 1, 'Super Administrator', 'updated', 'users', 'App\\Models\\User', 56, 'Rituraj Borgohain', NULL, NULL, '10.177.132.243', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-09 07:14:05'),
(95, 1, 'Super Administrator', 'logout', 'auth', NULL, NULL, NULL, NULL, NULL, '10.177.132.243', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-09 07:15:16'),
(96, 1, 'Super Administrator', 'login', 'auth', NULL, NULL, NULL, NULL, NULL, '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Logged in from IP: 10.177.132.59', '2026-06-09 23:24:17'),
(97, 1, 'Super Administrator', 'login', 'auth', NULL, NULL, NULL, NULL, NULL, '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'Logged in from IP: 10.177.132.59', '2026-06-10 05:14:57'),
(98, 1, 'Super Administrator', 'updated', 'departments', 'App\\Models\\Department', 2, 'e-Governance', '{\"id\": 2, \"city\": null, \"code\": null, \"name\": \"e-Governance\", \"block\": null, \"email\": null, \"floor\": \"Second Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": null, \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T09:35:57.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-09T10:48:38.000000Z\", \"head_user_id\": null}', '{\"id\": 2, \"city\": null, \"code\": \"EGOV\", \"name\": \"e-Governance\", \"block\": null, \"email\": null, \"floor\": \"Second Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": null, \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T09:35:57.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-10T10:46:23.000000Z\", \"head_user_id\": null}', '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-10 05:16:23'),
(99, 1, 'Super Administrator', 'updated', 'departments', 'App\\Models\\Department', 3, 'Development', '{\"id\": 3, \"city\": \"Golaghat\", \"code\": null, \"name\": \"Development\", \"block\": null, \"email\": null, \"floor\": \"Second Floor\", \"notes\": null, \"phone\": null, \"state\": \"Assam\", \"status\": \"active\", \"address\": null, \"pincode\": \"785621\", \"room_no\": \"B-5\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T10:42:49.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-09T10:46:23.000000Z\", \"head_user_id\": null}', '{\"id\": 3, \"city\": \"Golaghat\", \"code\": \"DEV\", \"name\": \"Development\", \"block\": null, \"email\": null, \"floor\": \"Second Floor\", \"notes\": null, \"phone\": null, \"state\": \"Assam\", \"status\": \"active\", \"address\": null, \"pincode\": \"785621\", \"room_no\": \"B-5\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T10:42:49.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-10T10:46:30.000000Z\", \"head_user_id\": null}', '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-10 05:16:30'),
(100, 1, 'Super Administrator', 'updated', 'departments', 'App\\Models\\Department', 4, 'PFC', '{\"id\": 4, \"city\": \"Golaghat\", \"code\": null, \"name\": \"PFC\", \"block\": null, \"email\": null, \"floor\": \"First Floor\", \"notes\": null, \"phone\": null, \"state\": \"ASSAM\", \"status\": \"active\", \"address\": null, \"pincode\": \"785621\", \"room_no\": null, \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T10:49:46.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-09T10:49:46.000000Z\", \"head_user_id\": null}', '{\"id\": 4, \"city\": \"Golaghat\", \"code\": \"PFC\", \"name\": \"PFC\", \"block\": null, \"email\": null, \"floor\": \"First Floor\", \"notes\": null, \"phone\": null, \"state\": \"ASSAM\", \"status\": \"active\", \"address\": null, \"pincode\": \"785621\", \"room_no\": null, \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T10:49:46.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-10T10:46:40.000000Z\", \"head_user_id\": null}', '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-10 05:16:40'),
(101, 1, 'Super Administrator', 'updated', 'departments', 'App\\Models\\Department', 5, 'Personnel', '{\"id\": 5, \"city\": null, \"code\": null, \"name\": \"Personnel\", \"block\": null, \"email\": null, \"floor\": \"First Floor\", \"notes\": null, \"phone\": null, \"state\": \"ASSAM\", \"status\": \"active\", \"address\": null, \"pincode\": \"785621\", \"room_no\": null, \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T10:50:30.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-09T10:50:30.000000Z\", \"head_user_id\": null}', '{\"id\": 5, \"city\": null, \"code\": \"PER\", \"name\": \"Personnel\", \"block\": null, \"email\": null, \"floor\": \"First Floor\", \"notes\": null, \"phone\": null, \"state\": \"ASSAM\", \"status\": \"active\", \"address\": null, \"pincode\": \"785621\", \"room_no\": null, \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T10:50:30.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-10T10:46:47.000000Z\", \"head_user_id\": null}', '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-10 05:16:47'),
(102, 1, 'Super Administrator', 'updated', 'departments', 'App\\Models\\Department', 6, 'Administration', '{\"id\": 6, \"city\": \"Golaghat\", \"code\": null, \"name\": \"Administration\", \"block\": null, \"email\": null, \"floor\": \"Second Floor\", \"notes\": null, \"phone\": null, \"state\": \"ASSAM\", \"status\": \"active\", \"address\": null, \"pincode\": \"785621\", \"room_no\": null, \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T10:51:16.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-09T10:51:16.000000Z\", \"head_user_id\": null}', '{\"id\": 6, \"city\": \"Golaghat\", \"code\": \"ADM\", \"name\": \"Administration\", \"block\": null, \"email\": null, \"floor\": \"Second Floor\", \"notes\": null, \"phone\": null, \"state\": \"ASSAM\", \"status\": \"active\", \"address\": null, \"pincode\": \"785621\", \"room_no\": null, \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T10:51:16.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-10T10:46:54.000000Z\", \"head_user_id\": null}', '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-10 05:16:54'),
(103, 1, 'Super Administrator', 'updated', 'departments', 'App\\Models\\Department', 7, 'Sub Registrar', '{\"id\": 7, \"city\": null, \"code\": null, \"name\": \"Sub Registrar\", \"block\": null, \"email\": null, \"floor\": \"First Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": \"A-1\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T10:54:23.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-09T10:54:23.000000Z\", \"head_user_id\": null}', '{\"id\": 7, \"city\": null, \"code\": \"SUR\", \"name\": \"Sub Registrar\", \"block\": null, \"email\": null, \"floor\": \"First Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": \"A-1\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T10:54:23.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-10T10:47:01.000000Z\", \"head_user_id\": null}', '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-10 05:17:01'),
(104, 1, 'Super Administrator', 'updated', 'departments', 'App\\Models\\Department', 8, 'FPD & CA', '{\"id\": 8, \"city\": null, \"code\": null, \"name\": \"FPD & CA\", \"block\": null, \"email\": null, \"floor\": \"First Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": \"A-5\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T10:54:48.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-09T10:54:48.000000Z\", \"head_user_id\": null}', '{\"id\": 8, \"city\": null, \"code\": \"FDC\", \"name\": \"FPD & CA\", \"block\": null, \"email\": null, \"floor\": \"First Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": \"A-5\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T10:54:48.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-10T10:47:14.000000Z\", \"head_user_id\": null}', '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-10 05:17:14'),
(105, 1, 'Super Administrator', 'updated', 'departments', 'App\\Models\\Department', 9, 'DCP Branch', '{\"id\": 9, \"city\": null, \"code\": null, \"name\": \"DCP Branch\", \"block\": null, \"email\": null, \"floor\": \"Second Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": \"B-1/B-2\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T11:00:12.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-09T11:00:12.000000Z\", \"head_user_id\": null}', '{\"id\": 9, \"city\": null, \"code\": \"DCP\", \"name\": \"DCP Branch\", \"block\": null, \"email\": null, \"floor\": \"Second Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": \"B-1/B-2\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T11:00:12.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-10T10:47:23.000000Z\", \"head_user_id\": null}', '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-10 05:17:23'),
(106, 1, 'Super Administrator', 'updated', 'departments', 'App\\Models\\Department', 10, 'Magistracy Branch', '{\"id\": 10, \"city\": null, \"code\": null, \"name\": \"Magistracy Branch\", \"block\": null, \"email\": null, \"floor\": \"Second Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": \"B-7\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T11:00:43.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-09T11:00:43.000000Z\", \"head_user_id\": null}', '{\"id\": 10, \"city\": null, \"code\": \"MAG\", \"name\": \"Magistracy Branch\", \"block\": null, \"email\": null, \"floor\": \"Second Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": \"B-7\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T11:00:43.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-10T10:47:29.000000Z\", \"head_user_id\": null}', '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-10 05:17:29');
INSERT INTO `activity_logs` (`id`, `user_id`, `user_name`, `action`, `module`, `subject_type`, `subject_id`, `subject_label`, `old_values`, `new_values`, `ip_address`, `user_agent`, `description`, `created_at`) VALUES
(107, 1, 'Super Administrator', 'updated', 'departments', 'App\\Models\\Department', 11, 'Census/ Bakijai', '{\"id\": 11, \"city\": null, \"code\": null, \"name\": \"Census/ Bakijai\", \"block\": null, \"email\": null, \"floor\": \"Second Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": \"B-8\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T11:01:12.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-09T11:01:12.000000Z\", \"head_user_id\": null}', '{\"id\": 11, \"city\": null, \"code\": \"BAK\", \"name\": \"Census/ Bakijai\", \"block\": null, \"email\": null, \"floor\": \"Second Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": \"B-8\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T11:01:12.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-10T10:47:36.000000Z\", \"head_user_id\": null}', '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-10 05:17:36'),
(108, 1, 'Super Administrator', 'updated', 'departments', 'App\\Models\\Department', 12, 'Election', '{\"id\": 12, \"city\": null, \"code\": null, \"name\": \"Election\", \"block\": null, \"email\": null, \"floor\": \"Second Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": \"B-11\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T11:01:38.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-09T11:01:38.000000Z\", \"head_user_id\": null}', '{\"id\": 12, \"city\": null, \"code\": \"ELE\", \"name\": \"Election\", \"block\": null, \"email\": null, \"floor\": \"Second Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": \"B-11\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T11:01:38.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-10T10:47:44.000000Z\", \"head_user_id\": null}', '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-10 05:17:44'),
(109, 1, 'Super Administrator', 'updated', 'departments', 'App\\Models\\Department', 13, 'DDMA', '{\"id\": 13, \"city\": null, \"code\": null, \"name\": \"DDMA\", \"block\": null, \"email\": null, \"floor\": \"Second Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": \"B-13\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T11:01:58.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-09T11:01:58.000000Z\", \"head_user_id\": null}', '{\"id\": 13, \"city\": null, \"code\": \"DDM\", \"name\": \"DDMA\", \"block\": null, \"email\": null, \"floor\": \"Second Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": \"B-13\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T11:01:58.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-10T10:47:51.000000Z\", \"head_user_id\": null}', '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-10 05:17:51'),
(110, 1, 'Super Administrator', 'updated', 'departments', 'App\\Models\\Department', 14, 'PA to DC', '{\"id\": 14, \"city\": null, \"code\": null, \"name\": \"PA to DC\", \"block\": null, \"email\": null, \"floor\": \"Third Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": \"C-2\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T11:05:46.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-09T11:05:46.000000Z\", \"head_user_id\": null}', '{\"id\": 14, \"city\": null, \"code\": \"PAD\", \"name\": \"PA to DC\", \"block\": null, \"email\": null, \"floor\": \"Third Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": \"C-2\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T11:05:46.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-10T10:47:59.000000Z\", \"head_user_id\": null}', '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-10 05:17:59'),
(111, 1, 'Super Administrator', 'updated', 'departments', 'App\\Models\\Department', 15, 'Excise', '{\"id\": 15, \"city\": null, \"code\": null, \"name\": \"Excise\", \"block\": null, \"email\": null, \"floor\": \"Fourt Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": \"D-3\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T11:07:08.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-09T11:07:08.000000Z\", \"head_user_id\": null}', '{\"id\": 15, \"city\": null, \"code\": \"EXC\", \"name\": \"Excise\", \"block\": null, \"email\": null, \"floor\": \"Fourt Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": \"D-3\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T11:07:08.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-10T10:48:07.000000Z\", \"head_user_id\": null}', '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-10 05:18:07'),
(112, 1, 'Super Administrator', 'updated', 'departments', 'App\\Models\\Department', 16, 'Registrar Kanungo Branch (RKG)', '{\"id\": 16, \"city\": null, \"code\": null, \"name\": \"Registrar Kanungo Branch (RKG)\", \"block\": null, \"email\": null, \"floor\": \"Fourt Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": \"D-4\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T11:07:52.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-09T11:07:52.000000Z\", \"head_user_id\": null}', '{\"id\": 16, \"city\": null, \"code\": \"RKG\", \"name\": \"Registrar Kanungo Branch (RKG)\", \"block\": null, \"email\": null, \"floor\": \"Fourt Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": \"D-4\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T11:07:52.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-10T10:48:15.000000Z\", \"head_user_id\": null}', '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-10 05:18:15'),
(113, 1, 'Super Administrator', 'updated', 'departments', 'App\\Models\\Department', 17, 'Revenue Branch', '{\"id\": 17, \"city\": null, \"code\": null, \"name\": \"Revenue Branch\", \"block\": null, \"email\": null, \"floor\": \"Fourt Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": \"D-6/7\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T11:08:23.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-09T11:08:23.000000Z\", \"head_user_id\": null}', '{\"id\": 17, \"city\": null, \"code\": \"REV\", \"name\": \"Revenue Branch\", \"block\": null, \"email\": null, \"floor\": \"Fourt Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": \"D-6/7\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T11:08:23.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-10T10:48:21.000000Z\", \"head_user_id\": null}', '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-10 05:18:21'),
(114, 1, 'Super Administrator', 'updated', 'departments', 'App\\Models\\Department', 18, 'Land Acquisition Branch', '{\"id\": 18, \"city\": null, \"code\": null, \"name\": \"Land Acquisition Branch\", \"block\": null, \"email\": null, \"floor\": \"Fourt Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": \"D-10\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T11:08:58.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-09T11:08:58.000000Z\", \"head_user_id\": null}', '{\"id\": 18, \"city\": null, \"code\": \"LA\", \"name\": \"Land Acquisition Branch\", \"block\": null, \"email\": null, \"floor\": \"Fourt Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": \"D-10\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T11:08:58.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-10T10:48:28.000000Z\", \"head_user_id\": null}', '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-10 05:18:28'),
(115, 1, 'Super Administrator', 'updated', 'departments', 'App\\Models\\Department', 14, 'PA to DC', '{\"id\": 14, \"city\": null, \"code\": \"PAD\", \"name\": \"PA to DC\", \"block\": null, \"email\": null, \"floor\": \"Third Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": \"C-2\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T11:05:46.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-10T10:47:59.000000Z\", \"head_user_id\": null}', '{\"id\": 14, \"city\": null, \"code\": \"PA\", \"name\": \"PA to DC\", \"block\": null, \"email\": null, \"floor\": \"Third Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": \"C-2\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T11:05:46.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-10T10:48:35.000000Z\", \"head_user_id\": null}', '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-10 05:18:35'),
(116, 1, 'Super Administrator', 'updated', 'departments', 'App\\Models\\Department', 19, 'NRC', '{\"id\": 19, \"city\": null, \"code\": null, \"name\": \"NRC\", \"block\": null, \"email\": null, \"floor\": \"Fourt Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": \"D-13\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T11:09:15.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-09T11:09:15.000000Z\", \"head_user_id\": null}', '{\"id\": 19, \"city\": null, \"code\": \"NRC\", \"name\": \"NRC\", \"block\": null, \"email\": null, \"floor\": \"Fourt Floor\", \"notes\": null, \"phone\": null, \"state\": null, \"status\": \"active\", \"address\": null, \"pincode\": null, \"room_no\": \"D-13\", \"building\": \"DC Office\", \"parent_id\": null, \"created_at\": \"2026-06-09T11:09:15.000000Z\", \"deleted_at\": null, \"updated_at\": \"2026-06-10T10:48:43.000000Z\", \"head_user_id\": null}', '10.177.132.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', NULL, '2026-06-10 05:18:43');

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

DROP TABLE IF EXISTS `assets`;
CREATE TABLE IF NOT EXISTS `assets` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `asset_tag` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Auto-generated tag based on settings format',
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asset_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Movable / Immovable / IT / Non-IT',
  `category_id` bigint UNSIGNED NOT NULL,
  `sub_category_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'UUID stored in asset_categories.sub_categories JSON',
  `sub_category_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Snapshot of sub-category name at time of entry',
  `make_brand` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_no` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `purchase_date` date DEFAULT NULL,
  `purchase_price` decimal(12,2) DEFAULT NULL,
  `warranty_expiry_date` date DEFAULT NULL,
  `under_amc` tinyint(1) NOT NULL DEFAULT '0',
  `amc_start_date` date DEFAULT NULL,
  `amc_end_date` date DEFAULT NULL,
  `amc_reference_no` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vendor_id` bigint UNSIGNED DEFAULT NULL,
  `invoice_no` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Uploaded invoice file path',
  `depreciation_rate` decimal(5,2) DEFAULT NULL COMMENT '% per annum - auto-filled from category, editable',
  `current_value` decimal(12,2) DEFAULT NULL COMMENT 'Auto-calculated based on depreciation',
  `status` enum('available','in_use','under_maintenance','disposed','lost','transferred') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `condition` enum('new','good','fair','poor','condemned') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `assigned_to_type` enum('department','employee') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Determines if asset is with a dept or employee',
  `assigned_department_id` bigint UNSIGNED DEFAULT NULL,
  `home_department_id` bigint UNSIGNED DEFAULT NULL,
  `assigned_employee_id` bigint UNSIGNED DEFAULT NULL,
  `location_building` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_block` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_floor` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_room_no` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assigned_on` date DEFAULT NULL,
  `assignment_notes` text COLLATE utf8mb4_unicode_ci,
  `disposed_on` date DEFAULT NULL,
  `disposal_method` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Auction, Scrap, Donation, Written-off',
  `disposal_value` decimal(12,2) DEFAULT NULL,
  `disposal_notes` text COLLATE utf8mb4_unicode_ci,
  `qr_code_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Path to generated QR code image',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `assets_asset_tag_unique` (`asset_tag`),
  UNIQUE KEY `assets_serial_no_unique` (`serial_no`),
  KEY `assets_vendor_id_foreign` (`vendor_id`),
  KEY `assets_created_by_foreign` (`created_by`),
  KEY `assets_updated_by_foreign` (`updated_by`),
  KEY `assets_asset_tag_index` (`asset_tag`),
  KEY `assets_status_index` (`status`),
  KEY `assets_condition_index` (`condition`),
  KEY `assets_category_id_status_index` (`category_id`,`status`),
  KEY `assets_assigned_to_type_index` (`assigned_to_type`),
  KEY `assets_assigned_department_id_status_index` (`assigned_department_id`,`status`),
  KEY `assets_assigned_employee_id_status_index` (`assigned_employee_id`,`status`),
  KEY `assets_under_amc_index` (`under_amc`),
  KEY `assets_warranty_expiry_date_index` (`warranty_expiry_date`),
  KEY `assets_home_department_id_foreign` (`home_department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=192 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `asset_tag`, `name`, `asset_type`, `category_id`, `sub_category_id`, `sub_category_name`, `make_brand`, `model`, `serial_no`, `description`, `purchase_date`, `purchase_price`, `warranty_expiry_date`, `under_amc`, `amc_start_date`, `amc_end_date`, `amc_reference_no`, `vendor_id`, `invoice_no`, `invoice_file`, `depreciation_rate`, `current_value`, `status`, `condition`, `assigned_to_type`, `assigned_department_id`, `home_department_id`, `assigned_employee_id`, `location_building`, `location_block`, `location_floor`, `location_room_no`, `assigned_on`, `assignment_notes`, `disposed_on`, `disposal_method`, `disposal_value`, `disposal_notes`, `qr_code_path`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'GOV-IT-2022-0001', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2190C1N', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 57, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(2, 'GOV-IT-2022-0002', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2190C1Q', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(3, 'GOV-IT-2022-0003', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2181LN9', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(4, 'GOV-IT-2022-0004', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2181LNK', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 42, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(5, 'GOV-IT-2022-0005', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2181LNN', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(6, 'GOV-IT-2022-0006', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2181LNQ', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 46, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(7, 'GOV-IT-2022-0007', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2181LNT', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(8, 'GOV-IT-2022-0008', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2181LNZ', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(9, 'GOV-IT-2022-0009', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2181LP2', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(10, 'GOV-IT-2022-0010', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2181LPF', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(11, 'GOV-IT-2022-0011', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2181LPN', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(12, 'GOV-IT-2022-0012', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2181LPV', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(13, 'GOV-IT-2022-0013', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2181LPX', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 103, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(14, 'GOV-IT-2022-0014', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2181LRN', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 88, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(15, 'GOV-IT-2022-0015', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2181LTG', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(16, 'GOV-IT-2022-0016', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2181LVC', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(17, 'GOV-IT-2022-0017', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2181LX9', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 99, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(18, 'GOV-IT-2022-0018', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2182ZYK', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(19, 'GOV-IT-2022-0019', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2182ZZR', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(20, 'GOV-IT-2022-0020', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC218302D', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(21, 'GOV-IT-2022-0021', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2183031', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(22, 'GOV-IT-2022-0022', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC218303Z', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 64, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(23, 'GOV-IT-2022-0023', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC218304M', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(24, 'GOV-IT-2022-0024', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2183057', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(25, 'GOV-IT-2022-0025', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC218305B', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 92, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(26, 'GOV-IT-2022-0026', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC218305G', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(27, 'GOV-IT-2022-0027', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC218305P', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(28, 'GOV-IT-2022-0028', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC218305Q', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(29, 'GOV-IT-2022-0029', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC218305R', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(30, 'GOV-IT-2022-0030', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC218305T', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 81, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(31, 'GOV-IT-2022-0031', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC218305V', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(32, 'GOV-IT-2022-0032', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2183062', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(33, 'GOV-IT-2022-0033', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC218307F', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 51, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(34, 'GOV-IT-2022-0034', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC218308F', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(35, 'GOV-IT-2022-0035', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC218308N', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(36, 'GOV-IT-2022-0036', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC218309M', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 64, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(37, 'GOV-IT-2022-0037', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC21830B5', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(38, 'GOV-IT-2022-0038', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC21830C9', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 71, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(39, 'GOV-IT-2022-0039', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC21830F0', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(40, 'GOV-IT-2022-0040', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC21830L0', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 87, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(41, 'GOV-IT-2022-0041', 'Printer', 'IT', 1, '4eca864a-86ec-420b-9fad-34221626b983', 'Printer', 'HP', 'Laser Jet M208DW', 'VNF3L07585', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'condemned', 'employee', NULL, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(42, 'GOV-IT-2022-0042', 'Printer', 'IT', 1, '4eca864a-86ec-420b-9fad-34221626b983', 'Printer', 'HP', 'Laser Jet M208DW', 'VNF3L13446', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'condemned', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(43, 'GOV-IT-2022-0043', 'Printer', 'IT', 1, '4eca864a-86ec-420b-9fad-34221626b983', 'Printer', 'HP', 'Laser Jet M208DW', 'VNF3L13974', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'condemned', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(44, 'GOV-IT-2022-0044', 'Printer', 'IT', 1, '4eca864a-86ec-420b-9fad-34221626b983', 'Printer', 'HP', 'Laser Jet M208DW', 'VNF3L14352', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'condemned', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(45, 'GOV-IT-2022-0045', 'Printer', 'IT', 1, '4eca864a-86ec-420b-9fad-34221626b983', 'Printer', 'HP', 'Laser Jet M208DW', 'VNF3L14355', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'condemned', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(46, 'GOV-IT-2022-0046', 'Printer', 'IT', 1, '4eca864a-86ec-420b-9fad-34221626b983', 'Printer', 'HP', 'Laser Jet M208DW', 'VNF3L14607', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'condemned', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(47, 'GOV-IT-2022-0047', 'Printer', 'IT', 1, '4eca864a-86ec-420b-9fad-34221626b983', 'Printer', 'HP', 'Laser Jet M208DW', 'VNF3L14633', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'condemned', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(48, 'GOV-IT-2022-0048', 'Printer', 'IT', 1, '4eca864a-86ec-420b-9fad-34221626b983', 'Printer', 'HP', 'Laser Jet M208DW', 'VNF3L17304', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'condemned', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(49, 'GOV-IT-2022-0049', 'Printer', 'IT', 1, '4eca864a-86ec-420b-9fad-34221626b983', 'Printer', 'HP', 'Laser Jet M208DW', 'VNF3L18118', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'condemned', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(50, 'GOV-IT-2022-0050', 'Printer', 'IT', 1, '4eca864a-86ec-420b-9fad-34221626b983', 'Printer', 'HP', 'Laser Jet M208DW', 'VNF3L18185', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'condemned', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(51, 'GOV-IT-2022-0051', 'Multi Functional Printer', 'IT', 1, '4eca864a-86ec-420b-9fad-34221626b983', 'Printer', 'HP', 'Laser Jet MFPM233sdw', 'VNH6H00727', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'condemned', 'employee', NULL, 1, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(52, 'GOV-IT-2022-0052', 'Multi Functional Printer', 'IT', 1, '4eca864a-86ec-420b-9fad-34221626b983', 'Printer', 'HP', 'Laser Jet MFPM233sdw', 'VNH8F00420', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'condemned', 'employee', NULL, 1, 60, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(53, 'GOV-IT-2022-0053', 'Multi Functional Printer', 'IT', 1, '4eca864a-86ec-420b-9fad-34221626b983', 'Printer', 'HP', 'Laser Jet MFPM233sdw', 'VNH8F02012', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'condemned', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(54, 'GOV-IT-2022-0054', 'OPS', 'IT', 1, '1.78099E+12', 'OPS', 'True View', 'True View True Security Systems OPS CORE i5 10 GEN ', '21IV098142', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(55, 'GOV-IT-2022-0055', '65-inch Smart TV', 'IT', 1, '1.78099E+12', 'Smart TV', 'ANDROID', 'ANDROID TV 65-INC', '05IV091172', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(56, 'GOV-IT-2022-0056', '65-inch Smart TV', 'IT', 1, '1.78099E+12', 'Smart TV', 'ANDROID', 'ANDROID TV 65-INC', '05IV091173', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(57, 'GOV-IT-2022-0057', '85-inch Smart TV', 'IT', 1, '1.78099E+12', 'Smart TV', 'ANDROID', 'ANDROID TV 85-INC', '27HV087648', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(59, 'GOV-IT-2022-0059', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372T4V', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(60, 'GOV-IT-2022-0060', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2371JPR', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(61, 'GOV-IT-2022-0061', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372T1X', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(62, 'GOV-IT-2022-0062', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372T2R', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(63, 'GOV-IT-2022-0063', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372T32', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(64, 'GOV-IT-2022-0064', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372T44', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(65, 'GOV-IT-2022-0065', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372T45', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(66, 'GOV-IT-2022-0066', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372T46', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 91, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(67, 'GOV-IT-2022-0067', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372T5C', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 38, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(68, 'GOV-IT-2022-0068', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372T5W', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(69, 'GOV-IT-2022-0069', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372T60', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(70, 'GOV-IT-2022-0070', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372T6G', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(71, 'GOV-IT-2022-0071', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372T6J', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 102, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(72, 'GOV-IT-2022-0072', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372T6M', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(73, 'GOV-IT-2022-0073', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372T71', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(74, 'GOV-IT-2022-0074', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372T76', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 97, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(75, 'GOV-IT-2022-0075', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372T7M', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(76, 'GOV-IT-2022-0076', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372T7Q', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 58, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(77, 'GOV-IT-2022-0077', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372T7T', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(78, 'GOV-IT-2022-0078', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372T82', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(79, 'GOV-IT-2022-0079', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372T8P', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(80, 'GOV-IT-2022-0080', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372T8V', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(81, 'GOV-IT-2022-0081', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372T9K', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(82, 'GOV-IT-2022-0082', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372T9W', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(83, 'GOV-IT-2022-0083', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372TB0', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(84, 'GOV-IT-2022-0084', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372TBJ', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(85, 'GOV-IT-2022-0085', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372TDW', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(86, 'GOV-IT-2022-0086', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372TFZ', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(87, 'GOV-IT-2022-0087', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372TG3', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(88, 'GOV-IT-2022-0088', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372THF', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(89, 'GOV-IT-2022-0089', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372THJ', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(90, 'GOV-IT-2022-0090', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372THK', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 79, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(91, 'GOV-IT-2022-0091', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372THL', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 60, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(92, 'GOV-IT-2022-0092', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372THM', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(93, 'GOV-IT-2022-0093', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372THN', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 61, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(94, 'GOV-IT-2022-0094', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372THQ', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 59, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(95, 'GOV-IT-2022-0095', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372THS', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 89, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(96, 'GOV-IT-2022-0096', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372THW', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 78, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(97, 'GOV-IT-2022-0097', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372THY', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(98, 'GOV-IT-2022-0098', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372TJ1', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 86, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(99, 'GOV-IT-2022-0099', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372TJ2', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(100, 'GOV-IT-2022-0100', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372TJ3', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(101, 'GOV-IT-2022-0101', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372TJ5', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(102, 'GOV-IT-2022-0102', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372TJ6', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(103, 'GOV-IT-2022-0103', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372TJC', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 77, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(104, 'GOV-IT-2022-0104', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372TJR', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(105, 'GOV-IT-2022-0105', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP24-CB1901INAIO', '8CC2372TJS', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 105, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(106, 'GOV-IT-2022-0106', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', 'HP20-C419IN', '8CC9050NW6', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(107, 'GOV-IT-2022-0107', 'Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'Dell', 'Dell Optiplex 3050', '549MZL2', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(108, 'GOV-IT-2023-0108', 'All in one Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'HP', '22-df0141in', '8CC052056D', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', 'condemned', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(109, 'GOV-IT-2023-0109', 'Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'Dell', 'Dell Inspiron', '8DBD1K3', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(110, 'GOV-IT-2023-0110', 'Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'Acer', 'Acer Veriton M6690G', 'UXVWUSI074325172C90700', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 93, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(111, 'GOV-IT-2023-0111', 'Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'Acer', 'Acer Veriton M6690G', 'UXVWUSI074325172270700', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 68, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(112, 'GOV-IT-2023-0112', 'Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'Acer', 'Acer Veriton M6690G', 'UXVWUSI074325170E20700', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 104, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(113, 'GOV-IT-2023-0113', 'Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'Acer', 'Acer Veriton M6690G', 'UXVWUSI074325172C30700', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 74, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(114, 'GOV-IT-2023-0114', 'Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'Acer', 'Acer Veriton M6690G', 'UXVWUSI074325171460700', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 76, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(115, 'GOV-IT-2023-0115', 'Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'Acer', 'Acer Veriton M6690G', 'UXVWUSI0743251729B0700', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 83, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(116, 'GOV-IT-2023-0116', 'Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'Acer', 'Acer Veriton M6690G', 'UXVWUSI074325170F30700', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(117, 'GOV-IT-2023-0117', 'Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'Acer', 'Acer Veriton M6690G', 'UXVWUSI074325171030700', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 64, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(118, 'GOV-IT-2023-0118', 'Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'Acer', 'Acer Veriton M6690G', 'UXVWUSI0743251719B0700', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 69, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(119, 'GOV-IT-2023-0119', 'Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'Acer', 'Acer Veriton M6690G', 'UXVWUSI074325172D50700', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 98, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(120, 'GOV-IT-2023-0120', 'Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'Acer', 'Acer Veriton M6690G', 'UXVWUSI074325172960700', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 49, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(121, 'GOV-IT-2023-0121', 'Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'Acer', 'Acer Veriton M6690G', 'UXVWUSI0743251727E0700', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 84, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(122, 'GOV-IT-2023-0122', 'Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'Acer', 'Acer Veriton M6690G', 'UXVWUSI074325171700700', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 100, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(123, 'GOV-IT-2023-0123', 'Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'Acer', 'Acer Veriton M6690G', 'UXVWUSI074325172FC0700', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 64, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(124, 'GOV-IT-2023-0124', 'Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'Acer', 'Acer Veriton M6690G', 'UXVWUSI0743251745B0700', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(125, 'GOV-IT-2023-0125', 'Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'Acer', 'Acer Veriton M6690G', 'UXVWUSI074325171390700', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(126, 'GOV-IT-2023-0126', 'Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'Acer', 'Acer Veriton M6690G', 'UXVWUSI074325171FA0700', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(127, 'GOV-IT-2023-0127', 'Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'Acer', 'Acer Veriton M6690G', 'UXVWUSI074325172B80700', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL);
INSERT INTO `assets` (`id`, `asset_tag`, `name`, `asset_type`, `category_id`, `sub_category_id`, `sub_category_name`, `make_brand`, `model`, `serial_no`, `description`, `purchase_date`, `purchase_price`, `warranty_expiry_date`, `under_amc`, `amc_start_date`, `amc_end_date`, `amc_reference_no`, `vendor_id`, `invoice_no`, `invoice_file`, `depreciation_rate`, `current_value`, `status`, `condition`, `assigned_to_type`, `assigned_department_id`, `home_department_id`, `assigned_employee_id`, `location_building`, `location_block`, `location_floor`, `location_room_no`, `assigned_on`, `assignment_notes`, `disposed_on`, `disposal_method`, `disposal_value`, `disposal_notes`, `qr_code_path`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(128, 'GOV-IT-2023-0128', 'Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'Acer', 'Acer Veriton M6690G', 'UXVWUSI074325171340700', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 90, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(129, 'GOV-IT-2023-0129', 'Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'Acer', 'Acer Veriton M6690G', 'UXVWUSI074325172DA0700', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 95, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(130, 'GOV-IT-2023-0130', 'Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'Acer', 'Acer Veriton M6690G', 'UXVWUSI074325172D20700', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 65, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(131, 'GOV-IT-2023-0131', 'Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'Acer', 'Acer Veriton M6690G', 'UXVWUSI0743251710D0700', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 94, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(132, 'GOV-IT-2023-0132', 'Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'Acer', 'Acer Veriton M6690G', 'UXVWUSI074325172C10700', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 67, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(133, 'GOV-IT-2023-0133', 'Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'Acer', 'Acer Veriton M6690G', 'UXVWUSI074325170FF0700', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 82, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(134, 'GOV-IT-2023-0134', 'Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'Acer', 'Acer Veriton M6690G', 'UXVWUSI0743251727D0700', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(135, 'GOV-IT-2023-0135', 'Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'Acer', 'Acer Veriton M6690G', 'UXVWUSI074325172C20700', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(136, 'GOV-IT-2023-0136', 'Monitor', 'IT', 1, '1.78099E+12', 'Monitor', 'Acer', 'Acer V247Y', 'MMTFKSS001321003512471', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 69, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(137, 'GOV-IT-2023-0137', 'Monitor', 'IT', 1, '1.78099E+12', 'Monitor', 'Acer', 'Acer V247Y', 'MMTFKSS001321003662471', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 90, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(138, 'GOV-IT-2023-0138', 'Monitor', 'IT', 1, '1.78099E+12', 'Monitor', 'Acer', 'Acer V247Y', 'MMTFKSS001321003672471', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 82, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(139, 'GOV-IT-2023-0139', 'Monitor', 'IT', 1, '1.78099E+12', 'Monitor', 'Acer', 'Acer V247Y', 'MMTFKSS001321003262471', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 76, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(140, 'GOV-IT-2023-0140', 'Monitor', 'IT', 1, '1.78099E+12', 'Monitor', 'Acer', 'Acer V247Y', 'MMTFKSS0013210034D2471', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 93, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(141, 'GOV-IT-2023-0141', 'Monitor', 'IT', 1, '1.78099E+12', 'Monitor', 'Acer', 'Acer V247Y', 'MMTFKSS001321006A32471', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 65, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(142, 'GOV-IT-2023-0142', 'Monitor', 'IT', 1, '1.78099E+12', 'Monitor', 'Acer', 'Acer V247Y', 'MMTFKSS001321006B12471', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 95, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(143, 'GOV-IT-2023-0143', 'Monitor', 'IT', 1, '1.78099E+12', 'Monitor', 'Acer', 'Acer V247Y', 'MMTFKSS001321004342471', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 49, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(144, 'GOV-IT-2023-0144', 'Monitor', 'IT', 1, '1.78099E+12', 'Monitor', 'Acer', 'Acer V247Y', 'MMTFKSS001321003412471', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(145, 'GOV-IT-2023-0145', 'Monitor', 'IT', 1, '1.78099E+12', 'Monitor', 'Acer', 'Acer V247Y', 'MMTFKSS001321006B32471', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 104, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(146, 'GOV-IT-2023-0146', 'Monitor', 'IT', 1, '1.78099E+12', 'Monitor', 'Acer', 'Acer V247Y', 'MMTFKSS001321003422471', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(147, 'GOV-IT-2023-0147', 'Monitor', 'IT', 1, '1.78099E+12', 'Monitor', 'Acer', 'Acer V247Y', 'MMTFKSS001321003392471', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 84, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(148, 'GOV-IT-2023-0148', 'Monitor', 'IT', 1, '1.78099E+12', 'Monitor', 'Acer', 'Acer V247Y', 'MMTFKSS00132100BA42471', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(149, 'GOV-IT-2023-0149', 'Monitor', 'IT', 1, '1.78099E+12', 'Monitor', 'Acer', 'Acer V247Y', 'MMTFKSS00132100B882471', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 74, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(150, 'GOV-IT-2023-0150', 'Monitor', 'IT', 1, '1.78099E+12', 'Monitor', 'Acer', 'Acer V247Y', 'MMTFKSS001321006992471', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 101, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(151, 'GOV-IT-2023-0151', 'Monitor', 'IT', 1, '1.78099E+12', 'Monitor', 'Acer', 'Acer V247Y', 'MMTFKSS00132100A242471', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 100, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(152, 'GOV-IT-2023-0152', 'Monitor', 'IT', 1, '1.78099E+12', 'Monitor', 'Acer', 'Acer V247Y', 'MMTFKSS00132100B272471', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(153, 'GOV-IT-2023-0153', 'Monitor', 'IT', 1, '1.78099E+12', 'Monitor', 'Acer', 'Acer V247Y', 'MMTFKSS001321006912471', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(154, 'GOV-IT-2023-0154', 'Monitor', 'IT', 1, '1.78099E+12', 'Monitor', 'Acer', 'Acer V247Y', 'MMTFKSS001321003522471', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 64, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(155, 'GOV-IT-2023-0155', 'Monitor', 'IT', 1, '1.78099E+12', 'Monitor', 'Acer', 'Acer V247Y', 'MMTFKSS001321003752471', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(156, 'GOV-IT-2023-0156', 'Monitor', 'IT', 1, '1.78099E+12', 'Monitor', 'Acer', 'Acer V247Y', 'MMTFKSS0013210035E2471', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 98, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(157, 'GOV-IT-2023-0157', 'Monitor', 'IT', 1, '1.78099E+12', 'Monitor', 'Acer', 'Acer V247Y', 'MMTFKSS0013210036D2471', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 96, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(158, 'GOV-IT-2023-0158', 'Monitor', 'IT', 1, '1.78099E+12', 'Monitor', 'Acer', 'Acer V247Y', 'MMTFKSS001321006932471', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 83, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(159, 'GOV-IT-2023-0159', 'Monitor', 'IT', 1, '1.78099E+12', 'Monitor', 'Acer', 'Acer V247Y', 'MMTFKSS00132100A162471', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 64, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(160, 'GOV-IT-2023-0160', 'Monitor', 'IT', 1, '1.78099E+12', 'Monitor', 'Acer', 'Acer V247Y', 'MMTFKSS0013210036A2471', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(161, 'GOV-IT-2023-0161', 'Monitor', 'IT', 1, '1.78099E+12', 'Monitor', 'Acer', 'Acer V247Y', 'MMTFKSS001321006C22471', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 67, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(162, 'GOV-IT-2023-0162', 'Monitor', 'IT', 1, '1.78099E+12', 'Monitor', 'Acer', 'Acer V247Y', 'MMTFKSS001321003312471', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 94, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(163, 'GOV-IT-2023-0163', 'Desktop', 'IT', 1, 'c9e3497f-db73-4c9b-bd6d-0464f95a6fe6', 'Desktop Computer', 'Acer', 'Acer Veriton M6690G', 'UXVWUSI074326172D80700', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 101, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(164, 'GOV-IT-2023-0164', 'UPS', 'IT', 1, '2f8e2c02-5d38-4b23-8dba-f369941c20d9', 'UPS', 'MICROTEK', 'MICROTEK LEGEND 650 VA S', '23G0U0404702050757', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 65, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(165, 'GOV-IT-2023-0165', 'UPS', 'IT', 1, '2f8e2c02-5d38-4b23-8dba-f369941c20d9', 'UPS', 'MICROTEK', 'MICROTEK LEGEND 650 VA S', '23G0U0404702050759', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(166, 'GOV-IT-2023-0166', 'UPS', 'IT', 1, '2f8e2c02-5d38-4b23-8dba-f369941c20d9', 'UPS', 'MICROTEK', 'MICROTEK LEGEND 650 VA S', '23G0U0404702050752', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 83, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(167, 'GOV-IT-2023-0167', 'UPS', 'IT', 1, '2f8e2c02-5d38-4b23-8dba-f369941c20d9', 'UPS', 'MICROTEK', 'MICROTEK LEGEND 650 VA S', '23G0U0404702050758', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 104, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(168, 'GOV-IT-2023-0168', 'UPS', 'IT', 1, '2f8e2c02-5d38-4b23-8dba-f369941c20d9', 'UPS', 'MICROTEK', 'MICROTEK LEGEND 650 VA S', '23G0U0404702050542', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 72, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(169, 'GOV-IT-2023-0169', 'UPS', 'IT', 1, '2f8e2c02-5d38-4b23-8dba-f369941c20d9', 'UPS', 'MICROTEK', 'MICROTEK LEGEND 650 VA S', '23G0U0404702050543', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 46, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(170, 'GOV-IT-2023-0170', 'UPS', 'IT', 1, '2f8e2c02-5d38-4b23-8dba-f369941c20d9', 'UPS', 'MICROTEK', 'MICROTEK LEGEND 650 VA S', '23G0U0404702050541', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 64, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(171, 'GOV-IT-2023-0171', 'UPS', 'IT', 1, '2f8e2c02-5d38-4b23-8dba-f369941c20d9', 'UPS', 'MICROTEK', 'MICROTEK LEGEND 650 VA S', '23G0U0404702050544', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 84, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(172, 'GOV-IT-2023-0172', 'UPS', 'IT', 1, '2f8e2c02-5d38-4b23-8dba-f369941c20d9', 'UPS', 'MICROTEK', 'MICROTEK LEGEND 650 VA S', '23G0U0404G01049144', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(173, 'GOV-IT-2023-0173', 'UPS', 'IT', 1, '2f8e2c02-5d38-4b23-8dba-f369941c20d9', 'UPS', 'MICROTEK', 'MICROTEK LEGEND 650 VA S', '23G0U0404G01049142', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(174, 'GOV-IT-2023-0174', 'UPS', 'IT', 1, '2f8e2c02-5d38-4b23-8dba-f369941c20d9', 'UPS', 'MICROTEK', 'MICROTEK LEGEND 650 VA S', '23G0U0404G01049143', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 74, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(175, 'GOV-IT-2023-0175', 'UPS', 'IT', 1, '2f8e2c02-5d38-4b23-8dba-f369941c20d9', 'UPS', 'MICROTEK', 'MICROTEK LEGEND 650 VA S', '23G0U0404G01049145', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(176, 'GOV-IT-2023-0176', 'UPS', 'IT', 1, '2f8e2c02-5d38-4b23-8dba-f369941c20d9', 'UPS', 'MICROTEK', 'MICROTEK LEGEND 650 VA S', '23G0U0404G01049645', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(177, 'GOV-IT-2023-0177', 'UPS', 'IT', 1, '2f8e2c02-5d38-4b23-8dba-f369941c20d9', 'UPS', 'MICROTEK', 'MICROTEK LEGEND 650 VA S', '23G0U0404G01049655', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(178, 'GOV-IT-2023-0178', 'UPS', 'IT', 1, '2f8e2c02-5d38-4b23-8dba-f369941c20d9', 'UPS', 'MICROTEK', 'MICROTEK LEGEND 650 VA S', '23G0U0404G01049664', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 67, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(179, 'GOV-IT-2023-0179', 'UPS', 'IT', 1, '2f8e2c02-5d38-4b23-8dba-f369941c20d9', 'UPS', 'MICROTEK', 'MICROTEK LEGEND 650 VA S', '23G0U0404G01049660', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(180, 'GOV-IT-2023-0180', 'UPS', 'IT', 1, '2f8e2c02-5d38-4b23-8dba-f369941c20d9', 'UPS', 'MICROTEK', 'MICROTEK LEGEND 650 VA S', '23G0U0404G01049209', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 68, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(181, 'GOV-IT-2023-0181', 'UPS', 'IT', 1, '2f8e2c02-5d38-4b23-8dba-f369941c20d9', 'UPS', 'MICROTEK', 'MICROTEK LEGEND 650 VA S', '23G0U0404G01049211', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(182, 'GOV-IT-2023-0182', 'UPS', 'IT', 1, '2f8e2c02-5d38-4b23-8dba-f369941c20d9', 'UPS', 'MICROTEK', 'MICROTEK LEGEND 650 VA S', '23G0U0404G01049210', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 43, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(183, 'GOV-IT-2023-0183', 'UPS', 'IT', 1, '2f8e2c02-5d38-4b23-8dba-f369941c20d9', 'UPS', 'MICROTEK', 'MICROTEK LEGEND 650 VA S', '23G0U0404G01049212', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(184, 'GOV-IT-2023-0184', 'UPS', 'IT', 1, '2f8e2c02-5d38-4b23-8dba-f369941c20d9', 'UPS', 'MICROTEK', 'MICROTEK LEGEND 650 VA S', '23G0U0404G01049129', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 38, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(185, 'GOV-IT-2023-0185', 'UPS', 'IT', 1, '2f8e2c02-5d38-4b23-8dba-f369941c20d9', 'UPS', 'MICROTEK', 'MICROTEK LEGEND 650 VA S', '23G0U0404G01049127', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(186, 'GOV-IT-2023-0186', 'UPS', 'IT', 1, '2f8e2c02-5d38-4b23-8dba-f369941c20d9', 'UPS', 'MICROTEK', 'MICROTEK LEGEND 650 VA S', '23G0U0404G01049134', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(187, 'GOV-IT-2023-0187', 'UPS', 'IT', 1, '2f8e2c02-5d38-4b23-8dba-f369941c20d9', 'UPS', 'MICROTEK', 'MICROTEK LEGEND 650 VA S', '23G0U0404702050042', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(188, 'GOV-IT-2023-0188', 'UPS', 'IT', 1, '2f8e2c02-5d38-4b23-8dba-f369941c20d9', 'UPS', 'MICROTEK', 'MICROTEK LEGEND 650 VA S', '23G0U0404702049994', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(189, 'GOV-IT-2023-0189', 'UPS', 'IT', 1, '2f8e2c02-5d38-4b23-8dba-f369941c20d9', 'UPS', 'MICROTEK', 'MICROTEK LEGEND 650 VA S', '23G0U0404702050043', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'in_use', 'good', 'employee', NULL, 1, 57, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(190, 'GOV-IT-2023-0190', 'UPS', 'IT', 1, '2f8e2c02-5d38-4b23-8dba-f369941c20d9', 'UPS', 'MICROTEK', 'MICROTEK LEGEND 650 VA S', '23G0U0404702050044', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL),
(191, 'GOV-IT-2024-0191', 'UPS', 'IT', 1, '2f8e2c02-5d38-4b23-8dba-f369941c20d9', 'UPS', 'Frontech', 'Frontech FT-2561', 'FT2561230703828', NULL, '2022-11-22', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', 'good', 'department', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-06-08 18:30:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `asset_assignments`
--

DROP TABLE IF EXISTS `asset_assignments`;
CREATE TABLE IF NOT EXISTS `asset_assignments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `asset_id` bigint UNSIGNED NOT NULL,
  `transaction_type` enum('initial','handover','takeover','transfer','maintenance','returned','disposed','lost','found') COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_type` enum('department','employee','store','vendor') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_department_id` bigint UNSIGNED DEFAULT NULL,
  `from_employee_id` bigint UNSIGNED DEFAULT NULL,
  `from_location_building` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_location_floor` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_location_room_no` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to_type` enum('department','employee','store','vendor') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to_department_id` bigint UNSIGNED DEFAULT NULL,
  `to_employee_id` bigint UNSIGNED DEFAULT NULL,
  `to_location_building` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to_location_floor` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to_location_room_no` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condition_at_handover` enum('new','good','fair','poor','condemned') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condition_at_return` enum('new','good','fair','poor','condemned') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `expected_return_date` date DEFAULT NULL COMMENT 'For maintenance / temporary transfers',
  `actual_return_date` date DEFAULT NULL,
  `form_no` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Auto-generated handover/takeover form number',
  `handover_form_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Uploaded signed physical form',
  `handover_acknowledged` tinyint(1) NOT NULL DEFAULT '0',
  `handover_acknowledged_at` timestamp NULL DEFAULT NULL,
  `takeover_acknowledged` tinyint(1) NOT NULL DEFAULT '0',
  `takeover_acknowledged_at` timestamp NULL DEFAULT NULL,
  `authorized_by` bigint UNSIGNED DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `asset_assignments_from_department_id_foreign` (`from_department_id`),
  KEY `asset_assignments_from_employee_id_foreign` (`from_employee_id`),
  KEY `asset_assignments_to_department_id_foreign` (`to_department_id`),
  KEY `asset_assignments_to_employee_id_foreign` (`to_employee_id`),
  KEY `asset_assignments_authorized_by_foreign` (`authorized_by`),
  KEY `asset_assignments_created_by_foreign` (`created_by`),
  KEY `asset_assignments_asset_id_transaction_type_index` (`asset_id`,`transaction_type`),
  KEY `asset_assignments_transaction_date_index` (`transaction_date`),
  KEY `asset_assignments_form_no_index` (`form_no`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asset_assignments`
--

INSERT INTO `asset_assignments` (`id`, `asset_id`, `transaction_type`, `from_type`, `from_department_id`, `from_employee_id`, `from_location_building`, `from_location_floor`, `from_location_room_no`, `to_type`, `to_department_id`, `to_employee_id`, `to_location_building`, `to_location_floor`, `to_location_room_no`, `condition_at_handover`, `condition_at_return`, `transaction_date`, `expected_return_date`, `actual_return_date`, `form_no`, `handover_form_path`, `handover_acknowledged`, `handover_acknowledged_at`, `takeover_acknowledged`, `takeover_acknowledged_at`, `authorized_by`, `remarks`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 92, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 1, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0001', 'handover-forms/DCGLTPC80.jpg', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(2, 79, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 2, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0002', 'handover-forms/DCGLTPC14.jpg', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(3, 35, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 3, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0003', 'handover-forms/DCGLTPC29.jpg', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(4, 41, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 3, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0004', 'handover-forms/DCGLTPRT88.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(5, 16, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 4, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0005', 'handover-forms/DCGLTPC3.jpeg', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(6, 135, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 4, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0006', 'handover-forms/DCGLTPC300.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(7, 160, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 4, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0007', 'handover-forms/DCGLTMontr302.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(8, 59, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 5, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0008', 'handover-forms/DCGLTPC49.jpg', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(9, 29, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 6, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0009', 'handover-forms/DCGLTPC27.jpg', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(10, 126, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 6, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0010', 'handover-forms/DCGLTPC228.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(11, 144, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 6, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0011', 'handover-forms/DCGLTMontr229.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(12, 86, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 7, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0012', 'handover-forms/DCGLTPC15.jpg', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(13, 63, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 8, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0013', 'handover-forms/DCGLTPC57.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(14, 82, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 8, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0014', 'handover-forms/DCGLTUPS187.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(15, 176, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 8, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0015', 'handover-forms/DCGLTPC318.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(16, 106, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 9, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0016', 'handover-forms/DCGLTPC39.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(17, 124, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 9, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0017', 'handover-forms/DCGLTPC287.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(18, 146, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 9, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0018', 'handover-forms/DCGLTMontr288.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(19, 19, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 10, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0019', 'handover-forms/DCGLTPC227.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(20, 78, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 11, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0020', 'handover-forms/DCGLTPC54.jpg', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(21, 7, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 12, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0021', 'handover-forms/DCGLTPC2.jpeg', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(22, 183, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 12, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0022', 'handover-forms/DCGLTUPS169.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(23, 31, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 13, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0023', 'handover-forms/DCGLTPC12.jpg', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(24, 101, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 16, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0024', 'handover-forms/DCGLTPC13.jpg', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(25, 89, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 17, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0025', 'handover-forms/DCGLTPC52.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(26, 39, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 20, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0026', 'handover-forms/DCGLTPC58.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(27, 11, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 21, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0027', 'handover-forms/DCGLTPC31.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(28, 12, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 22, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0028', 'handover-forms/DCGLTPC53.jpg', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(29, 32, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 25, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0029', 'handover-forms/DCGLTPC5.jpeg', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(30, 51, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 25, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0030', 'handover-forms/DCGLTSCN6.jpeg', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(32, 20, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 27, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0032', 'handover-forms/DCGLTPC43.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(33, 81, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 28, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0033', 'handover-forms/DCGLTPC50.jpg', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(34, 99, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 29, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0034', 'handover-forms/DCGLTPC44.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(35, 23, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 30, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0035', 'handover-forms/DCGLTPC33.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(36, 37, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 32, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0036', 'handover-forms/DCGLTPC24.jpg', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(37, 73, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 33, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0037', 'handover-forms/DCGLTPC66.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(38, 127, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 34, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0038', 'handover-forms/DCGLTPC145.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(39, 153, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 34, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0039', 'handover-forms/DCGLTMontr146.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(40, 102, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 35, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0040', 'handover-forms/DCGLTPC68.jpg', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(41, 134, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 36, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0041', 'handover-forms/DCGLTPC143.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(42, 152, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 36, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0042', 'handover-forms/DCGLTMontr144.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(43, 67, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 38, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0043', 'handover-forms/DCGLTPC9.jpg', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(44, 184, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 38, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0044', 'handover-forms/DCGLTUPS170.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(45, 2, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 40, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0045', 'handover-forms/DCGLTPC11.jpg', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(46, 65, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 41, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0046', 'handover-forms/DCGLTPC23.jpg', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(47, 80, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 41, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0047', 'handover-forms/DCGLTPC245.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(48, 4, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 42, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0048', 'handover-forms/DCGLTPC28.jpg', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(49, 182, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 43, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0049', 'handover-forms/DCGLTUPS168.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(50, 6, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 46, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0050', 'handover-forms/DCGLTPC26.jpg', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(51, 169, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 46, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0051', 'handover-forms/DCGLTUPS284.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(52, 120, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 49, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0052', 'handover-forms/DCGLTPC248.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(53, 143, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 49, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0053', 'handover-forms/DCGLTMontr249.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(54, 33, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 51, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0054', 'handover-forms/DCGLTPC10.jpg', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(55, 1, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 57, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0055', 'handover-forms/DCGLTPC41.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(56, 189, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 57, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0056', 'handover-forms/DCGLTUPS175.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(57, 76, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 58, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0057', 'handover-forms/DCGLTPC45.jpg', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(58, 94, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 59, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0058', 'handover-forms/DCGLTPC65.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(59, 52, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 60, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0059', 'handover-forms/DCGLTPC69.jpg', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(60, 91, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 60, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0060', 'handover-forms/DCGLTMFP87.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(61, 93, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 61, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0061', 'handover-forms/DCGLTPC111.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(62, 22, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 64, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0062', 'handover-forms/DCGLTPC79.jpg', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(63, 36, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 64, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0063', 'handover-forms/DCGLTPC81.jpg', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(64, 117, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 64, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0064', 'handover-forms/DCGLTMontr180.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(65, 123, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 64, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0065', 'handover-forms/DCGLTUPS181.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(66, 154, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 64, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0066', 'handover-forms/DCGLTPC183.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(67, 159, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 64, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0067', 'handover-forms/DCGLTPC305.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(68, 170, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 64, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0068', 'handover-forms/DCGLTMontr307.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(69, 130, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 65, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0069', 'handover-forms/DCGLTPC129.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(70, 141, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 65, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0070', 'handover-forms/DCGLTMontr131.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(71, 164, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 65, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0071', 'handover-forms/DCGLTUPS162.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(72, 132, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 67, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0072', 'handover-forms/DCGLTPC118.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(73, 161, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 67, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0073', 'handover-forms/DCGLTMontr119.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(74, 178, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 67, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0074', 'handover-forms/DCGLTUPS160.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(75, 111, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 68, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0075', 'handover-forms/DCGLTPC123.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(76, 180, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 68, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0076', 'handover-forms/DCGLTUPS166.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(77, 118, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 69, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0077', 'handover-forms/DCGLTPC137.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(78, 136, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 69, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0078', 'handover-forms/DCGLTMontr140.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(79, 38, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 71, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0079', 'handover-forms/DCGLTPC179.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(80, 168, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 72, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0080', 'handover-forms/DCGLTUPS189.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(81, 113, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 74, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0081', 'handover-forms/DCGLTPC195.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(82, 149, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 74, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0082', 'handover-forms/DCGLTMontr196.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(83, 174, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 74, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0083', 'handover-forms/DCGLTUPS197.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(84, 114, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 76, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0084', 'handover-forms/DCGLTPC222.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(85, 139, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 76, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0085', 'handover-forms/NULL', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(86, 103, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 77, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0086', 'handover-forms/DCGLTPC225.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(87, 96, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 78, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0087', 'handover-forms/DCGLTPC246.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(88, 90, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 79, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0088', 'handover-forms/DCGLTPC251.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(89, 9, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 80, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0089', 'handover-forms/DCGLTPC252.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(90, 34, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 80, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0090', 'handover-forms/DCGLTPC298.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(91, 30, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 81, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0091', 'handover-forms/DCGLTPC254.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(92, 133, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 82, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0092', 'handover-forms/DCGLTPC255.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(93, 138, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 82, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0093', 'handover-forms/DCGLTMontr256.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(94, 115, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 83, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0094', 'handover-forms/DCGLTPC257.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(95, 158, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 83, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0095', 'handover-forms/DCGLTMontr258.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(96, 166, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 83, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0096', 'handover-forms/DCGLTUPS259.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(97, 121, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 84, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0097', 'handover-forms/DCGLTPC263.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(98, 147, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 84, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0098', 'handover-forms/DCGLTMontr264.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(99, 171, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 84, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0099', 'handover-forms/DCGLTUPS265.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(100, 87, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 85, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0100', 'handover-forms/NULL', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(101, 98, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 86, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0101', 'handover-forms/DCGLTPC277.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(102, 40, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 87, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0102', 'handover-forms/NULL', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(103, 14, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 88, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0103', 'handover-forms/NULL', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(104, 95, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 89, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0104', 'handover-forms/NULL', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(105, 128, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 90, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0105', 'handover-forms/DCGLTPC294.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(106, 137, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 90, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0106', 'handover-forms/DCGLTMontr296.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(107, 66, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 91, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0107', 'handover-forms/NULL', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(108, 25, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 92, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0108', 'handover-forms/NULL', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(109, 110, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 93, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0109', 'handover-forms/DCGLTPC338.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(110, 140, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 93, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0110', 'handover-forms/DCGLTMontr349.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(111, 131, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 94, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0111', 'handover-forms/DCGLTMontr312.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(112, 162, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 94, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0112', 'handover-forms/DCGLTPC328.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(113, 129, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 95, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0113', 'handover-forms/DCGLTPC330.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(114, 142, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 95, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0114', 'handover-forms/DCGLTMontr347.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(115, 157, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 96, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0115', 'handover-forms/DCGLTMontr341.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(116, 74, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 97, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0116', 'handover-forms/DCGLTPC352.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(117, 119, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 98, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0117', 'handover-forms/NULL', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(118, 156, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 98, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0118', 'handover-forms/NULL', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(119, 17, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 99, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0119', 'handover-forms/DCGLTPC320.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(120, 122, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 100, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0120', 'handover-forms/DCGLTPC332.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(121, 151, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 100, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0121', 'handover-forms/DCGLTMontr343.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(122, 150, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 101, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0122', 'handover-forms/DCGLTMontr325.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(123, 163, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 101, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0123', 'handover-forms/DCGLTPC326.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(124, 71, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 102, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0124', 'handover-forms/DCGLTPC316.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(125, 13, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 103, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0125', 'handover-forms/DCGLTPC322.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(126, 112, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 104, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0126', 'handover-forms/DCGLTPC336.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(127, 145, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 104, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0127', 'handover-forms/DCGLTMontr345.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(128, 167, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 104, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0128', 'handover-forms/DCGLTUPS353.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL),
(129, 105, 'handover', 'department', 1, NULL, NULL, NULL, NULL, 'employee', NULL, 105, NULL, NULL, NULL, 'new', NULL, '0000-00-00', NULL, NULL, 'HO-202606-0129', 'handover-forms/DCGLTPC350.pdf', 0, NULL, 0, NULL, NULL, NULL, 1, '2026-09-05 18:30:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `asset_categories`
--

DROP TABLE IF EXISTS `asset_categories`;
CREATE TABLE IF NOT EXISTS `asset_categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Unique code used in Asset Tag generation',
  `description` text COLLATE utf8mb4_unicode_ci,
  `icon` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'CSS icon class e.g., fas fa-laptop, fas fa-chair',
  `depreciation_rate` decimal(5,2) DEFAULT NULL COMMENT 'Annual depreciation rate in percentage',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `sub_categories` json DEFAULT NULL COMMENT 'JSON array of sub-category objects',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `asset_categories_code_unique` (`code`),
  KEY `asset_categories_created_by_foreign` (`created_by`),
  KEY `asset_categories_updated_by_foreign` (`updated_by`),
  KEY `asset_categories_status_index` (`status`),
  KEY `asset_categories_code_index` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asset_categories`
--

INSERT INTO `asset_categories` (`id`, `name`, `code`, `description`, `icon`, `depreciation_rate`, `status`, `sub_categories`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'IT Equipment', 'IT', 'Computers, laptops, servers and other IT devices', 'fas fa-laptop', 33.33, 'active', '[{\"id\": \"c9e3497f-db73-4c9b-bd6d-0464f95a6fe6\", \"code\": \"DKT\", \"name\": \"Desktop Computer\", \"status\": \"active\"}, {\"id\": \"d42e9ad5-fd71-429a-ae01-b87e1c6e9edb\", \"code\": \"LAP\", \"name\": \"Laptop\", \"status\": \"active\"}, {\"id\": \"6ba2185f-7af2-4c2c-8193-7669c71b1633\", \"code\": \"SRV\", \"name\": \"Server\", \"status\": \"active\"}, {\"id\": \"4eca864a-86ec-420b-9fad-34221626b983\", \"code\": \"PRN\", \"name\": \"Printer\", \"status\": \"active\"}, {\"id\": \"5921958b-6b37-4aa2-8cfb-15f6ee65fcd2\", \"code\": \"SCN\", \"name\": \"Scanner\", \"status\": \"active\"}, {\"id\": \"2f8e2c02-5d38-4b23-8dba-f369941c20d9\", \"code\": \"UPS\", \"name\": \"UPS\", \"status\": \"active\"}, {\"id\": \"ae89a32c-2d70-412f-b124-07d85dc22db8\", \"code\": \"PRJ\", \"name\": \"Projector\", \"status\": \"active\"}, {\"id\": \"a60c22f3-dd12-4725-a988-9d1329d3bcb3\", \"code\": \"NSW\", \"name\": \"Network Switch\", \"status\": \"active\"}, {\"id\": \"13668c08-ca57-4a22-8186-b5625aa49170\", \"code\": \"WFR\", \"name\": \"Wi-Fi Router\", \"status\": \"active\"}, {\"id\": \"773db5ec-0bc6-4f3f-9447-976e57d30613\", \"code\": \"CTV\", \"name\": \"CCTV Camera\", \"status\": \"active\"}, {\"id\": \"1780992855618\", \"code\": \"MNT\", \"name\": \"Monitor\", \"status\": \"active\", \"description\": \"\"}, {\"id\": \"1780993050658\", \"code\": \"OPS\", \"name\": \"OPS\", \"status\": \"active\", \"description\": \"\"}, {\"id\": \"1780993072826\", \"code\": \"SMART TV\", \"name\": \"Smart TV\", \"status\": \"active\", \"description\": \"\"}]', NULL, 1, '2026-06-08 05:43:12', '2026-06-09 02:47:54', NULL),
(2, 'Furniture', 'FRN', 'Office furniture and fixtures', 'fas fa-chair', 10.00, 'active', '[{\"id\": \"b539d343-04cd-46a9-b1ff-65e379319b31\", \"code\": \"CHR\", \"name\": \"Chair\", \"status\": \"active\"}, {\"id\": \"14d78250-b11d-4a45-bcdf-37898fcbf24a\", \"code\": \"TBL\", \"name\": \"Table / Desk\", \"status\": \"active\"}, {\"id\": \"bf2ce59c-4ec8-4ad4-93d8-943a1c7a624b\", \"code\": \"ALM\", \"name\": \"Almirah\", \"status\": \"active\"}, {\"id\": \"e99632f1-39a8-4156-8741-906048a7b3d0\", \"code\": \"SFA\", \"name\": \"Sofa\", \"status\": \"active\"}, {\"id\": \"3c67c1f1-a33f-40f2-9b83-c91958d85c0f\", \"code\": \"FCB\", \"name\": \"Filing Cabinet\", \"status\": \"active\"}, {\"id\": \"43fda7f9-360f-4236-b544-c6eda8e4bf1e\", \"code\": \"BSF\", \"name\": \"Bookshelf\", \"status\": \"active\"}, {\"id\": \"35eb4a65-95ec-48cb-a964-be0bdeec086f\", \"code\": \"PRT\", \"name\": \"Partition\", \"status\": \"active\"}]', NULL, NULL, '2026-06-08 05:43:12', '2026-06-08 05:43:12', NULL),
(3, 'Electrical Equipment', 'ELE', 'Air conditioners, fans and electrical appliances', 'fas fa-plug', 15.00, 'active', '[{\"id\": \"492940f8-3751-4a7f-8615-f4d05f6bc230\", \"code\": \"ACU\", \"name\": \"Air Conditioner\", \"status\": \"active\"}, {\"id\": \"82947680-c753-4eff-b705-e4b59b940b0e\", \"code\": \"CFN\", \"name\": \"Ceiling Fan\", \"status\": \"active\"}, {\"id\": \"58db0b20-7113-4e5c-b118-6561f0e28e69\", \"code\": \"RFG\", \"name\": \"Refrigerator\", \"status\": \"active\"}, {\"id\": \"f7d6508d-137e-407f-8189-762387fbb2aa\", \"code\": \"WPR\", \"name\": \"Water Purifier\", \"status\": \"active\"}]', NULL, 1, '2026-06-08 05:43:12', '2026-06-09 02:47:07', NULL),
(4, 'Vehicle', 'VHL', 'Official vehicles', 'fas fa-car', 20.00, 'active', '[{\"id\": \"390cb6a4-8d76-4101-bc62-f75212720f78\", \"code\": \"CAR\", \"name\": \"Car\", \"status\": \"active\"}, {\"id\": \"dc5bffe4-f0bd-4f22-a93b-651a36b857bc\", \"code\": \"SUV\", \"name\": \"Suv\", \"status\": \"active\"}, {\"id\": \"fe1a1660-0cce-4506-9452-056bf228effa\", \"code\": \"PIU\", \"name\": \"Pick Up\", \"status\": \"active\"}, {\"id\": \"75f36546-8b25-417a-9215-0cbead5c724c\", \"code\": \"JEP\", \"name\": \"Jeep\", \"status\": \"active\"}]', NULL, NULL, '2026-06-08 05:43:12', '2026-06-08 05:43:12', NULL),
(5, 'Communication Equipment', 'COM', 'Phones, intercom and communication devices', 'fas fa-phone', 20.00, 'active', '[{\"id\": \"289773a1-f24a-4a84-b4c4-a04bd980b285\", \"code\": \"LPN\", \"name\": \"Landline Phone\", \"status\": \"active\"}, {\"id\": \"8b0cf01a-921f-47f3-aee0-021d066a27c0\", \"code\": \"MBL\", \"name\": \"Mobile Phone\", \"status\": \"active\"}, {\"id\": \"ee4534bc-2884-4989-aff1-e4129ff451f2\", \"code\": \"ICM\", \"name\": \"Intercom\", \"status\": \"active\"}, {\"id\": \"3f2ad099-6b9c-45f8-9151-74eb5bc4b885\", \"code\": \"WTK\", \"name\": \"Walkie-Talkie\", \"status\": \"active\"}, {\"id\": \"5f0f61cd-f0a9-4e42-adfe-d985e871a066\", \"code\": \"FAX\", \"name\": \"Fax Machine\", \"status\": \"active\"}]', NULL, NULL, '2026-06-08 05:43:12', '2026-06-08 05:43:12', NULL),
(6, 'Safety Equipment', 'SAF', 'Fire safety and security equipment', 'fas fa-fire-extinguisher', 15.00, 'active', '[{\"id\": \"0f45dbc8-0c4c-43c3-bb63-edfb8b367f1c\", \"code\": \"FEX\", \"name\": \"Fire Extinguisher\", \"status\": \"active\"}, {\"id\": \"2bdfcd7f-c82f-4a25-a57e-860c9d520a35\", \"code\": \"SMK\", \"name\": \"Smoke Detector\", \"status\": \"active\"}, {\"id\": \"3c447c77-5005-4ce8-88e8-3715d817c07a\", \"code\": \"SCA\", \"name\": \"Security Camera\", \"status\": \"active\"}]', NULL, NULL, '2026-06-08 05:43:12', '2026-06-08 05:43:12', NULL),
(7, 'Office Equipment', 'OFF', 'General office equipment', 'fas fa-briefcase', 15.00, 'active', '[{\"id\": \"21c4ecf3-9b5c-440f-b9a2-2882af12a7e3\", \"code\": \"PHC\", \"name\": \"Photocopier\", \"status\": \"active\"}, {\"id\": \"b8b547ec-6e33-43f4-a6ee-62b5c1140fb6\", \"code\": \"SHR\", \"name\": \"Shredder\", \"status\": \"active\"}, {\"id\": \"c46bc666-7409-45a0-9703-0e2f5afefee0\", \"code\": \"LAM\", \"name\": \"Laminator\", \"status\": \"active\"}, {\"id\": \"1df5a9e2-d7cb-44f3-abb3-1e251e9a8723\", \"code\": \"PWS\", \"name\": \"Paper Weight Scale\", \"status\": \"active\"}]', NULL, NULL, '2026-06-08 05:43:12', '2026-06-08 05:43:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `asset_documents`
--

DROP TABLE IF EXISTS `asset_documents`;
CREATE TABLE IF NOT EXISTS `asset_documents` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `asset_id` bigint UNSIGNED NOT NULL,
  `document_type` enum('invoice','warranty_card','manual','amc_contract','handover_form','takeover_form','inspection_report','maintenance_report','disposal_certificate','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `file_path` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'MIME type',
  `file_size` bigint UNSIGNED DEFAULT NULL COMMENT 'In bytes',
  `assignment_id` bigint UNSIGNED DEFAULT NULL,
  `maintenance_id` bigint UNSIGNED DEFAULT NULL,
  `uploaded_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `asset_documents_assignment_id_foreign` (`assignment_id`),
  KEY `asset_documents_maintenance_id_foreign` (`maintenance_id`),
  KEY `asset_documents_uploaded_by_foreign` (`uploaded_by`),
  KEY `asset_documents_asset_id_document_type_index` (`asset_id`,`document_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_maintenances`
--

DROP TABLE IF EXISTS `asset_maintenances`;
CREATE TABLE IF NOT EXISTS `asset_maintenances` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `asset_id` bigint UNSIGNED NOT NULL,
  `maintenance_type` enum('preventive','corrective','amc','calibration','inspection','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_no` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scheduled_date` date DEFAULT NULL,
  `start_date` date NOT NULL,
  `completion_date` date DEFAULT NULL,
  `vendor_id` bigint UNSIGNED DEFAULT NULL,
  `technician_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `technician_contact` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `issue_description` text COLLATE utf8mb4_unicode_ci,
  `work_done` text COLLATE utf8mb4_unicode_ci,
  `parts_replaced` text COLLATE utf8mb4_unicode_ci,
  `maintenance_cost` decimal(10,2) DEFAULT NULL,
  `invoice_no` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('scheduled','in_progress','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'scheduled',
  `condition_after` enum('new','good','fair','poor','condemned') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `document_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Any maintenance report / certificate',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `asset_maintenances_vendor_id_foreign` (`vendor_id`),
  KEY `asset_maintenances_created_by_foreign` (`created_by`),
  KEY `asset_maintenances_updated_by_foreign` (`updated_by`),
  KEY `asset_maintenances_asset_id_status_index` (`asset_id`,`status`),
  KEY `asset_maintenances_scheduled_date_index` (`scheduled_date`),
  KEY `asset_maintenances_completion_date_index` (`completion_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_network_details`
--

DROP TABLE IF EXISTS `asset_network_details`;
CREATE TABLE IF NOT EXISTS `asset_network_details` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `asset_id` bigint UNSIGNED NOT NULL,
  `ethernet_mac` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wifi_mac` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `asset_network_details_asset_id_unique` (`asset_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `backup_logs`
--

DROP TABLE IF EXISTS `backup_logs`;
CREATE TABLE IF NOT EXISTS `backup_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` bigint UNSIGNED DEFAULT NULL COMMENT 'In bytes',
  `status` enum('success','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'success',
  `disk` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'local' COMMENT 'Storage disk: local, s3, etc.',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `backup_logs_created_by_foreign` (`created_by`),
  KEY `backup_logs_created_at_index` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('inventory-management-system-cache-7002490210|10.177.132.249', 'i:2;', 1780990966),
('inventory-management-system-cache-7002490210|10.177.132.249:timer', 'i:1780990966;', 1780990966),
('inventory-management-system-cache-admin@admin.com|10.177.132.59', 'i:1;', 1781088346),
('inventory-management-system-cache-admin@admin.com|10.177.132.59:timer', 'i:1781088346;', 1781088346),
('inventory-management-system-cache-setting.asset_tag.format', 's:27:\"{ORG_CODE}-{CAT_CODE}-{SEQ}\";', 2096352686),
('inventory-management-system-cache-setting.asset_tag.org_code', 's:3:\"GLT\";', 2096352686),
('inventory-management-system-cache-setting.asset_tag.seq_digits', 'i:4;', 2096352686),
('inventory-management-system-cache-setting.general.app_name', 's:5:\"GARMS\";', 2096281894),
('inventory-management-system-cache-setting.organisation.org_logo', 's:57:\"organisation/MVV1PpODM7doruQcMy6K5HT1hkFvnxmrixJ1Rq0d.png\";', 2096281894),
('inventory-management-system-cache-setting.organisation.org_name', 's:45:\"Office of the District Commissioner, Golaghat\";', 2096281905),
('inventory-management-system-cache-settings.group.asset_tag', 'a:4:{s:13:\"auto_generate\";b:1;s:6:\"format\";s:27:\"{ORG_CODE}-{CAT_CODE}-{SEQ}\";s:8:\"org_code\";s:3:\"GLT\";s:10:\"seq_digits\";i:4;}', 2096283366),
('inventory-management-system-cache-settings.group.backup', 'a:4:{s:11:\"auto_backup\";b:0;s:11:\"backup_disk\";s:5:\"local\";s:16:\"backup_frequency\";s:5:\"daily\";s:16:\"backup_retention\";i:30;}', 2096281897),
('inventory-management-system-cache-settings.group.general', 'a:9:{s:8:\"app_name\";s:5:\"GARMS\";s:12:\"app_timezone\";s:12:\"Asia/Kolkata\";s:16:\"asset_tag_format\";s:27:\"{ORG_CODE}-{CAT_CODE}-{SEQ}\";s:18:\"asset_tag_org_code\";s:3:\"GLT\";s:20:\"asset_tag_seq_digits\";s:1:\"4\";s:8:\"currency\";s:3:\"₹\";s:15:\"currency_symbol\";s:3:\"₹\";s:11:\"date_format\";s:5:\"d/m/Y\";s:14:\"items_per_page\";i:25;}', 2096283366),
('inventory-management-system-cache-settings.group.notification', 'a:4:{s:11:\"admin_email\";s:0:\"\";s:14:\"amc_alert_days\";i:30;s:19:\"email_notifications\";b:1;s:19:\"warranty_alert_days\";i:30;}', 2096281896),
('inventory-management-system-cache-settings.group.organisation', 'a:9:{s:11:\"org_address\";s:63:\"Office of the Integrated District Commissioner Office, Golaghat\";s:8:\"org_city\";s:8:\"Golaghat\";s:9:\"org_email\";s:18:\"dc-golaghat@nic.in\";s:8:\"org_logo\";s:57:\"organisation/MVV1PpODM7doruQcMy6K5HT1hkFvnxmrixJ1Rq0d.png\";s:8:\"org_name\";s:45:\"Office of the District Commissioner, Golaghat\";s:9:\"org_phone\";s:10:\"3774280222\";s:11:\"org_pincode\";s:6:\"785621\";s:9:\"org_state\";s:5:\"Assam\";s:11:\"org_website\";s:30:\"https://golaghat.assam.gov.in/\";}', 2096281894);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE IF NOT EXISTS `departments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Short code for department e.g., IT, HR, FIN',
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `head_user_id` bigint UNSIGNED DEFAULT NULL,
  `building` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `block` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `floor` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `room_no` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pincode` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `departments_code_unique` (`code`),
  KEY `departments_head_user_id_foreign` (`head_user_id`),
  KEY `departments_status_index` (`status`),
  KEY `departments_parent_id_index` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `code`, `name`, `parent_id`, `head_user_id`, `building`, `block`, `floor`, `room_no`, `address`, `city`, `state`, `pincode`, `phone`, `email`, `status`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'NAZ', 'Nazarat', NULL, NULL, 'DC Office', NULL, 'Second Floor', 'B-3', NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2026-06-08 05:43:11', '2026-06-09 05:16:40', NULL),
(2, 'EGOV', 'e-Governance', NULL, NULL, 'DC Office', NULL, 'Second Floor', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2026-06-09 04:05:57', '2026-06-10 05:16:23', NULL),
(3, 'DEV', 'Development', NULL, NULL, 'DC Office', NULL, 'Second Floor', 'B-5', NULL, 'Golaghat', 'Assam', '785621', NULL, NULL, 'active', NULL, '2026-06-09 05:12:49', '2026-06-10 05:16:30', NULL),
(4, 'PFC', 'PFC', NULL, NULL, 'DC Office', NULL, 'First Floor', NULL, NULL, 'Golaghat', 'ASSAM', '785621', NULL, NULL, 'active', NULL, '2026-06-09 05:19:46', '2026-06-10 05:16:40', NULL),
(5, 'PER', 'Personnel', NULL, NULL, 'DC Office', NULL, 'First Floor', NULL, NULL, NULL, 'ASSAM', '785621', NULL, NULL, 'active', NULL, '2026-06-09 05:20:30', '2026-06-10 05:16:47', NULL),
(6, 'ADM', 'Administration', NULL, NULL, 'DC Office', NULL, 'Second Floor', NULL, NULL, 'Golaghat', 'ASSAM', '785621', NULL, NULL, 'active', NULL, '2026-06-09 05:21:16', '2026-06-10 05:16:54', NULL),
(7, 'SUR', 'Sub Registrar', NULL, NULL, 'DC Office', NULL, 'First Floor', 'A-1', NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2026-06-09 05:24:23', '2026-06-10 05:17:01', NULL),
(8, 'FDC', 'FPD & CA', NULL, NULL, 'DC Office', NULL, 'First Floor', 'A-5', NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2026-06-09 05:24:48', '2026-06-10 05:17:14', NULL),
(9, 'DCP', 'DCP Branch', NULL, NULL, 'DC Office', NULL, 'Second Floor', 'B-1/B-2', NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2026-06-09 05:30:12', '2026-06-10 05:17:23', NULL),
(10, 'MAG', 'Magistracy Branch', NULL, NULL, 'DC Office', NULL, 'Second Floor', 'B-7', NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2026-06-09 05:30:43', '2026-06-10 05:17:29', NULL),
(11, 'BAK', 'Census/ Bakijai', NULL, NULL, 'DC Office', NULL, 'Second Floor', 'B-8', NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2026-06-09 05:31:12', '2026-06-10 05:17:36', NULL),
(12, 'ELE', 'Election', NULL, NULL, 'DC Office', NULL, 'Second Floor', 'B-11', NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2026-06-09 05:31:38', '2026-06-10 05:17:44', NULL),
(13, 'DDM', 'DDMA', NULL, NULL, 'DC Office', NULL, 'Second Floor', 'B-13', NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2026-06-09 05:31:58', '2026-06-10 05:17:51', NULL),
(14, 'PA', 'PA to DC', NULL, NULL, 'DC Office', NULL, 'Third Floor', 'C-2', NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2026-06-09 05:35:46', '2026-06-10 05:18:35', NULL),
(15, 'EXC', 'Excise', NULL, NULL, 'DC Office', NULL, 'Fourt Floor', 'D-3', NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2026-06-09 05:37:08', '2026-06-10 05:18:07', NULL),
(16, 'RKG', 'Registrar Kanungo Branch (RKG)', NULL, NULL, 'DC Office', NULL, 'Fourt Floor', 'D-4', NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2026-06-09 05:37:52', '2026-06-10 05:18:15', NULL),
(17, 'REV', 'Revenue Branch', NULL, NULL, 'DC Office', NULL, 'Fourt Floor', 'D-6/7', NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2026-06-09 05:38:23', '2026-06-10 05:18:21', NULL),
(18, 'LA', 'Land Acquisition Branch', NULL, NULL, 'DC Office', NULL, 'Fourt Floor', 'D-10', NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2026-06-09 05:38:58', '2026-06-10 05:18:28', NULL),
(19, 'NRC', 'NRC', NULL, NULL, 'DC Office', NULL, 'Fourt Floor', 'D-13', NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2026-06-09 05:39:15', '2026-06-10 05:18:43', NULL),
(20, 'NIC', 'NIC', NULL, NULL, 'DC Office', NULL, 'Third Floor', 'C-14', NULL, 'Golaghat', 'ASSAM', '785621', NULL, NULL, 'active', NULL, '2026-06-09 05:40:40', '2026-06-09 05:40:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

DROP TABLE IF EXISTS `designations`;
CREATE TABLE IF NOT EXISTS `designations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_category` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'General category of designation',
  `sort_order` tinyint NOT NULL DEFAULT '0',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `designations_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `name`, `slug`, `department_category`, `sort_order`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'District Commissioner', 'district-commissioner', NULL, 1, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(2, 'District Development Commissioner', 'district-development-commissioner', NULL, 2, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(3, 'Addl. District Commissioner', 'addl-district-commissioner', NULL, 3, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(4, 'Asstt. Commissioner', 'asstt-commissioner', NULL, 4, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(5, 'Election Officer', 'election-officer', NULL, 5, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(6, 'Asstt. Planning Officer', 'asstt-planning-officer', NULL, 6, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(7, 'Exicse Officer', 'exicse-officer', NULL, 7, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(8, 'FAO', 'fao', NULL, 8, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(9, 'District Manager', 'district-manager', NULL, 9, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(10, 'District Project Officer', 'district-project-officer', NULL, 10, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(11, 'Administrative Officer', 'administrative-officer', NULL, 11, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(12, 'DDS', 'dds', NULL, 12, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(13, 'Research Assistant', 'research-assistant', NULL, 13, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(14, 'Revenue sheristadar', 'revenue-sheristadar', NULL, 14, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(15, 'Head Assistant', 'head-assistant', NULL, 15, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(16, 'Senior District Administrative Assistant', 'senior-district-administrative-assistant', NULL, 16, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(17, 'Stenographer Grade-III', 'stenographer-grade-iii', NULL, 17, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(18, 'Stenographer Grade-I', 'stenographer-grade-i', NULL, 18, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(19, 'Junior District Administrative Assistant', 'junior-district-administrative-assistant', NULL, 19, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(20, 'Superintendent of Accounts', 'superintendent-of-accounts', NULL, 20, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(21, 'Computor', 'computor', NULL, 21, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(22, 'Others', 'others', NULL, 22, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(23, 'Sub Divisional Officer (C)', 'sub-divisional-officer-c', NULL, 23, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(24, 'Circle Officer', 'circle-officer', NULL, 24, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(25, 'Consultant, ILRMS', 'consultant-ilrms', NULL, 25, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(26, 'PFC Operator', 'pfc-operator', NULL, 26, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(27, 'Computer Assistant', 'computer-assistant', NULL, 27, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(28, 'DPM, edistrict', 'dpm-edistrict', NULL, 28, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(29, 'Sub Divisional Officer (S)', 'sub-divisional-officer-s', NULL, 29, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(30, 'Superintendent of Exices', 'superintendent-of-exices', NULL, 30, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(31, 'Superintendent of F&CS', 'superintendent-of-fcs', NULL, 31, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(32, 'Chief Accounts Officer', 'chief-accounts-officer', NULL, 32, 'active', '2026-06-08 05:43:11', '2026-06-08 05:43:11', NULL),
(33, 'DTSS, DeGS', 'dtss-degs', NULL, 33, 'active', '2026-06-09 03:56:29', '2026-06-09 03:56:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ip_addresses`
--

DROP TABLE IF EXISTS `ip_addresses`;
CREATE TABLE IF NOT EXISTS `ip_addresses` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subnet_mask` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dns_primary` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dns_secondary` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `network_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'LAN',
  `vlan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('available','allocated','reserved','decommissioned') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip_addresses_ip_address_unique` (`ip_address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ip_allocations`
--

DROP TABLE IF EXISTS `ip_allocations`;
CREATE TABLE IF NOT EXISTS `ip_allocations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_address_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `asset_id` bigint UNSIGNED DEFAULT NULL,
  `ethernet_mac` varchar(17) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wifi_mac` varchar(17) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dns_override` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_allocated` date NOT NULL,
  `date_released` date DEFAULT NULL,
  `status` enum('active','released','suspended') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `allocated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `release_notes` text COLLATE utf8mb4_unicode_ci,
  `released_by` bigint UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ip_allocations_ip_address_id_foreign` (`ip_address_id`),
  KEY `ip_allocations_user_id_foreign` (`user_id`),
  KEY `ip_allocations_allocated_by_foreign` (`allocated_by`),
  KEY `ip_allocations_asset_id_foreign` (`asset_id`),
  KEY `ip_allocations_released_by_foreign` (`released_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2026_06_06_081917_create_designations_table', 1),
(4, '2026_06_06_082029_create_roles_and_permissions_table', 1),
(5, '2026_06_06_082034_create_users_table', 1),
(6, '2026_06_06_082040_create_departments_table', 1),
(7, '2026_06_06_082059_create_vendors_table', 1),
(8, '2026_06_06_082104_create_asset_categories_table', 1),
(9, '2026_06_06_082112_create_assets_table', 1),
(10, '2026_06_06_082117_create_asset_assignments_table', 1),
(11, '2026_06_06_082121_create_asset_maintenances_table', 1),
(12, '2026_06_06_082126_create_asset_documents_table', 1),
(13, '2026_06_06_082132_create_settings_table', 1),
(14, '2026_06_06_082142_create_activity_logs_table', 1),
(15, '2026_06_06_082146_create_notifications_table', 1),
(16, '2026_06_06_082150_create_backup_logs_table', 1),
(17, '2026_06_07_160515_add_home_department_to_assets_table', 1),
(18, '2026_06_08_300001_create_ip_addresses_table', 1),
(19, '2026_06_09_050909_create_asset_network_details_table', 2),
(20, '2026_06_09_051221_add_ip_allocations_column', 2),
(21, '2026_06_09_070247_add_ip_allocations_column', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` json NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'e.g., assets.create, assets.edit',
  `display_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'assets, departments, employees, vendors, reports, settings',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `module`, `description`, `created_at`, `updated_at`) VALUES
(1, 'assets.view', 'View Assets', 'assets', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(2, 'assets.create', 'Create Assets', 'assets', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(3, 'assets.edit', 'Edit Assets', 'assets', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(4, 'assets.delete', 'Delete Assets', 'assets', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(5, 'assets.assign', 'Assign Assets', 'assets', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(6, 'assets.transfer', 'Transfer Assets', 'assets', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(7, 'assets.dispose', 'Dispose Assets', 'assets', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(8, 'assets.export', 'Export Assets', 'assets', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(9, 'categories.view', 'View Categories', 'categories', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(10, 'categories.create', 'Create Categories', 'categories', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(11, 'categories.edit', 'Edit Categories', 'categories', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(12, 'categories.delete', 'Delete Categories', 'categories', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(13, 'departments.view', 'View Departments', 'departments', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(14, 'departments.create', 'Create Departments', 'departments', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(15, 'departments.edit', 'Edit Departments', 'departments', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(16, 'departments.delete', 'Delete Departments', 'departments', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(17, 'employees.view', 'View Employees', 'employees', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(18, 'employees.create', 'Create Employees', 'employees', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(19, 'employees.edit', 'Edit Employees', 'employees', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(20, 'employees.delete', 'Delete Employees', 'employees', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(21, 'vendors.view', 'View Vendors', 'vendors', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(22, 'vendors.create', 'Create Vendors', 'vendors', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(23, 'vendors.edit', 'Edit Vendors', 'vendors', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(24, 'vendors.delete', 'Delete Vendors', 'vendors', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(25, 'maintenance.view', 'View Maintenance', 'maintenance', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(26, 'maintenance.create', 'Create Maintenance', 'maintenance', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(27, 'maintenance.edit', 'Edit Maintenance', 'maintenance', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(28, 'maintenance.delete', 'Delete Maintenance', 'maintenance', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(29, 'reports.view', 'View Reports', 'reports', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(30, 'reports.export', 'Export Reports', 'reports', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(31, 'settings.view', 'View Settings', 'settings', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(32, 'settings.manage', 'Manage Settings', 'settings', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(33, 'activity-logs', 'View Activity Logs', 'activity-logs', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(34, 'users.view', 'View Users', 'users', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(35, 'users.create', 'Create Users', 'users', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(36, 'users.edit', 'Edit Users', 'users', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(37, 'users.delete', 'Delete Users', 'users', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(38, 'roles.manage', 'Manage Roles & Permissions', 'users', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(39, 'ip.view', 'View IP Addresses', 'ip', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(40, 'ip.manage', 'Manage IP & Allocations', 'ip', NULL, '2026-06-08 05:43:11', '2026-06-08 05:43:11');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'super_admin, admin, author, user',
  `display_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_system_role` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'System roles cannot be deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `is_system_role`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', 'Super Administrator', 'Full system access', 1, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(2, 'admin', 'Administrator', 'Administrative access', 1, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(3, 'IT admin', 'IT Administrator', 'IT Administrative access', 1, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(4, 'author', 'Author', 'Can create and edit records', 1, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(5, 'user', 'User', 'Read-only access', 1, '2026-06-08 05:43:11', '2026-06-08 05:43:11');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

DROP TABLE IF EXISTS `role_permissions`;
CREATE TABLE IF NOT EXISTS `role_permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` bigint UNSIGNED NOT NULL,
  `permission_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_permissions_role_id_permission_id_unique` (`role_id`,`permission_id`),
  KEY `role_permissions_permission_id_foreign` (`permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=160 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(1, 1, 33, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(2, 1, 5, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(3, 1, 2, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(4, 1, 4, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(5, 1, 7, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(6, 1, 3, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(7, 1, 8, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(8, 1, 6, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(9, 1, 1, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(10, 1, 10, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(11, 1, 12, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(12, 1, 11, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(13, 1, 9, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(14, 1, 14, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(15, 1, 16, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(16, 1, 15, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(17, 1, 13, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(18, 1, 18, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(19, 1, 20, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(20, 1, 19, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(21, 1, 17, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(22, 1, 40, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(23, 1, 39, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(24, 1, 26, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(25, 1, 28, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(26, 1, 27, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(27, 1, 25, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(28, 1, 30, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(29, 1, 29, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(30, 1, 38, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(31, 1, 32, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(32, 1, 31, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(33, 1, 35, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(34, 1, 37, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(35, 1, 36, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(36, 1, 34, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(37, 1, 22, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(38, 1, 24, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(39, 1, 23, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(40, 1, 21, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(41, 2, 33, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(42, 2, 5, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(43, 2, 2, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(45, 2, 7, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(46, 2, 3, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(47, 2, 8, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(48, 2, 6, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(49, 2, 1, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(54, 2, 14, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(56, 2, 15, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(57, 2, 13, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(64, 2, 26, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(66, 2, 27, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(67, 2, 25, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(68, 2, 30, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(69, 2, 29, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(75, 2, 34, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(76, 2, 22, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(78, 2, 23, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(79, 2, 21, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(86, 3, 8, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(88, 3, 1, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(92, 3, 9, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(96, 3, 13, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(101, 3, 40, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(102, 3, 39, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(106, 3, 25, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(107, 3, 30, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(108, 3, 29, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(114, 3, 34, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(118, 3, 21, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(119, 4, 2, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(120, 4, 3, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(121, 4, 1, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(122, 4, 10, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(123, 4, 11, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(124, 4, 9, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(125, 4, 14, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(126, 4, 15, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(127, 4, 13, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(128, 4, 18, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(129, 4, 19, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(130, 4, 17, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(131, 4, 39, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(132, 4, 26, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(133, 4, 27, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(134, 4, 25, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(135, 4, 29, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(136, 4, 31, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(137, 4, 34, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(138, 4, 22, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(139, 4, 23, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(140, 4, 21, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(141, 5, 1, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(142, 5, 9, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(143, 5, 13, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(144, 5, 17, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(145, 5, 39, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(146, 5, 25, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(147, 5, 29, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(148, 5, 31, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(149, 5, 34, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(150, 5, 21, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(151, 4, 6, '2026-06-09 04:00:02', '2026-06-09 04:00:02'),
(152, 3, 5, '2026-06-09 07:08:19', '2026-06-09 07:08:19'),
(153, 3, 2, '2026-06-09 07:08:19', '2026-06-09 07:08:19'),
(154, 3, 3, '2026-06-09 07:08:19', '2026-06-09 07:08:19'),
(155, 3, 10, '2026-06-09 07:08:19', '2026-06-09 07:08:19'),
(156, 3, 12, '2026-06-09 07:08:19', '2026-06-09 07:08:19'),
(157, 3, 11, '2026-06-09 07:08:19', '2026-06-09 07:08:19'),
(158, 3, 14, '2026-06-09 07:08:19', '2026-06-09 07:08:19'),
(159, 3, 15, '2026-06-09 07:08:19', '2026-06-09 07:08:19');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `group` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'general, organisation, asset_tag, notification, backup, email',
  `key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text' COMMENT 'text, textarea, boolean, json, integer, file',
  `label` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Human readable label for UI',
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_public` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'If true, accessible without auth (e.g., org name)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_group_key_unique` (`group`,`key`),
  KEY `settings_group_index` (`group`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `group`, `key`, `value`, `type`, `label`, `description`, `is_public`, `created_at`, `updated_at`) VALUES
(1, 'general', 'app_name', 'GARMS', 'text', 'Application Name', NULL, 1, '2026-06-08 05:43:11', '2026-06-08 07:00:04'),
(2, 'general', 'app_timezone', 'Asia/Kolkata', 'text', 'Timezone', NULL, 0, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(3, 'general', 'date_format', 'd/m/Y', 'text', 'Date Format', NULL, 0, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(4, 'general', 'currency', '₹', 'text', 'Currency', NULL, 1, '2026-06-08 05:43:11', '2026-06-08 07:00:04'),
(5, 'general', 'currency_symbol', '₹', 'text', 'Currency Symbol', NULL, 1, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(6, 'general', 'items_per_page', '25', 'integer', 'Items Per Page', NULL, 0, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(7, 'organisation', 'org_name', 'Office of the District Commissioner, Golaghat', 'text', 'Organisation Name', NULL, 1, '2026-06-08 05:43:11', '2026-06-08 07:01:33'),
(8, 'organisation', 'org_address', 'Office of the Integrated District Commissioner Office, Golaghat', 'textarea', 'Address', NULL, 1, '2026-06-08 05:43:11', '2026-06-08 07:01:33'),
(9, 'organisation', 'org_city', 'Golaghat', 'text', 'City', NULL, 1, '2026-06-08 05:43:11', '2026-06-08 07:01:33'),
(10, 'organisation', 'org_state', 'Assam', 'text', 'State', NULL, 1, '2026-06-08 05:43:11', '2026-06-08 07:01:33'),
(11, 'organisation', 'org_pincode', '785621', 'text', 'Pincode', NULL, 1, '2026-06-08 05:43:11', '2026-06-08 07:01:33'),
(12, 'organisation', 'org_phone', '3774280222', 'text', 'Phone', NULL, 1, '2026-06-08 05:43:11', '2026-06-08 07:01:33'),
(13, 'organisation', 'org_email', 'dc-golaghat@nic.in', 'text', 'Email', NULL, 1, '2026-06-08 05:43:11', '2026-06-08 07:01:33'),
(14, 'organisation', 'org_logo', 'organisation/MVV1PpODM7doruQcMy6K5HT1hkFvnxmrixJ1Rq0d.png', 'file', 'Logo', NULL, 1, '2026-06-08 05:43:11', '2026-06-08 07:01:33'),
(15, 'organisation', 'org_website', 'https://golaghat.assam.gov.in/', 'text', 'Website', NULL, 1, '2026-06-08 05:43:11', '2026-06-08 07:01:33'),
(16, 'asset_tag', 'format', '{ORG_CODE}-{CAT_CODE}-{SEQ}', 'text', 'Asset Tag Format', NULL, 0, '2026-06-08 05:43:11', '2026-06-08 07:00:04'),
(17, 'asset_tag', 'org_code', 'GLT', 'text', 'Organisation Code', NULL, 0, '2026-06-08 05:43:11', '2026-06-08 07:00:04'),
(18, 'asset_tag', 'seq_digits', '4', 'integer', 'Sequence Digits', NULL, 0, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(19, 'asset_tag', 'auto_generate', '1', 'boolean', 'Auto Generate Tag', NULL, 0, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(20, 'notification', 'warranty_alert_days', '30', 'integer', 'Warranty Alert (days before expiry)', NULL, 0, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(21, 'notification', 'amc_alert_days', '30', 'integer', 'AMC Alert (days before expiry)', NULL, 0, '2026-06-08 05:43:11', '2026-06-08 05:43:11'),
(22, 'notification', 'email_notifications', '1', 'boolean', 'Enable Email Notifications', NULL, 0, '2026-06-08 05:43:12', '2026-06-08 05:43:12'),
(23, 'notification', 'admin_email', '', 'text', 'Admin Notification Email', NULL, 0, '2026-06-08 05:43:12', '2026-06-08 05:43:12'),
(24, 'backup', 'auto_backup', '0', 'boolean', 'Enable Auto Backup', NULL, 0, '2026-06-08 05:43:12', '2026-06-08 05:43:12'),
(25, 'backup', 'backup_frequency', 'daily', 'text', 'Backup Frequency', NULL, 0, '2026-06-08 05:43:12', '2026-06-08 05:43:12'),
(26, 'backup', 'backup_retention', '30', 'integer', 'Backup Retention Days', NULL, 0, '2026-06-08 05:43:12', '2026-06-08 05:43:12'),
(27, 'backup', 'backup_disk', 'local', 'text', 'Backup Disk', NULL, 0, '2026-06-08 05:43:12', '2026-06-08 05:43:12'),
(28, 'general', 'asset_tag_format', '{ORG_CODE}-{CAT_CODE}-{SEQ}', 'text', NULL, NULL, 0, '2026-06-08 07:00:04', '2026-06-08 07:00:04'),
(29, 'general', 'asset_tag_org_code', 'GLT', 'text', NULL, NULL, 0, '2026-06-08 07:00:04', '2026-06-08 07:00:04'),
(30, 'general', 'asset_tag_seq_digits', '4', 'text', NULL, NULL, 0, '2026-06-08 07:00:04', '2026-06-08 07:00:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Government Employee ID / Staff ID',
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('male','female','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation_id` bigint UNSIGNED DEFAULT NULL,
  `department_id` bigint UNSIGNED DEFAULT NULL COMMENT 'Will be set after departments table is created',
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Null if employee is not a system user',
  `role_id` bigint UNSIGNED DEFAULT NULL,
  `is_system_user` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'True if the employee has login access',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `joining_date` date DEFAULT NULL,
  `leaving_date` date DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_employee_id_unique` (`employee_id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_designation_id_foreign` (`designation_id`),
  KEY `users_status_is_system_user_index` (`status`,`is_system_user`),
  KEY `users_role_id_index` (`role_id`),
  KEY `users_department_id_index` (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `employee_id`, `name`, `email`, `mobile`, `gender`, `profile_photo`, `designation_id`, `department_id`, `password`, `role_id`, `is_system_user`, `email_verified_at`, `remember_token`, `status`, `joining_date`, `leaving_date`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'SA-0001', 'Super Administrator', 'ditec.golaghat@gmail.com', '7002274743', 'male', NULL, NULL, NULL, '$2y$12$6jIC10Zf44/Z6nRXkahbQuWmBYIot2OlmGd.wsHoEzPZoDfLE0coK', 1, 1, '2026-06-08 05:43:11', NULL, 'active', NULL, NULL, NULL, '2026-06-08 05:43:11', '2026-06-09 05:11:30', NULL),
(2, 'ABHI.GLT', 'Abhinandan Hazarika', 'abhi.glt@assam.gov.in', '8638869193', 'male', NULL, 19, NULL, '$2y$10$wXVDGT16q7P2miM/bYP7FO3NMWKX9NDoZfVhKizuod6pEIFvQQTXK', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 05:57:36', '2026-06-08 06:14:20', NULL),
(3, 'ANKUR.GLT', 'Ankur Borah', 'ankur.glt@assam.gov.in', '7896051473', 'male', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(4, 'AYUSMAN.GLT', 'Ayusman Puzari', 'ayusman.glt@assam.gov.in', '9706771418', 'male', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(5, 'BEDNATH.GLT', 'Bednath Hazarika', 'bednath.glt@assam.gov.in', '7002380316', 'male', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(6, 'BIJOY.GLT', 'Bijoy Gogoi', 'bijoy.glt@assam.gov.in', '8876862264', 'male', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(7, 'BIMAN.GLT', 'Biman Pathori', 'biman.glt@assam.gov.in', '7002576711', 'male', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(8, 'BINU.GLT', 'Binu Das', 'binu.glt@assam.gov.in', '6000036470', 'female', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(9, 'BUDHIN.GLT', 'Budhin Gohain', 'budhin.glt@assam.gov.in', '9435450726', 'male', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(10, 'DIPIKA.GLT', 'Dipika Momin', 'dipika.glt@assam.gov.in', '7002219064', 'female', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(11, 'ELANEOG.GLT', 'Ela Neog', 'elaneog.glt@assam.gov.in', '9706702156', 'female', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(12, 'FARID.BARUAH', 'Farid Hussain Baruah', 'farid.baruah@assam.gov.in', '9435354170', 'male', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(13, 'JORSING.GLT', 'Jorsing Engti', 'jorsing.glt@assam.gov.in', '8638005213', 'male', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(14, 'JOYDEEP.GLT', 'Joydeep Chetia', 'joydeep.glt@assam.gov.in', '8472995391', 'male', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(15, 'JULI.GLT', 'Juli Borah', 'juli.glt@assam.gov.in', '9101123487', 'female', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(16, 'KRISHNA.GLT', 'Krishna Baruah', 'krishna.glt@assam.gov.in', '8638614717', 'female', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(17, 'KUNJA.GLT', 'Kunja Hazarika', 'kunja.glt@assam.gov.in', '9435867003', 'female', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(18, 'MAMONIH.GLT', 'Mamoni Hazarika', 'mamonih.glt@assam.gov.in', '9435660760', 'female', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(19, 'MAMONIS.GLT', 'Mamoni Saikia', 'mamonis.glt@assam.gov.in', '9706591324', 'female', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(20, 'MASUM.GLT', 'Masum Farmin', 'masum.glt@assam.gov.in', '8638492512', 'female', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(21, 'MOMEE.GLT', 'Momee Hmar', 'momee.glt@assam.gov.in', '8638603570', 'female', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(22, 'MONIKHA.GLT', 'Monikha Saikia', 'monikha.glt@assam.gov.in', '8402922954', 'female', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(23, 'MUNNA.GLT', 'Munna Gogoi', 'munna.glt@assam.gov.in', '9435151228', 'male', NULL, 11, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(24, 'NIJARA.GLT', 'Nijara Saikia', 'nijara.glt@assam.gov.in', '7086119589', 'female', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(25, 'RAHUL.GLT', 'Rahul Gogoi', 'rahul.glt@assam.gov.in', '7002323368', 'male', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(26, 'NIREN.GLT', 'Niren Baruah', 'niren.glt@assam.gov.in', '9854436132', 'male', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(27, 'PAMELA.GLT', 'Pamela Hansepi', 'pamela.glt@assam.gov.in', '9401126513', 'female', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(28, 'PARTHA.GLT', 'Partha Pratim Saikia', 'partha.glt@assam.gov.in', '8638643969', 'male', NULL, 13, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(29, 'POLASH.GLT', 'Polash Loying', 'polash.glt@assam.gov.in', '7002207320', 'male', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(30, 'PRANJIT.GLT', 'Pranjiit Saikia', 'pranjit.glt@assam.gov.in', '7002786332', 'male', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(31, 'PRATAP.GLT', 'Pratap Ch Saikia', 'pratap.glt@assam.gov.in', '9678782322', 'male', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(32, 'PRATYUSH.GLT', 'Pratyush Parasar Sarma', 'pratyush.glt@assam.gov.in', '7002983643', 'male', NULL, 19, 1, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 2, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:58:37', NULL),
(33, 'RANJIT.GLT', 'Ranjit Sarma', 'ranjit.glt@assam.gov.in', '8399055375', 'male', NULL, 17, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(34, 'RANTUMONI.GLT', 'Rantumoni Das', 'rantumoni.glt@assam.gov.in', '9401105378', 'male', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(35, 'ROSHMI.GLT', 'Rashmi Rekha Bora', 'roshmi.glt@assam.gov.in', '7399199027', 'female', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(36, 'RINTIMONI.GLT', 'Rintimoni Dutta', 'rintimoni.glt@assam.gov.in', '8472983867', 'female', NULL, 20, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(37, 'RIPUN.GLT', 'RIPUN DUTTA', 'ripun.glt@assam.gov.in', '9435234628', 'male', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(38, 'SAMPRITY.GLT', 'Samprity Kaushik', 'samprity.glt@assam.gov.in', '7002440207', 'female', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(39, 'SANJUKTA.GLT', 'Sanjukta Gogoi', 'sanjukta.glt@assam.gov.in', '7002432017', 'female', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(40, 'SIKHAMONI.GLT', 'Sikha Moni Chutia', 'sikhamoni.glt@assam.gov.in', '7638071333', 'female', NULL, 18, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(41, 'MUSANNA.GLT', 'Syed Musanna Rahman', 'musanna.glt@assam.gov.in', '8638500327', 'male', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(42, 'TRIDIP.GLT', 'Tridip Saikia', 'tridip.glt@assam.gov.in', '9435488128', 'male', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(43, 'UJJAL.GLT', 'Ujjal Dutta', 'ujjal.glt@assam.gov.in', '9864704411', 'male', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(44, 'UJJWAL.GLT', 'UJJWAL BORA', 'ujjwal.glt@assam.gov.in', '7002406225', 'male', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(45, 'AMLAN.PHUKAN', 'Amlan Phukan, ACS', 'amlan.phukan@assam.gov.in', '8011639282', 'male', NULL, 4, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(46, 'BITUL.GLT', 'Bitul Hazarika', 'bitul.glt@assam.gov.in', '9101168273', 'male', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(47, 'MUSFIQUR.GLT', 'Musfiqur Rahman', 'musfiqur.glt@assam.gov.in', '9101157116', 'male', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(48, 'TARUNI.GLT', 'Taruni Rajkhowa', 'taruni.glt@assam.gov.in', '9365728909', 'female', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(49, 'BINOD.GLT', 'Binod Hazarika', 'binod.glt@assam.gov.in', '7896606098', 'male', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(50, 'MONOJ.GLT', 'Manoj Kumar Saikia', 'monoj.glt@assam.gov.in', '9101712154', 'male', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(51, 'MUNIN.GLT', 'Munindra Tanti', 'munin.glt@assam.gov.in', '8638611703', 'male', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(52, 'TULTUL.GLT', 'Tultul Das', 'tultul.glt@assam.gov.in', '7002274754', 'male', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(53, 'SWAGATA.GLT', 'Swagata Sarma', 'swagata.glt@assam.gov.in', '8723014004', 'female', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(54, 'KULDIP.HAZARIKA', 'Kuldip Hazarika, ACS', 'kuldip.hazarika@assam.gov.in', '9854180171', 'male', NULL, 3, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(55, 'SAKHTARA.AHMED', 'Sultana Akhtara Ahmed, ACS', 'sakhtara.ahmed@assam.gov.in', '9954302968', 'female', NULL, 3, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(56, 'RITURAJ.BORGOHAIN', 'Rituraj Borgohain', 'rituraj.borgohain@assam.gov.in', '9706786200', 'male', NULL, 9, 2, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 2, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-09 07:14:05', NULL),
(57, 'PABITRA.GLT', 'Pabitra Kr Sarmah', 'pabitra.glt@assam.gov.in', '9365080617', 'male', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(58, 'POLASH.HAZARIKA', 'Polash Hazarika', 'polash.hazarika@gmail.com', '9101589922', 'male', NULL, 25, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(59, 'JITU.GLT', 'Jitu Gogoi', 'jitu.glt@assam.gov.in', '9401126344', 'male', NULL, 21, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(60, 'SRI.ANIL.GHOSH', 'Anil Ghosh', 'sri.anil.ghosh@gmail.com', '7002328446', 'male', NULL, 26, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(61, 'Y.KASHYAP', 'Yasubant Kashyap', 'y.kashyap@gmail.com', '8471902265', 'male', NULL, 28, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(62, 'ABHILASH.GLT', 'Abhilash Sharma', 'abhilash.glt@assam.gov.in', '7002775172', 'male', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(63, 'HIRONGOGOI.GLT', 'Hiron Gogoi', 'hirongogoi.glt@assam.gov.in', '8638862350', 'male', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(64, 'GOLAGHAT', 'NIC, Golaghat', 'golaghat@nic.in', '9864260148', 'male', NULL, 22, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(65, 'VIVEK.GLT', 'Vivek Gogoi', 'vivek.glt@assam.gov.in', '7002612947', 'male', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(66, 'MAUSUM.GLT', 'Mausum Raj Khound', 'mausum.glt@assam.gov.in', '9101080837', 'male', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(67, 'MIRMILI.GLT', 'Mirmili Hansepi', 'mirmili.glt@assam.gov.in', '9678758250', 'female', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(68, 'AMIRUL.GLT', 'Amirul Hussain', 'amirul.glt@assam.gov.in', '7002451408', 'male', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(69, 'DEHADUTTA70', 'Himanshu Dutta', 'dehadutta70@gmail.com', '8638707257', 'male', NULL, 22, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(70, 'JITEN.GLT', 'Jiten Gogoi', 'jiten.glt@assam.gov.in', '7002299388', 'male', NULL, 12, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(71, 'SUBHAMHALDER293', 'Subham Halder', 'subhamhalder293@gmail.com', '9954275609', 'male', NULL, 22, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(72, 'SUMANBORAHBOKAKHAT', 'Suman Borah', 'Sumanborahbokakhat@gmail.com', '8638239207', 'male', NULL, 27, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(73, 'FARUKAZIZ53', 'Faruk Aziz', 'farukaziz53@gmail.com', '8876454128', 'male', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(74, 'CHANDASURAJ809', 'Suraj Chanda', 'chandasuraj809@gmail.com', '7896321838', 'male', NULL, 33, 1, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 3, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-09 07:08:31', NULL),
(75, 'SMITIREKHAB', 'Smritirekha Bora', 'smitirekhab@gmail.com', '7002209177', 'female', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(76, 'MOYUR.DHAN', 'Moyur Jyoti Saikia', 'moyur.dhan@assam.gov.in', '9954608754', 'male', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(77, 'KHOGEN.GLT', 'Khogen Chutia', 'khogen.glt@assam.gov.in', '94013182262', 'male', NULL, 22, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(78, 'ABHILASHDAS.2023', 'Abhilash Das, ACS', 'abhilashdas.2023@assam.gov.in', '9706539443', 'male', NULL, 4, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(79, 'MOUSUMIBARMAN.2023', 'Mousumi Barman, ACS', 'mousumibarman.2023@assam.gov.in', '7002032375', 'female', NULL, 4, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(80, 'NEHAPHUKON.2023', 'Neha Phukon, ACS', 'nehaphukon.2023@assam.gov.in', '8638122394', 'female', NULL, 4, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(81, 'RATULROY.2023', 'Ratul Roy, ACS', 'ratulroy.2023@assam.gov.in', '8369692764', 'male', NULL, 4, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(82, 'MANUJKR.BORA', 'Manuj Kr. Bora', 'manujkr.bora@assam.gov.in', '7002328297', 'male', NULL, 31, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(83, 'HOMENCHUTIA1', 'Homen Chutia', 'homenchutia1@gmail.com', '8721848925', 'male', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(84, 'BORUAHPRYAS', 'Prayas Borauh', 'boruahpryas@gmail.com', '9401911280', 'male', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(85, 'RUBY.RAY', 'Ruby Kumari Ray, ACS', 'ruby.ray@assam.gov.in', '8486636550', 'female', NULL, 5, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(86, 'DEBAJITGOGOI198902', 'Debojit Gogoi', 'debajitgogoi198902@gmail.com', '9101831432', 'male', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(87, 'GSINGH.ACS', 'Mr. Gurnel singh, ACS', 'gsingh.acs@assam.gov.in', '9435159160', 'female', NULL, 2, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(88, 'SUPRIYA.BAWLARI', 'Supriya Bawlari, ACS', 'Supriya.bawlari@assam.gov.in', '8486228948', 'female', NULL, 4, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(89, 'DC-GOLAGHAT', 'Smt. Pubali Gohain, ACS', 'dc-golaghat@nic.in', '9864024779', 'female', NULL, 1, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(90, 'SEUJ.DOHUTIA', 'Dr. Seuj Dohutia, ACS', 'Seuj.dohutia@assam.gov.in', '7002479199', 'male', NULL, 4, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(91, 'ASHUTOSH.DEKA', 'Ashutosh Deka, ACS', 'ashutosh.deka@assam.gov.in', '9854984921', 'male', NULL, 3, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(92, 'MONIKA.BORAH', 'Monika Borah, ACS', 'monika.borah@assam.gov.in', '8876992296', 'female', NULL, 3, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(93, 'JOYA.MECH26', 'Joya Mech', 'joya.mech26@assam.gov.in', '8486782549', 'female', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(94, 'REEMAREKHAB', 'Reema Rekha Borpatra Bora', 'reemarekhab@gmail.com', '8638050330', 'female', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(95, 'PRATIKSHA.GLT', 'Pratiksha Goswami', 'pratiksha.glt@assam.gov.in', '9954380089', 'female', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(96, 'ANSUMAN.BORAH26', 'Ansuman Bora', 'ansuman.borah26@assam.gov.in', '9954566314', 'male', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(97, 'ALAKESH.KAKATI2013', 'Alakesh Kakati', 'alakesh.kakati2013@assam.gov.in', '6001703212', 'male', NULL, 22, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(98, 'MANAB.NATHR69', 'Manab Nath', 'manab.nathr69@gmail.com', '8638334018', 'male', NULL, 22, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(99, 'SPODCGLT', 'Pankaj Khangia', 'spodcglt@gmail.com', '9365177918', 'male', NULL, 22, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(100, 'KOUSTABHBORUAH', 'Koustabh Boruah', 'koustabhboruah@gmail.com', '7002062174', 'male', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(101, 'BIPULKUMERDEKA40', 'Bipul Kumar Deka', 'bipulkumerdeka40@gmail.com', '9435062296', 'male', NULL, 30, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(102, 'GOLAP.GLT', 'Golap Boruah', 'Golap.glt@assam.gov.in', '9435576084', 'male', NULL, 16, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(103, 'PRASTUTI.BORA', 'Prastuti Bora', 'prastuti.bora@assam.gov.in', '8134974680', 'female', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(104, 'MRIDUSMITA.BORA26', 'Mridusmita Bora', 'mridusmita.bora26@assam.gov.in', '8011616099', 'female', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(105, 'RANJANPROTIM.GLT', 'Ranjan Protim Neog', 'ranjanprotim.glt@assam.gov.in', '8638691705', 'male', NULL, 19, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(106, 'PULAKGOGOI85', 'Pulak Gogoi', 'pulakgogoi85@gmail.com', '8876249937', 'male', NULL, 22, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 5, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:12:28', NULL),
(107, 'NF2.GG.AS', 'Pankaj Medhi', 'nf2.gg.as@support.gov.in', '7002490210', 'male', NULL, 22, 4, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 3, 1, NULL, NULL, 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-09 07:12:37', NULL),
(108, 'NFO1.GG.AS', 'Atikur Rahman', 'nfo1.gg.as@support.gov.in', '7002322020', 'male', NULL, 22, NULL, '$2y$12$MMCvggcqc9tAwPUSgXlYguPWndNlUr.C0CKeuoTV1z3iB9kwwcLFi', 3, 1, NULL, 'PiDI4wUxt6t2lqaxHVqhcPdIEGGlLjctNgeIFzX0QMkPChqMwXG7jb1ariYF', 'active', NULL, NULL, NULL, '2026-06-08 06:12:28', '2026-06-08 06:22:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions`
--

DROP TABLE IF EXISTS `user_permissions`;
CREATE TABLE IF NOT EXISTS `user_permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `permission_id` bigint UNSIGNED NOT NULL,
  `type` enum('grant','deny') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'grant' COMMENT 'grant = extra permission, deny = revoke from role',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_permissions_user_id_permission_id_unique` (`user_id`,`permission_id`),
  KEY `user_permissions_permission_id_foreign` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

DROP TABLE IF EXISTS `vendors`;
CREATE TABLE IF NOT EXISTS `vendors` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Vendor short code',
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pincode` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'India',
  `gstin` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'GST Identification Number',
  `pan` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_no` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_ifsc` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provides_amc` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Whether vendor provides AMC service',
  `amc_terms` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vendors_code_unique` (`code`),
  KEY `vendors_created_by_foreign` (`created_by`),
  KEY `vendors_updated_by_foreign` (`updated_by`),
  KEY `vendors_status_index` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `code`, `name`, `contact_person`, `mobile`, `phone`, `email`, `website`, `address`, `city`, `state`, `pincode`, `country`, `gstin`, `pan`, `bank_name`, `bank_account_no`, `bank_ifsc`, `provides_amc`, `amc_terms`, `status`, `notes`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 'Brihaspathi Technologies Pvt. Ltd.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'India', NULL, NULL, NULL, NULL, NULL, 0, NULL, 'active', NULL, 1, NULL, '2026-06-09 02:51:38', '2026-06-09 02:51:38', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `assets_assigned_department_id_foreign` FOREIGN KEY (`assigned_department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `assets_assigned_employee_id_foreign` FOREIGN KEY (`assigned_employee_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `assets_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `asset_categories` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `assets_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `assets_home_department_id_foreign` FOREIGN KEY (`home_department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `assets_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `assets_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `asset_assignments`
--
ALTER TABLE `asset_assignments`
  ADD CONSTRAINT `asset_assignments_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `asset_assignments_authorized_by_foreign` FOREIGN KEY (`authorized_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `asset_assignments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `asset_assignments_from_department_id_foreign` FOREIGN KEY (`from_department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `asset_assignments_from_employee_id_foreign` FOREIGN KEY (`from_employee_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `asset_assignments_to_department_id_foreign` FOREIGN KEY (`to_department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `asset_assignments_to_employee_id_foreign` FOREIGN KEY (`to_employee_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `asset_categories`
--
ALTER TABLE `asset_categories`
  ADD CONSTRAINT `asset_categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `asset_categories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `asset_documents`
--
ALTER TABLE `asset_documents`
  ADD CONSTRAINT `asset_documents_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `asset_documents_assignment_id_foreign` FOREIGN KEY (`assignment_id`) REFERENCES `asset_assignments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `asset_documents_maintenance_id_foreign` FOREIGN KEY (`maintenance_id`) REFERENCES `asset_maintenances` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `asset_documents_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `asset_maintenances`
--
ALTER TABLE `asset_maintenances`
  ADD CONSTRAINT `asset_maintenances_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `asset_maintenances_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `asset_maintenances_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `asset_maintenances_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `backup_logs`
--
ALTER TABLE `backup_logs`
  ADD CONSTRAINT `backup_logs_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_head_user_id_foreign` FOREIGN KEY (`head_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `departments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ip_allocations`
--
ALTER TABLE `ip_allocations`
  ADD CONSTRAINT `ip_allocations_allocated_by_foreign` FOREIGN KEY (`allocated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ip_allocations_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ip_allocations_ip_address_id_foreign` FOREIGN KEY (`ip_address_id`) REFERENCES `ip_addresses` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `ip_allocations_released_by_foreign` FOREIGN KEY (`released_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ip_allocations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_designation_id_foreign` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD CONSTRAINT `user_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vendors`
--
ALTER TABLE `vendors`
  ADD CONSTRAINT `vendors_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `vendors_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
