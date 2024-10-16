-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 16 oct. 2024 à 12:56
-- Version du serveur : 5.7.40
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `cantine`
--

-- --------------------------------------------------------

--
-- Structure de la table `alerte`
--

DROP TABLE IF EXISTS `alerte`;
CREATE TABLE IF NOT EXISTS `alerte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `badge` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `classe` varchar(100) DEFAULT NULL,
  `commentaire` varchar(300) DEFAULT NULL,
  `justifier` enum('OUI','NON') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `calendrier`
--

DROP TABLE IF EXISTS `calendrier`;
CREATE TABLE IF NOT EXISTS `calendrier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cours` varchar(50) DEFAULT NULL,
  `profs` varchar(50) DEFAULT NULL,
  `classe` varchar(50) DEFAULT NULL,
  `salle` varchar(50) DEFAULT NULL,
  `date_cours` date DEFAULT NULL,
  `debut` time DEFAULT NULL,
  `fin` time DEFAULT NULL,
  `statut_cours` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `calendrier`
--

INSERT INTO `calendrier` (`id`, `cours`, `profs`, `classe`, `salle`, `date_cours`, `debut`, `fin`, `statut_cours`) VALUES
(1, 'Anglais', 'Truc', 'BTS CIEL', 'C22', '2024-10-09', '22:50:39', '23:13:39', NULL),
(2, 'Français', 'moi', 'BTS MS', 'C12', '2024-10-09', '12:44:47', '14:44:47', NULL),
(3, 'Pro', 'toi', 'BTS CIEL', 'sud 7', '2024-10-10', '20:45:58', '21:13:39', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `identifiant` varchar(50) DEFAULT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `classe` varchar(255) NOT NULL,
  `photo` blob,
  `statut` enum('Etudiant','Enseignant','admin') NOT NULL,
  `num_badge` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `nombre_retard` int(11) DEFAULT NULL,
  `nombre_absences` int(11) DEFAULT NULL,
  `absence_justifier` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `num_badge` (`num_badge`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `identifiant`, `nom`, `prenom`, `email`, `classe`, `photo`, `statut`, `num_badge`, `mdp`, `nombre_retard`, `nombre_absences`, `absence_justifier`) VALUES
(14, 'admin', 'billiotel', 'mateo', 'mateo.billiotel@gmail.com', 'CIEL2 IR', NULL, 'admin', '1', '$2y$10$IJIf9uR4fyTvZeqUcMQxtuFLMcaN5w.P7jyvM4OKzAxhHrZVGUbNq', NULL, NULL, NULL),
(15, 'prof', 'prof', 'prof', 'prof@gmail.com', 'CIEL2 IR', NULL, 'Enseignant', '2', '$2y$10$pEUzVubsMnub.8vQJiodneUSp9z5tlBO3lOm8wjdfMdE0Ozs6Sl9y', NULL, NULL, NULL),
(16, 'eleve', 'eleve', 'eleve', 'eleve@gmail.com', 'CIEL2 IR', NULL, 'Etudiant', '3', '$2y$10$PUrD9WstAHGqZ/VFMAPKxOLKtvXqiBg1YISrU2u4USzbeUp/ow9wW', NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
