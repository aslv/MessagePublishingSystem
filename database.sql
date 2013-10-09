-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Време на генериране: 
-- Версия на сървъра: 5.5.27
-- Версия на PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- БД: `messages_users_storage`
--
CREATE DATABASE IF NOT EXISTS `messages_users_storage` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `messages_users_storage`;

-- --------------------------------------------------------

--
-- Структура на таблица `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(63) NOT NULL,
  `description` tinytext NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Ссхема на данните от таблица `groups`
--

INSERT INTO `groups` (`group_id`, `title`, `description`) VALUES
(1, 'Обща група', 'Това е група за всичко'),
(2, 'Храна', 'Храна'),
(3, 'Транспорт', 'Транспорт'),
(4, 'Култура', 'Култура');

-- --------------------------------------------------------

--
-- Структура на таблица `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(63) NOT NULL,
  `content` text NOT NULL,
  `group_id` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Ссхема на данните от таблица `messages`
--

INSERT INTO `messages` (`message_id`, `user_id`, `title`, `content`, `group_id`, `datetime`) VALUES
(1, 1, 'Проба', 'Това е проба :)', 1, '2013-10-09 20:43:12');

-- --------------------------------------------------------

--
-- Структура на таблица `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(63) NOT NULL,
  `password` varchar(63) NOT NULL,
  `name` varchar(63) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Ссхема на данните от таблица `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `name`, `is_admin`) VALUES
(1, 'admin', 'admin', 'Admin', 1),
(2, 'username', 'password', 'User', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

GRANT ALL ON  `messages_users_storage` . * TO 'user'@'localhost' IDENTIFIED BY 'pass';
FLUSH PRIVILEGES;