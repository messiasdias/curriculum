import Curriculum from './../components/Curriculum'
//import Login from './../admin/components/Login'
//import Dashboard from './../admin/components/Dashboard'
// import CustomPages from './../admin/components/layout/pages/CustomPages'
// import Pages from './../admin/components/layout/pages/Pages'
// import Sliders from './../admin/components/layout/slider/Sliders'
// import Categories from './../admin/components/layout/cases/Categories'
// import Cases from './../admin/components/layout/cases/Cases'
// import Solutions from './../admin/components/layout/solutions/Solutions'
// import Users from './../admin/components/layout/users/Users'
// import Inbox from './../admin/components/layout/inbox/Inbox'
// import Images from './../admin/components/layout/images/Images'

export default [
    { 
        path: '/', 
        alias: '/curriculum', 
        name: 'curriculum', 
        component: Curriculum,
        meta: {
            requiresAuth: false,
            permissions: []
        }
    },
    // { 
    //     path: '/login', 
    //     alias: '/entrar', 
    //     name: 'login', 
    //     component: Login,
    //     meta: {
    //         requiresAuth: false,
    //         permissions: []
    //     }
    // },
    // { 
    //     path: '/dashboard', 
    //     alias: '/dashboard', 
    //     name: 'dashboard', 
    //     component: Dashboard,
    //     meta: {
    //         requiresAuth: true,
    //         permissions: ['all']
    //     }
    // },
    // {
    //     path: '/pages',
    //     component: CustomPages,
    //     meta: {
    //         requiresAuth: true,
    //         permissions: ['pages']
    //     },
    // },
    // { 
    //     path: '/pages/:pageId', 
    //     component: Pages,
    //     meta: {
    //         requiresAuth: true,
    //         permissions: ['pages']
    //     },
    // },
    // {
    //     path: '/sliders',
    //     component: Sliders,
    //     meta: {
    //         requiresAuth: true,
    //         permissions: ['slider']
    //     },
    // },
    // {
    //     path: '/sliders/:id',
    //     component: Sliders,
    //     meta: {
    //         requiresAuth: true,
    //         permissions: ['slider']
    //     },
    // },
    // {
    //     path: '/categories',
    //     component: Categories,
    //     meta: {
    //         requiresAuth: true,
    //         permissions: ['cases']
    //     },
    // },
    // {
    //     path: '/categories/:id',
    //     component: Categories,
    //     meta: {
    //         requiresAuth: true,
    //         permissions: ['cases']
    //     },
    // },
    // {
    //     path: '/cases',
    //     component: Cases,
    //     meta: {
    //         requiresAuth: true,
    //         permissions: ['cases']
    //     },
    // },
    // {
    //     path: '/cases/:id',
    //     component: Cases,
    //     meta: {
    //         requiresAuth: true,
    //         permissions: ['cases']
    //     },
    // },
    // {
    //     path: '/solutions',
    //     component: Solutions,
    //     meta: {
    //         requiresAuth: true,
    //         permissions: ['solutions']
    //     },
    // },
    // {
    //     path: '/solutions/:id',
    //     component: Solutions,
    //     meta: {
    //         requiresAuth: true,
    //         permissions: ['solutions']
    //     },
    // },
    // {
    //     path: '/inbox',
    //     component: Inbox,
    //     meta: {
    //         requiresAuth: true,
    //         permissions: ['inbox']
    //     },
    // },
    // {
    //     path: '/inbox/:messages_id',
    //     component: Inbox,
    //     meta: {
    //         requiresAuth: true,
    //         permissions: ['inbox']
    //     },
    // },
    // {
    //     path: '/images',
    //     component: Images,
    //     meta: {
    //         requiresAuth: true,
    //         permissions: ['images']
    //     },
    // },
    // {
    //     path: '/users',
    //     component: Users,
    //     meta: {
    //         requiresAuth: true,
    //         permissions: ['users']
    //     },
    // },
    // {
    //     path: '/users/:id',
    //     component: Users,
    //     meta: {
    //         requiresAuth: true,
    //         permissions: ['users', 'is_self']
    //     },
    // },
    { 
        path: '*', 
        alias: '/not-found', 
        name: 'not-found', 
        component: Curriculum,
        meta: {
            requiresAuth: false,
            permissions: []
        }
    },
]