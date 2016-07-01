-- MySQL dump 10.13  Distrib 5.7.9, for Win32 (AMD64)
--
-- Host: localhost    Database: psm
-- ------------------------------------------------------
-- Server version	5.6.17

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
-- Table structure for table `pelada_peladeiro`
--

DROP TABLE IF EXISTS `pelada_peladeiro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pelada_peladeiro` (
  `id_pelada` bigint(20) NOT NULL,
  `id_peladeiro` bigint(20) NOT NULL,
  `data_cadastro` date NOT NULL,
  PRIMARY KEY (`id_pelada`,`id_peladeiro`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pelada_peladeiro`
--

LOCK TABLES `pelada_peladeiro` WRITE;
/*!40000 ALTER TABLE `pelada_peladeiro` DISABLE KEYS */;
INSERT INTO `pelada_peladeiro` VALUES (1,7,'2016-06-12'),(1,9,'2016-06-12'),(1,10,'2016-06-12'),(1,11,'2016-06-14'),(1,12,'2016-06-14'),(1,13,'2016-06-14'),(1,14,'2016-06-14'),(1,15,'2016-06-14'),(1,16,'2016-06-14'),(1,17,'2016-06-14'),(1,18,'2016-06-14'),(1,19,'2016-06-14'),(1,20,'2016-06-14'),(1,21,'2016-06-14'),(1,22,'2016-06-14'),(1,23,'2016-06-14'),(1,24,'2016-06-14'),(1,25,'2016-06-14'),(2,9,'2016-06-12'),(5,7,'2016-06-12'),(5,8,'2016-06-12');
/*!40000 ALTER TABLE `pelada_peladeiro` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-30  0:30:40
