-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Set 24, 2018 alle 12:45
-- Versione del server: 10.1.30-MariaDB
-- Versione PHP: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `datixtest`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `lastName`) VALUES
(49, 'johnDoe', '$2y$10$rLXNvV6vxAcyi16MO8h15OzfGXIekBGL3VeW9Y1/6xOyvu6uSWRUy', 'JoeTwo', 'RossTwo'),
(71, 'johnDoe3', '$2y$10$COE417UdKZqImc.fPVvzAeqTEIMz7.JgF3YZ0aoaExzD0BEHr5fS2', 'Jhon', 'Doe'),
(72, 'johnDoe1', '$2y$10$Aq9dQfrq1ZwKu4EVv4RlMOShMIPDL5pp/tLrkNv4AXQNCuX14TuVi', 'Jhon', 'Doe'),
(73, 'johnDoe2', '$2y$10$H8BUSn37NoKN65OaHolpLeblrITMevbFsGNSDIiLJ3HAoNaPfyaya', 'John', 'Doe'),
(76, 'johnDoe4', '$2y$10$g68rPrsa8KbyW3Smx.N9O.FWr3opl4sHh47XzKkqi0KIwIPwCR4ie', 'Joe', 'Doe');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
