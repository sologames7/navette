<?php
include_once('function/dbConnect.php');

//Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
 
    //Load Composer's autoloader
    require 'vendor/autoload.php';
    
    $testMailExist = false;
    if(isset($_POST["email"])){
        $bdd1 = dbConnect();

        $stmt1 = $bdd1->prepare("SELECT email_verified_at FROM `user` WHERE us_email=?");
        $stmt1->execute([$_POST["email"]]); 
        $rep=$stmt1->fetch();
        if($rep==false){
            $testMailExist = true;
        }elseif($rep[0]==NULL){
            $testMailExist = true;
        }else{
            $emailErr ='adresse mail déjà utilisé';
        }

        
        $bdd1 = null;
        }
    
    $psdMatch = false;
    if(isset($_POST["password"])){
        if($_POST["password"] === $_POST["confirmPassword"]){
            $psdMatch = true;
        }else{
            $psdErr = "mots de passe différents";
        }
    }

    if (isset($_POST["register"]) && $psdMatch && $testMailExist)
    {
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $age = $_POST["age"];
        $email = $_POST["email"];
        $password = md5($_POST["password"]);
        
 
        //Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);
 
        try {
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
 
            $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
 
            $mail->Subject = 'Email verification';
            $mail->Body    = '<p>Votre code de vérification est: <b style="font-size: 30px;">' . $verification_code . '</b></p>';
 
            $mail->send();
            // echo 'Message has been sent';
 
            // connect with database

            // insert in users table
            try {
                $bdd = dbConnect();
                $token = bin2hex(openssl_random_pseudo_bytes(16));
                $data = [
                    'password' => $password,
                    'token' => $token,
                    'age' => $age,
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'email' => $email,
                    'verifCode' => $verification_code,
                ];
                $sql = "INSERT INTO `user` (`us_password`, `us_token`, `us_age`, `us_nom`, `us_prenom`, `us_email`, `verification_code`, `email_verified_at`) VALUES (:password, :token, :age, :nom, :prenom, :email, :verifCode , NULL)";
                $stmt= $bdd->prepare($sql);
                $stmt->execute($data);
                $bdd = null;
            } catch (PDOException $e) {
                print "Erreur !: " . $e->getMessage() . "<br/>";
                die();
            }
 
            header("Location: ./email-verification.php?email=" . $email);
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    
    if(isset($_COOKIE["LOGGED_USER"])){
        unset($_COOKIE["LOGGED_USER"]);
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
    <link rel="stylesheet" href="style/register.css">
    <link rel="stylesheet" href="style/global.css">
</head>
<body>
    <img class="divLogo" src="logo.png" alt="logo">
    <a class="lien" href="loginPage.php">J'ai déjà un compte, je me connecte.</a>
    <form class="registerForm" method="post" action="#">
            <input class="field" type="email" name ="email" placeholder="email" required>
            <?php if(isset($emailErr)){
                echo $emailErr;

                $testMail = false;
                if(isset($_POST["email"])){
                    $email = $_POST["email"];
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $emailErr = "Invalid email format";
                        echo $emailErr;
                    }else{
                        $testMail=true;
                    }
                }
            }?>
            <input class="field" type="text" name ="nom" placeholder="nom" required>
            <input class="field" type="text" name ="prenom" placeholder="prenom" required>
            <input class="field" type="number" name ="age" placeholder="age" required>
            <input class="field" type="password" name="password" placeholder="mot de passe" minlength="6" required>
            <input class="field" type="password" name="confirmPassword" placeholder="confirmer mot de passe" minlength="6" required>
            <?php if(isset($psdErr)){
                echo $psdErr;
            }?>
            <input class="button" name="register" type="submit" value="s'inscrire">
        </form>
    

</body>
</html>