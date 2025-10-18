-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 18, 2025 at 12:54 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `websitedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course_name` varchar(100) NOT NULL,
  `course_code` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

DROP TABLE IF EXISTS `notices`;
CREATE TABLE IF NOT EXISTS `notices` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `course` varchar(50) DEFAULT NULL,
  `semester` varchar(10) DEFAULT NULL,
  `year` varchar(10) DEFAULT NULL,
  `roll_number` varchar(20) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=98 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`user_id`, `full_name`, `course`, `semester`, `year`, `roll_number`, `phone_number`, `dob`, `email`) VALUES
(77, 'Rohan Mehta', 'B.Sc Zoology', '6', '2025', 'STU001', '9876543210', '2004-03-12', 'rohan.mehta@example.com'),
(78, 'Aman Verma', 'B.Sc Zoology', '6', '2024', 'STU002', '9123456780', '2003-07-19', 'aman.verma@example.com'),
(79, 'Kunal Joshi', 'B.Sc Zoology', '6', '2023', 'STU003', '9845123760', '2002-10-22', 'kunal.joshi@example.com'),
(80, 'Rahul Singh', 'B.Sc Zoology', '6', '2025', 'STU004', '9823456123', '2004-05-01', 'rahul.singh@example.com'),
(81, 'Aditya Sharma', 'B.Sc Zoology', '6', '2024', 'STU005', '9786543210', '2003-09-14', 'aditya.sharma@example.com'),
(82, 'Varun Patel', 'B.Sc Zoology', '6', '2023', 'STU006', '9871234567', '2002-12-09', 'varun.patel@example.com'),
(83, 'Siddharth Jain', 'B.Sc Zoology', '6', '2025', 'STU007', '9812345678', '2004-01-27', 'siddharth.jain@example.com'),
(84, 'Harsh Gupta', 'B.Sc Zoology', '6', '2024', 'STU008', '9988776655', '2003-08-11', 'harsh.gupta@example.com'),
(85, 'Arjun Malhotra', 'B.Sc Zoology', '6', '2023', 'STU009', '9911223344', '2002-02-15', 'arjun.malhotra@example.com'),
(86, 'Yash Tiwari', 'B.Sc Zoology', '6', '2025', 'STU010', '9845612378', '2004-06-20', 'yash.tiwari@example.com'),
(87, 'Ritik Bansal', 'B.Sc Zoology', '6', '2024', 'STU011', '9797979797', '2003-03-18', 'ritik.bansal@example.com'),
(88, 'Ayush Jain', 'B.Sc Zoology', '6', '2023', 'STU012', '9811122233', '2002-07-29', 'ayush.jain@example.com'),
(89, 'Ritesh Yadav', 'B.Sc Zoology', '6', '2025', 'STU013', '9822112233', '2004-09-05', 'ritesh.yadav@example.com'),
(90, 'Ankit Chauhan', 'B.Sc Zoology', '6', '2024', 'STU014', '9991112223', '2003-11-02', 'ankit.chauhan@example.com'),
(91, 'Sahil Kapoor', 'B.Sc Zoology', '6', '2023', 'STU015', '9873216540', '2002-04-10', 'sahil.kapoor@example.com'),
(92, 'Manav Goel', 'B.Sc Zoology', '6', '2025', 'STU016', '9812341290', '2004-08-12', 'manav.goel@example.com'),
(93, 'Raj Patel', 'B.Sc Zoology', '6', '2024', 'STU017', '9801234567', '2003-02-22', 'raj.patel@example.com'),
(94, 'Deepak Rao', 'B.Sc Zoology', '6', '2023', 'STU018', '9876001234', '2002-05-19', 'deepak.rao@example.com'),
(95, 'Laksh Khanna', 'B.Sc Zoology', '6', '2025', 'STU019', '9821456789', '2004-12-30', 'laksh.khanna@example.com'),
(96, 'Tanishq Suri', 'B.Sc Zoology', '6', '2024', 'STU020', '9998887776', '2003-06-03', 'tanishq.suri@example.com'),
(97, 'Goat', 'Zoology', '1', '1', '1', '1', '2000-01-01', '1@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
CREATE TABLE IF NOT EXISTS `teachers` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `dob` date DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','teacher','student') NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `status`) VALUES
(1, 'admin', '$2y$10$Cpx7O/Lkg53jluLKu5b8BOsyUwRsdhCRBRwueEgMasnneKa4MjG.a', 'admin', 'active'),
(80, 'STU020', '$2y$10$mGgnL9/Nf7VgtyABPQ1Y7uvEvaZtcYKe3PqGZM8ZcFF38BW59ltTC', 'student', 'active'),
(79, 'STU019', '$2y$10$/iGc51ambnYMRoM5QFQ4q.BsYB/7XPPI1sQR/0zIgIkOKF.uZgfei', 'student', 'active'),
(78, 'STU018', '$2y$10$UdTfythkD/TK4cMdZMaF.uP9wEGznN.O4wMva9kwkF/0l7Qt1UfIS', 'student', 'active'),
(77, 'STU017', '$2y$10$0KAmfTs6MWHyTL27Y4qTmeO8FtYT0BANPZGWsuRTYiIJt0Fs2n25C', 'student', 'active'),
(76, 'STU016', '$2y$10$vOVNHt9EwozhDTXyxS7XBeCek582HPiOgcYucsXgnUHDwDRqxgFce', 'student', 'active'),
(75, 'STU015', '$2y$10$1.Lpyy9xhLVldXGPxFpopOxi3cpQSbvL0KG876xzaQWnRB7W/yzwS', 'student', 'active'),
(74, 'STU014', '$2y$10$XvuItlqju6/fy2UouLNJte.XPtsBYMm73DOkGhmJzgYD.SkREhhI.', 'student', 'active'),
(73, 'STU013', '$2y$10$vQn5S9Vz.LPXgm4/Ge2Flubu5TxihM6I5vbMJ9Fs3Cw/C2r/GoYcm', 'student', 'active'),
(72, 'STU012', '$2y$10$YOGYGHAaSYEpLx3A6pG/8ul30OItBoRHAg3nG3y8rV1xGbAyqGWS6', 'student', 'active'),
(71, 'STU011', '$2y$10$El5DAky1ydxb40quhvkbE.YS3dwBDz.8gZm/geeuq2Se2fUT6giWa', 'student', 'active'),
(70, 'STU010', '$2y$10$pQSvB0uBXQE6e6VTPsGTHesajeSSK95DTxwQoreYy.yZwKaJJIy/O', 'student', 'active'),
(69, 'STU009', '$2y$10$pIEUDxiIYWbWYwR8WQeCXuaoB/IeOmpLpfDuEK1cVDZfbVBjp9JT6', 'student', 'active'),
(68, 'STU008', '$2y$10$TwPpujpCiNd/zwm1cfnv0ORivqTenPzkmYnuV4I8zlTgCCBoEpPNO', 'student', 'active'),
(67, 'STU007', '$2y$10$PqBlLalEteLGtVrHVgE6Yun/CyId/Q7ov2GL8L8miLVUT.n4st5qO', 'student', 'active'),
(65, 'STU005', '$2y$10$aNhhbka2yTKAdFsaM2xsx.xw8jHks.DZBHfaOJw4mQxpaP2OFE6TC', 'student', 'active'),
(66, 'STU006', '$2y$10$ZMkDcjRC5eWBqF9pVy9i.erz9KIX98J3sY6pVgxg/Qu9M/C/iRLQy', 'student', 'active'),
(64, 'STU004', '$2y$10$cHJitjNEG6M2TB1t/Ebl.OynGVKntrjGM0AAVXCQ06mnoYFmASJKS', 'student', 'active'),
(81, '1', '$2y$10$kFhxApPE/LuNDqdotHhWYugtkW6BfmwVX1OLsqzyqlOsMqhdE2.6W', 'student', 'active'),
(63, 'STU003', '$2y$10$9pWbjJiZRteT4.RyP/bsg.wxbGxizL7USLdkSlnysqdmfBL/1nXAC', 'student', 'active'),
(61, 'STU001', '$2y$10$8tXaFEH0FFsxSnpXP.264u62HZ/zOr/z7vs.4T/53K2hylfW3giPW', 'student', 'active'),
(62, 'STU002', '$2y$10$WONwHlT47ueR14ClDGIfOOdUH/HmHzqWTmjkeR3H3EXOutzRoIC0y', 'student', 'active');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
