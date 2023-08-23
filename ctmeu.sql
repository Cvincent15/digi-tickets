-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 23, 2023 at 03:35 PM
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
  `password` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `startTicket` int(6) DEFAULT NULL,
  `endTicket` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_ctmeu_id`, `first_name`, `last_name`, `username`, `password`, `role`, `startTicket`, `endTicket`) VALUES
(40, 'Vincent Andrei', 'Cosio', 'suaVCosio', '$2y$10$DaMOaTZBb5Z.aARcCHYT5uBXewoTHccNFEyuXFOEjvg', 'Super Administrator', 0, 0),
(42, 'Kristine Emerald', 'Casindac', 'itsKCasindac', '$2y$10$bLduxFLI6OO5PONITBL4cuAO3WLD6xwQVa8g.TfhL1k', 'IT Administrator', 0, 0),
(43, 'Jazzlyn Kate', 'Aquino', 'itsJAquino', '$2y$10$uhpH0FZSH9eQt06OXfBev.AdQd.c.2DbJHGtjbxGbfO', 'IT Administrator', 0, 0),
(44, 'Dan Carlo', 'Ramirez', 'enfDRamirez', '$2y$10$vFt1tdS71i5ZxdyrQAroYu39sFeNa71IOADV724OhmY', 'Enforcer', 0, 0),
(45, 'Zsyra Beatrise', 'Almendral', 'itsZAlmendral', '$2y$10$pKkz1pc7Fvp0vPFfGYxNmeL5e/uwmW3cjpcc9eIhIRr', 'IT Administrator', 0, 0),
(50, 'Kyle Dennis', 'Dalida', 'enfKDalida', '$2y$10$QGRj4sqhw5B4Psrlrs3MnuQCJuCdmHeIVkBTokwtAej', 'Enforcer', 0, 0),
(52, 'Lorenz Adrian', 'Artillagas', 'suaLArtillagas', '$2y$10$fQ2eXI1ZwIOQzcQ0sxKsHOoClarZk4URmDrNLNhDcRD', 'Super Administrator', NULL, NULL);

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
  MODIFY `user_ctmeu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

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
