<?php
$urlpost = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$urlLength = strlen($urlpost);
$indexUrlLength = $urlLength - 10;
$url = substr($urlpost, 0, $indexUrlLength);

$searchQ = $_GET['q'];
$userSearch = $searchQ;
if (!isset($userSearch) && $userSearch == "") {
    header('location: ./');
}
require('php/config.php');
$fetchVideos = $bdd->query('SELECT * FROM video ORDER BY date DESC');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?=$userSearch;?> - Résultats OchoVid</title>
    <link rel="shortcut icon" href="ico.svg" type="image/x-icon">
    <link rel="stylesheet" href="styles/all/font-awesome.css">
    <link rel="stylesheet" href="styles/home/style.css">
    <link rel="shortcut icon" href="ico.svg" type="image/x-icon">
    <link rel="stylesheet" href="styles/all/font-awesome.css">
    <link rel="stylesheet" href="styles/home/style.css">
    <?php if (($devicecheck == 1)) { ?><link rel="stylesheet" href="styles/all/mobile_navbar.css"><?php }else{  ?><link rel="stylesheet" href="styles/all/navbar.css"><?php } ?>
</head>
<body>
    <?php if (($devicecheck == 1)) { ?>
    <nav class="top-nav">
        <ul>
            <li class="logo">
                <a href="./"><img src="ico.svg" alt="logo"> OchoKOM</a>
            </li>
            <li class="search">
                <form action="search" method="get" name="q">
                    <span>
                        <svg class="search-back" viewBox="0 0 24 24">
                            <path fill="currentColor" d="m12 20-8-8 8-8 1.425 1.4-5.6 5.6H20v2H7.825l5.6 5.6Z"/>
                        </svg>
                    </span>
                    <div class="inputbox">
                        <input type="search" class="search-data" placeholder="Chercher" name="q" id="search" required value="<?=$userSearch?>">
                    </div>
                    
                    <button type="submit">
                        <svg class="play-icon" viewBox="0 0 48 48">
                            <path fill="currentColor" d="M39.8 41.95 26.65 28.8q-1.5 1.3-3.5 2.025-2 .725-4.25.725-5.4 0-9.15-3.75T6 18.75q0-5.3 3.75-9.05 3.75-3.75 9.1-3.75 5.3 0 9.025 3.75 3.725 3.75 3.725 9.05 0 2.15-.7 4.15-.7 2-2.1 3.75L42 39.75Zm-20.95-13.4q4.05 0 6.9-2.875Q28.6 22.8 28.6 18.75t-2.85-6.925Q22.9 8.95 18.85 8.95q-4.1 0-6.975 2.875T9 18.75q0 4.05 2.875 6.925t6.975 2.875Z"/>
                        </svg>
                    </button>
                </form>
            </li>
            <li>
                <label for="search" class="btn-icon search-toggle">
                    <svg viewBox="0 0 48 48" >
                        <path stroke="none" fill="currentColor" d="M39.8 41.95 26.65 28.8q-1.5 1.3-3.5 2.025-2 .725-4.25.725-5.4 0-9.15-3.75T6 18.75q0-5.3 3.75-9.05 3.75-3.75 9.1-3.75 5.3 0 9.025 3.75 3.725 3.75 3.725 9.05 0 2.15-.7 4.15-.7 2-2.1 3.75L42 39.75Zm-20.95-13.4q4.05 0 6.9-2.875Q28.6 22.8 28.6 18.75t-2.85-6.925Q22.9 8.95 18.85 8.95q-4.1 0-6.975 2.875T9 18.75q0 4.05 2.875 6.925t6.975 2.875Z"/>
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
                        <a class="btn-icon" href="<?= $_SESSION['pseudo'] ?>">
                            <?php if ($_SESSION['avatar']  != "admin/noprofil.jpg") {?>

                            <img src="<?=$_SESSION['avatar']?>" alt="Profile">

                            <?php }else {?>

                            <div class="noprofil"></div>

                            <?php }?> 
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
                <a href="./" class="btn-icon">
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
                        <path stroke="none" fill="currentColor" d="M39.8 41.95 26.65 28.8q-1.5 1.3-3.5 2.025-2 .725-4.25.725-5.4 0-9.15-3.75T6 18.75q0-5.3 3.75-9.05 3.75-3.75 9.1-3.75 5.3 0 9.025 3.75 3.725 3.75 3.725 9.05 0 2.15-.7 4.15-.7 2-2.1 3.75L42 39.75Zm-20.95-13.4q4.05 0 6.9-2.875Q28.6 22.8 28.6 18.75t-2.85-6.925Q22.9 8.95 18.85 8.95q-4.1 0-6.975 2.875T9 18.75q0 4.05 2.875 6.925t6.975 2.875Z"/>
                    </svg>
                    <span class="btn-text">
                        Rechercher
                    </span>
                </label>
            </li>
            <li>
                <a class="btn-icon" href="new">
                    <svg class="new-icon" viewBox="0 0 48 48">
                            <path fill="none" d="M22.65 34h3v-8.3H34v-3h-8.35V14h-3v8.7H14v3h8.65ZM24 44q-4.1 0-7.75-1.575-3.65-1.575-6.375-4.3-2.725-2.725-4.3-6.375Q4 28.1 4 23.95q0-4.1 1.575-7.75 1.575-3.65 4.3-6.35 2.725-2.7 6.375-4.275Q19.9 4 24.05 4q4.1 0 7.75 1.575 3.65 1.575 6.35 4.275 2.7 2.7 4.275 6.35Q44 19.85 44 24q0 4.1-1.575 7.75-1.575 3.65-4.275 6.375t-6.35 4.3Q28.15 44 24 44Zm.05-3q7.05 0 12-4.975T41 23.95q0-7.05-4.95-12T24 7q-7.05 0-12.025 4.95Q7 16.9 7 24q0 7.05 4.975 12.025Q16.95 41 24.05 41ZM24 24Z" />
                        </svg>
                </a>
            </li>
            <?php
                if(isset($_SESSION['auth']) && isset($_SESSION['id'])){
                    ?>
            <li>
                <a class="btn-icon" href="<?= $_SESSION['pseudo'] ?>">
                    <svg class="play-icon" viewBox="0 0 48 48" >
                        <path stroke="currentColor" fill="none" d="M11.1 35.25q3.15-2 6.225-3.025Q20.4 31.2 24 31.2q3.6 0 6.7 1.025t6.25 3.025q2.2-2.7 3.125-5.45Q41 27.05 41 24q0-7.25-4.875-12.125T24 7q-7.25 0-12.125 4.875T7 24q0 3.05.95 5.8t3.15 5.45ZM24 25.5q-2.9 0-4.875-1.975T17.15 18.65q0-2.9 1.975-4.875T24 11.8q2.9 0 4.875 1.975t1.975 4.875q0 2.9-1.975 4.875T24 25.5ZM24 44q-4.2 0-7.85-1.575-3.65-1.575-6.35-4.3Q7.1 35.4 5.55 31.75 4 28.1 4 23.95q0-4.1 1.575-7.75 1.575-3.65 4.3-6.35 2.725-2.7 6.375-4.275Q19.9 4 24.05 4q4.1 0 7.75 1.575 3.65 1.575 6.35 4.275 2.7 2.7 4.275 6.35Q44 19.85 44 24q0 4.1-1.575 7.75-1.575 3.65-4.275 6.375t-6.35 4.3Q28.15 44 24 44Z" />
                    </svg>
                    <span class="btn-text">
                        Profil
                    </span>
                </a>
            </li>
            <li>
                <a class="btn-icon" href="<?= $_SESSION['pseudo'] ?>/videos">
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
    <?php }else{  ?>
    <nav>
        <div class="topbar">
            <ul>
                <li class="logo">
                    <a href="./">
                        <span class="text">OchoKOM</span>
                    </a>
                </li>
                <li class="searchBox" action="search">
                    <form method="get">
                        <input type="search" name="q" id="searchInput" required placeholder="Rehercher">
                        <button type="submit">
                            <svg class="ionicon" viewBox="0 0 512 512" style="height: 1em;">
                                <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/>
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"/>
                            </svg>
                        </button>
                    </form>
                    <ul class="suggestion"></ul>
                </li>
                <li class="search-toggle">
                    <label for="search-toggle">
                        <svg class="ionicon" viewBox="0 0 512 512" style="height: 1em;">
                            <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/>
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"/>
                        </svg>
                    </label>
                    <input hidden type="radio" name="toggle" id="search-toggle">
                </li>
                <li>
                    <?php
                        include('php/loginAction.php');
                        if (isset($msg)) {
                            ?>
                            <input hidden type="radio" name="toggle" id="initial-toggle">
                            <input hidden type="radio" name="toggle" id="login-toggle" checked>
                            <?php
                        }else {
                            ?>
                            <input hidden type="radio" name="toggle" id="initial-toggle" checked>
                            <input hidden type="radio" name="toggle" id="login-toggle">
                            <?php
                        }
                    ?>
                    <?php
                        if(isset($_SESSION['auth']) && isset($_SESSION['id'])){
                            ?>    
                    <a href="new">
                        <span class="icon">
                            <svg class="ionicon" viewBox="0 0 512 512" style="height: 1em;">
                                <path d="M448 256c0-106-86-192-192-192S64 150 64 256s86 192 192 192 192-86 192-192z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/>
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 176v160M336 256H176"/>
                            </svg>
                        </span>
                    </a>   
                    <label class="imgBx" for="user-menu">
                    <?php if ($_SESSION['avatar'] != "admin/noprofil.jpg") {?>
                        <img src="<?=$_SESSION['avatar']?>" alt="Profile">
                    <?php }?> 
                    </label>
                    <input hidden type="radio" name="toggle" id="user-menu">
                    <ul class="user-menu">
                        <label for="initial-toggle">&times;</label></h2>
                        <li>
                            <a href="<?=$_SESSION['pseudo']?>">
                                <span class="icon">
                                    <svg class="ionicon" viewBox="0 0 512 512" style="height: 1em;">
                                        <path d="M344 144c-3.92 52.87-44 96-88 96s-84.15-43.12-88-96c-4-55 35-96 88-96s92 42 88 96z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/>
                                        <path d="M256 304c-87 0-175.3 48-191.64 138.6C62.39 453.52 68.57 464 80 464h352c11.44 0 17.62-10.48 15.65-21.4C431.3 352 343 304 256 304z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/>
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
                            <a href="logout">
                                <span class="icon">
                                    <svg class="ionicon" viewBox="0 0 512 512" style="height: 1em;">
                                        <path d="M304 336v40a40 40 0 01-40 40H104a40 40 0 01-40-40V136a40 40 0 0140-40h152c22.09 0 48 17.91 48 40v40M368 336l80-80-80-80M176 256h256" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/>
                                    </svg>
                                </span>
                                <span class="text">Deconnexion</span>
                            </a>
                        </li>
                    </ul> 
                            <?php                
                        }else {
                            ?>
                     <label for="login-toggle">
                        <span class="icon">
                            <svg class="ionicon" viewBox="0 0 512 512" style="height: 1em;">
                                <path d="M448 256c0-106-86-192-192-192S64 150 64 256s86 192 192 192 192-86 192-192z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/>
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 176v160M336 256H176"/>
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
                        <button type="submit" name="connecter">Submit</button>
                        <?php
                            if (isset($msg)) {
                                ?>
                                <div class="error"> <?=$msg?></div>
                                <?php
                            }
                        ?>
                        <div class="signup"> Nouveau ici ? <a href="login?auth=signup">Inscription</a></div> 
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
                    <a href="./">
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
                    <a href="./">
                        <span class="icon">
                            <svg class="ionicon" viewBox="0 0 512 512" style="height: 1em;">
                                <path d="M80 212v236a16 16 0 0016 16h96V328a24 24 0 0124-24h80a24 24 0 0124 24v136h96a16 16 0 0016-16V212" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/>
                                <path d="M480 256L266.89 52c-5-5.28-16.69-5.34-21.78 0L32 256M400 179V64h-48v69" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/>
                            </svg>
                        </span>
                        <span class="text">Accueil</span>
                    </a>
                </li>
                <?php
                    if(isset($_SESSION['auth']) && isset($_SESSION['id'])){
                        ?> 
                <li>
                    <a href="<?=$_SESSION['pseudo']?>">
                        <span class="icon">
                            <svg class="ionicon" viewBox="0 0 512 512" style="height: 1em;">
                                <path d="M344 144c-3.92 52.87-44 96-88 96s-84.15-43.12-88-96c-4-55 35-96 88-96s92 42 88 96z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/>
                                <path d="M256 304c-87 0-175.3 48-191.64 138.6C62.39 453.52 68.57 464 80 464h352c11.44 0 17.62-10.48 15.65-21.4C431.3 352 343 304 256 304z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/>
                            </svg>
                        </span>
                        <span class="text">Profil</span>
                    </a>
                </li>
                <li>
                    <a href="history">
                        <span class="icon">
                            <svg viewBox="0 -960 960 960" style="height: 1em;">
                                <path d="M478-120q-145.334 0-248.834-100.834-103.5-100.833-108.499-246.5H188q4.666 118 88.166 199.334T478-186.666q123.667 0 209.5-86.5 85.834-86.501 85.834-210.167 0-121.667-86.5-205.834Q600.333-773.334 478-773.334q-68.333 0-128 31.334-59.667 31.333-102.667 83.999H354v66.667H134.667V-810h66.666v102Q253-770 325.167-805 397.333-840 478-840q75 0 140.833 28.167 65.834 28.166 115 76.666Q783-686.667 811.5-621.5T840-481.333q0 75-28.5 140.833t-77.667 114.667q-49.166 48.833-115 77.333Q553-120 478-120Zm122.667-195.333-153.333-152V-682H514v187.333l134 132-47.333 47.334Z"  fill="currentColor"/>
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
                    <a href="<?= $_SESSION['pseudo']; ?>/videos">
                        <span class="icon">
                            <svg viewBox="0 -960 960 960" style="height: 1em;">
                                <path d="m435.999-375.333 266.667-171.333-266.667-171.333v342.666Zm-222.666 162V-880H880v666.667H213.333Zm66.666-66.666h533.335v-533.335H279.999v533.335ZM80-80v-666.667h66.666v600.001h600.001V-80H80Zm199.999-733.334v533.335-533.335Z"  fill="currentColor"/>
                            </svg>
                        </span>
                        <span class="text">Videos en ligne (<?=$fetch_video->rowCount()?>)</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon">
                            <svg class="ionicon" viewBox="0 0 512 512" style="height: 1em;">
                                <path d="M262.29 192.31a64 64 0 1057.4 57.4 64.13 64.13 0 00-57.4-57.4zM416.39 256a154.34 154.34 0 01-1.53 20.79l45.21 35.46a10.81 10.81 0 012.45 13.75l-42.77 74a10.81 10.81 0 01-13.14 4.59l-44.9-18.08a16.11 16.11 0 00-15.17 1.75A164.48 164.48 0 01325 400.8a15.94 15.94 0 00-8.82 12.14l-6.73 47.89a11.08 11.08 0 01-10.68 9.17h-85.54a11.11 11.11 0 01-10.69-8.87l-6.72-47.82a16.07 16.07 0 00-9-12.22 155.3 155.3 0 01-21.46-12.57 16 16 0 00-15.11-1.71l-44.89 18.07a10.81 10.81 0 01-13.14-4.58l-42.77-74a10.8 10.8 0 012.45-13.75l38.21-30a16.05 16.05 0 006-14.08c-.36-4.17-.58-8.33-.58-12.5s.21-8.27.58-12.35a16 16 0 00-6.07-13.94l-38.19-30A10.81 10.81 0 0149.48 186l42.77-74a10.81 10.81 0 0113.14-4.59l44.9 18.08a16.11 16.11 0 0015.17-1.75A164.48 164.48 0 01187 111.2a15.94 15.94 0 008.82-12.14l6.73-47.89A11.08 11.08 0 01213.23 42h85.54a11.11 11.11 0 0110.69 8.87l6.72 47.82a16.07 16.07 0 009 12.22 155.3 155.3 0 0121.46 12.57 16 16 0 0015.11 1.71l44.89-18.07a10.81 10.81 0 0113.14 4.58l42.77 74a10.8 10.8 0 01-2.45 13.75l-38.21 30a16.05 16.05 0 00-6.05 14.08c.33 4.14.55 8.3.55 12.47z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/>
                            </svg>
                        </span>
                        <span class="text">Options</span>
                    </a>
                </li>
                <ul class="bottom">
                    <li class="auth">
                        <a href="<?=$_SESSION['pseudo']?>">
                            <span class="icon">
                                <div class="pic imgBx">
                                <?php if ($_SESSION['avatar'] != "admin/noprofil.jpg") {?>
                                    <img src="<?=$_SESSION['avatar']?>" alt="Profile">
                                <?php }?> 
                                </div>
                            </span>
                            <span class="text"><?=$_SESSION['pseudo']?></span>
                        </a>
                    </li>
                    <li id="logout">
                        <a href="logout">
                            <span class="icon">
                                <svg class="ionicon" viewBox="0 0 512 512" style="height: 1em;">
                                    <path d="M304 336v40a40 40 0 01-40 40H104a40 40 0 01-40-40V136a40 40 0 0140-40h152c22.09 0 48 17.91 48 40v40M368 336l80-80-80-80M176 256h256" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/>
                                </svg>
                            </span>
                            <span class="text">Deconnexion</span>
                        </a>
                    </li>
                </ul>

                        <?php
                    }else{
                        ?>
                    <li>
                        <label for="login-toggle">
                            <span class="icon">
                                <svg class="ionicon" viewBox="0 0 512 512" style="height: 1em;">
                                    <path d="M344 144c-3.92 52.87-44 96-88 96s-84.15-43.12-88-96c-4-55 35-96 88-96s92 42 88 96z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/>
                                    <path d="M256 304c-87 0-175.3 48-191.64 138.6C62.39 453.52 68.57 464 80 464h352c11.44 0 17.62-10.48 15.65-21.4C431.3 352 343 304 256 304z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/>
                                </svg>
                            </span>
                            <span class="text">Profil (Deconnecté)</span>
                        </label>  
                    </li>
                    <li>
                        <label for="login-toggle">
                            <span class="icon">
                                <svg viewBox="0 -960 960 960" style="height: 1em;">
                                    <path d="M478-120q-145.334 0-248.834-100.834-103.5-100.833-108.499-246.5H188q4.666 118 88.166 199.334T478-186.666q123.667 0 209.5-86.5 85.834-86.501 85.834-210.167 0-121.667-86.5-205.834Q600.333-773.334 478-773.334q-68.333 0-128 31.334-59.667 31.333-102.667 83.999H354v66.667H134.667V-810h66.666v102Q253-770 325.167-805 397.333-840 478-840q75 0 140.833 28.167 65.834 28.166 115 76.666Q783-686.667 811.5-621.5T840-481.333q0 75-28.5 140.833t-77.667 114.667q-49.166 48.833-115 77.333Q553-120 478-120Zm122.667-195.333-153.333-152V-682H514v187.333l134 132-47.333 47.334Z"  fill="currentColor"/>
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
    <?php } ?>
    <div class="content">
                <?php if ($fetchVideos->rowcount() == 0 && !isset($_GET['q']) && empty($_GET['q'])) {
                    header('location: ./');
                }else {
                    $getSearch = $_GET['q'];
                }
                ?>
        
       
        <?php
            if (isset($_GET['q']) AND !empty($_GET['q'])) {
                
                $fetchVideos = $bdd->query('SELECT * FROM video WHERE titre LIKE "%'.$userSearch.'%"');
                $nombre_de_video = $fetchVideos->rowCount();

                // Requête pour la table 1
                $requete_table1 = $bdd->prepare('SELECT COUNT(*) FROM video');

                // Exécution de la requête pour la table 1
                $requete_table1->execute();

                // Récupération du nombre total de lignes pour la table 1
                $nombre_de_lignes_table1 = $requete_table1->fetchColumn();

                // Requête pour la table 2
                $requete_table2 = $bdd->prepare('SELECT COUNT(*) FROM profil');

                // Exécution de la requête pour la table 2
                $requete_table2->execute();

                // Récupération du nombre total de lignes pour la table 2
                $nombre_de_lignes_table2 = $requete_table2->fetchColumn();

                // Utilisation du plus grand nombre comme $nombre_de_requetes
                $nombre_de_requetes = max($nombre_de_lignes_table1, $nombre_de_lignes_table2);

                
                
                

                if ($nombre_de_video == 0 && $nombre_de_lignes_table2 == 0) {
                    ?>
                <div class="grid" >
                    <div align=center class="message">
                        <h3>Aucune vidéo trouvée et aucun utilisateur trouvé</h3>
                    </div>
                </div>
                <?php
                }else{
                    ?>
                    
                    
                <div class="grid search <?php if (($devicecheck == 1)) { ?>mobile<?php } ?>" >
                    <?php
                    
                    if ($nombre_de_video == 1){

                        ?><div align=center class="message" >
                        <h3><?=$nombre_de_video?> vidéo trouvée</h3>
                        </div><?php
                    }else {
                        ?><div align=center class="message">
                        <h3><?=$nombre_de_video?> vidéos trouvées</h3>
                        </div><?php
                    }


                    // Boucle pour exécuter la requête plusieurs fois
                for ($i = 0; $i < $nombre_de_requetes; $i++) {


                    $slice = $i * 5;

                    // Requête pour la table 1
                    $requete_table1 = $bdd->query('SELECT * FROM video WHERE titre LIKE "%'.$userSearch.'%" ORDER BY date DESC');
                
                    // Récupération des résultats pour la table 1
                    $resultats_table1 = $requete_table1->fetchAll();
                
                    // Requête pour la table 2
                    $requete_table2 = $bdd->query('SELECT * FROM profil WHERE pseudo LIKE "%'.$userSearch.'%"');
                
                    // Exécution de la requête pour la table 2
                    $requete_table2->execute();
                
                    // Récupération des résultats pour la table 2
                    $resultats_table2 = $requete_table2->fetchAll();
                
                    // Affichage des résultats
                    foreach (array_slice($resultats_table2, $i, $i + 1) as $resultat_table2) {

                        $userId = $resultat_table2['id'];
                        $userName = $resultat_table2['pseudo'];
                        $userAvatar = $resultat_table2['avatar'];
                        $query = $bdd->prepare('SELECT * FROM video WHERE id_auteur = ?');
                        $query->execute(array($userId));
                        $videoCount = $query->rowCount();
                        $videoCountStr = $videoCount . ' videos en ligne';
                        if ($videoCount == 0) {
                            $videoCountStr = 'Aucune video en ligne';
                        }elseif ($videoCount == 1) {
                            $videoCountStr = $videoCount . ' video en ligne';
                        }

                        ?>
                            <div class="links search">
                                <div class="thumbNails user-profile" data-mini="user-profile">
                                    <a href="<?=$userName?>">
                                        <div class="user" >
                                        <?php if ($userAvatar != "admin/noprofil.jpg") {?>
                                            <img src="<?=$userAvatar?>" data-thumbnail="user-profile" alt="Profile of <?=$userName?>">
                                        <?php }?>
                                        </div>
                                    </a>
                                    <div class="vidInf">
                                        <div class="buttons">
                                            <button class="btn btn-primary" onclick="location.replace('<?=$userName?>/videos')">
                                                Videos de l'utilisateur
                                            </button>
                                        </div>
                                        <div class="textInf">
                                            <a href="<?=$userName?>">
                                                <h4 class="username"><?=$userName?></h4>
                                            </a>
                                            <div class="auteur">
                                                <span>
                                                    <?=$videoCountStr?> 
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        <?php
                    }

                    foreach (array_slice($resultats_table1, $slice, $slice + 4) as $resultat_table1) {
                        $getUser = $bdd->prepare('SELECT id , pseudo , avatar FROM profil WHERE id = ?');
                        $getUser->execute(array($resultat_table1['id_auteur']));
                        $getUserInf = $getUser->fetch();
                        $userId = $getUserInf['id'];
                        $userPseudo = $getUserInf['pseudo'];
                        $userPdp = $getUserInf['avatar'];
                        $name = $resultat_table1['titre'];
                        $poster = $url.$resultat_table1['poster'];
                        $viewNbr = formatNumber($resultat_table1['vues']);
                        $getDate = $resultat_table1['date'];
                        if ($viewNbr === "0") {
                            $views = "Aucune vue";
                        }elseif ($viewNbr === "1") {
                            $views = "1 vue";
                        }else{
                            $views = " ".$viewNbr." vues "; 
                        }

                    ?>
                        <div class="links search">
                            <div class="thumbNails" data-mini="<?=$resultat_table1['id']?>">
                                <a>
                                    <div class="mini-player" >
                                        <img src="<?=$poster;?>" data-thumbnail="<?=$resultat_table1['id']?>" alt="Thumbnail of <?=$name;?>" onclick="location.replace('watch?v=<?=$resultat_table1['id']?>')">
                                        <video autoplay></video>
                                    </div>
                                    <div class="buttons">
                                        <button title="Lire" class="active" data-time="Lire">
                                            <svg class="play-icon" viewBox="0 0 24 24" style="width: 20px;height: 20px;">
                                                <path fill="currentColor" d="M8,5.14V19.14L19,12.14L8,5.14Z" />
                                            </svg>
                                        </button>
                                        <button title="Son" class="sound">
                                            <svg class="volume-high-icon" viewBox="0 0 48 48" style="display:none;">
                                                <path fill="currentColor" d="M28 41.45v-3.1q4.85-1.4 7.925-5.375T39 23.95q0-5.05-3.05-9.05-3.05-4-7.95-5.35v-3.1q6.2 1.4 10.1 6.275Q42 17.6 42 23.95t-3.9 11.225Q34.2 40.05 28 41.45ZM6 30V18h8L24 8v32L14 30Zm21 2.4V15.55q2.75.85 4.375 3.2T33 24q0 2.85-1.65 5.2T27 32.4Zm-6-16.8L15.35 21H9v6h6.35L21 32.45ZM16.3 24Z"/>
                                            </svg> 
                                            <svg class="volume-muted-icon" viewBox="0 0 45 45">
                                                <path fill="currentColor" d="m40.65 45.2-6.6-6.6q-1.4 1-3.025 1.725-1.625.725-3.375 1.125v-3.1q1.15-.35 2.225-.775 1.075-.425 2.025-1.125l-8.25-8.3V40l-10-10h-8V18h7.8l-11-11L4.6 4.85 42.8 43Zm-1.8-11.6-2.15-2.15q1-1.7 1.475-3.6.475-1.9.475-3.9 0-5.15-3-9.225-3-4.075-8-5.175v-3.1q6.2 1.4 10.1 6.275 3.9 4.875 3.9 11.225 0 2.55-.7 5t-2.1 4.65Zm-6.7-6.7-4.5-4.5v-6.5Q30 17 31.325 19.2q1.325 2.2 1.325 4.8 0 .75-.125 1.475-.125.725-.375 1.425Zm-8.5-8.5-5.2-5.2 5.2-5.2Zm-3 14.3v-7.5l-4.2-4.2h-7.8v6h6.3Zm-2.1-9.6Z"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress"></div>
                                    </div>
                                </a>
                                <div class="vidInf">
                                    <div class="avatar2">
                                        <a href="<?=$userPseudo;?>" title="<?=$userPseudo;?>">
                                            <?php if ($userPdp != "admin/noprofil.jpg") {?>
                                                <img src="<?=$userPdp;?>" alt="Profil de <?=$userPseudo;?> ">
                                            <?php }?> 
                                        </a>
                                    </div>
                                    <div class="textInf">
                                        <a href="watch?v=<?=$resultat_table1['id']?>" title="<?=$name;?>">
                                            <h4 class="vidName<?=$resultat_table1['id']?>"><?=$name;?></h4>
                                        </a>
                                        <div class="auteur">
                                            <a href="<?=$userPseudo;?>" title="<?=$userPseudo;?>">
                                                <?=$userPseudo;?>  
                                            </a>
                                            <span> • <?=$views?></span>
                                            <span class="time" data-date="<?=$getDate?>"> • Chargement</span>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    <?php

                    }
                }


                    
                }

            }
            ?>
        </div>
    </div>
    <script src="scripts/main.js"></script>
    <script>
        let autoplay = true
    </script>
    <script src="scripts/script.js"></script>
</body>
</html>