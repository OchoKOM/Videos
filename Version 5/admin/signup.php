<?php
require('../php/signupAction.php');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="admin/style.css">
</head>

<body style="--bg:#0a0a0a">

    <form method="post" style="--clr:#4ff321" class="card signup">
        <h2 style="--clr:#4ff321">Inscription</h2>
        <?php
        if (isset($msg)) {
        ?>
        <div class="oth"><span id="a" class="a" style="--clr:#ff1b69">
                <?= $msg; ?>
            </span></div>
        <?php
        }
        ?>

        <div class="inputBox">
            <input type="text" name="pseudo" required>
            <span>Pseudo</span>
            <i></i>
        </div>
        <div class="inputBox">
            <input type="password" name="mdp" required>
            <span>Mot de passe</span>
            <i></i>
        </div>
        <div class="inputBox">
            <input type="password" name="mdp1" required>
            <span>Confirmer</span>
            <i></i>
        </div>
        <div class="oth">
            <span id="a" class="a" style="--clr:#4ff321;">
                <input style="cursor:pointer;accent-color:#1e9bff;" type="checkbox" name="rememberme" id="rememberme"> 
                <label for="rememberme"> Se souvenir de moi </label>
            </span>
        </div>
        <a style="--clr:#4ff321"><button name="valider">S'inscrire</button></a>
        <span class="a" style="--clr:#1e9bff">J'ai déjà un compte</span>
        <a href="login" style="--clr:#1e9bff">
            <p>Se connecter</p>
        </a>
    </form>
</body>

</html>