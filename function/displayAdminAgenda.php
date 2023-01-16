<?php
include_once('function/dbConnect.php');

function displayAdminAgenda($travelTab){
    echo "<div class='agendaBody'>
    <div class='hagendaLine'> 
        <div class='hagendaCol color0'>Météo</div>
        <div class='hagendaCol'>Horaires</div>
        <div class='hagendaCol'>&Eacute;tat</div>
    </div>";

    foreach ($travelTab as $key => $line) {
            echo "<a  class='lineLink' href='modifierVoyage.php?travelId={$line['ag_id']}'>";

            if( $line["ag_etat"] === "annule"){
                echo "<div class='agendaLine noir'>";
            }elseif( $line["ag_etat"] === "prevu"){
                echo "<div class='agendaLine vert'>";
            }elseif(intval($line["ag_nb_passagers"], 10) >= 12 ){
                echo "<div class='agendaLine rouge'>";
            }elseif(intval($line["ag_nb_passagers"], 10) < 12  && intval($line["ag_nb_passagers"], 10) >= 1){
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
                echo "<div class='agendaNbPers red'>complet</div>";
            }elseif(  $line["ag_etat"] == "annule" ){
                echo "<div class='agendaNbPers'>pas de voyage</div>";
            }elseif( $line["ag_etat"] === "prevu"){
                echo "<div class='agendaNbPers'>{$line['ag_nb_passagers']}/12 passagers</div>";
            }else{
                echo "<div class='agendaNbPers'>non prévu</div>";
            }
                        
            echo "</div></a>";
    }
    echo "</div>";
}

?>