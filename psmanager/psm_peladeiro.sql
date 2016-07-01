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
-- Table structure for table `peladeiro`
--

DROP TABLE IF EXISTS `peladeiro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peladeiro` (
  `id_peladeiro` bigint(20) NOT NULL AUTO_INCREMENT,
  `nome_peladeiro` varchar(50) NOT NULL,
  `posicao_predominante` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `data_nascimento` date NOT NULL,
  `altura` decimal(5,2) DEFAULT NULL,
  `peso` decimal(5,2) DEFAULT NULL,
  `data_cadastro` date NOT NULL,
  PRIMARY KEY (`id_peladeiro`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peladeiro`
--

LOCK TABLES `peladeiro` WRITE;
/*!40000 ALTER TABLE `peladeiro` DISABLE KEYS */;
INSERT INTO `peladeiro` VALUES (7,'Eduardo Simões',3,'eduardocsimoes81@gmail.com','1981-03-20',1.89,95.00,'2016-06-07'),(8,'Renzo Souza',5,'renzo@gmail.com','1984-10-19',1.81,75.00,'2016-06-07'),(9,'Geovã Bahia',4,'baiano@gmail.com','1973-07-08',1.68,64.00,'2016-06-07'),(10,'Jefferson',1,'jeffinho@gmail.com','1976-11-25',1.92,88.00,'2016-06-07'),(11,'Lucas',2,'','1986-06-01',1.78,0.00,'2016-06-14'),(12,'Marcus',6,'','1985-06-01',1.67,0.00,'2016-06-14'),(13,'Leslei',6,'','1977-07-01',1.90,0.00,'2016-06-14'),(14,'Rafael',4,'','1988-07-01',1.71,0.00,'2016-06-14'),(15,'Alexandre',6,'','1980-06-01',1.87,0.00,'2016-06-14'),(16,'Ilson',3,'','1983-08-02',1.71,0.00,'2016-06-14'),(17,'Alcino',3,'','1986-08-02',1.70,0.00,'2016-06-14'),(18,'Augusto',2,'','1986-05-01',1.75,0.00,'2016-06-14'),(19,'Vitor',4,'','1986-04-01',1.69,0.00,'2016-06-14'),(20,'Cassio',4,'','1989-08-01',0.00,0.00,'2016-06-14'),(21,'Luiz',2,'','1982-09-01',1.78,0.00,'2016-06-14'),(22,'Fernando',4,'','1989-04-01',1.69,0.00,'2016-06-14'),(23,'Jean',1,'','1984-07-01',1.84,0.00,'2016-06-14'),(24,'Robson',3,'','1985-07-01',1.79,0.00,'2016-06-14'),(25,'Thiago',2,'','1985-08-01',0.00,0.00,'2016-06-14'),(26,'Felipe Carcaça',6,'','1989-05-01',1.79,0.00,'2016-06-14');
/*!40000 ALTER TABLE `peladeiro` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-30  0:30:36
