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
--

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


CREATE TABLE `track` (
    `id` int NOT NULL AUTO_INCREMENT,
    `title` varchar(80) NOT NULL,
    `artist` varchar(80) NOT NULL,
    `path` varchar(255) NOT NULL,
    `category_id` INT NOT NULL,
    PRIMARY KEY(`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
--
-- Foreign Key Constrait pour la table track :
--
ALTER TABLE `track`
ADD CONSTRAINT fk_track_category FOREIGN KEY (category_id) REFERENCES category (id);
--
-- Contenu de la table `track`
--

INSERT INTO `track` (`id`, `title`,`artist`, `date`, `path`, `category_id`) VALUES
(1, 'Nyan Cat', 'random', 2011, 'nyan-cat.mp3', 4);

INSERT INTO `track` (`id`, `title`,`artist`, `date`, `path`, `category_id`) VALUES
(2, 'Call Me ', 'Blondie', 1980, 'Call-Me.mp3', 3);
-- Structure de la table `user`
