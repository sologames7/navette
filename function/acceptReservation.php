<?php
include_once('function/getActivityById.php');
include_once('function/dbConnect.php');


function acceptReservation($id, $message){
    $activity = getActivityById($id);
    
    $id = strval($id);
    $nbPersonne = $activity[0]["ac_nb_pers"];
    $user = $activity[0]["ac_user_token"];
    $user = $user . " ";
    $travel = $activity[0]["ac_travel_id"];

    try{
    $bdd1 = dbConnect();

    $sql = "UPDATE `activite` SET `ac_etat` = 'accepte', `ac_message` = :message WHERE `activite`.`ac_id` = :id ;";
    $stmt = $bdd1->prepare($sql);
    $stmt->execute(['id' => $id , 'message' => $message]);

    $sql = "UPDATE `agenda` SET `ag_nb_passagers` = `ag_nb_passagers` + :nbPersonne , `ag_liste_passagers`=concat(`ag_liste_passagers`, :user) WHERE `agenda`.`ag_id` = :travel";
    $stmt = $bdd1->prepare($sql);
    $stmt->execute(['nbPersonne' => $nbPersonne, 'user' => $user , 'travel' => $travel]);

    return ($message);

    } catch (PDOException $e) {
        return false;
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

?>