-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2023 at 06:57 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `to_do_list`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_img` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`, `category_img`) VALUES
(1, 'general', 'default.jpg'),
(2, 'study', 'default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `collaborator`
--

CREATE TABLE `collaborator` (
  `id` int(5) NOT NULL,
  `task_id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `team` int(5) NOT NULL,
  `team_name` varchar(100) NOT NULL,
  `collab_role` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `collaborator`
--

INSERT INTO `collaborator` (`id`, `task_id`, `user_id`, `team`, `team_name`, `collab_role`) VALUES
(28, 130, 7, 63, 'blaze team', 'co_owner'),
(29, 130, 6, 63, 'blaze team', 'owner'),
(36, 133, 7, 63, 'buzzer', 'co_owner'),
(37, 133, 8, 63, 'buzzer', 'co_owner'),
(38, 133, 6, 63, 'buzzer', 'owner');

-- --------------------------------------------------------

--
-- Table structure for table `pet`
--

CREATE TABLE `pet` (
  `id` int(11) NOT NULL,
  `pet_name` varchar(100) NOT NULL,
  `demo_img` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pet`
--

INSERT INTO `pet` (`id`, `pet_name`, `demo_img`) VALUES
(1, 'axolotl', 'Axo.png'),
(2, 'golem', 'Golem.png');

-- --------------------------------------------------------

--
-- Table structure for table `pet_phase`
--

CREATE TABLE `pet_phase` (
  `id` int(5) NOT NULL,
  `pet_id` int(5) NOT NULL,
  `exp_minimum` int(10) NOT NULL,
  `exp_maximum` int(10) NOT NULL,
  `img` varchar(100) NOT NULL,
  `phase` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pet_phase`
--

INSERT INTO `pet_phase` (`id`, `pet_id`, `exp_minimum`, `exp_maximum`, `img`, `phase`) VALUES
(1, 1, 0, 49, 'Axo=Egg.png', 'egg'),
(2, 1, 50, 99, 'Axo=Baby.png', 'baby'),
(3, 1, 100, 199, 'Axo=Kid.png', 'kid'),
(4, 1, 200, 499, 'Axo=Mature.png', 'mature'),
(5, 1, 500, 1000, 'Axo=Legend.png', 'legend'),
(6, 2, 0, 49, 'Golem=Egg.png', 'egg'),
(7, 2, 50, 99, 'Golem=Baby.png', 'baby'),
(8, 2, 100, 199, 'Golem=Kid.png', 'kid'),
(9, 2, 200, 499, 'Golem=Mature.png', 'mature'),
(10, 2, 500, 1000, 'Golem=Legend.png', 'legend');

-- --------------------------------------------------------

--
-- Table structure for table `reminder`
--

CREATE TABLE `reminder` (
  `id` int(11) NOT NULL,
  `reminder_date` date NOT NULL,
  `reminder_time` time NOT NULL,
  `task_id` int(5) NOT NULL,
  `ringtone_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ringtone`
--

CREATE TABLE `ringtone` (
  `id` int(11) NOT NULL,
  `ringtone_name` varchar(100) NOT NULL,
  `ringtone_file` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ringtone`
--

INSERT INTO `ringtone` (`id`, `ringtone_name`, `ringtone_file`) VALUES
(1, 'alarm 1', 'iphone_14.mp3'),
(2, 'alarm 2', 'finally.mp3');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `task_date` date NOT NULL,
  `task_time` time NOT NULL,
  `task_desc` varchar(255) NOT NULL,
  `priority_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `team` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `task_name`, `task_date`, `task_time`, `task_desc`, `priority_id`, `user_id`, `category_id`, `status_id`, `team`) VALUES
(107, 'burukrupaa', '2023-07-21', '22:22:00', 'a', 1, 6, 1, 3, 0),
(109, 'a', '2023-07-21', '22:02:00', 'a', 1, 7, 1, 3, 0),
(110, 'tes collab', '2023-07-21', '22:22:00', 'haah', 1, 6, 2, 3, 0),
(111, 'tes collab', '2023-07-21', '22:22:00', 'haah', 1, 7, 2, 3, 0),
(112, 'tes collab', '2023-07-21', '22:22:00', 'a', 2, 6, 1, 2, 0),
(113, 'tes collab', '2023-07-21', '22:22:00', 'a', 2, 7, 1, 3, 0),
(114, 'tes collab 2', '2023-07-21', '07:35:00', 'tes', 1, 6, 1, 3, 0),
(115, 'tes collab 2', '2023-07-21', '07:35:00', 'tes', 1, 7, 1, 3, 0),
(116, 'tes collab lagi', '2023-07-31', '08:00:00', 'kerja', 1, 6, 1, 1, 0),
(117, 'collab euy', '2023-08-02', '07:00:00', 'a', 1, 6, 1, 1, 0),
(118, 'collab again', '2023-08-05', '08:08:00', 'a', 1, 6, 1, 1, 0),
(119, 'tes collab', '2023-08-02', '08:00:00', 'a', 1, 6, 1, 1, 0),
(125, 'tes lagi huhu', '2023-08-03', '22:22:00', 'a', 2, 6, 1, 1, 0),
(126, 'ts lagi tes lagi', '2023-08-05', '22:22:00', 'aaabc', 1, 6, 1, 1, 0),
(130, 'tes collab', '2023-08-05', '22:22:00', 'mantab', 1, 6, 1, 1, 63),
(133, 'huha', '2023-08-05', '22:22:00', 'abcdef', 1, 6, 1, 1, 63);

-- --------------------------------------------------------

--
-- Table structure for table `tbpriority`
--

CREATE TABLE `tbpriority` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `priority_score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbpriority`
--

INSERT INTO `tbpriority` (`id`, `title`, `priority_score`) VALUES
(1, 'high', 15),
(2, 'normal', 10),
(3, 'low', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbstatus`
--

CREATE TABLE `tbstatus` (
  `id` int(11) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbstatus`
--

INSERT INTO `tbstatus` (`id`, `status`) VALUES
(1, 'active'),
(2, 'done'),
(3, 'expired');

-- --------------------------------------------------------

--
-- Table structure for table `tbuser`
--

CREATE TABLE `tbuser` (
  `id` int(11) NOT NULL,
  `img` varchar(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `user_exp` int(100) NOT NULL,
  `status` enum('user','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbuser`
--

INSERT INTO `tbuser` (`id`, `img`, `username`, `fullname`, `email`, `user_password`, `pet_id`, `user_exp`, `status`) VALUES
(6, 'spidey.png', 'hazel', 'HazelD', 'hazel.dixon@itbss.ac.id', '202cb962ac59075b964b07152d234b70', 1, 60, 'user'),
(7, 'default.jpg', 'dixon', 'dixonH', 'hazel.dixon@itbss.ac.id', '289dff07669d7a23de0ef88d2f7129e7', 1, 160, 'user'),
(8, 'default.jpg', 'hd', 'hd', 'hazel.dixon@itbss.ac.id', '698d51a19d8a121ce581499d7b701668', 1, 160, 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collaborator`
--
ALTER TABLE `collaborator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pet`
--
ALTER TABLE `pet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pet_phase`
--
ALTER TABLE `pet_phase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pet_id` (`pet_id`);

--
-- Indexes for table `reminder`
--
ALTER TABLE `reminder`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `ringtone_id` (`ringtone_id`);

--
-- Indexes for table `ringtone`
--
ALTER TABLE `ringtone`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `priority_id` (`priority_id`);

--
-- Indexes for table `tbpriority`
--
ALTER TABLE `tbpriority`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbstatus`
--
ALTER TABLE `tbstatus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbuser`
--
ALTER TABLE `tbuser`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pet_id` (`pet_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `collaborator`
--
ALTER TABLE `collaborator`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `pet`
--
ALTER TABLE `pet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pet_phase`
--
ALTER TABLE `pet_phase`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reminder`
--
ALTER TABLE `reminder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `ringtone`
--
ALTER TABLE `ringtone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `tbpriority`
--
ALTER TABLE `tbpriority`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbstatus`
--
ALTER TABLE `tbstatus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbuser`
--
ALTER TABLE `tbuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pet_phase`
--
ALTER TABLE `pet_phase`
  ADD CONSTRAINT `pet_phase_ibfk_1` FOREIGN KEY (`pet_id`) REFERENCES `pet` (`id`);

--
-- Constraints for table `reminder`
--
ALTER TABLE `reminder`
  ADD CONSTRAINT `reminder_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`),
  ADD CONSTRAINT `reminder_ibfk_2` FOREIGN KEY (`ringtone_id`) REFERENCES `ringtone` (`id`);

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`priority_id`) REFERENCES `tbpriority` (`id`),
  ADD CONSTRAINT `task_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tbuser` (`id`),
  ADD CONSTRAINT `task_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `task_ibfk_5` FOREIGN KEY (`status_id`) REFERENCES `tbstatus` (`id`),
  ADD CONSTRAINT `task_ibfk_6` FOREIGN KEY (`priority_id`) REFERENCES `tbpriority` (`id`);

--
-- Constraints for table `tbuser`
--
ALTER TABLE `tbuser`
  ADD CONSTRAINT `tbuser_ibfk_1` FOREIGN KEY (`pet_id`) REFERENCES `pet` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
