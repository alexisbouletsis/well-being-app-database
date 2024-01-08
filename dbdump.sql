-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: well-being_app_db
-- ------------------------------------------------------
-- Server version	8.0.34

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activity`
--

DROP TABLE IF EXISTS `activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity` (
  `activity_id` int NOT NULL,
  `activity_type` varchar(25) NOT NULL,
  `duration` int NOT NULL,
  `activity_date` date NOT NULL,
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity`
--

LOCK TABLES `activity` WRITE;
/*!40000 ALTER TABLE `activity` DISABLE KEYS */;
INSERT INTO `activity` VALUES (65,'Swimming',30,'2021-05-17'),(216,'Yoga',15,'2023-06-17'),(321,'Walking',30,'2022-05-16'),(489,'Back - Biceps',60,'2021-05-19'),(7410,'Running',45,'2021-04-16');
/*!40000 ALTER TABLE `activity` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `activity_BEFORE_INSERT` BEFORE INSERT ON `activity` FOR EACH ROW BEGIN
	IF (NEW.activity_id <= 0) THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'invalid data';
	END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `activity_plan`
--

DROP TABLE IF EXISTS `activity_plan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_plan` (
  `activity_plan_type` enum('Cardiovascular','Strength','Flexibility and Stretching','Balance and Coordination','High-Intensity Interval Training') NOT NULL,
  `activity_id` int NOT NULL,
  `plan_id` int NOT NULL,
  PRIMARY KEY (`activity_plan_type`,`activity_id`),
  KEY `fk_activity_plan_activity1_idx` (`activity_id`),
  KEY `fk_activity_plan_plan1_idx` (`plan_id`),
  CONSTRAINT `fk_activity_plan_activity1` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`activity_id`),
  CONSTRAINT `fk_activity_plan_plan1` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`plan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_plan`
--

LOCK TABLES `activity_plan` WRITE;
/*!40000 ALTER TABLE `activity_plan` DISABLE KEYS */;
INSERT INTO `activity_plan` VALUES ('High-Intensity Interval Training',7410,4),('Flexibility and Stretching',65,11),('Strength',216,45),('Strength',489,127),('Balance and Coordination',321,235);
/*!40000 ALTER TABLE `activity_plan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `biometrics`
--

DROP TABLE IF EXISTS `biometrics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `biometrics` (
  `measurement_date` date NOT NULL,
  `weight` float NOT NULL,
  `height` float NOT NULL,
  `body_fat_percentage` float NOT NULL,
  `muscle_percentage` float NOT NULL,
  `fluid_percentage` float NOT NULL,
  `bone_percentage` float NOT NULL,
  `customer_username` varchar(25) NOT NULL,
  PRIMARY KEY (`measurement_date`,`customer_username`),
  KEY `fk_biometrics_customer1_idx` (`customer_username`),
  CONSTRAINT `fk_biometrics_customer1` FOREIGN KEY (`customer_username`) REFERENCES `customer` (`customer_username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `biometrics`
--

LOCK TABLES `biometrics` WRITE;
/*!40000 ALTER TABLE `biometrics` DISABLE KEYS */;
INSERT INTO `biometrics` VALUES ('2021-05-17',82.821,1.7,27.4,73.1,56.6,14.1,'kostasan'),('2021-07-03',56.23,1.63,24.3,76,52.4,13.8,'proteas'),('2022-07-03',100.2,1.8,30.27,70.2,53.7,14.3,'paris2'),('2022-08-12',72.152,1.82,18,82,60.3,14,'ariadn3'),('2023-04-19',70.203,1.68,30.4,70.8,47.1,13.7,'ilianailiou');
/*!40000 ALTER TABLE `biometrics` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `biometrics_BEFORE_INSERT` BEFORE INSERT ON `biometrics` FOR EACH ROW BEGIN
	IF (NEW.weight <= 0) THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'invalid data';
	END IF;
	IF (NEW.height <= 0) THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'invalid data';
	END IF;
	IF (NEW.body_fat_percentage <= 0) THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'invalid data';
	END IF;
	IF (NEW.muscle_percentage <= 0) THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'invalid data';
	END IF;
	IF (NEW.fluid_percentage <= 0) THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'invalid data';
	END IF;
	IF (NEW.bone_percentage <= 0) THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'invalid data';
	END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer` (
  `customer_username` varchar(25) NOT NULL,
  `name` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `date_of_birth` date NOT NULL,
  `date_of_subscription` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  PRIMARY KEY (`customer_username`),
  UNIQUE KEY `customer_username_UNIQUE` (`customer_username`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES ('ariadn3','Ariadne Papadimitriou','wdwed33','aria.papadim@yahoo.com','1999-03-23','2020-08-22','Female'),('ilianailiou','Iliana Iliopoulou','tata##4141','il.iliou@yahoo.com','1986-11-11','1990-09-09','Other'),('kostasan','Kostas Anastasiou','edewe3','ankos@gmail.com','2010-01-10','2022-03-02','Male'),('paris2','Paris Stoulou','wefwe!@','paris.stoulou@hotmail.com','2005-10-08','2002-08-09','Male'),('proteas','Proteas Iliou','dwed#43#','p.iliou@protonmail.com','1945-03-09','2003-01-02','Male');
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_meets_employee`
--

DROP TABLE IF EXISTS `customer_meets_employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer_meets_employee` (
  `customer_username` varchar(25) NOT NULL,
  `employee_username` varchar(25) NOT NULL,
  `appointment_date` datetime NOT NULL,
  `appointment_type` varchar(25) NOT NULL,
  PRIMARY KEY (`customer_username`,`employee_username`,`appointment_date`),
  KEY `fk_customer_has_employee_employee1_idx` (`employee_username`),
  KEY `fk_customer_has_employee_customer_idx` (`customer_username`),
  CONSTRAINT `fk_customer_has_employee_customer` FOREIGN KEY (`customer_username`) REFERENCES `customer` (`customer_username`),
  CONSTRAINT `fk_customer_has_employee_employee1` FOREIGN KEY (`employee_username`) REFERENCES `employee` (`employee_username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_meets_employee`
--

LOCK TABLES `customer_meets_employee` WRITE;
/*!40000 ALTER TABLE `customer_meets_employee` DISABLE KEYS */;
INSERT INTO `customer_meets_employee` VALUES ('ariadn3','npapad','2023-01-10 19:00:00','New diet plan'),('ilianailiou','ermionidalap','2021-12-20 20:30:00','New activity plan'),('kostasan','nikale','2023-01-10 18:00:00','Evaluation of progress'),('paris2','karajohn','2022-09-29 10:30:00','New activity plan'),('proteas','karajohn','2022-03-17 13:45:00','Somatometry');
/*!40000 ALTER TABLE `customer_meets_employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diet_plan`
--

DROP TABLE IF EXISTS `diet_plan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `diet_plan` (
  `diet_plan_type` enum('Ketogenic','Intermittent','Plant-based','Mediterranean','Vegan','Vegeterian','Pescetarian') NOT NULL,
  `meal_id` varchar(25) NOT NULL,
  `plan_id` int NOT NULL,
  PRIMARY KEY (`diet_plan_type`,`meal_id`),
  KEY `fk_diet_plan_meal1_idx` (`meal_id`),
  KEY `fk_diet_plan_plan1_idx` (`plan_id`),
  CONSTRAINT `fk_diet_plan_meal1` FOREIGN KEY (`meal_id`) REFERENCES `meal` (`meal_id`),
  CONSTRAINT `fk_diet_plan_plan1` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`plan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diet_plan`
--

LOCK TABLES `diet_plan` WRITE;
/*!40000 ALTER TABLE `diet_plan` DISABLE KEYS */;
INSERT INTO `diet_plan` VALUES ('Intermittent','65',4),('Mediterranean','235',11),('Plant-based','21',45),('Pescetarian','84',127),('Ketogenic','8964',265);
/*!40000 ALTER TABLE `diet_plan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee` (
  `employee_username` varchar(25) NOT NULL,
  `name` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `date_of_birth` date NOT NULL,
  `employee_type` enum('Dietitian','Trainer','Doctor') NOT NULL,
  PRIMARY KEY (`employee_username`),
  UNIQUE KEY `employee_username_UNIQUE` (`employee_username`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee`
--

LOCK TABLES `employee` WRITE;
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
INSERT INTO `employee` VALUES ('ermionidalap','Ermioni Dalapera','Starlight!56','ermiDa@protonmail.com','1962-09-10','Doctor'),('johndoe27','John Doe','SecretGarden$42','johnD@yahoo.com','1982-12-09','Dietitian'),('karajohn','Karagiannis Ioannis','SereneRiver*18','karagiannis@gmail.com','1968-09-02','Trainer'),('nikale','Nikolas Aleksandrou','blueSky#23','nalex@gmail.com','1990-03-02','Dietitian'),('npapad','Nikos Papadopoulos','Mountain@67','nikospap@hotmail.com','1985-03-31','Trainer');
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_designs_plan`
--

DROP TABLE IF EXISTS `employee_designs_plan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee_designs_plan` (
  `employee_username` varchar(25) NOT NULL,
  `plan_id` int NOT NULL,
  PRIMARY KEY (`employee_username`,`plan_id`),
  KEY `fk_employee_has_plan_plan1_idx` (`plan_id`),
  KEY `fk_employee_has_plan_employee1_idx` (`employee_username`),
  CONSTRAINT `fk_employee_has_plan_employee1` FOREIGN KEY (`employee_username`) REFERENCES `employee` (`employee_username`),
  CONSTRAINT `fk_employee_has_plan_plan1` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`plan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_designs_plan`
--

LOCK TABLES `employee_designs_plan` WRITE;
/*!40000 ALTER TABLE `employee_designs_plan` DISABLE KEYS */;
INSERT INTO `employee_designs_plan` VALUES ('johndoe27',4),('npapad',11),('ermionidalap',45),('nikale',127),('karajohn',265);
/*!40000 ALTER TABLE `employee_designs_plan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meal`
--

DROP TABLE IF EXISTS `meal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `meal` (
  `meal_id` varchar(25) NOT NULL,
  `meal_name` varchar(25) NOT NULL,
  `calories` int NOT NULL,
  `type` enum('Breakfast','Lunch','Tithe','Dinner') NOT NULL,
  `proteins` float NOT NULL,
  `carbs` float NOT NULL,
  `fat` float NOT NULL,
  `meal_date` date NOT NULL,
  PRIMARY KEY (`meal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meal`
--

LOCK TABLES `meal` WRITE;
/*!40000 ALTER TABLE `meal` DISABLE KEYS */;
INSERT INTO `meal` VALUES ('21','Toast',102,'Tithe',3.2,19.1,1.4,'2021-05-17'),('235','Baked chicken with rice',432,'Lunch',32,31,19,'2021-06-17'),('65','Porridge',267,'Breakfast',9.1,38,8.2,'2023-05-17'),('84','Spinach and banana yogurt',166,'Dinner',9.6,20,4,'2023-08-17'),('8964','Greek spinach and rice',302,'Lunch',8,34,13,'2021-05-19');
/*!40000 ALTER TABLE `meal` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `meal_BEFORE_INSERT` BEFORE INSERT ON `meal` FOR EACH ROW BEGIN
	IF (NEW.meal_id <= 0) THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'invalid data';
	END IF;
	IF (NEW.calories <= 0) THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'invalid data';
	END IF;
	IF (NEW.proteins <= 0) THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'invalid data';
	END IF;
	IF (NEW.carbs <= 0) THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'invalid data';
	END IF;
	IF (NEW.fat <= 0) THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'invalid data';
	END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `medication`
--

DROP TABLE IF EXISTS `medication`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `medication` (
  `medication_dosage` varchar(25) NOT NULL,
  `medication_type` varchar(25) NOT NULL,
  `medication_date_start` date NOT NULL,
  `medication_end_date` date NOT NULL,
  `customer_username` varchar(25) NOT NULL,
  PRIMARY KEY (`medication_dosage`,`medication_date_start`,`customer_username`),
  KEY `fk_medication_customer1_idx` (`customer_username`),
  CONSTRAINT `fk_medication_customer1` FOREIGN KEY (`customer_username`) REFERENCES `customer` (`customer_username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medication`
--

LOCK TABLES `medication` WRITE;
/*!40000 ALTER TABLE `medication` DISABLE KEYS */;
INSERT INTO `medication` VALUES ('20mg','Salospir','2021-03-21','2021-04-14','kostasan'),('2mg','Imodium','2020-12-09','2020-09-16','paris2'),('400mg','Augmentin','2022-12-01','2022-01-30','proteas'),('500mg','Algofren','2021-07-05','2021-05-30','ilianailiou'),('625mg','Medrol','2022-07-02','2022-02-27','kostasan');
/*!40000 ALTER TABLE `medication` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plan`
--

DROP TABLE IF EXISTS `plan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `plan` (
  `plan_id` int NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `customer_username` varchar(25) NOT NULL,
  PRIMARY KEY (`plan_id`,`customer_username`),
  KEY `fk_plan_customer1_idx` (`customer_username`),
  CONSTRAINT `fk_plan_customer1` FOREIGN KEY (`customer_username`) REFERENCES `customer` (`customer_username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plan`
--

LOCK TABLES `plan` WRITE;
/*!40000 ALTER TABLE `plan` DISABLE KEYS */;
INSERT INTO `plan` VALUES (4,'2021-03-19','2021-02-04','paris2'),(11,'2022-08-15','2022-08-30','ariadn3'),(45,'2023-06-04','2023-07-04','ilianailiou'),(46,'2023-07-05','2023-08-04','ilianailiou'),(127,'2021-03-30','2021-09-09','kostasan'),(235,'2021-07-17','2021-03-30','proteas');
/*!40000 ALTER TABLE `plan` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `plan_BEFORE_INSERT` BEFORE INSERT ON `plan` FOR EACH ROW BEGIN
	IF (NEW.plan_id <= 0) THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'invalid data';
	END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Temporary view structure for view `view_1`
--

DROP TABLE IF EXISTS `view_1`;
/*!50001 DROP VIEW IF EXISTS `view_1`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_1` AS SELECT 
 1 AS `username`,
 1 AS `password`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_2`
--

DROP TABLE IF EXISTS `view_2`;
/*!50001 DROP VIEW IF EXISTS `view_2`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_2` AS SELECT 
 1 AS `name`,
 1 AS `start_date`,
 1 AS `end_date`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_3`
--

DROP TABLE IF EXISTS `view_3`;
/*!50001 DROP VIEW IF EXISTS `view_3`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_3` AS SELECT 
 1 AS `appointment_date`,
 1 AS `employee_name`,
 1 AS `customer_name`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_4`
--

DROP TABLE IF EXISTS `view_4`;
/*!50001 DROP VIEW IF EXISTS `view_4`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_4` AS SELECT 
 1 AS `name`,
 1 AS `diet_plan_type`,
 1 AS `activity_plan_type`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_5`
--

DROP TABLE IF EXISTS `view_5`;
/*!50001 DROP VIEW IF EXISTS `view_5`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_5` AS SELECT 
 1 AS `name`,
 1 AS `diet_plan_type`,
 1 AS `activity_plan_type`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_6`
--

DROP TABLE IF EXISTS `view_6`;
/*!50001 DROP VIEW IF EXISTS `view_6`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_6` AS SELECT 
 1 AS `name`,
 1 AS `medication_type`,
 1 AS `weight`*/;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `view_1`
--

/*!50001 DROP VIEW IF EXISTS `view_1`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_1` AS select `customer`.`customer_username` AS `username`,`customer`.`password` AS `password` from `customer` union select `employee`.`employee_username` AS `username`,`employee`.`password` AS `password` from `employee` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_2`
--

/*!50001 DROP VIEW IF EXISTS `view_2`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_2` AS select `customer`.`name` AS `name`,`plan`.`start_date` AS `start_date`,`plan`.`end_date` AS `end_date` from (`customer` join `plan` on((`customer`.`customer_username` = `plan`.`customer_username`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_3`
--

/*!50001 DROP VIEW IF EXISTS `view_3`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_3` AS select `customer_meets_employee`.`appointment_date` AS `appointment_date`,`employee`.`name` AS `employee_name`,`customer`.`name` AS `customer_name` from ((`customer_meets_employee` join `customer` on((`customer`.`customer_username` = `customer_meets_employee`.`customer_username`))) join `employee` on((`employee`.`employee_username` = `customer_meets_employee`.`employee_username`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_4`
--

/*!50001 DROP VIEW IF EXISTS `view_4`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_4` AS select `employee`.`name` AS `name`,`diet_plan`.`diet_plan_type` AS `diet_plan_type`,`activity_plan`.`activity_plan_type` AS `activity_plan_type` from (((`employee_designs_plan` join `employee` on((`employee`.`employee_username` = `employee_designs_plan`.`employee_username`))) join `diet_plan` on((`employee_designs_plan`.`plan_id` = `diet_plan`.`plan_id`))) join `activity_plan` on((`employee_designs_plan`.`plan_id` = `activity_plan`.`plan_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_5`
--

/*!50001 DROP VIEW IF EXISTS `view_5`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_5` AS select `customer`.`name` AS `name`,`diet_plan`.`diet_plan_type` AS `diet_plan_type`,`activity_plan`.`activity_plan_type` AS `activity_plan_type` from (((`plan` join `customer` on((`customer`.`customer_username` = `plan`.`customer_username`))) join `diet_plan` on((`diet_plan`.`plan_id` = `plan`.`plan_id`))) join `activity_plan` on((`plan`.`plan_id` = `activity_plan`.`plan_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_6`
--

/*!50001 DROP VIEW IF EXISTS `view_6`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_6` AS select `customer`.`name` AS `name`,`medication`.`medication_type` AS `medication_type`,`biometrics`.`weight` AS `weight` from ((`customer` join `medication` on((`customer`.`customer_username` = `medication`.`customer_username`))) join `biometrics` on((`customer`.`customer_username` = `biometrics`.`customer_username`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-01-08 20:26:14
