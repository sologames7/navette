<?php
include_once('function/dbConnect.php');

include_once('function/getActivityById.php');

function rejectReservation($id, $message){
    $activity = getActivityById($id);
    
    $id = strval($id);
    $nbPersonne = $activity[0]["ac_nb_pers"];
    $user = $activity[0]["ac_user_token"];
    $user = $user . " ";
    $travel = $activity[0]["ac_travel_id"];

    try{
    $bdd1 = dbConnect();

    $sql = "UPDATE `activite` SET `ac_etat` = 'refuse', `ac_message` = :message WHERE `activite`.`ac_id` = :id ;";
    $stmt = $bdd1->prepare($sql);
    $stmt->execute(['id' => $id , 'message' => $message]);
    return ($message);

    } catch (PDOException $e) {
        return false;
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

?>