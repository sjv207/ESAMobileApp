-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 26 juil. 2023 à 15:41
-- Version du serveur : 10.5.18-MariaDB-0+deb11u1
-- Version de PHP : 8.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `esa2023APP`
--

-- --------------------------------------------------------

--
-- Structure de la table `announcements`
--
DROP TABLE IF EXISTS `announcements` ;
CREATE TABLE `announcements` (
  `id_announcements` int(100) NOT NULL,
  `date` datetime NOT NULL,
  `title` text NOT NULL,
  `text` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Structure de la table `codes`
--
DROP TABLE IF EXISTS `codes` ;
CREATE TABLE `codes` (
  `id_code` int(100) NOT NULL,
  `code` text NOT NULL,
  `date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


-- --------------------------------------------------------

--
-- Structure de la table `date_arrays`
--
DROP TABLE IF EXISTS `date_arrays` ;
CREATE TABLE `date_arrays` (
  `id_date_arrays` int(11) NOT NULL,
  `id_day` text NOT NULL,
  `day` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Structure de la table `joint_event`
--
DROP TABLE IF EXISTS `joint_event` ;
CREATE TABLE `joint_event` (
  `id_joint_event` int(11) NOT NULL,
  `sid` text NOT NULL,
  `timeslot` text NOT NULL,
  `room` text NOT NULL,
  `event_name` text DEFAULT NULL,
  `event_title` text DEFAULT NULL,
  `event_summary` text DEFAULT NULL,
  `event_presenter_fname` text DEFAULT NULL,
  `event_presenter_lname` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Structure de la table `my_list`
--
DROP TABLE IF EXISTS `my_list` ;
CREATE TABLE `my_list` (
  `ID_my_list` int(100) NOT NULL,
  `esa_id` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `session_id` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `participants_notalk`
--
DROP TABLE IF EXISTS `participants_notalk` ;
CREATE TABLE `participants_notalk` (
  `id_participants_notalk` int(11) NOT NULL,
  `fname` text NOT NULL,
  `lname` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `program`
--
DROP TABLE IF EXISTS `program` ;
CREATE TABLE `program` (
  `id_program` int(100) NOT NULL,
  `id_session` text NOT NULL,
  `day` text NOT NULL,
  `timeslot` text NOT NULL,
  `room` text NOT NULL,
  `name` text NOT NULL,
  `presenter_fname` text NOT NULL,
  `presenter_lname` text NOT NULL,
  `presenter_email` text NOT NULL,
  `university` text NOT NULL,
  `title` text NOT NULL,
  `abstract` text NOT NULL,
  `other_authors` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour la table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id_announcements`);

--
-- Index pour la table `codes`
--
ALTER TABLE `codes`
  ADD PRIMARY KEY (`id_code`);

--
-- Index pour la table `date_arrays`
--
ALTER TABLE `date_arrays`
  ADD PRIMARY KEY (`id_date_arrays`);

--
-- Index pour la table `joint_event`
--
ALTER TABLE `joint_event`
  ADD PRIMARY KEY (`id_joint_event`);

--
-- Index pour la table `my_list`
--
ALTER TABLE `my_list`
  ADD PRIMARY KEY (`ID_my_list`),
  ADD KEY `esa_id_index` (`esa_id`);

--
-- Index pour la table `participants_notalk`
--
ALTER TABLE `participants_notalk`
  ADD PRIMARY KEY (`id_participants_notalk`);

--
-- Index pour la table `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`id_program`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id_announcements` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `codes`
--
ALTER TABLE `codes`
  MODIFY `id_code` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=260;

--
-- AUTO_INCREMENT pour la table `date_arrays`
--
ALTER TABLE `date_arrays`
  MODIFY `id_date_arrays` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `joint_event`
--
ALTER TABLE `joint_event`
  MODIFY `id_joint_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `my_list`
--
ALTER TABLE `my_list`
  MODIFY `ID_my_list` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1926;

--
-- AUTO_INCREMENT pour la table `participants_notalk`
--
ALTER TABLE `participants_notalk`
  MODIFY `id_participants_notalk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT pour la table `program`
--
ALTER TABLE `program`
  MODIFY `id_program` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=484;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
