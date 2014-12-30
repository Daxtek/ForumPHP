-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2014 at 02:51 PM
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
-- Table structure for table `catégorie`
--

CREATE TABLE IF NOT EXISTS `catégorie` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `Titre` varchar(50) CHARACTER SET utf8 NOT NULL,
  `uid` int(11) NOT NULL,
  `Date de creation` date NOT NULL,
  `Description` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`Pseudonyme`, `Mot de passe`, `Mail`, `Date d'inscription`, `Nombre de post`, `Administrateur`, `uid`, `Nom`, `Prenom`) VALUES
('test', 'test', 'sdfsdf', '2014-12-26', 0, 0, 1, 'test', 'test'),
('george', 'test', 'test@test.fr', '2014-12-30', 0, 0, 3, 'test', 'test');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
