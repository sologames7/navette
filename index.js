const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const tokenUser = urlParams.get('tokenUser');

const check = async () => {
    console.log('fonction dans main : check');
    if (!('PushManager' in window)) {
        throw new Error('No Push API Support!')
      }
    if (!('serviceWorker' in navigator)) {
      throw new Error('No Service Worker support!')
    }
  }

  
const updateServiceWorker = async () => {
  console.log('fonction dans main : updateServiceWorker');
  // 
  const registration = await navigator.serviceWorker.ready;

  navigator.serviceWorker.getRegistration().then(function(registration) {
    if (registration) {
      registration.update()
        .then(() => {
                    registration.active.postMessage({
                          type: 'update',
                          tokenUser: tokenUser
                      });
                    console.log('update registration : ', registration);
                    })
        .catch((err) => {
          console.log('err for update registration : ', err)
        })
    }else{
      navigator.serviceWorker.register('/service-worker.js')
    }
  });
  // 
  console.log("fin de la fonction updateServiceWorker");
}
  
const requestNotificationPermission = async () => {
  console.log('fonction dans main : requestNotificationPermission , état de la permission avant de trigger la fonction:'+ window.Notification.permission);
  if (window.Notification.permission !== 'granted'){
    const permission = await window.Notification.requestPermission()
    if (permission !== 'granted') {
      throw new Error('Permission not granted for Notification')
    }
  }else if(window.Notification.permission === 'denied'){
    throw new Error('Permission is denied for Notification')
  }
  console.log("à la fin de la fonction de demande de notif l'état de la permission est:" + window.Notification.permission);
}

const main = async () => {
  if (window.Notification.permission === 'granted'){
    if (confirm('Les notifications sont déjà activés, ceci ne les désactivera pas mais cette action va les rafraichir voulez-vous continuer?')) {
      console.log("début éxécution main()");
      await check()
      await requestNotificationPermission()
      await updateServiceWorker()
    }else {
        console.log('confirm : no');
    }
  }else{
    console.log("début éxécution main()");
    await check()
    await requestNotificationPermission()
    await updateServiceWorker()
  }
}