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
    <link rel="stylesheet" href="Mobile/styles/style.css">
    <link rel="shortcut icon" href="scripts/controls/ico.png" type="image/x-icon">
    <link rel="stylesheet" href="styles/all/mobile_navbar.css">
</head>
<body>  
    <nav class="top-nav watch">
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
                        <input type="search" class="search-data" placeholder="Chercher" name="q" id="search" required >
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
            <li>
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
    <script src="scripts/script.js"></script>
    <div class="grid">
        <div class="watch">
            <form class="current-time" method="post">
                <input type="number" name="current" hidden>
                <input type="number" name="duration" hidden>
                <input type="text" name="video_id" id="video_id" hidden value="<?=$getid?>">
            </form>
            <div class="container">
                <div class="videoPlayer">
                    <video sizes="<?=$qality ?>" src="" poster="<?=$poster1?>" id="mainVideo"></video>
                </div>
            </div>
            <div class="aside-container">
            <div class="title" id="title">
                    <h3 class="vidName<?= $row['id'] ?>" title="<?= $name; ?>">
                        <?= $name; ?>
                    </h3>
                    <div class="vidInf">
                        <div class="avatar2">
                            <a href="<?= $usrPseudo; ?>" title="<?= $usrPseudo; ?>">
                                <img src="<?= $usrPdp; ?>" alt="">
                            </a>
                        </div>
                        <div class="textInf">
                            <a class="usrName" href="<?= $usrPseudo; ?>" title="<?= $usrPseudo; ?>">
                                <?= $usrPseudo; ?>
                            </a>
                            <span class="infos">• <?=$views?></span>
                            <span class="time<?=$getid?>"> • Il y a </span>
                        </div>
                    </div>
                </div>
                <div class="aside">
                <?php
                $fetchVideos = $bdd->query('SELECT * FROM video ORDER BY date DESC LIMIT 15');

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
                    $viewNbr1 = formatNumber($row2['vues']);
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
                            <img src="<?= $poster ?>" loading="lazy">
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
                                    <a href="<?= $userPseudo; ?>" title="<?= $userPseudo; ?>">
                                        <?= $userPseudo; ?>
                                    </a>
                                    <span>• <?=$views1?></span>
                                    <span class="time<?=$id?>"> • Il y a </span>
                                </div>
                            </div>
                            <div class="bottom">
                                <img onclick="location.replace('<?= $userPseudo; ?>')" title="<?= $userPseudo; ?>" src="<?= $userPdp; ?>">
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
    include('Mobile/scripts/controls.php');
    ?>
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
         <button type="submit" class="fas fa-search"></button>
        <div class="suggestion">
            <span class="option"></span>
        </div>
      </form>
      <div class="nav-items">
        <li><a href="./" >Accueil</a></li>
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
      
    </nav>
    <script src="scripts/script.js"></script>
    <form class="current-time" method="post">
        <input type="number" name="current" hidden>
        <input type="number" name="duration" hidden>
        <input type="text" name="video_id" id="video_id" hidden value="<?=$getid?>">
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
                            src = "" autoplay></video>
                        <?php
                        } else {
                        ?>
                        <video id="main-video" src = "" autoplay></video>
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
                            <a href="<?= $usrPseudo; ?>" title="<?= $usrPseudo; ?>">
                                <img src="<?= $usrPdp; ?>" alt="">
                            </a>
                        </div>
                        <div class="textInf">
                            <a class="usrName" href="<?= $usrPseudo; ?>" title="<?= $usrPseudo; ?>">
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
                $fetchVideos = $bdd->query('SELECT * FROM video ORDER BY date DESC LIMIT 30');

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
                            <img class="img<?= $id; ?>" loading="lazy">
                            <div class="duraion-bar" style="--w: <?=$durationwidth?>;" id="current<?= $id; ?>"></div>
                        </a>
                        <div class="vidInf">
                            <div class="avatar2">
                                <a href="<?= $userPseudo; ?>" title="<?= $userPseudo; ?>">
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
                                    <a href="<?= $userPseudo; ?>" title="<?= $userPseudo; ?>">
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
        include('scripts/controls/controls.php');
     }else{
        header('location: notfound');
     }
    }else{
        header('location: notfound');
    }
    ?>
</body>

</html>
<?php
}
?>