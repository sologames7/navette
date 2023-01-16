<?php
include_once('function/dbConnect.php');
include_once('function/getUserInfoByToken.php');

function displayAdminActivity($adminActivity){
    if($adminActivity == false){
        echo "Aucune activité en cours";
    }else{
        foreach ($adminActivity as $key => $activity) {
            $user = getUserInfoByToken($activity['ac_user_token']);
            echo "<div class='activityBody {$activity['ac_etat']}'>
                            <h3>{$user['us_prenom']} {$user['us_nom']}</h3>
                            <p>Trajet du {$activity['ac_date']}</p>
                            <p>à {$activity['ac_heure']}</p>
                            <p>pour {$activity['ac_nb_pers']} personne(s) | état: {$activity['ac_etat']}</p>";
            if($activity['ac_message'] != ""){
                echo "<p>Message: {$activity['ac_message']}</p>";
            }
            if($activity['ac_etat'] == "enAttente"){
                            
                            echo "<div class='boutonsAction'>
                            <form action='' method='post'>
                                <input type='text' name='activityId' value='{$activity['ac_id']}' hidden>
                                <input type='text' name='activityMessage' value='{$activity['ac_message']}' hidden>
                                <input class='petitBoutton vert' type='submit' name='accept' value='Valider' onclick='return confirm(&quot;Vous confirmez la validation de cette demande?\")'>
                                <input class='champTexte' type='text' name='newMessage' placeholder='message de confirmation(facultatif)'>
                            </form>
                            <form action='' method='post'>
                                <input type='text' name='activityId' value='{$activity['ac_id']}' hidden>
                                <input type='text' name='activityMessage' value='{$activity['ac_message']}' hidden>
                                <input class='champTexte' type='text' name='newMessage' placeholder='message de refus(facultatif)'>
                                <input class='petitBoutton rouge' type='submit' name='reject' value='Refuser' onclick='return confirm(&quot;Vous confirmez le refus de cette demande?\")'>
                            </form>";}
                        echo "</div></div>";
            }
    }
    
}

?>