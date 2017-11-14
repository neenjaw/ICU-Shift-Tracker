-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 14, 2017 at 09:25 AM
-- Server version: 10.1.20-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `id1876647_neenjawtest`
--

-- --------------------------------------------------------

--
-- Table structure for table `shift_login_tbl_users`
--

CREATE TABLE `shift_login_tbl_users` (
  `id` int(11) NOT NULL,
  `login` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `shift_login_tbl_users`
--

INSERT INTO `shift_login_tbl_users` (`id`, `login`, `password`, `auth_id`) VALUES
(1, 'user', '$2y$10$D0v7DhKS2dEK5xnX5K4m0eLG04LxlnvBmChnNWRwETtI4NBQ8BJSu', 4),
(3, 'firsttestuser', '$2y$10$mnWUoYZBj3ih/BTPACazuOiQ.nx5exwoWIpRcFCTiXkX7C7xxoiaG', 2),
(9, 'admintestuser', '$2y$10$lQpq4Wv0k1mKhHRl.rqkqOnBteejpFa1q8rO65UHoWCsbZn8V80me', 4),
(10, 'viewonlytestuser', '$2y$10$Oqx30gIRzrzVP4LLaDVCrO/m2jJExNK/49qNRRgl/S0BWH/2hUT7y', 3),
(14, 'testtesttest', '$2y$10$ccHGJhSWnDqd0BHlG1.2VOidV7hnBE6E3LVOTir5oTP2w3gVw8RUq', 1);

-- --------------------------------------------------------

--
-- Table structure for table `shift_login_tbl_user_auth`
--

CREATE TABLE `shift_login_tbl_user_auth` (
  `id` int(11) NOT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `shift_login_tbl_user_auth`
--

INSERT INTO `shift_login_tbl_user_auth` (`id`, `state`) VALUES
(1, 'inactive'),
(2, 'active'),
(3, 'viewonly'),
(4, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `shift_tracker_tbl_assignment`
--

CREATE TABLE `shift_tracker_tbl_assignment` (
  `id` int(11) NOT NULL,
  `assignment` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `shift_tracker_tbl_assignment`
--

INSERT INTO `shift_tracker_tbl_assignment` (`id`, `assignment`) VALUES
(1, 'A'),
(5, 'A/B'),
(8, 'A/B/C'),
(7, 'A/C'),
(2, 'B'),
(6, 'B/C'),
(3, 'C'),
(4, 'Float');

-- --------------------------------------------------------

--
-- Table structure for table `shift_tracker_tbl_shift_entry`
--

CREATE TABLE `shift_tracker_tbl_shift_entry` (
  `id` int(11) NOT NULL,
  `shift_date` date NOT NULL,
  `staff_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `bool_doubled` tinyint(1) DEFAULT NULL COMMENT '0 = no, 1 = yes',
  `bool_vented` tinyint(1) DEFAULT NULL COMMENT '0 = no vent, 1 = yes vent',
  `bool_new_admit` tinyint(1) DEFAULT NULL COMMENT '0 = no, 1 = yes',
  `bool_very_sick` tinyint(1) DEFAULT NULL COMMENT '0 = no, 1 = yes',
  `bool_code_pager` tinyint(1) DEFAULT NULL COMMENT '0 = no, 1 = yes',
  `bool_crrt` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = no, 1 = yes',
  `bool_burn` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = no, 1 = yes',
  `bool_evd` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = no, 1 = yes',
  `bool_day_or_night` tinyint(1) DEFAULT NULL COMMENT '0 = day, 1 = night'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `shift_tracker_tbl_shift_entry`
--

INSERT INTO `shift_tracker_tbl_shift_entry` (`id`, `shift_date`, `staff_id`, `role_id`, `assignment_id`, `bool_doubled`, `bool_vented`, `bool_new_admit`, `bool_very_sick`, `bool_code_pager`, `bool_crrt`, `bool_burn`, `bool_evd`, `bool_day_or_night`) VALUES
(1, '2017-02-02', 27, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(2, '2017-03-08', 25, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(3, '2017-07-07', 7, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(4, '2017-06-03', 16, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(5, '2017-02-12', 28, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(6, '2017-07-12', 21, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(7, '2017-04-02', 17, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(8, '2017-01-19', 26, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(10, '2017-07-15', 15, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(11, '2017-05-22', 5, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(12, '2017-05-02', 14, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(13, '2017-07-18', 8, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(15, '2017-04-15', 22, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(16, '2017-05-16', 26, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(17, '2017-05-14', 3, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(18, '2017-05-25', 13, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(19, '2017-06-30', 23, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(20, '2017-02-05', 4, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(21, '2017-04-17', 4, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(22, '2017-05-19', 19, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(24, '2017-01-10', 14, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(25, '2017-06-10', 24, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(26, '2017-07-06', 21, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(27, '2017-01-10', 22, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(28, '2017-06-08', 25, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(29, '2017-03-15', 26, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(30, '2017-04-20', 6, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(31, '2017-07-02', 9, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(32, '2017-05-25', 9, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(33, '2017-07-24', 28, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(34, '2017-01-10', 25, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(35, '2017-01-26', 19, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(36, '2017-03-13', 14, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(37, '2017-05-23', 27, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(38, '2017-06-10', 2, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(39, '2017-03-09', 24, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(40, '2017-06-10', 7, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(41, '2017-06-19', 17, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(42, '2017-01-14', 22, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(43, '2017-02-23', 26, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(44, '2017-01-20', 19, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(45, '2017-03-19', 3, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(46, '2017-03-09', 8, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(47, '2017-07-11', 19, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(48, '2017-07-19', 5, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(49, '2017-06-13', 23, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(50, '2017-02-26', 15, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(51, '2017-03-26', 5, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(52, '2017-01-11', 22, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(53, '2017-01-19', 13, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(54, '2017-07-12', 3, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(56, '2017-02-18', 2, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(57, '2017-02-21', 9, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(58, '2017-04-05', 15, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(59, '2017-06-27', 26, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(60, '2017-02-27', 22, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(61, '2017-03-19', 22, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(62, '2017-01-03', 13, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(63, '2017-01-17', 2, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(64, '2017-03-20', 24, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(65, '2017-07-10', 28, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(66, '2017-01-23', 21, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(67, '2017-03-31', 13, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(68, '2017-02-12', 2, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(69, '2017-03-28', 23, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(70, '2017-07-20', 22, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(71, '2017-04-07', 4, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(72, '2017-01-13', 10, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(73, '2017-05-30', 21, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(74, '2017-02-16', 11, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(75, '2017-05-11', 12, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(76, '2017-06-16', 23, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(77, '2017-03-17', 29, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(78, '2017-05-05', 29, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(79, '2017-02-19', 4, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(80, '2017-03-06', 7, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(81, '2017-03-29', 13, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(82, '2017-05-04', 28, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(83, '2017-06-16', 28, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(84, '2017-02-06', 20, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(85, '2017-06-15', 27, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(86, '2017-04-22', 20, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(87, '2017-06-11', 21, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(88, '2017-03-14', 6, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(89, '2017-03-29', 10, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(90, '2017-03-12', 16, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(91, '2017-05-11', 26, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(92, '2017-05-15', 24, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(93, '2017-04-06', 27, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(94, '2017-03-21', 23, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(95, '2017-04-26', 24, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(96, '2017-03-03', 17, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(97, '2017-03-31', 27, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(98, '2017-06-10', 19, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(99, '2017-01-06', 16, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(100, '2017-03-17', 25, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(101, '2017-02-25', 12, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(102, '2017-06-27', 24, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(103, '2017-05-04', 12, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(104, '2017-07-02', 11, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(105, '2017-06-09', 23, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(106, '2017-02-10', 29, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(108, '2017-06-26', 28, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(109, '2017-06-30', 16, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(110, '2017-03-05', 26, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(111, '2017-07-17', 29, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(112, '2017-01-24', 25, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(113, '2017-02-27', 16, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(114, '2017-04-27', 10, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(115, '2017-01-22', 14, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(116, '2017-02-18', 25, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(117, '2017-04-15', 11, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(118, '2017-03-30', 19, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(119, '2017-03-23', 5, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(120, '2017-07-09', 20, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(121, '2017-05-23', 9, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(122, '2017-04-18', 13, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(123, '2017-06-23', 4, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(125, '2017-05-05', 8, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(127, '2017-06-07', 19, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(128, '2017-02-18', 9, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(129, '2017-06-12', 13, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(130, '2017-05-14', 16, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(131, '2017-06-28', 19, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(132, '2017-05-30', 10, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(133, '2017-01-20', 16, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(134, '2017-04-15', 24, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(135, '2017-04-10', 14, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(136, '2017-03-13', 23, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(137, '2017-02-05', 21, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(138, '2017-05-04', 13, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(139, '2017-02-05', 15, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(140, '2017-06-13', 7, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(141, '2017-05-13', 25, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(142, '2017-01-09', 7, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(143, '2017-03-29', 17, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(144, '2017-06-17', 19, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(145, '2017-05-26', 23, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(146, '2017-03-10', 19, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(147, '2017-03-08', 6, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(148, '2017-02-28', 8, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(149, '2017-04-30', 11, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(150, '2017-03-02', 16, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(151, '2017-04-26', 17, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(152, '2017-03-15', 6, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(153, '2017-05-23', 28, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(154, '2017-04-01', 22, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(155, '2017-01-13', 2, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(156, '2017-04-03', 10, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(157, '2017-06-17', 14, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(158, '2017-07-23', 25, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(159, '2017-01-25', 9, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(160, '2017-03-08', 10, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(161, '2017-07-03', 11, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(162, '2017-05-19', 24, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(163, '2017-06-14', 28, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(165, '2017-01-20', 6, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(166, '2017-07-05', 16, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(167, '2017-06-25', 12, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(168, '2017-07-23', 22, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(169, '2017-01-30', 7, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(170, '2017-07-10', 9, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(171, '2017-03-29', 29, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(172, '2017-05-17', 28, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(173, '2017-05-11', 27, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(174, '2017-01-09', 18, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(175, '2017-06-04', 26, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(176, '2017-03-20', 13, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(177, '2017-06-11', 29, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(178, '2017-03-25', 5, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(179, '2017-06-27', 8, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(180, '2017-04-21', 27, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(181, '2017-03-15', 20, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(182, '2017-01-24', 5, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(183, '2017-04-09', 9, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(184, '2017-01-13', 17, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(185, '2017-04-23', 24, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(186, '2017-04-18', 29, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(187, '2017-04-05', 21, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(188, '2017-05-30', 22, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(189, '2017-02-13', 29, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(190, '2017-06-11', 2, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(191, '2017-07-10', 17, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(193, '2017-02-24', 19, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(194, '2017-07-13', 7, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(195, '2017-04-07', 6, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(196, '2017-02-07', 28, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(197, '2017-06-02', 27, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(198, '2017-05-03', 19, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(199, '2017-06-07', 12, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(200, '2017-02-26', 20, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(201, '2017-06-26', 12, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(202, '2017-04-28', 6, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(203, '2017-05-30', 26, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(204, '2017-04-10', 24, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(205, '2017-01-16', 5, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(206, '2017-06-04', 8, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(207, '2017-03-09', 11, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(208, '2017-05-27', 9, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(209, '2017-05-24', 25, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(210, '2017-01-10', 21, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(211, '2017-07-20', 10, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(212, '2017-04-17', 2, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(213, '2017-07-04', 3, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(214, '2017-04-24', 4, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(215, '2017-05-18', 28, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(216, '2017-04-28', 20, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(217, '2017-06-01', 25, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(218, '2017-05-26', 10, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(219, '2017-03-09', 5, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(220, '2017-06-13', 26, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(222, '2017-06-08', 10, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(223, '2017-03-24', 17, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(224, '2017-02-24', 14, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(225, '2017-07-10', 11, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(226, '2017-07-17', 16, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(227, '2017-04-17', 12, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(228, '2017-06-23', 29, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(229, '2017-02-20', 25, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(230, '2017-02-22', 29, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(231, '2017-05-26', 11, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(232, '2017-04-10', 4, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(233, '2017-04-06', 8, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(234, '2017-07-12', 8, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(235, '2017-05-25', 5, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(236, '2017-05-30', 15, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(237, '2017-02-24', 27, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(238, '2017-01-23', 4, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(239, '2017-02-17', 28, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(241, '2017-06-15', 19, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(242, '2017-04-09', 19, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(243, '2017-01-03', 22, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(244, '2017-07-17', 25, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(245, '2017-02-26', 6, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(246, '2017-07-23', 26, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(247, '2017-06-05', 28, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(248, '2017-02-26', 10, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(249, '2017-02-17', 2, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(250, '2017-05-21', 27, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(251, '2017-03-06', 22, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(252, '2017-06-16', 29, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(253, '2017-06-07', 18, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(254, '2017-04-14', 7, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(255, '2017-03-15', 15, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(256, '2017-02-25', 2, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(257, '2017-06-21', 18, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(258, '2017-07-01', 13, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(259, '2017-07-19', 2, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(260, '2017-05-10', 5, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(261, '2017-01-02', 17, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(262, '2017-04-06', 26, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(263, '2017-01-28', 25, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(264, '2017-05-03', 18, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(265, '2017-07-07', 10, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(267, '2017-05-27', 13, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(268, '2017-01-16', 26, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(269, '2017-07-22', 12, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(270, '2017-07-02', 26, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(271, '2017-07-22', 22, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(272, '2017-03-15', 13, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(273, '2017-03-05', 2, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(274, '2017-02-03', 15, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(275, '2017-04-14', 27, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(276, '2017-02-19', 5, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(277, '2017-01-02', 18, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(278, '2017-05-12', 22, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(279, '2017-03-30', 7, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(280, '2017-01-01', 4, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(281, '2017-07-22', 10, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(282, '2017-04-10', 13, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(283, '2017-04-11', 8, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(284, '2017-01-26', 3, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(285, '2017-04-10', 23, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(286, '2017-04-27', 28, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(287, '2017-01-02', 11, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(288, '2017-04-03', 2, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(289, '2017-03-25', 14, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(290, '2017-02-15', 8, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(291, '2017-06-11', 10, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(292, '2017-07-17', 12, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(293, '2017-03-21', 9, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(294, '2017-02-09', 14, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(295, '2017-07-10', 20, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(296, '2017-07-08', 23, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(297, '2017-01-14', 8, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(298, '2017-06-26', 14, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(299, '2017-06-05', 24, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(300, '2017-03-23', 18, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(301, '2017-08-12', 8, 5, 6, 1, 1, 0, 0, 0, 0, 0, 0, 0),
(302, '2017-08-12', 31, 6, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(303, '2017-08-12', 4, 1, 6, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(304, '2017-08-12', 44, 5, 2, 0, 1, 1, 1, 0, 0, 0, 0, 0),
(306, '2017-08-12', 15, 2, 3, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(307, '2017-07-11', 9, 2, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(308, '2017-07-04', 31, 5, 2, 0, 1, 0, 1, 0, 0, 0, 0, 0),
(309, '2017-08-13', 2, 5, 2, 0, 0, 1, 0, 1, 0, 0, 0, 1),
(310, '2017-08-13', 10, 5, 2, 1, 0, 0, 0, 0, 0, 0, 0, 1),
(311, '2017-08-13', 8, 4, 4, 0, 1, 1, 0, 0, 0, 0, 0, 1),
(312, '2017-08-13', 24, 4, 4, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(313, '2017-08-13', 44, 2, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(314, '2017-08-09', 44, 2, 1, 0, 1, 0, 0, 0, 0, 0, 0, 1),
(315, '2017-08-30', 47, 7, 5, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(316, '2017-09-01', 42, 5, 2, 1, 1, 0, 1, 0, 1, 0, 1, 1),
(317, '2017-09-14', 44, 6, 3, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(460, '2017-10-05', 45, 2, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(461, '2017-10-05', 31, 2, 3, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(462, '2017-10-05', 8, 5, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(463, '2017-10-05', 18, 5, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0),
(464, '2017-10-05', 7, 5, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0),
(465, '2017-10-05', 3, 5, 2, 0, 1, 0, 0, 0, 0, 0, 1, 0),
(466, '2017-10-05', 29, 5, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(467, '2017-10-05', 20, 5, 2, 0, 1, 0, 1, 1, 0, 0, 0, 0),
(468, '2017-10-05', 11, 5, 3, 0, 1, 1, 0, 0, 0, 0, 0, 0),
(469, '2017-10-05', 9, 5, 3, 1, 1, 0, 0, 0, 0, 1, 0, 0),
(470, '2017-10-05', 33, 5, 3, 0, 1, 0, 0, 0, 1, 0, 0, 0),
(471, '2017-10-05', 15, 4, 4, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(472, '2017-10-05', 44, 6, 8, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(473, '2017-10-05', 47, 7, 8, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(474, '2017-10-05', 40, 1, 8, 0, 1, 0, 0, 0, 0, 0, 0, 1),
(476, '2017-10-05', 26, 5, 1, 0, 1, 0, 1, 0, 0, 1, 0, 1),
(477, '2017-10-05', 42, 5, 1, 1, 1, 0, 0, 0, 1, 0, 1, 1),
(478, '2017-10-05', 17, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 1),
(479, '2017-10-05', 43, 5, 2, 1, 1, 0, 0, 1, 0, 0, 0, 1),
(481, '2017-10-05', 22, 5, 3, 0, 1, 0, 0, 0, 0, 0, 0, 1),
(482, '2017-10-05', 6, 5, 3, 0, 0, 0, 0, 1, 0, 0, 0, 1),
(483, '2017-10-05', 21, 5, 3, 0, 1, 0, 0, 0, 0, 0, 0, 1),
(484, '2017-10-05', 14, 4, 4, 0, 1, 0, 0, 0, 0, 0, 0, 1),
(485, '2017-10-05', 46, 6, 8, 0, 1, 0, 0, 0, 0, 0, 0, 1),
(488, '2017-10-10', 31, 2, 3, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(489, '2017-10-10', 8, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(490, '2017-10-10', 18, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(492, '2017-10-10', 3, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(493, '2017-10-10', 29, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(494, '2017-10-10', 20, 5, 3, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(495, '2017-10-10', 11, 5, 3, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(496, '2017-10-10', 9, 4, 4, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(497, '2017-10-10', 44, 6, 8, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(499, '2017-10-10', 33, 1, 8, 0, 1, 0, 0, 0, 0, 0, 0, 1),
(500, '2017-10-10', 15, 5, 4, 0, 1, 0, 0, 0, 0, 0, 0, 1),
(501, '2017-10-10', 4, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 1),
(502, '2017-10-10', 23, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 1),
(503, '2017-10-10', 13, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 1),
(504, '2017-10-10', 28, 5, 2, 0, 1, 1, 0, 0, 0, 1, 0, 1),
(505, '2017-10-10', 10, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 1),
(507, '2017-10-10', 25, 5, 3, 0, 1, 0, 0, 0, 0, 0, 0, 1),
(508, '2017-10-10', 5, 5, 3, 0, 1, 0, 0, 0, 0, 0, 0, 1),
(509, '2017-10-10', 24, 4, 4, 0, 1, 0, 0, 0, 0, 0, 0, 1),
(510, '2017-10-10', 32, 6, 6, 0, 1, 0, 0, 0, 0, 0, 0, 1),
(511, '2017-10-10', 47, 7, 8, 0, 1, 0, 0, 0, 0, 0, 0, 1),
(520, '2017-10-10', 30, 1, 5, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(521, '2017-10-10', 19, 2, 3, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(522, '2017-10-10', 16, 5, 4, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(523, '2017-10-10', 12, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(524, '2017-10-10', 14, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(525, '2017-10-10', 22, 5, 3, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(526, '2017-10-10', 6, 4, 4, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(527, '2017-10-05', 4, 1, 8, 0, 1, 0, 0, 0, 0, 0, 0, 1),
(528, '2017-10-05', 23, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 1),
(529, '2017-10-05', 13, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 1),
(530, '2017-10-05', 28, 5, 3, 0, 1, 0, 0, 0, 0, 0, 0, 1),
(531, '2017-10-05', 10, 4, 4, 0, 1, 0, 0, 0, 0, 0, 0, 1),
(532, '2017-10-05', 32, 6, 3, 0, 1, 0, 0, 0, 0, 0, 0, 1),
(534, '2017-10-03', 31, 2, 3, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(535, '2017-10-03', 8, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(536, '2017-10-03', 3, 5, 2, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(537, '2017-10-03', 29, 5, 3, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(538, '2017-10-03', 18, 4, 4, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(539, '2017-10-03', 46, 6, 5, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(540, '2017-10-03', 32, 6, 6, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(541, '2017-10-03', 47, 7, 8, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(542, '2017-10-01', 45, 1, 8, 1, 0, 0, 0, 0, 0, 0, 0, 0),
(543, '2017-10-01', 31, 2, 3, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(544, '2017-10-01', 8, 5, 4, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(545, '2017-10-01', 29, 5, 1, 0, 1, 1, 0, 0, 1, 0, 0, 0),
(546, '2017-10-01', 20, 5, 2, 0, 0, 1, 1, 0, 1, 1, 0, 0),
(547, '2017-10-01', 9, 5, 3, 1, 1, 0, 1, 1, 0, 0, 1, 0),
(548, '2017-10-01', 15, 4, 4, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(549, '2017-10-01', 46, 6, 8, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(550, '2017-10-01', 47, 7, 8, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(551, '2017-10-13', 45, 1, 5, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(552, '2017-10-13', 31, 3, 3, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(553, '2017-10-13', 18, 5, 4, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(554, '2017-10-13', 8, 5, 1, 0, 1, 0, 0, 0, 0, 1, 0, 0),
(555, '2017-10-13', 3, 5, 1, 1, 0, 1, 1, 1, 1, 0, 1, 0),
(556, '2017-10-13', 11, 5, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(557, '2017-10-13', 29, 5, 2, 0, 0, 1, 0, 1, 0, 0, 0, 0),
(558, '2017-10-13', 9, 5, 2, 1, 1, 0, 0, 0, 0, 0, 0, 0),
(559, '2017-10-13', 23, 5, 3, 0, 0, 1, 0, 0, 0, 0, 0, 0),
(560, '2017-10-13', 28, 5, 3, 1, 1, 0, 0, 0, 0, 0, 0, 0),
(561, '2017-10-13', 20, 4, 4, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(562, '2017-10-13', 44, 6, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(563, '2017-10-13', 47, 7, 3, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(565, '2017-11-02', 7, 5, 3, 0, 0, 1, 1, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `shift_tracker_tbl_shift_entry_ref`
--

CREATE TABLE `shift_tracker_tbl_shift_entry_ref` (
  `column_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `form_type` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `item_group` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `shift_tracker_tbl_shift_entry_ref`
--

INSERT INTO `shift_tracker_tbl_shift_entry_ref` (`column_name`, `display_name`, `form_type`, `item_group`) VALUES
('assignment_id', 'Assignment', 'select', 'ref'),
('bool_burn', 'Burn', 'checkbox', 'mod'),
('bool_code_pager', 'Code Pager', 'checkbox', 'mod'),
('bool_crrt', 'CRRT', 'checkbox', 'mod'),
('bool_day_or_night', 'Day or Night', 'checkbox', 'mod'),
('bool_doubled', 'Doubled', 'checkbox', 'mod'),
('bool_evd', 'EVD', 'checkbox', 'mod'),
('bool_new_admit', 'Admitted', 'checkbox', 'mod'),
('bool_vented', 'Vented', 'checkbox', 'mod'),
('bool_very_sick', 'Very Sick', 'checkbox', 'mod'),
('id', 'shift-id', NULL, 'ref'),
('role_id', 'Role', 'select', 'ref'),
('shift_date', 'Date', NULL, 'ref'),
('staff_id', 'Staff', NULL, 'ref');

-- --------------------------------------------------------

--
-- Table structure for table `shift_tracker_tbl_staff`
--

CREATE TABLE `shift_tracker_tbl_staff` (
  `id` int(11) NOT NULL,
  `last_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `bool_is_active` tinyint(1) NOT NULL COMMENT '0 = no, 1 = yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `shift_tracker_tbl_staff`
--

INSERT INTO `shift_tracker_tbl_staff` (`id`, `last_name`, `first_name`, `category_id`, `bool_is_active`) VALUES
(2, 'Kasprzak', 'Margurite', 1, 1),
(3, 'Carone', 'Claretta', 1, 1),
(4, 'Gambrell', 'Johnny', 1, 1),
(5, 'Lundy', 'Basilia', 1, 1),
(6, 'Sargent', 'Tamar', 1, 1),
(7, 'Brecht', 'Mai', 1, 1),
(8, 'Bakos', 'Audie', 1, 0),
(9, 'Feher', 'Shanae', 1, 1),
(10, 'Hong', 'Ken', 1, 1),
(11, 'Estevez', 'Kimberely', 1, 1),
(12, 'Peloquin', 'Joaquin', 1, 1),
(13, 'Hardy', 'Krysten', 1, 1),
(14, 'Rizzi', 'Hoyt', 1, 1),
(15, 'Flippin', 'Lacey', 1, 1),
(16, 'Mohamed', 'Cleopatra', 1, 1),
(17, 'Schow', 'Georgene', 1, 1),
(18, 'Borgeson', 'Kasey', 1, 1),
(19, 'Mcniff', 'Donovan', 1, 1),
(20, 'Delosh', 'Cassondra', 1, 1),
(21, 'Sassman', 'Ana', 1, 1),
(22, 'Saine', 'Jimmie', 1, 1),
(23, 'Goldsberry', 'Danyell', 1, 1),
(24, 'Maldanado', 'Lizeth', 1, 1),
(25, 'Laubscher', 'Alpha', 1, 1),
(26, 'Walberg', 'Shalanda', 1, 1),
(27, 'Stansel', 'Damion', 1, 1),
(28, 'Herrell', 'Randal', 1, 1),
(29, 'Carrigan', 'Tabatha', 1, 1),
(30, 'Mascia', 'Analisa', 1, 1),
(31, 'Amick', 'Sonny', 1, 1),
(32, 'Hansworthy', 'Michael', 3, 1),
(33, 'Fitzgerald', 'Gerald', 1, 1),
(40, 'Wong', 'Josh', 1, 1),
(42, 'Wong', 'Fredering', 1, 1),
(43, 'Shmorganson', 'Gary', 1, 1),
(44, 'Asd', 'Adas', 2, 1),
(45, 'Ada', 'Dasdas', 1, 1),
(46, 'Ggd', 'Ggdd', 2, 1),
(47, 'Porter', 'Dave', 4, 1),
(49, 'Bleu', 'Menu', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `shift_tracker_tbl_staff_category`
--

CREATE TABLE `shift_tracker_tbl_staff_category` (
  `id` int(11) NOT NULL,
  `category` varchar(60) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `shift_tracker_tbl_staff_category`
--

INSERT INTO `shift_tracker_tbl_staff_category` (`id`, `category`) VALUES
(3, 'LPN'),
(2, 'NA'),
(1, 'RN'),
(4, 'UC');

-- --------------------------------------------------------

--
-- Table structure for table `shift_tracker_tbl_staff_role`
--

CREATE TABLE `shift_tracker_tbl_staff_role` (
  `id` int(11) NOT NULL,
  `role` varchar(60) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `shift_tracker_tbl_staff_role`
--

INSERT INTO `shift_tracker_tbl_staff_role` (`id`, `role`) VALUES
(5, 'Bedside'),
(2, 'Charge'),
(1, 'Clinician'),
(3, 'Clinician Prn'),
(6, 'NA'),
(4, 'Outreach'),
(7, 'UC');

-- --------------------------------------------------------

--
-- Table structure for table `userdemo01_tbl_users`
--

CREATE TABLE `userdemo01_tbl_users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `contact_no` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userdemo01_tbl_users`
--

INSERT INTO `userdemo01_tbl_users` (`id`, `first_name`, `last_name`, `email_id`, `contact_no`) VALUES
(21, 'Hal1', '2000', 'hal2000@badcomputer.com', 403);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_shift_entries_w_staff_w_category`
-- (See below for the actual view)
--
CREATE TABLE `v_shift_entries_w_staff_w_category` (
`id` int(11)
,`shift_date` date
,`staff_id` int(11)
,`role_id` int(11)
,`assignment_id` int(11)
,`bool_doubled` tinyint(1)
,`bool_vented` tinyint(1)
,`bool_new_admit` tinyint(1)
,`bool_very_sick` tinyint(1)
,`bool_code_pager` tinyint(1)
,`bool_crrt` tinyint(1)
,`bool_burn` tinyint(1)
,`bool_evd` tinyint(1)
,`bool_day_or_night` tinyint(1)
,`first_name` varchar(60)
,`last_name` varchar(60)
,`category_id` int(11)
,`category` varchar(60)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_shift_entries_w_staff_w_category_w_assignment_w_role`
-- (See below for the actual view)
--
CREATE TABLE `v_shift_entries_w_staff_w_category_w_assignment_w_role` (
`id` int(11)
,`shift_date` date
,`staff_id` int(11)
,`category_id` int(11)
,`role_id` int(11)
,`assignment_id` int(11)
,`bool_doubled` tinyint(1)
,`bool_vented` tinyint(1)
,`bool_new_admit` tinyint(1)
,`bool_very_sick` tinyint(1)
,`bool_code_pager` tinyint(1)
,`bool_crrt` tinyint(1)
,`bool_burn` tinyint(1)
,`bool_evd` tinyint(1)
,`bool_day_or_night` tinyint(1)
,`first_name` varchar(60)
,`last_name` varchar(60)
,`category` varchar(60)
,`assignment` varchar(60)
,`role` varchar(60)
);

-- --------------------------------------------------------

--
-- Structure for view `v_shift_entries_w_staff_w_category`
--
DROP TABLE IF EXISTS `v_shift_entries_w_staff_w_category`;

CREATE ALGORITHM=UNDEFINED DEFINER=`id1876647_neenjawtestuser`@`%` SQL SECURITY DEFINER VIEW `v_shift_entries_w_staff_w_category`  AS  select `shift_tracker_tbl_shift_entry`.`id` AS `id`,`shift_tracker_tbl_shift_entry`.`shift_date` AS `shift_date`,`shift_tracker_tbl_shift_entry`.`staff_id` AS `staff_id`,`shift_tracker_tbl_shift_entry`.`role_id` AS `role_id`,`shift_tracker_tbl_shift_entry`.`assignment_id` AS `assignment_id`,`shift_tracker_tbl_shift_entry`.`bool_doubled` AS `bool_doubled`,`shift_tracker_tbl_shift_entry`.`bool_vented` AS `bool_vented`,`shift_tracker_tbl_shift_entry`.`bool_new_admit` AS `bool_new_admit`,`shift_tracker_tbl_shift_entry`.`bool_very_sick` AS `bool_very_sick`,`shift_tracker_tbl_shift_entry`.`bool_code_pager` AS `bool_code_pager`,`shift_tracker_tbl_shift_entry`.`bool_crrt` AS `bool_crrt`,`shift_tracker_tbl_shift_entry`.`bool_burn` AS `bool_burn`,`shift_tracker_tbl_shift_entry`.`bool_evd` AS `bool_evd`,`shift_tracker_tbl_shift_entry`.`bool_day_or_night` AS `bool_day_or_night`,`shift_tracker_tbl_staff`.`first_name` AS `first_name`,`shift_tracker_tbl_staff`.`last_name` AS `last_name`,`shift_tracker_tbl_staff`.`category_id` AS `category_id`,`shift_tracker_tbl_staff_category`.`category` AS `category` from ((`shift_tracker_tbl_shift_entry` left join `shift_tracker_tbl_staff` on((`shift_tracker_tbl_shift_entry`.`staff_id` = `shift_tracker_tbl_staff`.`id`))) left join `shift_tracker_tbl_staff_category` on((`shift_tracker_tbl_staff`.`category_id` = `shift_tracker_tbl_staff_category`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_shift_entries_w_staff_w_category_w_assignment_w_role`
--
DROP TABLE IF EXISTS `v_shift_entries_w_staff_w_category_w_assignment_w_role`;

CREATE ALGORITHM=UNDEFINED DEFINER=`id1876647_neenjawtestuser`@`%` SQL SECURITY DEFINER VIEW `v_shift_entries_w_staff_w_category_w_assignment_w_role`  AS  select `v_shift_entries_w_staff_w_category`.`id` AS `id`,`v_shift_entries_w_staff_w_category`.`shift_date` AS `shift_date`,`v_shift_entries_w_staff_w_category`.`staff_id` AS `staff_id`,`v_shift_entries_w_staff_w_category`.`category_id` AS `category_id`,`v_shift_entries_w_staff_w_category`.`role_id` AS `role_id`,`v_shift_entries_w_staff_w_category`.`assignment_id` AS `assignment_id`,`v_shift_entries_w_staff_w_category`.`bool_doubled` AS `bool_doubled`,`v_shift_entries_w_staff_w_category`.`bool_vented` AS `bool_vented`,`v_shift_entries_w_staff_w_category`.`bool_new_admit` AS `bool_new_admit`,`v_shift_entries_w_staff_w_category`.`bool_very_sick` AS `bool_very_sick`,`v_shift_entries_w_staff_w_category`.`bool_code_pager` AS `bool_code_pager`,`v_shift_entries_w_staff_w_category`.`bool_crrt` AS `bool_crrt`,`v_shift_entries_w_staff_w_category`.`bool_burn` AS `bool_burn`,`v_shift_entries_w_staff_w_category`.`bool_evd` AS `bool_evd`,`v_shift_entries_w_staff_w_category`.`bool_day_or_night` AS `bool_day_or_night`,`v_shift_entries_w_staff_w_category`.`first_name` AS `first_name`,`v_shift_entries_w_staff_w_category`.`last_name` AS `last_name`,`v_shift_entries_w_staff_w_category`.`category` AS `category`,`shift_tracker_tbl_assignment`.`assignment` AS `assignment`,`shift_tracker_tbl_staff_role`.`role` AS `role` from ((`v_shift_entries_w_staff_w_category` left join `shift_tracker_tbl_assignment` on((`v_shift_entries_w_staff_w_category`.`assignment_id` = `shift_tracker_tbl_assignment`.`id`))) left join `shift_tracker_tbl_staff_role` on((`v_shift_entries_w_staff_w_category`.`role_id` = `shift_tracker_tbl_staff_role`.`id`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `shift_login_tbl_users`
--
ALTER TABLE `shift_login_tbl_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`login`),
  ADD KEY `auth_id` (`auth_id`);

--
-- Indexes for table `shift_login_tbl_user_auth`
--
ALTER TABLE `shift_login_tbl_user_auth`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shift_tracker_tbl_assignment`
--
ALTER TABLE `shift_tracker_tbl_assignment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pod_name` (`assignment`),
  ADD UNIQUE KEY `pod_name_2` (`assignment`);

--
-- Indexes for table `shift_tracker_tbl_shift_entry`
--
ALTER TABLE `shift_tracker_tbl_shift_entry`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ix_uq` (`shift_date`,`staff_id`),
  ADD KEY `FK_role_id` (`role_id`),
  ADD KEY `FK_assignment_id` (`assignment_id`),
  ADD KEY `FK_staff_id` (`staff_id`);

--
-- Indexes for table `shift_tracker_tbl_shift_entry_ref`
--
ALTER TABLE `shift_tracker_tbl_shift_entry_ref`
  ADD PRIMARY KEY (`column_name`);

--
-- Indexes for table `shift_tracker_tbl_staff`
--
ALTER TABLE `shift_tracker_tbl_staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ui` (`last_name`,`first_name`,`category_id`),
  ADD KEY `FK_staff_category` (`category_id`);

--
-- Indexes for table `shift_tracker_tbl_staff_category`
--
ALTER TABLE `shift_tracker_tbl_staff_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category` (`category`);

--
-- Indexes for table `shift_tracker_tbl_staff_role`
--
ALTER TABLE `shift_tracker_tbl_staff_role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role` (`role`);

--
-- Indexes for table `userdemo01_tbl_users`
--
ALTER TABLE `userdemo01_tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `shift_login_tbl_users`
--
ALTER TABLE `shift_login_tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `shift_login_tbl_user_auth`
--
ALTER TABLE `shift_login_tbl_user_auth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `shift_tracker_tbl_assignment`
--
ALTER TABLE `shift_tracker_tbl_assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `shift_tracker_tbl_shift_entry`
--
ALTER TABLE `shift_tracker_tbl_shift_entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=566;
--
-- AUTO_INCREMENT for table `shift_tracker_tbl_staff`
--
ALTER TABLE `shift_tracker_tbl_staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `shift_tracker_tbl_staff_category`
--
ALTER TABLE `shift_tracker_tbl_staff_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `shift_tracker_tbl_staff_role`
--
ALTER TABLE `shift_tracker_tbl_staff_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `userdemo01_tbl_users`
--
ALTER TABLE `userdemo01_tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `shift_login_tbl_users`
--
ALTER TABLE `shift_login_tbl_users`
  ADD CONSTRAINT `shift_login_tbl_users_ibfk_1` FOREIGN KEY (`auth_id`) REFERENCES `shift_login_tbl_user_auth` (`id`);

--
-- Constraints for table `shift_tracker_tbl_shift_entry`
--
ALTER TABLE `shift_tracker_tbl_shift_entry`
  ADD CONSTRAINT `FK_assignment_id` FOREIGN KEY (`assignment_id`) REFERENCES `shift_tracker_tbl_assignment` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_role_id` FOREIGN KEY (`role_id`) REFERENCES `shift_tracker_tbl_staff_role` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_staff_id` FOREIGN KEY (`staff_id`) REFERENCES `shift_tracker_tbl_staff` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shift_tracker_tbl_staff`
--
ALTER TABLE `shift_tracker_tbl_staff`
  ADD CONSTRAINT `FK_staff_category` FOREIGN KEY (`category_id`) REFERENCES `shift_tracker_tbl_staff_category` (`id`) ON UPDATE CASCADE;
