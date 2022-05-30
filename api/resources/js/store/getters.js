export default {
    isAuth: async state => {
        return await setTimeout(() => {
            let expires_in = (parseInt(state.token_expires_in) + parseInt(state.token_genarated_in))
            let token_is_valid = expires_in > (new Date()).getTime()
            return (!!state.token && !!state.user) && token_is_valid
        }, 10)
    },
    auto_refresh: state => state.token_remember,
    apiBaseUrl: state => state.apiBaseUrl,
    user: state => state.user,
    token: state => state.token,
    users: state => state.users,
    cases: state => state.cases,
    pages: state => state.pages,
    images: state => state.images,
    sliders: state => state.sliders,
    contacts: state => state.contacts,
    contactsFilteds: state => state.contactsFilteds,
    solutions: state => state.solutions,
    categories: state => state.categories,
}