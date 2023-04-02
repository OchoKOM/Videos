<?php
$urlpost = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$urlLength = strlen($urlpost);
$indexUrlLength = $urlLength - 22;
$url = substr($urlpost, 0, $indexUrlLength);
require('../php/config.php');
$userSearch = $_GET['vs'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$userSearch?> - Resultats dans OchoVid</title>
    <link rel="stylesheet" href="../styles/history/style.css">
    <link rel="stylesheet" href="../styles/all/navbar.css">
    <link rel="stylesheet" href="../styles/all/font-awesome.css">
</head>

<body style="--bg:#222">
<nav>
      <div class="menu-icon">
        <span class="fas fa-bars"></span>
      </div>
      <a href="../"><div class="logo"><img src="../scripts/controls/ico.png" alt="logo"> OchoKOM</div></a>
      <div class="search-icon">
        <span class="fas fa-search"></span>
      </div>
      <div class="cancel-icon" style="color: rgb(255, 61, 0);">
        <span class="fas fa-times"></span>
      </div>
        <form action="../searchUser" method="get">
            <input name="vs" type="search" class="search-data" placeholder="Chercher un profil" required value="<?=$userSearch?>"/>
            <button type="submit" class="fas fa-search"> </button>
        </form>
      <div class="nav-items">
        <li><a href="../" >Accueil</a></li>
        <li><a href="../new">Créer</a></li>
        <?php
            if(isset($_SESSION['auth']) && isset($_SESSION['id'])){
                ?>
                <li><a href="profil/<?=$_SESSION['id']?>" >Profil</a></li>
                <li><a href="../history">Historique</a></li>
                <?php                
            }else {
                ?>
                <li><a href="../membres">Connexion</a></li>
                <?php
            }
            ?>
      </div>
      
    </nav>
      
    </nav>
    <script src="../scripts/navbar.js"></script>
    

    <div class="container" style="top: 150px;">
        <?php
        if (isset($_GET['vs'])) {
            // Récupérer les informations de l'utilisateur 
            $getUser = $bdd->query('SELECT id, pseudo, avatar FROM profil WHERE pseudo LIKE "%'.$userSearch.'%"');
        }else{
            header('location: javascript:history.go(-1)');
        }

        if ($getUser->rowcount() == 0) {?>
                <div class="empty">
                    Aucune utilisateur ne possède le pseudo <?=$userSearch?> 
                </div>
            <?php
        }
        ;
        while ($myUser = $getUser->fetch()) {

            $userId = $myUser['id'];
            $userPseudo = $myUser['pseudo'];
            $userPp = $url.$myUser['avatar'];

            $fetch_video = $bdd->prepare('SELECT id FROM video WHERE id_auteur = ?');
            $fetch_video->execute(array($userId));

            $getVideos = $fetch_video->rowcount();

            if ($getVideos === 0) {
                $videos = "Aucune vidéo";
            }elseif ($getVideos === 1) {
                $videos = "1 vidéo";
            }else{
                $videos = $getVideos." vidéos";
            }
            ?>

        <div class="links" data-short="<?= $userId?>">
            <div class="asideVid">
                <a href="myvideos?vs=<?= $userId?>">
                    <img src="<?= $userPp?>" style="aspect-ratio: 1;">
                </a>
                <div class="vidInfos">
                    <a href="myvideos?vs=<?= $userId?>">
                        <h4>
                            <div class="title" id="<?= $userId?>" title="<?= $userPseudo?>"><?= $userPseudo?></div> 
                        </h4>
                    </a>
                    <br>
                    <div class="date">
                        <img onclick="location.replace('profil/<?= $userId?>')"src="<?= $userPp?>"> 
                        <span><a href="profil/<?= $userId?>"><?= $userPseudo?></a></span>
                        <span> • </span>
                        <span><a href="myvideos?vs=<?= $userId?>">Voir ses vidéos (<?=$videos?>)</a></span>
                    </div>

                </div>
                <script>
                    var vidName = document.getElementById('<?= $userId?>');
                    var title = vidName.innerText
                    if (title.length >= 300) {
                        title = title.substring(0, 300) + " ...";
                        vidName.innerText = title;
                    }

                </script>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
</body>
</html>