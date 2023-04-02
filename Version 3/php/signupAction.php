<?php
 
require('../php/config.php');

$urlpost = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$urlLength = strlen($urlpost);
$indexUrlLength = $urlLength - 13;
$url = substr($urlpost, 0, $indexUrlLength);

if (isset($_POST['valider'])) {
    // Vérifier si les champs ne sont pas vides
    if (!empty($_POST['pseudo']) && !empty($_POST['mdp']) && !empty($_POST['mdp1'])) {

        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
        $mdp1 = password_hash($_POST['mdp1'], PASSWORD_DEFAULT);
        $avatar = "admin/noprofil.jpg";

        $pseudoleght = strlen($pseudo);

        // Vérifierla longueur du pseudo
        if ($pseudoleght <= 55) {

            // Vérifier si les deux mots de passe correspondent
            if ($mdp = $mdp1) {

                // Vérifier si le pseudo éxiste déjà dans la base des données
                $checkIfUserAlreadyExists = $bdd->prepare('SELECT pseudo FROM profil WHERE pseudo = ?');
                $checkIfUserAlreadyExists->execute(array($pseudo));

                if ($checkIfUserAlreadyExists->rowCount() == 0) {

                    // Insérer le membre dans la base des données
                    $insertMbr = $bdd->prepare("INSERT INTO profil(pseudo, avatar, mdp) VALUES(?, ?, ?)");
                    $insertMbr->execute(array($pseudo, $avatar, $mdp));
                    $success = "Votre compte a bien été créé  ...";

                    // Récupérer les informations de l'utilisateur 
                    $getInfosOfUserreq = $bdd->prepare('SELECT * FROM profil WHERE  pseudo = ? AND avatar = ? AND mdp = ?');
                    $getInfosOfUserreq->execute(array($pseudo, $avatar, $mdp));

                    $userInfos = $getInfosOfUserreq->fetch();

                    // Authentifier l'utilisateur sur le site
                    $_SESSION['auth'] = true;
                    $_SESSION['id'] = $userInfos['id'];
                    $_SESSION['pseudo'] = $userInfos['pseudo'];
                    $_SESSION['avatar'] = $avatar;

                    if (isset($_POST['rememberme'])) {
                        $sessid = $_SESSION['id'];
                        setcookie("users[$sessid]",$sessid, time() + 36500 * 24 * 3600, null, null, false, true);
                    }

                    header("location: picture/" . $_SESSION['id']);

                } else {

                    $msg = "Ce pseudo est déjà utilisé !";

                }


            } else {

                $msg = "Vos mots de passe ne correspondent pas !";

            }

        } else {
            $msg = "Votre pseudo est trop long !";
        }

    } else {
        $msg = "Veuillez completer tous les champs...";
    }
}
if (isset($_POST['profil'])) {
    $imgName = $_FILES['img']['name'];
    $imgSize = $_FILES['img']['size'];

    if (!empty($imgName)) {

        $tailleMax = 10485760;
        $extentionsValides = array('jpg', 'jpeg', 'png', 'gif', 'webp');
        $extentionUpload = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));

        if ($imgSize < $tailleMax) {
            if (in_array($extentionUpload, $extentionsValides)) {

                // todo: Déplacer l'image dans le dossier img
                $chemin = "img/" . $_SESSION['id']. '_' . generateRandomString(5) . "." . $extentionUpload;
                $deplacer = move_uploaded_file($_FILES['img']['tmp_name'], $chemin);

                if ($deplacer) {

                    //! Insérer les informations dans la base des données
                    $updateAvatar = $bdd->prepare('UPDATE profil SET avatar= ? WHERE id= ?');
                    $updateAvatar->execute(array('admin/'.$chemin, $_SESSION['id']));

                    //? Récupérer les informations de l'utilisateur 
                    $getInfosOfUserreq = $bdd->prepare('SELECT * FROM profil WHERE  id = ? ');
                    $getInfosOfUserreq->execute(array($_SESSION['id']));
                    $userInfos = $getInfosOfUserreq->fetch();
                    $_SESSION['pseudo'] = $userInfos['pseudo'];
                    $_SESSION['avatar'] = $userInfos['avatar'];
                    // Rédiriger vers la page de profil
                    if (isset($_COOKIE['link'])) {
                        $cookieLnk = substr($_COOKIE['link'], 0 ,(strlen($_COOKIE['link'])) - 4);
                        setcookie("link",$cookieLnk, time() - 3600, null, null, false, true);
                        header('location:'.$cookieLnk);
                    }else{
                        header("location: ../".$_SESSION['pseudo']);
                    }
                } else {
                    $msg = "Erreur durant l'importation de l'image";
                }

            } else {
                $msg = "Votre photo de profil <br> dois être au format <br> jpg, jpeg, png, gif ou webp ! ";
            }
        } else {
            $msg = "Votre photo de profil <br> ne dois pas dépasser 10Mo! ";
        }


    } else {
        $msg = "Aucune photo choisie <br> cliquez sur annuler si vous <br>voulez le faire ulterieurement";
    }
}
if (isset($_POST['cancel'])) {
    header('location: ../' . $_SESSION['pseudo']);
}