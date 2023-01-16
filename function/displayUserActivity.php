<?php
include_once('function/dbConnect.php');

function displayUserActivity($userActivity){
    if($userActivity == false){
        echo "Aucune activité en cours";
    }else{
        foreach ($userActivity as $key => $activity) {
            echo "<div class='activityBody {$activity['ac_etat']}'>
                            <p>Trajet du {$activity['ac_date']}</p>
                            <p>à {$activity['ac_heure']}</p>
                            <p>pour {$activity['ac_nb_pers']} personne(s) | état: {$activity['ac_etat']}</p>";
            if($activity['ac_message'] != ""){
                echo "<p>Message: {$activity['ac_message']}</p>";
            }
            echo "<form action='' method='post'>
            <input type='text' name='activityId' value='{$activity['ac_id']}' hidden>
            <input type='text' name='activityEtat' value='{$activity['ac_etat']}' hidden>
            <input class='annule' type='submit' name='cancelActivity' value='Annuler' onclick='return confirm(&quot;Voulez vous vraiment annuler cette demande?\")'>
                </form></div>";
        }
    }
    
}

?>