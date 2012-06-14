-- MySQL dump 10.13  Distrib 5.1.61, for debian-linux-gnu (i486)
--
-- Host: localhost    Database: error_js
-- ------------------------------------------------------
-- Server version	5.1.61-0+squeeze1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `error`
--

DROP TABLE IF EXISTS `error`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `error` (
  `error_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `error_msg` text NOT NULL,
  `error_line` int(11) DEFAULT NULL,
  `error_file` text,
  `error_date` datetime NOT NULL,
  `error_browser` varchar(255) NOT NULL,
  `error_count` int(11) NOT NULL DEFAULT '1',
  `status_id` int(11) NOT NULL DEFAULT '1',
  `type_id` int(11) NOT NULL DEFAULT '1',
  `dev_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`error_id`),
  UNIQUE KEY `erreur_id` (`error_id`,`project_id`)
) ENGINE=MyISAM AUTO_INCREMENT=75 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `error`
--

LOCK TABLES `error` WRITE;
/*!40000 ALTER TABLE `error` DISABLE KEYS */;
/*!40000 ALTER TABLE `error` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `error_dev`
--

DROP TABLE IF EXISTS `error_dev`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `error_dev` (
  `dev_id` int(11) NOT NULL AUTO_INCREMENT,
  `dev_name` varchar(65) NOT NULL,
  `dev_solved` int(11) NOT NULL,
  PRIMARY KEY (`dev_id`),
  UNIQUE KEY `dev_id` (`dev_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `error_dev`
--

--
-- L'utilisateur Nobody est obligatoire, sinon ça ne marche pas
--

LOCK TABLES `error_dev` WRITE;
/*!40000 ALTER TABLE `error_dev` DISABLE KEYS */;
INSERT INTO `error_dev` VALUES (1,'Nobody',2147483647);
/*!40000 ALTER TABLE `error_dev` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `error_project`
--

DROP TABLE IF EXISTS `error_project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `error_project` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(255) NOT NULL,
  `project_domain` varchar(255) NOT NULL,
  PRIMARY KEY (`project_id`),
  UNIQUE KEY `site_id` (`project_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `error_project`
--

LOCK TABLES `error_project` WRITE;
/*!40000 ALTER TABLE `error_project` DISABLE KEYS */;
/*!40000 ALTER TABLE `error_project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `error_status`
--

DROP TABLE IF EXISTS `error_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `error_status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(65) NOT NULL,
  PRIMARY KEY (`status_id`),
  UNIQUE KEY `status_id` (`status_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `error_status`
--

LOCK TABLES `error_status` WRITE;
/*!40000 ALTER TABLE `error_status` DISABLE KEYS */;
INSERT INTO `error_status` VALUES (1,'To deal'),(2,'In Progress'),(3,'Treated'),(4,'Urgent');
/*!40000 ALTER TABLE `error_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `error_type`
--

DROP TABLE IF EXISTS `error_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `error_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(65) NOT NULL,
  UNIQUE KEY `type_id` (`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `error_type`
--

LOCK TABLES `error_type` WRITE;
/*!40000 ALTER TABLE `error_type` DISABLE KEYS */;
INSERT INTO `error_type` VALUES (1,'TypeError'),(2,'EvalError'),(3,'RangeError'),(4,'ReferenceError'),(5,'SyntaxError'),(6,'URIError');
/*!40000 ALTER TABLE `error_type` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-04-16 15:30:52
