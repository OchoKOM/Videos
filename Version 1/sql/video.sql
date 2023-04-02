SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


-- Base de données : `video`

-- --------------------------------------------------------

-- Structure de la table `assets`

DROP TABLE IF EXISTS `assets`;
CREATE TABLE IF NOT EXISTS `assets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `video_id` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `current` int NOT NULL,
  `watch_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Structure de la table `history`

DROP TABLE IF EXISTS `history`;
CREATE TABLE IF NOT EXISTS `history` (
  `video_id` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `watch_date` varchar(10) NOT NULL,
  `viewer_id` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Structure de la table `profil`

DROP TABLE IF EXISTS `profil`;
CREATE TABLE IF NOT EXISTS `profil` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(100) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `mdp` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Structure de la table `video`

DROP TABLE IF EXISTS `video`;
CREATE TABLE IF NOT EXISTS `video` (
  `id` varchar(20) NOT NULL,
  `titre` text NOT NULL,
  `chemin` text NOT NULL,
  `quality` int NOT NULL,
  `poster` text NOT NULL,
  `id_auteur` int NOT NULL,
  `vues` int NOT NULL,
  `date` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;
