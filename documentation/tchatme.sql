-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 12 Juin 2017 à 10:42
-- Version du serveur :  5.6.15-log
-- Version de PHP :  5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `tchatme`
--
CREATE DATABASE IF NOT EXISTS `tchatme` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tchatme`;

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `idMessage` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(250) NOT NULL,
  `dateMessage` date NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `idTchat_room` int(11) NOT NULL,
  PRIMARY KEY (`idMessage`),
  KEY `idUtilisateur` (`idUtilisateur`,`idTchat_room`),
  KEY `idTchat_room` (`idTchat_room`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `sontamis`
--

DROP TABLE IF EXISTS `sontamis`;
CREATE TABLE IF NOT EXISTS `sontamis` (
  `idUtilisateur_estAmi` int(11) NOT NULL,
  `idUtilisateur_de` int(11) NOT NULL,
  `raison` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idUtilisateur_estAmi`,`idUtilisateur_de`),
  KEY `idUtilisateur_estAmi` (`idUtilisateur_estAmi`),
  KEY `idUtilisateur_de` (`idUtilisateur_de`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `sontamis`
--

INSERT INTO `sontamis` (`idUtilisateur_estAmi`, `idUtilisateur_de`, `raison`) VALUES
(1, 9, NULL),
(1, 10, NULL),
(1, 11, 'hello'),
(8, 10, NULL),
(9, 1, NULL),
(10, 1, NULL),
(10, 8, NULL),
(11, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `sontpresents`
--

DROP TABLE IF EXISTS `sontpresents`;
CREATE TABLE IF NOT EXISTS `sontpresents` (
  `idUtilisateur` int(11) NOT NULL,
  `idTchat_room` int(11) NOT NULL,
  KEY `idUtilisateur` (`idUtilisateur`,`idTchat_room`),
  KEY `sontpresents_ibfk_2` (`idTchat_room`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `sontpresents`
--

INSERT INTO `sontpresents` (`idUtilisateur`, `idTchat_room`) VALUES
(1, 1),
(1, 2),
(1, 18),
(10, 19);

-- --------------------------------------------------------

--
-- Structure de la table `tchat_rooms`
--

DROP TABLE IF EXISTS `tchat_rooms`;
CREATE TABLE IF NOT EXISTS `tchat_rooms` (
  `idTchat_room` int(11) NOT NULL AUTO_INCREMENT,
  `nomTchat_room` varchar(25) NOT NULL,
  `dureeVieTchat_room` date NOT NULL,
  `descritpionTchat_room` varchar(500) NOT NULL,
  `vignetteTchat_room` varchar(50) NOT NULL,
  PRIMARY KEY (`idTchat_room`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Contenu de la table `tchat_rooms`
--

INSERT INTO `tchat_rooms` (`idTchat_room`, `nomTchat_room`, `dureeVieTchat_room`, `descritpionTchat_room`, `vignetteTchat_room`) VALUES
(1, 'première tchatRoom', '2010-00-00', 'Bonjour, ceci est la première tchat room. je suis content que vous soyez entrer dans cette tchatRoom.\r\nJe vous souhaite une bonne discussion', '1.png'),
(2, 'deuxième TchatRoom', '2010-00-00', 'Voici la deuxième', '2.png'),
(18, 'Salut ', '2019-12-13', 'asadd', '18.jpeg'),
(19, 'tchat room kambi', '2020-12-13', 'hello, ici la tchat room de kambi', '19.png');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `nomUtilisateur` varchar(25) NOT NULL,
  `prenomUtilisateur` varchar(25) NOT NULL,
  `pseudoUtilisateur` varchar(25) NOT NULL,
  `emailUtilisateur` varchar(50) NOT NULL,
  `mdpUtilisateur` varchar(100) NOT NULL,
  `avatarUtilisateur` varchar(50) NOT NULL,
  PRIMARY KEY (`idUtilisateur`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`idUtilisateur`, `nomUtilisateur`, `prenomUtilisateur`, `pseudoUtilisateur`, `emailUtilisateur`, `mdpUtilisateur`, `avatarUtilisateur`) VALUES
(1, 'Antenen', 'Pierrick', 'pierrick1213', 'pierrickantenen@gmail.com', 'f6889fc97e14b42dec11a8c183ea791c5465b658', 'pierrick1213.jpg'),
(8, 'Trifunovic', 'Ivan', 'ivan', 'ivan@gmail.com', 'f6889fc97e14b42dec11a8c183ea791c5465b658', 'ivan.jpeg'),
(9, 'Pipolo', 'Loick', 'loick', 'loick@gmail.com', 'f6889fc97e14b42dec11a8c183ea791c5465b658', 'loick.jpeg'),
(10, 'Kamber', 'Christophe', 'kambi', 'christophe@kamber.com', 'f6889fc97e14b42dec11a8c183ea791c5465b658', 'kambi.jpeg'),
(11, 'Sirey', 'Loïc', 'loicsirey', 'loic.sr@eduge.ch', 'b23fc93a58200df43b29c02990234ee553ce8773', 'loicsirey.jpeg');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`idTchat_room`) REFERENCES `tchat_rooms` (`idTchat_room`);

--
-- Contraintes pour la table `sontamis`
--
ALTER TABLE `sontamis`
  ADD CONSTRAINT `sontamis_ibfk_1` FOREIGN KEY (`idUtilisateur_estAmi`) REFERENCES `utilisateurs` (`idUtilisateur`),
  ADD CONSTRAINT `sontamis_ibfk_2` FOREIGN KEY (`idUtilisateur_de`) REFERENCES `utilisateurs` (`idUtilisateur`);

--
-- Contraintes pour la table `sontpresents`
--
ALTER TABLE `sontpresents`
  ADD CONSTRAINT `sontpresents_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`),
  ADD CONSTRAINT `sontpresents_ibfk_2` FOREIGN KEY (`idTchat_room`) REFERENCES `tchat_rooms` (`idTchat_room`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
