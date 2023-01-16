<?php
include_once('function/dbConnect.php');

function isAdmin($token){
    try{
    $bdd1 = dbConnect();
    $stmt1 = $bdd1->prepare("SELECT * FROM `user` WHERE us_token=?");
    $stmt1->execute([$token]); 
    $rep=$stmt1->fetch();
    if($rep!=false && $rep["us_permission"]=="admin"){
        return true;
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