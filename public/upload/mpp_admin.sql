-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 12, 2014 at 10:14 AM
-- Server version: 5.1.73
-- PHP Version: 5.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mpp_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_list`
--

CREATE TABLE IF NOT EXISTS `access_list` (
  `roles_name` varchar(50) COLLATE utf8_bin NOT NULL,
  `resources_name` varchar(50) COLLATE utf8_bin NOT NULL,
  `access_name` varchar(50) COLLATE utf8_bin NOT NULL,
  `allowed` int(3) NOT NULL,
  PRIMARY KEY (`roles_name`,`resources_name`,`access_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `article_admin_log`
--

CREATE TABLE IF NOT EXISTS `article_admin_log` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `action_id` int(11) NOT NULL,
  `article_id` bigint(20) NOT NULL,
  `uid` bigint(20) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE IF NOT EXISTS `resources` (
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `resources_accesses`
--

CREATE TABLE IF NOT EXISTS `resources_accesses` (
  `resources_name` varchar(50) COLLATE utf8_bin NOT NULL,
  `access_name` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`resources_name`,`access_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `roles_inherits`
--

CREATE TABLE IF NOT EXISTS `roles_inherits` (
  `roles_name` varchar(50) COLLATE utf8_bin NOT NULL,
  `roles_inherit` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`roles_name`,`roles_inherit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(9) NOT NULL AUTO_INCREMENT,
  `email` varchar(125) NOT NULL,
  `password` varchar(125) NOT NULL,
  `display_name` varchar(125) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `status` enum('enabled','disabled') NOT NULL DEFAULT 'enabled',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `idx_mpp_user_email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `display_name`, `created_at`, `status`) VALUES
(1, 'jason@tamtay.vn', '$2a$08$vMyx3M2UWGQcX2hfMdR6YO4vMxxd7a7XJYAXgSB4ZQ7kv8v5Om0kO', 'Jason Nguyen', 1396260173, 'enabled'),
(2, 'dunghq87@gmail.com', '$2a$08$1gqzGYG463HC8s59OSKeguTZsFCSk4GV9xJAJgR5Fd.KgdPjDzf1m', 'Hoang Dung', 1396346401, 'enabled'),
(3, 'vietanh@tamtay.vn', '$2a$08$oln5UjWvcE9U3wxF/2Y8YOHmnvIdaDM9FtbEcswiDR4K9rzfZYBmK', 'zzzz', 1396346557, 'enabled'),
(4, '81.minh@gmail.com', '$2a$08$hRSp/BkwJTeMrwbhQJdIBubIfTgvTPXVyWeTwOoO0/yqQpRXAImw6', 'Temp Hor', 1396349345, 'enabled'),
(5, 'phuong.cao@tamtay.vn', '$2a$08$gJdsbB6BVIjnUAOclk.YRul2csZL.f/9EuWon5klTzxKdBnGsre.S', 'Phương Cao', 1396414745, 'enabled'),
(6, 'cdhungcnit@gmail.com', '$2a$08$Fy4p821/QeaTUi9faV1VW.k28LzTl7fZFiDpQMiB606Hp.PqDs3cy', 'Đức Hùng', 1396497906, 'enabled'),
(7, 'tung.nguyenduy@tamtay.vn', '$2a$08$Y9JU8eQQFcoLg/N4/GZOYuUErwqtSpKcCbtWaDOhUcLidncfesUAK', 'Tung Nguyen', 1396497926, 'enabled'),
(8, 'dung.hoang@tamtay.vn', '$2a$08$.imJnY63dGaMyGqTOLvFieDToXNxzT/O72IBuRGBJYWmRM7Ds08VG', 'dung.hoang', 1396509567, 'enabled'),
(9, 'betapcode@gmail.com', '$2a$08$e.Lipha1vAjLFSwyWUg9m.oc/vV63xiDvqoY1geskDJOoXFEtlutO', 'Minh Phạm', 1397532777, 'enabled'),
(10, 'truong.nguyen@tamtay.vn', '$2a$08$zpucQB/dgBfMMIaWLxDWoe2EukzT5R8EW.yGnX4XmBO0IU./XC2ju', 'truongbeo166', 1400490327, 'enabled'),
(11, 'vietank@gmail.com', '$2a$08$T9sdAKLh7xyPHiSZWxvLweK1QVTqMECYsT./tNdNVN5hdxYJoO7Zm', 'Nguyễn Việt Anh', 1402375774, 'enabled');

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

CREATE TABLE IF NOT EXISTS `users_roles` (
  `user_id` int(9) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`,`role_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
