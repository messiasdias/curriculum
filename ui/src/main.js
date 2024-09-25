import "./sass/main.scss"
import Vue from "vue"
import Vuex from "vuex"
import VueMeta from 'vue-meta'
import FontAwesomeIcon  from "./dom/icons"
import Curriculum from "./components/Curriculum.vue"
import Store from "./store"
import "./dom/dom"

Vue.use(Vuex)
Vue.use(VueMeta)
Vue.component('fontawesome',FontAwesomeIcon)

new Vue({
    store: new Vuex.Store(Store),  
    render: h => h(Curriculum),
}).$mount('#app')
