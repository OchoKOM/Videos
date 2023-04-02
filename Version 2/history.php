<?php
 
require('php/config.php');
if (isset($_SESSION['auth'])) {
    $historyFetch = $bdd->prepare(' SELECT * FROM history WHERE viewer_id = ? ORDER BY watch_date DESC');
    $historyFetch->execute(array($_SESSION['id']));
} else {
    header('location: javascript:history.go(-1)');
}
// Récupérer les informations de l'utilisateur 
$getUser = $bdd->prepare('SELECT * FROM profil WHERE  id = ?');
$getUser->execute(array($_SESSION['id']));

$InfoUs = $getUser->fetch();

$pseudo = $InfoUs['pseudo'];
$avatar = $InfoUs['avatar'];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique</title>
    <link rel="stylesheet" href="styles/history/style.css">
    <link rel="stylesheet" href="styles/all/navbar.css">
    <link rel="stylesheet" href="styles/All/font-awesome.css">
    <link rel="shortcut icon" href="scripts/controls/ico.png" type="image/x-icon">
</head>


<body>
<nav>
      <div class="menu-icon">
        <span class="fas fa-bars"></span>
      </div>
      <a href="./"><div class="logo"><img src="scripts/controls/ico.png" alt="logo"> OchoKOM</div></a>
      <div class="search-icon">
        <span class="fas fa-search"></span>
      </div>
      <div class="cancel-icon">
        <span class="fas fa-times" style="color: rgb(255, 61, 0);"></span>
      </div>
    <form action="search" method="get">
        <input name="q" type="search" class="search-data" placeholder="Chercher" required/>
        <button type="submit" class="fas fa-search"></button>
      </form>
      <div class="nav-items">
        <li><a href="./" >Accueil</a></li>
        <li><a href="new">Créer</a></li>
        <?php
            if(isset($_SESSION['auth']) && isset($_SESSION['id'])){
                ?>
                <li><a href="<?=$_SESSION['pseudo']?>">Profil</a></li>
                <li><a href="#" class="active">Historique</a></li>
                <?php                
            }else {
                ?>
                <li><a href="login">Connexion</a></li>
                <?php
            }
            ?>
      </div>
      
    </nav>
      
    </nav>
    <script src="scripts/navbar.js"></script>
    <div class="profileBx">
        <a href="profil/<?= $_SESSION['id']; ?>"><img class="profileImg" src="<?= $avatar; ?>" alt=""></a>
        
        <h3><?= $pseudo; ?></h3>
    </div>
    <div class="container">
        <?php
        define("dlt", true);
        if ($historyFetch->rowcount() == 0) {
        ?>
        <div class="empty">
            Historique vide cliquez <a href="./">ici</a> pour revenir à l'accueil
        </div>
        <?php
        }else {
            ?>
            <form action="php/deleteHistory?p=<?=$_SESSION['id'];?>" method="post">
                <input class="btn btn-warning" type="submit" value="Tout effacer" name="delete_all">
            </form>
        <?php
        }
        while ($fetchHistory = $historyFetch->fetch()) {
            $videoId = $fetchHistory['video_id'];
            $watchDate = $fetchHistory['watch_date'];

            $fetch_video = $bdd->prepare(' SELECT id, titre, poster, id_auteur FROM video WHERE id = ?');
            $fetch_video->execute(array($videoId));
            if($fetch_video->rowcount() == 0 ){
                return;
            }
            $videoHistory = $fetch_video->fetch();
            $id = $videoHistory['id'];
            $name = $videoHistory['titre'];
            $poster = $videoHistory['poster'];
            $auteur = $videoHistory['id_auteur'];

            $getUser = $bdd->prepare('SELECT * FROM profil WHERE  id = ?');
            $getUser->execute(array($auteur));
            $InfoUs = $getUser->fetch();

            $pseudo = $InfoUs['pseudo'];
            $avatar = $InfoUs['avatar'];
            ?>
        <div class="links" data-short="<?=$id;?>">
            <form action="php/deleteHistory?h=<?=$id;?>&p=<?=$_SESSION['id']?>" method="post">
                <input class="delete" type="submit" value="x" title="Effacer">
            </form>
            <div class="asideVid">
                <a href="watch?v=<?= $id; ?>">
                    <img src="<?= $poster; ?>">
                </a>
                <div class="vidInfos">
                    <div class="top">
                        <a href="watch?v=<?= $id; ?>">
                            <h4>
                                <div class="title" id="<?= $id; ?>" title="<?= $name; ?>"><?= $name; ?></div> 
                            </h4>
                        </a>
                        <div class="date">
                            <a href="profil/<?= $auteur; ?>"> <?= $pseudo; ?> </a>
                            <p class="time<?=$id?>">• Vu il y a </p>
                        </div>
                        
                    </div>
                    <div class="bottom">
                        <img onclick="location.replace('<?= $pseudo; ?>')" src="<?= $avatar; ?>">
                    </div>
                    <script>
                        let time<?=$id?> = document.querySelector('.time<?=$id?>')
                        setInterval(() => {
                            var date1<?=$id?> = <?=$watchDate?>;
                            let date<?=$id?> = new Date().getTime()/1000
                            
                            let difference<?=$id?> = date<?=$id?> - date1<?=$id?>;
                            time<?=$id?>.innerHTML = `• Vu il y a  ${formatTime(difference<?=$id?>)}`
                        }, 30000);
                        var date1<?=$id?> = <?=$watchDate?>;
                        let date<?=$id?> = new Date().getTime()/1000
                        
                        let difference<?=$id?> = date<?=$id?> - date1<?=$id?>;
                        time<?=$id?>.innerHTML = `• Vu il y a  ${formatTime(difference<?=$id?>)}`
                    </script>
                </div>
            </div>
        </div>
        
        <?php

        }
            ?>
        </div>
    </div>
    
</body>

</html>