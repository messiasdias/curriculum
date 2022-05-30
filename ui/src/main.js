import "./dom/dom"
import "./sass/main.scss"
import Vue from "vue"
import Vuex from "vuex"
import VueMeta from 'vue-meta'
import {mask as VueMask} from 'vue-the-mask'
import FontAwesomeIcon  from "./dom/icons"
import Curriculum from "./components/Curriculum.vue"
import store from "./store"
import router from './router'

Vue.use(VueMeta)
Vue.use(Vuex)
Vue.component('fontawesome', FontAwesomeIcon)

new Vue({
    router,
    store,
    directives: {VueMask}, 
    render: h => h(Curriculum),
}).$mount('#app')
