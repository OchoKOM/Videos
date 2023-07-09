<?php
    if (isset($_SESSION['id']) && isset($_SESSION['auth']) && isset($_POST['current']) ) {
        require('config.php');
        $getid = $_POST['video_id'];
        $current = $_POST['current'];
        $duration = $_POST['duration'];
        if ($duration != 0) {
            $sql = $bdd->prepare('UPDATE video SET duration = ? WHERE id = ?');
            $sql->execute(array($duration, $getid));
        }
        
        $assetsCheck = $bdd->prepare(' SELECT * FROM assets WHERE video_id = ? AND watch_id = ?');
        $assetsCheck->execute(array($getid, $_SESSION['id']));
        
        if ($assetsCheck->rowcount() === 0) {
            $sql = $bdd->prepare('INSERT INTO assets(video_id, current, watch_id) VALUES(?,?,?)');
            $sql->execute(array($getid, $current, $_SESSION['id']));
        } else {
            $sql = $bdd->prepare('UPDATE assets SET current = ? WHERE video_id = ? AND watch_id = ?');
            $sql->execute(array($current,$getid , $_SESSION['id']));
        }
    }
    if (isset($_GET['search'])) {
       // Inclure le fichier de configuration de la base de données
        require('config.php');

        // Préparer une requête pour compter le nombre de lignes dans la table vidéo
        $requete_table1 = $bdd->prepare('SELECT COUNT(*) FROM video');

        // Exécuter la requête pour compter le nombre de lignes dans la table vidéo
        $requete_table1->execute();

        // Récupérer le nombre de lignes dans la table vidéo
        $nombre_de_lignes_table1 = $requete_table1->fetchColumn();

        // Préparer une requête pour compter le nombre de lignes dans la table profil
        $requete_table2 = $bdd->prepare('SELECT COUNT(*) FROM profil');

        // Exécuter la requête pour compter le nombre de lignes dans la table profil
        $requete_table2->execute();

        // Récupérer le nombre de lignes dans la table profil
        $nombre_de_lignes_table2 = $requete_table2->fetchColumn();

        // Déterminer le nombre total de requêtes à exécuter (le maximum entre les deux tables)
        $nombre_de_requetes = max($nombre_de_lignes_table1, $nombre_de_lignes_table2);

        // Initialiser un tableau JSON vide pour stocker les résultats
        $json_array = array();

        // Boucle à travers chaque requête
        for ($i = 0; $i < $nombre_de_requetes; $i++) {

            // Calculer l'indice de début du sous-tableau à extraire à partir des résultats de la table vidéo
            $slice = $i * 5;

            // Préparer une requête pour récupérer les titres des vidéos à partir de la table vidéo triés par date décroissante
            $requete_table1 = $bdd->prepare('SELECT titre FROM video ORDER BY date DESC');

            // Exécuter la requête pour récupérer les titres des vidéos à partir de la table vidéo triés par date décroissante
            $requete_table1->execute();

            // Récupérer tous les résultats de la requête pour récupérer les titres des vidéos à partir de la table vidéo triés par date décroissante
            $resultats_table1 = $requete_table1->fetchAll();

            // Préparer une requête pour récupérer les noms d'utilisateur à partir de la table profil
            $requete_table2 = $bdd->prepare('SELECT pseudo FROM profil');

            // Exécuter la requête pour récupérer les noms d'utilisateur à partir de la table profil
            $requete_table2->execute();

            // Récupérer tous les résultats de la requête pour récupérer les noms d'utilisateur à partir de la table profil
            $resultats_table2 = $requete_table2->fetchAll();

            // Extraire un sous-tableau des résultats de la table profil à partir de l'indice i avec une longueur de 1 élément et stocker chaque nom d'utilisateur extrait dans le tableau JSON
            foreach (array_slice($resultats_table2, $i, 1) as $resultat_table2) {
                $userName = $resultat_table2['pseudo'];
                $json_array[] = $userName;
            }

            // Extraire un sous-tableau des résultats de la table vidéo à partir de l'indice slice avec une longueur de 4 éléments et stocker chaque titre extrait dans le tableau JSON
            foreach (array_slice($resultats_table1, $slice, 4) as $resultat_table1) {
                $title = $resultat_table1['titre'];
                $json_array[] = $title;
            }
        }

        // Afficher le tableau JSON contenant les titres des vidéos et les noms d'utilisateur extraits des tables vidéo et profil respectivement en utilisant la fonction json_encode()
        echo json_encode($json_array);

        return;       
    }
echo '';
?>