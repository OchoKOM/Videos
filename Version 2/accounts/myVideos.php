<?php
$urlpost = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$urlLength = strlen($urlpost);
$indexUrlLength = $urlLength - 21;
$url = substr($urlpost, 0, $indexUrlLength);
require('../php/config.php');

if (isset($_GET['vs'])) {
    // Récupérer les informations de l'utilisateur 
    $getUser = $bdd->prepare('SELECT * FROM profil WHERE  pseudo = ?');
    $getUser->execute(array($_GET['vs']));

    $vs = $_GET['vs'];
    $InfoUs = $getUser->fetch();
    if($getUser->rowcount() == 0){
        $msg = '<script>
        location.replace("../'.$vs.'");
    </script>';
    }

    $Id = $InfoUs['id'];
    $pseudo = $InfoUs['pseudo'];
    $avatar = $url.$InfoUs['avatar'];
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    if (isset($_GET['vs']) && isset($_SESSION['id']) && ($_GET['vs'] != $_SESSION['id']) || !isset($_SESSION['id'])) {
    ?>
    <title>Videos de <?= $pseudo ?>
    </title>
    <?php
    } else {
            ?>
    <title>Mes vidéos</title>
    <?php
    }
            ?>
    <link rel="stylesheet" href="../styles/history/style.css">
    <link rel="stylesheet" href="../styles/all/navbar.css">
    <link rel="stylesheet" href="../styles/all/font-awesome.css">
</head>
<?php
if (isset($msg)) {
    echo $msg;
}
?>
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
    <form action="../search" method="get">
        <input name="q" type="search" class="search-data" placeholder="Chercher" required/>
        <button type="submit" class="fas fa-search"> </button>
      </form>
      <div class="nav-items">
        <li><a href="../" >Accueil</a></li>
        <li><a href="../new">Créer</a></li>
        <?php
            if(isset($_SESSION['auth']) && isset($_SESSION['id'])){
                ?>
                <li><a href="../<?=$_SESSION['pseudo']?>" >Profil</a></li>
                <li><a href="../history">Historique</a></li>
                <?php                
            }else {
                ?>
                <li><a href="../login">Connexion</a></li>
                <?php
            }
            ?>
      </div>
      
    </nav>
      
    </nav>
    <script src="../scripts/navbar.js"></script>
    <div class="profileBx">
        <a href="../<?= $_GET['vs'] ?>"><img class="profileImg" src="<?= $avatar ?>" alt=""></a>
        <?php
        if (isset($_GET['vs']) && isset($_SESSION['id']) && ($_GET['vs'] != $_SESSION['pseudo']) || !isset($_SESSION['id'])) {
        ?>
        <h3>Videos de <a href="../<?= $_GET['vs'] ?>">
                <?= $pseudo ?>
            </a></h3>
        <?php
        } else {
            ?>
        <h3>Mes videos</h3>
        <?php
        }
            ?>
    </div>

    <div class="container">
        <?php
        if (isset($_GET['vs']) && !empty($_GET['vs'])) {
            $fetch_video = $bdd->prepare(' SELECT id, titre, poster, vues, date FROM video WHERE id_auteur = ? ORDER BY date DESC');
            $fetch_video->execute(array($Id));
        } else {
            $fetch_video = $bdd->prepare(' SELECT id, titre, poster, vues, date FROM video WHERE id_auteur = ? ORDER BY date DESC');
            $fetch_video->execute(array($_SESSION['id']));
        }

        if ($fetch_video->rowcount() == 0) {
            if(isset($_SESSION['auth']) && $_SESSION['pseudo'] === $_GET['vs']){
                ?>
                <div class="empty">
                    Aucune vidéo :| <br>
                    Cliquez <a href="../new">ici</a> pour publier une vidéo ;)
                    
                </div>
                <?php
            }else{
                ?>
                <div class="empty">
                   <?=$pseudo?> n'a encore publié aucune video... <br> 
                   Cliquez <a href="../">ici</a> pour revenir à la page d'accueil
                </div>
                <?php
            }
        
        }
        ;
        while ($myVid = $fetch_video->fetch()) {

            $id = $myVid['id'];
            $name = $myVid['titre'];
            $poster = $url.$myVid['poster'];
            $getDate = $myVid['date'];
            $viewNbr = $myVid['vues'];
            if ($viewNbr === "0") {
                $views = "• Aucune vue";
            }elseif ($viewNbr === "1") {
                $views = "• 1 vue";
            }else{
                $views = "• ".$viewNbr." vues "; 
            }
            ?>
            <div class="links" data-short="<?= $id ?>">
                <div class="asideVid">
                    <a href="../watch?v=<?= $id ?>">
                        <img src="<?= $poster ?>">
                    </a>
                    <div class="vidInfos">
                        <div class="top">
                            <h4>
                                <a href="../watch?v=<?= $id ?>">
                                    <div class="title" id="<?= $id ?>" title="<?= $name ?>"><?= $name ?></div> 
                                </a>
                            </h4>
                            <div class="date">
                                <a href="../<?= $_GET['vs'] ?>"> <?= $pseudo ?> </a>
                                <p><span><?=$views?></span> <p class="time<?=$id?>"> • Il y a </p></p>
                            </div>
                        </div>
                        
                        <br>
                        <?php
                        if (isset($_GET['vs']) && isset($_SESSION['id']) && ($Id != $_SESSION['id']) || !isset($_SESSION['id'])) {
                                    ?>
                        <div class="bottom">
                            <img onclick="location.replace('../<?= $_GET['vs'] ?>')" src="<?= $avatar ?>"> <a href="../<?= $_GET['vs'] ?>">
                                
                            </a></div>
                        <?php
                        } else {
                                        ?>
                        <div class="bottom"><a href="../edit_video/<?= $id ?>"><i class="fa fa-cog"></i> Plus
                                d'options</a></div>
                        <?php
                        }
                        ?>
                    </div>
                    <script>
                        let time<?= $id ?> = document.querySelector('.time<?= $id ?>')
                        setInterval(() => {
                            var date1<?= $id ?> = <?=$getDate?>;
                            let date<?= $id ?> = new Date().getTime()/1000
                            
                            let difference<?= $id ?> = date<?= $id ?> - date1<?= $id ?>;
                            time<?= $id ?>.innerHTML = `• Il y a  ${formatT(difference<?= $id ?>)}`
                        }, 3000);
                        var date1<?= $id ?> = <?=$getDate?>;
                        let date<?= $id ?> = new Date().getTime()/1000
                        
                        let difference<?= $id ?> = date<?= $id ?> - date1<?= $id ?>;
                        time<?= $id ?>.innerHTML = `• Il y a  ${formatT(difference<?= $id ?>)}`
                    </script>
                </div>
            </div>
        <?php

        }
            ?>
    </div>
</body>

</html>