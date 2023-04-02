SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de données : `videos`
--

-- --------------------------------------------------------

--
-- Structure de la table `assets`
--

DROP TABLE IF EXISTS `assets`;
CREATE TABLE IF NOT EXISTS `assets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `video_id` varchar(25) CHARACTER SET latin1 NOT NULL,
  `current` int(11) NOT NULL,
  `watch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `history`
--

DROP TABLE IF EXISTS `history`;
CREATE TABLE IF NOT EXISTS `history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `video_id` varchar(20) NOT NULL,
  `watch_date` varchar(10) NOT NULL,
  `viewer_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

DROP TABLE IF EXISTS `profil`;
CREATE TABLE IF NOT EXISTS `profil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(100) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `mdp` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `video`
--

DROP TABLE IF EXISTS `video`;
CREATE TABLE IF NOT EXISTS `video` (
  `id` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NOT NULL,
  `titre` text CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NOT NULL,
  `chemin` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `duration` int(11) NOT NULL,
  `quality` int(11) NOT NULL,
  `poster` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id_auteur` int(11) NOT NULL,
  `vues` int(11) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
COMMIT;