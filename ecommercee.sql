-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Oct 19, 2025 at 05:01 AM
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
-- Database: `ecommercee`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(2, 'LAPTOP', '2025-10-18 06:53:08', '2025-10-18 06:53:08'),
(3, 'SMARTPHONES', '2025-10-18 06:53:19', '2025-10-18 06:53:19'),
(4, 'EARPHONES', '2025-10-18 08:12:21', '2025-10-18 08:12:21'),
(5, 'AIR PODS', '2025-10-18 08:12:28', '2025-10-18 08:12:28'),
(6, 'CHARGER', '2025-10-18 08:12:41', '2025-10-18 08:12:41');

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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_10_17_173025_add_role_to_users_table', 1),
(5, '2025_10_17_214138_create_categories_table', 1),
(6, '2025_10_17_214138_create_products_table', 1),
(7, '2025_10_17_234506_add_slug_to_products_table', 1),
(8, '2025_10_18_173429_create_orders_table', 2),
(9, '2025_10_18_173800_create_order_items_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `recipient_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address_text` text NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `subtotal` bigint(20) UNSIGNED NOT NULL,
  `shipping_cost` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `grand_total` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `recipient_name`, `phone`, `address_text`, `note`, `subtotal`, `shipping_cost`, `grand_total`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'Ananda Bagus', '082310231999', 'Jl. Rengasdengklok,', 'taruh depan aja', 36600000, 0, 36600000, 'pending', '2025-10-18 13:03:59', '2025-10-18 13:03:59'),
(2, 2, 'Ananda Bagus', '082310231999', 'Jl. Rengasdengklok,', 'taruh depan aja', 27000000, 0, 27000000, 'pending', '2025-10-18 13:09:07', '2025-10-18 13:09:07'),
(3, 2, 'Bananda', '08712121121212', 'mulawarman bebas bos', 'taruh di loker', 129000, 0, 129000, 'pending', '2025-10-18 13:27:40', '2025-10-18 13:27:40'),
(4, 2, 'Ananda Bagus', '082310231999', 'Jl. Rengasdengklok,', 'taruh depan aja', 290000, 0, 290000, 'completed', '2025-10-18 13:44:48', '2025-10-18 15:24:27'),
(5, 2, 'Ananda', '0987654112121', 'Jl mulawarman', 'hehe', 129000, 0, 129000, 'shipped', '2025-10-18 17:18:21', '2025-10-18 17:19:07'),
(6, 1, 'admin', '0987654112121', 'Jl mulawarman', 'hehe', 290000, 0, 290000, 'pending', '2025-10-18 17:19:31', '2025-10-18 17:19:31'),
(7, 1, 'admin1', '0987654112121', 'Jl mulawarman', 'hehe', 27000000, 0, 27000000, 'pending', '2025-10-18 17:35:43', '2025-10-18 17:35:43'),
(8, 2, 'nabil', '09876545678', 'banjarsari', 'xxx', 290000, 0, 290000, 'pending', '2025-10-18 18:52:00', '2025-10-18 18:52:00'),
(9, 2, 'Pamong', '08121345124', 'Kos. Mulawarman Bebas', 'taruh depan aja pak', 5899000, 0, 5899000, 'pending', '2025-10-18 19:29:03', '2025-10-18 19:29:03');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name_snapshot` varchar(255) NOT NULL,
  `price_snapshot` bigint(20) UNSIGNED NOT NULL,
  `qty` int(10) UNSIGNED NOT NULL,
  `subtotal` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name_snapshot`, `price_snapshot`, `qty`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 'UGREEN Charger For Samsung USB C To USB C Super FAST Charging 25W 45W 2.0 Black - ADP 25W Black', 129000, 2, 258000, '2025-10-18 13:03:59', '2025-10-18 13:03:59'),
(2, 1, 4, 'ASUS VIVOBOOK GO 14 E1404FA-VIPS5151M - RYZEN 5-7520U 16GB 512GB 14\"VIPS W11 OHS', 9342000, 1, 9342000, '2025-10-18 13:03:59', '2025-10-18 13:03:59'),
(3, 1, 3, 'Macbook Pro M4', 27000000, 1, 27000000, '2025-10-18 13:03:59', '2025-10-18 13:03:59'),
(4, 2, 3, 'Macbook Pro M4', 27000000, 1, 27000000, '2025-10-18 13:09:07', '2025-10-18 13:09:07'),
(5, 3, 6, 'UGREEN Charger For Samsung USB C To USB C Super FAST Charging 25W 45W 2.0 Black - ADP 25W Black', 129000, 1, 129000, '2025-10-18 13:27:40', '2025-10-18 13:27:40'),
(6, 4, 5, 'Apple Airpods 4 Active Noise Cancellation Transparency Airpod Gen 4th - GEN 4 ANC', 290000, 1, 290000, '2025-10-18 13:44:48', '2025-10-18 13:44:48'),
(7, 5, 6, 'UGREEN Charger For Samsung USB C To USB C Super FAST Charging 25W 45W 2.0 Black - ADP 25W Black', 129000, 1, 129000, '2025-10-18 17:18:21', '2025-10-18 17:18:21'),
(8, 6, 5, 'Apple Airpods 4 Active Noise Cancellation Transparency Airpod Gen 4th - GEN 4 ANC', 290000, 1, 290000, '2025-10-18 17:19:31', '2025-10-18 17:19:31'),
(9, 7, 3, 'Macbook Pro M4', 27000000, 1, 27000000, '2025-10-18 17:35:43', '2025-10-18 17:35:43'),
(10, 8, 5, 'Apple Airpods 4 Active Noise Cancellation Transparency Airpod Gen 4th - GEN 4 ANC', 290000, 1, 290000, '2025-10-18 18:52:00', '2025-10-18 18:52:00'),
(11, 9, 7, 'Samsung Galaxy A56 5G [8/256] [Upgrade dari 8/128 GB] - Galaxy AI | Smartphone AI | 50MP OIS HDR Camera | 45W Super Fast Charge', 5899000, 1, 5899000, '2025-10-18 19:29:03', '2025-10-18 19:29:03');

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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `stock` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `price` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `category_id`, `stock`, `price`, `is_active`, `image_path`, `created_at`, `updated_at`) VALUES
(2, 'Iphone X 256 GB Grey', 'iphone-x-256-gb-grey-v4wde', 3, 2, 3000000, 1, 'products/oeNTXyIZEDZxye39nK6FoFx2YksjxmSGSmAmZPj6.jpg', '2025-10-18 06:55:12', '2025-10-18 06:55:12'),
(3, 'Macbook Pro M4', 'macbook-pro-m4-TVBnA', 2, 7, 27000000, 1, 'products/XUViq7uZHl9KtwCV5lZltrNkmj30J4e0g8JcNIIU.webp', '2025-10-18 06:56:58', '2025-10-18 17:35:43'),
(4, 'ASUS VIVOBOOK GO 14 E1404FA-VIPS5151M - RYZEN 5-7520U 16GB 512GB 14\"VIPS W11 OHS', 'asus-vivobook-go-14-e1404fa-vips5151m-ryzen-5-7520u-16gb-512gb-14vips-w11-ohs-Akyxi', 2, 9, 9342000, 1, 'products/0WQPo3LGoJP8DOqxad8i5tHvRdDqc0DPB1DBqkoG.jpg', '2025-10-18 07:55:35', '2025-10-18 13:03:59'),
(5, 'Apple Airpods 4 Active Noise Cancellation Transparency Airpod Gen 4th - GEN 4 ANC', 'apple-airpods-4-active-noise-cancellation-transparency-airpod-gen-4th-gen-4-anc-PpA0u', 5, 27, 290000, 1, 'products/avoe5Z5TF0vZ8oM1zm7SN85d3posX7ypJzBIYguB.jpg', '2025-10-18 08:32:11', '2025-10-18 18:52:00'),
(6, 'UGREEN Charger For Samsung USB C To USB C Super FAST Charging 25W 45W 2.0 Black - ADP 25W Black', 'ugreen-charger-for-samsung-usb-c-to-usb-c-super-fast-charging-25w-45w-20-black-adp-25w-black-Ah9vA', 6, 56, 129000, 1, 'products/Htqr5444a05F0ifPMJoUQl8wzGXhzl4KDOw0n8il.jpg', '2025-10-18 08:34:22', '2025-10-18 17:18:21'),
(7, 'Samsung Galaxy A56 5G [8/256] [Upgrade dari 8/128 GB] - Galaxy AI | Smartphone AI | 50MP OIS HDR Camera | 45W Super Fast Charge', 'samsung-galaxy-a56-5g-8256-upgrade-dari-8128-gb-galaxy-ai-smartphone-ai-50mp-ois-hdr-camera-45w-super-fast-charge-t2e76', 3, 9, 5899000, 1, 'products/PbvkAgfB74HY90R4fMZx8NFMcnUwdBwMe4dJ2pvN.jpg', '2025-10-18 19:23:46', '2025-10-18 19:29:03');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('5qmR8f2GL2N91PJCgE4xvWuGEsfNO61XRUJOJ3BD', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNmFmd2NQN0dBaGpzUUVBaHAxTkZTMlZ5U0RnOEZFTHhBMGRYWXQzUCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9vcmRlcnMvNSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1760835349),
('JA9dU9yTtd37CJlnAEO5kpBIEmdbKVRt3HW3lrpx', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSHl6ODM5RjlaVUhQa0VteWlva2JnTWxYeXM3SkRtWnRoZnk1aThOYiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9teS9vcmRlcnMvOSI7fXM6NDoiY2FydCI7YToxOntpOjA7YToyOntzOjEwOiJwcm9kdWN0X2lkIjtpOjY7czozOiJxdHkiO2k6MTt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1760842537),
('nSymzxGTWNAIUoiUH2juthQ3706QuTGcRTU1BV1T', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWmZqd3R6aUt6bmhXOXh1S2RxMFdrbXlrQmxQWmNsSWdZc29ISERrSiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNjoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL29yZGVycy81Ijt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1760835641),
('QlkEMscEt19fyyiqUiseXLSvnApKtp2tl9lhd3rr', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYm1DbEZlYW5PeVNwaFNTdWlKZ0Y2dUt1UXZrRlltak1Za0Q3VTZRRSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1760836542);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
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
(1, 'admin1', 'admin1@gmail.com', 'admin', NULL, '$2y$12$5GjrmIZBuZbHuliX73hWl.mC5w3s30Zwfu4.C.G2ZS3XxKpIQA01a', NULL, '2025-10-18 06:27:12', '2025-10-18 06:27:12'),
(2, 'user1', 'user1@gmail.com', 'user', NULL, '$2y$12$SMBpuKP.wm6fkRwxV5ooNe1byUZgMP3SE2tQIbHkoC32gOqMyyKRS', NULL, '2025-10-18 06:35:53', '2025-10-18 06:35:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
