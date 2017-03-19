-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Мар 20 2017 г., 01:04
-- Версия сервера: 5.5.25
-- Версия PHP: 5.5.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `apartments`
--

-- --------------------------------------------------------

--
-- Структура таблицы `apartments`
--

CREATE TABLE IF NOT EXISTS `apartments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `beds` int(11) DEFAULT NULL,
  `price1` float DEFAULT NULL,
  `price2` float DEFAULT NULL,
  `price3` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Дамп данных таблицы `apartments`
--

INSERT INTO `apartments` (`id`, `address`, `city`, `beds`, `price1`, `price2`, `price3`) VALUES
(16, 'Mullerstrasse 12', 'Düsseldorf', 3, 50, 40, 30),
(17, 'Schmitzallee 22', 'Düsseldorf', 4, 60, 50, 35),
(18, 'Meierweg 11', 'Köln', 4, 60, 55, 50);

-- --------------------------------------------------------

--
-- Структура таблицы `bookings`
--

CREATE TABLE IF NOT EXISTS `bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `apartment_id` int(11) DEFAULT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  `to_pay` float DEFAULT NULL,
  `payed` float NOT NULL DEFAULT '0',
  `info` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `bookings`
--

INSERT INTO `bookings` (`id`, `apartment_id`, `start`, `end`, `to_pay`, `payed`, `info`) VALUES
(5, 18, '2017-03-20', '2017-03-23', 380, 200, 'MMM NNN test test test111'),
(6, 16, '2017-03-20', '2017-03-22', 360, 15, ''),
(7, 17, '2017-03-22', '2017-03-25', 300, 100, '');

-- --------------------------------------------------------

--
-- Структура таблицы `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(50) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` text,
  `editable` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Дамп данных таблицы `config`
--

INSERT INTO `config` (`id`, `alias`, `name`, `value`, `editable`) VALUES
(1, 'city', 'city_1', 'Düsseldorf', 1),
(2, 'days', 'days_for_price2', '7', 1),
(3, 'days', 'days_for_price3', '30', 1),
(4, 'city', 'city_2', 'Köln', 1),
(5, 'menu_lang', 'calendar', 'Calendar', 1),
(6, 'menu_lang', 'debtors', 'Debtors', 1),
(7, 'menu_lang', 'new_booking', 'New booking', 1),
(8, 'menu_lang', 'apartments', 'Apartments', 1),
(9, 'menu_lang', 'new_apartment', 'New apartment', 1),
(10, 'menu_lang', 'fairs', 'Fairs', 1),
(11, 'menu_lang', 'new_fair', 'New fair', 1),
(12, 'menu_lang', 'reminder', 'Reminder', 1),
(13, 'title', 'apartments_title', 'Apartments', 1),
(14, 'title', 'apartments_edit_title', 'Edit Apartment', 1),
(15, 'title', 'apartments_create_title', 'Create Apartment', 1),
(16, 'title', 'bookings_title', 'Debtors', 1),
(17, 'title', 'bookings_edit_title', 'Edit Booking', 1),
(18, 'title', 'bookings_create_title', 'Create Booking', 1),
(19, 'title', 'bookings_search_title', 'Search Booking', 1),
(20, 'title', 'calendar_title', 'Calendar', 1),
(21, 'title', 'fairs_title', 'Fairs', 1),
(22, 'title', 'fairs_edit_title', 'Edit Fair', 1),
(23, 'title', 'fairs_create_title', 'Create Fair', 1),
(24, 'title', 'configs_title', 'Configs', 1),
(25, 'title', 'configs_edit_title', 'Edit Config', 1),
(26, 'title', 'configs_create_title', 'Create Config', 1),
(27, 'time', 'booking_start', '15.00', 1),
(28, 'time', 'booking_end', '11.00', 1),
(29, 'time', 'fair_start', '00.01', 1),
(30, 'time', 'fair_end', '23.59', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `fairs`
--

CREATE TABLE IF NOT EXISTS `fairs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  `price` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Дамп данных таблицы `fairs`
--

INSERT INTO `fairs` (`id`, `name`, `address`, `city`, `start`, `end`, `price`) VALUES
(13, 'Van Gogh', 'Eibel str 12', 'Düsseldorf', '2017-03-19', '2017-03-22', 120),
(15, 'Football', 'Manhatten 132', 'Köln', '2017-03-23', '2017-03-23', 130);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `name`) VALUES
(1, 'admin', '$2y$10$31ovsXN97IPIGbplfmpxA.IsnqjwpnWjqJqDvh1N5t3U/RYvZqR32', 'admin', 'Admin'),
(2, 'dev', '$2y$10$ED/kBwV1DEUx0r8dob80Q.2k.5uVOOugMquO2cVdwd/anAkKlQBfa', 'dev', 'Dev');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
