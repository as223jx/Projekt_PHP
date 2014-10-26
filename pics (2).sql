-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 26 okt 2014 kl 14:27
-- Serverversion: 5.6.15-log
-- PHP-version: 5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `pics`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `pics`
--

CREATE TABLE IF NOT EXISTS `pics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(40) NOT NULL,
  `url` varchar(120) NOT NULL,
  `description` text,
  `category` varchar(20) NOT NULL DEFAULT 'Other',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

--
-- Dumpning av Data i tabell `pics`
--

INSERT INTO `pics` (`id`, `title`, `url`, `description`, `category`) VALUES
(22, 'TSM', 'TSM.png', 'Fanart of professional LoL team Team SoloMid', '1'),
(44, 'Background WIP', 'Background_oklar.png', 'Work in progress of a background for an artwork', '5'),
(20, 'Lara', 'lara_smaller.png', 'Lara Croft from Tomb Raider', '1'),
(46, 'Victorious Janna WIP', 'victorious_janna.png', 'Work in progress of Janna fanart', '5'),
(15, 'Rengnar', 'Rengnar2.png', 'Gnar as Rengar from LoL', '1'),
(12, 'Morgana', 'Morgana_smaller.png', 'Morgana', '1'),
(55, 'Allis', 'left_4_dead_2___alle_ellis_by_yeojabuta-d696kbp.png', 'Self portrait as Ellis from Left 4 Dead 2', '1'),
(31, 'Bot Thresh', 'Bot_Thresh.png', 'Fan concept for Bot Thresh.', '6'),
(32, 'Pentakill Nami', 'pentakill-nami.png', 'Fan concept for Pentakill Nami.', '6'),
(33, 'Dignitas Yasuo', 'dignitas_yasuo.png', 'Fan concept commission for Dignitas Yasuo.', '1'),
(34, 'Pirate Caitlyn', 'Pirate_caitlyn.png', 'Fan concept for Pirate Caitlyn.', '1'),
(35, 'Bjergerking Syndra', 'bjerger_king_syndra.png', 'Fan concept for Bjergerking Syndra', '1'),
(36, 'Bjergerking Lux', 'Bjergerking_lux.png', 'Fan concept for Bjergerking Lux.', '1'),
(53, 'Caitlyn Sketch', 'Pirate-Caitlyn.png', 'Sketch of fan concept for Pirate Caitlyn', '6'),
(54, 'Mirror', 'medmoln2.png', 'dsfsdf', '8');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
