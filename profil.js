var bouton_activation_notification = document.getElementById("permission-btn");

bouton_activation_notification.addEventListener("click", () => {
    console.log("bouton_activation_notification clicked");
    firebase.messaging().requestPermission().then(() => {
        console.log('Autorisation accordée.');
        firebase.messaging().getToken().then((firebaseToken) => {
            console.log('firebaseToken de notification:', firebaseToken);
            // Enregistrez le token de notification pour l'utilisateur dans votre base de données.
            document.cookie = "firebaseToken=" + firebaseToken + "; path=/";
        }).catch((error) => {
          console.log('Impossible d\'obtenir le token de notification:', error);
        });
      }).catch((error) => {
        console.log('Impossible d\'accorder l\'autorisation:', error);
      });
});

