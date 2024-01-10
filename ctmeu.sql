-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2024 at 04:33 PM
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
-- Table structure for table `employee_masterlist`
--

CREATE TABLE `employee_masterlist` (
  `masterlist_id` int(11) NOT NULL,
  `Employee_ID` varchar(255) DEFAULT NULL,
  `First_name` varchar(255) DEFAULT NULL,
  `Last_name` varchar(255) DEFAULT NULL,
  `Middle_name` varchar(255) DEFAULT NULL,
  `Civil_status` varchar(255) DEFAULT NULL,
  `Gender` varchar(255) DEFAULT NULL,
  `Birth_date` varchar(255) DEFAULT NULL,
  `Employee_Address` varchar(255) DEFAULT NULL,
  `Employee_Education` varchar(255) DEFAULT NULL,
  `Employee_Position` varchar(255) DEFAULT NULL,
  `Employee_Status` varchar(255) DEFAULT NULL,
  `Date_hired` varchar(255) DEFAULT NULL,
  `Employee_refferal` varchar(255) DEFAULT NULL,
  `Employee_remark` varchar(255) DEFAULT NULL,
  `Tin_number` varchar(255) DEFAULT NULL,
  `SSS_number` varchar(255) DEFAULT NULL,
  `Pagibig_number` varchar(255) DEFAULT NULL,
  `Philhealth_number` varchar(255) DEFAULT NULL,
  `GSIS_number` varchar(255) DEFAULT NULL,
  `EmpContact` varchar(255) DEFAULT NULL,
  `EmpEmail` varchar(255) DEFAULT NULL,
  `Relname` varchar(255) DEFAULT NULL,
  `RelContact` varchar(255) DEFAULT NULL,
  `RelEmail` varchar(255) DEFAULT NULL,
  `Encoder` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_masterlist`
--

INSERT INTO `employee_masterlist` (`masterlist_id`, `Employee_ID`, `First_name`, `Last_name`, `Middle_name`, `Civil_status`, `Gender`, `Birth_date`, `Employee_Address`, `Employee_Education`, `Employee_Position`, `Employee_Status`, `Date_hired`, `Employee_refferal`, `Employee_remark`, `Tin_number`, `SSS_number`, `Pagibig_number`, `Philhealth_number`, `GSIS_number`, `EmpContact`, `EmpEmail`, `Relname`, `RelContact`, `RelEmail`, `Encoder`) VALUES
(1, '1', 'ARIEL', 'DELA TRINIDAD', 'ESTAJO', 'SINGLE', 'MALE', '12/03/1990', 'PUROK 4 BRGY. CAINGIN CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '09/01/2016', '-', '-', '-', '-', '-', '-', '-', '0930-898-2125', '-', '-', '-', '-', NULL),
(2, '40695', 'JOBERT', 'DELOS REYES', 'BASARAN', 'SINGLE', 'MALE', '8/31/1993', 'BLK-1 LOT-8 PROGRESSIVE VILLAGE PUROK 5 BRGY. TAGAPO CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0942-974-5972', '-', '-', '-', '-', NULL),
(3, '3', 'NESTORIO', 'DESEPIDA', 'REYES', 'MARRIED', 'MALE', '9/10/1970', 'PUROK 6 IBABA BRGY. SINALHAN CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0950-434-2857', '-', '-', '-', '-', NULL),
(4, '40696', 'JEFFREY', 'DIAZ', 'SALVADOR', 'MARRIED', 'MALE', '5/25/1982', 'ILAYA BRGY. SINALHAN CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0907-234-2157', '-', '-', '-', '-', NULL),
(5, '5', 'JERAL', 'DONESA', 'GAVILAGUIN', 'SINGLE', 'MALE', '11/4/1983', 'BLK-13 LOT-13 DE LIMA SUBDIVISION BRGY. IBABA CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0909-703-9551', '-', '-', '-', '-', NULL),
(6, '6', 'JUANITO', 'EMBODO', 'TURLA', 'MARRIED', 'MALE', '3/14/1983', 'CATAQUIZ SUBDIVISION BRGY. TAGAPO CSRL.', 'ELEMENTARY GRADUATE', 'TRAFFIC AIDE', 'CASUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0930-889-1152', '-', '-', '-', '-', NULL),
(7, '40698', 'ERICKSON', 'EMBUDO', 'BEATO', 'MARRIED', 'MALE', '10/3/1978', '396 PUROK 6 BRGY. APLAYA CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0997-532-4933', '-', '-', '-', '-', NULL),
(8, '8', 'CARLO JOSE', 'ESTANISLAO', 'TATING', 'MARRIED', 'MALE', '1/31/1985', 'PUROK 6 BRGY. APLAYA CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0948-083-8249', '-', '-', '-', '-', NULL),
(9, '9', 'REYNALDO', 'ESTEBAN', 'MAGBANUA', 'MARRIED', 'MALE', '12/31/1967', 'BLK-7 LOT- 6 CABALYERO ST. ALFONSO HOMES II BRGY. SINALHAN CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0910-907-1097', '-', '-', '-', '-', NULL),
(10, '40701', 'ROBERT', 'FACTORIZA', 'ROSARIO', 'SINGLE', 'MALE', '10/05/1995', 'PUROK 4 BRGY. CAINGIN CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '09/01/2016', '-', '-', '-', '-', '-', '-', '-', '0907-376-7673', '-', '-', '-', '-', NULL),
(11, '40742', 'WILPER', 'FALCIS', 'VICTORINO', 'SINGLE', 'MALE', '7/22/1988', 'PUROK 1 BRGY. APLAYA CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '--', '-', '0919-354-5246', '-', '-', '-', '-', NULL),
(12, '12', 'JOHN DERYL', 'GAGARIN', 'ANDAYA', 'SINGLE', 'MALE', '10/21/1986', '690 PUROK 6 BRGY. SINALHAN CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0929-591-9003', '-', '-', '-', '-', NULL),
(13, '40704', 'MICHAEL', 'GALICIA', 'CANDELARIA', 'MARRIED', 'MALE', '20/01/1984', 'CITY OF SANTA ROSA LAGUNA', '-', 'TRAFFIC AIDE', 'CONTRACTUAL', '09/01/2016', '-', '-', '-', '-', '-', '-', '-', '0919-462-0212', '-', '-', '-', '-', NULL),
(14, '14', 'GOMER', 'GREGORIO', 'CABRILLOS', 'MARRIED', 'MALE', '1/14/1968', 'ZAVALLA 1 BRGY. MARKET AREA CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0920-824-9219', '-', '-', '-', '-', NULL),
(15, '61', 'MARK', 'ANDES', 'ALULUD', 'SINGLE', 'MALE', '28/12/1988', 'PUORK 1 BRGY. SINALHAN CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '11/01/2017', 'HON. TUZON', '-', '-', '-', '--', '-', '-', '09464845463', '-', '-', '-', '-', NULL),
(16, '59', 'RONALDO JR.', 'SAN JOSE', 'QUIZADA', 'MARRIED', 'MALE', '8/10/1985 1:02:34 PM', 'BALIBAGO STAROSA NIA ROAD CSRL.', 'VOCATIONAL GRADUATE', 'Traffic Aide', 'CONTRACTUAL', '11/1/2017 1:02:34 PM', '-', '-', '-', '-', '--', '-', '-', '09096071418', '-', '-', '-', '-', 'Tony Dichioso'),
(17, '58', 'ANGELITO', 'CASIO', 'FAJARDO', 'SINGLE', 'MALE', '22/05/1979 1:04:51 PM', 'PUROK 4 BRGY. APLAYA CSRL.', 'HIGH SCHOOL GRADUATE', 'Traffic Aide', 'CONTRACTUAL', '11/01/2017 1:04:51 PM', 'HIN JOEL AALA', '-', '-', '-', '--', '', '-', '09231720646', '-', '-', '-', '-', 'Tom'),
(18, '56', 'ROWIN', 'LU-ANG', 'SINADOR', 'MARRIED', 'MALE', '11/12/1987 1:08:18 PM', '802 F. GOMEZ ST. BRGY. IBABA CSRL.', 'COLLEGE LEVEL ', 'TRAFFIC AIDE', 'CONTRACTUAL', '11/1/2017 1:08:18 PM', 'HON TIONGCO', '-', '-', '-', '--', '--', '-', '06053143598', '-', '-', '-', '-', NULL),
(19, '55', 'RAMFELL', 'RAYMUNDO', 'GETAPE', 'SINGLE', 'MALE', '2/28/1992 1:11:25 PM', '207 PUROK 4 BRGY. APLAYA CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '11/1/2017 1:11:25 PM', 'HON TIONGCO', '-', '-', '-', '--', '-', '-', '09354802599', '-', '-', '-', '-', NULL),
(20, '54', 'ARNELIO', 'DELA CRUZ JR.', 'PAGAS', 'SINGLE', 'MALE', '8/30/1989 1:12:46 PM', 'BLK-1 LOT-73 CIUDAD GRANDE BRGY. MARKET AREA CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '11/1/2017 1:12:46 PM', 'HON. CASTRO', '-', '-', '-', '--', '-', '-', '09493567137', '-', '-', '-', '-', NULL),
(21, '53', 'JOREN', 'MANATAD', '-', 'SINGLE', 'MALE', '11/30/1994 1:14:16 PM', 'TATLONGHARI ST.,ADATO COMPOUND CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '11/1/2017 1:14:16 PM', 'HON. CASTRO', '-', '-', '-', '--', '-', '-', '09122548742', '-', '-', '-', '-', NULL),
(22, '20', 'RAMIL', 'RICO', 'SAYAO', 'MARRIED', 'MALE', '9/17/1983', '1118 CAPT. PERLAS ST. BRGY. POOC CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '10/30/2017', 'HON. CARTAGENA', '-', '-', '-', '-', '-', '-', '09102695416', '-', '---', '-', '-', NULL),
(23, '14821', 'JESUS', 'IBASCO', 'INGUA', 'MARRIED', 'MALE', '24/12/1959', 'Blk 4 Lot 3 Engracia Street Zavalla Village 2 Brgy. Marke Area, City of Santa Rosa, Laguna', 'COLLEGE GRADUATE', 'Administrative Aide', 'CASUAL', '09/01/2016', 'SPO4 Gene M. Eugenio', '-', '127140240000', '-', '-', '-', '-', '09152068142', 'jesusinguaibasco.pnp@gmail.com', 'MERCEDES V. IBASCO', '09052234950', '-', 'Tom'),
(24, '14654', 'JIMMY', 'BALANTAC', 'SORIANO', 'MARRIED', 'MALE', '10/11/1970 7:41:42 PM', 'BLK 6 LOT 6 MERCEDEZ IV, BRGY MARKET AREA CITY OF STA ROSA LAGUNA', 'HIGH SCHOOL GRADUATE', 'Technician', 'PERMANENT', '7/15/2013 7:41:42 PM', 'SPO4 GENE EUGENIO', '-', '473-819-778', '-', '-', '-', '-', '09772658209', '-', 'STA VERONICA BALANTAC', '09095263809', '-', 'Tom'),
(25, '14913', 'JONAS', 'NATANAUAN', 'SUMADSAD', 'MARRIED', 'MALE', '29/03/1974 8:18:39 PM', 'PULONG STA CRUZ CITY OF STA ROSA LAGUNA', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '01/09/2016 8:18:39 PM', 'KONSEHAL JUN TUZON', '-', '-', '33-345444-0', '-', '-', '-', '09234628901', 'bagsik_jojo@gmail.com', 'JANE SOLOMON NATANANUAN', '09482270503', '-', NULL),
(26, '40690', 'ABNER', 'DE CASTRO', 'LIRIO', 'MARRIED', 'MALE', '12/04/1972 8:32:06 AM', '1613 DILA STA. ROSA LAGUNA', 'VOCATIONAL GRADUATE - BUILDING WIRING NCII', 'TRAFFIC AIDE', 'CONTRACTUAL', '01/09/2016 8:32:06 AM', 'RANDY CATINDIG', '-', '-', '-', '-', '-', '-', '09077798517', '-', 'NICKY DE CASTRO', '09077798517', '-', NULL),
(27, '14503', 'WILLAM', 'ADATO', 'DUE', 'MARRIED', 'MALE', '12/12/1961 3:31:15 PM', 'P2 BRGY.CAINGIN CITY OF STA ROSA,LAGUNA', 'STA ROSA HIGH SCHOOL', 'Traffic Aide', 'PERMANENT', '7/23/2002 3:31:15 PM', '-', '-', '105-117-803-000', '035-702998-3', '0022-441314-07', '08-000067880-9', 'B612WDA012', '-', '-', 'ADATO MARILOU A.', '-', '-', 'malaya'),
(28, '40737', 'JEI', 'SALES', 'ACEJO', 'SINGLE', 'MALE', '27/09/1989', 'TAGAPO SANTA ROSA', 'VOCATIONAL', 'Traffic Aide', 'CONTRACTUAL', '27/09/2017', '-', '-', '1234567890', '0987654321', '1234567890', '-', '1234567890', '09983015379', 'demonmonaco@yahoo.com', 'MARY ANN ROCAS MARBELLA', '09212475657', 'angelmonaco@yahoo.com', 'Tom'),
(29, '40648', 'JHOANNE', 'MAGSINO', 'BAROLO', 'SINGLE', 'FEMALE', '23/06/1992', 'Blk-13 Lot-2 Phase 2 Westdrive Village Brgy. Labas, CSRL.', '2 YEARS COLLEGE GRADUATE', 'Administrative Aide', 'CASUAL', '01/09/2016', 'Cong. Arlene B. Arcillas', '-', '403-745-447', '04-2323240-0', '121032409865', '-', '-', '0912-888-8614', 'rosas_laurence@yahoo.com', 'EMELITA B. MAGSINO', '0948-806-8797', '-', 'Tom'),
(30, '40652', 'Manuel', 'Abanes', 'Beato', 'Single', 'MALE', '3/16/1966', '396 Purok 6 Brgy. Aplaya Csrl.', 'Vocational Graduate', 'Traffic Aide', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0935-904-2950', '-', '-', '-', '-', NULL),
(31, '18', 'Ethelbert', 'Alagad', 'Enojo', 'SINGLE', 'MALE', '2/24/1992', 'Blk-17- lot-36 St. Joseph Richfield Brgy. Tagapo CSRL.', 'HighSchool Graduate', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0995-658-2042', '-', '-', '-', '-', NULL),
(32, '19', 'Alberto Jr.', 'Aldon', 'Terson', 'SINGLE', 'MALE', '7/21/1985', 'Blk-15 Lot-12 Phase 1 Celina Plains Brgy. Labas CSRL.', 'Vocational Grad', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0932-383-3674', '-', '-', '-', '-', NULL),
(33, '20', 'Andy', 'Alix', 'Mendez', 'SINGLE', 'MALE', '8/1/1995', 'Pabahay Brgy. Pooc CSRL.', 'High School Graduate', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0910-443-2522/0918-352-7411/0908-168-3955', '-', '-', '-', '-', NULL),
(34, '40657', 'Roy', 'Almodovar', 'Genotiva', 'MARRIED', 'MALE', '9/23/1989', 'Zeramyr 1 Subdivision Brgy. Market Area CSRL', 'High School Graduate', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0946-812-3714', '-', '-', '-', '-', NULL),
(35, '22', 'Jayson', 'Alupay', 'Aquino', 'SINGLE', 'MALE', '9/23/1973', 'Santa Rosa City Laguna', 'High School Graduate', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', NULL),
(36, '40660', 'Edmon', 'Amador', 'Tapangco', 'SINGLE', 'MALE', '2/25/1992', '1269 P. Arambulo Street Brgy. Kanluran CSRL.', 'High School Graduate', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0910-580-7672', '-', '-', '-', '-', NULL),
(37, '40661', 'Raymund Ryan', 'Andaya', 'Lavina', 'MARRIED', 'MALE', '9/12/1983', '690 Purok 3 Brgy. Sinalhan CSRL.', 'High School Graduate', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0921-298-5700', '-', '-', '-', '-', NULL),
(38, '40662', 'Rizaldy', 'Anore', 'Bato', 'SINGLE', 'MALE', '12/30/1969', 'Barangay Sinalhan CSRL.', 'High School Graduate', 'Traffic Aide', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0912-767-1726', '-', '-', '-', '-', 'Tony Dichioso'),
(39, '40663', 'GODOFREDO JR. ', 'ARIOLA', 'BUENO', 'MARRIED', 'MALE', '12/31/1981', '241 PUROK 4 BRGY. APLAYA CSRL.', 'VOCATIONAL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0919-880-8633', '-', '-', '-', '-', NULL),
(40, '27', 'RYAN ', 'BALDERAMA', 'DOB', 'MARRIED', 'MALE', '5/30/1984', 'BLK-1 LOT-6 ST. ROSE VILLAGE BRGY. MARKET AREA CSRL.', 'VOCATIONAL GRADAUTE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0929-776-6944', '-', '-', '-', '-', NULL),
(41, '28', 'CARLOS JR.', 'BALINGIT', 'APANTO', 'MARRIED', 'MALE', '12/31/1979', 'BLK-6 LOT-10 PHASE 2 SOUTHVILLE 4 BRGY. CAINGIN CSRL.', 'VOCATIONAL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0912-744-3134', '-', '-', '-', '-', NULL),
(42, '29', 'RUSSEL', 'BARROSO', 'CARPENA', 'SINGLE', 'MALE', '3/28/1981', '192 BRGY. TAGAPO CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0906-272-2366', '-', '-', '-', '-', NULL),
(43, '40668', 'JOHN HENRY', 'BARTOLOME', 'DELA CRUZ', 'SINGLE', 'MALE', '5/3/1996', '548 F. GOMEZ STREET BRGY. MALUSAK CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0927-488-5198', '-', '-', '-', '-', NULL),
(44, '40669', 'VERNADETTE', 'BASBAS', 'RECONA', 'MARRIED', 'FEMALE', '12/4/1984', 'BRGY. SINALHAN CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', 'CAP. DE LEON', '-', '-', '-', '-', '-', '-', '0907-016-2335', '-', '-', '-', '-', NULL),
(45, '40670', 'MARLON', 'BASBAS', 'ALMIRA', 'SINGLE', 'MALE', '9/10/1988', 'PUROK R BRGY. APLAY CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0912-768-7633', '-', '-', '-', '-', NULL),
(46, '40673', 'JOSE', 'BASBAS JR', 'BARRINUEVO', 'SINGLE', 'MALE', '5/4/1988', '269 BRGY. APLAYA CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0995-189-4741', '-', '-', '-', '-', NULL),
(47, '34', 'JAYVEE', 'BASCON', 'FORFIEDA', 'MARRIED', 'MALE', '8/2/1980', '14 CARNATION ST. ROSEVILLE SUBD. BRGY. MARKET AREA CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0907-925-1957', '-', '-', '-', '-', NULL),
(48, '35', 'ALBERTO', 'BATANG', 'ANTONIO', 'MARRIED', 'MALE', '1/24/1976', 'BLLK-1 LOT-20A ROSARIO HEIGHTS SUBD. BGY. MARKET AREA CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0935-802-2875', '-', '-', '-', '-', NULL),
(49, '40676', 'DONATO', 'BAYA', 'FULLA', 'MARRIED', 'MALE', '2/9/1968', 'PUROK 5 BRGY. SINALHAN CSRL.', 'VOCATIONAL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0949-434-7372', '-', '-', '-', '-', NULL),
(50, '40677', 'BRYDAN', 'BAYLON', 'ALMIRA', 'SINGLE', 'MALE', '9/24/1979', 'AMBROCIA VILLAGE. BRGY. IBABA CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0906-046-8684', '-', '-', '-', '-', NULL),
(51, '40678', 'JOSEPH ', 'BEATO', 'ALMIRA', 'MARRIED', 'MALE', '12/20/1977', '387 BRGY. APLAYA CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/27/2017', '-', '-', '-', '-', '-', '-', '-', '0949-897-3732', '-', '-', '-', '-', NULL),
(52, '39', 'MICHAEL ANGELO', 'BERNARDO', 'PACO', 'SINGLE', 'MALE', '2/2/1991', 'BLK-1 LOT-3 PHASE 6 SOUTHVILLE 4 BRGY. POOC CSRL.', 'VOCATIONAL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/27/2017', '-', '-', '-', '-', '-', '-', '-', '0930-391-9039', '-', '-', '-', '-', NULL),
(53, '40', 'EXEQUIEL', 'BRAGAIS', 'PACBA', 'MARRIED', 'MALE', '4/10/1978', 'PUROK 2 PANTALAN BRGY. SINALHAN CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0919-551-4686', '-', '-', '-', '-', NULL),
(54, '41', 'DYRICK', 'CARAPATAN', 'BARRIO', 'SINGLE', 'MALE', '3/10/1994', 'PUROK 5 BRGY. APLAYA CSRL.', 'COLLEGE GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0947-602-6859', '-', '-', '-', '-', NULL),
(55, '40683', 'JHOMER', 'CARAVANA', 'PACHECO', 'SINGLE', 'MALE', '12/31/1994', '396 PUROK 6 BRGY. APLAYA CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0935-719-0427', '-', '-', '-', '-', NULL),
(56, '40684', 'BIENVENIDO', 'CARPENA', 'DE LUNA', 'MARRIED', 'MALE', '3/23/1977', 'F. GOMEZ STREEET BRGY. IBABA CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0910-739-8374', '-', '-', '-', '-', NULL),
(57, '40686', 'ALVIN', 'CILOS', 'ESTANO', 'SINGLE', 'MALE', '7/24/1987', 'EASTDRIVE VILLAGE BRGY. POOC CSRL.', 'COLLEGE GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0997-531-6882', '-', '-', '-', '-', NULL),
(58, '40687', 'ERNELLOUIE', 'CLIMACO', 'FLORDELIZA', 'MARRIED', 'MALE', '8/4/1991', 'PUROK 6 BRGY. APLAYA CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0947-332-6661', '-', '-', '-', '-', NULL),
(59, '40688', 'ARNULFO', 'COSE', 'CAPARAN', 'MARRIED', 'MALE', '10/28/1975', 'BRGY. SINALHAN CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0906-769-6249', '-', '-', '-', '-', NULL),
(60, '47', 'FERNANDO JR.', 'CRUZ', 'VALENZUELA', 'MARRIED', 'MALE', '10/25/1971', 'BLK-30 LOT-2 BSRV1 BRGY. POOC CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0926-410-0719', '-', '-', '-', '-', NULL),
(61, '49', 'JACKY', 'DE RUFINO', 'LAO', 'SINGLE', 'MALE', '7/15/1988', 'ST. JOHN SUBDIVISION BRGY. IBABA CSRL.', 'VOCATIONAL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0910-247-3121', '-', '-', '-', '-', NULL),
(62, '50', 'NAPOLEON', 'DE VILLA', 'ESTILIDES', 'MARRIED', 'MALE', '11/27/1956', 'PUROK 5 BRGY. APLAYA CSRL.', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CASUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0998-223-5048', '-', '-', '-', '-', NULL),
(63, '51', 'JULIUS ', 'DECENA', 'MESA', 'MARRIED', 'MALE', '1/27/1981', 'BLK-32 LOT-32 BSRV1 BRGY. POOC CSRL.', 'VOCATIONAL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0948-735-6934', '-', '-', '-', '-', NULL),
(64, '08308', 'FRANKLIN', 'DELA CRUZ', 'VENTURA', 'WIDOW', 'MALE', '4/14/1964', 'BLK-8 LOT-25 GOLDEN CITY BRGY. DILA CSRL.', 'COLLEGE GRADUATE', 'TRAFFIC AIDE', 'CASUAL', '9/1/2016', '-', '-', '-', '-', '-', '-', '-', '0950-398-3026', '-', '-', '-', '-', NULL),
(65, '40729', 'NESTOR', 'PACLA', 'ALMARINEZ', 'MARRIED', 'MALE', '08/11/1987 12:35:50 PM', 'PUROK 6, BRGY SINALHAN, CITY OF STA ROSA LAGUNA', 'HIGH SCHOOL GRADUATE', 'TRAFFIC AIDE', 'CONTRACTUAL', '01/09/2016 12:35:50 PM', 'HARRIS ALCABASA', '-', '-', '-', '-', '-', '-', '0923-9156552', 'nestypacla@yahoo.com', 'MARIA ARREZA PACLA', '09465709469', 'nestypacla@yahoo.com', NULL),
(66, '40736', 'MERBEN', 'SAGRITALO', 'BOLIVAR', 'MARRIED', 'MALE', '27/09/1984 12:42:10 PM', '877 F GOMEZ ST, BRGY IBABA CITY OF STA ROSA LAGUNA', 'VOCATIONAL GRADUATE- CONSUMER ELECTRONICS', 'TRAFFIC AIDE', 'CONTRACTUAL', '01/09/2016 12:42:10 PM', 'ALDRIN DE ROXAS', '-', '249-279-565-000', '04-1448159-0', '-', '-', '-', '09094032407', 'merb_@yahoo.com', 'marymart manuyag', '09094040620', 'pinkdame@yahoo.com', NULL),
(67, '13011', 'TONY REY', 'DICHOSO', 'YAMBAO', 'SINGLE', 'MALE', '6/13/1984 9:34:22 AM', '1136 CAPTAIN PERLAS STREET, BRGY. POOC, CITY OF SANTA ROSA, LAGUNA', 'COLLEGE GRADUATE', 'Administrative Officer', 'PERMANENT', '7/1/2005 9:34:22 AM', '-', '-', '244-947-262', '-', '0022-481676-04', '08-000067817-5', 'LP-84061300065', '09084834997', 'bleue_seith@yahoo.com', 'TERESITA Y. DICHOSO', '09065897260', '-', 'Tony Dichioso'),
(68, '13001', 'FRANCISCO', 'ADAJAR', 'CORTES', 'MARRIED', 'MALE', '7/20/1956 12:05:38 PM', 'BLK.5 LOT 16 SAINT ROSE VILLAGE1 CITY OF STA ROSA, LAGUNA', 'HIGH SCHOOL GRADUATE', 'Traffic Aide I', 'PERMANENT', '5/22/2000 12:05:38 PM', '-', '-', '108-763-619', '03-3902954-5', '1020-0209-4992', '08-000045656-3', 'CRN-006-0050-4996-3', '0939-8607-290', '-', 'ADAJAR PRECILA B.', '-', '-', 'Claire'),
(69, '13002', 'AMADO', 'ALIMOROM', 'GETAPE', 'MARRIED', 'MALE', '9/22/1958 3:45:43 PM', 'RELOCATION 1,PULONG STA CRUZ CITY OF STA ROSA, LAGUNA', 'HIGH SCHOOL GRAD.', 'Traffic Aide I', 'PERMANENT', '1/1/2001 3:45:43 PM', '-', '-', '228-154-333', '-', '1020-0210-2173', '08-20033520-3', 'CM-000053578', '0919-280-7965', '-', 'ALIMOROM LETICIA R.', '-', '-', 'malaya'),
(70, '13003', 'DANILO', 'ALVARADO', 'MARTOS', 'MARRIED', 'MALE', '6/25/1972 4:02:26 PM', 'BLK 13 LOT 18 BRGY. CAINGIN CITY OF STA ROSA, LAGUNA', 'HIGH SCHOOL GRAD.', 'Traffic Aide I', 'PERMANENT', '7/1/1998 4:02:26 PM', '-', '-', '192-258-704', '-', '0021-4024-1506', '08-000018335-4', 'CM-0000-580738', '0930-3686-909', '-', 'ALVARADO GEMALIE T.', '-', '-', 'malaya'),
(71, '14507', 'ALMARIO', 'AMARANTE', 'SAN JOSE', 'MARRIED', 'MALE', '09/08/1977 10:23:28 AM', 'P1 BRGY. CAINGIN,CITY OF STA ROSA, LAGUNA', 'HIGH SCHOOL GRAD.', 'Traffic Aide I', 'PERMANENT', '15/10/2002', '-', '-', '908-294-425', '-', '-', '-', 'LP-77080900948', '09125475677', '-', 'AMARANTE VICTORIA S.', '-', '-', 'Tom'),
(72, '13004', 'FELIX', 'ANORE', 'MEJIA', 'MARRIED', 'MALE', '12/12/1966 10:32:21 AM', 'P4 BRGY. SINALHAN, CITY OF STA ROSA, LAGUNA', 'HIGH SCHOOL GRAD.', 'Traffic Aide I', 'PERMANENT', '5/31/2002 10:32:21 AM', '-', '-', '249-832-563', '-', '-', '08-200630293-5', 'LP-86121202507', '0929-464-3676', '-', 'ANORE ANA, B.', '-', '-', 'malaya'),
(73, '14508', 'ROGELIO', 'BARRAGA', 'FACTORIZA', 'SEPARATED', 'MALE', '12/22/1965 10:44:21 AM', 'SITIO IRAN,BRG. MACABLING,CITY OF STA ROSA, LAGUNA', 'COLLEGE UNDER GRAD.', 'Traffic Aide I', 'PERMANENT', '6/16/2008 10:44:21 AM', '-', '-', '146-276-698', '03-8780262-0', '1020-021318-58', '08-200628537-2', '65122202318', '09216750057', '-', '-', '-', '-', 'malaya'),
(74, '14509', 'GEMINI', 'BARRINUEVO', 'RAGUB', 'MARRIED', 'MALE', '7/5/1977 10:58:44 AM', '247 BRGY. APLAYA CITY OF STA ROSA,LAGUNA', 'VOCATIONAL GRAD.', 'Traffic Aide I', 'PERMANENT', '4/1/2005 10:58:44 AM', '-', '-', '241-755-523', '-', '102002131871', '08-200629177-1', '77070500879', '09484717145', '-', '-', '-', '-', 'malaya'),
(75, '300', 'ARWIN BOY', 'SAVARRE', 'ACERON', 'MARRIED', 'MALE', '6 Nov 1981 11:42:58 AM', 'SAINT JOHN SUBD BRGY IBABA CITY OF STA ROSA LAGUNA', 'H IGH SCHOOL GRADUATE', 'Traffic Aide', 'CONTRACTUAL', '28 Sep 2018 11:42:58 AM', 'KAP RELLY', 'OK', '-', '-', '-', '-', '-', '09157431547', 'airamleig@gmail.com', 'Maria Giel Savarre', '09157431547', 'airamleig@gmail.com', 'Tom'),
(76, '40807', 'MARIA GIEL', 'SAVARRE', 'FERRER', 'MARRIED', 'FEMALE', '11 Sep 1985 12:00:55 PM', 'SAINT JOHN BRGY IBABA CITY OF SANTA ROSA LAGUNA', 'HIGH SCHOOL GRADUATE', 'Utility', 'JOB ORDER', '2 Jul 2018 12:00:55 PM', 'CONGRESS WOMAN ARELENE B. ARCILLAS', 'OK', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', 'Tom'),
(77, '14611', 'RAMON', 'CHUA JR.', 'MAGDAYAO', 'MARRIED', 'MALE', '8/24/2018 1:38:44 PM', 'SOUTHVILL 4 PHASE 9 BLK 14 LOT  1 BRGY POOC  CITY OF SANTA  ROSA LAGUNA', 'HIGH SCHOOL GRADUATE', 'Traffic Aide I', 'CONTRACTUAL', '10/9/2013 1:38:44 PM', 'HON. RODRIGO MALAPITAN', 'OK', '449138987000', '0417428615', '121121726715', '080001073331', 'CRN-021-1516-0330-0', '09516118473', 'ramonchua24@yahoo.com', 'Analuz deleon CHUA', '09499321193', 'analuzchua26@yahoo.com', 'BELO'),
(78, 'OJT NEW', 'MARK LOUIE', 'LATEO', ' VIAJE', 'SINGLE', 'MALE', '01/11/1991 11:15:46 AM', 'PULONG STA CRUZ  CITY OF SANTA ROSA LAGUNA', 'TESDA SMAW NCI', 'Traffic Aide', 'CONTRACTUAL', '18/03/2019 11:15:46 AM', 'JONAS NATANAUAN', 'OK', '0', '0', '0', '0', '0', '09991807170', '0', '0', '0', '0', 'Tom'),
(79, '05334', 'EMETERIO', 'BELO', 'ASMA', 'MARRIED', 'MALE', '2/22/1978 4:34:08 PM', 'Riverstone Ciudad Grande Market Area,SRCL', 'VOCATIONAL', 'Traffic Aide', 'CONTRACTUAL', '10/1/2018 4:34:08 PM', 'BOSS', 'OK', '212-366-998', '00000000', '1020-0217-1382', '08-000076485-3', 'LP-78022201106', '09331261552', 'emittbelo08@gmail.com', 'Ramil belo', '09166321379', '-', 'BELO'),
(80, '227', 'Rogelio', 'San Juan JR.', 'Alinsod', 'MARRIED', 'MALE', '6/28/1974 11:38:35 AM', 'Purok 5 Barangay Sinalhan City of Sta. Rosa Laguna', 'Sinalhan Elementary School\r\n\r\nSaint Louie Anne Colleges\r\n\r\nUniversity of Perpetual Help System', 'Traffic Aide', 'CASUAL', '9/21/2016 11:38:35 AM', 'Soledad De Leon', '-', '-', '-', '-', '-', '-', '0908 690 2527', '-', 'Cynthia A. San Juan', '-', '-', 'Andrea Nominador'),
(81, '228', 'Antonio', 'League JR.', 'Barashari', 'MARRIED', 'MALE', '5/25/1974 11:43:00 AM', 'Blk 18 Lot 13 Garden Villas 3 Phase II Barangay Malusak Sta. Rosa City of Laguna', 'Santa Rosa Elementary School\r\n\r\nSanta Rosa Educational Institution\r\n\r\nPerpetual Help College of Laguna', 'Traffic Aide', 'CASUAL', '9/16/2016 11:43:00 AM', 'Gemini Barrinuevo', '-', '-', '-', '-', '-', '-', '0933 023 3229', '-', 'Alma Leysa', '-', '-', 'Andrea Nominador'),
(82, '14483', 'SUSAN', 'BATITIS', 'VILLERA', 'MARRIED', 'FEMALE', '9/21/1964 12:07:16 PM', 'Phase III Barangay Dita City of Sta. Rosa Laguna', 'Dita Elementary School\r\n\r\nDita National High School', 'Utility', 'CASUAL', '9/21/2016 12:07:16 PM', 'Gene Eugenio', '-', '-', '-', '-', '-', '-', '0928 939 3455', '-', 'Jomar Catindig', '-', '-', 'Andrea Nominador'),
(83, '231', 'Ceferino', 'Casilag Jr', 'Barlis', 'MARRIED', 'MALE', '10/24/1969 11:09:09 AM', '163 Barangay Aplaya Purok 1 City of Santa Rosa Laguna', 'Quirino Elementary School\r\n\r\nQuirino High School', 'Traffic Aide', 'CASUAL', '10/21/2008 11:09:09 AM', 'Edgar Anacan', '-', '-', '-', '-', '-', '-', '0998 861 1288', 'ceferinocasilag@yahoo.com', 'Prince Cesar A. Casilag', '-', '-', 'Andrea Nominador'),
(84, '232', 'Christian', 'De Castro', 'Ama', 'MARRIED', 'MALE', '6/23/1992 11:18:01 AM', 'Blk 4 Lot 11 Dama De Noche St. Mesa Homes Barangay Don Jose City of Sta. Rosa Laguna', 'Dr. Marcelino Z. Batista Memorial School\r\n\r\nBalibago National High School', 'Traffic Aide', 'CASUAL', '9/21/2016 11:18:01 AM', 'Rogelio San Juan Jr.', '-', '-', '-', '-', '-', '-', '0928 987 1305', '-', 'Reyna Jean C. De Castro', '-', '-', 'Andrea Nominador'),
(85, '233', 'Ricardo', 'Calandria', 'Basaca', '-', 'MALE', '2/11/1953 1:21:16 PM', 'Purok 4 Barangay Balibago City of Sta. Rosa Laguna', 'Cabuyao Institute Elementary School', 'Traffic Aide', 'CASUAL', '9/21/2015 1:21:16 PM', '-', '-', '-', '-', '-', '-', '-', '0949 932 6493', '-', '-', '-', '-', 'Andrea Nominador'),
(86, '40713', 'Sonny', 'Makiling', 'Otida', 'SINGLE', 'MALE', '4/1/1991 2:19:49 PM', 'Puok 1 Barangay Sinalhan City of Sta. Rosa Laguna', 'Santa Rosa Elementary School Central I\r\n\r\nAplaya National High School', 'Traffic Aide', 'CONTRACTUAL', '9/21/2016 2:19:49 PM', 'Crispin Mariñas', '-', '-', '-', '-', '-', '-', '0921 255 2632', 'sonnymakiling@yahoo.com', 'Susana Makiling', '-', '-', 'Andrea Nominador'),
(87, '235', 'Elvira', 'Flores', 'Moraleda', 'SINGLE', 'FEMALE', '2/19/1956 2:28:08 PM', 'Purok 2 Barangay Sinalhan City of Sta. Rosa Laguna', 'Sinalhan Elementary School\r\n\r\n', 'Traffic Aide', 'CONTRACTUAL', '9/21/2016 2:28:08 PM', 'Toto Sigue', '-', '-', '-', '-', '-', '-', '0918 445 7057', '-', '-', '-', '-', 'Andrea Nominador'),
(88, '40740', 'RUEL', 'SUAREZ', 'M.', 'SINGLE', 'MALE', '5 Apr 2018 12:35:44 PM', '-', '-', 'Traffic Aide', 'CONTRACTUAL', '5 Apr 2018 12:35:44 PM', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', 'Tom'),
(89, '40749', 'MARFEL', 'ZAMORA', 'R', 'SINGLE', 'MALE', '5 Apr 2018 12:42:30 PM', '-', '-', 'Traffic Aide', 'CONTRACTUAL', '5 Apr 2018 12:42:30 PM', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', 'Tom'),
(90, '-', 'LEONIDES', 'BARRINUEVO', 'RAGUB', 'MARRIED', 'MALE', '4/25/1975 11:51:29 AM', 'APLAYA, CITY OF STA ROSA, LAGUNA', 'COLLEGE UNDER GRAD.', 'Traffic Aide I', 'PERMANENT', '7/1/1998 11:51:29 AM', '-', '-', '195-390-318-000', '-', '102002093236', '080000182986', 'CM-5302496', '0918-6387-007', '-', 'BARRINUEVO JENNIELYN,L.', '-', '-', 'malaya'),
(91, '14510', 'MARIO', 'BASIBAS', 'LABONG', 'MARRIED', 'MALE', '1/30/1961 10:17:47 AM', '572 BRGY. MALUSAK,CITY OF STA ROSA LAGUNA.', 'HIGH SCHOOL GRAD.', 'Traffic Aide I', 'PERMANENT', '3/1/2013 10:17:47 AM', '-', '-', '171-831-331', '-', '1020 021318 82', '08-000067867-1', 'LP-61013002656', '0949-3761-560', '-', 'ANTONIA BASIBAS B.', '-', '-', 'malaya'),
(92, '14513', 'ROGELIO', 'BESENIO', 'BERCANSIL', 'MARRIED', 'MALE', '6/7/1969 11:00:54 AM', '1626 BRGY. DILA,CITY OF STA ROSA LAGUNA', 'VOCATIONAL GRAD.', 'Traffic Aide I', 'PERMANENT', '3/1/2013 11:00:54 AM', '-', '-', '258-437-419', '-', '1020 021319 02', '-', 'LP-020004240436', '0939-2893-248', '-', 'BESENIO CARMINA A.', '-', '-', 'malaya'),
(93, '14516', 'ALLAN', 'BROBIO', 'MENDOZA', 'MARRIED', 'MALE', '9/18/1971 11:08:19 AM', 'B10-A L2 CATAQUIZ SUBD.BRGY TAGAPO,CITY OF STA ROSA LAG.', 'COLLEGE UNDER GRAD.', 'Traffic Aide I', 'PERMANENT', '3/1/2013 11:08:19 AM', '-', '-', '216-413-866', '-', '-', '19-02059026-2', 'LP-71091801862', '0926-3114-117', '-', 'BROBIO MARYJANE', '-', '-', 'malaya'),
(94, '14549', 'RUSTICO', 'CRUZ', 'ALMODOVAR', 'MARRIED', 'MALE', '10/9/1957 11:54:38 AM', 'CATAQUIZ SUBD,BRGY.MARKET AREA,CITY OF SANTA ROSA, LAGUNA', 'HIGH SCHOOL GRAD.', 'Traffic Aide I', 'PERMANENT', '3/1/2013 11:54:38 AM', '-', '-', '241-757-277', '-', '1020-0213-1971', '08-200631088-1', 'LP-57100902348', '0929-139-2218', '-', 'CARMELITA CRUZ T.', '-', '-', 'malaya'),
(95, '14520', 'MICHAEL', 'CUETO', 'ENCARNACION', 'MARRIED', 'MALE', '4/13/1980 1:53:02 PM', 'ESPIRITU CMPD,BRGY.POOC,CITY OF SANTA ROSA LAGUNA', 'HIGH SCHOOL GRAD.', 'Traffic Aide I', 'PERMANENT', '3/1/2013 1:53:02 PM', '-', '-', '280-013-624', '-', '1020 021779 29', '08-000091321-2', 'LP-80041300772', '09983215193', '-', 'SARAH CUETO T.', '-', '-', 'malaya'),
(96, '14522', 'CESAR', 'DE CASTRO', 'CASTILLO', 'MARRIED', 'MALE', '9/2/1959 2:04:03 PM', 'B8 L12 SAN ISIDRO VILLAGE,BRGY. MACABLING,CITY OF SANTA ROSA LAGUNA', 'VOCATIONAL GRAD.', 'Traffic Aide I', 'PERMANENT', '3/1/2013 2:04:03 PM', '-', '-', '904-507-174', '03-5252322-2', '1020 0224 2239', '08-0502011724-5', '20033503298', '09997463137', '-', 'ELFLEDA DE CASTRO A.', '-', '-', 'malaya'),
(97, '13009', 'ROLANDO', 'DELA CRUZ', 'MARASIGAN', 'MARRIED', 'MALE', '10/29/1959 2:37:01 PM', 'BRGY, PULONG SANTA CRUZ,CITY OF SANTA ROSA LAGUNA', 'HIGH SCHOOL GRAD.', 'Traffic Aide I', 'PERMANENT', '9/16/1996 2:37:01 PM', '-', '-', '901-021-808', '04-0258521-7', '1020-0207-1623', '08-00009282-1', 'CM-0000947684', '09997580940', '-', 'MA. LANIE DELA CRUZ K.', '-', '-', 'malaya'),
(98, '14524', 'ROMEO', 'DE ROXAS', 'ALULOD', 'MARRIED', 'MALE', '8/24/1972 2:43:30 PM', 'BRGY. CAINGIN,CITY OF SANTA ROSA LAGUNA', 'HIGH SCHOOL GRAD.', 'Traffic Aide I', 'PERMANENT', '3/1/2013 2:43:30 PM', '-', '-', '178-079-676', '-', '1020-021320-12', '08-000067816-7', '2000 153 588', '09214902578', '-', 'MARIA ELIZABETH DE ROXAS M.', '-', '-', 'malaya'),
(99, '40706', 'Rustan', 'Infante', 'Legaspi', 'Single', 'MALE', '1/29/2018 1:37:04 PM', 'Blk 23 Lot 15 B.S.K.V 1 Pooc Sta. Rosa Laguna', 'Sta. Rosa Elementary School Central II\r\n\r\nAplaya National High School', 'Traffic Aide', 'CONTRACTUAL', '9/21/2016 1:37:04 PM', 'Violeta Legaspi', '-', '-', '-', '-', '-', '-', '0929 755 7366', 'RUSTANINFANTE@YAHOO.COM', 'Czarina Conda', '-', '-', 'Andrea Nominador'),
(100, '201', 'Ryan', 'Velandrez', 'Quilatez', 'SINGLE', 'MALE', '9/25/1981 1:50:01 PM', '115 Purok 2 Barangay Aplaya City of Sta. Rosa Laguna', 'Ano Elementary School\r\n\r\nCalasiao Comprehensive National High School', 'Traffic Aide', 'CONTRACTUAL', '9/1/2016', 'Restituto Laviña Opeña', '-', '-', '-', '-', '-', '-', '0928 165 1138', '-', '-', '-', '-', 'Andrea Nominador'),
(101, '202', 'Alan', 'Yanga', 'Lacap', 'Seperated', 'MALE', '12/8/1973 1:58:42 PM', 'Sitio Cawad Purok 3 Sto. Domingo City of Sta. Rosa Laguna', 'Sto. Ñino Elementary School', 'Traffic Aide', 'CONTRACTUAL', '9/16/2016 1:58:42 PM', 'Kap. Lily P.Ortega', '-', '-', '-', '-', '-', '-', '0905 941 4683', '-', 'Adonis Yanga', '-', '-', 'Andrea Nominador'),
(102, '203', 'Herman', 'Casupang', 'Marquez', 'MARRIED', 'MALE', '1/29/1969 2:06:55 PM', 'Pulong Sta. Cruz City of Sta. Rosa Laguna', 'Niugan Cabuyao Elementary School\r\n\r\nPulong Sta. Cruz National High School', 'Traffic Aide', 'CASUAL', '9/16/2012 2:06:55 PM', 'Basil Pag-Ong', '-', '-', '-', '-', '-', '-', '0950 035 6684', '-', 'Andy Casupang', '-', '-', 'Andrea Nominador'),
(103, '204', 'Joselito', 'Ocampo', 'Turrida', 'MARRIED', 'MALE', '6/19/1973 2:16:22 PM', 'Purok 4 Barangay Caingin City of Sta. Rosa Laguna', 'Sinalhan Elementary School\r\n\r\nAplaya National High School', 'Traffic Aide', 'CASUAL', '9/16/2016 2:16:22 PM', 'Bong Beato', '-', '-', '-', '-', '-', '-', '0907 989 9293', '-', 'Jamille Elaine R. Ocampo', '-', '-', 'Andrea Nominador'),
(104, '205', 'Magtanggol', 'Endrinal', 'A.', 'SINGLE', 'MALE', '4/30/1954 2:21:08 PM', 'Mercado Compound Barangay Tagapo City of Sta. Rosa Laguna', 'Platero Elementary School\r\n\r\nLakeshore National High School', 'Traffic Aide', 'PERMANENT', '9/16/2016 2:21:08 PM', 'Kapt. Aldrin Lumagi', '-', '-', '-', '-', '-', '-', '0908 113 0740', '-', '-', '-', '-', 'Andrea Nominador'),
(105, '207', 'Benjamin', 'Diaz', 'Amatorio', 'MARRIED', 'MALE', '6/20/2018 2:33:35 PM', 'Purok 4 Barangay Sinalhan City of Sta. Rosa Laguna', 'Sinalhan Elementary School\r\n\r\nSanta Rosa Educational Institute', 'Traffic Aide', 'CASUAL', '9/16/2016 2:33:35 PM', 'Omar Babasanta', '-', '-', '-', '-', '-', '-', '0921 212 4859', '-', 'Rosemarie S. Diaz', '-', '-', 'Andrea Nominador'),
(106, '209', 'Darwin', 'Dean', 'Lerpido', 'MARRIED', 'MALE', '1/29/2018 2:48:08 PM', '15 Catleya St. Rose Village Subdivision Dita Cuty of Sta. Rosa Laguna', 'Dita Elementary School\r\n\r\nBalibago High School\r\n\r\nSRMTC', 'Traffic Aide', 'CASUAL', '9/16/2016 2:48:08 PM', 'Toti Dela Rosa', '-', '-', '-', '-', '-', '-', '0946 714 5344', '-', 'Jerwin Corono Dean', '-', '-', 'Andrea Nominador'),
(107, '210', 'Cesar', 'De Castro', 'Castillo', 'MARRIED', 'MALE', '9/2/1959 3:16:43 PM', 'San Isidro Village Macabling Santa Rosa Laguna', 'Sto Tomas Elementary School\r\n\r\nSaint Tomas Academy\r\n\r\nPhilippine Seaferer Training', 'Traffic Aide', 'PERMANENT', '9/16/2016 3:16:43 PM', 'Celso Catindig', '-', '-', '-', '-', '-', '-', '0995 237 7178', '-', 'John Joel De Castro', '-', '-', 'Andrea Nominador'),
(108, '14504', 'Ronnie', 'Alibudbud', 'Gomez', 'MARRIED', 'MALE', '3/18/1981 3:27:27 PM', '186 Purok 1 Barangay Aplaya City of Sta. Rosa Laguna', 'Sta. Rosa Elementary School\r\n\r\nAplaya National High School\r\n\r\nUniversity of Perpetual Health Biñan', 'Traffic Aide', 'CASUAL', '9/16/2016 3:27:27 PM', 'Digoy Malapitan', '-', '-', '-', '-', '-', '-', '0905 232 9018', '-', 'Reynaldo Alibudbud', '-', '-', 'Andrea Nominador'),
(109, '213', 'Ildefonso', 'Katigbak', 'Quibral', 'MARRIED', 'MALE', '1/23/1965 3:32:26 PM', 'Estanislao Compound Barangay Labas City of Sta. Rosa Laguna', 'Anilao Elemtary School\r\n\r\nNilao Barangay High School', 'Traffic Aide', 'CASUAL', '9/16/2016 3:32:26 PM', 'Gilbert Barroso', '-', '-', '-', '-', '-', '-', '0928 262 2969', '-', 'Jayson F. Katigbak', '-', '-', 'Andrea Nominador'),
(110, '214', 'Ronquillo', 'Salud', 'Roa', 'MARRIED', 'MALE', '3/27/2018 3:38:33 PM', 'Blk 5 Lot 20 St. Rose Subdivision Market Area City of Sta. Rosa Laguna', 'Santa Rosa Elementary School Central II\r\n\r\nSanta Rosa Educational Institute', 'Traffic Aide', 'CASUAL', '9/16/2016', 'Dan S. Fernandez', '-', '-', '-', '-', '-', '-', '0930 628 6535', '-', 'Christine M. Abella', '-', '-', 'Andrea Nominador'),
(111, '215', 'Joselito', 'Delos Reyes', 'Salcedo', 'MARRIED', 'MALE', '2/12/2018 3:44:14 PM', 'Blk 23 Lot 3 Market Area City of Sta. Rosa Laguna', 'Bayanan Elementary School', 'Traffic Aide', 'CASUAL', '1/29/9670 3:44:14 PM', 'Marietta Bartolazo', '-', '-', '-', '-', '-', '-', '0921 843 6251', '-', 'Edna Y. Delos Reyes', '-', '-', 'Andrea Nominador'),
(112, '216', 'Franklin', 'Dela Cruz', 'Ventura', 'Widow', 'MALE', '4/14/1964 3:48:48 PM', 'Blk 81 Lot 25 Phase 2 Golden City Barangay Dila City of Sta. Rosa Laguna', 'Gregoria De Jesus Elementary School\r\n\r\nTorres High School\r\n\r\nFar Eastern University ', 'Traffic Aide', 'CASUAL', '9/16/2016 3:48:48 PM', 'Jose Peping Cartaño', '-', '-', '-', '-', '-', '-', '0907 072 4982', '-', 'John Lloyd Dela Cruz', '-', '-', 'Andrea Nominador'),
(113, '217', 'Michael', 'Beldad', 'Fallarna', 'MARRIED', 'MALE', '5/8/1973 4:01:11 PM', '110 F. Gomez Purok 2 Barangay Aplaya City of Sta. Rosa', 'Aplaya Elementary School\r\n\r\nSanta Rosa Educational Institute', 'Traffic Aide', 'CASUAL', '9/16/2016 4:01:11 PM', 'Romeo De Roxas', '-', '-', '-', '-', '-', '-', '0921 405 4092', '-', 'Maricel B. Beldad', '-', '-', 'Andrea Nominador'),
(114, '218', 'Edgar ', 'Anacan', 'Tiqui', 'MARRIED', 'MALE', '1/29/2018 4:09:05 PM', 'Buklod Diwa Relocation I Pulong Sta. Cruz City of Sta. Rosa Laguna', 'Pulong Sta. Cruz Elementary School\r\n\r\nPulong Sta. Cruz National High School', 'Traffic Aide', 'CASUAL', '9/16/2016 4:09:05 PM', 'Constacia Dones', '-', '-', '-', '-', '-', '-', '0910 311 6502', '-', 'Ma. Reina Anacan', '-', '-', 'Andrea Nominador'),
(115, '219', 'Joel', 'Meneses', 'Nebreja', 'MARRIED', 'MALE', '5/25/1971 4:14:39 PM', 'Purok 4 Barangay Santo Domingo City of Sta. Rosa Laguna', 'Santo Domingo Elementary School\r\n\r\nDon Jose National High School\r\n\r\nLaguna College of Business And Arts', 'Traffic Aide', 'CASUAL', '8/16/2016 4:14:39 PM', 'Lily Ortega', '-', '-', '-', '-', '-', '-', '0920 279 8583', 'menesesjoel188@gmail.com', 'Stephanie Nicole Meneses', '-', '-', 'Andrea Nominador'),
(116, '220', 'Malaya', 'Medina', 'Espinosa', 'SINGLE', 'FEMALE', '7/12/1975 11:05:28 AM', 'Purok 5 Barangay Aplaya City of Sta. Rosa Laguna', 'Santa Rosa Elementary School Central I\r\n\r\nAplaya National High School\r\n\r\nSRCBC\r\n\r\nCOM.SEC\r\n', 'Administrative Aide', 'PERMANENT', '9/16/2016 11:05:28 AM', 'Relly M. Medina', '-', '-', '-', '-', '-', '-', '0912 295 6239', '-', 'Ronaldo D. Torres', '-', '-', 'Andrea Nominador'),
(117, '221', 'Clara', 'Pastidio', 'Calimpon', 'SINGLE', 'FEMALE', '8/12/1969 11:15:31 AM', '855 Purok 4 Barangay Dita City of Sta. Rosa Laguna', 'Dita Elementary School\r\n\r\nSanta Rosa Educational Institution\r\n\r\nLCBA\r\n\r\nColegio De San Juan De Letran', 'Administrative Aide', 'CASUAL', '7/14/2014 11:15:31 AM', 'Godofredo Z. Dela Rosa', '-', '-', '-', '-', '-', '-', '0917 585 7512', 'Ijjamie@yahoo.com', 'Virgina C. Pastidio', '-', '-', 'Andrea Nominador'),
(118, '40813', 'Eddie', 'Colarina', 'Alibusan', 'SINGLE', 'MALE', '16/12/1983 11:25:01 AM', 'F 100 Purok 2 Barangay Aplaya City of Sta. Rosa Laguna', 'Malaban Elementary School\r\n\r\nAplaya National High School\r\n\r\nTrimex Institute of Science and Technology', 'Administrative Aide', 'CONTRACTUAL', '16/09/2016 11:25:01 AM', 'SPO4 Gene M. Eugenio', '-', '-', '3371252733', '-', '-', '-', '0942 003 8396', 'edscolarina@gmail.com', 'Mildred G. Espinosella', '09208089598', '-', 'Tom'),
(119, '225', 'ROCKEFELLER', 'REYES', 'LAVIÑA', 'MARRIED', 'MALE', '11/17/1967 11:50:07 AM', '709 PUROK 4 BARANGAY SINALHAN CITY OF STA. ROSA LAGUNA', 'SINALHAN ELEMENTARY SCHOOL\r\n\r\nGRINHAR COLLEGE', 'Traffic Aide', 'CASUAL', '9/16/2016 11:50:07 AM', 'SOLEDAD DE LEON', '-', '-', '-', '-', '-', '-', '0942 049 4681', '-', 'RUSSEL REYES', '-', '-', 'Andrea Nominador'),
(120, '236', 'Michael', 'Zamora', 'Pacaña', 'MARRIED', 'MALE', '7/31/1973 2:32:50 PM', 'Blk 28 Lot 51 Marigold St. Garden Villas Barangay Malusak City of Sta. Rosa Laguna', 'Don Andres Soriano Elementary School\r\n\r\nDon Andres Soriano High School\r\n\r\nCebu Institute of Technical', 'Traffic Aide', 'CONTRACTUAL', '9/21/2016 2:32:50 PM', 'Ramon Dia', '-', '-', '-', '-', '-', '-', '0942 300 9851', '-', 'Teresita A. Zamora', '-', '-', 'Andrea Nominador'),
(121, '237', 'Eduardo', 'Tapangco', 'Tuscano', 'MARRIED', 'MALE', '11/18/1979 2:40:27 PM', '582 Purok 2 Barangay Sinalhan City of Sta. Rosa Laguna', 'Sinalhan Elementary School\r\n\r\nAplaya National High School', 'Traffic Aide', 'CONTRACTUAL', '9/21/2016 2:40:27 PM', 'Soledad De Leon', '-', '-', '-', '-', '-', '-', '0949 135 6994', '-', 'Judy San Francisco', '-', '-', 'Andrea Nominador'),
(122, '238', 'Emmanuel', 'Arroyo', 'Mapusao', 'SINGLE', 'MALE', '10/9/1977 3:10:09 PM', 'Blk 31 Lot 6 Barangay Pooc  City of Sta. Rosa Laguna', 'Santa Rosa Elementary School Central I', 'Traffic Aide', 'CONTRACTUAL', '9/21/2016 3:10:09 PM', 'Dennis Ferra', '-', '-', '-', '-', '-', '-', '0948 998 6711', '-', 'Batriz Mapusao', '-', '-', 'Andrea Nominador'),
(123, '14551', 'LUIS', 'VILLAFLORES', 'CERDA', 'MARRIED', 'MALE', '21/06/1977 5:28:16 PM', 'PUROK 3 BRGY APLAYA STA ROSA LAGUNA', 'VOCATIONAL ELECTRONICS', 'Traffic Aide I', 'CASUAL', '02/01/2007 5:28:16 PM', 'VICE ARNOLD ARCILLAS', 'OK', '206126883', 'N/A', 'N/A', '080000761687', '2000153222', '09205635711', 'dy1nol@yahoo.com', 'Cecilia C. Villaflores', '09305232451', 'momyces_ganda@yahoo.com', 'Tom'),
(124, '13024', 'ROBERTO', 'SALAMAT', 'FAJARDO', 'MARRIED', 'MALE', '20/04/1965 5:57:22 PM', 'PUROK 4 BRGY APLAYA STA ROSA LAGUNA', 'HIGH SCHOOL GRADUATE', 'Traffic Aide I', 'PERMANENT', '01/01/1988 5:57:22 PM', 'MAYOR', 'N/A', '170001166', 'N/A', 'N/A', '08-000018325-7', 'CM-0000477031', '0906250774', 'N/A', 'LESLIE N. SALAMAT', '09987909622', 'N/A', 'Tom'),
(125, '14530', 'JAY', 'GALANG', 'ISAGON', 'MARRIED', 'MALE', '10/09/1980 12:46:02 PM', 'PUROK 6 BRGY SINALHAN STA ROSA LAGUNA', 'HIGH SCHOOL GRADUATE', 'Traffic Aide', 'CASUAL', '08/08/2008 12:46:02 PM', 'CAPTAIN LORENCIO SIGUE', 'APPROVED', '271054249', 'N/A', 'N/A', '080000858653', '2003627812', '09305752724', 'galangjay24@yahoo.com', 'RELENE GALANG', '09307572724', 'N/A', 'Tom');

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
  `startTicket` int(50) DEFAULT NULL,
  `endTicket` int(50) DEFAULT NULL,
  `currentTicket` int(50) DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `is_activated` tinyint(1) NOT NULL,
  `apiKey` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_ctmeu_id`, `first_name`, `middle_name`, `last_name`, `affixes`, `username`, `password`, `role`, `startTicket`, `endTicket`, `currentTicket`, `email`, `employee_id`, `is_activated`, `apiKey`) VALUES
(1, 'Vincent Andrei', '', 'Cosio', '', 'VanillaC', '$2y$10$wr.wTumAsDICvNPpWek8IeRYiG8ldm/qwBUdsTLzE7h1ANmozXG1q', 'Super Administrator', NULL, NULL, NULL, 'vincent.andrei15@gmail.com', NULL, 0, ''),
(101, 'eddie', 'alibusan', 'colarina', '', 'edscolarina', '$2y$10$b/G/TZG1b0aZAY0d1CAbeehcamsohCpmRbSZpr8nP53W9Sc4b61YK', 'Enforcer', NULL, NULL, NULL, '', NULL, 0, NULL);

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
(3, 99, 2),
(4, 1, 2),
(5, 1, 3);

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
  `date_violation` date DEFAULT NULL,
  `time_violation` time NOT NULL,
  `date_time_violation_edit` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `place_of_occurrence` varchar(50) NOT NULL,
  `tct_number` varchar(255) NOT NULL,
  `user_ctmeu_id` int(11) DEFAULT NULL,
  `user_id_motorists` int(11) DEFAULT NULL,
  `is_settled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `violation_tickets`
--

INSERT INTO `violation_tickets` (`ticket_id`, `driver_name`, `driver_license`, `issuing_district`, `driver_address`, `vehicle_type`, `plate_no`, `reg_owner`, `reg_owner_address`, `date_violation`, `time_violation`, `date_time_violation_edit`, `place_of_occurrence`, `tct_number`, `user_ctmeu_id`, `user_id_motorists`, `is_settled`) VALUES
(2, 'Juan Dela Cruz', 'DO4-45-709665', 'Cabuyao', 'Market Area lakeville', 2, 'ABC1234', 'Dela Cruz Juan', 'Market Area lakeville', '2024-12-27', '00:00:00', '2024-01-10 08:51:53', 'SM', 'motorist1@gmail.com', 101, NULL, 0),
(3, 'tom', 'do412345', 'cabuyao', 'aplaya', 1, 'dxn1244', 'ddosjs', 'wiehgei', '2024-01-03', '00:00:00', '2024-01-05 09:17:34', 'simbahan', 'edscolarina@gmail.co', 101, NULL, 0),
(4, 'Juan Dela Cruz', 'DO4-45-709665', 'Cabuyao', 'Market Area lakeville', 2, 'ABC1234', 'Dela Cruz Juan', 'Market Area lakeville', '2024-12-27', '00:00:00', '2024-01-10 08:54:34', 'SM', 'motorist1@gmail.com', 101, NULL, 1),
(5, 'tom', 'do412345', 'cabuyao', 'aplaya', 1, 'dxn1244', 'ddosjs', 'wiehgei', '2024-01-03', '00:00:00', '2024-01-10 08:54:40', 'simbahan', 'edscolarina@gmail.co', 101, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `violator_info`
--

CREATE TABLE `violator_info` (
  `violator_id` int(11) NOT NULL,
  `TCT_NUMBER` int(50) NOT NULL,
  `DRIVER_NAME` varchar(30) NOT NULL,
  `VIOLATION_NAME` varchar(30) NOT NULL,
  `VIOLATION_DATE` date NOT NULL,
  `VIOLATION_TIME` time NOT NULL,
  `VIOLATION_FINE` varchar(50) NOT NULL,
  `VIOLATION_SECTION` varchar(50) NOT NULL,
  `violationL_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee_masterlist`
--
ALTER TABLE `employee_masterlist`
  ADD PRIMARY KEY (`masterlist_id`);

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
  ADD PRIMARY KEY (`user_ctmeu_id`),
  ADD KEY `employeeid` (`employee_id`);

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
-- Indexes for table `violator_info`
--
ALTER TABLE `violator_info`
  ADD PRIMARY KEY (`violator_id`),
  ADD KEY `vioList` (`violationL_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employee_masterlist`
--
ALTER TABLE `employee_masterlist`
  MODIFY `masterlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `motorist_info`
--
ALTER TABLE `motorist_info`
  MODIFY `motorist_info_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_ctmeu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `users_motorists`
--
ALTER TABLE `users_motorists`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicletype`
--
ALTER TABLE `vehicletype`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `violationlists`
--
ALTER TABLE `violationlists`
  MODIFY `violation_list_ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT for table `violations`
--
ALTER TABLE `violations`
  MODIFY `violation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `violation_tickets`
--
ALTER TABLE `violation_tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `violator_info`
--
ALTER TABLE `violator_info`
  MODIFY `violator_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `motorist_info`
--
ALTER TABLE `motorist_info`
  ADD CONSTRAINT `motorist info id` FOREIGN KEY (`users_motorists_info_id`) REFERENCES `users_motorists` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `employeeid` FOREIGN KEY (`employee_id`) REFERENCES `employee_masterlist` (`masterlist_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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

--
-- Constraints for table `violator_info`
--
ALTER TABLE `violator_info`
  ADD CONSTRAINT `vioList` FOREIGN KEY (`violationL_id`) REFERENCES `violationlists` (`violation_list_ids`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
