-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2024 at 10:27 AM
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
-- Database: `bhrm`
--

-- --------------------------------------------------------

--
-- Table structure for table `bhapplication`
--

CREATE TABLE `bhapplication` (
  `id` int(11) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `hname` varchar(25) NOT NULL,
  `haddress` varchar(25) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `boardinghouses`
--

CREATE TABLE `boardinghouses` (
  `id` int(11) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `hname` varchar(25) NOT NULL,
  `haddress` varchar(25) NOT NULL,
  `contactno` int(255) NOT NULL,
  `landlord` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `boardinghouses`
--

INSERT INTO `boardinghouses` (`id`, `owner`, `hname`, `haddress`, `contactno`, `landlord`) VALUES
(2, 'alfred@gmail.com', 'Alfred Boarding House', 'maranding', 0, ''),
(3, 'khemark@gmail.com', 'Khemark BH', 'Tenazas', 0, ''),
(4, 'dodge@gmail.com', 'Dodge Boarding House', 'maranding', 0, ''),
(5, 'Jestoni@gmail.com', 'Jestoni Boarding House', 'Zamboanggaa', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `description`
--

CREATE TABLE `description` (
  `id` int(255) NOT NULL,
  `bh_description` varchar(255) NOT NULL,
  `hname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `description`
--

INSERT INTO `description` (`id`, `bh_description`, `hname`) VALUES
(3, 'pinaka nindot sa tanan', 'tenazas BH'),
(6, 'pinaka nindot sa tanan', 'Dave BH'),
(7, 'yes yes', 'Apitong Boarding House'),
(8, 'YE SYESYSE', 'Syudad Boarding House'),
(10, 'pinaka nindot sa tanan', 'Alfred Boarding House'),
(11, 'pinaka nindot sa tanan', 'Khemark BH'),
(13, 'pinaka nindot sa tanan', 'Dodge Boarding House'),
(24, 'Pinaka ayos sa tanan', 'Jestoni Boarding House');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(255) NOT NULL,
  `documents` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `hname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `documents`, `image`, `hname`) VALUES
(3, 'images/agesser.png', 'images/background.jpeg', 'tenazas BH'),
(6, 'images/al.jpg', 'images/agesser.png', 'Dave BH'),
(7, 'images/sgsdgs.jpg', 'images/sdfghdsf.jpg', 'Apitong Boarding House'),
(8, 'images/dfghdfh.jpg', 'images/drtd.jpg', 'Syudad Boarding House'),
(10, 'images/al.jpg', 'images/background.jpeg', 'Alfred Boarding House'),
(11, 'images/al.jpg', 'images/asfda.jpg', 'Khemark BH'),
(13, 'images/agesser.png', 'images/98174995_146435506983130_761808498299240448_n.jpg', 'Dodge Boarding House'),
(24, 'images/drtd.jpg', 'images/sgsdgs.jpg', 'Jestoni Boarding House');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `id` int(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_in` datetime NOT NULL DEFAULT current_timestamp(),
  `addons` varchar(255) NOT NULL,
  `room_no` int(255) NOT NULL,
  `amenities` varchar(255) NOT NULL,
  `price` int(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `res_stat` varchar(255) NOT NULL,
  `hname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `room_no` int(255) NOT NULL,
  `room_type` varchar(255) NOT NULL,
  `capacity` int(255) NOT NULL,
  `amenities` varchar(255) NOT NULL,
  `price` int(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `hname` varchar(255) NOT NULL,
  `datein` date DEFAULT NULL,
  `dateout` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_no`, `room_type`, `capacity`, `amenities`, `price`, `image`, `status`, `hname`, `datein`, `dateout`) VALUES
(1, 1, 'Single Room', 2, 'Tv, Wifi, Aircon', 10000000, 'images/sdfghdsf.jpg', 'occupied', 'Dodge Boarding House', '2024-09-16', NULL),
(2, 5, 'Double Room', 3, 'ref, computer, oven', 500, 'images/sdfghdsf.jpg', 'occupied', 'Dodge Boarding House', '2024-09-16', NULL),
(3, 2, 'Single Room', 4, 'ref, computer, microwave', 10000000, 'images/dfghdfh.jpg', 'available', 'Dodge Boarding House', NULL, NULL),
(4, 1, 'Single Room', 0, 'ref, computer, microwave', 10000000, 'images/sdfghdsf.jpg', 'occupied', 'Alfred Boarding House', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `uname` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `hname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `uname`, `pass`, `role`, `hname`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', 'yes', 'admin', ''),
(2, 'Dodge', 'Suico', 'dodge@gmail.com', 'yes', 'landlord', 'Dodge Boarding House'),
(3, 'alfred', 'magaso', 'alfred@gmail.com', 'yes', 'landlord', 'Alfred Boarding House'),
(5, 'khemark', 'ocariza', 'khemark@gmail.com', 'yes', 'landlord', 'Khemark BH'),
(6, 'Jestoni', 'Villarta', 'Jestoni@gmail.com', 'yes', 'landlord', 'Jestoni Boarding House'),
(7, 'Dave', 'Suico', 'dave@gmail.com', 'yes', 'landlord', 'Syudad Boarding House'),
(8, 'user', 'user', 'user@gmail.com', 'yes', 'user', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bhapplication`
--
ALTER TABLE `bhapplication`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `boardinghouses`
--
ALTER TABLE `boardinghouses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `description`
--
ALTER TABLE `description`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bhapplication`
--
ALTER TABLE `bhapplication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `boardinghouses`
--
ALTER TABLE `boardinghouses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `description`
--
ALTER TABLE `description`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
