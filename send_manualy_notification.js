// envoie une notification push manuellement à un utilisateur en fonction de son token et d'un message à modifier dans le code
const response = await fetch('https://425c94f.online-server.cloud:3443/send-notification', {
    method: 'post',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      tokenTable: ['348004382902b49724796fd7304dac2c'],
      pushMessage: 'salut salut 21:51'
    }),
  })


  
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