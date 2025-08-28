-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2025 at 05:47 AM
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
-- Database: `crm_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `crm`
--

CREATE TABLE `crm` (
  `company_email` varchar(150) NOT NULL,
  `marketing_id` char(3) NOT NULL,
  `marketing_person_name` varchar(100) DEFAULT NULL,
  `contact_person_email` varchar(150) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `contact_person` varchar(150) DEFAULT NULL,
  `contact_person_position_title` varchar(150) DEFAULT NULL,
  `phone_wa` varchar(50) DEFAULT NULL,
  `company_website` varchar(255) DEFAULT NULL,
  `company_category` varchar(100) DEFAULT NULL,
  `contact_person_position_category` varchar(100) DEFAULT NULL,
  `company_industry_type` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `postcode` varchar(20) DEFAULT NULL,
  `status` enum('input','wa','emailed','contacted','replied','presentation','CLIENT') DEFAULT 'input',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crm`
--

INSERT INTO `crm` (`company_email`, `marketing_id`, `marketing_person_name`, `contact_person_email`, `company_name`, `contact_person`, `contact_person_position_title`, `phone_wa`, `company_website`, `company_category`, `contact_person_position_category`, `company_industry_type`, `address`, `city`, `postcode`, `status`, `created_at`, `updated_at`) VALUES
('Antara@gmail.com', 'FRL', 'Farelfadlillah', 'Example@gmail.com', 'PT. Anatara', 'Bpk ...', 'IT SUPPORT', '0811...', 'antara.com', 'Public', 'IT', 'insurence', 'Jl...', 'Jakarta', '10410', 'emailed', '2025-08-27 12:16:26', '2025-08-27 12:16:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `marketing_id` char(3) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`marketing_id`, `name`, `email`, `password`, `created_at`) VALUES
('FAR', 'Farel', 'farel@example.com', '$2y$10$EXAMPLEHASHSHOULDBEGENERATEDIN_PHP', '2025-08-27 11:31:19'),
('FRL', 'Farelfadlillah', 'farel@rtn.com', '$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du', '2025-08-27 11:36:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `crm`
--
ALTER TABLE `crm`
  ADD PRIMARY KEY (`company_email`),
  ADD KEY `marketing_id` (`marketing_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`marketing_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `crm`
--
ALTER TABLE `crm`
  ADD CONSTRAINT `crm_ibfk_1` FOREIGN KEY (`marketing_id`) REFERENCES `users` (`marketing_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
