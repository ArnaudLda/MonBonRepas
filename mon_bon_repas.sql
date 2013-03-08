-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Ven 08 Mars 2013 à 10:53
-- Version du serveur: 5.5.16
-- Version de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `mon_bon_repas`
--

-- --------------------------------------------------------

--
-- Structure de la table `aliments`
--

CREATE TABLE IF NOT EXISTS `aliments` (
  `id_aliment` int(50) NOT NULL AUTO_INCREMENT,
  `categorie` varchar(255) NOT NULL,
  `aliment` varchar(255) NOT NULL,
  PRIMARY KEY (`id_aliment`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

--
-- Contenu de la table `aliments`
--

INSERT INTO `aliments` (`id_aliment`, `categorie`, `aliment`) VALUES
(1, 'Viande', 'Boeuf'),
(2, 'Viande', 'Mouton'),
(3, 'Légume', 'Poireaux'),
(4, 'Boisson', 'Coca'),
(5, 'Viande', 'Cheval'),
(6, 'Légume', 'Tomate'),
(7, 'Légume', 'Pomme de terre'),
(8, 'Légume', 'Haricots verts'),
(9, 'Légume', 'Brocolis'),
(10, 'Viande', 'Canard'),
(11, 'Viande', 'Porc'),
(12, 'Viande', 'Poulet'),
(13, 'Viande', 'Dinde'),
(14, 'Viande', 'Lapin'),
(15, 'Viande', 'Veau'),
(16, 'Viande', 'Gibier'),
(17, 'Viande', 'Merguez'),
(18, 'Viande', 'Chipolata'),
(19, 'Légume', 'Epinard'),
(20, 'Légume', 'Choux de Bruxelles'),
(21, 'Légume', 'Courgette'),
(22, 'Légume', 'Poivron'),
(23, 'Légume', 'Aubergine'),
(24, 'Légume', 'Carotte'),
(25, 'Légume', 'Tomate'),
(26, 'Fruit', 'Banane'),
(27, 'Fruit', 'Kiwi'),
(28, 'Fruit', 'Cerise'),
(29, 'Fruit', 'Fraise'),
(30, 'Fruit', 'Melon'),
(31, 'Fruit', 'Framboise'),
(32, 'Fruit', 'Pomme'),
(33, 'Fruit', 'Groseille'),
(34, 'Fruit', 'Clémentine'),
(35, 'Fruit', 'Mandarine'),
(36, 'Fruit', 'Orange'),
(37, 'Fruit', 'Mangue'),
(38, 'Fruit', 'Poire'),
(39, 'Fruit', 'Mûre'),
(40, 'Fromage', 'Camembert'),
(41, 'Fromage', 'Comté'),
(42, 'Fromage', 'Brie'),
(43, 'Fromage', 'Cantal'),
(44, 'Fromage', 'Bleu de chèvre'),
(45, 'Fromage', 'Tome de chèvre'),
(46, 'Fromage', 'Roquefort'),
(47, 'Fromage', 'Faiselle'),
(48, 'Fromage', 'Brique'),
(49, 'Fromage', 'Tome de brebis'),
(50, 'Poisson', 'Saumon'),
(51, 'Poisson', 'Maquereau'),
(52, 'Poisson', 'Sole'),
(53, 'Poisson', 'Truite'),
(54, 'Poisson', 'Thon'),
(55, 'Poisson', 'Brochet'),
(56, 'Poisson', 'Colin'),
(57, 'Accompagnement', 'Riz'),
(58, 'Accompagnement', 'Pâtes'),
(59, 'Accompagnement', 'Blé'),
(60, 'Accompagnement', 'Semoule'),
(61, 'Accompagnement', 'Maïs');

-- --------------------------------------------------------

--
-- Structure de la table `inscrit`
--

CREATE TABLE IF NOT EXISTS `inscrit` (
  `id` int(50) NOT NULL AUTO_INCREMENT COMMENT 'clé primaire',
  `prenom` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `gout` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `avatar` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Contenu de la table `inscrit`
--

INSERT INTO `inscrit` (`id`, `prenom`, `nom`, `mail`, `passwd`, `gout`, `contact`, `avatar`) VALUES
(1, 'Arnaud', 'Laumond', 'utar@hotmail.fr', 'nono', 'a:5:{s:3:"0_0";s:2:"on";s:3:"0_2";s:2:"on";s:3:"1_0";s:2:"on";s:3:"1_3";s:2:"on";s:3:"1_4";s:2:"on";}', 'a:6:{i:0;s:13:"lol@gmail.com";i:1;s:20:"robert.lol@gmail.com";i:2;s:14:"loli@gmail.com";i:3;s:14:"bibi@gmail.com";i:4;s:15:"kikoo@gmail.com";i:5;s:16:"robert@gmail.com";}', ''),
(2, 'dgrg', 'rgh', 'hhrh', 'rhhrh', '', '', ''),
(4, 'Arnaud', 'Laumond', 'utar@hotmail.fr', 'caca92', '', '', ''),
(6, 'Sofien', 'Troudi', 'lol@gmail.com', 'lol', 'a:4:{s:3:"0_0";s:2:"on";s:3:"0_2";s:2:"on";s:3:"1_0";s:2:"on";s:3:"1_4";s:2:"on";}', '', ''),
(7, 'batard', 'de merde', 'kikoo@gmail.com', 'lol', 'a:4:{s:3:"0_0";s:2:"on";s:3:"0_2";s:2:"on";s:3:"1_0";s:2:"on";s:3:"1_4";s:2:"on";}', 'a:5:{i:0;s:13:"lol@gmail.com";i:1;s:20:"robert.lol@gmail.com";i:2;s:14:"loli@gmail.com";i:3;s:14:"bibi@gmail.com";i:4;s:15:"kikoo@gmail.com";}', ''),
(28, 'baby', 'baby', 'bb@gmail.com', 'oh', '', '', ''),
(29, 'lol', 'lol', 'zuhfsi@gmail.com', 'zlg', '', '', ''),
(30, 'Jojo', 'BLOUPER', 'bla@gmail.com', '0fd06c7ae501e59de591a8d45c47cd38', '', 'a:2:{i:0;s:13:"lol@gmail.com";i:1;s:15:"kikoo@gmail.com";}', 'uploads/avatars/profilnone.jpg'),
(31, 'bla', 'bla', 'loli@gmail.com', '0fd06c7ae501e59de591a8d45c47cd38', 'a:4:{s:3:"0_0";s:2:"on";s:3:"0_1";s:2:"on";s:3:"1_3";s:2:"on";s:3:"1_4";s:2:"on";}', '', 'uploads/avatars/profilnone.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lib` text NOT NULL,
  `id_auteur` int(11) NOT NULL,
  `id_repas` int(11) NOT NULL,
  `date_heure` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `message`
--

INSERT INTO `message` (`id`, `lib`, `id_auteur`, `id_repas`, `date_heure`) VALUES
(9, 'lol', 1, 2, '2013-03-02 13:13:48');

-- --------------------------------------------------------

--
-- Structure de la table `repas`
--

CREATE TABLE IF NOT EXISTS `repas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `log_crea` varchar(100) NOT NULL,
  `log_invit` varchar(100) NOT NULL,
  `vu` tinyint(1) NOT NULL DEFAULT '0',
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `statut` varchar(100) NOT NULL DEFAULT 'non_lu',
  `date` date NOT NULL,
  `Lib_lieu` text NOT NULL,
  `is_inscrit` tinyint(1) NOT NULL DEFAULT '0',
  `id_repas` int(10) NOT NULL,
  `titre` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `log_crea` (`log_crea`),
  KEY `log_invit` (`log_invit`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=124 ;

--
-- Contenu de la table `repas`
--

INSERT INTO `repas` (`id`, `log_crea`, `log_invit`, `vu`, `lat`, `lng`, `statut`, `date`, `Lib_lieu`, `is_inscrit`, `id_repas`, `titre`) VALUES
(106, '1', '28', 0, 49.074, 2.67156, 'non_lu', '2013-03-28', '77280 Othis, France', 1, 268, ''),
(107, '1', '6', 0, 49.074, 2.67156, 'non_lu', '2013-03-28', '77280 Othis, France', 1, 268, ''),
(110, '1', 'roger@hotmail.com', 0, 0, 0, 'non_lu', '2013-03-13', '77280 Othis', 0, 18, ''),
(111, '1', 'coucou@gmail.com', 0, 0, 0, 'non_lu', '2013-03-13', '77280 Othis', 0, 18, ''),
(112, '1', '6', 0, 0, 0, 'non_lu', '2013-03-13', '77280 Othis', 1, 18, ''),
(113, '1', '31', 0, 0, 0, 'non_lu', '2013-03-13', '77280 Othis', 1, 18, ''),
(114, '1', 'robert@gmail.com', 0, 0, 0, 'non_lu', '2013-03-13', '77280 Othis', 0, 18, ''),
(115, '30', '1', 0, 0, 49.074, 'non_lu', '2013-03-30', '77280 Othis, France', 1, 36, 'Mon repas'),
(116, '30', '7', 0, 0, 49.074, 'non_lu', '2013-03-30', '77280 Othis, France', 1, 36, 'Mon repas'),
(117, '30', '31', 0, 0, 49.074, 'non_lu', '2013-03-30', '77280 Othis, France', 1, 36, 'Mon repas'),
(118, '30', 'coucou@gmail.com', 0, 0, 49.074, 'non_lu', '2013-03-30', '77280 Othis, France', 0, 36, 'Mon repas'),
(119, '30', '6', 0, 0, 49.074, 'non_lu', '2013-03-30', '77280 Othis, France', 1, 36, 'Mon repas'),
(120, '31', '30', 0, 0, 49.074, 'non_lu', '2013-03-02', '77280 Othis, France', 1, 660, 'BLABLA'),
(121, '31', '7', 0, 0, 49.074, 'non_lu', '2013-03-02', '77280 Othis, France', 1, 660, 'BLABLA'),
(122, '30', '7', 0, 2.42099, 48.8516, 'non_lu', '2013-03-05', '93100 Montreuil, France', 1, 617, 'KIKOOO'),
(123, '30', '31', 0, 2.42098, 48.8516, 'non_lu', '2013-03-19', '93100 Montreuil, France', 1, 193, 'BLAB');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
