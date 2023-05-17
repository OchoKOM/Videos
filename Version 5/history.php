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
    <?php if (($devicecheck == 1)) { ?><link rel="stylesheet" href="styles/all/mobile_navbar.css"><?php }else{  ?><link rel="stylesheet" href="styles/all/navbar.css"><?php } ?>
    <link rel="stylesheet" href="styles/All/font-awesome.css">
    <link rel="shortcut icon" href="scripts/controls/ico.png" type="image/x-icon">
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
                        <input type="search" class="search-data" placeholder="Chercher" name="q" id="search" required>
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
            <li >
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
            <li class="active">
                <a class="btn-icon" href="#">
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
        <form action="search" method="get">
            <input name="q" type="search" class="search-data" placeholder="Chercher" required/>
            <button type="submit" class="fas fa-search"></button>
        <div class="suggestion">
            <span class="option"></span>
        </div>
        </form>
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
    <?php } ?>
    <script src="scripts/script.js"></script>
    <script>
        let date = [];
    </script>
    <div class="profileBx">
        <a href="<?= $_SESSION['pseudo']; ?>"><img class="profileImg" src="<?= $avatar; ?>" alt=""></a>
        
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
                            <p class="time">• Vu il y a </p>
                        </div>
                        
                    </div>
                    <div class="bottom">
                        <img onclick="location.replace('<?= $pseudo; ?>')" src="<?= $avatar; ?>">
                    </div>
                    <script>
                        date.push(<?=$watchDate?>)
                    </script>
                </div>
            </div>
        </div>
        
        <?php

        }
            ?>
        </div>
    </div>
    <script src="scripts/main.js"></script>
    <script>
        times(date);
    </script>
</body>

</html>