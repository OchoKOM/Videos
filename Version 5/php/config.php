<?php
session_start();
try{
    $bdd = new PDO('mysql:host=localhost;dbname=ochovid;charset=utf8', 'root','');
} catch(Exception $e){
    die('Une erreur a été trouvé : ' . $e->getMessage()); 
}
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

echo '';