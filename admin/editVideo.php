<?php
require('../php/editAction.php');
if (($devicecheckIpad != 1) && ($devicecheck == 1)) {
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier <?= $edtitle; ?>
    </title>
    <link rel="shortcut icon" href="../ico.svg" type="image/x-icon">
    <link rel="stylesheet" href="../styles/all/font-awesome.css">
    <link rel="stylesheet" href="../Mobile/styles/post.css">
    <link rel="stylesheet" href="../styles/all/mobile_navbar.css">
</head>

<body>
    <nav class="top-nav">
        <ul>
            <li class="logo">
                <a href="../"><img src="../ico.svg" alt="logo"> OchoKOM</a>
            </li>
            <li class="search">
                <form action="../search" method="get" name="q">
                    <span>
                        <svg class="search-back" viewBox="0 0 24 24">
                            <path fill="currentColor" d="m12 20-8-8 8-8 1.425 1.4-5.6 5.6H20v2H7.825l5.6 5.6Z"/>
                        </svg>
                    </span>
                    <div class="inputbox">
                        <input type="search" class="search-data" placeholder="Chercher" name="q" id="search" required >
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
    <script src="../scripts/script.js"></script>

    <div class="modal" id="modal3">
        <div class="modal-content">

            <div class="modal-header" align=center>
                Suppression
                <div class="icon modal-close modalClose"><i class="fa fa-close"></i></div>
            </div>
            <hr>
            <div class="modal-body">
                <div class="pop-up">
                    <p>Voulez vous vraiment supprimer cette video cette action est irreversible</p>
                </div>
            </div>
            <br>
            <hr>
            <form method="post">
                <div class="modal-footer">
                    <input type="button" class="modal-close closeBtn" style="--clr:#1e9bff" value="Annuler">
                    <input type="submit" class="modalCancel" style="--clr:#f44336" name="delete" value="Effacer">
                </div>
            </form>

            <script>
                function logout() {
                    location.replace('../php/logout.php')
                }
            </script>

        </div>
    </div>
    <br>
    <br>
    <div class="cont">
        <div class="postcont" id="modal1">
            <div class="post-content">
                <?php
                if (isset($msg)) {
                ?>
                <div class="message">
                    <h3>
                        <?= $msg; ?>
                    </h3>
                </div>
                <?php
                }
                ?>
               
                    <div class="post-body">
                        <div class="preview">
                            <div class="videoPl">
                                <div class="vid">
                                    <video src="../kom<?=$getId?>" poster="<?= $poster; ?>" id="vid" class="vidPrev"
                                        loop></video>
                                </div>
                            </div>
                        <form method="post" enctype="multipart/form-data">
                            <div class="btns">
                                <p class="oldTitle">Modifier <br>
                                    <?= $edtitle; ?>
                                </p> <br>
                                <div class="imgBx"><img src="<?= $poster; ?>" alt=""></div>

                                
                                <div class="inputs" hidden onclick="hideMsg()">
                                    <input type="text" value="../ico.svg" id="logo">
                                    <input type="file" accept="video/*" name="file" id="vidBtn" value='empty'
                                        onchange="previewVid()">
                                    <input type="file" accept="image/*" name="poster" id="imgBtn"
                                        onchange="previewImg()">
                                </div>
                                <input type="button" class="btn btn-primary imgLnkBtn" value="Utiliser un URL">
                                <div class="title imgLnkFld" hidden>
                                    <label for="posterLnk">Utiliser un URL</label>
                                    <input type="url" name="posterLnk" id="posterLnk" placeholder="Inserez ici le lien vers la miniature" onchange="posterImg()">
                                </div>
                                <div class="vidBtn">
                                    <p class="instruction">Cliquez sur <span class="fa fa-image"></span> pour modifier
                                        la miniature</p>
                                    <div class="imgPrev">
                                        <img src="" width="190px" class="posterView" style="display:none;">
                                    </div>
                                    <div title="Cliquez ici" class="i im" onclick="imgInp()"><i class="fa fa-image"></i>
                                    </div>
                                </div>
                                <div class="title">
                                    <label for="title">Titre de la video</label>
                                    <input type="text" name="title" id="title"
                                        placeholder="Inserez ici le nouveau titre de la video" value="<?= $edtitle; ?>">
                                </div>
                                <div class="view" style="visibility: visible;">
                                    <input type="button" class="btn btn-primary pview" value="Previsualiser">
                                    <input type="submit" class="btn btn-warning" name="submit" value="Confirmer">
                                    <input type="button" class="btn btn-danger modal-op" data-modal="modal3"
                                        value="Effacer">
                                </div>
                            </div>
                        </div>
                        <div align=center class="post-footer">
                        </div>
                </form>
                <script src="../Mobile/scripts/postScripts/player.js"></script>
                <script src="../Mobile/scripts/postScripts/elements.js"></script>
                <script src="../Mobile/scripts/postScripts/controls.js"></script>
                <script src="../scripts/preview/editPreview.js"></script>
            </div>
        </div>

    </div>
</body>

</body>

</html>
<?php
} else {
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier <?= $edtitle; ?>
    </title>
    <link rel="shortcut icon" href="../ico.svg" type="image/x-icon">
    <link rel="stylesheet" href="../styles/all/font-awesome.css">
    <link rel="stylesheet" href="../styles/post/post.css">
    <link rel="stylesheet" href="../styles/all/navbar.css">
</head>
<body>
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
                        include('../php/loginAction.php');
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
                    <a href="../new">
                        <span class="icon">
                            <svg class="ionicon" viewBox="0 0 512 512" style="height: 1em;">
                                <path d="M448 256c0-106-86-192-192-192S64 150 64 256s86 192 192 192 192-86 192-192z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/>
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 176v160M336 256H176"/>
                            </svg>
                        </span>
                    </a>   
                    <label class="imgBx" for="user-menu">
                    <?php if ($_SESSION['avatar'] != "admin/noprofil.jpg") {?>
                        <img src="../<?=$_SESSION['avatar']?>" alt="Profile">
                    <?php }?> 
                    </label>
                    <input hidden type="radio" name="toggle" id="user-menu">
                    <ul class="user-menu">
                        <label for="initial-toggle">&times;</label></h2>
                        <li>
                            <a href="../<?=$_SESSION['pseudo']?>">
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
                            <a  href="../logout">
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
                        <button type="submit" name="connecter">Se connecter</button>
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
                    <a href="../<?=$_SESSION['pseudo']?>">
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
                    <a href="../history">
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
                    <a href="../<?= $_SESSION['pseudo']; ?>/videos">
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
                        <a href="../<?=$_SESSION['pseudo']?>">
                            <span class="icon">
                                <div class="pic imgBx">
                                <?php if ($_SESSION['avatar'] != "admin/noprofil.jpg") {?>
                                    <img src="../<?=$_SESSION['avatar']?>" alt="Profile">
                                <?php }?> 
                                </div>
                            </span>
                            <span class="text"><?=$_SESSION['pseudo']?></span>
                        </a>
                    </li>
                    <li id="logout">
                        <a href="../logout">
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
    <script src="../scripts/script.js"></script>

    <div class="modal" id="modal3">
        <div class="modal-content">

            <div class="modal-header" align=center>
                Suppression
                <div class="icon modal-close modalClose"><i class="fa fa-close"></i></div>
            </div>
            <hr>
            <div class="modal-body">
                <div class="pop-up">
                    <p>Voulez vous vraiment supprimer cette video cette action est irreversible</p>
                </div>
            </div>
            <br>
            <hr>
            <form method="post">
                <div class="modal-footer">
                    <input type="button" class="modal-close closeBtn" style="--clr:#1e9bff" value="Annuler">
                    <input type="submit" class="modalCancel" style="--clr:#f44336" name="delete" value="Effacer">
                </div>
            </form>

            <script>
                function logout() {
                    location.replace('../php/logout.php')
                }
            </script>

        </div>
    </div>
    <div class="post-content">
        <?php
            if (isset($msg)) {
                    ?>
                    <div class="message">
                        <h3>
                            <?= $msg; ?>
                        </h3>
                    </div>
                    <?php
            }
        ?>
        <form method="post" enctype="multipart/form-data">
            <div class="post-body">
                <div class="preview">
                    <div class="btns">
                        <p class="oldTitle">Modifier <br>
                            <?= $edtitle; ?>
                        </p> <br>
                        <div class="imgBx"><img src="<?= $poster; ?>" alt=""></div>

                        
                        <div class="inputs" hidden onclick="hideMsg()">
                            <input type="text" value="../ico.svg" id="logo">
                            <input type="file" accept="video/*" name="file" id="vidBtn" value='empty'
                                onchange="previewVid()">
                            <input type="file" accept="image/*" name="poster" id="imgBtn"
                                onchange="previewImg()">
                        </div>
                        <input type="button" class="btn btn-primary imgLnkBtn" value="Utiliser un URL">
                        <div class="title imgLnkFld" hidden>
                            <label for="posterLnk">Utiliser un URL</label>
                            <input type="url" name="posterLnk" id="posterLnk" placeholder="Inserez ici le lien vers la miniature" onchange="posterImg()">
                        </div>
                        <div class="vidBtn">
                            <p class="instruction">Cliquez sur <span class="fa fa-image"></span> pour modifier
                                la miniature</p>
                            <div class="imgPrev">
                                <img src="" width="190px" class="posterView" style="display:none;">
                            </div>
                            <div title="Cliquez ici" class="i im" onclick="imgInp()"><i class="fa fa-image"></i>
                            </div>
                        </div>
                        <div class="title">
                            <label for="title">Titre de la video</label>
                            <input type="text" name="title" id="title"
                                placeholder="Inserez ici le nouveau titre de la video" value="<?= $edtitle; ?>">
                        </div>
                        <div class="view" style="visibility: visible;">
                            <input type="button" class="btn btn-primary pview" value="Previsualiser">
                            <button type="submit" class="btn btn-warning" name="submit">Confirmer les modifications</button>
                            <input type="button" class="btn btn-danger modal-op" data-modal="modal3"
                                value="Effacer">
                        </div>
                    </div>
                    <div class="videoPl">
                        <div class="vid">
                            <video src="../kom<?=$getId?>" poster="<?= $poster; ?>" id="vid" class="vidPrev"
                                loop></video>
                        </div>
                    </div>


                </div>
                <div align=center class="post-footer">
                </div>
        </form>
    </div>
    <script src="../scripts/preview/player.js"></script>
    <script src="../scripts/preview/elements.js"></script>
    <script src="../scripts/watch/postControls.js"></script>
    <script src="../scripts/preview/editPreview.js"></script>
</body>

</html>
<?php
}