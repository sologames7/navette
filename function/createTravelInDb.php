<?php
function createTravelInDb(){
    include_once('function/dbConnect.php');
    $todayDate = date('d-m-Y');
    $next_date = date('d-m-Y', strtotime($todayDate .' +1 day'));
    $travelTab = ['07H00 GIR > VIG', '07H15 VIG > GIR', '08H00 GIR > VIG','08H15 VIG > GIR', '09H00 GIR > VIG', '09H15 VIG > GIR','10H00 GIR > VIG','10H15 VIG > GIR', '11H00 GIR > VIG','11H15 VIG > GIR', '12H00 GIR > VIG' ,'12H15 VIG > GIR','14H00 GIR > VIG' ,'14H15 VIG > GIR','15H00 GIR > VIG','15H15 VIG > GIR', '16H00 GIR > VIG','16H15 VIG > GIR', '17H00 GIR > VIG','17H15 VIG > GIR', '18H00 GIR > VIG','18H15 VIG > GIR', '19H00 GIR > VIG','19H15 VIG > GIR' ];
    
    try{
    $bdd1 = dbConnect();
    $sql = "SELECT * FROM `agenda` WHERE `ag_date` = :todayDate";
    $stmt = $bdd1->prepare($sql);
    $stmt->execute(['todayDate' => $todayDate]);
    $rep = $stmt->fetch();

    if ($rep == false){
        $sql2 = "INSERT INTO `agenda` (`ag_heure`, `ag_date`) VALUES (:heure , :todayDate)";
        
        foreach ($travelTab as $key => $value) {
            $stmt2 = $bdd1->prepare($sql2);
            $stmt2->execute(['heure' => $value , 'todayDate'=> $todayDate]);
        }
    }

    $sql3 = "SELECT * FROM `agenda` WHERE `ag_date` = :nextDate";
    $stmt3 = $bdd1->prepare($sql3);
    $stmt3->execute(['nextDate' => $next_date]);
    $rep2 = $stmt3->fetch();

    if ($rep2 == false){
        $sql4 = "INSERT INTO `agenda` (`ag_heure`, `ag_date`) VALUES (:heure, :nextDate)";
        
        foreach ($travelTab as $key => $value) {
            $stmt4 = $bdd1->prepare($sql4);
            $stmt4->execute(['heure' => $value, 'nextDate'=> $next_date]);
        }
    }

    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

?>