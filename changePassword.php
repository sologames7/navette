<?php
include_once('function/isAdmin.php');
include_once('function/getUserInfoByToken.php');
include_once('function/changePassword.php');

if(isset($_COOKIE["LOGGED_USER"])){
    $isAdmin = isAdmin($_COOKIE["LOGGED_USER"]);
    $userInfo = getUserInfoByToken($_COOKIE["LOGGED_USER"]);
}else{
    header('Location:loginPage.php');
}

if(isset($_POST["oldPassword"])){
    if((md5($_POST["oldPassword"]) === $userInfo["us_password"])){
        if($_POST["newPassword"] === $_POST["newPasswordConfirm"]){
            $statePSD = changePassword($_COOKIE["LOGGED_USER"], $_POST["newPassword"]);
            header('Location:profil.php');
        }else{
        $failMessage = "mots de passe différents";
        }
    }else{
        $failMessage = "mot de passe incorect";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="apple-touch-icon" href="icons/apple-icon-180.png">
    <link rel="manifest" href="manifest.json">
    <link rel="stylesheet" href="style/global.css">
    <link rel="stylesheet" href="style/changePassword.css">
</head>
<body>

    <a href="./profil.php"><img src="assets/flecheDeRetour.png" alt="bouton de retour"></a>
    <form method="post" action="">
            <h2>Modifier mot de passe</h2>
            <input class="field" type="password" name="oldPassword" placeholder="ancien mot de passe" required>
            <input class="field" type="password" name="newPassword" placeholder="nouveau mot de passe" required>
            <input class="field" type="password" name="newPasswordConfirm" placeholder="confirmer mot de passe" required>
            <?php
            if(isset($failMessage)){
                echo $failMessage;
            }
            ?>
            <input class="button" type="submit" value="valider">
    </form>
</body>
</html>