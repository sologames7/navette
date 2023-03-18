<?php
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

    function sendNotificationToAdmins($tokenTable, $pushMessage){
        $jscode = "sendNotificationRequest($tokenTable ,$pushMessage)";
        echo "<script>eval($jscode);</script>";
    }

?>