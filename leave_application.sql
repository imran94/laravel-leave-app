-- MariaDB dump 10.19-11.2.2-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: leave_application
-- ------------------------------------------------------
-- Server version	11.2.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` bigint(20) unsigned NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicant`
--

DROP TABLE IF EXISTS `applicant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applicant` (
  `id` bigint(20) unsigned NOT NULL,
  `achievements` varchar(255) NOT NULL,
  `degree` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `school` varchar(255) NOT NULL,
  `years` int(11) NOT NULL,
  `file_id` bigint(20) unsigned NOT NULL,
  `job_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK5d7h7p1eyo4v4t0by9axldlad` (`file_id`),
  KEY `FKt74cl2p3amxj0ukd6ngwdryvl` (`job_id`),
  CONSTRAINT `FK5d7h7p1eyo4v4t0by9axldlad` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`),
  CONSTRAINT `FKt74cl2p3amxj0ukd6ngwdryvl` FOREIGN KEY (`job_id`) REFERENCES `job` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicant`
--

LOCK TABLES `applicant` WRITE;
/*!40000 ALTER TABLE `applicant` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `branch`
--

DROP TABLE IF EXISTS `branch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `branch` (
  `id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `company_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK_2qdmejoguc37exo9i2fjxb0qo` (`name`),
  KEY `FK14f9k065wqeubl6tl0gdumcp5` (`company_id`),
  CONSTRAINT `FK14f9k065wqeubl6tl0gdumcp5` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `branch`
--

LOCK TABLES `branch` WRITE;
/*!40000 ALTER TABLE `branch` DISABLE KEYS */;
INSERT INTO `branch` VALUES
(1,'Pakistan',1),
(2,'Malaysia',1);
/*!40000 ALTER TABLE `branch` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company` (
  `id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK_niu8sfil2gxywcru9ah3r4ec5` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company`
--

LOCK TABLES `company` WRITE;
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
INSERT INTO `company` VALUES
(1,'Enron');
/*!40000 ALTER TABLE `company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `department` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `branch_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FKbjh7jsn9p35t0809q9ei5ox61` (`branch_id`),
  CONSTRAINT `FKbjh7jsn9p35t0809q9ei5ox61` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES
(1,'Products',1),
(2,'DevOps',1),
(3,'Business Development',1),
(4,'Management',1),
(5,'Alpha',1),
(6,'Sales',1),
(7,'Development',2),
(8,'DevOps',2),
(9,'Business Development',2),
(10,'Finance & Admin',2),
(11,'Alpha',2),
(12,'Sales',2),
(13,'EasyDukan',1);
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `designation`
--

DROP TABLE IF EXISTS `designation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `designation` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `deptId` bigint(20) unsigned NOT NULL,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_deptId_departement_id` (`deptId`),
  CONSTRAINT `FK_deptId_departement_id` FOREIGN KEY (`deptId`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `designation`
--

LOCK TABLES `designation` WRITE;
/*!40000 ALTER TABLE `designation` DISABLE KEYS */;
INSERT INTO `designation` VALUES
(1,1,'Software Engineer-I'),
(2,1,'Software Engineer-II'),
(3,1,'Lead Development'),
(4,1,'Head of Dept'),
(5,2,'Manager services and Software'),
(6,2,'Team Lead'),
(7,5,'System Engineer-I'),
(8,5,'System Engineer-II'),
(9,2,'Software Engineer-I'),
(10,2,'Software Engineer-II'),
(11,2,'DevOps Engineer'),
(12,2,'Lead DevOps'),
(13,3,'Key Account Manager'),
(14,3,'Pre-sales Manager'),
(15,3,'Business Development Manager'),
(16,6,'VP Sales'),
(17,4,'Director'),
(18,4,'Manager Group Finance'),
(19,4,'Manager HR'),
(20,4,'Admin Assistant'),
(22,5,'Team lead'),
(23,2,'Robotic Engineer'),
(24,4,'CEO'),
(25,1,'Senior Software Engineer'),
(26,5,'Senior System Engineer'),
(27,4,'Accounts Executive'),
(28,7,'Software Engineer-I'),
(29,7,'Software Engineer-II'),
(30,7,'Lead Development'),
(31,7,'Head of Dept'),
(32,8,'Manager Services and Software'),
(33,8,'Team Lead'),
(34,11,'Systems Engineer-I'),
(35,11,'Systems Engineer-II'),
(36,8,'Software Engineer-I'),
(37,8,'Software Engineer-II'),
(38,8,'DevOps Engineer'),
(39,8,'Lead DevOps'),
(40,9,'Key Account Manager'),
(41,9,'Pre-Sales Manager'),
(42,9,'Business Development Manager'),
(43,12,'VP Sales'),
(44,10,'Director'),
(45,10,'Group Finance Manager'),
(46,10,'HR Manager'),
(47,10,'Admin Assistant'),
(48,11,'Team Lead'),
(49,8,'Robotic Engineer'),
(50,10,'CEO'),
(51,7,'Senior Software Engineer'),
(52,11,'Senior System Engineer'),
(53,10,'Accounts Executive'),
(54,7,'Front-End Developer'),
(55,7,'Back-End Developer'),
(56,9,'Business Development'),
(57,1,'UI/UX Engineer'),
(58,13,'Data Entry'),
(59,13,'SEO'),
(60,13,'Business Development'),
(61,13,'Sales Manager'),
(62,13,'UI/UX Engineer'),
(63,13,'QA Engineer');
/*!40000 ALTER TABLE `designation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `file`
--

DROP TABLE IF EXISTS `file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `file` (
  `id` bigint(20) unsigned NOT NULL,
  `data` longblob DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file`
--

LOCK TABLES `file` WRITE;
/*!40000 ALTER TABLE `file` DISABLE KEYS */;
/*!40000 ALTER TABLE `file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hibernate_sequence`
--

DROP TABLE IF EXISTS `hibernate_sequence`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hibernate_sequence` (
  `next_val` bigint(20) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hibernate_sequence`
--

LOCK TABLES `hibernate_sequence` WRITE;
/*!40000 ALTER TABLE `hibernate_sequence` DISABLE KEYS */;
INSERT INTO `hibernate_sequence` VALUES
(1);
/*!40000 ALTER TABLE `hibernate_sequence` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job`
--

DROP TABLE IF EXISTS `job`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job` (
  `id` bigint(20) unsigned NOT NULL,
  `description` varchar(512) NOT NULL,
  `title` varchar(255) NOT NULL,
  `department_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FKhn4ysm8p7xteitn89lhj5c3g7` (`department_id`),
  CONSTRAINT `FKhn4ysm8p7xteitn89lhj5c3g7` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job`
--

LOCK TABLES `job` WRITE;
/*!40000 ALTER TABLE `job` DISABLE KEYS */;
/*!40000 ALTER TABLE `job` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leave_requests`
--

DROP TABLE IF EXISTS `leave_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leave_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `empId` bigint(20) unsigned NOT NULL COMMENT 'foreign key with references users',
  `created_at` date NOT NULL,
  `name` varchar(50) NOT NULL,
  `leaveDate` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `leaves` decimal(3,1) NOT NULL,
  `reason` varchar(500) NOT NULL COMMENT 'reason of leave',
  `status` tinyint(1) DEFAULT 0 COMMENT '1-Approved by HOD, 2-Approve by Admin, 3- Disapproved by HOD, 4- Disapprove by admin, 0-Pending',
  `comment` varchar(500) DEFAULT NULL COMMENT 'approval/disapproval comment',
  `type` varchar(100) NOT NULL,
  `adminComment` varchar(200) DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `lineManagerId` bigint(20) unsigned NOT NULL DEFAULT 1,
  `attachment` varchar(100) DEFAULT NULL,
  `time_period` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_emp_users_id` (`empId`),
  CONSTRAINT `FK_emp_users_id` FOREIGN KEY (`empId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=276 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leave_requests`
--

LOCK TABLES `leave_requests` WRITE;
/*!40000 ALTER TABLE `leave_requests` DISABLE KEYS */;
INSERT INTO `leave_requests` VALUES
(195,53,'2022-03-31','Imran','2022-04-01','2022-04-05',2.0,'Testing. Please disapprove',5,NULL,'Annual leave',NULL,'2022-04-01',23,'','Full Day'),
(200,59,'2022-04-07','Naqiuddeen','2022-05-05','2022-05-06',1.0,'Celebrate Raya Aidilfitri',2,'Selamat Hari Raya','Annual leave','','2022-06-21',57,'','Full Day'),
(201,59,'2022-04-07','Naqiuddeen','2022-05-06','2022-05-09',1.0,'Celebrate raya AidilFitri',2,'Selamat Hari Raya','Annual leave','','2022-06-21',57,'','Full Day'),
(205,59,'2022-04-13','Naqiuddeen','2022-04-29','2022-05-02',1.0,'',2,'Selamat Hari Raya','Annual leave','','2022-06-21',57,'','Full Day'),
(212,71,'2022-04-21','INDRA DEVI','2022-04-25','2022-04-25',0.5,'Daughter second dose vaccination',2,'','Annual leave','','2022-06-21',65,'','AM'),
(221,63,'2022-05-09','Leong Yee Ying','2022-05-05','2022-05-06',1.0,'back hometown',2,NULL,'Annual leave','',NULL,44,'','Full Day'),
(222,63,'2022-05-09','Leong Yee Ying','2022-05-06','2022-05-06',0.5,'',2,NULL,'Annual leave','',NULL,44,'','AM'),
(228,72,'2022-05-19','Muhammad Adnan','2022-05-20','2022-05-24',2.0,'Leave for Wife Hospitalized for Delivery (Paternity Leave)',2,NULL,'Annual leave','Congrats',NULL,36,'leaves/72DR_1652935562.jpeg','Full Day'),
(232,63,'2022-05-30','Leong Yee Ying','2022-06-02','2022-06-03',0.5,'house electricity service',2,NULL,'Annual leave','',NULL,44,'','PM'),
(233,72,'2022-05-30','Muhammad Adnan','2022-05-30','2022-05-31',0.5,'Half Day Leave for Wife Medical Follow-up at 4pm',2,NULL,'Other','Approved',NULL,36,'','PM'),
(243,70,'2022-06-07','HARRY ARIDASAN','2022-06-10','2022-06-13',0.5,'Want to go back hometown for attend family prayers.',2,NULL,'Annual leave','','2022-06-07',65,'','PM'),
(255,63,'2022-07-04','Leong Yee Ying','2022-07-08','2022-07-11',0.5,'back hometown',2,NULL,'Annual leave','Approve','2022-07-04',44,'','PM'),
(266,53,'2022-11-30','Imran','2022-12-01','2022-12-05',2.0,'',5,NULL,'Annual leave',NULL,'2022-11-30',73,'','Full Day'),
(267,53,'2022-11-30','Imran','2022-12-01','2022-12-05',2.0,'',5,'nigga','Annual leave',NULL,'2022-11-30',73,'','Full Day'),
(268,53,'2022-11-30','Imran','2022-12-01','2022-12-05',2.0,'',4,NULL,'Annual leave','','2023-06-27',73,'','Full Day'),
(269,53,'2022-11-30','Imran','2022-12-05','2022-12-08',3.0,'',2,NULL,'Annual leave','','2023-06-27',73,'','Full Day');
/*!40000 ALTER TABLE `leave_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leaves`
--

DROP TABLE IF EXISTS `leaves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leaves` (
  `empId` bigint(20) unsigned NOT NULL,
  `total` int(2) DEFAULT NULL,
  `sickAvailed` decimal(3,1) DEFAULT 0.0,
  `otherAvailed` decimal(3,1) DEFAULT 0.0,
  `annualAvailed` decimal(3,1) DEFAULT 0.0,
  `annualLeft` decimal(3,1) DEFAULT 0.0,
  `year` year(4) NOT NULL,
  `sickLeft` decimal(3,1) NOT NULL DEFAULT 0.0,
  `otherLeft` decimal(3,1) NOT NULL DEFAULT 0.0,
  KEY `leaves_empid_foreign` (`empId`),
  CONSTRAINT `leaves_empid_foreign` FOREIGN KEY (`empId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leaves`
--

LOCK TABLES `leaves` WRITE;
/*!40000 ALTER TABLE `leaves` DISABLE KEYS */;
INSERT INTO `leaves` VALUES
(38,15,0.0,0.0,0.0,15.0,2022,15.0,6.0),
(53,15,0.0,0.0,6.0,9.0,2022,6.0,6.0),
(59,15,0.0,0.0,3.0,12.0,2022,14.0,6.0),
(63,15,0.0,0.0,2.5,12.5,2022,14.0,6.0),
(64,15,0.0,0.0,0.0,15.0,2022,14.0,6.0),
(70,15,0.0,0.0,0.5,14.5,2022,14.0,6.0),
(71,15,0.0,0.0,0.5,14.5,2022,14.0,6.0),
(72,15,1.5,0.5,2.0,13.0,2022,13.5,5.5),
(73,15,2.0,0.0,0.0,15.0,2022,13.0,6.0),
(53,15,0.0,0.0,0.0,5.0,2025,6.0,6.0),
(38,15,0.0,0.0,0.0,15.0,2023,14.0,6.0),
(63,15,0.0,0.0,0.0,15.0,2023,14.0,6.0),
(71,15,0.0,0.0,0.0,15.0,2023,6.0,6.0),
(72,15,0.0,0.0,0.0,15.0,2023,6.0,6.0),
(73,15,0.0,0.0,0.0,15.0,2023,6.0,6.0),
(53,15,0.0,0.0,0.0,15.0,2023,6.0,6.0),
(59,15,0.0,0.0,0.0,15.0,2023,14.0,6.0),
(64,15,0.0,0.0,0.0,15.0,2023,14.0,6.0),
(70,15,0.0,0.0,0.0,15.0,2023,14.0,6.0),
(38,15,0.0,0.0,0.0,15.0,2024,14.0,6.0),
(63,15,0.0,0.0,0.0,15.0,2024,14.0,6.0),
(71,15,0.0,0.0,0.0,15.0,2024,6.0,6.0),
(72,15,0.0,0.0,0.0,15.0,2024,6.0,6.0),
(73,15,0.0,0.0,0.0,15.0,2024,6.0,6.0),
(53,15,0.0,0.0,0.0,15.0,2024,6.0,6.0),
(59,15,0.0,0.0,0.0,15.0,2024,14.0,6.0),
(64,15,0.0,0.0,0.0,15.0,2024,14.0,6.0),
(70,15,0.0,0.0,0.0,15.0,2024,14.0,6.0);
/*!40000 ALTER TABLE `leaves` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'2014_10_12_000000_create_users_table',1),
(2,'2014_10_12_100000_create_password_resets_table',1),
(3,'2021_10_01_151834_add_time_period_to_leave_requests_table',1),
(4,'2022_02_04_140253_add_year_to_leaves_table',1),
(5,'2022_02_04_152418_drop_primary_emp_id_in_leaves_table',1),
(6,'2022_02_14_015539_remove_country_code_from_users_table',1),
(7,'2022_02_14_021421_remove_country_code_from_leave_requests_table',1),
(8,'2022_03_30_145454_add_columns_to_leaves_table',2),
(9,'2022_04_18_124633_change_leaves_table_available_column_type_to_decimals',3),
(10,'2022_04_18_141712_update_leaves_column_in_leave_requests_table',3),
(11,'2022_06_07_132622_update_create_column_in_leave_requests_table',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` VALUES
('nadeem.arif@kalsym.com','$2y$10$pOvpP0Q4VouvQgDqN4NyO.xL1LXl3ZSKffgUlzFF9bYZ2pb5UL2lq','2021-10-04 10:10:47'),
('imran.tariq@kalsym.com','$2y$10$MnvPH5K05h8bI8mtkoV50.aPKPXOoDNVW1pSufKaCfo5.s0/Z2hFe','2022-04-22 05:55:12'),
('taufik@kalsym.com','$2y$10$fOvtkPqI47kXfE62oMkm4OO4JL86KJ5qK0Qhmc22lmE2WSbbhUkmC','2022-05-30 06:26:21');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team_lead`
--

DROP TABLE IF EXISTS `team_lead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team_lead` (
  `id` bigint(20) unsigned NOT NULL,
  `name` varchar(30) NOT NULL,
  `deptId` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_deptId_department_id` (`deptId`),
  CONSTRAINT `FK_deptId_department_id` FOREIGN KEY (`deptId`) REFERENCES `department` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_id_users_id` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_lead`
--

LOCK TABLES `team_lead` WRITE;
/*!40000 ALTER TABLE `team_lead` DISABLE KEYS */;
INSERT INTO `team_lead` VALUES
(38,'Bartholomew',4),
(72,'Danny',10),
(73,'Sam',1);
/*!40000 ALTER TABLE `team_lead` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_pass`
--

DROP TABLE IF EXISTS `user_pass`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_pass` (
  `prefix_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `prefix` varchar(20) NOT NULL,
  `password` varchar(100) DEFAULT NULL COMMENT 'ADMIN:Admin@123, CSR ADMIN: Admin@123, CSR: Csr@1234',
  PRIMARY KEY (`prefix_id`),
  UNIQUE KEY `UNIQUE` (`prefix`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_pass`
--

LOCK TABLES `user_pass` WRITE;
/*!40000 ALTER TABLE `user_pass` DISABLE KEYS */;
INSERT INTO `user_pass` VALUES
(12,'ADMIN','Kalsym@123'),
(13,'EMP','Kalsym@123');
/*!40000 ALTER TABLE `user_pass` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(765) NOT NULL,
  `username` varchar(765) NOT NULL,
  `password` varchar(765) NOT NULL,
  `access_type` int(11) NOT NULL COMMENT '1-Admin, 0-CSR',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1-active , 0-inactive',
  `remember_token` varchar(300) DEFAULT NULL COMMENT 'yeh mein ne majboran kai ha',
  `is_change_pass` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0-not changed,1 changed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `wrong_pass_count` tinyint(1) DEFAULT 0,
  `is_lock` tinyint(1) DEFAULT 0,
  `lock_expired` datetime DEFAULT NULL,
  `designationId` bigint(20) unsigned NOT NULL,
  `prefix_id` bigint(20) unsigned NOT NULL,
  `email` varchar(40) NOT NULL,
  `tlId` bigint(20) unsigned DEFAULT NULL,
  `departmentId` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_pass_prefix_id` (`prefix_id`),
  KEY `fk_department_id` (`departmentId`),
  KEY `fk_user_designation_id` (`designationId`),
  CONSTRAINT `fk_department_id` FOREIGN KEY (`departmentId`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_user_designation_id` FOREIGN KEY (`departmentId`) REFERENCES `designation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_user_pass_prefix_id` FOREIGN KEY (`prefix_id`) REFERENCES `user_pass` (`prefix_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `users_designationid_foreign` FOREIGN KEY (`designationId`) REFERENCES `designation` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(38,'Bartholomew','bart','$2a$12$L1yhNdO7B8AKTeknm/bws.pRTcNvuBz8/JXmuriWMS1uLfhx7u/EC',1,1,'IDLwVpjToo6zZkCa7xViRy3ll5lP92vdhAX2jW2pcz4OoYuNWT4IQyjvldmd',1,'2021-02-17 07:02:56','2022-03-30 08:18:18',0,0,NULL,50,12,'bart@m.com',0,4),
(53,'Irvin','irvin','$2a$12$L1yhNdO7B8AKTeknm/bws.pRTcNvuBz8/JXmuriWMS1uLfhx7u/EC',-2,1,'DqhceIir6sh2v60Yip2qyHLltbdoLg2EM7aHAU1NCNpXS7UliCjOmhORIs3R',1,'2022-02-14 12:03:04','2022-06-09 06:10:53',0,0,NULL,1,13,'irvin@m.com',63,1),
(59,'Norman','norman','$2a$12$L1yhNdO7B8AKTeknm/bws.pRTcNvuBz8/JXmuriWMS1uLfhx7u/EC',-2,1,'JfkFL9iTLvJxiwh8gZ87nyaRAdt7gnnMAbrewELvt6ghkKk81WhOMz36zwB4',1,'2022-03-29 08:17:05','2022-03-29 08:21:09',0,0,NULL,28,13,'norman@m.com',63,7),
(63,'Leon','leon','$2a$12$L1yhNdO7B8AKTeknm/bws.pRTcNvuBz8/JXmuriWMS1uLfhx7u/EC',1,1,'Ji9J70pkhnU8rsfNDmFejAxcaUWDP6Gj46mmaUCB2S26BzgNhpfOtgrHIBXA',1,'2022-04-15 07:47:13','2022-04-15 08:02:33',0,0,NULL,53,12,'leon@m.com',0,10),
(64,'Charles','charles','$2a$12$L1yhNdO7B8AKTeknm/bws.pRTcNvuBz8/JXmuriWMS1uLfhx7u/EC',-2,1,NULL,1,'2022-04-18 04:00:31','2022-07-01 10:14:37',0,0,NULL,56,13,'charles@m.com',63,9),
(70,'Harold','harold','$2a$12$L1yhNdO7B8AKTeknm/bws.pRTcNvuBz8/JXmuriWMS1uLfhx7u/EC',-2,1,NULL,1,'2022-04-18 04:13:57','2022-04-18 04:21:33',0,0,NULL,43,13,'harold@m.com',72,12),
(71,'Indra','indra','$2a$12$L1yhNdO7B8AKTeknm/bws.pRTcNvuBz8/JXmuriWMS1uLfhx7u/EC',-2,1,'XHInnO5ngWd0fnuIIuxQrbxnqVkGXbIceL2BSKrVd8Q6rLYclEPvD0nUH539',1,'2022-04-18 05:55:15','2022-05-06 03:31:23',0,0,NULL,15,12,'indra@m.com',72,3),
(72,'Danny','danny','$2a$12$L1yhNdO7B8AKTeknm/bws.pRTcNvuBz8/JXmuriWMS1uLfhx7u/EC',1,1,'Cih4Yt0Oh7Kx9w8Y5lDFfAVkhxPTSLBzNtBIZkxOmF2SlKYIWawTE6odWX8n',1,'2020-04-14 23:36:42','2022-06-09 06:12:02',0,0,NULL,1,12,'danny@m.com',82,4),
(73,'Sam','sam','$2a$12$L1yhNdO7B8AKTeknm/bws.pRTcNvuBz8/JXmuriWMS1uLfhx7u/EC',0,1,'uySGOUo9xr80Lb8tNXtKuMApHiZcCdl8cRUHjKvEUGJtNlMG2xudxZ5oA907',1,'2021-02-15 23:19:12','2021-06-20 23:00:44',0,0,NULL,4,12,'sam@m.com',0,1);
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

-- Dump completed on 2024-01-23 15:58:52
