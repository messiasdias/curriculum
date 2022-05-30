<template>
<transition>
    <keep-alive>
    <div class="app">
        <!--- Auth pages-->
        <template v-if="$route.meta.requiresAuth" > 
            <!-- Menus -->
            <TopMenu :user="user" />
            <VerticalMenu :user="user" />
        
            <div class="main-content">
                <router-view>
                    <component:is="$router.component" :user="user" />
                </router-view>
            </div>

            <!-- Right bar-->
            <RightBar :user="user" />
            <div class="rightbar-overlay"></div>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                        {{moment().format('YYYY')}} © Speel Solar
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Feito com <i class="mdi mdi-heart text-danger"></i>, um pouco de Laravel e Vue.js.
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </template>

        <!--- No auth pages-->
        <div v-else class="auth-body-bg">
            <router-view @login="$emit('login', $event)" >
                <component :is="$router.component" :user="user" />
            </router-view>
        </div>
    </div>
    </keep-alive>
</transition>
</template>
<script>
import Axios from 'axios'
import TopMenu from './layout/TopMenu.vue'
import VerticalMenu from './layout/VerticalMenu.vue'
import RightBar from './layout/RightBar.vue'
import moment from 'moment'
export default {
    components: {
        TopMenu,
        VerticalMenu,
        RightBar
    },  
    data(){
        return {
            moment: moment,
            user: this.$store.getters.user,
            token: this.$store.getters.token,
            token_expires_in: this.$store.getters.token_expires_in,
            token_remember: this.$store.getters.token_remember,
            tokenRefreshInterval: null,
        }
    },
    methods: {
        getUser(data = null){
            if(data) {
                this.$store.commit('token', data.token)
                return Axios.post(`${window.cmsApiBaseUrl}/auth/me`)
                .then((response) => {
                    this.$store.dispatch('login', {
                        user: response.data, 
                        token: data.token, 
                        expires_in: data.expires_in
                    })
                })
                .catch((err) => {
                    console.error('Login error:', err)
                    this.$store.dispatch('logout')
                })
            }
        },
        showMessage(type, title, message){
            window.toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-bottom-right",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "3000",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut",
                "iconClasses": {
                    "error": "toast-error",
                    "info": "toast-info",
                    "success": "toast-success",
                    "warning": "toast-warning"
                },
                "icons": {
                    "error": "fa fa-ban",
                    "info": "fa fa-info-circle",
                    "success": "fa fa-check",
                    "warning": "fa fa-exclamation-triangle"
                },
                "messageClass": "toast-message"
            } 
            window.toastr.options.onShown = () => { 
                let title = window.$(window.toastr.getContainer().children()[0]).children()[2]
                window.$(title).prepend(`<i class="${window.toastr.options.icons[type]}"></i>`)
            }
            window.toastr[type](message, title)
        }
    },
    async mounted(){
        if (!!localStorage.sessionStatus)  {
            setTimeout(() => {
                this.showMessage('success', "Status",  localStorage.sessionStatus)
                localStorage.removeItem('sessionStatus')
            }, 1000)
        }

        this.$on('login', async (data) => {
            await this.getUser(data)
            window.init()
        })

        this.$root.$on('showMessage', (msg = {type: 'info', title: '', message: ''}) => {
            this.showMessage(msg.type, msg.title, msg.message)
        })

        if (this.token_remember && this.token) {
            clearInterval(this.tokenRefreshInterval)
            this.tokenRefreshInterval = setInterval(async () => {
                await this.$store.dispatch("refresh")
            }, parseInt(this.token_expires_in) - 1000)
        }
        
        if (this.token) {
            await this.getUser({token: this.token})
            this.$store.dispatch("init")
        }

        if (!this.user && this.$route.path !== '/login') this.$router.push({path: "/login"})
    }
}

</script>