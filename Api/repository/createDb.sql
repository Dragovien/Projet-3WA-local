-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : db.3wa.io
-- Généré le : mar. 13 sep. 2022 à 23:32
-- Version du serveur :  5.7.33-0ubuntu0.18.04.1-log
-- Version de PHP : 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `axelhegron_DungeonQrawler`
--

-- --------------------------------------------------------

--
-- Structure de la table `Account`
--

CREATE TABLE `Account` (
  `id` char(36) NOT NULL,
  `login` varchar(15) NOT NULL,
  `password` char(64) NOT NULL,
  `firstName` varchar(40) NOT NULL,
  `lastName` varchar(40) NOT NULL,
  `adminPrivileges` varchar(3) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Account`
--

INSERT INTO `Account` (`id`, `login`, `password`, `firstName`, `lastName`, `adminPrivileges`) VALUES
('3d937294-310d-11ed-b26c-d4ae52cd72ed', 'Armor', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 'Alphonse', 'Elric', 'no'),
('6dde30eb-29fd-11ed-b26c-d4ae52cd72ed', 'Dragovien', '182f419060f17d2319132eb94f30b7548d81c0c740977d044ef1edbb9b97233d', 'Axel', 'Hégron', 'no'),
('958ceeb4-2a98-11ed-b26c-d4ae52cd72ed', 'KenKami', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 'Jordan', 'Nguyen', 'no'),
('a2f44a2f-2a99-11ed-b26c-d4ae52cd72ed', 'Dehos', '1b4f0e9851971998e732078544c96b36c3d01cedf7caa332359d6f1d83567014', 'Bastien', 'Michelet', 'no');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Account`
--
ALTER TABLE `Account`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
