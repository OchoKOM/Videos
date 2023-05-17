<?php
ob_start();
require('php/embedAction.php');
?>
<html>
<head>
    <title><?=$name?></title>
    <link rel="stylesheet" href="styles/embed/style.css">
</head>
<body>
    <div class="container" id="<?=$getid?>" data-url="<?=$url?>">
        <div id="video_player" class="video_player">
            <video width="720" sizes="<?=$qality ?>" poster="<?=$poster1?>" id="main-video"></video>
            <footer>
                <div class="ochovid" title="Voir le profil">
                    <a href="./<?=$usrPseudo?>" target="_blank">
                        <img src="<?=$url?><?=$usrPdp?>" alt="">
                    </a>
                </div> 
                <div class="ochovid" title="Voir sur OchoVid" data-link="time">
                    <a href="./watch?v=<?=$getid?>" target="_blank"><?=$name?></a>
                </div>
            </footer>
        </div>
    </div>
    <script src="scripts/embed/script.js"></script>
</body>
</html>

<?php
ob_end_flush();
?>