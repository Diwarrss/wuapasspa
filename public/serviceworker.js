var staticCacheName = "pwa-version" + new Date().getTime();
var filesToCache = [
    '/css/adminlte.css',
    '/css/misLibrerias.css',
    '/css/miWelcome.css',
    '/js/adminlte.js',
    '/js/appAdmin.js',
    '/js/appCliente.js',
    '/js/misLibrerias.js',
    '/js/miWelcome.js',
    '/img/icons/icon-72x72.png',
    '/img/icons/icon-96x96.png',
    '/img/icons/icon-128x128.png',
    '/img/icons/icon-144x144.png',
    '/img/icons/icon-152x152.png',
    '/img/icons/icon-192x192.png',
    '/img/icons/icon-384x384.png',
    '/img/icons/icon-512x512.png',
    '/img/icons/splash-640x1136.png',
    '/img/icons/splash-750x1334.png',
    '/img/icons/splash-1242x2208.png',
    '/img/icons/splash-1125x2436.png',
    '/img/icons/splash-828x1792.png',
    '/img/icons/splash-1242x2688.png',
    '/img/icons/splash-1536x2048.png',
    '/img/icons/splash-1668x2224.png',
    '/img/icons/splash-1668x2388.png',
    '/img/icons/splash-2048x2732.png'
];

// Cache on install
self.addEventListener("install", event => {
    this.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName)
            .then(cache => {
                return cache.addAll(filesToCache);
            })
    )
    console.log('Service Worker Instalado 2.0');
});

// Clear cache on activate
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames
                    .filter(cacheName => (cacheName.startsWith("pwa-")))
                    .filter(cacheName => (cacheName !== staticCacheName))
                    .map(cacheName => caches.delete(cacheName))
            );
        })
    );
    console.log('Service Worker listo controlando APP');
});

// Serve from Cache
self.addEventListener("fetch", event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                return response || fetch(event.request);
            })
            .catch(() => {
                return caches.match('offline');
            })
    )
});
