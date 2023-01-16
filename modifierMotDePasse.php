<?php
include_once('function/dbConnect.php');

if(isset($_GET['submit'])){
    $validMdp=false;
}

if(isset($_GET['submit'])){
    var_dump($_GET);
    if($_GET["mdp"] === $_GET["mememdp"]){
        $validMdp=true;
        $ashedMdp= md5($_GET['mdp']);
        echo $ashedMdp;
        $bdd = dbConnect();
        $sql = "UPDATE `user` SET  `us_password` = :password WHERE `us_email` = :email order by email_verified_at DESC";
        $stmt = $bdd->prepare($sql);
        $stmt->execute(['password' => $ashedMdp, 'email' => $_GET['email']]);
        echo "mot de passe changé avec succès";
        header('Location:loginPage.php?changedPassword=true');
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
</head>
<body>
    <h1>Récupérer le mot de passe pour <?php echo $_GET['email'];?></h1>
    <form action="" method="get">
        <?php if(isset($validMdp) && $validMdp===false){
            echo "mots de passe différents";
        }  ?>
        <input type="password" name="mdp" placeholder="nouveau mot de passe">
        <input type="password" name="mememdp" placeholder="confirmer mot de passe">
        <input type="text" name="email" value="<?php echo $_GET['email'] ?>" hidden>
        <input type="submit" name="submit" value="valider">
    </form>
</body>
</html>