<?php
include_once('function/getTravelById.php');
include_once('function/sendReservation.php');
include_once('function/dbConnect.php');
include_once('function/getUserInfoByToken.php');

$travel = getTravelById($_GET["travelId"]);
$nbPassagers = intval($travel[0]["ag_nb_passagers"], 10);
$retirerMax =  intval($travel[0]["ag_ajout_passagers"], 10);
$max = 12 - $nbPassagers;
$listeTokenPassagers = explode(" ", $travel[0]["ag_liste_passagers"] );
$listePassagers = "";
foreach ($listeTokenPassagers as $index => $token) {
    if($token!= ""){
        $tempInfo = getUserInfoByToken($token);
        $listePassagers .= $tempInfo["us_prenom"]." ".$tempInfo["us_nom"].",";
    }
}
if($listePassagers === "" ){
    $listePassagers = "aucune réservation utilisateur";
}

if(isset($_POST["voyageModification"])){
    $nombre="0";
    if($_POST["ajoutPassager"] != "0"){
        $nombre = $_POST["ajoutPassager"];
    }elseif($_POST["retirerPassager"] != "0"){
        $nombre= "-".$_POST["retirerPassager"];
    }
    $bdd = dbConnect();
    $sql = "UPDATE `agenda` SET  `ag_ajout_passagers` = `ag_ajout_passagers` + :nombre ,`ag_nb_passagers` = `ag_nb_passagers` + :nombre , `ag_meteo`= :meteo, `ag_etat` = :etat  WHERE `ag_id` = :travelId";
    $stmt = $bdd->prepare($sql);
    $stmt->execute(['nombre' => $nombre, 'meteo' => $_POST["meteo"] , 'etat' => $_POST["etat"],  'travelId' => $_GET["travelId"]]);

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>navette - modifier voyage</title>
    <link rel="apple-touch-icon" href="icons/apple-icon-180.png">
    <link rel="manifest" href="manifest.json">
    <link rel="stylesheet" href="style/global.css">
    <link rel="stylesheet" href="style/modifierVoyage.css">
</head>
<body>
    <div class="navbar">
        <a class="navButton" href="./activity.php"><img src="assets/book.png" alt="activity icon"></a>
        <a class="navButton" href="./home.php"><img src="assets/ferry.png" alt="home icon"></a>
        <a class="navButton" href="./profil.php"><img src="assets/account.png" alt="profil icon"></a>
    </div>
    <a href="./home.php"><img src="assets/flecheDeRetour.png" alt="bouton de retour"></a>
    <div class="editContent">
    <h1>Modifier voyage</h1>
    <h2>du <?php echo $travel[0]["ag_date"];?></h2>
    <h2>à <?php echo $travel[0]["ag_heure"];?></h2>
    <div class="listeVoyageurs">
        <h3>liste des réservations:</h3>
        <p><?php echo$listePassagers ?></p>
    </div>
    <form action="" method="post"> 
        <div class="champ">
            <label for="meteo">Météo</label>
            <select class="input" name="meteo" id="meteo-select">
                <option value="0">non définie</option>
                <option value="1">jaune</option>
                <option value="2">orange</option>
                <option value="3">rouge</option>
            </select>    
        </div>

        <div class="champ">
            <label for="etat">Etat du voyage</label>
            <select class="input" name="etat" id="etat-select">
                <option value="libre">normal</option>
                <option value="prevu">prévu</option>
                <option value="annule">annuler</option>
            </select>
        </div> 

        <div class="champ">
            <label for="ajoutPassager">Ajouter des passagers</label>
            <input class="input" name="ajoutPassager" type="number" value="0" min="0" max="<?php echo $max; ?>">
        </div>

        <div class="champ">
            <label for="retirerPassager">Retirer des passagers</label>
            <input class="input" name="retirerPassager" type="number" value="0" min="0" max="<?php echo $retirerMax; ?>">
        </div>
        <input class="button" type="submit" value="Modifier voyage" name="voyageModification">

    </form>
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/service-worker.js');
        }
    </script>
</body>
</html>