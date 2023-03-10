<?php
$urlpost = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$urlLength = strlen($urlpost);
$indexUrlLength = $urlLength - 9;
$url = substr($urlpost, 0, $indexUrlLength);

if (!isset($_GET['mv'])){ 
    require('php/config.php');
    $getid = $_GET['v'];
    $watch_date = time();
    $watch_hour = date('H:i');
    $rowv = $bdd->prepare('SELECT * FROM video WHERE id= ?');
    $rowv->execute(array($getid));

    $devicecheck = is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));

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
    if ($rowv->rowcount() == 0) {
        header('location: ./');
    }
    $getUserVid = $bdd->prepare('SELECT id , pseudo , avatar FROM profil WHERE id = ?');
    $getUserVid->execute(array($row['id_auteur']));
    $getUserVidInf = $getUserVid->fetch();
    $usrId = $getUserVidInf['id'];
    $usrPseudo = $getUserVidInf['pseudo'];
    $usrPdp = $getUserVidInf['avatar'];

    //todo: Mettre à jour le nombre de vues 
    if ($viewNbr === "0") {
        $views = "Aucune vue";
    }elseif ($viewNbr === "1") {
        $views = "1 vue";
    }else{
        $views = " ".$viewNbr." vues "; 
    }
    $addViews = $viewNbr + 1;
    if (isset($_SESSION['id']) && $_SESSION['id'] != $usrId) {
        if (!isset( $_COOKIE[$getid.'_'.$_SESSION['id']])) {
            if (setcookie($getid.'_'.$_SESSION['id'], true, time() + 24 * 3600, null, null, false, true)) {
                $sql = $bdd->prepare('UPDATE video SET vues = ? WHERE id = ?');
                $sql->execute(array($addViews,$getid));
            }
        }
    }elseif(!isset($_SESSION['id']) || !isset($_SESSION['auth'])){
        if (!isset( $_COOKIE[$getid])) {
            if (setcookie($getid, true, time() + 24 * 3600, null, null, false, true)) {
                $sql = $bdd->prepare('UPDATE video SET vues = ? WHERE id = ?');
                $sql->execute(array($addViews,$getid));
            }
        }
    }
    //todo: Enregistrer dans l'historique
    if (isset($_SESSION['id']) && $_SESSION['auth']) {
        $historyCheck = $bdd->prepare(' SELECT * FROM history WHERE video_id = ? AND viewer_id = ?');
        $historyCheck->execute(array($getid, $_SESSION['id']));
        if ($historyCheck->rowcount() == 0) {
            $sql = $bdd->prepare('INSERT INTO history(video_id, watch_date , viewer_id) VALUES(?, ?, ?)');
            $sql->execute(array($getid, $watch_date , $_SESSION['id']));
        } else {
            $sql = $bdd->prepare('UPDATE history SET watch_date = ? WHERE video_id = ? AND viewer_id = ?');
            $sql->execute(array($watch_date,$getid , $_SESSION['id']));
        }
    }
}elseif ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['mv'])){
    require('config.php');
    $getid = $_GET['mv'];
    $watch_date = time();
    $rowv = $bdd->prepare('SELECT * FROM video WHERE id= ?');
    $rowv->execute(array($getid));
    
    $row = $rowv->fetch();
    $viewNbr = $row['vues'];
    if ($rowv->rowcount() == 0) {
        die();
    }
    $getUserVid = $bdd->prepare('SELECT id , pseudo , avatar FROM profil WHERE id = ?');
    $getUserVid->execute(array($row['id_auteur']));
    $getUserVidInf = $getUserVid->fetch();
    $usrId = $getUserVidInf['id'];
    //todo: Mettre à jour le nombre de vues 
    $addViews = $viewNbr + 1;
    if (isset($_SESSION['id']) && $_SESSION['id'] != $usrId) {
        if (!isset( $_COOKIE[$getid.'_'.$_SESSION['id']])) {
            if (setcookie($getid.'_'.$_SESSION['id'], true, time() + 24 * 3600, null, null, false, true)) {
                $sql = $bdd->prepare('UPDATE video SET vues = ? WHERE id = ?');
                $sql->execute(array($addViews,$getid));
            }
        }
    }elseif(!isset($_SESSION['id']) || !isset($_SESSION['auth'])){
        if (!isset( $_COOKIE[$getid])) {
            if (setcookie($getid, true, time() + 24 * 3600, null, null, false, true)) {
                $sql = $bdd->prepare('UPDATE video SET vues = ? WHERE id = ?');
                $sql->execute(array($addViews,$getid));
            }
        }
    }
    //todo: Enregistrer dans l'historique
    if (isset($_SESSION['id']) && $_SESSION['auth']) {
        $historyCheck = $bdd->prepare(' SELECT * FROM history WHERE video_id = ? AND viewer_id = ?');
        $historyCheck->execute(array($getid, $_SESSION['id']));
        if ($historyCheck->rowcount() == 0) {
            $sql = $bdd->prepare('INSERT INTO history(video_id, watch_date , viewer_id) VALUES(?, ?, ?)');
            $sql->execute(array($getid, $watch_date , $_SESSION['id']));
        } else {
            $sql = $bdd->prepare('UPDATE history SET watch_date = ? WHERE video_id = ? AND viewer_id = ?');
            $sql->execute(array($watch_date,$getid , $_SESSION['id']));
        }
    }
}