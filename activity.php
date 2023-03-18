<?php
include_once('function/isAdmin.php');
include_once('function/getUserActivity.php');
include_once('function/getAdminActivity.php');
include_once('function/displayUserActivity.php');
include_once('function/displayAdminActivity.php');
include_once('function/rejectReservation.php');
include_once('function/acceptReservation.php');
include_once('function/cancelActivity.php');


if(isset($_COOKIE["LOGGED_USER"])){
    $isAdmin = isAdmin($_COOKIE["LOGGED_USER"]);
}else{
    header('Location:loginPage.php');
}

if(isset($_POST["cancelActivity"])){
    $cancelAct = cancelActivity($_POST["activityId"], $_POST["activityEtat"]);
    header('Location:activity.php');
}

if(isset($_POST["accept"])){
    $acceptAct = acceptReservation($_POST["activityId"], $_POST["newMessage"]);
    header('Location:activity.php');
}

if(isset($_POST["reject"])){
    $acceptAct = rejectReservation($_POST["activityId"],  $_POST["newMessage"]);   
    header('Location:activity.php');
}

$userActivity = getUserActivity($_COOKIE["LOGGED_USER"]);
$AdminActivity = getAdminActivity();

if(isset($_POST["cancelActivity"])){
    cancelActivity($_POST["activityId"], $_POST["activityEtat"]);
    header('Location:activity.php');
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
    <link rel="stylesheet" href="style/activity.css">

</head>
<body>
    <div class="navbar">
        <a class="navButton" href="./activity.php"><img src="assets/bookB.png" alt="activity icon"></a>
        <a class="navButton" href="./home.php"><img src="assets/ferry.png" alt="home icon"></a>
        <a class="navButton" href="./profil.php"><img src="assets/account.png" alt="profil icon"></a>
    </div>
    <h1>Mes activités</h2>
    <div class="activitiesList">
        
        <?php
        if(!$isAdmin){
            displayUserActivity($userActivity);
        }
        if($isAdmin){
            displayAdminActivity($AdminActivity);
        }
        ?>
    </div>
</body>
</html>