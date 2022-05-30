import Axios from 'axios'
import {remove as removeStore} from './save'

export default {
    init({getters, dispatch}){
        if (getters.isAuth) {
            dispatch("getPages")
            dispatch("getUsers")
            dispatch("getCases")
            dispatch("getImages")
            dispatch("getSliders")
            dispatch("getContacts")
            dispatch("getSolutions")
            dispatch("getCategories")
        }
    },
    login({commit, dispatch}, opts = {user: null, token: null, expires_in: null}){
        if((opts.token && opts.expires_in) && opts.user) {
            commit('token', opts.token)
            commit('token_expires_in', opts.expires_in)
            commit('token_genarated_in', (new Date).getTime() - 100)
            commit('user', opts.user)
            commit('isAuth', true)
            dispatch('getPages')
            window.location.href = "/cms#/"
        }
    },
    refresh({commit, state}){
        let expires_in = (parseInt(state.token_expires_in) + parseInt(state.token_genarated_in))
        let expires_in_left = expires_in > (new Date()).getTime()
        
        Axios.post(`${state.apiBaseUrl}/auth/refresh`, {access_token: state.token})
        .then(({data}) => {
            commit('token', data.access_token)
            commit('token_expires_in', data.expires_in)
            commit('token_genarated_in', expires_in_left)
        })
        .catch(() => {
            dispatch('logout')
        })
    },
    logout({commit, state}){
        if (state.token) {
            Axios.post(`${state.apiBaseUrl}/auth/logout`, {access_token: state.token})
            .then(() => {
                commit('user', null)
                commit('token', null)
                commit('token_expires_in', null)
                commit('token_genarated_in', null)
                commit('isAuth', false)
                removeStore('user')
                removeStore('token')
                removeStore('token_expires_in')
                removeStore('token_genarated_in')
                commit('users', [])
                commit('cases', [])
                commit('images', [])
                commit('categories', [])
                commit('solutions', [])
                commit('contacts', [])
            })
        }
        
        try {
            if(window.location.href.split('#')[1] !== '/login') window.location.href = "/cms#/login"
        } catch (e) {
            window.location.href = "/"
        }
    },
    getPages({state, commit}, page = 1){
        if(state.user.permissions.pages) {
            Axios.get(`${state.apiBaseUrl}/pages?page=${page}`)
            .then(({data}) => {
                commit('pages', data)
            })
            .catch(() => {
                commit('pages', [])
            })
        }
    },
    getUser({commit}, callback = null){
        if (!callback || typeof callback != 'function') {
            callback = ({data}) => {
                commit('user', data)
            }
        }
        Axios.post(`${window.cmsApiBaseUrl}/auth/me`).then(callback)
    },
    getUsers({state, commit}, page = 1){
        if(state.user.permissions.users) {
            Axios.get(`${state.apiBaseUrl}/users?page=${page}`)
            .then(({data}) => {
                commit('users', data)
            })
            .catch(() => {
                commit('users', [])
            })
        }
    },
    getCases({state, commit}, page = 1){
        if(state.user.permissions.cases) {
            Axios.get(`${state.apiBaseUrl}/cases?page=${page}`)
            .then(({data}) => {
                commit('cases', data)
            })
            .catch(() => {
                commit('cases', [])
            })
        }
    },
    getContacts({state, commit}, page = 1){
        if(state.user.permissions.inbox) {
            Axios.get(`${state.apiBaseUrl}/contacts?page=${page}?paginate=100`)
            .then(({data}) => {
                commit('contacts', data)
            })
            .catch(() => {
                commit('contacts', [])
            })
        }
    },
    getContactsFilteds({state, commit}, options = {page: 1, filterColumn: 'status', filterValue: 'new'}){
        if(state.user.permissions.inbox) {
            Axios.get(`${state.apiBaseUrl}/contacts?page=${options.page}&filterColumn=${options.filterColumn}&filterValue=${options.filterValue}`)
            .then(({data}) => {
                commit('contactsFilteds', data)
            })
            .catch(() => {
                commit('contactsFilteds', [])
            })
        }
    },
    getSolutions({state, commit}, page = 1){
        if(state.user.permissions.solutions) {
            Axios.get(`${state.apiBaseUrl}/solutions?page=${page}`)
            .then(({data}) => {
                commit('solutions', data)
            })
            .catch(() => {
                commit('solutions', [])
            })
        }
    },
    getSliders({state, commit}, page = 1){
        if(state.user.permissions.slider) {
            Axios.get(`${state.apiBaseUrl}/sliders?page=${page}`)
            .then(({data}) => {
                commit('sliders', data)
            })
            .catch(() => {
                commit('sliders', [])
            })
        }
    },
    getCategories({state, commit}, page = 1){
        if(state.user.permissions.cases) {
            Axios.get(`${state.apiBaseUrl}/categories?page=${page}`)
            .then(({data}) => {
                commit('categories', data)
            })
            .catch(() => {
                commit('categories', [])
            })
        }
    },
    getImages({state, commit}, page = 1){
        if(state.user.permissions.images) {
            Axios.get(`${state.apiBaseUrl}/images?page=${page}`)
            .then(({data}) => {
                commit('images', data)
            })
            .catch(() => {
                commit('images', [])
            })
        }
    }
}