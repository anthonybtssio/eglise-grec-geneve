const CACHE_NAME = 'antioch-v1';
const ASSETS_TO_CACHE = [
  'index.html',
  'contact.html',
  'horaire.html',
  'localisation.html',
  'evenement.html',
  'apropos.html',
  'InscrivezVous.html',
  'style.css',
  'script.js',
  'logo.png',
  'manifest.json'
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      return cache.addAll(ASSETS_TO_CACHE);
    })
  );
});

self.addEventListener('fetch', (event) => {
  event.respondWith(
    caches.match(event.request).then((response) => {
      return response || fetch(event.request);
    })
  );
});
