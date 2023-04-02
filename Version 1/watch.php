<?php
require('php/watchAction.php');
if (($devicecheck == 1)) {
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $name; ?> - OchoVid
    </title>
    <link rel="stylesheet" href="styles/All/font-awesome.css">
    <link rel="stylesheet" href="styles/all/navbar.css">
    <link rel="stylesheet" href="Mobile/styles/style.css">
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
      <div class="cancel-icon" style="color: rgb(255, 61, 0);">
        <span class="fas fa-times"></span>
      </div>
    <form action="history" method="get">
        <input name="q" type="search" class="search-data" placeholder="Chercher" required/>
        <button type="submit" class="fas fa-search"> </button>
      </form>
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
    <div class="grid">
        <div class="watch">
            <form class="current-time" method="post">
                <input type="number" name="current" hidden>
                <input type="number" name="duration" hidden>
                <input type="text" name="video_id" hidden value="<?=$getid?>">
            </form>
            <div class="container">
                <div class="videoPlayer">
                    <video sizes="<?=$qality ?>" src="kom<?=$getid?>" poster="<?=$poster1?>" id="mainVideo"></video>
                </div>
            </div>
            <div class="aside-container">
            <div class="title" id="title">
                    <h3 class="vidName<?= $row['id'] ?>" title="<?= $name; ?>">
                        <?= $name; ?>
                    </h3>
                    <div class="vidInf">
                        <div class="avatar2">
                            <a href="profil/<?= $usrId; ?>" title="<?= $usrPseudo; ?>">
                                <img src="<?= $usrPdp; ?>" alt="">
                            </a>
                        </div>
                        <div class="textInf">
                            <a class="usrName" href="profil/<?= $usrId; ?>" title="<?= $usrPseudo; ?>">
                                <?= $usrPseudo; ?>
                            </a>
                            <span class="infos">• <?=$views?></span>
                            <span class="time<?=$getid?>"> • Il y a </span>
                        </div>
                    </div>
                </div>
                <div class="aside">
                <?php
                $fetchVideos = $bdd->query('SELECT * FROM video ORDER BY date DESC');

                while ($row2 = $fetchVideos->fetch()) {
                    $getUser = $bdd->prepare('SELECT id , pseudo , avatar FROM profil WHERE id = ?');
                    $getUser->execute(array($row2['id_auteur']));
                    if (isset($_SESSION['auth'])) {
                        $getCurrentTime = $bdd->prepare('SELECT current, video_id FROM assets WHERE video_id = ? AND watch_id = ?');
                        $getCurrentTime->execute(array($row2['id'], $_SESSION['id']));
                    }
                    $getUserInf = $getUser->fetch();
                    $userId = $getUserInf['id'];
                    $userPseudo = $getUserInf['pseudo'];
                    $userPdp = $url.$getUserInf['avatar'];
                    $id = $row2['id'];
                    $duration = $row2['duration'];
                    if (isset($getCurrentTime) && $getCurrent = $getCurrentTime->fetch()) {
                        $current = $getCurrent['current'];
                    }else {
                        $current = 0;
                    }
                    $durationwidth = (($current / $duration) * 100).'%';
                    $viewNbr1 = $row2['vues'];
                    $getDate1 = $row2['date'];
                    if ($viewNbr1 === "0") {
                        $views1 = "Aucune vue";
                    }elseif ($viewNbr1 === "1") {
                        $views1 = "1 vue";
                    }else{
                        $views1 = " ".$viewNbr1." vues "; 
                    }
                    $name2 = $row2['titre'];
                    if ($id != $getid) {
                        $poster = $url.$row2['poster'];
                        if (!empty($poster)) {
                ?>
                <div class="links" id="lnkVD<?= $id; ?>">
                    <div class="asideVid">
                        <a href="watch?v=<?= $id; ?>" title="<?= $name2; ?>">
                            <img src="<?= $poster ?>">
                            <div class="duraion-bar"style="width:<?=$durationwidth?>"></div>
                        </a>
                        <div class="vidInfos">
                            <div class="top">
                                <a href="watch?v=<?= $row2['id']; ?>" title="<?= $name2; ?>">
                                    <h4 class="vidName<?= $row2['id'] ?>">
                                        <div class="title" id="<?= $row2['id'] ?>" title="<?= $name2; ?>"><?= $name2; ?></div> 
                                    </h4>
                                </a>
                                <div class="date" title="<?= $userPseudo; ?>">
                                    <a href="profil/<?= $userId; ?>" title="<?= $userPseudo; ?>">
                                        <?= $userPseudo; ?>
                                    </a>
                                    <span>• <?=$views1?></span>
                                    <span class="time<?=$id?>"> • Il y a </span>
                                </div>
                            </div>
                            <div class="bottom">
                                <img onclick="location.replace('membres/profil/<?= $userId; ?>')" title="<?= $userPseudo; ?>" src="<?= $userPdp; ?>">
                            </div>
                            
                            <script>
                                let time<?=$id?> = document.querySelector('.time<?=$id?>')
                                setInterval(() => {
                                    var date1<?=$id?> = <?=$getDate1?>;
                                    let date<?=$id?> = new Date().getTime()/1000
                                    
                                    let difference<?=$id?> = date<?=$id?> - date1<?=$id?>;
                                    time<?=$id?>.innerHTML = `• Il y a  ${formatT(difference<?=$id?>)}`
                                }, 3000);
                                var date1<?=$id?> = <?=$getDate?>;
                                let date<?=$id?> = new Date().getTime()/1000
                                
                                let difference<?=$id?> = date<?=$id?> - date1<?=$id?>;
                                time<?=$id?>.innerHTML = `• Il y a  ${formatT(difference<?=$id?>)}`
                                
                                
                            </script>
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
        </div>

    <?php
    include('Mobile\scripts\controls.php');
    ?>
    <script src="scripts/views.js"></script>
</body>

</html>
<?php
} else {
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.5">
    <title>
        <?= $name; ?> - OchoVid
    </title>
    <link rel="shortcut icon" href="scripts/controls/ico.png" type="image/x-icon">
    <link rel="stylesheet" href="styles/all/font-awesome.css">
    <link rel="stylesheet" href="styles/view/style.css">
    <link rel="stylesheet" href="styles/all/navbar.css">
</head>
<body>          
    <?php
    if (isset($getid) && !empty($getid)) {
        if (($getid) == $row['id']) {
    ?>
    <nav>
      <div class="menu-icon">
        <span class="fas fa-bars"></span>
      </div>
      <a href="./"><div class="logo"><img src="scripts/controls/ico.png" alt="logo"> OchoKOM</div></a>
      <div class="search-icon">
        <span class="fas fa-search"></span>
      </div>
      <div class="cancel-icon" style="color: rgb(255, 61, 0);">
        <span class="fas fa-times"></span>
      </div>
    <form action="search" method="get">
        <input name="q" type="search" class="search-data" placeholder="Chercher" required/>
        <button type="submit" class="fas fa-search watch"> </button>
      </form>
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
    <form class="current-time" method="post">
        <input type="number" name="current" hidden>
        <input type="number" name="duration" hidden>
        <input type="text" name="video_id" hidden value="<?=$getid?>">
    </form>
    <div class="conta">
        <div class="grid">
            <div class="mainVideo">
                <div class="container">
                    <div id="video_player" class="video_player">
                        <?php
                        if (!empty($poster1)) {
                        ?>
                        <video sizes="<?=$qality?>" id="main-video" poster="<?= $poster1; ?>" 
                            src = "kom<?=$getid?>"></video>
                        <?php
                        } else {
                        ?>
                        <video id="main-video" src = "kom<?=$getid?>"></video>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="title">
                    <h3 class="vidName<?= $row['id'] ?>" title="<?= $name; ?>">
                        <?= $name; ?>
                    </h3>
                    <script>
                        let vidTitle = document.querySelector('.vidName<?= $row['id'] ?>')
                        vidTitle.innerText = splitText(vidTitle, 45);
                    </script>
                    <div class="vidInf">
                        <div class="avatar2">
                            <a href="profil/<?= $usrId; ?>" title="<?= $usrPseudo; ?>">
                                <img src="<?= $usrPdp; ?>" alt="">
                            </a>
                        </div>
                        <div class="textInf">
                            <a class="usrName" href="profil/<?= $usrId; ?>" title="<?= $usrPseudo; ?>">
                                <?= $usrPseudo; ?>
                            </a>
                            <span class="infos">• <?=$views?></span>
                            <span class="time<?=$getid?>"> • Il y a </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="aside">
                <?php
                $fetchVideos = $bdd->query('SELECT * FROM video ORDER BY date DESC');

                while ($row2 = $fetchVideos->fetch()) {
                    $getUser = $bdd->prepare('SELECT id , pseudo , avatar FROM profil WHERE id = ?');
                    $getUser->execute(array($row2['id_auteur']));
                    if (isset($_SESSION['auth'])) {
                        $getCurrentTime = $bdd->prepare('SELECT current, video_id FROM assets WHERE video_id = ? AND watch_id = ?');
                        $getCurrentTime->execute(array($row2['id'], $_SESSION['id']));
                    }
                    $getUserInf = $getUser->fetch();
                    $userId = $getUserInf['id'];
                    $userPseudo = $getUserInf['pseudo'];
                    $userPdp = $url.$getUserInf['avatar'];
                    $id = $row2['id'];
                    $duration = $row2['duration'];
                    if (isset($getCurrentTime) && $getCurrent = $getCurrentTime->fetch()) {
                        $current = $getCurrent['current'];
                    }else {
                        $current = 0;
                    }
                    $durationwidth = (($current / $duration) * 100).'%';
                    $viewNbr1 = $row2['vues'];
                    $getDate1 = $row2['date'];
                    if ($viewNbr1 === "0") {
                        $views1 = "Aucune vue";
                    }elseif ($viewNbr1 === "1") {
                        $views1 = "1 vue";
                    }else{
                        $views1 = " ".$viewNbr1." vues "; 
                    }
                    $name2 = $row2['titre'];
                    if ($id != $getid) {
                        $poster = $url.$row2['poster'];
                        if (!empty($poster)) {
                ?>
                <div class="links" id="lnkVD<?= $id; ?>">
                    <div align=center class="load">
                        <div class="loader">

                        </div>
                        <h4>Chargement...</h4>
                    </div>
                    <div class="asideVid">
                        <a href="watch?v=<?= $id; ?>" title="<?= $name2; ?>" style="display: flex;">
                            <img class="img<?= $id; ?>">
                            <div class="duraion-bar" style="--w: <?=$durationwidth?>;" id="current<?= $id; ?>"></div>
                        </a>
                        <div class="vidInf">
                            <div class="avatar2">
                                <a href="profil/<?= $userId; ?>" title="<?= $userPseudo; ?>">
                                    <img src="<?= $userPdp; ?>" alt="">
                                </a>
                            </div>
                            <div class="textInf">
                                <a href="watch?v=<?= $row2['id']; ?>" title="<?= $name2; ?>">
                                    <h4 class="vidName<?= $row2['id'] ?>">
                                        <?= $name2; ?>
                                    </h4>
                                </a>
                                <div class="infos">
                                    <a href="profil/<?= $userId; ?>" title="<?= $userPseudo; ?>">
                                        <?= $userPseudo; ?>
                                    </a>
                                    <span>• <?=$views1?></span>
                                    <span class="time<?=$id?>"> • Il y a </span>
                                </div>
                                
                                <script>
                                    let time<?=$id?> = document.querySelector('.time<?=$id?>')
                                    setInterval(() => {
                                        var date1<?=$id?> = <?=$getDate1?>;
                                        let date<?=$id?> = new Date().getTime()/1000
                                        
                                        let difference<?=$id?> = date<?=$id?> - date1<?=$id?>;
                                        time<?=$id?>.innerHTML = `• Il y a  ${formatT(difference<?=$id?>)}`
                                    }, 3000);
                                    var date1<?=$id?> = <?=$getDate?>;
                                    let date<?=$id?> = new Date().getTime()/1000
                                    
                                    let difference<?=$id?> = date<?=$id?> - date1<?=$id?>;
                                    time<?=$id?>.innerHTML = `• Il y a  ${formatT(difference<?=$id?>)}`
                                    var nom = document.querySelector(".vidName<?= $row2['id']; ?>").innerText;
                                    var vidName = document.querySelector(".vidName<?= $row2['id']; ?>")
                                    vidName.innerText = splitText(vidName, 21);
                                    var imglod = document.querySelector('.aside .img<?= $id; ?>');
                                    

                                    imglod.addEventListener('load', (event) => {
                                        document.getElementById("lnkVD<?= $id; ?>").classList.add('loaded')
                                    })
                                    imglod.src = "<?= $poster; ?>";
                                    imglod.src = imglod.src;

                                    var durationBar<?= $id; ?>= document.getElementById('current<?= $id; ?>')
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
    </div>
    
    <script src="scripts/controls/player.js"></script>
    <?php
        include('scripts\controls\controls.php');
     }else{
        header('location: ./');
     }
    }else{
        header('location: ./');
    }
    ?>
    <script src="scripts/views.js"></script>
</body>

</html>
<?php
}
?>