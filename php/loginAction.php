<?php
if (isset($_POST['connecter'])) {
    
    // Les infos rentrés par l'utilisateur
    $connect = htmlspecialchars($_POST['pseudo']);
    $mdpconnect = htmlspecialchars($_POST['mdp']);

    if(login($bdd, $connect, $mdpconnect) != 'ok'){
        $msg = login($bdd, $connect, $mdpconnect);
    }else {
        if (isset($_POST['rememberme'])) {
            $sessid = $_SESSION['id'];
            setcookie("users[$sessid]",$sessid, time() + 36500 * 24 * 3600, null, null, false, true);
        }
    }
}
if (isset($_POST['logout'])) {
    session_start();
    $_SESSION = [];
    session_destroy();
}
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
echo '';