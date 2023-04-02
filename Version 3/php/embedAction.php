<?php
$urlpost = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$urlLength = strlen($urlpost);
$indexUrlLength = $urlLength - 9;
$url = substr($urlpost, 0, $indexUrlLength);

if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['v'])){ 
    require('php/config.php');
    $getid = $_GET['v'];
    $watch_date = time();
    $watch_hour = date('H:i');
    $rowv = $bdd->prepare('SELECT * FROM video WHERE id= ?');
    $rowv->execute(array($getid));

    $fetchIds = $bdd->query('SELECT id FROM video');
    while ($row3 = $fetchIds->fetch()) {
        if (($row3['id'] != $getid && $row3['id'] <= $getid)) {
            $row4 = $row3['id'];
        }
    }
    if (!isset($row4)) {
        $fetchId = $bdd->query('SELECT id FROM video ORDER BY date DESC');
        $row3 = $fetchId->fetch();
        $row4 = $row3['id'];
    }

    // Récuperer dans la base des données les vidéos pour la lecture automatique
    $fetchV = $bdd->prepare(' SELECT * FROM video WHERE id= ?');
    $fetchV->execute(array($row4));

    $nextV = $fetchV->fetch();
    $nextName = $nextV['titre'];
    $nextUsrN = $nextV['id_auteur'];
    $nextPoster = $url.$nextV['poster'];

    $getUsrN = $bdd->prepare(' SELECT pseudo FROM profil WHERE id= ?');
    $getUsrN->execute(array($nextUsrN));

    $nextUsr = $getUsrN->fetch()['pseudo'];

    $row = $rowv->fetch();
    $name = $row['titre'];
    $location = $url.$row['chemin'];
    $poster1 = $url.$row['poster'];
    $qality = $row['quality'];
    $viewNbr = $row['vues'];
    $getDate = $row['date'];
    if ($rowv->rowcount() === 0) {
        header("location: videonotfound");
    }
    $getUserVid = $bdd->prepare('SELECT id , pseudo , avatar FROM profil WHERE id = ?');
    $getUserVid->execute(array($row['id_auteur']));
    $getUserVidInf = $getUserVid->fetch();
    $usrId = $getUserVidInf['id'];
    $usrPseudo = $getUserVidInf['pseudo'];
    $usrPdp = $getUserVidInf['avatar'];

}
//todo: Mettre à jour le nombre de vues 
if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['n'])){ 
    require('config.php');
    $getid = $_GET['n'];
    $rowv = $bdd->prepare('SELECT * FROM video WHERE id= ?');
    $rowv->execute(array($getid));
    $row = $rowv->fetch();
    $viewNbr = $row['vues'];
    $addViews = $viewNbr + 1;
    if (!isset( $_COOKIE[$getid])) {
        if (setcookie($getid, true, time() + 24 * 3600, null, null, false, true)) {
            $sql = $bdd->prepare('UPDATE video SET vues = ? WHERE id = ?');
            $sql->execute(array($addViews,$getid));
        }
    }
}