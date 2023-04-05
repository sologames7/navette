<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navette</title>
    <link rel="apple-touch-icon" href="icons/apple-icon-180.png">
    <link rel="manifest" href="manifest.json">
    <link rel="stylesheet" href="style/global.css">
    <link rel="stylesheet" href="style/profil.css">
    <script type="module" src="firebase.js"></script>
</head>

<?php
include_once('function/isAdmin.php');
include_once('function/getUserInfoByToken.php');
include_once('function/dbConnect.php');

if(isset($_COOKIE["LOGGED_USER"])){
    $isAdmin = isAdmin($_COOKIE["LOGGED_USER"]);
    $userInfo = getUserInfoByToken($_COOKIE["LOGGED_USER"]);
}else{
    header('Location:loginPage.php');
}

if(isset($_COOKIE["firebaseToken"])){
    $firebaseToken = $_COOKIE["firebaseToken"];
    $bdd = dbConnect();
    $req = $bdd->prepare("UPDATE user SET us_firebase_token = ? WHERE us_token = ?");
    $stmt->execute(array($firebaseToken, $_COOKIE["LOGGED_USER"]));
}

if(isset($_POST["sentHide"])){
}
?>

<body>
    <div class="navbar">
        <a class="navButton" href="./activity.php"><img src="assets/book.png" alt="activity icon"></a>
        <a class="navButton" href="./home.php"><img src="assets/ferry.png" alt="home icon"></a>
        <a class="navButton" href="./profil.php"><img src="assets/accountB.png" alt="profil icon"></a>
    </div>
    <a href="./home.php"><img src="assets/flecheDeRetour.png" alt="bouton de retour"></a>
    <div class="profilPageContent">
        <img src="assets/iconProfil.png" alt="icon de profil">
        <h2>Bonjour <?php echo $userInfo["us_prenom"]; ?></h2>

        <div class="buttonsArea">
            <form action="changePassword.php">
                <input class="button fontsize buttonGap" type="submit" value="Changer mon mot de passe">
            </form>

            <!-- BOUTON DE NOTIFS -->
            <button class="button buttonGap" id="permission-btn">Activer notifications</button>
            <!--  -->

            <form method="get" action="loginPage.php">
                <input name="logout" class="button red buttonGap" type="submit" value="Deconnexion">
            </form>
        </div>
        
    </div>

    
    <script src="profil.js"></script>
</body>
</html>