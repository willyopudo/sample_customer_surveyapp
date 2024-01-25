-- MySQL dump 10.13  Distrib 8.0.32, for Linux (x86_64)
--
-- Host: localhost    Database: survey_db
-- ------------------------------------------------------
-- Server version	8.0.35-0ubuntu0.22.04.1

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
-- Table structure for table `answers`
--

DROP TABLE IF EXISTS `answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = latin1 */;
CREATE TABLE `answers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `survey_id` int NOT NULL,
  `user_id` int NOT NULL,
  `answer` text NOT NULL,
  `question_id` int NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `survey_user_id` int NOT NULL,
  `survey_service_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci a;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answers`
--

LOCK TABLES `answers` WRITE;
/*!40000 ALTER TABLE `answers` DISABLE KEYS */;
INSERT INTO `answers` VALUES (33,1,6,'rtyyyy',4,'2024-01-23 21:48:18',30,0),(34,1,6,'[dOeJi]',2,'2024-01-23 21:48:18',30,0),(35,1,6,'esNuP',1,'2024-01-23 21:48:18',30,0),(36,1,6,'was good',4,'2024-01-23 21:49:17',31,0),(37,1,6,'[zZpTE]',2,'2024-01-23 21:49:17',31,0),(38,1,6,'esNuP',1,'2024-01-23 21:49:17',31,0),(39,2,6,'VvwCQ',5,'2024-01-23 21:58:26',32,0),(40,2,6,'[YlMkx],[wFAVn]',7,'2024-01-23 21:58:26',32,0),(41,2,6,'nice service',6,'2024-01-23 21:58:26',32,0),(42,2,6,'eqMCY',8,'2024-01-23 21:58:26',32,0),(43,2,6,'MyoOm',9,'2024-01-23 21:58:26',32,0),(44,2,6,'QFjlN',10,'2024-01-23 21:58:26',32,0),(45,2,6,'TpURl',5,'2024-01-23 22:11:17',35,0),(46,2,6,'[wFAVn],[RtOLz]',7,'2024-01-23 22:11:17',35,0),(47,2,6,'Excelent service',6,'2024-01-23 22:11:17',35,0),(48,2,6,'TJBrc',8,'2024-01-23 22:11:17',35,0),(49,2,6,'MyoOm',9,'2024-01-23 22:11:17',35,0),(50,2,6,'ZencO',10,'2024-01-23 22:11:17',35,0),(51,2,1,'VvwCQ',5,'2024-01-25 22:11:54',38,3),(52,2,1,'[SRYBa],[RtOLz]',7,'2024-01-25 22:11:54',38,3),(53,2,1,'Very nice service',6,'2024-01-25 22:11:54',38,3),(54,2,1,'eqMCY',8,'2024-01-25 22:11:54',38,3),(55,2,1,'ZjKCX',10,'2024-01-25 22:11:54',38,3),(56,2,1,'VvwCQ',5,'2024-01-25 22:36:16',40,4),(57,2,1,'[YlMkx],[wFAVn]',7,'2024-01-25 22:36:16',40,4),(58,2,1,'nice',6,'2024-01-25 22:36:16',40,4),(59,2,1,'eqMCY',8,'2024-01-25 22:36:17',40,4),(60,2,1,'spJBG',10,'2024-01-25 22:36:17',40,4);
/*!40000 ALTER TABLE `answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = latin1 */;
CREATE TABLE `questions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `frm_option` text NOT NULL,
  `type` varchar(50) NOT NULL,
  `order_by` int NOT NULL,
  `survey_id` int NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci a;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (1,'Sample Survey Question using Radio Button','{\"cKWLY\":\"Option 1\",\"esNuP\":\"Option 2\",\"dAWTD\":\"Option 3\",\"eZCpf\":\"Option 4\"}','radio_opt',3,1,'2020-11-10 12:04:46'),(2,'Question for Checkboxes','{\"qCMGO\":\"Checkbox label 1\",\"JNmhW\":\"Checkbox label 2\",\"zZpTE\":\"Checkbox label 3\",\"dOeJi\":\"Checkbox label 4\"}','check_opt',2,1,'2020-11-10 12:25:13'),(4,'Sample question for the text field','','textfield_s',1,1,'2020-11-10 13:34:21'),(5,'Did you leave a tip?','{\"VvwCQ\":\"Yes\",\"TpURl\":\"No\"}','radio_opt',1,2,'2024-01-13 20:58:56'),(6,'Describe your experience in a few words :) ','','textfield_s',3,2,'2024-01-13 21:03:31'),(7,'Which of the following dishes did you take?','{\"SRYBa\":\"Fried Chicken\",\"YlMkx\":\"Fish Fillets\",\"wFAVn\":\"Rice\",\"dAfrx\":\"Grilled Beef\",\"RtOLz\":\"Roated tomamto\"}','check_opt',2,2,'2024-01-14 12:46:20'),(8,'Sample question','{\"eqMCY\":\"qw\",\"TJBrc\":\"er\"}','radio_opt',4,2,'2024-01-14 15:53:03'),(10,'How much would you recomend a friend','{\"RinVY\":\"0\",\"inline\":\"1\",\"xmLJW\":\"1\",\"ZozuF\":\"2\",\"ACjaU\":\"3\",\"WLjHu\":\"4\",\"UOkFG\":\"5\",\"ceWio\":\"6\",\"rsjLn\":\"7\",\"spJBG\":\"8\",\"ZjKCX\":\"9\",\"TOgUd\":\"10\"}','radio_opt',6,2,'2024-01-14 16:12:31');
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `survey_service`
--

DROP TABLE IF EXISTS `survey_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = latin1 */;
CREATE TABLE `survey_service` (
  `id` int NOT NULL AUTO_INCREMENT,
  `storenumber` varchar(45) NOT NULL,
  `servicedate` datetime NOT NULL,
  `transactionnumber` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci a;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `survey_service`
--

LOCK TABLES `survey_service` WRITE;
/*!40000 ALTER TABLE `survey_service` DISABLE KEYS */;
INSERT INTO `survey_service` VALUES (1,'3737930','2024-01-24 08:16:00','17FGHTR653222'),(2,'3737931','2024-01-23 09:11:00','17FGHTR653222'),(3,'3737931','2024-01-23 09:13:00','17FGHTR653222'),(4,'3738232','2024-01-22 12:12:00','54WUKD54G4378');
/*!40000 ALTER TABLE `survey_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `survey_set`
--

DROP TABLE IF EXISTS `survey_set`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = latin1 */;
CREATE TABLE `survey_set` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `user_id` int NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci a;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `survey_set`
--

LOCK TABLES `survey_set` WRITE;
/*!40000 ALTER TABLE `survey_set` DISABLE KEYS */;
INSERT INTO `survey_set` VALUES (1,'Sample Survey','Sample Only',0,'2024-01-15','2024-02-11','2020-11-10 09:57:47'),(2,'SUBZ Listens','Your feedback is extremely valuable to us, so please complete our 1-minute survey and tell us about your recent SUBZ® visit. A valid receipt is required and you have 5 days from your purchase to complete the survey. Since your satisfaction is our main priority, we may contact you to ensure that your next visit is even better. * required fields',0,'2024-02-25','2024-03-16','2020-11-10 14:12:09'),(3,'Survey 2','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec in tempus turpis, sed fermentum risus. Praesent vitae velit rutrum, dictum massa nec, pharetra felis. ',0,'2020-09-01','2020-11-27','2020-11-10 14:12:33'),(4,'Survey 23','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec in tempus turpis, sed fermentum risus. Praesent vitae velit rutrum, dictum massa nec, pharetra felis. ',0,'2020-09-10','2020-11-27','2020-11-10 14:14:03'),(5,'Sample Survey 101','Sample only',0,'2020-10-01','2020-11-23','2020-11-10 14:14:29');
/*!40000 ALTER TABLE `survey_set` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `survey_user`
--

DROP TABLE IF EXISTS `survey_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = latin1 */;
CREATE TABLE `survey_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(60) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) DEFAULT NULL,
  `survey_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_survey_id` (`email`,`survey_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci a;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `survey_user`
--

LOCK TABLES `survey_user` WRITE;
/*!40000 ALTER TABLE `survey_user` DISABLE KEYS */;
INSERT INTO `survey_user` VALUES (30,'opudowilfred@yahoo.com','wilfred','opudo',1),(31,'opudowilfred@yahoo.com1','wilfred','opudo',1),(32,'opudowilfred@yahoo.com','wilfred','opudo',2),(33,'opudowilfred@yahoo.com3','wilfred','opudo',2),(34,'opudowilfred@yahoo.com4','wilfred','opudo',2),(35,'opudowilfred@yahoo.com5','wilfred','opudo',2),(36,'Opudowilfred.ow@gmail.com','Wilfred','Ouma',2),(38,'Opudowilfred.ow3@gmail.com','Wilfred','Ouma',2),(40,'opudowilfred3@yahoo.com','wilfred','opudo',2);
/*!40000 ALTER TABLE `survey_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = latin1 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `middlename` varchar(200) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '3' COMMENT '1=Admin,2 = Staff, 3= Subscriber',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci a;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','Admin','','+123456789','Sample address','admin@admin.com','0192023a7bbd73250516f069df18b500',1,'2020-11-10 08:43:06'),(2,'John','Smith','D','8747808787','Sample Address','jsmith@sample.com','827ccb0eea8a706c4c34a16891f84e7b',3,'2020-11-10 09:16:53'),(3,'Claire','Blake','D','+6948 8542 623','Sample Address','cblake@sample.com','4744ddea876b11dcb1d169fadf494418',3,'2020-11-10 15:59:11'),(4,'Mike','Williams','G','8747808787','Sample','mwilliams@sample.com','3cc93e9a6741d8b40460457139cf8ced',3,'2020-11-10 16:21:02'),(5,'Willy','Opudo','Ouma','0735337828','Street 01','mock@tester.com','827ccb0eea8a706c4c34a16891f84e7b',3,'2024-01-13 13:17:15'),(6,'Domo','User','','0000000000','demo address','demo@tester.com','e10adc3949ba59abbe56e057f20f883e',3,'2024-01-13 14:23:55');
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

-- Dump completed on 2024-01-25 23:29:32
