-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2025 at 07:05 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `attendease`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `middleName` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_ID`, `user_ID`, `firstName`, `lastName`, `middleName`) VALUES
(2, 8, 'q', 'he', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendanceID` int(11) NOT NULL,
  `learnerID` int(11) NOT NULL,
  `scheduleID` int(11) NOT NULL,
  `teacherID` int(11) NOT NULL,
  `adminID` int(11) NOT NULL,
  `sectionID` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `timeIn` time DEFAULT NULL,
  `timeOut` time DEFAULT NULL,
  `status` enum('absent','tardy','present') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendanceID`, `learnerID`, `scheduleID`, `teacherID`, `adminID`, `sectionID`, `date`, `timeIn`, `timeOut`, `status`) VALUES
(5, 5, 1, 1, 2, 2, '2025-10-02', '08:00:00', '09:00:00', 'tardy'),
(6, 5, 1, 1, 2, 2, '2025-10-03', '08:00:00', '09:00:00', 'tardy'),
(7, 5, 1, 1, 2, 2, '2025-10-04', '08:00:00', '09:00:00', 'tardy'),
(8, 5, 1, 1, 2, 2, '2025-10-05', '07:30:00', '09:00:00', 'present'),
(9, 5, 1, 1, 2, 2, '2025-10-06', NULL, NULL, 'absent'),
(10, 5, 1, 1, 2, 2, '2025-10-07', NULL, NULL, 'absent');

-- --------------------------------------------------------

--
-- Table structure for table `learner`
--

CREATE TABLE `learner` (
  `learnerID` int(11) NOT NULL,
  `adminID` int(11) NOT NULL,
  `nfcID` int(50) DEFAULT NULL,
  `sectionID` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `mname` varchar(50) DEFAULT NULL,
  `LRN` int(20) NOT NULL,
  `sex` enum('Male','Female') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `learner`
--

INSERT INTO `learner` (`learnerID`, `adminID`, `nfcID`, `sectionID`, `fname`, `lname`, `mname`, `LRN`, `sex`) VALUES
(5, 2, NULL, 2, 'Martin', 'Romualdez', 'Gomez', 112346, 'Male'),
(6, 2, NULL, 2, 'Imee', 'Marcos', 'Romualdez', 34, 'Female');

-- --------------------------------------------------------

--
-- Table structure for table `nfctag`
--

CREATE TABLE `nfctag` (
  `nfcID` int(50) NOT NULL,
  `uid` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notif_ID` int(11) NOT NULL,
  `teacher_ID` int(11) NOT NULL,
  `adminID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `scheduleID` int(50) NOT NULL,
  `sectionID` int(50) NOT NULL,
  `teacherID` int(50) NOT NULL,
  `day` enum('Monday','Tuesday','Wednesday','Thursday','Friday') NOT NULL,
  `startTime` time NOT NULL DEFAULT current_timestamp(),
  `endTime` time NOT NULL DEFAULT current_timestamp(),
  `schoolYear` varchar(50) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `roomAssignment` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`scheduleID`, `sectionID`, `teacherID`, `day`, `startTime`, `endTime`, `schoolYear`, `subject`, `roomAssignment`) VALUES
(1, 2, 1, 'Monday', '07:30:00', '09:00:00', '2024-2025', 'Math', 'R 105');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `sectionID` int(11) NOT NULL,
  `teacherID` int(11) NOT NULL,
  `sectionName` varchar(50) NOT NULL,
  `gradeLevel` enum('7','8','9','10','11') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`sectionID`, `teacherID`, `sectionName`, `gradeLevel`) VALUES
(2, 1, 'Korap', '7');

-- --------------------------------------------------------

--
-- Table structure for table `sf2`
--

CREATE TABLE `sf2` (
  `sf2ID` int(11) NOT NULL,
  `attendanceID` int(11) NOT NULL,
  `adminID` int(11) NOT NULL,
  `teacherID` int(11) NOT NULL,
  `studID` int(11) NOT NULL,
  `school_ID` int(11) NOT NULL,
  `schoolYear` varchar(11) NOT NULL,
  `schoolName` varchar(50) NOT NULL,
  `month` enum('January','February','March','April','May','June','July','August','September','October','November','December') NOT NULL,
  `remarks` text NOT NULL,
  `date` date NOT NULL,
  `summary` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacherID` int(11) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacherID`, `userID`) VALUES
(1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_ID` int(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `accountType` enum('Admin','Teacher','') NOT NULL DEFAULT 'Teacher',
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `middleName` varchar(50) NOT NULL,
  `verified_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_ID`, `username`, `email`, `password`, `accountType`, `firstName`, `lastName`, `middleName`, `verified_at`) VALUES
(7, 'Ken', 'ken@com', '$2y$10$nRMGekbIs84.S/jgMxyZfuIK1KJ1nldpo6vXCLrRhJ7tsHDJTuyJO', 'Teacher', 'kenny', 'J', '', '2025-09-30 22:00:19'),
(8, 'q', 'q@com', '$2y$10$E4tX8Ji5w/2Ly25KkHVFUO9jj5GTLHyzd8DRsXtRF5wrH66qTkQ1y', 'Admin', 'q', 'he', '', '2025-10-01 22:40:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_ID`),
  ADD KEY `user_ID` (`user_ID`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendanceID`),
  ADD KEY `adminID` (`adminID`),
  ADD KEY `teacherID` (`teacherID`),
  ADD KEY `learnerID` (`learnerID`),
  ADD KEY `attendance_ibfk_3` (`scheduleID`),
  ADD KEY `sectionID` (`sectionID`);

--
-- Indexes for table `learner`
--
ALTER TABLE `learner`
  ADD PRIMARY KEY (`learnerID`),
  ADD UNIQUE KEY `nfcID` (`learnerID`),
  ADD KEY `adminID` (`adminID`),
  ADD KEY `nfcID_2` (`nfcID`),
  ADD KEY `sectionID` (`sectionID`);

--
-- Indexes for table `nfctag`
--
ALTER TABLE `nfctag`
  ADD PRIMARY KEY (`nfcID`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notif_ID`),
  ADD KEY `teacher_ID` (`teacher_ID`),
  ADD KEY `adminID` (`adminID`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`scheduleID`),
  ADD KEY `teacherID` (`teacherID`),
  ADD KEY `sectionID` (`sectionID`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`sectionID`),
  ADD KEY `teacherID` (`teacherID`);

--
-- Indexes for table `sf2`
--
ALTER TABLE `sf2`
  ADD PRIMARY KEY (`sf2ID`),
  ADD KEY `attendanceID` (`attendanceID`),
  ADD KEY `adminID` (`adminID`),
  ADD KEY `teacherID` (`teacherID`),
  ADD KEY `studID` (`studID`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacherID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendanceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `learner`
--
ALTER TABLE `learner`
  MODIFY `learnerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `scheduleID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `sectionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teacherID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_ID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `user` (`user_ID`);

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`adminID`) REFERENCES `admin` (`admin_ID`),
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`teacherID`) REFERENCES `teacher` (`teacher_ID`),
  ADD CONSTRAINT `attendance_ibfk_3` FOREIGN KEY (`scheduleID`) REFERENCES `schedule` (`scheduleID`),
  ADD CONSTRAINT `attendance_ibfk_4` FOREIGN KEY (`learnerID`) REFERENCES `learner` (`learnerID`),
  ADD CONSTRAINT `attendance_ibfk_5` FOREIGN KEY (`sectionID`) REFERENCES `section` (`sectionID`);

--
-- Constraints for table `learner`
--
ALTER TABLE `learner`
  ADD CONSTRAINT `learner_ibfk_1` FOREIGN KEY (`adminID`) REFERENCES `admin` (`admin_ID`),
  ADD CONSTRAINT `learner_ibfk_2` FOREIGN KEY (`nfcID`) REFERENCES `nfctag` (`nfcID`),
  ADD CONSTRAINT `learner_ibfk_3` FOREIGN KEY (`sectionID`) REFERENCES `section` (`sectionID`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`teacher_ID`) REFERENCES `teacher` (`teacher_ID`),
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`adminID`) REFERENCES `admin` (`admin_ID`);

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`teacherID`) REFERENCES `teacher` (`teacher_ID`),
  ADD CONSTRAINT `schedule_ibfk_3` FOREIGN KEY (`sectionID`) REFERENCES `section` (`sectionID`);

--
-- Constraints for table `section`
--
ALTER TABLE `section`
  ADD CONSTRAINT `section_ibfk_1` FOREIGN KEY (`teacherID`) REFERENCES `teacher` (`teacher_ID`);

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`user_ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
