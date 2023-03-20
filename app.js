const express = require('express')
const https = require('https')
const path = require('path')
const fs = require('fs')
const cors = require('cors')
const bodyParser = require('body-parser')
const webpush = require('web-push')
var mysql = require('mysql')

//local db connexion
var con = mysql.createConnection({
  host: "localhost",
  user: "root",
  password: "seninu618",
});
 
con.connect(function(err) {
  if (err) throw err;
  console.log("DB Connected!");
});


const app = express()

app.use(cors())
app.use(bodyParser.json())

const dummyDb = { subscription: null } //dummy in memory store

const saveToDatabase = async (subscription, token) => {
  console.log('saving user to database (token: ' +token)
  let subField = JSON.stringify(subscription)
  //VERIFIE SI L'UTILISATEUR A DEJA ETE INSCRIT
  let sqlVerif = `SELECT * FROM navette.userEndpoint WHERE userToken = '${token}'`
  let userExist = true
  con.query(sqlVerif, function (err, result) {
    if (err) throw err
    if(JSON.stringify(result)== '[]'){
      userExist = false
    }
  });

  if(userExist){
    let sqlDel = `DELETE FROM navette.userEndpoint WHERE userToken = '${token}'`
    con.query(sqlDel, function (err, result){
      if (err) throw err
    })
  }
  let sql = `INSERT INTO navette.userEndpoint (id, userToken, userEndpointStringify) VALUES (NULL,'${token}',  '${subField}' );`

  con.query(sql, function (err, result) {
    if (err) throw err
    console.log("Result: " + JSON.stringify(result))
  });


  // dummyDb.subscription = subscription
}

// The new /save-subscription endpoint
app.post('/save-subscription', async (req, res) => {
  try {
    const subscription = req.body.sub
    const token = req.body.userToken
    await saveToDatabase(subscription, token ) //Method to save the subscription to Database
    res.json({ message: "Enregistré dans la base de données du serveur"})
  } catch (error) {
    console.log(error);
  }
})

const vapidKeys = {
  publicKey:
    'BCNPy1TUfqYbs6cU6uXwBrlmEyouxFm-L78hQiZvs4sDafI7fgvtvL8vKdtjBTeP16-d8GnsFWNNdGfjQwBdwK4',
  privateKey: 'NTFMeKwgnyOmnuJzrdU9kJx2D1shbJgA37odjSofYPc',
}

//setting our previously generated VAPID keys
webpush.setVapidDetails(
  'mailto:myuserid@email.com',
  vapidKeys.publicKey,
  vapidKeys.privateKey
)

//function to send the notification to the subscribed device
const sendNotification = (subscription, dataToSend, userToken) => {
  
    webpush.sendNotification(subscription, dataToSend)
    .then((result) => {
      console.log('Notification sent successfully, token: ', userToken)
    })
    .catch((err) => {
      console.log('err from webpush for token : ', userToken)
    })
}
 
//route to test send notification
app.post('/send-notification', (req, res) => {
  console.log('route \'/send-notification\' called');
  try{
    const subscriptions = req.body.tokenTable
    const messageToDisplay = req.body.pushMessage
    let responseSent = false
    subscriptions.forEach(usTok => {
        // On récup sur la db locale les endpoints
        // demande sql : select * from userEndpoint where userToken = usTok
        let sqlQuerry = `SELECT * FROM navette.userEndpoint WHERE userToken = '${usTok}'`
        con.query(sqlQuerry, function (err, result) {
          if (err) console.log(err);
          if(JSON.stringify(result)!= '[]'){
            for (let rowDbReponse = 0; rowDbReponse < result.length; rowDbReponse++) {
              let userSubscription = JSON.parse(result[rowDbReponse].userEndpointStringify);
              const message = messageToDisplay
              
              sendNotification(userSubscription, message, usTok) //dbRep: réponse de la db (endpoint) /!\ METTRE EN JSON.PARSE()/
              
          }
        }
        });
        if(!responseSent){
          res.json({ message: "notification(s) envoyé(s)" })
          responseSent = true
        }
      })
  } catch (error) { 
    console.log(error);
  }
})

//RAJOUTE 
app.use('/', (req, res, next) => {
    console.log('route \'/\' called');
    res.json({ message: 'Hello from SSLserver' })
})

const sslServer = https.createServer({
    key: fs.readFileSync(path.join(__dirname,'cert', 'key.pem')),
    cert: fs.readFileSync(path.join(__dirname,'cert', 'cert.pem'))
}, app)

sslServer.listen(3443, () => console.log("Secure server on port 3443 v3.3.0 'no crash' "))