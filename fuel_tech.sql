-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2025 at 07:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fuel_tech`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `AdminID` int(11) NOT NULL,
  `AdminUsername` varchar(30) NOT NULL,
  `AdminName` varchar(35) NOT NULL,
  `PasswordHash` varchar(255) NOT NULL,
  `AllPermissions` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`AdminID`, `AdminUsername`, `AdminName`, `PasswordHash`, `AllPermissions`) VALUES
(1, 'moh7mmedehab', 'Mohammed Ehab', '$2y$12$wYBctwFTEnVEls7UDom1rOEv6rEnGkJf5fo.BtqEtEkHD3j.8gBDC', 1),
(2, 'tamer', 'tamerr', 'tamer@2008', 2),
(3, 'Tamer1', 'tamerrr', 'tamer@2008', 3),
(4, 'ahmed', 'ahmedd', '4d7e3b48b0647f8e045a8c82944d6368ee0b6abce3ef4d55d548d1f35cc632e9', 4),
(100, 'ahmedt', 'ahmedd', '4d7e3b48b0647f8e045a8c82944d6368ee0b6abce3ef4d55d548d1f35cc632e9', 100);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `EmployeeID` int(11) NOT NULL,
  `EmployeeName` varchar(35) NOT NULL,
  `EmployeeEmail` varchar(100) NOT NULL,
  `EmployeePhone` varchar(18) NOT NULL,
  `EmployeeRole` varchar(30) NOT NULL,
  `PersonalID` varchar(14) NOT NULL,
  `WorkingHours` int(11) NOT NULL DEFAULT 8,
  `EmployeeSalary` int(11) NOT NULL,
  `AdminID` int(11) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `RequestID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Name` varchar(35) NOT NULL,
  `PhoneNumber` varchar(18) NOT NULL,
  `CarType` varchar(30) NOT NULL,
  `CarModel` varchar(30) NOT NULL,
  `Services` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`Services`)),
  `LocationURL` varchar(60) NOT NULL,
  `Issues` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `IssuesForm` tinyint(1) DEFAULT NULL,
  `FrontID` varchar(100) NOT NULL,
  `BackID` varchar(100) NOT NULL,
  `IssueImage` varchar(100) DEFAULT NULL,
  `Statue` enum('Not-Confirmed','Cancelled','Pending','Accepted','Completed') NOT NULL DEFAULT 'Not-Confirmed',
  `AdminDescription` varchar(255) DEFAULT NULL,
  `AdminID` int(11) DEFAULT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `RespondingDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`RequestID`, `UserID`, `Name`, `PhoneNumber`, `CarType`, `CarModel`, `Services`, `LocationURL`, `Issues`, `Description`, `IssuesForm`, `FrontID`, `BackID`, `IssueImage`, `Statue`, `AdminDescription`, `AdminID`, `Date`, `RespondingDate`) VALUES
(1, 1, 'ahmedtamer', '12345678910', 'hjdf', 'jnbgdr', '[\"Gasoline 92\",\"Maintenance\"]', '', NULL, NULL, 0, '1_67e30ff4c5897.png', '1_67e30ff4c6666.png', NULL, 'Accepted', 'kljsab', 1, '2025-03-25 20:20:04', '2025-03-25 20:22:44');

-- --------------------------------------------------------

--
-- Table structure for table `technicians`
--

CREATE TABLE `technicians` (
  `TechnicianID` int(11) NOT NULL,
  `EmployeeID` int(11) NOT NULL,
  `Username` varchar(35) NOT NULL,
  `PasswordHash` varchar(255) NOT NULL,
  `TechnicianName` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(35) NOT NULL,
  `PasswordHash` varchar(200) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Verified` tinyint(1) NOT NULL DEFAULT 0 CHECK (`Verified` in (0,1)),
  `VerificationCode` varchar(8) DEFAULT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `PasswordHash`, `Email`, `Verified`, `VerificationCode`, `Date`) VALUES
(1, 'ahmedtamer', '$2y$10$ULcofTXVXr4Q.KXw4NzfrukR130nNl9KcU2mnLuJQZCE9hbeMpjk2', 'ahmedtamer@gmail.com', 1, '576652', '2025-03-25 20:15:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`AdminID`),
  ADD UNIQUE KEY `AdminUsername` (`AdminUsername`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`EmployeeID`),
  ADD KEY `AdminID` (`AdminID`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`RequestID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `AdminID` (`AdminID`);

--
-- Indexes for table `technicians`
--
ALTER TABLE `technicians`
  ADD PRIMARY KEY (`TechnicianID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD KEY `EmployeeID` (`EmployeeID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `EmployeeID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `RequestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `technicians`
--
ALTER TABLE `technicians`
  MODIFY `TechnicianID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`AdminID`) REFERENCES `admins` (`AdminID`);

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`AdminID`) REFERENCES `admins` (`AdminID`);

--
-- Constraints for table `technicians`
--
ALTER TABLE `technicians`
  ADD CONSTRAINT `technicians_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `employees` (`EmployeeID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
