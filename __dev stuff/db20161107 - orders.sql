-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2016 at 03:13 PM
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
  `ico_paymentway` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=126 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `number`, `rev`, `create_date`, `create_by`, `send_date`, `send_by`, `comment`, `history`, `ico_preparedby`, `ico_approvedby`, `ico_subject`, `ico_client`, `ico_clientcountry`, `ico_enduser`, `ico_endusercountry`, `ico_amount`, `ico_amountcurrency`, `ico_scopeofsupply`, `ico_factorytests`, `ico_deliveryterms`, `ico_meansoftransport`, `ico_warrantyperiod`, `ico_attachments`, `ico_notes`, `ico_shippingdocuments`, `ico_paymentway`) VALUES
(96, 'RS-16-444', 0, '2016-08-29 10:00', 'A. Yanev', '', '', 'Ð¡Ð¿Ð¾Ñ€ÐµÐ´ Ð¼ÐµÐ½ ÐºÑŠÐ¼ Ð¿Ñ€Ð¸Ð»Ð¾Ð¶ÐµÐ½Ð¸ÑÑ‚Ð° Ð½Ðµ Ðµ Ð½ÑƒÐ¶Ð½Ð¾ Ð´Ð° ÑÐµ Ð´Ð¾Ð±Ð°Ð²Ñ ÑÐ».Ð±ÐµÐ»ÐµÐ¶ÐºÐ°, Ñ‚ÑŠÐ¹ ÐºÐ°Ñ‚Ð¾ Ð³Ð¸ Ð¾Ð±ÐµÐ´Ð¸Ð½ÑÐ²Ð°Ð¼Ðµ ÐºÐ°Ñ‚Ð¾ Ð´Ð¾ÐºÑƒÐ¼ÐµÐ½Ñ‚Ð¸, Ð.Ð¯Ð½ÐµÐ².', '[2016-11-07 15:13] [WEB MASTER] [Ð ÐµÐ´Ð°ÐºÑ‚Ð¸Ñ€Ð°Ð½Ðµ Ð½Ð° Ð’Ð¤ÐŸ RS-16-444 Rev.0].\r\n[2016-11-07 15:06] [WEB MASTER] [Ð ÐµÐ´Ð°ÐºÑ‚Ð¸Ñ€Ð°Ð½Ðµ Ð½Ð° Ð’Ð¤ÐŸ RS-16-444 Rev.0].\r\n[2016-11-07 14:57] [WEB MASTER] [Ð ÐµÐ´Ð°ÐºÑ‚Ð¸Ñ€Ð°Ð½Ðµ Ð½Ð° Ð’Ð¤ÐŸ RS-16-444 Rev.0].\r\n[2016-11-07 14:46] [WEB MASTER] [Ð ÐµÐ´Ð°ÐºÑ‚Ð¸Ñ€Ð°Ð½Ðµ Ð½Ð° Ð’Ð¤ÐŸ RS-16-444 Rev.0].\r\n[2016-11-07 14:30] [WEB MASTER] [Ð ÐµÐ´Ð°ÐºÑ‚Ð¸Ñ€Ð°Ð½Ðµ Ð½Ð° Ð’Ð¤ÐŸ RS-16-444 Rev.0].\r\n[2016-10-20 13:29] [A. Yanev] [Ð ÐµÐ´Ð°ÐºÑ‚Ð¸Ñ€Ð°Ð½Ðµ Ð½Ð° Ð’Ð¤ÐŸ RS-16-444 Rev.0].\r\n[2016-10-20 13:05] [A. Yanev] [Ð ÐµÐ´Ð°ÐºÑ‚Ð¸Ñ€Ð°Ð½Ðµ Ð½Ð° Ð’Ð¤ÐŸ RS-16-444 Rev.0].\r\n[2016-10-20 12:55] [A. Yanev] [ÐºÐ°Ñ‡Ð¸ (ÐŸÐŸ): EP_444_CQ5.AM0T.I.EJ_RUS_19_Russia_monitoringova.zip].\r\n[2016-10-20 12:55] [A. Yanev] [ÐºÐ°Ñ‡Ð¸ (ÐŸÐŸ): RS-16-444-REV.0 (PO, signatures).pdf].\r\n[2016-10-20 12:40] [A. Yanev] [ÐºÐ°Ñ‡Ð¸: RS-16-444-REV.0.pdf].\r\n[2016-10-20 12:37] [A. Yanev] [ÑÑŠÐ·Ð´Ð°Ð´ÐµÐ½Ð°].\r\n', 'M. Arsenova', '', 'ÐŸÑ€Ð¾Ð¸Ð·Ð²Ð¾Ð´ÑÑ‚Ð²Ð¾ Ð½Ð° ÑÑ‚ÑŠÐ¿Ð°Ð»Ð½Ð¸ Ñ€ÐµÐ³ÑƒÐ»Ð°Ñ‚Ð¾Ñ€Ð¸', 'ÐžÐžÐž Ð¢Ð¾Ð»Ð¸Ð°Ñ‚Ð¸Ð½ÑÐºÐ¸ Ð¢Ñ€Ð°Ð½ÑÑ„Ð¾Ñ€Ð¼Ð°Ñ‚Ð¾Ñ€ - Ð³Ñ€. Ð¢Ð¾Ð»Ð¸Ð°Ñ‚Ð¸', 'Ð ÑƒÑÐ¸Ñ', 'ÐžÐžÐž Ð¢Ð¾Ð»Ð¸Ð°Ñ‚Ð¸Ð½ÑÐºÐ¸ Ð¢Ñ€Ð°Ð½ÑÑ„Ð¾Ñ€Ð¼Ð°Ñ‚Ð¾Ñ€ - Ð³Ñ€. Ð¢Ð¾Ð»Ð¸Ð°Ñ‚Ð¸', 'Ð ÑƒÑÐ¸Ñ', '16000', 'EUR', 'a:2:{i:0;a:16:{s:5:"sos01";s:1:"1";s:5:"sos02";s:1:"3";s:5:"sos03";s:4:"5000";s:5:"sos04";s:10:"2016-11-07";s:5:"sos05";s:5:"RS5\r\n";s:5:"sos06";s:4:"II\r\n";s:5:"sos07";s:5:"400\r\n";s:5:"sos08";s:5:"245\r\n";s:5:"sos09";s:6:"41,5\r\n";s:5:"sos10";s:4:"12\r\n";s:5:"sos11";s:4:"11\r\n";s:5:"sos12";s:4:"ME\r\n";s:5:"sos13";s:4:"MZ\r\n";s:5:"sos14";s:8:"4.1.1T\r\n";s:5:"sos15";s:36:"Ð¼Ð¾Ð½Ð¸Ñ‚Ð¾Ñ€Ð¸Ð½Ð³Ð¾Ð²Ð° ITMS 1000";s:5:"sos16";s:27:"Ñ€ÐµÐ·ÐµÑ€Ð²Ð½Ð¸ Ñ‡Ð°ÑÑ‚Ð¸";}i:1;a:16:{s:5:"sos01";s:1:"2";s:5:"sos02";s:1:"1";s:5:"sos03";s:4:"1000";s:5:"sos04";s:10:"2016-11-07";s:5:"sos05";s:5:"PBV\r\n";s:5:"sos06";s:6:"02.1\r\n";s:5:"sos07";s:3:"2\r\n";s:5:"sos08";s:6:"41,5\r\n";s:5:"sos09";s:6:"17,5\r\n";s:5:"sos10";s:4:"09\r\n";s:5:"sos11";s:5:"020\r\n";s:5:"sos12";s:4:"MD\r\n";s:5:"sos13";s:4:"ZR\r\n";s:5:"sos14";s:4:"03\r\n";s:5:"sos15";s:0:"";s:5:"sos16";s:27:"Ñ€ÐµÐ·ÐµÑ€Ð²Ð½Ð° Ñ€ÑŠÑ‡ÐºÐ°";}}', '', 'FCA - Ð¡Ð¾Ñ„Ð¸Ñ', 'ÐÐ²Ñ‚Ð¾Ð¼Ð¾Ð±Ð¸Ð»ÐµÐ½', '18/24', 'Ð¡Ð».Ð±ÐµÐ»ÐµÐ¶ÐºÐ° â„– 363/22.08.2016', '1. Ð¡ÐµÑ€Ñ‚Ð¸Ñ„Ð¸ÐºÐ°Ñ‚ Ð·Ð° ÐºÐ°Ñ‡ÐµÑÑ‚Ð²Ð¾ - 5 ÐµÐºÐ·. Ð½Ð° Ñ€ÑƒÑÐºÐ¸ ÐµÐ·Ð¸Ðº\r\n2. Ð’ÑŠÐ¿Ñ€Ð¾ÑÐ½Ð¸Ñ‚Ðµ Ð»Ð¸ÑÑ‚Ð° Ñ‰Ðµ Ð±ÑŠÐ´Ð°Ñ‚ Ð¸Ð·Ð¿Ñ€Ð°Ñ‚ÐµÐ½Ð¸ Ð² Ð¢Ð”Ð•Ð Ð¿Ð¾ Ð¸Ð¼ÐµÐ¹Ð»', '1. Ð¤Ð°ÐºÑ‚ÑƒÑ€Ð°\r\n2. ÐžÐ¿Ð°ÐºÐ¾Ð²ÑŠÑ‡ÐµÐ½ Ð»Ð¸ÑÑ‚\r\n3. Ð¡ÐµÑ€Ñ‚Ð¸Ñ„Ð¸ÐºÐ°Ñ‚ Ð·Ð° ÐºÐ°Ñ‡ÐµÑÑ‚Ð²Ð¾\r\n(Ð²ÑÐ¸Ñ‡ÐºÐ¸ Ð´Ð¾ÐºÑƒÐ¼ÐµÐ½Ñ‚Ð¸ Ð´Ð° ÑÐ° Ð½Ð° Ñ€ÑƒÑÐºÐ¸ ÐµÐ·Ð¸Ðº)', '100% 60 Ð´Ð½Ð¸ ÑÐ»ÐµÐ´ ÐµÐºÑÐ¿ÐµÐ´Ð¸Ñ†Ð¸ÑÑ‚Ð°'),
(97, 'RS-16-444', 1, '2016-10-20 13:06', 'A. Yanev', '', '', '', '[2016-11-07 15:02] [WEB MASTER] [Ð ÐµÐ´Ð°ÐºÑ‚Ð¸Ñ€Ð°Ð½Ðµ Ð½Ð° Ð’Ð¤ÐŸ RS-16-444 Rev.1].\r\n[2016-10-20 13:31] [A. Yanev] [ÐºÐ°Ñ‡Ð¸: RS-16-444-REV.1.pdf].\r\n[2016-10-20 13:29] [A. Yanev] [Ð ÐµÐ´Ð°ÐºÑ‚Ð¸Ñ€Ð°Ð½Ðµ Ð½Ð° Ð’Ð¤ÐŸ RS-16-444 Rev.1].\r\n[2016-10-20 13:28] [A. Yanev] [Ð ÐµÐ´Ð°ÐºÑ‚Ð¸Ñ€Ð°Ð½Ðµ Ð½Ð° Ð’Ð¤ÐŸ RS-16-444 Rev.1].\r\n[2016-10-20 13:22] [A. Yanev] [ÑÑŠÐ·Ð´Ð°Ð´ÐµÐ½Ð° Rev.1 Ð½Ð° Ð±Ð°Ð·Ð° Ð¸Ð½Ñ„Ð¾. Ð¾Ñ‚ Rev.0].\r\n', 'M. Arsenova', '', 'ÐŸÑ€Ð¾Ð¸Ð·Ð²Ð¾Ð´ÑÑ‚Ð²Ð¾ Ð½Ð° ÑÑ‚ÑŠÐ¿Ð°Ð»Ð½Ð¸ Ñ€ÐµÐ³ÑƒÐ»Ð°Ñ‚Ð¾Ñ€Ð¸', 'ÐžÐžÐž Ð¢Ð¾Ð»Ð¸Ð°Ñ‚Ð¸Ð½ÑÐºÐ¸ Ð¢Ñ€Ð°Ð½ÑÑ„Ð¾Ñ€Ð¼Ð°Ñ‚Ð¾Ñ€ - Ð³Ñ€. Ð¢Ð¾Ð»Ð¸Ð°Ñ‚Ð¸', 'Ð ÑƒÑÐ¸Ñ', 'ÐžÐžÐž Ð¢Ð¾Ð»Ð¸Ð°Ñ‚Ð¸Ð½ÑÐºÐ¸ Ð¢Ñ€Ð°Ð½ÑÑ„Ð¾Ñ€Ð¼Ð°Ñ‚Ð¾Ñ€ - Ð³Ñ€. Ð¢Ð¾Ð»Ð¸Ð°Ñ‚Ð¸', 'Ð ÑƒÑÐ¸Ñ', '11', 'EUR', 'a:2:{i:0;a:16:{s:5:"sos01";s:1:"1";s:5:"sos02";s:1:"2";s:5:"sos03";s:5:"17390";s:5:"sos04";s:10:"2016-11-07";s:5:"sos05";s:5:"RS9";s:5:"sos06";s:3:"3";s:5:"sos07";s:5:"400";s:5:"sos08";s:6:"41,5";s:5:"sos09";s:3:"K";s:5:"sos10";s:4:"10";s:5:"sos11";s:4:"19";s:5:"sos12";s:4:"1W";s:5:"sos13";s:4:"MZ";s:5:"sos14";s:5:"4.4";s:5:"sos15";s:0:"";s:5:"sos16";s:0:"";}i:1;a:16:{s:5:"sos01";s:1:"2";s:5:"sos02";s:1:"2";s:5:"sos03";s:5:"19490";s:5:"sos04";s:0:"";s:5:"sos05";s:8:"RSV9.3";s:5:"sos06";s:5:"III";s:5:"sos07";s:5:"630";s:5:"sos08";s:6:"41,5";s:5:"sos09";s:3:"M";s:5:"sos10";s:4:"10";s:5:"sos11";s:4:"19";s:5:"sos12";s:4:"3W";s:5:"sos13";s:4:"MZ";s:5:"sos14";s:6:"4.4T";s:5:"sos15";s:26:"Ð¼Ð¾Ð½Ð¸Ñ‚Ð¾Ñ€Ð¸Ð½Ð³Ð¾Ð²Ð°";s:5:"sos16";s:27:"Ñ€ÐµÐ·ÐµÑ€Ð²Ð½Ð¸ Ñ‡Ð°ÑÑ‚Ð¸";}}', '', 'FCA - Ð¡Ð¾Ñ„Ð¸Ñ', 'ÐÐ²Ñ‚Ð¾Ð¼Ð¾Ð±Ð¸Ð»ÐµÐ½', '18/24', 'Ð¡Ð».Ð±ÐµÐ»ÐµÐ¶ÐºÐ° â„– 363/22.08.2016', '1. Ð¡ÐµÑ€Ñ‚Ð¸Ñ„Ð¸ÐºÐ°Ñ‚ Ð·Ð° ÐºÐ°Ñ‡ÐµÑÑ‚Ð²Ð¾ - 5 ÐµÐºÐ·. Ð½Ð° Ñ€ÑƒÑÐºÐ¸ ÐµÐ·Ð¸Ðº', '1. Ð¤Ð°ÐºÑ‚ÑƒÑ€Ð°\r\n2. ÐžÐ¿Ð°ÐºÐ¾Ð²ÑŠÑ‡ÐµÐ½ Ð»Ð¸ÑÑ‚\r\n3. Ð¡ÐµÑ€Ñ‚Ð¸Ñ„Ð¸ÐºÐ°Ñ‚ Ð·Ð° ÐºÐ°Ñ‡ÐµÑÑ‚Ð²Ð¾\r\n(Ð²ÑÐ¸Ñ‡ÐºÐ¸ Ð´Ð¾ÐºÑƒÐ¼ÐµÐ½Ñ‚Ð¸ Ð´Ð° ÑÐ° Ð½Ð° Ñ€ÑƒÑÐºÐ¸ ÐµÐ·Ð¸Ðº)', '100% 60 Ð´Ð½Ð¸ ÑÐ»ÐµÐ´ ÐµÐºÑÐ¿ÐµÐ´Ð¸Ñ†Ð¸ÑÑ‚Ð°'),
(101, 'RS-16-444', 2, '2016-10-31 15:51', 'G. Uzunov', '', '', '', '[2016-10-31 15:52] [G. Uzunov] [ÐºÐ°Ñ‡Ð¸: ÐžÑÑ†Ð¸Ð»Ð¾Ð³Ñ€Ð°Ð¼Ð° â„–ÐœÐœ14-0005, Ñ„Ð°Ð·Ð° A, Ð¿Ð¾ÑÐ¾ÐºÐ° 31-32-31.lvm].\r\n[2016-10-31 15:52] [G. Uzunov] [ÑÑŠÐ·Ð´Ð°Ð´ÐµÐ½Ð° Rev.2 Ð½Ð° Ð±Ð°Ð·Ð° Ð¸Ð½Ñ„Ð¾. Ð¾Ñ‚ Rev.1].\r\n', 'M. Arsenova', '', 'ÐŸÑ€Ð¾Ð¸Ð·Ð²Ð¾Ð´ÑÑ‚Ð²Ð¾ Ð½Ð° ÑÑ‚ÑŠÐ¿Ð°Ð»Ð½Ð¸ Ñ€ÐµÐ³ÑƒÐ»Ð°Ñ‚Ð¾Ñ€Ð¸', 'ÐžÐžÐž Ð¢Ð¾Ð»Ð¸Ð°Ñ‚Ð¸Ð½ÑÐºÐ¸ Ð¢Ñ€Ð°Ð½ÑÑ„Ð¾Ñ€Ð¼Ð°Ñ‚Ð¾Ñ€ - Ð³Ñ€. Ð¢Ð¾Ð»Ð¸Ð°Ñ‚Ð¸', 'Ð ÑƒÑÐ¸Ñ', 'ÐžÐžÐž Ð¢Ð¾Ð»Ð¸Ð°Ñ‚Ð¸Ð½ÑÐºÐ¸ Ð¢Ñ€Ð°Ð½ÑÑ„Ð¾Ñ€Ð¼Ð°Ñ‚Ð¾Ñ€ - Ð³Ñ€. Ð¢Ð¾Ð»Ð¸Ð°Ñ‚Ð¸', 'Ð ÑƒÑÐ¸Ñ', '130870', 'EUR', 'a:2:{i:0;a:16:{s:5:"sos01";s:1:"1";s:5:"sos02";s:1:"2";s:5:"sos03";s:5:"17390";s:5:"sos04";s:10:"2016-11-07";s:5:"sos05";s:5:"RS9";s:5:"sos06";s:3:"3";s:5:"sos07";s:5:"400";s:5:"sos08";s:6:"41,5";s:5:"sos09";s:3:"K";s:5:"sos10";s:4:"10";s:5:"sos11";s:4:"19";s:5:"sos12";s:4:"1W";s:5:"sos13";s:4:"MZ";s:5:"sos14";s:5:"4.4";s:5:"sos15";s:0:"";s:5:"sos16";s:0:"";}i:1;a:16:{s:5:"sos01";s:1:"2";s:5:"sos02";s:1:"2";s:5:"sos03";s:5:"19490";s:5:"sos04";s:0:"";s:5:"sos05";s:8:"RSV9.3";s:5:"sos06";s:5:"III";s:5:"sos07";s:5:"630";s:5:"sos08";s:6:"41,5";s:5:"sos09";s:3:"M";s:5:"sos10";s:4:"10";s:5:"sos11";s:4:"19";s:5:"sos12";s:4:"3W";s:5:"sos13";s:4:"MZ";s:5:"sos14";s:6:"4.4T";s:5:"sos15";s:26:"Ð¼Ð¾Ð½Ð¸Ñ‚Ð¾Ñ€Ð¸Ð½Ð³Ð¾Ð²Ð°";s:5:"sos16";s:27:"Ñ€ÐµÐ·ÐµÑ€Ð²Ð½Ð¸ Ñ‡Ð°ÑÑ‚Ð¸";}}', '', 'FCA - Ð¡Ð¾Ñ„Ð¸Ñ', 'ÐœÐ¾Ñ€ÑÐºÐ¸', '18/24', 'Ð¡Ð».Ð±ÐµÐ»ÐµÐ¶ÐºÐ° â„– 363/22.08.2016', '1. Ð¡ÐµÑ€Ñ‚Ð¸Ñ„Ð¸ÐºÐ°Ñ‚ Ð·Ð° ÐºÐ°Ñ‡ÐµÑÑ‚Ð²Ð¾ - 5 ÐµÐºÐ·. Ð½Ð° Ñ€ÑƒÑÐºÐ¸ ÐµÐ·Ð¸Ðº\r\nÐŸÐ¾Ð»ÑƒÑ‡ÐµÐ½ e-mail Ð¾Ñ‚ 31,10,2016', '1. Ð¤Ð°ÐºÑ‚ÑƒÑ€Ð°\r\n2. ÐžÐ¿Ð°ÐºÐ¾Ð²ÑŠÑ‡ÐµÐ½ Ð»Ð¸ÑÑ‚\r\n3. Ð¡ÐµÑ€Ñ‚Ð¸Ñ„Ð¸ÐºÐ°Ñ‚ Ð·Ð° ÐºÐ°Ñ‡ÐµÑÑ‚Ð²Ð¾\r\n(Ð²ÑÐ¸Ñ‡ÐºÐ¸ Ð´Ð¾ÐºÑƒÐ¼ÐµÐ½Ñ‚Ð¸ Ð´Ð° ÑÐ° Ð½Ð° Ñ€ÑƒÑÐºÐ¸ ÐµÐ·Ð¸Ðº)', '100% 60 Ð´Ð½Ð¸ ÑÐ»ÐµÐ´ ÐµÐºÑÐ¿ÐµÐ´Ð¸Ñ†Ð¸ÑÑ‚Ð°'),
(103, 'RS-16-444', 3, '2016-10-31 16:23', 'G. Uzunov', '', '', '', '[2016-10-31 16:23] [G. Uzunov] [ÑÑŠÐ·Ð´Ð°Ð´ÐµÐ½Ð° Rev.3 Ð½Ð° Ð±Ð°Ð·Ð° Ð¸Ð½Ñ„Ð¾. Ð¾Ñ‚ Rev.2].\r\n', 'M. Arsenova', '', 'ÐŸÑ€Ð¾Ð¸Ð·Ð²Ð¾Ð´ÑÑ‚Ð²Ð¾ Ð½Ð° ÑÑ‚ÑŠÐ¿Ð°Ð»Ð½Ð¸ Ñ€ÐµÐ³ÑƒÐ»Ð°Ñ‚Ð¾Ñ€Ð¸', 'ÐžÐžÐž Ð¢Ð¾Ð»Ð¸Ð°Ñ‚Ð¸Ð½ÑÐºÐ¸ Ð¢Ñ€Ð°Ð½ÑÑ„Ð¾Ñ€Ð¼Ð°Ñ‚Ð¾Ñ€ - Ð³Ñ€. Ð¢Ð¾Ð»Ð¸Ð°Ñ‚Ð¸', 'Ð ÑƒÑÐ¸Ñ', 'ÐžÐžÐž Ð¢Ð¾Ð»Ð¸Ð°Ñ‚Ð¸Ð½ÑÐºÐ¸ Ð¢Ñ€Ð°Ð½ÑÑ„Ð¾Ñ€Ð¼Ð°Ñ‚Ð¾Ñ€ - Ð³Ñ€. Ð¢Ð¾Ð»Ð¸Ð°Ñ‚Ð¸', 'Ð ÑƒÑÐ¸Ñ', '130870', 'EUR', 'a:2:{i:0;a:16:{s:5:"sos01";s:1:"1";s:5:"sos02";s:1:"2";s:5:"sos03";s:5:"17390";s:5:"sos04";s:10:"2016-11-07";s:5:"sos05";s:5:"RS9";s:5:"sos06";s:3:"3";s:5:"sos07";s:5:"400";s:5:"sos08";s:6:"41,5";s:5:"sos09";s:3:"K";s:5:"sos10";s:4:"10";s:5:"sos11";s:4:"19";s:5:"sos12";s:4:"1W";s:5:"sos13";s:4:"MZ";s:5:"sos14";s:5:"4.4";s:5:"sos15";s:0:"";s:5:"sos16";s:0:"";}i:1;a:16:{s:5:"sos01";s:1:"2";s:5:"sos02";s:1:"2";s:5:"sos03";s:5:"19490";s:5:"sos04";s:0:"";s:5:"sos05";s:8:"RSV9.3";s:5:"sos06";s:5:"III";s:5:"sos07";s:5:"630";s:5:"sos08";s:6:"41,5";s:5:"sos09";s:3:"M";s:5:"sos10";s:4:"10";s:5:"sos11";s:4:"19";s:5:"sos12";s:4:"3W";s:5:"sos13";s:4:"MZ";s:5:"sos14";s:6:"4.4T";s:5:"sos15";s:26:"Ð¼Ð¾Ð½Ð¸Ñ‚Ð¾Ñ€Ð¸Ð½Ð³Ð¾Ð²Ð°";s:5:"sos16";s:27:"Ñ€ÐµÐ·ÐµÑ€Ð²Ð½Ð¸ Ñ‡Ð°ÑÑ‚Ð¸";}}', '', 'FCA - Ð¡Ð¾Ñ„Ð¸Ñ', 'ÐœÐ¾Ñ€ÑÐºÐ¸', '18', 'Ð¡Ð».Ð±ÐµÐ»ÐµÐ¶ÐºÐ° â„– 363/22.08.2016', '1. Ð¡ÐµÑ€Ñ‚Ð¸Ñ„Ð¸ÐºÐ°Ñ‚ Ð·Ð° ÐºÐ°Ñ‡ÐµÑÑ‚Ð²Ð¾ - 5 ÐµÐºÐ·. Ð½Ð° Ñ€ÑƒÑÐºÐ¸ ÐµÐ·Ð¸Ðº\r\nÐŸÐ¾Ð»ÑƒÑ‡ÐµÐ½ e-mail Ð¾Ñ‚ 31,10,2016', '1. Ð¤Ð°ÐºÑ‚ÑƒÑ€Ð°\r\n2. ÐžÐ¿Ð°ÐºÐ¾Ð²ÑŠÑ‡ÐµÐ½ Ð»Ð¸ÑÑ‚\r\n3. Ð¡ÐµÑ€Ñ‚Ð¸Ñ„Ð¸ÐºÐ°Ñ‚ Ð·Ð° ÐºÐ°Ñ‡ÐµÑÑ‚Ð²Ð¾\r\n(Ð²ÑÐ¸Ñ‡ÐºÐ¸ Ð´Ð¾ÐºÑƒÐ¼ÐµÐ½Ñ‚Ð¸ Ð´Ð° ÑÐ° Ð½Ð° Ñ€ÑƒÑÐºÐ¸ ÐµÐ·Ð¸Ðº)', '100% 60 Ð´Ð½Ð¸ ÑÐ»ÐµÐ´ ÐµÐºÑÐ¿ÐµÐ´Ð¸Ñ†Ð¸ÑÑ‚Ð°');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
MODIFY `id` int(16) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=126;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
