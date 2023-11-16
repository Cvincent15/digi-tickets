-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2023 at 01:25 AM
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
  `last_name` varchar(50) NOT NULL,
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

INSERT INTO `users` (`user_ctmeu_id`, `first_name`, `last_name`, `username`, `password`, `role`, `startTicket`, `endTicket`, `email`, `is_activated`) VALUES
(55, 'Lorenz Adrian', 'Artillagas', 'suaLArtillagas', '$2y$10$AfnrrkgGdBX8GM9G5t73MO0fjVL4sdOLRXGUv1haKEb3ws.PjlYqa', 'Super Administrator', NULL, NULL, '', 0),
(56, 'Vincent Andrei', 'Cosio', 'suaVCosio', '$2y$10$TgYe54Uo23DFVoQbwIBVhuFu44Pygiku/B.b3mUm9IoEtV9kc/N8i', 'Super Administrator', NULL, NULL, 'vincent.andrei15@gmail.com', 0),
(57, 'Kristine Emerald', 'Casindac', 'itsKCasindac', '$2y$10$7a79hmUn26xiO6Yduf0V5ugajSJ7V.jr28vzibUmT7jyDdTGc./KK', 'IT Administrator', NULL, NULL, '', 0),
(58, 'Zsyra Beatrise', 'Almendral', 'itsZAlmendral', '$2y$10$FoLrzPZL4WUKp7x7f7YQMuRCIKiVI1OkZqNQrm.XZ30QUQhumFrBC', 'IT Administrator', NULL, NULL, '', 0),
(59, 'Jazzlyn Kate', 'Aquino', 'itsJAquino', '$2y$10$fODyHUzw731MZGbkkOYPFeBxJewacAucw/YGqCDciqh3zbn7NPAUW', 'IT Administrator', NULL, NULL, '', 0),
(70, 'Kyle Dennis', 'Dalida', 'enfKDalida', '$2y$10$TKURg8EEGf32mdRWwlKbm.YMOtXsa2zrK4OkwNtcIByM9kyKV1ifu', 'Enforcer', NULL, NULL, '', 0),
(73, 'Jhimwell', 'Robles', 'enfJRobles', '$2y$10$bB5v0ePlisqJ5EdJtFDmaeXF.BwuQiKV8ze3uY1hf9u7640akKn.K', 'Enforcer', NULL, NULL, '', 0),
(74, 'Dan Carlo', 'Ramirez', 'enfDRamirez', '$2y$10$AJY.heS1GdiwnWdFpgSWzu46ijT3LfjLcTg9EwFQt3HkyxPPjShrW', 'Enforcer', NULL, NULL, '', 0),
(76, 'Carl', 'Bantatua', 'enfCBantatua', '$2y$10$8NcAU3XI/00E7VxDfqESfe3T3SdpN7aK/ukXY9zptVaJ3mcwHaKnW', 'Enforcer', NULL, NULL, '', 0);

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
-- Table structure for table `violations`
--

CREATE TABLE `violations` (
  `violation_id` int(11) NOT NULL,
  `violation_code` varchar(10) DEFAULT NULL,
  `violation_name` varchar(100) NOT NULL,
  `ticket_id_violations` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `violations`
--

INSERT INTO `violations` (`violation_id`, `violation_code`, `violation_name`, `ticket_id_violations`) VALUES
(8, NULL, 'Driving without license', 110),
(9, NULL, 'Driving with a delinquent, invalid, suspended ineffectual or revoked license', 110),
(10, NULL, 'Fake or Counterfeit License', 110),
(11, NULL, 'Defective horn or signaling device', 110),
(12, NULL, 'Defective brakes', 110),
(13, NULL, 'Tampered/marked plate or stickers', 110),
(14, NULL, 'Driving without license', 111),
(15, NULL, 'Defective horn or signaling device', 111),
(16, NULL, 'Defective brakes', 111),
(17, NULL, 'Defective horn or signaling device', 112),
(18, NULL, 'Defective brakes', 112),
(19, NULL, 'Tampered/marked plate or stickers', 112),
(20, NULL, 'Defective horn or signaling device', 112),
(21, NULL, 'Defective brakes', 112),
(22, NULL, 'Defective horn or signaling device', 113),
(23, NULL, 'Defective horn or signaling device', 114),
(24, NULL, 'Defective horn or signaling device', 115),
(25, NULL, 'Defective horn or signaling device', 116),
(26, NULL, 'Defective horn or signaling device', 117),
(27, NULL, 'Defective horn or signaling device', 118),
(28, NULL, 'Defective horn or signaling device', 119),
(29, NULL, 'Defective horn or signaling device', 120),
(30, NULL, 'Defective horn or signaling device', 121),
(31, NULL, 'Defective horn or signaling device', 122),
(32, NULL, 'Defective horn or signaling device', 123),
(33, NULL, 'Defective horn or signaling device', 124),
(34, NULL, 'Defective horn or signaling device', 125),
(35, NULL, 'Defective horn or signaling device', 126),
(36, NULL, 'Defective horn or signaling device', 127),
(37, NULL, 'Defective horn or signaling device', 128),
(38, NULL, 'Defective horn or signaling device', 129),
(39, NULL, 'Defective horn or signaling device', 130),
(40, NULL, 'Defective horn or signaling device', 131),
(41, NULL, 'Defective horn or signaling device', 132),
(42, NULL, 'Driving with a delinquent, invalid, suspended ineffectual or revoked license', 133),
(43, NULL, 'Fake or Counterfeit License', 133);

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
  `cor_no` varchar(10) DEFAULT NULL,
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
(73, 'John Does', '123 Main St, Cityville', 'DL123456', 'District A', 'Sedan', 'ABC123', '12345', 'dunno', 'Jane Doe', '456 Elm St, Townsville', '2023-09-14 13:59:03', 'Intersection of Oak Ave and Maple St', 74, NULL, 1),
(74, 'Alice Smith', '789 Elm St, Villagetown', 'DL987654', 'District B', 'SUV', 'XYZ789', '', '', 'Bob Smith', '101 Pine St, Hamletville', '2023-09-14 13:59:03', 'Parking Lot C', 76, NULL, 1),
(75, 'Michael Johnson', '456 Oak St, Countryside', 'DL456789', 'District C', 'Motorcycle', 'MNO456', '', '', 'Sarah Johnson', '777 Cedar St, Farmville', '2023-09-14 13:59:03', 'Highway 101', 70, NULL, 1),
(76, 'Emily Wilson', '321 Pine St, Smalltown', 'DL654321', 'District A', 'Truck', 'DEF456', '', '', 'David Wilson', '555 Birch St, Villageville', '2023-09-14 13:59:03', 'Construction Zone', 76, NULL, 1),
(77, 'Jessica Brown', '222 Maple St, Riverside', 'DL123789', 'District B', 'Sedan', 'JKL123', '', '', 'Michael Brown', '888 Oak St, Hillside', '2023-09-14 13:59:03', 'School Zone', 73, NULL, 1),
(78, 'Daniel Garcia', '555 Cedar St, Lakeside', 'DL789123', 'District C', 'SUV', 'GHI789', '', '', 'Linda Garcia', '222 Elm St, Parkville', '2023-09-14 13:59:03', 'Shopping Center', 73, NULL, 1),
(79, 'Sophia Lee', '777 Birch St, Forestville', 'DL321789', 'District A', 'Motorcycle', 'PQR789', '', '', 'Jason Lee', '333 Oak St, Suburbia', '2023-09-14 13:59:03', 'Gas Station', 76, NULL, 1),
(80, 'William Martinez', '888 Pine St, Waterside', 'DL456123', 'District B', 'Truck', 'UVW123', '', '', 'Maria Martinez', '444 Elm St, Countrysville', '2023-09-14 13:59:03', 'Residential Area', 76, NULL, 1),
(81, 'Olivia Rodriguez', '333 Oak St, Townsville', 'DL987123', 'District C', 'Sedan', 'STU123', '', '', 'Robert Rodriguez', '999 Cedar St, Villagetown', '2023-09-14 13:59:03', 'Parking Garage', 74, NULL, 1),
(82, 'Ethan Davis', '999 Elm St, Hamletville', 'DL789456', 'District A', 'SUV', 'VWX123', '', '', 'Jennifer Davis', '777 Pine St, Smalltown', '2023-09-14 13:59:03', 'Highway 102', 73, NULL, 1),
(83, 'Ava Hernandez', '111 Birch St, Farmville', 'DL987456', 'District B', 'Motorcycle', 'YZA123', '', '', 'Carlos Hernandez', '111 Oak St, Riverside', '2023-09-14 13:59:03', 'City Park', 70, NULL, 1),
(84, 'Mason Lewis', '444 Maple St, Villageville', 'DL321456', 'District C', 'Truck', 'BCD123', '', '', 'Angela Lewis', '666 Elm St, Lakeside', '2023-09-14 14:24:05', 'Downtown Area', 76, NULL, 1),
(85, 'Liam Walker', '666 Cedar St, Parkville', 'DL456987', 'District A', 'Sedan', 'EFG123', '', '', 'Mary Walker', '888 Oak St, Forestville', '2023-09-14 14:24:09', 'Gas Station', 74, NULL, 1),
(86, 'Charlotte Wright', '111 Elm St, Suburbia', 'DL987321', 'District B', 'SUV', 'HIJ123', '', '', 'Richard Wright', '222 Pine St, Waterside', '2023-09-14 14:24:15', 'Shopping Center', 59, NULL, 1),
(87, 'Lucas King', '777 Oak St, Countrysville', 'DL123987', 'District C', 'Motorcycle', 'KLM123', '', '', 'Patricia King', '111 Cedar St, Townsville', '2023-09-14 14:25:01', 'School Zone', 70, NULL, 1),
(88, 'Aria Young', '888 Cedar St, Villagetown', 'DL654987', 'District A', 'Truck', 'NOP123', '', '', 'James Young', '555 Birch St, Hamletville', '2023-09-14 14:25:27', 'Residential Area', 73, NULL, 1),
(89, 'Henry Turner', '222 Elm St, Farmville', 'DL789654', 'District B', 'Sedan', 'QRS123', '', '', 'Karen Turner', '777 Pine St, Riverside', '2023-09-14 14:26:44', 'Parking Lot D', 70, NULL, 1),
(90, 'Grace Parker', '555 Oak St, Villageville', 'DL123654', 'District C', 'SUV', 'TUV123', '', '', 'Joseph Parker', '999 Elm St, Countryside', '2023-09-13 06:55:27', 'Intersection of Maple St and Cedar St', 73, NULL, 1),
(91, 'Jackson Adams', '333 Cedar St, Parkville', 'DL987654', 'District A', 'Motorcycle', 'WXY123', '', '', 'Nancy Adams', '333 Birch St, Forestville', '2023-09-13 06:55:33', 'Highway 103', 70, NULL, 1),
(92, 'Sophie Baker', '111 Pine St, Suburbia', 'DL456654', 'District B', 'Truck', 'ZAB123', '', '', 'John Baker', '444 Oak St, Waterside', '2023-09-13 06:55:37', 'Gas Station', 74, NULL, 1),
(110, 'Vincent Andrei M Cosio', 'Marcopolo Tagapo', 'N03-21-654532', 'canlalay', 'Motorcycle', 'ABC0987', '11111111-2', 'dunno', 'Vincent Andrei M Cosio', 'Marcopolo Tagapo', '2023-09-14 14:26:54', 'SM', 70, NULL, 1),
(111, 'Dan Carlo Dela Cruz Ramirez', 'BLK 16 LOT 33 GRAND RIVERSTONE VILLAGE DITA SANTA ', 'N50-20-026873', 'Taguig', 'Tesla', 'ABC 234', '12345678-1', 'Taguig', 'Dan Carlo Dela Cruz Ramirez', 'BLK 16 LOT 33 GRAND RIVERSTONE VILLAGE DITA SANTA ', '2023-09-14 14:26:59', 'Golden City', 73, NULL, 0),
(112, 'John Does', 'Marcopolo Tagapo', 'N03-21-654532', 'Taguig', 'Motorcycle', 'ABC0987', '87654321-3', 'Taguig', 'Jane Does', 'Marcopolo Tagapo', '2023-09-14 14:27:04', 'SM', 73, NULL, 0),
(113, 'Alice Smith', '123 Oak Street', 'A12-34-567890', 'Los Angeles', 'Car', 'XYZ1234', '98765432-1', 'Los Angeles', 'Bob Smith', '123 Oak Street', '2023-09-14 14:25:42', 'Downtown', 76, NULL, 0),
(114, 'Sarah Johnson', '456 Elm Avenue', 'B45-67-890123', 'New York', 'SUV', 'JKL5678', '87654321-2', 'New York', 'David Johnson', '456 Elm Avenue', '2023-09-15 14:32:40', 'Midtown', 76, 6, 0),
(115, 'Michael Brown', '789 Maple Lane', 'C78-90-123456', 'Chicago', 'Truck', 'PQR7890', '76543210-3', 'Chicago', 'Jennifer Brown', '789 Maple Lane', '2023-09-14 14:27:37', 'Industrial Area', 76, NULL, 0),
(116, 'James Wilson', '101 Pine Street', 'D01-23-456789', 'Houston', 'Van', 'MNO1234', '65432109-4', 'Houston', 'Emily Wilson', '101 Pine Street', '2023-09-14 14:27:42', 'Suburbs', 73, NULL, 0),
(117, 'William Davis', '222 Cedar Road', 'E45-67-890123', 'Miami', 'Motorcycle', 'GHI5678', '54321098-5', 'Miami', 'Olivia Davis', '222 Cedar Road', '2023-09-14 14:27:51', 'Beachfront', 73, NULL, 0),
(118, 'Linda Martinez', '333 Elm Street', 'F67-89-012345', 'San Francisco', 'Car', 'STU9012', '43210987-6', 'San Francisco', 'Carlos Martinez', '333 Elm Street', '2023-09-14 14:27:55', 'Downtown', 76, NULL, 0),
(119, 'Sophia Clark', '444 Oak Lane', 'G78-90-123456', 'Dallas', 'SUV', 'VWX3456', '32109876-7', 'Dallas', 'Daniel Clark', '444 Oak Lane', '2023-09-14 14:27:59', 'Shopping Mall', 70, NULL, 0),
(120, 'Oliver Adams', '555 Pine Avenue', 'H01-23-456789', 'Phoenix', 'Truck', 'YZA6789', '21098765-8', 'Phoenix', 'Isabella Adams', '555 Pine Avenue', '2023-09-14 14:28:04', 'Industrial Park', 70, NULL, 0),
(121, 'Ethan Turner', '666 Cedar Street', 'I45-67-890123', 'Seattle', 'Car', 'BCD8901', '09876543-9', 'Seattle', 'Ava Turner', '666 Cedar Street', '2023-09-14 14:28:14', 'Suburbs', 76, NULL, 0),
(122, 'Mia Harris', '777 Elm Road', 'J78-90-123456', 'Denver', 'Motorcycle', 'EFG1234', '98765432-0', 'Denver', 'Noah Harris', '777 Elm Road', '2023-09-14 14:28:18', 'City Park', 74, NULL, 0),
(123, 'Ella Johnson', '789 Willow Lane', 'K01-23-456789', 'San Diego', 'Car', 'LMN4567', '87654321-1', 'San Diego', 'Jacob Johnson', '789 Willow Lane', '2023-09-14 14:34:36', 'Downtown', 73, NULL, 0),
(124, 'Aiden White', '222 Birch Street', 'L45-67-890123', 'Atlanta', 'SUV', 'OPQ5678', '76543210-2', 'Atlanta', 'Sophie White', '222 Birch Street', '2023-09-14 14:34:36', 'Shopping Center', 74, NULL, 0),
(125, 'Henry Lee', '333 Cedar Avenue', 'M78-90-123456', 'San Antonio', 'Truck', 'RST6789', '65432109-3', 'San Antonio', 'Olivia Lee', '333 Cedar Avenue', '2023-09-14 14:34:36', 'Industrial Zone', 76, NULL, 0),
(126, 'Liam Wilson', '444 Maple Road', 'N01-23-456789', 'Boston', 'Van', 'UVW9012', '54321098-4', 'Boston', 'Aria Wilson', '444 Maple Road', '2023-09-14 14:34:36', 'Suburban Street', 70, NULL, 0),
(127, 'Emma Turner', '555 Oak Avenue', 'O45-67-890123', 'Phoenix', 'Motorcycle', 'XYZ1234', '43210987-5', 'Phoenix', 'Noah Turner', '555 Oak Avenue', '2023-09-14 14:34:36', 'City Center', 73, NULL, 0),
(128, 'Olivia Smith', '666 Elm Lane', 'P78-90-123456', 'Seattle', 'Car', 'ABC7890', '21098765-6', 'Seattle', 'William Smith', '666 Elm Lane', '2023-09-14 14:34:36', 'Residential Area', 74, NULL, 0),
(129, 'Mason Davis', '777 Birch Road', 'Q01-23-456789', 'Denver', 'SUV', 'DEF4567', '09876543-7', 'Denver', 'Harper Davis', '777 Birch Road', '2023-09-14 14:34:36', 'Park', 73, NULL, 0),
(130, 'Ava Martinez', '888 Cedar Lane', 'R45-67-890123', 'Chicago', 'Car', 'GHI9012', '98765432-8', 'Chicago', 'Elijah Martinez', '888 Cedar Lane', '2023-09-14 14:34:36', 'Suburbia', 76, NULL, 0),
(131, 'Charlotte Harris', '999 Pine Street', 'S01-23-456789', 'Los Angeles', 'Motorcycle', 'JKL1234', '76543210-9', 'Los Angeles', 'Lucas Harris', '999 Pine Street', '2023-09-14 14:34:36', 'Highway', 76, NULL, 0),
(132, 'Liam Johnson', '111 Maple Avenue', 'T45-67-890123', 'New York', 'Car', 'MNO5678', '54321098-0', 'New York', 'Olivia Johnson', '111 Maple Avenue', '2023-09-14 14:34:36', 'Downtown Crossing', 70, NULL, 0),
(133, 'Driver Name', 'Driver Address', 'N03-21-234519', 'canlalay', 'Car', 'ABC 235', '11111111-2', 'Taguig', 'Jane Does', 'Driver Address', '2023-10-24 08:58:33', 'Golden City', 74, NULL, 0);

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
  ADD KEY `user_id_motorists` (`user_id_motorists`),
  ADD KEY `ticket sender` (`user_ctmeu_id`);

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
  MODIFY `user_ctmeu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `users_motorists`
--
ALTER TABLE `users_motorists`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `violations`
--
ALTER TABLE `violations`
  MODIFY `violation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `violation_tickets`
--
ALTER TABLE `violation_tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

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
  ADD CONSTRAINT `ticket violation` FOREIGN KEY (`ticket_id_violations`) REFERENCES `violation_tickets` (`ticket_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `violation_tickets`
--
ALTER TABLE `violation_tickets`
  ADD CONSTRAINT `ticket sender` FOREIGN KEY (`user_ctmeu_id`) REFERENCES `users` (`user_ctmeu_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `violation_tickets_ibfk_1` FOREIGN KEY (`user_id_motorists`) REFERENCES `users_motorists` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
