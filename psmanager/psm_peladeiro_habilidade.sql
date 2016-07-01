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
-- Table structure for table `peladeiro_habilidade`
--

DROP TABLE IF EXISTS `peladeiro_habilidade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peladeiro_habilidade` (
  `id_peladeiro` bigint(20) NOT NULL,
  `id_habilidade` int(11) NOT NULL,
  `nivel` decimal(4,2) DEFAULT NULL,
  `data_cadastro` date NOT NULL,
  PRIMARY KEY (`id_peladeiro`,`id_habilidade`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peladeiro_habilidade`
--

LOCK TABLES `peladeiro_habilidade` WRITE;
/*!40000 ALTER TABLE `peladeiro_habilidade` DISABLE KEYS */;
INSERT INTO `peladeiro_habilidade` VALUES (7,1,3.50,'2016-06-14'),(7,3,4.50,'2016-06-30'),(7,5,3.50,'2016-06-30'),(8,1,4.50,'2016-06-14'),(8,2,3.00,'2016-06-30'),(8,5,4.00,'2016-06-30'),(8,6,4.50,'2016-06-30'),(9,1,1.50,'2016-06-14'),(10,1,4.00,'2016-06-14'),(10,2,4.50,'2016-06-30'),(11,1,2.00,'2016-06-14'),(12,1,3.50,'2016-06-14'),(13,1,2.00,'2016-06-14'),(14,1,4.00,'2016-06-14'),(15,1,2.50,'2016-06-14'),(16,1,1.00,'2016-06-14'),(17,1,4.00,'2016-06-14'),(18,1,3.50,'2016-06-14'),(19,1,4.00,'2016-06-14'),(20,1,3.50,'2016-06-14'),(21,1,3.00,'2016-06-14'),(22,1,2.00,'2016-06-14'),(23,1,4.00,'2016-06-14'),(24,1,3.00,'2016-06-14'),(25,1,3.00,'2016-06-14'),(26,1,4.00,'2016-06-14');
/*!40000 ALTER TABLE `peladeiro_habilidade` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-30  0:30:44
