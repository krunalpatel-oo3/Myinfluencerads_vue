-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 09, 2023 at 01:27 PM
-- Server version: 8.0.21
-- PHP Version: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `narola_machine`
--

-- --------------------------------------------------------

--
-- Table structure for table `attend_tickets`
--

DROP TABLE IF EXISTS `attend_tickets`;
CREATE TABLE IF NOT EXISTS `attend_tickets` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `start_time` timestamp NOT NULL,
  `close_time` timestamp NULL DEFAULT NULL,
  `start_location` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_location` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attend_tickets_ticket_id_index` (`ticket_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `broadcast`
--

DROP TABLE IF EXISTS `broadcast`;
CREATE TABLE IF NOT EXISTS `broadcast` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_ids` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint NOT NULL DEFAULT '1' COMMENT '0="warning", 1="success"',
  `message` text COLLATE utf8mb4_unicode_ci,
  `started_at` timestamp NULL DEFAULT NULL,
  `expired_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0="In-active", 1= "Active"',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_branches`
--

DROP TABLE IF EXISTS `client_branches`;
CREATE TABLE IF NOT EXISTS `client_branches` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` bigint UNSIGNED DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0="In-active", 1= "Active"',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `client_branches_client_id_index` (`client_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
CREATE TABLE IF NOT EXISTS `companies` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0="In-active", 1= "Active"',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `location`, `contact_number`, `logo`, `status`, `created_at`, `updated_at`) VALUES
(2, 'KGirdharlal International Pvt Ltd', 'Surat / Gujarat - 395008', NULL, NULL, 1, '2023-05-30 03:29:50', '2023-05-30 06:54:49'),
(3, 'Concept Medical Research Pvt Ltd', 'Surat / Gujarat - 395001', '9898989898', NULL, 1, '2023-05-30 03:30:35', '2023-06-09 05:41:32'),
(5, 'Hare krishna (HARE RAM)', 'Pal RTO', NULL, '1685682184_mark-hennick-EyP5jw-ZAU0-unsplash.jpg', 1, '2023-05-30 06:00:35', '2023-06-01 23:33:04'),
(27, 'Crest', 'Surat Lp s', '9721000321', NULL, 1, '2023-06-02 01:59:46', '2023-06-02 03:43:47');

-- --------------------------------------------------------

--
-- Table structure for table `company_branches`
--

DROP TABLE IF EXISTS `company_branches`;
CREATE TABLE IF NOT EXISTS `company_branches` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` bigint UNSIGNED DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0="In-active", 1= "Active"',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `company_branches_company_id_index` (`company_id`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_branches`
--

INSERT INTO `company_branches` (`id`, `name`, `location`, `company_id`, `status`, `created_at`, `updated_at`) VALUES
(68, 'test 7', 'test 7', 3, 1, '2023-06-09 05:41:32', '2023-06-09 05:41:32'),
(67, 'test 6', 'test 6', 3, 1, '2023-06-09 05:41:32', '2023-06-09 05:41:32'),
(3, 'Narola Branch 2', 'Location 11, Adajan', 3, 1, '2023-05-30 03:30:35', '2023-05-30 03:30:35'),
(62, 'test 1', 'test 1', 3, 1, '2023-06-09 05:41:32', '2023-06-09 05:41:32'),
(63, 'test 2', 'test 2', 3, 1, '2023-06-09 05:41:32', '2023-06-09 05:41:32'),
(64, 'test 3', 'test 3', 3, 1, '2023-06-09 05:41:32', '2023-06-09 05:41:32'),
(7, 'NEW 122', 'LOCA 2', 2, 1, '2023-05-30 06:32:22', '2023-05-30 06:43:02'),
(8, 'Ne 2', 'Loc 23', 2, 1, '2023-05-30 06:32:44', '2023-05-30 06:32:44'),
(37, 'n10', '10', 5, 1, '2023-05-31 06:44:44', '2023-05-31 06:44:44'),
(40, 'n168', '168', 3, 1, '2023-05-31 06:57:54', '2023-05-31 07:35:27'),
(19, 'NEW ', 'LOCAKK', 5, 1, '2023-05-31 05:12:35', '2023-05-31 05:12:35'),
(66, 'test 5', 'test 5', 3, 1, '2023-06-09 05:41:32', '2023-06-09 05:41:32'),
(65, 'test 4', 'test 4', 3, 1, '2023-06-09 05:41:32', '2023-06-09 05:41:32'),
(69, 'test 8', 'test 8', 3, 1, '2023-06-09 05:41:32', '2023-06-09 05:41:32'),
(70, 'test 9', 'test 9', 3, 1, '2023-06-09 05:41:32', '2023-06-09 05:41:32'),
(71, 'test 10', 'test 10', 3, 1, '2023-06-09 05:41:32', '2023-06-09 05:41:32');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

DROP TABLE IF EXISTS `feedbacks`;
CREATE TABLE IF NOT EXISTS `feedbacks` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `rating` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `feedbacks_user_id_index` (`user_id`),
  KEY `feedbacks_ticket_id_index` (`ticket_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `km_allowances`
--

DROP TABLE IF EXISTS `km_allowances`;
CREATE TABLE IF NOT EXISTS `km_allowances` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `km` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `km_allowances_user_id_index` (`user_id`),
  KEY `km_allowances_ticket_id_index` (`ticket_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_status`
--

DROP TABLE IF EXISTS `login_status`;
CREATE TABLE IF NOT EXISTS `login_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `verify_token` varchar(100) NOT NULL,
  `expired_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `login_status`
--

INSERT INTO `login_status` (`id`, `user_id`, `verify_token`, `expired_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'ZmfzJUuHBuAhVQ971TRdAeAHt5DnxI', '2023-06-09 13:17:17', '2023-05-24 00:37:27', '2023-06-09 07:45:17');

-- --------------------------------------------------------

--
-- Table structure for table `machines`
--

DROP TABLE IF EXISTS `machines`;
CREATE TABLE IF NOT EXISTS `machines` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `assign_id` bigint UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0="In-active", 1= "Active"',
  `amc_status` tinyint DEFAULT NULL,
  `amc_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `machines_assign_id_index` (`assign_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(17, '2023_05_17_104059_create_clients_table', 2),
(7, '2023_05_17_111624_create_machines_table', 1),
(8, '2023_05_17_112635_create_user_role_table', 1),
(9, '2023_05_17_112914_create_user_location_table', 1),
(10, '2023_05_17_114124_create_tickets_table', 1),
(11, '2023_05_17_114221_create_problems_table', 1),
(12, '2023_05_17_115349_create_attend_tickets_table', 1),
(13, '2023_05_17_122524_create_ticket_media_table', 1),
(14, '2023_05_17_123204_create_km_allowances_table', 1),
(15, '2023_05_17_124020_create_feedbacks_table', 1),
(16, '2023_05_17_124711_create_broadcast_table', 1),
(19, '2023_05_17_110721_create_client_branches_table', 3),
(20, '2023_05_30_084930_create_companies_table', 4),
(21, '2023_05_30_085028_create_company_branches_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'MyApp', '951c75a1c17bcabdb27267e8e8cc9c8b0a0204166f9e00434381e3c2c062f0ac', '[\"*\"]', NULL, NULL, '2023-05-23 06:48:03', '2023-05-23 06:48:03'),
(2, 'App\\Models\\User', 1, 'Narola_Machine', '328e3036ed4702700d0e0c6d97c9e6e463f747142f0d6c5d881cc0e39e649956', '[\"*\"]', NULL, NULL, '2023-05-23 06:55:31', '2023-05-23 06:55:31'),
(3, 'App\\Models\\User', 1, 'Narola_Machine', 'f3c8be3ea0c43a06e1e55f9cd8ac3adbfb317b1f54137a1d26cd73bd2e2be056', '[\"*\"]', NULL, NULL, '2023-05-23 06:56:10', '2023-05-23 06:56:10'),
(4, 'App\\Models\\User', 1, 'Narola_Machine', '2c25f8e14b3942fabbed6e271aeaafa697524b0b3869e35b626916c6ad292c0d', '[\"*\"]', NULL, NULL, '2023-05-23 06:58:37', '2023-05-23 06:58:37'),
(5, 'App\\Models\\User', 1, 'Narola_Machine', 'bf8ae54aeb2c68220c5ab5da18d2d227362023ca19886ae7e1484e534f83aff9', '[\"*\"]', NULL, NULL, '2023-05-23 06:58:55', '2023-05-23 06:58:55'),
(6, 'App\\Models\\User', 1, 'Narola_Machine', '5d47d1b568dc29151b51193ef43a59666e19fa3a183826d63c457c2784307f84', '[\"*\"]', NULL, NULL, '2023-05-23 06:59:34', '2023-05-23 06:59:34'),
(7, 'App\\Models\\User', 1, 'Narola_Machine', '2955cc0defed6d23075e5d63f38c0678733dc72873b5ee2fb4acb1750c417136', '[\"*\"]', NULL, NULL, '2023-05-23 07:00:05', '2023-05-23 07:00:05'),
(8, 'App\\Models\\User', 1, 'Narola_Machine', '9dfcd6e1e174df106968b290d479c2bdb8c0a0fced5709e285a39ca2a2967784', '[\"*\"]', NULL, NULL, '2023-05-23 07:13:36', '2023-05-23 07:13:36'),
(9, 'App\\Models\\User', 1, 'Narola_Machine', 'fd704fbbd10a5606c017f537e2fb05919cec1c48286b525bdbeb23cc4b6c272b', '[\"*\"]', NULL, NULL, '2023-05-23 22:21:18', '2023-05-23 22:21:18'),
(10, 'App\\Models\\User', 1, 'Narola_Machine', '46d102efcdcb0f6236f45d5bb00032123ffcc55477311e6ddd0849ffe2a0adcf', '[\"*\"]', NULL, NULL, '2023-05-23 23:11:05', '2023-05-23 23:11:05'),
(11, 'App\\Models\\User', 1, 'Narola_Machine', '50e6272989657538ffa66136bd7c6ed10d5aa6ec3bf159580bab7d056157232d', '[\"*\"]', NULL, NULL, '2023-05-23 23:47:37', '2023-05-23 23:47:37'),
(12, 'App\\Models\\User', 1, 'Narola_Machine', 'e96fb538b33221a91a3ba61ad7f5ad5f518062d6fef81108a6f27d7878f7f3d7', '[\"*\"]', NULL, NULL, '2023-05-24 04:37:11', '2023-05-24 04:37:11'),
(13, 'App\\Models\\User', 1, 'Narola_Machine', '7896dc58e011d14a1feff59b69301468c60de3fae58126cf0627687854069e07', '[\"*\"]', NULL, NULL, '2023-05-24 23:41:16', '2023-05-24 23:41:16'),
(14, 'App\\Models\\User', 1, 'Narola_Machine', '8fc3c73bc0599337d2aa085f38408234fd5304d8afb103a7d364ef21ad906e40', '[\"*\"]', NULL, NULL, '2023-05-25 00:21:32', '2023-05-25 00:21:32'),
(15, 'App\\Models\\User', 1, 'Narola_Machine', '5334a9e5afd8b30058551705be4c7ba351316a126705bcca182af0a30fa0e5ef', '[\"*\"]', NULL, NULL, '2023-05-25 00:49:46', '2023-05-25 00:49:46'),
(16, 'App\\Models\\User', 1, 'Narola_Machine', 'b935e2422f1e72f2db3088a81444a28344d6b55329eef1a23cc25407518ec019', '[\"*\"]', NULL, NULL, '2023-05-25 00:55:50', '2023-05-25 00:55:50'),
(17, 'App\\Models\\User', 1, 'Narola_Machine', 'c6bf8895bd3e43c5c7a2ef605e5502d8840d018ff50c9e42626814075f805c1a', '[\"*\"]', NULL, NULL, '2023-05-25 01:00:26', '2023-05-25 01:00:26'),
(18, 'App\\Models\\User', 1, 'Narola_Machine', 'cf3e9f43ced83690adb78edd786b5a6e0bbe7d51c3846847d9144027cf08527d', '[\"*\"]', NULL, NULL, '2023-05-25 01:17:24', '2023-05-25 01:17:24'),
(19, 'App\\Models\\User', 1, 'Narola_Machine', '622345bf32bcfe18d045cc53f54f96f447d8c70dec52b40ff614b80f381d9a6d', '[\"*\"]', NULL, NULL, '2023-05-25 01:59:45', '2023-05-25 01:59:45'),
(20, 'App\\Models\\User', 1, 'Narola_Machine', 'a5aa3c595c81ed1e665629a6dc335bf36f6c27fc35e436d6fed9d58e0810acd6', '[\"*\"]', NULL, NULL, '2023-05-25 02:00:48', '2023-05-25 02:00:48'),
(21, 'App\\Models\\User', 1, 'Narola_Machine', 'e9d8a8faec9b94b2e1b6b59164a3015321a7fde5587f3c7eb6aa655c6e38bc3c', '[\"*\"]', NULL, NULL, '2023-05-25 04:24:05', '2023-05-25 04:24:05'),
(22, 'App\\Models\\User', 1, 'Narola_Machine', '93d970a9b7007c1c305a71f3744d7f379984dbed696e0dde29cb426a549b8a13', '[\"*\"]', NULL, NULL, '2023-05-25 04:35:56', '2023-05-25 04:35:56'),
(23, 'App\\Models\\User', 1, 'Narola_Machine', 'b8395aa5a0224aab4c97588ee2e870a79394afe55a1ffccd2720200041ecaee2', '[\"*\"]', NULL, NULL, '2023-05-25 07:11:20', '2023-05-25 07:11:20'),
(24, 'App\\Models\\User', 1, 'Narola_Machine', 'f47011065feecd2fa0bbb84a0a1af99ac4a7cfa3456def9d02db615f8b6c5791', '[\"*\"]', NULL, NULL, '2023-05-25 07:13:32', '2023-05-25 07:13:32'),
(25, 'App\\Models\\User', 1, 'Narola_Machine', '6a54e103ae12da1f64e4605a9c7bc52ddd317e14d75aab038859e6b938ea6463', '[\"*\"]', NULL, NULL, '2023-05-25 07:18:11', '2023-05-25 07:18:11'),
(26, 'App\\Models\\User', 1, 'Narola_Machine', '842e328c0c55434b0da3af3549f178aaf85318c33f32d6343eb7858965931b24', '[\"*\"]', NULL, NULL, '2023-05-25 22:35:04', '2023-05-25 22:35:04'),
(27, 'App\\Models\\User', 1, 'Narola_Machine', '1b2a313b8404f5dc0a69af0b10579285f5a0435f385ebd10dc987c1feb21c553', '[\"*\"]', NULL, NULL, '2023-05-26 01:42:27', '2023-05-26 01:42:27'),
(28, 'App\\Models\\User', 1, 'Narola_Machine', 'e91c2b407059c66bb16abda810e6ea340f8919ad866c099290aac305faa5608c', '[\"*\"]', NULL, NULL, '2023-05-26 03:02:57', '2023-05-26 03:02:57'),
(29, 'App\\Models\\User', 1, 'Narola_Machine', '4ccd631538538d5584d4317d54531b37a4dd682d8942f74fe8106e89f3ad493b', '[\"*\"]', NULL, NULL, '2023-05-26 03:18:06', '2023-05-26 03:18:06'),
(30, 'App\\Models\\User', 1, 'Narola_Machine', '3535c4e21eeb21bf6db23cdc2387767c3b93d3cc90395e84182022d6fe4338a5', '[\"*\"]', NULL, NULL, '2023-05-26 05:39:38', '2023-05-26 05:39:38'),
(31, 'App\\Models\\User', 1, 'Narola_Machine', '01d64dec492ba23ae09d06fa12ae845b92b3fdd689654535f1af4193f3efcd3a', '[\"*\"]', NULL, NULL, '2023-05-26 05:46:52', '2023-05-26 05:46:52'),
(32, 'App\\Models\\User', 1, 'Narola_Machine', '288270e5ac7fab13ffcf1619deb97a63d212aef08c6c47edd86bc83026b09680', '[\"*\"]', NULL, NULL, '2023-05-26 05:48:44', '2023-05-26 05:48:44'),
(33, 'App\\Models\\User', 1, 'Narola_Machine', 'feeb914db0bd3b50cebb2ef3b59f52f68dc2d7a55b3fa069669fbcfe00c20952', '[\"*\"]', NULL, NULL, '2023-05-28 23:33:48', '2023-05-28 23:33:48'),
(34, 'App\\Models\\User', 1, 'Narola_Machine', 'c79fba290e6cdc2d6a15a9781167f5a5b1005f56b14157cce8d95c15e85b3f8d', '[\"*\"]', NULL, NULL, '2023-05-29 00:12:49', '2023-05-29 00:12:49'),
(35, 'App\\Models\\User', 1, 'Narola_Machine', '17bec4e02fb836fdf709a956ab2725faa0959bbe83f57a1a2f48159dc074e79d', '[\"*\"]', NULL, NULL, '2023-05-29 03:40:54', '2023-05-29 03:40:54'),
(36, 'App\\Models\\User', 1, 'Narola_Machine', '61b35da458caa5a0454fb52b30736b2ec3becf0d60da6659cb45c35f6b36e97a', '[\"*\"]', NULL, NULL, '2023-05-29 03:42:24', '2023-05-29 03:42:24'),
(37, 'App\\Models\\User', 1, 'Narola_Machine', '9c67ca21cb446bf129fbe88b978464031819828ffb718c5c38c41abfb0c2b159', '[\"*\"]', NULL, NULL, '2023-05-29 22:44:30', '2023-05-29 22:44:30'),
(38, 'App\\Models\\User', 1, 'Narola_Machine', 'a700cce06a843483fc43c40ab8f7ea91a3b90f8f6fce6408a94768d5e12df86d', '[\"*\"]', NULL, NULL, '2023-05-29 23:35:23', '2023-05-29 23:35:23'),
(39, 'App\\Models\\User', 1, 'Narola_Machine', 'eb2f18c576385d3e3671150a186efa24547eb68aba75ebce40cdcd73a2ad7085', '[\"*\"]', NULL, NULL, '2023-05-30 22:09:54', '2023-05-30 22:09:54'),
(40, 'App\\Models\\User', 1, 'Narola_Machine', '6a50b468ae3d1325324dd4c8262d0e218c978923cd429c246459bd9d07134d4e', '[\"*\"]', NULL, NULL, '2023-05-31 22:31:44', '2023-05-31 22:31:44'),
(41, 'App\\Models\\User', 1, 'Narola_Machine', '7a2d85d02a39484f70325a70478b41ea06cd991204e766e6a283359cff70a400', '[\"*\"]', NULL, NULL, '2023-06-01 01:38:56', '2023-06-01 01:38:56'),
(42, 'App\\Models\\User', 1, 'Narola_Machine', '6f2f7eb0b621d30e46d98fd6783aa727412b60bf28ae4507bb178500eb468550', '[\"*\"]', NULL, NULL, '2023-06-01 04:14:04', '2023-06-01 04:14:04'),
(43, 'App\\Models\\User', 1, 'Narola_Machine', 'a8c1b28209878210f49bf99100634032726e857bdeda67d9cc14e8620e3ce88f', '[\"*\"]', NULL, NULL, '2023-06-01 22:34:17', '2023-06-01 22:34:17'),
(44, 'App\\Models\\User', 1, 'Narola_Machine', 'f568bea5bd6283eb2d3c20bfc2547fa298da616178c75819c925e852c37fe7f2', '[\"*\"]', NULL, NULL, '2023-06-04 23:16:26', '2023-06-04 23:16:26'),
(45, 'App\\Models\\User', 1, 'Narola_Machine', 'dfbc65162bcdbaee0f805eed40c504389f43d9918ee414ae8c374d18a20f1d96', '[\"*\"]', NULL, NULL, '2023-06-05 06:44:51', '2023-06-05 06:44:51'),
(46, 'App\\Models\\User', 1, 'Narola_Machine', '89040aac3e5187dc5047d0a7f929385c1cb8278792f1281ca7b6372fb46481da', '[\"*\"]', NULL, NULL, '2023-06-05 22:15:00', '2023-06-05 22:15:00'),
(47, 'App\\Models\\User', 1, 'Narola_Machine', 'e5bf177f67b2b80148007a7a5b93ac30a9228de61fe3c24f34392a997733eade', '[\"*\"]', NULL, NULL, '2023-06-06 04:00:17', '2023-06-06 04:00:17'),
(48, 'App\\Models\\User', 1, 'Narola_Machine', '5ee5cb9fe64cdd44eff22f99eac9d6ed60aa012d3047b4a1659b4eff7ba4a48b', '[\"*\"]', NULL, NULL, '2023-06-06 04:06:04', '2023-06-06 04:06:04'),
(49, 'App\\Models\\User', 1, 'Narola_Machine', '4bec25a9321ac2b13247cb23a528c9a81f9da22af2ccfb20bb4a279dfd2ac532', '[\"*\"]', NULL, NULL, '2023-06-06 04:07:47', '2023-06-06 04:07:47'),
(50, 'App\\Models\\User', 1, 'Narola_Machine', '2a8d4a13c01f47a6e810746373f151a4d6b66a2304a402e09b914c072a1e262e', '[\"*\"]', NULL, NULL, '2023-06-06 04:08:19', '2023-06-06 04:08:19'),
(51, 'App\\Models\\User', 1, 'Narola_Machine', 'b57e1336484a25c50e1f489cb6536f0b1e4c2eef1e60358551694d68906cdb03', '[\"*\"]', NULL, NULL, '2023-06-06 04:23:47', '2023-06-06 04:23:47'),
(52, 'App\\Models\\User', 1, 'Narola_Machine', 'ba7010b789909d9facd46b4b17a2d439f0186b63b69493406286a5a75a2cf696', '[\"*\"]', NULL, NULL, '2023-06-06 04:33:37', '2023-06-06 04:33:37'),
(53, 'App\\Models\\User', 1, 'Narola_Machine', '0a6c1819291d24ea1cdf24124e3d7935a698adcd2b1929cea9a25d4b73688da3', '[\"*\"]', NULL, NULL, '2023-06-06 04:38:20', '2023-06-06 04:38:20'),
(54, 'App\\Models\\User', 1, 'Narola_Machine', '7237eb9f2b9f7b613108d0ce0c6959109289f8cb8ac78ae03257d34d768f2d73', '[\"*\"]', NULL, NULL, '2023-06-06 04:45:23', '2023-06-06 04:45:23'),
(55, 'App\\Models\\User', 1, 'Narola_Machine', '2af0c794bdecde1d4a5360b9e1be9764f7da0f5a22bc974e6362366550ae64f8', '[\"*\"]', NULL, NULL, '2023-06-06 05:12:27', '2023-06-06 05:12:27'),
(56, 'App\\Models\\User', 1, 'Narola_Machine', '837d29cd8afcc0788634abd4a6133394b8b8e1b23686d51e0b931502949683f1', '[\"*\"]', NULL, NULL, '2023-06-06 05:18:28', '2023-06-06 05:18:28'),
(57, 'App\\Models\\User', 1, 'Narola_Machine', '59f0e1ea9af1505f877f78c4ef59956c8a31a0d3101b93a22ca864d459d84cef', '[\"*\"]', NULL, NULL, '2023-06-06 05:26:24', '2023-06-06 05:26:24'),
(58, 'App\\Models\\User', 1, 'Narola_Machine', 'f61c12cc2eaa2ef2f6a8e4c58e115b6ec1ecf20f1729c8f158135096bfa9d61b', '[\"*\"]', NULL, NULL, '2023-06-06 05:27:02', '2023-06-06 05:27:02'),
(59, 'App\\Models\\User', 1, 'Narola_Machine', 'ff90c2757c6aed2a9aee9bcf41c3bdde79ea8ad00af275904fe91f928fc325d4', '[\"*\"]', NULL, NULL, '2023-06-06 06:11:45', '2023-06-06 06:11:45'),
(60, 'App\\Models\\User', 1, 'Narola_Machine', 'a3f2d6dd6ed335e9ee7b036cfb3382ed1821e58c27a56dd47c8d83c7842fc7e5', '[\"*\"]', NULL, NULL, '2023-06-06 06:12:32', '2023-06-06 06:12:32'),
(61, 'App\\Models\\User', 1, 'Narola_Machine', '737d5871f634e3415597915e95cf4833d4346b6e3129bb50d14223691d676b1f', '[\"*\"]', NULL, NULL, '2023-06-06 06:13:02', '2023-06-06 06:13:02'),
(62, 'App\\Models\\User', 1, 'Narola_Machine', '4263c1197835b9baab9b12c7f18c19e53fcfb406e691b576f84255f2332cf533', '[\"*\"]', NULL, NULL, '2023-06-06 21:51:51', '2023-06-06 21:51:51'),
(63, 'App\\Models\\User', 1, 'Narola_Machine', '2d5db7284b6dd2c23e06788afda1019772b55ac06dae20104c0677ae788bceb0', '[\"*\"]', NULL, NULL, '2023-06-07 01:24:22', '2023-06-07 01:24:22'),
(64, 'App\\Models\\User', 1, 'Narola_Machine', 'a022e1a4b9308edf021bae11672110ff4fbb0ca82220456cf81cb51efdb4c741', '[\"*\"]', NULL, NULL, '2023-06-07 03:56:34', '2023-06-07 03:56:34'),
(65, 'App\\Models\\User', 1, 'Narola_Machine', '36c1c90d017136bff15beec50b9e9d4a4b2b2ebc527a6d70c39e78be3373827e', '[\"*\"]', NULL, NULL, '2023-06-07 04:47:41', '2023-06-07 04:47:41'),
(66, 'App\\Models\\User', 1, 'Narola_Machine', '36d97eb32356736a048b47bc5a74e755b210b3f8ecaf7b3ad6153bd784c4068b', '[\"*\"]', NULL, NULL, '2023-06-07 22:33:32', '2023-06-07 22:33:32'),
(67, 'App\\Models\\User', 1, 'Narola_Machine', '8d61c5967e571578741e45919e16d92f642c3ef71b1a6aab9040da5b5f083291', '[\"*\"]', NULL, NULL, '2023-06-07 22:40:06', '2023-06-07 22:40:06'),
(68, 'App\\Models\\User', 1, 'Narola_Machine', '41b3eefee6c7cbbfa5a1d87868f5207e50d2724443db32b218bd68cf639905f4', '[\"*\"]', NULL, NULL, '2023-06-08 05:41:14', '2023-06-08 05:41:14'),
(69, 'App\\Models\\User', 1, 'Narola_Machine', '6ec27ee595e4600122d93bb512a30b23b546b273516da57b345bb30ab86a7ee9', '[\"*\"]', NULL, NULL, '2023-06-08 06:10:56', '2023-06-08 06:10:56'),
(70, 'App\\Models\\User', 1, 'Narola_Machine', 'ed73fa976ba1f909ac22ba086ee9159e447d2cd9b976a4f97349d76b37838d08', '[\"*\"]', NULL, NULL, '2023-06-08 22:16:09', '2023-06-08 22:16:09'),
(71, 'App\\Models\\User', 1, 'Narola_Machine', 'cae9c73bf4f6d876663346e778d5140c6e332f95a92b08426b2cab0492e542a0', '[\"*\"]', NULL, NULL, '2023-06-08 23:28:44', '2023-06-08 23:28:44'),
(72, 'App\\Models\\User', 1, 'Narola_Machine', '6ca8625c97381394cdf3daeb308cc8276c3150acc2b411de3013e7f65282e963', '[\"*\"]', NULL, NULL, '2023-06-09 01:02:09', '2023-06-09 01:02:09'),
(73, 'App\\Models\\User', 1, 'Narola_Machine', 'd63ee8fe6514761081a5bc4150d29c82d5751a0f0b67c3ac5112f3ce5e5c5622', '[\"*\"]', NULL, NULL, '2023-06-09 02:57:42', '2023-06-09 02:57:42'),
(74, 'App\\Models\\User', 1, 'Narola_Machine', 'ddd66e776d63b0eb41e9717887f0ac1263868c7c6ac6c4689d5ec42ac29cc0ad', '[\"*\"]', NULL, NULL, '2023-06-09 06:00:18', '2023-06-09 06:00:18'),
(75, 'App\\Models\\User', 1, 'Narola_Machine', 'c8246261087be68904f80fb9fd03eda7f332cf54be2bf091cb89579d7283e1a1', '[\"*\"]', NULL, NULL, '2023-06-09 07:03:12', '2023-06-09 07:03:12'),
(76, 'App\\Models\\User', 1, 'Narola_Machine', 'bd70cd99e910e18d018919052377b13e5698e979fc0b4a825efa506ba7f165f6', '[\"*\"]', NULL, NULL, '2023-06-09 07:55:32', '2023-06-09 07:55:32');

-- --------------------------------------------------------

--
-- Table structure for table `problems`
--

DROP TABLE IF EXISTS `problems`;
CREATE TABLE IF NOT EXISTS `problems` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0="In-active", 1= "Active"',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
CREATE TABLE IF NOT EXISTS `tickets` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `descritpion` text COLLATE utf8mb4_unicode_ci,
  `problem_id` bigint UNSIGNED NOT NULL,
  `machine_id` bigint UNSIGNED NOT NULL,
  `assign_id` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1="Open"\n            2="Pending"\n            3="On-hold"\n            4="Solved"\n            5="Re-open"',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tickets_problem_id_index` (`problem_id`),
  KEY `tickets_machine_id_index` (`machine_id`),
  KEY `tickets_assign_id_index` (`assign_id`),
  KEY `tickets_created_by_index` (`created_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_media`
--

DROP TABLE IF EXISTS `ticket_media`;
CREATE TABLE IF NOT EXISTS `ticket_media` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `photo` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `audio` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ticket_media_ticket_id_index` (`ticket_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_role_id` int UNSIGNED NOT NULL,
  `company_id` bigint DEFAULT NULL,
  `branch_id` bigint UNSIGNED DEFAULT NULL,
  `mobile_number` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_picture` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0="In-active", 1= "Active"',
  `login_at` timestamp NULL DEFAULT NULL,
  `logout_at` timestamp NULL DEFAULT NULL,
  `password_reset_token` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verify_string` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_branch_id_foreign` (`branch_id`),
  KEY `users_user_role_id_index` (`user_role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `password`, `remember_token`, `user_role_id`, `company_id`, `branch_id`, `mobile_number`, `profile_picture`, `status`, `login_at`, `logout_at`, `password_reset_token`, `verify_string`, `created_at`, `updated_at`) VALUES
(1, 'Admin1', 'Narolas', '$2y$10$Cw5qr0pMJ6APqUI30ehIqOzJx8R1kXJeL5rVjYqc1Am8CWKq5iivO', NULL, 1, NULL, NULL, '9737800015', '1685518227_Mobile-login.jpg', 0, NULL, NULL, '123456', NULL, '2023-05-23 04:04:51', '2023-06-09 07:45:17'),
(2, 'Dhaval', 'brd', NULL, NULL, 2, 2, 7, '9737800014', NULL, 0, NULL, NULL, NULL, NULL, '2023-06-05 03:49:58', '2023-06-05 03:49:58'),
(4, 'Mayank', 'Bhandari', NULL, NULL, 2, 3, 3, '9735222125', NULL, 0, NULL, NULL, NULL, NULL, '2023-06-05 22:25:01', '2023-06-05 22:25:01'),
(5, 'Divyes', 'Patel', NULL, NULL, 2, 3, 3, '9714145632', '1686027922_1668158515_01.png', 0, NULL, NULL, NULL, NULL, '2023-06-05 23:35:22', '2023-06-05 23:35:22'),
(8, 'Sidhh', 'Patel', NULL, NULL, 2, 2, 7, '9755582200', NULL, 1, NULL, NULL, NULL, NULL, '2023-06-05 23:53:58', '2023-06-06 03:34:49'),
(11, 'Nitesh', 'prajapati', NULL, NULL, 2, 3, 3, '9754562626', '1686031256_yard_59cb083d7c01efb6e835ce7d6ae6fa12.jpg', 1, NULL, NULL, NULL, NULL, '2023-06-06 00:12:37', '2023-06-06 00:30:56'),
(12, 'Mitesh', 'Pro', NULL, NULL, 2, 3, 40, '7585522201', '1686035065_08-12-2022-17-07-40.090.jpg', 1, NULL, NULL, NULL, NULL, '2023-06-06 00:13:46', '2023-06-07 04:10:05'),
(13, 'SMO', 'Narola', NULL, NULL, 2, 3, 3, '9445522255', NULL, 1, NULL, NULL, NULL, NULL, '2023-06-07 23:07:35', '2023-06-07 23:07:35'),
(14, 'TEST NAm', 'PATEL', NULL, NULL, 2, 27, 7, '9725482256', NULL, 1, NULL, NULL, NULL, NULL, '2023-06-08 22:47:52', '2023-06-09 04:30:19');

-- --------------------------------------------------------

--
-- Table structure for table `user_location`
--

DROP TABLE IF EXISTS `user_location`;
CREATE TABLE IF NOT EXISTS `user_location` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `state` int NOT NULL DEFAULT '1' COMMENT '1="Gujarat"',
  `city` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_location_user_id_index` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
CREATE TABLE IF NOT EXISTS `user_role` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `role` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0="In-active", 1= "Active"',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 1, NULL, NULL),
(2, 'manager', 1, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
