-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  jeu. 04 avr. 2019 à 13:41
-- Version du serveur :  10.1.37-MariaDB
-- Version de PHP :  7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projetptb`
--

-- --------------------------------------------------------

--
-- Structure de la table `abonnement`
--

CREATE TABLE `abonnement` (
  `id` int(11) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `update_at` datetime NOT NULL,
  `nombre_carte` int(11) DEFAULT NULL,
  `expiration` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `audit`
--

CREATE TABLE `audit` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `audit`
--

INSERT INTO `audit` (`id`, `user_id`, `type_id`, `created_at`, `updated_at`, `description`) VALUES
(1, 1, 1, '2019-04-04 12:01:01', '2019-04-04 12:01:01', 'impression billet PTB Dakar-Thiaroye-section1 pour le Guichet Dakar du  Numero 41 au numero 00060'),
(2, 1, 1, '2019-04-04 13:11:06', '2019-04-04 13:11:06', 'impression billet PTB Dakar-Thiaroye-section1 pour le Guichet Dakar du  Numero 81 au numero 00100');

-- --------------------------------------------------------

--
-- Structure de la table `billet_event`
--

CREATE TABLE `billet_event` (
  `id` int(11) NOT NULL,
  `trajet_id` int(11) NOT NULL,
  `guichet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `billet_navette`
--

CREATE TABLE `billet_navette` (
  `id` int(11) NOT NULL,
  `navette_id` int(11) NOT NULL,
  `guichet_id` int(11) NOT NULL,
  `numero_dernier_billet` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `billet_ptb`
--

CREATE TABLE `billet_ptb` (
  `id` int(11) NOT NULL,
  `ptb_id` int(11) DEFAULT NULL,
  `guichet_id` int(11) NOT NULL,
  `numero_dernier_billets` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `billet_ptb`
--

INSERT INTO `billet_ptb` (`id`, `ptb_id`, `guichet_id`, `numero_dernier_billets`, `created_at`, `update_at`) VALUES
(1, 1, 1, 100, '2019-04-04 11:49:08', '2019-04-04 11:49:08'),
(2, 6, 1, 0, '2019-04-04 11:49:32', '2019-04-04 11:49:32');

-- --------------------------------------------------------

--
-- Structure de la table `billet_taxe`
--

CREATE TABLE `billet_taxe` (
  `id` int(11) NOT NULL,
  `numero_dernier_billet` int(11) NOT NULL,
  `prix` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `classe`
--

CREATE TABLE `classe` (
  `id` int(11) NOT NULL,
  `libelle` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `classe`
--

INSERT INTO `classe` (`id`, `libelle`, `created_at`, `updated_at`) VALUES
(1, '1ière classe', '2019-04-04 12:41:06', '2019-04-04 12:41:06');

-- --------------------------------------------------------

--
-- Structure de la table `commande_navette`
--

CREATE TABLE `commande_navette` (
  `id` int(11) NOT NULL,
  `billet_id` int(11) NOT NULL,
  `nombre_billet` int(11) NOT NULL,
  `etat_commande` int(11) NOT NULL,
  `date_commande` datetime NOT NULL,
  `date_comnande_valider` datetime DEFAULT NULL,
  `date_commande_realiser` datetime DEFAULT NULL,
  `nombre_billet_vendu` int(11) NOT NULL,
  `nombre_billet_realise` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commande_ptb`
--

CREATE TABLE `commande_ptb` (
  `id` int(11) NOT NULL,
  `billet_id` int(11) NOT NULL,
  `nombre_billet` int(11) NOT NULL,
  `etat_commande` int(11) NOT NULL,
  `date_commande` datetime NOT NULL,
  `date_commande_valider` datetime DEFAULT NULL,
  `date_commande_realiser` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `nombre_billet_realise` int(11) NOT NULL,
  `nombre_billet_vendu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commande_ptb`
--

INSERT INTO `commande_ptb` (`id`, `billet_id`, `nombre_billet`, `etat_commande`, `date_commande`, `date_commande_valider`, `date_commande_realiser`, `updated_at`, `created_at`, `nombre_billet_realise`, `nombre_billet_vendu`) VALUES
(1, 1, 100, 2, '2019-04-04 11:52:46', NULL, NULL, '2019-04-04 11:52:46', '2019-04-04 11:52:46', 100, 0),
(2, 2, 100, 0, '2019-04-04 11:52:46', NULL, NULL, '2019-04-04 11:52:46', '2019-04-04 11:52:46', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `commande_taxe`
--

CREATE TABLE `commande_taxe` (
  `id` int(11) NOT NULL,
  `billet_id` int(11) DEFAULT NULL,
  `nombre_billet` int(11) NOT NULL,
  `etat_commande` int(11) NOT NULL,
  `date_commande` datetime NOT NULL,
  `date_comnande_valider` datetime DEFAULT NULL,
  `date_commande_realiser` datetime DEFAULT NULL,
  `nombre_billet_vendu` int(11) NOT NULL,
  `nombre_billet_realise` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commande_vignette`
--

CREATE TABLE `commande_vignette` (
  `id` int(11) NOT NULL,
  `billet_id` int(11) NOT NULL,
  `nombre_billet` int(11) NOT NULL,
  `etat_commande` int(11) NOT NULL,
  `date_commande` datetime NOT NULL,
  `date_comnande_valider` datetime DEFAULT NULL,
  `date_commande_realiser` datetime DEFAULT NULL,
  `nombre_billet_vendu` int(11) NOT NULL,
  `nombre_billet_realise` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `destinateur`
--

CREATE TABLE `destinateur` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `processus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `destinateur`
--

INSERT INTO `destinateur` (`id`, `nom`, `prenom`, `email`, `processus`, `active`) VALUES
(1, 'THERA', 'THERA', 'taalr@taalr.com', 'utilisateur', 1),
(2, 'THERA', 'THERA', 'taalr@taalr.com', 'commande', 1),
(3, 'THERA', 'THERA', 'taalr@taalr.com', 'impression', 1);

-- --------------------------------------------------------

--
-- Structure de la table `evenement`
--

CREATE TABLE `evenement` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_event` date NOT NULL,
  `fin_event` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `guichet`
--

CREATE TABLE `guichet` (
  `id` int(11) NOT NULL,
  `lieu_id` int(11) NOT NULL,
  `code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `guichet`
--

INSERT INTO `guichet` (`id`, `lieu_id`, `code`, `nom`, `created_at`, `updated_at`) VALUES
(1, 1, 'GDK', 'Dakar', '2019-04-04 11:30:45', '2019-04-04 11:30:45'),
(2, 4, 'GHN1', 'Hann1', '2019-04-04 11:33:49', '2019-04-04 11:33:49'),
(3, 5, 'GHN2', 'Hann2', '2019-04-04 11:34:18', '2019-04-04 11:34:18'),
(4, 6, 'GMB', 'Mobil', '2019-04-04 11:34:52', '2019-04-04 11:34:52'),
(5, 8, 'GPK', 'pikine', '2019-04-04 11:35:26', '2019-04-04 11:35:26'),
(6, 9, 'GTH', 'Thiaroye', '2019-04-04 11:36:14', '2019-04-04 11:36:14'),
(7, 10, 'GTB', 'Tableau', '2019-04-04 11:36:53', '2019-04-04 11:36:53'),
(8, 11, 'GY', 'yeumbeul', '2019-04-04 11:37:48', '2019-04-04 11:37:48'),
(9, 12, 'GFM', 'FassMbao', '2019-04-04 11:38:17', '2019-04-04 11:38:17'),
(10, 14, 'GKMF', 'KeurMbayeFall', '2019-04-04 11:39:02', '2019-04-04 11:39:02'),
(11, 15, 'GPNR', 'PNR', '2019-04-04 11:39:45', '2019-04-04 11:39:45'),
(12, 16, 'GRF', 'Rufisque', '2019-04-04 11:40:19', '2019-04-04 11:40:19');

-- --------------------------------------------------------

--
-- Structure de la table `lieux`
--

CREATE TABLE `lieux` (
  `id` int(11) NOT NULL,
  `libelle` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `lieux`
--

INSERT INTO `lieux` (`id`, `libelle`, `created_at`, `updated_at`) VALUES
(1, 'Dakar', '2019-04-04 11:20:12', '2019-04-04 11:20:12'),
(4, 'Hann 1', '2019-04-04 11:21:53', '2019-04-04 11:21:53'),
(5, 'Hann 2', '2019-04-04 11:22:51', '2019-04-04 11:22:51'),
(6, 'Mobil', '2019-04-04 11:23:01', '2019-04-04 11:23:01'),
(7, 'Icotaf', '2019-04-04 11:23:12', '2019-04-04 11:23:12'),
(8, 'Pikine', '2019-04-04 11:23:31', '2019-04-04 11:23:31'),
(9, 'Thiaroye', '2019-04-04 11:23:47', '2019-04-04 11:41:53'),
(10, 'Tableau abonnement', '2019-04-04 11:24:00', '2019-04-04 11:24:00'),
(11, 'Yeumbeul', '2019-04-04 11:24:15', '2019-04-04 11:24:15'),
(12, 'Fass Mbao', '2019-04-04 11:24:30', '2019-04-04 11:24:30'),
(14, 'Keur Mbaye Fall', '2019-04-04 11:27:23', '2019-04-04 11:27:23'),
(15, 'Passage à Niveau de Rufisque', '2019-04-04 11:27:44', '2019-04-04 11:27:44'),
(16, 'Rufisque', '2019-04-04 11:39:21', '2019-04-04 11:39:21'),
(17, 'Thiés', '2019-04-04 12:39:53', '2019-04-04 12:39:53');

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20190404085935', '2019-04-04 09:01:34'),
('20190404110902', '2019-04-04 11:09:13');

-- --------------------------------------------------------

--
-- Structure de la table `navette`
--

CREATE TABLE `navette` (
  `id` int(11) NOT NULL,
  `trajet_id` int(11) NOT NULL,
  `classe_id` int(11) NOT NULL,
  `prix` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `abonnement_id` int(11) DEFAULT NULL,
  `annee` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mois` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ptb`
--

CREATE TABLE `ptb` (
  `id` int(11) NOT NULL,
  `trajet_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ptb`
--

INSERT INTO `ptb` (`id`, `trajet_id`, `section_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2019-04-04 11:46:55', '2019-04-04 11:46:55'),
(2, 3, 1, '2019-04-04 11:47:05', '2019-04-04 11:47:05'),
(3, 6, 1, '2019-04-04 11:47:15', '2019-04-04 11:47:15'),
(4, 4, 1, '2019-04-04 11:47:26', '2019-04-04 11:47:26'),
(5, 5, 4, '2019-04-04 11:48:07', '2019-04-04 11:48:07'),
(6, 2, 4, '2019-04-04 11:48:18', '2019-04-04 11:48:18');

-- --------------------------------------------------------

--
-- Structure de la table `section`
--

CREATE TABLE `section` (
  `id` int(11) NOT NULL,
  `libelle` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `section`
--

INSERT INTO `section` (`id`, `libelle`, `prix`, `created_at`, `updated_at`) VALUES
(1, 'section1', 150, '2019-04-04 11:43:42', '2019-04-04 11:43:42'),
(4, 'section 2', 200, '2019-04-04 11:47:40', '2019-04-04 11:47:40');

-- --------------------------------------------------------

--
-- Structure de la table `section_event`
--

CREATE TABLE `section_event` (
  `id` int(11) NOT NULL,
  `libelle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `stock_navette`
--

CREATE TABLE `stock_navette` (
  `id` int(11) NOT NULL,
  `billet_id` int(11) NOT NULL,
  `nbre` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `stock_ptb`
--

CREATE TABLE `stock_ptb` (
  `id` int(11) NOT NULL,
  `billet_id` int(11) NOT NULL,
  `nbre` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `stock_ptb`
--

INSERT INTO `stock_ptb` (`id`, `billet_id`, `nbre`, `created_at`, `updated_at`) VALUES
(1, 1, 60, '2019-04-04 11:49:08', '2019-04-04 11:49:08'),
(2, 2, 0, '2019-04-04 11:49:32', '2019-04-04 11:49:32');

-- --------------------------------------------------------

--
-- Structure de la table `stock_taxe`
--

CREATE TABLE `stock_taxe` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `stock_vignette`
--

CREATE TABLE `stock_vignette` (
  `id` int(11) NOT NULL,
  `billet_id` int(11) NOT NULL,
  `nbre` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tracabilite`
--

CREATE TABLE `tracabilite` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ptb_id` int(11) DEFAULT NULL,
  `navette_id` int(11) DEFAULT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `motif` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_depart` int(11) NOT NULL,
  `num_fin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `trajet`
--

CREATE TABLE `trajet` (
  `id` int(11) NOT NULL,
  `depart_id` int(11) NOT NULL,
  `arrivee_id` int(11) NOT NULL,
  `evenement_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trajet`
--

INSERT INTO `trajet` (`id`, `depart_id`, `arrivee_id`, `evenement_id`, `created_at`, `updated_at`) VALUES
(1, 1, 9, NULL, '2019-04-04 11:41:00', '2019-04-04 11:41:00'),
(2, 1, 16, NULL, '2019-04-04 11:42:21', '2019-04-04 11:42:21'),
(3, 9, 1, NULL, '2019-04-04 11:42:33', '2019-04-04 11:42:33'),
(4, 9, 16, NULL, '2019-04-04 11:42:47', '2019-04-04 11:42:47'),
(5, 16, 1, NULL, '2019-04-04 11:42:56', '2019-04-04 11:42:56'),
(6, 16, 9, NULL, '2019-04-04 11:43:04', '2019-04-04 11:43:04'),
(7, 1, 17, NULL, '2019-04-04 12:40:18', '2019-04-04 12:40:18');

-- --------------------------------------------------------

--
-- Structure de la table `trajet_event`
--

CREATE TABLE `trajet_event` (
  `id` int(11) NOT NULL,
  `evenement_id` int(11) DEFAULT NULL,
  `section_id` int(11) NOT NULL,
  `depart` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `arrivee` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

CREATE TABLE `type` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` int(11) NOT NULL,
  `section` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `type_audit`
--

CREATE TABLE `type_audit` (
  `id` int(11) NOT NULL,
  `libelle` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type_audit`
--

INSERT INTO `type_audit` (`id`, `libelle`) VALUES
(1, 'impression'),
(2, 'impression irreguliére');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nom` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `update_at` datetime NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `email`, `username`, `created_at`, `filename`, `roles`, `update_at`, `password`) VALUES
(1, 'THERA', 'THERA', 'taalr@taalr.com', 'thera', '2019-04-04 11:02:38', 'Edward_elric.png', '[\"ROLE_ADMINISTRATEUR\"]', '2019-04-04 12:56:17', '$2y$12$kZ6E2IL0hlpsQUni1qlhCO5t/1HP2kKtNVqXFFLfWzDkzFL3gWDa.');

-- --------------------------------------------------------

--
-- Structure de la table `vente`
--

CREATE TABLE `vente` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `vente_navette`
--

CREATE TABLE `vente_navette` (
  `id` int(11) NOT NULL,
  `billet_id` int(11) NOT NULL,
  `nbre_de_billet` int(11) NOT NULL,
  `create_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `vente_ptb`
--

CREATE TABLE `vente_ptb` (
  `id` int(11) NOT NULL,
  `billet_id` int(11) NOT NULL,
  `nbre_de_billet` int(11) NOT NULL,
  `create_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `vente_ptb`
--

INSERT INTO `vente_ptb` (`id`, `billet_id`, `nbre_de_billet`, `create_at`, `updated_at`) VALUES
(1, 1, 40, '2019-04-04 12:01:51', '2019-04-04 12:01:51');

-- --------------------------------------------------------

--
-- Structure de la table `vente_vignette`
--

CREATE TABLE `vente_vignette` (
  `id` int(11) NOT NULL,
  `billet_id` int(11) NOT NULL,
  `nbre_de_billet` int(11) NOT NULL,
  `create_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `vignette`
--

CREATE TABLE `vignette` (
  `id` int(11) NOT NULL,
  `guichet_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `numero_dernier_billet` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `prix` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `abonnement`
--
ALTER TABLE `abonnement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_351268BBC54C8C93` (`type_id`);

--
-- Index pour la table `audit`
--
ALTER TABLE `audit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9218FF79A76ED395` (`user_id`),
  ADD KEY `IDX_9218FF79C54C8C93` (`type_id`);

--
-- Index pour la table `billet_event`
--
ALTER TABLE `billet_event`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_65D11774D12A823` (`trajet_id`),
  ADD KEY `IDX_65D11774D75742EE` (`guichet_id`);

--
-- Index pour la table `billet_navette`
--
ALTER TABLE `billet_navette`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_13476BB4DD1420CC` (`navette_id`),
  ADD KEY `IDX_13476BB4D75742EE` (`guichet_id`);

--
-- Index pour la table `billet_ptb`
--
ALTER TABLE `billet_ptb`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_76110B65BE9DC9C7` (`ptb_id`),
  ADD KEY `IDX_76110B65D75742EE` (`guichet_id`);

--
-- Index pour la table `billet_taxe`
--
ALTER TABLE `billet_taxe`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `classe`
--
ALTER TABLE `classe`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commande_navette`
--
ALTER TABLE `commande_navette`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2CEFBD6E44973C78` (`billet_id`);

--
-- Index pour la table `commande_ptb`
--
ALTER TABLE `commande_ptb`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_440F1A9444973C78` (`billet_id`);

--
-- Index pour la table `commande_taxe`
--
ALTER TABLE `commande_taxe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3D5E2E0A44973C78` (`billet_id`);

--
-- Index pour la table `commande_vignette`
--
ALTER TABLE `commande_vignette`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DD6B4E8444973C78` (`billet_id`);

--
-- Index pour la table `destinateur`
--
ALTER TABLE `destinateur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `evenement`
--
ALTER TABLE `evenement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `guichet`
--
ALTER TABLE `guichet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3C05CCE96AB213CC` (`lieu_id`);

--
-- Index pour la table `lieux`
--
ALTER TABLE `lieux`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `navette`
--
ALTER TABLE `navette`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DA54CFCED12A823` (`trajet_id`),
  ADD KEY `IDX_DA54CFCE8F5EA509` (`classe_id`);

--
-- Index pour la table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6D28840DF1D74413` (`abonnement_id`);

--
-- Index pour la table `ptb`
--
ALTER TABLE `ptb`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_435F0DC4D12A823` (`trajet_id`),
  ADD KEY `IDX_435F0DC4D823E37A` (`section_id`);

--
-- Index pour la table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `section_event`
--
ALTER TABLE `section_event`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `stock_navette`
--
ALTER TABLE `stock_navette`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_C3F2DF6D44973C78` (`billet_id`);

--
-- Index pour la table `stock_ptb`
--
ALTER TABLE `stock_ptb`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_3531B85244973C78` (`billet_id`);

--
-- Index pour la table `stock_taxe`
--
ALTER TABLE `stock_taxe`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `stock_vignette`
--
ALTER TABLE `stock_vignette`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_448D025C44973C78` (`billet_id`);

--
-- Index pour la table `tracabilite`
--
ALTER TABLE `tracabilite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7E1E9A8AA76ED395` (`user_id`),
  ADD KEY `IDX_7E1E9A8ABE9DC9C7` (`ptb_id`),
  ADD KEY `IDX_7E1E9A8ADD1420CC` (`navette_id`);

--
-- Index pour la table `trajet`
--
ALTER TABLE `trajet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2B5BA98CAE02FE4B` (`depart_id`),
  ADD KEY `IDX_2B5BA98CEAF07E42` (`arrivee_id`),
  ADD KEY `IDX_2B5BA98CFD02F13` (`evenement_id`);

--
-- Index pour la table `trajet_event`
--
ALTER TABLE `trajet_event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8DC7EEDDFD02F13` (`evenement_id`),
  ADD KEY `IDX_8DC7EEDDD823E37A` (`section_id`);

--
-- Index pour la table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `type_audit`
--
ALTER TABLE `type_audit`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`);

--
-- Index pour la table `vente`
--
ALTER TABLE `vente`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `vente_navette`
--
ALTER TABLE `vente_navette`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_855E532E44973C78` (`billet_id`);

--
-- Index pour la table `vente_ptb`
--
ALTER TABLE `vente_ptb`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C8234B5E44973C78` (`billet_id`);

--
-- Index pour la table `vente_vignette`
--
ALTER TABLE `vente_vignette`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_AB1EBEFA44973C78` (`billet_id`);

--
-- Index pour la table `vignette`
--
ALTER TABLE `vignette`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B4B561ED75742EE` (`guichet_id`),
  ADD KEY `IDX_B4B561EC54C8C93` (`type_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `abonnement`
--
ALTER TABLE `abonnement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `audit`
--
ALTER TABLE `audit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `billet_event`
--
ALTER TABLE `billet_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `billet_navette`
--
ALTER TABLE `billet_navette`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `billet_ptb`
--
ALTER TABLE `billet_ptb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `billet_taxe`
--
ALTER TABLE `billet_taxe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `classe`
--
ALTER TABLE `classe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `commande_navette`
--
ALTER TABLE `commande_navette`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commande_ptb`
--
ALTER TABLE `commande_ptb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `commande_taxe`
--
ALTER TABLE `commande_taxe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commande_vignette`
--
ALTER TABLE `commande_vignette`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `destinateur`
--
ALTER TABLE `destinateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `evenement`
--
ALTER TABLE `evenement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `guichet`
--
ALTER TABLE `guichet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `lieux`
--
ALTER TABLE `lieux`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `navette`
--
ALTER TABLE `navette`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ptb`
--
ALTER TABLE `ptb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `section`
--
ALTER TABLE `section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `section_event`
--
ALTER TABLE `section_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `stock_navette`
--
ALTER TABLE `stock_navette`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `stock_ptb`
--
ALTER TABLE `stock_ptb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `stock_taxe`
--
ALTER TABLE `stock_taxe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `stock_vignette`
--
ALTER TABLE `stock_vignette`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tracabilite`
--
ALTER TABLE `tracabilite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `trajet`
--
ALTER TABLE `trajet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `trajet_event`
--
ALTER TABLE `trajet_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `type`
--
ALTER TABLE `type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `type_audit`
--
ALTER TABLE `type_audit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `vente`
--
ALTER TABLE `vente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `vente_navette`
--
ALTER TABLE `vente_navette`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `vente_ptb`
--
ALTER TABLE `vente_ptb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `vente_vignette`
--
ALTER TABLE `vente_vignette`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `vignette`
--
ALTER TABLE `vignette`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `abonnement`
--
ALTER TABLE `abonnement`
  ADD CONSTRAINT `FK_351268BBC54C8C93` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`);

--
-- Contraintes pour la table `audit`
--
ALTER TABLE `audit`
  ADD CONSTRAINT `FK_9218FF79A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_9218FF79C54C8C93` FOREIGN KEY (`type_id`) REFERENCES `type_audit` (`id`);

--
-- Contraintes pour la table `billet_event`
--
ALTER TABLE `billet_event`
  ADD CONSTRAINT `FK_65D11774D12A823` FOREIGN KEY (`trajet_id`) REFERENCES `trajet_event` (`id`),
  ADD CONSTRAINT `FK_65D11774D75742EE` FOREIGN KEY (`guichet_id`) REFERENCES `guichet` (`id`);

--
-- Contraintes pour la table `billet_navette`
--
ALTER TABLE `billet_navette`
  ADD CONSTRAINT `FK_13476BB4D75742EE` FOREIGN KEY (`guichet_id`) REFERENCES `guichet` (`id`),
  ADD CONSTRAINT `FK_13476BB4DD1420CC` FOREIGN KEY (`navette_id`) REFERENCES `navette` (`id`);

--
-- Contraintes pour la table `billet_ptb`
--
ALTER TABLE `billet_ptb`
  ADD CONSTRAINT `FK_76110B65BE9DC9C7` FOREIGN KEY (`ptb_id`) REFERENCES `ptb` (`id`),
  ADD CONSTRAINT `FK_76110B65D75742EE` FOREIGN KEY (`guichet_id`) REFERENCES `guichet` (`id`);

--
-- Contraintes pour la table `commande_navette`
--
ALTER TABLE `commande_navette`
  ADD CONSTRAINT `FK_2CEFBD6E44973C78` FOREIGN KEY (`billet_id`) REFERENCES `billet_navette` (`id`);

--
-- Contraintes pour la table `commande_ptb`
--
ALTER TABLE `commande_ptb`
  ADD CONSTRAINT `FK_440F1A9444973C78` FOREIGN KEY (`billet_id`) REFERENCES `billet_ptb` (`id`);

--
-- Contraintes pour la table `commande_taxe`
--
ALTER TABLE `commande_taxe`
  ADD CONSTRAINT `FK_3D5E2E0A44973C78` FOREIGN KEY (`billet_id`) REFERENCES `billet_taxe` (`id`);

--
-- Contraintes pour la table `commande_vignette`
--
ALTER TABLE `commande_vignette`
  ADD CONSTRAINT `FK_DD6B4E8444973C78` FOREIGN KEY (`billet_id`) REFERENCES `vignette` (`id`);

--
-- Contraintes pour la table `guichet`
--
ALTER TABLE `guichet`
  ADD CONSTRAINT `FK_3C05CCE96AB213CC` FOREIGN KEY (`lieu_id`) REFERENCES `lieux` (`id`);

--
-- Contraintes pour la table `navette`
--
ALTER TABLE `navette`
  ADD CONSTRAINT `FK_DA54CFCE8F5EA509` FOREIGN KEY (`classe_id`) REFERENCES `classe` (`id`),
  ADD CONSTRAINT `FK_DA54CFCED12A823` FOREIGN KEY (`trajet_id`) REFERENCES `trajet` (`id`);

--
-- Contraintes pour la table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `FK_6D28840DF1D74413` FOREIGN KEY (`abonnement_id`) REFERENCES `abonnement` (`id`);

--
-- Contraintes pour la table `ptb`
--
ALTER TABLE `ptb`
  ADD CONSTRAINT `FK_435F0DC4D12A823` FOREIGN KEY (`trajet_id`) REFERENCES `trajet` (`id`),
  ADD CONSTRAINT `FK_435F0DC4D823E37A` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`);

--
-- Contraintes pour la table `stock_navette`
--
ALTER TABLE `stock_navette`
  ADD CONSTRAINT `FK_C3F2DF6D44973C78` FOREIGN KEY (`billet_id`) REFERENCES `billet_navette` (`id`);

--
-- Contraintes pour la table `stock_ptb`
--
ALTER TABLE `stock_ptb`
  ADD CONSTRAINT `FK_3531B85244973C78` FOREIGN KEY (`billet_id`) REFERENCES `billet_ptb` (`id`);

--
-- Contraintes pour la table `stock_vignette`
--
ALTER TABLE `stock_vignette`
  ADD CONSTRAINT `FK_448D025C44973C78` FOREIGN KEY (`billet_id`) REFERENCES `vignette` (`id`);

--
-- Contraintes pour la table `tracabilite`
--
ALTER TABLE `tracabilite`
  ADD CONSTRAINT `FK_7E1E9A8AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_7E1E9A8ABE9DC9C7` FOREIGN KEY (`ptb_id`) REFERENCES `ptb` (`id`),
  ADD CONSTRAINT `FK_7E1E9A8ADD1420CC` FOREIGN KEY (`navette_id`) REFERENCES `navette` (`id`);

--
-- Contraintes pour la table `trajet`
--
ALTER TABLE `trajet`
  ADD CONSTRAINT `FK_2B5BA98CAE02FE4B` FOREIGN KEY (`depart_id`) REFERENCES `lieux` (`id`),
  ADD CONSTRAINT `FK_2B5BA98CEAF07E42` FOREIGN KEY (`arrivee_id`) REFERENCES `lieux` (`id`),
  ADD CONSTRAINT `FK_2B5BA98CFD02F13` FOREIGN KEY (`evenement_id`) REFERENCES `evenement` (`id`);

--
-- Contraintes pour la table `trajet_event`
--
ALTER TABLE `trajet_event`
  ADD CONSTRAINT `FK_8DC7EEDDD823E37A` FOREIGN KEY (`section_id`) REFERENCES `section_event` (`id`),
  ADD CONSTRAINT `FK_8DC7EEDDFD02F13` FOREIGN KEY (`evenement_id`) REFERENCES `evenement` (`id`);

--
-- Contraintes pour la table `vente_navette`
--
ALTER TABLE `vente_navette`
  ADD CONSTRAINT `FK_855E532E44973C78` FOREIGN KEY (`billet_id`) REFERENCES `billet_navette` (`id`);

--
-- Contraintes pour la table `vente_ptb`
--
ALTER TABLE `vente_ptb`
  ADD CONSTRAINT `FK_C8234B5E44973C78` FOREIGN KEY (`billet_id`) REFERENCES `billet_ptb` (`id`);

--
-- Contraintes pour la table `vente_vignette`
--
ALTER TABLE `vente_vignette`
  ADD CONSTRAINT `FK_AB1EBEFA44973C78` FOREIGN KEY (`billet_id`) REFERENCES `vignette` (`id`);

--
-- Contraintes pour la table `vignette`
--
ALTER TABLE `vignette`
  ADD CONSTRAINT `FK_B4B561EC54C8C93` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`),
  ADD CONSTRAINT `FK_B4B561ED75742EE` FOREIGN KEY (`guichet_id`) REFERENCES `guichet` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
