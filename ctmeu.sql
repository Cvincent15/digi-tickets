-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2023 at 08:44 PM
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
-- Database: `ctmeu2`
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
(55, 'Lorenz Adrian', 'Artillagas', 'suaLArtillagas', '$2y$10$AfnrrkgGdBX8GM9G5t73MO0fjVL4sdOLRXGUv1haKEb3ws.PjlYqa', 'Super Administrator', NULL, NULL),
(56, 'Vincent Andrei', 'Cosio', 'suaVCosio', '$2y$10$TgYe54Uo23DFVoQbwIBVhuFu44Pygiku/B.b3mUm9IoEtV9kc/N8i', 'Super Administrator', NULL, NULL),
(57, 'Kristine Emerald', 'Casindac', 'itsKCasindac', '$2y$10$7a79hmUn26xiO6Yduf0V5ugajSJ7V.jr28vzibUmT7jyDdTGc./KK', 'IT Administrator', NULL, NULL),
(58, 'Zsyra Beatrise', 'Almendral', 'itsZAlmendral', '$2y$10$FoLrzPZL4WUKp7x7f7YQMuRCIKiVI1OkZqNQrm.XZ30QUQhumFrBC', 'IT Administrator', NULL, NULL),
(59, 'Jazzlyn Kate', 'Aquino', 'itsJAquino', '$2y$10$fODyHUzw731MZGbkkOYPFeBxJewacAucw/YGqCDciqh3zbn7NPAUW', 'IT Administrator', NULL, NULL),
(70, 'Kyle Dennis', 'Dalida', 'enfKDalida', '$2y$10$TKURg8EEGf32mdRWwlKbm.YMOtXsa2zrK4OkwNtcIByM9kyKV1ifu', 'Enforcer', NULL, NULL),
(73, 'Jhimwell', 'Robles', 'enfJRobles', '$2y$10$bB5v0ePlisqJ5EdJtFDmaeXF.BwuQiKV8ze3uY1hf9u7640akKn.K', 'Enforcer', NULL, NULL),
(74, 'Dan Carlo', 'Ramirez', 'enfDRamirez', '$2y$10$pzH/jEmPx0oVS8PTEfRhF.IpEzo/s57PBd44Rp3DYKV279cRBoqdm', 'Enforcer', NULL, NULL),
(76, 'Carl', 'Bantatua', 'enfCBantatua', '$2y$10$8NcAU3XI/00E7VxDfqESfe3T3SdpN7aK/ukXY9zptVaJ3mcwHaKnW', 'Enforcer', NULL, NULL);

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
  `driver_phone` int(13) NOT NULL,
  `driver_password` varchar(250) NOT NULL,
  `driver_license` varchar(20) NOT NULL,
  `driver_license_expiry` date NOT NULL,
  `driver_license_serial` varchar(50) NOT NULL,
  `is_filipino` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_motorists`
--

INSERT INTO `users_motorists` (`user_id`, `driver_last_name`, `driver_first_name`, `driver_middle_name`, `driver_birthday`, `driver_gender`, `mother_last_name`, `mother_first_name`, `mother_middle_name`, `driver_email`, `driver_phone`, `driver_password`, `driver_license`, `driver_license_expiry`, `driver_license_serial`, `is_filipino`) VALUES
(5, 'driver last name', 'driver first name', 'driver middle name', '2024-03-06', 'Male', 'mom last name', 'mom first name', 'mom middle name', 'something@gmail.com', 2147483647, '$2y$10$Yg2m32rymMKxk1GRU4/jrOTl3R27hi4Nt4RMhymlKgZBKtxRFJEPi', 'license goes heres', '2024-05-15', 'serial heree', 1);

-- --------------------------------------------------------

--
-- Table structure for table `violations`
--

CREATE TABLE `violations` (
  `violation_id` int(11) NOT NULL,
  `violation_code` varchar(10) NOT NULL,
  `violation_name` varchar(100) NOT NULL,
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
  `cor_no` int(20) DEFAULT NULL,
  `place_issued` varchar(50) DEFAULT NULL,
  `reg_owner` varchar(50) NOT NULL,
  `reg_owner_address` varchar(50) NOT NULL,
  `date_time_violation` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `place_of_occurrence` varchar(50) NOT NULL,
  `user_ctmeu_id` int(11) DEFAULT NULL,
  `user_id_motorists` int(11) DEFAULT NULL,
  `is_settled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `violation_tickets`
--

INSERT INTO `violation_tickets` (`ticket_id`, `driver_name`, `driver_address`, `driver_license`, `issuing_district`, `vehicle_type`, `plate_no`, `cor_no`, `place_issued`, `reg_owner`, `reg_owner_address`, `date_time_violation`, `place_of_occurrence`, `user_ctmeu_id`, `user_id_motorists`, `is_settled`) VALUES
(73, 'John Doe', '123 Main St, Cityville', 'DL123456', 'District A', 'Sedan', 'ABC123', NULL, NULL, 'Jane Doe', '456 Elm St, Townsville', '2023-08-01 10:51:45', 'Intersection of Oak Ave and Maple St', 74, NULL, 0),
(74, 'Alice Smith', '789 Elm St, Villagetown', 'DL987654', 'District B', 'SUV', 'XYZ789', NULL, NULL, 'Bob Smith', '101 Pine St, Hamletville', '2023-07-04 10:54:31', 'Parking Lot C', 76, NULL, 0),
(75, 'Michael Johnson', '456 Oak St, Countryside', 'DL456789', 'District C', 'Motorcycle', 'MNO456', NULL, NULL, 'Sarah Johnson', '777 Cedar St, Farmville', '2023-06-06 10:54:31', 'Highway 101', 70, NULL, 0),
(76, 'Emily Wilson', '321 Pine St, Smalltown', 'DL654321', 'District A', 'Truck', 'DEF456', NULL, NULL, 'David Wilson', '555 Birch St, Villageville', '2023-05-09 10:54:31', 'Construction Zone', 76, NULL, 0),
(77, 'Jessica Brown', '222 Maple St, Riverside', 'DL123789', 'District B', 'Sedan', 'JKL123', NULL, NULL, 'Michael Brown', '888 Oak St, Hillside', '2023-04-19 10:54:31', 'School Zone', 73, NULL, 0),
(78, 'Daniel Garcia', '555 Cedar St, Lakeside', 'DL789123', 'District C', 'SUV', 'GHI789', NULL, NULL, 'Linda Garcia', '222 Elm St, Parkville', '2023-05-22 10:54:31', 'Shopping Center', 73, NULL, 0),
(79, 'Sophia Lee', '777 Birch St, Forestville', 'DL321789', 'District A', 'Motorcycle', 'PQR789', NULL, NULL, 'Jason Lee', '333 Oak St, Suburbia', '2023-03-13 10:54:31', 'Gas Station', 76, NULL, 0),
(80, 'William Martinez', '888 Pine St, Waterside', 'DL456123', 'District B', 'Truck', 'UVW123', NULL, NULL, 'Maria Martinez', '444 Elm St, Countrysville', '2023-09-04 10:54:31', 'Residential Area', 76, NULL, 0),
(81, 'Olivia Rodriguez', '333 Oak St, Townsville', 'DL987123', 'District C', 'Sedan', 'STU123', NULL, NULL, 'Robert Rodriguez', '999 Cedar St, Villagetown', '2023-09-04 10:55:37', 'Parking Garage', 74, NULL, 0),
(82, 'Ethan Davis', '999 Elm St, Hamletville', 'DL789456', 'District A', 'SUV', 'VWX123', NULL, NULL, 'Jennifer Davis', '777 Pine St, Smalltown', '2023-09-04 10:54:31', 'Highway 102', 73, NULL, 0),
(83, 'Ava Hernandez', '111 Birch St, Farmville', 'DL987456', 'District B', 'Motorcycle', 'YZA123', NULL, NULL, 'Carlos Hernandez', '111 Oak St, Riverside', '2023-09-04 10:55:35', 'City Park', 70, NULL, 0),
(84, 'Mason Lewis', '444 Maple St, Villageville', 'DL321456', 'District C', 'Truck', 'BCD123', NULL, NULL, 'Angela Lewis', '666 Elm St, Lakeside', '2023-09-04 10:51:07', 'Downtown Area', NULL, NULL, 0),
(85, 'Liam Walker', '666 Cedar St, Parkville', 'DL456987', 'District A', 'Sedan', 'EFG123', NULL, NULL, 'Mary Walker', '888 Oak St, Forestville', '2023-09-04 10:55:32', 'Gas Station', NULL, NULL, 0),
(86, 'Charlotte Wright', '111 Elm St, Suburbia', 'DL987321', 'District B', 'SUV', 'HIJ123', NULL, NULL, 'Richard Wright', '222 Pine St, Waterside', '2023-09-04 10:51:07', 'Shopping Center', NULL, NULL, 0),
(87, 'Lucas King', '777 Oak St, Countrysville', 'DL123987', 'District C', 'Motorcycle', 'KLM123', NULL, NULL, 'Patricia King', '111 Cedar St, Townsville', '2023-09-04 10:55:27', 'School Zone', NULL, NULL, 0),
(88, 'Aria Young', '888 Cedar St, Villagetown', 'DL654987', 'District A', 'Truck', 'NOP123', NULL, NULL, 'James Young', '555 Birch St, Hamletville', '2023-09-04 10:51:07', 'Residential Area', NULL, NULL, 0),
(89, 'Henry Turner', '222 Elm St, Farmville', 'DL789654', 'District B', 'Sedan', 'QRS123', NULL, NULL, 'Karen Turner', '777 Pine St, Riverside', '2023-09-04 10:55:24', 'Parking Lot D', NULL, NULL, 0),
(90, 'Grace Parker', '555 Oak St, Villageville', 'DL123654', 'District C', 'SUV', 'TUV123', NULL, NULL, 'Joseph Parker', '999 Elm St, Countryside', '2023-09-04 11:34:24', 'Intersection of Maple St and Cedar St', NULL, NULL, 1),
(91, 'Jackson Adams', '333 Cedar St, Parkville', 'DL987654', 'District A', 'Motorcycle', 'WXY123', NULL, NULL, 'Nancy Adams', '333 Birch St, Forestville', '2023-09-04 11:34:24', 'Highway 103', NULL, NULL, 1),
(92, 'Sophie Baker', '111 Pine St, Suburbia', 'DL456654', 'District B', 'Truck', 'ZAB123', NULL, NULL, 'John Baker', '444 Oak St, Waterside', '2023-09-04 11:34:24', 'Gas Station', NULL, NULL, 1);

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
  MODIFY `user_ctmeu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `users_motorists`
--
ALTER TABLE `users_motorists`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `violations`
--
ALTER TABLE `violations`
  MODIFY `violation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `violation_tickets`
--
ALTER TABLE `violation_tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

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
