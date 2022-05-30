/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap')
window.Vue = require('vue').default
const {mask} = require('vue-the-mask')

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
*/

try {
    if(window.location.href.includes('cms')) {
        //Set Vue instance cms app
        require('./router/axios-inteceptor').default()
        new window.Vue({
            el: '#cms',
            router: require('./router').default,
            store: require('./store').default,
            directives: {mask},
            render: h => h(require('./components/cms/App.vue').default)
        });
    } else {
        //Set Vue instance site app
        new window.Vue({
            el: '#site',
            directives: {mask},
            components: {
                'home-sliders': require('./components/site/HomeSliders.vue').default,
                'home-boxes': require('./components/site/HomeBoxes.vue').default,
                'contact': require('./components/site/Contact.vue').default,
                'cases': require('./components/site/Cases.vue').default,
                'solutions': require('./components/site/Solutions.vue').default
            },
            mounted(){
                setTimeout(() => window.mainInit(), 100)
            }
        });
    }
} catch (e) {
    console.error('App build error:', e)
}

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register(`${window.assets}service-worker.js`, {scope:  `/public/`})
    .then((registration) => {
      if (registration.installing) console.log('ServiceWorker installing...')
    })
    .catch((error) => {
      console.error('Service worker registration failed:', error);
    });
    setInterval(() => {navigator.serviceWorker.controller.postMessage('update');}, 180000); 
} else {
  console.error('Service workers are not supported.');
}