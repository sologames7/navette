<?php
include_once('function/dbConnect.php');

function getDayTravels($day){
    $testDate = '2022-06-21';
    

    try{
    $bdd1 = dbConnect();
    $sql = "SELECT * FROM `agenda` WHERE `ag_date` = :day";
    $stmt = $bdd1->prepare($sql);
    $stmt->execute(['day' => $day]);
    $rep = $stmt->fetchAll();

    if ($rep != false){
        return $rep;
    }elseif($rep == false){
        return false;
    }

    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

?>