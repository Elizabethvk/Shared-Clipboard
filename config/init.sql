SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `clipboard` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `clipboard`;

CREATE TABLE IF NOT EXISTS `auth_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `clip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `resource_type` varchar(63) NOT NULL,
  `resource_data` text NOT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT 1,
  `owner_id` int(11) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `clip` (`id`, `name`, `description`, `resource_type`, `resource_data`, `is_public`, `owner_id`, `uploaded_at`, `last_updated_at`) VALUES
(18, 'regext', '', 'link', 'https://regexr.com/', 1, 5, '2024-01-25 21:21:41', '2024-01-25 21:53:22'),
(19, 'gulugulu', '', 'link', 'https://google.com', 1, 5, '2024-01-25 21:23:11', '2024-01-25 21:53:25'),
(20, 'dir', '', 'bash', 'dir', 1, 5, '2024-01-25 21:39:17', '2024-01-25 21:53:27'),
(23, 'код', 'примерен пхп код', 'php', '<?php echo \"Hello world\"; ?>', 1, 5, '2024-01-25 21:55:07', '2024-01-25 21:55:07'),
(24, 'още един баш', '', 'bash', 'echo \"Helo world!\"', 1, 5, '2024-01-25 21:57:00', '2024-01-25 21:57:00'),
(25, 'лъвче', 'снимка на лъвче', 'link', 'https://m.netinfo.bg/media/images/49214/49214792/991-ratio-lyvche.jpg', 0, 5, '2024-01-25 21:58:34', '2024-01-25 21:58:34');

CREATE TABLE IF NOT EXISTS `subscription` (
  `subscriber_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`subscriber_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `subscription` (`subscriber_id`, `user_id`, `created_at`) VALUES
(1, 1, '2024-01-25 20:47:39'),
(3, 3, '2024-01-25 21:51:46'),
(3, 4, '2024-01-25 21:51:47'),
(4, 3, '2024-01-25 21:52:14'),
(4, 4, '2024-01-25 21:52:14');

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `email` (`email`) USING HASH,
  UNIQUE KEY `username` (`username`) USING HASH
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `user` (`id`, `email`, `username`, `password`, `is_admin`, `created_at`, `last_updated_at`, `is_deleted`) VALUES
(3, 'redovi1@redoven.com', 'redovi1', '$2y$10$nYHQyqOQFHom50kUwrqxOu3NvYrZboOmQhm2Wk9j19SRkIqHhRU8a', 0, '2024-01-25 21:48:38', '2024-01-25 21:48:38', 0),
(4, 'redovi2@redoven.com', 'redovi2', '$2y$10$rcdtO4yOBbcg/rbUiLz6keyqpQg/OPzrNtE5L.GDQKwdp6/Q7Nu/i', 0, '2024-01-25 21:49:05', '2024-01-25 21:49:05', 0),
(5, 'admin@adminov.com', 'kostadinov', '$2y$10$oPaSV8mByhT0/zINgG26qODXox/9r3bc4HLta13IJF2Yh/nkV1NL6', 1, '2024-01-25 21:52:45', '2024-01-25 22:21:34', 0);


ALTER TABLE `auth_token`
  ADD CONSTRAINT `auth_token_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

ALTER TABLE `clip`
  ADD CONSTRAINT `clip_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
