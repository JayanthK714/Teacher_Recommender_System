-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2023 at 05:38 PM
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
-- Database: `teacherdb`
--
CREATE DATABASE IF NOT EXISTS `teacherdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `teacherdb`;

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `InsertAchievements`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertAchievements` (IN `p_srn` VARCHAR(20), IN `p_cgpa` FLOAT, IN `p_achievement` VARCHAR(255), IN `p_achievement_date` DATE, IN `p_certification` VARCHAR(255))   BEGIN
    INSERT INTO achievements (srn, cgpa, achievement, achievement_date, certification)
    VALUES (p_srn, p_cgpa, p_achievement, p_achievement_date, p_certification);

    SELECT 'Achievement submitted successfully!' AS Message;
END$$

DROP PROCEDURE IF EXISTS `ValidateTeamCGPA`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ValidateTeamCGPA` (IN `cgpa_1` FLOAT, IN `cgpa_2` FLOAT, IN `cgpa_3` FLOAT, IN `cgpa_4` FLOAT)   BEGIN
    DECLARE high_cgpa_count INT DEFAULT 0;
    
    IF cgpa_1 > 9 THEN
        SET high_cgpa_count = high_cgpa_count + 1;
    END IF;
    
    IF cgpa_2 > 9 THEN
        SET high_cgpa_count = high_cgpa_count + 1;
    END IF;
    
    IF cgpa_3 > 9 THEN
        SET high_cgpa_count = high_cgpa_count + 1;
    END IF;
    
    IF cgpa_4 > 9 THEN
        SET high_cgpa_count = high_cgpa_count + 1;
    END IF;
    
    IF high_cgpa_count > 2 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'More than two students have CGPA above 9 in the team.';
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `achievements`
--

DROP TABLE IF EXISTS `achievements`;
CREATE TABLE IF NOT EXISTS `achievements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `SRN` varchar(20) NOT NULL,
  `CGPA` decimal(3,2) NOT NULL,
  `achievement` text DEFAULT NULL,
  `achievement_date` text DEFAULT NULL,
  `certification` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ;

--
-- RELATIONSHIPS FOR TABLE `achievements`:
--

-- --------------------------------------------------------

--
-- Table structure for table `capstone`
--

DROP TABLE IF EXISTS `capstone`;
CREATE TABLE IF NOT EXISTS `capstone` (
  `capstone_id` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` int(11) NOT NULL,
  `project_title` varchar(255) NOT NULL,
  `project_description` text NOT NULL,
  `project_requirements` text NOT NULL,
  PRIMARY KEY (`capstone_id`),
  KEY `team_id` (`team_id`)
) ;

--
-- RELATIONSHIPS FOR TABLE `capstone`:
--   `team_id`
--       `team` -> `team_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `domain`
--

DROP TABLE IF EXISTS `domain`;
CREATE TABLE IF NOT EXISTS `domain` (
  `domain_id` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` int(11) NOT NULL,
  `domain_name` varchar(255) NOT NULL,
  PRIMARY KEY (`domain_id`),
  KEY `team_id` (`team_id`)
) ;

--
-- RELATIONSHIPS FOR TABLE `domain`:
--   `team_id`
--       `team` -> `team_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `publications`
--

DROP TABLE IF EXISTS `publications`;
CREATE TABLE IF NOT EXISTS `publications` (
  `id` int(11) NOT NULL,
  `conferences` varchar(1000) NOT NULL,
  `journals` varchar(1000) NOT NULL,
  `publications` varchar(1000) NOT NULL
) ;

--
-- RELATIONSHIPS FOR TABLE `publications`:
--

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `std_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text DEFAULT NULL,
  `srn` varchar(20) NOT NULL,
  `gender` char(10) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `contact` int(11) DEFAULT NULL,
  `deptname` char(50) DEFAULT NULL,
  `semester` text DEFAULT NULL,
  `profile_picture` blob NOT NULL,
  `team_id` int(6) DEFAULT NULL,
  PRIMARY KEY (`std_id`,`srn`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `contact` (`contact`)
) ;

--
-- RELATIONSHIPS FOR TABLE `student`:
--

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

DROP TABLE IF EXISTS `teacher`;
CREATE TABLE IF NOT EXISTS `teacher` (
  `id` int(11) NOT NULL,
  `name` char(50) DEFAULT NULL,
  `image_path` blob DEFAULT NULL,
  `phone` int(15) NOT NULL,
  `teacherdept` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `campus` varchar(25) NOT NULL,
  `achievements` varchar(1000) NOT NULL,
  `Teaching` varchar(1000) NOT NULL,
  `researchinterest` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ;

--
-- RELATIONSHIPS FOR TABLE `teacher`:
--

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

DROP TABLE IF EXISTS `team`;
CREATE TABLE IF NOT EXISTS `team` (
  `team_id` int(11) NOT NULL AUTO_INCREMENT,
  `team_name` varchar(100) NOT NULL,
  `student_name_1` varchar(100) NOT NULL,
  `student_srn_1` varchar(20) NOT NULL,
  `student_dept_1` varchar(50) NOT NULL,
  `student_cgpa_1` decimal(3,2) NOT NULL,
  `student_name_2` varchar(100) NOT NULL,
  `student_srn_2` varchar(20) NOT NULL,
  `student_dept_2` varchar(50) NOT NULL,
  `student_cgpa_2` decimal(3,2) NOT NULL,
  `student_name_3` varchar(100) NOT NULL,
  `student_srn_3` varchar(20) NOT NULL,
  `student_dept_3` varchar(50) NOT NULL,
  `student_cgpa_3` decimal(3,2) NOT NULL,
  `student_name_4` varchar(100) NOT NULL,
  `student_srn_4` varchar(20) NOT NULL,
  `student_dept_4` varchar(50) NOT NULL,
  `student_cgpa_4` decimal(3,2) NOT NULL,
  PRIMARY KEY (`team_id`)
) ;

--
-- RELATIONSHIPS FOR TABLE `team`:
--

--
-- Triggers `team`
--
DROP TRIGGER IF EXISTS `prevent_multiple_teams`;
DELIMITER $$
CREATE TRIGGER `prevent_multiple_teams` BEFORE INSERT ON `team` FOR EACH ROW BEGIN
    DECLARE student_exists INT;
    DECLARE error_message VARCHAR(255);
    
    SELECT COUNT(*) INTO student_exists
    FROM team
    WHERE 
        (NEW.student_srn_1 IN (student_srn_1, student_srn_2, student_srn_3, student_srn_4)
        OR NEW.student_srn_2 IN (student_srn_1, student_srn_2, student_srn_3, student_srn_4)
        OR NEW.student_srn_3 IN (student_srn_1, student_srn_2, student_srn_3, student_srn_4)
        OR NEW.student_srn_4 IN (student_srn_1, student_srn_2, student_srn_3, student_srn_4));
    
    IF student_exists > 0 THEN
        SET error_message = CONCAT('One or more students are already part of a team.');
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = error_message;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ;

--
-- RELATIONSHIPS FOR TABLE `users`:
--

--
-- Constraints for dumped tables
--

--
-- Constraints for table `capstone`
--
ALTER TABLE `capstone`
  ADD CONSTRAINT `capstone_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `team` (`team_id`);

--
-- Constraints for table `domain`
--
ALTER TABLE `domain`
  ADD CONSTRAINT `domain_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `team` (`team_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
