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
                header('location: ../profil/' . $_SESSION['id']);
            } else {
                $msg = "Ce pseudo a déjà été utilisée !";
            }

        }
        if ((isset($newmdp) && !empty($newmdp)) && (isset($newmdp1) && !empty($newmdp1))) {

            if ($newmdp = $newmdp1) {
                $updateMdp = $bdd->prepare('UPDATE profil SET mdp = ? WHERE id= ?');
                $updateMdp->execute(array($newmdp, $_SESSION['id']));

                $_SESSION['edit'] = "0";
                header('location: ../profil/' . $_SESSION['id']);
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
    <link rel="stylesheet" href="../membres/style.css">
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
    <form action="search" method="get">
        <input name="q" type="search" class="search-data" placeholder="Chercher" required/>
        <button type="submit" class="fas fa-search"> </button>
      </form>
      <div class="nav-items">
        <li><a href="../" >Accueil</a></li>
        <li><a href="../new">Créer</a></li>
        <?php
            if(isset($_SESSION['auth']) && isset($_SESSION['id'])){
                ?>
                <li><a href="../profil/<?=$_SESSION['id']?>" class="active">Profil</a></li>
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
            <a style="--clr:#1e9bff" href="profil/<?= $_SESSION['id']; ?>">
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