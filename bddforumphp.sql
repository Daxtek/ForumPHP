-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2015 at 09:53 AM
-- Server version: 5.6.17-log
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bddforumphp`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `Titre` varchar(50) CHARACTER SET utf8 NOT NULL,
  `uid` int(11) NOT NULL,
  `Date de creation` date NOT NULL,
  `Description` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`cid`, `Titre`, `uid`, `Date de creation`, `Description`) VALUES
(3, 'Programation', 14, '2015-01-02', 'Viens discuter de programmation informatique !'),
(4, 'Serie TV', 14, '2015-01-02', 'Viens discuter de sÃ©rie TÃ©lÃ© '),
(5, 'Films', 14, '2015-01-02', 'Discutons de film !'),
(8, 'Test', 14, '2015-01-08', 'une catÃ©gorie de test'),
(9, 'Autre test', 14, '2015-01-08', 'un autre test');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `TItre` int(200) NOT NULL,
  `Date de creation` date NOT NULL,
  `Texte` text NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sujet`
--

CREATE TABLE IF NOT EXISTS `sujet` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `Date de création` date NOT NULL,
  `Date de fermeture` date NOT NULL,
  `Titre` varchar(200) CHARACTER SET utf8 NOT NULL,
  `Description` text CHARACTER SET utf8 NOT NULL,
  `Statut` tinyint(1) NOT NULL COMMENT '0 : fermé , 1 : ouvert',
  `Premier post` int(11) NOT NULL COMMENT 'pid du premier post',
  `Dernier post` int(11) NOT NULL COMMENT 'pid du dernier post',
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `sujet`
--

INSERT INTO `sujet` (`sid`, `cid`, `uid`, `Date de création`, `Date de fermeture`, `Titre`, `Description`, `Statut`, `Premier post`, `Dernier post`) VALUES
(1, 1, 14, '2015-01-02', '0000-00-00', 'Test', 'test', 1, 0, 0),
(2, 3, 12, '2015-01-02', '0000-00-00', 'PHP', 'On parle de PHP', 1, 0, 0),
(5, 3, 12, '2015-01-02', '0000-00-00', 'Java', 'Test', 1, 0, 0),
(6, 2, 14, '2015-01-08', '0000-00-00', 'Un sujet test', 'test', 1, 0, 0),
(7, 1, 14, '2015-01-08', '0000-00-00', 'Un autre sujet de test', 'Encore un test', 1, 0, 0),
(8, 6, 14, '2015-01-08', '0000-00-00', 'Encore un test pour le fun', 'youpii', 1, 0, 0),
(9, 1, 14, '2015-01-08', '0000-00-00', 'Java', '', 1, 0, 0),
(11, 2, 14, '2015-01-08', '0000-00-00', 'Java', '', 1, 0, 0),
(12, 3, 14, '2015-01-08', '0000-00-00', 'Test', 'test', 1, 0, 0),
(13, 4, 14, '2015-01-08', '0000-00-00', 'Test', 'un sujet de test', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `Pseudonyme` varchar(20) CHARACTER SET utf8 NOT NULL,
  `Mot de passe` varchar(20) CHARACTER SET utf8 NOT NULL,
  `Mail` varchar(100) CHARACTER SET utf8 NOT NULL,
  `Date d'inscription` date NOT NULL,
  `Nombre de post` int(11) NOT NULL,
  `Administrateur` tinyint(1) NOT NULL COMMENT 'True: Admin , False: Utilisateur lambda ',
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(100) CHARACTER SET utf8 NOT NULL,
  `Prenom` varchar(100) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`Pseudonyme`, `Mot de passe`, `Mail`, `Date d'inscription`, `Nombre de post`, `Administrateur`, `uid`, `Nom`, `Prenom`) VALUES
('test', 'test', 'sdfsdf', '2014-12-26', 0, 0, 1, 'test', 'test'),
('az', 'az', 'az@az.fr', '2014-12-30', 0, 0, 5, 'a', 'az'),
('george', 'az', 'test@test.fr', '2014-12-30', 0, 0, 12, 'aa', 'az'),
('george412', 'az', 'aze@aze.fr', '2014-12-30', 0, 0, 13, 'aa', 'aa'),
('Ploutch', 'azerty', 'dieudonne.loic@gmail.com', '2015-01-02', 0, 1, 14, 'Loïc', 'Dieudonné'),
('JeanMich', 'azerty', 'lol@lol.fr', '2015-01-08', 0, 0, 15, 'Jean', 'Mich');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
