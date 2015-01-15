-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 15 Janvier 2015 à 21:22
-- Version du serveur :  5.6.16
-- Version de PHP :  5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `forumphp`
--
CREATE DATABASE IF NOT EXISTS `forumphp` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `forumphp`;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `categorie_id` int(11) NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int(11) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `date_creation` datetime NOT NULL,
  PRIMARY KEY (`categorie_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`categorie_id`, `utilisateur_id`, `titre`, `description`, `date_creation`) VALUES
(1, 1, 'PHP', 'Une catégorie pour discuter du PHP', '2015-01-15 21:08:34'),
(2, 1, 'Java', 'La catégorie pour discuter du Java', '2015-01-15 21:09:00'),
(3, 1, 'C++', 'La catégorie sur le C#', '2015-01-15 21:09:26');

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `sujet_id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `texte` text NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `post`
--

INSERT INTO `post` (`post_id`, `sujet_id`, `utilisateur_id`, `texte`, `date_creation`) VALUES
(1, 1, 1, 'Voici les règles de cette catégorie\r\n- Règle 1\r\n- Règle 2\r\n- Règle 3\r\n- Règle 4', '2015-01-15 21:10:26'),
(2, 2, 1, 'Voici les règles de cette catégorie\r\n- Règle 1\r\n- Règle 2\r\n- Règle 3\r\n- Règle 4', '2015-01-15 21:10:52'),
(3, 3, 1, 'Voici les règles de cette catégorie\r\n- Règle 1\r\n- Règle 2\r\n- Règle 3\r\n- Règle 4', '2015-01-15 21:11:13'),
(4, 4, 1, 'J''arrive pas à faire mon echo $maVariable', '2015-01-15 21:12:10'),
(5, 5, 1, 'Comment on prononce ce langage ?', '2015-01-15 21:12:53'),
(6, 4, 2, 'Essaye de voir si $maVariable existe !', '2015-01-15 21:15:38'),
(7, 5, 2, 'Ça ne se prononce pas en fait', '2015-01-15 21:15:57'),
(8, 4, 1, 'Ça marche toujours pas !', '2015-01-15 21:21:01');

-- --------------------------------------------------------

--
-- Structure de la table `sujet`
--

CREATE TABLE IF NOT EXISTS `sujet` (
  `sujet_id` int(11) NOT NULL AUTO_INCREMENT,
  `categorie_id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `ouvert` tinyint(1) NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_fermeture` datetime DEFAULT NULL,
  `premier_post` int(11) DEFAULT NULL,
  `dernier_post` int(11) DEFAULT NULL,
  PRIMARY KEY (`sujet_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `sujet`
--

INSERT INTO `sujet` (`sujet_id`, `categorie_id`, `utilisateur_id`, `titre`, `ouvert`, `date_creation`, `date_fermeture`, `premier_post`, `dernier_post`) VALUES
(1, 1, 1, 'Les règles générales', 0, '2015-01-15 21:10:26', '2015-01-15 21:10:38', 1, 1),
(2, 2, 1, 'Règles générales', 0, '2015-01-15 21:10:52', '2015-01-15 21:10:58', 2, 2),
(3, 3, 1, 'Règles générales', 0, '2015-01-15 21:11:13', '2015-01-15 21:11:18', 3, 3),
(4, 1, 1, 'J''ai un gros problème sur mon PHP. Help me !!!!', 1, '2015-01-15 21:12:10', NULL, 4, 8),
(5, 3, 1, 'Prononcer le C#', 1, '2015-01-15 21:12:53', NULL, 5, 7);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `utilisateur_id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(40) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `date_inscription` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nom` varchar(30) DEFAULT NULL,
  `prenom` varchar(30) DEFAULT NULL,
  `nb_posts` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`utilisateur_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`utilisateur_id`, `pseudo`, `mdp`, `mail`, `admin`, `date_inscription`, `nom`, `prenom`, `nb_posts`) VALUES
(1, 'admin', 'admin', 'admin@site.com', 1, '2015-01-13 13:04:29', 'admin', 'admin', 6),
(2, 'user', 'user', 'user@site.com', 0, '2015-01-15 21:06:53', 'user', 'user', 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
