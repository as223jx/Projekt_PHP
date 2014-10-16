-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 16 okt 2014 kl 11:29
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
  `title` varchar(40) NOT NULL,
  `url` varchar(120) NOT NULL,
  `description` text,
  `category` varchar(20) NOT NULL DEFAULT 'Other'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `pics`
--

INSERT INTO `pics` (`title`, `url`, `description`, `category`) VALUES
('Titel', 'brushsize.png', NULL, 'Kategori'),
('Titel', 'namiskin.png', NULL, 'Kategori'),
('Titel', 'old.png', 'Beskrivning', 'Kategori'),
('Titel', 'portfolio.png', 'Beskrivning', 'Kategori'),
('PvZ', 'soon.png', 'Plants vs Zombies download screenshot', 'Kategori'),
('asdads', 'eclipse.png', 'sadasd', 'Kategori'),
('apa', 'minimap.png', 'apa', 'Kategori'),
('sasad', 'leona.png', 'dsadsa', 'Kategori'),
('sada', 'letsdothis2.png', 'sdasd', 'Kategori'),
('Kabba', 'VXfjpO2.png', 'Kabba', 'Kategori'),
('Morgana', 'Morgana.png', 'Morgana', 'Kategori'),
('Morgana', 'Morgana_smaller.png', 'Morgana', 'Kategori');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
