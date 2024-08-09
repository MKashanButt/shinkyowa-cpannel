-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2024 at 11:34 PM
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
-- Database: `shinkyowa_cpannel`
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

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('admin@shinkyowa.com|127.0.0.1', 'i:1;', 1721919504),
('admin@shinkyowa.com|127.0.0.1:timer', 'i:1721919504;', 1721919504);

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
-- Table structure for table `customer_accounts`
--

CREATE TABLE `customer_accounts` (
  `id` int(11) NOT NULL,
  `customer_id` varchar(100) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_company` varchar(200) NOT NULL,
  `customer_phone` varchar(15) NOT NULL,
  `customer_whatsapp` varchar(20) NOT NULL,
  `description` text DEFAULT NULL,
  `buying` text DEFAULT NULL,
  `deposit` text DEFAULT NULL,
  `agent_manager` varchar(100) NOT NULL,
  `agent` varchar(50) NOT NULL,
  `currency` varchar(1) NOT NULL,
  `customer_email` varchar(100) DEFAULT NULL,
  `location` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_accounts`
--

INSERT INTO `customer_accounts` (`id`, `customer_id`, `customer_name`, `customer_company`, `customer_phone`, `customer_whatsapp`, `description`, `buying`, `deposit`, `agent_manager`, `agent`, `currency`, `customer_email`, `location`, `created_at`, `updated_at`) VALUES
(5, 'SKC-1001', 'Mike Thomas', 'Shinkyowa International', '123456789', '', NULL, '58050', '17500', 'ABC', 'Aima Jamil', '$', 'mike@shinkyowa.com', '', '2024-06-25 14:46:44', '2024-07-29 11:01:56'),
(7, 'SKC-1003', 'Joel Felix', 'Squad Interntaional', '123456', '', NULL, NULL, NULL, 'ABC', 'Oliver', '$', 'joel@squad.com', '', '2024-06-27 14:21:09', '2024-06-27 14:21:09'),
(8, 'SKC-1004', 'Ehtesham', 'Ehtesham Enterprises', '123456789', '', NULL, '38800', '58000', 'ABC', 'Agent', '$', 'ehtesham@shinkyowa.com', 'Street 26c', '2024-07-26 15:45:17', '2024-07-29 15:41:06');

-- --------------------------------------------------------

--
-- Table structure for table `customer_payments`
--

CREATE TABLE `customer_payments` (
  `id` int(11) NOT NULL,
  `stock_id` varchar(15) NOT NULL,
  `description` text NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `payment_date` date NOT NULL,
  `payment` varchar(15) NOT NULL,
  `payment_recieved_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_payments`
--

INSERT INTO `customer_payments` (`id`, `stock_id`, `description`, `customer_email`, `payment_date`, `payment`, `payment_recieved_date`, `created_at`, `updated_at`) VALUES
(6, 'SKI-12456', 'Toyota Voxy 2018', 'mike@shinkyowa.com', '2024-06-28', '12500', '2024-06-27', '2024-06-27 15:27:14', '2024-06-27 15:27:14'),
(8, 'SKI-12456', 'Toyota Voxy 2018', 'mike@shinkyowa.com', '2024-06-28', '5000', '2024-06-28', '2024-06-27 15:36:09', '2024-06-27 15:36:09'),
(10, 'SKI-3', 'Toyota Vitz 2016', 'ehtesham@shinkyowa.com', '2024-07-30', '12500', '2024-07-30', '2024-07-29 15:03:26', '2024-07-29 15:03:26'),
(11, 'SKI-3', 'Toyota Vitz 2016', 'ehtesham@shinkyowa.com', '2024-07-30', '12500', '2024-07-30', '2024-07-29 15:03:45', '2024-07-29 15:03:45'),
(12, 'SKI-3', 'This is a test', 'ehtesham@shinkyowa.com', '2024-07-30', '500', '2024-07-30', '2024-07-29 15:38:15', '2024-07-29 15:38:15'),
(13, 'SKI-3', 'Another payment', 'ehtesham@shinkyowa.com', '2024-07-20', '10000', '2024-07-24', '2024-07-29 15:39:05', '2024-07-29 15:39:05'),
(14, 'SKI-4', 'Another Payment', 'ehtesham@shinkyowa.com', '2024-07-31', '10000', '2024-07-30', '2024-07-29 15:41:06', '2024-07-29 15:41:06');

-- --------------------------------------------------------

--
-- Table structure for table `customer_vehicles`
--

CREATE TABLE `customer_vehicles` (
  `id` int(11) NOT NULL,
  `stock_id` varchar(15) NOT NULL,
  `vehicle` varchar(100) NOT NULL,
  `chassis` varchar(100) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `fob_or_cnf` varchar(3) NOT NULL,
  `amount` varchar(20) NOT NULL DEFAULT '0',
  `payment` varchar(100) DEFAULT '0',
  `status` varchar(15) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_vehicles`
--

INSERT INTO `customer_vehicles` (`id`, `stock_id`, `vehicle`, `chassis`, `customer_email`, `fob_or_cnf`, `amount`, `payment`, `status`, `created_at`, `updated_at`) VALUES
(1, 'SKI-1', 'Toyota Voxy 2018', 'GDH223-2007837', 'mike@shinkyowa.com', '', '0', '0', 'reserved', '2024-06-28 13:22:50', '2024-06-28 13:22:50'),
(5, 'SKI-1', 'Toyota Voxy 2019', 'ZRR8****', 'mike@shinkyowa.com', 'FOB', '16150', '0', 'reserved', '2024-07-19 15:49:15', '2024-07-19 15:49:15'),
(9, 'SKI-2', 'Toyota Vitz 2016', 'NCP1****', 'mike@shinkyowa.com', 'FOB', '7550', '0', 'reserved', '2024-07-25 14:44:30', '2024-07-25 14:44:30'),
(10, 'SKI-3', 'Toyota Vitz 2016', 'ZRR8****', 'ehtesham@shinkyowa.com', 'FOB', '7550', '23000', 'reserved', '2024-07-26 16:19:03', '2024-07-29 15:39:05'),
(11, 'SKI-4', 'Toyota Vitz 2016', 'ZRR8****', 'ehtesham@shinkyowa.com', 'FOB', '7550', '10000', 'reserved', '2024-07-26 16:19:30', '2024-07-29 15:41:06'),
(12, 'SKI-3', 'Toyota Voxy 2018', 'NCP1****', 'ehtesham@shinkyowa.com', 'FOB', '7550', '23000', 'reserved', '2024-07-29 10:54:13', '2024-07-29 15:39:05'),
(13, 'SKI-3', 'Toyota Voxy 2018', 'NCP1****', 'ehtesham@shinkyowa.com', 'FOB', '7550', '23000', 'reserved', '2024-07-29 10:55:28', '2024-07-29 15:39:05'),
(14, 'SKI-3', 'Toyota Vitz 2016', 'NCP1****', 'mike@shinkyowa.com', 'FOB', '7550', '23000', 'reserved', '2024-07-29 10:55:48', '2024-07-29 15:39:05'),
(15, 'SKI-3', 'Toyota Vitz 2016', 'NCP1****', 'mike@shinkyowa.com', 'FOB', '7550', '23000', 'reserved', '2024-07-29 10:56:02', '2024-07-29 15:39:05'),
(16, 'SKI-3', 'Toyota Vitz 2016', 'NCP1****', 'mike@shinkyowa.com', 'FOB', '7550', '23000', 'reserved', '2024-07-29 11:01:56', '2024-07-29 15:39:05'),
(17, 'SKI-3', 'Toyota Vitz 2016', 'NCP1****', 'ehtesham@shinkyowa.com', 'FOB', '7550', '23000', 'reserved', '2024-07-29 15:27:30', '2024-07-29 15:39:05'),
(18, 'SKI-4', 'Toyota Voxy 2018', 'ZRR8****', 'ehtesham@shinkyowa.com', 'FOB', '16150', '10000', 'reserved', '2024-07-29 15:28:03', '2024-07-29 15:41:06');

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
(4, '2024_06_25_183036_create_customer_accounts_table', 1),
(5, '2024_06_27_180025_create_customer_payments_table', 2),
(6, '2024_06_28_170742_create_customer_vehicles_table', 3);

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
('7XPF9RY0i3XxDDxgyNSCAdE4Zskn0Ls5srPYDF1Q', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoibVZERkZnT1JiOTIwYnFBcWpOd0tqa2t3MndFYjdIV2doZnc1Tnk5ViI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQwOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvdXNlci9jcmVkZW50aWFscy80Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1723239159),
('mlt1ltbe8BCROOKXgPhAq0zy5EpCQUq8xj7MbFZ5', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:130.0) Gecko/20100101 Firefox/130.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiRlJoY1lzRGE4djMzd1RIU2FtaHphMXA5dHVDbmJLbXo2ak9nMTNIVCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjIxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1723236360);

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `thumbnail` text NOT NULL,
  `stock_images` text NOT NULL,
  `stock_id` varchar(10) NOT NULL,
  `chassis` varchar(10) NOT NULL,
  `make` varchar(10) NOT NULL,
  `model` varchar(20) NOT NULL,
  `year` int(11) NOT NULL,
  `fob` varchar(20) NOT NULL,
  `currency` varchar(1) DEFAULT NULL,
  `mileage` varchar(10) NOT NULL,
  `doors` varchar(4) NOT NULL,
  `transmission` varchar(10) NOT NULL,
  `body_type` varchar(10) NOT NULL,
  `fuel` varchar(10) NOT NULL,
  `category` varchar(25) NOT NULL,
  `country` varchar(40) NOT NULL,
  `features` text NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'available',
  `customer_email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `thumbnail`, `stock_images`, `stock_id`, `chassis`, `make`, `model`, `year`, `fob`, `currency`, `mileage`, `doors`, `transmission`, `body_type`, `fuel`, `category`, `country`, `features`, `status`, `customer_email`, `created_at`, `updated_at`) VALUES
(7, '01HYBRQ7G9HX531CRADEQR30YD.jpg', '[\"01HYBRQ7GKC5VW9XA6FY03Z2CX.jpg\",\"01HYBRQ7GMZ69PW13RK8QK3N67.jpg\",\"01HYBRQ7GMZ69PW13RK8QK3N68.jpg\",\"01HYBRQ7GNG1HEDHNS0AMNSXQX.jpg\",\"01HYBRQ7GPT041KE7Z0C0SSV7G.jpg\",\"01HYBRQ7GPT041KE7Z0C0SSV7H.jpg\",\"01HYBRQ7GQC6R6DBNCTXQD9RFJ.jpg\",\"01HYBRQ7GQC6R6DBNCTXQD9RFK.jpg\"]', 'SKI-1', 'ZRR8****', 'toyota', 'VOXY', 2019, '16,150 ', '$', '97,000', '5', 'Automatic', 'van', 'PETROL', 'discounted', 'jamaica', '<p><strong>TOYOTA VOXY</strong></p><p><strong>YEAR </strong>: 2019&nbsp;</p><p><strong>GRADE </strong>: ZS Kirameki II&nbsp;</p><p><strong>MODEL </strong>: ZRR80W&nbsp;</p><p><strong>CHASSIS </strong>: ZRR80-0489***&nbsp;</p><p><strong>COLOR </strong>: PEARL&nbsp;</p><p><strong>ENGINE </strong>: 2000 CC&nbsp;</p><p><strong>MILEAGE </strong>: 97,000 KM&nbsp;</p><p><strong>FUEL </strong>: PETROL&nbsp;</p><p><strong>GEAR </strong>: AT</p><p><strong>SEATS </strong>: 08&nbsp;</p><p><strong>SPECIFICATIONS&nbsp;</strong></p><ul><li>CD/BACK CAMERA&nbsp;</li><li>ETC&nbsp;</li><li>ANTI-SKIDDING DEVICE (ESC)&nbsp;</li><li>DRIVER\'S SEAT AIRBAG&nbsp;</li><li>THEFT PREVENTION SYSTEM&nbsp;</li><li>SMART KEY - KEYLESS ENTRY&nbsp;</li><li>ABS MOTION - FULL SEGMENT TV&nbsp;</li><li>COLLISION DAMAGE REDUCTION&nbsp;</li><li>COLLISION SAFETY BODY&nbsp;</li><li>IDLING STOP&nbsp;</li><li>AUTO CRUISE CONTROL&nbsp;</li><li>DVD PLAYBACK&nbsp;</li><li>POWER SLIDING DOORS ON BOTH SIDES</li></ul>', 'reserved', 'ehtesham@shinkyowa.com', '2024-05-21 02:47:40', '2024-07-26 16:19:03'),
(8, '/01HZ344WB73JN7Z7QYFB1BHD33.webp', '[\"01HZ07238K611BCP830QSCCT3S.png\",\"01HZ07238MVJ90KMSJ9SSME9NT.png\",\"01HZ07238PMF43YSQ9QV7SFTJ0.png\",\"01HZ07238PMF43YSQ9QV7SFTJ1.png\",\"01HZ07238RH1AEV0ZNGM0NWS9T.png\",\"01HZ07238SV0M3GYSC9DH04CN0.png\",\"\\/01HZ344WHMQ0FPHZ270SZ80FZ8.webp\"]', 'SKI-2', 'NCP1****', 'toyota', 'VITZ', 2016, '7,550', '$', '54,000 KM', '5', 'Manual', 'Hatchback', 'PETROL', 'new arrival', 'Jamaica', '<ul><li>ETC&nbsp;</li><li>Back Mmonitor&nbsp;</li><li>Security Side Airbag&nbsp;</li><li>ESC&nbsp;</li><li>Lowdown TEIN Suspension&nbsp;</li><li>Enkei 15AW Fujitsubo Muffler&nbsp;</li><li>Genuine Nnavigation&nbsp;</li><li>Full Segment TV&nbsp;</li><li>Back Monitor&nbsp;</li><li>Throttle Control&nbsp;</li><li>Lane Keep Assist&nbsp;</li><li>Half Leather Seats&nbsp;</li><li>HID Fog&nbsp;</li><li>Smart Key</li></ul>', 'reserved', 'mike@shinkyowa.com', '2024-05-29 01:23:05', '2024-07-29 10:55:48'),
(9, '/01HZ34D73BTSDQPWS6VZ9FBG5A.webp', '[\"01HZ07HAS4E15VSHFZJJ7B52KY.png\",\"01HZ07HAS5Z897EWWGC3XERZKA.png\",\"01HZ07HAS6B0SBGN5NRKDB9R63.png\",\"01HZ07HAS6B0SBGN5NRKDB9R64.png\",\"01HZ07HAS816CMWMEGGQSSCP08.png\",\"\\/01HZ34D777X7A2HZME2P0WF598.webp\",\"\\/01HZ34D79RX7QGY7KW5SZ8D5G2.webp\"]', 'SKI-3', 'KF2P****', 'mazda', 'CX-5', 2021, '18,000', '$', '38,000 KM', '5', 'Automatic', 'SUV', 'DIESEL', 'new arrival', 'Jamaica', '<ul><li>Mazda Connect</li><li>360° View Monitor</li><li>ETC</li><li>Heated Front Seats</li><li>Radar Cruise Control</li><li>Heated Steering Wheel</li><li>Electric Parking</li><li>Auto Hold</li><li>Power Seats</li><li>Auto High Beam</li><li>Steering Switch</li><li>Power Lift Gate</li><li>Auto Lights</li></ul>', 'reserved', 'ehtesham@shinkyowa.com', '2024-05-29 01:31:24', '2024-07-29 15:27:30'),
(10, '/01HZ4WHTME3VA4W0RQBF02308E.webp', '[\"01HZ07VF130HSG6CQ17HP86JPS.png\",\"01HZ07VF15FJD1XFX701PNHRJR.png\",\"01HZ07VF15FJD1XFX701PNHRJS.png\",\"01HZ07VF165A6N5X7JB3G6X8C5.png\",\"01HZ07VF17ZJH4ZXMJEH90CTHQ.png\",\"\\/01HZ4WHTRP8GMVQ57NH25SF5SH.webp\",\"\\/01HZ4WHTVK28QPQZC3ZPF21584.webp\"]', 'SKI-4', 'MXUA****', 'toyota', 'HARRIER', 2021, '28,600', '$', '24,000 KM', '5', 'Automatic', 'SUV', 'PETROL', 'new arrival', 'Jamaica', '<ul><li>Back Monitor</li><li>LED Headlight</li><li>Panoramic View Monitor&nbsp;</li><li>ETC</li><li>Undercoat Modelista Aero Guard</li></ul>', 'reserved', 'ehtesham@shinkyowa.com', '2024-05-29 01:36:56', '2024-07-29 15:28:03'),
(11, '/01HZ09H3MSZJXWPMFD00E6MP0X.webp', '[\"\\/01HZ09H3QQKEJ4XWD237649BYV.webp\",\"\\/01HZ09H3TB9XPPPCYKW9ZZNF6Q.webp\",\"\\/01HZ09H3WV0RHTXP6Y9HT5M57B.webp\",\"\\/01HZ09H3Z89W2TRC2V7KRJ9FN7.webp\",\"\\/01HZ09H41QQ8Q9S3HPQ4XKMRGT.webp\",\"\\/01HZ09H444SN4EXS1Z4JRDMVY4.webp\",\"\\/01HZ09H46P91AX0CXWN36J7PZM.webp\",\"\\/01HZ09H49CV0V5TS6X0NX59Z97.webp\",\"\\/01HZ09H4C3QE32984DK88MEBTY.webp\"]', 'SKI-5', 'FC6J****', 'hino', 'RANGER', 2007, '20,000', '$', '231,000 KM', '2', 'Manual', 'Truck', 'DIESEL', 'commercial', 'Jamaica', '<ul><li>UNIC 3-Tier Crane</li><li>Hook-In&nbsp;</li><li>Radio Control</li><li>Maximum Lifting Load: 2.9 Tons</li><li>Boom Maximum 7.70 Meters</li><li>Floor Height : Approx. 109 cm</li><li>Rope Holes : 9 Pairs</li><li>Right Center Tool Box</li><li>Navigation/Full Segment</li><li>6MT</li><li>ETC&nbsp;</li><li>Compatible With Nox/PM&nbsp;</li><li>Loading Capacity : 2.93 Tons/Total Weight Less Than 8 Tons<br><br></li></ul>', 'available', NULL, '2024-05-29 02:06:15', '2024-05-30 22:17:16'),
(12, '/01HZ2BA1TWYPDQDEK92DDMZESD.webp', '[\"\\/01HZ2BA20DA6VP8PW9Z0BPNCY1.webp\",\"\\/01HZ2BA231TS2BCT4DYPQBVCJY.webp\",\"\\/01HZ2BA25NZCW9XKZJ5Z5ZA395.webp\",\"\\/01HZ2BA286XWS0FDQRQXEWS9MT.webp\",\"\\/01HZ2BA2B1EV8ZX51Q6XCWCT7Z.webp\",\"\\/01HZ2BA2DGG0TBZV67JG3NFJQS.webp\",\"\\/01HZ2BA2G1BN8X1J97GW2GCF0T.webp\"]', 'SKI-6', 'FRR9****', 'isuzu', 'FORWARD', 2010, '10,100', '$', '666,000 KM', '2', 'Manual', 'Truck', 'DIESEL', 'commercial', 'Jamaica', '<ul><li>ABS&nbsp;</li><li>POWER SLIDING DOOR&nbsp;</li><li>POWER WINDOW</li><li>AIRBAG&nbsp;</li><li>KEYLESS</li></ul>', 'available', NULL, '2024-05-29 21:15:50', '2024-05-30 22:18:56'),
(13, '/01HZ2BK3CQC1DMA8FWRTS0YKBR.webp', '[\"\\/01HZ2BK3FZ61W4AC47PWDX60Q6.webp\",\"\\/01HZ2BK3JTHDWB1M8S2RBCSP26.webp\",\"\\/01HZ2BK3NZFKN5QAWM14ZDH41J.webp\",\"\\/01HZ2BK3RXYFQWHF8RYQVJRJAT.webp\",\"\\/01HZ2BK3WA9K4XK1PKG999062R.webp\",\"\\/01HZ2BK3ZG7QAS1DF1CBXSRQBH.webp\"]', 'SKI-7', 'FRR9***', 'isuzu', 'FORWARD', 2011, '10,000', '$', '366,000 KM', '2', 'Manual', 'Truck', 'PETROL', 'commercial', 'Jamaica', '<p>-</p>', 'available', NULL, '2024-05-29 21:20:46', '2024-05-30 22:24:47'),
(14, '/01HZ338BXB6C7PE0MRW450VYHM.webp', '[\"\\/01HZ2CC2BAR9YVPGZDNXBKVQ7E.webp\",\"\\/01HZ2CC2DTMSZBKKVPXBANK77M.webp\",\"\\/01HZ2CC2FMJNS7P92GF4T598M3.webp\",\"\\/01HZ2CC2HXECEN0KW36ZBSFNTK.webp\",\"\\/01HZ2CC2M88TN8VBSKZBR714QC.webp\",\"\\/01HZ2CC2RTPHBRT5YEBK84GT7S.webp\",\"\\/01HZ2CC2VGPMMJWEDD4QKVF5QS.webp\",\"\\/01HZ338C1ZH33P2285PTWKGVHQ.webp\"]', 'SKI-8', 'FK71****', 'honda', 'CIVIC', 2018, '10,500', '$', '96,000 KM', '5', 'Automatic', 'Hatchback', 'PETROL', 'discounted', 'Jamaica', '<ul><li>Honda Sensing</li><li>Special PKG for navigation installation</li><li>Gathers memory navigation</li><li>Bluetooth</li><li>Full segment</li><li>Back camera</li><li>LED</li><li>Intellikey</li><li>ETC</li><li>Seat heater</li><li>Auto cruise</li><li>Genuine 18 inch aluminum<br><br></li></ul>', 'available', NULL, '2024-05-29 21:34:24', '2024-05-30 22:47:52'),
(15, '/01HZ2EEXMNR4GN3Q3NQGYYGSK4.webp', '[\"\\/01HZ2CQXTSB98V7EJWD5JTNJSE.webp\",\"\\/01HZ2CQXX0EMEP69XWPSZ6W1N9.webp\",\"\\/01HZ2CQXZBGHVPGG4N0MYFPSMD.webp\",\"\\/01HZ2CQY1T6PX2WZN329V76SDE.webp\",\"\\/01HZ2CQY4EM68J5W2Q9E31A0D2.webp\",\"\\/01HZ2CQY6TDSBC2SS56WYSRPGY.webp\",\"\\/01HZ2CQY9A9BPDAP1VZ3RAAGEZ.webp\",\"\\/01HZ2EEXS4TN4E1TQBEZ30THER.webp\",\"\\/01HZ2EEXW0YDG19TADPX9AMBCT.webp\"]', 'SKI-9', 'ZC33****', 'suzuki', 'SWIFT', 2022, '10,700', '$', '31,000 KM', '5', 'Manual', 'Hatchback', 'PETROL', 'discounted', 'Jamaica', '<ul><li>ETC&nbsp;</li><li>SMART KEY</li><li>NON SMOKING CAR</li><li>ABS</li><li>POWER SLIDING DOOR</li><li>NAVIGATION TV</li><li>POWER WINDOW</li><li>ALLOY WHEELS</li></ul>', 'available', NULL, '2024-05-29 21:40:53', '2024-05-30 22:48:22'),
(16, '/01HZ2EKX38AKYQMXG2283WXN23.webp', '[\"\\/01HZ2EKX6PNEPRNGYHN5Z1A5ER.webp\",\"\\/01HZ2EKX9G7734D1ADDNKKB2HB.webp\"]', 'SKI-10', 'AUCP****', 'volswagen', 'GOLF', 2019, '13,200', '$', '22,000 KM', '5', 'Automatic', 'Hatchback', 'PETROL', 'discounted', 'Jamaica', '<p>-</p>', 'available', NULL, '2024-05-29 22:13:38', '2024-05-30 22:57:43'),
(17, '/01HZ85DYPXGNRDR6ZV1JGEYQBX.webp', '[\"\\/01HZ85DYXNEXAZT0APZ9H928PA.webp\",\"\\/01HZ85DZ3GZHT8P9WQ0AH6NPQX.webp\",\"\\/01HZ85DZ655WTDAA4M0MZT531S.webp\",\"\\/01HZ85DZ8RVGM8YBEZ7165MKD4.webp\",\"\\/01HZ85DZBDFM9AGGF0J4B4GF5J.webp\",\"\\/01HZ85DZE05DJ1M0HE5GRP774T.webp\",\"\\/01HZ85DZGR1KJK0FTNFFEEBBH0.webp\",\"\\/01HZ8651WSF923M2BQPWB42N7P.webp\"]', 'SKI-11', 'WBA1R***', 'BMW', '1 SERIES', 2017, '6,500', '$', '23,000 KM', '5', 'Automatic', 'Hatchback', 'PETROL', 'discounted', 'Jamaica', '<ul><li>Power Mirror</li><li>Power Window</li><li>Air Bag</li><li>Multi Function Steering</li><li>Push Start</li><li>Fog Lamps</li><li>Tv nav</li><li>Alloy Rims</li></ul>', 'available', NULL, '2024-06-01 03:28:33', '2024-06-05 22:17:27'),
(18, '/01HZ87GTYETD91SBNA4390XXF3.webp', '[\"\\/01HZ87GV2WTHCQ1AACNE9Y2WEX.webp\",\"\\/01HZ87GV5D0D6MEDFX570ZWJ61.webp\",\"\\/01HZ87GV9P6RFE0DD8SKTR3TY8.webp\",\"\\/01HZ87GVC4WWTKY3GKVYFK76Y8.webp\",\"\\/01HZ87GVEP0S76CNSF9DZP7GW2.webp\",\"\\/01HZ87GVH1BDR4VYCJRYQX2ZCH.webp\",\"\\/01HZ87GVKK82ASHW1HGHXSMR2J.webp\",\"\\/01HZ87GVP15PYK8APSVX2SGG5F.webp\",\"\\/01HZ87GVRHT381AXXD94ZD2B66.webp\",\"\\/01HZ87GVTYF5EAY9TG9SEXWYVW.webp\",\"\\/01HZ87GVXF0XR8HYNNS07CHKCE.webp\"]', 'SKI-12', 'ZRR80****', 'toyota', 'Voxy ', 2019, '15,500', '$', '82,000 KM', '5', 'Automatic', 'Van', 'PETROL', 'new arrival', 'Jamaica', '<ul><li>Power Mirror</li><li>Power Window</li><li>Air Bags</li><li>Push Start</li><li>Multi Function Steering</li><li>Tv Nav</li><li>Fog Lamps</li><li>Alloy Rims&nbsp;</li></ul>', 'available', NULL, '2024-06-01 04:05:05', '2024-06-05 02:16:06'),
(19, '/01HZ883PSM2GGCJFYXJA70ZNR4.webp', '[\"\\/01HZ883PWHMDD9JHX2373ANQZP.webp\",\"\\/01HZ883PZ7K32Z80Z9CXQSFKQG.webp\",\"\\/01HZ883Q20AB610FP11YAK9FGQ.webp\",\"\\/01HZ883Q4KWD84S1G6A6J1KFA9.webp\",\"\\/01HZ883Q7H3EQSH3T9QK6YFP73.webp\",\"\\/01HZ883QABNC6FF6R520YA8ZRQ.webp\",\"\\/01HZ883QCW7YV3J2FMRKVZ24FR.webp\",\"\\/01HZ883QFVSCP7KZHEX3XBVYBD.webp\",\"\\/01HZ883QJGN4K56KSGV4M4ZCDQ.webp\",\"\\/01HZ883QN4AYWHR75RPQJZVY7S.webp\",\"\\/01HZ883QR10W9MFW2Q8X5J7QN4.webp\",\"\\/01HZ883QTVC9SBF8EMEQ60WPR0.webp\"]', 'SKI-13', 'GDH223****', 'toyota', 'HIACE ', 2018, '26,000', '$', '160,000 KM', '5', 'Automatic', 'Van', 'PETROL', 'new arrival', 'Jamaica', '<ul><li>Power Mirror</li><li>Power Window</li><li>Air Bags</li><li>KEY Start</li><li>Tv Nav</li><li>Fog Lamps</li><li>Alloy Rims&nbsp;</li></ul>', 'available', NULL, '2024-06-01 04:15:23', '2024-06-05 02:11:31'),
(20, '/01HZ89FY48E9CSXA7BH1A657WE.webp', '[\"\\/01HZ89FYA5K7X4Q1TRJ42M2J25.webp\",\"\\/01HZ89FYE08J5KFVGP829AATKM.webp\",\"\\/01HZ89FYH0AKNDDPAG089DS9JR.webp\",\"\\/01HZ89FYM6A9H6T4H200QWKE97.webp\",\"\\/01HZ89FYQ6E9GJM5BA857MCHGH.webp\",\"\\/01HZ89FYSWG6BK6JHGJXKH59W5.webp\",\"\\/01HZ89FYW8QVRDT6BV9GY70B77.webp\",\"\\/01HZ89FYZ78J25T3QDN3MZED8Y.webp\",\"\\/01HZ89FZ202ZN6BWVCSHPKZ6HM.webp\",\"\\/01HZ89FZ50F0DQVTB5G0YEH2BW.webp\",\"\\/01HZ89FZ8KSC1PT3XK1A2A9MX0.webp\"]', 'SKI-14', 'NCP160****', 'toyota', 'PROBOX', 2018, '3,400', '$', '154,000 KM', '5', 'Automatic', 'Wagon', 'PETROL', 'discounted', 'Jamaica', '<ul><li>Power Mirror</li><li>Power Window</li><li>Air Bags</li><li>Tv Nav</li><li>Alloy Rims</li><li>Key Start</li></ul>', 'available', NULL, '2024-06-01 04:39:32', '2024-06-05 02:13:20'),
(21, '/01HZ89SYZ1PHDK8R2RVA5H3QWQ.webp', '[\"\\/01HZ89SZ1Z6BK976SXRATFPYS1.webp\",\"\\/01HZ89SZ4TTBXJH26DD1ZNP668.webp\",\"\\/01HZ89SZ7QGRTFJTQ2WYFA2SYN.webp\",\"\\/01HZ89SZABVANEN8ZHY02SNYM2.webp\",\"\\/01HZ89SZCZ4ND2RTTV6TM0FQP8.webp\",\"\\/01HZ89SZFH347DZVNQMTTPAVM5.webp\",\"\\/01HZ89SZJ5JT7CQFJMJGEPM6SY.webp\",\"\\/01HZ89SZMPMBADENJ3TNSWZ98Q.webp\",\"\\/01HZ89SZSF088QQV0JSD8Z374A.webp\",\"\\/01HZ89SZW5CF58ZYG9X535KG5T.webp\",\"\\/01HZ89SZZ12EHWFN58PBS8FH75.webp\",\"\\/01HZ89T023NPE7PMFVM35JP911.webp\"]', 'SKI-15', 'NCP160****', 'toyota', 'PROBOX', 2018, '3,500', '$', '130,000 KM', '5', 'Automatic', 'Wagon', 'PETROL', 'discounted', 'Jamaica', '<ul><li>Power Mirror</li><li>Power Window</li><li>Air Bags</li><li>Tv Nav</li><li>Alloy Rims</li><li>Key Start</li></ul>', 'available', NULL, '2024-06-01 04:45:01', '2024-06-05 02:14:07'),
(23, '/01HZF87VCPEP8YC80X0K9P95EV.webp', '[\"\\/01HZF87VHGED9JS1434PC4ETK1.webp\",\"\\/01HZF87VNXMJK0XRRPQ4QM1HYK.webp\",\"\\/01HZF87VS16F834ZQVYTP1BG1D.webp\",\"\\/01HZF87VVHT486VP29AYJVC58T.webp\",\"\\/01HZF87VY5NJ47MWVMZDZAYX90.webp\",\"\\/01HZF87W0SQEA33MX23CDZCQSX.webp\",\"\\/01HZF87W37WEE8H36WEN5CVYKD.webp\",\"\\/01HZF87W5VB8G0K10674QG7R9D.webp\",\"\\/01HZF87W8E3NQK9M3E2AFSH651.webp\"]', 'SKI-17', 'SJ5****', 'subaru', 'FORESTER ', 2018, '9,000', '$', '66,000 KM', '5', 'Automatic', 'SUV', 'PETROL', 'new arrival', 'Jamaica', '<ul><li>Power Mirror</li><li>Power Window</li><li>Air Bags</li><li>TV Navigation</li><li>Fog Lamps</li><li>Alloy Wheels</li><li>Key Start</li><li>Multi Function Steering</li></ul>', 'available', NULL, '2024-06-03 21:32:20', '2024-06-05 02:18:43'),
(24, '/01HZF8GP4VM999QNB7EDZ3MZ57.webp', '[\"\\/01HZF8GP7P65TPSJXWD8WAAM6M.webp\",\"\\/01HZF8GPAF279GX9D674DXCQ4M.webp\",\"\\/01HZF8GPDBE5GT49MXCE4SXBE9.webp\",\"\\/01HZF8GPFZ9VVF37D1AQ78JY8C.webp\",\"\\/01HZF8GPJTK03QCKYEX9B7G09M.webp\",\"\\/01HZF8GPNH2FJCWY1CG9H8051A.webp\",\"\\/01HZF8GPRAD5P3VCDVJK4B31FB.webp\",\"\\/01HZF8GPTZ84C1B5CTQBF33ZSS.webp\",\"\\/01HZF8GPXN1EEA5SZQGQKACW3T.webp\"]', 'SKI-18', 'GK2****', 'subaru', 'G4', 2018, '5,800', '$', '44,000 KM', '5', 'Automatic', 'Sedan', 'PETROL', 'new arrival', 'Jamaica', '<ul><li>Power Mirror</li><li>Power Window</li><li>Air Bags</li><li>TV Navigation</li><li>Fog Lamps</li><li>Alloy Wheels</li><li>Push Start</li><li>Multi Function Steering</li></ul>', 'available', NULL, '2024-06-03 21:37:09', '2024-06-05 02:16:50'),
(25, '/01HZF94CXDM7HK00G34J921SYY.webp', '[\"\\/01HZF94D00HDHVF1ZWMA33SSZT.webp\",\"\\/01HZF94D2K7QNAW4BSTYYCTTJA.webp\",\"\\/01HZF94D4Y27T2JH67677APZRB.webp\",\"\\/01HZF94D7A3QY7BX7GKEWBJV7J.webp\",\"\\/01HZF94D9F3NF99WGERZBB6TZ8.webp\",\"\\/01HZF94DBNAXRYJHDXE4G1GN5S.webp\",\"\\/01HZF94DE79VBJ4HXCWNX4YKPH.webp\",\"\\/01HZF94DGQN561XH5D1GDNPQDK.webp\"]', 'SKI-19', 'NRE161****', 'toyota', ' COROLLA AXIO', 2018, '6,000', '$', '45,000 KM', '5', 'Automatic', 'Sedan', 'PETROL', 'discounted', 'Jamaica', '<ul><li>Power Mirror</li><li>Power Window</li><li>Air Bags</li><li>TV Navigation</li><li>Alloy Wheels&nbsp;</li><li>Key Start</li></ul>', 'available', NULL, '2024-06-03 21:47:55', '2024-06-05 02:17:26'),
(26, '/01HZFANA68R9VMN8AGAZT2SXNF.webp', '[\"\\/01HZFANABKNMTAQRN91XRKZ7RM.webp\",\"\\/01HZFANAE38N16JNHYJSQHX6H8.webp\",\"\\/01HZFANAGYT9052RKARZR6HD3Q.webp\",\"\\/01HZFANAKB9JXYSD6EWRP5WC20.webp\",\"\\/01HZFANAP02R5PS29SM2KFB9HV.webp\",\"\\/01HZFANARMQW3T2P9KB2KNWRMH.webp\",\"\\/01HZFANAV8CTVTR08W2H5BH3CE.webp\",\"\\/01HZFANAXC5T0P09E1GD6RVW94.webp\",\"\\/01HZFANB04R6VCY4CSKN6XXEHX.webp\",\"\\/01HZFANB2GH9P54VAEYRQP7QZX.webp\",\"\\/01HZFANB5RZABPN6QRAW677QCX.webp\"]', 'SKI-20', 'RK5****', 'honda', 'STEPWAGEN', 2014, ' 6,400', '$', '129,000 KM', '5', 'Automatic', 'Van', 'PETROL', 'discounted', 'Jamaica', '<ul><li>Power Mirror</li><li>Power Window</li><li>Air Bags</li><li>Multi Function Steering</li><li>TV Navigation&nbsp;</li><li>Fog Lamps</li><li>Alloy Wheels</li><li>Key Start</li></ul>', 'available', NULL, '2024-06-03 22:14:38', '2024-06-05 02:17:55'),
(27, '/01HZFB30WYKYBM92P3S2MXKXAC.webp', '[\"\\/01HZFB30ZR6W9P8EESM6GR8CTM.webp\",\"\\/01HZFB3129XR56HJ0ZAHV8F8W5.webp\",\"\\/01HZFB3157P2KAH3YZPG2NAZN5.webp\",\"\\/01HZFB317RD53N05MGVJZG0EQ8.webp\",\"\\/01HZFB31AAD6PQTY77CAYN3E4N.webp\",\"\\/01HZFB31CZGNFR7R2ZH33K01GY.webp\",\"\\/01HZFB31FQ7Z4F73GDYY577789.webp\",\"\\/01HZFB31J7MGXW0CQD7ZF0B5H9.webp\",\"\\/01HZFB31MV6J0HEY13J3A7YDQS.webp\",\"\\/01HZFB31QBC9EN37D2KC67EA5T.webp\",\"\\/01HZFB31SYT9TV6Y53BQK3R03A.webp\"]', 'SKI-21', 'ZRR80****', 'toyota', 'Voxy ', 2019, '7,200', '$', '85,000 KM', '5', 'Automatic', 'Van', 'PETROL', 'new arrival', 'Jamaica', '<ul><li>Power Mirror</li><li>Power Window</li><li>Air Bags</li><li>Multi Function Steering</li><li>TV Navigation&nbsp;</li><li>Alloy Wheels</li><li>Push Start</li></ul>', 'available', NULL, '2024-06-03 22:22:07', '2024-06-05 02:19:28'),
(28, '/01HZFCRN7JW5PMNGEYYM54S7SX.webp', '[\"\\/01HZFCRNDEQ3BYSZ1YSZK4Z9WW.webp\",\"\\/01HZFCRNFZ1YTMX6SP8JWXGE8Y.webp\",\"\\/01HZFCRNJY470WNW9AAF2699K1.webp\",\"\\/01HZFCRNNKQH0PRC7VCC2M696C.webp\",\"\\/01HZFCRNRF7PG3DW6W7TDWXFPC.webp\",\"\\/01HZFCRNTY0C4BVZS37C1P6MBX.webp\"]', 'SKI-22', ' WAUZ****', 'audi', 'A3', 2017, '9,100', '$', '46,000 KM', '5', 'Automatic', 'Hatchback', 'PETROL', 'discounted', 'Ireland', '<ul><li>Power Mirror</li><li>Power Window</li><li>Air Bags</li><li>Multi Function Steering</li><li>TV Navigation</li><li>Alloy Wheel</li><li>Push Start</li></ul>', 'available', NULL, '2024-06-03 22:51:24', '2024-06-03 22:51:24'),
(29, '/01HZFD0CNBSC7W8HQ8XRC2X0Z8.webp', '[\"\\/01HZFD0CRC0V2Q3D0DZNXD1NHY.webp\",\"\\/01HZFD0CTT5TY7P4HNETW74HCA.webp\",\"\\/01HZFD0CXGF6CY81RG4YS0TDAE.webp\",\"\\/01HZFD0CZZJJCPYPRZ4973A4V6.webp\",\"\\/01HZFD0D2KJFQ422AE2HKFD85Q.webp\",\"\\/01HZFD0D4SF3BQYFW2WH9JT36T.webp\"]', 'SKI-23', 'WDD2****', 'mercedes', 'B CLASS ', 2013, '2,400', '$', '44,000 KM', '5', 'Automatic', 'Hatchback', 'PETROL', 'discounted', 'Ireland', '<ul><li>Power Mirror</li><li>Power Window</li><li>Air Bags</li><li>Multi Function Steering</li><li>TV Navigation</li><li>Alloy Wheel</li><li>Ke Start</li></ul>', 'available', NULL, '2024-06-03 22:55:38', '2024-06-04 01:20:30'),
(30, '/01HZMDAGD93T9W4DJKCK16PMKC.webp', '[\"\\/01HZMDAGM73TWJE85RT9NJPPSR.webp\",\"\\/01HZMDAGQAZ3GMH7X409JE966E.webp\",\"\\/01HZMDAGTES9N5Q65CQGFSV0JY.webp\",\"\\/01HZMDAGXCDE5YW444CE527RDS.webp\",\"\\/01HZMDAH0998SXQ6HCR3VJS9FV.webp\",\"\\/01HZMDAH2RR0NS2T4EQRZNCJVG.webp\",\"\\/01HZMDAH5T93WFSC0QKHN9NGXY.webp\",\"\\/01HZMDAH89V6J1RAC5KAJ5KYH3.webp\",\"\\/01HZMDAHAV6PCG7G7ET7KGP37R.webp\",\"\\/01HZMDAHDDYBMBFK5EW6SGFA0G.webp\",\"\\/01HZMDAHFNMN7XR8FZ8WJ8QSKP.webp\",\"\\/01HZMDAHJ1S3W24JY8HGZV9GMC.webp\"]', 'SKI-24', 'WDD1173***', 'mercedes', 'CLA180', 2016, '9,400', '$', '61,000 KM', '5', 'Automatic', 'Sedan', 'PETROL', 'new arrival', 'Ireland', '<ul><li>Power Mirror</li><li>Power Window</li><li>Air Bags</li><li>Multi Function Steering</li><li>TV Navigation</li><li>Alloy Wheels</li><li>Push Start</li></ul>', 'available', NULL, '2024-06-05 21:37:22', '2024-06-05 21:37:22'),
(31, '/01HZMDNTWWNN5CK55WBRD2YVPN.webp', '[\"\\/01HZMDNV0XHR5YG1NP2VY5CB2C.webp\",\"\\/01HZMDNV4CAA0WF9ZN5458Z2DQ.webp\",\"\\/01HZMDNV7AMWZQRR88FTHZJ7YF.webp\",\"\\/01HZMDNVACD07ENHYSQG5N79B2.webp\",\"\\/01HZMDNVD8RX30D160DP4FTZY3.webp\",\"\\/01HZMDNVGE5P2ZQV6D57XF6621.webp\",\"\\/01HZMDNVK7AKXWYSDE4TF4GWP8.webp\",\"\\/01HZMDNVNQG2R7FC0T4T5X370Q.webp\",\"\\/01HZMDNVR2P5JC1KNM6K99SJN0.webp\",\"\\/01HZMDNVTT0N30PYER4T1FPRHT.webp\",\"\\/01HZMDNVXY9P927ZKEAKP58V7K.webp\",\"\\/01HZMDNW1C5JHMH3Y3EYWWYFCK.webp\",\"\\/01HZMDNW3FW7BYFQMDFMEVZ718.webp\",\"\\/01HZMDNW8P54BRFAND88GK8JGD.webp\"]', 'SKI-25', 'WAUZZZ8***', 'audi', 'A3', 2015, '5,400', '$', '50,000 KM', '5', 'Automatic', 'Sedan', 'PETROL', 'discounted', 'Ireland', '<ul><li>Power Mirror</li><li>Power Window</li><li>Air Bags</li><li>Multi Function Steering</li><li>TV Navigation</li><li>Alloy Wheels</li><li>Push Start&nbsp;</li></ul>', 'available', NULL, '2024-06-05 21:43:33', '2024-06-05 21:43:33'),
(32, '/01HZT2HZKRQ9WDPAETATZ8E4CP.webp', '[\"\\/01HZT2HZT17D6CW40EYV95HSY2.webp\",\"\\/01HZT2HZWP6VP677XHXS04R5KE.webp\",\"\\/01HZT2J0046D9CH4S4E86SB9QV.webp\",\"\\/01HZT2J043PJR6QZ36YGA8BJ0P.webp\",\"\\/01HZT2J078VBV5F1QS659TPKYB.webp\",\"\\/01HZT2J0AAFS211C5XE5CRJHN3.webp\"]', 'SKI-26', 'K13****', 'nissan', 'MARCH', 2017, '2,400', '$', '38,000 KM', '5', 'Automatic', 'Hatchback', 'PETROL', 'discounted', 'Ireland', '<ul><li>Power Mirror,</li><li>Power Window</li><li>Air Bags</li><li>Tv Navigation</li><li>Alloy Wheels</li><li>Push Start</li></ul>', 'available', NULL, '2024-06-08 02:24:39', '2024-06-20 22:16:34'),
(33, '/01HZT2S9N92T102TMFH81WD861.webp', '[\"\\/01HZT2S9TPXKXAV6B1TRNC3MSZ.webp\",\"\\/01HZT2S9Y1X3XM0ZPGGW7KE4J0.webp\",\"\\/01HZT2SA0V1FSDDHD9H3A9BWMC.webp\",\"\\/01HZT2SA4FSMPAGS7AMKVFXT5S.webp\",\"\\/01HZT2SA7VD9PSMRMFMSZJXVBX.webp\",\"\\/01HZT2SAANM3VHAP8HBNXCA3H2.webp\",\"\\/01HZT2SADDFGC42V5XRJNA60XM.webp\",\"\\/01HZT2SAGBJNSF0ZBP5SW09AK4.webp\",\"\\/01HZT2SAK63C3H2NRGCMNK5S1G.webp\"]', 'SKI-27', 'KF2P****', 'mazda', 'CX-5', 2019, '11,900', '$', '103,000 KM', '5', 'Automatic', 'SUV', 'PETROL', 'new arrival', 'Jamaica', '<ul><li>Power Mirror,</li><li>Power Window</li><li>Air Bags</li><li>Tv Navigation</li><li>Alloy Wheels</li><li>Push Start</li><li>Multi Function Steering</li></ul>', 'available', NULL, '2024-06-08 02:28:39', '2024-06-08 02:28:39'),
(34, '/01HZT2ZN5ETQGHKJB6SQNY21ZP.webp', '[\"\\/01HZT2ZN8BF4R8TX7Z5DW171RZ.webp\",\"\\/01HZT2ZNB1ZMHRQ7SG5P13TCP4.webp\",\"\\/01HZT2ZNDQFHMXVYARFMZ37RAZ.webp\",\"\\/01HZT2ZNG3GGFEMBQX9ZPJEH3M.webp\",\"\\/01HZT2ZNJKVCMDD22Z3D1Q85NW.webp\",\"\\/01HZT2ZNN2VREXTFTDPEWY3M5T.webp\",\"\\/01HZT2ZNQJQ1MSPKPMG94Q4VHA.webp\",\"\\/01HZT2ZNSZ17DPJBB97GHFJ93V.webp\",\"\\/01HZT2ZNWT255R0PKTR08S291V.webp\"]', 'SKI-28', 'MXAA52****', 'toyota', 'RAV4', 2022, '20,000', '$', '18,000 KM ', '5', 'Automatic', 'SUV', 'PETROL', 'new arrival', 'Jamaica', '<ul><li>Power Mirror,</li><li>Power Window</li><li>Air Bags</li><li>Tv Navigation</li><li>Alloy Wheels</li><li>Push Start</li><li>Multi Function Steering</li></ul>', 'available', NULL, '2024-06-08 02:32:07', '2024-06-08 02:32:07'),
(35, '/01HZT367NFFVNAZ7PB7AA3KG58.webp', '[\"\\/01HZT367RAMAV81J01G3RH0XQT.webp\",\"\\/01HZT367TZ7DQZXNHWSXSSM3XT.webp\",\"\\/01HZT367XR5TKPMER6YHV88S2G.webp\",\"\\/01HZT368047N9HSAM6P9F85SRC.webp\",\"\\/01HZT3682VGJ1C402FZS13BD63.webp\",\"\\/01HZT3685E91Z5XZRV4PH2NMBT.webp\",\"\\/01HZT36880CS0SBBK3T470DNC0.webp\",\"\\/01HZT368AKKFZ04FWFQCDAF7ZA.webp\",\"\\/01HZT368EC9AS1X61JR6DAD3NS.webp\",\"\\/01HZT368HQTCKACR2Y2JH1V038.webp\"]', 'SKI-29', 'NCP160****', 'toyota', 'SUCCEED', 2019, '4,600', '$', '112,000 KM', '5', 'Automatic', 'Van', 'PETROL', 'discounted', 'Jamaica', '<ul><li>Power Mirror,</li><li>Power Window</li><li>Air Bags</li><li>Tv Navigation</li><li>Alloy Wheels</li><li>Key Start</li></ul>', 'available', NULL, '2024-06-08 02:35:42', '2024-06-08 02:35:42'),
(36, '/01HZT3CPREFPPASC29RMZCY6D3.webp', '[\"\\/01HZT3CPW5RYDJDZWXQ56FBKH6.webp\",\"\\/01HZT3CPYN31S6R6YCKZ1GDE6H.webp\",\"\\/01HZT3CQ1A74EQ9JF671PX3A0Z.webp\",\"\\/01HZT3CQ3RY900GBA0Y5BT06EB.webp\",\"\\/01HZT3CQ6GWP963QH7KTB783Y1.webp\",\"\\/01HZT3CQ8YKQW36SQY1A4KHRYP.webp\",\"\\/01HZT3CQBFN531G0H1WTMM37KN.webp\",\"\\/01HZT3CQE515QV94RGXB93SWSD.webp\",\"\\/01HZT3CQH0JF2G68B44DNRCMY7.webp\"]', 'SKI-30', 'NRE161****', 'toyota', 'COROLLA FIELDER', 2016, '5000', '$', '17,8000 KM', '5', 'Automatic', 'Wagon', 'PETROL', 'discounted', 'Jamaica', '<ul><li>Power Mirror,</li><li>Power Window</li><li>Air Bags</li><li>Tv Navigation</li><li>Alloy Wheels</li><li>Key Start</li></ul>', 'available', NULL, '2024-06-08 02:39:14', '2024-06-20 22:19:16'),
(37, '/01HZT3J0CHWDD8GP5BCEG78CCH.webp', '[\"\\/01HZT3J0F817SN0C0M87PS52WQ.webp\",\"\\/01HZT3J0HSBCDPCBBYMKHPYHGX.webp\",\"\\/01HZT3J0M520ZFTWFXM354SQ5G.webp\",\"\\/01HZT3J0PPXHCMCFG9JZ9MVEZ0.webp\",\"\\/01HZT3J0VATF68YJW3VRGHCZ7Q.webp\",\"\\/01HZT3J0XYWBWGYQBVE522DB03.webp\",\"\\/01HZT3J10JSM0Y2KC0MMV234M3.webp\",\"\\/01HZT3J1371VJR390X2D79CM69.webp\",\"\\/01HZT3J15RVY4P8SBWERJKRAMB.webp\"]', 'SKI-31', 'VR2E26****', 'nissan', 'CARAVAN', 2019, '9,200', '$', '98,000 KM', '5', 'Automatic', 'Van', 'PETROL', 'discounted', 'Jamaica', '<ul><li>Power Mirror,</li><li>Power Window</li><li>Air Bags</li><li>Tv Navigation</li><li>Alloy Wheels</li><li>Push Start</li></ul>', 'available', NULL, '2024-06-08 02:42:08', '2024-06-20 22:14:29'),
(38, '/01HZT3Z6TE0XFSTNT327YF1D9K.webp', '[\"\\/01HZT3Z6XASTMX0QXP6Q14Q1HM.webp\",\"\\/01HZT3Z6ZS76923VQXXAW5N9W2.webp\",\"\\/01HZT3Z72DM8NVCH2M13BV23CY.webp\",\"\\/01HZT3Z74QY1AE6JK0G8S4VBV8.webp\",\"\\/01HZT3Z77HKH8AXZER0QNTZ47N.webp\",\"\\/01HZT3Z7A8ZQZJ6SF8G1A6E3B8.webp\",\"\\/01HZT3Z7CWDDYSSTWRR3C1W6EN.webp\",\"\\/01HZT3Z7FMCDJAQNYE58K71FH8.webp\",\"\\/01HZT3Z7JAAW4Q5QBTZ2ETE73H.webp\",\"\\/01HZT3Z7MZJQ6BK7MJ4E0VEV3Q.webp\",\"\\/01HZT3Z7QT4SHT8WZXNNJWV9DB.webp\",\"\\/01HZT3Z7T6C714554GMNPPNMKE.webp\"]', 'SKI-32', 'WAUZZZ8***', 'audi', 'Q3', 2016, '7,500', '$', '92,000 KM', '5', 'Automatic', 'SUV', 'PETROL', 'stock', 'Ireland', '<ul><li>Power Mirror</li><li>Power Window</li><li>Air Bags</li><li>Tv Navigation</li><li>Alloy Wheels</li><li>Push Start</li><li>Multi Function Steering</li></ul>', 'available', NULL, '2024-06-08 02:49:21', '2024-06-20 22:17:33'),
(39, '/01HZT47G0200KKQH6M1X1ARRX6.webp', '[\"\\/01HZT47G2Y774WRFDH1QM15YTA.webp\",\"\\/01HZT47G5DQN171F307EBTFNA4.webp\",\"\\/01HZT47G88NF79136Y8T92C94Q.webp\",\"\\/01HZT47GAQ6MF7VHG11K9TGHZ2.webp\",\"\\/01HZT47GD5XD9CTABTEVENMYRK.webp\",\"\\/01HZT47GF6BTS97J0TGCA1RDRG.webp\"]', 'SKI-33', 'WAUZZZ8V**', 'audi', 'A3', 2015, '3,600', '$', '104,000 KM', '5', 'Automatic', 'Hatchback', 'PETROL', 'stock', 'Ireland', '<ul><li>Power Mirror</li><li>Power Window</li><li>Air Bags</li><li>Tv Navigation</li><li>Alloy Wheels</li><li>Push Start</li><li>Multi Function Steering&nbsp;</li></ul>', 'available', NULL, '2024-06-08 02:53:52', '2024-06-08 02:53:52'),
(40, '/01HZT4D7QHZGJR0EKE4PQ1QHBB.webp', '[\"\\/01HZT4D7V2X3CDDJM7BEPVYMXF.webp\",\"\\/01HZT4D7XJ4517X5WNDQBC9410.webp\",\"\\/01HZT4D807VABZ1Q7T7A01CXXQ.webp\",\"\\/01HZT4D82GZR1XGXESFPBVCQ58.webp\",\"\\/01HZT4D85FYW3JVFBNW8XGG7ED.webp\",\"\\/01HZT4D87Q86DR73SDJB0PBM9R.webp\"]', 'SKI-34', 'WDD117****', 'mercedes', 'CLA180', 2016, '5,500', '$', '110,000 KM', '5', 'Automatic', 'Hatchback', 'PETROL', 'stock', 'Ireland', '<ul><li>Power Mirror</li><li>Power Window</li><li>Air Bags</li><li>Tv Navigation</li><li>Alloy Wheels</li><li>Push Start</li><li>Multi Function Steering&nbsp;&nbsp;</li></ul>', 'available', NULL, '2024-06-08 02:57:00', '2024-06-10 21:39:27'),
(41, '/01HZT4N04NSJCPSQ8V5P16BWK6.webp', '[\"\\/01HZT4N07P0EJ1KWGVK2KP21Z8.webp\",\"\\/01HZT4N0ADRJGRJWW2923AFA7J.webp\",\"\\/01HZT4N0D4GEKHDW1912F4NPNR.webp\",\"\\/01HZT4N0FREFRSY8C4N6PJQ0PN.webp\",\"\\/01HZT4N0JPTHK4SWY7P9RTWCQ0.webp\",\"\\/01HZT4N0NFXSZYY2B9B7WMS7PV.webp\",\"\\/01HZT4N0R6JMRXR8CX32VDGQWE.webp\",\"\\/01HZT4N0TZ8CHGB8R4E1MBVNZ2.webp\",\"\\/01HZT4N0XS4540ATAQ8XKW1HGB.webp\",\"\\/01HZT4N10BQWSAY1W9EN5GTHEE.webp\",\"\\/01HZT4N1382Y5R9GZMZ3YKXNS6.webp\",\"\\/01HZT4N15VT7G8EJYQZQ2KCNY8.webp\"]', 'SKI-35', 'WDD1179***', 'mercedes', 'CLA180', 2016, '5,750', '$', '79,000 KM', '5', 'Automatic', 'Hatchback', 'PETROL', 'stock', 'Ireland', '<ul><li>Power Mirror</li><li>Power Window</li><li>Air Bags</li><li>Tv Navigation</li><li>Alloy Wheels</li><li>Push Start</li><li>Multi Function Steering&nbsp;&nbsp;</li></ul>', 'available', NULL, '2024-06-08 03:01:15', '2024-06-10 21:49:49'),
(42, '/01HZT4VDN65ZVHJEYBQWZSQ4JJ.webp', '[\"\\/01HZT4VDR57KR3B88D9ZNDG6KW.webp\",\"\\/01HZT4VDTQXNCJV5NP6031KVRE.webp\",\"\\/01HZT4VDX4F15RWCXY7T6PYBHT.webp\",\"\\/01HZT4VDZG8XNYCHXJ59QRDG0E.webp\",\"\\/01HZT4VE24TZWK9FKG5XZ0WSSK.webp\",\"\\/01HZT4VE4QDVG1AWNW9D3K4B9V.webp\",\"\\/01HZT4VE7FNRNFYYYNBV8ANKJR.webp\",\"\\/01HZT4VE9Z021JTP9HNF7SZAY8.webp\",\"\\/01HZT4VECQ5W3J2CB1DGF5DF9K.webp\",\"\\/01HZT4VEF9KHQ1853ZTVSX54G3.webp\",\"\\/01HZT4VEHXC4X7DMA5GXF3H6EG.webp\",\"\\/01HZT4VEMK1SPQQ6WHHS8Y94PV.webp\"]', 'SKI-36', 'WDD1179***', 'mercedes', 'CLA180', 2016, '4,600', '$', '85,000 KM', '5', 'Automatic', 'Hatchback', 'PETROL', 'stock', 'Ireland', '<ul><li>Power Mirror</li><li>Power Window</li><li>Air Bags</li><li>Tv Navigation</li><li>Alloy Wheels</li><li>Push Start</li><li>Multi Function Steering&nbsp;</li></ul>', 'available', NULL, '2024-06-08 03:04:45', '2024-06-10 21:49:00'),
(43, '/01HZT515HRH950894P1KGP69B6.webp', '[\"\\/01HZT515MSRYG0YYVV8S6S1CXS.webp\",\"\\/01HZT515Q8F6XHRG28MW29JG1T.webp\",\"\\/01HZT515SWJB3JF90K7MT01GR9.webp\",\"\\/01HZT515WB7PXWWX5G8XGBF86M.webp\",\"\\/01HZT515Z74MM4M98CWQP9PBYQ.webp\",\"\\/01HZT5161SPR2RHNPTS928NSE1.webp\"]', 'SKI-37', 'WVWZZZ6***', 'volswagen', 'POLO', 2017, '4,650 ', '$', '44,000 KM', '5', 'Automatic', 'Hatchback', 'PETROL', 'stock', 'Ireland', '<ul><li>Power Mirror</li><li>Power Window</li><li>Air Bags</li><li>Tv Navigation</li><li>Alloy Wheels</li><li>Key Start</li><li>Multi Function Steering&nbsp;</li></ul>', 'available', NULL, '2024-06-08 03:07:53', '2024-06-08 03:07:53'),
(44, '/01HZT55T0DN1CVD31614G7P7KQ.webp', '[\"\\/01HZT55T3K6C8501Q2P2P6C2GA.webp\",\"\\/01HZT55T6EGCV6D207V0Y5GS7W.webp\",\"\\/01HZT55T9F2G5J8JTM51B6T07G.webp\",\"\\/01HZT55TC3CWHHAD5C2VC6WRP5.webp\",\"\\/01HZT55TF7EZAF3MNT0MB9PDBT.webp\",\"\\/01HZT55THZE5ZRJEHMSDPDJ9QE.webp\"]', 'SKI-38', 'WVWZZZ****', 'volswagen', 'GOLF', 2015, '3,950', '$', '57,000 KM', '5', 'Automatic', 'Hatchback', 'PETROL', 'stock', 'Ireland', '<ul><li>Power Mirror</li><li>Power Window</li><li>Air Bags</li><li>Tv Navigation</li><li>Alloy Wheels</li><li>Key Start</li><li>Multi Function Steering&nbsp;&nbsp;</li></ul>', 'available', NULL, '2024-06-08 03:10:25', '2024-06-20 22:18:33'),
(45, '/01HZT5D9NK7QJJNK4X3VB9K35R.webp', '[\"\\/01HZT5D9RGG7NMASRSXEV8VWCR.webp\",\"\\/01HZT5D9V7V5M90Y2N3X27FC5E.webp\",\"\\/01HZT5D9Y0S8045MA7D60HSG9N.webp\",\"\\/01HZT5DA0SYEN1CWNVY6YTZ4T4.webp\",\"\\/01HZT5DA3PMFFTF56QF9XX5HYB.webp\",\"\\/01HZT5DA6D64DRV4M8TB7QX73Q.webp\",\"\\/01HZT5DA91QD9HED8Q9JD3X20X.webp\",\"\\/01HZT5DABFF2RF3TNZYK5XW7EH.webp\",\"\\/01HZT5DAE6DPYKACVNEXRXEVG5.webp\",\"\\/01HZT5DAGQH8YYF074S59QHNN9.webp\",\"\\/01HZT5DAKFPRRM9Z9G44XZ688W.webp\"]', 'SKI-39', 'ZRR80*****', 'toyota', 'VOXY', 2014, '9,400', '$', '109,000 KM', '5', 'Automatic', 'Van', 'PETROL', 'stock', 'Jamaica', '<ul><li>Power Mirror</li><li>Power Window</li><li>Air Bags</li><li>TV Navigation</li><li>Alloy Wheels</li><li>Push Start</li><li>Fog Lamps</li><li>Media Steering &nbsp;</li></ul>', 'available', NULL, '2024-06-08 03:14:31', '2024-06-08 03:21:50'),
(46, '/01HZT5K1V7PG736M97BZ4E0GPW.webp', '[\"\\/01HZT5K1Y1HRGFA7V1WSGJNK91.webp\",\"\\/01HZT5K20ND07PWG7D76J6Y3F0.webp\",\"\\/01HZT5K237HRJE5EBYJ342YNRS.webp\",\"\\/01HZT5K25MAFH9EPPGCS2G310F.webp\",\"\\/01HZT5K28C22N1KYFNPDWHTW6E.webp\",\"\\/01HZT5K2AW79TT1KBPH1HBXS1P.webp\",\"\\/01HZT5K2FGCKK0VBTX1VFBE9XZ.webp\",\"\\/01HZT5K2J5CMKZWA3N4QPR9JFH.webp\",\"\\/01HZT5K2MW06E9F6FJVA41K0D1.webp\",\"\\/01HZT5K2QGMDKAERCPMN694KS3.webp\",\"\\/01HZT5K2T2BRDCQN93EJHETF9H.webp\"]', 'SKI-40', 'ZRR80*****', 'toyota', 'VOXY', 2015, '7,500', '$', '134,000 KM', '5', 'Automatic', 'Van', 'PETROL', 'stock', 'Jamaica', '<ul><li>Power Mirror</li><li>Power Window</li><li>Air Bags</li><li>TV Navigation</li><li>Alloy Wheels</li><li>Push Start</li><li>Media Steering &nbsp;</li></ul>', 'available', NULL, '2024-06-08 03:17:40', '2024-06-08 03:17:40'),
(47, '/01HZT6X6XY1JNKFMFKS7DEQ4AF.webp', '[\"\\/01HZT6X72J5JEYS5YVRX6E7G8D.webp\",\"\\/01HZT6X75ES2KES82XFSDYVPN2.webp\",\"\\/01HZT6X784SB251X75S64WMB67.webp\",\"\\/01HZT6X7ANHY0JCFBNNGYP2XSX.webp\",\"\\/01HZT6X7DNF8C0N0J7BFFK2QG1.webp\",\"\\/01HZT6X7G2TP5BSH7FM9P0XDNT.webp\",\"\\/01HZT6X7JVK38FMHJVD0E44DE5.webp\"]', 'SKI-41', 'FC7JCW****', 'hino', 'RANGER ', 2005, '13,000', '$', '107,000 KM', '2', 'Manual', 'Truck', 'Diesel', 'commercial', 'Jamaica', '<p>-</p>', 'available', NULL, '2024-06-08 03:40:41', '2024-06-08 04:04:33'),
(48, '/01HZT938Q3BZGFAQKX0SVFQJJP.webp', '[\"\\/01HZT938WEGSKSK9XN73TBN508.webp\",\"\\/01HZT938Z6MRGWJYGQT4TQKGAF.webp\",\"\\/01HZT9392155CY0DK1NM7HKYXG.webp\",\"\\/01HZT9395S25KY908BH1NMVHF0.webp\",\"\\/01HZT93998DTRX866CNBV7KW1Q.webp\",\"\\/01HZT939BX66KWZT5CJZ04CWXC.webp\",\"\\/01HZT939EKPKGDYMF9YFWDJAPB.webp\",\"\\/01HZT939HBHY1D7E9MD8E6MYN2.webp\",\"\\/01HZT939M1XGW89QFNRY7ZTM12.webp\"]', 'SKI-42', 'RT51*****', 'honda', 'CR-V', 2019, '18,700', '$', '54,000 KM', '5', 'Automatic', 'SUV', 'PETROL', 'stock', 'Jamaica', '<ul><li>Power Mirror</li><li>Power Window</li><li>Air Bags</li><li>Multi Function Steering</li><li>TV Navigation</li><li>Alloy Wheel</li><li>Push Start</li><li>Fog Lamps</li></ul>', 'available', NULL, '2024-06-08 04:18:57', '2024-06-20 22:15:23'),
(49, '/01J0185E7M9N5HEXZ6MY2AM4KQ.webp', '[\"\\/01J0185ECMBBW2XMY3CGZ1V65B.webp\",\"\\/01J0185EFGVNQHFCRNBBQ9W3JK.webp\",\"\\/01J0185EJDXDD5WG5NVNWXWNZ6.webp\",\"\\/01J0185EN86XD1ARQ4ZTBVH6FZ.webp\",\"\\/01J0185ER0YDWP2KFTPB27Z42H.webp\",\"\\/01J0185ETVHJ1Q1ZBJEXMT77XF.webp\",\"\\/01J0185EXKZKY3MV5Z50Q19F3C.webp\",\"\\/01J0185F0R4J0QXZ6SH4M8MQ20.webp\",\"\\/01J0185F3RPN4F6EW4S9451M76.webp\",\"\\/01J0185F6F5S3Q4YTJE6TVCR9X.webp\"]', 'SKI-43', 'ZRR80', 'toyota', 'Voxy', 2016, '9,700', '$', '99,000 KM', '5', 'Automatic', 'Van', 'PETROL', 'new arrival', 'Jamaica', '<ul><li>Power Mirror</li><li>Power Window</li><li>Air Bags</li><li>Multi Function Steering</li><li>Tv Navigation</li><li>Alloy Wheels</li><li>Fog Lamps</li><li>Push Start</li></ul>', 'available', NULL, '2024-06-10 21:17:20', '2024-06-20 22:23:21'),
(50, '/01J0V1PG35KHA95NQCZJEG9CJZ.webp', '[\"\\/01J0V1PG7M5D0JA08DQBW5E970.webp\",\"\\/01J0V1PGAESKPME5HQZ25Y4SNF.webp\",\"\\/01J0V1PGDC5P4WQ0HQZFWYPJDF.webp\",\"\\/01J0V1PGG2BPVC0CB3KSFDN1C8.webp\",\"\\/01J0V1PGK1ZVNT6G73B37QKMZK.webp\",\"\\/01J0V1PGNRF22N2FZZZXKN9QFH.webp\",\"\\/01J0V1PGRQK5B19TFYBR8C6JN6.webp\",\"\\/01J0V1PGVESQ17D7A8H755WN5Q.webp\",\"\\/01J0V1PGYDHP350KQD4AMZ69ZZ.webp\",\"\\/01J0V1PH1JEJTE0KSHVBVX9MK3.webp\"]', 'SKI-44', 'ZRR80*****', 'toyota', 'VOXY', 2015, '9,900', '$', '106,000', '5', 'Automatic', 'Van', 'PETROL', 'stock', 'Jamaica', '<ul><li>Power Mirror&nbsp;</li><li>Power Window</li><li>Air Bags</li><li>Multi Function Steering&nbsp;</li><li>Fog lamps</li><li>Tv Navigation</li><li>Alloy Wheels</li><li>Push Start</li></ul>', 'available', NULL, '2024-06-20 21:44:35', '2024-06-20 22:24:24'),
(51, '/01J1ANP8ATG04CAT2J5CHMKAYD.webp', '[\"\\/01J1ANP8D7BEZJRMMN6BMTB9KH.webp\",\"\\/01J1ANP8F6HMFTNHNXHHFH2114.webp\",\"\\/01J1ANP8H1GQEKAC50XF59KZFW.webp\",\"\\/01J1ANP8K1CHKZ5DJ7ZBM9FRRV.webp\",\"\\/01J1ANP8MWPKZ48QE775EJE5QJ.webp\",\"\\/01J1ANP8PV9M61MF4696CRZ8SC.webp\",\"\\/01J1ANP8RQE6F06GMFZPPN6K81.webp\",\"\\/01J1ANP8TGZQ01QRMA425MGFM3.webp\",\"\\/01J1ANP8WCE6A1W2QXAHCW6H92.webp\",\"\\/01J1ANP8Y56HS6JR8CH5BGT1CK.webp\"]', 'SKI-45', 'ZRR70*****', 'toyota', 'VOXY', 2013, 'Inquiry', '$', '119,000 KM', '5', 'Automatic', 'Van', 'PETROL', 'stock', 'UK', '<ul><li>&nbsp;Power Mirror</li><li>&nbsp;Power Window</li><li>&nbsp;Air Bags</li><li>&nbsp;Media Steering</li><li>&nbsp;Fog Lamps</li><li>Tv Navigation</li><li>&nbsp;Alloy Wheels</li><li>&nbsp;Push Start</li></ul>', 'available', NULL, '2024-06-26 23:22:34', '2024-06-26 23:22:34'),
(52, '/01J1AP0AKQDYK06A5GYNTVDT9M.webp', '[\"\\/01J1AP0ANP542QQ3C9S7YDDE3G.webp\",\"\\/01J1AP0AQJTYDAXHFH5T49E09D.webp\",\"\\/01J1AP0ASB7BTMHV2J1JQKQ7ZR.webp\",\"\\/01J1AP0AV07PJDWMFVF9HCZY92.webp\",\"\\/01J1AP0AWPZYVMSNSJ66CHGTAQ.webp\",\"\\/01J1AP0AYH77G1ECQWTBJA55JS.webp\",\"\\/01J1AP0B0F4918XZBQFWMDX117.webp\",\"\\/01J1AP0B24FDX3642J7E0MPH22.webp\",\"\\/01J1AP0B3Q5T5K542FG4MEKZFX.webp\",\"\\/01J1AP0B5GM2HZ3SGJCDQKC5A3.webp\",\"\\/01J1AP0B71VE6NTRTPNKTEV5R3.webp\",\"\\/01J1AP0B8KKQCKJ2BB31TE0FB1.webp\"]', 'SKI-46', 'GP5*******', 'honda', 'FIT', 2014, 'Inquiry', '$', '81,000 KM', '5', 'Automatic', 'Hatchback', 'PETROL', 'stock', 'UK', '<ul><li>Power Mirror</li><li>Power Window</li><li>Air Bags</li><li>Multi Function Steering</li><li>Tv Navigation</li><li>Alloy Wheels</li><li>Push Start</li></ul>', 'available', NULL, '2024-06-26 23:28:04', '2024-06-26 23:28:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL,
  `manager` varchar(100) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `manager`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Agent', 'agent@shinkyowa.com', NULL, '$2y$12$MXDs59ko8UWtII6Cf1Vg7uH62Hic3d234d9QPglNlQQJpZMTLKr0W', 'admin', '', NULL, '2024-07-24 13:18:05', '2024-07-24 13:18:05'),
(2, 'Ghazi Muqbil', 'ghazi@shinkyowa.com', NULL, '$2y$12$VkdhejCq.jdKX1kp0Y0sLOcbW6mdsbi4Miktc3Wsoz0GLJKvW667q', 'manager', '', NULL, '2024-07-31 10:33:29', '2024-07-31 10:33:29'),
(3, 'Aima Jamil', 'aima@shinkyowa.com', NULL, '$2y$12$fc9y6BGvaL1mdRBfHQEQseVyg9ejYXIZeXb8z8PxpwVvWjXIwDlBS', 'agent', 'Ghazi Muqbil', NULL, '2024-07-31 11:29:35', '2024-07-31 11:29:35'),
(4, 'Oliver', 'oliver@shinkyowa.com', NULL, '$2y$12$BreOYgZxFJW7gDwfXya49eoqkj2IuEW/pk3QlrKDla6RBqvOfx6B.', 'agent', 'Ghazi Muqbil', NULL, '2024-07-31 11:32:38', '2024-08-09 16:18:11');

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
-- Indexes for table `customer_accounts`
--
ALTER TABLE `customer_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_payments`
--
ALTER TABLE `customer_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_vehicles`
--
ALTER TABLE `customer_vehicles`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
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
-- AUTO_INCREMENT for table `customer_accounts`
--
ALTER TABLE `customer_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `customer_payments`
--
ALTER TABLE `customer_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `customer_vehicles`
--
ALTER TABLE `customer_vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
