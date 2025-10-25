-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 25, 2025 at 03:27 PM
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
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE IF NOT EXISTS `attendance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `date` date NOT NULL,
  `status` enum('Present','Absent') NOT NULL DEFAULT 'Present',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_attendance` (`student_id`,`teacher_id`,`date`)
) ENGINE=MyISAM AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `student_id`, `teacher_id`, `date`, `status`) VALUES
(94, 110, 14, '2025-10-25', 'Present'),
(93, 109, 14, '2025-10-25', 'Present'),
(92, 108, 14, '2025-10-25', 'Present'),
(91, 107, 14, '2025-10-25', 'Present'),
(90, 106, 14, '2025-10-25', 'Present'),
(89, 105, 14, '2025-10-25', 'Present'),
(88, 104, 14, '2025-10-25', 'Present'),
(87, 103, 14, '2025-10-25', 'Present'),
(86, 102, 14, '2025-10-25', 'Present'),
(85, 101, 14, '2025-10-25', 'Present'),
(84, 106, 14, '2025-10-21', 'Absent'),
(83, 106, 14, '2025-10-22', 'Present');

-- --------------------------------------------------------

--
-- Table structure for table `bsc_courses`
--

DROP TABLE IF EXISTS `bsc_courses`;
CREATE TABLE IF NOT EXISTS `bsc_courses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class` varchar(100) NOT NULL,
  `papers` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bsc_courses`
--

INSERT INTO `bsc_courses` (`id`, `class`, `papers`) VALUES
(16, 'B. Sc. Part I', 'Paper I : Cell biology and Non chordata\r\nPaper II : Chordata and Embryology\r\nPractical :'),
(18, 'B. Sc. Part III', 'Paper I : Ecology, Environmental Biology, Toxicology, Microbiology and Medical Zoology\r\nPaper II : Genetics, Cell Physiology, Biochemistry, Biotechnology and Biotechniques\r\nPractical :'),
(17, 'B. Sc. Part II', 'Paper I : Anatomy and Physiology\r\nPaper II : Vertebrate Endocrinology, Reproductive Biology, Behaviour, Evolution and Applied Zoology\r\nPractical :');

-- --------------------------------------------------------

--
-- Table structure for table `contact_info`
--

DROP TABLE IF EXISTS `contact_info`;
CREATE TABLE IF NOT EXISTS `contact_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contact_info`
--

INSERT INTO `contact_info` (`id`, `email`, `phone`) VALUES
(1, 'hod@college.edu', '(123) 456-7890');

-- --------------------------------------------------------

--
-- Table structure for table `internal_marks`
--

DROP TABLE IF EXISTS `internal_marks`;
CREATE TABLE IF NOT EXISTS `internal_marks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course_type` varchar(10) DEFAULT NULL,
  `marks_info` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `course_type` (`course_type`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `internal_marks`
--

INSERT INTO `internal_marks` (`id`, `course_type`, `marks_info`) VALUES
(1, 'bsc', '15'),
(2, 'msc', '10+10');

-- --------------------------------------------------------

--
-- Table structure for table `msc_courses`
--

DROP TABLE IF EXISTS `msc_courses`;
CREATE TABLE IF NOT EXISTS `msc_courses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class` varchar(100) NOT NULL,
  `papers` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `msc_courses`
--

INSERT INTO `msc_courses` (`id`, `class`, `papers`) VALUES
(43, 'M. Sc. Semester IV', 'Paper I : General physiology and neurophysiology (compulsory)\r\nPaper II : Biochemistry and metabolic regulation and cell function (compulsory)\r\nPaper III : Fish (Ichthyology) structure and function (optional group I)\r\nPaper IV : Applied fisheries (optional group I)\r\nLab course I :\r\nLab course II :'),
(42, 'M. Sc. Semester III', 'Paper I : Comparative anatomy of vertebrates\r\nPaper II : Biosystematics, taxonomy and biodiversity\r\nPaper III : Immunology and developmental biology\r\nPaper IV : Population genetics and evolution\r\nLab course I :\r\nLab course II :'),
(40, 'M. Sc. Semester I', 'Paper I : Invertebrate structure and function, Minor phyla\r\nPaper II : Animal Behaviour\r\nPaper III : Quantitative Biology\r\nPaper IV : Ecology and Environmental Physiology\r\nLab course I :\r\nLab course II :'),
(41, 'M. Sc. Semester II', 'Paper I : General and Comparative endocrinology of vertebrates\r\nPaper II : Gamete biology and reproductive physiology in human beings\r\nPaper III : Molecular cell biology\r\nPaper IV : Tools and techniques for biology\r\nLab course I :\r\nLab course II :');

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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`id`, `title`, `file_path`, `date`) VALUES
(7, 'j', 'uploads/notices/1760866973_croco.jpg', '2025-10-19 15:12:53'),
(8, 'you you you you you', 'uploads/notices/1761046240_croco.jpg', '2025-10-21 17:00:40');

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

DROP TABLE IF EXISTS `resources`;
CREATE TABLE IF NOT EXISTS `resources` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `type` enum('file','link') NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `uploaded_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`id`, `title`, `type`, `file_path`, `link_url`, `date`, `uploaded_by`) VALUES
(3, 'link', 'link', NULL, 'https://zoologymv.kesug.com/', '2025-10-19', NULL),
(2, 'file', 'file', 'uploads/resources/1760893269_batman.jpg', NULL, '2025-10-19', NULL),
(7, 'this is just for test', 'file', 'uploads/resources/1761031697_batman.jpg', NULL, '2025-10-21', NULL),
(8, 'you you you you you you you you you you you you', 'file', 'uploads/resources/1761032165_batman.jpg', NULL, '2025-10-21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `user_id` int NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `course` varchar(50) NOT NULL,
  `semester` int NOT NULL,
  `dob` date NOT NULL,
  `year` varchar(10) DEFAULT NULL,
  `snp_id` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `snp_id` (`snp_id`),
  UNIQUE KEY `snp_id_2` (`snp_id`)
) ENGINE=MyISAM AUTO_INCREMENT=160 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`user_id`, `full_name`, `course`, `semester`, `dob`, `year`, `snp_id`, `email`, `phone_number`) VALUES
(101, 'Jane Smith', 'B.sc', 2, '2003-09-25', '2021-22', 'SNP1002', 'jane2@example.com', '9876543202'),
(102, 'Mark Johnson', 'B.sc', 2, '2002-12-05', '2021-22', 'SNP1003', 'mark3@example.com', '9876543203'),
(103, 'Emily Davis', 'B.sc', 4, '2002-03-18', '2021-22', 'SNP1004', 'emily4@example.com', '9876543204'),
(104, 'Liam Brown', 'B.sc', 5, '2001-07-22', '2021-22', 'SNP1005', 'liam5@example.com', '9876543205'),
(105, 'Olivia Wilson', 'B.sc', 6, '2001-11-10', '2021-22', 'SNP1006', 'olivia6@example.com', '9876543206'),
(106, 'Ethan Harris', 'B.sc', 1, '2003-02-18', '2021-22', 'SNP1007', 'ethan7@example.com', '9876543207'),
(107, 'Mia Clark', 'B.sc', 2, '2003-11-10', '2021-22', 'SNP1008', 'mia8@example.com', '9876543208'),
(108, 'Alexander Lewis', 'B.sc', 3, '2002-05-23', '2021-22', 'SNP1009', 'alex9@example.com', '9876543209'),
(109, 'Charlotte Walker', 'B.sc', 4, '2002-08-12', '2021-22', 'SNP1010', 'charlotte10@example.com', '9876543210'),
(110, 'Daniel Hall', 'B.sc', 5, '2001-03-15', '2021-22', 'SNP1011', 'daniel11@example.com', '9876543211'),
(111, 'Amelia Allen', 'B.sc', 6, '2001-09-19', '2021-22', 'SNP1012', 'amelia12@example.com', '9876543212'),
(112, 'Matthew Young', 'B.sc', 1, '2003-06-30', '2021-22', 'SNP1013', 'matthew13@example.com', '9876543213'),
(113, 'Sofia King', 'B.sc', 2, '2003-01-22', '2021-22', 'SNP1014', 'sofia14@example.com', '9876543214'),
(114, 'Joseph Wright', 'B.sc', 3, '2002-10-05', '2021-22', 'SNP1015', 'joseph15@example.com', '9876543215'),
(115, 'Isabella Scott', 'B.sc', 4, '2002-04-28', '2021-22', 'SNP1016', 'isabella16@example.com', '9876543216'),
(116, 'David Green', 'B.sc', 5, '2001-12-15', '2021-22', 'SNP1017', 'david17@example.com', '9876543217'),
(117, 'Mia Baker', 'B.sc', 6, '2001-07-21', '2021-22', 'SNP1018', 'mia18@example.com', '9876543218'),
(118, 'James Adams', 'B.sc', 1, '2003-03-14', '2021-22', 'SNP1019', 'james19@example.com', '9876543219'),
(119, 'Ava Nelson', 'B.sc', 2, '2003-08-09', '2021-22', 'SNP1020', 'ava20@example.com', '9876543220'),
(120, 'Benjamin Carter', 'B.sc', 3, '2002-11-30', '2021-22', 'SNP1021', 'ben21@example.com', '9876543221'),
(121, 'Ella Mitchell', 'B.sc', 4, '2002-06-12', '2021-22', 'SNP1022', 'ella22@example.com', '9876543222'),
(122, 'Logan Perez', 'B.sc', 5, '2001-05-25', '2021-22', 'SNP1023', 'logan23@example.com', '9876543223'),
(123, 'Harper Roberts', 'B.sc', 6, '2001-09-18', '2021-22', 'SNP1024', 'harper24@example.com', '9876543224'),
(124, 'Noah Taylor', 'M.sc', 1, '2004-01-15', '2023-24', 'SNP2001', 'noah1@example.com', '9876543225'),
(125, 'Ava Thomas', 'M.sc', 2, '2004-04-09', '2023-24', 'SNP2002', 'ava2@example.com', '9876543226'),
(126, 'William Moore', 'M.sc', 3, '2003-08-30', '2023-24', 'SNP2003', 'william3@example.com', '9876543227'),
(127, 'Sophia Martin', 'M.sc', 4, '2003-12-12', '2023-24', 'SNP2004', 'sophia4@example.com', '9876543228'),
(128, 'James Lee', 'M.sc', 5, '2002-06-05', '2023-24', 'SNP2005', 'james5@example.com', '9876543229'),
(129, 'Isabella White', 'M.sc', 6, '2002-09-20', '2023-24', 'SNP2006', 'isabella6@example.com', '9876543230'),
(130, 'Michael Young', 'M.sc', 1, '2004-06-30', '2023-24', 'SNP2007', 'michael7@example.com', '9876543231'),
(131, 'Harper King', 'M.sc', 2, '2004-03-22', '2023-24', 'SNP2008', 'harper8@example.com', '9876543232'),
(132, 'Benjamin Wright', 'M.sc', 3, '2003-10-05', '2023-24', 'SNP2009', 'benjamin9@example.com', '9876543233'),
(133, 'Evelyn Scott', 'M.sc', 4, '2003-01-28', '2023-24', 'SNP2010', 'evelyn10@example.com', '9876543234'),
(134, 'Logan Green', 'M.sc', 5, '2002-12-15', '2023-24', 'SNP2011', 'logan11@example.com', '9876543235'),
(135, 'Ella Baker', 'M.sc', 6, '2002-07-21', '2023-24', 'SNP2012', 'ella12@example.com', '9876543236'),
(136, 'Liam Adams', 'M.sc', 1, '2004-02-18', '2023-24', 'SNP2013', 'liam13@example.com', '9876543237'),
(137, 'Charlotte Nelson', 'M.sc', 2, '2004-11-10', '2023-24', 'SNP2014', 'charlotte14@example.com', '9876543238'),
(138, 'Alexander Carter', 'M.sc', 3, '2003-05-23', '2023-24', 'SNP2015', 'alex15@example.com', '9876543239'),
(139, 'Mia Mitchell', 'M.sc', 4, '2003-08-12', '2023-24', 'SNP2016', 'mia16@example.com', '9876543240'),
(140, 'Matthew Perez', 'M.sc', 5, '2002-03-15', '2023-24', 'SNP2017', 'matthew17@example.com', '9876543241'),
(141, 'Sofia Roberts', 'M.sc', 6, '2002-09-19', '2023-24', 'SNP2018', 'sofia18@example.com', '9876543242'),
(142, 'Joseph Adams', 'M.sc', 1, '2004-06-30', '2023-24', 'SNP2019', 'joseph19@example.com', '9876543243'),
(143, 'Isabella Nelson', 'M.sc', 2, '2004-01-22', '2023-24', 'SNP2020', 'isabella20@example.com', '9876543244'),
(144, 'David Carter', 'M.sc', 3, '2003-10-05', '2023-24', 'SNP2021', 'david21@example.com', '9876543245'),
(145, 'Mia Mitchell', 'M.sc', 4, '2003-04-28', '2023-24', 'SNP2022', 'mia22@example.com', '9876543246'),
(146, 'James Green', 'M.sc', 5, '2002-12-15', '2023-24', 'SNP2023', 'james23@example.com', '9876543247'),
(147, 'Ava Baker', 'M.sc', 6, '2002-07-21', '2023-24', 'SNP2024', 'ava24@example.com', '9876543248'),
(148, 'John Scott', 'B.sc', 1, '2003-05-12', '2021-22', 'SNP1025', 'john25@example.com', '9876543249'),
(149, 'Jane Thomas', 'B.sc', 2, '2003-09-25', '2021-22', 'SNP1026', 'jane26@example.com', '9876543250'),
(150, 'Mark Harris', 'B.sc', 3, '2002-12-05', '2021-22', 'SNP1027', 'mark27@example.com', '9876543251'),
(151, 'Emily Lewis', 'B.sc', 4, '2002-03-18', '2021-22', 'SNP1028', 'emily28@example.com', '9876543252'),
(152, 'Liam Walker', 'B.sc', 5, '2001-07-22', '2021-22', 'SNP1029', 'liam29@example.com', '9876543253'),
(153, 'Olivia Hall', 'B.sc', 6, '2001-11-10', '2021-22', 'SNP1030', 'olivia30@example.com', '9876543254'),
(154, 'Ethan Allen', 'B.sc', 1, '2003-02-18', '2021-22', 'SNP1031', 'ethan31@example.com', '9876543255'),
(155, 'Mia Young', 'B.sc', 2, '2003-11-10', '2021-22', 'SNP1032', 'mia32@example.com', '9876543256'),
(156, 'Alexander King', 'B.sc', 3, '2002-05-23', '2021-22', 'SNP1033', 'alex33@example.com', '9876543257'),
(157, 'Charlotte Wright', 'B.sc', 4, '2002-08-12', '2021-22', 'SNP1034', 'charlotte34@example.com', '9876543258'),
(158, 'Daniel Scott', 'B.sc', 5, '2001-03-15', '2021-22', 'SNP1035', 'daniel35@example.com', '9876543259');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
CREATE TABLE IF NOT EXISTS `teachers` (
  `user_id` int NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `date_joined` date DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`user_id`, `full_name`, `dob`, `email`, `phone_number`, `qualification`, `date_joined`, `image_path`) VALUES
(11, 'Batman', '1970-02-19', 'Batman@gmail.com', '8888888888', 'Ph.D', '1939-03-13', 'uploads/teachers/teacher_68f45348e716b.jpg'),
(12, 'BlackCat', '2000-01-01', 'blackcat@gmail.com', '6999999999', 'Ph.D', '2005-01-01', 'uploads/teachers/teacher_68f453b5e0cc2.png'),
(13, 'Spiderman', '1962-08-10', 'Peterparker@gmail.com', '0000000000', 'Ph.D', '1962-08-10', 'uploads/teachers/teacher_68f46514756e2.jpg'),
(14, 'kkkkk', '2000-11-11', '1@gmail.com', '1', 'Ph.D, gg', '1111-11-11', NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=160 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `status`) VALUES
(1, 'admin', '$2y$10$Cpx7O/Lkg53jluLKu5b8BOsyUwRsdhCRBRwueEgMasnneKa4MjG.a', 'admin', 'active'),
(85, 'blackcat@gmail.com', '$2y$10$XM953iuVvsGtP7fPG5D6VO0/YoDgfTsBdjsVYoejG5.FwYTFswULa', 'teacher', 'active'),
(122, 'SNP1023', '$2y$10$WyvSHm1sew.n84fFBLVLKOQZwSdbQddpnzmI2lH57IAQLpf2H8wv.', 'student', 'active'),
(121, 'SNP1022', '$2y$10$qgE5Hk/NOUs1nK4NZxmb3uZiPYnlKjZB9AsCSoHQTi5VWSXA2lFca', 'student', 'active'),
(120, 'SNP1021', '$2y$10$5seUxGCHaA9VEFsLu2nd2ejUx7GXoUWFHY6xlEoGcC2V1ameb03nm', 'student', 'active'),
(119, 'SNP1020', '$2y$10$vCmCD9qJ6KKm14PySzgwo.cOna26cr/wfyD4OCcvc7o36pfH8xn9.', 'student', 'active'),
(118, 'SNP1019', '$2y$10$PpwUvp8SpS3IGycwlmdXP.XwYzVmKnTPVe31rcPWZdwZQMB7.IyXu', 'student', 'active'),
(117, 'SNP1018', '$2y$10$Ptc0AWWIxOT5GCNn/cieOOu6ztwVE34aORcNQrMBPixFUkGc9upEW', 'student', 'active'),
(116, 'SNP1017', '$2y$10$FGIEXXnnkX8l5aG6UyRXru.aFFsRICeIpZMN/Cv1O6dZxrZ5e6P/C', 'student', 'active'),
(115, 'SNP1016', '$2y$10$5kqvcyF7Z7npuwSiyMd1kuiU9FQWTKKPyEHoKz4202eXynwSSSR1e', 'student', 'active'),
(114, 'SNP1015', '$2y$10$FbU/z4GRs5p4aeJVAeQT.uEKKbuXbT0Jn1qxw0ncrKTrOr58Mtr2u', 'student', 'active'),
(113, 'SNP1014', '$2y$10$xgz14Fhi97oUqVyI0us30Ov3hQmkLWbo1pJL17iSz.8.2T7AOC7Qi', 'student', 'active'),
(112, 'SNP1013', '$2y$10$IZJLCdHrWvOt3vcdjfu0suON/xBD6W99pqJPXZms8Kn3oZCb0e1P2', 'student', 'active'),
(111, 'SNP1012', '$2y$10$66I4Pa/zzIQ3mCek/PfTyeRLjUX/HcXa9u1i7PWhzKZyjSYE3pCf6', 'student', 'active'),
(110, 'SNP1011', '$2y$10$cHavPrcYBkAHxNRCX8ABeuernyEwaBMd8uY9zm6oFO9Dk2guJ/9Y6', 'student', 'active'),
(108, 'SNP1009', '$2y$10$64uUUe01amAfleOITEO0T.p51BA2ZKTTrJ3lzeWjg6/zzeHnEL8tK', 'student', 'active'),
(109, 'SNP1010', '$2y$10$C7pmqmpdKL3FcC4eDTkf..CPX9f6UHMTZ4EnZs.FURsS5XmgrlVyq', 'student', 'active'),
(101, 'SNP1002', '$2y$10$Bg.7s9jiHtn54zZJ5XrRFeF6ltIAKdSEXtKSNhWnMVNLzbALq57eW', 'student', 'active'),
(102, 'SNP1003', '$2y$10$Qyj/WA0gKmsPvvBZ6eSlrOlPv/Dhd11ziOcqxtTR4DyQT/HZymGOq', 'student', 'active'),
(103, 'SNP1004', '$2y$10$RQBKT2MrmdZ09hKIp1rhB.IRxTEj1zDc3kU3mlYo4CQVzRf.9WZg.', 'student', 'active'),
(104, 'SNP1005', '$2y$10$AtStkbjvpdbiaIff3NlnrOroeSKtQVZ.zbzI/3EoH5SA5qPkY1WJG', 'student', 'active'),
(84, 'Batman@gmail.com', '$2y$10$u7Jp.8MGNJeIpvOSgrVM9eKO6MkeoAvYp6n23xWT/JRcsfRdZ5HgW', 'teacher', 'active'),
(86, 'Peterparker@gmail.com', '$2y$10$pXdJDwzfCezTBd5qs08cEeL8bGJKCGGALF4uIoViQWmjlwDJvvJx.', 'teacher', 'active'),
(106, 'SNP1007', '$2y$10$uTXgzZASkPEG9TwLwUj2wOIT/4Dj1pSO11okSukumTZ2pM02iPiAC', 'student', 'active'),
(14, '1@gmail.com', '$2y$10$U3qNeYy2yBiROBNEPc7.6exig3BWrqoiJF8Zs2qwAScDnHWVLtILm', 'teacher', 'active'),
(107, 'SNP1008', '$2y$10$vKBZmnK.uhYbQSb11lYW3OcHv..acifzPQX2s3jNixS1qHaLRUACi', 'student', 'active'),
(105, 'SNP1006', '$2y$10$P.2d4HlLZobZISshzM1WmePW9GHpliHLusvVIDIj5BjETDr3WvgbW', 'student', 'active'),
(123, 'SNP1024', '$2y$10$Sji9qwUM6D.RGAholHoSXO5SDlS62CJuv0eO1qEtMowN3p5ANCZ9a', 'student', 'active'),
(124, 'SNP2001', '$2y$10$maEjXmFHPTeBWsDmWr33zedEZ8jdwaZdGR6XVYEJ2Gi7L0RTMb/ge', 'student', 'active'),
(125, 'SNP2002', '$2y$10$Z83LwIkMNokv8oPl83BWP.txLm20WULnJHYsUOAsfWQyLYPtfCuMm', 'student', 'active'),
(126, 'SNP2003', '$2y$10$KLVzVXxoz02rJgjIdOUqZe6SduvzDNfFtRlzGVG7tQMAbXPzgG27q', 'student', 'active'),
(127, 'SNP2004', '$2y$10$wiw.nlQCUC.8walulowdd.Z91jTmypeLHhmdW0/Opjj/Uea4Nta3.', 'student', 'active'),
(128, 'SNP2005', '$2y$10$r1vfV5tE3nCLGSUV//sqo.Tp066F3uCAzolhdCZiEMKf0PKJOcaGC', 'student', 'active'),
(129, 'SNP2006', '$2y$10$gWiAts4mT4GPKtI45b/c5eUTLHeF55Pwmlcuq8yq6uv.8xKEdp.kC', 'student', 'active'),
(130, 'SNP2007', '$2y$10$UuXbbVnN1y1F.T2FP0kUwuHDUReOhshyXEECloXq.1yjQg6ThQKdu', 'student', 'active'),
(131, 'SNP2008', '$2y$10$d7F1Y2JS9X5br20ZpTho2uACKLnofwt/ugLhs1FqX4d/RoMNFjH0.', 'student', 'active'),
(132, 'SNP2009', '$2y$10$GrpI9scFPLYHuxjGhS2/TO1bcD3TX8IdaXJXsT6P.wJ4X0TRDLbBC', 'student', 'active'),
(133, 'SNP2010', '$2y$10$Wjm.Oa7RSz533Z.DvKHjCOEgW7H2rxKE6IRyJ.6iEfNKYNvRwaDhO', 'student', 'active'),
(134, 'SNP2011', '$2y$10$fI5BnAM4p38cpi.XjrvnQuV7xcdPw3h/Fa1hboFYmwd6BE7/jPr1K', 'student', 'active'),
(135, 'SNP2012', '$2y$10$Mlsf96/1HZuCdb0SH.zrzu/vGvHcnqXT3Ft56KH74dqFT9NE8pr2O', 'student', 'active'),
(136, 'SNP2013', '$2y$10$ZF/nK2drZ/6wyIdE1Ici.uYinY.eu.h8x44arOGJxvhW8bnMRGqEK', 'student', 'active'),
(137, 'SNP2014', '$2y$10$NUOAD3gIuYmZKJTXnh/WnewHTnNmkyuHFE0YNj4R/HZEZtUVCKpqG', 'student', 'active'),
(138, 'SNP2015', '$2y$10$xQqo.uk..uwvoi9zASAW/.0DPhRNasCacIoDqaaZ.0SbK4yKZB/v6', 'student', 'active'),
(139, 'SNP2016', '$2y$10$DDnWtAAaVuvWQioT7sF5duawWdAThZbpfX8fvS0h1sypwB4Y/K3cy', 'student', 'active'),
(140, 'SNP2017', '$2y$10$/9I1T.LNgaaMtZsoNYTMHO8Jk4gOQ6w9YlN18Uj0B5pvej4Q5cxwm', 'student', 'active'),
(141, 'SNP2018', '$2y$10$iIeVpTFcYIQkLrW4C5Y/L.BzNWWEukUEft8p658sQZKNZzbfSyfmG', 'student', 'active'),
(142, 'SNP2019', '$2y$10$ZwpC/fjKownznlxET.YUkudmbB5XIELkk3gGvnahcXSJ3ZwZzIaEW', 'student', 'active'),
(143, 'SNP2020', '$2y$10$lcIwu3/qBjt7qCS7Tctogeh6ne8Hrtsm8Vz1yhl1zpPhyKjK3T3zO', 'student', 'active'),
(144, 'SNP2021', '$2y$10$QaJt74JQ8Ptq47s0jek6V.d20QvaCgApb302vPZ4Vv12ea3XrWHAK', 'student', 'active'),
(145, 'SNP2022', '$2y$10$W9d2P6N2t1NMUxxxddXl2OtMFljp4voj7wfUKU/9sHUu1d3OklyIq', 'student', 'active'),
(146, 'SNP2023', '$2y$10$YrovxtJwlksz83IGWlDXResAxtOPc9CmRIlt2nE5riK82eUti/Lti', 'student', 'active'),
(147, 'SNP2024', '$2y$10$1H10pg/SmPB2ZOrg9p6aeen4zE5nqnOYzYXQDjjzCYhe/tDdXaK7S', 'student', 'active'),
(148, 'SNP1025', '$2y$10$pVCUL/R2V5LMMqJBYqaihOSqBWMbcrRtezRdvrHorZmxT2o2.KsR.', 'student', 'active'),
(149, 'SNP1026', '$2y$10$k6HMlSwGD5ymey77UpWpy.GirkG3KYrSvb8Y8o37HsZriQwdXObf6', 'student', 'active'),
(150, 'SNP1027', '$2y$10$RURkqNrSj9doStltXsUPvu2gMEzoxKo5eANm3oHg0cZT66Gt6bhXO', 'student', 'active'),
(151, 'SNP1028', '$2y$10$oupdDvwbhMVJ9m.eCdrAH.s8lUJgX.ZxO7VyYW0vvB1Bewx/2QbLu', 'student', 'active'),
(152, 'SNP1029', '$2y$10$oIuBUQIQ3VYUXVzwq.zOTuZTnK.1hSdB3L5tb/rBrWCmr2VswnrBq', 'student', 'active'),
(153, 'SNP1030', '$2y$10$yuCnWREj9P/L0ds6qTrfhObr66darFb5KZ9Aaid5yWGplsgdFi4Bq', 'student', 'active'),
(154, 'SNP1031', '$2y$10$3kcWHbnVTE0/0sFRQGz/a.lL4sd61NKrVFmj1bH8TSTlDQc8HZ0XC', 'student', 'active'),
(155, 'SNP1032', '$2y$10$AZPy1W3N6gq/hxbyQkyArOCDdSbTHJVprJTOAy4/Bra0xqmpkU4Ny', 'student', 'active'),
(156, 'SNP1033', '$2y$10$6G7AepYM5X805GRYYIQw3uhLhdpmIEa.zC0m0V/EG/IkMhX7SSAeC', 'student', 'active'),
(157, 'SNP1034', '$2y$10$ksaiJsxni/xuJR1An3j0A.KQT5pFaXeSg5756tALy.IOHrrQbfZYC', 'student', 'active'),
(158, 'SNP1035', '$2y$10$zw32qwWMkjMNsTafc1rCpeLBq.HQYn68NiNdXERIypYtQ.d5NlHZW', 'student', 'active');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
