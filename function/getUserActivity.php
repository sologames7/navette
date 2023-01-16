<?php
include_once('function/dbConnect.php');

function getUserActivity($token){
    try{
    $bdd1 = dbConnect();
    $stmt1 = $bdd1->prepare("SELECT * FROM `activite` WHERE ac_user_token=? ORDER BY ac_id DESC");
    $stmt1->execute([$token]);
    $rep=$stmt1->fetchAll();
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