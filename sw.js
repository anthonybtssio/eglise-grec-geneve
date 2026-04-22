const CACHE_NAME = 'antioch-v3';
const ASSETS_TO_CACHE = [
  './',
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
  'face.jpg'
];

// Installation
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      return cache.addAll(ASSETS_TO_CACHE);
    })
  );
  self.skipWaiting();
});

// Activation
self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((keys) => {
      return Promise.all(keys.filter(key => key !== CACHE_NAME).map(key => caches.delete(key)));
    })
  );
});

// Stratégie : Réseau d'abord, sinon Cache (Évite les bugs d'affichage)
self.addEventListener('fetch', (event) => {
  event.respondWith(
    fetch(event.request).catch(() => {
      return caches.match(event.request);
    })
  );
});
