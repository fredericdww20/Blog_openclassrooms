-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 14 mai 2024 à 14:52
-- Version du serveur : 10.6.17-MariaDB
-- Version de PHP : 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `pofr8259_blogopen`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `commentary` varchar(255) NOT NULL,
  `sta` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `title`, `commentary`, `sta`, `created_at`, `id_post`, `id_user`) VALUES
(240, 'Super 1', 'Top', 1, '2023-11-19 18:59:49', 235, 45);

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `chapo` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sta` tinyint(1) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `title`, `description`, `chapo`, `created_at`, `updated_at`, `sta`, `id_user`) VALUES
(232, 'Les langages informatiques', 'C, C++ et C# seront-ils bientôt les trois langages les plus populaires dans le sillage de Python ? Si C et C++ figurent depuis plusieurs mois aux deuxième et troisième places du classement TIOBE, C# pourrait rafler la quatrième place à Java. En effet, l’é', 'Python, C et C++ dominent toujours le classement, mais C# se rapproche de la quatrième place occupée par Java.', '2023-10-09 17:32:15', '2023-10-17 05:47:11', 1, 45),
(233, 'iPhone : 5 astuces !', 'La mise à jour iOS 17, disponible au téléchargement depuis le 18 septembre pour les appareils éligibles, apporte une série de nouvelles fonctionnalités à Messages qui permettent, notamment, de simplifier ', 'Découvrez les fonctionnalités introduites dans l’application de messagerie de l’iPhone depuis le déploiement .', '2023-10-09 17:37:43', '2023-10-10 05:06:06', 1, 45),
(235, 'Instagram, nouveautés !!!', 'Durant l’événement Instagram University, qui s’est tenu à New York ce vendredi 6 octobre, Ashley Yuki, la co-directrice des produits d’Instagram. a annoncé l’arrivée de nouvelles fonctionnalités destinées à la Gen Z. ', 'Dans le cadre de son événement Instagram University.  a annoncé l’arrivée de nouvelles fonctionnalités destinées à la Gen Z. ', '2023-10-10 07:07:06', '2023-10-17 05:49:36', 1, 45);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `roles` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `lastname`, `firstname`, `email`, `roles`, `password`) VALUES
(45, 'Frederic', 'Portemer', 'synapsefred@hotmail.fr', 'ROLE_ADMIN', '$2y$10$VaBuZeTyusRZ9HsrKoYx6uLvMXuXHAvh4kIOJiB6dp4Dfae1IsGjy'),
(71, 'ggrrg', 'fdgdfd', 'synapsefred12@hotmail.fr', 'ROLE_USER', '$2y$10$9PckhaW/b9AzgP8sJZfUMOo8kmFCKfnMSjQvuO/7Z.KWYyCGqQ6cG'),
(72, 'ertret', 'ertretertret', 'synapse5fred@hotmail.fr', 'ROLE_USER', '$2y$10$lC0rWTJOzEfjr667gDtxPuSBA6q41DSUqeobKElIpCWsP.wPz4tda');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`id_post`),
  ADD KEY `user_id` (`id_user`),
  ADD KEY `id_post` (`id_post`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_post_2` (`id_post`,`id_user`);

--
-- Index pour la table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=242;

--
-- AUTO_INCREMENT pour la table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `id_post` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `id_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
