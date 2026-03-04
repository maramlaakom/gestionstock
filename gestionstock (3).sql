-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2026 at 11:34 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestionstock`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id_article` int(11) NOT NULL,
  `nom_article` varchar(100) NOT NULL,
  `modele` varchar(100) DEFAULT NULL,
  `numero_serie` varchar(100) DEFAULT NULL,
  `cout` decimal(10,2) DEFAULT NULL,
  `quantite` int(11) DEFAULT 0,
  `id_magasin` int(11) DEFAULT NULL,
  `etat` enum('actif','supprime') DEFAULT 'actif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id_article`, `nom_article`, `modele`, `numero_serie`, `cout`, `quantite`, `id_magasin`, `etat`) VALUES
(45, 'souris', 'hp', 'azedfgbn', 123.00, 358, 11, ''),
(46, 'souris', 'hp', NULL, 123.00, 124, 12, ''),
(47, 'sdfg', 'edfr', '12234T', 123.00, 123, 11, 'supprime'),
(48, 'sdfg', 'edfr', NULL, 123.00, 0, 12, ''),
(49, 'dfgd', 'dsfgb', 'dcvfbgnh', 1234.00, 1, 11, ''),
(50, 'dfgd', 'dsfgb', NULL, 1234.00, 0, 12, ''),
(51, 'souris', 'hp', '\'123N?K', 30.00, 0, 11, ''),
(52, 'sdf', 'df', 'zdszdf', 12.00, 1, 11, ''),
(53, 'sdf', 'df', NULL, 12.00, 0, 12, ''),
(54, 'RTGHY', 'TGHY', '123', 12.00, 1, 12, ''),
(55, 'RTGHY', 'TGHY', NULL, 12.00, 0, 11, ''),
(56, 'FGVBH', 'DFG', 'DFGBNH', 12.00, 1, 11, ''),
(57, 'FGVBH', 'DFG', NULL, 12.00, 0, 12, ''),
(58, 'bhjk', 'dfvgb', 'fdgb', 12.00, 0, 11, 'actif'),
(59, 'bhjk', 'dfvgb', NULL, 12.00, 0, 12, 'actif'),
(60, 'dfgd', 'sdfrgthn', 'dvfbgn', 0.05, 138, 12, 'actif'),
(61, 'dfgh', 'sdfg', 'dfgh', 20.00, 0, 12, 'supprime'),
(62, 'ghjn,kl;', 'vbn,', 'ghjk', 12.00, 0, 11, 'actif'),
(63, 'ghjn,kl;', 'vbn,', NULL, 12.00, 1, 12, 'actif');

-- --------------------------------------------------------

--
-- Table structure for table `demande_contact`
--

CREATE TABLE `demande_contact` (
  `id_demande` int(11) NOT NULL,
  `id_utilisateur` int(11) DEFAULT NULL,
  `id_magasin_dest` int(11) DEFAULT NULL,
  `id_article` int(11) DEFAULT NULL,
  `qte_demande` int(11) DEFAULT NULL,
  `sujet` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `statut` enum('en_attente','approuvee','refusee','executed') DEFAULT 'en_attente',
  `date_demande` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `demande_contact`
--

INSERT INTO `demande_contact` (`id_demande`, `id_utilisateur`, `id_magasin_dest`, `id_article`, `qte_demande`, `sujet`, `message`, `statut`, `date_demande`) VALUES
(1, 1, NULL, NULL, NULL, 'DEMANDE DE TRANSERT DE PRODUIT', 'YA WLDI I9BEL IL DEMMANDE', 'refusee', '2026-01-07 15:22:55'),
(2, 18, NULL, NULL, NULL, 'DEMANDE PERMISSION', 'DEMANDE_ACCES | ID_ART:22 | QTY:12 | TYPE:sortie | FROM:IOT | TO:IOT', 'approuvee', '2026-01-23 16:03:54'),
(3, 20, NULL, NULL, 10, 'DEMANDE PERMISSION', 'DEMANDE_ACCES | ID_ART:22 | QTY:10 | TYPE:sortie | FROM:IOT | TO:IOT', 'approuvee', '2026-01-24 22:49:26'),
(4, 20, NULL, NULL, 12, 'DEMANDE PERMISSION', 'DEMANDE_ACCES | ID_ART:23 | QTY:12 | TYPE:sortie | FROM:IOT | TO:IOT', 'approuvee', '2026-01-25 00:30:36'),
(5, 20, NULL, NULL, 12, 'DEMANDE PERMISSION', 'DEMANDE_ACCES | ID_ART:22 | QTY:12 | TYPE:transfert | FROM:IOT | TO:iot2', 'approuvee', '2026-01-25 00:37:24'),
(6, 20, NULL, NULL, 12, 'DEMANDE PERMISSION', 'DEMANDE_ACCES | Nom_ART:souris | QTY:12 | TYPE:transfert | FROM:IOT | TO:iot2', 'approuvee', '2026-01-25 13:51:21'),
(22, 18, NULL, 58, 123, 'DEMANDE PERMISSION', 'DEMANDE_ACCES | Employé: er az | Art: bhjk | Qty: 123 | Type: sortie | From: iot | To: N/A', 'approuvee', '2026-01-29 22:04:03'),
(23, 18, NULL, 58, 12, 'DEMANDE PERMISSION', 'DEMANDE_ACCES | Employé: er az | Art: bhjk | Qty: 12 | Type: sortie | From: iot | To: N/A', 'approuvee', '2026-01-29 22:15:33'),
(24, 26, NULL, 60, 11, 'DEMANDE PERMISSION', 'DEMANDE_ACCES | Employé: achwak belili | Art: dfgd | Qty: 11 | Type: sortie | From: iot2 | To: N/A', 'refusee', '2026-01-30 14:42:17'),
(25, 26, NULL, 62, 2, 'DEMANDE PERMISSION', 'DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 2 | Type: sortie | From: iot | To: N/A', 'en_attente', '2026-01-30 14:44:16'),
(26, 26, NULL, 62, 22, 'DEMANDE PERMISSION', 'DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 22 | Type: sortie | From: iot | To: N/A', 'en_attente', '2026-01-30 14:45:08'),
(27, 26, NULL, 62, 22, 'DEMANDE PERMISSION', 'DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 22 | Type: sortie | From: iot | To: N/A', 'approuvee', '2026-01-30 14:45:39'),
(28, 26, NULL, 63, 20, 'DEMANDE PERMISSION', 'DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 20 | Type: sortie | From: iot2 | To: N/A', 'approuvee', '2026-01-30 15:33:02');

-- --------------------------------------------------------

--
-- Table structure for table `historique_movement`
--

CREATE TABLE `historique_movement` (
  `id_historique` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  `type_mouvement` enum('entree','sortie','transfert') NOT NULL,
  `quantite` int(11) NOT NULL,
  `date_mouvement` datetime DEFAULT current_timestamp(),
  `id_utilisateur` int(11) NOT NULL,
  `id_magasin_src` int(11) DEFAULT NULL,
  `id_magasin_dst` int(11) DEFAULT NULL,
  `commentaire` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `historique_movement`
--

INSERT INTO `historique_movement` (`id_historique`, `id_article`, `type_mouvement`, `quantite`, `date_mouvement`, `id_utilisateur`, `id_magasin_src`, `id_magasin_dst`, `commentaire`) VALUES
(98, 45, 'entree', 1, '2026-01-29 16:48:43', 15, NULL, 11, 'Nouvel article ajoute'),
(99, 45, 'entree', 123, '2026-01-29 18:33:52', 15, NULL, 11, NULL),
(100, 45, 'sortie', 12, '2026-01-29 18:34:20', 15, 11, NULL, 'Sortie validée'),
(101, 45, 'transfert', 112, '2026-01-29 19:30:18', 15, 11, 12, 'Transfert effectué'),
(102, 46, 'transfert', 112, '2026-01-29 19:33:27', 15, 12, 11, 'Transfert effectué'),
(103, 46, 'entree', 123, '2026-01-29 19:40:34', 15, NULL, 12, NULL),
(104, 46, 'transfert', 123, '2026-01-29 19:40:46', 15, 12, 11, 'Transfert effectué'),
(105, 46, 'entree', 123, '2026-01-29 19:42:03', 15, NULL, 12, NULL),
(106, 46, 'transfert', 123, '2026-01-29 19:42:27', 15, 12, 11, 'Transfert effectué'),
(107, 47, 'entree', 1, '2026-01-29 19:48:03', 15, NULL, 11, 'Nouvel article ajoute'),
(108, 47, 'entree', 123, '2026-01-29 19:48:13', 15, NULL, 11, NULL),
(109, 47, 'transfert', 123, '2026-01-29 19:48:22', 15, 11, 12, 'Transfert effectué'),
(111, 47, 'sortie', 1, '2026-01-29 19:49:18', 15, 11, NULL, 'Suppression definitive par  ab cd'),
(113, 48, 'transfert', 123, '2026-01-29 19:53:39', 15, 12, 11, 'Transfert effectué'),
(114, 49, 'entree', 1, '2026-01-29 19:58:57', 15, NULL, 11, 'Nouvel article ajoute'),
(115, 49, 'transfert', 1, '2026-01-29 19:59:11', 15, 11, 12, 'Transfert effectué'),
(116, 51, 'entree', 1, '2026-01-29 20:00:15', 15, NULL, 11, 'Nouvel article ajoute'),
(117, 51, 'entree', 123, '2026-01-29 20:00:26', 15, NULL, 11, NULL),
(118, 51, 'transfert', 124, '2026-01-29 20:01:27', 15, 11, 12, 'Transfert effectué'),
(119, 50, 'transfert', 1, '2026-01-29 20:01:51', 15, 12, 11, 'Transfert effectué'),
(120, 52, 'entree', 1, '2026-01-29 20:07:53', 15, NULL, 11, 'Nouvel article ajoute'),
(121, 52, 'transfert', 1, '2026-01-29 20:09:37', 15, 11, 12, 'Transfert effectué'),
(122, 53, 'transfert', 1, '2026-01-29 20:10:00', 15, 12, 11, 'Transfert effectué'),
(123, 54, 'entree', 1, '2026-01-29 20:12:06', 15, NULL, 12, 'Nouvel article ajoute'),
(124, 54, 'transfert', 1, '2026-01-29 20:12:27', 15, 12, 11, 'Transfert effectué'),
(125, 55, 'transfert', 1, '2026-01-29 20:13:01', 15, 11, 12, 'Transfert effectué'),
(126, 56, 'entree', 1, '2026-01-29 20:13:54', 15, NULL, 11, 'Nouvel article ajoute'),
(127, 56, 'transfert', 1, '2026-01-29 20:14:04', 15, 11, 12, 'Transfert effectué'),
(128, 57, 'transfert', 1, '2026-01-29 20:14:17', 15, 12, 11, 'Transfert effectué'),
(129, 58, 'entree', 1, '2026-01-29 20:21:21', 15, NULL, 11, 'Nouvel article ajoute'),
(130, 58, 'transfert', 1, '2026-01-29 20:21:50', 15, 11, 12, 'Transfert effectué'),
(131, 59, 'transfert', 1, '2026-01-29 20:23:37', 15, 12, 11, 'Transfert effectué'),
(132, 58, 'sortie', 1, '2026-01-29 20:24:05', 15, 11, NULL, 'Sortie validée'),
(133, 60, 'entree', 1, '2026-01-29 20:28:48', 15, NULL, 12, 'Nouvel article ajoute'),
(134, 60, 'entree', 123, '2026-01-29 20:33:38', 15, NULL, 12, NULL),
(135, 60, 'entree', 12, '2026-01-29 20:34:14', 15, NULL, 12, NULL),
(136, 61, 'entree', 1, '2026-01-29 21:29:27', 15, NULL, 12, 'Nouvel article ajoute'),
(137, 62, 'entree', 1, '2026-01-30 12:05:10', 15, NULL, 11, 'Nouvel article ajoute'),
(138, 61, 'sortie', 1, '2026-01-30 12:05:27', 15, 12, NULL, 'Suppression definitive par  ab cd'),
(139, 60, 'entree', 2, '2026-01-30 14:43:51', 26, NULL, 12, NULL),
(140, 62, 'transfert', 1, '2026-01-30 15:21:37', 19, 11, 12, 'Transfert effectué');

-- --------------------------------------------------------

--
-- Table structure for table `magasin`
--

CREATE TABLE `magasin` (
  `id_magasin` int(11) NOT NULL,
  `nom_magasin` varchar(50) NOT NULL,
  `adresse` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `magasin`
--

INSERT INTO `magasin` (`id_magasin`, `nom_magasin`, `adresse`) VALUES
(11, 'iot', 'iot'),
(12, 'iot2', 'ae');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id_message` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `contenu` text NOT NULL,
  `type` enum('utilisateur','chatbot') NOT NULL,
  `date_message` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id_message`, `id_utilisateur`, `contenu`, `type`, `date_message`) VALUES
(45, 18, 'ok', 'chatbot', '2026-01-26 15:43:21'),
(46, 18, 'ok1', 'chatbot', '2026-01-26 15:43:29'),
(47, 18, 'OK&amp;', 'chatbot', '2026-01-26 15:43:34'),
(48, 18, 'OK3', 'chatbot', '2026-01-26 15:44:36'),
(49, 18, 'rtt', 'chatbot', '2026-01-26 15:54:08'),
(50, 18, 'h', 'chatbot', '2026-01-26 15:54:09'),
(51, 18, 'sdffff', 'chatbot', '2026-01-27 12:13:41'),
(52, 18, 'gg', 'chatbot', '2026-01-27 12:13:44'),
(53, 18, 'bg', 'utilisateur', '2026-01-27 12:17:06'),
(54, 19, 'vf', 'chatbot', '2026-01-27 12:28:16'),
(55, 18, 'h', 'chatbot', '2026-01-27 21:40:57'),
(56, 20, 'h,', 'utilisateur', '2026-01-27 21:41:08'),
(57, 20, 'h,', 'utilisateur', '2026-01-27 21:41:12'),
(58, 20, 'h,', 'utilisateur', '2026-01-27 21:41:12'),
(59, 20, 'h,', 'utilisateur', '2026-01-27 21:41:15'),
(60, 20, 'h,', 'utilisateur', '2026-01-27 21:41:16'),
(61, 20, 'h,', 'utilisateur', '2026-01-27 21:41:16'),
(62, 20, 'h,', 'utilisateur', '2026-01-27 21:41:16'),
(63, 20, 'h,', 'utilisateur', '2026-01-27 21:41:16'),
(64, 18, 'G', 'utilisateur', '2026-01-27 21:43:11'),
(65, 18, 'HHH', 'utilisateur', '2026-01-27 21:43:21'),
(66, 18, 'LL', 'utilisateur', '2026-01-27 21:43:24'),
(67, 18, 'klm', 'utilisateur', '2026-01-27 22:31:28'),
(68, 18, 'lmù', 'utilisateur', '2026-01-27 22:31:32'),
(69, 18, 'a', 'utilisateur', '2026-01-27 22:31:37'),
(70, 18, 'a', 'utilisateur', '2026-01-27 22:31:42'),
(71, 18, 'rfthy', 'chatbot', '2026-01-27 22:32:34'),
(72, 18, 'çoo', 'chatbot', '2026-01-27 22:32:39'),
(73, 18, 'lmpmpm', 'chatbot', '2026-01-27 22:32:43'),
(74, 18, 'ù', 'chatbot', '2026-01-27 22:32:46'),
(75, 18, 'p', 'chatbot', '2026-01-27 22:32:49'),
(76, 18, 'k', 'utilisateur', '2026-01-27 22:33:49'),
(77, 18, 'ahla', 'utilisateur', '2026-01-27 22:33:53'),
(78, 18, 'dfgthyju', 'utilisateur', '2026-01-29 21:48:45'),
(79, 18, 'fghjk', 'utilisateur', '2026-01-29 21:48:48'),
(80, 18, 'fghjk', 'utilisateur', '2026-01-29 21:48:51'),
(81, 18, 'sdfghjk;l', 'utilisateur', '2026-01-29 21:50:30'),
(82, 18, 'dfghj', 'utilisateur', '2026-01-29 21:50:33'),
(83, 18, 'dfgh', 'utilisateur', '2026-01-29 21:50:35'),
(84, 18, 'jj', 'chatbot', '2026-01-29 23:10:41'),
(85, 23, 'CC ACHWAK', 'chatbot', '2026-01-30 15:24:07'),
(86, 26, 'FGHJ', 'utilisateur', '2026-01-30 15:25:54'),
(87, 18, 'dfghjk', 'utilisateur', '2026-01-30 15:26:19'),
(88, 26, 'dfghj', 'chatbot', '2026-01-30 15:27:02'),
(89, 26, 'fghjk', 'utilisateur', '2026-01-30 15:27:31'),
(90, 18, 'h', 'chatbot', '2026-01-30 16:03:56');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id_notification` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `contenu` text NOT NULL,
  `etat` enum('non_lu','lu') DEFAULT 'non_lu',
  `date_notification` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id_notification`, `id_utilisateur`, `contenu`, `etat`, `date_notification`) VALUES
(252, 18, 'L\'administrateur vous a envoyé un nouveau message.', 'lu', '2026-01-26 15:43:21'),
(253, 18, 'L\'administrateur vous a envoyé un nouveau message.', 'lu', '2026-01-26 15:43:29'),
(254, 18, 'L\'administrateur vous a envoyé un nouveau message.', 'lu', '2026-01-26 15:43:34'),
(255, 18, 'L\'administrateur vous a envoyé un nouveau message.', 'lu', '2026-01-26 15:44:36'),
(256, 18, 'L\'administrateur vous a envoyé un nouveau message.', 'lu', '2026-01-26 15:54:08'),
(257, 18, 'L\'administrateur vous a envoyé un nouveau message.', 'lu', '2026-01-26 15:54:09'),
(258, 18, 'L\'administrateur vous a envoyé un nouveau message.', 'lu', '2026-01-27 12:13:41'),
(259, 18, 'L\'administrateur vous a envoyé un nouveau message.', 'lu', '2026-01-27 12:13:44'),
(260, 1, 'Nouveau message de az', 'non_lu', '2026-01-27 12:17:06'),
(261, 2, 'Nouveau message de az', 'non_lu', '2026-01-27 12:17:06'),
(262, 5, 'Nouveau message de az', 'non_lu', '2026-01-27 12:17:06'),
(263, 15, 'Nouveau message de az', 'lu', '2026-01-27 12:17:06'),
(264, 19, 'Nouveau message de az', 'lu', '2026-01-27 12:17:06'),
(265, 21, 'Nouveau message de az', 'non_lu', '2026-01-27 12:17:06'),
(266, 19, 'L\'administrateur vous a envoyé un nouveau message.', 'lu', '2026-01-27 12:28:16'),
(267, 1, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-27 15:55:31'),
(268, 2, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-27 15:55:31'),
(269, 5, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-27 15:55:31'),
(270, 15, 'Nouvelle demande (sortie) de la part de er az', 'lu', '2026-01-27 15:55:31'),
(271, 19, 'Nouvelle demande (sortie) de la part de er az', 'lu', '2026-01-27 15:55:31'),
(272, 21, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-27 15:55:31'),
(273, 1, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 20).', 'non_lu', '2026-01-27 15:55:36'),
(274, 2, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 20).', 'non_lu', '2026-01-27 15:55:36'),
(275, 5, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 20).', 'non_lu', '2026-01-27 15:55:36'),
(276, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 20).', 'lu', '2026-01-27 15:55:36'),
(277, 19, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 20).', 'lu', '2026-01-27 15:55:36'),
(278, 21, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 20).', 'non_lu', '2026-01-27 15:55:36'),
(279, 18, 'OK_DEMANDE_16', 'lu', '2026-01-27 15:55:43'),
(280, 18, 'L\'administrateur vous a envoyé un nouveau message.', 'lu', '2026-01-27 21:40:57'),
(281, 1, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:09'),
(282, 2, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:10'),
(283, 5, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:12'),
(284, 15, 'Nouveau message de CLAVIER', 'lu', '2026-01-27 21:41:12'),
(285, 19, 'Nouveau message de CLAVIER', 'lu', '2026-01-27 21:41:12'),
(286, 21, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:12'),
(287, 1, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:12'),
(288, 2, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:12'),
(289, 5, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:12'),
(290, 15, 'Nouveau message de CLAVIER', 'lu', '2026-01-27 21:41:12'),
(291, 19, 'Nouveau message de CLAVIER', 'lu', '2026-01-27 21:41:12'),
(292, 21, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:12'),
(293, 1, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:12'),
(294, 2, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:12'),
(295, 5, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:13'),
(296, 15, 'Nouveau message de CLAVIER', 'lu', '2026-01-27 21:41:13'),
(297, 19, 'Nouveau message de CLAVIER', 'lu', '2026-01-27 21:41:13'),
(298, 21, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:13'),
(299, 1, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:15'),
(300, 2, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:16'),
(301, 5, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:16'),
(302, 15, 'Nouveau message de CLAVIER', 'lu', '2026-01-27 21:41:16'),
(303, 19, 'Nouveau message de CLAVIER', 'lu', '2026-01-27 21:41:16'),
(304, 21, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:16'),
(305, 1, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:16'),
(306, 2, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:16'),
(307, 5, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:16'),
(308, 15, 'Nouveau message de CLAVIER', 'lu', '2026-01-27 21:41:16'),
(309, 19, 'Nouveau message de CLAVIER', 'lu', '2026-01-27 21:41:16'),
(310, 21, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:16'),
(311, 1, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:16'),
(312, 2, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:16'),
(313, 5, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:16'),
(314, 15, 'Nouveau message de CLAVIER', 'lu', '2026-01-27 21:41:16'),
(315, 19, 'Nouveau message de CLAVIER', 'lu', '2026-01-27 21:41:16'),
(316, 21, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:16'),
(317, 1, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:16'),
(318, 2, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:16'),
(319, 5, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:16'),
(320, 15, 'Nouveau message de CLAVIER', 'lu', '2026-01-27 21:41:16'),
(321, 19, 'Nouveau message de CLAVIER', 'lu', '2026-01-27 21:41:16'),
(322, 21, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:16'),
(323, 1, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:16'),
(324, 2, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:16'),
(325, 5, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:16'),
(326, 15, 'Nouveau message de CLAVIER', 'lu', '2026-01-27 21:41:16'),
(327, 19, 'Nouveau message de CLAVIER', 'lu', '2026-01-27 21:41:16'),
(328, 21, 'Nouveau message de CLAVIER', 'non_lu', '2026-01-27 21:41:16'),
(329, 1, 'Nouvelle demande (sortie) de la part de cvb CLAVIER', 'non_lu', '2026-01-27 21:41:35'),
(330, 2, 'Nouvelle demande (sortie) de la part de cvb CLAVIER', 'non_lu', '2026-01-27 21:41:35'),
(331, 5, 'Nouvelle demande (sortie) de la part de cvb CLAVIER', 'non_lu', '2026-01-27 21:41:35'),
(332, 15, 'Nouvelle demande (sortie) de la part de cvb CLAVIER', 'lu', '2026-01-27 21:41:35'),
(333, 19, 'Nouvelle demande (sortie) de la part de cvb CLAVIER', 'lu', '2026-01-27 21:41:35'),
(334, 21, 'Nouvelle demande (sortie) de la part de cvb CLAVIER', 'non_lu', '2026-01-27 21:41:35'),
(335, 1, 'ALERTE STOCK: L\'article \'souris\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-27 21:41:43'),
(336, 2, 'ALERTE STOCK: L\'article \'souris\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-27 21:41:43'),
(337, 5, 'ALERTE STOCK: L\'article \'souris\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-27 21:41:43'),
(338, 15, 'ALERTE STOCK: L\'article \'souris\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-27 21:41:43'),
(339, 19, 'ALERTE STOCK: L\'article \'souris\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-27 21:41:43'),
(340, 21, 'ALERTE STOCK: L\'article \'souris\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-27 21:41:43'),
(341, 1, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-27 21:41:43'),
(342, 2, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-27 21:41:43'),
(343, 5, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-27 21:41:43'),
(344, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-27 21:41:43'),
(345, 19, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-27 21:41:43'),
(346, 21, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-27 21:41:43'),
(347, 1, 'ALERTE STOCK: L\'article \'zzefrgth\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-27 21:41:43'),
(348, 2, 'ALERTE STOCK: L\'article \'zzefrgth\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-27 21:41:43'),
(349, 5, 'ALERTE STOCK: L\'article \'zzefrgth\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-27 21:41:43'),
(350, 15, 'ALERTE STOCK: L\'article \'zzefrgth\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-27 21:41:43'),
(351, 19, 'ALERTE STOCK: L\'article \'zzefrgth\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-27 21:41:43'),
(352, 21, 'ALERTE STOCK: L\'article \'zzefrgth\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-27 21:41:43'),
(353, 1, 'Nouveau message de az', 'non_lu', '2026-01-27 21:43:11'),
(354, 2, 'Nouveau message de az', 'non_lu', '2026-01-27 21:43:11'),
(355, 5, 'Nouveau message de az', 'non_lu', '2026-01-27 21:43:11'),
(356, 15, 'Nouveau message de az', 'lu', '2026-01-27 21:43:11'),
(357, 19, 'Nouveau message de az', 'lu', '2026-01-27 21:43:11'),
(358, 21, 'Nouveau message de az', 'non_lu', '2026-01-27 21:43:11'),
(359, 1, 'Nouveau message de az', 'non_lu', '2026-01-27 21:43:21'),
(360, 2, 'Nouveau message de az', 'non_lu', '2026-01-27 21:43:21'),
(361, 5, 'Nouveau message de az', 'non_lu', '2026-01-27 21:43:21'),
(362, 15, 'Nouveau message de az', 'lu', '2026-01-27 21:43:21'),
(363, 19, 'Nouveau message de az', 'lu', '2026-01-27 21:43:21'),
(364, 21, 'Nouveau message de az', 'non_lu', '2026-01-27 21:43:21'),
(365, 1, 'Nouveau message de az', 'non_lu', '2026-01-27 21:43:24'),
(366, 2, 'Nouveau message de az', 'non_lu', '2026-01-27 21:43:24'),
(367, 5, 'Nouveau message de az', 'non_lu', '2026-01-27 21:43:24'),
(368, 15, 'Nouveau message de az', 'lu', '2026-01-27 21:43:24'),
(369, 19, 'Nouveau message de az', 'lu', '2026-01-27 21:43:24'),
(370, 21, 'Nouveau message de az', 'non_lu', '2026-01-27 21:43:24'),
(371, 1, 'Nouveau message de az', 'non_lu', '2026-01-27 22:31:28'),
(372, 2, 'Nouveau message de az', 'non_lu', '2026-01-27 22:31:28'),
(373, 5, 'Nouveau message de az', 'non_lu', '2026-01-27 22:31:28'),
(374, 15, 'Nouveau message de az', 'lu', '2026-01-27 22:31:28'),
(375, 19, 'Nouveau message de az', 'lu', '2026-01-27 22:31:28'),
(376, 21, 'Nouveau message de az', 'non_lu', '2026-01-27 22:31:28'),
(377, 1, 'Nouveau message de az', 'non_lu', '2026-01-27 22:31:32'),
(378, 2, 'Nouveau message de az', 'non_lu', '2026-01-27 22:31:32'),
(379, 5, 'Nouveau message de az', 'non_lu', '2026-01-27 22:31:32'),
(380, 15, 'Nouveau message de az', 'lu', '2026-01-27 22:31:32'),
(381, 19, 'Nouveau message de az', 'lu', '2026-01-27 22:31:32'),
(382, 21, 'Nouveau message de az', 'non_lu', '2026-01-27 22:31:32'),
(383, 1, 'Nouveau message de az', 'non_lu', '2026-01-27 22:31:37'),
(384, 2, 'Nouveau message de az', 'non_lu', '2026-01-27 22:31:37'),
(385, 5, 'Nouveau message de az', 'non_lu', '2026-01-27 22:31:37'),
(386, 15, 'Nouveau message de az', 'lu', '2026-01-27 22:31:37'),
(387, 19, 'Nouveau message de az', 'lu', '2026-01-27 22:31:37'),
(388, 21, 'Nouveau message de az', 'non_lu', '2026-01-27 22:31:37'),
(389, 1, 'Nouveau message de az', 'non_lu', '2026-01-27 22:31:42'),
(390, 2, 'Nouveau message de az', 'non_lu', '2026-01-27 22:31:42'),
(391, 5, 'Nouveau message de az', 'non_lu', '2026-01-27 22:31:42'),
(392, 15, 'Nouveau message de az', 'lu', '2026-01-27 22:31:42'),
(393, 19, 'Nouveau message de az', 'lu', '2026-01-27 22:31:42'),
(394, 21, 'Nouveau message de az', 'non_lu', '2026-01-27 22:31:42'),
(395, 18, 'L\'administrateur vous a envoyé un nouveau message.', 'lu', '2026-01-27 22:32:34'),
(396, 18, 'L\'administrateur vous a envoyé un nouveau message.', 'lu', '2026-01-27 22:32:39'),
(397, 18, 'L\'administrateur vous a envoyé un nouveau message.', 'lu', '2026-01-27 22:32:43'),
(398, 18, 'L\'administrateur vous a envoyé un nouveau message.', 'lu', '2026-01-27 22:32:46'),
(399, 18, 'L\'administrateur vous a envoyé un nouveau message.', 'lu', '2026-01-27 22:32:49'),
(400, 1, 'Nouveau message de az', 'non_lu', '2026-01-27 22:33:49'),
(401, 2, 'Nouveau message de az', 'non_lu', '2026-01-27 22:33:49'),
(402, 5, 'Nouveau message de az', 'non_lu', '2026-01-27 22:33:49'),
(403, 15, 'Nouveau message de az', 'lu', '2026-01-27 22:33:49'),
(404, 19, 'Nouveau message de az', 'lu', '2026-01-27 22:33:49'),
(405, 21, 'Nouveau message de az', 'non_lu', '2026-01-27 22:33:49'),
(406, 1, 'Nouveau message de az', 'non_lu', '2026-01-27 22:33:53'),
(407, 2, 'Nouveau message de az', 'non_lu', '2026-01-27 22:33:53'),
(408, 5, 'Nouveau message de az', 'non_lu', '2026-01-27 22:33:53'),
(409, 15, 'Nouveau message de az', 'lu', '2026-01-27 22:33:53'),
(410, 19, 'Nouveau message de az', 'lu', '2026-01-27 22:33:53'),
(411, 21, 'Nouveau message de az', 'non_lu', '2026-01-27 22:33:53'),
(412, 1, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-28 19:22:53'),
(413, 2, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-28 19:22:53'),
(414, 5, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-28 19:22:53'),
(415, 15, 'Nouvelle demande (sortie) de la part de er az', 'lu', '2026-01-28 19:22:53'),
(416, 19, 'Nouvelle demande (sortie) de la part de er az', 'lu', '2026-01-28 19:22:53'),
(417, 21, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-28 19:22:53'),
(418, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 20).', 'lu', '2026-01-28 19:22:58'),
(419, 15, 'ALERTE STOCK: L\'article \'souris\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:22:58'),
(420, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:22:58'),
(421, 15, 'ALERTE STOCK: L\'article \'zzefrgth\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:22:58'),
(422, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 20).', 'lu', '2026-01-28 19:23:06'),
(423, 15, 'ALERTE STOCK: L\'article \'souris\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:23:06'),
(424, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:23:06'),
(425, 15, 'ALERTE STOCK: L\'article \'zzefrgth\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:23:06'),
(426, 1, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-28 19:24:07'),
(427, 2, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-28 19:24:07'),
(428, 5, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-28 19:24:07'),
(429, 15, 'Nouvelle demande (sortie) de la part de er az', 'lu', '2026-01-28 19:24:07'),
(430, 19, 'Nouvelle demande (sortie) de la part de er az', 'lu', '2026-01-28 19:24:07'),
(431, 21, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-28 19:24:07'),
(432, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 20).', 'lu', '2026-01-28 19:24:12'),
(433, 15, 'ALERTE STOCK: L\'article \'souris\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:24:12'),
(434, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:24:12'),
(435, 15, 'ALERTE STOCK: L\'article \'zzefrgth\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:24:12'),
(436, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 20).', 'lu', '2026-01-28 19:25:57'),
(437, 15, 'ALERTE STOCK: L\'article \'souris\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:25:57'),
(438, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:25:57'),
(439, 15, 'ALERTE STOCK: L\'article \'zzefrgth\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:25:57'),
(440, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 20).', 'lu', '2026-01-28 19:26:41'),
(441, 15, 'ALERTE STOCK: L\'article \'souris\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:26:41'),
(442, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:26:41'),
(443, 15, 'ALERTE STOCK: L\'article \'zzefrgth\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:26:41'),
(444, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 20).', 'lu', '2026-01-28 19:27:08'),
(445, 15, 'ALERTE STOCK: L\'article \'souris\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:27:08'),
(446, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:27:08'),
(447, 15, 'ALERTE STOCK: L\'article \'zzefrgth\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:27:08'),
(448, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 20).', 'lu', '2026-01-28 19:29:57'),
(449, 15, 'ALERTE STOCK: L\'article \'souris\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:29:57'),
(450, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:29:57'),
(451, 15, 'ALERTE STOCK: L\'article \'zzefrgth\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:29:57'),
(452, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 20).', 'lu', '2026-01-28 19:30:23'),
(453, 15, 'ALERTE STOCK: L\'article \'souris\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:30:23'),
(454, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:30:23'),
(455, 15, 'ALERTE STOCK: L\'article \'zzefrgth\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:30:23'),
(456, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 20).', 'lu', '2026-01-28 19:31:35'),
(457, 15, 'ALERTE STOCK: L\'article \'souris\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:31:35'),
(458, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:31:35'),
(459, 15, 'ALERTE STOCK: L\'article \'zzefrgth\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:31:35'),
(460, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 20).', 'lu', '2026-01-28 19:32:15'),
(461, 15, 'ALERTE STOCK: L\'article \'souris\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:32:15'),
(462, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:32:15'),
(463, 15, 'ALERTE STOCK: L\'article \'zzefrgth\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:32:15'),
(464, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 20).', 'lu', '2026-01-28 19:33:29'),
(465, 15, 'ALERTE STOCK: L\'article \'souris\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:33:29'),
(466, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:33:29'),
(467, 15, 'ALERTE STOCK: L\'article \'zzefrgth\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:33:29'),
(468, 1, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-28 19:34:05'),
(469, 2, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-28 19:34:05'),
(470, 5, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-28 19:34:05'),
(471, 15, 'Nouvelle demande (sortie) de la part de er az', 'lu', '2026-01-28 19:34:05'),
(472, 19, 'Nouvelle demande (sortie) de la part de er az', 'lu', '2026-01-28 19:34:05'),
(473, 21, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-28 19:34:05'),
(474, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 20).', 'lu', '2026-01-28 19:34:10'),
(475, 15, 'ALERTE STOCK: L\'article \'souris\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:34:10'),
(476, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:34:10'),
(477, 15, 'ALERTE STOCK: L\'article \'zzefrgth\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-28 19:34:10'),
(478, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 20).', 'lu', '2026-01-28 19:34:49'),
(479, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'IOT\' est presque épuisé (Qte: 20).', 'lu', '2026-01-28 19:35:14'),
(480, 1, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-28 19:36:02'),
(481, 2, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-28 19:36:02'),
(482, 5, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-28 19:36:02'),
(483, 15, 'Nouvelle demande (sortie) de la part de er az', 'lu', '2026-01-28 19:36:02'),
(484, 19, 'Nouvelle demande (sortie) de la part de er az', 'lu', '2026-01-28 19:36:02'),
(485, 21, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-28 19:36:02'),
(486, 1, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'iot2\' est presque épuisé (Qte: 12).', 'non_lu', '2026-01-28 19:57:04'),
(487, 2, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'iot2\' est presque épuisé (Qte: 12).', 'non_lu', '2026-01-28 19:57:04'),
(488, 5, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'iot2\' est presque épuisé (Qte: 12).', 'non_lu', '2026-01-28 19:57:04'),
(489, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'iot2\' est presque épuisé (Qte: 12).', 'lu', '2026-01-28 19:57:05'),
(490, 19, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'iot2\' est presque épuisé (Qte: 12).', 'lu', '2026-01-28 19:57:05'),
(491, 21, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'iot2\' est presque épuisé (Qte: 12).', 'non_lu', '2026-01-28 19:57:05'),
(492, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'iot2\' est presque épuisé (Qte: 12).', 'lu', '2026-01-28 19:57:20'),
(493, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'iot2\' est presque épuisé (Qte: 12).', 'lu', '2026-01-28 19:59:09'),
(494, 15, 'ALERTE STOCK: L\'article \'CLAVIER\' dans le magasin \'iot2\' est presque épuisé (Qte: 12).', 'lu', '2026-01-28 19:59:46'),
(495, 1, 'ALERTE STOCK: L\'article \'ZEFRGTHY\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-29 00:09:57'),
(496, 2, 'ALERTE STOCK: L\'article \'ZEFRGTHY\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-29 00:09:57'),
(497, 5, 'ALERTE STOCK: L\'article \'ZEFRGTHY\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-29 00:09:57'),
(498, 15, 'ALERTE STOCK: L\'article \'ZEFRGTHY\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-29 00:09:57'),
(499, 19, 'ALERTE STOCK: L\'article \'ZEFRGTHY\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-29 00:09:57'),
(500, 21, 'ALERTE STOCK: L\'article \'ZEFRGTHY\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-29 00:09:57'),
(501, 1, 'ALERTE STOCK: L\'article \'ZEFRGTHY\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-29 00:13:09'),
(502, 2, 'ALERTE STOCK: L\'article \'ZEFRGTHY\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-29 00:13:09'),
(503, 5, 'ALERTE STOCK: L\'article \'ZEFRGTHY\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-29 00:13:09'),
(504, 15, 'ALERTE STOCK: L\'article \'ZEFRGTHY\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-01-29 00:13:09'),
(505, 19, 'ALERTE STOCK: L\'article \'ZEFRGTHY\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-01-29 00:13:09'),
(506, 21, 'ALERTE STOCK: L\'article \'ZEFRGTHY\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-29 00:13:09'),
(507, 1, 'ALERTE STOCK: L\'article \'zerftyh\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-29 13:39:34'),
(508, 2, 'ALERTE STOCK: L\'article \'zerftyh\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-29 13:39:34'),
(509, 5, 'ALERTE STOCK: L\'article \'zerftyh\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-29 13:39:34'),
(510, 15, 'ALERTE STOCK: L\'article \'zerftyh\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-29 13:39:34'),
(511, 19, 'ALERTE STOCK: L\'article \'zerftyh\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'lu', '2026-01-29 13:39:34'),
(512, 21, 'ALERTE STOCK: L\'article \'zerftyh\' dans le magasin \'IOT\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-29 13:39:34'),
(513, 22, 'ALERTE STOCK: L\'article \'ZEFRGTHY\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-29 14:20:11'),
(514, 23, 'ALERTE STOCK: L\'article \'ZEFRGTHY\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-29 14:20:11'),
(515, 24, 'ALERTE STOCK: L\'article \'ZEFRGTHY\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-29 14:20:11'),
(516, 25, 'ALERTE STOCK: L\'article \'ZEFRGTHY\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-29 14:20:11'),
(517, 1, 'ALERTE STOCK: L\'article \'souris\' dans le magasin \'iot2\' est presque épuisé (Qte: 0).', 'non_lu', '2026-01-29 19:40:16'),
(518, 2, 'ALERTE STOCK: L\'article \'souris\' dans le magasin \'iot2\' est presque épuisé (Qte: 0).', 'non_lu', '2026-01-29 19:40:16'),
(519, 5, 'ALERTE STOCK: L\'article \'souris\' dans le magasin \'iot2\' est presque épuisé (Qte: 0).', 'non_lu', '2026-01-29 19:40:16'),
(520, 15, 'ALERTE STOCK: L\'article \'souris\' dans le magasin \'iot2\' est presque épuisé (Qte: 0).', 'lu', '2026-01-29 19:40:16'),
(521, 19, 'ALERTE STOCK: L\'article \'souris\' dans le magasin \'iot2\' est presque épuisé (Qte: 0).', 'lu', '2026-01-29 19:40:16'),
(522, 21, 'ALERTE STOCK: L\'article \'souris\' dans le magasin \'iot2\' est presque épuisé (Qte: 0).', 'non_lu', '2026-01-29 19:40:16'),
(523, 22, 'ALERTE STOCK: L\'article \'souris\' dans le magasin \'iot2\' est presque épuisé (Qte: 0).', 'non_lu', '2026-01-29 19:40:16'),
(524, 23, 'ALERTE STOCK: L\'article \'souris\' dans le magasin \'iot2\' est presque épuisé (Qte: 0).', 'non_lu', '2026-01-29 19:40:16'),
(525, 24, 'ALERTE STOCK: L\'article \'souris\' dans le magasin \'iot2\' est presque épuisé (Qte: 0).', 'non_lu', '2026-01-29 19:40:16'),
(526, 25, 'ALERTE STOCK: L\'article \'souris\' dans le magasin \'iot2\' est presque épuisé (Qte: 0).', 'non_lu', '2026-01-29 19:40:16'),
(527, 1, 'ALERTE STOCK: L\'article \'bhjk\' dans le magasin \'iot\' est presque épuisé (Qte: 0).', 'non_lu', '2026-01-29 20:33:43'),
(528, 2, 'ALERTE STOCK: L\'article \'bhjk\' dans le magasin \'iot\' est presque épuisé (Qte: 0).', 'non_lu', '2026-01-29 20:33:43'),
(529, 5, 'ALERTE STOCK: L\'article \'bhjk\' dans le magasin \'iot\' est presque épuisé (Qte: 0).', 'non_lu', '2026-01-29 20:33:43'),
(530, 15, 'ALERTE STOCK: L\'article \'bhjk\' dans le magasin \'iot\' est presque épuisé (Qte: 0).', 'lu', '2026-01-29 20:33:43'),
(531, 19, 'ALERTE STOCK: L\'article \'bhjk\' dans le magasin \'iot\' est presque épuisé (Qte: 0).', 'lu', '2026-01-29 20:33:43'),
(532, 21, 'ALERTE STOCK: L\'article \'bhjk\' dans le magasin \'iot\' est presque épuisé (Qte: 0).', 'non_lu', '2026-01-29 20:33:43'),
(533, 22, 'ALERTE STOCK: L\'article \'bhjk\' dans le magasin \'iot\' est presque épuisé (Qte: 0).', 'non_lu', '2026-01-29 20:33:43'),
(534, 23, 'ALERTE STOCK: L\'article \'bhjk\' dans le magasin \'iot\' est presque épuisé (Qte: 0).', 'non_lu', '2026-01-29 20:33:43'),
(535, 24, 'ALERTE STOCK: L\'article \'bhjk\' dans le magasin \'iot\' est presque épuisé (Qte: 0).', 'non_lu', '2026-01-29 20:33:43'),
(536, 25, 'ALERTE STOCK: L\'article \'bhjk\' dans le magasin \'iot\' est presque épuisé (Qte: 0).', 'non_lu', '2026-01-29 20:33:43'),
(537, 1, 'ALERTE STOCK: L\'article \'bhjk\' dans le magasin \'iot2\' est presque épuisé (Qte: 0).', 'non_lu', '2026-01-29 20:33:43'),
(538, 2, 'ALERTE STOCK: L\'article \'bhjk\' dans le magasin \'iot2\' est presque épuisé (Qte: 0).', 'non_lu', '2026-01-29 20:33:43'),
(539, 5, 'ALERTE STOCK: L\'article \'bhjk\' dans le magasin \'iot2\' est presque épuisé (Qte: 0).', 'non_lu', '2026-01-29 20:33:43'),
(540, 15, 'ALERTE STOCK: L\'article \'bhjk\' dans le magasin \'iot2\' est presque épuisé (Qte: 0).', 'lu', '2026-01-29 20:33:43'),
(541, 19, 'ALERTE STOCK: L\'article \'bhjk\' dans le magasin \'iot2\' est presque épuisé (Qte: 0).', 'lu', '2026-01-29 20:33:43'),
(542, 21, 'ALERTE STOCK: L\'article \'bhjk\' dans le magasin \'iot2\' est presque épuisé (Qte: 0).', 'non_lu', '2026-01-29 20:33:43'),
(543, 22, 'ALERTE STOCK: L\'article \'bhjk\' dans le magasin \'iot2\' est presque épuisé (Qte: 0).', 'non_lu', '2026-01-29 20:33:43'),
(544, 23, 'ALERTE STOCK: L\'article \'bhjk\' dans le magasin \'iot2\' est presque épuisé (Qte: 0).', 'non_lu', '2026-01-29 20:33:43'),
(545, 24, 'ALERTE STOCK: L\'article \'bhjk\' dans le magasin \'iot2\' est presque épuisé (Qte: 0).', 'non_lu', '2026-01-29 20:33:43'),
(546, 25, 'ALERTE STOCK: L\'article \'bhjk\' dans le magasin \'iot2\' est presque épuisé (Qte: 0).', 'non_lu', '2026-01-29 20:33:43'),
(547, 1, 'ALERTE STOCK: L\'article \'dfgh\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-29 21:29:31'),
(548, 2, 'ALERTE STOCK: L\'article \'dfgh\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-29 21:29:31'),
(549, 5, 'ALERTE STOCK: L\'article \'dfgh\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-29 21:29:31'),
(550, 15, 'ALERTE STOCK: L\'article \'dfgh\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-01-29 21:29:31'),
(551, 19, 'ALERTE STOCK: L\'article \'dfgh\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-01-29 21:29:31'),
(552, 21, 'ALERTE STOCK: L\'article \'dfgh\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-29 21:29:31'),
(553, 22, 'ALERTE STOCK: L\'article \'dfgh\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-29 21:29:31'),
(554, 23, 'ALERTE STOCK: L\'article \'dfgh\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-29 21:29:31'),
(555, 24, 'ALERTE STOCK: L\'article \'dfgh\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-29 21:29:31'),
(556, 25, 'ALERTE STOCK: L\'article \'dfgh\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-29 21:29:31'),
(557, 1, 'Nouveau message de az', 'non_lu', '2026-01-29 21:48:45'),
(558, 2, 'Nouveau message de az', 'non_lu', '2026-01-29 21:48:45'),
(559, 5, 'Nouveau message de az', 'non_lu', '2026-01-29 21:48:45'),
(560, 15, 'Nouveau message de az', 'lu', '2026-01-29 21:48:45'),
(561, 19, 'Nouveau message de az', 'lu', '2026-01-29 21:48:45'),
(562, 21, 'Nouveau message de az', 'non_lu', '2026-01-29 21:48:45'),
(563, 22, 'Nouveau message de az', 'non_lu', '2026-01-29 21:48:45'),
(564, 23, 'Nouveau message de az', 'non_lu', '2026-01-29 21:48:45'),
(565, 24, 'Nouveau message de az', 'non_lu', '2026-01-29 21:48:45'),
(566, 25, 'Nouveau message de az', 'non_lu', '2026-01-29 21:48:45'),
(567, 1, 'Nouveau message de az', 'non_lu', '2026-01-29 21:48:48'),
(568, 2, 'Nouveau message de az', 'non_lu', '2026-01-29 21:48:48'),
(569, 5, 'Nouveau message de az', 'non_lu', '2026-01-29 21:48:48'),
(570, 15, 'Nouveau message de az', 'lu', '2026-01-29 21:48:48'),
(571, 19, 'Nouveau message de az', 'lu', '2026-01-29 21:48:48'),
(572, 21, 'Nouveau message de az', 'non_lu', '2026-01-29 21:48:48'),
(573, 22, 'Nouveau message de az', 'non_lu', '2026-01-29 21:48:48'),
(574, 23, 'Nouveau message de az', 'non_lu', '2026-01-29 21:48:48'),
(575, 24, 'Nouveau message de az', 'non_lu', '2026-01-29 21:48:48'),
(576, 25, 'Nouveau message de az', 'non_lu', '2026-01-29 21:48:48'),
(577, 1, 'Nouveau message de az', 'non_lu', '2026-01-29 21:48:51'),
(578, 2, 'Nouveau message de az', 'non_lu', '2026-01-29 21:48:51'),
(579, 5, 'Nouveau message de az', 'non_lu', '2026-01-29 21:48:51'),
(580, 15, 'Nouveau message de az', 'lu', '2026-01-29 21:48:51'),
(581, 19, 'Nouveau message de az', 'lu', '2026-01-29 21:48:51'),
(582, 21, 'Nouveau message de az', 'non_lu', '2026-01-29 21:48:51'),
(583, 22, 'Nouveau message de az', 'non_lu', '2026-01-29 21:48:51'),
(584, 23, 'Nouveau message de az', 'non_lu', '2026-01-29 21:48:51'),
(585, 24, 'Nouveau message de az', 'non_lu', '2026-01-29 21:48:51'),
(586, 25, 'Nouveau message de az', 'non_lu', '2026-01-29 21:48:51'),
(587, 15, 'ALERTE STOCK: L\'article \'bhjk\' dans le magasin \'iot\' est presque épuisé (Qte: 0).', 'lu', '2026-01-29 21:48:55'),
(588, 15, 'ALERTE STOCK: L\'article \'bhjk\' dans le magasin \'iot2\' est presque épuisé (Qte: 0).', 'lu', '2026-01-29 21:48:55'),
(589, 15, 'ALERTE STOCK: L\'article \'dfgh\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-01-29 21:48:55'),
(590, 15, 'ALERTE STOCK: L\'article \'dfgh\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-01-29 21:50:15'),
(591, 15, 'ALERTE STOCK: L\'article \'dfgh\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-01-29 21:50:21'),
(592, 1, 'Nouveau message de az', 'non_lu', '2026-01-29 21:50:30'),
(593, 2, 'Nouveau message de az', 'non_lu', '2026-01-29 21:50:30'),
(594, 5, 'Nouveau message de az', 'non_lu', '2026-01-29 21:50:30'),
(595, 15, 'Nouveau message de az', 'lu', '2026-01-29 21:50:30'),
(596, 19, 'Nouveau message de az', 'lu', '2026-01-29 21:50:30'),
(597, 21, 'Nouveau message de az', 'non_lu', '2026-01-29 21:50:30'),
(598, 22, 'Nouveau message de az', 'non_lu', '2026-01-29 21:50:30'),
(599, 23, 'Nouveau message de az', 'non_lu', '2026-01-29 21:50:30'),
(600, 24, 'Nouveau message de az', 'non_lu', '2026-01-29 21:50:30'),
(601, 25, 'Nouveau message de az', 'non_lu', '2026-01-29 21:50:30'),
(602, 1, 'Nouveau message de az', 'non_lu', '2026-01-29 21:50:33'),
(603, 2, 'Nouveau message de az', 'non_lu', '2026-01-29 21:50:33'),
(604, 5, 'Nouveau message de az', 'non_lu', '2026-01-29 21:50:33'),
(605, 15, 'Nouveau message de az', 'lu', '2026-01-29 21:50:33'),
(606, 19, 'Nouveau message de az', 'lu', '2026-01-29 21:50:33'),
(607, 21, 'Nouveau message de az', 'non_lu', '2026-01-29 21:50:33'),
(608, 22, 'Nouveau message de az', 'non_lu', '2026-01-29 21:50:33'),
(609, 23, 'Nouveau message de az', 'non_lu', '2026-01-29 21:50:33'),
(610, 24, 'Nouveau message de az', 'non_lu', '2026-01-29 21:50:33'),
(611, 25, 'Nouveau message de az', 'non_lu', '2026-01-29 21:50:33'),
(612, 1, 'Nouveau message de az', 'non_lu', '2026-01-29 21:50:35'),
(613, 2, 'Nouveau message de az', 'non_lu', '2026-01-29 21:50:35'),
(614, 5, 'Nouveau message de az', 'non_lu', '2026-01-29 21:50:35'),
(615, 15, 'Nouveau message de az', 'lu', '2026-01-29 21:50:35'),
(616, 19, 'Nouveau message de az', 'lu', '2026-01-29 21:50:35'),
(617, 21, 'Nouveau message de az', 'non_lu', '2026-01-29 21:50:35'),
(618, 22, 'Nouveau message de az', 'non_lu', '2026-01-29 21:50:35'),
(619, 23, 'Nouveau message de az', 'non_lu', '2026-01-29 21:50:35'),
(620, 24, 'Nouveau message de az', 'non_lu', '2026-01-29 21:50:35'),
(621, 25, 'Nouveau message de az', 'non_lu', '2026-01-29 21:50:35'),
(622, 15, 'ALERTE STOCK: L\'article \'dfgh\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-01-29 21:52:03'),
(623, 15, 'ALERTE STOCK: L\'article \'dfgh\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-01-29 21:52:19'),
(624, 15, 'ALERTE STOCK: L\'article \'dfgh\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-01-29 21:55:00'),
(625, 15, 'ALERTE STOCK: L\'article \'dfgh\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-01-29 21:55:18'),
(626, 15, 'ALERTE STOCK: L\'article \'dfgh\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-01-29 21:55:22'),
(627, 15, 'ALERTE STOCK: L\'article \'dfgh\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-01-29 22:03:19'),
(628, 1, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-29 22:04:03'),
(629, 2, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-29 22:04:03'),
(630, 5, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-29 22:04:03'),
(631, 15, 'Nouvelle demande (sortie) de la part de er az', 'lu', '2026-01-29 22:04:03'),
(632, 19, 'Nouvelle demande (sortie) de la part de er az', 'lu', '2026-01-29 22:04:03'),
(633, 21, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-29 22:04:03'),
(634, 22, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-29 22:04:03'),
(635, 23, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-29 22:04:03'),
(636, 24, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-29 22:04:03'),
(637, 25, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-29 22:04:03'),
(638, 18, 'OK_DEMANDE_22', 'lu', '2026-01-29 22:04:25'),
(639, 19, 'ALERTE STOCK: L\'article \'dfgh\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-01-29 22:04:53'),
(640, 1, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-29 22:15:33'),
(641, 2, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-29 22:15:33'),
(642, 5, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-29 22:15:33'),
(643, 15, 'Nouvelle demande (sortie) de la part de er az', 'lu', '2026-01-29 22:15:33'),
(644, 19, 'Nouvelle demande (sortie) de la part de er az', 'lu', '2026-01-29 22:15:33'),
(645, 21, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-29 22:15:33'),
(646, 22, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-29 22:15:33'),
(647, 23, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-29 22:15:33'),
(648, 24, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-29 22:15:33'),
(649, 25, 'Nouvelle demande (sortie) de la part de er az', 'non_lu', '2026-01-29 22:15:33'),
(650, 18, 'OK_DEMANDE_23', 'lu', '2026-01-29 22:15:51'),
(651, 15, 'ALERTE STOCK: L\'article \'dfgh\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-01-29 22:26:02'),
(652, 15, 'ALERTE STOCK: L\'article \'dfgh\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-01-29 22:29:41'),
(653, 15, 'ALERTE STOCK: L\'article \'dfgh\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-01-29 22:30:39'),
(654, 15, 'ALERTE STOCK: L\'article \'dfgh\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-01-29 22:33:02'),
(655, 15, 'ALERTE STOCK: L\'article \'dfgh\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-01-29 22:34:32'),
(656, 15, 'ALERTE STOCK: L\'article \'dfgh\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-01-29 22:39:39'),
(657, 15, 'ALERTE STOCK: L\'article \'dfgh\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-01-29 22:48:49'),
(658, 15, 'ALERTE STOCK: L\'article \'dfgh\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-01-29 22:52:28'),
(659, 15, 'ALERTE STOCK: L\'article \'dfgh\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-01-29 22:54:02'),
(660, 18, 'L\'administrateur vous a envoyé un nouveau message.', 'non_lu', '2026-01-29 23:10:41'),
(661, 15, 'ALERTE STOCK: L\'article \'dfgh\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-01-30 12:04:57'),
(662, 1, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-30 12:05:13'),
(663, 2, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-30 12:05:13'),
(664, 5, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-30 12:05:13'),
(665, 15, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot\' est presque épuisé (Qte: 1).', 'lu', '2026-01-30 12:05:13'),
(666, 19, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot\' est presque épuisé (Qte: 1).', 'lu', '2026-01-30 12:05:13'),
(667, 21, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-30 12:05:13'),
(668, 22, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-30 12:05:13'),
(669, 23, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-30 12:05:13'),
(670, 24, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-30 12:05:13'),
(671, 25, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-30 12:05:13'),
(672, 15, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot\' est presque épuisé (Qte: 1).', 'lu', '2026-01-30 12:05:38'),
(673, 1, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: dfgd | Qty: 11 | Type: sortie | From: iot2 | To: N/A', 'non_lu', '2026-01-30 14:42:17'),
(674, 2, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: dfgd | Qty: 11 | Type: sortie | From: iot2 | To: N/A', 'non_lu', '2026-01-30 14:42:17'),
(675, 5, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: dfgd | Qty: 11 | Type: sortie | From: iot2 | To: N/A', 'non_lu', '2026-01-30 14:42:17'),
(676, 15, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: dfgd | Qty: 11 | Type: sortie | From: iot2 | To: N/A', 'lu', '2026-01-30 14:42:17'),
(677, 19, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: dfgd | Qty: 11 | Type: sortie | From: iot2 | To: N/A', 'lu', '2026-01-30 14:42:17'),
(678, 21, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: dfgd | Qty: 11 | Type: sortie | From: iot2 | To: N/A', 'non_lu', '2026-01-30 14:42:17'),
(679, 22, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: dfgd | Qty: 11 | Type: sortie | From: iot2 | To: N/A', 'non_lu', '2026-01-30 14:42:17'),
(680, 23, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: dfgd | Qty: 11 | Type: sortie | From: iot2 | To: N/A', 'non_lu', '2026-01-30 14:42:17'),
(681, 24, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: dfgd | Qty: 11 | Type: sortie | From: iot2 | To: N/A', 'non_lu', '2026-01-30 14:42:17'),
(682, 25, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: dfgd | Qty: 11 | Type: sortie | From: iot2 | To: N/A', 'non_lu', '2026-01-30 14:42:17'),
(683, 1, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 2 | Type: sortie | From: iot | To: N/A', 'non_lu', '2026-01-30 14:44:16'),
(684, 2, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 2 | Type: sortie | From: iot | To: N/A', 'non_lu', '2026-01-30 14:44:16'),
(685, 5, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 2 | Type: sortie | From: iot | To: N/A', 'non_lu', '2026-01-30 14:44:16'),
(686, 15, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 2 | Type: sortie | From: iot | To: N/A', 'lu', '2026-01-30 14:44:16'),
(687, 19, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 2 | Type: sortie | From: iot | To: N/A', 'lu', '2026-01-30 14:44:16'),
(688, 21, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 2 | Type: sortie | From: iot | To: N/A', 'non_lu', '2026-01-30 14:44:16'),
(689, 22, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 2 | Type: sortie | From: iot | To: N/A', 'non_lu', '2026-01-30 14:44:16'),
(690, 23, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 2 | Type: sortie | From: iot | To: N/A', 'non_lu', '2026-01-30 14:44:16'),
(691, 24, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 2 | Type: sortie | From: iot | To: N/A', 'non_lu', '2026-01-30 14:44:16'),
(692, 25, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 2 | Type: sortie | From: iot | To: N/A', 'non_lu', '2026-01-30 14:44:16'),
(693, 1, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 22 | Type: sortie | From: iot | To: N/A', 'non_lu', '2026-01-30 14:45:08'),
(694, 2, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 22 | Type: sortie | From: iot | To: N/A', 'non_lu', '2026-01-30 14:45:08'),
(695, 5, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 22 | Type: sortie | From: iot | To: N/A', 'non_lu', '2026-01-30 14:45:08'),
(696, 15, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 22 | Type: sortie | From: iot | To: N/A', 'lu', '2026-01-30 14:45:08'),
(697, 19, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 22 | Type: sortie | From: iot | To: N/A', 'lu', '2026-01-30 14:45:08'),
(698, 21, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 22 | Type: sortie | From: iot | To: N/A', 'non_lu', '2026-01-30 14:45:08'),
(699, 22, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 22 | Type: sortie | From: iot | To: N/A', 'non_lu', '2026-01-30 14:45:08'),
(700, 23, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 22 | Type: sortie | From: iot | To: N/A', 'non_lu', '2026-01-30 14:45:08'),
(701, 24, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 22 | Type: sortie | From: iot | To: N/A', 'non_lu', '2026-01-30 14:45:08'),
(702, 25, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 22 | Type: sortie | From: iot | To: N/A', 'non_lu', '2026-01-30 14:45:08'),
(703, 1, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 22 | Type: sortie | From: iot | To: N/A', 'non_lu', '2026-01-30 14:45:39'),
(704, 2, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 22 | Type: sortie | From: iot | To: N/A', 'non_lu', '2026-01-30 14:45:39'),
(705, 5, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 22 | Type: sortie | From: iot | To: N/A', 'non_lu', '2026-01-30 14:45:39'),
(706, 15, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 22 | Type: sortie | From: iot | To: N/A', 'lu', '2026-01-30 14:45:39'),
(707, 19, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 22 | Type: sortie | From: iot | To: N/A', 'lu', '2026-01-30 14:45:39'),
(708, 21, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 22 | Type: sortie | From: iot | To: N/A', 'non_lu', '2026-01-30 14:45:39'),
(709, 22, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 22 | Type: sortie | From: iot | To: N/A', 'non_lu', '2026-01-30 14:45:39'),
(710, 23, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 22 | Type: sortie | From: iot | To: N/A', 'non_lu', '2026-01-30 14:45:39'),
(711, 24, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 22 | Type: sortie | From: iot | To: N/A', 'non_lu', '2026-01-30 14:45:39'),
(712, 25, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 22 | Type: sortie | From: iot | To: N/A', 'non_lu', '2026-01-30 14:45:39'),
(713, 19, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot\' est presque épuisé (Qte: 1).', 'lu', '2026-01-30 15:12:18'),
(714, 19, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot\' est presque épuisé (Qte: 1).', 'lu', '2026-01-30 15:14:45'),
(715, 19, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot\' est presque épuisé (Qte: 1).', 'lu', '2026-01-30 15:15:14'),
(716, 26, 'OK_DEMANDE_27', 'lu', '2026-01-30 15:21:49');
INSERT INTO `notification` (`id_notification`, `id_utilisateur`, `contenu`, `etat`, `date_notification`) VALUES
(717, 1, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-30 15:23:16'),
(718, 2, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-30 15:23:16'),
(719, 5, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-30 15:23:16'),
(720, 15, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-01-30 15:23:16'),
(721, 19, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-01-30 15:23:16'),
(722, 21, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-30 15:23:16'),
(723, 22, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-30 15:23:16'),
(724, 23, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-30 15:23:16'),
(725, 24, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-30 15:23:16'),
(726, 25, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-30 15:23:16'),
(727, 26, 'REFUS_DEMANDE_24', 'lu', '2026-01-30 15:23:42'),
(728, 23, 'L\'administrateur vous a envoyé un nouveau message.', 'non_lu', '2026-01-30 15:24:08'),
(729, 19, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-01-30 15:24:59'),
(730, 1, 'Nouveau message de belili', 'non_lu', '2026-01-30 15:25:54'),
(731, 2, 'Nouveau message de belili', 'non_lu', '2026-01-30 15:25:54'),
(732, 5, 'Nouveau message de belili', 'non_lu', '2026-01-30 15:25:54'),
(733, 15, 'Nouveau message de belili', 'lu', '2026-01-30 15:25:54'),
(734, 19, 'Nouveau message de belili', 'lu', '2026-01-30 15:25:54'),
(735, 21, 'Nouveau message de belili', 'non_lu', '2026-01-30 15:25:54'),
(736, 22, 'Nouveau message de belili', 'non_lu', '2026-01-30 15:25:54'),
(737, 23, 'Nouveau message de belili', 'non_lu', '2026-01-30 15:25:54'),
(738, 24, 'Nouveau message de belili', 'non_lu', '2026-01-30 15:25:54'),
(739, 25, 'Nouveau message de belili', 'non_lu', '2026-01-30 15:25:54'),
(740, 1, 'Nouveau message de az', 'non_lu', '2026-01-30 15:26:19'),
(741, 2, 'Nouveau message de az', 'non_lu', '2026-01-30 15:26:19'),
(742, 5, 'Nouveau message de az', 'non_lu', '2026-01-30 15:26:19'),
(743, 15, 'Nouveau message de az', 'lu', '2026-01-30 15:26:19'),
(744, 19, 'Nouveau message de az', 'lu', '2026-01-30 15:26:19'),
(745, 21, 'Nouveau message de az', 'non_lu', '2026-01-30 15:26:19'),
(746, 22, 'Nouveau message de az', 'non_lu', '2026-01-30 15:26:19'),
(747, 23, 'Nouveau message de az', 'non_lu', '2026-01-30 15:26:19'),
(748, 24, 'Nouveau message de az', 'non_lu', '2026-01-30 15:26:19'),
(749, 25, 'Nouveau message de az', 'non_lu', '2026-01-30 15:26:19'),
(750, 26, 'L\'administrateur vous a envoyé un nouveau message.', 'lu', '2026-01-30 15:27:02'),
(751, 1, 'Nouveau message de belili', 'non_lu', '2026-01-30 15:27:31'),
(752, 2, 'Nouveau message de belili', 'non_lu', '2026-01-30 15:27:31'),
(753, 5, 'Nouveau message de belili', 'non_lu', '2026-01-30 15:27:31'),
(754, 15, 'Nouveau message de belili', 'lu', '2026-01-30 15:27:31'),
(755, 19, 'Nouveau message de belili', 'lu', '2026-01-30 15:27:31'),
(756, 21, 'Nouveau message de belili', 'non_lu', '2026-01-30 15:27:31'),
(757, 22, 'Nouveau message de belili', 'non_lu', '2026-01-30 15:27:31'),
(758, 23, 'Nouveau message de belili', 'non_lu', '2026-01-30 15:27:31'),
(759, 24, 'Nouveau message de belili', 'non_lu', '2026-01-30 15:27:31'),
(760, 25, 'Nouveau message de belili', 'non_lu', '2026-01-30 15:27:31'),
(761, 1, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 20 | Type: sortie | From: iot2 | To: N/A', 'non_lu', '2026-01-30 15:33:02'),
(762, 2, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 20 | Type: sortie | From: iot2 | To: N/A', 'non_lu', '2026-01-30 15:33:02'),
(763, 5, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 20 | Type: sortie | From: iot2 | To: N/A', 'non_lu', '2026-01-30 15:33:02'),
(764, 15, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 20 | Type: sortie | From: iot2 | To: N/A', 'lu', '2026-01-30 15:33:02'),
(765, 19, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 20 | Type: sortie | From: iot2 | To: N/A', 'lu', '2026-01-30 15:33:02'),
(766, 21, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 20 | Type: sortie | From: iot2 | To: N/A', 'non_lu', '2026-01-30 15:33:02'),
(767, 22, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 20 | Type: sortie | From: iot2 | To: N/A', 'non_lu', '2026-01-30 15:33:02'),
(768, 23, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 20 | Type: sortie | From: iot2 | To: N/A', 'non_lu', '2026-01-30 15:33:02'),
(769, 24, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 20 | Type: sortie | From: iot2 | To: N/A', 'non_lu', '2026-01-30 15:33:02'),
(770, 25, 'Nouvelle demande (sortie) de la part de achwak belili DEMANDE_ACCES | Employé: achwak belili | Art: ghjn,kl; | Qty: 20 | Type: sortie | From: iot2 | To: N/A', 'non_lu', '2026-01-30 15:33:02'),
(771, 15, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-01-30 15:33:10'),
(772, 26, 'OK_DEMANDE_28', 'lu', '2026-01-30 15:33:16'),
(773, 19, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-01-30 15:38:54'),
(774, 19, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-01-30 15:39:02'),
(775, 19, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'non_lu', '2026-01-30 15:39:06'),
(776, 18, 'L\'administrateur vous a envoyé un nouveau message.', 'non_lu', '2026-01-30 16:03:56'),
(777, 15, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'lu', '2026-02-03 16:37:38'),
(778, 15, 'ALERTE STOCK: L\'article \'ghjn,kl;\' dans le magasin \'iot2\' est presque épuisé (Qte: 1).', 'non_lu', '2026-02-03 16:37:45');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` varchar(20) DEFAULT 'employe_stock',
  `etat_compte` enum('actif','bloque') DEFAULT 'actif',
  `date_creation` datetime DEFAULT current_timestamp(),
  `code_verif` int(6) DEFAULT NULL,
  `token_recuperation` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `nom`, `prenom`, `email`, `mot_de_passe`, `role`, `etat_compte`, `date_creation`, `code_verif`, `token_recuperation`) VALUES
(1, 'laakom', 'maram', 'maramlakoom@gmail.com', 'yes123', 'admin', 'bloque', '2026-01-07 15:05:41', NULL, NULL),
(2, 'maram', 'dsfgsdf', 'maramlaakomyghujikolp2@gmail.com', '$2y$10$Z6cJ4edZ8tlAsgZChp1CMOmN9Im0Ou4i6ZqsN46UiyWCoTD.0FbQi', 'admin', 'bloque', '2025-12-29 00:00:00', NULL, NULL),
(5, 'jkl', 'j', '96558789@gmail.com', '$2y$10$qyKydnJUdwX1xSVnNjsrT.zUXIu2/36l58aKFcwn9cTC2lF22Aztm', 'admin', 'bloque', '2026-01-08 00:00:00', NULL, NULL),
(7, 'hjj', 'jAZEE', '96558DDD789@gmail.com', '$2y$10$Llp2xNQUmoXooNkckG8ZweoYm6ZGbUXsDtdFzoU3DrnzLglNPRCd2', '', 'bloque', '2026-01-08 09:05:28', NULL, NULL),
(8, 'm', 'h', 'abcd@gmail.com', '$2y$10$XdCC/yl0qLiYx8vQJYAnkuc8XIfOmwHmDZBpucGqCP1uiF8V8IGQW', '', 'bloque', '2026-01-08 21:48:51', NULL, NULL),
(9, 'az', 'bs', 'abcdf@gmail.com', 'azertyuiop', '', 'bloque', '2026-01-10 11:56:24', NULL, NULL),
(11, 'az', 'bs', 'abcdff@gmail.com', 'azertyuiop', '', 'bloque', '2026-01-10 11:57:37', NULL, NULL),
(12, 'az', 'er', 'dffghj', '$2y$10$3v75yaHMc1mLIGcsl.493Ovr4oeTdEWJFlFUhs1cyJ62JLBIf11vS', '', 'bloque', '2026-01-22 11:39:34', NULL, NULL),
(13, 'az', 'er', 'maramlaakom4ssdd@gmail.com', '$2y$10$kHb6iCErVvZ.KhowUngDx.f9G87ZQxw8e9HTzlapLyYSfLS1tHO6u', 'employe_stock', 'bloque', '2026-01-22 11:44:14', NULL, NULL),
(14, 'ab', 'cd', 'maramlaakomsdfg2@gmail.com', 'ab', 'employe_stock', 'bloque', '2026-01-22 11:48:14', NULL, NULL),
(15, 'ab', 'cd', 'maramlaakom2@gmail.com', '$2y$10$FsvgIxv18Ru5M/M9sgqFH.WYC/gZoPQO60GfIRLqagDrVlLJZa3xO', 'admin', 'actif', '2026-01-22 11:49:56', 657759, NULL),
(18, 'az', 'er', 'maramlaakom4@gmail.com', '$2y$10$Baf9XS5D3yW/IRIoAggV3uIeyXSpY.2urOwKEllPlNA0pmHLs/D1q', 'employe_stock', 'actif', '2026-01-22 14:40:11', NULL, NULL),
(19, 'ad', 'min', 'manellaakom24@gmail.com', '$2y$10$AvBwC1RZW6DsNdbm/NJF6e6sc5SFsh.WVdooYafmDTWJdCbaZX39G', 'Admin', 'actif', '2026-01-24 20:21:34', 755387, NULL),
(20, 'CLAVIER', 'cvb', 'qsfghjk@gmail.com', '$2y$10$qmdjov.h4MWZd5qVzC23AeadJEevfmm4s23pIYSs4ckg.j2UZfEcK', 'employe_stock', 'bloque', '2026-01-24 22:16:03', NULL, NULL),
(21, 'trry', 'ret', 'tyui@gmail.com', '$2y$10$m7T.UQIw/fPvVOn/dwbMm.28oyEpJxLMSoLQjzG7GgIZPS4IglTDe', 'Admin', 'bloque', '2026-01-24 22:16:46', NULL, NULL),
(22, 'dfg', 'dfd', 'marghj@gmail.com', '$2y$10$xPmtg0VETdV3rUTVGoA6WOngrRuf7vCGgiS6.xRQR9PK39qq3PK.q', 'Admin', 'actif', '2026-01-29 13:51:56', NULL, NULL),
(23, 'sddfqsdf', 'dfg', 'maramlaakom@gmail.com', '$2y$10$8XqQZIzBHWQVZQ3wX0zf1.XytIQGRcvnld9TRcIqGUospKcZCDa3y', 'Admin', 'actif', '2026-01-29 13:52:42', NULL, NULL),
(24, 'dfg', 'frgth', 'sdf@gmail.com', '$2y$10$D7zgYFHX6pRdADzCJgNONeJfjtsQoPa4mmnAehZR0FzueVcRJUElO', 'Admin', 'actif', '2026-01-29 14:04:05', NULL, NULL),
(25, 'az', 'df', 'mar@gmail.com', '$2y$10$75J4cE36B32TrQpcfRee/eH2kkNDSYWOwT.INuKJ/1mnRcNcTQNJy', 'Admin', 'actif', '2026-01-29 14:04:46', NULL, NULL),
(26, 'belili', 'achwak', 'belliliachwek@gmail.com', '$2y$10$g9JI3tmwZMv332eog0EamuRqIOsfwyU6shJTvJNo/tOlyBvDxPyvK', 'employe_stock', 'actif', '2026-01-30 14:24:54', 239024, NULL),
(28, 'hhhh', 'hhhh', 'belliliachwekK@gmail.com', '$2y$10$.nMBb35YB6iNx0m9cdf2huQHFh4D5CHWGEJFx3TJbOFEg2zraOFOq', 'employe_stock', 'actif', '2026-01-30 15:31:04', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id_article`),
  ADD UNIQUE KEY `numero_serie` (`numero_serie`),
  ADD KEY `article_ibfk_1` (`id_magasin`);

--
-- Indexes for table `demande_contact`
--
ALTER TABLE `demande_contact`
  ADD PRIMARY KEY (`id_demande`),
  ADD KEY `id_utilisateur` (`id_utilisateur`),
  ADD KEY `fk_demande_article1A22` (`id_article`),
  ADD KEY `fk_demande_magasin_src` (`id_magasin_dest`);

--
-- Indexes for table `historique_movement`
--
ALTER TABLE `historique_movement`
  ADD PRIMARY KEY (`id_historique`),
  ADD KEY `id_utilisateur` (`id_utilisateur`),
  ADD KEY `id_magasin_src` (`id_magasin_src`),
  ADD KEY `id_magasin_dst` (`id_magasin_dst`),
  ADD KEY `fk_historique_article` (`id_article`);

--
-- Indexes for table `magasin`
--
ALTER TABLE `magasin`
  ADD PRIMARY KEY (`id_magasin`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id_message`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id_notification`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id_article` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `demande_contact`
--
ALTER TABLE `demande_contact`
  MODIFY `id_demande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `historique_movement`
--
ALTER TABLE `historique_movement`
  MODIFY `id_historique` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `magasin`
--
ALTER TABLE `magasin`
  MODIFY `id_magasin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id_message` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id_notification` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=779;

--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`id_magasin`) REFERENCES `magasin` (`id_magasin`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_article_magasin` FOREIGN KEY (`id_magasin`) REFERENCES `magasin` (`id_magasin`) ON DELETE CASCADE;

--
-- Constraints for table `demande_contact`
--
ALTER TABLE `demande_contact`
  ADD CONSTRAINT `demande_contact_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`),
  ADD CONSTRAINT `fk_demande_article1A22` FOREIGN KEY (`id_article`) REFERENCES `article` (`id_article`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_demande_magasin_src` FOREIGN KEY (`id_magasin_dest`) REFERENCES `magasin` (`id_magasin`) ON DELETE CASCADE;

--
-- Constraints for table `historique_movement`
--
ALTER TABLE `historique_movement`
  ADD CONSTRAINT `fk_historique_article` FOREIGN KEY (`id_article`) REFERENCES `article` (`id_article`) ON DELETE CASCADE,
  ADD CONSTRAINT `historique_movement_ibfk_1` FOREIGN KEY (`id_article`) REFERENCES `article` (`id_article`) ON DELETE CASCADE,
  ADD CONSTRAINT `historique_movement_ibfk_2` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE,
  ADD CONSTRAINT `historique_movement_ibfk_3` FOREIGN KEY (`id_magasin_src`) REFERENCES `magasin` (`id_magasin`) ON DELETE CASCADE,
  ADD CONSTRAINT `historique_movement_ibfk_4` FOREIGN KEY (`id_magasin_dst`) REFERENCES `magasin` (`id_magasin`) ON DELETE CASCADE;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
