// importScripts('cdn://workbox-sw.js');
importScripts('https://storage.googleapis.com/workbox-cdn/releases/6.0.2/workbox-sw.js');

const tokenUser = new URL(location).searchParams.get('tokenUser');
workbox.routing.registerRoute(
    ({request}) => request.destination === 'image',
    new workbox.strategies.NetworkFirst()
)
console.log("service-worker registration");



// NOTIF :

if(tokenUser){
  console.log("execute service worker for activate notifs");
  // urlB64ToUint8Array is a magic function that will encode the base64 public key
  // to Array buffer which is needed by the subscription option
  const urlB64ToUint8Array = (base64String) => {
    console.log('urlB64ToUint8Array : 1');
    const padding = '='.repeat((4 - (base64String.length % 4)) % 4)
    const base64 = (base64String + padding).replace(/\-/g, '+').replace(/_/g, '/')
    const rawData = atob(base64)
    const outputArray = new Uint8Array(rawData.length)
    for (let i = 0; i < rawData.length; ++i) {
      outputArray[i] = rawData.charCodeAt(i)
    }
    return outputArray
  }

  self.addEventListener('activate', async () => {
    console.log('activate : 2');
    // This will be called only once when the service worker is activated.
    try {
      const applicationServerKey = urlB64ToUint8Array(
        'BCNPy1TUfqYbs6cU6uXwBrlmEyouxFm-L78hQiZvs4sDafI7fgvtvL8vKdtjBTeP16-d8GnsFWNNdGfjQwBdwK4'
      )
      const options = { applicationServerKey, userVisibleOnly: true }
      const subscription = await self.registration.pushManager.subscribe(options)
      const response = await saveSubscription(subscription, tokenUser)
      console.log(response)


    } catch (err) {
      console.log('Error', err)
    }
  })

 

  // saveSubscription saves the subscription to the backend
  const saveSubscription = async (subscription, token) => {
      console.log('saveSubscription : 3');
      const response = await fetch('https://425c94f.online-server.cloud:3443/save-subscription', {
        method: 'post',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          sub: subscription,
          userToken: token
        }),
      }).catch((error) => {
        console.log(error);
      })
      return response.json()
    }
    
  

  // ecouter (frontend) les notif push 
  self.addEventListener('push', function (event) {
    if (event.data) {
      console.log('Push event!! ', event.data.text())
      showLocalNotification('Vous avez une nouvelle activité', event.data.text(), self.registration)
    } else {
      console.log('Push event but no data')
    }
  })

  const showLocalNotification = (title, body, swRegistration) => {
    const options = {
      body,
      // here you can add more properties like icon, image, vibrate, etc.
    }
    swRegistration.showNotification(title, options)
  }

}

