<?php
    session_start();
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=video;charset=utf8', 'root','');
    } catch(Exception $e){
        die('Une erreur a été trouvé : ' . $e->getMessage()); 
    }
    if (isset($_SESSION['id']) && $_SESSION['auth'] && isset($_POST['current']) ) {
        $getid = $_POST['video_id'];
        $current = $_POST['current'];
        $duration = $_POST['duration'];
        if ($duration != 0) {
            $sql = $bdd->prepare('UPDATE video SET duration = ? WHERE id = ?');
            $sql->execute(array($duration, $getid));
        }
        
        $assetsCheck = $bdd->prepare(' SELECT * FROM assets WHERE video_id = ? AND watch_id = ?');
        $assetsCheck->execute(array($getid, $_SESSION['id']));
        if ($assetsCheck->rowcount() == 0) {
            $sql = $bdd->prepare('INSERT INTO assets(video_id, current, watch_id) VALUES(?,?,?)');
            $sql->execute(array($getid, $current, $_SESSION['id']));
        } else {
            $sql = $bdd->prepare('UPDATE assets SET current = ? WHERE video_id = ? AND watch_id = ?');
            $sql->execute(array($current,$getid , $_SESSION['id']));
        }
    }
