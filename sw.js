const CACHE_NAME = 'antioch-v2';
const ASSETS_TO_CACHE = [
  'index.html',
  'contact.html',
  'horaire.html',
  'localisation.html',
  'evenement.html',
  'apropos.html',
  'InscrivezVous.html',
  'documents.php',
  'style.css',
  'script.js',
  'logo.png',
  'manifest.json',
  'face.jpg',
  'Resurrection.jpg',
  'IMG_7211.JPG',
  'IMG_7225.PNG',
  'IMG_7226.PNG'
];

// Installation : Mise en cache de tout le site
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      return cache.addAll(ASSETS_TO_CACHE);
    })
  );
  self.skipWaiting();
});

// Activation : Nettoyage des anciens caches
self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((cache) => {
          if (cache !== CACHE_NAME) {
            return caches.delete(cache);
          }
        })
      );
    })
  );
});

// Récupération : Priorité au cache pour le hors-ligne
self.addEventListener('fetch', (event) => {
  event.respondWith(
    caches.match(event.request).then((response) => {
      return response || fetch(event.request).catch(() => {
        // Optionnel : retourner une page d'erreur personnalisée ici
      });
    })
  );
});
