<?php
include_once('function/getActivityById.php');
include_once('function/getTravelById.php');
include_once('function/dbConnect.php');


function cancelActivity($id, $etat){

    try{
    if($etat == "refuse" || $etat== "enAttente"){
        $bdd1 = dbConnect();
        $sql = "DELETE FROM `activite` WHERE `activite`.`ac_id` = :id";
        $stmt = $bdd1->prepare($sql);
        $stmt->execute(['id' => $id]);
        return true;
    }
    if($etat == "accepte"){
        $activity = getActivityById($id);
        if($activity != false){
            $travel = getTravelById($activity[0]['ac_travel_id']);

            $listePassagers = $travel[0]['ag_liste_passagers'];
            $passagers = explode(" ", $listePassagers);
            foreach ($passagers as $key => $value) {
                if($value == $activity[0]['ac_user_token']){
                    unset($passagers[$key]);
                }
            }
            $newList ="";
            foreach ($passagers as $key => $value) {
                $newList = $newList . $value ." ";
            }

            $bdd1 = dbConnect();
            $sql = "UPDATE `agenda` SET `ag_nb_passagers` = `ag_nb_passagers` - :nbPersonne , `ag_liste_passagers`= :newList WHERE `agenda`.`ag_id` = :travel";
            $stmt = $bdd1->prepare($sql);
            $stmt->execute(['nbPersonne' => $activity[0]['ac_nb_pers'], 'newList' => $newList , 'travel' => $activity[0]['ac_travel_id']]);

            $sql2 = "DELETE FROM `activite` WHERE `activite`.`ac_id` = :id";
            $stmt2 = $bdd1->prepare($sql2);
            $stmt2->execute(['id' => $id]);
            return true;
        }
    }else{
        return false;
    }

    } catch (PDOException $e) {
        return false;
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

?>