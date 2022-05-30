import Vue from 'vue'
import Vuex from 'vuex'
import actions from './actions'
import getters from './getters'
import mutations from './mutations'
import {get as getStore} from './save'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        apiBaseUrl: window.cmsApiBaseUrl,
        isAuth: false,
        user: getStore('user', null),
        token: getStore('token', null),
        token_remember: getStore('token_remember', false),
        token_expires_in: getStore('token_expires_in', null),
        token_genarated_in: getStore('token_genarated_in', null),
        users: [],
        cases: [],
        pages: [],
        sliders: [],
        images: [],
        contacts: [],
        contactsFilteds: [],
        solutions: [],
        categories: [],
    },
    actions: actions,
    getters: getters,
    mutations: mutations,
})