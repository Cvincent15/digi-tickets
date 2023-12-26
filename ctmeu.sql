-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2023 at 07:18 AM
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
(5, '4020', 'Single', 'Santa Rosa', 'O+', 'White', 'Blue', 'Yellow', 60, 168, 'Lungs', 'Nigel Malapitan', '4020', '+6394521312', 'Dyan lang malapits', 'dun lang sa tagapo', 6),
(7, '4652', 'single', 'dun lang', 'a+', 'macho', 'GREEN', 'blue', 65, 173, 'no i will not donate', 'baby ko ', 'si k', '09222222222', 'don sa kanto', 'brgy batumbakal si idol ko ', 13),
(8, '5465', 'widow', 'market place', 'a-', 'macho', 'green', 'blue', 60, 179, 'kjkjkbhb', 'Lorenz Artillagas', '977', '8465830', 'B4 L7 P2 Celina home', 'B4 L7 P2 Celina homes 5 Tagapo', 16);

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
  `is_activated` tinyint(1) NOT NULL,
  `apiKey` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_ctmeu_id`, `first_name`, `middle_name`, `last_name`, `affixes`, `username`, `password`, `role`, `startTicket`, `endTicket`, `email`, `is_activated`, `apiKey`) VALUES
(56, 'Vincent Andrei', '', 'Cosio', '', 'suaVCosio', '$2y$10$QBn.JZrKySQ/WX7LJkjVEedOIjJ3xchcW960phCULhl88ucNw6w/C', 'Super Administrator', NULL, NULL, 'vincent.andrei15@gmail.com', 0, ''),
(57, 'Kristine Emerald', '', 'Casindac', '', 'itsKCasindac', '$2y$10$7a79hmUn26xiO6Yduf0V5ugajSJ7V.jr28vzibUmT7jyDdTGc./KK', 'IT Administrator', NULL, NULL, '', 0, ''),
(58, 'Zsyra Beatrise', '', 'Almendral', '', 'itsZAlmendral', '$2y$10$FoLrzPZL4WUKp7x7f7YQMuRCIKiVI1OkZqNQrm.XZ30QUQhumFrBC', 'IT Administrator', NULL, NULL, '', 0, ''),
(59, 'Jazzlyn Kate', '', 'Aquino', '', 'itsJAquino', '$2y$10$fODyHUzw731MZGbkkOYPFeBxJewacAucw/YGqCDciqh3zbn7NPAUW', 'IT Administrator', NULL, NULL, '', 0, ''),
(70, 'Kyle Dennis', '', 'Dalida', '', 'enfKDalida', '$2y$10$TKURg8EEGf32mdRWwlKbm.YMOtXsa2zrK4OkwNtcIByM9kyKV1ifu', 'Enforcer', NULL, NULL, '', 0, ''),
(73, 'Jhimwell', '', 'Robles', '', 'enfJRobles', '$2y$10$bB5v0ePlisqJ5EdJtFDmaeXF.BwuQiKV8ze3uY1hf9u7640akKn.K', 'Enforcer', NULL, NULL, '', 0, ''),
(74, 'Dan Carlo', '', 'Ramirez', '', 'enfDRamirez', '$2y$10$TN/0F4PsSP6IHez/1djKXOLmDCMrk/rWl4ZBCKep9pTAXh1gmPKZO', 'Enforcer', NULL, NULL, '', 0, ''),
(76, 'Carl', '', 'Bantatua', '', 'enfCBantatua', '$2y$10$8NcAU3XI/00E7VxDfqESfe3T3SdpN7aK/ukXY9zptVaJ3mcwHaKnW', 'Enforcer', NULL, NULL, '', 0, ''),
(90, 'Lorenz Adrian', 'Nofuente', 'Artillagas', '', 'Zephyr', '$2y$10$MwCDJbFLL52gISaXsHf2O.8WrVxDVckPprCvbS6/E/IAimNqxloxG', 'Super Administrator', NULL, NULL, '', 0, ''),
(95, 'Bon Jovi', '', 'Villarama', '', 'BonJovi-IT', '$2y$10$WW5BROc7oWIiqP5HWHYG0uqh8l3TVJRSpVaoCK0U5VcDn6z/OuMmG', 'IT Administrator', NULL, NULL, '', 0, NULL),
(97, 'jj', '', 'calma', '', 'enfJcalma', '$2y$10$qZnxaEZXz/VUWxC8/9IgCepnXcdimo8H2XQVaAE5M94.wlq6Yw8ty', 'Enforcer', NULL, NULL, '', 0, NULL),
(98, 'Ash', 'K', 'Etchum', '', 'AshKetchum', '$2y$10$ytui9LIqYcENlD0W2NaFfOAL922m1K8IcAtkYQ3XmabPA9.8pgW2q', 'Enforcer', NULL, NULL, '', 0, NULL);

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
(9, 'Smith', 'Alice', 'Masda', '2001-08-06', 'Female', 'Masda', 'Melissa', 'Tasda', 'alicesmith@gmail.com', '+639123456789', '$2y$10$t6ramdBpiu5d0JWakQH2aOLUaadVvt1/9ZSWvKcHHILNelxM/xigG', 'A12-34-567890', '2024-05-15', '222222222222', 1, 0),
(11, 'Denton', 'CJ', 'Top G', '2005-12-25', 'Male', 'Aquino', 'Jazzlyn Kate', 'Manalo', 'cjdenton@gmail.com', '+639987654321', '$2y$10$FKo2l2qA0zDzrAJL..kiW.OFHHG.gb0HYiLYvPjJS2Sz6g4IPSXN6', 'TL111111', '2024-02-29', '1111111111-1', 1, 0),
(12, 'Mercer', 'Alex', 'GG', '2005-12-04', 'Male', 'Aquino', 'Jazzlyn Kate', 'Manalo', 'amercer@gmail.com', '+639954556789', '$2y$10$JD/vprKwlxojm.p.sxxF9O74LkDRL2jI6JpaC154XJXMLaM8vt/Gy', 'TL222222', '2023-12-02', '1111111111-3', 1, 0),
(13, 'ching', 'chong', 'wang', '2005-12-19', 'Male', 'chang', 'chung', 'wong', 'dancarlo342@gmail.com', '+639562541265', '$2y$10$V7iStCfsO6A11L.ijAdJ/OgXF7Pdtd/f/7E9L6Q2KyiBBeoQnqgp6', 'D04-22-305969', '2024-12-11', '31495260', 0, 0),
(14, 'robles', 'jhim', 'dasd', '2005-12-07', 'Male', 'calma ', 'jj', 'reaf', 'artillagaslorenz4@gmail.com', '+639778465830', '$2y$10$saY7tXa46rSSVNd83uIx6O8Az7Q7UbHfn21IENykJGUEBqp/iaYLW', 'N50-97-654345', '2023-12-15', '966663434', 1, 0),
(15, 'may kagat ', 'apple', 'asd', '2005-12-28', 'Male', 'mansanas', 'hilaw', 'hinog', 'carloramirez@gmail.com', '+630983258723', '$2y$10$RHg7kGc/ePNUJSKulIUz6OznbY/hOONqmcZr3hCk2wzXLPeuOVcLy', 'DS0-98-098908', '2023-12-20', '099890890', 1, 0),
(16, 'almendral', 'jazz', 'dalida', '1999-12-03', 'Female', 'dasdasd', 'asodja', 'aposjd', 'dalidakyle@gmail.com', '+630982342342', '$2y$10$7puMPM2BFykplhnKPJRTM.3C.NJ0nXthYU.6VZoPO5OPDiCtZRqPi', 'NCQ-O3-423524', '2023-12-18', '523525235', 1, 0),
(17, 'calma', 'jayjay', 'jhim', '2005-12-02', 'Male', 'drex', 'eph', 'tin', 'calmajj@gmail.com', '+639876543211', '$2y$10$.GOPFwAnih9eYRj8vSPFxef2xTmLyhFiHPO6tXmkSMJ23J7pcYFc6', 'N09-12-345678', '2023-12-15', '123456789', 1, 0),
(18, 'almendral', 'jazz', 'dalida', '2005-12-06', 'Male', 'sa school', 'cassie', 'di ka muna papasok ', 'dalidakyle2@gmail.com', '+639876543567', '$2y$10$qwTJSXu5YEITFYLApmuF/.XxhYODfX3xONv5JNjprgHNumFdqK9yi', 'N05-34-123456', '2023-12-22', '123456789', 1, 0),
(19, 'Oak', 'Gary', 'Blue', '2005-12-15', 'Male', 'Professor', 'Oak', 'Pokemon', 'gary@gmail.com', '+639914877549', '$2y$10$/F7rPhoX9rhja41di4.oj.0NnOdcNSB03Mo0HhPn/jBFQBbbgrrwO', 'NB0-86-12334', '2028-12-28', '123123123', 1, 0);

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
(6, 'Tricycle');

-- --------------------------------------------------------

--
-- Table structure for table `violationlists`
--

CREATE TABLE `violationlists` (
  `violation_list_ids` int(11) NOT NULL,
  `violation_section` varchar(255) NOT NULL,
  `responsible` varchar(255) NOT NULL,
  `violation_name` varchar(255) NOT NULL,
  `violation_fine` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `violationlists`
--

INSERT INTO `violationlists` (`violation_list_ids`, `violation_section`, `responsible`, `violation_name`, `violation_fine`) VALUES
(1, '1', 'Driver', 'Driving without license', '500'),
(2, '2', 'Driver', 'Driving with a delinquent, invalid, suspended ineffectual or revoked license', '200'),
(3, 'KP 1471-2006', 'Driver', 'SHUTTLE POINT TO POINT', NULL),
(4, 'KP 1265-2003', 'Driver', 'Coding', NULL),
(5, 'KP 1465-2006', 'Driver', 'ILLEGAL TERMINAL', NULL),
(6, 'KP 1418-2005', 'Driver', 'TRUCK BAN', NULL),
(7, 'KP 1721-2011', 'Driver', 'TOWING', NULL),
(8, '3A', 'Driver', 'Failure to show or surrender license', '100'),
(9, '3B', 'Driver', 'Failure to carry drivers license', '100'),
(10, '3C', 'Driver', 'Failure to sign drivers license', '100'),
(11, '4', 'Driver', 'Driving while in the influence of liquor or prohibited drugs', '1000'),
(12, '5', 'Driver', 'Allowing unlicensed/improperly licensed person to drive', '500'),
(13, '6', 'Driver', 'Fake or Counterfeit license', '1000'),
(14, '7', 'Driver', 'Allowing another person to use his/her drivers license', '400'),
(15, '8', 'Driver', 'Using motor vehicle in commission of crime', '1000'),
(16, '9', 'Driver', 'Student driver operating MV without being accompanied by a licensed driver', '150'),
(17, '10', 'Constructor', 'Conductor Unlicensed Conductor', '200'),
(18, '11', 'Driver', 'Driving unregistered/improperly registered/ Owner delinquent or invalid registration', '300'),
(19, '12A', 'Driver', 'Unregistered substitute or replacement engine', '300'),
(20, '12B', 'Driver', 'Unauthorized change of color or configuration', '300'),
(21, '14', 'Driver', 'Operating/allowing the operation of a motor vehicle with suspended/revoked certificate of registration', '300'),
(22, '15', 'Driver', 'Tourist operating a non-philippine registered vehicle beyond 90 days period', '1000'),
(23, '15A', 'Driver', 'Certificate ofRegistration and official receipt not carried', '100'),
(24, '16B', 'Driver', 'Dirty or uncared license plates', '100'),
(25, '16C', 'Driver', 'Unconspicously displayed license plates', '100'),
(26, '16D', 'Driver', 'No license plate sticker', '100'),
(27, '17', 'Driver', 'License plate different from body number-for hire', '150'),
(28, '18', 'Driver', 'Improperly displayed plates (removing permanent plates to accommodate commemorative plates)', '150'),
(29, '19', 'Driver', 'Expired commemorative plates/stickers', '150'),
(30, '20', 'Driver', 'Tampered/marked plate or stickers', '200'),
(31, '21', 'Driver', 'Illegal transfer of plates, tags or stickers', '750'),
(32, '22B', 'Driver', 'Defective brakes', '100'),
(33, '22C', 'Driver', 'Improper horn or signaling device-using device with exceptionally loud, startling, or disagreeable sound', '100'),
(34, '22D', 'Driver', 'Defective horn or signaling device', '100'),
(35, '22E', 'Driver', 'Carrying red light visible in front ofvehicle', '100'),
(36, '22F', 'Driver', 'No or defective headlights', '100'),
(37, '22G', 'Driver', 'No or defective taillights', '100'),
(38, '22I', 'Driver', 'No license plate light', '100'),
(39, '22J', 'Driver', 'No brake (stop lights)', '100'),
(40, '22K', 'Driver', 'No or defective windshield wipers', '100'),
(41, '22L', 'Driver', 'No or disconnected muffler', '100'),
(42, '23', 'Driver', 'Dirty and unsightly or dilapidated motor vehicle', '100'),
(43, '24', 'Driver', 'Failure to paint or improper painting of authorized route', '250'),
(44, '25', 'Driver', 'Non-painting of business or trade name on vehicle used in business trade', '100'),
(45, '26A', 'Driver', 'Unauthorized improvised plates', '100'),
(46, '26B', 'Driver', 'Plates are made to appear as registered to operate as \"For Hire\"', '1000'),
(47, '27A', 'Driver', 'Applies to \"for hire\" vehicles: Dirty and unsanitary equipment', '100'),
(48, '27B', 'Driver', 'Applies to \"For Hire\" vehicles: Defective equipment not roadworthy', '100'),
(49, '27C', 'Driver', 'Applies to \"For Hire\" vehicles: No hand brakes', '100'),
(50, '27D', 'Driver', 'Applies to.\"For Hire\" vehicles: Defective hand brakes', '100'),
(51, '27E', 'Driver', 'Applies to \"For Hire\" vehicles: No or defective Speedometer', '100'),
(52, '27F', 'Driver', 'Applies to \"For Hire\" vehicles: defective or broken windshield', '100'),
(53, '27G', 'Driver', 'Applies to \"For Hire\" vehicles: No or defective windshield wipers', '100'),
(54, '27H', 'Driver', 'Applies to \"For Hire\" vehicles: No rear view mirror', '100'),
(55, '27I', 'Driver', 'Applies to \"For Hire\" vehicles : No interior lights', '100'),
(56, '28', 'Driver', 'No name or business name and address on For Hire vehicle', '100'),
(57, '29', 'Driver', 'No spare tire', '100'),
(58, '30', 'Driver', 'Unauthorized bell, siren or exhaust whistle', '100'),
(59, '31', 'Driver', 'No red flag or red lights on projecting load', '100'),
(60, '32', 'Driver', 'No body number on \"For Hire\" vehicle', '200'),
(61, '33', 'Driver', 'No \"early\" warning device\" or failure to use EWD', '200'),
(62, '34', 'Driver', 'No capacity markings', '100'),
(63, '35', 'Driver', 'Installation ofjalousies, curtains, DIM lights, strobelights, or similar lights/tinted, colored or painted windshield or window glass on \"For Hire\" vehicles', '350'),
(64, '36', 'Driver', 'Failure to \"put \"Not for Hire\" sign onjeepney/jitney not operated for hire', '200'),
(65, '37', 'Driver', 'Load extended beyond projected width without permit', '150'),
(66, '38', 'Driver', 'Overloading', '100'),
(67, '38A', 'Driver', 'Operating a vehicle in excess of limit', '100'),
(68, '38B', 'Driver', 'Total weight of cargo carrying device or passenger truck in excess of 100 kilos', '100'),
(69, '38C', 'Driver', 'Allowing load in excess of its carrying capacity', '100'),
(70, '38D', 'Driver', 'Baggage or freight carried on top of truck exceeds 20 kilos square meters and not distributed properly', '100'),
(71, '39', 'Driver', 'Outside its authorized route', '300'),
(72, '40', 'Driver', 'Colorum operation including private passenger automobiles, private trucks, private motorcycles', '300'),
(73, '41', 'Owner', 'Colorum operation (imposed on owner/operator)', '700'),
(74, '42', 'Owner', 'Employing insolent, discourteous or arrogant driver or conductor', '200'),
(75, '43', 'Driver', 'Refusal to convey passenger to proper destination/trip cutting', '100'),
(76, '44', 'Driver', 'Refusal to render service to the public', '500'),
(77, '45', 'Driver', 'Conductor & No issuance of fare ticket on bus', '200'),
(78, '46', 'Owner', 'Unauthorized commercial or business name, allowing another to use his/her commercial or business name', '200'),
(79, '47', 'Driver', 'Undue preference or unjust discrimination', '200'),
(80, '48', 'Driver', 'Overcharging/undercharging', '300'),
(81, '49', 'Owner', 'Breach of Franchise conditions', '200'),
(82, '50', 'Driver', 'No franchise/certificate of public conveyance or evidence of franchise in the motor vehicle', '200'),
(83, '51', 'Driver', 'Fake license, identification card or permit', '500'),
(84, '52', 'Driver', 'Fake CR, OR, plates, tags or stickers or spurious documents', '500'),
(85, '53', 'Driver', 'Misrepresenting a copy of document before the traffic Adjudication service (TAS)', '100'),
(86, '54D', 'Driver', 'Arrogance or discourtesy', '100'),
(87, '54A1', 'Driver', 'Parking within an intersection', '100'),
(88, '54A2', 'Driver', 'Parking on a crosswalk', '100'),
(89, '54A3', 'Driver', 'Parking within 6 meters of intersection of curb lines', '100'),
(90, '54A4', 'Driver', 'Parking within 4 meters of driveway entrance of fire station', '100'),
(91, '54A5', 'Driver', 'Parking within 4 meters of a fire hydrant', '100'),
(92, '54A6', 'Driver', 'Parking in front of a private driveway', '100'),
(93, '54A7', 'Driver', 'Double Parking', '100'),
(94, '54A8', 'Driver', 'Parking at any place where official signs of prohibited parking are posted', '100'),
(95, '16A', 'Driver', 'License plates not firmly attached and visible', '100'),
(96, '54B', 'Driver', 'Allowing a passenger on top or on the cover of a vehicle', '100'),
(97, '54C', 'Driver', 'Permitting a passenger to ride on the running board,step board or mudguard of a vehicle', '100'),
(98, '54E', 'Driver', 'Disregarding traffic signs', '100'),
(99, '54F', 'Driver', 'No helmet when driving or riding motorcycle', '100'),
(100, '55', 'Driver', 'Reckless driving', '300'),
(101, '56', 'Driver', 'Failure to dim headlights', '100'),
(102, '57', 'Driver', 'Use of slippers or sleeveless shirts when driving a for Hire MV', '100'),
(103, '58A', 'Driver', 'Driving or parking in a place not designed for parking such as sidewalks, paths or alleys', '100'),
(104, '58B', 'Driver', 'Failure to give way to police/fire vehicles or ambulances', '100'),
(105, '58C', 'Driver', 'Hitching - permitting any person to hang on to/ride on outside ofvehicle such as person on bicycle,roller skate or skateboard', '100'),
(106, '59', 'Driver', 'Fast, tampered, defective or no taximeter, tampered Owner broken, fake or altered meter seals', '1000'),
(107, '60', 'Driver', 'Driver & Tampered, broken, joined, reconnected, fake or Owner altered sealing wire', '500'),
(108, '61', 'Driver', 'Driver Refusal to render service to the public or to convey passenger to his/her destination', '500'),
(109, '62A', 'Driver', 'Violation of color scheme. Adoption ofnew color or design without authority', '200'),
(110, '62B', 'Driver', 'Unregistered or unauthorized trade name or business or its unauthorized use', '200'),
(111, '62C', 'Driver', 'No body number on \"For Hire\" vehicle', '200'),
(112, '62D', 'Driver', 'Old meter, transmission seal or triplex seal', '200'),
(113, '62E', 'Driver', 'Loose triplex seal', '200'),
(114, '62F', 'Driver', 'Flagged up taxi meter Operating on contractual basis', '200'),
(115, '63', 'Driver', 'No taxi drivers uniform', '100'),
(116, '64', 'Driver', 'No taximeter', '500'),
(117, '65', 'Driver', 'Owner Installing-air conditioning unit without authority, failure to paint \"aircon\" on taxi unit', '500'),
(118, '66A', 'Driver', 'Owner Failure OT provide light on taximeter', '100'),
(119, '66B', 'Driver', 'Owner Failure to provide top light indicating availability', '100'),
(120, '66C', 'Driver', 'Owner Failure to provide clean seat covers', '100'),
(121, '67', 'Driver', 'Owner Failure to paint his/her name and address on his/ her unit', '100'),
(122, '68A', 'Driver', 'Illegal turn', '100'),
(123, '68B', 'Driver', 'Driving against flow of traffic', '100'),
(124, '68C', 'Driver', 'Illegal overtaking', '100'),
(125, '68D', 'Driver', 'Overtaking at an unsafe distance', '100'),
(126, '68E', 'Driver', 'Cutting an overtaken vehicle', '100'),
(127, '68F', 'Driver', 'Failure to give way to an overtaking vehicle', '100'),
(128, '68G', 'Driver', 'Increasing speed when being overtaken', '100'),
(129, '68H', 'Driver', 'Overtaking when left side is not visible/clear of incoming traffic', '100'),
(130, '681', 'Driver', 'Overtaking on a crest of a grade', '100'),
(131, '68J', 'Driver', 'Overtaking on a curve', '100'),
(132, '68K', 'Driver', 'Overtaking at railway grade crossing', '100'),
(133, '68L', 'Driver', 'Overtaking on an intersection', '100'),
(134, '68M', 'Driver', 'Overtaking between \"men working\" or \"caution signs', '100'),
(135, '68N', 'Driver', 'Overtaking in a no overtaking zone', '100'),
(136, '680', 'Driver', 'Failure to yield to right ofway (same time rule)', '100'),
(137, '68P', 'Driver', 'Failure to yield to right of way (first at intersection rule)', '100'),
(138, '68Q', 'Driver', 'Failure to yield to right of way (to pedestrian at crosswalk)', '100'),
(139, '68R', 'Driver', 'Failure to complete stop on a thorough street or railroad crossing', '100'),
(140, '68S', 'Driver', 'Failure to yield to right of way vehicle coming from a private road or drive way', '100'),
(141, '68T', 'Driver', 'Failure to yield to right of way of ambulance, police car, or stop intersection', '100'),
(142, '68U', 'Driver', 'Failure to come to complete stop a through highway or stop intersection', '100'),
(143, '68V', 'Driver', 'Failure to give proper turn/stop signals', '100'),
(144, '68W', 'Driver', 'Illegal right turn', '100'),
(145, '68X', 'Driver', 'Illegal left turn', '100'),
(146, '68Y', 'Driver', 'Failure to stop MV and apply handbrake when left unattended', '100'),
(147, '68Z', 'Driver', 'Obstruction of traffic', '100'),
(148, '10A', 'Driver', 'Failure to wear prescribed seat belt devices and/or  failure to require passengers to wear prescribed seat Belt device or to take another seat for which seat Belt is not required', '150'),
(149, '10B', 'Driver', 'Failure to post signage \"fasten seat belts\" on public Owner motor vehicle required to wear seat belts', '150'),
(150, '72', 'Driver', 'Illegal use of commemorative plates without prior authority', '2500'),
(151, '73', 'Driver', 'Without conduction stickers', '300'),
(152, '74', 'Driver', 'Smoke belching', '500'),
(153, '75', 'Driver', 'Use or attach to vehicle any siren, bell, horn, whistle or other similar gadget that produce exceptionally load or startling sound, including domelights, blinkers and similar signaling or flashing device', '300'),
(154, '76', 'Owner', 'Glaring front or rear body parts and/or sporting dazzling accessories', '300'),
(155, '77', 'Driver', 'Operation of vehicles with right-hand steering wheels', '2500'),
(156, 'T14', 'Driver', 'No sticker showing the correct year', '100'),
(157, 'T26', 'Driver', 'Disregarding traffic officer', '300');

-- --------------------------------------------------------

--
-- Table structure for table `violations`
--

CREATE TABLE `violations` (
  `violation_id` int(11) NOT NULL,
  `violationlist_id` int(11) NOT NULL,
  `ticket_id_violations` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `violations`
--

INSERT INTO `violations` (`violation_id`, `violationlist_id`, `ticket_id_violations`) VALUES
(1, 1, 47),
(2, 2, 47),
(3, 3, 47),
(4, 5, 47),
(5, 4, 47),
(6, 1, 53),
(7, 2, 53),
(8, 2, 54),
(9, 4, 54),
(10, 5, 54),
(11, 1, 57),
(12, 2, 57),
(13, 6, 57),
(14, 5, 57),
(15, 8, 57),
(16, 9, 57),
(17, 11, 57),
(18, 3, 79),
(19, 1, 81),
(20, 2, 81);

-- --------------------------------------------------------

--
-- Table structure for table `violation_tickets`
--

CREATE TABLE `violation_tickets` (
  `ticket_id` int(11) NOT NULL,
  `driver_name` varchar(50) NOT NULL,
  `driver_license` varchar(50) NOT NULL,
  `issuing_district` varchar(20) NOT NULL,
  `driver_address` varchar(50) NOT NULL,
  `vehicle_type` int(11) NOT NULL,
  `plate_no` varchar(20) NOT NULL,
  `reg_owner` varchar(20) NOT NULL,
  `reg_owner_address` varchar(50) NOT NULL,
  `date_time_violation` datetime DEFAULT NULL,
  `date_time_violation_edit` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `place_of_occurrence` varchar(50) NOT NULL,
  `email` varchar(20) NOT NULL,
  `user_ctmeu_id` int(11) DEFAULT NULL,
  `user_id_motorists` int(11) DEFAULT NULL,
  `is_settled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `violation_tickets`
--

INSERT INTO `violation_tickets` (`ticket_id`, `driver_name`, `driver_license`, `issuing_district`, `driver_address`, `vehicle_type`, `plate_no`, `reg_owner`, `reg_owner_address`, `date_time_violation`, `date_time_violation_edit`, `place_of_occurrence`, `email`, `user_ctmeu_id`, `user_id_motorists`, `is_settled`) VALUES
(2, 'CJ Denta', 'TL111111', '', '', 1, 'RST111', '', '', '2023-10-01 09:00:00', '2023-12-16 04:40:53', 'SM', '', 70, NULL, 1),
(6, 'Alex Mercer', 'TL222222', '', '', 3, 'XYZ222', '', '', '2023-10-27 02:30:00', '2023-12-15 07:26:25', 'Downtown', '', 70, NULL, 1),
(7, 'Elena Fisher', 'TL333333', '', '', 2, 'ABC333', '', '', '2023-10-27 03:45:00', '2023-12-15 07:27:32', 'Main Street', '', 70, NULL, 1),
(8, 'Nathan Drake', 'TL444444', '', '', 4, 'JKL444', '', '', '2023-10-27 05:15:00', '2023-12-15 07:22:10', 'Market Square', '', 73, NULL, 1),
(9, 'Aloy Horizon', 'TL555555', '', '', 5, 'MNO555', '', '', '2023-10-27 06:30:00', '2023-12-15 07:27:32', 'Park Avenue', '', 76, NULL, 1),
(10, 'Geralt of Rivia', 'TL6666668', '', '', 6, 'PQR6668', '', '', '2023-10-18 10:00:00', '2023-12-16 04:41:08', 'Crossroads', '', 74, NULL, 1),
(12, 'Ezio Auditore', 'TL888888', '', '', 2, 'VWX888', '', '', '2023-10-19 10:15:00', '2023-12-16 04:42:14', 'Waterfront Drive', '', 70, NULL, 0),
(13, 'Aloy Horizon', 'TL999999', '', '', 1, 'YZA999', '', '', '2023-10-27 11:30:00', '2023-12-16 04:42:24', 'Oak Street', '', 70, NULL, 0),
(14, 'John Wick', 'TL777777', '', '', 1, 'JKL777', '', '', '2023-10-23 04:00:00', '2023-12-16 04:42:41', 'Alley Street', '', 70, NULL, 0),
(15, 'Ellie Williams', 'TL888888', '', '', 2, 'XYZ888', '', '', '2023-10-20 05:30:00', '2023-12-16 04:43:24', 'Broadway Avenue', '', 74, NULL, 0),
(16, 'Joel Miller', 'TL999999', '', '', 1, 'ABC999', '', '', '2023-10-13 06:45:00', '2023-12-16 04:43:31', 'City Park', '', 74, NULL, 0),
(17, 'Ezio Auditore', 'TL123456', '', '', 2, 'DEF123', '', '', '2023-09-27 20:15:00', '2023-12-15 07:14:47', 'Sunset Boulevard', '', 74, NULL, 0),
(18, 'Chloe Frazer', 'TL654321', '', '', 1, 'GHI654', '', '', '2023-09-27 09:30:00', '2023-12-15 07:14:49', 'Maple Lane', '', 74, NULL, 0),
(19, 'Nathan Drake', 'TL987654', '', '', 2, 'JKL987', '', '', '2023-09-27 10:45:00', '2023-12-15 07:14:50', 'Highland Road', '', 74, NULL, 0),
(20, 'Aloy Horizon', 'TL321654', '', '', 1, 'MNO321', '', '', '2023-09-27 11:59:00', '2023-12-16 00:18:30', 'Hillside Drive', '', 70, NULL, 1),
(23, 'sarah johnson', 'B45-67-890123', '', '', 1, 'ABC123', '', '', '2023-10-06 01:00:00', '2023-12-16 04:45:46', 'SM', '', 74, 6, 0),
(33, 'ABC 123', 'ABC123', '', '', 3, 'XYZ789', '', '', '2023-12-10 05:00:00', '2023-12-15 07:14:57', 'Tagapo', '', 70, NULL, 0),
(36, 'Sarah Connor', 'DL56789CA', '', '', 2, 'Oakwood', '', '', '2023-12-10 22:00:00', '2023-12-15 07:14:59', 'FGH456', '', 70, NULL, 0),
(38, 'Driver1', 'License2', '', '', 3, 'Plate3', '', '', '2023-12-10 22:07:00', '2023-12-15 07:15:01', 'Place4', '', 70, NULL, 0),
(39, 'Beyonce', 'NoCar12', '', '', 6, 'XYZ542', '', '', '2023-12-10 22:34:00', '2023-12-15 07:15:03', 'Empire State Building', '', 70, NULL, 0),
(40, 'Robbie', 'jkl432', '', '', 2, 'tyufg3', '', '', '2023-12-10 22:35:00', '2023-12-15 07:15:07', 'PUP', '', 76, NULL, 0),
(41, 'Ed Sheeran', 'LegoHouse', '', '', 1, 'Photograph', '', '', '2023-12-10 22:38:00', '2023-12-10 14:39:30', 'Happier', '', 76, NULL, 0),
(46, 'Drive', 'Lice', '', '', 1, 'Plate', '', '', '2023-12-12 20:04:00', '2023-12-15 07:15:09', 'Place', 'Email', 70, NULL, 0),
(47, 'done charlo ', 'n50-231234134-12412414 124', '', '', 2, 'mc 123v', '', '', '2023-12-15 12:00:00', '2023-12-15 07:14:24', 'dun sa kanto', 'dandandan.com', 70, NULL, 0),
(48, '', '', '', '', 1, '', '', '', '2023-12-15 16:14:00', '2023-12-15 08:14:18', '', '', 90, NULL, 0),
(49, '', '', '', '', 1, '', '', '', '2023-12-15 16:15:00', '2023-12-15 08:15:22', '', '', 90, NULL, 0),
(50, '', '', '', '', 1, '', '', '', '2023-12-15 17:29:00', '2023-12-15 09:29:35', '', '', 90, NULL, 0),
(51, 'Dan', '123456', '', '', 6, '123456778', '', '', '2023-12-15 17:29:00', '2023-12-15 09:31:01', 'santa rosa', 'test@gmail.com', 90, NULL, 0),
(52, 'Yowyow revillame', 'no50-9284uhjuyyy', '', '', 3, 'tr 183837', '', '', '2023-12-15 18:21:00', '2023-12-15 10:26:36', 'sa padis', 'artillagaslorenz7@gm', 70, NULL, 0),
(53, 'Jazz dalida almendral', 'N05-34-123456', '', '', 1, 'CHAR234', '', '', '2023-12-15 12:00:00', '2023-12-15 12:27:36', 'KANTO', 'dalidakylegmail.com', 70, 18, 0),
(54, 'qweqwe', 'weqwe', '', '', 3, 'asdad', '', '', '2023-12-15 02:00:00', '2023-12-15 12:07:30', 'asdadq', 'asdadsadasdsad', 76, NULL, 0),
(55, 'asdasdasda', 'qweqweqweqwe', '', '', 1, 'asdasdqwe', '', '', '2023-12-15 20:09:00', '2023-12-15 12:10:35', 'eqweqsa', 'zxcsdqweqwe', 76, NULL, 0),
(56, 'CP ni cosio', 'lhcoyxo', '', '', 1, 'khcoyxoyd', '', '', '2023-12-15 20:13:00', '2023-12-15 12:13:32', 'ljljv', 'igxkhcoh', 76, NULL, 0),
(57, 'jhimwill dela cruz ', 'N05-34-123456', '', '', 5, 'nvaoinr', '', '', '2023-12-15 12:00:00', '2023-12-15 12:30:22', 'arko', 'dalidatickitgmail.co', 70, 18, 0),
(58, 'Jaslin Aquino', '', '', '', 4, '', '', '', '2023-12-15 20:37:00', '2023-12-15 12:39:08', 'ZSP127', 'jasscheesecurls@gmai', 70, NULL, 0),
(59, 'Jaslin Aquino', '', '', '', 4, '', '', '', '2023-12-15 20:37:00', '2023-12-15 12:39:09', 'ZSP127', 'jasscheesecurls@gmai', 70, NULL, 0),
(60, 'Jaslin Aquino', '', '', '', 4, '', '', '', '2023-12-15 20:37:00', '2023-12-15 12:39:10', 'ZSP127', 'jasscheesecurls@gmai', 70, NULL, 0),
(61, 'Jaslin Aquino', '', '', '', 4, '', '', '', '2023-12-15 20:37:00', '2023-12-15 12:39:11', 'ZSP127', 'jasscheesecurls@gmai', 70, NULL, 0),
(62, 'Jaslin Aquino', '', '', '', 4, '', '', '', '2023-12-15 20:37:00', '2023-12-15 12:39:12', 'ZSP127', 'jasscheesecurls@gmai', 70, NULL, 0),
(63, 'Jaslin Aquino', '', '', '', 4, '', '', '', '2023-12-15 20:37:00', '2023-12-15 12:39:13', 'ZSP127', 'jasscheesecurls@gmai', 70, NULL, 0),
(64, 'Jaslin Aquino', 'ayoko', '', '', 4, 'ayoko nga', '', '', '2023-12-15 20:37:00', '2023-12-15 12:40:09', 'Enchanted Kingdom', 'jasscheesecurls@gmai', 70, NULL, 0),
(65, 'Jaslin Aquino', 'ayoko', '', '', 4, 'ayoko nga', '', '', '2023-12-15 20:37:00', '2023-12-15 12:40:10', 'Enchanted Kingdom', 'jasscheesecurls@gmai', 70, NULL, 0),
(66, 'Jaslin Aquino', 'ayoko', '', '', 4, 'ayoko nga', '', '', '2023-12-15 20:37:00', '2023-12-15 12:40:11', 'Enchanted Kingdom', 'jasscheesecurls@gmai', 70, NULL, 0),
(67, 'Jaslin Aquino', 'ayoko', '', '', 4, 'ayoko nga', '', '', '2023-12-15 20:37:00', '2023-12-15 12:40:12', 'Enchanted Kingdom', 'jasscheesecurls@gmai', 70, NULL, 0),
(68, 'Jaslin Aquino', 'ayoko', '', '', 4, 'ayoko nga', '', '', '2023-12-15 20:37:00', '2023-12-15 12:40:13', 'Enchanted Kingdom', 'jasscheesecurls@gmai', 70, NULL, 0),
(69, 'Apo Whang Od', 'N03-12-123457', '', '', 5, 'ZSP127', '', '', '2023-12-15 20:45:00', '2023-12-15 12:47:47', 'Barangay Malitlit', 'enfkdaliduh1234@gmai', 70, NULL, 0),
(70, 'Apo Whang Od', 'N03-12-123457', '', '', 5, 'ZSP127', '', '', '2023-12-15 20:45:00', '2023-12-15 12:47:48', 'Barangay Malitlit', 'enfkdaliduh1234@gmai', 70, NULL, 0),
(71, 'asdqwe', 'qwe123', '', '', 1, 'qwe123', '', '', '2023-12-15 22:59:00', '2023-12-15 15:00:21', 'asda', '123sad', 76, NULL, 0),
(72, 'Driver80', '12354567', '', '', 5, 'hcrexed', '', '', '2023-12-15 23:43:00', '2023-12-15 15:44:08', 'njio564', '2154jhv', 76, NULL, 0),
(73, 'Olaf Frozen', 'N04-12-789091', '', '', 2, 'NCT127', '', '', '2023-12-16 01:54:00', '2023-12-15 17:56:17', 'Barangay Malusak', 'elsaandanna@gmail.co', 70, NULL, 0),
(74, 'Olaf Frozen', 'N04-12-789091', '', '', 2, 'NCT127', '', '', '2023-12-16 01:54:00', '2023-12-15 17:56:23', 'Barangay Malusak', 'elsaandanna@gmail.co', 70, NULL, 0),
(75, 'Driver', '123', '', '', 3, '123abc', '', '', '2023-12-16 07:21:00', '2023-12-15 23:23:21', 'sm', 'test@testing.com', 90, NULL, 1),
(76, 'Gary Oak', 'NB-086-12334', '', '', 3, 'ABC123', '', '', '2023-12-16 08:11:00', '2023-12-16 00:13:04', 'PUP', 'gary@gmail.com', 98, NULL, 0),
(77, '', '', '', '', 1, '', '', '', '2023-12-16 18:03:00', '2023-12-16 10:03:37', '', '', 70, NULL, 0),
(78, '123', 'i2', '', '', 1, 'q1230', '', '', '2023-12-16 18:03:00', '2023-12-16 10:04:06', '2krbwnw', 'jwhr.c', 70, NULL, 0),
(79, 'Mark Lee', 'L123453', '', '', 3, 'ZSP122', '', '', '2023-12-20 12:00:00', '2023-12-18 18:32:37', 'Malusak', 'lingmaildotcom', 70, NULL, 0),
(80, 'Mark Lee', 'L123NCT127', '', '', 3, 'EXO143', '', '', '2023-12-19 02:33:00', '2023-12-18 18:34:19', 'Kanluran', 'marklee@gmail.com', 70, NULL, 0),
(81, 'Eme Mikasa', 'DL321785', 'Canlalay', '21 Jump Street', 3, 'RST679', 'Charlutte Ann', '21 Jump Street', '2023-12-22 04:00:00', '2023-12-21 15:01:42', 'Budget lane', 'asdgmail.com', 57, NULL, 0);

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
-- Indexes for table `violationlists`
--
ALTER TABLE `violationlists`
  ADD PRIMARY KEY (`violation_list_ids`);

--
-- Indexes for table `violations`
--
ALTER TABLE `violations`
  ADD PRIMARY KEY (`violation_id`),
  ADD KEY `ticket violation` (`ticket_id_violations`),
  ADD KEY `violationlist_id` (`violationlist_id`);

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
  MODIFY `motorist_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_ctmeu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `users_motorists`
--
ALTER TABLE `users_motorists`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `vehicletype`
--
ALTER TABLE `vehicletype`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `violationlists`
--
ALTER TABLE `violationlists`
  MODIFY `violation_list_ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT for table `violations`
--
ALTER TABLE `violations`
  MODIFY `violation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `violation_tickets`
--
ALTER TABLE `violation_tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

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
  ADD CONSTRAINT `violations_ibfk_1` FOREIGN KEY (`violationlist_id`) REFERENCES `violationlists` (`violation_list_ids`) ON DELETE CASCADE ON UPDATE CASCADE;

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
