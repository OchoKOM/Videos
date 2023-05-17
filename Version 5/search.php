<?php
$urlpost = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$urlLength = strlen($urlpost);
$indexUrlLength = $urlLength - 10;
$url = substr($urlpost, 0, $indexUrlLength);

$userSearch = $_GET['q'];
if (!isset($userSearch) && $userSearch == "") {
    header('location: ./');
}
require('php/config.php');
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
    <link rel="shortcut icon" href="scripts/controls/ico.png" type="image/x-icon">
    <link rel="stylesheet" href="styles/all/font-awesome.css">
    <link rel="stylesheet" href="styles/home/style.css">
    <?php if (($devicecheck == 1)) { ?><link rel="stylesheet" href="styles/all/mobile_navbar.css"><?php }else{  ?><link rel="stylesheet" href="styles/all/navbar.css"><?php } ?>
</head>
<body>
    <?php if (($devicecheck == 1)) { ?>
    <nav class="top-nav">
        <ul>
            <li class="logo">
                <a href="./"><img src="scripts/controls/ico.png" alt="logo"> OchoKOM</a>
            </li>
            <li class="search">
                <form action="search" method="get" name="q">
                    <span>
                        <svg class="search-back" viewBox="0 0 24 24">
                            <path fill="currentColor" d="m12 20-8-8 8-8 1.425 1.4-5.6 5.6H20v2H7.825l5.6 5.6Z"/>
                        </svg>
                    </span>
                    <div class="inputbox">
                        <input type="search" class="search-data" placeholder="Chercher" name="q" id="search" required value="<?=$userSearch?>">
                    </div>
                    
                    <button type="submit">
                        <svg class="play-icon" viewBox="0 0 48 48">
                            <path fill="currentColor" d="M39.8 41.95 26.65 28.8q-1.5 1.3-3.5 2.025-2 .725-4.25.725-5.4 0-9.15-3.75T6 18.75q0-5.3 3.75-9.05 3.75-3.75 9.1-3.75 5.3 0 9.025 3.75 3.725 3.75 3.725 9.05 0 2.15-.7 4.15-.7 2-2.1 3.75L42 39.75Zm-20.95-13.4q4.05 0 6.9-2.875Q28.6 22.8 28.6 18.75t-2.85-6.925Q22.9 8.95 18.85 8.95q-4.1 0-6.975 2.875T9 18.75q0 4.05 2.875 6.925t6.975 2.875Z"/>
                        </svg>
                    </button>
                </form>
            </li>
            <li>
                <label for="search" class="btn-icon search-toggle">
                    <svg viewBox="0 0 48 48" >
                        <path fill="none" d="M39.8 41.95 26.65 28.8q-1.5 1.3-3.5 2.025-2 .725-4.25.725-5.4 0-9.15-3.75T6 18.75q0-5.3 3.75-9.05 3.75-3.75 9.1-3.75 5.3 0 9.025 3.75 3.725 3.75 3.725 9.05 0 2.15-.7 4.15-.7 2-2.1 3.75L42 39.75Zm-20.95-13.4q4.05 0 6.9-2.875Q28.6 22.8 28.6 18.75t-2.85-6.925Q22.9 8.95 18.85 8.95q-4.1 0-6.975 2.875T9 18.75q0 4.05 2.875 6.925t6.975 2.875Z"/>
                    </svg>
                    <span class="btn-text">
                        Rechercher
                    </span>
                </label>
            </li>
            <li>
                <?php
                if(isset($_SESSION['auth']) && isset($_SESSION['id'])){
                    ?>
                <a class="btn-icon" href="<?=$_SESSION['pseudo']?>">
                    <img src="<?=$_SESSION['avatar']?>" alt="Profil">
                    <span class="btn-text">
                        Profil
                    </span>
                </a>
                    <?php                
                }
                    ?>
            </li>
        </ul>
        <div class="suggestion">
            <span class="option"></span>
        </div>
    </nav>
    <nav class="bottom-nav">
        <ul>
            <li>
                <a href="./" class="btn-icon">
                    <svg class="play-icon" viewBox="0 0 48 48" >
                        <path fill="none" d="M8 42V18L24 6l16 12v24H28V28h-8v14Z"/>
                    </svg>
                    <span class="btn-text">
                        Accueil
                    </span>
                </a>
            </li>
            <li class="active">
                <label for="search" class="btn-icon search-toggle">
                    <svg class="play-icon" viewBox="0 0 48 48" >
                        <path fill="none" d="M39.8 41.95 26.65 28.8q-1.5 1.3-3.5 2.025-2 .725-4.25.725-5.4 0-9.15-3.75T6 18.75q0-5.3 3.75-9.05 3.75-3.75 9.1-3.75 5.3 0 9.025 3.75 3.725 3.75 3.725 9.05 0 2.15-.7 4.15-.7 2-2.1 3.75L42 39.75Zm-20.95-13.4q4.05 0 6.9-2.875Q28.6 22.8 28.6 18.75t-2.85-6.925Q22.9 8.95 18.85 8.95q-4.1 0-6.975 2.875T9 18.75q0 4.05 2.875 6.925t6.975 2.875Z"/>
                    </svg>
                    <span class="btn-text">
                        Rechercher
                    </span>
                </label>
            </li>
            <li>
                <a class="btn-icon" href="new">
                    <svg class="play-icon" viewBox="0 0 48 48" >
                        <path fill="none" d="M22.65 34h3v-8.3H34v-3h-8.35V14h-3v8.7H14v3h8.65ZM24 44q-4.1 0-7.75-1.575-3.65-1.575-6.375-4.3-2.725-2.725-4.3-6.375Q4 28.1 4 23.95q0-4.1 1.575-7.75 1.575-3.65 4.3-6.35 2.725-2.7 6.375-4.275Q19.9 4 24.05 4q4.1 0 7.75 1.575 3.65 1.575 6.35 4.275 2.7 2.7 4.275 6.35Q44 19.85 44 24q0 4.1-1.575 7.75-1.575 3.65-4.275 6.375t-6.35 4.3Q28.15 44 24 44Zm.05-3q7.05 0 12-4.975T41 23.95q0-7.05-4.95-12T24 7q-7.05 0-12.025 4.95Q7 16.9 7 24q0 7.05 4.975 12.025Q16.95 41 24.05 41ZM24 24Z" />
                    </svg>
                    <span class="btn-text">
                        Créer
                    </span>
                </a>
            </li>
            <?php
                if(isset($_SESSION['auth']) && isset($_SESSION['id'])){
                    ?>
            <li>
                <a class="btn-icon" href="<?=$_SESSION['pseudo']?>">
                    <svg class="play-icon" viewBox="0 0 48 48" >
                        <path stroke="currentColor" fill="none" d="M11.1 35.25q3.15-2 6.225-3.025Q20.4 31.2 24 31.2q3.6 0 6.7 1.025t6.25 3.025q2.2-2.7 3.125-5.45Q41 27.05 41 24q0-7.25-4.875-12.125T24 7q-7.25 0-12.125 4.875T7 24q0 3.05.95 5.8t3.15 5.45ZM24 25.5q-2.9 0-4.875-1.975T17.15 18.65q0-2.9 1.975-4.875T24 11.8q2.9 0 4.875 1.975t1.975 4.875q0 2.9-1.975 4.875T24 25.5ZM24 44q-4.2 0-7.85-1.575-3.65-1.575-6.35-4.3Q7.1 35.4 5.55 31.75 4 28.1 4 23.95q0-4.1 1.575-7.75 1.575-3.65 4.3-6.35 2.725-2.7 6.375-4.275Q19.9 4 24.05 4q4.1 0 7.75 1.575 3.65 1.575 6.35 4.275 2.7 2.7 4.275 6.35Q44 19.85 44 24q0 4.1-1.575 7.75-1.575 3.65-4.275 6.375t-6.35 4.3Q28.15 44 24 44Z" />
                    </svg>
                    <span class="btn-text">
                        Profil
                    </span>
                </a>
            </li>
            <li>
                <a class="btn-icon" href="history">
                    <svg class="play-icon" viewBox="0 0 48 48" >
                        <path stroke="currentColor" fill="none" d="M23.85 42q-7.45 0-12.65-5.275T6 23.95h3q0 6.25 4.3 10.65T23.85 39q6.35 0 10.75-4.45t4.4-10.8q0-6.2-4.45-10.475Q30.1 9 23.85 9q-3.4 0-6.375 1.55t-5.175 4.1h5.25v3H7.1V7.25h3v5.3q2.6-3.05 6.175-4.8Q19.85 6 23.85 6q3.75 0 7.05 1.4t5.775 3.825q2.475 2.425 3.9 5.675Q42 20.15 42 23.9t-1.425 7.05q-1.425 3.3-3.9 5.75-2.475 2.45-5.775 3.875Q27.6 42 23.85 42Zm6.4-9.85-7.7-7.6v-10.7h3v9.45L32.4 30Z" />
                    </svg>
                    <span class="btn-text">
                        Historique
                    </span>
                </a>
            </li>
                    <?php                
                }else {
                    ?>
            <li>
                <a class="btn-icon" href="login">
                    <svg class="play-icon" viewBox="0 0 48 48" >
                        <path stroke="currentColor" fill="none" d="M11.1 35.25q3.15-2 6.225-3.025Q20.4 31.2 24 31.2q3.6 0 6.7 1.025t6.25 3.025q2.2-2.7 3.125-5.45Q41 27.05 41 24q0-7.25-4.875-12.125T24 7q-7.25 0-12.125 4.875T7 24q0 3.05.95 5.8t3.15 5.45ZM24 25.5q-2.9 0-4.875-1.975T17.15 18.65q0-2.9 1.975-4.875T24 11.8q2.9 0 4.875 1.975t1.975 4.875q0 2.9-1.975 4.875T24 25.5ZM24 44q-4.2 0-7.85-1.575-3.65-1.575-6.35-4.3Q7.1 35.4 5.55 31.75 4 28.1 4 23.95q0-4.1 1.575-7.75 1.575-3.65 4.3-6.35 2.725-2.7 6.375-4.275Q19.9 4 24.05 4q4.1 0 7.75 1.575 3.65 1.575 6.35 4.275 2.7 2.7 4.275 6.35Q44 19.85 44 24q0 4.1-1.575 7.75-1.575 3.65-4.275 6.375t-6.35 4.3Q28.15 44 24 44Z" />
                    </svg>
                    <span class="btn-text">
                        Connexion
                    </span>
                </a>
            </li>
                    <?php
                }
                ?>
        </ul>
    </nav>
    <?php }else{  ?>
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
            <input name="q" value="<?=$userSearch?>" type="search" class="search-data" placeholder="Chercher" required/>
            <button type="submit" class="fas fa-search"></button>
        <div class="suggestion">
            <span class="option"></span>
        </div>
        </form>
        <?php
        }
        ?>
      <div class="nav-items">
        <li><a href="./" class="active">Accueil</a></li>
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
    <script>
        let date = [];
    </script>
    <?php } ?>
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
                        ?><div align=center class="message" style="display: block;z-index: 2;position: absolute;top: 70px;;">
                        <h3><?=$fetchVideos->rowcount()?> vidéo trouvée</h3>
                        </div><?php
                    }else {
                        ?><div align=center class="message" style="display: block;z-index: 2;position: absolute;top: 70px;">
                    <h3><?=$fetchVideos->rowcount()?> vidéos trouvées</h3>
                    </div><?php
                    }
                    ?>
                    
                    
        <div class="grid search <?php if (($devicecheck == 1)) { ?>mobile<?php } ?>" >
                    <?php
                    while($row = $fetchVideos->fetch()){
                        $getUser = $bdd->prepare('SELECT id , pseudo , avatar FROM profil WHERE id = ?');
                        $getUser->execute(array($row['id_auteur']));
                            $getUserInf = $getUser->fetch();
                            $userId = $getUserInf['id'];
                            $userPseudo = $getUserInf['pseudo'];
                            $userPdp = $getUserInf['avatar'];
                            $name = $row['titre'];
                            $poster = $url.$row['poster'];
                            $viewNbr = formatNumber($row['vues']);
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
                                    <img src="<?=$poster;?>" data-thumbnail="<?=$row['id']?>" alt="Thumbnail of <?=$name;?>" onclick="location.replace('watch?v=<?=$row['id']?>')">
                                    <video autoplay></video>
                                </div>
                                <div class="buttons">
                                    <button title="Lire" class="active" data-time="Lire">
                                        <svg class="play-icon" viewBox="0 0 24 24" style="width: 20px;height: 20px;">
                                            <path fill="currentColor" d="M8,5.14V19.14L19,12.14L8,5.14Z" />
                                        </svg>
                                    </button>
                                    <button title="Son" class="sound">
                                        <svg class="volume-high-icon" viewBox="0 0 48 48" style="display:none;">
                                            <path fill="currentColor" d="M28 41.45v-3.1q4.85-1.4 7.925-5.375T39 23.95q0-5.05-3.05-9.05-3.05-4-7.95-5.35v-3.1q6.2 1.4 10.1 6.275Q42 17.6 42 23.95t-3.9 11.225Q34.2 40.05 28 41.45ZM6 30V18h8L24 8v32L14 30Zm21 2.4V15.55q2.75.85 4.375 3.2T33 24q0 2.85-1.65 5.2T27 32.4Zm-6-16.8L15.35 21H9v6h6.35L21 32.45ZM16.3 24Z"/>
                                        </svg> 
                                        <svg class="volume-muted-icon" viewBox="0 0 45 45">
                                            <path fill="currentColor" d="m40.65 45.2-6.6-6.6q-1.4 1-3.025 1.725-1.625.725-3.375 1.125v-3.1q1.15-.35 2.225-.775 1.075-.425 2.025-1.125l-8.25-8.3V40l-10-10h-8V18h7.8l-11-11L4.6 4.85 42.8 43Zm-1.8-11.6-2.15-2.15q1-1.7 1.475-3.6.475-1.9.475-3.9 0-5.15-3-9.225-3-4.075-8-5.175v-3.1q6.2 1.4 10.1 6.275 3.9 4.875 3.9 11.225 0 2.55-.7 5t-2.1 4.65Zm-6.7-6.7-4.5-4.5v-6.5Q30 17 31.325 19.2q1.325 2.2 1.325 4.8 0 .75-.125 1.475-.125.725-.375 1.425Zm-8.5-8.5-5.2-5.2 5.2-5.2Zm-3 14.3v-7.5l-4.2-4.2h-7.8v6h6.3Zm-2.1-9.6Z"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress"></div>
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
                                        <span class="time"> • Il y a </span>
                                    </div>
                                    <script>
                                        date.push(<?=$getDate?>)
                                    </script>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <?php
                    } 
                }

            }
            ?>
        </div>
    </div>
    <script src="scripts/main.js"></script>
    <script>
        times(date);
        let autoplay = true
    </script>
    <script src="scripts/script.js"></script>
</body>
</html>