-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 06 août 2019 à 12:36
-- Version du serveur :  5.7.24
-- Version de PHP :  7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

--
-- Base de données :  `mydb`
--

-- --------------------------------------------------------

--
-- Structure de la table `certifications`
--

DROP TABLE IF EXISTS `certifications`;
CREATE TABLE IF NOT EXISTS `certifications` (
                                                `idCert` int(11) NOT NULL AUTO_INCREMENT,
                                                `ScoreReussite` int(11) DEFAULT NULL,
                                                `NomCertification` varchar(45) DEFAULT NULL,
                                                PRIMARY KEY (`idCert`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `disponibilite`
--

 DROP TABLE IF EXISTS `disponibilite`;
 CREATE TABLE IF NOT EXISTS `disponibilite` (
                                                `idDisponibilite` int(11) NOT NULL AUTO_INCREMENT,
                                                `date` date DEFAULT NULL,
                                                `HeureDebut` time DEFAULT NULL,
                                                `HeureFin` time DEFAULT NULL,
                                                `Salles_idSalle` int(11) NOT NULL,
                                                `Surveillants_idSurveillant` int(11) NOT NULL,
                                                PRIMARY KEY (`idDisponibilite`),
                                                KEY `Salles_idSalle` (`Salles_idSalle`),
                                                KEY `Surveillants_idSurveillant` (`Surveillants_idSurveillant`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

DROP TABLE IF EXISTS `etudiants`;
CREATE TABLE IF NOT EXISTS `etudiants` (
                                           `idEtudiant` int(11) NOT NULL AUTO_INCREMENT,
                                           `Classe` varchar(255)  DEFAULT NULL,
                                           `Filiere` varchar(255)  DEFAULT NULL,
                                           `Ecole` varchar(255)  DEFAULT NULL,
                                           `Utilisateurs_idUtilisateur` int(11) NOT NULL,
                                           PRIMARY KEY (`idEtudiant`),
                                           KEY `Utilisateurs_idUtilisateur` (`Utilisateurs_idUtilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `machines`
--

DROP TABLE IF EXISTS `machines`;
CREATE TABLE IF NOT EXISTS `machines` (
                                          `idMachine` int(11) NOT NULL AUTO_INCREMENT,
                                          `NumMachine` varchar(45) DEFAULT NULL,
                                          `Salles_idSalle` int(11) NOT NULL,
                                          PRIMARY KEY (`idMachine`),
                                          KEY `Salles_idSalle` (`Salles_idSalle`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
                                              `idResult` int(11) NOT NULL AUTO_INCREMENT,
                                              `score` int(11) DEFAULT '-1',
                                              `Apreciation` varchar(45) DEFAULT 'EN ATTENTE',
                                              `Date` date DEFAULT NULL,
                                              `Plage` text,
                                              `madeAt` time DEFAULT NULL,
                                              `Absence` tinyint(4) DEFAULT '1',
                                              `Utilisateurs_idUtilisateur` int(11) NOT NULL,
                                              `Machines_idMachine` int(11) NOT NULL,
                                              `Certifications_idCert` int(11) DEFAULT NULL,
                                              PRIMARY KEY (`idResult`),
                                              KEY `Utilisateurs_idUtilisateur` (`Utilisateurs_idUtilisateur`),
                                              KEY `Certifications_idCert` (`Certifications_idCert`),
                                              KEY `Machines_idMachine` (`Machines_idMachine`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `salles`
--

DROP TABLE IF EXISTS `salles`;
CREATE TABLE IF NOT EXISTS `salles` (
                                        `idSalle` int(11) NOT NULL AUTO_INCREMENT,
                                        `NumSalle` varchar(45) DEFAULT NULL,
                                        `Sites_idSite` int(11) NOT NULL,
                                        PRIMARY KEY (`idSalle`),
                                        KEY `Sites_idSite` (`Sites_idSite`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `sites`
--

DROP TABLE IF EXISTS `sites`;
CREATE TABLE IF NOT EXISTS `sites` (
                                       `idSite` int(11) NOT NULL AUTO_INCREMENT,
                                       `NomSite` varchar(45) DEFAULT NULL,
                                       PRIMARY KEY (`idSite`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `super_administrateur`
--

DROP TABLE IF EXISTS `super_administrateur`;
CREATE TABLE IF NOT EXISTS `super_administrateur` (
                                                      `idAdmin` int(11) NOT NULL AUTO_INCREMENT,
                                                      `Utilisateurs_idUtilisateur` int(11) NOT NULL,
                                                      PRIMARY KEY (`idAdmin`),
                                                      KEY `Utilisateurs_idUtilisateur` (`Utilisateurs_idUtilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `surveillants`
--


DROP TABLE IF EXISTS `surveillants`;
CREATE TABLE IF NOT EXISTS `surveillants` (
                                              `idSurveillant` int(11) NOT NULL AUTO_INCREMENT,
                                              `Salles_idSalle` int(11) NOT NULL,
                                              `Utilisateurs_idUtilisateur` int(11) NOT NULL,
                                              PRIMARY KEY (`idSurveillant`),
                                              KEY `Utilisateurs_idUtilisateur` (`Utilisateurs_idUtilisateur`),
                                              KEY `Salles_idSalle` (`Salles_idSalle`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
                                              `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT,
                                              `Matricule` varchar(11) DEFAULT NULL,
                                              `Nom` varchar(45) DEFAULT NULL,
                                              `Mail` varchar(45) DEFAULT NULL,
                                              `Contact` varchar(45) DEFAULT NULL,
                                              `MotDePass` varchar(255) DEFAULT NULL,
                                              `NiveauAcces` tinyint(3) NOT NULL DEFAULT '-1',
                                              `StatutCompte` tinyint(4) NOT NULL DEFAULT '-1',
                                              PRIMARY KEY (`idUtilisateur`),
                                              UNIQUE KEY `Matricule` (`Matricule`),
                                              UNIQUE KEY `Mail` (`Mail`)
) ENGINE=InnoDB AUTO_INCREMENT=157 DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `disponibilite`
--
 ALTER TABLE `disponibilite`
     ADD CONSTRAINT `disponibilite_ibfk_1` FOREIGN KEY (`Salles_idSalle`) REFERENCES `salles` (`idSalle`),
     ADD CONSTRAINT `disponibilite_ibfk_2` FOREIGN KEY (`Surveillants_idSurveillant`) REFERENCES `surveillants` (`idSurveillant`);

--
-- Contraintes pour la table `machines`
--
ALTER TABLE `machines`
    ADD CONSTRAINT `machines_ibfk_1` FOREIGN KEY (`Salles_idSalle`) REFERENCES `salles` (`idSalle`);

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
    ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`Utilisateurs_idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`),
    ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`Certifications_idCert`) REFERENCES `certifications` (`idCert`),
    ADD CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`Machines_idMachine`) REFERENCES `machines` (`idMachine`);

--
-- Contraintes pour la table `salles`
--
ALTER TABLE `salles`
    ADD CONSTRAINT `salles_ibfk_1` FOREIGN KEY (`Sites_idSite`) REFERENCES `sites` (`idSite`);

--
-- Contraintes pour la table `super_administrateur`
--
ALTER TABLE `super_administrateur`
    ADD CONSTRAINT `super_administrateur_ibfk_1` FOREIGN KEY (`Utilisateurs_idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`);

--
-- Contraintes pour la table `surveillants`
--
ALTER TABLE `surveillants`
    ADD CONSTRAINT `surveillants_ibfk_1` FOREIGN KEY (`Utilisateurs_idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`),
    ADD CONSTRAINT `surveillants_ibfk_2` FOREIGN KEY (`Salles_idSalle`) REFERENCES `salles` (`idSalle`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
