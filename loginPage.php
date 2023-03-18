<?php
include_once('function/login.php');
include_once('function/dbConnect.php');

    if(isset($_POST["email"]) && isset($_POST["password"])){
        $isValidLogin = login($_POST["email"] , $_POST["password"]);
        if($isValidLogin[0]){
            setcookie(
                'LOGGED_USER',
                $isValidLogin[1],
                [
                    'expires' => time() + 365*24*3600,
                    'secure' => true,
                    'httponly' => true,
                ]
            );
            header('Location:home.php?token='. $isValidLogin[1] .'');
        }
    }
    elseif(isset($_GET["logout"])){
        setcookie(
            'LOGGED_USER',
                'loggedout',
                [
                    'expires' => time() + 365*24*3600,
                    'secure' => true,
                    'httponly' => true,
                ]
        );
    }
    
    elseif(isset($_COOKIE["LOGGED_USER"])){
        header('Location:home.php?token='. $_COOKIE["LOGGED_USER"] .'');
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
    <link rel="stylesheet" href="style/login.css">
    <link rel="stylesheet" href="style/global.css">
</head>
<body>
    <section class="loginPageBody">
        <img class="divLogo" src="logo.png" alt="logo">
        <form class="form" method="post" action="#">
            <?php
            if(isset($isValidLogin[0]) && $isValidLogin[0] === false){
                echo "<p>mot de passe ou email incorrect</p>";
            }
            ?>
            <input class="field" type="email" name ="email" placeholder="Adresse mail" required>
            <div class="inputAndLink">
                <input class="field" type="password" name="password" placeholder="Mot de passe" required>
                <a class="lien" href="forgotPassword.php">j'ai oublié mon mot de passe</a>
            </div>
            <input class="button" type="submit" name="login" value="connexion">
        </form>
        <a  class="lien" href="registerPage.php">pas encore de compte ? S'inscrire</a>
    </section>
    

    
</body>
</html>