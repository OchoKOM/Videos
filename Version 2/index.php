<?php
$urlpost = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$urlLength = strlen($urlpost);
$indexUrlLength = $urlLength - 9;
$url = substr($urlpost, 0, $indexUrlLength);


require('php/postAction.php');
$fetchVideos = $bdd->query('SELECT * FROM video ORDER BY date DESC LIMIT 100');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php
if (isset($_GET['q']) && !empty($_GET['q'])) {
    $userSearch = $_GET['q'];
    ?>
    <title> <?=$userSearch;?> - Résultats dans Vidéos</title>
    <?php 
}else{
    ?>
    <title>OchoVid</title>
    <?php 
}
?>
<link rel="shortcut icon" href="scripts/controls/ico.png" type="image/x-icon">
<link rel="stylesheet" href="styles/all/font-awesome.css">
<link rel="stylesheet" href="styles/all/navbar.css">
<link rel="stylesheet" href="styles/home/style.css">
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
        <span class="fas fa-times"></span>
      </div>
      <?php if ($fetchVideos->rowcount() > 1) {
        ?> 
        <form action="search" method="get">
        <input name="q" type="search" class="search-data" placeholder="Chercher" required/>
        <button type="submit" class="fas fa-search"></button>
      </form>
        <?php
        }
        ?>
      <div class="nav-items">
        <li><a href="#" class="active">Accueil</a></li>
        <li><a href="new">Créer</a></li>
        <?php
            if(isset($_SESSION['auth']) && isset($_SESSION['id'])){
                ?>
                <li><a href="<?=$_SESSION['pseudo'];?>">Profil</a></li>
                <li><a href="history">Historique</a></li>
                <?php                
            }else {
                ?>
                <li><a href="login">Connexion</a></li>
                <?php
            }
            ?>
      </div>
      
    </nav>
    <script src="scripts/navbar.js"></script>
<div class="content">
        <div class="grid" >
        <?php
           
                if ($fetchVideos->rowcount() == 0) {
                    ?>
                <script>
                    localStorage.clear()
                </script>
                <div align=center class="message">
                <h3>Aucune vidéo n'a été publié pour l'instant 
                    <button onclick="location.replace('new')" class="btn btn-warning" id="mod">Cliquez Ici</button> pour être le premier à publier une video
                </h3>
                </div>
                <?php
                
                }else{
                    while($row = $fetchVideos->fetch()){
                        $getUser = $bdd->prepare('SELECT id , pseudo , avatar FROM profil WHERE id = ?');
                        $getUser->execute(array($row['id_auteur']));
                            $getUserInf = $getUser->fetch();
                            $userId = $getUserInf['id'];
                            $userPseudo = $getUserInf['pseudo'];
                            $userPdp = $getUserInf['avatar'];
                            $name = $row['titre'];
                            $poster = $url.$row['poster'];
                            $viewNbr = $row['vues'];
                            $getDate = $row['date'];
                            if ($viewNbr === "0") {
                                $views = "Aucune vue";
                            }elseif ($viewNbr === "1") {
                                $views = "1 vue";
                            }else{
                                $views = " ".$viewNbr." vues "; 
                            }
                
                        ?>
                    <div class="links">
                        <div class="thumbNails" data-mini="<?=$row['id']?>">
                            <a>
                                <div class="mini-player" >
                                    <img src="<?=$poster;?>" alt="Thumbnail of <?=$name;?>" onclick="location.replace('watch?v=<?=$row['id']?>')">
                                    <video autoplay></video>
                                    <button title="Lire" class="active" data-time="Lire">
                                        <svg class="play-icon" viewBox="0 0 24 24" style="width: 20px;height: 20px;">
                                            <path fill="currentColor" d="M8,5.14V19.14L19,12.14L8,5.14Z" />
                                        </svg>
                                    </button>
                                </div>
                            </a>
                            <div class="vidInf">
                                <div class="avatar2">
                                    <a href="<?=$userPseudo;?>" title="<?=$userPseudo;?>">
                                        <img src="<?=$userPdp;?>" alt="Profil de <?=$userPseudo;?> ">
                                    </a>
                                </div>
                                <div class="textInf">
                                    <a href="watch?v=<?=$row['id']?>" title="<?=$name;?>">
                                        <h4 class="vidName<?=$row['id']?>"><?=$name;?></h4>
                                    </a>
                                    <div class="auteur">
                                        <a href="<?=$userPseudo;?>" title="<?=$userPseudo;?>">
                                            <?=$userPseudo;?>  
                                        </a>
                                        <span> • <?=$views?></span>
                                        <span class="time<?=$row['id']?>"> • Il y a </span>
                                    </div>
                                    <script>
                                        let time<?=$row['id']?> = document.querySelector('.time<?=$row['id']?>')
                                        setInterval(() => {
                                            var date1<?=$row['id']?> = <?=$getDate?>;
                                            let date<?=$row['id']?> = new Date().getTime()/1000
                                            
                                            let difference<?=$row['id']?> = date<?=$row['id']?> - date1<?=$row['id']?>;
                                            time<?=$row['id']?>.innerHTML = `• Il y a  ${formatT(difference<?=$row['id']?>)}`
                                        }, 3000);
                                        var date1<?=$row['id']?> = <?=$getDate?>;
                                        let date<?=$row['id']?> = new Date().getTime()/1000
                                        
                                        let difference<?=$row['id']?> = date<?=$row['id']?> - date1<?=$row['id']?>;
                                        time<?=$row['id']?>.innerHTML = `• Il y a  ${formatT(difference<?=$row['id']?>)}`
                                    </script>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <?php
                    } 
                }
            
            ?>
        </div>
    </div>
<script src="scripts/script.js"></script>
</body>
</html>