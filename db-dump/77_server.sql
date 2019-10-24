-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2019 at 02:55 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `77_server`
--

-- --------------------------------------------------------

--
-- Table structure for table `boards`
--

CREATE TABLE `boards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `creator_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `boards`
--

INSERT INTO `boards` (`id`, `creator_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 5, 'belajar ngoding', '2019-10-20 10:44:09', '2019-10-20 11:12:32'),
(6, 5, 'go front-end', '2019-10-20 11:16:13', '2019-10-23 06:56:29'),
(7, 2, 'tester', '2019-10-23 06:55:28', '2019-10-24 02:38:47'),
(8, 5, 'go back-end', '2019-10-23 18:41:05', '2019-10-23 18:41:05'),
(9, 5, 'go fullstack-end', '2019-10-24 04:19:32', '2019-10-24 04:19:32');

-- --------------------------------------------------------

--
-- Table structure for table `board_lists`
--

CREATE TABLE `board_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `board_id` bigint(20) UNSIGNED NOT NULL,
  `order` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `board_lists`
--

INSERT INTO `board_lists` (`id`, `board_id`, `order`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'informatic logic', '2019-10-20 13:40:42', '2019-10-20 13:48:42'),
(2, 1, 2, 'tipe data', '2019-10-20 13:41:55', '2019-10-20 13:41:55'),
(12, 6, 1, 'belajar', '2019-10-20 16:53:24', '2019-10-20 17:19:06'),
(13, 6, 2, 'santuy', '2019-10-20 16:53:34', '2019-10-20 17:19:13'),
(14, 6, 3, 'dapat kerjaan', '2019-10-20 16:53:40', '2019-10-20 17:33:28'),
(15, 6, 4, 'banyak duit', '2019-10-20 16:53:48', '2019-10-20 17:33:27');

-- --------------------------------------------------------

--
-- Table structure for table `board_members`
--

CREATE TABLE `board_members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `board_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `board_members`
--

INSERT INTO `board_members` (`id`, `board_id`, `user_id`, `created_at`, `updated_at`) VALUES
(3, 6, 5, '2019-10-22 13:32:11', '2019-10-23 14:56:16'),
(4, 6, 4, '2019-10-22 13:32:38', '2019-10-22 13:32:38'),
(5, 9, 5, '2019-10-24 04:19:32', '2019-10-24 04:19:32');

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `list_id` bigint(20) UNSIGNED NOT NULL,
  `order` int(11) NOT NULL,
  `task` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`id`, `list_id`, `order`, `task`, `created_at`, `updated_at`) VALUES
(1, 15, 1, 'kerja', '2019-10-20 17:49:15', '2019-10-21 01:48:29'),
(2, 12, 3, 'santuy', '2019-10-20 17:49:29', '2019-10-22 11:08:51'),
(3, 15, 2, 'apaandah', '2019-10-20 22:18:57', '2019-10-21 01:48:45');

-- --------------------------------------------------------

--
-- Table structure for table `login_tokens`
--

CREATE TABLE `login_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_tokens`
--

INSERT INTO `login_tokens` (`id`, `user_id`, `token`, `created_at`, `updated_at`) VALUES
(11, 5, '$2y$10$6bmGm5IEKMUsnrKwHpIeceMYGUf0TXgV7KlXyG3WdIkkEMxphvhOm', '2019-10-20 10:14:21', '2019-10-20 10:14:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `password`, `created_at`, `updated_at`) VALUES
(2, 'dRoman', 'Ziddan', 'romanz1idan', '$2y$10$1oilzM2UTWEQg8UJtElKpeZ0SZRJil0M16O1yY4R.CiULGyjo0dge', '2019-10-19 22:24:38', '2019-10-19 22:24:38'),
(4, 'Kyze', 'Luci', 'kyzeluci12', '$2y$10$cjEm8ot/HRjiSocTzVrOW.IX/U5zuEAHsrPn4Y/H38ef7Q1IBqtqq', '2019-10-19 23:04:19', '2019-10-19 23:04:19'),
(5, 'Account', 'Tester', 'admin', '$2y$10$zTPwt9/Ul2SExcEr/tdbWOhf/sIBaqGlF7qg/5LfEjWkNFKwXjIHS', '2019-10-19 23:13:48', '2019-10-19 23:13:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `boards`
--
ALTER TABLE `boards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creator_id` (`creator_id`);

--
-- Indexes for table `board_lists`
--
ALTER TABLE `board_lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `board_id` (`board_id`);

--
-- Indexes for table `board_members`
--
ALTER TABLE `board_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `board_id` (`board_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `list_id` (`list_id`);

--
-- Indexes for table `login_tokens`
--
ALTER TABLE `login_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `boards`
--
ALTER TABLE `boards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `board_lists`
--
ALTER TABLE `board_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `board_members`
--
ALTER TABLE `board_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `login_tokens`
--
ALTER TABLE `login_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `boards`
--
ALTER TABLE `boards`
  ADD CONSTRAINT `boards_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `board_lists`
--
ALTER TABLE `board_lists`
  ADD CONSTRAINT `board_lists_ibfk_1` FOREIGN KEY (`board_id`) REFERENCES `boards` (`id`);

--
-- Constraints for table `board_members`
--
ALTER TABLE `board_members`
  ADD CONSTRAINT `board_members_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `board_members_ibfk_2` FOREIGN KEY (`board_id`) REFERENCES `boards` (`id`);

--
-- Constraints for table `cards`
--
ALTER TABLE `cards`
  ADD CONSTRAINT `cards_ibfk_1` FOREIGN KEY (`list_id`) REFERENCES `board_lists` (`id`);

--
-- Constraints for table `login_tokens`
--
ALTER TABLE `login_tokens`
  ADD CONSTRAINT `login_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
