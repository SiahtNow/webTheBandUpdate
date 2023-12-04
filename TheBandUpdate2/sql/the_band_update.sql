-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2023 at 01:37 PM
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
-- Database: `the_band_update`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_account`
--

CREATE TABLE `tbl_account` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_account`
--

INSERT INTO `tbl_account` (`user_id`, `user_name`, `email`, `password`) VALUES
(1, 'admin1', '', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_buy_ticket`
--

CREATE TABLE `tbl_buy_ticket` (
  `ticket_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `email` varchar(500) NOT NULL,
  `date_buy` date NOT NULL,
  `quantity` int(1) NOT NULL,
  `location` varchar(500) NOT NULL,
  `date_view` date NOT NULL,
  `rows_of_seat` int(11) NOT NULL,
  `type_ticket` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_buy_ticket`
--

INSERT INTO `tbl_buy_ticket` (`ticket_id`, `type_id`, `user_id`, `user_name`, `email`, `date_buy`, `quantity`, `location`, `date_view`, `rows_of_seat`, `type_ticket`) VALUES
(1, 0, 0, 'Lee Thai', 'conmabata2003@gmail.com', '0000-00-00', 3, '', '0000-00-00', 2, 'A'),
(2, 0, 0, 'Le Nguyen Thai', 'conmabata@gmail.com', '0000-00-00', 3, '', '0000-00-00', 3, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comment`
--

CREATE TABLE `tbl_comment` (
  `message_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `email` varchar(500) NOT NULL,
  `content` text NOT NULL,
  `post_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_comment`
--

INSERT INTO `tbl_comment` (`message_id`, `user_id`, `user_name`, `email`, `content`, `post_date`) VALUES
(1, 0, 'Thai', 'conmabata2003@gmail.com', 'Hay', '2023-12-03'),
(2, 0, 'Thai', 'conmabata2003@gmail.com', 'Hay qua', '2023-12-03'),
(3, 0, 'Thai', 'conmabata2003@gmail.com', 'Hay qua troi', '2023-12-03'),
(4, 0, 'Thai', 'conmabata2003@gmail.com', 'Hay qua troi oi', '2023-12-03'),
(5, 0, 'Tài', 'conmabata2003@gmail.com', 'Hay qua troi oi', '2023-12-03'),
(6, 0, 'Tài', 'conmabata2003@gmail.com', 'Hay qua troi', '2023-12-03');

-- --------------------------------------------------------

--
-- Table structure for table `type_ticket`
--

CREATE TABLE `type_ticket` (
  `type_id` int(11) NOT NULL,
  `location` varchar(300) NOT NULL,
  `date_view` date NOT NULL,
  `link_img` varchar(500) NOT NULL,
  `type_ticket` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `type_ticket`
--

INSERT INTO `type_ticket` (`type_id`, `location`, `date_view`, `link_img`, `type_ticket`) VALUES
(1, 'England', '2023-12-06', 'upload_img/place1.jpg', 'A'),
(2, 'England', '2023-12-15', 'upload_img/place2.jpg', 'B'),
(3, 'USA', '2023-12-08', 'upload_img/place3.jpg', 'B'),
(4, 'Germany', '2023-12-18', 'upload_img/place1.jpg', 'B'),
(5, 'VietNam', '2023-12-20', 'upload_img/place3.jpg', 'B'),
(6, 'Thailand', '2023-12-22', 'upload_img/place2.jpg', 'A');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_account`
--
ALTER TABLE `tbl_account`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_buy_ticket`
--
ALTER TABLE `tbl_buy_ticket`
  ADD PRIMARY KEY (`ticket_id`);

--
-- Indexes for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `type_ticket`
--
ALTER TABLE `type_ticket`
  ADD PRIMARY KEY (`type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_account`
--
ALTER TABLE `tbl_account`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_buy_ticket`
--
ALTER TABLE `tbl_buy_ticket`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `type_ticket`
--
ALTER TABLE `type_ticket`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
