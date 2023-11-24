-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2023 at 05:18 AM
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
-- Table structure for table `motorist_documents`
--

CREATE TABLE `motorist_documents` (
  `document_id` varchar(20) NOT NULL,
  `license_type` varchar(20) NOT NULL,
  `expiry_date` date NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `motorist_documents`
--

INSERT INTO `motorist_documents` (`document_id`, `license_type`, `expiry_date`, `status`) VALUES
('N02-18-018507', 'Driver\'s License', '2023-09-16', 1);

-- --------------------------------------------------------

--
-- Table structure for table `motorist_info`
--

CREATE TABLE `motorist_info` (
  `motorist_info_id` int(11) NOT NULL,
  `driver_area_code` varchar(30) DEFAULT NULL,
  `civil_status` varchar(20) DEFAULT NULL,
  `birthplace` varchar(50) DEFAULT NULL,
  `blood_type` varchar(10) DEFAULT NULL,
  `complexion` varchar(20) DEFAULT NULL,
  `eye_color` varchar(20) DEFAULT NULL,
  `hair_color` varchar(20) DEFAULT NULL,
  `weight` int(150) DEFAULT NULL,
  `height` int(150) DEFAULT NULL,
  `organ_donor` varchar(50) DEFAULT NULL,
  `em_name` varchar(30) DEFAULT NULL,
  `em_area_code` varchar(30) DEFAULT NULL,
  `em_mobile` varchar(11) DEFAULT NULL,
  `em_address` varchar(50) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `users_motorists_info_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `motorist_info`
--

INSERT INTO `motorist_info` (`motorist_info_id`, `driver_area_code`, `civil_status`, `birthplace`, `blood_type`, `complexion`, `eye_color`, `hair_color`, `weight`, `height`, `organ_donor`, `em_name`, `em_area_code`, `em_mobile`, `em_address`, `address`, `users_motorists_info_id`) VALUES
(5, '4020', 'Single', 'Santa Rosa', 'O+', 'White', 'Blue', 'Yellow', 60, 168, 'Lungs', 'Nigel Malapitan', '4020', '+6394521312', 'Dyan lang malapits', 'dun lang sa tagapo', 6);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_ctmeu_id` int(11) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `middle_name` varchar(20) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `affixes` varchar(10) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `startTicket` int(6) DEFAULT NULL,
  `endTicket` int(6) DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  `is_activated` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_ctmeu_id`, `first_name`, `middle_name`, `last_name`, `affixes`, `username`, `password`, `role`, `startTicket`, `endTicket`, `email`, `is_activated`) VALUES
(56, 'Vincent Andrei', '', 'Cosio', '', 'suaVCosio', '$2y$10$TgYe54Uo23DFVoQbwIBVhuFu44Pygiku/B.b3mUm9IoEtV9kc/N8i', 'Super Administrator', NULL, NULL, 'vincent.andrei15@gmail.com', 0),
(57, 'Kristine Emerald', '', 'Casindac', '', 'itsKCasindac', '$2y$10$7a79hmUn26xiO6Yduf0V5ugajSJ7V.jr28vzibUmT7jyDdTGc./KK', 'IT Administrator', NULL, NULL, '', 0),
(58, 'Zsyra Beatrise', '', 'Almendral', '', 'itsZAlmendral', '$2y$10$FoLrzPZL4WUKp7x7f7YQMuRCIKiVI1OkZqNQrm.XZ30QUQhumFrBC', 'IT Administrator', NULL, NULL, '', 0),
(59, 'Jazzlyn Kate', '', 'Aquino', '', 'itsJAquino', '$2y$10$fODyHUzw731MZGbkkOYPFeBxJewacAucw/YGqCDciqh3zbn7NPAUW', 'IT Administrator', NULL, NULL, '', 0),
(70, 'Kyle Dennis', '', 'Dalida', '', 'enfKDalida', '$2y$10$TKURg8EEGf32mdRWwlKbm.YMOtXsa2zrK4OkwNtcIByM9kyKV1ifu', 'Enforcer', NULL, NULL, '', 0),
(73, 'Jhimwell', '', 'Robles', '', 'enfJRobles', '$2y$10$bB5v0ePlisqJ5EdJtFDmaeXF.BwuQiKV8ze3uY1hf9u7640akKn.K', 'Enforcer', NULL, NULL, '', 0),
(74, 'Dan Carlo', '', 'Ramirez', '', 'enfDRamirez', '$2y$10$TN/0F4PsSP6IHez/1djKXOLmDCMrk/rWl4ZBCKep9pTAXh1gmPKZO', 'Enforcer', NULL, NULL, '', 0),
(76, 'Carl', '', 'Bantatua', '', 'enfCBantatua', '$2y$10$8NcAU3XI/00E7VxDfqESfe3T3SdpN7aK/ukXY9zptVaJ3mcwHaKnW', 'Enforcer', NULL, NULL, '', 0),
(90, 'Lorenz Adrian', 'Nofuente', 'Artillagas', '', 'Zephyr', '$2y$10$osueKM4rArR5IpQHKq/rUuQEfb.WdPcXYaQzNS4mVcz26XtlPyf3i', 'Super Administrator', NULL, NULL, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users_motorists`
--

CREATE TABLE `users_motorists` (
  `user_id` int(11) NOT NULL,
  `driver_last_name` varchar(50) NOT NULL,
  `driver_first_name` varchar(50) NOT NULL,
  `driver_middle_name` varchar(50) DEFAULT NULL,
  `driver_birthday` date NOT NULL,
  `driver_gender` varchar(10) NOT NULL,
  `mother_last_name` varchar(50) NOT NULL,
  `mother_first_name` varchar(50) NOT NULL,
  `mother_middle_name` varchar(50) NOT NULL,
  `driver_email` varchar(30) NOT NULL,
  `driver_phone` varchar(13) NOT NULL,
  `driver_password` varchar(250) NOT NULL,
  `driver_license` varchar(20) NOT NULL,
  `driver_license_expiry` date NOT NULL,
  `driver_license_serial` varchar(50) NOT NULL,
  `is_filipino` tinyint(1) NOT NULL,
  `is_activated` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_motorists`
--

INSERT INTO `users_motorists` (`user_id`, `driver_last_name`, `driver_first_name`, `driver_middle_name`, `driver_birthday`, `driver_gender`, `mother_last_name`, `mother_first_name`, `mother_middle_name`, `driver_email`, `driver_phone`, `driver_password`, `driver_license`, `driver_license_expiry`, `driver_license_serial`, `is_filipino`, `is_activated`) VALUES
(6, 'Johnson', 'Sarah', 'Black-Briar', '2003-06-11', 'Male', 'Black-Briar', 'Maven', 'Riften', 'sarahjohnson@gmail.com', '+639956372834', '$2y$10$1x2NpUncR9ZFrM8muJkZXe94Vqm6ezJc1oam8tilWeJuZrQpZ.sOW', 'B45-67-890123', '2026-08-19', '111111111111', 1, 0),
(9, 'Smith', 'Alice', 'Masda', '2001-08-06', 'Female', 'Masda', 'Melissa', 'Tasda', 'alicesmith@gmail.com', '+639123456789', '$2y$10$t6ramdBpiu5d0JWakQH2aOLUaadVvt1/9ZSWvKcHHILNelxM/xigG', 'A12-34-567890', '2024-05-15', '222222222222', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `vehicletype`
--

CREATE TABLE `vehicletype` (
  `vehicle_id` int(11) NOT NULL,
  `vehicle_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicletype`
--

INSERT INTO `vehicletype` (`vehicle_id`, `vehicle_name`) VALUES
(1, 'Car'),
(2, 'Motorcycle'),
(3, 'Truck'),
(4, 'Bus'),
(5, 'Van'),
(6, 'Tricycle'),
(7, 'E-Bike');

-- --------------------------------------------------------

--
-- Table structure for table `violationlist`
--

CREATE TABLE `violationlist` (
  `violationlist_id` int(11) NOT NULL,
  `violation_code` varchar(5) NOT NULL,
  `violation_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `violations`
--

CREATE TABLE `violations` (
  `violation_id` int(11) NOT NULL,
  `violation_list_id` int(11) NOT NULL,
  `ticket_id_violations` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `violation_tickets`
--

CREATE TABLE `violation_tickets` (
  `ticket_id` int(11) NOT NULL,
  `driver_name` varchar(50) NOT NULL,
  `driver_license` varchar(50) NOT NULL,
  `vehicle_type` int(11) NOT NULL,
  `plate_no` varchar(20) NOT NULL,
  `date_time_violation` varchar(20) NOT NULL,
  `date_time_violation_edit` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `place_of_occurrence` varchar(50) NOT NULL,
  `user_ctmeu_id` int(11) DEFAULT NULL,
  `user_id_motorists` int(11) DEFAULT NULL,
  `is_settled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `motorist_info`
--
ALTER TABLE `motorist_info`
  ADD PRIMARY KEY (`motorist_info_id`),
  ADD KEY `motorist info id` (`users_motorists_info_id`);

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
-- Indexes for table `vehicletype`
--
ALTER TABLE `vehicletype`
  ADD PRIMARY KEY (`vehicle_id`);

--
-- Indexes for table `violationlist`
--
ALTER TABLE `violationlist`
  ADD PRIMARY KEY (`violationlist_id`);

--
-- Indexes for table `violations`
--
ALTER TABLE `violations`
  ADD PRIMARY KEY (`violation_id`),
  ADD KEY `ticket violation` (`ticket_id_violations`),
  ADD KEY `violations_ibfk_1` (`violation_list_id`);

--
-- Indexes for table `violation_tickets`
--
ALTER TABLE `violation_tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `user_id_motorists` (`user_id_motorists`),
  ADD KEY `ticket sender` (`user_ctmeu_id`),
  ADD KEY `vehicle_type` (`vehicle_type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `motorist_info`
--
ALTER TABLE `motorist_info`
  MODIFY `motorist_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_ctmeu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `users_motorists`
--
ALTER TABLE `users_motorists`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `vehicletype`
--
ALTER TABLE `vehicletype`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `violationlist`
--
ALTER TABLE `violationlist`
  MODIFY `violationlist_id` int(11) NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `motorist_info`
--
ALTER TABLE `motorist_info`
  ADD CONSTRAINT `motorist info id` FOREIGN KEY (`users_motorists_info_id`) REFERENCES `users_motorists` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `violations`
--
ALTER TABLE `violations`
  ADD CONSTRAINT `ticket violation` FOREIGN KEY (`ticket_id_violations`) REFERENCES `violation_tickets` (`ticket_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `violations_ibfk_1` FOREIGN KEY (`violation_list_id`) REFERENCES `violationlist` (`violationlist_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `violation_tickets`
--
ALTER TABLE `violation_tickets`
  ADD CONSTRAINT `ticket sender` FOREIGN KEY (`user_ctmeu_id`) REFERENCES `users` (`user_ctmeu_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `violation_tickets_ibfk_1` FOREIGN KEY (`user_id_motorists`) REFERENCES `users_motorists` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `violation_tickets_ibfk_2` FOREIGN KEY (`vehicle_type`) REFERENCES `vehicletype` (`vehicle_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
