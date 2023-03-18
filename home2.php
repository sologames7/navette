<?php
include_once('function/isAdmin.php');
include_once('function/getDayTravels.php');
include_once('function/displayAgenda.php');
include_once('function/displayAdminAgenda.php');
include_once('function/createTravelInDb.php');
include_once('function/dbConnect.php');



createTravelInDb();

if(isset($_COOKIE["LOGGED_USER"])){
    $isAdmin = isAdmin($_COOKIE["LOGGED_USER"]);
}else{
    header('Location:./loginPage.php?logout=deconnexion');
}

if (isset($_GET["token"]))
    {
        $GETtoken = $_GET["token"];
 
        // connect with database
        $conn = mysqli_connect("db5008549598.hosting-data.io", "dbu3999208", "Seninu(618)!", "dbs7177894");
 
        // check if credentials are okay, and email is verified
        $sql = "SELECT * FROM user WHERE us_token = '" . $GETtoken . "' ORDER BY us_id DESC";
        $result = mysqli_query($conn, $sql);
 
        if (mysqli_num_rows($result) == 0)
        {
            header('Location:loginPage.php?logout=deconnexion');
        }
 
        $user = mysqli_fetch_object($result);
 
        if ($user->email_verified_at == null)
        {
            die("Veuillez verifier votre email <a href='email-verification.php?email=" . $user->us_email . "'>en cliquant ici</a>");
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
    <link rel="stylesheet" href="style/home.css">
    <link rel="apple-touch-icon" href="icons/apple-icon-180.png">
    <link rel="manifest" href="manifest.json">
    <link rel="stylesheet" href="style/global.css">
    <link rel="stylesheet" href="style/home.css">
</head>
<body>
    <div class="navbar">
        <a class="navButton" href="./activity.php"><img src="assets/book.png" alt="activity icon"></a>
        <a class="navButton" href="./home.php"><img src="assets/ferryB.png" alt="home icon"></a>
        <a class="navButton" href="./profil.php"><img src="assets/account.png" alt="profil icon"></a>
    </div>
   
    <div class="navNext">
        <a href="home.php"><img src="assets/leftArrow.png" alt="fleche"></a>
        <div class="topDate">
            <p class="date topP">Demain</p>
            <p class="topP"><?php echo date('d-m', strtotime(date('d-m-Y') .' +1 day')) ?></p>
        </div>
        <img src="assets/rightArrowGrey.png" alt="fleche">
    </div>

    <?php 
        $hoursTable = getDayTravels(date('d-m-Y', strtotime(' +1 day')));
        if($isAdmin){
            displayAdminAgenda($hoursTable); 
        }else{
            displayAgenda($hoursTable); 
        }
    ?>

    
</body>
</html>