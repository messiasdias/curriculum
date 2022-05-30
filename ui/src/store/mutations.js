import {put as putStore} from './save'

export default{
    isAuth(state, isAuth = false){
        state.isAuth = isAuth
    },
    user(state, user = null){
        state.user = user
        if(user) putStore('user', user)
    },
    token(state, token = null){
        state.token = token
        if(token) putStore('token', token)
    },
    token_expires_in(state, token_expires_in = null){
        state.token_expires_in = token_expires_in
        putStore('token_expires_in', token_expires_in)
    },
    token_genarated_in(state, token_genarated_in = null){
        state.token_genarated_in = token_genarated_in
        putStore('token_genarated_in', token_genarated_in)
    },
    token_remember(state, token_remember = null){
        state.token_remember = token_remember
        if(token_remember) putStore('token_remember', token_remember)
    },
    users(state, users = []){
        state.users = users
    },
    cases(state, cases = []){
        state.cases = cases
    },
    pages(state, pages = []){
        state.pages = pages
    },
    sliders(state, sliders = []){
        state.sliders = sliders
    },
    images(state, images = []){
        state.images = images
    },
    contacts(state, contacts = []){
        state.contacts = contacts
    },
    contactsFilteds(state, contacts = []){
        state.contactsFilteds = contacts
    },
    solutions(state, solutions = []){
        state.solutions = solutions
    },
    categories(state, categories = []){
        state.categories = categories
    }
}