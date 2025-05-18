-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2025 at 07:08 AM
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
-- Database: `login`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE `admin_login` (
  `id` int(11) NOT NULL,
  `admin_id` int(25) NOT NULL,
  `admin_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`id`, `admin_id`, `admin_password`) VALUES
(1, 2468, '$2y$10$b8VaWiVi25kF6QarJC6h/OQK7Mz0WD2BM/IbjK/K7B2QUaWhRvYwe');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(11) NOT NULL,
  `c_name` varchar(50) NOT NULL,
  `c_email` varchar(50) NOT NULL,
  `c_message` varchar(600) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `c_name`, `c_email`, `c_message`) VALUES
(1, 'a', 'A@a', 'jklasdjnflk'),
(2, 'a', 'a@a', 'a'),
(3, 'a', 'A@A', 'a'),
(4, 'a', 'a@a', 'a'),
(5, 'a', 'a@a', 'gagapasd');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `specialty` varchar(255) NOT NULL,
  `contact` bigint(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `fname`, `lname`, `specialty`, `contact`) VALUES
(1, 'Marvin', 'Acuin', 'Gynecology , Surgery , Plastic surgery , Dermatology ', 9368149358),
(2, 'David', 'Heard', 'Nuclear medicine , Radiology , Anesthesiology , Forensic pathology', 9760492077),
(3, 'Eitan Dwane', 'Maceda', 'intensive care medicine , Infectious diseases , Urologist , Reproductive Endocrinologists', 9513212143),
(4, 'John Ray Michael', 'Marcellana', 'Virologist , Oncologists ,  Colorectal Surgeon , Psychiatrist', 94521475685);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `patient__id` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `patient_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `patient__id`, `password`, `patient_name`) VALUES
(12, 'David12', '$2y$10$wVRLWUEmbEZgxF4HkjDC3uhii/jan0T64DvuB6knHKqRQ8iC6nULe', 'David'),
(13, 'marvin123', '$2y$10$SN2bkqYimLCj4ieE0x.zjOhnuNxQ97o00znRJ5gQO/bb.P6YyvIcq', 'Marvin'),
(14, 'tantan', '$2y$10$fb4HQf0.LulWwaD61KoOt.EzaiXIOeaO/Jk5JkRRAqP1m4/fuZRO.', 'eitan27'),
(15, 'harry1', '$2y$10$/Xj2eRgmAi1wdSkQe/Yhs.s9iMYcS7IPftlANDewGXVnoXdxhtD4a', 'Harry'),
(17, 'redford1', '$2y$10$p7wQAn0Rvp/XyA67ug7HquK2caXo5TPVx1krH2FLIX4nit9U1s.BG', 'redford'),
(18, '000', '$2y$10$wm9hpfHhTf27.3vt.xnbMOVmGn.XIzJwOv3s.Gxy7bOv7yBsACbpi', 'seyus'),
(19, '001', '$2y$10$mIFvR8D31Zmlde2e0ZPWY.PenVHNdqVDP40CFwcdOmWSyhClAn3eG', 'christ'),
(21, 'd', '$2y$10$kGn9VzzOg8LxAcbblLjVau0t5yKUhWGTj5GQO93EqKW8.aQhgB9IG', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `age` int(3) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `_doc` varchar(255) NOT NULL,
  `_appointment` int(3) NOT NULL,
  `_meds` varchar(255) NOT NULL,
  `_test` int(2) NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`id`, `first_name`, `last_name`, `age`, `address`, `contact`, `_doc`, `_appointment`, `_meds`, `_test`, `photo`) VALUES
(12, 'David', 'heard', 26, '63 quezon st. landayan', '09760492077', 'Dr. Marvin Acuin', 125, 'sinok', 2, 'cfaaa2b2-6d00-4776-8998-9a0f254d532b-removebg-preview.png'),
(13, 'Marvin ', 'Acuin', 67, '132 san pedro', '7894561232', 'Dr. Eitan Maceda', 7, 'ubo na may plema', 5, 'FB_IMG_1586967917024.jpg'),
(14, 'eitan', 'maceda', 56, '12 high way st', '123123456', 'Dr. Marvin Acuin', 4, 'tulo', 3, 'FB_IMG_1586967911182.jpg'),
(15, 'Harry ', 'Lagman', 29, 'Encantadia', '09513212145', 'Dr. Marvin Acuin', 68, 'Kidney stones sa utak, ubo na may plema', 75, '494358060_932894782187820_8463390880289035124_n.png'),
(17, 'babaluu', 'white', 32, 'sa tabi', '09513212143', 'Dr. Marvin Acuin', 3, 'wala', 0, 'E5YpJO_5f.jpg'),
(18, 'Earlfred', 'Reyes', 60, '12 tambay st. binan', '987654321', 'Dr. Eitan Maceda', 12, 'nangamatis yung butas ng etits, chemo not effective, need more tests.', 56, 'image_2025-05-16_173018854.png'),
(19, 'ice', 'the jesus', 87, '12 jerusalem st.', '0398231565', 'Dr. Marvin Acuin', 12, 'tigas ng muka di madaan sa sinsil, kelangan na ng excavator saka jack hammer', 67, 'image_2025-05-16_173605189.png'),
(21, 'david', 'bieber', 12, 'a', 'a', 'Dr. Marvin Acuin', 1, 'a', 0, 'FB_IMG_1585962878971.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_login`
--
ALTER TABLE `admin_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_login`
--
ALTER TABLE `admin_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
