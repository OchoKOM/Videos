<?php
 
require('../php/config.php');
if (isset($_SESSION['auth']) && $_GET['p'] = $_SESSION['id']) {
} elseif (isset($_SESSION['auth']) && $_GET['p'] != $_SESSION['id']) {
    header("location: edit/" . $_SESSION['id']);
} else {
    header("location: login");
}
$id = $_GET['p'];
if (isset($id)) {
    if (isset($_POST['editc'])) {

        // Les infos rentrés par l'utilisateur
        $mdpconnect = htmlspecialchars($_POST['mdp']);

        // Vérifier si tous les champs sont bien remplis
        if (!empty($mdpconnect)) {



            // Vérifier si l'adresse email existe
            $checkIfUser = $bdd->prepare('SELECT * FROM profil WHERE id = ? ');
            $checkIfUser->execute(array($id));

            // Récupérer les données de l'utilisateur 
            $userFetchInfos = $checkIfUser->fetch();

            // Vérifier si le mot de passe est correct
            if (password_verify($mdpconnect, $userFetchInfos['mdp'])) {




                // Authentifier l'utilisateur sur le site
                $_SESSION['edit'] = "1";
                $thisId = $userFetchInfos['id'];
                $_SESSION['pseudo'] = $userFetchInfos['pseudo'];



            } else {
                $msg = "Mot de passe incorrect";
            }


        } else {
            $msg = "Ce champ est requi !";
        }

    }
    if (isset($_POST['edit'])) {


        // Les infos rentrés par l'utilisateur
        $oldPseudo = $_SESSION['pseudo'];
        $newpseudo = htmlspecialchars($_POST['pseudo']);
        $newmdp = password_hash($_POST['mdpEd'], PASSWORD_DEFAULT);
        $newmdp1 = password_hash($_POST['mdpEd1'], PASSWORD_DEFAULT);

        // Vérifier si tous les champs sont bien remplis
        if (isset($newpseudo) && $userEditInfos['pseudo'] = $oldPseudo && !empty($newpseudo)) {

            // Vérifier si le pseudo existe déjà dans la base des données
            $checkPseudo = $bdd->prepare('SELECT pseudo FROM profil WHERE pseudo = ?');
            $checkPseudo->execute(array($newpseudo));

            if ($checkPseudo->rowCount() == 0) {
                $updatePseudo = $bdd->prepare('UPDATE profil SET pseudo = ? WHERE id= ?');
                $updatePseudo->execute(array($newpseudo, $_SESSION['id']));

                $_SESSION['edit'] = "0";
                header('location: ../' . $_SESSION['pseudo']);
            } else {
                $msg = "Ce pseudo a déjà été utilisée !";
            }

        }
        if ((isset($newmdp) && !empty($newmdp)) && (isset($newmdp1) && !empty($newmdp1))) {

            if ($newmdp = $newmdp1) {
                $updateMdp = $bdd->prepare('UPDATE profil SET mdp = ? WHERE id= ?');
                $updateMdp->execute(array($newmdp, $_SESSION['id']));

                $_SESSION['edit'] = "0";
                header('location: ../' . $_SESSION['pseudo']);
            } else {
                $msg = "Les mots de passe ne correspondent pas...";
            }

        }

    }
}


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editer le profil</title>
    <link rel="stylesheet" href="../admin/style.css">
    <link rel="stylesheet" href="../styles/all/font-awesome.css">
    <?php if (($devicecheck == 1)) { ?><link rel="stylesheet" href="../styles/all/mobile_navbar.css"><?php }else{  ?><link rel="stylesheet" href="../styles/all/navbar.css"><?php } ?>
</head>
<body style="--bg:#222">
<?php if (($devicecheck == 1)) { ?>
    <nav class="top-nav">
        <ul>
            <li class="logo">
                <a href="../"><img src="../scripts/controls/ico.png" alt="logo"> OchoKOM</a>
            </li>
            <li class="search">
                <form action="../searchUser" method="get">
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
                <a class="btn-icon" href="../<?=$_SESSION['pseudo']?>" onclick="document.querySelector('.menuToggle').click()">
                    <img src="../<?=$_SESSION['avatar']?>" alt="Profil">
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
                <a href="../" class="btn-icon">
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
                <a class="btn-icon" href="../new">
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
                <a class="btn-icon" href="../<?=$_SESSION['pseudo']?>">
                    <svg class="play-icon" viewBox="0 0 48 48" >
                        <path stroke="currentColor" fill="none" d="M11.1 35.25q3.15-2 6.225-3.025Q20.4 31.2 24 31.2q3.6 0 6.7 1.025t6.25 3.025q2.2-2.7 3.125-5.45Q41 27.05 41 24q0-7.25-4.875-12.125T24 7q-7.25 0-12.125 4.875T7 24q0 3.05.95 5.8t3.15 5.45ZM24 25.5q-2.9 0-4.875-1.975T17.15 18.65q0-2.9 1.975-4.875T24 11.8q2.9 0 4.875 1.975t1.975 4.875q0 2.9-1.975 4.875T24 25.5ZM24 44q-4.2 0-7.85-1.575-3.65-1.575-6.35-4.3Q7.1 35.4 5.55 31.75 4 28.1 4 23.95q0-4.1 1.575-7.75 1.575-3.65 4.3-6.35 2.725-2.7 6.375-4.275Q19.9 4 24.05 4q4.1 0 7.75 1.575 3.65 1.575 6.35 4.275 2.7 2.7 4.275 6.35Q44 19.85 44 24q0 4.1-1.575 7.75-1.575 3.65-4.275 6.375t-6.35 4.3Q28.15 44 24 44Z" />
                    </svg>
                    <span class="btn-text">
                        Profil
                    </span>
                </a>
            </li>
            <li>
                <a class="btn-icon" href="../history">
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
                <a class="btn-icon" href="../login">
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
      <a href="../"><div class="logo"><img src="../scripts/controls/ico.png" alt="logo"> OchoKOM</div></a>
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
    <?php } ?>
    <script src="../scripts/script.js"></script>
    <?php
    if (!isset($_SESSION['edit']) || ($_SESSION['edit'] == "0")) {
    ?>
    <form method="post" style="--clr:#1e9bff" class="card">
        <h2 style="--clr:#1e9bff">Editer le profil</h2>
        <div class="oth"><span id="a" class="a" style="--clr:#4ff321">Tapez votre mot de passe pour <br> modifier vos
                informations</span></div>
        <div class="inputBox">
            <input type="password" required name="mdp">
            <span>Mot de passe</span>
            <i></i>
        </div>
        <?php
        if (isset($msg)) {
            ?>
        <div class="oth"><span id="a" class="a" style="--clr:#ff1b69">
                <?= $msg; ?>
            </span></div>
        <?php
        }
                    ?>
        <div class="oth"><span id="a" class="a" style="--clr:#1e9bff">Mot de passe oublié ?</span></div>
        <a style="--clr:#1e9bff"><button name="editc">Confirmer</button></a>
    </form>
    <?php
    } else {
        ?>
    <form method="post" style="--clr:#1e9bff" class="card">
        <h2 style="--clr:#4ff321">Editer le profil</h2>
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
            <input type="text" name="pseudo" required value="<?= $_SESSION['pseudo']; ?>">
            <span>Pseudo</span>
            <i></i>
        </div>
        <div class="inputBox">
            <input type="password" name="mdpEd" required>
            <span>Nouveau mot de passe</span>
            <i></i>
        </div>
        <div class="inputBox">
            <input type="password" name="mdpEd1" required>
            <span>Confirmer</span>
            <i></i>
        </div>
        <div class="btns">
            <a style="--clr:#1e9bff" href="../<?= $_SESSION['pseudo']; ?>">
                <p name="cancel" id="cancel">Annuler</p>
            </a>
            <a style="--clr:#4ff321"><button name="edit">Confirmer</button></a>
        </div>

    </form>
    <?php
    }

        ?>

    <script>

    </script>
</body>

</html>