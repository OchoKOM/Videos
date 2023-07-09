<?php
session_start();
try{
    $bdd = new PDO('mysql:host=localhost;dbname=videos;charset=utf8', 'root','');
} catch(Exception $e){
    die('Une erreur a été trouvé : ' . $e->getMessage()); 
}
$devicecheck = is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
function generateRandomString($length = 15) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}
function generateRandomPassword($length = 10) {
    $characters = '!@#$%&()_0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}
function formatNumber($number, $lang = "fr") {
    $i = $number == 0 ? 0 : floor(log($number) / log(1000));
    $result = ($number / pow(1000, $i));
    $isResultIntenger = (is_float($result) && $result != floor($result)) ? false : true;
    $prefixes = array(
      "fr" => array('', 'k', 'M', 'Md', 'T'),
      "en" => array('', 'k', 'M', 'B', 'T'),
      "es" => array('', 'k', 'M', 'MM', 'B')
      //todo ajouter d'autres langues ici
      //todo add others languages here 
    );
    return $isResultIntenger ? $result . $prefixes[$lang][$i] : number_format($result, 1) . $prefixes[$lang][$i];
}
function login($bdd, $connect, $mdpconnect){

    // Vérifier si tous les champs sont bien remplis
    if (!empty($mdpconnect) and !empty($connect)) {


        // Vérifier si l'adresse email existe
        $checkIfUserExist = $bdd->prepare('SELECT * FROM profil WHERE pseudo = ? ');
        $checkIfUserExist->execute(array($connect));

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

                $msg = "ok";
                
            } else {
                $msg = "Mot de passe incorrect";
            }

        } else {
            $msg = "Pseudo introuvable ou incorrect !";
        }


    } else {
        $msg = "Veuillez compléter tous les champs !";
    }
    setcookie("msg",$msg, time() + 60, null, null, false, true);
    return $msg;
}
function logout(){
    session_start();
    $_SESSION = [];
    session_destroy();
}

echo '';