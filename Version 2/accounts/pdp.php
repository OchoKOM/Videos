<?php
require('../php/signupAction.php');
require('../php/security.php');
$avatar = 'http://' . $_SERVER['HTTP_HOST'].'/'  .$_SESSION['avatar'];
$pseudo = $_SESSION['pseudo'];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo de profil</title>
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
        <input name="vs" type="search" class="search-data" placeholder="Chercher un profil" required />
        <button type="submit" class="fas fa-search"> </button>
    </form>
      <div class="nav-items">
        <li><a href="../" >Accueil</a></li>
        <li><a href="../new">Créer</a></li>
        <?php
            if(isset($_SESSION['auth']) && isset($_SESSION['id'])){
                ?>
                <li><a href="../<?=$_SESSION['pseudo']?>" class="active">Profil</a></li>
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
                <?= $pseudo; ?>
            </p>
        </div>
        <div class="menuToggle"></div>
        <div class="menu">
            <li><a href="../profil/<?= $_SESSION['id']; ?>"><i class="fa fa-user"></i> Profil</a></li>
            <li><a href="pdp?p=<?= $_SESSION['id']; ?>" class="active"><i class="fa fa-user-circle"></i>Modifier la
                    photo</a></li>
            <li><a href="../history"><i class="fa fa-history    "></i> Historique</a></li>
            <li><a><i class="fa fa-video-camera" aria-hidden="true"></i> Mes Créations</a></li>
            <li><a><i class="fa fa-question" aria-hidden="true"></i> Aide et Support</a></li>
            <li><a class="logout"><i class="fa fa-sign-out" aria-hidden="true"></i> Se Déconnecter</a></li>
        </div>
    </div>
    <script>
        let menuToggle = document.querySelector('.menuToggle')
        let nav = document.querySelector('.nav')
        let logout = document.querySelector('.logout')


        logout.onclick = () => {
            location.replace('../php/logout')
        }
        menuToggle.onclick = () => {
            nav.classList.toggle('active')
        }
    </script>
    <form method="post" enctype="multipart/form-data" class="card" style="--clr:#1e9bff">
        <h2 style="--clr:#1e9bff">Photo de profil</h2>
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
            <input id="input" name="img" type="file" accept="image/*" hidden>
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
        <div class="btns">
            <a style="--clr:#1e9bff"><button name="cancel">Annuler</button></a>
            <a style="--clr:#4ff321"><button name="profil">Choisir</button></a>
        </div>
    </form>
    <script>
        const img = document.getElementById('img')
        const input = document.getElementById('input')
        const camera = document.querySelector('.choose')
        const cacel = document.querySelector('.cancel')
        const confirms = document.querySelector('.confirms')

        var userImg = img.src
        img.onclick = () => {
            input.click()
        }
        camera.onclick = () => {
            input.click()
        }
        cacel.onclick = () => {
            img.src = userImg
            input.value = ""
            confirms.classList.remove('active')
            cacel.style.visibility = "hidden"
        }
        input.onchange = () => {
            img.src = URL.createObjectURL(input.files[0]);
            confirms.classList.add('active')
            cacel.style.visibility = "visible"
        }
    </script>
</body>

</html>