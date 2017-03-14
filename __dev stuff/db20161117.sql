-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2016 at 04:29 PM
-- Server version: 5.5.39
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
`id` smallint(8) NOT NULL,
  `user_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_password` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `real_name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=34 ;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `user_name`, `user_password`, `user_type`, `user_email`, `real_name`) VALUES
(1, 'admin', '123', '1111', '', 'Masterpiece'),
(2, 'ayanev', '123', '1111', 'ayanev@hhi-co.bg', 'A. Yanev'),
(3, 'guzunov', '123', '1111', 'guzunov@hhi-co.bg', 'G. Uzunov'),
(6, 'bbogdanov', '0411', '0000', 'bbogdanov@hhi-co.bg', 'B. Bogdanov'),
(8, 'gvalchev', '123', '', 'gvalchev@hhi-co.bg', 'G. Valchev'),
(9, 'ntodorov', '123', '', 'ntodorov@hhi-co.bg', 'N. Todorov'),
(13, 'ppaskov', '123', '1111', 'ppaskov@hhi-co.bg', 'P. Paskov'),
(14, 'atodorov', '123', '1111', 'atodorov@hhi-co.bg', 'A. Todorov'),
(15, 'gkibarov', '123', '1111', 'kibarov@hhi-co.bg', 'G. Kibarov'),
(16, 'enikolova', '123', '', 'enikolova@hhi-co.bg', 'E. Nikolova'),
(17, 'nmanev', '123', '', 'nmanev@hhi-co.bg', 'N. Manev'),
(18, 'sradeva', '123', '0111', 'sradeva@hhi-co.bg', 'S. Radeva'),
(19, 'hslavov', '123', '0000', 'hslavov@hhi-co.bg', 'H. Slavov'),
(20, 'skovacheva', '123', '', 'kovacheva@hhi-co.bg', 'S. Kovacheva'),
(21, 'ivivanov', '123', '', 'ivivanov@hhi-co.bg', 'I. Ivanov'),
(22, 'vnikolov', '123', '', 'vanikolov@hhi-co.bg', 'V. Nikolov'),
(23, 'iangelova', '123', '', 'iangelova@hhi-co.bg', 'I. Angelova'),
(24, 'gdimitrova', '123', '', 'gdimitrova@hhi-co.bg', 'G. Dimitrova'),
(25, 'ngrigorova', '123', '', 'grigorova@hhi-co.bg', 'N. Grigorova'),
(26, 'ddancheva', '123', '', 'ddancheva@hhi-co.bg', 'D. Dancheva'),
(27, 'ddrencheva', '123', '', 'drencheva@hhi-co.bg', 'D. Drencheva'),
(28, 'dpetkova', '123', '', 'dpetkova@hhi-co.bg', 'D. Petkova'),
(29, 'nstoev', '123', '', 'nstoev@hhi-co.bg', 'N. Stoev'),
(30, 'sandreev', '123', '', 'sandreev@hhi-co.bg', 'S. Andreev'),
(31, 'palexandrov', '3445', '', 'palexandrov@hhi-co.bg', 'P. Alexandrov');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE IF NOT EXISTS `offers` (
`id` int(16) NOT NULL,
  `number` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rev` int(2) NOT NULL,
  `create_date` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_by` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `history` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `approve` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=120 ;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `number`, `rev`, `create_date`, `create_by`, `comment`, `history`, `approve`) VALUES
(118, 'RM-16-RU-GK-403', 0, '2016-11-17 16:06', 'G. Uzunov', '', '[2016-11-17 16:23] [G. Uzunov] [Ð¾Ñ‚ÐºÐ». Ð½Ð° ÐµÑ‚Ð°Ð¿: . ÑÐ¼ÐµÐ½ÐµÐ½ ÑÑ‚Ð°Ñ‚ÑƒÑ Ð½Ð°: Ð—Ð° ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ - 7. Ð£Ñ‚Ð²ÑŠÑ€Ð¶Ð´Ð°Ð²Ð°Ð½Ðµ (Ð—Ð° Ð¸Ð·Ð¿Ñ€Ð°Ñ‰Ð°Ð½Ðµ)].\r\n[2016-11-17 16:23] [G. Uzunov] [Ð¾Ñ‚ÐºÐ». Ð½Ð° ÐµÑ‚Ð°Ð¿: . ÑÐ¼ÐµÐ½ÐµÐ½ ÑÑ‚Ð°Ñ‚ÑƒÑ Ð½Ð°: Ð—Ð° ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ - 4. ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ ÐœÐ—].\r\n[2016-11-17 16:23] [G. Uzunov] [Ð¾Ñ‚ÐºÐ». Ð½Ð° ÐµÑ‚Ð°Ð¿: . ÑÐ¼ÐµÐ½ÐµÐ½ ÑÑ‚Ð°Ñ‚ÑƒÑ Ð½Ð°: Ð—Ð° ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ - 3. ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ Ð¡Ð ].\r\n[2016-11-17 16:07] [G. Uzunov] [ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð° - 7. Ð£Ñ‚Ð²ÑŠÑ€Ð¶Ð´Ð°Ð²Ð°Ð½Ðµ (Ð—Ð° Ð¸Ð·Ð¿Ñ€Ð°Ñ‰Ð°Ð½Ðµ)].\r\n[2016-11-17 16:07] [G. Uzunov] [ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð° - 4. ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ ÐœÐ—].\r\n[2016-11-17 16:07] [G. Uzunov] [ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð° - 3. ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ Ð¡Ð ].\r\n[2016-11-17 16:07] [G. Uzunov] [Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚ÐµÐ½Ð° - 2. Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚Ð²Ð°Ð½Ðµ ÐœÐ—].\r\n[2016-11-17 16:07] [G. Uzunov] [Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚ÐµÐ½Ð° - 1. Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚Ð²Ð°Ð½Ðµ Ð¡Ð ].\r\n[2016-11-17 16:06] [G. Uzunov] [ÑÑŠÐ·Ð´Ð°Ð´ÐµÐ½Ð°].\r\n', 'a:5:{i:0;a:6:{s:13:"approveStatus";s:20:"Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚ÐµÐ½Ð°";s:11:"stageNumber";s:1:"1";s:10:"stageTitle";s:27:"Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚Ð²Ð°Ð½Ðµ Ð¡Ð ";s:10:"approvedBy";s:9:"G. Uzunov";s:12:"approvedDate";s:16:"2016-11-17 16:07";s:14:"approveComment";s:0:"";}i:1;a:6:{s:13:"approveStatus";s:20:"Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚ÐµÐ½Ð°";s:11:"stageNumber";s:1:"2";s:10:"stageTitle";s:27:"Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚Ð²Ð°Ð½Ðµ ÐœÐ—";s:10:"approvedBy";s:9:"G. Uzunov";s:12:"approvedDate";s:16:"2016-11-17 16:07";s:14:"approveComment";s:0:"";}i:2;a:6:{s:13:"approveStatus";s:23:"Ð—Ð° ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ";s:11:"stageNumber";s:1:"3";s:10:"stageTitle";s:23:"ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ Ð¡Ð ";s:10:"approvedBy";s:0:"";s:12:"approvedDate";s:16:"2016-11-17 16:23";s:14:"approveComment";s:26:"[Ð¾ÐºÐ». Ð¾Ñ‚: G. Uzunov] ";}i:3;a:6:{s:13:"approveStatus";s:23:"Ð—Ð° ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ";s:11:"stageNumber";s:1:"4";s:10:"stageTitle";s:23:"ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ ÐœÐ—";s:10:"approvedBy";s:0:"";s:12:"approvedDate";s:16:"2016-11-17 16:23";s:14:"approveComment";s:26:"[Ð¾ÐºÐ». Ð¾Ñ‚: G. Uzunov] ";}i:4;a:6:{s:13:"approveStatus";s:23:"Ð—Ð° ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ";s:11:"stageNumber";s:1:"7";s:10:"stageTitle";s:50:"Ð£Ñ‚Ð²ÑŠÑ€Ð¶Ð´Ð°Ð²Ð°Ð½Ðµ (Ð—Ð° Ð¸Ð·Ð¿Ñ€Ð°Ñ‰Ð°Ð½Ðµ)";s:10:"approvedBy";s:0:"";s:12:"approvedDate";s:16:"2016-11-17 16:23";s:14:"approveComment";s:26:"[Ð¾ÐºÐ». Ð¾Ñ‚: G. Uzunov] ";}}'),
(119, 'RM-16-RU-GK-333', 0, '2016-11-17 16:10', 'Masterpiece', '', '[2016-11-17 16:25] [Masterpiece] [ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð° - 5. Ð£Ñ‚Ð²ÑŠÑ€Ð¶Ð´Ð°Ð²Ð°Ð½Ðµ (Ð—Ð° Ð¸Ð·Ð¿Ñ€Ð°Ñ‰Ð°Ð½Ðµ)].\r\n[2016-11-17 16:25] [Masterpiece] [ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð° - 4. ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ ÐœÐ—].\r\n[2016-11-17 16:25] [Masterpiece] [ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð° - 3. ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ Ð¡Ð ].\r\n[2016-11-17 16:25] [Masterpiece] [Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚ÐµÐ½Ð° - 2. Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚Ð²Ð°Ð½Ðµ ÐœÐ—].\r\n[2016-11-17 16:25] [Masterpiece] [Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚ÐµÐ½Ð° - 1. Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚Ð²Ð°Ð½Ðµ Ð¡Ð ].\r\n[2016-11-17 16:10] [Masterpiece] [ÑÑŠÐ·Ð´Ð°Ð´ÐµÐ½Ð° Rev.8 Ð½Ð° Ð±Ð°Ð·Ð° Ð¸Ð½Ñ„Ð¾. Ð¾Ñ‚ Rev.7].\r\n', 'a:5:{i:0;a:6:{s:13:"approveStatus";s:20:"Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚ÐµÐ½Ð°";s:11:"stageNumber";s:1:"1";s:10:"stageTitle";s:27:"Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚Ð²Ð°Ð½Ðµ Ð¡Ð ";s:10:"approvedBy";s:11:"Masterpiece";s:12:"approvedDate";s:16:"2016-11-17 16:25";s:14:"approveComment";s:0:"";}i:1;a:6:{s:13:"approveStatus";s:20:"Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚ÐµÐ½Ð°";s:11:"stageNumber";s:1:"2";s:10:"stageTitle";s:27:"Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚Ð²Ð°Ð½Ðµ ÐœÐ—";s:10:"approvedBy";s:11:"Masterpiece";s:12:"approvedDate";s:16:"2016-11-17 16:25";s:14:"approveComment";s:0:"";}i:2;a:6:{s:13:"approveStatus";s:16:"ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð°";s:11:"stageNumber";s:1:"3";s:10:"stageTitle";s:23:"ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ Ð¡Ð ";s:10:"approvedBy";s:11:"Masterpiece";s:12:"approvedDate";s:16:"2016-11-17 16:25";s:14:"approveComment";s:0:"";}i:3;a:6:{s:13:"approveStatus";s:16:"ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð°";s:11:"stageNumber";s:1:"4";s:10:"stageTitle";s:23:"ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ ÐœÐ—";s:10:"approvedBy";s:11:"Masterpiece";s:12:"approvedDate";s:16:"2016-11-17 16:25";s:14:"approveComment";s:0:"";}i:4;a:6:{s:13:"approveStatus";s:16:"ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð°";s:11:"stageNumber";s:1:"5";s:10:"stageTitle";s:50:"Ð£Ñ‚Ð²ÑŠÑ€Ð¶Ð´Ð°Ð²Ð°Ð½Ðµ (Ð—Ð° Ð¸Ð·Ð¿Ñ€Ð°Ñ‰Ð°Ð½Ðµ)";s:10:"approvedBy";s:11:"Masterpiece";s:12:"approvedDate";s:16:"2016-11-17 16:25";s:14:"approveComment";s:0:"";}}');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
`id` int(16) NOT NULL,
  `number` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rev` tinyint(2) DEFAULT NULL,
  `create_date` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_by` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `send_date` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `send_by` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `history` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ico_preparedby` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ico_approvedby` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ico_subject` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ico_client` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ico_clientcountry` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ico_enduser` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ico_endusercountry` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ico_amount` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ico_amountcurrency` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ico_scopeofsupply` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ico_factorytests` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ico_deliveryterms` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ico_meansoftransport` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ico_warrantyperiod` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ico_attachments` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ico_notes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ico_shippingdocuments` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ico_paymentway` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `approve` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=197 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `number`, `rev`, `create_date`, `create_by`, `send_date`, `send_by`, `comment`, `history`, `ico_preparedby`, `ico_approvedby`, `ico_subject`, `ico_client`, `ico_clientcountry`, `ico_enduser`, `ico_endusercountry`, `ico_amount`, `ico_amountcurrency`, `ico_scopeofsupply`, `ico_factorytests`, `ico_deliveryterms`, `ico_meansoftransport`, `ico_warrantyperiod`, `ico_attachments`, `ico_notes`, `ico_shippingdocuments`, `ico_paymentway`, `approve`) VALUES
(191, 'RS-16-100', 0, '2016-11-17 11:44', 'WEB MASTER', '', '', '', '[2016-11-17 11:55] [WEB MASTER] [Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚ÐµÐ½Ð° - 7. Ð£Ñ‚Ð²ÑŠÑ€Ð¶Ð´Ð°Ð²Ð°Ð½Ðµ Ð½Ð° ÐŸÐŸ].\r\n[2016-11-17 11:55] [WEB MASTER] [ÐžÑ‚ÐºÐ°Ð·Ð°Ð½Ð¾ ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ - 7. Ð£Ñ‚Ð²ÑŠÑ€Ð¶Ð´Ð°Ð²Ð°Ð½Ðµ Ð½Ð° ÐŸÐŸ].\r\n[2016-11-17 11:53] [G. Uzunov] [ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð° - 6. ÐŸÐŸ ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ ÐœÐ—].\r\n[2016-11-17 11:47] [WEB MASTER] [ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð° - 5. ÐŸÐŸ ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ Ð¡Ð ].\r\n[2016-11-17 11:47] [WEB MASTER] [Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚ÐµÐ½Ð° - 4. ÐŸÐŸ Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚Ð²Ð°Ð½Ðµ ÐœÐ—].\r\n[2016-11-17 11:47] [WEB MASTER] [Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚ÐµÐ½Ð° - 3. ÐŸÐŸ Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚Ð²Ð°Ð½Ðµ Ð¡Ð ].\r\n[2016-11-17 11:46] [WEB MASTER] [ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð° - 2. ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ Ð’Ð¤ÐŸ].\r\n[2016-11-17 11:44] [WEB MASTER] [ÑÑŠÐ·Ð´Ð°Ð´ÐµÐ½Ð° Rev.4 Ð½Ð° Ð±Ð°Ð·Ð° Ð¸Ð½Ñ„Ð¾. Ð¾Ñ‚ Rev.2].\r\n', 'G. Uzunov', '', '', '', '', '', '', '0', 'EUR', 'a:1:{i:0;a:16:{s:5:"sos01";s:0:"";s:5:"sos02";s:0:"";s:5:"sos03";s:0:"";s:5:"sos04";s:0:"";s:5:"sos05";s:3:"1\r\n";s:5:"sos06";s:3:"1\r\n";s:5:"sos07";s:3:"1\r\n";s:5:"sos08";s:3:"1\r\n";s:5:"sos09";s:3:"1\r\n";s:5:"sos10";s:3:"1\r\n";s:5:"sos11";s:3:"1\r\n";s:5:"sos12";s:3:"1\r\n";s:5:"sos13";s:3:"1\r\n";s:5:"sos14";s:3:"1\r\n";s:5:"sos15";s:0:"";s:5:"sos16";s:0:"";}}', '', '', '', '', '', '', '', '', 'a:7:{i:0;a:6:{s:13:"approveStatus";s:20:"Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚ÐµÐ½Ð°";s:11:"stageNumber";s:1:"1";s:10:"stageTitle";s:25:"Ð˜Ð·Ð³Ð¾Ñ‚Ð²ÑÐ½Ðµ Ð’Ð¤ÐŸ";s:10:"approvedBy";s:10:"WEB MASTER";s:12:"approvedDate";s:16:"2016-11-17 11:44";s:14:"approveComment";s:0:"";}i:1;a:6:{s:13:"approveStatus";s:16:"ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð°";s:11:"stageNumber";s:1:"2";s:10:"stageTitle";s:25:"ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ Ð’Ð¤ÐŸ";s:10:"approvedBy";s:10:"WEB MASTER";s:12:"approvedDate";s:16:"2016-11-17 11:46";s:14:"approveComment";s:0:"";}i:2;a:6:{s:13:"approveStatus";s:20:"Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚ÐµÐ½Ð°";s:11:"stageNumber";s:1:"3";s:10:"stageTitle";s:32:"ÐŸÐŸ Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚Ð²Ð°Ð½Ðµ Ð¡Ð ";s:10:"approvedBy";s:10:"WEB MASTER";s:12:"approvedDate";s:16:"2016-11-17 11:47";s:14:"approveComment";s:0:"";}i:3;a:6:{s:13:"approveStatus";s:20:"Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚ÐµÐ½Ð°";s:11:"stageNumber";s:1:"4";s:10:"stageTitle";s:32:"ÐŸÐŸ Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚Ð²Ð°Ð½Ðµ ÐœÐ—";s:10:"approvedBy";s:10:"WEB MASTER";s:12:"approvedDate";s:16:"2016-11-17 11:47";s:14:"approveComment";s:0:"";}i:4;a:6:{s:13:"approveStatus";s:16:"ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð°";s:11:"stageNumber";s:1:"5";s:10:"stageTitle";s:28:"ÐŸÐŸ ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ Ð¡Ð ";s:10:"approvedBy";s:10:"WEB MASTER";s:12:"approvedDate";s:16:"2016-11-17 11:47";s:14:"approveComment";s:0:"";}i:5;a:6:{s:13:"approveStatus";s:16:"ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð°";s:11:"stageNumber";s:1:"6";s:10:"stageTitle";s:28:"ÐŸÐŸ ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ ÐœÐ—";s:10:"approvedBy";s:9:"G. Uzunov";s:12:"approvedDate";s:16:"2016-11-17 11:53";s:14:"approveComment";s:34:"ÐÐ°ÑÐºÐ¾ Ðµ Ð¿Ñ€Ð¾Ð³Ñ€Ð°Ð¼Ð¸ÑÑ‚";}i:6;a:6:{s:13:"approveStatus";s:20:"Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚ÐµÐ½Ð°";s:11:"stageNumber";s:1:"7";s:10:"stageTitle";s:34:"Ð£Ñ‚Ð²ÑŠÑ€Ð¶Ð´Ð°Ð²Ð°Ð½Ðµ Ð½Ð° ÐŸÐŸ";s:10:"approvedBy";s:10:"WEB MASTER";s:12:"approvedDate";s:16:"2016-11-17 11:55";s:14:"approveComment";s:3:"123";}}'),
(195, 'RS-16-101', 0, '2016-11-17 14:05', 'Masterpiece', '', '', '', '[2016-11-17 14:05] [Masterpiece] [ÑÑŠÐ·Ð´Ð°Ð´ÐµÐ½Ð° Rev.7 Ð½Ð° Ð±Ð°Ð·Ð° Ð¸Ð½Ñ„Ð¾. Ð¾Ñ‚ Rev.6].\r\n', 'M. Arsenova', '', 'ÐŸÑ€Ð¾Ð¸Ð·Ð²Ð¾Ð´ÑÑ‚Ð²Ð¾ Ð½Ð° ÑÑ‚ÑŠÐ¿Ð°Ð»Ð½Ð¸ Ñ€ÐµÐ³ÑƒÐ»Ð°Ñ‚Ð¾Ñ€Ð¸', 'ÐžÐžÐž Ð¢Ð¾Ð»Ð¸Ð°Ñ‚Ð¸Ð½ÑÐºÐ¸ Ð¢Ñ€Ð°Ð½ÑÑ„Ð¾Ñ€Ð¼Ð°Ñ‚Ð¾Ñ€ - Ð³Ñ€. Ð¢Ð¾Ð»Ð¸Ð°Ñ‚Ð¸', 'Ð ÑƒÑÐ¸Ñ', 'ÐžÐžÐž Ð¢Ð¾Ð»Ð¸Ð°Ñ‚Ð¸Ð½ÑÐºÐ¸ Ð¢Ñ€Ð°Ð½ÑÑ„Ð¾Ñ€Ð¼Ð°Ñ‚Ð¾Ñ€ - Ð³Ñ€. Ð¢Ð¾Ð»Ð¸Ð°Ñ‚Ð¸', 'Ð ÑƒÑÐ¸Ñ', '16000', 'EUR', 'a:2:{i:0;a:16:{s:5:"sos01";s:1:"1";s:5:"sos02";s:1:"3";s:5:"sos03";s:4:"5000";s:5:"sos04";s:10:"2016-11-07";s:5:"sos05";s:5:"RS5\r\n";s:5:"sos06";s:4:"II\r\n";s:5:"sos07";s:5:"400\r\n";s:5:"sos08";s:5:"245\r\n";s:5:"sos09";s:6:"41,5\r\n";s:5:"sos10";s:4:"12\r\n";s:5:"sos11";s:4:"11\r\n";s:5:"sos12";s:4:"ME\r\n";s:5:"sos13";s:4:"MZ\r\n";s:5:"sos14";s:8:"4.1.1T\r\n";s:5:"sos15";s:36:"Ð¼Ð¾Ð½Ð¸Ñ‚Ð¾Ñ€Ð¸Ð½Ð³Ð¾Ð²Ð° ITMS 1000";s:5:"sos16";s:27:"Ñ€ÐµÐ·ÐµÑ€Ð²Ð½Ð¸ Ñ‡Ð°ÑÑ‚Ð¸";}i:1;a:16:{s:5:"sos01";s:1:"2";s:5:"sos02";s:1:"1";s:5:"sos03";s:4:"1000";s:5:"sos04";s:10:"2016-11-07";s:5:"sos05";s:5:"PBV\r\n";s:5:"sos06";s:6:"02.1\r\n";s:5:"sos07";s:3:"2\r\n";s:5:"sos08";s:6:"41,5\r\n";s:5:"sos09";s:6:"17,5\r\n";s:5:"sos10";s:4:"09\r\n";s:5:"sos11";s:5:"020\r\n";s:5:"sos12";s:4:"MD\r\n";s:5:"sos13";s:4:"MZ\r\n";s:5:"sos14";s:5:"4,1\r\n";s:5:"sos15";s:0:"";s:5:"sos16";s:27:"Ñ€ÐµÐ·ÐµÑ€Ð²Ð½Ð° Ñ€ÑŠÑ‡ÐºÐ°";}}', '', 'FCA - Ð¡Ð¾Ñ„Ð¸Ñ', 'ÐÐ²Ñ‚Ð¾Ð¼Ð¾Ð±Ð¸Ð»ÐµÐ½', '18/24', 'Ð¡Ð».Ð±ÐµÐ»ÐµÐ¶ÐºÐ° â„– 363/22.08.2016', '1. Ð¡ÐµÑ€Ñ‚Ð¸Ñ„Ð¸ÐºÐ°Ñ‚ Ð·Ð° ÐºÐ°Ñ‡ÐµÑÑ‚Ð²Ð¾ - 5 ÐµÐºÐ·. Ð½Ð° Ñ€ÑƒÑÐºÐ¸ ÐµÐ·Ð¸Ðº\r\n2. Ð’ÑŠÐ¿Ñ€Ð¾ÑÐ½Ð¸Ñ‚Ðµ Ð»Ð¸ÑÑ‚Ð° Ñ‰Ðµ Ð±ÑŠÐ´Ð°Ñ‚ Ð¸Ð·Ð¿Ñ€Ð°Ñ‚ÐµÐ½Ð¸ Ð² Ð¢Ð”Ð•Ð Ð¿Ð¾ Ð¸Ð¼ÐµÐ¹Ð»', '1. Ð¤Ð°ÐºÑ‚ÑƒÑ€Ð°\r\n2. ÐžÐ¿Ð°ÐºÐ¾Ð²ÑŠÑ‡ÐµÐ½ Ð»Ð¸ÑÑ‚\r\n3. Ð¡ÐµÑ€Ñ‚Ð¸Ñ„Ð¸ÐºÐ°Ñ‚ Ð·Ð° ÐºÐ°Ñ‡ÐµÑÑ‚Ð²Ð¾\r\n(Ð²ÑÐ¸Ñ‡ÐºÐ¸ Ð´Ð¾ÐºÑƒÐ¼ÐµÐ½Ñ‚Ð¸ Ð´Ð° ÑÐ° Ð½Ð° Ñ€ÑƒÑÐºÐ¸ ÐµÐ·Ð¸Ðº)', '100% 60 Ð´Ð½Ð¸ ÑÐ»ÐµÐ´ ÐµÐºÑÐ¿ÐµÐ´Ð¸Ñ†Ð¸ÑÑ‚Ð°', 'a:7:{i:0;a:6:{s:13:"approveStatus";s:20:"Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚ÐµÐ½Ð°";s:11:"stageNumber";s:1:"1";s:10:"stageTitle";s:25:"Ð˜Ð·Ð³Ð¾Ñ‚Ð²ÑÐ½Ðµ Ð’Ð¤ÐŸ";s:10:"approvedBy";s:11:"Masterpiece";s:12:"approvedDate";s:16:"2016-11-17 14:05";s:14:"approveComment";s:0:"";}i:1;a:6:{s:13:"approveStatus";s:23:"Ð—Ð° ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ";s:11:"stageNumber";s:1:"2";s:10:"stageTitle";s:25:"ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ Ð’Ð¤ÐŸ";s:10:"approvedBy";s:0:"";s:12:"approvedDate";s:0:"";s:14:"approveComment";s:0:"";}i:2;a:6:{s:13:"approveStatus";s:27:"Ð—Ð° Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚Ð²Ð°Ð½Ðµ";s:11:"stageNumber";s:1:"3";s:10:"stageTitle";s:32:"ÐŸÐŸ Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚Ð²Ð°Ð½Ðµ Ð¡Ð ";s:10:"approvedBy";s:0:"";s:12:"approvedDate";s:0:"";s:14:"approveComment";s:0:"";}i:3;a:6:{s:13:"approveStatus";s:27:"Ð—Ð° Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚Ð²Ð°Ð½Ðµ";s:11:"stageNumber";s:1:"4";s:10:"stageTitle";s:32:"ÐŸÐŸ Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚Ð²Ð°Ð½Ðµ ÐœÐ—";s:10:"approvedBy";s:0:"";s:12:"approvedDate";s:0:"";s:14:"approveComment";s:0:"";}i:4;a:6:{s:13:"approveStatus";s:23:"Ð—Ð° ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ";s:11:"stageNumber";s:1:"5";s:10:"stageTitle";s:28:"ÐŸÐŸ ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ Ð¡Ð ";s:10:"approvedBy";s:0:"";s:12:"approvedDate";s:0:"";s:14:"approveComment";s:0:"";}i:5;a:6:{s:13:"approveStatus";s:23:"Ð—Ð° ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ";s:11:"stageNumber";s:1:"6";s:10:"stageTitle";s:28:"ÐŸÐŸ ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ ÐœÐ—";s:10:"approvedBy";s:0:"";s:12:"approvedDate";s:0:"";s:14:"approveComment";s:0:"";}i:6;a:6:{s:13:"approveStatus";s:23:"Ð—Ð° ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ";s:11:"stageNumber";s:1:"7";s:10:"stageTitle";s:34:"Ð£Ñ‚Ð²ÑŠÑ€Ð¶Ð´Ð°Ð²Ð°Ð½Ðµ Ð½Ð° ÐŸÐŸ";s:10:"approvedBy";s:0:"";s:12:"approvedDate";s:0:"";s:14:"approveComment";s:0:"";}}'),
(196, 'RS-16-102', 0, '2016-11-17 14:06', 'Masterpiece', '', '', '', '[2016-11-17 14:51] [G. Uzunov] [Ð¾Ñ‚ÐºÐ». Ð½Ð° ÐµÑ‚Ð°Ð¿: . ÑÐ¼ÐµÐ½ÐµÐ½ ÑÑ‚Ð°Ñ‚ÑƒÑ Ð½Ð°: Ð—Ð° ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ - 6. ÐŸÐŸ ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ ÐœÐ—].\r\n[2016-11-17 14:51] [G. Uzunov] [ÐžÑ‚ÐºÐ°Ð·Ð°Ð½Ð¾ ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ - 7. Ð£Ñ‚Ð²ÑŠÑ€Ð¶Ð´Ð°Ð²Ð°Ð½Ðµ Ð½Ð° ÐŸÐŸ].\r\n[2016-11-17 14:50] [G. Uzunov] [ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð° - 6. ÐŸÐŸ ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ ÐœÐ—].\r\n[2016-11-17 14:50] [G. Uzunov] [ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð° - 5. ÐŸÐŸ ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ Ð¡Ð ].\r\n[2016-11-17 14:50] [G. Uzunov] [ÐŸÑ€ÐµÐ¼Ð°Ñ…Ð½Ð° ÐµÑ‚Ð°Ð¿: 4. ÐŸÐ Ð•ÐœÐÐ¥ÐÐÐ¢ Ð•Ð¢ÐÐŸ].\r\n[2016-11-17 14:50] [G. Uzunov] [Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚ÐµÐ½Ð° - 3. ÐŸÐŸ Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚Ð²Ð°Ð½Ðµ Ð¡Ð ].\r\n[2016-11-17 14:50] [G. Uzunov] [ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð° - 2. ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ Ð’Ð¤ÐŸ].\r\n[2016-11-17 14:50] [G. Uzunov] [Ð¾Ñ‚ÐºÐ». Ð½Ð° ÐµÑ‚Ð°Ð¿: . ÑÐ¼ÐµÐ½ÐµÐ½ ÑÑ‚Ð°Ñ‚ÑƒÑ Ð½Ð°: Ð—Ð° ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ - 2. ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ Ð’Ð¤ÐŸ].\r\n[2016-11-17 14:49] [G. Uzunov] [ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð° - 2. ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ Ð’Ð¤ÐŸ].\r\n[2016-11-17 14:06] [Masterpiece] [ÑÑŠÐ·Ð´Ð°Ð´ÐµÐ½Ð° Rev.2 Ð½Ð° Ð±Ð°Ð·Ð° Ð¸Ð½Ñ„Ð¾. Ð¾Ñ‚ Rev.1].\r\n', 'WEB MASTER', '', '', '', '', '', '', '0', 'EUR', 'a:1:{i:0;a:16:{s:5:"sos01";s:0:"";s:5:"sos02";s:0:"";s:5:"sos03";s:0:"";s:5:"sos04";s:0:"";s:5:"sos05";s:3:"1\r\n";s:5:"sos06";s:3:"1\r\n";s:5:"sos07";s:3:"1\r\n";s:5:"sos08";s:3:"1\r\n";s:5:"sos09";s:3:"1\r\n";s:5:"sos10";s:3:"1\r\n";s:5:"sos11";s:3:"1\r\n";s:5:"sos12";s:3:"1\r\n";s:5:"sos13";s:3:"1\r\n";s:5:"sos14";s:3:"1\r\n";s:5:"sos15";s:0:"";s:5:"sos16";s:0:"";}}', '', '', '', '', '', '', '', '', 'a:7:{i:0;a:6:{s:13:"approveStatus";s:20:"Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚ÐµÐ½Ð°";s:11:"stageNumber";s:1:"1";s:10:"stageTitle";s:25:"Ð˜Ð·Ð³Ð¾Ñ‚Ð²ÑÐ½Ðµ Ð’Ð¤ÐŸ";s:10:"approvedBy";s:11:"Masterpiece";s:12:"approvedDate";s:16:"2016-11-17 14:06";s:14:"approveComment";s:0:"";}i:1;a:6:{s:13:"approveStatus";s:16:"ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð°";s:11:"stageNumber";s:1:"2";s:10:"stageTitle";s:25:"ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ Ð’Ð¤ÐŸ";s:10:"approvedBy";s:9:"G. Uzunov";s:12:"approvedDate";s:16:"2016-11-17 14:50";s:14:"approveComment";s:0:"";}i:2;a:6:{s:13:"approveStatus";s:20:"Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚ÐµÐ½Ð°";s:11:"stageNumber";s:1:"3";s:10:"stageTitle";s:32:"ÐŸÐŸ Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚Ð²Ð°Ð½Ðµ Ð¡Ð ";s:10:"approvedBy";s:9:"G. Uzunov";s:12:"approvedDate";s:16:"2016-11-17 14:50";s:14:"approveComment";s:0:"";}i:3;a:6:{s:13:"approveStatus";s:16:"ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð°";s:11:"stageNumber";s:1:"4";s:10:"stageTitle";s:27:"ÐŸÐ Ð•ÐœÐÐ¥ÐÐÐ¢ Ð•Ð¢ÐÐŸ";s:10:"approvedBy";s:9:"G. Uzunov";s:12:"approvedDate";s:16:"2016-11-17 14:50";s:14:"approveComment";s:32:"[ÐŸÑ€ÐµÐ¼Ð°Ñ…Ð½Ð°Ñ‚: G. Uzunov] ";}i:4;a:6:{s:13:"approveStatus";s:16:"ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð°";s:11:"stageNumber";s:1:"5";s:10:"stageTitle";s:28:"ÐŸÐŸ ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ Ð¡Ð ";s:10:"approvedBy";s:9:"G. Uzunov";s:12:"approvedDate";s:16:"2016-11-17 14:50";s:14:"approveComment";s:0:"";}i:5;a:6:{s:13:"approveStatus";s:23:"Ð—Ð° ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ";s:11:"stageNumber";s:1:"6";s:10:"stageTitle";s:28:"ÐŸÐŸ ÐžÐ´Ð¾Ð±Ñ€ÐµÐ½Ð¸Ðµ ÐœÐ—";s:10:"approvedBy";s:0:"";s:12:"approvedDate";s:16:"2016-11-17 14:51";s:14:"approveComment";s:26:"[Ð¾ÐºÐ». Ð¾Ñ‚: G. Uzunov] ";}i:6;a:6:{s:13:"approveStatus";s:27:"Ð—Ð° Ð˜Ð·Ñ€Ð°Ð±Ð¾Ñ‚Ð²Ð°Ð½Ðµ";s:11:"stageNumber";s:1:"7";s:10:"stageTitle";s:34:"Ð£Ñ‚Ð²ÑŠÑ€Ð¶Ð´Ð°Ð²Ð°Ð½Ðµ Ð½Ð° ÐŸÐŸ";s:10:"approvedBy";s:0:"";s:12:"approvedDate";s:0:"";s:14:"approveComment";s:4:"test";}}');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
MODIFY `id` smallint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
MODIFY `id` int(16) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=120;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
MODIFY `id` int(16) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=197;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
