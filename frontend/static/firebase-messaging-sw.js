
    importScripts(
      'https://www.gstatic.com/firebasejs/9.6.11/firebase-app-compat.js'
    )
    importScripts(
      'https://www.gstatic.com/firebasejs/9.6.11/firebase-messaging-compat.js'
    )
    firebase.initializeApp({"apiKey":"AIzaSyAYyce_o4pC1KYN5pEktGanaXOzWyI6288","authDomain":"shoplo-80327.firebaseapp.com","projectId":"shoplo-80327","storageBucket":"shoplo-80327.appspot.com","messagingSenderId":"831418037461","appId":"1:831418037461:web:b61da5911a86076e929e5c","measurementId":"G-W01FNZQN9D"})

    // Retrieve an instance of Firebase Messaging so that it can handle background
    // messages.
    const messaging = firebase.messaging()

    self.addEventListener("push", function (e) {
  data = e.data.json();
  var options = {
    body: data.notification.body,
    icon: data.notification.icon,
    vibrate: [100, 50, 100],
    data: {
      dateOfArrival: Date.now(),
      primaryKey: "2",
    },
  };
});

messaging.onBackgroundMessage((payload) => {
  // Customize notification here
  const notificationTitle = payload.notification.title;
  const notificationOptions = {
    body: payload.notification.body,
  };

  return self.registration.showNotification(
    notificationTitle,
    notificationOptions
  );
});

    