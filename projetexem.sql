-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 21, 2026 at 09:10 PM
-- Server version: 8.0.46
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projetexem`
--

-- --------------------------------------------------------

--
-- Table structure for table `appliances`
--

CREATE TABLE `appliances` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default_power_w` int UNSIGNED NOT NULL,
  `default_duration_hours` decimal(8,2) NOT NULL DEFAULT '4.00',
  `has_startup_surge` tinyint(1) NOT NULL DEFAULT '0',
  `startup_factor` decimal(8,2) NOT NULL DEFAULT '1.00',
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appliances`
--

INSERT INTO `appliances` (`id`, `name`, `default_power_w`, `default_duration_hours`, `has_startup_surge`, `startup_factor`, `category`, `created_at`, `updated_at`) VALUES
(1, 'Éclairage LED', 20, '5.00', 0, '1.00', 'eclairage', '2026-10-12 18:43:33', '2026-10-12 18:43:33'),
(2, 'Télévision', 120, '4.00', 0, '1.00', 'multimedia', '2026-10-12 18:43:33', '2026-10-12 18:43:33'),
(3, 'Réfrigérateur', 150, '6.00', 1, '3.00', 'froid', '2026-10-12 18:43:33', '2026-10-12 18:43:33'),
(4, 'Ordinateur', 100, '8.00', 0, '1.00', 'informatique', '2026-10-12 18:43:33', '2026-10-12 18:43:33'),
(5, 'Enceinte', 100, '4.00', 0, '1.00', 'audio', '2026-10-12 18:43:33', '2026-10-12 18:43:33'),
(6, 'DJ / table de mixage', 250, '5.00', 0, '1.00', 'audio', '2026-10-12 18:43:33', '2026-10-12 18:43:33'),
(7, 'Perceuse', 800, '2.00', 1, '3.00', 'outillage', '2026-10-12 18:43:33', '2026-10-12 18:43:33'),
(8, 'Meuleuse', 1000, '1.00', 1, '3.00', 'outillage', '2026-10-12 18:43:33', '2026-10-12 18:43:33'),
(9, 'Pompe', 750, '2.00', 1, '4.00', 'outillage', '2026-10-12 18:43:33', '2026-10-12 18:43:33'),
(10, 'Chargeur téléphone', 15, '4.00', 0, '1.00', 'informatique', '2026-10-12 18:43:33', '2026-10-12 18:43:33'),
(11, 'Imprimante', 50, '4.00', 0, '1.00', 'informatique', '2026-10-12 18:43:33', '2026-10-12 18:43:33'),
(12, 'Ventilateur', 60, '8.00', 1, '2.00', 'confort', '2026-10-12 18:43:33', '2026-10-12 18:43:33');

-- --------------------------------------------------------

--
-- Table structure for table `availabilities`
--

CREATE TABLE `availabilities` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED DEFAULT NULL,
  `pack_id` bigint UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `quantity_total` int UNSIGNED NOT NULL DEFAULT '0',
  `quantity_reserved` int UNSIGNED NOT NULL DEFAULT '0',
  `quantity_available` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Panneaux', 'Panneaux solaires photovoltaïques.', 'panneaux', '2026-10-12 18:43:33', '2026-10-12 18:43:33'),
(2, 'Batteries', 'Stockage lithium et plomb.', 'batteries', '2026-10-12 18:43:33', '2026-10-12 18:43:33'),
(3, 'Onduleurs', 'Onduleurs 230 V.', 'onduleurs', '2026-10-12 18:43:33', '2026-10-12 18:43:33'),
(4, 'Chargeurs / MPPT', 'Régulateurs et MPPT.', 'chargeurs-mppt', '2026-10-12 18:43:33', '2026-10-12 18:43:33'),
(5, 'Accessoires', 'Câbles, coffrets, supports.', 'accessoires', '2026-10-12 18:43:33', '2026-10-12 18:43:33'),
(6, 'Générateurs', 'Groupes électrogènes d’appoint.', 'generateurs', '2026-10-12 18:43:33', '2026-10-12 18:43:33');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_10_05_100001_create_categories_table', 1),
(6, '2026_10_05_100002_create_products_table', 1),
(7, '2026_10_05_100003_create_packs_table', 1),
(8, '2026_10_05_100004_create_pack_products_table', 1),
(9, '2026_10_05_100005_create_appliances_table', 1),
(10, '2026_10_05_100006_create_quotes_table', 1),
(11, '2026_10_05_100007_create_quote_items_table', 1),
(12, '2026_10_05_100008_create_reservations_table', 1),
(13, '2026_10_05_100009_create_reservation_products_table', 1),
(14, '2026_10_05_100010_create_availabilities_table', 1),
(15, '2026_10_05_100011_create_settings_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `packs`
--

CREATE TABLE `packs` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price_per_day` decimal(10,2) NOT NULL,
  `deposit` decimal(10,2) NOT NULL DEFAULT '0.00',
  `energy_capacity_wh` int UNSIGNED NOT NULL,
  `continuous_power_w` int UNSIGNED NOT NULL,
  `surge_power_w` int UNSIGNED DEFAULT NULL,
  `recommended_uses` json DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packs`
--

INSERT INTO `packs` (`id`, `name`, `description`, `price_per_day`, `deposit`, `energy_capacity_wh`, `continuous_power_w`, `surge_power_w`, `recommended_uses`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Pack Stand Marché', 'Idéal pour un stand, un marché ou un petit point de vente. Installation simple, silencieux.', '90.00', '700.00', 4500, 1200, 2200, '[\"Stand\", \"Marché\", \"Caisse / éclairage\"]', NULL, 1, '2026-10-12 18:43:33', '2026-10-12 18:43:33'),
(2, 'Pack Événement 1 Nuit', 'Éclairage, sono légère, TV et réfrigérateur pour une soirée ou un mariage.', '180.00', '1400.00', 9500, 3500, 6500, '[\"Mariage\", \"Anniversaire\", \"Concert léger\"]', NULL, 1, '2026-10-12 18:43:33', '2026-10-12 18:43:33'),
(3, 'Pack Chantier Journée', 'Conçu pour perceuses, meuleuses et éclairage de chantier, avec marge sur les pics.', '220.00', '1800.00', 12000, 5500, 10000, '[\"Chantier\", \"Bureau temporaire\", \"Outillage\"]', NULL, 1, '2026-10-12 18:43:33', '2026-10-12 18:43:33');

-- --------------------------------------------------------

--
-- Table structure for table `pack_products`
--

CREATE TABLE `pack_products` (
  `id` bigint UNSIGNED NOT NULL,
  `pack_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `quantity` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pack_products`
--

INSERT INTO `pack_products` (`id`, `pack_id`, `product_id`, `quantity`) VALUES
(1, 1, 3, 1),
(2, 1, 6, 1),
(3, 1, 1, 1),
(4, 1, 9, 1),
(5, 1, 10, 1),
(6, 2, 4, 1),
(7, 2, 7, 1),
(8, 2, 2, 2),
(9, 2, 9, 1),
(10, 2, 10, 1),
(11, 3, 4, 1),
(12, 3, 8, 1),
(13, 3, 2, 4),
(14, 3, 9, 1),
(15, 3, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
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
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `power_w` int UNSIGNED DEFAULT NULL,
  `voltage_v` int UNSIGNED DEFAULT NULL,
  `capacity_wh` int UNSIGNED DEFAULT NULL,
  `capacity_ah` decimal(10,2) DEFAULT NULL,
  `surge_power_w` int UNSIGNED DEFAULT NULL,
  `daily_price` decimal(10,2) NOT NULL,
  `deposit` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quantity` int UNSIGNED NOT NULL DEFAULT '1',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `reference`, `description`, `power_w`, `voltage_v`, `capacity_wh`, `capacity_ah`, `surge_power_w`, `daily_price`, `deposit`, `quantity`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Panneau solaire 400 W', 'PV-400', 'Panneau monocristallin 400 W, idéal pour compléter un pack événement.', 400, 24, NULL, NULL, NULL, '15.00', '120.00', 20, 'products/NUQxxqvMXQvN8HEbAJNP9iDXCZ3x29eM0tMAihpI.webp', 1, '2026-10-12 18:43:33', '2026-10-12 19:12:49'),
(2, 1, 'Panneau solaire 550 W', 'PV-550', 'Haut rendement pour chantiers et recharge diurne.', 550, 48, NULL, NULL, NULL, '20.00', '150.00', 16, 'products/kzHaPWqdq6YMytXkTXK4P2lcjUMcBqrtXmA1ZUMu.webp', 1, '2026-10-12 18:43:33', '2026-10-12 19:12:15'),
(3, 2, 'Batterie lithium 5 kWh 48 V', 'BAT-L5', 'Lithium LiFePO4, DoD élevé, silencieuse.', NULL, 48, 5000, '104.00', NULL, '80.00', '900.00', 6, 'products/uhwK9Yu6VNqSnmNRjRiXLVDhuadBr84Q7jKwOjVy.webp', 1, '2026-10-12 18:43:33', '2026-10-12 19:14:22'),
(4, 2, 'Batterie lithium 10 kWh 48 V', 'BAT-L10', 'Grande autonomie pour soirées et stands.', NULL, 48, 10000, '208.00', NULL, '140.00', '1600.00', 4, 'products/3MCHEAxBHGNW5BFauXQ9RFAZWVloGxZi04B525rU.webp', 1, '2026-10-12 18:43:33', '2026-10-12 19:09:37'),
(5, 2, 'Batterie plomb 200 Ah 12 V', 'BAT-P200', 'Solution économique, DoD plus faible.', NULL, 12, 2400, '200.00', NULL, '25.00', '250.00', 10, 'products/av4Z67gCia6NSLVOZG3mTxtvg9eVJ63mGLDXZ2tP.webp', 1, '2026-10-12 18:43:33', '2026-10-12 19:15:07'),
(6, 3, 'Onduleur 1000 W', 'INV-1000', 'Pour éclairage, TV et petit froid.', 1000, 230, NULL, NULL, 2000, '20.00', '180.00', 8, 'products/7DSMBTvPGJgUCU6RVMwtbGrignMdHwKYsScC6RVo.webp', 1, '2026-10-12 18:43:33', '2026-10-12 19:16:17'),
(7, 3, 'Onduleur 3000 W', 'INV-3000', 'Événements, sono et mixeurs.', 3000, 230, NULL, NULL, 6000, '45.00', '400.00', 5, 'products/FuMUcNEDlrUUeiP7UySf1hSCdrXCdZGpaTBe7gdM.webp', 1, '2026-10-12 18:43:33', '2026-10-12 19:16:57'),
(8, 3, 'Onduleur 5000 W', 'INV-5000', 'Outils électroportatifs et pics de démarrage.', 5000, 230, NULL, NULL, 10000, '70.00', '650.00', 3, 'products/oUrtoV5aoyuVPwrnxsy5lv3nG1zF7iZY6clVp6Lt.webp', 1, '2026-10-12 18:43:33', '2026-10-12 19:17:31'),
(9, 4, 'Régulateur MPPT 40 A', 'MPPT-40', 'Charge solaire optimisée.', NULL, 48, NULL, NULL, NULL, '15.00', '120.00', 8, 'products/UopyeqkerYT21gtAb2955csiFZuIaneJFy7OpRFT.webp', 1, '2026-10-12 18:43:33', '2026-10-12 19:18:07'),
(10, 5, 'Kit câbles et protections', 'ACC-CABLES', 'MC4, DC, AC, disjoncteurs.', NULL, NULL, NULL, NULL, NULL, '8.00', '40.00', 15, 'products/1MEh5tmNGVaPCdhnICEIMo89q79KO08hVPxaJJzm.webp', 1, '2026-10-12 18:43:33', '2026-10-12 19:18:57'),
(11, 6, 'Groupe électrogène 3 kVA', 'GEN-3K', 'Appoint thermique si le solaire est insuffisant.', 2400, NULL, NULL, NULL, 3300, '60.00', '500.00', 2, 'products/BRZGHQVUgqbXEyVYtZ9CtDROy7X7MNKZKTuoGYgr.webp', 1, '2026-10-12 18:43:33', '2026-10-12 19:19:40');

-- --------------------------------------------------------

--
-- Table structure for table `quotes`
--

CREATE TABLE `quotes` (
  `id` bigint UNSIGNED NOT NULL,
  `project_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_energy_wh` decimal(12,2) NOT NULL,
  `energy_with_margin_wh` decimal(12,2) NOT NULL,
  `max_simultaneous_power_w` decimal(12,2) NOT NULL,
  `peak_power_w` decimal(12,2) NOT NULL,
  `recommended_battery_wh` decimal(12,2) NOT NULL,
  `recommended_battery_ah` decimal(12,2) NOT NULL,
  `battery_voltage` int UNSIGNED NOT NULL DEFAULT '48',
  `recommended_inverter_w` decimal(12,2) NOT NULL,
  `recommended_solar_w` decimal(12,2) NOT NULL,
  `recommended_pack_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quote_items`
--

CREATE TABLE `quote_items` (
  `id` bigint UNSIGNED NOT NULL,
  `quote_id` bigint UNSIGNED NOT NULL,
  `appliance_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `power_w` int UNSIGNED NOT NULL,
  `quantity` int UNSIGNED NOT NULL,
  `duration_hours` decimal(8,2) NOT NULL,
  `usage_period` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'jour',
  `has_startup_surge` tinyint(1) NOT NULL DEFAULT '0',
  `startup_power_w` int UNSIGNED DEFAULT NULL,
  `energy_wh` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `quote_id` bigint UNSIGNED DEFAULT NULL,
  `pack_id` bigint UNSIGNED DEFAULT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_required` tinyint(1) NOT NULL DEFAULT '0',
  `delivery_fee` decimal(10,2) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `estimated_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `deposit_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `customer_message` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservation_products`
--

CREATE TABLE `reservation_products` (
  `id` bigint UNSIGNED NOT NULL,
  `reservation_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `quantity` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'company_name', 'WattLoc', '2026-10-12 18:43:33', '2026-10-12 18:43:33'),
(2, 'whatsapp_number', '21623119627', '2026-10-12 18:43:33', '2026-10-12 18:43:33'),
(3, 'default_system_efficiency', '0.85', '2026-10-12 18:43:33', '2026-10-12 18:43:33'),
(4, 'default_energy_margin', '1.20', '2026-10-12 18:43:33', '2026-10-12 18:43:33'),
(5, 'default_solar_hours', '4.5', '2026-10-12 18:43:33', '2026-10-12 18:43:33'),
(6, 'default_inverter_factor', '1.25', '2026-10-12 18:43:33', '2026-10-12 18:43:33'),
(7, 'default_lithium_dod', '0.80', '2026-10-12 18:43:33', '2026-10-12 18:43:33'),
(8, 'default_lead_dod', '0.50', '2026-10-12 18:43:33', '2026-10-12 18:43:33'),
(9, 'default_battery_voltage', '48', '2026-10-12 18:43:33', '2026-10-12 18:43:33'),
(10, 'delivery_fee', '30', '2026-10-12 18:43:33', '2026-10-12 18:43:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrateur WattLoc', 'admin@wattloc.test', '20000000', NULL, '$2y$12$WJC9L6d0pe6xsDH12z0CSOAef5P8sV1XTT4cCH5xv.edyzU3zAe1O', 'admin', 1, NULL, '2026-10-12 18:43:33', '2026-10-12 18:43:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appliances`
--
ALTER TABLE `appliances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `availabilities`
--
ALTER TABLE `availabilities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `availabilities_pack_id_date_unique` (`pack_id`,`date`),
  ADD KEY `availabilities_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

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
-- Indexes for table `packs`
--
ALTER TABLE `packs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pack_products`
--
ALTER TABLE `pack_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pack_products_pack_id_product_id_unique` (`pack_id`,`product_id`),
  ADD KEY `pack_products_product_id_foreign` (`product_id`);

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
  ADD UNIQUE KEY `products_reference_unique` (`reference`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `quotes`
--
ALTER TABLE `quotes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotes_recommended_pack_id_foreign` (`recommended_pack_id`);

--
-- Indexes for table `quote_items`
--
ALTER TABLE `quote_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quote_items_quote_id_foreign` (`quote_id`),
  ADD KEY `quote_items_appliance_id_foreign` (`appliance_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservations_user_id_foreign` (`user_id`),
  ADD KEY `reservations_quote_id_foreign` (`quote_id`),
  ADD KEY `reservations_pack_id_foreign` (`pack_id`);

--
-- Indexes for table `reservation_products`
--
ALTER TABLE `reservation_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservation_products_reservation_id_foreign` (`reservation_id`),
  ADD KEY `reservation_products_product_id_foreign` (`product_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

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
-- AUTO_INCREMENT for table `appliances`
--
ALTER TABLE `appliances`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `availabilities`
--
ALTER TABLE `availabilities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `packs`
--
ALTER TABLE `packs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pack_products`
--
ALTER TABLE `pack_products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `quotes`
--
ALTER TABLE `quotes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quote_items`
--
ALTER TABLE `quote_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservation_products`
--
ALTER TABLE `reservation_products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `availabilities`
--
ALTER TABLE `availabilities`
  ADD CONSTRAINT `availabilities_pack_id_foreign` FOREIGN KEY (`pack_id`) REFERENCES `packs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `availabilities_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pack_products`
--
ALTER TABLE `pack_products`
  ADD CONSTRAINT `pack_products_pack_id_foreign` FOREIGN KEY (`pack_id`) REFERENCES `packs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pack_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quotes`
--
ALTER TABLE `quotes`
  ADD CONSTRAINT `quotes_recommended_pack_id_foreign` FOREIGN KEY (`recommended_pack_id`) REFERENCES `packs` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `quote_items`
--
ALTER TABLE `quote_items`
  ADD CONSTRAINT `quote_items_appliance_id_foreign` FOREIGN KEY (`appliance_id`) REFERENCES `appliances` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `quote_items_quote_id_foreign` FOREIGN KEY (`quote_id`) REFERENCES `quotes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_pack_id_foreign` FOREIGN KEY (`pack_id`) REFERENCES `packs` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reservations_quote_id_foreign` FOREIGN KEY (`quote_id`) REFERENCES `quotes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reservations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `reservation_products`
--
ALTER TABLE `reservation_products`
  ADD CONSTRAINT `reservation_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservation_products_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
