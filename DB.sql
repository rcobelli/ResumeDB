# ************************************************************
# Sequel Ace SQL dump
# Version 20056
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: 127.0.0.1 (MySQL 8.1.0)
# Database: resume_db
# Generation Time: 2023-10-22 02:41:16 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table certifications
# ------------------------------------------------------------

DROP TABLE IF EXISTS `certifications`;

CREATE TABLE `certifications` (
  `certification_id` int unsigned NOT NULL AUTO_INCREMENT,
  `internal_certification_name` varchar(25) NOT NULL,
  `external_certification_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `expiration` date DEFAULT NULL,
  PRIMARY KEY (`certification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



# Dump of table education
# ------------------------------------------------------------

DROP TABLE IF EXISTS `education`;

CREATE TABLE `education` (
  `education_id` int unsigned NOT NULL AUTO_INCREMENT,
  `education_internal_name` varchar(25) NOT NULL,
  `institution` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `location` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `result` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `gpa` varchar(5) DEFAULT NULL,
  `description` blob,
  `completion_date` date DEFAULT NULL,
  PRIMARY KEY (`education_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



# Dump of table jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `job_id` int unsigned NOT NULL AUTO_INCREMENT,
  `job_internal_name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `machine_description` blob,
  `human_description` blob,
  `current` tinyint(1) NOT NULL DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `employer_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `location` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`job_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



# Dump of table links
# ------------------------------------------------------------

DROP TABLE IF EXISTS `links`;

CREATE TABLE `links` (
  `link_id` int unsigned NOT NULL AUTO_INCREMENT,
  `link_name` varchar(25) NOT NULL,
  `link_value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`link_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



# Dump of table profile
# ------------------------------------------------------------

DROP TABLE IF EXISTS `profile`;

CREATE TABLE `profile` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(25) NOT NULL,
  `value` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



# Dump of table resume_certifications
# ------------------------------------------------------------

DROP TABLE IF EXISTS `resume_certifications`;

CREATE TABLE `resume_certifications` (
  `rc_id` int unsigned NOT NULL AUTO_INCREMENT,
  `resume_id` int NOT NULL,
  `certification_id` int NOT NULL,
  PRIMARY KEY (`rc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



# Dump of table resume_education
# ------------------------------------------------------------

DROP TABLE IF EXISTS `resume_education`;

CREATE TABLE `resume_education` (
  `re_id` int unsigned NOT NULL AUTO_INCREMENT,
  `resume_id` int NOT NULL,
  `education_id` int NOT NULL,
  PRIMARY KEY (`re_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



# Dump of table resume_jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `resume_jobs`;

CREATE TABLE `resume_jobs` (
  `rj_id` int unsigned NOT NULL AUTO_INCREMENT,
  `job_id` int NOT NULL,
  `resume_id` int NOT NULL,
  PRIMARY KEY (`rj_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



# Dump of table resume_links
# ------------------------------------------------------------

DROP TABLE IF EXISTS `resume_links`;

CREATE TABLE `resume_links` (
  `rl_id` int unsigned NOT NULL AUTO_INCREMENT,
  `resume_id` int NOT NULL,
  `link_id` int NOT NULL,
  PRIMARY KEY (`rl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



# Dump of table resumes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `resumes`;

CREATE TABLE `resumes` (
  `resume_id` int unsigned NOT NULL AUTO_INCREMENT,
  `internal_resume_name` varchar(25) NOT NULL,
  `machine_first` tinyint(1) NOT NULL DEFAULT '1',
  `skills` blob,
  PRIMARY KEY (`resume_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
