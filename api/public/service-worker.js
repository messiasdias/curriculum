const cacheName = "v1"

const localCacheFiles = [
  "/js",
  "/css/",
  "/img/",
  "/admin/",
  "/fonts/",
  "/storage/"
]

const remoteCacheFiles = [
  "https://cdn.jsdelivr.net",
]

const denyCacheFiles = [
  "/service-worker.js"
]

function isCacheFileDenied(url) {
  return denyCacheFiles.map(path => url == path || url.includes(path)).some(v => v)
}

function isCacheFileAllow(url) {
  return isCacheFileDenied(url) ? false : [
    localCacheFiles.map(path => url == path || url.includes(path)).some(v => v),
    remoteCacheFiles.map(path => url == path || url.includes(path)).some(v => v),
  ].some(v => v)
}

async function updateCache(request, response){
  if (isCacheFileAllow(request.url) && request.method.toLowerCase() != 'post') {
    caches.open(cacheName).then(cache => cache.put(request, response))
  }
}

function installAndUpdate(event){
  let localFiles = localCacheFiles.filter(path => path.includes('.'))
  event.waitUntil(caches.open(cacheName).then(cache => {
    return cache.addAll(localFiles).then(() => {
      localCacheFiles.forEach(path => { if(isCacheFileDenied(path)) cache.delete(path)})
      self.skipWaiting()
    })
  }))
}

self.addEventListener('install', event => installAndUpdate(event))

self.addEventListener('activate', event => {
  event.waitUntil(caches.keys().then(cacheNames => {
    return Promise.all(cacheNames.map(cache => {if (cache !== cacheName) return caches.delete(cache)}))
  }))
})

self.addEventListener('fetch', async (event )=> {
  event.respondWith(
    caches.match(event.request).then(async (response) => {
      return response || fetch(event.request).then((res) => {
        self.updateCache(event.request, res.clone())
        return res
      })
    })
  )
})

// Additions to your service worker code:
self.addEventListener('message', (event) => {
  if (event.data === 'update') {
    installAndUpdate(event)
  }
});