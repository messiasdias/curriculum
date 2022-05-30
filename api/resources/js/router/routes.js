import Login from './../components/cms/Login'
import Dashboard from './../components/cms/Dashboard'
import CustomPages from './../components/cms/layout/pages/CustomPages'
import Pages from './../components/cms/layout/pages/Pages'
import Sliders from './../components/cms/layout/slider/Sliders'
import Categories from './../components/cms/layout/cases/Categories'
import Cases from './../components/cms/layout/cases/Cases'
import Solutions from './../components/cms/layout/solutions/Solutions'
import Users from './../components/cms/layout/users/Users'
import Inbox from './../components/cms/layout/inbox/Inbox'
import Images from './../components/cms/layout/images/Images'

export default [
    { 
        path: '/login', 
        alias: '/entrar', 
        name: 'login', 
        component: Login,
        meta: {
            requiresAuth: false,
            permissions: []
        }
    },
    { 
        path: '/', 
        alias: '/dashboard', 
        name: 'dashboard', 
        component: Dashboard,
        meta: {
            requiresAuth: true,
            permissions: ['all']
        }
    },
    {
        path: '/pages',
        component: CustomPages,
        meta: {
            requiresAuth: true,
            permissions: ['pages']
        },
    },
    { 
        path: '/pages/:pageId', 
        component: Pages,
        meta: {
            requiresAuth: true,
            permissions: ['pages']
        },
    },
    {
        path: '/sliders',
        component: Sliders,
        meta: {
            requiresAuth: true,
            permissions: ['slider']
        },
    },
    {
        path: '/sliders/:id',
        component: Sliders,
        meta: {
            requiresAuth: true,
            permissions: ['slider']
        },
    },
    {
        path: '/categories',
        component: Categories,
        meta: {
            requiresAuth: true,
            permissions: ['cases']
        },
    },
    {
        path: '/categories/:id',
        component: Categories,
        meta: {
            requiresAuth: true,
            permissions: ['cases']
        },
    },
    {
        path: '/cases',
        component: Cases,
        meta: {
            requiresAuth: true,
            permissions: ['cases']
        },
    },
    {
        path: '/cases/:id',
        component: Cases,
        meta: {
            requiresAuth: true,
            permissions: ['cases']
        },
    },
    {
        path: '/solutions',
        component: Solutions,
        meta: {
            requiresAuth: true,
            permissions: ['solutions']
        },
    },
    {
        path: '/solutions/:id',
        component: Solutions,
        meta: {
            requiresAuth: true,
            permissions: ['solutions']
        },
    },
    {
        path: '/inbox',
        component: Inbox,
        meta: {
            requiresAuth: true,
            permissions: ['inbox']
        },
    },
    {
        path: '/inbox/:messages_id',
        component: Inbox,
        meta: {
            requiresAuth: true,
            permissions: ['inbox']
        },
    },
    {
        path: '/images',
        component: Images,
        meta: {
            requiresAuth: true,
            permissions: ['images']
        },
    },
    {
        path: '/users',
        component: Users,
        meta: {
            requiresAuth: true,
            permissions: ['users']
        },
    },
    {
        path: '/users/:id',
        component: Users,
        meta: {
            requiresAuth: true,
            permissions: ['users', 'is_self']
        },
    },
    { 
        path: '*', 
        alias: '/not-found', 
        name: 'not-found', 
        component: Dashboard,
        meta: {
            requiresAuth: true,
            permissions: ['all']
        }
    },
]