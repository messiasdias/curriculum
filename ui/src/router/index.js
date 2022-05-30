import VueRouter from 'vue-router'
import store from './../store'
import Routes from './routes'

const baseUrl = process.env.NODE_ENV === "production" ? "/curriculum/" : "/"

const router = new VueRouter({
    mode: 'hash',
    base: baseUrl,
    publicPath: baseUrl,
    saveScrollPosition: true,
    routes: Routes
})

router.beforeEach(async (to, from, next) => {
    let permissions = store.getters?.user ? store.getters.user.permissions : []
    let user = store.getters?.user ? store.getters.user : null
    let id = to.params.hasOwnProperty("id") ? to.params.id : null

    let allowRoute = false
    if(store.getters?.isAuth && to.meta.requiresAuth) {
        allowRoute = to.meta.permissions ? to.meta.permissions.some(p => {
            return [
                p === 'all',
                permissions[p],
                (p === 'is_self' && (!!user && user.id == id))
            ].some(vv => vv)
        }) : false;

        if (!allowRoute) return next('/')
    }

    if (to.meta.requiresAuth && !store.getters?.isAuth) return next('/login')

    next()
})

export default router