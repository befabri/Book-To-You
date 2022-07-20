DROP TABLE IF EXISTS `votes`;
DROP TABLE IF EXISTS `comments`;
DROP TABLE IF EXISTS `ideas`;
DROP TABLE IF EXISTS `members`;

-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 17 avr. 2021 à 17:31
-- Version du serveur :  10.4.14-MariaDB
-- Version de PHP : 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `booktoyou`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id_comments` int(4) NOT NULL,
  `text` varchar(200) NOT NULL,
  `date_submitted` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `id_member` int(4) NOT NULL,
  `id_idea` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id_comments`, `text`, `date_submitted`, `deleted`, `id_member`, `id_idea`) VALUES
(1, 'Trop bien comme idée!', '2021-03-31 16:06:35', 0, 1, 5),
(2, 'J\'approuve', '2021-04-02 19:06:35', 0, 2, 5),
(3, '-1', '2021-04-01 16:08:51', 0, 4, 5),
(4, 'Je n\'ai pas aimé le livre, je ne l\'ai pas trouvé intéressant', '2020-12-26 16:09:11', 0, 3, 7),
(5, 'Bonne idée', '2021-02-24 10:09:11', 0, 1, 6);

-- --------------------------------------------------------

--
-- Structure de la table `ideas`
--

CREATE TABLE `ideas` (
  `id_idea` int(4) NOT NULL,
  `title` varchar(80) NOT NULL,
  `text` varchar(1200) NOT NULL,
  `status` enum('SUBMITTED','ACCEPTED','REFUSED','CLOSED') NOT NULL DEFAULT 'SUBMITTED',
  `date_submitted` datetime NOT NULL,
  `date_accepted` datetime DEFAULT NULL,
  `date_refused` datetime DEFAULT NULL,
  `date_closed` datetime DEFAULT NULL,
  `id_member` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `ideas`
--

INSERT INTO `ideas` (`id_idea`, `title`, `text`, `status`, `date_submitted`, `date_accepted`, `date_refused`, `date_closed`, `id_member`) VALUES
(5, 'Lecture Sci-Fi', 'Que pensez vous de lire de la science-fiction ?', 'ACCEPTED', '2021-03-24 15:54:44', '2021-03-31 15:54:44', NULL, NULL, 3),
(6, 'Avril : Marathon Harry Potter', 'Voter pour faire un marathon en avril de la saga Harry Potter de J. K. Rowling !', 'ACCEPTED', '2021-03-24 15:54:44', '2021-04-01 15:54:44', NULL, NULL, 2),
(7, 'Livre de l\'année 2020 : Chavirer', 'Selon moi le livre de l\'année est Chavirer de Lola Lafon.\r\n\r\n\"Entre corps érotisé et corps souffrant, magie de la scène et coulisses des douleurs, Chavirer raconte l’histoire de Cléo, jeune collégienne rêvant de devenir danseuse, tour à tour sexuellement piégée par une pseudo Fondation de la vocation, puis complice de ses stratégies de “recrutement”. Trente ans plus tard, alors qu’elle-même a fait carrière – des plateaux et coulisses de Champs-Elysées à la scène d’une prestigieuse “revue” parisienne – l’affaire ressurgit. Sous le signe des impossibles pardons, le personnage de Cléo se diffracte et se recompose à l’envi, au fil des époques et des évocations de celles et ceux qui l‘ont côtoyée, aimée, déçue ou rejetée\"\r\n\r\nRoman sortie le 19 août 2020', 'CLOSED', '2020-12-09 15:57:01', '2020-12-19 15:57:01', NULL, '2021-01-01 15:57:01', 1),
(8, 'C\'est nul ce site ', 'Votre site est tout moche', 'REFUSED', '2021-02-17 16:01:56', NULL, '2021-02-22 16:01:56', NULL, 4),
(13, 'Refonte du site', 'Je propose qu\'on devrait re designer le site\r\n', 'ACCEPTED', '2021-04-17 16:53:04', '2021-04-15 16:53:59', NULL, NULL, 5),
(14, 'Mon TOP 5 de romans Policier et Thriller ', '1° La Chasse de Bernard Minier\r\n2° Les Enquêtes d\'Hannah Swensen - tome 1 Meurtres et pépites de chocolat de Joanne Fluke\r\n3° Cordoue 1211 de Jean d\' Aillon\r\n4° Impact de Olivier Norek\r\n5° Les oubliés de John Grisham ', 'SUBMITTED', '2021-04-17 16:58:43', NULL, NULL, NULL, 6),
(15, 'Livre de l\'année 2018 : Helena ', 'Helena de Jérémy Fel aux éditions Payot et Rivages\r\n\r\nRésumé:\r\nKansas, un été plus chaud qu\'à l\'ordinaire. Une décapotable rouge fonce sur l\'Interstate. Du sang coule dans un abattoir désaffecté. Une présence terrifiante sort de l\'ombre. Des adolescents veulent changer de vie. Des hurlements s\'échappent d\'une cave. Des rêves de gloire naissent, d\'autres se brisent. La jeune Hayley se prépare pour un tournoi de golf en hommage à sa mère trop tôt disparue. Norma, seule avec ses trois enfants dans une maison perdue au milieu des champs, essaie tant bien que mal de maintenir l\'équilibre familial.\r\nQuant à Tommy, dix-sept ans, il ne parvient à atténuer sa propre souffrance qu\'en l\'infligeant à d\'autres... Tous trois se retrouvent piégés, chacun à sa manière, dans un engrenage infernal d\'où ils tenteront par tous les moyens de s\'extirper. Quitte à risquer le pire. Et il y a Helena... Jusqu\'où une mère peut-elle aller pour protéger ses enfants lorsqu\'ils commettent l\'irréparable ? Après Les Loups à leur porte, Jeremy Fel aborde cette vertigineuse question dans une grande fresque virtuose aux allures de thriller psychologique. ', 'CLOSED', '2017-12-06 17:07:06', '2017-12-08 12:23:44', NULL, '2018-01-01 22:34:12', 3),
(16, 'Octobre : Marathon romans de Bernard Minier', 'Voter pour faire un marathon des 9 romans de Bernard Minier.\r\nLe premier livre à lire est Glacé', 'CLOSED', '2020-09-29 12:19:50', '2020-09-30 11:24:09', NULL, '2020-11-17 17:21:55', 2),
(17, 'dfipusd fisdpofj iospdfhiosdfh oisdh', 'idfosdhfosd fosdhfosdfhosdhfsd fodosfhsdofhsd fhsodfsdO¨odifhsd fhsud fhusdfhsdfgusdgfq', 'REFUSED', '2021-04-17 17:22:58', NULL, '2021-04-19 17:23:13', NULL, 3),
(18, 'Lecture facile : Le prisonnier du temps', 'Le prisonnier du temps est un roman de Adam RO et c\'est un roman de science fiction.\r\n\r\n\"La pluie tombe sur la base de lancement française de Kourou, en Guyane. Elle a fait partir beaucoup de journalistes venus filmer, pour les télévisions du monde entier, le lancement de la navette européenne Argos I.\"', 'ACCEPTED', '2021-04-17 17:27:31', NULL, NULL, NULL, 1),
(19, 'Lecture fantastique', 'Comme lecture fantastique, d\'après moi il y a des romans qui méritent d\'être lus.\r\nA savoir : \r\n- Le Vagabond des étoiles  de Jack London\r\n- Le parfum de Patrick Süskind', 'SUBMITTED', '2021-04-17 17:30:48', NULL, NULL, NULL, 5);

-- --------------------------------------------------------

--
-- Structure de la table `members`
--

CREATE TABLE `members` (
  `id_member` int(4) NOT NULL,
  `username` char(30) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(80) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `privilege` enum('admin','member') NOT NULL DEFAULT 'member'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `members`
--

INSERT INTO `members` (`id_member`, `username`, `email`, `password`, `active`, `privilege`) VALUES
(1, 'broodjude', 'broodjude@hotmail.com', '$2y$10$iDFRL8NFyjJEkvUIYQd9B.wZd3PprNxOV8.v8xHz16ix6aAAEwhz.', 1, 'member'),
(2, 'overlookcook', 'overlookcook@gmail.com', '$2y$10$6mOK7FLBt9Z5wLxF/cNddOshyDc58rijdaaEPF0gSC/auRRex8chO', 1, 'member'),
(3, 'malotus', 'malotus@gmail.com', '$2y$10$xuwQWyBJ4cJpC6jJO9NesO79UZcOuRPrqZjKGHIhjM17Z4klMB4CO', 1, 'member'),
(4, 'tinselpar', 'tinselpar@outlook.com', '$2y$10$Uv9uFX/Uoz5Y8g0ZAPAZgOWeFib9O2AC2EP8/Kd5NZgtq3hMbmyzq', 0, 'member'),
(5, 'admin', 'admin@gmail.com', '$2y$10$YoeXnGzv3ZZjf1/Eu4XzIutFFxQtQzJc2DGZBLaT0YPf8xPKRz45O', 1, 'admin'),
(6, 'fruit', 'fruit@email.fr', '$2y$10$OMPv.fps0onT9GAVkct8t.gZQieLf9Zv6Fs8R0ycoOx55wLgU0ESK', 1, 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `votes`
--

CREATE TABLE `votes` (
  `id_member` int(4) NOT NULL,
  `id_idea` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `votes`
--

INSERT INTO `votes` (`id_member`, `id_idea`) VALUES
(1, 5),
(1, 6),
(1, 8),
(3, 6),
(3, 7),
(4, 6),
(5, 5),
(5, 6),
(5, 7),
(5, 8),
(5, 16),
(6, 6),
(6, 7);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id_comments`),
  ADD KEY `id_member` (`id_member`),
  ADD KEY `id_idea` (`id_idea`);

--
-- Index pour la table `ideas`
--
ALTER TABLE `ideas`
  ADD PRIMARY KEY (`id_idea`),
  ADD KEY `id_member` (`id_member`);

--
-- Index pour la table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id_member`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id_member`,`id_idea`),
  ADD KEY `id_idea` (`id_idea`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id_comments` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `ideas`
--
ALTER TABLE `ideas`
  MODIFY `id_idea` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `members`
--
ALTER TABLE `members`
  MODIFY `id_member` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id_member`) REFERENCES `members` (`id_member`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`id_idea`) REFERENCES `ideas` (`id_idea`);

--
-- Contraintes pour la table `ideas`
--
ALTER TABLE `ideas`
  ADD CONSTRAINT `ideas_ibfk_1` FOREIGN KEY (`id_member`) REFERENCES `members` (`id_member`);

--
-- Contraintes pour la table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`id_member`) REFERENCES `members` (`id_member`),
  ADD CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`id_idea`) REFERENCES `ideas` (`id_idea`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
