<?php
include_once('function/dbConnect.php');

function getTravelById($id){
    try{
    $bdd1 = dbConnect();
    $stmt1 = $bdd1->prepare("SELECT * FROM `agenda` WHERE ag_id=?");
    $stmt1->execute([$id]); 
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