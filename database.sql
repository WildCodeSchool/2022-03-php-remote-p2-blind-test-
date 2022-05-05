-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 26 Octobre 2017 à 13:53
-- Version du serveur :  5.7.19-0ubuntu0.16.04.1
-- Version de PHP :  7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


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
(1, 'Rap', 'photo-rap.jpeg'),
(2, 'Pop', 'photo-pop.jpeg'),
(3, 'Années 80', 'photo-80.jpeg'),
(4, 'Meme Song', 'meme.png');

 -- --------------------------------------------------------

--
-- Structure de la table `user`
DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nickname` varchar(80) NOT NULL,
  `image` varchar(255),
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `nickname`) VALUES
(1, 'Trombone');
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
    PRIMARY KEY(`id`)
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
    `is_correct` BOOL NOT NULL,
    `track_id` int NOT NULL,
    PRIMARY KEY(`id`),
    CONSTRAINT fk_answer_track
    FOREIGN KEY (track_id)
    REFERENCES track(id)
);

--
-- Contenu de la table `track`
--

INSERT INTO `track` (`title`,`artist`, `path`, `category_id`) VALUES
    ('Nyan Cat', 'random', 'nyan-cat.mp3', 4),
    ('24kGoldn Mood', 'Iann Dior', '24kGoldn_Mood_iann_dior.mp3', 2),
    ('All We Got', 'Robin Schulz', 'All_We_Got.mp3', 2),
    ('Courage_To_Change', 'Sia', 'Courage_To_Change.mp3', 2),
    ('Del Mar', 'Ozuna & Sia', 'Del_Mar.mp3', 2),
    ('Driver license', 'Olivia Rodrigo', 'drivers_license.mp3', 2),
    ('Je Veux Chanter Pour Ceux', 'Lââm', 'Je_veux_chanter_pour_ceux.mp3', 2),
    ('Love Not War', 'Jason Derulo', 'Love_Not_War.mp3', 2),
    ('Rather Be You', 'Tom Gregory', 'Rather_Be_You.mp3', 2);

--
-- Contenu de la table `answer`
--
INSERT INTO `answer` (`title`, `is_correct`, `track_id`) VALUES
     ('Nyan Cat', true, 1),
     ('24kGoldn Mood', true, 2),
     ('All We Got', true, 3),
     ('Courage_To_Change', true, 4),
     ('Del Mar', true, 5),
     ('Driver license', true, 6),
     ('Je Veux Chanter Pour Ceux', true, 7),
     ('Love Not War', true, 8),
     ('Rather Be You', true, 9);


--
-- Foreign Key Constraint pour les tables :
--

ALTER TABLE `play`
ADD CONSTRAINT fk_play_answer FOREIGN KEY (answer_id) REFERENCES answer (id);

ALTER TABLE `play`
ADD CONSTRAINT fk_play_quizz_session FOREIGN KEY (quizz_session_id) REFERENCES quizz_session (id);

ALTER TABLE `track`
ADD CONSTRAINT fk_track_category FOREIGN KEY (category_id) REFERENCES category (id);
