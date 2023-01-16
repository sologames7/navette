<?php
include_once('function/dbConnect.php');

function dbConnect(){
    
    try {
        $user = "dbu3999208";
        $pass= "Seninu(618)!";
        $dbh = new PDO('mysql:host=db5008549598.hosting-data.io;dbname=dbs7177894', $user, $pass);
        return $dbh;
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}
?>
