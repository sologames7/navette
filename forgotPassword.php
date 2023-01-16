<?php
include_once('function/dbConnect.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
 
//Load Composer's autoloader
require 'vendor/autoload.php';


$testMailExist = false;
    if(isset($_POST["email"])){
        $bdd1 = dbConnect();

        $stmt1 = $bdd1->prepare("SELECT * FROM `user` where us_email=?");
        $stmt1->execute([$_POST["email"]]); 
        $rep=$stmt1->fetch();
        if($rep==false){
            $testMailExist = false;
        }elseif($rep!=false){
            $testMailExist = true;
        }

        
        $bdd1 = null;
        }
    

    if ($testMailExist && isset($_POST["email"])){
        $nom = "Utilisateur";
        $email = $_POST["email"];
        
 
        //Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);
 
        try{
            //Enable verbose debug output
            $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;
 
            //Send using SMTP
            $mail->isSMTP();
 
            //Set the SMTP server to send through
            $mail->Host = 'smtp.ionos.fr';
 
            //Enable SMTP authentication
            $mail->SMTPAuth = true;
 
            //SMTP username
            $mail->Username = 'contact@navette.port-girolata.com';
 
            //SMTP password
            $mail->Password = 'seninu618';
 
            //Enable TLS encryption;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
 
            //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $mail->Port = 465;
 
            //Recipients
            $mail->setFrom('contact@navette.port-girolata.com', 'Navette Vignola');
 
            //Add a recipient
            $mail->addAddress($email, $nom);
 
            //Set email format to HTML
            $mail->isHTML(true);
 
            $mail->Subject = 'Navette: modifier mon mot de passe';
            $mail->Body    = '<p>Bonjour, cliquez <a href="https://navette.port-girolata.com/modifierMotDePasse.php?email='.$email.'">ici</a> pour changer de mot de passe.</p>';
 
            $mail->send();
            echo "<div class='message'>Vous avez reçu un mail à l'adresse: <b>".$_POST["email"]."</b> vous permettant de réinitialiser votre mot de passe</div>";

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="formContainer">
        <h2>Changer de mot de passe</h2>
        
        <form method="post" action="">
            <p>entrez votre email</p>
            <input name="email" type="email" required>
            <input name="submitMail" type="submit">
        </form>
        <?php
        if($testMailExist==false && isset($_POST["submitMail"])){
        echo "adresse mail inconue.";
        }
        ?>
    </div>
</body>
</html>