-- MySQL dump 10.13  Distrib 8.0.28, for Win64 (x86_64)
--
-- Host: localhost    Database: db_blindtest
-- ------------------------------------------------------
-- Server version	8.0.28

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
-- Table structure for table `answer`
--

DROP TABLE IF EXISTS `answer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `answer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `track_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_answer_track` (`track_id`),
  CONSTRAINT `fk_answer_track` FOREIGN KEY (`track_id`) REFERENCES `track` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answer`
--

LOCK TABLES `answer` WRITE;
/*!40000 ALTER TABLE `answer` DISABLE KEYS */;
INSERT INTO `answer` VALUES (1,'Alugalug Cat',11),(2,'beep beep i\'m a sheep',12),(3,'Jeff Bezos',13),(4,'Carabistouille',14),(5,'Castaner',15),(6,'Dr House',16),(7,'Epic Sax Guy',17),(8,'Gangnam Style',18),(9,'HEYYEYAAEYAAAEYAEYAA',19),(10,'levan Polkka',20),(11,'Never Gonna Give You Up',21),(12,'numnum Cat',22),(13,'Nyan Cat',23),(14,'Oh My Dayum',24),(15,'One Pound Fish Man',25),(16,'Trololo',26),(17,'Welcome to the internet',27),(18,'White and Nerdy',28),(19,'Zol',29),(20,'Coffin Dance',30),(21,'24kGoldn Mood',31),(22,'Courage To Change',32),(23,'Love Not War',33),(24,'Drivers License',34);
/*!40000 ALTER TABLE `answer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Rock','rock.jpg'),(2,'Pop','photo-pop.jpeg'),(3,'Années 80','photo-80.jpeg'),(4,'Meme Song','meme.png');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `play`
--

DROP TABLE IF EXISTS `play`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `play` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quizz_session_id` int NOT NULL,
  `answer_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_play_answer` (`answer_id`),
  KEY `fk_play_quizz_session` (`quizz_session_id`),
  CONSTRAINT `fk_play_answer` FOREIGN KEY (`answer_id`) REFERENCES `answer` (`id`),
  CONSTRAINT `fk_play_quizz_session` FOREIGN KEY (`quizz_session_id`) REFERENCES `quizz_session` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `play`
--

LOCK TABLES `play` WRITE;
/*!40000 ALTER TABLE `play` DISABLE KEYS */;
/*!40000 ALTER TABLE `play` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quizz_session`
--

DROP TABLE IF EXISTS `quizz_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quizz_session` (
  `id` int NOT NULL AUTO_INCREMENT,
  `startedAt` datetime DEFAULT NULL,
  `endedAt` datetime DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `score` int DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_quizz_session_user` (`user_id`),
  CONSTRAINT `fk_quizz_session_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quizz_session`
--

LOCK TABLES `quizz_session` WRITE;
/*!40000 ALTER TABLE `quizz_session` DISABLE KEYS */;
INSERT INTO `quizz_session` VALUES (1,'2022-05-02 19:33:49','2022-05-02 19:34:49',4,5),(3,'2022-05-09 19:48:50','2022-05-09 19:51:50',3,4),(18,'2022-05-02 16:34:13','2022-05-02 16:37:13',2,10),(19,'2022-05-01 16:49:56','2022-05-01 16:52:56',6,16),(20,'2022-05-02 16:53:04','2022-05-02 16:56:04',9,15),(21,'2022-05-02 16:53:21','2022-05-01 16:56:21',7,9),(22,'2022-05-10 16:54:07','2022-05-10 16:57:07',8,13),(46,'2022-05-10 18:03:16','2022-05-10 18:06:16',10,16);
/*!40000 ALTER TABLE `quizz_session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `track`
--

DROP TABLE IF EXISTS `track`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `track` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL,
  `artist` varchar(80) NOT NULL,
  `path` varchar(255) NOT NULL,
  `category_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_track_category` (`category_id`),
  CONSTRAINT `fk_track_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `track`
--

LOCK TABLES `track` WRITE;
/*!40000 ALTER TABLE `track` DISABLE KEYS */;
INSERT INTO `track` VALUES (1,'Nyan Cat','random','nyan-cat.mp3',4),(11,'Alugalug Cat','The Kiffness','Alugalug Cat - The Kiffness.mp3',4),(12,'beep beep i\'m a sheep','LildeuceDeuce','Beep Beep I\'m a Sheep - LilDeuceDeuce.mp3',4),(13,'Jeff Bezos','Bo Burnham','Bezos - Bo Burnham.mp3',4),(14,'Carabistouille','Khaled Freak','CARABISTOUILLE  - Khaled Freak.mp3',4),(15,'Castaner','Khaled Freak','Castaner - Khaled Freak.mp3',4),(16,'Dr House','Christophe Hondelatte','Dr House - Christophe Hondelatte .mp3',4),(17,'Epic Sax Guy','Sax Guy','Epic Sax Guy.mp3',4),(18,'Gangnam Style','PSY','GANGNAM STYLE - PSY.mp3',4),(19,'HEYYEYAAEYAAAEYAEYAA','HEYYEYAAEYAAAEYAEYAA','HEYYEYAAEYAAAEYAEYAA.mp3',4),(20,'levan Polkka','Bilal Göregen','levan Polkka - Bilal Göregen.mp3',4),(21,'Never Gonna Give You Up','Rick Astley','Never Gonna Give You Up  - Rick Astley.mp3',4),(22,'numnum Cat','The Kiffness','Numnum Cat - The Kiffness.mp3',4),(23,'Nyan Cat','random','Nyan Cat.mp3',4),(24,'Oh My Dayum','Daym Drops','OH MY DAYUM  - Daym Drops.mp3',4),(25,'One Pound Fish Man','The Kiffness','One Pound Fish Man - The Kiffness.mp3',4),(26,'Trololo','Mr trololo','Trololo song.mp3',4),(27,'Welcome to the internet','Bo Burnham','Welcome to the Internet - Bo Burnham.mp3',4),(28,'White and Nerdy','Al Yankovic','White and Nerdy - Al Yankovic -.mp3',4),(29,'Zol','Max Hurrel','ZOL - Max Hurrell.mp3',4),(30,'Coffin Dance','Vicetone','Coffin Dance - Vicetone.mp3',4),(31,'24kGoldn Mood','Iann Dior','24kGoldn_Mood_iann_dior.mp3',2),(32,'Courage To Change','Sia','Courage_To_Change.mp3',2),(33,'Love Not War','Jason Derulo','Love_Not_War.mp3',2),(34,'Drivers License','Olivia Rodrigo','drivers_license.mp3',2);
/*!40000 ALTER TABLE `track` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nickname` varchar(80) NOT NULL,
  `image` varchar(255) DEFAULT 'perso.png',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (2,'default','default','Choan','perso.png'),(3,'default','default','La Tite','perso.png'),(4,'default','default','Mel','perso.png'),(5,'default','default','trueChoan','perso.png'),(6,'default','default','J-F le Boss','perso.png'),(7,'default','default','Jojo','perso.png'),(8,'default','default','MikOP','perso.png'),(9,'default','default','dePhants','perso.png'),(10,'default','default','poutchi','perso.png');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-11 14:48:00
