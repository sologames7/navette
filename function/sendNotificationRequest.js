//la fonction à appeler pour envoyer une notification
const sendNotificationRequest = async (tokenTable, pushMessage) => {
    const response = await fetch('https://425c94f.online-server.cloud:3443/send-notification', {
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