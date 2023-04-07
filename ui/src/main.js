import "./sass/main.scss"
import Vue from "vue"
import Vuex from "vuex"
import VueMeta from 'vue-meta'
import FontAwesomeIcon  from "./dom/icons"
import Curriculum from "./components/Curriculum.vue"
import Store from "./store"
import "./dom/dom"

Vue.component('fontawesome',FontAwesomeIcon)
Vue.use(VueMeta)
Vue.use(Vuex)

new Vue({
    store: new Vuex.Store(Store),  
    render: h => h(Curriculum),
}).$mount('#app')
