-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2025 at 03:16 PM
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
(5, 'a', 'a@a', 'gagapasd'),
(6, 'david heard', 'heard@email.com', 'hello po');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `spec1` varchar(255) NOT NULL,
  `spec2` varchar(255) NOT NULL,
  `spec3` varchar(255) NOT NULL,
  `spec4` varchar(255) NOT NULL,
  `contact` bigint(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `fname`, `lname`, `spec1`, `spec2`, `spec3`, `spec4`, `contact`) VALUES
(1, 'Marvin', 'Acuin', 'Gynecology', 'Surgery', 'Plastic surgery', 'Dermatology', 9513212142),
(2, 'David', 'Heard', 'Nuclear', 'Radiology ', 'Anesthesiology ', 'Forensic pathology', 9512212149),
(3, 'Eitan', 'Maceda', 'intensive care medicine', 'Infectious diseases', 'Urologist', 'Reproductive Endocrinologists', 9513212143),
(4, 'John', 'Ray', 'Virologist', 'Oncologists', 'Colorectal Surgeon', 'Psychiatrist', 9513215427),
(5, 'Earl Fred ', 'Reyes', 'Virologist', 'Oncologists', 'Colorectal', 'Psychiatrist', 9513621804);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `patient__id` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `patient__id`, `password`) VALUES
(13, 'marvin123', '$2y$10$SN2bkqYimLCj4ieE0x.zjOhnuNxQ97o00znRJ5gQO/bb.P6YyvIcq'),
(14, 'tantan', '$2y$10$fb4HQf0.LulWwaD61KoOt.EzaiXIOeaO/Jk5JkRRAqP1m4/fuZRO.'),
(15, 'harry1', '$2y$10$/Xj2eRgmAi1wdSkQe/Yhs.s9iMYcS7IPftlANDewGXVnoXdxhtD4a'),
(17, 'redford1', '$2y$10$p7wQAn0Rvp/XyA67ug7HquK2caXo5TPVx1krH2FLIX4nit9U1s.BG'),
(18, '000', '$2y$10$wm9hpfHhTf27.3vt.xnbMOVmGn.XIzJwOv3s.Gxy7bOv7yBsACbpi'),
(19, '001', '$2y$10$mIFvR8D31Zmlde2e0ZPWY.PenVHNdqVDP40CFwcdOmWSyhClAn3eG'),
(21, 'david112', '$2y$10$qyT0Mw/NEWABClx7d7oNt./6eIECGXcVhNcUTVxc.t0eBE06F.7pG');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `age` int(3) NOT NULL,
  `_sex` varchar(2) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `_doc` varchar(255) NOT NULL,
  `_appointment` int(3) NOT NULL,
  `_meds` varchar(255) NOT NULL,
  `_test` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `systolic` int(20) NOT NULL,
  `diastolic` int(20) NOT NULL,
  `bpm` int(5) NOT NULL,
  `cholesterol` int(5) NOT NULL,
  `glucose` int(5) NOT NULL,
  `last_date` date NOT NULL,
  `med1` varchar(255) NOT NULL,
  `med2` varchar(255) NOT NULL,
  `med_sched1` varchar(255) NOT NULL,
  `med_sched2` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`id`, `first_name`, `last_name`, `age`, `_sex`, `address`, `contact`, `_doc`, `_appointment`, `_meds`, `_test`, `photo`, `systolic`, `diastolic`, `bpm`, `cholesterol`, `glucose`, `last_date`, `med1`, `med2`, `med_sched1`, `med_sched2`) VALUES
(13, 'Marvin ', 'Acuin', 67, '', '132 san pedro', '7894561232', 'Dr. Eitan Maceda', 7, 'ubo na may plema', '5', 'FB_IMG_1586967917024.jpg', 0, 0, 0, 0, 0, '0000-00-00', '', '', '00:00:00', '00:00:00'),
(14, 'eitan', 'maceda', 56, '', '12 high way st', '123123456', 'Dr. Marvin Acuin', 4, 'tulo', '3', 'FB_IMG_1586967911182.jpg', 0, 0, 0, 0, 0, '0000-00-00', '', '', '00:00:00', '00:00:00'),
(15, 'skibidi', 'Lagman', 29, 'M', 'Encantadia', '09513212145', 'Dr. Marvin Acuin', 68, 'Kidney stones sa utak', '75', '494358060_932894782187820_8463390880289035124_n.png', 198, 0, 127, 89, 255, '2025-06-25', '', '', '00:00:00', '00:00:00'),
(17, 'babalu ', 'white', 33, '', 'sa tabi', '09513212143', 'Dr. Eitan Maceda', 3, 'wala', '0', 'E5YpJO_5f.jpg', 0, 0, 0, 0, 0, '0000-00-00', '', '', '00:00:00', '00:00:00'),
(18, 'Earlfred', 'Reyes', 60, 'M', '12 tambay st. binan', '987654321', 'Dr. Eitan Maceda', 12, 'nangamatis yung butas ng etits, chemo not effective, need more tests.', '56', 'image_2025-05-16_173018854.png', 198, 90, 127, 900, 255, '2025-05-21', 'Salbutamol 4mg', 'Antacid 100mg', '07:30 AM', '04:00 PM'),
(19, 'ice', 'the jesus', 87, '', '12 jerusalem st.', '0398231565', 'Dr. Marvin Acuin', 12, 'tigas ng muka di madaan sa sinsil, kelangan na ng excavator saka jack hammer', '67', 'image_2025-05-16_173605189.png', 0, 0, 0, 0, 0, '0000-00-00', '', '', '00:00:00', '00:00:00'),
(21, 'david', 'heard', 25, 'M', '544545', '09760492077', 'Dr. Eitan Maceda', 12, 'masyadong pogi', '2', 'images (2).jpg', 0, 0, 0, 0, 0, '0000-00-00', '', '', '00:00:00', '00:00:00');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
