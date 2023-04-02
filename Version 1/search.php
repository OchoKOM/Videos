<?php
$devicecheck = is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
$devicecheckIpad = is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "ipad"));

$userSearch = $_GET['q'];
if (!isset($userSearch) && $userSearch == "") {
    header('location: ./');
}
require('php/postAction.php');
$fetchVideos = $bdd->query('SELECT * FROM video ORDER BY date DESC');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?=$userSearch;?> - Résultats OchoVid</title>
  
<link rel="shortcut icon" href="scripts/controls/ico.png" type="image/x-icon">
<link rel="stylesheet" href="styles/all/font-awesome.css">
<link rel="stylesheet" href="styles/home/style.css">
<link rel="stylesheet" href="styles/all/navbar.css">
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
            <input name="q" type="search" class="search-data" value="<?=$_GET['q']?>" placeholder="Chercher" required/>
        <button type="submit" class="fas fa-search"></button>
      </form>
        <?php
        }
        ?>
      <div class="nav-items">
        <li><a href="./" >Accueil</a></li>
        <li><a href="new">Créer</a></li>
        <?php
            if(isset($_SESSION['auth']) && isset($_SESSION['id'])){
                ?>
                <li><a href="profil/<?=$_SESSION['id'];?>">Profil</a></li>
                <li><a href="history">Historique</a></li>
                <?php                
            }else {
                ?>
                <li><a href="membres">Connexion</a></li>
                <?php
            }
            ?>
      </div>
      
    </nav>
      
    </nav>
    <script src="scripts/navbar.js"></script>
    <div class="content">
                <?php if ($fetchVideos->rowcount() == 0 && !isset($_GET['q']) && empty($_GET['q'])) {
                    header('location: ./');
                }else {
                    $getSearch = $_GET['q'];
                }
                ?>
        
       
        <?php
            if (isset($_GET['q']) AND !empty($_GET['q'])) {
                
                $fetchVideos = $bdd->query('SELECT * FROM video WHERE titre LIKE "%'.$userSearch.'%"');

                if ($fetchVideos->rowcount() == 0) {
                    ?>
                 <div class="grid" >
                <div align=center class="message">
                <h3>Aucune vidéo trouvée</h3>
                </div>
                </div>
                <?php
                
                }else{
                    if ($fetchVideos->rowcount() == 1){
                        ?><div align=center class="message" style="display:block">
                        <h3><?=$fetchVideos->rowcount()?> vidéo trouvée</h3>
                        </div><?php
                    }else {
                        ?><div align=center class="message" style="display:block">
                    <h3><?=$fetchVideos->rowcount()?> vidéos trouvées</h3>
                    </div><?php
                    }
                    ?>
                    
                    
        <div class="grid" >
                    <?php
                    while($row = $fetchVideos->fetch()){
                        $getUser = $bdd->prepare('SELECT id , pseudo , avatar FROM profil WHERE id = ?');
                        $getUser->execute(array($row['id_auteur']));
                            $getUserInf = $getUser->fetch();
                            $userId = $getUserInf['id'];
                            $userPseudo = $getUserInf['pseudo'];
                            $userPdp = $getUserInf['avatar'];
                            $name = $row['titre'];
                            $location = $row['chemin'];
                            $poster = $row['poster'];
                            $getDate = $row['date'];
                            ?>
                            <div class="links">
                        <div class="thumbNails">
                            <a href="watch?v=<?=$row['id'];?>">
                                <img src="<?=$poster;?>">
                            </a>
                            
                            <div class="vidInf">
                                <div class="avatar2">
                                    <a href="profil/<?=$userId;?>" title="<?=$userPseudo;?>">
                                        <img src="<?=$userPdp;?>" alt="">
                                    </a>
                                </div>
                                <div class="textInf">
                                    <a href="watch?v=<?=$row['id'];?>" title="<?=$name;?>">
                                        <h4 class="vidName<?=$row['id']?>"><?=$name;?></h4>
                                    </a>
                                    <div class="auteur">
                                        <a href="profil/<?=$userId;?>" title="<?=$userPseudo;?>">
                                            <?=$userPseudo;?>  
                                        </a>
                                        <p class="time<?=$row['id']?>"> • Il y a </p>
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
                                        var nom = document.querySelector(".vidName<?=$row['id'];?>").innerText;
                                        var vidName = document.querySelector(".vidName<?=$row['id'];?>")
                                        if(nom.length >= 25){
                                            nom = nom.substring(0, 24) + "...";
                                            vidName.innerText = nom;
                                        }
                                    </script>
                                </div>
                            </div>
                            
                        </div>
                        </div><?php
                        } 
                }

            }
            ?>
        </div>
</div>
</body>
</html>