-- MySQL dump fixed for crm_app
-- ------------------------------------------------------
-- Host: localhost    Database: crm_app
-- Server version 8.0.30

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `crm`;
DROP TABLE IF EXISTS `users`;

-- ======================================================
-- Table: users
-- ======================================================
CREATE TABLE `users` (
  `marketing_id` char(3) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`marketing_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Isi data users
INSERT INTO `users` VALUES
('FRL','Farelfadlillah','farel@rtn.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-27 11:36:07'),
-- (dst, semua data users yang ada di dump awal…)

-- ======================================================
-- Table: crm
-- ======================================================
CREATE TABLE `crm` (
  `company_email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `marketing_id` char(3) COLLATE utf8mb4_general_ci NOT NULL,
  `marketing_person_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact_person_email` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact_person` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact_person_position_title` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone_wa` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `company_website` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `company_category` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact_person_position_category` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `company_industry_type` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_general_ci,
  `city` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `postcode` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('input','wa','emailed','contacted','replied','presentation','CLIENT') COLLATE utf8mb4_general_ci DEFAULT 'input',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`company_email`),
  KEY `marketing_id` (`marketing_id`),
  CONSTRAINT `crm_ibfk_1` FOREIGN KEY (`marketing_id`) REFERENCES `users` (`marketing_id`) 
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Isi data crm
INSERT INTO `crm` VALUES
('Antara@gmail.com','FRL','Farelfadlillah','Example@gmail.com','PT. Anatara','Bpk ...','IT SUPPORT','0811...','antara.com','Public','IT','insurence','Jl...','Jakarta','10410','emailed','2025-08-27 12:16:26','2025-08-27 12:16:39');

SET FOREIGN_KEY_CHECKS=1;

-- Dump selesai, fixed urutan
