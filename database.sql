-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 26 Octobre 2017 à 13:53
-- Version du serveur :  5.7.19-0ubuntu0.16.04.1
-- Version de PHP :  7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET GLOBAL time_zone = "+02:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `simple-mvc`
--

-- --------------------------------------------------------
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- --------------------------------------------------------

--
-- Structure de la table `track`
--

--


/* PENSER A FAIRE UN INSERT POUR LA TABLE category */
/* ET AJOUTER : CONSTRAINT fk_track_category FOREIGN KEY (category_id) REFERENCES category(id) */

-- --------------------------------------------------------

--
-- Structure de la table `category`
--
DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image` varchar(255),
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `category`
--

INSERT INTO `category` (`id`, `name`, `image`) VALUES
(1, 'Rock', 'rock.jpg'),
(2, 'Pop', 'photo-pop.jpeg'),
(3, 'Années 80', 'photo-80.jpeg'),
(4, 'Meme Song', 'meme.png');

 -- --------------------------------------------------------

--
-- Structure de la table `user`
DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `nickname` varchar(80) NOT NULL,
  `image` varchar(255) DEFAULT 'perso.png',
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`nickname`, `email`, `password`) VALUES
('Trombone', 'melissa.callejon@yahoo.fr', 'motdepasse');
-- Structure de la table `user`
--

--
-- supprime la table quizz_session si elle existe
DROP TABLE IF EXISTS `quizz_session`;

-- Structure de la table `quizz_session`
--
CREATE TABLE `quizz_session` (
    `id` int NOT NULL AUTO_INCREMENT,
    `startedAt` datetime DEFAULT NULL,
    `endedAt` datetime DEFAULT NULL,
    `user_id` int DEFAULT NULL,
    `score` int DEFAULT 0,
    `category_id` int DEFAULT NULL,
    PRIMARY KEY(`id`),
    CONSTRAINT fk_quizz_session_user
    FOREIGN KEY (user_id)
    REFERENCES user (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Structure de la table `track`
DROP TABLE IF EXISTS `track`;

CREATE TABLE `track` (
    `id` int NOT NULL AUTO_INCREMENT,
    `title` varchar(80) NOT NULL,
    `artist` varchar(80) NOT NULL,
    `path` varchar(255) NOT NULL,
    `category_id` INT NOT NULL,
    PRIMARY KEY(`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Structure de la table `play`
DROP TABLE IF EXISTS `play`;

CREATE TABLE `play` (
    `id` int NOT NULL AUTO_INCREMENT,
    `quizz_session_id` int NOT NULL,
    `answer_id` int NOT NULL,
    PRIMARY KEY(`id`)
);

-- Structure de la table `answer`
DROP TABLE IF EXISTS `answer`;

CREATE TABLE `answer` (
    `id` int NOT NULL AUTO_INCREMENT,
    `title` varchar(150) NOT NULL,
    `track_id` int NOT NULL,
    PRIMARY KEY(`id`)
);



INSERT INTO `track` VALUES (1,'Nyan Cat','random','nyan-cat.mp3',4),(11,'Alugalug Cat','The Kiffness','Alugalug Cat - The Kiffness.mp3',4),(12,'beep beep i\'m a sheep','LildeuceDeuce','Beep Beep I\'m a Sheep - LilDeuceDeuce.mp3',4),(13,'Jeff Bezos','Bo Burnham','Bezos - Bo Burnham.mp3',4),(14,'Carabistouille','Khaled Freak','CARABISTOUILLE  - Khaled Freak.mp3',4),(15,'Castaner','Khaled Freak','Castaner - Khaled Freak.mp3',4),(16,'Dr House','Christophe Hondelatte','Dr House - Christophe Hondelatte .mp3',4),(17,'Epic Sax Guy','Sax Guy','Epic Sax Guy.mp3',4),(18,'Gangnam Style','PSY','GANGNAM STYLE - PSY.mp3',4),(19,'HEYYEYAAEYAAAEYAEYAA','HEYYEYAAEYAAAEYAEYAA','HEYYEYAAEYAAAEYAEYAA.mp3',4),(20,'levan Polkka','Bilal Göregen','levan Polkka - Bilal Göregen.mp3',4),(21,'Never Gonna Give You Up','Rick Astley','Never Gonna Give You Up  - Rick Astley.mp3',4),(22,'numnum Cat','The Kiffness','Numnum Cat - The Kiffness.mp3',4),(23,'Nyan Cat','random','Nyan Cat.mp3',4),(24,'Oh My Dayum','Daym Drops','OH MY DAYUM  - Daym Drops.mp3',4),(25,'One Pound Fish Man','The Kiffness','One Pound Fish Man - The Kiffness.mp3',4),(26,'Trololo','Mr trololo','Trololo song.mp3',4),(27,'Welcome to the internet','Bo Burnham','Welcome to the Internet - Bo Burnham.mp3',4),(28,'White and Nerdy','Al Yankovic','White and Nerdy - Al Yankovic -.mp3',4),(29,'Zol','Max Hurrel','ZOL - Max Hurrell.mp3',4),(30,'Coffin Dance','Vicetone','Coffin Dance - Vicetone.mp3',4),(31,'24kGoldn Mood','Iann Dior','24kGoldn_Mood_iann_dior.mp3',2),(32,'Courage To Change','Sia','Courage_To_Change.mp3',2),(33,'Love Not War','Jason Derulo','Love_Not_War.mp3',2),(34,'Drivers License','Olivia Rodrigo','drivers_license.mp3',2);



/*!40000 ALTER TABLE `answer` DISABLE KEYS */;
INSERT INTO `answer` VALUES (1,'Alugalug Cat',11),(2,'beep beep i\'m a sheep',12),(3,'Jeff Bezos',13),(4,'Carabistouille',14),(5,'Castaner',15),(6,'Dr House',16),(7,'Epic Sax Guy',17),(8,'Gangnam Style',18),(9,'HEYYEYAAEYAAAEYAEYAA',19),(10,'levan Polkka',20),(11,'Never Gonna Give You Up',21),(12,'numnum Cat',22),(13,'Nyan Cat',23),(14,'Oh My Dayum',24),(15,'One Pound Fish Man',25),(16,'Trololo',26),(17,'Welcome to the internet',27),(18,'White and Nerdy',28),(19,'Zol',29),(20,'Coffin Dance',30),(21,'24kGoldn Mood',31),(22,'Courage To Change',32),(23,'Love Not War',33),(24,'Drivers License',34);

INSERT INTO `user` VALUES (2,'default','default','Choan','perso.png'),(3,'default','default','La Tite','perso.png'),(4,'default','default','Mel','perso.png'),(5,'default','default','trueChoan','perso.png'),(6,'default','default','J-F le Boss','perso.png'),(7,'default','default','Jojo','perso.png'),(8,'default','default','MikOP','perso.png'),(9,'default','default','dePhants','perso.png'),(10,'default','default','poutchi','perso.png');

INSERT INTO `quizz_session` VALUES (1,'2022-05-02 19:33:49','2022-05-02 19:34:49',4,5,1),(3,'2022-05-09 19:48:50','2022-05-09 19:51:50',3,4,2),(18,'2022-05-02 16:34:13','2022-05-02 16:37:13',2,10,2),(19,'2022-05-01 16:49:56','2022-05-01 16:52:56',6,16,2),(20,'2022-05-02 16:53:04','2022-05-02 16:56:04',9,15,2),(21,'2022-05-02 16:53:21','2022-05-01 16:56:21',7,9,3),(22,'2022-05-10 16:54:07','2022-05-10 16:57:07',8,13,3),(46,'2022-05-10 18:03:16','2022-05-10 18:06:16',10,16,4);


--
--
-- Foreign Key Constraint pour les tables :
--

ALTER TABLE `play`
ADD CONSTRAINT fk_play_answer FOREIGN KEY (answer_id) REFERENCES answer (id);

ALTER TABLE `play`
ADD CONSTRAINT fk_play_quizz_session FOREIGN KEY (quizz_session_id) REFERENCES quizz_session (id);

ALTER TABLE `track`
ADD CONSTRAINT fk_track_category FOREIGN KEY (category_id) REFERENCES category (id);

ALTER TABLE `answer`
ADD CONSTRAINT fk_answer_track FOREIGN KEY (track_id) REFERENCES track (id) ON DELETE CASCADE;
