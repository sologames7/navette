<?php
include_once('function/dbConnect.php');

function login($email, $password ){
    $testName = false;
    $password = md5($password);
    try{
    $bdd1 = dbConnect();
    $stmt1 = $bdd1->prepare("SELECT * FROM `user` WHERE us_email=? AND us_password=? ORDER BY us_id DESC;");
    $stmt1->execute([$email, $password]); 
    $rep=$stmt1->fetch();
    if($rep!=false){
        $testName = true;
        if($rep["us_password"]==$password){
            $token=$rep["us_token"];
            return array(true, $token);
        }else{
            return array(false,false);
        }
    }else{
        return array(false,false);
    }

    $bdd1 = null;
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

?>