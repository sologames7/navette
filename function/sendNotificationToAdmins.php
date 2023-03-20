<?php
    include_once('function/dbConnect.php');
    function sendNotificationToAdmins($pushMessage){
        try{
            $tokenTable = [];
            $bdd1 = dbConnect();
            $sql = "SELECT * FROM `user` WHERE us_permission='admin'";
            $reponse = $bdd1->query($sql);
            
            if($reponse->rowCount() > 0){
                while($donnees = $reponse->fetch()){
                    array_push($tokenTable, $donnees["us_token"]);
                }
            }else{
                return false;
            }
            $bdd1 = null;
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        echo "<script>
            const sendNotificationRequest = async (tokenTable, pushMessage) => {  const response = await fetch('https://425c94f.online-server.cloud:3443/send-notification', {
                method: 'post',
                headers: {
                'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                tokenTable: tokenTable,
                pushMessage: pushMessage
                }),
                })
                const data = await response.json()
                console.log(data)
                }
         </script>";
        $jscode = "sendNotificationRequest($tokenTable ,$pushMessage)";
        echo "<script>eval($jscode);</script>";
    }

?>