import {initializeApp} from 'firebase/app'
import {
    getFirestore, collection, getDocs
} from 'firebase/firestore'

// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
    apiKey: "AIzaSyCJYwTjdJbocOuQqUUPPcjQ49Y8R2eng0E",
    authDomain: "ctmeu-d5575.firebaseapp.com",
    databaseURL: "https://ctmeu-d5575-default-rtdb.asia-southeast1.firebasedatabase.app",
    projectId: "ctmeu-d5575",
    storageBucket: "ctmeu-d5575.appspot.com",
    messagingSenderId: "1062661015515",
    appId: "1:1062661015515:web:c0f4f62b1f010a9216c9fe",
    measurementId: "G-65PXT5618B"
  };

  initializeApp(firebaseConfig)
  
  const db = getFirestore()

  const colRef = collection(db, 'userCTMEU')

  getDocs(colRef)
    .then((snapshot) => [
        console.log(snapshot.docs)
    ])