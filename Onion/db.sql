/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.4.3-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: socDB
-- ------------------------------------------------------
-- Server version	11.4.3-MariaDB-1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `chat`
--

DROP TABLE IF EXISTS `chat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `receiver_id` (`receiver_id`),
  CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat`
--

LOCK TABLES `chat` WRITE;
/*!40000 ALTER TABLE `chat` DISABLE KEYS */;
INSERT INTO `chat` VALUES
(1,2,3,'test','2024-12-22 13:50:31'),
(2,3,2,'halo arya','2024-12-22 13:51:06'),
(3,3,2,'yuk kita main moba','2024-12-22 14:01:31'),
(4,2,3,'ayo aja kata gwa mah','2024-12-22 14:02:30'),
(5,2,3,'lu udah login ga ?','2024-12-22 14:02:50'),
(6,3,2,'udah gwa','2024-12-22 14:03:03'),
(7,3,2,'hola','2024-12-22 15:54:15'),
(8,2,3,'halo ar','2024-12-22 16:15:48'),
(9,2,3,'halo fer','2024-12-22 16:15:58'),
(10,3,2,'oi kenapa','2024-12-22 16:16:28'),
(11,2,3,'jadi ga login nya','2024-12-22 16:16:44'),
(12,3,2,'jadi','2024-12-22 16:16:51'),
(13,2,3,'woke','2024-12-22 16:16:58'),
(14,3,4,'glady','2024-12-22 16:45:19'),
(15,3,2,'test','2024-12-22 17:08:59'),
(16,4,3,'kenap fer','2024-12-23 06:08:52'),
(17,3,4,'halo glady','2024-12-23 09:37:15'),
(18,3,4,'glady asu','2024-12-23 09:38:09'),
(19,2,3,'halo fer','2024-12-23 11:12:41'),
(20,2,3,'info glady asu','2024-12-23 11:12:52'),
(21,3,5,'🤣','2024-12-23 11:37:13'),
(22,3,2,'yoi ar','2024-12-23 12:16:38'),
(23,4,3,'fer koe bisa dateng ga ntar ?','2024-12-23 13:04:00'),
(24,4,2,'halo ar','2024-12-23 13:52:09'),
(25,2,4,'kenapa glad ?','2024-12-23 13:52:43'),
(26,2,3,'FER LOGIN HOK DONG','2024-12-23 14:33:59'),
(27,3,2,'oke arya','2024-12-23 14:35:25'),
(28,2,3,'test','2024-12-23 18:54:05'),
(29,5,2,'halo ar','2024-12-23 20:47:38'),
(30,5,2,'boleh liat jawaban mu gak ?','2024-12-23 20:47:49'),
(31,2,5,'jawaban apa cok?','2024-12-23 20:48:20'),
(32,5,2,'jawaban tugas PBO','2024-12-23 20:48:44'),
(33,2,5,'oke','2024-12-23 20:48:51'),
(34,5,3,'Halo fer, Bagaimana kabar kamu ?','2024-12-24 07:27:17'),
(35,4,2,'Bagaimana kabar mu ?','2024-12-24 12:36:43'),
(36,4,2,'besok apa bisa kita berbincang bincang sedikit ?','2024-12-24 12:37:03'),
(37,2,4,'kabar aku baik, boleh','2024-12-24 12:37:40'),
(38,2,4,'dimana kita bisa berbincang ?','2024-12-24 12:37:56'),
(39,4,2,'di cafe dekat kampus bagaimana ?','2024-12-24 12:38:14'),
(40,4,2,'aku tunggu sekitar jam 4 sore','2024-12-24 12:38:43'),
(41,2,4,'oke, gasssss','2024-12-24 12:38:57'),
(42,3,2,'<h1><Halo/h1>','2024-12-25 03:56:23'),
(43,3,2,'<script>alert(\"XSS\")</script>','2024-12-25 03:57:03'),
(44,3,2,'<h1>halo</h1>','2024-12-25 03:58:29'),
(45,3,2,'<script>alert(\"halo\")</script>','2024-12-25 03:58:53');
/*!40000 ALTER TABLE `chat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `topup`
--

DROP TABLE IF EXISTS `topup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `topup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `topup_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topup`
--

LOCK TABLES `topup` WRITE;
/*!40000 ALTER TABLE `topup` DISABLE KEYS */;
INSERT INTO `topup` VALUES
(1,2,20000,'2024-12-10 20:16:45','rejected'),
(2,2,20000,'2024-12-10 20:18:36','approved'),
(3,2,20000,'2024-12-10 20:18:38','approved'),
(4,2,20000,'2024-12-11 19:38:40','rejected'),
(5,2,20000,'2024-12-11 19:47:50','approved'),
(6,2,10000,'2024-12-11 19:51:04','approved'),
(7,2,10000,'2024-12-11 19:51:39','approved'),
(8,2,20000,'2024-12-11 20:16:31','approved'),
(9,2,20000,'2024-12-11 20:23:14','approved'),
(10,4,20000,'2024-12-11 22:33:38','approved'),
(11,4,20000,'2024-12-11 22:36:13','approved'),
(12,2,20000,'2024-12-11 22:48:37','approved'),
(13,2,20000,'2024-12-11 22:49:37','rejected'),
(14,4,20000,'2024-12-11 22:51:44','approved'),
(15,4,100000,'2024-12-12 11:05:10','approved'),
(16,3,120000,'2024-12-12 11:12:19','approved'),
(17,5,50000,'2024-12-12 12:27:26','approved'),
(18,5,1000000,'2024-12-12 14:53:07','approved'),
(19,2,20000,'2024-12-18 01:38:40','rejected'),
(20,2,20000,'2024-12-18 01:39:12','rejected'),
(21,2,20000,'2024-12-18 01:39:12','rejected'),
(22,2,20000,'2024-12-18 01:39:12','rejected'),
(23,2,20000,'2024-12-18 01:39:12','rejected'),
(24,2,20000,'2024-12-18 01:39:13','rejected'),
(25,2,20000,'2024-12-18 01:39:46','rejected'),
(26,2,20000,'2024-12-18 01:46:37','rejected'),
(27,2,20000,'2024-12-18 01:56:04','rejected'),
(28,2,20000,'2024-12-18 02:00:26','rejected'),
(29,2,20000,'2024-12-18 02:05:40','rejected'),
(30,2,20000,'2024-12-18 02:16:22','rejected'),
(31,2,20000,'2024-12-18 02:16:23','rejected'),
(32,2,20000,'2024-12-18 02:16:23','rejected'),
(33,2,20000,'2024-12-18 02:19:16','rejected'),
(34,3,20000,'2024-12-18 02:22:53','rejected'),
(35,2,20000,'2024-12-18 02:27:04','rejected'),
(36,2,20000,'2024-12-18 02:28:14','rejected'),
(37,3,20000,'2024-12-18 02:28:48','rejected'),
(38,3,20000,'2024-12-18 02:29:49','rejected'),
(39,3,20000,'2024-12-18 02:30:14','approved'),
(40,2,20000,'2024-12-18 03:15:50','rejected'),
(41,2,20000,'2024-12-18 04:47:31','approved'),
(42,3,20000,'2024-12-18 04:49:04','rejected'),
(43,4,20000,'2024-12-18 05:32:46','rejected'),
(44,2,20000,'2024-12-20 09:38:06','rejected'),
(45,4,20000,'2024-12-20 14:30:44','rejected'),
(46,4,20000,'2024-12-20 14:32:41','rejected'),
(47,4,20000,'2024-12-20 14:33:03','approved'),
(48,4,20000,'2024-12-22 00:25:25','approved'),
(49,2,2000,'2024-12-22 00:51:24','approved'),
(50,2,20000,'2024-12-22 00:55:02','approved'),
(51,1,20000,'2024-12-22 02:26:49','approved'),
(52,4,20000,'2024-12-22 05:22:41','rejected'),
(53,2,50000,'2024-12-24 01:14:34','rejected'),
(54,2,50000,'2024-12-24 01:16:16','rejected'),
(55,2,20000,'2024-12-24 03:34:22','rejected'),
(56,2,10000,'2024-12-24 03:35:20','rejected'),
(57,2,100000,'2024-12-24 03:35:54','rejected'),
(58,2,100000,'2024-12-24 03:37:18','rejected');
/*!40000 ALTER TABLE `topup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transfer`
--

DROP TABLE IF EXISTS `transfer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transfer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`),
  KEY `receiver_id` (`receiver_id`),
  CONSTRAINT `transfer_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  CONSTRAINT `transfer_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transfer`
--

LOCK TABLES `transfer` WRITE;
/*!40000 ALTER TABLE `transfer` DISABLE KEYS */;
INSERT INTO `transfer` VALUES
(1,4,2,20000,'2024-12-12 10:19:43'),
(2,2,4,100000,'2024-12-12 11:10:06'),
(3,3,2,20000,'2024-12-12 11:12:49'),
(4,3,4,20000,'2024-12-12 11:13:08'),
(5,5,2,10000,'2024-12-12 12:29:21'),
(6,5,4,200000,'2024-12-12 14:54:37'),
(7,4,2,20000,'2024-12-18 02:38:55'),
(8,4,2,20000,'2024-12-18 02:39:52'),
(9,4,2,20000,'2024-12-18 02:40:19'),
(10,4,2,20000,'2024-12-18 02:40:35'),
(11,4,2,20000,'2024-12-18 02:41:01'),
(12,4,2,20000,'2024-12-18 02:46:18'),
(13,4,2,20000,'2024-12-18 02:48:39'),
(14,4,2,20000,'2024-12-18 03:12:29'),
(15,4,2,20000,'2024-12-18 03:13:51'),
(16,4,2,20000,'2024-12-18 03:14:30'),
(17,3,4,20000,'2024-12-18 03:16:25'),
(18,2,4,20000,'2024-12-18 04:48:43'),
(19,3,2,20000,'2024-12-18 04:49:21'),
(20,4,2,50000,'2024-12-18 05:32:59'),
(21,5,2,500000,'2024-12-20 08:46:17'),
(22,2,2,20000,'2024-12-24 01:11:14'),
(23,2,3,100000,'2024-12-24 01:11:49');
/*!40000 ALTER TABLE `transfer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `balance` decimal(15,2) DEFAULT 0.00,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'Admin','admin','admin@example.com','admin','Jl. Default No.1, Anywhere','admin',20000.00),
(2,'Arya Putra','arya','arya@example.com','arya123','Jl. Bali No.1, Denpasar','user',562000.00),
(3,'Fergo','fergo','fergo@example.com','fergo123','Jl. Uluwatu No.8, Jimbaran','user',220000.00),
(4,'Glady','glady','glady@example.com','glady123','Jl. Mawar No.2, Yogyakarta','user',380000.00),
(5,'Hanif','hanif','hanif@example.com','hanif123','Jl. Kamboja No.3, Bantul','user',350000.00);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2024-12-25 20:08:43
