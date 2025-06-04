-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2024 at 04:23 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel_online_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(1, 'samsung', 'samsung', 1, '2024-08-21 08:57:27', '2024-08-26 08:27:03'),
(3, 'oppo', 'oppo', 1, '2024-08-21 08:58:08', '2024-08-26 08:26:58'),
(4, 'realme', 'realme', 1, '2024-08-21 08:58:30', '2024-08-26 08:26:50'),
(5, 'Apple', 'apple', 1, '2024-08-27 00:53:43', '2024-08-27 00:53:43');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `showHome` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `image`, `status`, `showHome`, `created_at`, `updated_at`) VALUES
(3, 'charger', 'charger', NULL, 1, 'No', '2024-08-19 07:42:46', '2024-08-21 05:12:30'),
(9, 'screen glass', 'screen-glass', NULL, 1, 'No', '2024-08-19 07:42:46', '2024-08-21 01:51:40'),
(22, 'Prof. Donald Jacobson', 'Lloyd Sanford', NULL, 0, 'No', '2024-08-19 07:42:46', '2024-08-19 07:42:46'),
(23, 'Cloyd Raynor', 'Bridgette Kuhlman', NULL, 1, 'Yes', '2024-08-19 07:42:46', '2024-09-04 13:32:00'),
(24, 'Prof. Lola Hand', 'Miss Maudie Marquardt II', NULL, 1, 'No', '2024-08-19 07:42:46', '2024-08-19 07:42:46'),
(25, 'Alexa Grant', 'Sim Stiedemann', NULL, 1, 'No', '2024-08-19 07:42:46', '2024-08-19 07:42:46'),
(26, 'Deangelo Ruecker', 'Lexi Ferry', NULL, 0, 'No', '2024-08-19 07:42:46', '2024-08-19 07:42:46'),
(27, 'Mr. Korey Schumm', 'Quinton Weimann', NULL, 1, 'No', '2024-08-19 07:42:46', '2024-08-19 07:42:46'),
(28, 'Miss Lorine Dietrich V', 'Dr. Colt Orn DVM', NULL, 0, 'No', '2024-08-19 07:42:46', '2024-08-19 07:42:46'),
(29, 'Nat Durgan', 'Wilton Klocko', NULL, 0, 'No', '2024-08-19 07:42:46', '2024-08-19 07:42:46'),
(30, 'Kaleigh Beatty', 'Ignatius Bradtke MD', NULL, 0, 'No', '2024-08-19 07:42:46', '2024-08-19 07:42:46'),
(31, 'Men\'s cloth', 'mens-cloth', NULL, 1, 'No', '2024-08-19 07:58:11', '2024-08-19 07:58:11'),
(38, 'Home Appliances', 'home-appliances', '38-1725356670.jpg', 1, 'Yes', '2024-08-19 13:53:10', '2024-09-03 04:14:30'),
(40, 'Clothes', 'clothes', '40-1725356241.jpg', 1, 'Yes', '2024-08-26 08:25:09', '2024-09-03 04:07:21'),
(41, 'Electronics', 'electronics', '41-1725356705.png', 1, 'Yes', '2024-08-26 08:26:04', '2024-09-03 04:15:05'),
(42, 'Books', 'books', '42-1725356454.webp', 1, 'Yes', '2024-09-02 14:03:17', '2024-09-03 04:10:54'),
(43, 'Game', 'game', '43.png', 0, 'No', '2024-09-06 06:42:17', '2024-09-15 09:48:50');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_08_07_110441_alter_table_users', 1),
(6, '2024_08_19_122016_create_categories_table', 1),
(7, '2024_08_19_133117_create_images_table', 2),
(8, '2024_08_19_134008_create_tmp_images_table', 3),
(9, '2024_08_20_201855_create_sub_categories', 4),
(10, '2024_08_21_100336_create_brands_table', 5),
(11, '2024_08_22_071924_create_products_table', 6),
(12, '2024_08_22_071944_create_products_images_table', 6),
(13, '2024_08_27_121616_create_product_images_table', 7),
(14, '2024_09_02_192457_alter_categories_create', 8),
(15, '2024_09_02_194127_alter_products_create', 9),
(16, '2024_09_02_195241_alter_sub_categories_create', 10);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` double(10,2) NOT NULL,
  `compare_price` double(10,2) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `sub_category_id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `is_featured` enum('Yes','No') NOT NULL DEFAULT 'No',
  `sku` varchar(255) NOT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `track_qty` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `qty` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `slug`, `description`, `price`, `compare_price`, `category_id`, `sub_category_id`, `brand_id`, `is_featured`, `sku`, `barcode`, `track_qty`, `qty`, `status`, `created_at`, `updated_at`) VALUES
(2, 'mobile battery v1', 'mobile-battery-v1', '<p>mobile battery v1<br></p>', 1500.00, 1800.00, 38, 10, 4, 'No', '1254mm', 'ASFDA1254', 'Yes', 10, 1, '2024-08-23 10:00:26', '2024-08-23 10:00:26'),
(3, 'Oppo mobile phone 5\"', 'oppo-mobile-phone-5', 'Oppo mobile phone 5\"', 15000.00, 18000.00, 41, 13, 3, 'Yes', 'abc122', 'adfsfs', 'Yes', 10, 1, '2024-08-26 08:24:10', '2024-09-03 12:30:13'),
(4, 'Samsung 5 g mobile phone', 'samsung-5-g-mobile-phone', '<p>Samsung 5 g mobile phone&nbsp;Samsung 5 g mobile phone&nbsp;Samsung 5 g mobile phone<br></p>', 35000.00, 38000.00, 41, 13, 1, 'No', 'sm5487', 'sssmmms', 'Yes', 15, 1, '2024-08-26 08:45:41', '2024-08-26 08:45:41'),
(5, 'appo 5 g mobile phone', 'appo-5-g-mobile-phone', '<p>appo 5 g mobile phone&nbsp;appo 5 g mobile phone<br></p>', 25000.00, 26000.00, 38, 8, 3, 'No', 'ffffasdas', 'twetrerg', 'Yes', 10, 1, '2024-08-27 06:29:17', '2024-08-27 06:29:17'),
(6, 'Realme 5 g mobile phone', 'realme-5-g-mobile-phone', '<p>Realme 5 g mobile phone<br></p>', 25000.00, 26000.00, 38, 8, 4, 'No', 'ffffasdas', 'twetrerg', 'Yes', 10, 1, '2024-08-27 06:42:07', '2024-08-27 06:42:07'),
(7, 'mobile charger v52', 'mobile-charger-v52', '<p>mobile charger v52&nbsp;mobile charger v52<br></p>', 25000.00, 26000.00, 38, 3, 3, 'No', 'ffffasdas', 'twetrerg', 'Yes', 15, 1, '2024-08-27 06:52:09', '2024-08-27 06:52:09'),
(8, 'Oppo mobile charger v5', 'oppo-mobile-charger-v5', '<p>Oppo mobile charger v5<br></p>', 25000.00, 26000.00, 38, 3, 3, 'No', 'ffffasdas', 'twetrerg', 'Yes', 15, 1, '2024-08-27 07:00:23', '2024-08-27 07:00:23'),
(9, 'Samsung mobile charger 25v', 'samsung-mobile-charger-25v', '<p>Samsung mobile charger 25v&nbsp;<br></p>', 25000.00, 26000.00, 41, 13, 1, 'No', 'wwwrr', 'twetrergqq', 'Yes', 21, 1, '2024-08-27 07:50:06', '2024-08-27 07:50:06'),
(10, 'Samsung galaxy mobile phone 5g+', 'samsung-galaxy-mobile-phone-5g', '<p>Samsung galaxy mobile phone 5g+<br></p>', 25000.00, 26000.00, 38, 3, 1, 'No', 'sssww', 'sssww1', 'Yes', 23, 1, '2024-08-27 08:09:42', '2024-08-27 08:09:42'),
(11, 'T-Shirt for man\'s', 't-shirt-for-mans', '<p>T-Shirt for man\'s&nbsp;T-Shirt for man\'s<br></p>', 25000.00, 26000.00, 41, 13, 4, 'No', 'ssssssssdd', 'ssssssssdd2', 'Yes', 25, 1, '2024-08-28 06:05:26', '2024-08-28 06:05:26'),
(12, 'mobile phone 5g altra', 'mobile-phone-5g-altra', '<p>mobile phone 5g altra mobile phone 5g altra<br></p>', 25000.00, 26000.00, 38, 8, 4, 'No', 'ssssssssdd', 'twetrerg', 'Yes', 25, 1, '2024-08-28 06:57:35', '2024-08-28 06:57:35'),
(13, 'oppo mobile phone 5 g altar', 'oppo-mobile-phone-5-g-altar', '<p>oppo mobile phone 5 g altar&nbsp;oppo mobile phone 5 g altar<br></p>', 25000.00, 26000.00, 38, 8, 3, 'No', 'sssdd', 'twedtrerg', 'Yes', 12, 1, '2024-08-28 07:24:50', '2024-08-28 07:24:50'),
(15, 'Oppo mobile phone abc', 'oppo-mobile-phone-abc', 'Oppo mobile phone abc', 150005.00, 180005.00, 38, 10, 1, 'No', 'SKU-542', 'ANCSS', 'No', 15, 0, '2024-08-29 08:18:06', '2024-08-29 08:18:06'),
(16, 'oppo mobile phone 5 g altar mobile', 'oppo-mobile-phone-5-g-altar-mobile', '<span style=\"color: rgb(0, 29, 61); font-family: Poppins;\">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sit, incidunt blanditiis suscipit quidem magnam doloribus earum hic exercitationem. Distinctio dicta veritatis alias delectus quaerat, quam sint ab nulla aperiam commodi. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sit, incidunt blanditiis suscipit quidem magnam doloribus earum hic exercitationem. Distinctio dicta veritatis alias delectus quaerat, quam sint ab nulla aperiam commodi. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sit, incidunt blanditiis suscipit quidem magnam doloribus earum hic exercitationem. Distinctio dicta veritatis alias delectus quaerat, quam sint ab nulla aperiam commodi.</span>', 25000.00, 26000.00, 38, 8, 3, 'No', 'GASDFDS', 'twedtrerg', 'Yes', 12, 1, '2024-08-29 08:25:34', '2024-09-26 11:04:15'),
(17, 'oppo mobile phone 5 g altar 6.7\"', 'oppo-mobile-phone-5-g-altar-67', 'oppo mobile phone 5 g altar 6.7\"', 25000.00, 26000.00, 41, 13, 3, 'Yes', 'SKU-85847', 'twedtrerg', 'No', 12, 1, '2024-08-29 08:26:24', '2024-09-03 12:24:05'),
(18, 'Men Slim Mid Rise Dark Blue Jeans', 'men-slim-mid-rise-dark-blue-jeans', 'Men Slim Mid Rise Dark Blue Jeans', 1300.00, 1600.00, 40, 7, 4, 'Yes', 'gdsgfgsdf', 'ssssssssdd2', 'Yes', 25, 1, '2024-08-29 08:30:13', '2024-09-03 12:37:57'),
(19, 'Samsung 7 kg, 5 star, Semi-Automatic Top Load Washing Machine', 'samsung-7-kg-5-star-semi-automatic-top-load-washing-machine', '<p><span style=\"color: rgb(51, 51, 51); font-family: Arial, sans-serif; font-size: 14px;\">‎Special Features: Rat Protection, Caster Wheel : 4 wheels located on each corner of the base, Auto Restart : Resumes washing process when power is back, Rust Proof Body, Key Features : BEE 5 star certified, Magic Filter, Air Turbo Drying System</span><br></p>', 12000.00, 13000.00, 41, 15, 1, 'Yes', '‎WT70M3000UU/TL', '‎WT70M3000UU/TL', 'Yes', 10, 1, '2024-09-03 05:09:39', '2024-09-03 05:09:39'),
(21, 'pollo T-Shirt for man\'s', 'pollo-t-shirt-for-mans', 'pollo T-Shirt for man\'s', 500.00, 600.00, 40, 7, 4, 'Yes', 'ewew', 'ssssssssdd2', 'Yes', 25, 1, '2024-09-03 06:29:14', '2024-09-03 12:28:09'),
(22, 'T-Shirt for man\'s', 't-shirt-for-mans1', 'T-Shirt for man\'s', 25000.00, 26000.00, 40, 7, 4, 'Yes', 'ggggyt', 'ssssssssdd2', 'Yes', 25, 1, '2024-09-03 09:59:03', '2024-09-03 12:19:57'),
(23, 'T-Shirt for man\'s', 't-shirt-for-mans2', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sit, incidunt blanditiis suscipit quidem magnam doloribus earum hic exercitationem. Distinctio dicta veritatis alias delectus quaerat, quam sint ab nulla aperiam commodi. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sit, incidunt blanditiis suscipit quidem magnam doloribus earum hic exercitationem. Distinctio dicta veritatis alias delectus quaerat, quam sint ab nulla aperiam commodi. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sit, incidunt blanditiis suscipit quidem magnam doloribus earum hic exercitationem. Distinctio dicta veritatis alias delectus quaerat, quam sint ab nulla aperiam commodi.', 25000.00, 26000.00, 40, 7, 4, 'Yes', 'HGFR42', 'ssssssssdd2', 'Yes', 25, 1, '2024-09-03 09:59:58', '2024-09-26 10:53:35'),
(24, 'oppo mobile phone 5 g', 'oppo-mobile-phone-5-g', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sit, incidunt blanditiis suscipit quidem magnam doloribus earum hic exercitationem. Distinctio dicta veritatis alias delectus quaerat, quam sint ab nulla aperiam commodi. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sit, incidunt blanditiis suscipit quidem magnam doloribus earum hic exercitationem. Distinctio dicta veritatis alias delectus quaerat, quam sint ab nulla aperiam commodi. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sit, incidunt blanditiis suscipit quidem magnam doloribus earum hic exercitationem. Distinctio dicta veritatis alias delectus quaerat, quam sint ab nulla aperiam commodi.', 25000.00, 26000.00, 41, 13, 3, 'Yes', 'OPHYG6', 'twedtrerg', 'Yes', 12, 1, '2024-09-03 11:51:38', '2024-09-26 11:01:20'),
(1255, 'Miss Daisha Quigley', 'miss-daisha-quigley', NULL, 6616.00, NULL, 41, 13, 5, 'Yes', '1603', '1', 'Yes', 20, 1, '2024-09-12 01:06:46', '2024-09-12 01:06:46'),
(1256, 'Keara Grimes', 'keara-grimes', NULL, 3319.00, NULL, 41, 10, 4, 'Yes', '6156', '1', 'Yes', 20, 1, '2024-09-12 01:06:46', '2024-09-12 01:06:46'),
(1257, 'Christop Rolfson', 'christop-rolfson', NULL, 4329.00, NULL, 41, 13, 1, 'Yes', '3749', '0', 'Yes', 20, 1, '2024-09-12 01:06:46', '2024-09-12 01:06:46'),
(1258, 'Jameson Yundt Sr.', 'jameson-yundt-sr', NULL, 10893.00, NULL, 41, 5, 3, 'Yes', '6675', '1', 'Yes', 20, 1, '2024-09-12 01:06:46', '2024-09-12 01:06:46'),
(1259, 'Emerson Spencer IV', 'emerson-spencer-iv', NULL, 3002.00, NULL, 41, 15, 4, 'Yes', '9719', '1', 'Yes', 20, 1, '2024-09-12 01:06:46', '2024-09-12 01:06:46'),
(1260, 'Bud Leuschke', 'bud-leuschke', NULL, 8034.00, NULL, 41, 10, 4, 'Yes', '9353', '1', 'Yes', 20, 1, '2024-09-12 01:06:46', '2024-09-12 01:06:46'),
(1261, 'Mrs. Karlee Breitenberg', 'mrs-karlee-breitenberg', NULL, 12702.00, NULL, 41, 15, 3, 'Yes', '7917', '0', 'Yes', 20, 1, '2024-09-12 01:06:46', '2024-09-12 01:06:46'),
(1262, 'Natalie Collins', 'natalie-collins', NULL, 2151.00, NULL, 41, 15, 3, 'Yes', '3547', '1', 'Yes', 20, 1, '2024-09-12 01:06:46', '2024-09-12 01:06:46'),
(1263, 'Francesco Trantow', 'francesco-trantow', NULL, 11361.00, NULL, 41, 13, 3, 'Yes', '8064', '0', 'Yes', 20, 1, '2024-09-12 01:06:46', '2024-09-12 01:06:46'),
(1264, 'August Quitzon I', 'august-quitzon-i', NULL, 11785.00, NULL, 41, 15, 4, 'Yes', '6525', '0', 'Yes', 20, 1, '2024-09-12 01:06:46', '2024-09-12 01:06:46'),
(1265, 'Rhoda Farrell', 'rhoda-farrell', NULL, 14886.00, NULL, 41, 15, 5, 'Yes', '7934', '0', 'Yes', 20, 1, '2024-09-12 01:06:46', '2024-09-12 01:06:46'),
(1266, 'Weston Littel', 'weston-littel', NULL, 5279.00, NULL, 41, 13, 5, 'Yes', '9044', '1', 'Yes', 20, 1, '2024-09-12 01:06:46', '2024-09-12 01:06:46'),
(1267, 'Mrs. Isabella Ledner', 'mrs-isabella-ledner', NULL, 14443.00, NULL, 41, 10, 3, 'Yes', '6476', '1', 'Yes', 20, 1, '2024-09-12 01:06:46', '2024-09-12 01:06:46'),
(1268, 'Ms. Evangeline Nicolas', 'ms-evangeline-nicolas', NULL, 3627.00, NULL, 41, 10, 1, 'Yes', '9969', '1', 'Yes', 20, 1, '2024-09-12 01:06:46', '2024-09-12 01:06:46'),
(1269, 'Gayle Schulist', 'gayle-schulist', NULL, 6547.00, NULL, 41, 5, 1, 'Yes', '7511', '0', 'Yes', 20, 1, '2024-09-12 01:06:46', '2024-09-12 01:06:46'),
(1270, 'Rickey Boyer', 'rickey-boyer', NULL, 7428.00, NULL, 41, 10, 3, 'Yes', '2294', '0', 'Yes', 20, 1, '2024-09-12 01:06:46', '2024-09-12 01:06:46'),
(1271, 'Okey Volkman', 'okey-volkman', NULL, 741.00, NULL, 41, 5, 3, 'Yes', '3160', '0', 'Yes', 20, 1, '2024-09-12 01:06:46', '2024-09-12 01:06:46'),
(1272, 'Llewellyn Collier', 'llewellyn-collier', NULL, 8035.00, NULL, 41, 13, 1, 'Yes', '6814', '1', 'Yes', 20, 1, '2024-09-12 01:06:46', '2024-09-12 01:06:46'),
(1273, 'Johnson Grant II', 'johnson-grant-ii', NULL, 1986.00, NULL, 41, 5, 5, 'Yes', '4797', '0', 'Yes', 20, 1, '2024-09-12 01:06:46', '2024-09-12 01:06:46'),
(1274, 'Dr. Leif Crooks Jr.', 'dr-leif-crooks-jr', NULL, 10823.00, NULL, 41, 5, 3, 'Yes', '2710', '1', 'Yes', 20, 1, '2024-09-12 01:06:46', '2024-09-12 01:06:46'),
(1275, 'Prof. Dimitri Hettinger', 'prof-dimitri-hettinger', NULL, 11946.00, NULL, 41, 13, 3, 'Yes', '1019', '1', 'Yes', 20, 1, '2024-09-12 01:06:46', '2024-09-12 01:06:46'),
(1276, 'Abagail Wilderman', 'abagail-wilderman', NULL, 12712.00, NULL, 41, 15, 1, 'Yes', '8238', '0', 'Yes', 20, 1, '2024-09-12 01:06:46', '2024-09-12 01:06:46'),
(1277, 'Hector Hackett', 'hector-hackett', NULL, 3063.00, NULL, 41, 15, 1, 'Yes', '4682', '1', 'Yes', 20, 1, '2024-09-12 01:06:46', '2024-09-12 01:06:46'),
(1278, 'Meaghan Sauer PhD', 'meaghan-sauer-phd', NULL, 4083.00, NULL, 41, 5, 3, 'Yes', '6675', '0', 'Yes', 20, 1, '2024-09-12 01:06:46', '2024-09-12 01:06:46'),
(1279, 'Abdiel Hane', 'abdiel-hane', NULL, 4270.00, NULL, 41, 10, 3, 'Yes', '1058', '1', 'Yes', 20, 1, '2024-09-12 01:06:46', '2024-09-12 01:06:46'),
(1280, 'Mrs. Aubree Keeling DVM', 'mrs-aubree-keeling-dvm', NULL, 12709.00, NULL, 41, 15, 1, 'Yes', '2398', '1', 'Yes', 20, 1, '2024-09-12 01:06:46', '2024-09-12 01:06:46'),
(1281, 'Madaline Lemke', 'madaline-lemke', NULL, 4074.00, NULL, 41, 5, 4, 'Yes', '4744', '1', 'Yes', 20, 1, '2024-09-12 01:06:46', '2024-09-12 01:06:46'),
(1282, 'Jeramie Ledner', 'jeramie-ledner', NULL, 10302.00, NULL, 41, 13, 5, 'Yes', '2106', '1', 'Yes', 20, 1, '2024-09-12 01:06:46', '2024-09-12 01:06:46'),
(1283, 'Shaina Schoen V', 'shaina-schoen-v', NULL, 10073.00, NULL, 41, 15, 3, 'Yes', '6912', '1', 'Yes', 20, 1, '2024-09-12 01:06:46', '2024-09-12 01:06:46'),
(1284, 'Lynn Corwin', 'lynn-corwin', NULL, 8184.00, NULL, 41, 10, 4, 'Yes', '5113', '1', 'Yes', 20, 1, '2024-09-12 01:06:46', '2024-09-12 01:06:46'),
(1288, 'Lorena Welch', 'lorena-welch', NULL, 14620.00, NULL, 40, 7, 3, 'Yes', '1315', '225626', 'Yes', 20, 1, '2024-09-12 01:16:18', '2024-09-12 01:16:18'),
(1290, 'Dr. Mark Nikolaus', 'dr-mark-nikolaus', NULL, 4647.00, NULL, 40, 7, 3, 'Yes', '8229', '460559', 'Yes', 20, 1, '2024-09-12 01:16:18', '2024-09-12 01:16:18'),
(1291, 'Dr. Lauriane Dare', 'dr-lauriane-dare', NULL, 5586.00, NULL, 40, 7, 5, 'Yes', '5616', '798326', 'Yes', 20, 1, '2024-09-12 01:16:18', '2024-09-12 01:16:18'),
(1294, 'Hilario Koelpin', 'hilario-koelpin', NULL, 10228.00, NULL, 40, 7, 4, 'Yes', '5645', '506593', 'Yes', 20, 1, '2024-09-12 01:16:18', '2024-09-12 01:16:18'),
(1295, 'Mr. Waldo Rosenbaum', 'mr-waldo-rosenbaum', NULL, 13297.00, NULL, 40, 7, 4, 'Yes', '2723', '106780', 'Yes', 20, 1, '2024-09-12 01:16:18', '2024-09-12 01:16:18'),
(1296, 'Miss Catharine Rippin', 'miss-catharine-rippin', NULL, 12495.00, NULL, 40, 7, 4, 'Yes', '2593', '526112', 'Yes', 20, 1, '2024-09-12 01:16:18', '2024-09-12 01:16:18'),
(1299, 'Emerald Beahan', 'emerald-beahan', NULL, 10088.00, NULL, 40, 7, 4, 'Yes', '4807', '734080', 'Yes', 20, 1, '2024-09-12 01:16:18', '2024-09-12 01:16:18'),
(1300, 'Antonia Russel', 'antonia-russel', NULL, 3994.00, NULL, 40, 7, 1, 'Yes', '2104', '404944', 'Yes', 20, 1, '2024-09-12 01:16:18', '2024-09-12 01:16:18'),
(1302, 'Elyse O\'Hara', 'elyse-ohara', NULL, 14821.00, NULL, 40, 7, 5, 'Yes', '8092', '116768', 'Yes', 20, 1, '2024-09-12 01:16:18', '2024-09-12 01:16:18'),
(1305, 'Lafayette Padberg', 'lafayette-padberg', NULL, 5233.00, NULL, 40, 7, 3, 'Yes', '8498', '57924', 'Yes', 20, 1, '2024-09-12 01:16:18', '2024-09-12 01:16:18'),
(1308, 'Tomasa Mayert', 'tomasa-mayert', NULL, 13294.00, NULL, 40, 7, 1, 'Yes', '3884', '863844', 'Yes', 20, 1, '2024-09-12 01:16:18', '2024-09-12 01:16:18'),
(1309, 'Peter Roberts', 'peter-roberts', NULL, 10357.00, NULL, 40, 7, 4, 'Yes', '7967', '868764', 'Yes', 20, 1, '2024-09-12 01:16:18', '2024-09-12 01:16:18'),
(1312, 'Irwin Walker', 'irwin-walker', NULL, 3652.00, NULL, 40, 7, 5, 'Yes', '2163', '247527', 'Yes', 20, 1, '2024-09-12 01:16:18', '2024-09-12 01:16:18'),
(1314, 'Antonette Feest', 'antonette-feest', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sit, incidunt blanditiis suscipit quidem magnam doloribus earum hic exercitationem. Distinctio dicta veritatis alias delectus quaerat, quam sint ab nulla aperiam commodi. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sit, incidunt blanditiis suscipit quidem magnam doloribus earum hic exercitationem. Distinctio dicta veritatis alias delectus quaerat, quam sint ab nulla aperiam commodi. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sit, incidunt blanditiis suscipit quidem magnam doloribus earum hic exercitationem. Distinctio dicta veritatis alias delectus quaerat, quam sint ab nulla aperiam commodi.', 5789.00, NULL, 41, 13, 5, 'Yes', '7314', '169796', 'Yes', 20, 1, '2024-09-12 01:16:18', '2024-09-26 10:58:29');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `sort_order` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`, `sort_order`, `created_at`, `updated_at`) VALUES
(21, 13, '1724849646.jfif', NULL, '2024-08-28 07:24:50', '2024-08-28 07:24:50'),
(22, 13, '1724849646.jpg', NULL, '2024-08-28 07:24:50', '2024-08-28 07:24:50'),
(23, 13, '1724849647.jpg', NULL, '2024-08-28 07:24:51', '2024-08-28 07:24:51'),
(25, 19, '19-25-1725359979.jpg', NULL, '2024-09-03 05:09:39', '2024-09-03 05:09:39'),
(30, 16, '16-30-1725384026.png', NULL, '2024-09-03 11:50:26', '2024-09-03 11:50:26'),
(31, 22, '22-31-1725385703.jpg', NULL, '2024-09-03 12:18:23', '2024-09-03 12:18:23'),
(32, 24, '24-32-1725385896.png', NULL, '2024-09-03 12:21:36', '2024-09-03 12:21:36'),
(33, 17, '17-33-1725386039.png', NULL, '2024-09-03 12:23:59', '2024-09-03 12:23:59'),
(34, 21, '21-34-1725386280.jpg', NULL, '2024-09-03 12:28:00', '2024-09-03 12:28:00'),
(35, 23, '23-35-1725386307.jpg', NULL, '2024-09-03 12:28:27', '2024-09-03 12:28:27'),
(36, 3, '3-36-1725386406.png', NULL, '2024-09-03 12:30:06', '2024-09-03 12:30:06'),
(37, 18, '18-37-1725386848.webp', NULL, '2024-09-03 12:37:28', '2024-09-03 12:37:28'),
(38, 1314, '1314-38-1726128263.png', NULL, '2024-09-12 02:34:23', '2024-09-12 02:34:23'),
(39, 23, '23-39-1727367435.jpg', NULL, '2024-09-26 10:47:15', '2024-09-26 10:47:15'),
(40, 23, '23-40-1727367436.jpg', NULL, '2024-09-26 10:47:16', '2024-09-26 10:47:16'),
(41, 23, '23-41-1727367437.jpg', NULL, '2024-09-26 10:47:17', '2024-09-26 10:47:17'),
(42, 1314, '1314-42-1727368101.jpg', NULL, '2024-09-26 10:58:21', '2024-09-26 10:58:21'),
(43, 1314, '1314-43-1727368102.jpg', NULL, '2024-09-26 10:58:22', '2024-09-26 10:58:22'),
(44, 1314, '1314-44-1727368103.jpg', NULL, '2024-09-26 10:58:23', '2024-09-26 10:58:23'),
(45, 24, '24-45-1727368275.jpg', NULL, '2024-09-26 11:01:15', '2024-09-26 11:01:15'),
(46, 24, '24-46-1727368275.jpg', NULL, '2024-09-26 11:01:15', '2024-09-26 11:01:15'),
(47, 24, '24-47-1727368276.jpg', NULL, '2024-09-26 11:01:16', '2024-09-26 11:01:16'),
(48, 16, '16-48-1727368410.jpg', NULL, '2024-09-26 11:03:30', '2024-09-26 11:03:30'),
(49, 16, '16-49-1727368411.jpg', NULL, '2024-09-26 11:03:31', '2024-09-26 11:03:31'),
(50, 16, '16-50-1727368412.jpg', NULL, '2024-09-26 11:03:32', '2024-09-26 11:03:32');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `showHome` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `name`, `slug`, `category_id`, `status`, `showHome`, `created_at`, `updated_at`) VALUES
(3, 'charger', 'charger', 38, 1, 'Yes', '2024-08-21 00:50:52', '2024-09-03 01:25:08'),
(5, 'Laptop', 'laptop', 41, 1, 'Yes', '2024-08-21 00:51:23', '2024-09-03 05:16:11'),
(7, 'men\'s appearance', 'mens-appearance', 40, 1, 'Yes', '2024-08-21 00:51:57', '2024-09-03 11:48:47'),
(8, 'head phone', 'head-phone', 38, 1, 'Yes', '2024-08-21 00:52:17', '2024-09-03 01:20:48'),
(10, 'battery', 'battery', 38, 1, 'Yes', '2024-08-21 00:52:55', '2024-09-03 01:20:30'),
(13, 'Phone', 'phone', 41, 1, 'Yes', '2024-08-26 08:26:23', '2024-09-02 14:39:53'),
(14, 'Comics', 'comics', 42, 1, 'Yes', '2024-09-02 14:32:09', '2024-09-02 14:32:09'),
(15, 'Washing Machine', 'washing-machine', 41, 1, 'Yes', '2024-09-03 05:08:00', '2024-09-03 05:08:00');

-- --------------------------------------------------------

--
-- Table structure for table `tmp_images`
--

CREATE TABLE `tmp_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tmp_images`
--

INSERT INTO `tmp_images` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, '1724078068.png', '2024-08-19 09:04:28', '2024-08-19 09:04:28'),
(2, '1724079972.png', '2024-08-19 09:36:12', '2024-08-19 09:36:12'),
(3, '1724080140.png', '2024-08-19 09:39:00', '2024-08-19 09:39:00'),
(4, '1724093957.jpg', '2024-08-19 13:29:17', '2024-08-19 13:29:17'),
(5, '1724094255.jpg', '2024-08-19 13:34:15', '2024-08-19 13:34:15'),
(6, '1724094797.jpg', '2024-08-19 13:43:17', '2024-08-19 13:43:17'),
(7, '1724095097.jpg', '2024-08-19 13:48:17', '2024-08-19 13:48:17'),
(8, '1724095381.jpg', '2024-08-19 13:53:01', '2024-08-19 13:53:01'),
(9, '1724123089.jpg', '2024-08-19 21:34:49', '2024-08-19 21:34:49'),
(10, '1724143916.jpg', '2024-08-20 03:21:56', '2024-08-20 03:21:56'),
(11, '1724144916.jpg', '2024-08-20 03:38:36', '2024-08-20 03:38:36'),
(12, '1724145469.jpg', '2024-08-20 03:47:49', '2024-08-20 03:47:49'),
(13, '1724145556.jpg', '2024-08-20 03:49:16', '2024-08-20 03:49:16'),
(14, '1724146987.png', '2024-08-20 04:13:07', '2024-08-20 04:13:07'),
(15, '1724147619.png', '2024-08-20 04:23:39', '2024-08-20 04:23:39'),
(16, '1724151899.png', '2024-08-20 05:34:59', '2024-08-20 05:34:59'),
(17, '1724342543.jpeg', '2024-08-22 10:32:23', '2024-08-22 10:32:23'),
(18, '1724680504.png', '2024-08-26 08:25:04', '2024-08-26 08:25:04'),
(19, '1724680562.png', '2024-08-26 08:26:02', '2024-08-26 08:26:02'),
(20, '1724681955.png', '2024-08-26 08:49:15', '2024-08-26 08:49:15'),
(21, '1724682204.png', '2024-08-26 08:53:24', '2024-08-26 08:53:24'),
(22, '1724748326.png', '2024-08-27 03:15:26', '2024-08-27 03:15:26'),
(23, '1724748978.jfif', '2024-08-27 03:26:18', '2024-08-27 03:26:18'),
(24, '1724748991.jfif', '2024-08-27 03:26:31', '2024-08-27 03:26:31'),
(25, '1724748995.jpg', '2024-08-27 03:26:35', '2024-08-27 03:26:35'),
(26, '1724749104.jfif', '2024-08-27 03:28:24', '2024-08-27 03:28:24'),
(27, '1724749104.jfif', '2024-08-27 03:28:24', '2024-08-27 03:28:24'),
(28, '1724749104.jpg', '2024-08-27 03:28:24', '2024-08-27 03:28:24'),
(29, '1724749105.jpg', '2024-08-27 03:28:25', '2024-08-27 03:28:25'),
(30, '1724749629.jfif', '2024-08-27 03:37:09', '2024-08-27 03:37:09'),
(31, '1724749630.jfif', '2024-08-27 03:37:10', '2024-08-27 03:37:10'),
(32, '1724749630.jpg', '2024-08-27 03:37:10', '2024-08-27 03:37:10'),
(33, '1724749631.jpg', '2024-08-27 03:37:11', '2024-08-27 03:37:11'),
(34, '1724749671.jfif', '2024-08-27 03:37:51', '2024-08-27 03:37:51'),
(35, '1724749672.jfif', '2024-08-27 03:37:52', '2024-08-27 03:37:52'),
(36, '1724749672.jfif', '2024-08-27 03:37:52', '2024-08-27 03:37:52'),
(37, '1724749783.jfif', '2024-08-27 03:39:43', '2024-08-27 03:39:43'),
(38, '1724749783.jfif', '2024-08-27 03:39:43', '2024-08-27 03:39:43'),
(39, '1724749784.jfif', '2024-08-27 03:39:44', '2024-08-27 03:39:44'),
(40, '1724749784.jpg', '2024-08-27 03:39:44', '2024-08-27 03:39:44'),
(41, '1724749855.jfif', '2024-08-27 03:40:55', '2024-08-27 03:40:55'),
(42, '1724749856.jfif', '2024-08-27 03:40:56', '2024-08-27 03:40:56'),
(43, '1724749856.jfif', '2024-08-27 03:40:56', '2024-08-27 03:40:56'),
(44, '1724749856.jpg', '2024-08-27 03:40:56', '2024-08-27 03:40:56'),
(45, '1724749939.jfif', '2024-08-27 03:42:19', '2024-08-27 03:42:19'),
(46, '1724749939.jfif', '2024-08-27 03:42:19', '2024-08-27 03:42:19'),
(47, '1724749940.jfif', '2024-08-27 03:42:20', '2024-08-27 03:42:20'),
(48, '1724749940.jpg', '2024-08-27 03:42:20', '2024-08-27 03:42:20'),
(49, '1724751447.png', '2024-08-27 04:07:27', '2024-08-27 04:07:27'),
(50, '1724751636.jfif', '2024-08-27 04:10:36', '2024-08-27 04:10:36'),
(51, '1724751637.jfif', '2024-08-27 04:10:37', '2024-08-27 04:10:37'),
(52, '1724751637.jfif', '2024-08-27 04:10:37', '2024-08-27 04:10:37'),
(53, '1724751638.jpg', '2024-08-27 04:10:38', '2024-08-27 04:10:38'),
(54, '1724751667.jfif', '2024-08-27 04:11:07', '2024-08-27 04:11:07'),
(55, '1724751668.jfif', '2024-08-27 04:11:08', '2024-08-27 04:11:08'),
(56, '1724751668.jfif', '2024-08-27 04:11:08', '2024-08-27 04:11:08'),
(57, '1724751669.jpg', '2024-08-27 04:11:09', '2024-08-27 04:11:09'),
(58, '1724751901.jfif', '2024-08-27 04:15:01', '2024-08-27 04:15:01'),
(59, '1724751902.jfif', '2024-08-27 04:15:02', '2024-08-27 04:15:02'),
(60, '1724751902.jfif', '2024-08-27 04:15:02', '2024-08-27 04:15:02'),
(61, '1724751902.jpg', '2024-08-27 04:15:02', '2024-08-27 04:15:02'),
(62, '1724756667.jfif', '2024-08-27 05:34:27', '2024-08-27 05:34:27'),
(63, '1724756668.jfif', '2024-08-27 05:34:28', '2024-08-27 05:34:28'),
(64, '1724756668.jfif', '2024-08-27 05:34:28', '2024-08-27 05:34:28'),
(65, '1724756668.jpg', '2024-08-27 05:34:28', '2024-08-27 05:34:28'),
(66, '1724760114.jfif', '2024-08-27 06:31:54', '2024-08-27 06:31:54'),
(67, '1724760114.jfif', '2024-08-27 06:31:54', '2024-08-27 06:31:54'),
(68, '1724760115.jfif', '2024-08-27 06:31:55', '2024-08-27 06:31:55'),
(69, '1724760115.jpg', '2024-08-27 06:31:55', '2024-08-27 06:31:55'),
(70, '1724760530.jfif', '2024-08-27 06:38:50', '2024-08-27 06:38:50'),
(71, '1724760531.jfif', '2024-08-27 06:38:51', '2024-08-27 06:38:51'),
(72, '1724760531.jfif', '2024-08-27 06:38:51', '2024-08-27 06:38:51'),
(73, '1724760531.jpg', '2024-08-27 06:38:51', '2024-08-27 06:38:51'),
(74, '1724760694.jfif', '2024-08-27 06:41:34', '2024-08-27 06:41:34'),
(75, '1724760695.jfif', '2024-08-27 06:41:35', '2024-08-27 06:41:35'),
(76, '1724760695.jfif', '2024-08-27 06:41:35', '2024-08-27 06:41:35'),
(77, '1724760696.jpg', '2024-08-27 06:41:36', '2024-08-27 06:41:36'),
(78, '1724761246.jfif', '2024-08-27 06:50:46', '2024-08-27 06:50:46'),
(79, '1724761246.jfif', '2024-08-27 06:50:46', '2024-08-27 06:50:46'),
(80, '1724761247.jfif', '2024-08-27 06:50:47', '2024-08-27 06:50:47'),
(81, '1724761247.jpg', '2024-08-27 06:50:47', '2024-08-27 06:50:47'),
(82, '1724761760.jfif', '2024-08-27 06:59:20', '2024-08-27 06:59:20'),
(83, '1724761760.jfif', '2024-08-27 06:59:20', '2024-08-27 06:59:20'),
(84, '1724761761.jfif', '2024-08-27 06:59:21', '2024-08-27 06:59:21'),
(85, '1724761761.jpg', '2024-08-27 06:59:21', '2024-08-27 06:59:21'),
(86, '1724761761.jpg', '2024-08-27 06:59:21', '2024-08-27 06:59:21'),
(87, '1724764762.jpg', '2024-08-27 07:49:22', '2024-08-27 07:49:22'),
(88, '1724764762.jpg', '2024-08-27 07:49:22', '2024-08-27 07:49:22'),
(89, '1724764762.jpg', '2024-08-27 07:49:22', '2024-08-27 07:49:22'),
(90, '1724765375.jpg', '2024-08-27 07:59:35', '2024-08-27 07:59:35'),
(91, '1724765376.jpg', '2024-08-27 07:59:36', '2024-08-27 07:59:36'),
(92, '1724765376.jpg', '2024-08-27 07:59:36', '2024-08-27 07:59:36'),
(93, '1724765477.jpg', '2024-08-27 08:01:17', '2024-08-27 08:01:17'),
(94, '1724765477.jpg', '2024-08-27 08:01:17', '2024-08-27 08:01:17'),
(95, '1724765477.jpg', '2024-08-27 08:01:17', '2024-08-27 08:01:17'),
(96, '1724765524.jpg', '2024-08-27 08:02:04', '2024-08-27 08:02:04'),
(97, '1724765524.jpg', '2024-08-27 08:02:04', '2024-08-27 08:02:04'),
(98, '1724765524.jpg', '2024-08-27 08:02:04', '2024-08-27 08:02:04'),
(99, '1724765868.jpg', '2024-08-27 08:07:48', '2024-08-27 08:07:48'),
(100, '1724765868.jpg', '2024-08-27 08:07:48', '2024-08-27 08:07:48'),
(111, '1724849646.jfif', '2024-08-28 07:24:06', '2024-08-28 07:24:06'),
(112, '1724849646.jpg', '2024-08-28 07:24:06', '2024-08-28 07:24:06'),
(113, '1724849647.jpg', '2024-08-28 07:24:07', '2024-08-28 07:24:07'),
(114, '1724849648.jpg', '2024-08-28 07:24:08', '2024-08-28 07:24:08'),
(115, '1725305588.png', '2024-09-02 14:03:08', '2024-09-02 14:03:08'),
(116, '1725355934.png', '2024-09-03 04:02:14', '2024-09-03 04:02:14'),
(117, '1725356237.jpg', '2024-09-03 04:07:17', '2024-09-03 04:07:17'),
(118, '1725356451.webp', '2024-09-03 04:10:51', '2024-09-03 04:10:51'),
(119, '1725356667.jpg', '2024-09-03 04:14:27', '2024-09-03 04:14:27'),
(120, '1725356701.png', '2024-09-03 04:15:01', '2024-09-03 04:15:01'),
(121, '1725359734.jpg', '2024-09-03 05:05:34', '2024-09-03 05:05:34'),
(122, '1725359924.jpg', '2024-09-03 05:08:44', '2024-09-03 05:08:44'),
(123, '1725361385.jpg', '2024-09-03 05:33:05', '2024-09-03 05:33:05'),
(124, '1725364702.png', '2024-09-03 06:28:22', '2024-09-03 06:28:22'),
(125, '1725624733.png', '2024-09-06 06:42:13', '2024-09-06 06:42:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` int(11) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Admin', 'admin@gmail.com', 2, NULL, '$2y$10$YBabiMP2sqOSuuqacWk3IekAOamZ/cLWEdIQh7wfhhlA1bbR3fPMq', NULL, '2024-08-19 07:54:14', '2024-08-19 07:54:14'),
(3, 'User', 'user@gmail.com', 1, NULL, '$2y$10$MegGJ/8H7G3j/4qBM9LiNueOGkBdlIRvgoiG/l3QT/duwTOBwTHe.', NULL, '2024-08-19 07:56:18', '2024-08-19 07:56:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_sub_category_id_foreign` (`sub_category_id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `tmp_images`
--
ALTER TABLE `tmp_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1315;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tmp_images`
--
ALTER TABLE `tmp_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
