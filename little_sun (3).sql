-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Gegenereerd op: 21 mei 2024 om 18:53
-- Serverversie: 5.7.24
-- PHP-versie: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `little sun`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `clock`
--

CREATE TABLE `clock` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `action` enum('clock_in','clock_out') NOT NULL,
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `clock`
--

INSERT INTO `clock` (`id`, `user_name`, `action`, `timestamp`) VALUES
(1, 'bob', 'clock_in', '2024-05-12 21:22:14'),
(2, 'bob', 'clock_out', '2024-05-12 21:22:39'),
(3, 'jonas', 'clock_in', '2024-05-21 13:40:55'),
(4, 'jonas', 'clock_out', '2024-05-21 13:41:20');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `locations`
--

INSERT INTO `locations` (`id`, `name`) VALUES
(1, 'spanje'),
(2, 'italie'),
(3, 'duitsland'),
(6, 'Nederland');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `location_users`
--

CREATE TABLE `location_users` (
  `id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `location_users`
--

INSERT INTO `location_users` (`id`, `location_id`, `username`) VALUES
(1, 2, 'jeffrey'),
(2, 2, 'emma'),
(5, 1, 'test'),
(6, 1, 'whoppa'),
(9, 1, 'wajoooo'),
(10, 1, 'wajoooo'),
(11, 1, 'bob'),
(12, 1, 'mike'),
(13, 1, 'mike'),
(14, 6, 'mike'),
(15, 6, 'bob'),
(16, 6, 'Emiel'),
(17, 1, 'jef'),
(18, 2, 'hannes'),
(19, 1, 'wafel'),
(21, 1, 'zoef'),
(22, 1, 'zoef');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `managers`
--

CREATE TABLE `managers` (
  `manager_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `taken`
--

CREATE TABLE `taken` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `task_date` date DEFAULT NULL,
  `task_description` varchar(255) DEFAULT NULL,
  `task_start_time` time DEFAULT NULL,
  `task_end_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `taken`
--

INSERT INTO `taken` (`id`, `user_id`, `task_date`, `task_description`, `task_start_time`, `task_end_time`) VALUES
(1, 11, '2025-05-02', 'poetsen', '05:00:00', '12:00:00'),
(2, 11, '2025-05-02', 'poetsen', '05:00:00', '12:00:00'),
(3, 11, '2025-05-02', 'poetsen', '05:00:00', '12:00:00'),
(4, 14, '2024-05-13', 'Poets', '12:00:00', '16:00:00'),
(5, 15, '2024-05-15', 'Papier werk ', '10:00:00', '12:00:00'),
(6, 14, '2024-05-17', 'Papier werk1111', '12:00:00', '16:00:00'),
(7, 13, '2024-05-22', 'Cleaning', '09:00:00', '10:00:00'),
(8, 12, '2024-05-21', 'cleaning\r\n', '10:00:00', '12:00:00'),
(9, 11, '2024-05-27', 'cleaning', '09:49:00', '18:49:00'),
(10, 11, '2024-05-20', 'cleaning', '10:49:00', '18:50:00'),
(11, 12, '2024-05-23', 'cleaning\r\n', '20:00:00', '23:09:00'),
(12, 22, '2024-05-21', 'cleaning\r\n', '20:56:00', '08:56:00'),
(13, 22, '2024-05-22', 'cleaning', '10:00:00', '11:00:00'),
(14, 11, '2024-05-22', 'cleaning', '10:00:00', '11:00:00'),
(15, 12, '2024-02-22', 'gekke test', '20:00:00', '21:00:00');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `time_off`
--

CREATE TABLE `time_off` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `reason` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `time_off`
--

INSERT INTO `time_off` (`id`, `user_id`, `date`, `reason`, `created_at`, `start_time`, `end_time`) VALUES
(2, 14, '2024-05-14', 'trouw', '2024-05-12 19:01:03', NULL, NULL),
(3, 14, '2024-05-13', 'trouw', '2024-05-12 21:12:16', NULL, NULL),
(4, 14, '2024-05-13', 'Feest', '2024-05-12 21:14:54', NULL, NULL),
(5, 5, '2024-05-16', 'Ziek', '2024-05-12 21:21:25', NULL, NULL),
(6, 22, '2024-05-13', 'ziek', '2024-05-19 17:19:27', '09:19:00', '19:19:00'),
(7, 22, '2024-05-24', 'geen zin', '2024-05-19 17:30:37', '00:30:00', '15:30:00'),
(8, 22, '2024-05-22', 'ziek', '2024-05-19 18:06:43', '10:00:00', '12:00:00'),
(9, 5, '2024-05-23', 'Trouw', '2024-05-21 13:40:07', '00:00:00', '23:59:00');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `rol` enum('user','manager','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `user_name`, `password`, `name`, `rol`) VALUES
(5, 'Van Roy', '99754106633f94d350db34d548d6091a', 'Jonas', 'user'),
(9, 'root', '21232f297a57a5a743894a0e4a801fc3', 'root', 'user'),
(11, 'jonas', '9c5ddd54107734f7d18335a5245c286b', 'jonas', 'user'),
(12, 'frankrijk', '67135a3de78cbb7818473b2ebefcad95', 'frankrijk', 'user'),
(13, 'bob', '81dc9bdb52d04dc20036dbd8313ed055', 'bob', 'user'),
(14, 'mike', '81dc9bdb52d04dc20036dbd8313ed055', 'mike', 'user'),
(15, 'Emiel', '81dc9bdb52d04dc20036dbd8313ed055', 'Emiel Van Gorpen', 'user'),
(16, 'manager', '1d0258c2440a8d19e716292b231e3190', 'manager', 'manager'),
(21, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'admin'),
(22, 'jef', 'c386950aa5131b703f031267f77e1075', 'jef', 'user'),
(23, 'manager dave', '1d0258c2440a8d19e716292b231e3190', 'manager dave', 'manager'),
(24, 'ham', '79af0c177db2ee64b7301af6e1d53634', 'ham', 'user'),
(25, 'zoef', '3f3b4f98a1135a3c71a397b17008e500', 'zoef', 'user');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `clock`
--
ALTER TABLE `clock`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `location_users`
--
ALTER TABLE `location_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `location_id` (`location_id`);

--
-- Indexen voor tabel `taken`
--
ALTER TABLE `taken`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `time_off`
--
ALTER TABLE `time_off`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `clock`
--
ALTER TABLE `clock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT voor een tabel `location_users`
--
ALTER TABLE `location_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT voor een tabel `taken`
--
ALTER TABLE `taken`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT voor een tabel `time_off`
--
ALTER TABLE `time_off`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `location_users`
--
ALTER TABLE `location_users`
  ADD CONSTRAINT `location_users_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
