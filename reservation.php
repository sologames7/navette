<?php
include_once('function/getTravelById.php');
include_once('function/sendReservation.php');
include_once('function/dbConnect.php');

$travel = getTravelById($_GET["travelId"]);
$nbPassagers = intval($travel[0]["ag_nb_passagers"], 10);
$max = 12 - $nbPassagers;
$already = false;
$id = $_GET["travelId"];
$token = $_COOKIE["LOGGED_USER"];

$bdd1 = dbConnect();
$sql = "SELECT * FROM `activite` WHERE ac_user_token=:token AND ac_travel_id=:id";
$stmt = $bdd1->prepare($sql);
$stmt->execute(['id' => $id , 'token' => $token]);
$rep=$stmt->fetchAll();
if($rep!=false){
    $already = true;
}

if( $already){
    echo"<p class='ok'>Vous avez déjà une activité en cours, annuler la puis réessayez</p>";

}elseif(isset($_POST["demande"])){
    $success = sendReservation($_POST);

    if($success){
        echo"<p class='ok'>votre demande à bien été prise en compte</p>";
        header('Location:activity.php');
    }else{
        echo"une erreur est survenue";
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
    <link rel="stylesheet" href="style/reserver.css">
    <script src="firebase.js"></script>
</head>
<body>
    <div class="navbar">
        <a class="navButton" href="./activity.php"><img src="assets/book.png" alt="activity icon"></a>
        <a class="navButton" href="./home.php"><img src="assets/ferry.png" alt="home icon"></a>
        <a class="navButton" href="./profil.php"><img src="assets/account.png" alt="profil icon"></a>
    </div>
    <a href="./home.php"><img src="assets/flecheDeRetour.png" alt="bouton de retour"></a>
    
    <div class="resaContent">
        <h1>Voyage du <?php echo $travel[0]["ag_date"];?> à <?php echo $travel[0]["ag_heure"];?></h1>
        <div class="nombreDePassagers">
            <h2>Nombre actuel de passagers:</h2>
            <p class="nombre"><?php echo $travel[0]["ag_nb_passagers"] ?>/12</p>
        </div>
        <form action="" method="post">
            <input type="text" name="userToken" value="<?php echo $_COOKIE['LOGGED_USER'] ;?>" required hidden>
            <input type="text" name="travelId" value="<?php echo $_GET['travelId'] ;?>" required hidden>
            <p class="sous">Nombre de personne(s):</p>
            <input class="number" type="number" min="1" value="1" max="<?php echo $max; ?>" name="nombreDePersonne" required>
            <p class="sous">Message (facultatif):</p>
            <textarea name="message"></textarea>
            <input class="button sub" type="submit" value="reserver" name="demande">
        </form>
    </div>
</body>
</html>