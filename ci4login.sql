-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for ci4login
CREATE DATABASE IF NOT EXISTS `ci4login` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `ci4login`;

-- Dumping structure for table ci4login.auth_activation_attempts
CREATE TABLE IF NOT EXISTS `auth_activation_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ci4login.auth_activation_attempts: ~0 rows (approximately)

-- Dumping structure for table ci4login.auth_groups
CREATE TABLE IF NOT EXISTS `auth_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ci4login.auth_groups: ~4 rows (approximately)
INSERT INTO `auth_groups` (`id`, `name`, `description`) VALUES
	(1, 'admin', 'Site Administrator'),
	(2, 'user', 'Regular User'),
	(6, 'berqurban', 'Peserta Qurban'),
	(7, 'panitia', 'Qurban Committee');

-- Dumping structure for table ci4login.auth_groups_permissions
CREATE TABLE IF NOT EXISTS `auth_groups_permissions` (
  `group_id` int(11) unsigned NOT NULL DEFAULT 0,
  `permission_id` int(11) unsigned NOT NULL DEFAULT 0,
  KEY `auth_groups_permissions_permission_id_foreign` (`permission_id`),
  KEY `group_id_permission_id` (`group_id`,`permission_id`),
  CONSTRAINT `auth_groups_permissions_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `auth_groups_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ci4login.auth_groups_permissions: ~3 rows (approximately)
INSERT INTO `auth_groups_permissions` (`group_id`, `permission_id`) VALUES
	(1, 1),
	(1, 2),
	(2, 2);

-- Dumping structure for table ci4login.auth_groups_users
CREATE TABLE IF NOT EXISTS `auth_groups_users` (
  `group_id` int(11) unsigned NOT NULL DEFAULT 0,
  `user_id` int(11) unsigned NOT NULL DEFAULT 0,
  KEY `auth_groups_users_user_id_foreign` (`user_id`),
  KEY `group_id_user_id` (`group_id`,`user_id`),
  CONSTRAINT `auth_groups_users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ci4login.auth_groups_users: ~72 rows (approximately)
INSERT INTO `auth_groups_users` (`group_id`, `user_id`) VALUES
	(1, 17),
	(2, 28),
	(2, 29),
	(2, 30),
	(2, 31),
	(2, 32),
	(2, 33),
	(2, 34),
	(2, 35),
	(2, 36),
	(2, 37),
	(2, 38),
	(2, 39),
	(2, 40),
	(2, 41),
	(2, 42),
	(2, 43),
	(2, 44),
	(2, 45),
	(2, 46),
	(2, 47),
	(2, 48),
	(2, 49),
	(2, 50),
	(2, 51),
	(2, 52),
	(2, 53),
	(2, 54),
	(2, 55),
	(2, 56),
	(2, 57),
	(2, 58),
	(2, 59),
	(2, 60),
	(2, 61),
	(2, 62),
	(2, 63),
	(2, 64),
	(2, 65),
	(2, 66),
	(2, 67),
	(2, 68),
	(2, 69),
	(2, 70),
	(2, 71),
	(2, 72),
	(2, 73),
	(2, 74),
	(2, 75),
	(2, 76),
	(2, 77),
	(2, 78),
	(2, 79),
	(2, 80),
	(2, 81),
	(2, 82),
	(2, 83),
	(2, 84),
	(2, 85),
	(2, 86),
	(2, 87),
	(6, 28),
	(6, 29),
	(6, 30),
	(6, 31),
	(6, 32),
	(6, 33),
	(6, 34),
	(6, 35),
	(6, 36),
	(7, 37),
	(7, 38);

-- Dumping structure for table ci4login.auth_logins
CREATE TABLE IF NOT EXISTS `auth_logins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ci4login.auth_logins: ~91 rows (approximately)
INSERT INTO `auth_logins` (`id`, `ip_address`, `email`, `user_id`, `date`, `success`) VALUES
	(1, '::1', 'momoshisenju@gmail.com', 3, '2025-06-02 13:38:21', 1),
	(2, '::1', 'momoshisenju@gmail.com', 3, '2025-06-02 13:43:46', 1),
	(3, '::1', 'momoshisenju@gmail.com', 3, '2025-06-02 13:45:18', 1),
	(4, '::1', 'momoshisenju@gmail.com', 3, '2025-06-02 13:49:16', 1),
	(5, '::1', 'teguhdarmapinan@gmail.com', 4, '2025-06-02 13:59:14', 1),
	(6, '::1', 'momoshisenju@gmail.com', 3, '2025-06-02 14:04:32', 1),
	(7, '::1', 'momoshisenju@gmail.com', NULL, '2025-06-02 14:04:45', 0),
	(8, '::1', 'momoshisenju@gmail.com', 3, '2025-06-02 14:06:19', 1),
	(9, '::1', 'teguhdarmapinan@gmail.com', 4, '2025-06-02 14:11:25', 1),
	(10, '::1', 'momoshisenju@gmail.com', 3, '2025-06-02 14:21:20', 1),
	(11, '::1', 'momoshisenju@gmail.com', 3, '2025-06-03 02:11:53', 1),
	(12, '::1', 'momoshisenju@gmail.com', 3, '2025-06-03 07:40:25', 1),
	(13, '::1', 'momoshisenju@gmail.com', 3, '2025-06-03 13:03:38', 1),
	(14, '::1', 'teguh', NULL, '2025-06-17 00:47:28', 0),
	(15, '::1', 'loremipsum@gmail.com', 5, '2025-06-17 00:48:40', 1),
	(16, '::1', 'loremipsum123@gmail.com', 6, '2025-06-17 04:46:37', 1),
	(17, '::1', 'admin', NULL, '2025-06-17 04:48:12', 0),
	(18, '::1', 'momoshisenju@gmail.com', 3, '2025-06-17 04:50:02', 1),
	(19, '::1', 'loremipsum123@gmail.com', 6, '2025-06-17 04:52:36', 1),
	(20, '::1', 'momoshisenju@gmail.com', 3, '2025-06-17 04:53:30', 1),
	(21, '::1', 'momoshisenju@gmail.com', 3, '2025-06-17 05:03:26', 1),
	(22, '::1', 'momoshisenju@gmail.com', 3, '2025-06-17 06:51:24', 1),
	(23, '::1', 'momoshisenju@gmail.com', 3, '2025-06-17 06:52:35', 1),
	(24, '::1', 'momoshisenju@gmail.com', 3, '2025-06-17 06:53:48', 1),
	(25, '::1', 'loremipsum123@gmail.com', 6, '2025-06-17 07:07:03', 1),
	(26, '::1', 'momoshisenju@gmail.com', 3, '2025-06-17 07:08:11', 1),
	(27, '::1', 'loremipsum123@gmail.com', 6, '2025-06-17 07:17:50', 1),
	(28, '::1', 'loremipsum123@gmail.com', 6, '2025-06-17 07:19:22', 1),
	(29, '::1', 'loremipsum123@gmail.com', 6, '2025-06-17 09:31:42', 1),
	(30, '::1', 'momoshisenju@gmail.com', 3, '2025-06-17 09:41:56', 1),
	(31, '::1', 'loremipsum123@gmail.com', 6, '2025-06-17 09:44:44', 1),
	(32, '::1', 'loremipsum123@gmail.com', 6, '2025-06-17 09:45:05', 1),
	(33, '::1', 'momoshisenju@gmail.com', 3, '2025-06-17 09:45:33', 1),
	(34, '::1', 'loremipsum123@gmail.com', 6, '2025-06-17 09:47:09', 1),
	(35, '::1', 'momoshisenju@gmail.com', 3, '2025-06-17 09:48:07', 1),
	(36, '::1', 'loremipsum123@gmail.com', 6, '2025-06-17 09:50:35', 1),
	(37, '::1', 'loremipsum123@gmail.com', 6, '2025-06-17 09:50:54', 1),
	(38, '::1', 'momoshisenju@gmail.com', 3, '2025-06-17 09:55:05', 1),
	(39, '::1', 'loremipsum123@gmail.com', 6, '2025-06-17 09:55:21', 1),
	(40, '::1', 'momoshisenju@gmail.com', 3, '2025-06-17 09:55:32', 1),
	(41, '::1', 'warga1@gmail.com', 7, '2025-06-17 10:01:54', 1),
	(42, '::1', 'momoshisenju@gmail.com', 3, '2025-06-17 10:02:31', 1),
	(43, '::1', 'momoshisenju@gmail.com', 3, '2025-06-17 12:03:17', 1),
	(44, '::1', 'admin1@gmail.com', NULL, '2025-06-17 12:22:14', 0),
	(45, '::1', 'admin1@gmail.com', 15, '2025-06-17 12:22:22', 1),
	(46, '::1', 'admin1@gmail.com', 16, '2025-06-17 12:23:35', 1),
	(47, '::1', 'admin1@gmail.com', 16, '2025-06-17 12:24:22', 1),
	(48, '::1', 'admin1@gmail.com', 16, '2025-06-17 12:25:27', 1),
	(49, '::1', 'admin1@gmail.com', 17, '2025-06-17 12:27:02', 1),
	(50, '::1', 'warga2', NULL, '2025-06-17 12:41:42', 0),
	(51, '::1', 'admin1@gmail.com', 17, '2025-06-17 12:46:03', 1),
	(52, '::1', 'admin1@gmail.com', 17, '2025-06-17 15:42:01', 1),
	(53, '::1', 'warga01@gmail.com', 28, '2025-06-17 15:43:08', 1),
	(54, '::1', 'warga02@gmail.com', 29, '2025-06-17 15:44:01', 1),
	(55, '::1', 'warga03@gmail.com', 30, '2025-06-17 15:44:17', 1),
	(56, '::1', 'warga04@gmail.com', 31, '2025-06-17 15:44:47', 1),
	(57, '::1', 'warga05@gmail.com', 32, '2025-06-17 15:45:05', 1),
	(58, '::1', 'warga06@gmail.com', 33, '2025-06-17 15:45:22', 1),
	(59, '::1', 'warga07@gmail.com', 34, '2025-06-17 15:45:39', 1),
	(60, '::1', 'warga08@gmail.com', 35, '2025-06-17 15:45:55', 1),
	(61, '::1', 'warga09@gmail.com', 36, '2025-06-17 15:46:10', 1),
	(62, '::1', 'admin1@gmail.com', 17, '2025-06-17 15:46:28', 1),
	(63, '::1', 'admin1@gmail.com', 17, '2025-06-18 01:29:27', 1),
	(64, '::1', 'warga01@gmail.com', 28, '2025-06-18 02:09:16', 1),
	(65, '::1', 'admin1@gmail.com', 17, '2025-06-18 02:10:11', 1),
	(66, '::1', 'warga01@gmail.com', 28, '2025-06-18 02:12:35', 1),
	(67, '::1', 'admin1@gmail.com', 17, '2025-06-18 02:26:24', 1),
	(68, '::1', 'warga01@gmail.com', 28, '2025-06-18 05:18:52', 1),
	(69, '::1', 'admin1@gmail.com', 17, '2025-06-18 05:20:55', 1),
	(70, '::1', 'warga01@gmail.com', 28, '2025-06-18 05:23:50', 1),
	(71, '::1', 'admin1@gmail.com', 17, '2025-06-18 05:27:00', 1),
	(72, '::1', 'warga01@gmail.com', 28, '2025-06-18 05:39:06', 1),
	(73, '::1', 'admin1@gmail.com', 17, '2025-06-18 06:06:49', 1),
	(74, '::1', 'warga10@gmail.com', 37, '2025-06-18 06:13:17', 1),
	(75, '::1', 'admin1@gmail.com', 17, '2025-06-18 06:19:12', 1),
	(76, '::1', 'warga10@gmail.com', 37, '2025-06-18 06:22:51', 1),
	(77, '::1', 'admin1@gmail.com', 17, '2025-06-18 06:25:16', 1),
	(78, '::1', 'warga10@gmail.com', 37, '2025-06-18 06:27:47', 1),
	(79, '::1', 'warga01', NULL, '2025-06-18 06:35:18', 0),
	(80, '::1', 'warga01@gmail.com', 28, '2025-06-18 06:35:27', 1),
	(81, '::1', 'warga10@gmail.com', 37, '2025-06-18 06:46:00', 1),
	(82, '::1', 'admin1@gmail.com', 17, '2025-06-18 06:46:35', 1),
	(83, '::1', 'warga10@gmail.com', 37, '2025-06-18 06:55:57', 1),
	(84, '::1', 'admin1@gmail.com', 17, '2025-06-18 06:56:52', 1),
	(85, '::1', 'warga10@gmail.com', 37, '2025-06-18 06:58:29', 1),
	(86, '::1', 'admin1@gmail.com', 17, '2025-06-18 07:04:59', 1),
	(87, '::1', 'admin1@gmail.com', 17, '2025-06-18 07:06:30', 1),
	(88, '::1', 'warga10@gmail.com', 37, '2025-06-18 07:09:15', 1),
	(89, '::1', 'warga01@gmail.com', 28, '2025-06-18 07:09:34', 1),
	(90, '::1', 'warga10@gmail.com', 37, '2025-06-18 07:10:03', 1),
	(91, '::1', 'admin1@gmail.com', 17, '2025-06-18 20:47:38', 1),
	(92, '::1', 'warga01@gmail.com', 28, '2025-06-18 23:19:59', 1),
	(93, '::1', 'admin1@gmail.com', 17, '2025-06-18 23:24:37', 1),
	(94, '::1', 'admin1@gmail.com', 17, '2025-06-18 23:27:28', 1),
	(95, '::1', 'admin1@gmail.com', 17, '2025-06-18 23:32:57', 1),
	(96, '::1', 'admin1@gmail.com', 17, '2025-06-18 23:34:11', 1),
	(97, '::1', 'warga01@gmail.com', 28, '2025-06-18 23:34:29', 1),
	(98, '::1', 'warga01@gmail.com', 28, '2025-06-19 00:30:50', 1),
	(99, '::1', 'admin1', NULL, '2025-06-19 01:03:24', 0),
	(100, '::1', 'admin1@gmail.com', 17, '2025-06-19 01:03:33', 1),
	(101, '::1', 'admin1@gmail.com', 17, '2025-06-19 01:04:46', 1);

-- Dumping structure for table ci4login.auth_permissions
CREATE TABLE IF NOT EXISTS `auth_permissions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ci4login.auth_permissions: ~2 rows (approximately)
INSERT INTO `auth_permissions` (`id`, `name`, `description`) VALUES
	(1, 'manage-users', 'Manage All Users'),
	(2, 'manage-profile', 'Manage user\'s profile');

-- Dumping structure for table ci4login.auth_reset_attempts
CREATE TABLE IF NOT EXISTS `auth_reset_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ci4login.auth_reset_attempts: ~0 rows (approximately)

-- Dumping structure for table ci4login.auth_tokens
CREATE TABLE IF NOT EXISTS `auth_tokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `expires` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `auth_tokens_user_id_foreign` (`user_id`),
  KEY `selector` (`selector`),
  CONSTRAINT `auth_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ci4login.auth_tokens: ~0 rows (approximately)

-- Dumping structure for table ci4login.auth_users_permissions
CREATE TABLE IF NOT EXISTS `auth_users_permissions` (
  `user_id` int(11) unsigned NOT NULL DEFAULT 0,
  `permission_id` int(11) unsigned NOT NULL DEFAULT 0,
  KEY `auth_users_permissions_permission_id_foreign` (`permission_id`),
  KEY `user_id_permission_id` (`user_id`,`permission_id`),
  CONSTRAINT `auth_users_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `auth_users_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ci4login.auth_users_permissions: ~0 rows (approximately)

-- Dumping structure for table ci4login.ci_sessions
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT 0,
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ci4login.ci_sessions: ~0 rows (approximately)

-- Dumping structure for table ci4login.iuran_peserta
CREATE TABLE IF NOT EXISTS `iuran_peserta` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `jenis_iuran` enum('kambing','sapi','administrasi_kambing','administrasi_sapi') DEFAULT NULL,
  `jumlah_iuran` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tanggal_bayar` datetime DEFAULT NULL,
  `status_bayar` enum('lunas','belum') NOT NULL DEFAULT 'belum',
  `keterangan` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `iuran_peserta_user_id_foreign` (`user_id`),
  CONSTRAINT `iuran_peserta_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ci4login.iuran_peserta: ~0 rows (approximately)

-- Dumping structure for table ci4login.keuangan
CREATE TABLE IF NOT EXISTS `keuangan` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `jenis_transaksi` enum('masuk','keluar') NOT NULL DEFAULT 'masuk',
  `deskripsi` text DEFAULT NULL,
  `jumlah` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tanggal_transaksi` datetime DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `keuangan_user_id_foreign` (`user_id`),
  CONSTRAINT `keuangan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ci4login.keuangan: ~0 rows (approximately)

-- Dumping structure for table ci4login.meat_distribution
CREATE TABLE IF NOT EXISTS `meat_distribution` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `recipient_user_id` int(11) unsigned NOT NULL,
  `meat_weight_kambing` decimal(10,2) NOT NULL,
  `meat_weight_sapi` decimal(10,2) NOT NULL,
  `distribution_date` datetime NOT NULL,
  `status` enum('pending','distributed') NOT NULL DEFAULT 'pending',
  `qr_code` varchar(255) DEFAULT NULL,
  `collected_at` datetime DEFAULT NULL,
  `collected_by_user_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `qr_code` (`qr_code`),
  KEY `recipient_user_id` (`recipient_user_id`),
  KEY `collected_by_user_id` (`collected_by_user_id`),
  CONSTRAINT `fk_collected_by_user` FOREIGN KEY (`collected_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `fk_recipient_user` FOREIGN KEY (`recipient_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ci4login.meat_distribution: ~0 rows (approximately)

-- Dumping structure for table ci4login.meat_distribution_kambing
CREATE TABLE IF NOT EXISTS `meat_distribution_kambing` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `recipient_user_id` int(11) unsigned NOT NULL,
  `distribution_type` enum('warga','berqurban','panitia') NOT NULL,
  `meat_weight` decimal(10,2) NOT NULL,
  `distribution_date` datetime NOT NULL,
  `status` enum('distributed','pending') NOT NULL DEFAULT 'pending',
  `qr_code` varchar(255) DEFAULT NULL,
  `qurban_animal_id` varchar(50) DEFAULT NULL,
  `collected_at` datetime DEFAULT NULL,
  `collected_by_user_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `qr_code` (`qr_code`),
  KEY `meat_distribution_kambing_recipient_user_id_foreign` (`recipient_user_id`),
  CONSTRAINT `meat_distribution_kambing_recipient_user_id_foreign` FOREIGN KEY (`recipient_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=421 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ci4login.meat_distribution_kambing: ~60 rows (approximately)
INSERT INTO `meat_distribution_kambing` (`id`, `recipient_user_id`, `distribution_type`, `meat_weight`, `distribution_date`, `status`, `qr_code`, `qurban_animal_id`, `collected_at`, `collected_by_user_id`) VALUES
	(541, 28, 'berqurban', 13.33, '2025-06-19 01:20:21', 'distributed', 'DSTR28_KAMBING_POOL_2025-06-19_685365d5d3bd4', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(542, 29, 'berqurban', 13.33, '2025-06-19 01:20:21', 'distributed', 'DSTR29_KAMBING_POOL_2025-06-19_685365d5d3be1', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(543, 30, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR30_KAMBING_POOL_2025-06-19_685365d5d460f', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(544, 31, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR31_KAMBING_POOL_2025-06-19_685365d5d4612', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(545, 32, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR32_KAMBING_POOL_2025-06-19_685365d5d4613', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(546, 33, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR33_KAMBING_POOL_2025-06-19_685365d5d4614', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(547, 34, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR34_KAMBING_POOL_2025-06-19_685365d5d4615', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(548, 35, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR35_KAMBING_POOL_2025-06-19_685365d5d4616', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(549, 36, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR36_KAMBING_POOL_2025-06-19_685365d5d4617', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(550, 37, 'panitia', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR37_KAMBING_POOL_2025-06-19_685365d5d4618', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(551, 38, 'panitia', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR38_KAMBING_POOL_2025-06-19_685365d5d4619', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(552, 39, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR39_KAMBING_POOL_2025-06-19_685365d5d461a', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(553, 40, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR40_KAMBING_POOL_2025-06-19_685365d5d461b', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(554, 41, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR41_KAMBING_POOL_2025-06-19_685365d5d461c', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(555, 42, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR42_KAMBING_POOL_2025-06-19_685365d5d461d', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(556, 43, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR43_KAMBING_POOL_2025-06-19_685365d5d461e', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(557, 44, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR44_KAMBING_POOL_2025-06-19_685365d5d461f', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(558, 45, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR45_KAMBING_POOL_2025-06-19_685365d5d4620', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(559, 46, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR46_KAMBING_POOL_2025-06-19_685365d5d4621', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(560, 47, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR47_KAMBING_POOL_2025-06-19_685365d5d4622', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(561, 48, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR48_KAMBING_POOL_2025-06-19_685365d5d4623', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(562, 49, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR49_KAMBING_POOL_2025-06-19_685365d5d4624', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(563, 50, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR50_KAMBING_POOL_2025-06-19_685365d5d4625', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(564, 51, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR51_KAMBING_POOL_2025-06-19_685365d5d4626', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(565, 52, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR52_KAMBING_POOL_2025-06-19_685365d5d4627', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(566, 53, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR53_KAMBING_POOL_2025-06-19_685365d5d4628', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(567, 54, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR54_KAMBING_POOL_2025-06-19_685365d5d4629', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(568, 55, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR55_KAMBING_POOL_2025-06-19_685365d5d462a', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(569, 56, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR56_KAMBING_POOL_2025-06-19_685365d5d462b', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(570, 57, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR57_KAMBING_POOL_2025-06-19_685365d5d462c', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(571, 58, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR58_KAMBING_POOL_2025-06-19_685365d5d462d', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(572, 59, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR59_KAMBING_POOL_2025-06-19_685365d5d462e', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(573, 60, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR60_KAMBING_POOL_2025-06-19_685365d5d462f', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(574, 61, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR61_KAMBING_POOL_2025-06-19_685365d5d4630', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(575, 62, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR62_KAMBING_POOL_2025-06-19_685365d5d4631', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(576, 63, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR63_KAMBING_POOL_2025-06-19_685365d5d4632', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(577, 64, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR64_KAMBING_POOL_2025-06-19_685365d5d4633', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(578, 65, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR65_KAMBING_POOL_2025-06-19_685365d5d4634', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(579, 66, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR66_KAMBING_POOL_2025-06-19_685365d5d4635', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(580, 67, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR67_KAMBING_POOL_2025-06-19_685365d5d4636', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(581, 68, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR68_KAMBING_POOL_2025-06-19_685365d5d4637', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(582, 69, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR69_KAMBING_POOL_2025-06-19_685365d5d4638', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(583, 70, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR70_KAMBING_POOL_2025-06-19_685365d5d4639', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(584, 71, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR71_KAMBING_POOL_2025-06-19_685365d5d463a', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(585, 72, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR72_KAMBING_POOL_2025-06-19_685365d5d463b', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(586, 73, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR73_KAMBING_POOL_2025-06-19_685365d5d463c', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(587, 74, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR74_KAMBING_POOL_2025-06-19_685365d5d463d', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(588, 75, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR75_KAMBING_POOL_2025-06-19_685365d5d463e', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(589, 76, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR76_KAMBING_POOL_2025-06-19_685365d5d463f', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(590, 77, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR77_KAMBING_POOL_2025-06-19_685365d5d4640', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(591, 78, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR78_KAMBING_POOL_2025-06-19_685365d5d4641', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(592, 79, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR79_KAMBING_POOL_2025-06-19_685365d5d4642', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(593, 80, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR80_KAMBING_POOL_2025-06-19_685365d5d4643', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(594, 81, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR81_KAMBING_POOL_2025-06-19_685365d5d4644', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(595, 82, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR82_KAMBING_POOL_2025-06-19_685365d5d4645', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(596, 83, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR83_KAMBING_POOL_2025-06-19_685365d5d4646', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(597, 84, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR84_KAMBING_POOL_2025-06-19_685365d5d4647', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(598, 85, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR85_KAMBING_POOL_2025-06-19_685365d5d4648', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(599, 86, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR86_KAMBING_POOL_2025-06-19_685365d5d4649', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17),
	(600, 87, 'warga', 0.92, '2025-06-19 01:20:21', 'distributed', 'DSTR87_KAMBING_POOL_2025-06-19_685365d5d464a', 'KAMBING_POOL_2025-06-19', '2025-06-19 01:26:51', 17);

-- Dumping structure for table ci4login.meat_distribution_sapi
CREATE TABLE IF NOT EXISTS `meat_distribution_sapi` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `recipient_user_id` int(11) unsigned NOT NULL,
  `distribution_type` enum('warga','berqurban','panitia') NOT NULL,
  `meat_weight` decimal(10,2) NOT NULL,
  `distribution_date` datetime NOT NULL,
  `status` enum('distributed','pending') NOT NULL DEFAULT 'pending',
  `qr_code` varchar(255) DEFAULT NULL,
  `qurban_animal_id` varchar(50) DEFAULT NULL,
  `collected_at` datetime DEFAULT NULL,
  `collected_by_user_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `qr_code` (`qr_code`),
  KEY `meat_distribution_sapi_recipient_user_id_foreign` (`recipient_user_id`),
  CONSTRAINT `meat_distribution_sapi_recipient_user_id_foreign` FOREIGN KEY (`recipient_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=601 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ci4login.meat_distribution_sapi: ~60 rows (approximately)
INSERT INTO `meat_distribution_sapi` (`id`, `recipient_user_id`, `distribution_type`, `meat_weight`, `distribution_date`, `status`, `qr_code`, `qurban_animal_id`, `collected_at`, `collected_by_user_id`) VALUES
	(601, 30, 'berqurban', 5.71, '2025-06-19 01:11:25', 'pending', 'DSTR30_SAPI_POOL_2025-06-19_685363bd808f6', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(602, 31, 'berqurban', 5.71, '2025-06-19 01:11:25', 'pending', 'DSTR31_SAPI_POOL_2025-06-19_685363bd808f8', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(603, 32, 'berqurban', 5.71, '2025-06-19 01:11:25', 'pending', 'DSTR32_SAPI_POOL_2025-06-19_685363bd808f9', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(604, 33, 'berqurban', 5.71, '2025-06-19 01:11:25', 'pending', 'DSTR33_SAPI_POOL_2025-06-19_685363bd808fa', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(605, 34, 'berqurban', 5.71, '2025-06-19 01:11:25', 'pending', 'DSTR34_SAPI_POOL_2025-06-19_685363bd808fb', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(606, 35, 'berqurban', 5.71, '2025-06-19 01:11:25', 'pending', 'DSTR35_SAPI_POOL_2025-06-19_685363bd808fc', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(607, 36, 'berqurban', 5.71, '2025-06-19 01:11:25', 'pending', 'DSTR36_SAPI_POOL_2025-06-19_685363bd80910', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(608, 28, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR28_SAPI_POOL_2025-06-19_685363bd814dc', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(609, 29, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR29_SAPI_POOL_2025-06-19_685363bd814de', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(610, 37, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR37_SAPI_POOL_2025-06-19_685363bd814e0', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(611, 38, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR38_SAPI_POOL_2025-06-19_685363bd814e1', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(612, 39, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR39_SAPI_POOL_2025-06-19_685363bd814e2', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(613, 40, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR40_SAPI_POOL_2025-06-19_685363bd814e3', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(614, 41, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR41_SAPI_POOL_2025-06-19_685363bd814e4', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(615, 42, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR42_SAPI_POOL_2025-06-19_685363bd814e5', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(616, 43, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR43_SAPI_POOL_2025-06-19_685363bd814e6', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(617, 44, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR44_SAPI_POOL_2025-06-19_685363bd814e7', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(618, 45, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR45_SAPI_POOL_2025-06-19_685363bd814e8', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(619, 46, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR46_SAPI_POOL_2025-06-19_685363bd814e9', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(620, 47, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR47_SAPI_POOL_2025-06-19_685363bd814ea', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(621, 48, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR48_SAPI_POOL_2025-06-19_685363bd814eb', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(622, 49, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR49_SAPI_POOL_2025-06-19_685363bd814ec', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(623, 50, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR50_SAPI_POOL_2025-06-19_685363bd814ed', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(624, 51, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR51_SAPI_POOL_2025-06-19_685363bd814ee', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(625, 52, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR52_SAPI_POOL_2025-06-19_685363bd814ef', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(626, 53, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR53_SAPI_POOL_2025-06-19_685363bd814f0', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(627, 54, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR54_SAPI_POOL_2025-06-19_685363bd814f1', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(628, 55, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR55_SAPI_POOL_2025-06-19_685363bd814f2', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(629, 56, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR56_SAPI_POOL_2025-06-19_685363bd814f3', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(630, 57, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR57_SAPI_POOL_2025-06-19_685363bd814f4', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(631, 58, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR58_SAPI_POOL_2025-06-19_685363bd814f5', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(632, 59, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR59_SAPI_POOL_2025-06-19_685363bd814f6', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(633, 60, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR60_SAPI_POOL_2025-06-19_685363bd814f7', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(634, 61, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR61_SAPI_POOL_2025-06-19_685363bd814f8', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(635, 62, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR62_SAPI_POOL_2025-06-19_685363bd814f9', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(636, 63, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR63_SAPI_POOL_2025-06-19_685363bd814fa', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(637, 64, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR64_SAPI_POOL_2025-06-19_685363bd814fb', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(638, 65, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR65_SAPI_POOL_2025-06-19_685363bd814fc', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(639, 66, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR66_SAPI_POOL_2025-06-19_685363bd814fd', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(640, 67, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR67_SAPI_POOL_2025-06-19_685363bd814fe', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(641, 68, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR68_SAPI_POOL_2025-06-19_685363bd814ff', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(642, 69, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR69_SAPI_POOL_2025-06-19_685363bd81500', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(643, 70, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR70_SAPI_POOL_2025-06-19_685363bd81501', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(644, 71, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR71_SAPI_POOL_2025-06-19_685363bd81502', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(645, 72, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR72_SAPI_POOL_2025-06-19_685363bd81503', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(646, 73, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR73_SAPI_POOL_2025-06-19_685363bd81504', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(647, 74, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR74_SAPI_POOL_2025-06-19_685363bd81505', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(648, 75, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR75_SAPI_POOL_2025-06-19_685363bd81506', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(649, 76, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR76_SAPI_POOL_2025-06-19_685363bd81507', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(650, 77, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR77_SAPI_POOL_2025-06-19_685363bd81508', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(651, 78, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR78_SAPI_POOL_2025-06-19_685363bd81509', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(652, 79, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR79_SAPI_POOL_2025-06-19_685363bd8150a', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(653, 80, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR80_SAPI_POOL_2025-06-19_685363bd8150b', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(654, 81, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR81_SAPI_POOL_2025-06-19_685363bd8150c', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(655, 82, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR82_SAPI_POOL_2025-06-19_685363bd8150d', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(656, 83, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR83_SAPI_POOL_2025-06-19_685363bd8150e', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(657, 84, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR84_SAPI_POOL_2025-06-19_685363bd8150f', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(658, 85, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR85_SAPI_POOL_2025-06-19_685363bd81510', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(659, 86, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR86_SAPI_POOL_2025-06-19_685363bd81511', 'SAPI_POOL_2025-06-19', NULL, NULL),
	(660, 87, 'warga', 1.51, '2025-06-19 01:11:25', 'pending', 'DSTR87_SAPI_POOL_2025-06-19_685363bd81512', 'SAPI_POOL_2025-06-19', NULL, NULL);

-- Dumping structure for table ci4login.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ci4login.migrations: ~14 rows (approximately)
INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
	(1, '2017-11-20-223112', 'Myth\\Auth\\Database\\Migrations\\CreateAuthTables', 'default', 'Myth\\Auth', 1748819164, 1),
	(2, '2017-11-20-223112', 'App\\Database\\Migrations\\CreateAuthTables', 'default', 'App', 1750128261, 2),
	(3, '2025-06-17-024225', 'App\\Database\\Migrations\\CreateKeuangan', 'default', 'App', 1750128261, 2),
	(4, '2025-06-17-024302', 'App\\Database\\Migrations\\CreateIuranPeserta', 'default', 'App', 1750128261, 2),
	(5, '2025-06-17-070239', 'App\\Database\\Migrations\\AddQurbanGroupAndAmountPaidToQurbanParticipants', 'default', 'App', 1750143787, 3),
	(6, '2025-06-17-070245', 'App\\Database\\Migrations\\AddQurbanAnimalIdToMeatDistribution', 'default', 'App', 1750143787, 3),
	(7, '2025-06-17-070245', 'App\\Database\\Migrations\\AddAnimalTagToQurbanParticipants', 'default', 'App', 1750185792, 4),
	(8, '2025-06-17-184243', 'App\\Database\\Migrations\\AddAnimalTagToQurbanParticipants', 'default', 'App', 1750188660, 5),
	(9, '2025-06-17-193011', 'App\\Database\\Migrations\\RestructureMeatDistributionTable', 'default', 'App', 1750188660, 5),
	(10, '2025-06-17-194934', 'App\\Database\\Migrations\\RemoveAnimalTypeFromMeatDistribution', 'default', 'App', 1750189846, 6),
	(11, '2025-06-17-202441', 'App\\Database\\Migrations\\CreateSeparateDistributionTables', 'default', 'App', 1750191922, 7),
	(12, '2025-06-17-210422', 'App\\Database\\Migrations\\FinalizeMeatDistributionSchema', 'default', 'App', 1750194288, 8),
	(13, '2025-06-18-021928', 'App\\Database\\Migrations\\AddAdminFeeToQurbanParticipants', 'default', 'App', 1750213206, 9),
	(14, '2025-06-18-024001', 'App\\Database\\Migrations\\ReworkTransactionsTable', 'default', 'App', 1750214427, 10);

-- Dumping structure for table ci4login.qurban_participants
CREATE TABLE IF NOT EXISTS `qurban_participants` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `animal_type` enum('kambing','sapi') NOT NULL,
  `share_number` int(11) DEFAULT NULL,
  `qurban_group` varchar(50) DEFAULT NULL,
  `animal_tag` varchar(50) DEFAULT NULL,
  `payment_status` enum('paid','unpaid') NOT NULL DEFAULT 'unpaid',
  `amount_paid` decimal(10,2) DEFAULT 0.00,
  `amount_paid_admin` decimal(10,2) DEFAULT 0.00,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `animal_tag` (`animal_tag`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `qurban_participants_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ci4login.qurban_participants: ~9 rows (approximately)
INSERT INTO `qurban_participants` (`id`, `user_id`, `animal_type`, `share_number`, `qurban_group`, `animal_tag`, `payment_status`, `amount_paid`, `amount_paid_admin`, `created_at`, `updated_at`) VALUES
	(33, 28, 'kambing', NULL, NULL, NULL, 'paid', 2700000.00, 50000.00, '2025-06-19 01:04:57', '2025-06-19 01:04:57'),
	(34, 29, 'kambing', NULL, NULL, NULL, 'paid', 2700000.00, 50000.00, '2025-06-19 01:05:14', '2025-06-19 01:05:14'),
	(35, 30, 'sapi', 1, 'Sapi A', NULL, 'paid', 3000000.00, 100000.00, '2025-06-19 01:05:25', '2025-06-19 01:05:25'),
	(36, 31, 'sapi', 1, 'Sapi A', NULL, 'paid', 3000000.00, 100000.00, '2025-06-19 01:05:33', '2025-06-19 01:05:33'),
	(37, 32, 'sapi', 1, 'Sapi A', NULL, 'paid', 3000000.00, 100000.00, '2025-06-19 01:05:43', '2025-06-19 01:05:43'),
	(38, 33, 'sapi', 1, 'Sapi A', NULL, 'paid', 3000000.00, 100000.00, '2025-06-19 01:05:52', '2025-06-19 01:05:52'),
	(39, 34, 'sapi', 1, 'Sapi A', NULL, 'paid', 3000000.00, 100000.00, '2025-06-19 01:06:25', '2025-06-19 01:06:25'),
	(40, 35, 'sapi', 1, 'Sapi A', NULL, 'paid', 3000000.00, 100000.00, '2025-06-19 01:06:48', '2025-06-19 01:06:48'),
	(41, 36, 'sapi', 1, 'Sapi A', NULL, 'paid', 3000000.00, 100000.00, '2025-06-19 01:07:03', '2025-06-19 01:07:03');

-- Dumping structure for table ci4login.transactions
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `amount` decimal(10,2) NOT NULL,
  `description` varchar(255) NOT NULL,
  `related_user_id` int(11) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `related_user_id` (`related_user_id`),
  CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`related_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ci4login.transactions: ~6 rows (approximately)
INSERT INTO `transactions` (`id`, `amount`, `description`, `related_user_id`, `created_at`) VALUES
	(40, 180000.00, 'Golok', 17, '2025-06-19 01:08:55'),
	(41, 60000.00, 'Tambang', 17, '2025-06-19 01:09:06'),
	(42, 80000.00, 'Terpal', 17, '2025-06-19 01:09:19'),
	(43, 180000.00, 'Timbangan', 17, '2025-06-19 01:09:27'),
	(46, 20000.00, 'Tali rafia dan plastik', 17, '2025-06-19 01:28:51'),
	(48, 80000.00, 'Konsumsi Panitia (Untuk pemotongan daging qurban, panitia mendapatkan shodaqoh langsung dari masjid)', 17, '2025-06-19 01:30:07');

-- Dumping structure for table ci4login.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `user_image` varchar(255) NOT NULL DEFAULT 'default.svg',
  `password_hash` varchar(255) NOT NULL,
  `reset_hash` varchar(255) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `activate_hash` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `force_pass_reset` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`),
  KEY `idx_users_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table ci4login.users: ~61 rows (approximately)
INSERT INTO `users` (`id`, `email`, `username`, `fullname`, `user_image`, `password_hash`, `reset_hash`, `reset_at`, `reset_expires`, `activate_hash`, `status`, `status_message`, `active`, `force_pass_reset`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(17, 'admin1@gmail.com', 'admin1', NULL, 'default.svg', '$2y$10$tf3sDgVcJpw5fT4QvJQZMOvjNxnDHKgk/2lj5I3ar42AZRVYa76Iy', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 12:26:38', '2025-06-17 12:26:38', NULL),
	(28, 'warga01@gmail.com', 'warga01', NULL, 'default.svg', '$2y$10$lBugoOYSjiPsJjlJQMwWYeZywyu5q/EMVgN/18vwTsWWWk4rkiEiC', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 13:35:08', '2025-06-17 13:35:08', NULL),
	(29, 'warga02@gmail.com', 'warga02', NULL, 'default.svg', '$2y$10$i1t6J6Ex.ayPNjc8ITkWT.p5eTBLX1nz/fjaj5c6.gn5CE.XtdvFi', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 13:51:35', '2025-06-17 13:51:35', NULL),
	(30, 'warga03@gmail.com', 'warga03', NULL, 'default.svg', '$2y$10$KgFGeyOVtgmpmaj6//7/m.nzp2pDb3Bx0aZanybP9r0Tq5FEYG9be', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 13:51:49', '2025-06-17 13:51:49', NULL),
	(31, 'warga04@gmail.com', 'warga04', NULL, 'default.svg', '$2y$10$S.lRZXQ6D02BgdqJgJw/Hu3UfTamck.SEK0VtOTHPZSX5q.Y/m8du', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 13:52:03', '2025-06-17 13:52:03', NULL),
	(32, 'warga05@gmail.com', 'warga05', NULL, 'default.svg', '$2y$10$XvcUFw1r91/fJJ.ymNAF3uP8VMdZKj1AlmM8FmIqZVja7GLzBbTly', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 13:52:14', '2025-06-17 13:52:14', NULL),
	(33, 'warga06@gmail.com', 'warga06', NULL, 'default.svg', '$2y$10$obCrgjuzaxF9YTFGKEmJcevJPBRtva3iBDDB1KQ60iMBpxcww780y', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 13:52:30', '2025-06-17 13:52:30', NULL),
	(34, 'warga07@gmail.com', 'warga07', NULL, 'default.svg', '$2y$10$9FZnvg8fa/uaVwZlmu2oB.kBLr55eXEs.L3UxOxSp09Z16AgKpfrm', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 13:52:44', '2025-06-17 13:52:44', NULL),
	(35, 'warga08@gmail.com', 'warga08', NULL, 'default.svg', '$2y$10$lkK0lpU4Uw42yCr2vD5S7OuxWAoNopmvPsdx4ZyFOhv2rmZWmvKG.', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 13:52:54', '2025-06-17 13:52:54', NULL),
	(36, 'warga09@gmail.com', 'warga09', NULL, 'default.svg', '$2y$10$kq54tnH6a/0SVaGNsy6OzO76e8AbK/aeX/nBSmdaMoujxCoXAUG4u', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 13:53:06', '2025-06-17 13:53:06', NULL),
	(37, 'warga10@gmail.com', 'warga10', NULL, 'default.svg', '$2y$10$L1wammIOtMSEMpYkjK7UluvMEYwWsxACyYcK47Gp6kBAaPrQbcSw.', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 13:53:37', '2025-06-17 13:53:37', NULL),
	(38, 'warga11@gmail.com', 'warga11', NULL, 'default.svg', '$2y$10$Pg6vpsnS4bvOTKKP/lCuTOvcr9w/KtIPf6YNmhLQhXPlzuh5DijGu', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 13:53:47', '2025-06-17 13:53:47', NULL),
	(39, 'warga12@gmail.com', 'warga12', NULL, 'default.svg', '$2y$10$clbpnuYfNbkaKTv0UfdnoOZ3CWCSibZ7K33qJY6pYSH3q2KGzJfka', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 13:59:59', '2025-06-17 13:59:59', NULL),
	(40, 'warga13@gmail.com', 'warga13', NULL, 'default.svg', '$2y$10$RmxdjL3K17j0F/v7fiH9p.xFFNl63ImWOcCoqNnvGDW1r4lk7wuMC', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 14:00:13', '2025-06-17 14:00:13', NULL),
	(41, 'warga14@gmail.com', 'warga14', NULL, 'default.svg', '$2y$10$LdpMPU0kBk9v8ky/UyPd3OdNcgZNJ5byGrT0k/y9vsiLtqM80.mdS', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 14:00:28', '2025-06-17 14:00:28', NULL),
	(42, 'warga15@gmail.com', 'warga15', NULL, 'default.svg', '$2y$10$R049rNLdxjtbN0our/fQzu8/uyj1JrVMOY533LDBXR.bSamTwhjRW', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 14:00:41', '2025-06-17 14:00:41', NULL),
	(43, 'warga16@gmail.com', 'warga16', NULL, 'default.svg', '$2y$10$xoYJYUtuQjb3HOvibSEXau4f3i0kZDAL5lxvso5PbbwLsdhNgajPa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 14:00:54', '2025-06-17 14:00:54', NULL),
	(44, 'warga17@gmail.com', 'warga17', NULL, 'default.svg', '$2y$10$UW6OEYduYzWKHQlJGo9PV.QahLR05K2fhJ0qi/dhAMa.tsso4WosS', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 14:02:37', '2025-06-17 14:02:37', NULL),
	(45, 'warga18@gmail.com', 'warga18', NULL, 'default.svg', '$2y$10$jxpgOQhfAi8Zd3gnDuhGDOu7FKKzkMwbl/iPdYFWEIaNSF.YEXeNW', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 14:02:50', '2025-06-17 14:02:50', NULL),
	(46, 'warga19@gmail.com', 'warga19', NULL, 'default.svg', '$2y$10$a1ChBMrhzQ8XExTdRjtVw.EPqdWK4IxFFuZ6spCSu7TNqn6t3Y1cu', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 14:03:20', '2025-06-17 14:03:20', NULL),
	(47, 'warga20@gmail.com', 'warga20', NULL, 'default.svg', '$2y$10$03AYFdb0D.w7T1WcZIZk0.iLYV3Khs5Cf2480.aWUcpNhGh1CwDDW', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 14:03:35', '2025-06-17 14:03:35', NULL),
	(48, 'warga21@gmail.com', 'warga21', NULL, 'default.svg', '$2y$10$1zzh84oLVdGr9FzfME2bUO5P5/pTtRhUsuPdms5wP6xvCjrcTq4Qi', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:32:06', '2025-06-17 15:32:06', NULL),
	(49, 'warga22@gmail.com', 'warga22', NULL, 'default.svg', '$2y$10$ObxsPoVsij1Ce6QtyOyV7e1ggwpa4CbEEg6r3/UB6AJ9lWc3IocEm', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:32:20', '2025-06-17 15:32:20', NULL),
	(50, 'warga23@gmail.com', 'warga23', NULL, 'default.svg', '$2y$10$Aumbt8mtDUpnF59C0ykC4ODyFZICHV2iB2qOP1SmE1UdUXoofsrNq', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:32:32', '2025-06-17 15:32:32', NULL),
	(51, 'warga24@gmail.com', 'warga24', NULL, 'default.svg', '$2y$10$nt7fJIkbrqUJLp0qCs4Pbuc2FYFDqRTW76mZPr7ezZUS8w8VAkU1G', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:32:50', '2025-06-17 15:32:50', NULL),
	(52, 'warga25@gmail.com', 'warga25', NULL, 'default.svg', '$2y$10$bish1P57YcxJh2tWxoBwyOW4UV2ubS8Fzp/aDaJee7f6HIq4vFEke', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:33:07', '2025-06-17 15:33:07', NULL),
	(53, 'warga26@gmail.com', 'warga26', NULL, 'default.svg', '$2y$10$w2zN0MvTnBnG0Ee3XHYQV..fnGbVDCyiPFYC37OI8U0PJ6Ad9xdbO', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:33:28', '2025-06-17 15:33:28', NULL),
	(54, 'warga27@gmail.com', 'warga27', NULL, 'default.svg', '$2y$10$3H9E9FBjLq9r1LmUbU7q9etrxWmBDUyz/C/XKK8fe8Sujr0eBM6mC', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:33:47', '2025-06-17 15:33:47', NULL),
	(55, 'warga28@gmail.com', 'warga28', NULL, 'default.svg', '$2y$10$.rE6ag6i9b4uW/nZpN73ju6MJstNlYksCKp86ZH1AZOx0PWqiyJ5K', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:34:02', '2025-06-17 15:34:02', NULL),
	(56, 'warga29@gmail.com', 'warga29', NULL, 'default.svg', '$2y$10$j9WTPgmElmF/35MvyJXVT.LEpOPWUqAs5GHzESWu6gm36pyWmYX66', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:34:17', '2025-06-17 15:34:17', NULL),
	(57, 'warga30@gmail.com', 'warga30', NULL, 'default.svg', '$2y$10$pIVZPBoF7Ix/hIeRH1AmBebHbvLeWrYYcoC8axf.p5Y4ip51pgqVq', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:34:33', '2025-06-17 15:34:33', NULL),
	(58, 'warga31@gmail.com', 'warga31', NULL, 'default.svg', '$2y$10$jwLi2RWSrqpEpH83QGy8OOaQ5vmg/fehDDLMw4tCnpsIKOERufYrq', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:34:46', '2025-06-17 15:34:46', NULL),
	(59, 'warga32@gmail.com', 'warga32', NULL, 'default.svg', '$2y$10$ffOryUztr9Z8qmp8HWNQ7O8qgXSiVtsOSQadDSeAPzFMcQsKGohbK', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:34:59', '2025-06-17 15:34:59', NULL),
	(60, 'warga33@gmail.com', 'warga33', NULL, 'default.svg', '$2y$10$3uA0DbhffoUElznc0oBXU.9UlWLdpEiNzboC8iYBDfROLWopTltK.', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:35:13', '2025-06-17 15:35:13', NULL),
	(61, 'warga34@gmail.com', 'warga34', NULL, 'default.svg', '$2y$10$EvX1NMJIGKkSey9G4aetuOLjKxxjci69zp6hRUd2prLpCG7ysdSoO', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:35:25', '2025-06-17 15:35:25', NULL),
	(62, 'warga35@gmail.com', 'warga35', NULL, 'default.svg', '$2y$10$2QAOnPACb0nZ6i3NHQ3F1el6oKlFJXMSyBnx4.ZB5WI0uLjlR5kxC', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:35:39', '2025-06-17 15:35:39', NULL),
	(63, 'warga36@gmail.com', 'warga36', NULL, 'default.svg', '$2y$10$e10KQ//RWEeuktC7bRjLie8yh159cAFDtCBm2jVf1jvz1jhNWmnKC', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:35:53', '2025-06-17 15:35:53', NULL),
	(64, 'warga37@gmail.com', 'warga37', NULL, 'default.svg', '$2y$10$pE2uTJANkqcFg4753/XsreacjDFgYcYMsGUU1jvrxvUFGk/lOQtQe', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:36:05', '2025-06-17 15:36:05', NULL),
	(65, 'warga38@gmail.com', 'warga38', NULL, 'default.svg', '$2y$10$QKF70f7m8gBfjyqnFDOS0Ob7ESTJhStCERw0oPVpetrIKMj.3uauu', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:36:42', '2025-06-17 15:36:42', NULL),
	(66, 'warga39@gmail.com', 'warga39', NULL, 'default.svg', '$2y$10$OzE5APmLDIbwYuN3Jc2WTu9aPdjlQwanfMvMGVS2mWqd0KpB.Z3.K', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:37:01', '2025-06-17 15:37:01', NULL),
	(67, 'warga40@gmail.com', 'warga40', NULL, 'default.svg', '$2y$10$PCMZv6ke59GK0iLuVi8Ew.SLTRqZ/9Bp5oreDJvA8qgW5wjM8948y', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:37:13', '2025-06-17 15:37:13', NULL),
	(68, 'warga41@gmail.com', 'warga41', NULL, 'default.svg', '$2y$10$PqHEk7H0zmFFrlk6Ynqo.OMOm53dq8hozYtxbtoGMpO8S51Qeq20i', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:37:24', '2025-06-17 15:37:24', NULL),
	(69, 'warga42@gmail.com', 'warga42', NULL, 'default.svg', '$2y$10$pN.YTXRpJi0x9SOQeMbI6OvCtMleDQzSBsPeCzxPJf6rYvkiMwQ/C', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:37:34', '2025-06-17 15:37:34', NULL),
	(70, 'warga43@gmail.com', 'warga43', NULL, 'default.svg', '$2y$10$cG1jUTVkDk8yrJ9Zs8MQjuN7JYo16619J1Ghvxw4voWQfek5ZDgli', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:37:45', '2025-06-17 15:37:45', NULL),
	(71, 'warga44@gmail.com', 'warga44', NULL, 'default.svg', '$2y$10$DvNKAsyQZqYppnqZMGiKVuOCH16f29ajGsiWgKDd1Tt5NdJmG2O0C', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:37:56', '2025-06-17 15:37:56', NULL),
	(72, 'warga45@gmail.com', 'warga45', NULL, 'default.svg', '$2y$10$Z4EYHA4BDnjddqTJo0hu5ejjG2PI9FexZ67Y6FhpQ4cIHmykBtdV2', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:38:08', '2025-06-17 15:38:08', NULL),
	(73, 'warga46@gmail.com', 'warga46', NULL, 'default.svg', '$2y$10$94Cx3UdKNRqH0dXWiuFxieHI5UQD9bSaRz7LQtQ0juRlujaYvlIAW', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:38:21', '2025-06-17 15:38:21', NULL),
	(74, 'warga47@gmail.com', 'warga47', NULL, 'default.svg', '$2y$10$BYqs/2mx8efoqkbZRHBlBu9hNpAHmbRZp5NmmQdxiC2hhib3hCCGa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:38:34', '2025-06-17 15:38:34', NULL),
	(75, 'warga48@gmail.com', 'warga48', NULL, 'default.svg', '$2y$10$7xGLtoZvpRJri3jKEmWthu1WxEzyU1Bu1r5Ufvn3P2TP5ZgAg41f.', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:38:46', '2025-06-17 15:38:46', NULL),
	(76, 'warga49@gmail.com', 'warga49', NULL, 'default.svg', '$2y$10$INznJerR4XQ8Ft0qukpqKOKJELqkoLTAJqznN0P1jwWacaE.xnWD6', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:39:05', '2025-06-17 15:39:05', NULL),
	(77, 'warga50@gmail.com', 'warga50', NULL, 'default.svg', '$2y$10$IQm3YNWZIIZnfLTWBo8oe.R9sUB4hZG4vw3SgT5OEydo6Ql.HA2Iy', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:39:21', '2025-06-17 15:39:21', NULL),
	(78, 'warga51@gmail.com', 'warga51', NULL, 'default.svg', '$2y$10$ubHz/KeFoIUBcQgDqqv4/.0OyZhcVG1cKRyos3T5M6O6CMQLTfxvK', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:39:39', '2025-06-17 15:39:39', NULL),
	(79, 'warga52@gmail.com', 'warga52', NULL, 'default.svg', '$2y$10$1W9oIFUR6432ELjRacmxDORMFBV7sgXtctblIDapylAJPVARbAF1u', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:39:54', '2025-06-17 15:39:54', NULL),
	(80, 'warga53@gmail.com', 'warga53', NULL, 'default.svg', '$2y$10$0AW8r.njnt6RJadVEb6VM.L5nmmkvgEtK5iS8fEw0lQHMcG32XHYS', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:40:10', '2025-06-17 15:40:10', NULL),
	(81, 'warga54@gmail.com', 'warga54', NULL, 'default.svg', '$2y$10$CRBkAGP9Sh.22OSFRbkDGe.yC1fUbhUBFf5eoy866fEJbSB8.LB7u', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:40:22', '2025-06-17 15:40:22', NULL),
	(82, 'warga55@gmail.com', 'warga55', NULL, 'default.svg', '$2y$10$sunzKSvnDqXFfDeo06chqutN5rTgVnXrUSqOFiFNr8J6O9Q3AN01O', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:40:34', '2025-06-17 15:40:34', NULL),
	(83, 'warga56@gmail.com', 'warga56', NULL, 'default.svg', '$2y$10$Gft9Ug6jWoUjmN8/6o8DP./cP3el35iwg3EZL0u0f3yU6UWJXKJnS', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:40:45', '2025-06-17 15:40:45', NULL),
	(84, 'warga57@gmail.com', 'warga57', NULL, 'default.svg', '$2y$10$cYMB1PqJ.5hGWZ.4so.Bxu7z7ybLjkDW0yy5AZ0uaUUysSc8BJT46', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:40:58', '2025-06-17 15:40:58', NULL),
	(85, 'warga58@gmail.com', 'warga58', NULL, 'default.svg', '$2y$10$be6Jw.pCVIPOlriPoyR7YuzOFfVy1bUuztap7BtyjxfcSG0lvRJZ2', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:41:10', '2025-06-17 15:41:10', NULL),
	(86, 'warga59@gmail.com', 'warga59', NULL, 'default.svg', '$2y$10$18/k7q.9WLvIw7Icxug2JuM0DgzkevhUB2p9u9s5zW1eKGfc/lAEi', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:41:22', '2025-06-17 15:41:22', NULL),
	(87, 'warga60@gmail.com', 'warga60', NULL, 'default.svg', '$2y$10$I517kDSSRr4auI8nb.JEgOvR3IUsFDy./7bN6tQ0MWzi/HCUi8b9e', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-06-17 15:41:32', '2025-06-17 15:41:32', NULL);

-- Dumping structure for trigger ci4login.trg_before_insert_meat_distribution
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER trg_before_insert_meat_distribution
BEFORE INSERT ON meat_distribution
FOR EACH ROW
BEGIN
  DECLARE kambing_weight DECIMAL(10,2);
  DECLARE sapi_weight DECIMAL(10,2);

  -- Ambil berat daging kambing untuk user
  SELECT meat_weight INTO kambing_weight
  FROM meat_distribution_kambing
  WHERE recipient_user_id = NEW.recipient_user_id
  LIMIT 1;

  -- Ambil berat daging sapi untuk user
  SELECT meat_weight INTO sapi_weight
  FROM meat_distribution_sapi
  WHERE recipient_user_id = NEW.recipient_user_id
  LIMIT 1;

  -- Isi kolom otomatis
  SET NEW.meat_weight_kambing = kambing_weight;
  SET NEW.meat_weight_sapi = sapi_weight;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
