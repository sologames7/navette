
<?php
include_once('function/dbConnect.php');

function changePassword($usToken, $newPassword){
    $newPasswordHash = md5($newPassword);
    try{
    $bdd1 = dbConnect();
    $data = [
        'password' => $newPasswordHash,
        'token' => $usToken
    ];
    $sql = "UPDATE `user` SET `us_password`=:password WHERE `user`.`us_token` =:token";
    $stmt= $bdd1->prepare($sql);
    $stmt->execute($data);
    return "Changement éffectué";
    $bdd1 = null;
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

?>