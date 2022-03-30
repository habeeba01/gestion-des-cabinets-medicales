-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 03 fév. 2021 à 03:01
-- Version du serveur :  10.4.17-MariaDB
-- Version de PHP : 7.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `cabinet_medical`
--

-- --------------------------------------------------------

--
-- Structure de la table `consultation`
--

CREATE TABLE `consultation` (
  `id_medecin` int(11) DEFAULT NULL,
  `id_usager` int(11) NOT NULL,
  `dateConsultation` date NOT NULL,
  `heureConsultation` time NOT NULL,
  `dureeConsultation` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `consultation`
--

INSERT INTO `consultation` (`id_medecin`, `id_usager`, `dateConsultation`, `heureConsultation`, `dureeConsultation`) VALUES
(3, 1, '2020-01-15', '12:00:00', '00:30:00'),
(4, 1, '2020-03-10', '09:00:00', '00:30:00'),
(1, 2, '2020-01-15', '10:00:00', '00:30:00'),
(5, 3, '2020-02-02', '15:00:00', '00:30:00');

-- --------------------------------------------------------

--
-- Structure de la table `medecin`
--

CREATE TABLE `medecin` (
  `id_medecin` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `civilite` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `medecin`
--

INSERT INTO `medecin` (`id_medecin`, `nom`, `prenom`, `civilite`) VALUES
(1, 'Ballet', 'Thomas', 'H'),
(2, 'Garbet', 'Louise', 'F'),
(3, 'Brunet', 'Paul', 'H'),
(4, 'Randon', 'Tiphen', 'H'),
(5, 'Rech', 'Loic', 'H'),
(6, 'Namli', 'Najwa', 'F');

-- --------------------------------------------------------

--
-- Structure de la table `usager`
--

CREATE TABLE `usager` (
  `id_usager` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `civilite` char(1) DEFAULT NULL,
  `dateNaissance` date DEFAULT NULL,
  `lieuNaissance` varchar(50) DEFAULT NULL,
  `adresse` varchar(50) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `codePostal` int(11) DEFAULT NULL,
  `numeroSC` char(15) DEFAULT NULL,
  `id_medecin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `usager`
--

INSERT INTO `usager` (`id_usager`, `nom`, `prenom`, `civilite`, `dateNaissance`, `lieuNaissance`, `adresse`, `ville`, `codePostal`, `numeroSC`, `id_medecin`) VALUES
(1, 'Najwa', 'Namli', 'H', '2000-07-15', 'Safi', 'DUT Informatique', 'Safi', 36000, '000000000000001', 1),
(2, 'Alae', 'El Oula', 'H', '1999-08-26', 'Safi', 'DUT Informatique', 'Safi', 36000, '000000000000002', 3),
(3, 'Ahmed', 'Ahmed', 'H', '2000-10-15', 'Marrakech', 'DUT Informatique', 'Marrakech', 32000, '000000000000003', 4),
(4, 'Salma', 'Salma', 'F', '2001-01-11', 'Marrakech', 'DUT Informatique', 'Marrakech', 32000, '000000000000004', NULL),
(10, 'Jolie', 'Angelina', 'F', '1975-06-04', 'Paris', 'Hollywood', 'Californie', 31000, '000000000000010', 2),
(13, 'Shawn', 'Mendes', 'H', '1930-05-31', 'San Francisco', 'Hollywood', 'Californie', 31000, '000000000000013', NULL),
(15, 'Watson', 'Emma', 'F', '1990-04-15', 'Paris', 'Poudlard', 'Royaume-Uni', 31000, '000000000000015', 3),
(16, 'Travis', 'Scott', 'H', '1959-03-18', 'Rabat', 'Hay Anas', 'Rabat', 33000, '000000000000016', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_users` int(11) NOT NULL,
  `username` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_users`, `username`, `password`) VALUES
(1, 'user', 'password'),
(2, 'root', 'root'),
(3, 'test', 'test');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `consultation`
--
ALTER TABLE `consultation`
  ADD PRIMARY KEY (`id_usager`,`dateConsultation`,`heureConsultation`);

--
-- Index pour la table `medecin`
--
ALTER TABLE `medecin`
  ADD PRIMARY KEY (`id_medecin`);

--
-- Index pour la table `usager`
--
ALTER TABLE `usager`
  ADD PRIMARY KEY (`id_usager`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `medecin`
--
ALTER TABLE `medecin`
  MODIFY `id_medecin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `usager`
--
ALTER TABLE `usager`
  MODIFY `id_usager` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
