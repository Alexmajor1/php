-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июл 20 2021 г., 06:56
-- Версия сервера: 10.4.11-MariaDB
-- Версия PHP: 7.3.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `mydatabase`
--
CREATE DATABASE IF NOT EXISTS `mydatabase` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `mydatabase`;

-- --------------------------------------------------------

--
-- Структура таблицы `aliases`
--

CREATE TABLE IF NOT EXISTS `aliases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `page` varchar(255) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `aliases`
--

INSERT INTO `aliases` (`id`, `name`, `page`) VALUES
(1, 'RYJ67A6Ose', 'index.php?page=logout'),
(2, 'KO5Uw2Xxj5', 'index.php?page=cabinet'),
(3, '7perZCZCi1', 'index.php?page=authorization'),
(4, 'fVgxeFOmzj', 'index.php?page=registration'),
(5, 'aMxeVfgaXP', 'index.php?page=admin\\forums'),
(6, 'ar8WUgKDM3', 'index.php?page=admin\\roles'),
(7, 'p2Fv1GRU7T', 'index.php?page=admin\\rules'),
(8, 'oUTN20ZoRD', 'index.php?page=admin\\themes'),
(9, 'u4Fxap85WF', 'index.php?page=admin\\topics'),
(10, '02DHlky78m', 'index.php?page=admin\\users'),
(11, 'aMxeVfgaXG', 'index.php?page=admin\\main'),
(12, 'abcd', 'index.php?page=test');

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `forum`
-- (См. Ниже фактическое представление)
--
CREATE TABLE IF NOT EXISTS `forum` (
`name` varchar(255)
);

-- --------------------------------------------------------

--
-- Структура таблицы `forums`
--

CREATE TABLE IF NOT EXISTS `forums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `forums`
--

INSERT INTO `forums` (`id`, `user_id`, `name`) VALUES
(16, 6, 'general'),
(17, 6, 'test'),
(18, 6, 'test1');

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Role_name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `Role_name`) VALUES
(1, 'Customer'),
(2, 'Admin');

-- --------------------------------------------------------

--
-- Структура таблицы `rules`
--

CREATE TABLE IF NOT EXISTS `rules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Rule_name` varchar(45) DEFAULT NULL,
  `Rule_role` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_rule_role_idx` (`Rule_role`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `rules`
--

INSERT INTO `rules` (`id`, `Rule_name`, `Rule_role`) VALUES
(1, 'access', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` int(11) NOT NULL AUTO_INCREMENT,
  `session_key` varchar(255) NOT NULL,
  `session_user` int(11) NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `sessions`
--

INSERT INTO `sessions` (`session_id`, `session_key`, `session_user`) VALUES
(99, 'dHYAcMT79v', 6),
(100, 'zAoxPwNIID', 7),
(101, 'cik1HUONMr', 6),
(102, '2HAq8on0lL', 7),
(103, 'GMdFCtrGkt', 6),
(104, 'tqk1sIenzv', 7),
(105, 'EhN3b6qmjp', 6),
(106, 'DPNb4IqITz', 6),
(107, 'gBtWetjvTH', 6),
(108, 'Wlb8L0iwUb', 6),
(109, 'CLmv26Zgwz', 6),
(110, 'RkycPBv1CR', 6),
(111, 'PKWfrHpmw3', 6),
(112, 'nfgMlp48JE', 6),
(113, 'UBja7OfUeV', 6),
(114, 'qolMXASJH5', 6),
(115, '2KJAKrL6HX', 6),
(116, 'aKmWKNaOwP', 6),
(117, 'rLEgcPcPv0', 6),
(118, 'l7kZmWa7Nx', 6),
(119, 'pFzrM3YwAq', 6),
(120, '7N1Hfho9mz', 7),
(121, 'bbLG8v38FE', 6),
(122, 'ewKJ0LG41n', 7),
(123, 'HI0Bm9xU8I', 6);

-- --------------------------------------------------------

--
-- Структура таблицы `themes`
--

CREATE TABLE IF NOT EXISTS `themes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `forum_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `themes`
--

INSERT INTO `themes` (`id`, `user_id`, `forum_id`, `name`) VALUES
(2, 6, 16, 'main');

-- --------------------------------------------------------

--
-- Структура таблицы `topics`
--

CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `theme_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `topics`
--

INSERT INTO `topics` (`id`, `user_id`, `theme_id`, `name`) VALUES
(2, 6, 2, 'hello world!');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `User_name` varchar(16) DEFAULT NULL,
  `User_role` int(11) DEFAULT NULL,
  `User_password` varchar(32) DEFAULT NULL,
  `User_remember` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_role_idx` (`User_role`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `User_name`, `User_role`, `User_password`, `User_remember`) VALUES
(6, 'admin', 2, '8113bf210841684140ba650e5f5020b1', NULL),
(7, 'programer', 1, 'ce1eff8a1ef7bc37e29551c6333a7203', NULL);

-- --------------------------------------------------------

--
-- Структура для представления `forum`
--
DROP TABLE IF EXISTS `forum`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `forum`  AS  select `forums`.`name` AS `name` from `forums` ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `rules`
--
ALTER TABLE `rules`
  ADD CONSTRAINT `fk_rule_role` FOREIGN KEY (`Rule_role`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_role` FOREIGN KEY (`User_role`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
