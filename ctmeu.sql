-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 24, 2023 at 11:27 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ctmeu`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_ctmeu_id` int(11) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `startTicket` int(6) DEFAULT NULL,
  `endTicket` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_ctmeu_id`, `first_name`, `last_name`, `username`, `password`, `role`, `startTicket`, `endTicket`) VALUES
(55, 'Lorenz Adrian', 'Artillagas', 'suaLArtillagas', '$2y$10$eBRzuxuhARfOglgnoDfPIOKWfWOO1fzm/7dtn7ekY.KOp51SmHux2', 'Super Administrator', NULL, NULL),
(56, 'Vincent Andrei', 'Cosio', 'suaVCosio', '$2y$10$CgVBRVaVWCE/gdr1wSwmKu5sBAp.ZQ4nDrJ205OYy1QabRs0mCxre', 'Super Administrator', NULL, NULL),
(57, 'Kristine Emerald', 'Casindac', 'itsKCasindac', '$2y$10$7a79hmUn26xiO6Yduf0V5ugajSJ7V.jr28vzibUmT7jyDdTGc./KK', 'IT Administrator', NULL, NULL),
(58, 'Zsyra Beatrise', 'Almendral', 'itsZAlmendral', '$2y$10$FoLrzPZL4WUKp7x7f7YQMuRCIKiVI1OkZqNQrm.XZ30QUQhumFrBC', 'IT Administrator', NULL, NULL),
(59, 'Jazzlyn Kate', 'Aquino', 'itsJAquino', '$2y$10$fODyHUzw731MZGbkkOYPFeBxJewacAucw/YGqCDciqh3zbn7NPAUW', 'IT Administrator', NULL, NULL),
(60, 'Kyle Dennis', 'Dalida', 'enfKDalida', '$2y$10$g7O0UwF/Jau.8Lz/jCoLhuhqxphzIlhzxTlTA32/XX9QPNk7rBAlG', 'Enforcer', NULL, NULL),
(61, 'Dan Carlo', 'Ramirez', 'enfDRamirez', '$2y$10$PdMN6ThGqQLV9XX5FR8aWe9GkYXhwU.fv9m0CXKYR8A3JLz3cYdXG', 'Enforcer', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_motorists`
--

CREATE TABLE `users_motorists` (
  `user_id` int(11) NOT NULL,
  `driver_name` varchar(50) NOT NULL,
  `driver_email` varchar(30) NOT NULL,
  `driver_phone` int(13) NOT NULL,
  `driver_password` varchar(50) NOT NULL,
  `driver_license` varchar(20) NOT NULL,
  `birthday` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `violations`
--

CREATE TABLE `violations` (
  `violation_id` int(11) NOT NULL,
  `violation_code` varchar(10) NOT NULL,
  `violation_name` varchar(20) NOT NULL,
  `ticket_id_violations` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `violation_tickets`
--

CREATE TABLE `violation_tickets` (
  `ticket_id` int(11) NOT NULL,
  `driver_name` varchar(50) NOT NULL,
  `driver_address` varchar(100) NOT NULL,
  `driver_license` varchar(50) NOT NULL,
  `issuing_district` varchar(20) NOT NULL,
  `vehicle_type` varchar(20) NOT NULL,
  `plate_no` varchar(20) NOT NULL,
  `cor_no` int(20) NOT NULL,
  `place_issued` varchar(50) NOT NULL,
  `reg_owner` varchar(50) NOT NULL,
  `reg_owner_address` varchar(50) NOT NULL,
  `date_time_violation` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `place_of_occurence` varchar(50) NOT NULL,
  `user_ctmeu_id` int(11) NOT NULL,
  `user_id_motorists` int(11) DEFAULT NULL,
  `is_settled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_ctmeu_id`);

--
-- Indexes for table `users_motorists`
--
ALTER TABLE `users_motorists`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `violations`
--
ALTER TABLE `violations`
  ADD PRIMARY KEY (`violation_id`),
  ADD KEY `ticket violation` (`ticket_id_violations`);

--
-- Indexes for table `violation_tickets`
--
ALTER TABLE `violation_tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `ticket sender` (`user_ctmeu_id`),
  ADD KEY `user_id_motorists` (`user_id_motorists`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_ctmeu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `users_motorists`
--
ALTER TABLE `users_motorists`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `violations`
--
ALTER TABLE `violations`
  MODIFY `violation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `violation_tickets`
--
ALTER TABLE `violation_tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `violations`
--
ALTER TABLE `violations`
  ADD CONSTRAINT `ticket violation` FOREIGN KEY (`ticket_id_violations`) REFERENCES `violation_tickets` (`ticket_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `violation_tickets`
--
ALTER TABLE `violation_tickets`
  ADD CONSTRAINT `ticket sender` FOREIGN KEY (`user_ctmeu_id`) REFERENCES `users` (`user_ctmeu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `violation_tickets_ibfk_1` FOREIGN KEY (`user_id_motorists`) REFERENCES `users_motorists` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
