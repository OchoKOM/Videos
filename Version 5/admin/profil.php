<?php
ob_start();
require('../php/signupAction.php');
$urlpost2 = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$urlLength2 = strlen($urlpost2);
$indexUrlLength2 = $urlLength2 - 16;
$url2 = substr($urlpost2, 0, $indexUrlLength2);
// Récupérer les informations de l'utilisateur 
$getUsereq = $bdd->query('SELECT * FROM profil');
$getUsereq->fetch();
if ($getUsereq->rowcount() == 0) {
    $_SESSION = [];
    session_destroy();
    header('location: login');
} else {
    $getUserreq = $bdd->prepare('SELECT * FROM profil WHERE  pseudo = ?');
    $getUserreq->execute(array($_GET['name']));
}
    ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    if ( $getUserreq->rowcount() == 0) {
        if ($_GET['name'] === "videonotfound") {
            ?>
    <title>Video Not Found</title>
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: sans-serif;
      }
      #error-page {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        min-height: 100vh;
        overflow: hidden;
      }
      #error-page #error-page .content {
        max-width: 600px;
        text-align: center;
      }
      #error-page .content h2.header {
        font-size: 18vw;
        line-height: 1em;
        position: relative;
        background: transparent;
        border-bottom: none;
        display: block;
        height: 100%;
      }
      #error-page .content h2.header:after {
        position: absolute;
        content: attr(data-text);
        top: 0;
        left: 0;
        right: 0;
        background: -webkit-repeating-linear-gradient(
          -45deg,
          #71b7e6,
          #69a6ce,
          #b98acc,
          #ee8176,
          #b98acc,
          #69a6ce,
          #9b59b6
        );
        background-size: 400%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.25);
        animation: animate 10s ease-in-out infinite;
      }
      @keyframes animate {
        0% {
          background-position: 0 0;
        }
        25% {
          background-position: 100% 0;
        }
        50% {
          background-position: 100% 100%;
        }
        75% {
          background-position: 0% 100%;
        }
        100% {
          background-position: 0% 0%;
        }
      }
      #error-page .content h4 {
        font-size: 1.5em;
        margin-bottom: 20px;
        text-transform: uppercase;
        color: #000;
        font-size: 2em;
        position: relative;
      }
      #error-page .content h4:after {
        position: absolute;
        content: attr(data-text);
        top: 0;
        left: 0;
        right: 0;
        text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
      }
      #error-page .content p {
        font-size: 1.2em;
        color: #0d0d0d;
      }
      #error-page .content .btns {
        margin: 25px 0;
        display: inline-flex;
      }
      #error-page .content .btns a {
        display: inline-block;
        margin: 0 10px;
        text-decoration: none;
        border: 2px solid #69a6ce;
        color: #69a6ce;
        font-weight: 500;
        padding: 10px 25px;
        border-radius: 25px;
        text-transform: uppercase;
        transition: all 0.3s ease;
      }
      #error-page .content .btns a:hover {
        background: #69a6ce;
        color: #fff;
      }
    </style>
  </head>
  <body>
    <div id="error-page">
      <div class="content">
        <h2 class="header" data-text="404">404</h2>
        <h4 data-text="Opps! Video not found">Opps! Video not found</h4>
        <p>
          Sorry, the video you are looking for does not exist. If you think
          something is broken, report a problem.
        </p>
        <div class="btns">
            <a href="./" target="_blank">search your video</a>
        </div>
      </div>
    </div>
  </body>
</html>
            <?php
            exit();
        }
    ?>
    <title>Impossible d'ouvrir le lien</title>
    <link rel="shortcut icon" href="ico.png" type="image/x-icon">
    <link rel="stylesheet" href="styles/all/font-awesome.css">
    <?php if (($devicecheck == 1)) { ?><link rel="stylesheet" href="styles/all/mobile_navbar.css"><?php }else{  ?><link rel="stylesheet" href="styles/all/navbar.css"><?php } ?>
    <link rel="stylesheet" href="styles/home/style.css">
    <?php
    }else {
        $Info = $getUserreq->fetch();
        $pseudo = $Info['pseudo'];
        $avatar = $url2.$Info['avatar'];
    ?>
    <title>Profil de <?= $pseudo; ?></title>
    <link rel="shortcut icon" href="ico.png" type="image/x-icon">
    <link rel="stylesheet" href="admin/style.css">
    <?php if (($devicecheck == 1)) { ?><link rel="stylesheet" href="styles/all/mobile_navbar.css"><?php }else{  ?><link rel="stylesheet" href="styles/all/navbar.css"><?php } ?>
    <link rel="stylesheet" href="styles/all/font-awesome.css">
    <?php
    }?>
</head>
<body style="--bg:#000">
<?php if (($devicecheck == 1)) { ?>
    <nav class="top-nav">
        <ul>
            <li class="logo">
                <a href="./"><img src="scripts/controls/ico.png" alt="logo"> OchoKOM</a>
            </li>
            <li class="search">
                <form action="searchUser" method="get">
                    <span>
                        <svg class="search-back" viewBox="0 0 24 24">
                            <path fill="currentColor" d="m12 20-8-8 8-8 1.425 1.4-5.6 5.6H20v2H7.825l5.6 5.6Z"/>
                        </svg>
                    </span>
                    <div class="inputbox">
                        <input type="search" class="search-data" placeholder="Chercher un profil" name="vs" id="search" required>
                    </div>
                    <button>
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
                <a class="btn-icon" href="#" onclick="document.querySelector('.menuToggle').click()">
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
            <li class="active">
                <a class="btn-icon" href="#">
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
            <li  class="active">
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
        <form action="searchUser" method="get">
        <input name="vs" type="search" class="search-data" placeholder="Chercher" required/>
        <button type="submit" class="fas fa-search"></button>
        <div class="suggestion">
            <span class="option"></span>
        </div>
      </form>
      <div class="nav-items">
        <li><a href="./">Accueil</a></li>
        <li><a href="new">Créer</a></li>
        <?php
            if(isset($_SESSION['auth']) && isset($_SESSION['id'])){
                ?>
                <li><a href="<?=$_SESSION['pseudo'];?>" class="active">Profil</a></li>
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
    <?php
    if ( $getUserreq->rowcount() == 0) {
        $getUserreq = $bdd->prepare('SELECT * FROM profil WHERE  id = ?');
        $getUserreq->execute(array($_SESSION['id']));
        if ($getUserreq->rowcount() == 0) {
            $_SESSION = [];
            session_destroy();
            header('location: login');
        }
    ?>
    <div class="content">
        <div class="grid" >
                <div align=center class="message">
                <h3>Lien introuvable sur le serveur :(
                    <button onclick="location.replace('./')" class="btn btn-warning" id="mod">Cliquez Ici</button> pour revenir à l'accueil
                </h3>
                </div>
        </div>
    </div>
    <?php
    }else {
    if (isset($_SESSION['auth']) && $pseudo === $_SESSION['pseudo']) {
    ?>
    <div class="nav">
        <div class="userBx">
            <div class="imgBx">
                <img src="<?= $avatar; ?>" alt="">
            </div>
            <p class="userName">
                @<?= $pseudo; ?>
            </p>
        </div>
        <div class="menuToggle"></div>
        <div class="menu">
            <li><a class="active"><i class="fa fa-user"></i> Profil</a></li>
            <li><a style="--clr:#4ff321" href="./edit/<?= $_SESSION['id']; ?>"><i class="fa fa-pencil"
                        aria-hidden="true"></i> Modifier les informations du compte</a></li>
            <li><a href="./picture/<?= $_SESSION['id']; ?>"><i class="fa fa-user-circle"></i>Modifier la photo de profil</a>
            </li>
            <li><a href="./history"><i class="fa fa-history"></i> Historique</a></li>
            <li><a href="./<?= $_SESSION['pseudo']; ?>/videos"><i class="fa fa-video-camera" aria-hidden="true"></i> Mes Videos</a></li>
            <!-- <li><a><i class="fa fa-question" aria-hidden="true"></i> Aide et Support</a></li> -->
            <li><a class="modal-op" data-modal="modal2"><i class="fa fa-sign-out"></i> Se Déconnecter</a></li>
        </div>
    </div>
    <?php
    include('../modal.php');
    ?>
    <div class="card" style="--clr:#1e9bff">
        <h2 style="--clr:#1e9bff">@<?= $pseudo; ?></h2>
        <?php
    if (isset($msg)) {
        ?>
        <div class="oth"><span id="a" class="a" style="--clr:#ff1b69">
                <?= $msg; ?>
            </span></div>
        <?php
    }
        ?>
        <div class="inputBox">
            <img class="img" id="img" src="<?= $avatar; ?>" alt="">
            <div class="confirms">
                <div class="conf-btns cancel" title="Annuler">
                    <svg viewBox="0 0 48 48">
                        <path fill="#f00"
                            d="m16.5 33.6 7.5-7.5 7.5 7.5 2.1-2.1-7.5-7.5 7.5-7.5-2.1-2.1-7.5 7.5-7.5-7.5-2.1 2.1 7.5 7.5-7.5 7.5ZM24 44q-4.1 0-7.75-1.575-3.65-1.575-6.375-4.3-2.725-2.725-4.3-6.375Q4 28.1 4 24q0-4.15 1.575-7.8 1.575-3.65 4.3-6.35 2.725-2.7 6.375-4.275Q19.9 4 24 4q4.15 0 7.8 1.575 3.65 1.575 6.35 4.275 2.7 2.7 4.275 6.35Q44 19.85 44 24q0 4.1-1.575 7.75-1.575 3.65-4.275 6.375t-6.35 4.3Q28.15 44 24 44Zm0-3q7.1 0 12.05-4.975Q41 31.05 41 24q0-7.1-4.95-12.05Q31.1 7 24 7q-7.05 0-12.025 4.95Q7 16.9 7 24q0 7.05 4.975 12.025Q16.95 41 24 41Zm0-17Z">
                    </svg>
                </div>
                <div class="conf-btns choose">
                    <svg viewBox="0 0 48 48">
                        <path fill="#fff"
                            d="M24 34.7q3.6 0 6.05-2.45 2.45-2.45 2.45-6.1 0-3.6-2.45-6.025Q27.6 17.7 24 17.7q-3.65 0-6.075 2.425Q15.5 22.55 15.5 26.15q0 3.65 2.425 6.1Q20.35 34.7 24 34.7Zm0-3q-2.4 0-3.95-1.575-1.55-1.575-1.55-3.975 0-2.35 1.55-3.9Q21.6 20.7 24 20.7q2.35 0 3.925 1.55 1.575 1.55 1.575 3.9 0 2.4-1.575 3.975Q26.35 31.7 24 31.7ZM7 42q-1.2 0-2.1-.9Q4 40.2 4 39V13.35q0-1.15.9-2.075.9-.925 2.1-.925h7.35L18 6h12l3.65 4.35H41q1.15 0 2.075.925Q44 12.2 44 13.35V39q0 1.2-.925 2.1-.925.9-2.075.9Zm34-3V13.35h-8.75L28.6 9h-9.2l-3.65 4.35H7V39ZM24 26.2Z">
                    </svg>
                </div>
            </div>

        </div>
        <div class="btns ed">
            <a style="--clr:#4ff321" href="./<?= $_SESSION['pseudo']; ?>/videos">
                <p>Mes Videos</p>
            </a>
        </div>
    </div>
    <script>
        const img = document.getElementById('img')
        const camera = document.querySelector('.choose')
        camera.onclick = () => {
            location.replace('../picture/<?= $_SESSION['id']; ?>')
        }
        img.onclick = () => {
            location.replace('../picture/<?= $_SESSION['id']; ?>')
        }
    </script>
<?php
} elseif (isset($_SESSION['auth'])) {
?>
    <div class="nav">
        <div class="userBx">
            <div class="imgBx">
                <img src="<?= $avatar; ?>" alt="">
            </div>
            <p class="userName">
                @<?= $pseudo; ?>
            </p>
        </div>
        <div class="menuToggle"></div>
        <div class="menu">
            <li><a class="active"><i class="fa fa-user"></i> Profil de <?= $pseudo; ?></a></li>
            <li><a href="<?= $_SESSION['pseudo']; ?>"><i class="fa fa-user-circle"></i>Voir mon profil</a></li>
            <li><a href="history"><i class="fa fa-history"></i>Voir Mon Historique</a></li>
            <li>
                <a href="./<?= $_SESSION['pseudo']; ?>/videos">
                    <i class="fa fa-video-camera" aria-hidden="true"></i>Voir Mes Créations
                </a>
            </li>
            <li><a><i class="fa fa-question" aria-hidden="true"></i> Aide et Support</a></li>
        </div>
    </div>
    <div class="card" style="--clr:#1e9bff">
        <h2 style="--clr:#1e9bff">Profil de <?= $pseudo; ?>
        </h2>
        <?php
    if (isset($msg)) {
        ?>
        <div class="oth"><span id="a" class="a" style="--clr:#ff1b69">
                <?=$msg;?>
            </span></div>
        <?php
    }
        ?>
        <div class="inputBox">
            <img class="img" id="img" src="<?= $avatar; ?>" alt="">
        </div>
        <div class="btns ed">
            <a style="--clr:#ff0" href="./<?= $_GET['name']; ?>/videos"><button name="edit">Voir ses videos</button></a>
        </div>
    </div>
<?php
} else {
?>
    <div class="nav">
        <div class="userBx">
            <div class="imgBx">
                <img src="<?= $avatar; ?>" alt="">
            </div>
            <p class="userName">
                @<?= $pseudo; ?>
            </p>
        </div>
        <div class="menuToggle"></div>
        <div class="menu">
            <li><a class="./active"><i class="fa fa-user"></i> Profil de <?= $pseudo; ?></a></li>
            <li><a href="./history"><i class="fa fa-history"></i>Voir Mon Historique</a></li>
            <li><a href="./login"><i class="fa fa-sign-in" aria-hidden="true"></i> Se Connecter</a></li>
            <li><a><i class="fa fa-question" aria-hidden="true"></i> Aide et Support</a></li>
        </div>
    </div>
    <div class="card" style="--clr:#1e9bff">
        <h2 style="--clr:#1e9bff">Profil de @<?= $pseudo; ?>
        </h2>
        <?php
    if (isset($msg)) {
        ?>
        <div class="oth"><span id="a" class="a" style="--clr:#ff1b69">
                <?= $msg; ?>
            </span></div>
        <?php
    }
        ?>
        <div class="inputBox">
            <img class="img" id="img" src="<?= $avatar; ?>" alt="">
        </div>
        <div class="btns ed">
            <a style="--clr:#ff0" href="./<?= $_GET['name']; ?>/videos"><button name="edit">Voir ses  videos</button></a>
        </div>
    </div>
<?php
}
}
ob_end_flush();?>
<script>
    let menuToggle = document.querySelector('.menuToggle')
    let nav = document.querySelector('.nav')

    menuToggle.onclick = () => {
        nav.classList.toggle('active')
    }
</script>
</body>
</html>