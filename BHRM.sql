-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2024 at 11:29 AM
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
  `hname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `beds`
--

INSERT INTO `beds` (`id`, `roomno`, `bed_img`, `bed_no`, `bed_stat`, `bed_price`, `hname`) VALUES
(1, 7, 'beds/sdfghdsf.jpg', 1, 'Occupied', 1000, 'Dodge Boarding House'),
(2, 8, 'beds/drtd.jpg', 4, 'Occupied', 1000, 'Dodge Boarding House'),
(5, 1, 'beds/sdfghdsf.jpg', 1, 'Available', 1000, 'Alfred Boarding House'),
(6, 2, 'beds/sdfghdsf.jpg', 1, 'Available', 1000, 'Alfred Boarding House'),
(7, 7, 'beds/sdfghdsf.jpg', 2, 'Occupied', 1000, 'Dodge Boarding House'),
(8, 6, 'beds/drtd.jpg', 1, 'Occupied', 1000, 'Dodge Boarding House'),
(9, 2, 'beds/sgsdgs.jpg', 1, 'Occupied', 1000, 'Dodge Boarding House'),
(10, 1, 'beds/drtd.jpg', 1, 'Available', 1000, 'Jestoni Boarding House');

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
(29, 'jessie@gmail.com', 'jesse BH', 'maranding', 4564464, 'Approved', 'Jesse'),
(30, 'landlord@gmail.com', 'landlord BH', 'Zamboanggaa', 4564464, 'Rejected', 'landlord');

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
(2, 'alfred@gmail.com', 'Alfred Boarding House', 'maranding', 345345, 'Alfred Mag Aso'),
(3, 'khemark@gmail.com', 'Khemark BH', 'Tenazas', 4564464, 'khemark Ocariza'),
(4, 'dodge@gmail.com', 'Dodge Boarding House', 'maranding', 0, ''),
(28, 'Jestoni@gmail.com', 'Jestoni Boarding House', 'Zamboanggaa', 7897979, 'Jestoni Villarta'),
(29, 'jessie@gmail.com', 'jesse BH', 'maranding', 4564464, 'Jesse');

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
(28, 'pinaka nindot sa tanan', 'Jestoni Boarding House'),
(29, 'pinaka nindot sa tanan', 'jesse BH'),
(30, 'pinaka nindot sa tanan', 'landlord BH');

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
(11, 'images/al.jpg', 'images/gallery_4.jpg', 'Khemark BH'),
(13, 'images/agesser.png', 'images/98174995_146435506983130_761808498299240448_n.jpg', 'Dodge Boarding House'),
(28, 'images/agesser.png', 'images/98174995_146435506983130_761808498299240448_n.jpg', 'Jestoni Boarding House'),
(29, 'images/agesser.png', 'images/98174995_146435506983130_761808498299240448_n.jpg', 'jesse BH'),
(30, 'images/agesser.png', 'images/asfafs.jpg', 'landlord BH');

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
  `hname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `email`, `room_no`, `bed_no`, `bed_price`, `payment`, `pay_stat`, `pay_date`, `hname`) VALUES
(1, '', 0, 2, 0, 0, 'Not Fully Paid', '2024-11-17', 'Dodge Boarding House'),
(2, 'user@gmail.com', 7, 1, 1000, 0, 'Not Fully Paid', '2024-11-17', 'Dodge Boarding House'),
(3, 'user@gmail.com', 7, 1, 1000, 0, 'Not Fully Paid', '2024-11-17', 'Dodge Boarding House'),
(4, 'user@gmail.com', 7, 2, 1000, 0, 'Not Fully Paid', '2024-11-17', 'Dodge Boarding House'),
(5, 'user2@gmail.com', 8, 4, 1000, 0, 'Not Fully Paid', '2024-11-17', 'Dodge Boarding House'),
(6, 'user@gmail.com', 7, 1, 1000, 0, 'Not Fully Paid', '2024-11-17', 'Dodge Boarding House'),
(7, 'user@gmail.com', 7, 2, 1000, 0, 'Not Fully Paid', '2024-11-17', 'Dodge Boarding House'),
(8, 'user@gmail.com', 7, 1, 1000, 0, 'Not Fully Paid', '2024-11-17', 'Dodge Boarding House'),
(9, 'user@gmail.com', 7, 2, 1000, 0, 'Not Fully Paid', '2024-11-17', 'Dodge Boarding House'),
(10, 'user@gmail.com', 7, 1, 1000, 0, 'Not Fully Paid', '2024-11-17', 'Dodge Boarding House'),
(11, 'user@gmail.com', 7, 2, 1000, 0, 'Not Fully Paid', '2024-11-17', 'Dodge Boarding House'),
(12, 'user@gmail.com', 7, 1, 1000, 0, 'Not Fully Paid', '2024-11-17', 'Dodge Boarding House'),
(13, 'user@gmail.com', 7, 2, 1000, 0, 'Not Fully Paid', '2024-11-17', 'Dodge Boarding House'),
(14, 'user@gmail.com', 7, 1, 1000, 0, 'Not Fully Paid', '2024-11-17', 'Dodge Boarding House'),
(15, 'user@gmail.com', 7, 2, 1000, 0, 'Not Fully Paid', '2024-11-17', 'Dodge Boarding House'),
(16, 'user@gmail.com', 7, 1, 1000, 0, 'Not Fully Paid', '2024-11-17', 'Dodge Boarding House'),
(17, 'user@gmail.com', 7, 2, 1000, 0, 'Not Fully Paid', '2024-11-17', 'Dodge Boarding House'),
(18, 'user@gmail.com', 7, 2, 0, 0, 'Not Fully Paid', '2024-11-17', 'Dodge Boarding House'),
(19, 'user@gmail.com', 1, 1, 1000, 0, 'Not Fully Paid', '2024-11-17', 'Jestoni Boarding House'),
(20, 'user@gmail.com', 7, 1, 1000, 0, 'Not Fully Paid', '2024-11-17', 'Dodge Boarding House'),
(21, 'user@gmail.com', 7, 2, 1000, 0, 'Not Fully Paid', '2024-11-17', 'Dodge Boarding House'),
(22, 'user1@gmail.com', 8, 4, 1000, 0, 'Not Fully Paid', '0000-00-00', 'Dodge Boarding House');

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
  `hname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`id`, `fname`, `lname`, `email`, `gender`, `date_in`, `date_out`, `tenant_status`, `addons`, `room_no`, `bed_no`, `bed_price`, `bed_stat`, `capacity`, `amenities`, `price`, `image`, `status`, `res_stat`, `res_duration`, `res_reason`, `hname`) VALUES
(8, 'user', 'user', 'user2@gmail.com', '', '0000-00-00', '0000-00-00', '', '', 8, '4', 1000, 'Available', 3, 'ref, computer, oven', 500, 'images/sdfghdsf.jpg', 'available', 'Ended', '1 day', 'Reservation Ended', 'Dodge Boarding House'),
(17, 'user', 'user', 'user@gmail.com', 'Male', '2024-11-20', '2024-12-20', '', '', 7, '2 Bed(s)', 1000, 'Available', 6, 'ref, computer, oven', 0, 'images/sdfghdsf.jpg', 'available', 'Ended', '1 day', 'Reservation Ended', 'Dodge Boarding House'),
(18, 'user', 'user', 'user@gmail.com', 'Male', '2024-11-20', '2024-12-20', '', 'palihug kog hinlo', 7, '2 Bed(s)', 1000, 'Available', 6, 'ref, computer, oven', 0, 'images/sdfghdsf.jpg', 'available', 'Rejected', '1 day', 'No valid information / No Tenant Came', 'Dodge Boarding House'),
(19, 'user', 'user', 'user@gmail.com', 'Male', '2024-11-20', '2024-12-20', '', 'palihug kog hinlo', 7, '2', 0, 'Available', 6, 'ref, computer, oven', 1000, 'images/sdfghdsf.jpg', 'available', 'Ended', '1 day', 'Reservation Ended', 'Dodge Boarding House'),
(20, 'user', 'user', 'user@gmail.com', 'Male', '2024-11-20', '2024-12-20', '', 'palihug kog hinlo', 7, '2 Bed(s)', 1000, 'Reserved', 6, 'ref, computer, oven', 0, 'images/sdfghdsf.jpg', 'available', 'Cancelled', '1 day', 'Reservation Cancelled', 'Dodge Boarding House'),
(21, 'user', 'user', 'user@gmail.com', 'Male', '2024-11-20', '2024-12-20', '', 'palihug kog hinlo', 1, '2 Bed(s)', 1000, 'Available', 6, 'Tv, Wifi, Aircon', 0, 'images/sgsdgs.jpg', 'available', 'Rejected', '1 day', 'No valid information / No Tenant Came', 'Jestoni Boarding House'),
(22, 'user', 'user', 'user@gmail.com', 'Male', '2024-11-19', '2024-12-19', '', 'palihug kog hinlo', 1, '1', 1000, 'Available', 6, 'Tv, Wifi, Aircon', 0, 'images/sgsdgs.jpg', 'available', 'Cancelled', '1 day', 'Reservation Cancelled', 'Jestoni Boarding House'),
(23, 'user', 'user', 'user@gmail.com', '', '0000-00-00', '0000-00-00', '', '', 1, '1', 1000, 'Available', 6, 'Tv, Wifi, Aircon', 0, 'images/sgsdgs.jpg', 'available', 'Ended', '1 day', 'Reservation Ended', 'Jestoni Boarding House'),
(24, 'user', 'user', 'user@gmail.com', 'Male', '2024-11-19', '2024-12-19', '', 'palihug kog hinlo', 7, '2 Bed(s)', 1000, 'Occupied', 6, 'ref, computer, oven', 0, 'images/sdfghdsf.jpg', 'available', 'Confirmed', '1 day', 'Tenant Arrived', 'Dodge Boarding House'),
(25, 'user', 'user', 'user1@gmail.com', 'Male', '2024-11-20', '2024-12-20', '', 'palihug kog hinlo', 8, '4', 1000, 'Occupied', 1, 'ref, computer, oven', 0, 'images/sdfghdsf.jpg', 'available', 'Confirmed', '1 day', 'Tenant Arrived', 'Dodge Boarding House');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `room_no` int(255) NOT NULL,
  `room_type` varchar(255) NOT NULL,
  `capacity` int(255) NOT NULL,
  `current_tenant` int(255) NOT NULL,
  `amenities` varchar(255) NOT NULL,
  `tenant_type` varchar(255) NOT NULL,
  `room_floor` varchar(255) NOT NULL,
  `price` int(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `hname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_no`, `room_type`, `capacity`, `current_tenant`, `amenities`, `tenant_type`, `room_floor`, `price`, `image`, `status`, `hname`) VALUES
(2, 5, 'Double Room', 3, 0, 'ref, computer, oven', 'female', 'ground floor', 500, 'images/sdfghdsf.jpg', 'available', 'Dodge Boarding House'),
(3, 2, 'Single Room', 4, 0, 'ref, computer, microwave', 'male', 'ground floor', 10000000, 'images/sdfghdsf.jpg', 'available', 'Dodge Boarding House'),
(4, 1, 'Single Room', 3, 0, 'ref, computer, microwave', 'male', 'ground floor', 10000000, 'images/sdfghdsf.jpg', 'available', 'Alfred Boarding House'),
(5, 6, 'Quadrouple Room', 3, 0, 'Tv, Wifi, Aircon', 'male', 'ground floor', 10000000, 'images/sdfghdsf.jpg', 'available', 'Dodge Boarding House'),
(6, 7, 'Tripple Room', 6, 2, 'Tv, Wifi, Aircon', 'male', 'ground floor', 10000000, 'images/sdfghdsf.jpg', 'available', 'Dodge Boarding House'),
(7, 1, 'Single Room', 6, 0, 'Tv, Wifi, Aircon', 'male', 'ground floor', 10000000, 'images/sgsdgs.jpg', 'available', 'Jestoni Boarding House'),
(8, 8, 'Double Room', 1, 1, 'Tv, Wifi, Aircon', 'male', 'ground floor', 500, 'images/drtd.jpg', 'available', 'Dodge Boarding House'),
(9, 2, 'Quadrouple Room', 4, 0, 'lababo', 'male', 'ground floor', 500, 'images/drtd.jpg', 'available', 'Alfred Boarding House');

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
(8, 'user', 'user', 'user@gmail.com', 'yes', 'user', ''),
(9, 'shrek', 'shrek', 'shrek@gmail.com', 'yes', 'landlord', ''),
(10, 'jessie', 'jessie', 'jessie@gmail.com', 'yes', 'landlord', ''),
(11, 'user', 'user', 'user1@gmail.com', 'yes', 'user', ''),
(12, 'user', 'user', 'user2@gmail.com', 'yes', 'user', ''),
(13, 'user', 'user', 'user3@gmail.com', 'yes', 'user', ''),
(14, 'Dodge', 'Ackkerman', 'user4@gmail.com', 'yes', 'user', ''),
(15, 'Dodge', 'Ackkerman', 'user5@gmail.com', 'yes', 'user', ''),
(16, 'Dodge', 'Ackkerman', 'user6@gmail.com', 'yes', 'user', ''),
(17, 'landlord', 'landlord', 'landlord@gmail.com', 'yes', 'landlord', '');

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
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `bhapplication`
--
ALTER TABLE `bhapplication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `boardinghouses`
--
ALTER TABLE `boardinghouses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `description`
--
ALTER TABLE `description`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
