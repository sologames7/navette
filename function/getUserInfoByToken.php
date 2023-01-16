<?php
include_once('function/dbConnect.php');

function getUserInfoByToken($token){
    try{
    $bdd1 = dbConnect();
    $stmt1 = $bdd1->prepare("SELECT * FROM `user` WHERE us_token=?");
    $stmt1->execute([$token]); 
    $rep=$stmt1->fetch();
    if($rep!=false){
        return $rep;
    }else{
        return false;
    }
    $bdd1 = null;
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

?>