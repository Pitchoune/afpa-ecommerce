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
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `nom`) VALUES
(2, 'Administrateur'),
(1, 'Super administrateur');

-- --------------------------------------------------------

--
-- Déchargement des données de la table `employe`
--

INSERT INTO `employe` (`id`, `nom`, `prenom`, `mail`, `pass`, `role`) VALUES
(1, 'Moon', 'Kevin', 'jywiledyk@mailinator.com', '$2y$10$XJZGCP.boFZD0UM74/CqY..ll0CELfmZfLv3IHhvv0HxBecVYhfHK', 1),
(3, 'rgsff', 'sfsef', 'fdebfs@djgfdkjf.com', '$2y$10$KzLHwapxlQ3VnFnTb3RTlO3YLrMkNLX0q5DfL13/4wlddKugc/v5W', 1),
(4, 'Marquez', 'Marshall', 'lagabadiw@mailinator.com', '$2y$10$veCb5GUioGhlOVg8.2j0QutPBHIUmgLh/gBMndokwHapmyXbbn23C', 1),
(5, 'Jesse', 'Cochran', 'cigap@mailinator.com', '$2y$10$u5/VylBDSwulslaQh1/KTe0DVLWCzl6nP8223jknnMIUREBHlvnp.', 2);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
