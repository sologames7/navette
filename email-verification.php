<?php
include_once('function/dbConnect.php');

 
    if (isset($_POST["verify_email"]))
    {
        $email = $_POST["email"];
        $verification_code = $_POST["verification_code"];
 
        // connect with database
        // $bdd1 = new PDO('mysql:host=db5008549598.hosting-data.io;dbname=dbs7177894', "dbu3999208", "Seninu(618)!");
        $conn = mysqli_connect("db5008549598.hosting-data.io", "dbu3999208", "Seninu(618)!", "dbs7177894");

        // mark email as verified
        $sql = "UPDATE user SET email_verified_at = NOW() WHERE us_email = '" . $email . "' AND verification_code = '" . $verification_code . "'";
        // $stmt= $bdd1->prepare($sql);
        // $stmt->execute();
        $result  = mysqli_query($conn, $sql);
        // $bdd = null;
 
        if (mysqli_affected_rows($conn) == 0)
        {
            die("Code de vérification incorrect.");
        }
 
        echo "<p>Vous pouvez maintenant vous connecter.</p><a href='loginPage.php'>se connecter</a>";
        exit();
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
    <link rel="stylesheet" href="style/emailVerification.css">
</head>
<body>
    <div class="info"><p>Vous avez reçu un code par mail de <b>contact@navette.port-girolata.com</b> qui a pour objet "Navette vignola" </p></div>
    <form action="" method="POST">
        <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>" required>
        <input class="field"type="text" name="verification_code" placeholder="Code de vérification" required />
    
        <input class="button" type="submit" name="verify_email" value="Vérifier Email">
    </form>
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/service-worker.js');
        }
    </script>
</body>
</html>