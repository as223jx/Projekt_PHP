-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 26 okt 2014 kl 23:08
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=93 ;

--
-- Dumpning av Data i tabell `pics`
--

INSERT INTO `pics` (`id`, `title`, `url`, `description`, `category`) VALUES
(22, 'TSM', 'TSM.png', 'Fanart of professional LoL team Team SoloMid', '1'),
(92, 'Mirror''s Edge 3', 'medmoln2.png', 'School assignment "Top Game". Concept for Mirror''s Edge 3 cover.', '7'),
(91, 'Flying WIP', 'flyingwip5.png', 'Work in progress.', '5'),
(90, 'Victorious Janna WIP', 'victorious_janna.png', 'Work in progress for a fanart of Victorious Janna from League of Legends.', '5'),
(89, 'Sketch o''f old OC', 'sk.png', 'Sketch of an old OC.', '6'),
(88, 'Pentakill Nami', 'pentakill-nami.png', 'Fan concept sketch for Pentakill Nami', '6'),
(87, 'Sona', 'sona_smaller.png', 'Fanart of Sona from League of Legends', '1'),
(86, 'Pirate Caitlyn', 'Pirate_caitlyn.png', 'Fan concept of Pirate Caitlyn.', '1'),
(83, 'Dignitas Yasuo', 'dignitas_yasuo.png', 'Fan concept commission for Dignitas Yasuo.', '1'),
(80, 'Morgana', 'Morgana_smaller.png', 'Fanart of Morgana from League of Legends.', '1'),
(76, 'Lara', 'lara_smaller.png', 'Fanart of Lara Croft from Tomb Raider.', '1'),
(81, 'Bot Thresh', 'Bot_Thresh.png', 'Fan concept for Bot Thresh.', '6'),
(78, 'Rengnar', 'Rengnar2.png', 'Fanart of Gnar as Rengar from League of Legends.', '1'),
(74, 'Bjergerking Lux', 'Bjergerking_lux.png', 'Fanart for professional League of Legends player Bjergsen featuring champion Lux as a Bjergerking worker.', '1'),
(73, 'Bjergerking Syndra', 'bjerger_king_syndra.png', 'Fanart for professional League of Legends player Bjergsen featuring champion Syndra as a Bjergerking worker.', '1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
