<?php
include_once('function/dbConnect.php');

function displayAgenda($travelTab){
    echo "<div class='agendaBody'>
    <div class='hagendaLine'> 
        <div class='hagendaCol color0'>Météo</div>
        <div class='hagendaCol'>Horaires</div>
        <div class='hagendaCol'>&Eacute;tat</div>
    </div>";

    foreach ($travelTab as $key => $line) {
        if( $line["ag_etat"] == "annule" || intval($line["ag_nb_passagers"], 10) >= 12 ){
            if( $line["ag_etat"] == "annule"){
                echo "<div class='lineLink'><div class='agendaLine noir'>";
            }elseif(intval($line["ag_nb_passagers"], 10) >= 12 ){
                echo "<div class='lineLink'><div class='agendaLine rouge'>";
            } 

            if($line['ag_meteo'] != null){
                echo "<div class='agendaMeteo color{$line['ag_meteo']}'></div>";
            }else{
                echo "<div class='agendaMeteo'></div>";
            }
            
            echo "<div class='agendaHour'>{$line['ag_heure']}</div>";

            if( $line["ag_etat"] == "annule" ){
                echo "<div class='agendaNbPers'>pas de voyage</div>";
            }elseif($line["ag_nb_passagers"] <= 0 && intval($line["ag_nb_passagers"], 10) < 12 ){
                echo "<div class='agendaNbPers'>{$line['ag_nb_passagers']}/12 passagers</div>";
            }elseif($line["ag_nb_passagers"] != 0 && intval($line["ag_nb_passagers"], 10) >= 12 ){
                echo "<div class='agendaNbPers'>complet</div>";
            }else{
                echo "<div class='agendaNbPers'>non prévu</div>";
            }
                    
            echo "</div></div>";
        }else{
            echo "<a class='lineLink' href='reservation.php?travelId={$line['ag_id']}'>";
            
            if($line["ag_nb_passagers"] != 0 && intval($line["ag_nb_passagers"], 10) < 12 ){
                echo "<div class='agendaLine vert'>";
            }elseif($line["ag_nb_passagers"] != 0 && intval($line["ag_nb_passagers"], 10) >= 12 ){
                echo "<div class='agendaLine rouge'>";
            }elseif( $line["ag_etat"] === "prevu"){
                echo "<div class='agendaLine vert'>";
            }else{
                echo "<div class='agendaLine grey'>";
            }
            if($line['ag_meteo'] != null){
                echo "<div class='agendaMeteo color{$line['ag_meteo']}'></div>";
                }else{
                    echo "<div class='agendaMeteo'></div>";
                }
            echo "<div class='agendaHour'>{$line['ag_heure']}</div>";


        
            if($line["ag_nb_passagers"] != 0 && intval($line["ag_nb_passagers"], 10) < 12 ){
                echo "<div class='agendaNbPers'>{$line['ag_nb_passagers']}/12 passagers</div>";
            }elseif($line["ag_nb_passagers"] != 0 && intval($line["ag_nb_passagers"], 10) >= 12 ){
                echo "<div class='agendaNbPers'>complet</div>";
            }elseif( $line["ag_etat"] === "prevu"){
                echo "<div class='agendaNbPers'>{$line['ag_nb_passagers']}/12 passagers</div>";
            }else{
                echo "<div class='agendaNbPers'>non prévu</div>";
            }
                        
            echo "</div></a>";
                }
    }
    echo "</div>";
}

?>