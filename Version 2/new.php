<?php
require('php/postAction.php');
    $sesslnk = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
if(!isset($_SESSION['auth']) || !isset($_SESSION['id']) && $_SESSION['id'] === 0){
    setcookie("link",$sesslnk, time() + 36500 * 24 * 3600, null, null, false, true);
    header('location: login');
}
$devicecheck = is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));

if ($devicecheck == 1) { 
    ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publier une video</title>
    <link rel="shortcut icon" href="scripts/controls/ico.png" type="image/x-icon">
    <link rel="stylesheet" href="styles/all\font-awesome.css">
    <link rel="stylesheet" href="mobile/styles/post.css">
    <link rel="stylesheet" href="styles/all/navbar.css">
</head>
<body>
<nav>
      <div class="menu-icon">
        <span class="fas fa-bars"></span>
      </div>
      <a href="./"><div class="logo"><img src="scripts/controls/ico.png" alt="logo"> OchoKOM</div></a>
      <div class="search-icon">
        <span class="fas fa-search"></span>
      </div>
      <div class="cancel-icon">
        <span class="fas fa-times" style="color: rgb(255, 61, 0);"></span>
      </div>
    <form action="search" method="get">
        <input name="q" type="search" class="search-data" placeholder="Chercher" required/>
        <button type="submit" class="fas fa-search"></button>
      </form>
      <div class="nav-items">
        <li><a href="./" >Accueil</a></li>
        <li><a href="#" class="active">Publier une vidéo</a></li>
        <li><a href="<?=$_SESSION['pseudo'];?>">Profil</a></li>
      </div>
      
    </nav>
      
    </nav>
    <script src="scripts/navbar.js"></script>
    <div class="modal" id="modal5">
        <div class="modal-content">

            <div class="modal-header" align=center>
                Plus d'options
                <div class="icon modal-close modalClose"><i class="fa fa-close"></i></div>
            </div>
            <hr>
            <div class="modal-body">
                <div class="pop-up">
                    <p>Ajouter une transcription (sous-titres)</p>
                    <input type="file" name="caption" id="caption">
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
            if(isset($msg)){
                ?>
                <div class= "message">
                <h3>
                    <?=$msg;?>
                </h3>
                </div>
                <?php
            }else{
                ?>
                <div class= "message">
                <h3>
                </h3>
                </div>
                <?php
            }
            ?>
            <div class="post-body">
            <div class="preview">
                <div class="videoPl">
                    <div class="vid" >
                        <video src="" poster="" id="vid" class="vidPrev" loop></video>
                    </div>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <input type="number" name="quality" id="quality" hidden required>
                    <input type="number" name="duration" id="duration" hidden required>
                <div class="btns">
                <input type="button" class="btn btn-primary vidLnkBtn" value="Utiliser un URL">
                <div class="vidBtn">
                    <p class="vidInstr">Cliquez sur <span class="fa fa-video"></span> pour importer une video</p>
                    <div title="Cliquez ici" class="i vd" onclick="vidInp()"><i class="fa fa-video"></i></div>
                </div>
                <div class="title vidLnkFld" hidden>
                    <label for="lnk">Utiliser un URL</label>
                    <input type="url" name="Link" id="lnk" placeholder="Inserez ici le lien vers la video"onchange="previewLnk()" >
                </div>
                <div class="inputs" hidden onclick="hideMsg()">
                    <input type="text" value="scripts/controls/ico.png" id="logo">
                    <input type="file" accept="video/*" name="file" id="vidBtn">
                    <input type="file" accept="image/*" name="poster" id="imgBtn">
                </div>
                <input type="button" class="btn btn-primary imgLnkBtn" value="Utiliser un URL">
                <div class="title imgLnkFld" hidden>
                    <label for="posterLnk">Utiliser un URL</label>
                    <input type="url" name="posterLnk" id="posterLnk" placeholder="Inserez ici le lien vers la miniature" onchange="posterImg()">
                </div>
                <div class="vidBtn">
                    <p class="instruction">Cliquez sur <span class="fa fa-image"></span> pour importer une miniature</p>
                    <div class="imgPrev">
                        <img src="" width="190px" class="posterView" style="display:none;">
                    </div>
                    <div title="Cliquez ici" class="i im" onclick="imgInp()" ><i class="fa fa-image"></i></div>
                </div>
            <div class="title">
                <label for="title">Titre de la video</label>
                <input type="text" name="title" id="title" placeholder="Inserez ici le titre de la video" >
            </div>
                <div class="view">
                    <input type="button"  class="btn btn-primary pview" value="Previsualiser">
                    <!-- <input type="button"  class="btn btn-warning modal-open" data-modal="modal5" value="+ d'options"> -->
                    <input type="submit" class="btn btn-success" name="submit" value="Publier">
                </div>
            </div>
            </div>
            <div align=center class="post-footer">   
            </div>
        </form>
        <script src="scripts/modal.js"></script>
        <script src="Mobile/scripts/postScripts/player.js"></script>
        <script src="Mobile/scripts/postScripts/elements.js"></script>
        <script src="Mobile/scripts/postScripts/controls.js"></script>
        <script src="scripts/preview/postPreview.js"></script>
    </div>
</div>

</div>
</body>
</html>
    <?php
}else { 
    ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publier une video</title>
    <link rel="shortcut icon" href="scripts/controls/ico.png" type="image/x-icon">
    <link rel="stylesheet" href="styles\all\font-awesome.css">
    <link rel="stylesheet" href="styles/post/post.css">
    <link rel="stylesheet" href="styles/all/navbar.css">
</head>
<body>
<nav>
      <div class="menu-icon">
        <span class="fas fa-bars"></span>
      </div>
      <a href="./"><div class="logo"><img src="scripts/controls/ico.png" alt="logo"> OchoKOM</div></a>
      <div class="search-icon">
        <span class="fas fa-search"></span>
      </div>
      <div class="cancel-icon">
        <span class="fas fa-times" style="color: rgb(255, 61, 0);"></span>
      </div>
    <form action="search" method="get">
        <input name="q" type="search" class="search-data" placeholder="Chercher" required/>
        <button type="submit" class="fas fa-search"></button>
      </form>
      <div class="nav-items">
        <li><a href="./" >Accueil</a></li>
        <li><a href="#" class="active">Publier une vidéo</a></li>
        <li><a href="<?=$_SESSION['pseudo'];?>">Profil</a></li>
      </div>
      
    </nav>
      
    </nav>
    <script src="scripts/navbar.js"></script>
<br>
<br>
<div class="cont">
<div class="postcont" id="modal1">
    <div class="post-content">
            <?php
            if(isset($msg)){
                ?>
                <div class= "message">
                <h3>
                    <?=$msg;?>
                </h3>
                </div>
                <?php
            }
            ?>
        <form method="post" enctype="multipart/form-data">
            <input type="number" name="quality" id="quality" hidden required>
            <input type="number" name="duration" id="duration" hidden required>
            <div class="post-body">
            <div class="preview">
                <div class="btns">
                <input type="button" class="btn btn-primary vidLnkBtn" value="Utiliser un URL">
                <div class="vidBtn">
                    <p class="vidInstr">Cliquez sur <span class="fa fa-video"></span> pour importer une video</p>
                    <div title="Cliquez ici" class="i vd" onclick="vidInp()"><i class="fa fa-video"></i></div>
                </div>
                <div class="title vidLnkFld" hidden>
                    <label for="lnk">Utiliser un URL</label>
                    <input type="url" name="Link" id="lnk" placeholder="Inserez ici le lien vers la video"onchange="previewLnk()" >
                </div>
                <div class="inputs" hidden onclick="hideMsg()">
                    <input type="text" value="scripts/controls/ico.png" id="logo">
                    <input type="file" accept="video/*" name="file" id="vidBtn">
                    <input type="file" accept="image/*" name="poster" id="imgBtn">
                </div>
                <input type="button" class="btn btn-primary imgLnkBtn" value="Utiliser un URL">
                <div class="title imgLnkFld" hidden>
                    <label for="posterLnk">Utiliser un URL</label>
                    <input type="url" name="posterLnk" id="posterLnk" placeholder="Inserez ici le lien vers la miniature" onchange="posterImg()">
                </div>
                <div class="vidBtn">
                    <p class="instruction">Cliquez sur <span class="fa fa-image"></span> pour importer une miniature</p>
                    <div class="imgPrev">
                        <img src="" width="190px" class="posterView" style="display:none;">
                    </div>
                    <div title="Cliquez ici" class="i im" onclick="imgInp()" ><i class="fa fa-image"></i></div>
                </div>
            <div class="title">
                <label for="title">Titre de la video</label>
                <input type="text" name="title" id="title" placeholder="Inserez ici le titre de la video" >
            </div>
                <div class="view">
                    <input type="button"  class="btn btn-primary pview" value="Previsualiser">
                    <button type="submit" class="btn btn-success" name="submit">Publier</button>
                </div>
            </div>
            <div class="videoPl">
                <div class="vid" >
                    <video src="" poster="" id="vid" class="vidPrev" loop></video>
                </div>
            </div>
            </div>
            <div align=center class="post-footer">   
            </div>
        </form>
        <script src="scripts\preview\player.js"></script>
        <script src="scripts\preview\elements.js"></script>
        <script src="scripts\controls\postControls.js"></script>
        <script src="scripts\preview\postPreview.js"></script>
    </div>
</div>

</div>
</body>
</html>
    <?php
}



?>

