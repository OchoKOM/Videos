<?php

require('../php/config.php');
if (isset($_SESSION['auth']) && $_GET['name'] == $_SESSION['pseudo']) {
} elseif (isset($_SESSION['auth']) && $_GET['name'] != $_SESSION['pseudo']) {
    header("location: ../" . $_SESSION['pseudo']. "/settings");
    exit();
} else {
    header("location: login");
    exit();
}
$id = $_SESSION['id'];
$avatar = '../' . $_SESSION['avatar'];

if (isset($_POST['changePic'])) {
    $imgName = $_FILES['img']['name'];
    $imgSize = $_FILES['img']['size'];

    if (!empty($imgName)) {

        $tailleMax = 10485760;
        $extentionsValides = array('jpg', 'jpeg', 'png', 'gif', 'webp');
        $extentionUpload = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));

        if ($imgSize < $tailleMax) {
            if (in_array($extentionUpload, $extentionsValides)) {

                // todo: Déplacer l'image dans le dossier img
                if(!is_dir("img/")){
                    mkdir("img/");
                }
                $chemin = "img/" . $_SESSION['id'] . '_' . generateRandomString(5) . "." . $extentionUpload;
                $deplacer = move_uploaded_file($_FILES['img']['tmp_name'], $chemin);

                if ($deplacer) {

                    @unlink($avatar);

                    //! Insérer les informations dans la base des données
                    $updateAvatar = $bdd->prepare('UPDATE profil SET avatar= ? WHERE id= ?');
                    $updateAvatar->execute(array('admin/' . $chemin, $_SESSION['id']));

                    //? Récupérer les informations de l'utilisateur 
                    $getInfosOfUserreq = $bdd->prepare('SELECT * FROM profil WHERE  id = ? ');
                    $getInfosOfUserreq->execute(array($_SESSION['id']));
                    $userInfos = $getInfosOfUserreq->fetch();
                    $_SESSION['avatar'] = $userInfos['avatar'];
                    $avatar = "../" . $userInfos['avatar'];
                    $success = "Avatar modifié avec success";
                } else {
                    $msg = "Erreur durant l'importation de l'image";
                }
            } else {
                $msg = "Votre photo de profil dois être au format jpg, jpeg, png, gif ou webp ! ";
            }
        } else {
            $msg = "Votre photo de profil ne dois pas dépasser 10Mo! ";
        }
    } else {
        $msg = "Aucune photo choisie";
    }
}
if (isset($_POST['deletePic'])) {

    $currentAvatar = '../' . $_SESSION['avatar'];
    if ($_SESSION['avatar'] != "admin/noprofil.jpg") {
        @unlink($currentAvatar);
        $deleteAvatar = $bdd->prepare('UPDATE profil SET avatar= ? WHERE id= ?');
        $deleteAvatar->execute(array("admin/noprofil.jpg", $_SESSION['id']));
        $_SESSION['avatar'] = "admin/noprofil.jpg";
        $avatar = "../" . $_SESSION['avatar'];
        $success = "Avatar effacé avec success";
    }
}
if (isset($_POST['editc'])) {

    // Les infos rentrés par l'utilisateur
    $mdpconnect = htmlspecialchars($_POST['oldpwd']);

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
            $_SESSION['edit'] = true;
            $thisId = $userFetchInfos['id'];
            $_SESSION['pseudo'] = $userFetchInfos['pseudo'];
        } else {
            $msg = "Mot de passe incorrect";
        }
    } else {
        $msg = "Confirmez votre ancien mot de passe";
    }
}
if (isset($_POST['name_edit'])) {

    // Les infos rentrés par l'utilisateur
    $oldPseudo = $_SESSION['pseudo'];
    $newpseudo = htmlspecialchars($_POST['pseudo']);

    // Vérifier si tous les champs sont bien remplis
    if (isset($newpseudo) && $userEditInfos['pseudo'] = $oldPseudo && !empty($newpseudo)) {

        // Vérifier si le pseudo existe déjà dans la base des données
        $checkPseudo = $bdd->prepare('SELECT pseudo FROM profil WHERE pseudo = ?');
        $checkPseudo->execute(array($newpseudo));

        if ($checkPseudo->rowCount() == 0) {
            $updatePseudo = $bdd->prepare('UPDATE profil SET pseudo = ? WHERE id= ?');
            $updatePseudo->execute(array($newpseudo, $_SESSION['id']));

            $success = "Pseudo modifié avec success";
            $_SESSION['pseudo'] = $newpseudo;
            $_SESSION['edit'] = false;
        } else {
            $msg = "Ce pseudo a déjà été utilisée !";
        }
    }
}
if (isset($_POST['pwd_edit'])) {
    $newmdp = password_hash($_POST['mdpEd'], PASSWORD_DEFAULT);
    if (isset($newmdp) && !empty($newmdp)) {
        if (isset($_SESSION['edit']) && $_SESSION['edit'] == true) {
            $updateMdp = $bdd->prepare('UPDATE profil SET mdp = ? WHERE id= ?');
            $updateMdp->execute(array($newmdp, $_SESSION['id']));

            $success = "Mot de passe modifié avec success";
            $_SESSION['edit'] = false;
        } else {
            $msg = "Confirmez d'abord votre ancien mot de passe";
        }
    }
}


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Options</title>
    <link rel="shortcut icon" href="../ico.svg" type="image/x-icon">
    <link rel="stylesheet" href="../admin/edit.css" />
    <?php if (($devicecheck == 1)) { ?>
        <link rel="stylesheet" href="../styles/all/mobile_navbar.css">
    <?php } else {  ?>
        <link rel="stylesheet" href="../styles/all/navbar.css">
    <?php } ?>
</head>

<body>
    <?php if (($devicecheck != 1)) { ?>
        <nav>
            <div class="topbar">
                <ul>
                    <li class="logo">
                        <a href="../">
                            <span class="text">OchoKOM</span>
                        </a>
                    </li>
                    <li class="searchBox">
                        <form method="get" action="../search">
                            <input type="search" name="q" id="searchInput" required placeholder="Rehercher">
                            <button type="submit">
                                <svg class="ionicon" viewBox="0 0 512 512" style="height: 1em;">
                                    <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32" />
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448" />
                                </svg>
                            </button>
                        </form>
                        <ul class="suggestion"></ul>
                    </li>
                    <li class="search-toggle">
                        <label for="search-toggle">
                            <svg class="ionicon" viewBox="0 0 512 512" style="height: 1em;">
                                <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32" />
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448" />
                            </svg>
                        </label>
                        <input hidden type="radio" name="toggle" id="search-toggle">
                    </li>
                    <li>
                        <?php
                        include('../php/loginAction.php');
                        if (isset($msg)) {
                        ?>
                            <input hidden type="radio" name="toggle" id="initial-toggle">
                            <input hidden type="radio" name="toggle" id="login-toggle" checked>
                        <?php
                        } else {
                        ?>
                            <input hidden type="radio" name="toggle" id="initial-toggle" checked>
                            <input hidden type="radio" name="toggle" id="login-toggle">
                        <?php
                        }
                        ?>
                        <?php
                        if (isset($_SESSION['auth']) && isset($_SESSION['id'])) {
                        ?>
                            <a href="../new">
                                <span class="icon">
                                    <svg class="ionicon" viewBox="0 0 512 512" style="height: 1em;">
                                        <path d="M448 256c0-106-86-192-192-192S64 150 64 256s86 192 192 192 192-86 192-192z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32" />
                                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 176v160M336 256H176" />
                                    </svg>
                                </span>
                            </a>
                            <label class="imgBx edit" for="user-menu">
                                <?php if ($_SESSION['avatar'] != "admin/noprofil.jpg") { ?>
                                    <img src="../<?= $_SESSION['avatar'] ?>" alt="Profile">
                                <?php } ?>
                            </label>
                            <input hidden type="radio" name="toggle" id="user-menu">
                            <ul class="user-menu">
                                <label for="initial-toggle">&times;</label></h2>
                                <li>
                                    <a href="../<?= $_SESSION['pseudo'] ?>">
                                        <span class="icon">
                                            <svg class="ionicon" viewBox="0 0 512 512" style="height: 1em;">
                                                <path d="M344 144c-3.92 52.87-44 96-88 96s-84.15-43.12-88-96c-4-55 35-96 88-96s92 42 88 96z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" />
                                                <path d="M256 304c-87 0-175.3 48-191.64 138.6C62.39 453.52 68.57 464 80 464h352c11.44 0 17.62-10.48 15.65-21.4C431.3 352 343 304 256 304z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32" />
                                            </svg>
                                        </span>
                                        <span class="text">Profil</span>
                                    </a>
                                </li>
                                <!-- <li>
                            <a href="#">
                                <span class="icon">
                                    <div class="imgBx"></div>
                                </span>
                                <span class="text">Ocho Uchiha</span>
                            </a>
                        </li> -->
                                <li>
                                    <a href="../logout">
                                        <span class="icon">
                                            <svg class="ionicon" viewBox="0 0 512 512" style="height: 1em;">
                                                <path d="M304 336v40a40 40 0 01-40 40H104a40 40 0 01-40-40V136a40 40 0 0140-40h152c22.09 0 48 17.91 48 40v40M368 336l80-80-80-80M176 256h256" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" />
                                            </svg>
                                        </span>
                                        <span class="text">Deconnexion</span>
                                    </a>
                                </li>
                            </ul>
                        <?php
                        } else {
                        ?>
                            <label for="login-toggle">
                                <span class="icon">
                                    <svg class="ionicon" viewBox="0 0 512 512" style="height: 1em;">
                                        <path d="M448 256c0-106-86-192-192-192S64 150 64 256s86 192 192 192 192-86 192-192z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32" />
                                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 176v160M336 256H176" />
                                    </svg>
                                </span>
                            </label>
                            <label for="login-toggle" class="connect">
                                Connexion
                            </label>

                            <form method="post" class="login-menu" action="">
                                <h2>Connexion <label for="initial-toggle">&times;</label></h2>
                                <input type="text" name="pseudo" class="input" placeholder="Pseudo" required>
                                <input type="password" name="mdp" class="input" placeholder="Mot de passe" required>
                                <button type="submit" name="connecter">Se connecter</button>
                                <?php
                                if (isset($msg)) {
                                ?>
                                    <div class="error"> <?= $msg ?></div>
                                <?php
                                }
                                ?>
                                <div class="signup"> Nouveau ici ? <a href=" login?auth=signup>Inscription</a></div>
                            </form>
                        <?php
                        }
                        ?>
                    </li>
                </ul>
            </div>

            <!-- //! La bare de navigation lateralle -->


            <div class="sidebar">
                <div class="overlay"></div>
                <ul class="side-logo">
                    <li class="logo">
                        <a href="../">
                            <span class="icon">
                                <svg class="ionicon" viewBox="0 0 512 512" style="height: 1em;">
                                    <path fill="currentColor" d="M256 48C141.31 48 48 141.31 48 256s93.31 208 208 208 208-93.31 208-208S370.69 48 256 48zm74.77 217.3l-114.45 69.14a10.78 10.78 0 01-16.32-9.31V186.87a10.78 10.78 0 0116.32-9.31l114.45 69.14a10.89 10.89 0 010 18.6z"></path>
                                </svg>
                            </span>
                            <span class="text">OchoKOM</span>
                        </a>
                    </li>
                </ul>
                <ul>
                    <li>
                        <a href="../">
                            <span class="icon">
                                <svg class="ionicon" viewBox="0 0 512 512" style="height: 1em;">
                                    <path d="M80 212v236a16 16 0 0016 16h96V328a24 24 0 0124-24h80a24 24 0 0124 24v136h96a16 16 0 0016-16V212" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" />
                                    <path d="M480 256L266.89 52c-5-5.28-16.69-5.34-21.78 0L32 256M400 179V64h-48v69" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" />
                                </svg>
                            </span>
                            <span class="text">Accueil</span>
                        </a>
                    </li>
                    <?php
                    if (isset($_SESSION['auth']) && isset($_SESSION['id'])) {
                    ?>
                        <li>
                            <a href="../<?= $_SESSION['pseudo'] ?>">
                                <span class="icon">
                                    <svg class="ionicon" viewBox="0 0 512 512" style="height: 1em;">
                                        <path d="M344 144c-3.92 52.87-44 96-88 96s-84.15-43.12-88-96c-4-55 35-96 88-96s92 42 88 96z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" />
                                        <path d="M256 304c-87 0-175.3 48-191.64 138.6C62.39 453.52 68.57 464 80 464h352c11.44 0 17.62-10.48 15.65-21.4C431.3 352 343 304 256 304z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32" />
                                    </svg>
                                </span>
                                <span class="text">Profil</span>
                            </a>
                        </li>
                        <li>
                            <a href="../history">
                                <span class="icon">
                                    <svg viewBox="0 -960 960 960" style="height: 1em;">
                                        <path d="M478-120q-145.334 0-248.834-100.834-103.5-100.833-108.499-246.5H188q4.666 118 88.166 199.334T478-186.666q123.667 0 209.5-86.5 85.834-86.501 85.834-210.167 0-121.667-86.5-205.834Q600.333-773.334 478-773.334q-68.333 0-128 31.334-59.667 31.333-102.667 83.999H354v66.667H134.667V-810h66.666v102Q253-770 325.167-805 397.333-840 478-840q75 0 140.833 28.167 65.834 28.166 115 76.666Q783-686.667 811.5-621.5T840-481.333q0 75-28.5 140.833t-77.667 114.667q-49.166 48.833-115 77.333Q553-120 478-120Zm122.667-195.333-153.333-152V-682H514v187.333l134 132-47.333 47.334Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <span class="text">Historique</span>
                            </a>
                        </li>
                        <li>
                            <?php
                            $fetch_video = $bdd->prepare(' SELECT id FROM video WHERE id_auteur = ? ORDER BY date DESC');
                            $fetch_video->execute(array($_SESSION['id']));
                            ?>
                            <a href="../<?= $_SESSION['pseudo']; ?>/videos">
                                <span class="icon">
                                    <svg viewBox="0 -960 960 960" style="height: 1em;">
                                        <path d="m435.999-375.333 266.667-171.333-266.667-171.333v342.666Zm-222.666 162V-880H880v666.667H213.333Zm66.666-66.666h533.335v-533.335H279.999v533.335ZM80-80v-666.667h66.666v600.001h600.001V-80H80Zm199.999-733.334v533.335-533.335Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <span class="text">Videos en ligne (<?= $fetch_video->rowCount() ?>)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="icon">
                                    <svg class="ionicon" viewBox="0 0 512 512" style="height: 1em;">
                                        <path d="M262.29 192.31a64 64 0 1057.4 57.4 64.13 64.13 0 00-57.4-57.4zM416.39 256a154.34 154.34 0 01-1.53 20.79l45.21 35.46a10.81 10.81 0 012.45 13.75l-42.77 74a10.81 10.81 0 01-13.14 4.59l-44.9-18.08a16.11 16.11 0 00-15.17 1.75A164.48 164.48 0 01325 400.8a15.94 15.94 0 00-8.82 12.14l-6.73 47.89a11.08 11.08 0 01-10.68 9.17h-85.54a11.11 11.11 0 01-10.69-8.87l-6.72-47.82a16.07 16.07 0 00-9-12.22 155.3 155.3 0 01-21.46-12.57 16 16 0 00-15.11-1.71l-44.89 18.07a10.81 10.81 0 01-13.14-4.58l-42.77-74a10.8 10.8 0 012.45-13.75l38.21-30a16.05 16.05 0 006-14.08c-.36-4.17-.58-8.33-.58-12.5s.21-8.27.58-12.35a16 16 0 00-6.07-13.94l-38.19-30A10.81 10.81 0 0149.48 186l42.77-74a10.81 10.81 0 0113.14-4.59l44.9 18.08a16.11 16.11 0 0015.17-1.75A164.48 164.48 0 01187 111.2a15.94 15.94 0 008.82-12.14l6.73-47.89A11.08 11.08 0 01213.23 42h85.54a11.11 11.11 0 0110.69 8.87l6.72 47.82a16.07 16.07 0 009 12.22 155.3 155.3 0 0121.46 12.57 16 16 0 0015.11 1.71l44.89-18.07a10.81 10.81 0 0113.14 4.58l42.77 74a10.8 10.8 0 01-2.45 13.75l-38.21 30a16.05 16.05 0 00-6.05 14.08c.33 4.14.55 8.3.55 12.47z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" />
                                    </svg>
                                </span>
                                <span class="text">Options</span>
                            </a>
                        </li>
                        <ul class="bottom">
                            <li class="auth">
                                <a href="../<?= $_SESSION['pseudo'] ?>">
                                    <span class="icon">
                                        <div class="pic imgBx">
                                            <?php if ($_SESSION['avatar'] != "admin/noprofil.jpg") { ?>
                                                <img src="../<?= $_SESSION['avatar'] ?>" alt="Profile">
                                            <?php } ?>
                                        </div>
                                    </span>
                                    <span class="text"><?= $_SESSION['pseudo'] ?></span>
                                </a>
                            </li>
                            <li id="logout">
                                <a href="../logout">
                                    <span class="icon">
                                        <svg class="ionicon" viewBox="0 0 512 512" style="height: 1em;">
                                            <path d="M304 336v40a40 40 0 01-40 40H104a40 40 0 01-40-40V136a40 40 0 0140-40h152c22.09 0 48 17.91 48 40v40M368 336l80-80-80-80M176 256h256" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" />
                                        </svg>
                                    </span>
                                    <span class="text">Deconnexion</span>
                                </a>
                            </li>
                        </ul>

                    <?php
                    } else {
                    ?>
                        <li>
                            <label for="login-toggle">
                                <span class="icon">
                                    <svg class="ionicon" viewBox="0 0 512 512" style="height: 1em;">
                                        <path d="M344 144c-3.92 52.87-44 96-88 96s-84.15-43.12-88-96c-4-55 35-96 88-96s92 42 88 96z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" />
                                        <path d="M256 304c-87 0-175.3 48-191.64 138.6C62.39 453.52 68.57 464 80 464h352c11.44 0 17.62-10.48 15.65-21.4C431.3 352 343 304 256 304z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32" />
                                    </svg>
                                </span>
                                <span class="text">Profil (Deconnecté)</span>
                            </label>
                        </li>
                        <li>
                            <label for="login-toggle">
                                <span class="icon">
                                    <svg viewBox="0 -960 960 960" style="height: 1em;">
                                        <path d="M478-120q-145.334 0-248.834-100.834-103.5-100.833-108.499-246.5H188q4.666 118 88.166 199.334T478-186.666q123.667 0 209.5-86.5 85.834-86.501 85.834-210.167 0-121.667-86.5-205.834Q600.333-773.334 478-773.334q-68.333 0-128 31.334-59.667 31.333-102.667 83.999H354v66.667H134.667V-810h66.666v102Q253-770 325.167-805 397.333-840 478-840q75 0 140.833 28.167 65.834 28.166 115 76.666Q783-686.667 811.5-621.5T840-481.333q0 75-28.5 140.833t-77.667 114.667q-49.166 48.833-115 77.333Q553-120 478-120Zm122.667-195.333-153.333-152V-682H514v187.333l134 132-47.333 47.334Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <span class="text">Historique (Indisponible)</span>
                            </label>
                        </li>
                    <?php
                    }
                    ?>

                </ul>
            </div>

        </nav>
    <?php } else {  ?>
        <nav class="top-nav">
            <ul>
                <li class="logo">
                    <a href="../"><img src="../ico.svg" alt="logo"> OchoKOM</a>
                </li>
                <li class="search">
                    <form action="../search" method="get">
                        <span>
                            <svg class="search-back" viewBox="0 0 24 24">
                                <path fill="currentColor" d="m12 20-8-8 8-8 1.425 1.4-5.6 5.6H20v2H7.825l5.6 5.6Z" />
                            </svg>
                        </span>
                        <div class="inputbox">
                            <input type="search" class="search-data" placeholder="Chercher" name="q" id="search" required>
                        </div>
                        <button>
                            <svg class="play-icon" viewBox="0 0 48 48">
                                <path fill="currentColor" d="M39.8 41.95 26.65 28.8q-1.5 1.3-3.5 2.025-2 .725-4.25.725-5.4 0-9.15-3.75T6 18.75q0-5.3 3.75-9.05 3.75-3.75 9.1-3.75 5.3 0 9.025 3.75 3.725 3.75 3.725 9.05 0 2.15-.7 4.15-.7 2-2.1 3.75L42 39.75Zm-20.95-13.4q4.05 0 6.9-2.875Q28.6 22.8 28.6 18.75t-2.85-6.925Q22.9 8.95 18.85 8.95q-4.1 0-6.975 2.875T9 18.75q0 4.05 2.875 6.925t6.975 2.875Z" />
                            </svg>
                        </button>
                    </form>
                </li>
                <li>
                    <label for="search" class="btn-icon search-toggle edit">
                        <svg viewBox="0 0 48 48">
                            <path fill="none" d="M39.8 41.95 26.65 28.8q-1.5 1.3-3.5 2.025-2 .725-4.25.725-5.4 0-9.15-3.75T6 18.75q0-5.3 3.75-9.05 3.75-3.75 9.1-3.75 5.3 0 9.025 3.75 3.725 3.75 3.725 9.05 0 2.15-.7 4.15-.7 2-2.1 3.75L42 39.75Zm-20.95-13.4q4.05 0 6.9-2.875Q28.6 22.8 28.6 18.75t-2.85-6.925Q22.9 8.95 18.85 8.95q-4.1 0-6.975 2.875T9 18.75q0 4.05 2.875 6.925t6.975 2.875Z" />
                        </svg>
                        <span class="btn-text">
                            Rechercher
                        </span>
                    </label>
                </li>
                <li>
                    <?php
                    if (isset($_SESSION['auth']) && isset($_SESSION['id'])) {
                    ?>
                        <a class="btn-icon" href="../<?= $_SESSION['pseudo'] ?>">
                            <?php if ($_SESSION['avatar'] != "admin/noprofil.jpg") {?>
                                <img src="<?=$avatar?>" alt="Profile">
                            <?php }else {
                                ?>
                                <div class="noprofil"></div>
                                <?php
                            }?> 

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
                        <svg class="new-icon" viewBox="0 0 48 48">
                                <path fill="none" d="M22.65 34h3v-8.3H34v-3h-8.35V14h-3v8.7H14v3h8.65ZM24 44q-4.1 0-7.75-1.575-3.65-1.575-6.375-4.3-2.725-2.725-4.3-6.375Q4 28.1 4 23.95q0-4.1 1.575-7.75 1.575-3.65 4.3-6.35 2.725-2.7 6.375-4.275Q19.9 4 24.05 4q4.1 0 7.75 1.575 3.65 1.575 6.35 4.275 2.7 2.7 4.275 6.35Q44 19.85 44 24q0 4.1-1.575 7.75-1.575 3.65-4.275 6.375t-6.35 4.3Q28.15 44 24 44Zm.05-3q7.05 0 12-4.975T41 23.95q0-7.05-4.95-12T24 7q-7.05 0-12.025 4.95Q7 16.9 7 24q0 7.05 4.975 12.025Q16.95 41 24.05 41ZM24 24Z" />
                            </svg>
                    </a>
                </li>
                <?php
                    if(isset($_SESSION['auth']) && isset($_SESSION['id'])){
                        ?>
                <li>
                    <a class="btn-icon" href="../<?= $_SESSION['pseudo'] ?>">
                        <svg class="play-icon" viewBox="0 0 48 48" >
                            <path stroke="currentColor" fill="none" d="M11.1 35.25q3.15-2 6.225-3.025Q20.4 31.2 24 31.2q3.6 0 6.7 1.025t6.25 3.025q2.2-2.7 3.125-5.45Q41 27.05 41 24q0-7.25-4.875-12.125T24 7q-7.25 0-12.125 4.875T7 24q0 3.05.95 5.8t3.15 5.45ZM24 25.5q-2.9 0-4.875-1.975T17.15 18.65q0-2.9 1.975-4.875T24 11.8q2.9 0 4.875 1.975t1.975 4.875q0 2.9-1.975 4.875T24 25.5ZM24 44q-4.2 0-7.85-1.575-3.65-1.575-6.35-4.3Q7.1 35.4 5.55 31.75 4 28.1 4 23.95q0-4.1 1.575-7.75 1.575-3.65 4.3-6.35 2.725-2.7 6.375-4.275Q19.9 4 24.05 4q4.1 0 7.75 1.575 3.65 1.575 6.35 4.275 2.7 2.7 4.275 6.35Q44 19.85 44 24q0 4.1-1.575 7.75-1.575 3.65-4.275 6.375t-6.35 4.3Q28.15 44 24 44Z" />
                        </svg>
                        <span class="btn-text">
                            Profil
                        </span>
                    </a>
                </li>
                <li>
                    <a class="btn-icon" href="../<?= $_SESSION['pseudo'] ?>/videos">
                        <svg viewBox="0 -960 960 960" class="play-icon" >
                            <path d="m435.999-375.333 266.667-171.333-266.667-171.333v342.666Zm-222.666 162V-880H880v666.667H213.333Zm66.666-66.666h533.335v-533.335H279.999v533.335ZM80-80v-666.667h66.666v600.001h600.001V-80H80Zm199.999-733.334v533.335-533.335Z"  fill="currentColor"/>
                        </svg>
                        <span class="btn-text">
                            Videos
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
                <li >
                    <a class="btn-icon" href="login">
                        <svg viewBox="0 -960 960 960" class="play-icon" >
                            <path d="m435.999-375.333 266.667-171.333-266.667-171.333v342.666Zm-222.666 162V-880H880v666.667H213.333Zm66.666-66.666h533.335v-533.335H279.999v533.335ZM80-80v-666.667h66.666v600.001h600.001V-80H80Zm199.999-733.334v533.335-533.335Z"  fill="currentColor"/>
                        </svg>
                        <span class="btn-text">
                            Indisponible
                        </span>
                    </a>
                </li>
                        <?php
                    }
                    ?>
            </ul>
        </nav>
    <?php } ?>
    <script src="../scripts/script.js"></script>
    <div class="container <?php if (($devicecheck == 1)) { ?>mobile<?php }?>">
        <div class="profile">
            <form method="post" enctype="multipart/form-data" hidden>
                <input type="file" name="img" id="imgInput" accept="image/*">
                <input type="submit" name="changePic" id="changePic">
            </form>
            <form method="post" hidden>
                <input type="submit" name="deletePic" id="deletePic">
            </form>

            <h1>Infos Personel</h1>
            <div class="profile-pic">
                <div class="imgBx">
                    <img src="<?= $avatar ?>" alt=" " id="profileImg">
                </div>
                <div class="edit-btns left">
                    <label for="deletePic" class="edit delete" title="Delete">
                        <svg height="24" viewBox="0 -960 960 960" width="24">
                            <path fill="currentColor" d="M292.309-140.001q-30.308 0-51.308-21t-21-51.308V-720h-10q-12.769 0-21.384-8.615-8.616-8.615-8.616-21.384t8.616-21.384q8.615-8.616 21.384-8.616H360q0-15.076 10.538-25.23 10.539-10.154 25.616-10.154h167.692q15.077 0 25.616 10.154Q600-795.075 600-779.999h149.999q12.769 0 21.384 8.616 8.616 8.615 8.616 21.384t-8.616 21.384Q762.768-720 749.999-720h-10v507.691q0 30.308-21 51.308t-51.308 21H292.309ZM280-720v507.691q0 5.385 3.462 8.847 3.462 3.462 8.847 3.462h375.382q5.385 0 8.847-3.462 3.462-3.462 3.462-8.847V-720H280Zm96.155 410.001q0 12.769 8.615 21.384T406.154-280q12.769 0 21.384-8.615 8.616-8.615 8.616-21.384v-300.002q0-12.769-8.616-21.384Q418.923-640 406.154-640t-21.384 8.615q-8.615 8.615-8.615 21.384v300.002Zm147.691 0q0 12.769 8.616 21.384Q541.077-280 553.846-280t21.384-8.615q8.615-8.615 8.615-21.384v-300.002q0-12.769-8.615-21.384T553.846-640q-12.769 0-21.384 8.615-8.616 8.615-8.616 21.384v300.002ZM280-720v507.691q0 5.385 3.462 8.847 3.462 3.462 8.847 3.462H280v-520Z" />
                        </svg>
                    </label>
                    <div class="edit cancel" title="Annuler">&times;</div>
                </div>
                <div class="edit-btns">
                    <label for="imgInput" class="edit" title="Edit">
                        <svg height="24" viewBox="0 -960 960 960" width="24">
                            <path fill="currentColor" d="M212.309-32.002q-30.308 0-51.308-21t-21-51.307v-535.382q0-30.308 21-51.308t51.308-21h341.614L493.924-652H212.309q-4.616 0-8.463 3.846-3.846 3.847-3.846 8.463v535.382q0 4.616 3.846 8.463Q207.693-92 212.309-92h535.382q4.616 0 8.463-3.846Q760-99.693 760-104.31V-386.54l59.999-59.998v342.229q0 30.308-21 51.308t-51.308 21H212.309ZM480-372Zm181.232-323.153L704.385-653 440-389v57h56l265.769-265 42.384 41.768-282.231 283.231H380.001v-141.921l281.231-281.231Zm142.921 139.921L661.232-695.153l91.538-91.538q21.307-21.307 51.73-21.307t51.115 21.692L894.691-747q20.692 21.077 20.692 50.808 0 29.73-21.077 50.807l-90.153 90.153Z" />
                        </svg>
                    </label>
                    <label for="changePic" class="edit submit" title="Confirmer">&check;</label>
                </div>
            </div>
            <?php
            if (!isset($_SESSION['edit']) && !isset($success) || isset($_SESSION['edit']) && $_SESSION['edit'] == false && !isset($success)) {
            ?>
                <div class="message">Confirmez votre ancien mot de passe pour continuer</div>
            <?php
            } elseif (isset($msg)) {
            ?>
                <div class="message"><?= $msg ?></div>
            <?php
            } elseif (isset($success)) {
            ?>
                <div class="message"><?= $success ?></div>
            <?php
            }
            ?>
            <label>Pseudo</label>
            <form method="post" class="inputBox">
                <input type="text" name="pseudo" placeholder="<?= $_SESSION['pseudo'] ?>" required>
                <button class="btn" name="name_edit">Modifier</button>
            </form>
            <label>Ancien Mot de passe</label>
            <form method="post" class="inputBox">
                <input type="password" name="oldpwd" placeholder="*********" required autofocus>
                <button class="btn" name="editc">Confirmer</button>
            </form>
            <label> Nouveau Mot de passe</label>
            <form method="post" class="inputBox">
                <input type="password" name="mdpEd" placeholder="*********" required>
                <button class="btn" name="pwd_edit">Changer</button>
            </form>
        </div>
    </div>
    <script>
        const img = document.getElementById('profileImg'),
            input = document.getElementById('imgInput'),
            cacel = document.querySelector('.cancel'),
            submit = document.querySelector('.submit'),
            pdp = document.querySelector('.profile-pic');
        const userImg = img.src;

        submit.onclick = (e) => {
            if (input.value === "") {
                e.preventDefault();
            }
        }
        cacel.onclick = () => {
            img.src = userImg
            input.value = ""
            pdp.classList.remove('active')
        }
        input.onchange = () => {
            img.src = URL.createObjectURL(input.files[0]);
            pdp.classList.add('active')
        }
    </script>
</body>

</html>