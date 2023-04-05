<?php
include_once('function/dbConnect.php');
include_once('function/getTravelById.php');

function sendReservation($array){
    $personnes = $array["nombreDePersonne"];
    $token = $array["userToken"];
    $message = $array["message"];
    $travelId = $array["travelId"];
    $travel = getTravelById($travelId);

    try{
    $bdd1 = dbConnect();
    $sql = "INSERT INTO `activite` (`ac_nb_pers`, `ac_user_token`, `ac_message`,`ac_travel_id`, `ac_date`, `ac_heure`) VALUES (:personnes, :token,:message, :travelId, :travelDate, :travelHour)";
    $stmt = $bdd1->prepare($sql);
    $stmt->execute(['personnes' => $personnes, 'token' => $token , 'message' => $message , 'travelId' => $travelId, 'travelDate' => $travel[0]["ag_date"], 'travelHour' => $travel[0]["ag_heure"]]);
    return true;

    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        return false;
        die();
    }
}

?>