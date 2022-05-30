<template>
    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <router-link v-if="theme === 'light'" to="/" class="waves-effect logo logo-dark">
                        <span class="logo-sm">
                            <img :src="`${assets}img/logo.png`" alt="logo-sm-dark" height="22">
                        </span>
                        <span class="logo-lg">
                            <img :src="`${assets}img/speel.svg`" alt="logo-dark" height="50">
                        </span>
                    </router-link>
                    <router-link v-if="theme === 'dark'" to="/" class="waves-effect logo logo-light">
                        <span class="logo-sm">
                            <img :src="`${assets}img/icon.svg`" alt="logo-sm-light" height="22">
                        </span>
                        <span class="logo-lg">
                            <img :src="`${assets}img/speel2.svg`" alt="logo-light" height="50">
                        </span>
                    </router-link>
                </div>
                <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect"
                    id="vertical-menu-btn">
                    <i class="ri-menu-2-line align-middle"></i>
                </button>
               
            </div>
            <div class="d-flex">
                <div class="dropdown d-none d-lg-inline-block ms-1">
                    <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                        <i class="ri-fullscreen-line"></i>
                    </button>
                </div>

                <div v-if="hasNewContacts && authUser.permissions.inbox" class="dropdown d-inline-block">
                    <button type="button" class="btn header-item noti-icon waves-effect"
                        id="page-header-contacts-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ri-notification-3-line"></i>
                        <span v-if="hasNewContacts" class="noti-dot"></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-contacts-dropdown">
                        <div class="p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0"> Notificações</h6>
                                </div>
                            </div>
                        </div>
                        <div data-simplebar style="max-height: 230px;">
                            <router-link 
                                v-for="contact in contacts"
                                :key="contact.id" href="" 
                                class="text-reset notification-item"
                                :to="`/inbox/${contact.id}`"
                            >
                                <div class="d-flex">
                                    <div class="avatar-xs me-3">
                                        <span class="avatar-title bg-primary rounded-circle font-size-16">
                                            <i class="ri-mail-send-line font-size-24"></i>
                                        </span>
                                    </div>
                                    <div class="flex-1">
                                        <h6 class="mt-0 mb-1">Nova mensagem na Caixa de entrada</h6>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1">{{contact.subject}}</p>
                                            <p class="mb-0"><i class="mdi mdi-clock-outline"></i> {{moment(contact.created_at).startOf('hour').fromNow()}}</p>
                                        </div>
                                    </div>
                                </div>
                            </router-link >
                        </div>
                        <div class="p-2 border-top">
                            <div class="d-grid">
                                <router-link
                                    to="/inbox" 
                                    class="btn btn-sm btn-link font-size-14 text-center"
                                >
                                    <i class="mdi mdi-arrow-right-circle me-1"></i> Ver Todas
                                </router-link >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dropdown d-inline-block user-dropdown">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img 
                            class="rounded-circle header-profile-user" 
                            alt="Imagem do Usuário"
                            title="Imagem do Usuário"
                            :src="`${userAvatar}`"
                        >
                        <span v-if="userFirstName" class="d-none d-xl-inline-block ms-1">{{userFirstName}}</span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    </button>
                    <div v-if="authUser" class="dropdown-menu dropdown-menu-end">
                        <router-link :to="`/users/${authUser.id}`" class="dropdown-item"><i class="ri-user-line align-middle me-1"></i> Perfil</router-link>
                        <div class="dropdown-divider"></div>
                        <a @click.prevent="logout()" class="dropdown-item text-danger" href="#"><i
                                class="ri-shut-down-line align-middle me-1 text-danger"></i> Sair</a>
                    </div>
                </div>
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                        <i class="ri-settings-2-line"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>
</template>
<script>
import moment from 'moment'
export default {
    name: "top-menu",
    props: {
        user: {
            type: Object,
            default : () => null
        }
    },
    computed: {
        hasNewContacts(){
            return this.$store.getters.contacts?.data?.filter(c => c.status == 'new').length > 0 || false
        },
        contacts(){
            return this.$store.getters.contacts?.data?.filter(c => c.status == 'new') || []
        },
        authUser(){
            return this.$store.getters.user
        },
        userFirstName(){
            return this.authUser ? this.authUser.name.split(' ')[0] : ''
        },
        userAvatar(){
            return this.authUser?.image ? `${this.assets}${this.authUser.image.url}` : `${this.assets}admin/images/users/avatar-2.jpg`
        }
    },
    data(){
        return {
            moment: moment,
            assets: window.assets,
            theme: document.querySelector('body').getAttribute('data-sidebar')
        }
    },
    methods: {
        logout(){
            this.$store.dispatch("logout")
        }
    }
}
</script>