// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/9.19.1/firebase-app.js";
import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.19.1/firebase-analytics.js";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
apiKey: "AIzaSyBG8yMHcevDOPXNmnLpzeVQE5Ay5QNa4d8",
authDomain: "navette-fb783.firebaseapp.com",
projectId: "navette-fb783",
storageBucket: "navette-fb783.appspot.com",
messagingSenderId: "68326465827",
appId: "1:68326465827:web:42f1f1cb689eba95d9ac96",
measurementId: "G-5GBE40NZYR"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);

console.log("firebase.js loaded");