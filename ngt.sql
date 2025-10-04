-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2025 at 05:56 PM
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
-- Database: `ngt`
--

-- --------------------------------------------------------

--
-- Table structure for table `abouts`
--

CREATE TABLE `abouts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `mission` longtext DEFAULT NULL,
  `vision` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `abouts`
--

INSERT INTO `abouts` (`id`, `featured_image`, `description`, `mission`, `vision`, `created_at`, `updated_at`) VALUES
(1, 'abouts/p72HNwPOGw7HOgc9P2gRj6WBSLHIkPpADMMEyCAU.jpg', '<p>Nuhi Great Travels is your trusted partner in reliable and comfortable transportation solutions. We specialize in corporate car rentals, airport transfers, fleet leasing, and chauffeured services tailored to meet the unique needs of individuals and businesses.<br><br>With a commitment to excellence, safety, and professionalism, we go beyond just driving—we create seamless travel experiences that combine convenience, comfort, and class. Whether you’re on a business trip, vacation, or daily commute, Nuhi Great Travels ensures every journey is smooth, timely, and memorable.<br><br>As Kenya’s premier luxury and executive car rental service, we are dedicated to providing unparalleled comfort, style, and convenience. Our fleet of high-end vehicles is designed for business, leisure, and special events. We cater to individuals, corporate clients, and tourists, offering a luxurious experience that goes beyond mere transportation.</p>', 'Provide reliable, luxurious travel experiences', 'Be the preffered executive car rental service', '2025-10-04 07:29:02', '2025-10-04 08:08:26');

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
-- Table structure for table `carousels`
--

CREATE TABLE `carousels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `subtitle_two` varchar(255) DEFAULT NULL,
  `button_text` varchar(255) DEFAULT 'Read More',
  `button_link` varchar(255) DEFAULT NULL,
  `video_link` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carousels`
--

INSERT INTO `carousels` (`id`, `title`, `subtitle`, `subtitle_two`, `button_text`, `button_link`, `video_link`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Car <span>Rental</span>', 'Your Best', 'Experience', 'Learn More', 'https://www.youtube.com/watch?v=hC_C7VHtW3Y', 'https://www.youtube.com/watch?v=hC_C7VHtW3Y', 'carousels/ODixRUk2XzC5JvOLFhirzMG1C8I8i8dSgHpps2Fh.jpg', '2025-10-03 09:55:07', '2025-10-03 10:09:18');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `make` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `make`, `description`, `created_at`, `updated_at`) VALUES
(1, 'SUV', 'SUV', '2025-10-04 11:00:10', '2025-10-04 11:00:10'),
(2, 'Compact SUV', 'Compact SUV', '2025-10-04 11:00:41', '2025-10-04 11:00:41'),
(3, 'Luxury Sedan', 'Luxury Sedan', '2025-10-04 11:00:53', '2025-10-04 11:00:53'),
(4, 'Choppers', 'Choppers', '2025-10-04 11:01:09', '2025-10-04 11:01:09'),
(5, 'Luxury Sport Cars', 'Luxury Sport Cars', '2025-10-04 11:01:25', '2025-10-04 11:01:25'),
(6, 'Coaster Bus', 'Coaster Bus', '2025-10-04 11:01:40', '2025-10-04 11:01:40'),
(7, 'Limousine', 'Limousine', '2025-10-04 11:15:43', '2025-10-04 11:15:43');

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
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'How old do I need to be to rent a car?', 'From personalized solutions to expert execution, we prioritize quality, reliability, and customer satisfaction in everything we do. Let us be your trusted partner in achieving success.', 1, '2025-10-04 10:02:54', '2025-10-04 10:02:54'),
(2, 'How old do I need to be to rent a car?', 'From personalized solutions to expert execution, we prioritize quality, reliability, and customer satisfaction in everything we do. Let us be your trusted partner in achieving success.', 1, '2025-10-04 10:03:30', '2025-10-04 10:03:30'),
(3, 'What documents do I need to rent a car?', 'From personalized solutions to expert execution, we prioritize quality, reliability, and customer satisfaction in everything we do. Let us be your trusted partner in achieving success.', 1, '2025-10-04 10:08:48', '2025-10-04 10:08:48'),
(4, 'What types of vehicles are available for rent?', 'From personalized solutions to expert execution, we prioritize quality, reliability, and customer satisfaction in everything we do. Let us be your trusted partner in achieving success.', 1, '2025-10-04 10:09:11', '2025-10-04 10:09:11'),
(5, 'Can I rent a car with a debit card?', 'From personalized solutions to expert execution, we prioritize quality, reliability, and customer satisfaction in everything we do. Let us be your trusted partner in achieving success.', 1, '2025-10-04 10:09:33', '2025-10-04 10:09:33'),
(6, 'What is your fuel policy?', 'From personalized solutions to expert execution, we prioritize quality, reliability, and customer satisfaction in everything we do. Let us be your trusted partner in achieving success.', 1, '2025-10-04 10:09:54', '2025-10-04 10:13:47');

-- --------------------------------------------------------

--
-- Table structure for table `fleets`
--

CREATE TABLE `fleets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `car_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(11,0) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fleets`
--

INSERT INTO `fleets` (`id`, `car_id`, `name`, `type`, `image`, `price`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Range Rover V8 2020', 'SUV', 'fleets/LXkgGwWeLrZQuiuYl0mleovtkW7DUtgocAjgu1Qc.png', NULL, 'Range Rover V8 2020', '2025-10-04 10:43:50', '2025-10-04 11:19:15'),
(2, 3, 'Toyota Crown Athlete', 'Sedan', 'fleets/qJboHlBRL5a0Cvs4jPXla3HtQJzgrF3PVmaKiXkt.jpg', NULL, 'Toyota Crown Athlete', '2025-10-04 10:45:15', '2025-10-04 11:19:05'),
(3, 3, 'Mercedes Bens E350 2021', 'Sedan', 'fleets/YLcySMyuiNks85eTNPUXuruyLZGPIMfVLwKqEn6l.jpg', NULL, 'Mercedes Bens E350 2021', '2025-10-04 10:46:18', '2025-10-04 11:18:56'),
(4, 2, 'Mercedes GLE 350', 'Compact SUV', 'fleets/9hWEh7vkUQasbzerU74NUPaVk8TI4WEx45tflQEF.jpg', NULL, 'Mercedes GLE 350', '2025-10-04 10:47:38', '2025-10-04 11:18:44'),
(5, 1, 'Toyota Land Cruiser TX', 'SUV', 'fleets/l0ZhQHCjZs4lW5yWbSlEHYJ1REhDKtLAlbWxs9Lr.jpg', NULL, 'Toyota Land Cruiser TX', '2025-10-04 10:48:20', '2025-10-04 11:18:35'),
(6, 2, 'Porsche Cayenne', 'Compact SUV', 'fleets/mljV68PaBqqwI1yoJOFajENdFFsVvIIghmY2qzog.jpg', NULL, 'Porsche Cayenne', '2025-10-04 10:49:26', '2025-10-04 11:18:27'),
(7, 7, 'Cadillac Limousine', 'Limousine', 'fleets/diMDa5R9aUUy7F5VrTBLcAOd63rFdi6uJewJMX6U.jpg', NULL, 'Cadillac Limousine', '2025-10-04 10:50:50', '2025-10-04 11:18:16');

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
(4, '2025_10_03_090435_add_role_to_users_table', 1),
(5, '2025_10_03_095304_create_cars_tabsle', 2),
(6, '2025_10_03_120504_create_settings_tasble', 2),
(7, '2025_10_03_095304_create_cars_tasble', 3),
(8, '2025_10_03_120504_create_settingsssss_table', 3),
(9, '2025_10_03_120504_create_settings_table', 4),
(10, '2025_10_03_124419_create_carousels_table', 5),
(11, '2025_10_04_100158_create_abouts_table', 6),
(12, '2025_10_04_125031_create_faqs_table', 7),
(13, '2025_10_04_133251_create_fleets_table', 8),
(14, '2025_10_03_095304_create_cars_table', 9),
(15, '2025_10_04_140703_add_car_id_to_fleets_table', 10),
(16, '2025_10_04_143544_create_services_table', 11);

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
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `slug`, `image`, `short_description`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Self Drive Rentals', 'self-drive-rentals', 'services/zBUYhKBrk6iT65Ke0ammQanB2OUKwe6NLOOCXYTI.jpg', NULL, 'Self Drive Rentals', 1, '2025-10-04 11:54:49', '2025-10-04 12:24:15'),
(2, 'Airport Transfers', 'airport-transfers', 'services/8NCKYz7eFvvCCSuhsIMflJuqfUQJTGe6Lej5hlmP.jpg', NULL, 'Airport Transfers', 1, '2025-10-04 11:59:01', '2025-10-04 12:24:09'),
(3, 'Chauffered Services', 'chauffered-services', 'services/Y8W7mC8S1EIA2VYUwQNmASmvAvOiFavfmzK4FqnD.png', NULL, 'Chauffered Services', 1, '2025-10-04 12:13:54', '2025-10-04 12:24:05'),
(4, 'Corporate Rentals', 'corporate-rentals', 'services/RNzqIysAJWpVO4CmyoWJuNKzTPEJBaggpjHHiJRW.jpg', NULL, 'Corporate Rentals', 1, '2025-10-04 12:14:36', '2025-10-04 12:24:00'),
(5, 'Event Car Rentals', 'event-car-rentals', 'services/xT52V7rvsHmpxLlxXQ8KNR8fDWnZ5JWCIWTD2pay.png', NULL, 'Event Car Rentals', 1, '2025-10-04 12:15:11', '2025-10-04 12:23:56');

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
('JCuCHaBhYEgqF0qUTL9glF6Tf6n3RX6RsgK9i2bz', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiUERXYU5OVENiWTJtVnJhdzdId01hTDRHaGtWWmN2RmRPc081VWs0WCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1759592016);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `shape` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `tiktok` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `map_iframe` longtext DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `tawkto` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `url`, `logo`, `favicon`, `shape`, `email`, `mobile`, `location`, `facebook`, `instagram`, `tiktok`, `twitter`, `youtube`, `map_iframe`, `linkedin`, `tawkto`, `whatsapp`, `created_at`, `updated_at`) VALUES
(1, 'https://nuhigreattravels.com', 'settings/kQw9ZzvzEgX5VTAjGc6QJ1SBQ0ppP5vpalacr5Wy.jpg', 'settings/EPLDU9OyU2IaQnaqGvgVY3SeTpspAQkFoWcs2GST.png', NULL, 'info@nuhigreattravels.com', '+254 712 675 673', 'Hurlingham, Nairobi, Kenya', 'https://www.facebook.com/', 'https://instagram.com', 'https://tiktok.com', 'https://x.com', NULL, 'https://wa.me/254712675673', 'https://linkedin.com', 'https://wa.me/254712675673', 'https://wa.me/254712675673', '2025-10-03 09:29:51', '2025-10-04 11:33:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'client',
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
(1, 'Site Admin', 'admin@nuhigreattravels.com', 'admin', '2025-10-03 06:45:56', '$2y$12$XLrUmuDeAyhGzsRu.hvRx.Z1OYVWy/hmfepmALGDznl0Hm9/WV82S', 'vuih0OyszM', '2025-10-03 06:45:56', '2025-10-03 06:45:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abouts`
--
ALTER TABLE `abouts`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `carousels`
--
ALTER TABLE `carousels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fleets`
--
ALTER TABLE `fleets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fleets_car_id_foreign` (`car_id`);

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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
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
-- AUTO_INCREMENT for table `abouts`
--
ALTER TABLE `abouts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `carousels`
--
ALTER TABLE `carousels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `fleets`
--
ALTER TABLE `fleets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fleets`
--
ALTER TABLE `fleets`
  ADD CONSTRAINT `fleets_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
