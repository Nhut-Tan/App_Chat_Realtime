-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 25, 2025 at 04:39 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chatapp-realtime`
--

-- --------------------------------------------------------

--
-- Table structure for table `chatrooms`
--

DROP TABLE IF EXISTS `chatrooms`;
CREATE TABLE IF NOT EXISTS `chatrooms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userid` int NOT NULL,
  `msg` varchar(200) NOT NULL,
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `chatrooms`
--

INSERT INTO `chatrooms` (`id`, `userid`, `msg`, `created_on`) VALUES
(1, 35, 'hello friend', '2025-02-15 01:39:19'),
(2, 36, 'halo', '2025-02-15 01:40:19'),
(3, 35, 'how are you', '2025-02-15 01:56:49'),
(4, 36, 'fine', '2025-02-15 01:56:55'),
(5, 36, 'what', '2025-02-15 01:57:12'),
(6, 35, 'kk', '2025-02-15 01:57:26'),
(7, 35, 'alolo', '2025-02-15 02:28:04'),
(8, 35, 'alo', '2025-02-17 03:13:02');

-- --------------------------------------------------------

--
-- Table structure for table `chat_message`
--

DROP TABLE IF EXISTS `chat_message`;
CREATE TABLE IF NOT EXISTS `chat_message` (
  `chat_message_id` int NOT NULL AUTO_INCREMENT,
  `to_user_id` int NOT NULL,
  `from_user_id` int NOT NULL,
  `chat_message` mediumtext NOT NULL,
  `timestamp` timestamp NOT NULL,
  `status` enum('Yes','No') NOT NULL,
  PRIMARY KEY (`chat_message_id`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `chat_message`
--

INSERT INTO `chat_message` (`chat_message_id`, `to_user_id`, `from_user_id`, `chat_message`, `timestamp`, `status`) VALUES
(5, 36, 35, 'alo', '2025-02-16 20:14:02', 'Yes'),
(2, 36, 35, 'a', '2025-02-16 19:48:22', 'Yes'),
(3, 35, 36, 'what', '2025-02-16 19:48:47', 'Yes'),
(4, 36, 35, 'abc', '2025-02-16 19:49:00', 'Yes'),
(6, 36, 35, 'a', '2025-02-16 20:15:26', 'Yes'),
(7, 35, 36, 'alo', '2025-02-16 20:15:56', 'Yes'),
(8, 36, 35, 'nghe', '2025-02-16 20:16:12', 'Yes'),
(9, 36, 35, 'lll', '2025-02-16 20:17:15', 'Yes'),
(17, 35, 36, 'a', '2025-02-16 20:19:09', 'Yes'),
(18, 35, 36, 'hi', '2025-02-16 20:24:33', 'Yes'),
(19, 35, 36, 'hihana', '2025-02-16 20:24:54', 'Yes'),
(20, 35, 36, 'a', '2025-02-16 20:31:11', 'Yes'),
(21, 35, 36, 'what', '2025-02-16 20:33:16', 'Yes'),
(22, 35, 36, 'aa', '2025-02-16 20:33:33', 'Yes'),
(23, 35, 36, 'a', '2025-02-16 20:33:35', 'Yes'),
(24, 35, 36, 'test', '2025-02-16 20:35:47', 'Yes'),
(25, 36, 35, 'hiihanna', '2025-02-17 20:52:12', 'Yes'),
(26, 36, 35, 'testnotification', '2025-02-17 20:52:27', 'Yes'),
(27, 35, 36, 'ahihi', '2025-02-17 20:53:06', 'Yes'),
(28, 35, 36, 'a', '2025-02-17 20:54:02', 'Yes'),
(29, 35, 36, 'b', '2025-02-17 20:54:12', 'Yes'),
(30, 35, 36, 'acs', '2025-02-17 20:54:17', 'Yes'),
(31, 36, 35, 'a', '2025-02-17 20:54:24', 'Yes'),
(32, 36, 35, 'aaa', '2025-02-17 20:54:31', 'Yes'),
(33, 36, 35, 'vvvv', '2025-02-17 20:54:33', 'Yes'),
(34, 36, 35, 'ad', '2025-02-17 20:55:02', 'Yes'),
(35, 36, 35, 'a', '2025-02-17 20:55:04', 'Yes'),
(36, 35, 36, 'bbb', '2025-02-17 20:55:08', 'Yes'),
(37, 35, 36, 'b', '2025-02-17 20:55:13', 'Yes'),
(38, 35, 36, 'jaja', '2025-02-17 20:55:16', 'Yes'),
(39, 35, 36, 'haha', '2025-02-17 20:55:20', 'Yes'),
(40, 35, 36, 'wii', '2025-02-17 20:59:09', 'Yes'),
(41, 35, 36, 'hii', '2025-02-17 21:04:31', 'Yes'),
(42, 36, 35, 'a', '2025-02-17 21:07:18', 'Yes'),
(43, 36, 35, 'bcs', '2025-02-17 21:07:21', 'Yes'),
(44, 36, 35, 'aaa', '2025-02-17 21:07:25', 'Yes'),
(45, 36, 35, 'aaa', '2025-02-17 21:07:29', 'Yes'),
(46, 36, 35, 'k', '2025-02-17 21:49:47', 'Yes'),
(47, 36, 35, 'a', '2025-03-24 21:24:19', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(100) NOT NULL,
  `profile` varchar(100) NOT NULL,
  `status` enum('Disable','Enable') NOT NULL,
  `created_on` datetime NOT NULL,
  `verify_code` varchar(100) NOT NULL,
  `login_status` enum('Logout','Login') NOT NULL,
  `user_token` varchar(100) NOT NULL,
  `user_connection_id` int NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `email`, `password`, `profile`, `status`, `created_on`, `verify_code`, `login_status`, `user_token`, `user_connection_id`) VALUES
(12, 'kaka', 'ka@gmail.com', '621e1355c0c0edebd2592a3589447130', 'images/1737817278.png', 'Disable', '2025-01-25 15:01:18', 'd15df97e17a4db3b117ad13950e91a2d', 'Logout', '', 0),
(26, 'congtan', 'congtan@gmail.com', '55381da2cee813c2afe437898d8a7742', 'images/1738744557.png', 'Disable', '2025-02-05 08:35:57', 'c3c31133b234699c84abdcd1386a8733', 'Logout', '', 0),
(27, 'naaa', 'haha@gmail.com', 'ea5add792a02d6f996f05e57cbdc1352', 'images/1738744906.png', 'Disable', '2025-02-05 08:41:46', '15a8a3e6035a29a1f48007ea326d8674', 'Logout', '', 0),
(28, 'tanne', 'tanne@gmail.com', '4b1b4b29e55fee39550928df484950d5', 'images/1738745397.png', 'Disable', '2025-02-05 08:49:57', 'dd229d32a19b25aeebbdaf9c6574f198', 'Logout', '', 0),
(33, 'nguyenna', 'nguyen@gmail.com', '6e97123d7be0c38c111ff6d7d6b274cd', 'images/1739020503.png', 'Disable', '2025-02-08 13:15:04', '1cab8f78fa4dca5a72bc3372afe9cb37', 'Logout', '', 0),
(35, 'tanhana1', 'dh52111716@student.stu.edu.vn', '4b1b4b29e55fee39550928df484950d5', 'images/571184064.JPG', 'Enable', '2025-02-12 13:09:13', 'a673ef85f745da27b45071515a616195', 'Login', '9c0431f2c18904be035f54c917471daa', 55),
(36, 'Hana', 'tanphan1823@gmail.com', '4b1b4b29e55fee39550928df484950d5', 'images/1739451860.png', 'Enable', '2025-02-13 13:04:20', '8b3fa829f5b3c72976acb41cbbefb573', 'Login', '1805525f3c92d3c726573392072b990c', 97);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
