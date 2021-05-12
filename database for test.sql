-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 23, 2021 alle 18:28
-- Versione del server: 10.4.18-MariaDB
-- Versione PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bluedog`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `artist`
--

CREATE TABLE `artist` (
  `id` int(11) NOT NULL,
  `stage_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `artist`
--

INSERT INTO `artist` (`id`, `stage_name`, `first_name`, `last_name`) VALUES
(1, 'Nek', 'Filippo', 'Neviani'),
(2, 'Neffa', 'Giovanni', 'Pellino'),
(3, 'Calcutta', 'Edoardo', 'D\'Erme'),
(4, 'Carmen Consoli', 'Carmen', 'Consoli'),
(5, 'Robbie Williams', 'Robert Peter', 'Williams');

-- --------------------------------------------------------

--
-- Struttura della tabella `discography`
--

CREATE TABLE `discography` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stage_name_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `release_datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `discography`
--

INSERT INTO `discography` (`id`, `title`, `stage_name_id`, `language_id`, `sales_id`, `release_datetime`) VALUES
(1, 'Unici', 1, 1, 1, '2016-10-14 10:00:00'),
(2, 'L\'abitudine di tornare', 4, 1, 2, '2015-01-20 10:00:00'),
(3, 'AmarAmmore', 2, 1, 3, '2021-04-02 10:00:00'),
(4, 'The Christmas Present ', 5, 2, 8, '2019-11-22 10:00:00'),
(5, 'Sorriso', 3, 1, 4, '2019-06-07 10:00:00'),
(6, 'Nella stanza 26', 1, 1, 6, '2006-11-07 10:00:00'),
(7, 'Prima di Parlare', 1, 1, 5, '2015-03-03 10:00:00'),
(8, 'Il mio gioco preferito', 1, 1, 7, '2019-05-10 10:00:00'),
(9, 'The Heavy Entertainment Show', 5, 2, 9, '2016-11-04 10:00:00'),
(10, 'Swings Both Ways', 5, 2, 10, '2013-11-18 00:00:00'),
(11, 'Take the Crown', 5, 2, 11, '2012-11-02 10:00:00');

-- --------------------------------------------------------

--
-- Struttura della tabella `language`
--

CREATE TABLE `language` (
  `id` int(11) NOT NULL,
  `language` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `language`
--

INSERT INTO `language` (`id`, `language`) VALUES
(1, 'italiano'),
(2, 'inglese'),
(3, 'spagnolo'),
(4, 'tedesco');

-- --------------------------------------------------------

--
-- Struttura della tabella `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `sale_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `number_sales` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `sales`
--

INSERT INTO `sales` (`id`, `sale_datetime`, `number_sales`) VALUES
(1, '2016-10-14 10:00:00', 25000000),
(2, '2015-01-20 10:00:00', 24000000),
(3, '2021-04-02 10:00:00', 10200000),
(4, '2019-06-07 10:00:00', 50000),
(5, '2015-03-03 10:00:00', 2000000),
(6, '2006-11-17 10:00:00', 1500000),
(7, '2019-05-10 00:00:00', 1800000),
(8, '2019-11-22 10:00:00', 4500000),
(9, '2016-11-04 10:00:00', 58522111),
(10, '2013-11-18 10:00:00', 6545641),
(11, '2012-11-02 00:00:00', 787812221);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `artist`
--
ALTER TABLE `artist`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `discography`
--
ALTER TABLE `discography`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rel_artist` (`stage_name_id`),
  ADD KEY `rel_language` (`language_id`),
  ADD KEY `rel_sales` (`sales_id`);

--
-- Indici per le tabelle `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `artist`
--
ALTER TABLE `artist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `discography`
--
ALTER TABLE `discography`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT per la tabella `language`
--
ALTER TABLE `language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `discography`
--
ALTER TABLE `discography`
  ADD CONSTRAINT `rel_artist` FOREIGN KEY (`stage_name_id`) REFERENCES `artist` (`id`),
  ADD CONSTRAINT `rel_language` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`),
  ADD CONSTRAINT `rel_sales` FOREIGN KEY (`sales_id`) REFERENCES `sales` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
