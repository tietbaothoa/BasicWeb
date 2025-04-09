-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2025 at 04:08 AM
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
-- Database: `challenge5a`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `upload_date` datetime DEFAULT NULL,
  `teacher_username` varchar(50) DEFAULT NULL,
  `file_size` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `title`, `description`, `file_path`, `upload_date`, `teacher_username`, `file_size`) VALUES
(3, 'docx', '123', 'uploads/1744119233_N01-23-He-thong-quan-ly-khach-hang-va-hoa-don-tien-dien-pha-yeu-cau (1).docx', '2025-04-08 15:33:53', 'teacher1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exercises`
--

CREATE TABLE `exercises` (
  `id` int(11) NOT NULL,
  `sendername` varchar(100) DEFAULT NULL,
  `receivername` varchar(100) DEFAULT NULL,
  `message` text NOT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sendername` varchar(100) NOT NULL,
  `receivername` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sendername`, `receivername`, `message`, `created_at`) VALUES
(2, 'teacher1', '', 'hehe', '2025-04-08 23:46:17');

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `student_username` varchar(100) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `upload_date` datetime NOT NULL,
  `filename` varchar(100) DEFAULT NULL,
  `filesize` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (`id`, `task_id`, `student_username`, `file_path`, `upload_date`, `filename`, `filesize`) VALUES
(3, 3, 'student2', 'uploads/1744121107_Đề tài bài tập lớn Python.pdf', '2025-04-08 16:05:07', '1744121107_Đề tài bài tập lớn Python.pdf', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phonenumber` varchar(20) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role` enum('teacher','student') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `fullname`, `email`, `phonenumber`, `avatar`, `role`) VALUES
('student1', '$2y$10$3AdnBzLpAT.S75Urb8Msf.nHUu9SA1/MEOAmwOFlzXLXr879fC8mG', 'Sinh viên 1', 'sv1@gmail.com', '0987654444', NULL, 'student'),
('student2', '$2y$10$3AdnBzLpAT.S75Urb8Msf.nHUu9SA1/MEOAmwOFlzXLXr879fC8mG', 'Sinh viên 2', 'sv2@gmail.com', '0987654324', NULL, 'student'),
('teacher1', '$2y$10$x2woysa5zsyvUcvlbCIePeyte6tebFx8rjvxsZ4u3ggR8Eubc9muC', 'Giáo viên 1', 'gv1@gmail.com', '0987654321', NULL, 'teacher'),
('teacher2', '$2y$10$rpheNbX8xnJ3bKz2wl5oiOSB.dZuegEYgm8ib8XSYKS.Xw3bisqWa', 'Giáo viên 2', 'gv2@gmail.com', '0987654322', NULL, 'teacher');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exercises`
--
ALTER TABLE `exercises`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `exercises`
--
ALTER TABLE `exercises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
