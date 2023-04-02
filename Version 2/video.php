<?php
require('php/config.php');


if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_GET['id'])) {
        $getid = $_GET['id'];
        $rowv = $bdd->prepare('SELECT * FROM video WHERE id= ?');
        $rowv->execute(array($getid));
        $row = $rowv->fetch();
        $location = $row['chemin'];
        $path = $location;
        $size = filesize($path);
        $fm = @fopen($path, 'rb');

        if (!$fm) {
            die();
        }
        $begin = 0;
        $end = $size;
        header("Accept-Ranges: bytes");
        header("Content-Length: ".$size);
        header("Content-Disposition: inline;");
        header("Content-Ranges: bytes".($begin-$end/$size));
        header("Content-Transfert-Encoding: binary\n");
        header("Connexion: close");

        $cur= $begin;
        fseek($fm, $begin,0);
        while (!feof($fm) && $cur<$end &&(connection_status() === 0)) {
            print fread($fm,min(6144,$end-$cur));
                $cur += 6144;
        }
    }elseif (isset($_GET['location'])) {
        $getid = $_GET['location'];
        $rowv = $bdd->prepare('SELECT * FROM video WHERE id= ?');
        $rowv->execute(array($getid));
        $row = $rowv->fetch();
        $location = $row['chemin'];
        echo $location;
    }
}