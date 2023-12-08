-- phpMyAdmin SQL Dump
-- version 4.0.2
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Sam 15 Février 2020 à 21:17
-- Version du serveur: 5.6.11-log
-- Version de PHP: 5.3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `litetechinfo`
--
CREATE DATABASE IF NOT EXISTS `litetechinfo` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `litetechinfo`;

-- --------------------------------------------------------

--
-- Structure de la table `adresse_livraison`
--

CREATE TABLE IF NOT EXISTS `adresse_livraison` (
  `ID_ADRESSE_LIVRAISON` int(11) NOT NULL AUTO_INCREMENT,
  `ID_FACTURE` int(11) NOT NULL,
  `CIVILITE_LV` varchar(50) NOT NULL,
  `ID_UTILISATEUR` int(11) DEFAULT NULL,
  `NOM_LV` varchar(250) DEFAULT NULL,
  `PRENOM_LV` varchar(250) DEFAULT NULL,
  `PAYS` varchar(250) DEFAULT NULL,
  `VILLE` varchar(250) DEFAULT NULL,
  `ADRESSE` varchar(250) DEFAULT NULL,
  `CADRESSE` varchar(250) NOT NULL,
  `N_TELEPHONE1` varchar(250) DEFAULT NULL,
  `N_TELEPHONE2` varchar(250) DEFAULT NULL,
  `CODE_POSTAL` char(50) DEFAULT NULL,
  `DATE_AJOUT_AL` datetime DEFAULT NULL,
  PRIMARY KEY (`ID_ADRESSE_LIVRAISON`),
  KEY `FK_RELATION_17` (`ID_UTILISATEUR`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `adresse_livraison`
--

INSERT INTO `adresse_livraison` (`ID_ADRESSE_LIVRAISON`, `ID_FACTURE`, `CIVILITE_LV`, `ID_UTILISATEUR`, `NOM_LV`, `PRENOM_LV`, `PAYS`, `VILLE`, `ADRESSE`, `CADRESSE`, `N_TELEPHONE1`, `N_TELEPHONE2`, `CODE_POSTAL`, `DATE_AJOUT_AL`) VALUES
(8, 25, 'Femme', 12, 'RAMANANTSOA', 'Tahina', 'Madagascar', 'Antsirabe', '15B05', 'Antsinanantsena', '0340225654', '0340225654', '110', '2020-02-08 12:31:57');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `ID_CATEGORIE` int(11) NOT NULL AUTO_INCREMENT,
  `CTITRE` varchar(250) NOT NULL,
  PRIMARY KEY (`ID_CATEGORIE`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`ID_CATEGORIE`, `CTITRE`) VALUES
(2, 'Informatique'),
(3, 'Image & son'),
(4, 'Téléphonie'),
(29, 'Connectique'),
(28, 'Consommables'),
(27, 'Jeux');

-- --------------------------------------------------------

--
-- Structure de la table `detail_facture`
--

CREATE TABLE IF NOT EXISTS `detail_facture` (
  `ID_DETAIL_FACTURE` int(11) NOT NULL AUTO_INCREMENT,
  `ID_FACTURE` int(11) NOT NULL,
  `ID_PRODUIT` int(11) NOT NULL,
  `DESIGNATION_DF` varchar(250) NOT NULL,
  `QUANTITE_DF` int(11) NOT NULL,
  `PRIX_DF` decimal(10,0) NOT NULL,
  `FRAIS_DF` decimal(10,0) NOT NULL,
  PRIMARY KEY (`ID_DETAIL_FACTURE`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Contenu de la table `detail_facture`
--

INSERT INTO `detail_facture` (`ID_DETAIL_FACTURE`, `ID_FACTURE`, `ID_PRODUIT`, `DESIGNATION_DF`, `QUANTITE_DF`, `PRIX_DF`, `FRAIS_DF`) VALUES
(22, 25, 20, 'Acer Predator Triton', 2, '1250', '0'),
(21, 25, 21, 'ASUS Vivobook', 3, '832', '0');

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE IF NOT EXISTS `facture` (
  `ID_FACTURE` int(11) NOT NULL AUTO_INCREMENT,
  `ID_UTILISATEUR` int(11) DEFAULT NULL,
  `REFERENCE` varchar(250) DEFAULT NULL,
  `TYPE_PAIEMENT` varchar(250) NOT NULL,
  `STATUT` varchar(250) DEFAULT NULL,
  `PRIX_TOTAL` double(10,2) DEFAULT NULL,
  `DATE_FACTURE` datetime DEFAULT NULL,
  PRIMARY KEY (`ID_FACTURE`),
  KEY `FK_RELATION_10` (`ID_UTILISATEUR`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Contenu de la table `facture`
--

INSERT INTO `facture` (`ID_FACTURE`, `ID_UTILISATEUR`, `REFERENCE`, `TYPE_PAIEMENT`, `STATUT`, `PRIX_TOTAL`, `DATE_FACTURE`) VALUES
(25, 12, '12C1GK', 'paypal', 'En attente de paiement', 4996.00, '2020-02-08 12:31:57');

-- --------------------------------------------------------

--
-- Structure de la table `fiche_tq_stitre`
--

CREATE TABLE IF NOT EXISTS `fiche_tq_stitre` (
  `ID_FICHE_TQ_STITRE` int(11) NOT NULL AUTO_INCREMENT,
  `ID_FICHE_TQ_TITRE` int(11) DEFAULT NULL,
  `RECHERCHE` int(11) NOT NULL,
  `FSTITRE` varchar(250) DEFAULT NULL,
  `FSORDRE` int(11) NOT NULL,
  PRIMARY KEY (`ID_FICHE_TQ_STITRE`),
  KEY `FK_RELATION_25` (`ID_FICHE_TQ_TITRE`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Contenu de la table `fiche_tq_stitre`
--

INSERT INTO `fiche_tq_stitre` (`ID_FICHE_TQ_STITRE`, `ID_FICHE_TQ_TITRE`, `RECHERCHE`, `FSTITRE`, `FSORDRE`) VALUES
(3, 6, 0, 'Désignation', 0),
(4, 6, 1, 'Marque', 0),
(5, 6, 0, 'Modèle', 0),
(6, 19, 0, 'Système d''exploitation', 0),
(7, 19, 0, 'Langue de l''OS', 0),
(8, 8, 2, 'Processeur', 0),
(9, 8, 0, 'Type de processeur', 0),
(10, 8, 0, 'Fréquence CPU', 0),
(11, 8, 0, 'Chipset', 0),
(12, 23, 3, 'Taille de la mémoire', 0),
(13, 23, 0, 'Nombre de barrettes', 0),
(14, 23, 0, 'Slots mémoire disponibles', 0),
(15, 23, 0, 'Type de mémoire', 0),
(16, 23, 0, 'Fréquence', 0),
(17, 23, 0, 'Capacité maximale de RAM par slot', 0),
(18, 23, 0, 'Capacité maximale de RAM', 0),
(19, 24, 0, 'Configuration disque(s)', 0),
(20, 24, 4, 'Disque dur', 0),
(21, 24, 0, 'Type de Disque', 0),
(22, 24, 0, 'Interface ordinateur/disque dur', 0),
(23, 24, 0, 'Lecteur Optique', 0),
(24, 24, 0, 'Lecteur de disquettes', 0),
(25, 25, 3, 'Chipset graphique', 0),
(26, 25, 0, 'Taille mémoire vidéo', 0),
(27, 25, 0, 'Type de multi-GPU', 0),
(28, 25, 0, 'VR Ready (réalité virtuelle)', 0),
(29, 26, 0, 'Sans-fil', 0),
(30, 26, 0, 'Nombre de ports/Contrôleur Ethernet', 0),
(31, 26, 0, 'Norme(s) réseau', 0),
(32, 27, 0, 'Connecteurs panneau avant', 0);

-- --------------------------------------------------------

--
-- Structure de la table `fiche_tq_titre`
--

CREATE TABLE IF NOT EXISTS `fiche_tq_titre` (
  `ID_FICHE_TQ_TITRE` int(11) NOT NULL AUTO_INCREMENT,
  `ID_SS_CATEGORIE` int(11) DEFAULT NULL,
  `FTITRE` varchar(250) DEFAULT NULL,
  `FORDRE` int(11) NOT NULL,
  PRIMARY KEY (`ID_FICHE_TQ_TITRE`),
  KEY `FK_RELATION_24` (`ID_SS_CATEGORIE`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Contenu de la table `fiche_tq_titre`
--

INSERT INTO `fiche_tq_titre` (`ID_FICHE_TQ_TITRE`, `ID_SS_CATEGORIE`, `FTITRE`, `FORDRE`) VALUES
(6, 21, 'Informations générales', 1),
(8, 21, 'Processeur et chipset', 3),
(19, 21, 'Système d''exploitation', 2),
(23, 21, 'Mémoire', 4),
(24, 21, 'Stockage', 5),
(25, 21, 'Graphismes', 6),
(26, 21, 'Réseau', 7),
(27, 21, 'Connectique', 8),
(28, 21, 'Equipement', 9),
(29, 21, 'CARECTERISTIQUE PHYSIQUE', 10),
(30, 21, 'GARENTIES', 11);

-- --------------------------------------------------------

--
-- Structure de la table `fiche_tq_valeur`
--

CREATE TABLE IF NOT EXISTS `fiche_tq_valeur` (
  `ID_FICHE_TQ_VALEUR` int(11) NOT NULL AUTO_INCREMENT,
  `ID_FICHE_TQ_STITRE` int(11) DEFAULT NULL,
  `ID_PRODUIT` int(11) DEFAULT NULL,
  `ID_FICHE_TQ_TITRE` int(11) DEFAULT NULL,
  `VALEUR` varchar(250) DEFAULT NULL,
  `VORDRE` int(11) NOT NULL,
  PRIMARY KEY (`ID_FICHE_TQ_VALEUR`),
  KEY `FK_RELATION_26` (`ID_PRODUIT`),
  KEY `FK_RELATION_27` (`ID_FICHE_TQ_STITRE`),
  KEY `FK_RELATION_3` (`ID_FICHE_TQ_TITRE`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=271 ;

--
-- Contenu de la table `fiche_tq_valeur`
--

INSERT INTO `fiche_tq_valeur` (`ID_FICHE_TQ_VALEUR`, `ID_FICHE_TQ_STITRE`, `ID_PRODUIT`, `ID_FICHE_TQ_TITRE`, `VALEUR`, `VORDRE`) VALUES
(60, 32, 19, 27, 'test', 0),
(59, 31, 19, 26, 'valuenb29', 0),
(58, 30, 19, 26, 'valuenb28', 0),
(57, 29, 19, 26, 'valuenb27', 0),
(56, 28, 19, 25, 'valuenb26', 0),
(55, 27, 19, 25, 'valuenb25', 0),
(54, 26, 19, 25, 'valuenb24', 0),
(53, 25, 19, 25, 'valuenb23', 0),
(52, 24, 19, 24, 'valuenb22', 0),
(51, 23, 19, 24, 'valuenb21', 0),
(50, 22, 19, 24, 'valuenb20', 0),
(49, 21, 19, 24, 'valuenb19', 0),
(48, 20, 19, 24, 'valuenb18', 0),
(47, 19, 19, 24, 'valuenb17', 0),
(46, 18, 19, 23, 'valuenb16', 0),
(45, 17, 19, 23, 'valuenb15', 0),
(44, 16, 19, 23, 'valuenb14', 0),
(43, 15, 19, 23, 'valuenb13', 0),
(42, 14, 19, 23, 'valuenb12', 0),
(41, 13, 19, 23, 'valuenb11', 0),
(40, 12, 19, 23, 'valuenb1', 1),
(39, 11, 19, 8, 'valuenb9', 0),
(38, 10, 19, 8, 'valuenb8', 0),
(37, 9, 19, 8, 'valuenb7', 0),
(36, 8, 19, 8, 'valuenb6', 0),
(35, 7, 19, 19, 'valuenb5', 0),
(34, 6, 19, 19, 'valuenb4', 0),
(33, 5, 19, 6, 'valuenb3', 0),
(32, 4, 19, 6, 'valuenb2', 2),
(31, 3, 19, 6, 'valuenb1', 0),
(61, 3, 20, 6, 'valuenb1', 0),
(62, 4, 20, 6, 'valuenb2', 1),
(63, 5, 20, 6, 'valuenb3', 0),
(64, 6, 20, 19, 'valuenb4', 0),
(65, 7, 20, 19, 'valuenb5', 0),
(66, 8, 20, 8, 'valuenb6', 0),
(67, 9, 20, 8, 'valuenb7', 0),
(68, 10, 20, 8, 'valuenb8', 0),
(69, 11, 20, 8, 'valuenb9', 0),
(70, 12, 20, 23, 'valuenb10', 2),
(71, 13, 20, 23, 'valuenb11', 0),
(72, 14, 20, 23, 'valuenb12', 0),
(73, 15, 20, 23, 'valuenb13', 0),
(74, 16, 20, 23, 'valuenb14', 0),
(75, 17, 20, 23, 'valuenb15', 0),
(76, 18, 20, 23, 'valuenb16', 0),
(77, 19, 20, 24, 'valuenb17', 0),
(78, 20, 20, 24, 'valuenb18', 0),
(79, 21, 20, 24, 'valuenb19', 0),
(80, 22, 20, 24, 'valuenb20', 0),
(81, 23, 20, 24, 'valuenb21', 0),
(82, 24, 20, 24, 'valuenb22', 0),
(83, 25, 20, 25, 'valuenb23', 0),
(84, 26, 20, 25, 'valuenb24', 0),
(85, 27, 20, 25, 'valuenb25', 0),
(86, 28, 20, 25, 'valuenb26', 0),
(87, 29, 20, 26, 'valuenb27', 0),
(88, 30, 20, 26, 'valuenb28', 0),
(89, 31, 20, 26, 'valuenb29', 0),
(90, 32, 20, 27, 'predator', 0),
(91, 3, 21, 6, 'asus1', 0),
(92, 4, 21, 6, 'valuenb2', 0),
(93, 5, 21, 6, 'valuenb3', 0),
(94, 6, 21, 19, 'valuenb4', 0),
(95, 7, 21, 19, 'valuenb5', 0),
(96, 8, 21, 8, 'valuenb6', 0),
(97, 9, 21, 8, 'valuenb7', 0),
(98, 10, 21, 8, 'valuenb8', 0),
(99, 11, 21, 8, 'valuenb9', 0),
(100, 12, 21, 23, 'valuenb10', 3),
(101, 13, 21, 23, 'valuenb11', 0),
(102, 14, 21, 23, 'valuenb12', 0),
(103, 15, 21, 23, 'valuenb13', 0),
(104, 16, 21, 23, 'valuenb14', 0),
(105, 17, 21, 23, 'valuenb15', 0),
(106, 18, 21, 23, 'valuenb16', 0),
(107, 19, 21, 24, 'valuenb17', 0),
(108, 20, 21, 24, 'valuenb18', 0),
(109, 21, 21, 24, 'valuenb19', 0),
(110, 22, 21, 24, 'valuenb20', 0),
(111, 23, 21, 24, 'valuenb21', 0),
(112, 24, 21, 24, 'valuenb22', 0),
(113, 25, 21, 25, 'valuenb23', 0),
(114, 26, 21, 25, 'valuenb24', 0),
(115, 27, 21, 25, 'valuenb25', 0),
(116, 28, 21, 25, 'valuenb26', 0),
(117, 29, 21, 26, 'valuenb27', 0),
(118, 30, 21, 26, 'valuenb28', 0),
(119, 31, 21, 26, 'valuenb29', 0),
(120, 32, 21, 27, 'asus30', 0),
(121, 3, 22, 6, 'ASUS Transformer Book T101HA-GR029RC Gris', 0),
(122, 4, 22, 6, 'ASUS', 0),
(123, 5, 22, 6, 'valuenb3', 0),
(124, 6, 22, 19, 'Windows 10 Professionnel 64 bits', 0),
(125, 7, 22, 19, 'valuenb5', 0),
(126, 8, 22, 8, 'Intel Atom', 0),
(127, 9, 22, 8, 'valuenb7', 0),
(128, 10, 22, 8, 'valuenb8', 0),
(129, 11, 22, 8, 'valuenb9', 0),
(130, 12, 22, 23, '4 Go', 1),
(131, 13, 22, 23, 'valuenb11', 0),
(132, 14, 22, 23, 'valuenb12', 0),
(133, 15, 22, 23, 'vad', 0),
(134, 16, 22, 23, 'valuenb14', 0),
(135, 17, 22, 23, 'valuenb15', 0),
(136, 18, 22, 23, 'valuenb16', 0),
(137, 19, 22, 24, 'SSD 64 Go', 0),
(138, 20, 22, 24, 'valuenb18', 0),
(139, 21, 22, 24, 'valuenb19', 0),
(140, 22, 22, 24, 'valuenb20', 0),
(141, 23, 22, 24, 'valuenb21', 0),
(142, 24, 22, 24, 'valuenb22', 0),
(143, 25, 22, 25, 'Intel HD Graphics', 0),
(144, 26, 22, 25, 'valuenb24', 0),
(145, 27, 22, 25, 'valuenb25', 0),
(146, 28, 22, 25, 'valuenb26', 0),
(147, 29, 22, 26, 'valuenb27', 0),
(148, 30, 22, 26, 'valuenb28', 0),
(149, 31, 22, 26, 'valuenb29', 0),
(150, 32, 22, 27, 'value', 0),
(151, 3, 23, 6, 'HP OMEN 15-dc1097nf', 0),
(152, 4, 23, 6, 'HP', 0),
(153, 5, 23, 6, 'valuenb3', 0),
(154, 6, 23, 19, 'valuenb4', 0),
(155, 7, 23, 19, 'valuenb5', 0),
(156, 8, 23, 8, 'Intel Core i7', 0),
(157, 9, 23, 8, 'valuenb7', 0),
(158, 10, 23, 8, 'valuenb8', 0),
(159, 11, 23, 8, 'valuenb9', 0),
(160, 12, 23, 23, '16 Go', 3),
(161, 13, 23, 23, 'valuenb11', 0),
(162, 14, 23, 23, 'valuenb12', 0),
(163, 15, 23, 23, 'valuenb13', 0),
(164, 16, 23, 23, 'valuenb14', 0),
(165, 17, 23, 23, 'valuenb15', 0),
(166, 18, 23, 23, 'valuenb16', 0),
(167, 19, 23, 24, 'valuenb17', 0),
(168, 20, 23, 24, 'SSD 512 Go', 0),
(169, 21, 23, 24, 'valuenb19', 0),
(170, 22, 23, 24, 'valuenb20', 0),
(171, 23, 23, 24, 'valuenb21', 0),
(172, 24, 23, 24, 'valuenb22', 0),
(173, 25, 23, 25, 'NVIDIA GeForce RTX 2070', 0),
(174, 26, 23, 25, 'valuenb24', 0),
(175, 27, 23, 25, 'valuenb25', 0),
(176, 28, 23, 25, 'valuenb26', 0),
(177, 29, 23, 26, 'valuenb27', 0),
(178, 30, 23, 26, 'valuenb28', 0),
(179, 31, 23, 26, 'valuenb29', 0),
(180, 32, 23, 27, '30', 0),
(181, 3, 24, 6, 'Lenovo ThinkPad T580 (20L9001WFR)', 0),
(182, 4, 24, 6, 'Lenovo', 0),
(183, 5, 24, 6, 'valuenb3', 0),
(184, 6, 24, 19, 'valuenb4', 0),
(185, 7, 24, 19, 'valuenb5', 0),
(186, 8, 24, 8, 'Intel Core i5', 0),
(187, 9, 24, 8, 'valuenb7', 0),
(188, 10, 24, 8, 'valuenb8', 0),
(189, 11, 24, 8, 'valuenb9', 0),
(190, 12, 24, 23, '8 Go', 2),
(191, 13, 24, 23, 'valuenb11', 0),
(192, 14, 24, 23, 'valuenb12', 0),
(193, 15, 24, 23, 'valuenb13', 0),
(194, 16, 24, 23, 'valuenb14', 0),
(195, 17, 24, 23, 'valuenb15', 0),
(196, 18, 24, 23, 'valuenb16', 0),
(197, 19, 24, 24, 'valuenb17', 0),
(198, 20, 24, 24, '500 Go', 0),
(199, 21, 24, 24, 'valuenb19', 0),
(200, 22, 24, 24, 'valuenb20', 0),
(201, 23, 24, 24, 'valuenb21', 0),
(202, 24, 24, 24, 'valuenb22', 0),
(203, 25, 24, 25, 'Intel UHD Graphics 620', 0),
(204, 26, 24, 25, 'valuenb24', 0),
(205, 27, 24, 25, 'valuenb25', 0),
(206, 28, 24, 25, 'valuenb26', 0),
(207, 29, 24, 26, 'valuenb27', 0),
(208, 30, 24, 26, 'valuenb28', 0),
(209, 31, 24, 26, 'valuenb29', 0),
(210, 32, 24, 27, '30', 0),
(211, 3, 25, 6, 'Toshiba Satellite Pro R50-E-127', 0),
(212, 4, 25, 6, 'Toshiba', 0),
(213, 5, 25, 6, 'valuenb3', 0),
(214, 6, 25, 19, 'Windows 10 Professionnel 64 bits', 0),
(215, 7, 25, 19, 'valuenb5', 0),
(216, 8, 25, 8, 'Intel Core i3', 0),
(217, 9, 25, 8, 'valuenb7', 0),
(218, 10, 25, 8, 'valuenb8', 0),
(219, 11, 25, 8, 'valuenb9', 0),
(220, 12, 25, 23, '4 Go', 1),
(221, 13, 25, 23, 'valuenb11', 0),
(222, 14, 25, 23, 'valuenb12', 0),
(223, 15, 25, 23, 'valuenb13', 0),
(224, 16, 25, 23, 'valuenb14', 0),
(225, 17, 25, 23, 'valuenb15', 0),
(226, 18, 25, 23, 'valuenb16', 0),
(227, 19, 25, 24, 'HDD 500 Go', 0),
(228, 20, 25, 24, '500 Go', 0),
(229, 21, 25, 24, 'valuenb19', 0),
(230, 22, 25, 24, 'valuenb20', 0),
(231, 23, 25, 24, 'valuenb21', 0),
(232, 24, 25, 24, 'valuenb22', 0),
(233, 25, 25, 25, 'Intel HD Graphics 620', 0),
(234, 26, 25, 25, 'valuenb24', 0),
(235, 27, 25, 25, 'valuenb25', 0),
(236, 28, 25, 25, 'valuenb26', 0),
(237, 29, 25, 26, 'valuenb27', 0),
(238, 30, 25, 26, 'valuenb28', 0),
(239, 31, 25, 26, 'valuenb29', 0),
(240, 32, 25, 27, '30', 0),
(241, 3, 26, 6, 'Dell G7 17-7790 (63M12)', 0),
(242, 4, 26, 6, 'Dell', 0),
(243, 5, 26, 6, 'valuenb3', 0),
(244, 6, 26, 19, 'Windows 10 Famille 64 bits', 0),
(245, 7, 26, 19, 'valuenb5', 0),
(246, 8, 26, 8, 'Intel Core i7', 0),
(247, 9, 26, 8, 'valuenb7', 0),
(248, 10, 26, 8, 'valuenb8', 0),
(249, 11, 26, 8, 'valuenb9', 0),
(250, 12, 26, 23, '16 Go', 3),
(251, 13, 26, 23, 'valuenb11', 0),
(252, 14, 26, 23, 'valuenb12', 0),
(253, 15, 26, 23, 'valuenb13', 0),
(254, 16, 26, 23, 'valuenb14', 0),
(255, 17, 26, 23, 'valuenb15', 0),
(256, 18, 26, 23, 'valuenb16', 0),
(257, 19, 26, 24, 'SSD 512 Go', 0),
(258, 20, 26, 24, 'SSD 512 Go', 0),
(259, 21, 26, 24, 'valuenb19', 0),
(260, 22, 26, 24, 'valuenb20', 0),
(261, 23, 26, 24, 'valuenb21', 0),
(262, 24, 26, 24, 'valuenb22', 0),
(263, 25, 26, 25, 'NVIDIA GeForce RTX 2060', 0),
(264, 26, 26, 25, 'valuenb24', 0),
(265, 27, 26, 25, 'valuenb25', 0),
(266, 28, 26, 25, 'valuenb26', 0),
(267, 29, 26, 26, 'valuenb27', 0),
(268, 30, 26, 26, 'valuenb28', 0),
(269, 31, 26, 26, 'valuenb29', 0),
(270, 32, 26, 27, '30', 0);

-- --------------------------------------------------------

--
-- Structure de la table `paiement`
--

CREATE TABLE IF NOT EXISTS `paiement` (
  `ID_PAIEMENT` int(10) NOT NULL AUTO_INCREMENT,
  `ID_FACTURE` int(11) DEFAULT NULL,
  `REFERENCE_PI` varchar(250) DEFAULT NULL,
  `PAYER` double(10,2) DEFAULT NULL,
  `DATE_PAIEMENT` datetime DEFAULT NULL,
  PRIMARY KEY (`ID_PAIEMENT`),
  KEY `FK_RELATION_15` (`ID_FACTURE`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=117 ;

--
-- Contenu de la table `paiement`
--

INSERT INTO `paiement` (`ID_PAIEMENT`, `ID_FACTURE`, `REFERENCE_PI`, `PAYER`, `DATE_PAIEMENT`) VALUES
(105, 25, NULL, 4960.00, '2020-02-11 11:18:18'),
(116, 25, NULL, 6.00, '2020-02-11 13:37:20'),
(87, 25, NULL, 20.00, '2020-02-11 10:48:20'),
(30, 25, NULL, 10.00, '2020-02-11 07:56:36');

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE IF NOT EXISTS `panier` (
  `ID_PANIER` int(11) NOT NULL AUTO_INCREMENT,
  `ID_UTILISATEUR` int(11) DEFAULT NULL,
  `ID_PRODUIT` int(11) DEFAULT NULL,
  `QUANTITE_PN` int(11) DEFAULT NULL,
  `DATE_AJOUT_PN` datetime DEFAULT NULL,
  PRIMARY KEY (`ID_PANIER`),
  KEY `FK_RELATION_18` (`ID_UTILISATEUR`),
  KEY `FK_RELATION_8` (`ID_PRODUIT`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Contenu de la table `panier`
--

INSERT INTO `panier` (`ID_PANIER`, `ID_UTILISATEUR`, `ID_PRODUIT`, `QUANTITE_PN`, `DATE_AJOUT_PN`) VALUES
(23, 1, 19, 1, '2020-01-15 19:30:16');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE IF NOT EXISTS `produit` (
  `ID_PRODUIT` int(11) NOT NULL AUTO_INCREMENT,
  `ID_CATEGORIE` int(11) NOT NULL,
  `ID_S_CATEGORIE` int(11) NOT NULL,
  `ID_SS_CATEGORIE` int(11) NOT NULL,
  `DESIGNATION` varchar(250) DEFAULT NULL,
  `PRIX_ACHAT` decimal(10,0) DEFAULT NULL,
  `PRIX_VENTE` decimal(10,0) NOT NULL,
  `QUANTITE` int(11) DEFAULT NULL,
  `INFO` varchar(250) DEFAULT NULL,
  `DESCRIPTION` varchar(1000) DEFAULT NULL,
  `STATUT` int(11) NOT NULL,
  `DATE_AJOUT_PD` datetime DEFAULT NULL,
  PRIMARY KEY (`ID_PRODUIT`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Contenu de la table `produit`
--

INSERT INTO `produit` (`ID_PRODUIT`, `ID_CATEGORIE`, `ID_S_CATEGORIE`, `ID_SS_CATEGORIE`, `DESIGNATION`, `PRIX_ACHAT`, `PRIX_VENTE`, `QUANTITE`, `INFO`, `DESCRIPTION`, `STATUT`, `DATE_AJOUT_PD`) VALUES
(8, 2, 16, 21, 'LDLC Aurore NI5R-16-S5', '800', '849', 5, 'Intel Core i5-8265U 16 Go SSD 480 Go 15.6\\" LED Full HD Wi-Fi AC/Bluetooth Webcam (sans OS)', 'L\\''ordinateur portable LDLC Aurore NI5R est un modèle performant et polyvalent, conçu pour répondre efficacement à tous vos besoins du quotidien. Son design compact et élégant, avec cadre d\\''écran ultra-mince, en fait aussi un compagnon mobile très agréable.', 1, '2020-01-08 15:06:53'),
(9, 2, 16, 21, 'LDLC Aurore NI5S-8-S2', '700', '729', 10, 'Intel Core i5-8265U 8 Go SSD 240 Go 15.6\\" LED Full HD Wi-Fi AC/Bluetooth Webcam (sans OS)', 'L\\''ordinateur portable LDLC Aurore NI5S est un modèle performant et polyvalent, conçu pour répondre efficacement à tous vos besoins du quotidien. Son design compact et élégant, avec cadre d\\''écran ultra-mince, en fait aussi un compagnon mobile très agréable.', 1, '2020-01-08 15:24:46'),
(10, 2, 16, 21, 'LDLC Bellone ZY7-I7-16-H20S2', '1000', '1799', 12, 'Intel Core i7-8750H 16 Go SSD 240 Go + HDD 2 To 17.3\\" LED Full HD 120 Hz NVIDIA GeForce GTX 1070 8 Go Wi-Fi AC/Bluetooth Webcam (sans OS)', 'Boostez votre confort de jeu avec le PC portable Gamer LDLC Bellone ZY7 ! Avec ses composants dernier cri et son superbe écran mat 120 Hz, il vous offre la performance, la vitesse et le confort visuel dont avez besoin pour jouer dans d\\''excellentes conditions.', 1, '2020-01-08 15:31:24'),
(11, 2, 16, 21, 'ASUS FX571GT-BQ009T', '900', '999', 20, 'Intel Core i5-9300H 8 Go SSD 512 Go 15.6\\" LED Full HD NVIDIA GeForce GTX 1650 4 Go Wi-Fi AC/Bluetooth Webcam Windows 10 Famille 64 bits', 'Avec le PC portable ASUS FX571GT-BQ012T, bénéficiez d\\''excellentes performances quelle que soit votre utilisation ! Sa conception de qualité et ses composants performants vous permettront de travailler dans d\\''excellentes conditions mais aussi de profiter d\\''un divertissement numérique de qualité.', 1, '2020-01-08 15:54:33'),
(12, 2, 16, 21, 'ASUS ROG Zephyrus S GX535GXR-Z086R', '2', '2', 10, 'Intel Core i7-9750H 16 Go SSD 1 To 15.6\\" LED Full HD 240 Hz NVIDIA GeForce RTX 2080 8 Go Wi-Fi AC/Bluetooth Webcam Windows 10 Professionnel 64 bits', 'Taillé pour les Gamers nomades, le PC portable ASUS ROG Zephyrus S GX535GXR offre de hautes performances de jeu dans un châssis de moins de 16 mm d\\''épaisseur ! Grâce à sa finesse et son fonctionnement très silencieux il vous accompagnera dans tous vos déplacements.', 1, '2020-01-08 16:12:28'),
(13, 2, 16, 21, 'MSI GF63 Thin 9RCX-664XFR', '600', '699', 12, 'Intel Core i5-9300H 8 Go 1 To 15.6\\" LED Full HD NVIDIA GeForce GTX 1050 Ti 4 Go Wi-Fi AC/Bluetooth Webcam FreeDOS', 'Profitez d\\''excellentes performances avec le PC portable Gamer MSI GF63 Thin 9RCX ! Cet ordinateur portable MSI offre un parfait confort de jeu grâce à ses composants performants, son écran de 15.6\\" Full HD, son clavier Gamer rétroéclairé et son système audio performant.', 1, '2020-01-08 16:21:45'),
(14, 2, 16, 21, 'ASUS Vivobook S14 S412DA-EK005T avec NumPad', '500', '599', 46, 'AMD Ryzen 5 3500U 8 Go SSD 256 Go 14\\" LED Full HD Wi-Fi AC/Bluetooth Webcam Windows 10 Famille 64 bits', 'Emportez le PC portable ASUS Vivobook S14 S412DA partout avec vous ! A la fois reine de beauté, condensé de performance et modèle de légèreté, cette machine répondra parfaitement à tous vos besoins, à domicile ou en déplacement.', 1, '2020-01-08 16:52:14'),
(15, 2, 16, 21, 'ASUS Vivobook S14 S412DA-EK005T', '500', '599', 46, 'AMD Ryzen 5 3500U 8 Go SSD 256 Go 14\\" LED Full HD Wi-Fi AC/Bluetooth Webcam Windows 10 Famille 64 bits', 'Emportez le PC portable ASUS Vivobook S14 S412DA partout avec vous ! A la fois reine de beauté, condensé de performance et modèle de légèreté, cette machine répondra parfaitement à tous vos besoins, à domicile ou en déplacement.', 1, '2020-01-08 17:01:28'),
(16, 2, 16, 21, 'Acer Predator Triton 500 PT515-51-75EB', '1200', '1999', 4, 'Intel Core i7-9750H 16 Go SSD 512 Go (2 x 256 Go) 15.6\\" LED Full HD 144 Hz G-SYNC NVIDIA GeForce RTX 2070 8 Go Max-Q Wi-Fi AC/Bluetooth Webcam Windows 10 Famille 64 bits', 'Le PC portable Acer Predator Triton 500  allie mobilité avec un châssis léger et fin tout en proposant des performances dignes des meilleurs tours PC ! Ecran Full HD 144 Hz G-Sync, processeur Intel Hexa-Core de dernière génération et carte graphique Nvidia Turing, rien ne manque pour vous éblouir.', 1, '2020-01-08 17:07:05'),
(17, 2, 16, 21, 'Lenovo Legion Y740-15IRHg (81UH001BFR)', '1500', '1799', 4, 'Intel Core i7-9750H 16 Go SSD 256 Go + HDD 1 To 15.6\\" LED Full HD 144 Hz G-SYNC NVIDIA GeForce RTX 2060 6 Go Wi-Fi AC/Bluetooth Webcam Windows 10 Famille 64 bits', 'Gagnez en confort de jeu avec le PC portable Gamer Lenovo Legion Y740 ! Avec ses composants performants, son écran 144 Hz HDR 400 compatible G-SYNC, son sytème de rétroéclairage Corsair iCUE, il vous offre la puissance et le confort dont vous avez besoin !', 1, '2020-01-08 17:11:27'),
(18, 2, 16, 21, 'Dell G5 15-5590 (5590-7807)', '1239', '1699', 30, 'Intel Core i7-9750H 16 Go SSD 256 Go + HDD 1 To 15.6\\" LED Full HD 144 Hz NVIDIA GeForce RTX 2060 6 Go Wi-Fi AC/Bluetooth Webcam Windows 10 Famille 64 bits', 'Le PC Portable Dell G5 15-5590 a été pensé pour les Gamers. Il bénéficie d\\''une conception garantissant des performances constantes sur le long terme grâce à un système de refroidissement ultra-efficace et des composants particulièrement robustes.', 1, '2020-01-08 17:48:41'),
(19, 2, 16, 21, 'Lenovo Legion Y740-15IRHg', '800', '850', 32, 'Intel Core i7-9750H 16 Go SSD 256 Go + HDD 1 To 15.6\\" LED Full HD 144 Hz G-SYNC NVIDIA GeForce RTX 2060 6 Go Wi-Fi AC/Bluetooth Webcam Windows 10 Famille 64 bits', 'Intel Core i7-9750H 16 Go SSD 256 Go + HDD 1 To 15.6\\" LED Full HD 144 Hz G-SYNC NVIDIA GeForce RTX 2060 6 Go Wi-Fi AC/Bluetooth Webcam Windows 10 Famille 64 bits', 1, '2020-01-11 19:57:29'),
(20, 2, 16, 21, 'Acer Predator Triton', '1200', '1250', 2, 'Intel Core i7-9750H 16 Go SSD 512 Go (2 x 256 Go) 15.6\\" LED Full HD 144 Hz G-SYNC NVIDIA GeForce RTX 2070 8 Go Max-Q Wi-Fi AC/Bluetooth Webcam Windows 10 Famille 64 ', 'Intel Core i7-9750H 16 Go SSD 512 Go (2 x 256 Go) 15.6\\" LED Full HD 144 Hz G-SYNC NVIDIA GeForce RTX 2070 8 Go Max-Q Wi-Fi AC/Bluetooth Webcam Windows 10 Famille 64 ', 1, '2020-01-11 20:02:21'),
(21, 2, 16, 21, 'ASUS Vivobook', '560', '832', 4, 'AMD Ryzen 5 3500U 8 Go SSD 256 Go 14\\" LED Full HD Wi-Fi AC/Bluetooth Webcam Windows 10 Famille 64 bits', 'AMD Ryzen 5 3500U 8 Go SSD 256 Go 14\\" LED Full HD Wi-Fi AC/Bluetooth Webcam Windows 10 Famille 64 bits', 1, '2020-01-11 20:24:33'),
(22, 2, 16, 21, 'ASUS Transformer Book T101HA-GR029RC', '300', '379', 20, 'Intel Atom x5-Z8350 4 Go eMMC 64 Go 10.1" LED Tactile Wi-Fi AC/Bluetooth Webcam Windows 10 Professionnel 64 bits', 'Gagnez en mobilité pour vos tâches courantes avec la tablette hybride ASUS Transformer Book T101HA ! Conçue pour la mobilité, la tablette ne mesure que 9 mm d''épaisseur pour un poids de 700 g.', 1, '2020-01-19 16:51:12'),
(23, 2, 16, 21, 'HP OMEN 15-dc1097nf', '1800', '1999', 20, 'Intel Core i7-9750H 16 Go SSD 512 Go + HDD 1 To 15.6" LED Full HD 144 Hz NVIDIA GeForce RTX 2070 8 Go Wi-Fi AC/Bluetooth Webcam Windows 10 Famille 64 bits', 'Profitez d''excellentes performances mobiles avec le PC portable HP OMEN 15 ! Doté d''un écran IPS Full HD 144 Hz, de composants performants et d''un système sonore Bang & Olufsen, il offre d''excellentes performances de jeu et un excellent niveau de confort.', 1, '2020-01-19 17:12:37'),
(24, 2, 16, 21, 'Lenovo ThinkPad T580 (20L9001WFR)', '800', '885', 20, 'Intel Core i5-8250U 8 Go 500 Go 15.6" LED Full HD Wi-Fi AC/Bluetooth Webcam Windows 10 Professionnel 64 bits', 'Gagnez en performance et en autonomie avec le PC Portable Lenovo ThinkPad T580 ! Combinant batterie interne et batterie externe, il offre jusqu''à 13 heures d''autonomie. Avec ses fonctions de sécurité renforcées, restez serein où que votre travail vous mène.', 1, '2020-01-19 17:27:03'),
(25, 2, 16, 21, 'Toshiba Satellite Pro R50-E-127', '400', '449', 20, 'Intel Core i3-7020U 4 Go 500 Go 15.6" LED HD Graveur DVD Wi-Fi AC/Bluetooth Webcam Windows 10 Professionnel 64 bits', 'Le PC portable Toshiba Satellite Pro R50-E est conçu pour répondre efficacement aux besoins des entreprises. Cet ordinateur portable Toshiba offre aux professionnels la performance, la sécurité et la fiabilité dont ils ont besoin.', 1, '2020-01-19 17:40:18'),
(26, 2, 16, 21, 'Dell G7 17-7790 (63M12)', '1600', '1649', 20, 'Intel Core i7-9750H 16 Go SSD 512 Go 17.3" LED Full HD 144 Hz NVIDIA GeForce RTX 2060 6 Go Wi-Fi AC/Bluetooth Webcam Windows 10 Famille 64 bits', 'Gagnez en confort et en performance de jeu avec le PC portable Dell G7 17-7790 ! Avec ses composants ultra-performants, son écran IPS 144 Hz, son clavier rétroclairé et son système audio performant, il offre un haut niveau de confort de jeu.', 1, '2020-01-19 17:55:31');

-- --------------------------------------------------------

--
-- Structure de la table `promotion`
--

CREATE TABLE IF NOT EXISTS `promotion` (
  `ID_PROMOTION` int(11) NOT NULL AUTO_INCREMENT,
  `ID_PRODUIT` int(11) DEFAULT NULL,
  `PRIX_PROMOTION` decimal(10,0) DEFAULT NULL,
  `DATE_PROMOTION` char(10) DEFAULT NULL,
  PRIMARY KEY (`ID_PROMOTION`),
  KEY `FK_RELATION_9` (`ID_PRODUIT`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ss_categorie`
--

CREATE TABLE IF NOT EXISTS `ss_categorie` (
  `ID_SS_CATEGORIE` int(11) NOT NULL AUTO_INCREMENT,
  `ID_CATEGORIE` int(11) NOT NULL,
  `ID_S_CATEGORIE` int(11) NOT NULL,
  `CSSTITRE` varchar(250) NOT NULL,
  PRIMARY KEY (`ID_SS_CATEGORIE`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Contenu de la table `ss_categorie`
--

INSERT INTO `ss_categorie` (`ID_SS_CATEGORIE`, `ID_CATEGORIE`, `ID_S_CATEGORIE`, `CSSTITRE`) VALUES
(16, 2, 14, 'Carte graphique'),
(15, 2, 14, 'Carte mère'),
(14, 2, 14, 'Alimentation'),
(13, 2, 14, 'Disque dur'),
(17, 2, 15, 'Clef USB'),
(18, 2, 15, 'Disque dur externe'),
(19, 2, 15, 'Clavier/Souris'),
(20, 2, 15, 'Imprimante'),
(21, 2, 16, 'Pc Portable'),
(22, 2, 16, 'Macbook'),
(23, 2, 16, 'Refroidisseur'),
(24, 2, 16, 'Extension mémoire'),
(25, 2, 16, 'Chargeur'),
(26, 2, 17, 'Ordinateur PC fixe'),
(27, 2, 17, 'Ordinateur Apple'),
(28, 3, 19, 'Compact'),
(29, 3, 19, 'Hybride'),
(30, 3, 19, 'Reflex'),
(31, 3, 20, 'TV'),
(32, 3, 20, 'TV 4K Ultra HD'),
(33, 3, 20, 'TV connectée'),
(34, 3, 21, 'Ampli home cinéma'),
(35, 3, 21, 'Pack home cinéma'),
(36, 4, 24, 'Mobile & smartphone'),
(37, 4, 24, 'Carte mémoire'),
(38, 4, 24, 'Chargeur'),
(39, 4, 25, 'Téléphone sans fil'),
(40, 4, 25, 'Téléphone filaire'),
(41, 4, 25, 'Téléphone VoIP'),
(42, 4, 26, 'Autoradio'),
(43, 4, 26, 'Enceintes'),
(44, 4, 26, 'GPS'),
(45, 4, 26, 'Amplificateur'),
(46, 2, 28, 'Serveur NAS'),
(47, 2, 18, 'Tablette'),
(48, 2, 18, 'iPad');

-- --------------------------------------------------------

--
-- Structure de la table `s_categorie`
--

CREATE TABLE IF NOT EXISTS `s_categorie` (
  `ID_S_CATEGORIE` int(11) NOT NULL AUTO_INCREMENT,
  `ID_CATEGORIE` int(11) NOT NULL,
  `CSTITRE` varchar(250) NOT NULL,
  PRIMARY KEY (`ID_S_CATEGORIE`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Contenu de la table `s_categorie`
--

INSERT INTO `s_categorie` (`ID_S_CATEGORIE`, `ID_CATEGORIE`, `CSTITRE`) VALUES
(20, 3, 'Télévision'),
(19, 3, 'Photo'),
(18, 2, 'Tablettes'),
(17, 2, 'Ordinateurs'),
(16, 2, 'Portables'),
(15, 2, 'Périphériques'),
(14, 2, 'Pièces'),
(21, 3, 'Home cinéma / Hifi'),
(22, 3, 'Son numérique'),
(23, 3, 'Projection'),
(24, 4, 'Mobile'),
(25, 4, 'Fixe'),
(26, 4, 'Auto'),
(28, 2, 'Réseaux');

-- --------------------------------------------------------

--
-- Structure de la table `top_vente`
--

CREATE TABLE IF NOT EXISTS `top_vente` (
  `ID_TOP_VENTE` int(11) NOT NULL AUTO_INCREMENT,
  `ID_PRODUIT` int(11) DEFAULT NULL,
  `NOMBRE_VENTE` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ID_TOP_VENTE`),
  KEY `FK_RELATION_14` (`ID_PRODUIT`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `ID_UTILISATEUR` int(11) NOT NULL AUTO_INCREMENT,
  `CIVILITE` char(50) DEFAULT NULL,
  `EMAIL` varchar(250) DEFAULT NULL,
  `MDP` varchar(250) DEFAULT NULL,
  `NOM` varchar(250) DEFAULT NULL,
  `PRENOM` varchar(250) DEFAULT NULL,
  `DATE_DE_NAISSANCE` date DEFAULT NULL,
  `DATE_INSCRIPTION` datetime DEFAULT NULL,
  PRIMARY KEY (`ID_UTILISATEUR`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`ID_UTILISATEUR`, `CIVILITE`, `EMAIL`, `MDP`, `NOM`, `PRENOM`, `DATE_DE_NAISSANCE`, `DATE_INSCRIPTION`) VALUES
(1, 'Homme', 'm.vola@ymail.com', '12345678', 'RAZAFIMNDIMBY', 'Onintsoa', '2019-05-15', '2019-12-17 00:00:00'),
(4, 'Homme', 'mahefa@ymail.com', '123456789', 'ANDRIANATOANDRO', 'Mahefa Sandratra', '1994-12-28', '2019-12-17 16:24:06'),
(3, 'Homme', 'ando@ymail.com', '12345678', 'RANDRIANASOLO', 'Ando niaina', '2019-12-04', '2019-12-17 16:18:41'),
(5, 'Homme', 'stephanie@ymail.com', '12345678', 'RAKOTONIRINA', 'Stephanie', '1994-05-05', '2019-12-17 16:28:04'),
(6, 'Homme', 'aina@ymail.com', '12345678', 'JARNOU', 'Aina', '1994-05-05', '2019-12-17 16:55:37'),
(7, 'Femme', 'njaka@ymail.com', '12345678', 'ANDRIANATOANDRO', 'Njaka', '1994-05-05', '2019-12-17 21:38:27'),
(8, 'Femme', 'tahiry@ymail.com', '12345678', 'RAZAFIMAHEFA', 'Tahiry', '1994-05-05', '2019-12-17 21:40:05'),
(9, 'Femme', 'koto@ymail.com', '12345678', 'RAKOTO', 'Koto', '1994-12-21', '2019-12-17 22:35:48'),
(10, 'Homme', 'vola@ymail.com', '12345678', 'RAZAFIMNDIMBY', 'Vola', '1994-05-02', '2020-01-13 14:55:06'),
(11, 'Homme', 'kobe@ymail.com', '12345678', 'SANDRATRA', 'Mahefa', '1989-01-11', '2020-01-13 14:56:40'),
(12, 'Femme', 'tahina@ymail.com', '12345678', 'RAMANANTSOA', 'Tahina', '2020-01-08', '2020-01-13 15:02:36');

-- --------------------------------------------------------

--
-- Structure de la table `ville_tarif`
--

CREATE TABLE IF NOT EXISTS `ville_tarif` (
  `id_ville_tarif` int(11) NOT NULL AUTO_INCREMENT,
  `ville` varchar(255) NOT NULL,
  `0ga50g` double NOT NULL,
  `50ga1000g` double NOT NULL,
  `1000ga5000g` double NOT NULL,
  `5000ga10000g` double NOT NULL,
  `10000ga15000g` double NOT NULL,
  `15000ga20000g` double NOT NULL,
  `20000ga30000g` double NOT NULL,
  `30000ga40000g` double NOT NULL,
  `40000ga60000g` double NOT NULL,
  `60kgplus` double NOT NULL,
  PRIMARY KEY (`id_ville_tarif`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=95 ;

--
-- Contenu de la table `ville_tarif`
--

INSERT INTO `ville_tarif` (`id_ville_tarif`, `ville`, `0ga50g`, `50ga1000g`, `1000ga5000g`, `5000ga10000g`, `10000ga15000g`, `15000ga20000g`, `20000ga30000g`, `30000ga40000g`, `40000ga60000g`, `60kgplus`) VALUES
(3, 'Antananarivo', 4000, 5000, 6000, 8500, 13000, 14000, 20000, 25000, 30000, 600),
(4, 'Manjakandriana', 4000, 5000, 6000, 8500, 13000, 14000, 20000, 25000, 30000, 600),
(5, 'Behenjy', 4000, 5000, 6000, 8500, 13000, 14000, 20000, 25000, 30000, 600),
(6, 'Ambatolampy', 4000, 5000, 6000, 8500, 13000, 14000, 20000, 25000, 30000, 600),
(7, 'Antanifotsy', 4000, 5000, 6000, 8500, 13000, 14000, 20000, 25000, 30000, 600),
(8, 'Ambohibaty', 4000, 5000, 6000, 8500, 13000, 14000, 20000, 25000, 30000, 600),
(9, 'Antsirabe', 4000, 5000, 6000, 8500, 13000, 14000, 20000, 25000, 30000, 600),
(10, 'Betafo', 4000, 5000, 6000, 8500, 13000, 14000, 20000, 25000, 30000, 600),
(11, 'Ankazomiriotra', 4000, 5000, 6000, 8500, 13000, 14000, 20000, 25000, 30000, 600),
(12, 'Mandoto', 4000, 5000, 6000, 8500, 13000, 14000, 20000, 25000, 30000, 600),
(13, 'Anjoma Ramartina', 4000, 5000, 6000, 8500, 13000, 14000, 20000, 25000, 30000, 600),
(14, 'Imertsiatosika', 4000, 5000, 6000, 8500, 13000, 14000, 20000, 25000, 30000, 600),
(15, 'Arivonimamo', 4000, 5000, 6000, 8500, 13000, 14000, 20000, 25000, 30000, 600),
(16, 'Ambositra', 4000, 5000, 6000, 8500, 13000, 14000, 20000, 25000, 30000, 600),
(17, 'Alarobia Vohiposa', 4000, 5000, 6000, 8500, 13000, 14000, 20000, 25000, 30000, 600),
(18, 'Ambohimahasoa', 4000, 5000, 6000, 8500, 13000, 14000, 20000, 25000, 30000, 600),
(19, 'Ambohidratrimo', 4000, 5000, 6000, 8500, 13000, 14000, 20000, 25000, 30000, 600),
(20, 'Mahitsy', 4000, 5000, 6000, 8500, 13000, 14000, 20000, 25000, 30000, 600),
(21, 'Rsiroanomandidy', 4000, 5000, 6500, 9800, 14700, 17000, 24000, 30000, 32000, 650),
(22, 'Miarinarivo', 4000, 5000, 6500, 9800, 14700, 17000, 24000, 30000, 32000, 650),
(23, 'Analavory', 4000, 5000, 6500, 9800, 14700, 17000, 24000, 30000, 32000, 650),
(24, 'Ampefy', 4000, 5000, 6500, 9800, 14700, 17000, 24000, 30000, 32000, 650),
(25, 'Soavinandriana', 4000, 5000, 6500, 9800, 14700, 17000, 24000, 30000, 32000, 650),
(26, 'Babetville', 4000, 5000, 6500, 9800, 14700, 17000, 24000, 30000, 32000, 650),
(27, 'Fianarantsoa', 4000, 5000, 6500, 9800, 14700, 17000, 24000, 30000, 32000, 650),
(28, 'Ambalavao', 4000, 5000, 6500, 9800, 14700, 17000, 24000, 30000, 32000, 650),
(29, 'Ankaramena', 4000, 5000, 6500, 9800, 14700, 17000, 24000, 30000, 32000, 650),
(30, 'Miandrivazo', 4000, 5000, 6500, 9800, 14700, 17000, 24000, 30000, 32000, 650),
(31, 'Ambatolahy', 4000, 5000, 6500, 9800, 14700, 17000, 24000, 30000, 32000, 650),
(32, 'Malaimbandy', 4000, 5000, 6500, 9800, 14700, 17000, 24000, 30000, 32000, 650),
(33, 'Ranomafana Centre', 4000, 5000, 6500, 9800, 14700, 17000, 24000, 30000, 32000, 650),
(34, 'Ifanadiana', 4000, 5000, 6500, 9800, 14700, 17000, 24000, 30000, 32000, 650),
(35, 'Ikanjavato', 4000, 5000, 6500, 9800, 14700, 17000, 24000, 30000, 32000, 650),
(36, 'Moramanga', 4000, 5000, 6500, 9800, 14700, 17000, 24000, 30000, 32000, 650),
(37, 'Andasibe', 4000, 5000, 6500, 9800, 14700, 17000, 24000, 30000, 32000, 650),
(38, 'Ranomafana Est', 4000, 5000, 6500, 9800, 14700, 17000, 24000, 30000, 32000, 650),
(39, 'Amboasary', 4000, 5000, 6500, 9800, 14700, 17000, 24000, 30000, 32000, 650),
(40, 'Andaingo', 4000, 5000, 6500, 9800, 14700, 17000, 24000, 30000, 32000, 650),
(41, 'Andilanatoby', 4000, 5000, 6500, 9800, 14700, 17000, 24000, 30000, 32000, 650),
(42, 'Manakambahiny', 4000, 5000, 6500, 9800, 14700, 17000, 24000, 30000, 32000, 650),
(43, 'Ankazobe Centre', 4000, 5000, 6500, 9800, 14700, 17000, 24000, 30000, 32000, 650),
(44, 'Mahatsinjo', 4000, 5000, 6500, 9800, 14700, 17000, 24000, 30000, 32000, 650),
(45, 'Andriba', 4000, 5000, 6500, 9800, 14700, 17000, 24000, 30000, 32000, 650),
(46, 'Ihosy', 4000, 5000, 8500, 15000, 20000, 22000, 31000, 40000, 42000, 750),
(47, 'Ranohiry', 4000, 5000, 8500, 15000, 20000, 22000, 31000, 40000, 42000, 750),
(48, 'Ankilizato', 4000, 5000, 8500, 15000, 20000, 22000, 31000, 40000, 42000, 750),
(49, 'Mahabo', 4000, 5000, 8500, 15000, 20000, 22000, 31000, 40000, 42000, 750),
(50, 'Morondava', 4000, 5000, 8500, 15000, 20000, 22000, 31000, 40000, 42000, 750),
(51, 'Betroka', 4000, 5000, 8500, 15000, 20000, 22000, 31000, 40000, 42000, 750),
(52, 'Antsenavolo', 4000, 5000, 8500, 15000, 20000, 22000, 31000, 40000, 42000, 750),
(53, 'Mananjary', 4000, 5000, 8500, 15000, 20000, 22000, 31000, 40000, 42000, 750),
(54, 'Ambatondrazaka', 4000, 5000, 8500, 15000, 20000, 22000, 31000, 40000, 42000, 750),
(55, 'Brickaville', 4000, 5000, 8500, 15000, 20000, 22000, 31000, 40000, 42000, 750),
(56, 'Toamasina', 4000, 5000, 8500, 15000, 20000, 22000, 31000, 40000, 42000, 750),
(57, 'Foulpoint', 4000, 5000, 8500, 15000, 20000, 22000, 31000, 40000, 42000, 750),
(58, 'Vatomandry', 4000, 5000, 8500, 15000, 20000, 22000, 31000, 40000, 42000, 750),
(59, 'Mahanoro', 4000, 5000, 8500, 15000, 20000, 22000, 31000, 40000, 42000, 750),
(60, 'Maevatanana', 4000, 5000, 8500, 15000, 20000, 22000, 31000, 40000, 42000, 750),
(61, 'Tulear', 4000, 5000, 10000, 15500, 22200, 25000, 36000, 46800, 50000, 850),
(62, 'Sakaraha', 4000, 5000, 10000, 15500, 22200, 25000, 36000, 46800, 50000, 850),
(63, 'Manakara', 4000, 5000, 10000, 15500, 22200, 25000, 36000, 46800, 50000, 850),
(64, 'Vohipeno', 4000, 5000, 10000, 15500, 22200, 25000, 36000, 46800, 50000, 850),
(65, 'Farafangana', 4000, 5000, 10000, 15500, 22200, 25000, 36000, 46800, 50000, 850),
(66, 'Isoanala', 4000, 5000, 10000, 15500, 22200, 25000, 36000, 46800, 50000, 850),
(67, 'Beraketa', 4000, 5000, 10000, 15500, 22200, 25000, 36000, 46800, 50000, 850),
(68, 'Bekily', 4000, 5000, 10000, 15500, 22200, 25000, 36000, 46800, 50000, 850),
(69, 'Antanimora', 4000, 5000, 10000, 15500, 22200, 25000, 36000, 46800, 50000, 850),
(70, 'Ambovombe', 4000, 5000, 10000, 15500, 22200, 25000, 36000, 46800, 50000, 850),
(71, 'Amboasary', 4000, 5000, 10000, 15500, 22200, 25000, 36000, 46800, 50000, 850),
(72, 'Manambao', 4000, 5000, 10000, 15500, 22200, 25000, 36000, 46800, 50000, 850),
(73, 'Fort-dauphin', 4000, 5000, 10000, 15500, 22200, 25000, 36000, 46800, 50000, 850),
(74, 'Vavatenina', 4000, 5000, 10000, 15500, 22200, 25000, 36000, 46800, 50000, 850),
(75, 'Fenerive Est', 4000, 5000, 10000, 15500, 22200, 25000, 36000, 46800, 50000, 850),
(76, 'Soanierana Ivongo', 4000, 5000, 10000, 15500, 22200, 25000, 36000, 46800, 50000, 850),
(77, 'Mahajanga', 4000, 5000, 10000, 15500, 22200, 25000, 36000, 46800, 50000, 850),
(78, 'Tsaramandroso', 4000, 5000, 10000, 15500, 22200, 25000, 36000, 46800, 50000, 850),
(79, 'Andranofasika', 4000, 5000, 10000, 15500, 22200, 25000, 36000, 46800, 50000, 850),
(80, 'Marovoay', 4000, 5000, 10000, 15500, 22200, 25000, 36000, 46800, 50000, 850),
(81, 'Mampikony', 4000, 5000, 10000, 15500, 22200, 25000, 36000, 46800, 50000, 850),
(82, 'Port-Berger', 4000, 5000, 10000, 15500, 22200, 25000, 36000, 46800, 50000, 850),
(83, 'Anahindrano', 4000, 5000, 10000, 15500, 22200, 25000, 36000, 46800, 50000, 850),
(84, 'Antsohihy', 4000, 5000, 10000, 15500, 22200, 25000, 36000, 46800, 50000, 850),
(85, 'Maromandia', 4000, 5000, 10000, 15500, 22200, 25000, 36000, 46800, 50000, 850),
(86, 'Djangoa', 4000, 5000, 12000, 20000, 30000, 38000, 44000, 52000, 60000, 1100),
(87, 'Ambilobe', 4000, 5000, 12000, 20000, 30000, 38000, 44000, 52000, 60000, 1100),
(88, 'Anivorano Nord', 4000, 5000, 12000, 20000, 30000, 38000, 44000, 52000, 60000, 1100),
(89, 'Diego Suarez', 4000, 5000, 12000, 20000, 30000, 38000, 44000, 52000, 60000, 1100),
(90, 'Nosy Be', 4000, 5000, 15000, 22500, 30500, 42500, 62500, 85000, 105000, 2200),
(91, 'Vohemara', 4000, 5000, 15000, 22500, 30500, 42500, 62500, 85000, 105000, 2200),
(92, 'Antalaha', 4000, 5000, 15000, 22500, 30500, 42500, 62500, 85000, 105000, 2200),
(93, 'Andapa', 4000, 5000, 15000, 22500, 30500, 42500, 62500, 85000, 105000, 2200),
(94, 'Sambava', 4000, 5000, 15000, 22500, 30500, 42500, 62500, 85000, 105000, 2200);

-- --------------------------------------------------------

--
-- Structure de la table `visiteur`
--

CREATE TABLE IF NOT EXISTS `visiteur` (
  `ID_VISITEUR` int(11) NOT NULL AUTO_INCREMENT,
  `ID_UTILISATEUR` int(11) DEFAULT NULL,
  `TIMES_TAMP` varchar(50) DEFAULT NULL,
  `ETAT` varchar(50) DEFAULT NULL,
  `NB_VISITEUR` bigint(20) DEFAULT NULL,
  `IP_VISITEUR` varchar(50) DEFAULT NULL,
  `DATE_VISITE` datetime DEFAULT NULL,
  PRIMARY KEY (`ID_VISITEUR`),
  KEY `FK_RELATION_16` (`ID_UTILISATEUR`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
