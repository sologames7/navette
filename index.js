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

  
const registerServiceWorker = async () => {
  console.log('fonction dans main : registerServiceWorker');
  navigator.serviceWorker.getRegistrations().then(function(registrations) {
      for(let registration of registrations) {
        registration.unregister()
      } })
  const swUrl = './service-worker.js?tokenUser=' + tokenUser
  const swRegistration = await navigator.serviceWorker.register(swUrl)
  return swRegistration
}
  
const requestNotificationPermission = async () => {
  console.log('fonction dans main : requestNotificationPermission');

  if (window.Notification.permission !== 'granted'){
    const permission = await window.Notification.requestPermission()
    if (permission !== 'granted') {
      throw new Error('Permission not granted for Notification')
    }
  }else if(window.Notification.permission === 'denied'){
    throw new Error('Permission is denied for Notification')
  }
}

const unregisterServiceWorker =async () => {
  console.log('fonction dans main : unregisterServiceWorker')

}
  
const main = async () => {
  await check()
  await requestNotificationPermission()
  await registerServiceWorker()
}

const desactivation = async () => {
  await check()
  if (window.Notification.permission === 'granted'){
    console.log('granted donc on desac');
    unregisterServiceWorker()
  }else{
    console.log('pas granted ', window.Notification.permission);
  }

}