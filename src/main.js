import "./sass/main.scss"
//import "animate-scss"
import Vue from "vue"
import Vuex from "vuex"
import FontAwesomeIcon  from "./icons"
import Curriculum from "./components/Curriculum.vue"
import Store from "./store"

Vue.component('fontawesome',FontAwesomeIcon)
Vue.use(Vuex)
let store = new Vuex.Store(Store)

new Vue({
    el:"#app", 
    store,  
    render: h => h(Curriculum),
})