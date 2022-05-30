<template>
 <!-- ========== Left Sidebar Start ========== -->
    <div v-if="authUser" class="vertical-menu">
        <div data-simplebar class="h-100">
            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <!-- Left Menu Start -->
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li class="menu-title">Dashboard</li>
                    <li>
                        <router-link to="/" class="waves-effect">
                            <i class="ri-dashboard-line"></i>
                            <span>Dashboard</span>
                        </router-link>
                    </li>
                    <li v-if="authUser.permissions.inbox">
                        <router-link target="_self" :to="`/inbox`">
                            <i class="ri-inbox-line"></i> 
                            <span>Inbox</span>
                            <span v-if="newContacts > 0" class="badge rounded-pill bg-success float-end">{{newContacts}}</span>
                        </router-link>
                    </li>
                    <li class="menu-title" v-if="allowManage">Gerenciar</li>
                    <li class="mn" v-if="authUser.permissions.pages ||  authUser.permissions.slider">
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-layout-3-line"></i>
                            <span>Páginas e Slider</span>
                        </a>
                        <ul class="sub-menu mm-collapse" ref="pages" aria-expanded="false">
                            <template v-for="page in pages" >
                                <li v-if="page.is_default_page && authUser.permissions.pages" :key="page.id">
                                    <router-link target="_self" :to="`/pages/${page.id}`">{{page.name}}</router-link>
                                </li>
                            </template>
                            <li v-if="authUser.permissions.pages">
                                <router-link target="_self" :to="`/pages`">Gerenciar Páginas</router-link>
                            </li>
                            <li v-if="authUser.permissions.slider">
                                <router-link target="_self" :to="`/sliders`">Gerenciar Slides</router-link>
                            </li>
                        </ul>
                    </li>
                    <li v-if="authUser.permissions.cases || authUser.permissions.solutions" class="mn">
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-briefcase-line"></i>
                             <span>Cases e Soluções</span>
                        </a>
                        <ul class="sub-menu mm-collapse" ref="cases" aria-expanded="false">
                            <li v-if="authUser.permissions.cases">
                                <router-link target="_self" :to="`/categories`">Categorias</router-link>
                            </li>
                            <li v-if="authUser.permissions.cases">
                                <router-link target="_self" :to="`/cases`">Itens do Case</router-link>
                            </li>
                            <li v-if="authUser.permissions.solutions">
                                <router-link target="_self" :to="`/solutions`">Soluções</router-link>
                            </li>
                        </ul>
                    </li>
                    <li v-if="authUser.permissions.images" class="mn">
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-gallery-fill"></i> 
                            <span>Gerenciar de Imagens</span>
                        </a>
                        <ul class="sub-menu mm-collapse" ref="images" aria-expanded="false">
                            <li>
                                <router-link target="_self" :to="`/images`">Todas</router-link>
                            </li>
                            <li>
                                <router-link target="_self" :to="`/images?filters.table=categories`">Categorias</router-link>
                            </li>
                            <li>
                                <router-link target="_self" :to="`/images?filters.table=cases`">Cases</router-link>
                            </li>
                            <li>
                                <router-link target="_self" :to="`/images?filters.table=solutions`">Soluções</router-link>
                            </li>
                            <li>
                                <router-link target="_self" :to="`/images?filters.table=sliders`">Slides</router-link>
                            </li>
                        </ul>
                    </li>
                    <li v-if="authUser.permissions.users">
                      <router-link to="/users" class="waves-effect">
                          <i class="fa fa-users"></i> 
                          <span>Gerenciar Usuários</span>
                      </router-link>
                    </li>
                </ul>
            </div>
            <!-- Sidebar -->
        </div>
    </div>
<!-- Left Sidebar End -->
</template>
<script>
export default {
    name: 'vertical-menu',
    computed: {
        authUser(){
            return this.$store.getters.user
        },
        pages(){
            return this.$store.getters.pages.data
        },
        newContacts(){
            return this.$store.getters.contacts?.data?.filter(c => c.status == 'new').length || 0
        },
        allowManage(){
            return [
                this.authUser.permissions.cases,
                this.authUser.permissions.solutions,
                this.authUser.permissions.pages,
                this.authUser.permissions.slider,
                this.authUser.permissions.images,
                this.authUser.permissions.users,
            ].some(v => v);
        }
    },
    data(){
        return {
            updateContactsInterval: null,
        }
    },
    methods: {
        updateContacts(){
            if (!this.updateContactsInterval) {
                this.updateContactsInterval = setInterval(() => this.$store.dispatch('getContacts'), 60000 * 3)
            }
        }
    },
    beforeDestroy(){
        if(this.updateContactsInterval) clearInterval(this.updateContactsInterval)
    },
    mounted(){
        this.updateContacts()
        setTimeout(() => {if(!this.authUser) this.$store.dispatch('logout') }, 10)
    }
}
</script>