# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.6.14)
# Database: p_welltrail_dev
# Generation Time: 2014-10-02 00:30:04 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table clients
# ------------------------------------------------------------

DROP TABLE IF EXISTS `clients`;

CREATE TABLE `clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;

INSERT INTO `clients` (`id`, `name`, `created_at`, `updated_at`)
VALUES
	(3,'Microsoft Indonesia','2014-09-29 18:04:53','2014-09-29 18:04:53'),
	(4,'Google Indonesia','2014-09-29 18:04:53','2014-09-29 18:04:53');

/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table contacts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contacts`;

CREATE TABLE `contacts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `method` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `start` date NOT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `location_id` int(10) unsigned NOT NULL,
  `employee_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `contacts_client_id_foreign` (`client_id`),
  KEY `contacts_location_id_foreign` (`location_id`),
  KEY `contacts_employee_id_foreign` (`employee_id`),
  CONSTRAINT `contacts_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  CONSTRAINT `contacts_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  CONSTRAINT `contacts_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;

INSERT INTO `contacts` (`id`, `mode`, `method`, `start`, `client_id`, `location_id`, `employee_id`, `created_at`, `updated_at`)
VALUES
	(1,'2','1','2014-06-02',4,1,1,'2014-09-30 08:19:09','2014-09-30 08:19:09');

/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table employees
# ------------------------------------------------------------

DROP TABLE IF EXISTS `employees`;

CREATE TABLE `employees` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `middle_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sex` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `department` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hire_year` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hire_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `health_plan` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` text COLLATE utf8_unicode_ci NOT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `location_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `employees_client_id_foreign` (`client_id`),
  KEY `employees_location_id_foreign` (`location_id`),
  CONSTRAINT `employees_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`),
  CONSTRAINT `employees_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;

INSERT INTO `employees` (`id`, `first_name`, `middle_name`, `last_name`, `sex`, `dob`, `department`, `position`, `hire_year`, `hire_type`, `health_plan`, `image`, `client_id`, `location_id`, `created_at`, `updated_at`)
VALUES
	(1,'Sandi','\'tube\'','Andrian','male','1987-06-05','Software Engineering','Senior Programmer','2013','permanent','Ada aja','',3,1,'2014-09-30 02:23:22','2014-10-01 18:50:41');

/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `groups_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table health_consult
# ------------------------------------------------------------

DROP TABLE IF EXISTS `health_consult`;

CREATE TABLE `health_consult` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(10) unsigned NOT NULL,
  `location_id` int(10) unsigned NOT NULL,
  `employee_id` int(10) unsigned NOT NULL,
  `under_medical_care` int(11) DEFAULT NULL,
  `info` text COLLATE utf8_unicode_ci,
  `topics` text COLLATE utf8_unicode_ci,
  `soap` text COLLATE utf8_unicode_ci,
  `follow_up` int(11) DEFAULT NULL,
  `notes` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `health_consult_client_id_foreign` (`client_id`),
  KEY `health_consult_location_id_foreign` (`location_id`),
  KEY `health_consult_employee_id_foreign` (`employee_id`),
  CONSTRAINT `health_consult_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  CONSTRAINT `health_consult_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  CONSTRAINT `health_consult_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `health_consult` WRITE;
/*!40000 ALTER TABLE `health_consult` DISABLE KEYS */;

INSERT INTO `health_consult` (`id`, `client_id`, `location_id`, `employee_id`, `under_medical_care`, `info`, `topics`, `soap`, `follow_up`, `notes`, `created_at`, `updated_at`)
VALUES
	(1,4,1,1,NULL,'{\"height\":\"168\",\"width\":\"54\",\"bmi\":\"\",\"body-fat\":\"\",\"hydration\":\"\",\"bmr\":\"\",\"visceral-fat\":\"\",\"bone-mass\":\"\",\"muscle-mass\":\"\",\"waist-circumference\":\"\",\"hip-circumference\":\"\",\"thigh-circumference\":\"\",\"arm-circumference\":\"\",\"chest-circumference\":\"\",\"systolic\":\"\",\"diastolic\":\"\",\"heart-rate\":\"\",\"glucose\":\"\",\"total-cho\":\"\",\"hdl\":\"\",\"ldl\":\"\",\"ratio\":\"\",\"triglycerides\":\"\"}','cardiovascular,sleep-disorder','soap-notes',1,'musti difollow up nih','2014-09-30 10:01:44','2014-09-30 10:01:44');

/*!40000 ALTER TABLE `health_consult` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table injury_consult
# ------------------------------------------------------------

DROP TABLE IF EXISTS `injury_consult`;

CREATE TABLE `injury_consult` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(10) unsigned NOT NULL,
  `location_id` int(10) unsigned NOT NULL,
  `employee_id` int(10) unsigned NOT NULL,
  `under_medical_care` int(11) DEFAULT NULL,
  `info` text COLLATE utf8_unicode_ci,
  `topics` text COLLATE utf8_unicode_ci,
  `soap` text COLLATE utf8_unicode_ci,
  `follow_up` int(11) DEFAULT NULL,
  `notes` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `injury_consult_client_id_foreign` (`client_id`),
  KEY `injury_consult_location_id_foreign` (`location_id`),
  KEY `injury_consult_employee_id_foreign` (`employee_id`),
  CONSTRAINT `injury_consult_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  CONSTRAINT `injury_consult_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  CONSTRAINT `injury_consult_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table locations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `locations`;

CREATE TABLE `locations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;

INSERT INTO `locations` (`id`, `name`, `created_at`, `updated_at`)
VALUES
	(1,'DKI Jakarta','2014-09-29 18:04:53','2014-09-29 18:04:53'),
	(2,'Jawa Barat','2014-09-29 18:04:53','2014-09-29 18:04:53');

/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`migration`, `batch`)
VALUES
	('2012_12_06_225921_migration_cartalyst_sentry_install_users',1),
	('2012_12_06_225929_migration_cartalyst_sentry_install_groups',1),
	('2012_12_06_225945_migration_cartalyst_sentry_install_users_groups_pivot',1),
	('2012_12_06_225988_migration_cartalyst_sentry_install_throttle',1),
	('2014_09_29_174757_create_clients_table',2),
	('2014_09_29_180037_create_locations_table',3),
	('2014_09_30_005504_create_employees_table',4),
	('2014_09_30_022716_create_contacts_table',5),
	('2014_09_30_085247_create_health_consult_table',6),
	('2014_09_30_100350_create_injury_table',7),
	('2014_09_30_104806_create_opportunity_consult_table',8),
	('2014_09_30_105935_create_proactive_consult_table',9),
	('2014_09_30_111125_create_well_credit_consult_table',10);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table opportunity_consult
# ------------------------------------------------------------

DROP TABLE IF EXISTS `opportunity_consult`;

CREATE TABLE `opportunity_consult` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(10) unsigned NOT NULL,
  `location_id` int(10) unsigned NOT NULL,
  `employee_id` int(10) unsigned NOT NULL,
  `under_medical_care` int(11) DEFAULT NULL,
  `comment` text COLLATE utf8_unicode_ci,
  `follow_up` int(11) DEFAULT NULL,
  `notes` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `opportunity_consult_client_id_foreign` (`client_id`),
  KEY `opportunity_consult_location_id_foreign` (`location_id`),
  KEY `opportunity_consult_employee_id_foreign` (`employee_id`),
  CONSTRAINT `opportunity_consult_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  CONSTRAINT `opportunity_consult_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  CONSTRAINT `opportunity_consult_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `opportunity_consult` WRITE;
/*!40000 ALTER TABLE `opportunity_consult` DISABLE KEYS */;

INSERT INTO `opportunity_consult` (`id`, `client_id`, `location_id`, `employee_id`, `under_medical_care`, `comment`, `follow_up`, `notes`, `created_at`, `updated_at`)
VALUES
	(1,4,1,1,NULL,'\"Halo!\"',1,'Follow up yeh!','2014-09-30 10:57:18','2014-09-30 10:57:18');

/*!40000 ALTER TABLE `opportunity_consult` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table proactive_consult
# ------------------------------------------------------------

DROP TABLE IF EXISTS `proactive_consult`;

CREATE TABLE `proactive_consult` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(10) unsigned NOT NULL,
  `location_id` int(10) unsigned NOT NULL,
  `employee_id` int(10) unsigned NOT NULL,
  `under_medical_care` int(11) DEFAULT NULL,
  `comment` text COLLATE utf8_unicode_ci,
  `follow_up` int(11) DEFAULT NULL,
  `notes` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `proactive_consult_client_id_foreign` (`client_id`),
  KEY `proactive_consult_location_id_foreign` (`location_id`),
  KEY `proactive_consult_employee_id_foreign` (`employee_id`),
  CONSTRAINT `proactive_consult_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  CONSTRAINT `proactive_consult_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  CONSTRAINT `proactive_consult_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `proactive_consult` WRITE;
/*!40000 ALTER TABLE `proactive_consult` DISABLE KEYS */;

INSERT INTO `proactive_consult` (`id`, `client_id`, `location_id`, `employee_id`, `under_medical_care`, `comment`, `follow_up`, `notes`, `created_at`, `updated_at`)
VALUES
	(1,4,1,1,NULL,'{\"type\":\"comment-1\",\"comment\":\"Test comment!\"}',1,'FU','2014-09-30 11:09:18','2014-09-30 11:09:18');

/*!40000 ALTER TABLE `proactive_consult` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table throttle
# ------------------------------------------------------------

DROP TABLE IF EXISTS `throttle`;

CREATE TABLE `throttle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attempts` int(11) NOT NULL DEFAULT '0',
  `suspended` tinyint(1) NOT NULL DEFAULT '0',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `last_attempt_at` timestamp NULL DEFAULT NULL,
  `suspended_at` timestamp NULL DEFAULT NULL,
  `banned_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `throttle_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `throttle` WRITE;
/*!40000 ALTER TABLE `throttle` DISABLE KEYS */;

INSERT INTO `throttle` (`id`, `user_id`, `ip_address`, `attempts`, `suspended`, `banned`, `last_attempt_at`, `suspended_at`, `banned_at`)
VALUES
	(1,1,NULL,0,0,0,NULL,NULL,NULL);

/*!40000 ALTER TABLE `throttle` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `activation_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activated_at` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `persist_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reset_password_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_activation_code_index` (`activation_code`),
  KEY `users_reset_password_code_index` (`reset_password_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `email`, `password`, `permissions`, `activated`, `activation_code`, `activated_at`, `last_login`, `persist_code`, `reset_password_code`, `first_name`, `last_name`, `created_at`, `updated_at`)
VALUES
	(1,'admin@welltrail.com','$2y$10$F1zsPUJo5smB2.r2prHXAugEQPJ.czNlVlOIGAi0gYtNj/A0Udrpm',NULL,1,NULL,NULL,'2014-10-01 17:43:11','$2y$10$hbNmCW/Tt4fkXJzBb8SbvezXQ9v4jTqXUjy36Ek8yJ2OiBUjgdsku',NULL,'Adm','Welltrail','2014-10-01 17:27:16','2014-10-01 17:43:11');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users_groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users_groups`;

CREATE TABLE `users_groups` (
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table well_credit_consult
# ------------------------------------------------------------

DROP TABLE IF EXISTS `well_credit_consult`;

CREATE TABLE `well_credit_consult` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(10) unsigned NOT NULL,
  `location_id` int(10) unsigned NOT NULL,
  `employee_id` int(10) unsigned NOT NULL,
  `comment` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `well_credit_consult_client_id_foreign` (`client_id`),
  KEY `well_credit_consult_location_id_foreign` (`location_id`),
  KEY `well_credit_consult_employee_id_foreign` (`employee_id`),
  CONSTRAINT `well_credit_consult_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  CONSTRAINT `well_credit_consult_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  CONSTRAINT `well_credit_consult_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `well_credit_consult` WRITE;
/*!40000 ALTER TABLE `well_credit_consult` DISABLE KEYS */;

INSERT INTO `well_credit_consult` (`id`, `client_id`, `location_id`, `employee_id`, `comment`, `created_at`, `updated_at`)
VALUES
	(1,4,1,1,'1,3','2014-09-30 11:21:18','2014-09-30 11:21:18'),
	(2,4,2,1,'1,2','2014-09-30 11:21:51','2014-09-30 11:21:51');

/*!40000 ALTER TABLE `well_credit_consult` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
