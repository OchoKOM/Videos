<?php

$urlpost = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$urlLength = strlen($urlpost);
$indexUrlLength = $urlLength - 18;
$url = substr($urlpost, 0, $indexUrlLength);

require('../php/config.php');
$getId = $_GET['v'];
$rowv = $bdd->prepare(' SELECT * FROM video WHERE id= ?');
$rowv->execute(array($getId));

$editfetch = $rowv->fetch();

$location = $url.$editfetch['chemin'];
$poster = $url.$editfetch['poster'];
$edtitle = $editfetch['titre'];
$sessid = $editfetch['id_auteur'];

if ($sessid != $_SESSION['id'] && !isset($_GET['v']) && empty($_GET['v'])) {
    header('location: ../');
}
if (!isset($_SESSION['auth'])) {
    header('location: ../login');
}
$devicecheck = is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
$devicecheckIpad = is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "ipad"));
// File upload
if (isset($_POST['submit'])) {

    $title = htmlspecialchars($_POST['title']);
    $maxsize = 1048576000; // 100MB in bytes
    if(empty($title) || !isset($title)){
        $title = date();
    }
    if (isset($title) && !empty($title)) {
        // Insert record
        $sql = $bdd->prepare('UPDATE video SET titre = ? WHERE id_auteur = ? AND id = ?');
        $sql->execute(array($title, $_SESSION['id'], $getId));

        header('location: ../accounts/myVideos?vs=' . $_SESSION['id']);

    }
    if (isset($_FILES['poster']['name']) && !empty($_FILES['poster']['name'])) {
        $posterExt = strtolower(pathinfo($_FILES['poster']['name'], PATHINFO_EXTENSION)) ;

        $poster = time() . '_'. $title . "." . $posterExt;
        $poster_target = "../uploads/vignettes/";
        $poster_target_home = "uploads/vignettes/";
        $target_poster_home = $poster_target_home . $poster;
        $target_poster = $poster_target . $poster;
        $maxsize = 104857600; // 10MB in bytes
        // Check file size
        if ($_FILES['poster']['size'] <= $maxsize) {
            if (move_uploaded_file($_FILES['poster']['tmp_name'], $target_poster)) {

                // Insert record
                $sql = $bdd->prepare('UPDATE video SET poster = ? WHERE id_auteur = ? AND id = ?');
                $sql->execute(array($target_poster_home, $_SESSION['id'], $getId));

                header('location:../'. $_SESSION['pseudo'].'/videos');

            }
        } else {
            $msg = "Miniature trop volumineuse";
        }
    } elseif (isset($_POST['posterLnk']) && !empty($_POST['posterLnk'])) {
        $posterLink = htmlspecialchars($_POST['posterLnk']);

        // Insert record
        $sql = $bdd->prepare('UPDATE video SET poster = ? WHERE id_auteur = ? AND id = ?');
        $sql->execute(array($posterLink, $_SESSION['id'], $getId));

        header('location: javascript:history.go(-1)');

    } else {
        $msg = "Vous n'avez pas inserré une miniature";
    }
}
if (isset($_POST['submit'])) {
    header('location:../'. $_SESSION['pseudo'].'/videos');
}
if (isset($_POST['delete'])) {
    $sql = $bdd->prepare('SELECT chemin, poster FROM video WHERE id = ?');
    $sql->execute(array($getId));

    $delete0 = $sql->fetch();
    $posterDelete = '../'.$delete0['poster'];
    $videoDelete = '../'.$delete0['chemin'];

    if(unlink($videoDelete) && unlink($posterDelete) || unlink($videoDelete) || unlink($posterDelete)){
        $delete = $bdd->prepare('DELETE FROM video WHERE id = ?');
        $delete->execute(array($getId));
        $hideH = $bdd->prepare('DELETE FROM history WHERE video_id = ?');
        $hideH->execute(array($getId));
        header('location:../'. $_SESSION['pseudo'].'/videos');
    }else{
        $delete = $bdd->prepare('DELETE FROM video WHERE id = ?');
        $delete->execute(array($getId));
        $hideH = $bdd->prepare('DELETE FROM history WHERE video_id = ?');
        $hideH->execute(array($getId));
        header('location:../'. $_SESSION['pseudo'].'/videos');
    }
}