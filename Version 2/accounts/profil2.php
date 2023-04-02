<?php
require('../php/signupAction.php');
$urlpost2 = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$urlLength2 = strlen($urlpost2);
$indexUrlLength2 = $urlLength2 - 20;
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
$Info = $getUserreq->fetch();

$pseudo = $Info['pseudo'];
$avatar = $url2.$Info['avatar'];
if (isset($_SESSION['auth']) && $pseudo === $_SESSION['pseudo']) {
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de <?= $pseudo; ?>
    </title>
    <link rel="stylesheet" href="../accounts/style.css">
    <link rel="stylesheet" href="../styles/all/navbar.css">
    <link rel="stylesheet" href="../styles/all/font-awesome.css">
</head>

<body style="--bg:#0a0a0a">
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
            <input name="vs" type="search" class="search-data" placeholder="Chercher un profil" required/>
            <button type="submit" class="fas fa-search"> </button>
        </form>
      <div class="nav-items">
        <li><a href="../" >Accueil</a></li>
        <li><a href="../new">Créer</a></li>
        <?php
            if(isset($_SESSION['auth']) && isset($_SESSION['id'])){
                ?>
                <li><a href="#" class="active">Profil</a></li>
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
            <li><a style="--clr:#4ff321" href="../edit/<?= $_SESSION['id']; ?>"><i class="fa fa-pencil"
                        aria-hidden="true"></i> Modifier les informations du compte</a></li>
            <li><a href="../picture/<?= $_SESSION['id']; ?>"><i class="fa fa-user-circle"></i>Modifier la photo de profil</a>
            </li>
            <li><a href="../history"><i class="fa fa-history"></i> Historique</a></li>
            <li><a href="../<?= $_SESSION['pseudo']; ?>/videos"><i class="fa fa-video-camera" aria-hidden="true"></i> Mes Videos</a></li>
            <!-- <li><a><i class="fa fa-question" aria-hidden="true"></i> Aide et Support</a></li> -->
            <li><a class="modal-op" data-modal="modal2"><i class="fa fa-sign-out"></i> Se Déconnecter</a></li>
        </div>
    </div>
    <?php
    include('../modal.php');
    ?>
    <script>
        let menuToggle = document.querySelector('.menuToggle')
        let nav = document.querySelector('.nav')

        menuToggle.onclick = () => {
            nav.classList.toggle('active')
        }
    </script>
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
            <a style="--clr:#4ff321" href="../<?= $_SESSION['pseudo']; ?>/videos">
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
</body>

</html>
<?php
} elseif (isset($_SESSION['auth'])) {
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de <?= $pseudo; ?>
    </title>
    <link rel="stylesheet" href="../accounts/style.css">
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
        <input name="vs" type="search" class="search-data" placeholder="Chercher un profil" required/>
        <button type="submit" class="fas fa-search"> </button>
      </form>
      <div class="nav-items">
        <li><a href="../" >Accueil</a></li>
        <li><a href="../new">Créer</a></li>
        <?php
            if(isset($_SESSION['auth']) && isset($_SESSION['id'])){
                ?>
                <li><a href="#" class="active">Profil</a></li>
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
                <a href="../<?= $_SESSION['pseudo']; ?>/videos">
                    <i class="fa fa-video-camera" aria-hidden="true"></i>Voir Mes Créations
                </a>
            </li>
            <li><a><i class="fa fa-question" aria-hidden="true"></i> Aide et Support</a></li>
        </div>
    </div>
    <script>
        let menuToggle = document.querySelector('.menuToggle')
        let nav = document.querySelector('.nav')

        menuToggle.onclick = () => {
            nav.classList.toggle('active')
        }
    </script>
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
            <a style="--clr:#ff0" href="../<?= $_GET['name']; ?>/videos"><button name="edit">Voir ses
                    videos</button></a>
        </div>
    </div>
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de <?= $pseudo; ?>
    </title>
    <link rel="stylesheet" href="../accounts/style.css">
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
        <input name="vs" type="search" class="search-data" placeholder="Chercher un profil" required/>
        <button type="submit" class="fas fa-search"> </button>
      </form>
      <div class="nav-items">
        <li><a href="../" >Accueil</a></li>
        <li><a href="../new">Créer</a></li>
        <li><a href="../login">Connexion</a></li>
      </div>
      
    </nav>
      
    </nav>
    <script src="../scripts/navbar.js"></script>
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
            <li><a class="../active"><i class="fa fa-user"></i> Profil de <?= $pseudo; ?></a></li>
            <li><a href="../history"><i class="fa fa-history"></i>Voir Mon Historique</a></li>
            <li><a href="../login"><i class="fa fa-sign-in" aria-hidden="true"></i> Se Connecter</a></li>
            <li><a><i class="fa fa-question" aria-hidden="true"></i> Aide et Support</a></li>
        </div>
    </div>
    <script>
        let menuToggle = document.querySelector('.menuToggle')
        let nav = document.querySelector('.nav')

        menuToggle.onclick = () => {
            nav.classList.toggle('active')
        }
    </script>
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
            <a style="--clr:#ff0" href="../<?= $_GET['name']; ?>/videos"><button name="edit">Voir ses
                    videos</button></a>
        </div>
    </div>
</body>

</html>
<?php
}