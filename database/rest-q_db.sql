-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2022 at 06:04 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rest-q_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `alertlogs`
--

CREATE TABLE `alertlogs` (
  `Alert_ID` bigint(255) NOT NULL,
  `P_ID` varchar(255) NOT NULL,
  `alertType` varchar(20) NOT NULL,
  `alertMessage` varchar(255) NOT NULL,
  `isSeen` varchar(20) NOT NULL,
  `DateNotify` date NOT NULL,
  `TimeNotify` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- --------------------------------------------------------

--
-- Table structure for table `alertpersonnel`
--

CREATE TABLE `alertpersonnel` (
  `ID` bigint(255) NOT NULL,
  `U_ID` varchar(100) NOT NULL,
  `NotifyMessage` varchar(255) NOT NULL,
  `isSeen` text NOT NULL,
  `Status` text NOT NULL,
  `DateNotify` varchar(20) NOT NULL,
  `TimeNotify` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `patient_info`
--

CREATE TABLE `patient_info` (
  `ID` bigint(255) NOT NULL,
  `P_ID` varchar(30) NOT NULL,
  `Passwd` varchar(255) NOT NULL,
  `Image` varchar(100) NOT NULL,
  `Sname` text NOT NULL,
  `Fname` text NOT NULL,
  `Mname` text NOT NULL,
  `Barangay` varchar(30) NOT NULL,
  `RegistrationDate` date NOT NULL,
  `QuarantineDate` date NOT NULL,
  `QuarantineEnd` date NOT NULL,
  `InfectiousDisease` varchar(50) NOT NULL,
  `BirthDate` date NOT NULL,
  `Gender` text NOT NULL,
  `Nationality` text NOT NULL,
  `Address` varchar(150) NOT NULL,
  `Latitude` float(10,6) NOT NULL,
  `Longhitude` float(10,6) NOT NULL,
  `ContactNumber` varchar(11) NOT NULL,
  `EmailAddress` varchar(100) NOT NULL,
  `Occupation` varchar(50) NOT NULL,
  `Comorbidities` varchar(255) NOT NULL,
  `BloodType` varchar(10) NOT NULL,
  `LastTravelHistory` varchar(255) NOT NULL,
  `ContactPersonName` text NOT NULL,
  `Relationship` text NOT NULL,
  `ContactPersonNumber` varchar(11) NOT NULL,
  `ContactPersonAddress` varchar(255) NOT NULL,
  `PatientCondition` varchar(50) NOT NULL,
  `DeviceStatus` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- --------------------------------------------------------

--
-- Table structure for table `session_logs`
--

CREATE TABLE `session_logs` (
  `ID` bigint(255) NOT NULL,
  `U_ID` varchar(255) NOT NULL,
  `Session_Unit` text NOT NULL,
  `Session_Date` date NOT NULL,
  `Session_Time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `ID` bigint(255) NOT NULL,
  `AvailabilityStatus` text NOT NULL,
  `SigninStatus` text NOT NULL,
  `VerificationStatus` varchar(255) NOT NULL,
  `OTPCode` varchar(255) NOT NULL,
  `OTPExpiration` varchar(5) NOT NULL,
  `U_ID` varchar(255) NOT NULL,
  `Roles` varchar(255) NOT NULL,
  `FromBrgy` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Passwd` varchar(255) NOT NULL,
  `AccountStatus` text NOT NULL,
  `DeletedDate` varchar(20) NOT NULL,
  `Sname` text NOT NULL,
  `Fname` text NOT NULL,
  `Mname` text NOT NULL,
  `Gender` varchar(6) NOT NULL,
  `ContactNumber` varchar(11) NOT NULL,
  `EmailAddress` varchar(255) NOT NULL,
  `Addr` varchar(255) NOT NULL,
  `JoinDate` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_info`
--

  INSERT INTO `user_info` (`ID`, `AvailabilityStatus`, `SigninStatus`, `VerificationStatus`, `OTPCode`, `OTPExpiration`, `U_ID`, `Roles`, `FromBrgy`, `Image`, `Passwd`, `AccountStatus`, `DeletedDate`, `Sname`, `Fname`, `Mname`, `Gender`, `ContactNumber`, `EmailAddress`, `Addr`, `JoinDate`) VALUES
  (1, 'Offline', 'Unblock', 'Verified', '', '0', 'B000-E21001', 'Global Administrator', '', 'default_avatar_male.png', '$2y$10$0cdPYS0XiGKxtBn2uIvfzeInQom3rF.LQlgoD9okgrzHx8SHjzEhe', 'Active', '', 'Admin', 'Default', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_logs`
--

CREATE TABLE `user_logs` (
  `ID` bigint(255) NOT NULL,
  `U_ID` varchar(255) NOT NULL,
  `U_ID_Action` varchar(255) NOT NULL,
  `Uname_Action` varchar(255) NOT NULL,
  `Action` varchar(255) NOT NULL,
  `Comments` varchar(255) NOT NULL,
  `DateOfAction` date NOT NULL,
  `TimeOfAction` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alertlogs`
--
ALTER TABLE `alertlogs`
  ADD PRIMARY KEY (`Alert_ID`);

--
-- Indexes for table `alertpersonnel`
--
ALTER TABLE `alertpersonnel`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `patient_info`
--
ALTER TABLE `patient_info`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `session_logs`
--
ALTER TABLE `session_logs`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alertlogs`
--
ALTER TABLE `alertlogs`
  MODIFY `Alert_ID` bigint(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `alertpersonnel`
--
ALTER TABLE `alertpersonnel`
  MODIFY `ID` bigint(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient_info`
--
ALTER TABLE `patient_info`
  MODIFY `ID` bigint(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `session_logs`
--
ALTER TABLE `session_logs`
  MODIFY `ID` bigint(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `ID` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `ID` bigint(255) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
