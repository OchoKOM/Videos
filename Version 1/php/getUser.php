<?php
 
require('config.php');

$getVid = $bdd->query('SELECT * FROM video');


while ($getVideos = $getVid->fetch()) {
    $getUser = $bdd->prepare('SELECT id , pseudo , avatar FROM profil WHERE id = ?');
    $getUser->execute(array($getVideos['id_auteur']));
    $getUserInf = $getUser->fetch();
    $userId = $getUserInf['id'];
    $userPseudo = $getUserInf['pseudo'];
    $userPdp = $getUserInf['avatar'];
    echo $getUserInf['pseudo'] . "<br>";
}