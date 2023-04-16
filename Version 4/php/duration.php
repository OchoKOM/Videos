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
        require('config.php');
        $host = "localhost";
        $user = "root";
        $mdp = "";
        $db = "video";
        $bdd = mysqli_connect($host, $user, $mdp, $db);
        $sql = "SELECT titre FROM video ORDER BY date DESC";
        $result = mysqli_query($bdd, $sql);
        $json_array = array();

        while ($data = mysqli_fetch_assoc($result)) {
            $json_array[] = $data['titre'];
        }

        echo json_encode($json_array);
        return;
    }
    if (isset($_GET['searchUser'])) {
        require('config.php');
        $host = "localhost";
        $user = "root";
        $mdp = "";
        $db = "video";

        $bdd = mysqli_connect($host, $user, $mdp, $db);
        $sql = "SELECT pseudo FROM profil";
        $result = mysqli_query($bdd, $sql);
        $json_array = array();

        while ($data = mysqli_fetch_assoc($result)) {
            $json_array[] = $data['pseudo'];
        }

        echo json_encode($json_array);
        return;
    }

echo '';
?>