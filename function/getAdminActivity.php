<?php
include_once('function/dbConnect.php');

function getAdminActivity(){
    $todayDate = date('d-m-Y');
    $next_date = date('d-m-Y', strtotime($todayDate .' +1 day'));
    try{
    $bdd1 = dbConnect();
    $stmt1 = $bdd1->prepare("SELECT * FROM `activite` WHERE ac_date= :tomorow OR ac_date= :today ORDER BY ( case ac_etat when 'enAttente' then 0 when 'accepte' then 1 when 'refuse' then 2 end ), ac_id DESC");
    $stmt1->execute([ "today"=> $todayDate, "tomorow"=> $next_date ]);
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