-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: crm_app
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `crm`
--

DROP TABLE IF EXISTS `crm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
  CONSTRAINT `crm_ibfk_1` FOREIGN KEY (`marketing_id`) REFERENCES `users` (`marketing_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crm`
--

LOCK TABLES `crm` WRITE;
/*!40000 ALTER TABLE `crm` DISABLE KEYS */;
INSERT INTO `crm` VALUES ('Antara@gmail.com','FRL','Farelfadlillah','Example@gmail.com','PT. Anatara','Bpk ...','IT SUPPORT','0811...','antara.com','Public','IT','insurence','Jl...','Jakarta','10410','emailed','2025-08-27 12:16:26','2025-08-27 12:16:39');
/*!40000 ALTER TABLE `crm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `marketing_id` char(3) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`marketing_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('AGS','Agusti Bahtiar','agusti@rayterton.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-28 09:26:13'),('ASA','Aisyah Ratna Aulia','aisyah@rayterton.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-28 09:26:13'),('BRY','Bryan Syahputra','bryan@rayterton.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-28 09:26:13'),('BTG','Bintang Rayvan','bintang@rayterton.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-28 09:26:13'),('FAR','Farel','farel@example.com','$2y$10$EXAMPLEHASHSHOULDBEGENERATEDIN_PHP','2025-08-27 11:31:19'),('FDL','Fadhal Nurul Azmi','fadhal@rayterton.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-28 09:26:13'),('FRL','Farelfadlillah','farel@rtn.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-27 11:36:07'),('FZL','Fazle Adrevi Bintang Al Farrel','fazle@rayterton.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-28 09:26:13'),('HDN','Hildan Argiansyah','hildan@rayterton.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-28 09:26:13'),('HFA','Haikal Fakhri Agnitian','haikal@rayterton.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-28 09:26:13'),('HNA','Halena Maheswari Viehandini','halena@rayterton.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-28 09:26:13'),('HNF','Hannif Fahmy Fadilah','hannif@rayterton.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-28 09:26:13'),('IBL','Iqbal Hadi Mustafa','iqbal@rayterton.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-28 09:26:13'),('ILY','Firyal Dema Elputri','firyal@rayterton.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-28 09:26:13'),('JMH','Joshua Matthew Hendra','joshua@rayterton.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-28 09:26:13'),('KIY','Kirana Firjal Attakhira','kirana@rayterton.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-28 09:26:13'),('KYD','Kurniawan Yafi Djayakusuma','kurniawan@rayterton.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-28 09:26:13'),('MST','Marsya Safeena Tama','marsya@rayterton.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-28 09:26:13'),('NBL','Muhammad Nabil','nabil@rayterton.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-28 09:26:13'),('PRS','Prasetyo Adi','prasetyo@rayterton.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-28 09:26:13'),('PTR','Rizky Putra Hadi Sarwono','putra@rayterton.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-28 09:26:13'),('RAD','Ristyo Arditto','ristyo@rayterton.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-28 09:26:13'),('RAF','Shaquille Raffalea','raffa@rayterton.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-28 09:26:13'),('RBO','Rhomie Bireuno','rhomie@rayterton.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-28 09:26:13'),('RFK','Rifki Alhaqi','rifki@rayterton.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-28 09:26:13'),('RSV','Achmad Wafiq Risvyan','risvyan@rayterton.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-28 09:26:13'),('RZY','Muhammad Rizky','rizky@rayterton.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-28 09:26:13'),('SYA','Rasya Al Zikri','rasya@rayterton.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-28 09:26:13'),('VIN','Kevin Revaldo','kevin@rayterton.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-28 09:26:13'),('WLD','Muhammad Wildan Ichsanul Akbar','wildan@rayterton.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-28 09:26:13'),('ZFR','Zafira Marvella Rae','zafira@rayterton.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-28 09:26:13'),('ZID','Ahmad Zidan','zidan@rayterton.com','$2y$10$oM1L2.rdmilz70hafNTiz.Gm.q8J6wj3ZDTjo.My6yi4WdltIX0Du','2025-08-28 09:26:13');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-08-28 16:35:33
