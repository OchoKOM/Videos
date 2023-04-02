<?php
$urlpost = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$urlLength = strlen($urlpost);
$indexUrlLength = $urlLength - 17;
$url = substr($urlpost, 0, $indexUrlLength);
require('../php/config.php');
if (isset($_POST['connecter'])) {

    // Les infos rentrés par l'utilisateur
    $mailconnect = htmlspecialchars($_POST['pseudo']);
    $mdpconnect = htmlspecialchars($_POST['mdp']);

    // Vérifier si tous les champs sont bien remplis
    if (!empty($mdpconnect) and !empty($mailconnect)) {



        // Vérifier si l'adresse email existe
        $checkIfUserExist = $bdd->prepare('SELECT * FROM profil WHERE pseudo = ? ');
        $checkIfUserExist->execute(array($mailconnect));

        if ($checkIfUserExist->rowCount() > 0) {
            // Récupérer les données de l'utilisateur 
            $userInfos = $checkIfUserExist->fetch();

            // Vérifier si le mot de passe est correct
            if (password_verify($mdpconnect, $userInfos['mdp'])) {




                // Authentifier l'utilisateur sur le site
                $_SESSION['auth'] = true;
                $_SESSION['id'] = $userInfos['id'];
                $_SESSION['pseudo'] = $userInfos['pseudo'];
                $_SESSION['avatar'] = $userInfos['avatar'];

                if (isset($_POST['rememberme'])) {
                    $sessid = $_SESSION['id'];
                    setcookie("users[$sessid]",$sessid, time() + 36500 * 24 * 3600, null, null, false, true);
                }
                // Rédiriger vers la page de profil
                if (isset($_COOKIE['link'])) {
                    $cookieLnk = substr($_COOKIE['link'], 0 ,(strlen($_COOKIE['link'])) - 4);
                    setcookie("link",'', time() - 3600, null, null, false, true);
                    header('location:'.$cookieLnk);
                }else{
                    header("location: profil/".$_SESSION['id']);
                }
                
            } else {
                $msg = "Mot de passe incorrect";
            }





        } else {
            $msg = "Pseudo introuvable ou incorrect !";
        }


    } else {
        $msg = "Veuillez compléter tous les champs !";
    }

}