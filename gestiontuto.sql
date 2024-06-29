-- MySQL dump 10.13  Distrib 5.7.39, for osx10.12 (x86_64)
--
-- Host: localhost    Database: gestionTuto
-- ------------------------------------------------------
-- Server version	5.7.39

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
-- Table structure for table `etudiant`
--

DROP TABLE IF EXISTS `etudiant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `etudiant` (
  `idEtud` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `password` varchar(256) NOT NULL,
  PRIMARY KEY (`idEtud`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etudiant`
--

LOCK TABLES `etudiant` WRITE;
/*!40000 ALTER TABLE `etudiant` DISABLE KEYS */;
INSERT INTO `etudiant` VALUES (2,'Diallo','Abdoul rich','rich028@gmail.com','d9c7abd2f526dde65e7cf401a11fa19e17d1c45909cb13510693098e67c370f4'),(3,'Diallo','ibrahima Gueye','rich018@gmail.com','d9c7abd2f526dde65e7cf401a11fa19e17d1c45909cb13510693098e67c370f4'),(15,'test1','test2','test1@gmail.com','d9c7abd2f526dde65e7cf401a11fa19e17d1c45909cb13510693098e67c370f4'),(16,'ali','brahim','ali@esp.sn','d9c7abd2f526dde65e7cf401a11fa19e17d1c45909cb13510693098e67c370f4');
/*!40000 ALTER TABLE `etudiant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `etudiant_matiere`
--

DROP TABLE IF EXISTS `etudiant_matiere`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `etudiant_matiere` (
  `idEtud` int(11) NOT NULL,
  `idMat` int(11) NOT NULL,
  PRIMARY KEY (`idEtud`,`idMat`),
  KEY `idMat` (`idMat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etudiant_matiere`
--

LOCK TABLES `etudiant_matiere` WRITE;
/*!40000 ALTER TABLE `etudiant_matiere` DISABLE KEYS */;
INSERT INTO `etudiant_matiere` VALUES (2,2),(2,8),(2,9),(2,10),(2,11);
/*!40000 ALTER TABLE `etudiant_matiere` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expertise`
--

DROP TABLE IF EXISTS `expertise`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expertise` (
  `idExpert` int(11) NOT NULL AUTO_INCREMENT,
  `nomExpert` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idExpert`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expertise`
--

LOCK TABLES `expertise` WRITE;
/*!40000 ALTER TABLE `expertise` DISABLE KEYS */;
INSERT INTO `expertise` VALUES (1,'Expert 1'),(2,'Expert 2'),(3,'Expert 3'),(4,'Expert 4'),(5,'Expert 5');
/*!40000 ALTER TABLE `expertise` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instructeur`
--

DROP TABLE IF EXISTS `instructeur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instructeur` (
  `idInstructeur` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `password` varchar(256) NOT NULL,
  PRIMARY KEY (`idInstructeur`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instructeur`
--

LOCK TABLES `instructeur` WRITE;
/*!40000 ALTER TABLE `instructeur` DISABLE KEYS */;
INSERT INTO `instructeur` VALUES (14,'isaac','Abdoul rich','isaac@gmail.com','d9c7abd2f526dde65e7cf401a11fa19e17d1c45909cb13510693098e67c370f4'),(15,'ali','brahim','hamid@esp.sn','d9c7abd2f526dde65e7cf401a11fa19e17d1c45909cb13510693098e67c370f4'),(16,'ngome','fatou','fatou@esp.sn','d9c7abd2f526dde65e7cf401a11fa19e17d1c45909cb13510693098e67c370f4');
/*!40000 ALTER TABLE `instructeur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instructeurexpertise`
--

DROP TABLE IF EXISTS `instructeurexpertise`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instructeurexpertise` (
  `idInstructeur` int(11) NOT NULL,
  `idExpert` int(11) NOT NULL,
  `isValid` tinyint(1) DEFAULT '0',
  `justificatif` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`idInstructeur`,`idExpert`),
  KEY `idExpert` (`idExpert`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instructeurexpertise`
--

LOCK TABLES `instructeurexpertise` WRITE;
/*!40000 ALTER TABLE `instructeurexpertise` DISABLE KEYS */;
INSERT INTO `instructeurexpertise` VALUES (3,3,0,NULL),(3,4,0,NULL),(4,3,0,NULL),(4,5,0,NULL),(6,2,0,NULL),(7,5,0,NULL),(8,2,0,NULL),(8,4,0,NULL),(9,1,0,NULL),(9,5,0,NULL),(11,1,0,NULL),(11,2,0,NULL),(12,1,0,NULL),(12,2,0,NULL);
/*!40000 ALTER TABLE `instructeurexpertise` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instructeurmatiere`
--

DROP TABLE IF EXISTS `instructeurmatiere`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instructeurmatiere` (
  `idInstructeur` int(11) NOT NULL,
  `idMat` int(11) NOT NULL,
  `justificatif` varchar(255) DEFAULT NULL,
  `isValid` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`idInstructeur`,`idMat`),
  KEY `idMat` (`idMat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instructeurmatiere`
--

LOCK TABLES `instructeurmatiere` WRITE;
/*!40000 ALTER TABLE `instructeurmatiere` DISABLE KEYS */;
INSERT INTO `instructeurmatiere` VALUES (3,7,'Justificatif/668051d1e3692-03simple.pdf',1),(3,8,'Justificatif/668051d1e3692-03simple.pdf',1),(3,10,'Justificatif/668053b69c758-Admin Dashboard.pdf',1),(3,11,'Justificatif/668051d1e3692-03simple.pdf',1),(3,12,'Justificatif/668053b69c758-Admin Dashboard.pdf',1),(8,2,NULL,0),(14,2,'Justificatif/667fdf3f95f3f-Isaac Feglar Fiacre Memini Edou GLSIA.pdf',2),(15,7,'Justificatif/667feda573b89-Isaac Feglar Fiacre Memini Edou GLSIA.pdf',2),(16,7,'Justificatif/668013bbebd55-Isaac Feglar Fiacre Memini Edou GLSIA.pdf',1),(16,9,'Justificatif/668013bbebd55-Isaac Feglar Fiacre Memini Edou GLSIA.pdf',1);
/*!40000 ALTER TABLE `instructeurmatiere` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `instructeursmatierenonvalide`
--

DROP TABLE IF EXISTS `instructeursmatierenonvalide`;
/*!50001 DROP VIEW IF EXISTS `instructeursmatierenonvalide`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `instructeursmatierenonvalide` AS SELECT 
 1 AS `instructeur`,
 1 AS `justificatif`,
 1 AS `matieres`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `lestutoriels`
--

DROP TABLE IF EXISTS `lestutoriels`;
/*!50001 DROP VIEW IF EXISTS `lestutoriels`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `lestutoriels` AS SELECT 
 1 AS `id_tuto`,
 1 AS `chemin`,
 1 AS `instructeur`,
 1 AS `matiere`,
 1 AS `titre`,
 1 AS `niveau`,
 1 AS `description`,
 1 AS `duree`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `matiere`
--

DROP TABLE IF EXISTS `matiere`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `matiere` (
  `idMat` int(11) NOT NULL AUTO_INCREMENT,
  `nomMat` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idMat`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matiere`
--

LOCK TABLES `matiere` WRITE;
/*!40000 ALTER TABLE `matiere` DISABLE KEYS */;
INSERT INTO `matiere` VALUES (2,'Mathematiques'),(7,'trigonometrie'),(8,'Algebre'),(9,'Geometrie'),(10,'Calcul differentiel'),(11,'Statistiques'),(12,'Probabilites');
/*!40000 ALTER TABLE `matiere` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `tutoetudiant`
--

DROP TABLE IF EXISTS `tutoetudiant`;
/*!50001 DROP VIEW IF EXISTS `tutoetudiant`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `tutoetudiant` AS SELECT 
 1 AS `id_tuto`,
 1 AS `chemin`,
 1 AS `instructeur`,
 1 AS `matiere`,
 1 AS `titre`,
 1 AS `niveau`,
 1 AS `description`,
 1 AS `duree`,
 1 AS `idEtud`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `tutoriel`
--

DROP TABLE IF EXISTS `tutoriel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tutoriel` (
  `id_tuto` int(11) NOT NULL AUTO_INCREMENT,
  `chemin` varchar(250) DEFAULT NULL,
  `instructeur` int(11) DEFAULT NULL,
  `matiere` int(11) DEFAULT NULL,
  `titre` varchar(100) DEFAULT NULL,
  `niveau` varchar(100) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `duree` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_tuto`),
  KEY `fk_instruncteur` (`instructeur`),
  KEY `fk_matiere` (`matiere`),
  CONSTRAINT `fk_instruncteur` FOREIGN KEY (`instructeur`) REFERENCES `instructeur` (`idInstructeur`) ON DELETE CASCADE,
  CONSTRAINT `fk_matiere` FOREIGN KEY (`matiere`) REFERENCES `matiere` (`idMat`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tutoriel`
--

LOCK TABLES `tutoriel` WRITE;
/*!40000 ALTER TABLE `tutoriel` DISABLE KEYS */;
INSERT INTO `tutoriel` VALUES (79,'videos/bd6b3b847dd44ae9acfa9169badcd9c5.MP4',14,10,'Calcul differentiel','expert','Calcul differentiel pour les pros','01:30'),(80,'videos/RPReplay_Final1705188741.mov',15,11,'Statistiques 101','debutant','Apprenez les bases des statistiques','00:50'),(85,'videos/RPReplay_Final1700520306.mov',14,9,'Geometrie pour experts','expert','Concepts avances en geometrie','01:10'),(86,'videos/bd6b3b847dd44ae9acfa9169badcd9c5.MP4',15,10,'Techniques de calcul differentiel','expert','Approfondir le calcul differentiel','01:40'),(91,'videos/RPReplay_Final1700520306.mov',14,8,'Les bases de l algebre','debutant','Cours elementaire en algebre','00:50'),(92,'videos/RPReplay_Final1700520306.mov',15,9,'Principes de la geometrie','debutant','Introduction aux formes geometriques','01:00'),(97,'videos/bd6b3b847dd44ae9acfa9169badcd9c5.MP4',14,7,'Trigonometrie en pratique','amateur','Cours pratique en trigonometrie','01:15'),(98,'videos/RPReplay_Final1700520306.mov',15,8,'Problemes d algebre','amateur','Resolution de problemes algebriques','01:05'),(104,'videos/bd6b3b847dd44ae9acfa9169badcd9c5.MP4',14,10,'Calcul differentiel','expert','Calcul differentiel pour les pros','01:30'),(105,'videos/RPReplay_Final1700520306.mov',15,11,'Statistiques 101','debutant','Apprenez les bases des statistiques','00:50'),(110,'videos/bd6b3b847dd44ae9acfa9169badcd9c5.MP4',14,9,'Geometrie pour experts','expert','Concepts avances en geometrie','01:10'),(111,'videos/RPReplay_Final1700520306.mov',15,10,'Techniques de calcul differentiel','expert','Approfondir le calcul differentiel','01:40'),(116,'videos/bd6b3b847dd44ae9acfa9169badcd9c5.MP4',14,8,'Les bases de l algebre','debutant','Cours elementaire en algebre','00:50'),(117,'videos/RPReplay_Final1700520306.mov',15,9,'Principes de la geometrie','debutant','Introduction aux formes geometriques','01:00'),(122,'videos/bd6b3b847dd44ae9acfa9169badcd9c5.MP4',14,7,'Trigonometrie en pratique','amateur','Cours pratique en trigonometrie','01:15'),(123,'videos/RPReplay_Final1700520306.mov',15,8,'Problemes d algebre','amateur','Resolution de problemes algebriques','01:05'),(128,'videos/bd6b3b847dd44ae9acfa9169badcd9c5.MP4',14,10,'Calcul differentiel','expert','Calcul differentiel pour les pros','01:30'),(129,'videos/RPReplay_Final1705188741.mov',15,11,'Statistiques 101','debutant','Apprenez les bases des statistiques','00:50'),(162,'videos/bd6b3b847dd44ae9acfa9169badcd9c5.MP4',16,7,' test avec madame a l\'ecole','debutant',' presentation','0:10');
/*!40000 ALTER TABLE `tutoriel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `instructeursmatierenonvalide`
--

/*!50001 DROP VIEW IF EXISTS `instructeursmatierenonvalide`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`devWeb`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `instructeursmatierenonvalide` AS select concat(`i`.`nom`,' ',`i`.`prenom`) AS `instructeur`,`im`.`justificatif` AS `justificatif`,group_concat(`m`.`nomMat` separator ', ') AS `matieres` from ((`instructeur` `i` join `instructeurmatiere` `im` on((`i`.`idInstructeur` = `im`.`idInstructeur`))) join `matiere` `m` on((`im`.`idMat` = `m`.`idMat`))) where (`im`.`isValid` = 0) group by `i`.`idInstructeur`,`im`.`justificatif` order by `i`.`nom`,`i`.`prenom`,`im`.`justificatif` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `lestutoriels`
--

/*!50001 DROP VIEW IF EXISTS `lestutoriels`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`devWeb`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `lestutoriels` AS select `t`.`id_tuto` AS `id_tuto`,`t`.`chemin` AS `chemin`,concat(`i`.`nom`,' ',`i`.`prenom`) AS `instructeur`,`m`.`nomMat` AS `matiere`,`t`.`titre` AS `titre`,`t`.`niveau` AS `niveau`,`t`.`description` AS `description`,`t`.`duree` AS `duree` from ((`tutoriel` `t` left join `instructeur` `i` on((`t`.`instructeur` = `i`.`idInstructeur`))) left join `matiere` `m` on((`t`.`matiere` = `m`.`idMat`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `tutoetudiant`
--

/*!50001 DROP VIEW IF EXISTS `tutoetudiant`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`devWeb`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `tutoetudiant` AS select `t`.`id_tuto` AS `id_tuto`,`t`.`chemin` AS `chemin`,`t`.`instructeur` AS `instructeur`,`t`.`matiere` AS `matiere`,`t`.`titre` AS `titre`,`t`.`niveau` AS `niveau`,`t`.`description` AS `description`,`t`.`duree` AS `duree`,`em`.`idEtud` AS `idEtud` from ((`etudiant_matiere` `em` join `matiere` `m` on((`em`.`idMat` = `m`.`idMat`))) join `tutoriel` `t` on((`m`.`idMat` = `t`.`matiere`))) */;
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

-- Dump completed on 2024-06-29 18:46:18
