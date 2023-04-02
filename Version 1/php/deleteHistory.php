<?php

require('../php/security.php');
require('../php/config.php');
// Effacer de l'historique
if (isset($_GET['p'])) {
    $useId = $bdd->prepare('SELECT viewer_id FROM history WHERE viewer_id = ?');
    $useId->execute(array($_GET['p']));

    $userId = $useId->fetch();
    if (isset($_SESSION['auth']) && $userId['viewer_id'] === $_SESSION['id']) {
        if (isset($_POST['delete_all'])) {
            $delete = $bdd->prepare('DELETE FROM history WHERE viewer_id = ?');
            $delete->execute(array($_SESSION['id']));
            header('location: ../history');
        }else{
            $delete = $bdd->prepare('DELETE FROM history WHERE viewer_id = ? AND video_id = ?');
            $delete->execute(array($_SESSION['id'],$_GET['h']));
            header('location: ../history');
        }
    }
}else{
    header('location: ../');
}