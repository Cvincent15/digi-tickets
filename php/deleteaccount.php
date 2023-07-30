<script>
// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.0.0/firebase-app.js";
import { getFirestore, collection, doc, addDoc, getDocs, query, where } from "https://www.gstatic.com/firebasejs/10.0.0/firebase-firestore.js";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
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

 // Initialize Firebase
 initializeApp(firebaseConfig);
  const db = getFirestore();

  // Function to delete a user document
  function deleteUserDocument(username) {
    // Create a reference to the 'usersCTMEU' collection
    const usersCollection = collection(db, 'usersCTMEU');

    // Query the Firestore collection to find the document with the provided username
    const query = where('username', '==', username);
    getDocs(query(usersCollection))
      .then((querySnapshot) => {
        if (!querySnapshot.empty) {
          // Delete the document from Firestore
          const docSnapshot = querySnapshot.docs[0];
          const docRef = doc(usersCollection, docSnapshot.id);
          return deleteDoc(docRef);
        } else {
          console.error('Error: Account not found.');
        }
      })
      .then(() => {
        console.log('Account deleted successfully.');
        // Redirect back to the same page
        window.location.href = window.location.href;
      })
      .catch((error) => {
        console.error('Error deleting account:', error);
      });
  }

  // Add an event listener to the "Delete" button
  document.getElementById('delete-button').addEventListener('click', function (event) {
    const username = document.getElementById('username').value;
    if (confirm("Are you sure you want to delete the account for username: " + username + "?")) {
      // Call the function to delete the user document
      deleteUserDocument(username);
    }
  });

</script>