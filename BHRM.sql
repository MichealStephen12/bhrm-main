-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2024 at 04:09 AM
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
-- Table structure for table `beds`
--

CREATE TABLE `beds` (
  `id` int(255) NOT NULL,
  `roomno` int(255) NOT NULL,
  `bed_img` varchar(255) NOT NULL,
  `bed_no` int(255) NOT NULL,
  `bed_stat` varchar(255) NOT NULL,
  `bed_price` int(255) NOT NULL,
  `hname` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `beds`
--

INSERT INTO `beds` (`id`, `roomno`, `bed_img`, `bed_no`, `bed_stat`, `bed_price`, `hname`, `owner`) VALUES
(1, 1, 'beds/67400efec6c107.72247498.jpg', 1, 'Available', 1000, 'Dodge BH', 'dodge@gmail.com'),
(2, 1, 'beds/67400efec6c107.72247498.jpg', 2, 'Available', 1000, 'Dodge BH', 'dodge@gmail.com'),
(3, 1, 'beds/sgsdgs.jpg', 3, 'Available', 1000, 'Dodge BH', 'dodge@gmail.com'),
(4, 2, 'beds/gasda.jpg', 1, 'Available', 1000, 'Dodge BH', 'dodge@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `bhapplication`
--

CREATE TABLE `bhapplication` (
  `id` int(11) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `hname` varchar(25) NOT NULL,
  `haddress` varchar(25) NOT NULL,
  `contact_no` int(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `landlord` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bhapplication`
--

INSERT INTO `bhapplication` (`id`, `owner`, `hname`, `haddress`, `contact_no`, `status`, `landlord`) VALUES
(1, 'dodge@gmail.com', 'Dodge Boarding House', 'Maranding', 4564464, 'Approved', 'Dodge'),
(2, 'Jestoni@gmail.com', 'Jestoni Boarding House', 'Zamboanggaa', 946464646, 'Approved', 'jestoni villarta'),
(3, 'khemark@gmail.com', 'tenazas BH', 'Zamboanggaa', 4564464, 'Approved', 'khemark ocariza'),
(4, 'khemark@gmail.com', 'tenazas BH', 'Tenazas', 4564464, 'Approved', 'khemark Ocariza'),
(5, 'khemark@gmail.com', 'tenazas BH', 'Zamboanggaa', 4564464, 'Approved', 'khemark Ocariza');

-- --------------------------------------------------------

--
-- Table structure for table `boardinghouses`
--

CREATE TABLE `boardinghouses` (
  `id` int(11) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `hname` varchar(25) NOT NULL,
  `haddress` varchar(25) NOT NULL,
  `contact_no` int(255) NOT NULL,
  `landlord` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `boardinghouses`
--

INSERT INTO `boardinghouses` (`id`, `owner`, `hname`, `haddress`, `contact_no`, `landlord`) VALUES
(1, 'dodge@gmail.com', 'Dodge BH', 'Maranding', 24234, 'Dodge'),
(2, 'Jestoni@gmail.com', 'Jestoni Boarding House', 'Zamboanggaa', 946464646, 'jestoni villarta'),
(5, 'khemark@gmail.com', 'tenazas BH', 'Zamboanggaa', 4564464, 'khemark ocariza');

-- --------------------------------------------------------

--
-- Table structure for table `description`
--

CREATE TABLE `description` (
  `id` int(255) NOT NULL,
  `bh_description` varchar(255) NOT NULL,
  `hname` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `description`
--

INSERT INTO `description` (`id`, `bh_description`, `hname`, `owner`) VALUES
(1, 'pinaka nindot sa tanan', 'Dodge BH', 'dodge@gmail.com'),
(2, 'pinaka nindot sa tanan', 'Jestoni Boarding House', 'jestoni@gmail.com'),
(5, 'pinaka nindot sa tanan', 'tenazas BH', 'khemark@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(255) NOT NULL,
  `documents` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `hname` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `documents`, `image`, `hname`, `owner`) VALUES
(1, 'images/agesser.png', 'images/azianna.jpg', 'Dodge BH', 'dodge@gmail.com'),
(2, 'images/agesser.png', 'images/background.jpeg', 'Jestoni Boarding House', 'Jestoni@gmail.com'),
(5, 'images/agesser.png', 'images/dgfgd.jpg', 'tenazas BH', 'khemark@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `room_no` int(255) NOT NULL,
  `bed_no` int(255) NOT NULL,
  `bed_price` int(255) NOT NULL,
  `payment` int(255) NOT NULL,
  `pay_stat` varchar(255) NOT NULL,
  `pay_date` date DEFAULT NULL,
  `hname` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `payment` int(255) NOT NULL,
  `pay_date` date DEFAULT NULL,
  `date_in` date DEFAULT NULL,
  `date_out` date DEFAULT NULL,
  `room_no` int(255) NOT NULL,
  `bed_no` int(255) NOT NULL,
  `hname` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `fname`, `lname`, `gender`, `email`, `payment`, `pay_date`, `date_in`, `date_out`, `room_no`, `bed_no`, `hname`, `owner`) VALUES
(1, 'user', 'user', 'Male', 'user@gmail.com', 1000, '2024-11-22', '2024-11-22', '2024-11-22', 1, 3, 'Dodge BH', 'dodge@gmail.com'),
(2, 'user', 'user', 'Male', 'user@gmail.com', 1000, '2024-11-25', '2024-11-25', '2024-11-25', 1, 3, 'Dodge BH', ''),
(3, 'user', 'user', 'Male', 'user@gmail.com', 0, '0000-00-00', '2024-11-25', '2024-11-25', 1, 3, 'Dodge BH', ''),
(4, 'user', 'user', 'Male', 'user@gmail.com', 0, '0000-00-00', '2024-11-25', '2024-11-25', 1, 3, 'Dodge BH', ''),
(5, 'user', 'user', 'Male', 'user@gmail.com', 0, '0000-00-00', '2024-11-25', '2024-11-25', 1, 3, 'Dodge BH', ''),
(6, 'user', 'user', 'Male', 'user@gmail.com', 0, '0000-00-00', '2024-11-25', '2024-11-25', 1, 3, 'Dodge BH', '');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `id` int(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `date_in` date DEFAULT NULL,
  `date_out` date DEFAULT NULL,
  `tenant_status` varchar(255) NOT NULL,
  `addons` varchar(255) NOT NULL,
  `room_no` int(255) NOT NULL,
  `bed_no` varchar(255) NOT NULL,
  `bed_price` int(255) NOT NULL,
  `bed_stat` varchar(255) NOT NULL,
  `capacity` int(255) NOT NULL,
  `amenities` varchar(255) NOT NULL,
  `price` int(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `res_stat` varchar(255) NOT NULL,
  `res_duration` varchar(255) NOT NULL,
  `res_reason` varchar(255) NOT NULL,
  `hname` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`id`, `fname`, `lname`, `email`, `gender`, `date_in`, `date_out`, `tenant_status`, `addons`, `room_no`, `bed_no`, `bed_price`, `bed_stat`, `capacity`, `amenities`, `price`, `image`, `status`, `res_stat`, `res_duration`, `res_reason`, `hname`, `owner`) VALUES
(1, 'user', 'user', 'user@gmail.com', 'Male', '2024-11-23', '2024-12-23', '', 'palihug kog hinlo', 1, '3 Bed(s)', 1000, 'Available', 3, 'wifi', 0, 'images/673fdeb1a44f30.60824496.jpg', 'available', 'Ended', '', 'Reservation Ended', 'Dodge BH', 'dodge@gmail.com'),
(2, 'user', 'user', 'user@gmail.com', 'Male', '2024-11-28', '2024-12-28', '', 'palihug kog hinlo', 1, '3 Bed(s)', 1000, 'Available', 3, 'wifi, tv, afasf', 0, 'images/673fdeb1a44f30.60824496.jpg', 'available', 'Ended', '', 'Reservation Ended', 'Dodge BH', ''),
(3, 'user', 'user', 'user@gmail.com', 'Male', '2024-11-29', '2024-12-29', '', 'palihug kog hinlo', 1, '3', 1000, 'Available', 3, 'wifi, tv, afasf', 0, 'images/673fdeb1a44f30.60824496.jpg', 'available', 'Ended', '', 'Reservation Ended', 'Dodge BH', 'dodge@gmail.com'),
(4, 'user', 'user', 'user@gmail.com', 'Male', '2024-11-28', '2024-12-28', '', 'palihug kog hinlo', 1, '3 Bed(s)', 1000, 'Available', 3, 'wifi, tv, afasf', 0, 'images/673fdeb1a44f30.60824496.jpg', 'available', 'Ended', '', 'Reservation Ended', 'Dodge BH', ''),
(5, 'user', 'user', 'user@gmail.com', 'Male', '2024-12-05', '2025-01-04', '', '', 1, '3 Bed(s)', 1000, 'Available', 3, 'wifi, tv, afasf', 0, 'images/673fdeb1a44f30.60824496.jpg', 'available', 'Ended', '', 'Reservation Ended', 'Dodge BH', ''),
(6, 'user', 'user', 'user@gmail.com', 'Male', '2024-11-28', '2024-12-28', '', 'palihug kog hinlo', 1, '3 Bed(s)', 1000, 'Available', 3, 'wifi, tv, afasf', 0, 'images/673fdeb1a44f30.60824496.jpg', 'available', 'Ended', '', 'Reservation Ended', 'Dodge BH', 'dodge@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `room_no` int(255) NOT NULL,
  `capacity` int(255) NOT NULL,
  `current_tenant` int(255) NOT NULL,
  `amenities` varchar(255) NOT NULL,
  `tenant_type` varchar(255) NOT NULL,
  `room_floor` varchar(255) NOT NULL,
  `price` int(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `hname` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_no`, `capacity`, `current_tenant`, `amenities`, `tenant_type`, `room_floor`, `price`, `image`, `status`, `hname`, `owner`) VALUES
(1, 1, 3, 0, 'wifi, tv, afasf', 'male', 'ground floor', 1000, 'images/673fdeb1a44f30.60824496.jpg', 'available', 'Dodge BH', 'dodge@gmail.com'),
(2, 2, 3, 0, 'wifi', 'male', 'ground floor', 1000, 'images/673fdf57bba517.83684901.jpg', 'available', 'Dodge BH', 'dodge@gmail.com'),
(3, 3, 3, 0, 'wifi, bedsheets', 'male', 'ground floor', 1000, 'images/6743e5676e5f17.95594161.jpg', 'available', 'Dodge BH', 'dodge@gmail.com');

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
(2, 'Dodge', 'Suico', 'dodge@gmail.com', 'yes', 'landlord', 'Dodge BH'),
(3, 'user', 'user', 'user@gmail.com', 'yes', 'user', ''),
(4, 'user', 'user', 'user1@gmail.com', 'yes', 'user', ''),
(5, 'Jestoni', 'Villarta', 'Jestoni@gmail.com', 'yes', 'landlord', 'Jestoni Boarding House'),
(6, 'khemark', 'ocariza', 'khemark@gmail.com', 'yes', 'landlord', 'tenazas BH');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `beds`
--
ALTER TABLE `beds`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
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
-- AUTO_INCREMENT for table `beds`
--
ALTER TABLE `beds`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bhapplication`
--
ALTER TABLE `bhapplication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `boardinghouses`
--
ALTER TABLE `boardinghouses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `description`
--
ALTER TABLE `description`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
