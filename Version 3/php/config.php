<?php
$host = "localhost";
$user = "root";
$mdp = "";
$db = "videos";
session_start();
try{
    $bdd = new PDO('mysql:host='.$host.';dbname='.$db.';charset=utf8', $user,$mdp);
} catch(Exception $e){
    die('Une erreur a été trouvé : ' . $e->getMessage()); 
}

$db = mysqli_connect($host, $user, $mdp, $db);
$devicecheck = is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}
function generateRandomPassword($length) {
    $characters = '!@#$%&()_0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}