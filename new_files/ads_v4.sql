-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 11, 2023 at 12:19 AM
-- Server version: 8.0.33-0ubuntu0.22.04.2
-- PHP Version: 8.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cocolocal`
--

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

DROP TABLE IF EXISTS `ads`;
CREATE TABLE `ads` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `category_id` int DEFAULT NULL,
  `sub_category_id` int DEFAULT NULL,
  `brand_id` int DEFAULT NULL,
  `type` enum('personal','business') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ad_condition` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(12,2) DEFAULT NULL,
  `is_negotiable` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seller_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seller_email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seller_phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` int DEFAULT NULL,
  `state_id` int DEFAULT NULL,
  `city_id` int DEFAULT NULL,
  `address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('0','1','2','3') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_plan` enum('regular','premium') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mark_ad_urgent` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `view` int DEFAULT NULL,
  `max_impression` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `latitude` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expired_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `subtitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cat1_id` int NOT NULL,
  `cat2_id` int DEFAULT NULL,
  `cat1_slugpath` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cat2_slugpath` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quan` int NOT NULL DEFAULT '1',
  `ad_count` int NOT NULL DEFAULT '1',
  `ad_condition_descr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_bid` decimal(12,2) NOT NULL DEFAULT '0.00',
  `price_reserve` decimal(12,2) DEFAULT NULL,
  `price_buynow` decimal(12,2) DEFAULT NULL,
  `price_offer_accept` int DEFAULT NULL,
  `pay_free` tinyint(1) DEFAULT NULL,
  `pay_cash` tinyint(1) DEFAULT NULL,
  `pay_bank` tinyint(1) DEFAULT NULL,
  `pay_cc` tinyint(1) DEFAULT NULL,
  `pay_trade` tinyint(1) DEFAULT NULL,
  `pay_sendinstr` tinyint(1) DEFAULT NULL,
  `auth_users_only` tinyint(1) DEFAULT NULL,
  `pickup_option` tinyint(1) NOT NULL DEFAULT '0',
  `ship_option` tinyint(1) NOT NULL DEFAULT '0',
  `prom_ad_type` int DEFAULT NULL,
  `prom_bold` tinyint(1) DEFAULT NULL,
  `prom_glow` tinyint(1) DEFAULT NULL,
  `ad_start_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ad_close_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `item_dim_h` decimal(12,2) DEFAULT NULL,
  `item_dim_l` decimal(12,2) DEFAULT NULL,
  `item_dim_w` decimal(12,2) DEFAULT NULL,
  `item_weight_kg` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`id`, `title`, `slug`, `description`, `category_id`, `sub_category_id`, `brand_id`, `type`, `ad_condition`, `model`, `price`, `is_negotiable`, `seller_name`, `seller_email`, `seller_phone`, `country_id`, `state_id`, `city_id`, `address`, `video_url`, `category_type`, `status`, `price_plan`, `mark_ad_urgent`, `view`, `max_impression`, `user_id`, `latitude`, `longitude`, `expired_at`, `created_at`, `updated_at`, `subtitle`, `cat1_id`, `cat2_id`, `cat1_slugpath`, `cat2_slugpath`, `quan`, `ad_count`, `ad_condition_descr`, `price_bid`, `price_reserve`, `price_buynow`, `price_offer_accept`, `pay_free`, `pay_cash`, `pay_bank`, `pay_cc`, `pay_trade`, `pay_sendinstr`, `auth_users_only`, `pickup_option`, `ship_option`, `prom_ad_type`, `prom_bold`, `prom_glow`, `ad_start_timestamp`, `ad_close_timestamp`, `item_dim_h`, `item_dim_l`, `item_dim_w`, `item_weight_kg`) VALUES
(1, 'A modern sedan car up for auction', 'a-modern-sedan-car-up-for-auction', '<p>This is really some days used car</p>', NULL, 2, 0, NULL, NULL, NULL, 300.00, '0', 'john doe', 'admin@demo.com', '+1902342342', 231, 3920, 42672, 'ny, 303 avenue road', '', 'auction', '1', 'regular', '0', 11, NULL, 1, '41.310050226546856', '-72.91969299316406', '2018-05-31 00:00:00', '2018-01-06 13:07:08', '2018-01-07 07:40:00', NULL, 0, NULL, '', NULL, 1, 1, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2023-07-03 22:25:56', '2023-07-03 22:25:56', NULL, NULL, NULL, NULL),
(2, '3 Storied Building', '3-storied-building', '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,</p>', NULL, 2, 0, NULL, NULL, NULL, 400.00, '0', 'john doe', 'admin@demo.com', '+1902342342', 4, 164, 6414, 'ny, 303 avenue road', '', 'auction', '1', 'regular', '0', NULL, NULL, 1, '41.31', '-72.92', '2020-12-31 00:00:00', '2018-01-07 08:33:46', '2018-01-07 08:35:19', NULL, 0, NULL, '', NULL, 1, 1, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2023-07-03 22:25:56', '2023-07-03 22:25:56', NULL, NULL, NULL, NULL),
(3, 'Range Rover', 'range-rover', '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,</p>', NULL, 4, 0, NULL, NULL, NULL, 1200.00, '0', 'john doe', 'admin@demo.com', '+1902342342', 10, 209, 6484, 'ny, 303 avenue road', '', 'auction', '1', 'regular', '0', NULL, NULL, 1, '41.31', '-72.92', '2019-11-28 00:00:00', '2018-01-07 08:48:18', '2018-01-07 08:48:26', NULL, 0, NULL, '', NULL, 1, 1, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2023-07-03 22:25:56', '2023-07-03 22:25:56', NULL, NULL, NULL, NULL),
(4, 'European Mega Mall', 'european-mega-mall', '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,</p>', NULL, 2, 0, NULL, NULL, NULL, 3000.00, '0', 'john doe', 'admin@demo.com', '+1902342342', 21, 423, 7567, 'ny, 303 avenue road', '', 'auction', '1', 'regular', '0', 3, NULL, 1, '41.31', '-72.92', '2019-02-27 00:00:00', '2018-01-07 08:51:23', '2018-01-07 13:19:26', NULL, 0, NULL, '', NULL, 1, 1, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2023-07-03 22:25:56', '2023-07-03 22:25:56', NULL, NULL, NULL, NULL),
(5, 'iPhone 7 128 GB', 'iphone-7-128-gb', '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,</p>', NULL, 3, 0, NULL, NULL, NULL, 200.00, '0', 'john doe', 'admin@demo.com', '+1902342342', 13, 245, 6555, 'ny, 303 avenue road', '', 'auction', '1', 'premium', '0', 1, NULL, 1, '41.31', '-72.92', '2022-11-30 00:00:00', '2018-01-07 08:55:55', '2018-01-07 12:06:35', NULL, 0, NULL, '', NULL, 1, 1, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2023-07-03 22:25:56', '2023-07-03 22:25:56', NULL, NULL, NULL, NULL),
(6, 'Home Tv Stand Shelves', 'home-tv-stand-shelves', '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,</p>', NULL, 3, 0, NULL, NULL, NULL, 400.00, '0', 'john doe', 'admin@demo.com', '+1902342342', 2, 75, 6022, 'ny, 303 avenue road', '', 'auction', '1', 'premium', '0', 2, NULL, 1, '41.31', '-72.92', '2019-06-20 00:00:00', '2018-01-07 09:01:49', '2018-01-07 13:23:21', NULL, 0, NULL, '', NULL, 1, 1, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2023-07-03 22:25:56', '2023-07-03 22:25:56', NULL, NULL, NULL, NULL),
(7, 'Nice Dog', 'nice-dog', '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.</p>\r\n\r\n<p>Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet.</p>\r\n\r\n<p>Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,</p>', NULL, 7, 0, NULL, NULL, NULL, 500.00, '0', 'john doe', 'admin@demo.com', '+1902342342', 32, 542, 9740, 'ny, 303 avenue road', '', 'auction', '1', 'premium', '0', 5, NULL, 1, '41.31', '-72.92', '2020-08-28 00:00:00', '2018-01-07 09:07:44', '2023-06-28 18:33:33', NULL, 0, NULL, '', NULL, 1, 1, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2023-07-03 22:25:56', '2023-07-03 22:25:56', NULL, NULL, NULL, NULL),
(8, 'Green Eyed Cats', 'green-eyed-cats', '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,</p>', NULL, 7, 0, NULL, NULL, NULL, 50.00, '0', 'john doe', 'admin@demo.com', '+1902342342', 33, 546, 9757, 'ny, 303 avenue road', 'https://www.youtube.com/watch?v=FHCy6wOJh48', 'auction', '1', 'premium', '0', 12, NULL, 1, '41.30592391484644', '-72.91402816772461', '2020-09-09 00:00:00', '2018-01-07 09:11:49', '2023-07-06 21:36:17', NULL, 0, NULL, '', NULL, 1, 1, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2023-07-03 22:25:56', '2023-07-03 22:25:56', NULL, NULL, NULL, NULL),
(9, 'Testing Auction update', 'testing-auction', '<p>this is test auctions</p>', NULL, 4, 0, NULL, NULL, NULL, 200.00, '0', 'john doe', 'admin@demo.com', '+1902342342', 2, 76, 6023, 'ny, 303 avenue road', '', 'auction', '0', 'regular', '0', NULL, NULL, 1, NULL, NULL, '2018-01-31 00:00:00', '2018-01-07 11:54:31', '2018-01-07 11:59:07', NULL, 0, NULL, '', NULL, 1, 1, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2023-07-03 22:25:56', '2023-07-03 22:25:56', NULL, NULL, NULL, NULL),
(10, 'This is testing Auction', 'this-is-testing-auction', '<p>Testing Auction Details</p>', NULL, 4, 0, NULL, NULL, NULL, 1000.00, '0', 'Muhammad Waqas', 'mwaqasiu@gmail.com', '03070210516', 101, 1, NULL, 'Testing Address', '', 'auction', '1', 'regular', '0', 2, NULL, 3, NULL, NULL, '2023-05-26 08:45:01', '2023-05-25 10:59:08', '2023-05-25 11:12:50', NULL, 0, NULL, '', NULL, 1, 1, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2023-07-03 22:25:56', '2023-07-03 22:25:56', NULL, NULL, NULL, NULL),
(11, 'Test', 'test', '<p>Test</p>', NULL, 4, 0, NULL, NULL, NULL, 500.00, '0', 'john doe', 'admin@demo.com', '123123', 1, 42, NULL, 'Home', '', 'auction', '1', 'regular', '0', 1, NULL, 1, NULL, NULL, NULL, '2023-05-26 11:24:52', '2023-05-26 11:25:02', NULL, 0, NULL, '', NULL, 1, 1, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2023-07-03 22:25:56', '2023-07-03 22:25:56', NULL, NULL, NULL, NULL),
(12, 'Test2', 'test2', '<p>Test2</p>', NULL, 3, 0, NULL, NULL, NULL, 2000.00, '0', 'john doe', 'admin@demo.com', '123123', 2, NULL, NULL, 'Home', '', 'auction', '1', 'regular', '0', 1, NULL, 1, NULL, NULL, NULL, '2023-05-26 11:26:25', '2023-05-26 11:26:36', NULL, 0, NULL, '', NULL, 1, 1, NULL, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2023-07-03 22:25:56', '2023-07-03 22:25:56', NULL, NULL, NULL, NULL),
(13, 'title', 'slug', 'description', 0, 0, 0, '', 'ad_condition', 'model', 0.00, '', 'seller_name', 'seller_email', 'seller_phone', 0, 0, 0, 'address', 'video_url', 'category_type', '', '', '', 0, 0, 0, 'latitude', 'longitude', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'subtitle', 0, 0, 'cat1_slugpath', 'cat2_slugpath', 0, 1, 'ad_condition_descr', 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0.00, 0.00, 0.00, 0.00),
(20, 'Green Eyed Cats', 'green-eyed-cats', '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,</p>', 3021, 7, 0, NULL, '1', NULL, 50.00, '0', 'john doe', 'admin@demo.com', '1902342342', 33, 546, 9757, 'ny, 303 avenue road', 'https://www.youtube.com/watch?v=FHCy6wOJh48', 'auction', '1', 'premium', '0', 12, NULL, 1, '41.30592391484644', '-72.91402816772461', '2020-09-09 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 3021, NULL, 'pets-animals/cats/cats-for-sale', NULL, 5, 1, NULL, 0.00, 25.00, 50.00, NULL, 1, 1, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
