-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 12, 2017 at 06:12 PM
-- Server version: 10.1.24-MariaDB
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `users`
--

-- --------------------------------------------------------

--
-- Table structure for table `bas_user`
--

CREATE TABLE `bas_user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bas_user`
--

INSERT INTO `bas_user` (`user_id`, `user_name`) VALUES
(25, 'ashish'),
(26, 'bob'),
(27, 'clive'),
(28, 'dan'),
(29, 'Eric'),
(30, 'Francis'),
(31, 'Gary'),
(32, 'Harry'),
(33, 'Ian'),
(35, 'sajid');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `parent_id` int(11) DEFAULT NULL,
  `child_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`parent_id`, `child_id`) VALUES
(25, 26),
(25, 27),
(26, 28),
(26, 29),
(26, 30),
(30, 31),
(30, 32),
(27, 33);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bas_user`
--
ALTER TABLE `bas_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD KEY `roles_ibfk_1` (`parent_id`),
  ADD KEY `roles_ibfk_2` (`child_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bas_user`
--
ALTER TABLE `bas_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `bas_user` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roles_ibfk_2` FOREIGN KEY (`child_id`) REFERENCES `bas_user` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
