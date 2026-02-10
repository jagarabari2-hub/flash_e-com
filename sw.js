// FLASH E-Commerce Service Worker
// Provides offline support, caching, and performance optimization

const CACHE_NAME = 'flash-ecommerce-v1';
const STATIC_ASSETS = [
    '/',
    '/index.php',
    '/css/bootstrap.min.css',
    '/mcss/modern-style.css',
    '/mcss/performance.css',
    '/js/app.js',
    '/js/bootstrap.bundle.min.js'
];

// Install Event - Cache static assets
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                console.log('Service Worker: Caching static assets');
                return cache.addAll(STATIC_ASSETS).catch(err => {
                    console.log('Some assets failed to cache:', err);
                });
            })
            .then(() => self.skipWaiting())
    );
});

// Activate Event - Clean up old caches
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys()
            .then(cacheNames => {
                return Promise.all(
                    cacheNames.map(cacheName => {
                        if (cacheName !== CACHE_NAME) {
                            console.log('Service Worker: Deleting old cache:', cacheName);
                            return caches.delete(cacheName);
                        }
                    })
                );
            })
            .then(() => self.clients.claim())
    );
});

// Fetch Event - Cache first strategy for static assets, network first for dynamic content
self.addEventListener('fetch', event => {
    const { request } = event;
    const url = new URL(request.url);

    // Skip cross-origin requests
    if (url.origin !== location.origin) {
        return;
    }

    // For GET requests
    if (request.method === 'GET') {
        // Cache first strategy for static assets
        if (request.url.includes('.css') || request.url.includes('.js') || request.url.includes('img/')) {
            event.respondWith(
                caches.match(request)
                    .then(response => {
                        return response || fetch(request)
                            .then(response => {
                                // Clone the response
                                const clonedResponse = response.clone();
                                caches.open(CACHE_NAME)
                                    .then(cache => cache.put(request, clonedResponse));
                                return response;
                            });
                    })
                    .catch(() => {
                        // Return cached response if available
                        return caches.match(request);
                    })
            );
        } else {
            // Network first strategy for HTML pages
            event.respondWith(
                fetch(request)
                    .then(response => {
                        const clonedResponse = response.clone();
                        caches.open(CACHE_NAME)
                            .then(cache => cache.put(request, clonedResponse));
                        return response;
                    })
                    .catch(() => {
                        return caches.match(request)
                            .then(response => {
                                return response || new Response('Offline - Page not cached', {
                                    status: 503,
                                    statusText: 'Service Unavailable',
                                    headers: new Headers({
                                        'Content-Type': 'text/plain'
                                    })
                                });
                            });
                    })
            );
        }
    }
});

// Message Event - Handle messages from client
self.addEventListener('message', event => {
    if (event.data && event.data.type === 'SKIP_WAITING') {
        self.skipWaiting();
    }
});
