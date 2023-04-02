<?php
require('../php/loginAction.php');
if (isset($_SESSION['auth']) && !isset($_COOKIE['link'])) {
    header('location: profil/' . $_SESSION['id']);
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="membres/style.css">
    <link rel="stylesheet" href="styles/all/navbar.css">
    <link rel="stylesheet" href="styles/all/font-awesome.css">
</head>

<body style="--bg:#222">
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
                <li><a href="profil/<?=$_SESSION['id']?>" >Profil</a></li>
                <li><a href="../history">Historique</a></li>
                <?php                
            }else {
                ?>
                <li><a href="#" class="active">Connexion</a></li>
                <?php
            }
            ?>
      </div>
      
    </nav>
      
    </nav>
    <script src="../scripts/navbar.js"></script>

    <?php
        if (isset($_COOKIE['users']) && !isset($_GET['auth']) ) {
            
            ?><div class="container">
            <div class="savedUsers">
                <?php
                    foreach ($_COOKIE['users'] as $id => $value) {
                        $getUser = $bdd->prepare('SELECT id , pseudo , avatar FROM profil WHERE id = ?');
                        $getUser->execute(array($value));
                        $getUserInf = $getUser->fetch();
                        $userId = $getUserInf['id'];
                        $userPseudo = $getUserInf['pseudo'];
                        $userPdp = $url.$getUserInf['avatar'];

                        if (isset($_POST['connectUsrp']) && $_POST['connectUsrp'] === $userId) {
                            // Authentifier l'utilisateur sur le site
                            $_SESSION['auth'] = true;
                            $_SESSION['id'] = $userId;
                            $_SESSION['pseudo'] = $userPseudo;
                            $_SESSION['avatar'] = $userPdp;

                            // Rédiriger vers la page de profil
                            if (isset($_COOKIE['link'])) {
                                $cookieLnk = substr($_COOKIE['link'], 0 ,(strlen($_COOKIE['link'])) - 4);
                                setcookie("link",'', time() - 3600, null, null, false, true);
                                header('location:'.$cookieLnk);
                            }else{
                                header("location: profil/".$_SESSION['id']);
                            }
                        }
                        if (isset($_POST['deleteUsrP']) && $_POST['deleteUsrP'] === $userId) {
                            // Supprimer 
                            setcookie("users[$userId]",$userId, time() - 3600, null, null, false, true);
                            header('location: login');
                        }

                        ?>
                        <form method="post">
                            <input type="submit" value="<?=$userId?>" name="connectUsrp" id="connectUsrp<?=$userId?>" hidden>
                            <input type="submit" value="<?=$userId?>" name="deleteUsrP" id="deleteUsrP<?=$userId?>" hidden>
                        </form>
                        <div class="savedPb">
                            <div class="overlay" onclick="document.getElementById('connectUsrp<?=$userId?>').click()"></div>
                            <img src="<?=$userPdp?>" alt="">
                            <div class="savedName">
                                <?=$userPseudo?>
                            </div>
                            <div class="delete" onclick="document.getElementById('deleteUsrP<?=$userId?>').click()">
                                <div class="x">
                                    <span style="--i:1;"></span>
                                    <span style="--i:-1;"></span>
                                </div>
                            </div>
                        </div>
                        <?php

                    }
                ?>
            </div>
            <div class="newUser">
                <form method="get">
                    <input type="submit" name="auth" id="newAccount" hidden value="connect" >
                </form>
                <div class="addUser" onclick="document.getElementById('newAccount').click()">
                    <div class="add">
                        <span style="--i:1;"></span>
                        <span style="--i:2;"></span>
                    </div>
                    <div>
                        Se connecter à un autre compte
                    </div>
                </div>
                <div class="addUser new">
                    <button class="submit" onclick="location.replace('signup')">
                        Créer un nouveau compte
                    </button>
                </div>
            </div>
        </div><?php
        }else {
            ?>
            <form method="post" style="--clr:#1e9bff" class="card login">
                <h2 style="--clr:#1e9bff">Connexion</h2>
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
                    <input type="text" required name="pseudo">
                    <span>Pseudo</span>
                    <i></i>
                </div>
                <div class="inputBox">
                    <input type="password" required name="mdp">
                    <span>Mot de passe</span>
                    <i></i>
                </div>
                <div class="oth">
                    <span id="a" class="a" style="--clr:#1e9bff;">
                        <input style="cursor:pointer;accent-color:#4ff321;" type="checkbox" name="rememberme" id="rememberme"> 
                        <label for="rememberme"> Se souvenir de moi </label>
                    </span>
                </div>
                <a style="--clr:#1e9bff"><button name="connecter">Se connecter</button></a>
                <span class="a" style="--clr:#4ff321">Pas encore inscri</span>
                <a href="signup" style="--clr:#4ff321">
                    <p>S'inscrire</p>
                </a>
            </form>
            <?php
        }
    ?>
</body>

</html>