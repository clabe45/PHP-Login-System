-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2017 at 08:26 PM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `login_course`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(5) UNSIGNED NOT NULL COMMENT 'User id',
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'User name',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'First and last name of user',
  `email` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'User''s email',
  `password` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'User''s password',
  `reg_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'The time and date the user registered'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='User''s table';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `name`, `email`, `password`, `reg_time`) VALUES
(1, 'clabe45', 'Caleb Sacks', 'calebjs88@gmail.com', '$2y$10$Yug2sde23HCTkVZyI6g0suhu7.styX8Vta2hic0/fZxPaIqMknvP.', '2017-09-08 21:41:55'),
(2, 'hworld1234', 'Hello World', 'hellojworld@example.com', '$2y$10$2OBqGKB.tZhE701KwFS7MulvCahrdXiwsyBJuTmJCnaadIkakGihm', '2017-09-08 23:28:26'),
(3, 'gworld4321', 'Goodbye World', 'goodbyejworld@gmail.com', '$2y$10$40fnIBpNL.5vXdfc2Ik6CuSJA2BURqXZAuoGGQRnQJ/r1Gr6IZt7y', '2017-09-08 23:32:05'),
(4, 'heworld4321', 'Hey World', 'heyjworld@gmail.com', '$2y$10$YrCfqdMoskx17h6C63cHxejEjc8uCGt5B9qUyF9CpUGMnR4s/uCym', '2017-09-08 23:35:03'),
(5, 'dps101758', 'Daniel Sacks', 'dansacks11@gmail.com', '$2y$10$Dry0LWZni7TCyDZAmhvf9udrmyX3ScLt4qR0ILZYa.p3bdhtom2aO', '2017-09-08 23:42:05'),
(6, 'ljs1969', 'Lisa Sacks', 'lisajoysacks@yahoo.com', '$2y$10$zAXfykNKbcl3TkC6AfUABOlevKiOUrv7qcC0iTm6d0XkRknPMR91q', '2017-09-09 14:06:12'),
(7, 'test12', 'Test 12', 'test12@test.com', '$2y$10$Wif2Mtz7OSBeRyFumjJgQe8fVXPlvmoSyrU2II90vN7kY8LqxwqY6', '2017-09-09 14:11:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'User id', AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
