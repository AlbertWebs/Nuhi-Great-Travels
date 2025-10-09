-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2025 at 05:49 PM
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
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `slug`, `author`, `excerpt`, `content`, `featured_image`, `is_published`, `created_at`, `updated_at`) VALUES
(1, 'Documentrs required for Car Rental Services', 'documentrs-required-for-car-rental-services', 'Site Admin', 'Car Is Where Early Adopters And Innovation Seekers Find Lively Imaginative Tech.', 'Car Is Where Early Adopters And Innovation Seekers Find Lively Imaginative Tech. Car Is Where Early Adopters And Innovation Seekers Find Lively Imaginative Tech. Car Is Where Early Adopters And Innovation Seekers Find Lively Imaginative Tech. Car Is Where Early Adopters And Innovation Seekers Find Lively Imaginative Tech.', 'blogs/34WlYAFKA5B805vioVKeqR5lCX0rJH6k7HCWsPiT.jpg', 0, '2025-10-06 05:42:53', '2025-10-06 05:42:53'),
(2, 'How to rent a car at the Airport Terminal', 'how-to-rent-a-car-at-the-airport-terminal', 'Site Admin', 'How to rent a car at the Airport Terminal', 'How to rent a car at the Airport Terminal', 'blogs/2VKEfVAlTygzrooijCPwVS5cHwEkS5nVCPpjZ1t5.jpg', 0, '2025-10-06 05:47:28', '2025-10-06 05:47:28'),
(3, 'Rental cars how to check driving                                         fines?', 'rental-cars-how-to-check-driving-fines', 'Site Admin', 'Rental cars how to check driving\r\n                                        fines?', 'Rental cars how to check driving\r\n                                        fines?', 'blogs/zNcCh4l7qHYHiPJWu1fxgZcXLYnlZHiMURusMAfF.jpg', 0, '2025-10-06 05:48:16', '2025-10-06 05:48:16');

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
  `slug` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `make`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'SUV', 'suv', 'SUV', '2025-10-04 11:00:10', '2025-10-04 11:00:10'),
(2, 'Compact SUV', 'compact-suv', 'Compact SUV', '2025-10-04 11:00:41', '2025-10-08 09:52:45'),
(3, 'Luxury Sedan', 'luxury-sedan', 'Luxury Sedan', '2025-10-04 11:00:53', '2025-10-08 09:52:21'),
(4, 'Chopper', 'chopper', 'Choppers', '2025-10-04 11:01:09', '2025-10-08 09:51:31'),
(5, 'Luxury Sport Car', 'luxury-sport-car', 'Luxury Sport Cars', '2025-10-04 11:01:25', '2025-10-08 09:51:04'),
(6, 'Coaster Bus', 'coaster-bus', 'Coaster Bus', '2025-10-04 11:01:40', '2025-10-08 09:51:58'),
(7, 'Limousines', 'limousines', 'Limousine', '2025-10-04 11:15:43', '2025-10-08 09:50:51');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kyc_token` char(36) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `kyc_token`, `name`, `image`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Radison Hotels & Resorts', 'clients/e5Ib6j5Ij56sbgucffl0cXThFa9b7ja2YHHYtDi2.png', '2025-10-06 12:00:15', '2025-10-06 12:00:15'),
(2, NULL, 'EABL', 'clients/rguPsB9daHQPcus34TRl7G6DQzvSeqg8KFed6Hsd.png', '2025-10-06 12:00:30', '2025-10-06 12:00:30'),
(3, NULL, 'Mega-Scope', 'clients/U90poE4DUCNDglWofflzsGQFjKX8bipLOJJvpwAf.png', '2025-10-06 12:00:52', '2025-10-06 12:00:52'),
(4, NULL, 'Kenatco Taxis Limited', 'clients/ckRrhvserEHcWTDQcI08ohprdqz6YCcRnaoNhNwa.png', '2025-10-06 12:01:15', '2025-10-06 12:01:15'),
(5, NULL, 'Faimount The Norfolk', 'clients/lsrh9h4AgANujcWPBK1PkmRG6uPSmBfMiedj6TH9.png', '2025-10-06 12:01:51', '2025-10-06 12:01:51'),
(6, NULL, 'TV47', 'clients/Z7jhIByLBvpYaP6cMrNODu21PjkXru36WLJe5kn8.png', '2025-10-06 12:02:15', '2025-10-06 12:02:15'),
(7, NULL, 'USA Embasi', 'clients/6Rm2LqVL1FKonCXEglmoYiDKRFcGnGysneEx6EJ0.png', '2025-10-06 12:02:30', '2025-10-06 12:02:30'),
(8, NULL, 'YDx Agency', 'clients/m0918PcZXFpUrpTgFhVg2REw9uKgZCvSzSmDSqdH.png', '2025-10-06 12:02:47', '2025-10-06 12:02:47');

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
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `position`, `company`, `message`, `photo`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Albert', 'MD', 'Designekta Studios', 'Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services', 'feedback/ZUKlAubfOChmQMAseRlIjITOUt4BKLLUKr9eKGw4.jpg', 1, '2025-10-06 05:05:47', '2025-10-06 05:05:47'),
(2, 'Albert', 'MD', 'Designekta Studios', 'Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services', 'feedback/ivZo3nz8PFxfBvVAVycRy82lJqUmic1c50Lqn9fu.jpg', 1, '2025-10-06 05:06:37', '2025-10-06 05:06:37'),
(3, 'Albert', 'MD', 'Designekta Studios', 'Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services', 'feedback/ivZo3nz8PFxfBvVAVycRy82lJqUmic1c50Lqn9fu.jpg', 1, '2025-10-06 05:06:37', '2025-10-06 05:06:37'),
(4, 'Albert', 'MD', 'Designekta Studios', 'Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services', 'feedback/ZUKlAubfOChmQMAseRlIjITOUt4BKLLUKr9eKGw4.jpg', 1, '2025-10-06 05:05:47', '2025-10-06 05:05:47'),
(5, 'Albert', 'MD', 'Designekta Studios', 'Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services Wonderful Services', 'feedback/ZUKlAubfOChmQMAseRlIjITOUt4BKLLUKr9eKGw4.jpg', 1, '2025-10-06 05:05:47', '2025-10-06 05:05:47');

-- --------------------------------------------------------

--
-- Table structure for table `fleets`
--

CREATE TABLE `fleets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `car_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `transmission` varchar(255) DEFAULT NULL,
  `fuel_type` varchar(255) DEFAULT NULL,
  `seats` int(11) DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(11,0) DEFAULT NULL,
  `price_per_day` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `status` enum('available','unavailable') NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fleets`
--

INSERT INTO `fleets` (`id`, `car_id`, `name`, `slug`, `type`, `transmission`, `fuel_type`, `seats`, `year`, `image`, `price`, `price_per_day`, `description`, `content`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Range Rover V8 2020', 'range-rover-v8-2020-1', 'SUV', NULL, NULL, NULL, NULL, 'fleets/LXkgGwWeLrZQuiuYl0mleovtkW7DUtgocAjgu1Qc.png', NULL, NULL, 'Range Rover V8 2020', NULL, 'available', '2025-10-04 10:43:50', '2025-10-08 10:24:17'),
(2, 3, 'Toyota Crown Athlete', 'toyota-crown-athlete-2', 'Sedan', NULL, NULL, NULL, NULL, 'fleets/qJboHlBRL5a0Cvs4jPXla3HtQJzgrF3PVmaKiXkt.jpg', NULL, NULL, 'Toyota Crown Athlete', NULL, 'available', '2025-10-04 10:45:15', '2025-10-08 10:24:17'),
(3, 3, 'Mercedes Bens E350 2021', 'mercedes-bens-e350-2021-3', 'Sedan', NULL, NULL, NULL, NULL, 'fleets/YLcySMyuiNks85eTNPUXuruyLZGPIMfVLwKqEn6l.jpg', NULL, NULL, 'Mercedes Bens E350 2021', NULL, 'available', '2025-10-04 10:46:18', '2025-10-08 10:24:17'),
(4, 2, 'Mercedes GLE 350', 'mercedes-gle-350-4', 'Compact SUV', NULL, NULL, NULL, NULL, 'fleets/9hWEh7vkUQasbzerU74NUPaVk8TI4WEx45tflQEF.jpg', NULL, NULL, 'Mercedes GLE 350', NULL, 'available', '2025-10-04 10:47:38', '2025-10-08 10:24:17'),
(5, 1, 'Toyota Land Cruiser TX', 'toyota-land-cruiser-tx-5', 'SUV', NULL, NULL, NULL, NULL, 'fleets/l0ZhQHCjZs4lW5yWbSlEHYJ1REhDKtLAlbWxs9Lr.jpg', NULL, NULL, 'Toyota Land Cruiser TX', NULL, 'available', '2025-10-04 10:48:20', '2025-10-08 10:24:17'),
(6, 2, 'Porsche Cayenne', 'porsche-cayenne-6', 'Compact SUV', NULL, NULL, NULL, NULL, 'fleets/mljV68PaBqqwI1yoJOFajENdFFsVvIIghmY2qzog.jpg', NULL, NULL, 'Porsche Cayenne', NULL, 'available', '2025-10-04 10:49:26', '2025-10-08 10:24:17'),
(7, 7, 'Cadillac Limousine', 'cadillac-limousine-7', 'Limousine', NULL, NULL, NULL, NULL, 'fleets/diMDa5R9aUUy7F5VrTBLcAOd63rFdi6uJewJMX6U.jpg', NULL, NULL, 'Cadillac Limousine', NULL, 'available', '2025-10-04 10:50:50', '2025-10-08 10:24:17'),
(8, 2, 'Mercedes Bens  GLE 300', 'mercedes-bens-gle-300', 'SUV', 'Automatic', 'Petrol', 4, '2018', 'fleets/uM3ZFxYECI3btL4sAX3WtoHRNGmfUufw0RqxpiYo.jpg', 12000, 15000.00, 'The Mercedes-Benz GLE 300 is the cornerstone of the Nuhi Great Travel fleet—the ultimate expression of prestige, comfort, and safety. When you book a GLE 300, you aren\'t just hiring an SUV; you are investing in a seamless, tranquil, and productive travel experience.\r\n\r\nThe Mercedes-Benz GLE 300 is the cornerstone of the Nuhi Great Travel fleet—the ultimate expression of prestige, comfort, and safety. When you book a GLE 300, you aren\'t just hiring an SUV; you are investing in a seamless, tranquil, and productive travel experience.', '<h2>Mercedes-Benz GLE 300: Your Journey, Elevated</h2><p>&nbsp;</p><p><strong>Headline: Arrive with Uncompromising Style and Serenity.</strong></p><p>The Mercedes-Benz GLE 300 is the cornerstone of the Nuhi Great Travel fleet—the ultimate expression of prestige, comfort, and safety. When you book a GLE 300, you aren\'t just hiring an SUV; you are investing in a seamless, tranquil, and productive travel experience.</p><p>&nbsp;</p><h3>Why the GLE 300 Defines Nuhi Luxury:</h3><p>&nbsp;</p><p>&nbsp;</p><h4>1. First-Class Comfort, Every Seat</h4><p>&nbsp;</p><p>From the moment you step in, the GLE cabin is a sanctuary. Designed for long-haul serenity, it offers abundant legroom, supportive seating, and a whisper-quiet ride, making it the perfect mobile office or private retreat.</p><ul><li><strong>Custom Climate Control:</strong> Enjoy personalized comfort with advanced multi-zone climate control.</li><li><strong>Ambient Serenity:</strong> Subtle <strong>64-colour ambient lighting</strong> is customized to create a relaxing and sophisticated atmosphere for any time of day.</li></ul><p>&nbsp;</p><h4>2. Seamlessly Connected, Effortlessly Productive</h4><p>&nbsp;</p><p>Our clients shouldn\'t have to pause their life while traveling. The GLE’s cutting-edge technology ensures you remain connected and in control, securely and intuitively.</p><ul><li><strong>MBUX Intelligence:</strong> Control navigation, communication, and entertainment using the dual high-definition displays and intuitive voice control (\"Hey Mercedes\").</li><li><strong>Always Charged:</strong> Dedicated, fast-charging USB-C ports in the front and rear ensure all your devices are ready for your next meeting or destination.</li></ul><p>&nbsp;</p><h4>3. Efficient Power, Unshakeable Reliability</h4><p>&nbsp;</p><p>For Nuhi, reliability is non-negotiable. The GLE 300 combines the robust performance of its modern mild-hybrid powertrain (Diesel or Petrol) with Mercedes-Benz\'s renowned engineering.</p><ul><li><strong>Efficient Performance:</strong> Experience smooth, effortless acceleration with optimized fuel efficiency—meaning fewer stops and more time on the road.</li><li><strong>4MATIC Confidence:</strong> Mercedes-Benz\'s All-Wheel Drive system ensures stable, confident travel on all roads, guaranteeing reliable, on-time arrivals, regardless of the weather.</li><li><strong>Ample Luggage Capacity:</strong> The generous boot space is perfectly sized to handle a full complement of passenger luggage, making it ideal for high-end airport transfers and extended tours.</li></ul>', 'available', '2025-10-08 10:35:15', '2025-10-08 11:50:28');

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
-- Table structure for table `kyc_submissions`
--

CREATE TABLE `kyc_submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `document_type` varchar(255) NOT NULL,
  `document_image` varchar(255) NOT NULL,
  `selfie_image` varchar(255) NOT NULL,
  `liveliness_data` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `legals`
--

CREATE TABLE `legals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `page` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `legals`
--

INSERT INTO `legals` (`id`, `page`, `title`, `content`, `created_at`, `updated_at`) VALUES
(1, 'terms', 'Terms and Conditions', '<p>test</p>', NULL, '2025-10-07 14:05:51'),
(2, 'privacy', 'Privacy Policy', NULL, NULL, NULL),
(3, 'booking', 'Booking Policy', NULL, NULL, NULL),
(4, 'copyright', 'Copyright Statement', NULL, NULL, NULL);

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
(16, '2025_10_04_143544_create_services_table', 11),
(17, '2025_10_06_075826_create_feedback_table', 12),
(18, '2025_10_06_083133_create_blogs_table', 13),
(19, '2025_10_06_145532_create_clients_table', 14),
(20, '2025_10_06_165143_create_legals_table', 15),
(21, '2025_10_07_171336_create_notifications_table', 16),
(22, '2025_10_07_174628_create_sms_table', 17),
(23, '2025_10_08_064228_create_subscribers_table', 18),
(24, '2025_10_08_072746_create_kyc_submissions_table', 19),
(25, '2025_10_08_100255_add_kyc_token_to_clients_table', 20),
(26, '2025_10_08_100822_add_kyc_token_to_users_table', 21);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
('vAwYl1P7vAy374CzrZct4dgvEq5Eh1aUAqAwsUGo', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:143.0) Gecko/20100101 Firefox/143.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiaEE5YkVVZjRjek1LbkZiWlhMSHdPMjFYUnRMSlQzRmNER3gyN3F6QSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM4OiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYWRtaW4va3ljL2NyZWF0ZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1759938506),
('w6ViPeta8EKRiWDIdxVixsPCm6VbxVcDmyuOVKEr', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiaDM2R0ZyT1RIbkpPSDU1WkcxQ3ZTZEN4TmZHZ3Z2dmhCSm1vbVNYdyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9zZXJ2aWNlcy9jb3Jwb3JhdGUtcmVudGFscyI7fXM6MzoidXJsIjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1759938508);

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
-- Table structure for table `sms`
--

CREATE TABLE `sms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `recipients` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`recipients`)),
  `status` varchar(255) NOT NULL DEFAULT 'sent',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `email`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'albertmuhatia@gmail.com', 1, '2025-10-08 04:11:45', '2025-10-08 04:11:45'),
(2, 'designektastudios@gmail.com', 1, '2025-10-08 04:15:56', '2025-10-08 04:15:56'),
(3, 'nickmuthuma@gmail.com', 1, '2025-10-08 04:18:46', '2025-10-08 04:18:46'),
(4, 'kimrop20@gmail.com', 1, '2025-10-08 04:19:59', '2025-10-08 04:19:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kyc_token` char(36) DEFAULT NULL,
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

INSERT INTO `users` (`id`, `kyc_token`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '0e1b6cf6-9919-4808-8f5b-bf30cafb5441', 'Site Admin', 'admin@nuhigreattravels.com', 'admin', '2025-10-03 06:45:56', '$2y$12$XLrUmuDeAyhGzsRu.hvRx.Z1OYVWy/hmfepmALGDznl0Hm9/WV82S', 'WZgdMdrGxBcZ0yHiPO3OfWypPvAoXLnGzNMnOPUrXppor37JuX1iDssZ5Bds', '2025-10-03 06:45:56', '2025-10-08 07:09:13'),
(2, 'c38610d4-8528-4287-938f-65aa6d402436', 'Albert Muhatia', 'albert@nuhigreattravels.com', 'client', NULL, '$2y$12$sDEjWXCEa2ga4lDsibcOt.qvcTX1QmazPcHCKO3ETp0cnIK0VuFZu', NULL, '2025-10-06 13:46:01', '2025-10-08 07:09:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abouts`
--
ALTER TABLE `abouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blogs_slug_unique` (`slug`);

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
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clients_kyc_token_unique` (`kyc_token`);

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
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
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
-- Indexes for table `kyc_submissions`
--
ALTER TABLE `kyc_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `legals`
--
ALTER TABLE `legals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
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
-- Indexes for table `sms`
--
ALTER TABLE `sms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscribers_email_unique` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_kyc_token_unique` (`kyc_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abouts`
--
ALTER TABLE `abouts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `fleets`
--
ALTER TABLE `fleets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kyc_submissions`
--
ALTER TABLE `kyc_submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `legals`
--
ALTER TABLE `legals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `sms`
--
ALTER TABLE `sms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
