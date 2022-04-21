-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : jeu. 21 avr. 2022 à 21:53
-- Version du serveur : 10.7.3-MariaDB
-- Version de PHP : 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ecommerce`
--

--
-- Déchargement des données de la table `employe`
--

INSERT INTO `employe` (`id`, `nom`, `prenom`, `mail`, `pass`, `role`) VALUES
(1, 'Moon', 'Kevin', 'jywiledyk@mailinator.com', '$2y$10$XJZGCP.boFZD0UM74/CqY..ll0CELfmZfLv3IHhvv0HxBecVYhfHK', 1),
(3, 'rgsff', 'sfsef', 'fdebfs@djgfdkjf.com', '$2y$10$KzLHwapxlQ3VnFnTb3RTlO3YLrMkNLX0q5DfL13/4wlddKugc/v5W', 1),
(4, 'Marquez', 'Marshall', 'lagabadiw@mailinator.com', '$2y$10$veCb5GUioGhlOVg8.2j0QutPBHIUmgLh/gBMndokwHapmyXbbn23C', 1),
(5, 'Jesse', 'Cochran', 'cigap@mailinator.com', '$2y$10$u5/VylBDSwulslaQh1/KTe0DVLWCzl6nP8223jknnMIUREBHlvnp.', 2);

-- --------------------------------------------------------

--
-- Structure de la table `permission`
--

CREATE TABLE `permission` (
  `id` int(11) UNSIGNED NOT NULL,
  `module` varchar(30) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `permission`
--

INSERT INTO `permission` (`id`, `module`, `description`) VALUES
(1, 'rôles', 'Peut voir la liste des rôles'),
(2, 'rôles', 'Peut ajouter un rôle'),
(3, 'rôles', 'Peut modifier un rôle'),
(4, 'rôles', 'Peut supprimer un rôle'),
(5, 'employés', 'Peut voir la liste des employés'),
(6, 'employés', 'Peut ajouter un employé'),
(7, 'employés', 'Peut modifier un employé'),
(8, 'employés', 'Peut supprimer un employé'),
(9, 'catégories', 'Peut voir la liste des catégories'),
(10, 'catégories', 'Peut ajouter une catégorie'),
(11, 'catégories', 'Peut modifier une catégorie'),
(12, 'catégories', 'Peut supprimer une catégorie'),
(13, 'marques', 'Peut voir la liste des marques'),
(14, 'marques', 'Peut ajouter une marque'),
(15, 'marques', 'Peut modifier une marque'),
(16, 'marques', 'Peut modifier le logo des marques'),
(17, 'marques', 'Peut supprimer une marque'),
(18, 'transporteurs', 'Peut voir la liste de transporteur'),
(19, 'transporteurs', 'Peut ajouter un transporteur'),
(20, 'transporteurs', 'Peut modifier un transporteur'),
(21, 'transporteurs', 'Peut modifier le logo des transporteurs'),
(22, 'transporteurs', 'Peut supprimer un transporteur'),
(23, 'produits', 'Peut voir la liste des produits'),
(24, 'produits', 'Peut ajouter un produit'),
(25, 'produits', 'Peut modifier un produit'),
(26, 'produits', 'Peut modifier les photos des produits'),
(27, 'produits', 'Peut supprimer les produits'),
(28, 'clients', 'Peut voir la liste des clients'),
(29, 'clients', 'Peut ajouter un client'),
(30, 'clients', 'Peut modifier un client'),
(31, 'clients', 'Peut consulter les commandes des clients'),
(32, 'clients', 'Peut consulter le détails des commandes des clients'),
(33, 'clients', '');

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `nom`) VALUES
(2, 'Administrateur'),
(1, 'Super administrateur');

-- --------------------------------------------------------

--
-- Structure de la table `role_permission`
--

CREATE TABLE `role_permission` (
  `id_role` int(11) NOT NULL,
  `id_perm` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `role_permission`
--

INSERT INTO `role_permission` (`id_role`, `id_perm`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 32),
(1, 33),
(2, 1),
(2, 2),
(2, 3),
(2, 5),
(2, 6),
(2, 7),
(2, 9),
(2, 10),
(2, 11),
(2, 13),
(2, 14),
(2, 15),
(2, 16),
(2, 18),
(2, 19),
(2, 20),
(2, 21),
(2, 23),
(2, 24),
(2, 25),
(2, 26),
(2, 28),
(2, 29),
(2, 30),
(2, 31),
(2, 32);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `role_permission`
--
ALTER TABLE `role_permission`
  ADD UNIQUE KEY `id_role` (`id_role`,`id_perm`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
