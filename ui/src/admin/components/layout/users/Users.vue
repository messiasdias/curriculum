<template>
<div class="page-content">
    <div class="container-fluid">
        <template v-if="$route.params.hasOwnProperty('id')" >
            <User 
                :userId="parseInt($route.params.id)" 
                @sendConfirmationMail="showSendConfirmationMail($event)"
            />
        </template>

        <template  v-else >
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Usuários</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><router-link to="/users">Lista</router-link></li>
                                <li class="breadcrumb-item active">Lista de Usuários</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12" slot="content">

                    <div class="card">
                        <div class="card-body">
                            
                            <h4 class="card-title">Usuários</h4>
                            <p class="card-title-desc">Lista de Usuários</p>
                            
                            <button 
                                type="button" 
                                class="btn btn-primary waves-effect waves-light mb-3" 
                                @click.prevent="$router.push('/users/0')"
                            >
                                Novo Usuário
                            </button>
                    
                            <div class="table-rep-plugin mt-3">
                                <div class="table-responsive mb-0" data-pattern="priority-columns">
                                    <table id="tech-companies-1" class="table">
                                        <thead>
                                            <tr>
                                                <th data-priority="1">#</th>
                                                <th data-priority="1">Imagem</th>
                                                <th data-priority="1">Name</th>
                                                <th data-priority="1">Email</th>
                                                <th data-priority="1">Email Confirmado</th>
                                                <th data-priority="3">Criado</th>
                                                <th data-priority="3">Atualizado</th>
                                                <th data-priority="3">Ativo</th>
                                                <th data-priority="1">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template v-for="(user, c) in users" >
                                            <tr v-if="authUser.id !== user.id" :key="user.id">
                                                <th>{{c + 1}}</th>
                                                <td> 
                                                    <router-link :to="`/users/${user.id}`">
                                                        <img loading="lazy" class="header-profile-user" :src="!!user.image ? `${assets}${user.image.url}` : `${assets}admin/images/authentication-bg.jpg`"/>
                                                    </router-link>
                                                </td>
                                                <th><span class="co-name"><router-link :to="`/users/${user.id}`">{{user.name}}</router-link></span></th>
                                                <th><span class="co-email"><router-link :to="`/users/${user.id}`">{{user.email}}</router-link></span></th>
                                                <td>{{user.email_verified_at ? 'Sim': 'Não'}}</td>
                                                <td>{{dateTimeToLocaleString(user.created_at) || '-'}}</td>
                                                <td>{{dateTimeToLocaleString(user.updated_at) || '-'}}</td>
                                                <td>
                                                    <div v-if="user.id !== authUser.is" class="form-check form-switch col-12 col-md-4" dir="ltr">
                                                        <input 
                                                            type="checkbox" 
                                                            class="form-check-input" 
                                                            :id="`user${user.id}`" 
                                                            v-model="user.active"
                                                            @change="activeUser(user)"
                                                        > 
                                                        <label 
                                                            class="form-check-label" 
                                                            :for="`user${user.id}`"
                                                        >
                                                            {{user.active ? 'Ativa' : 'Inativa'}}
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="col-md-6">
                                                        <div class="btn-group mt-4 mt-md-0" role="group" aria-label="Ações">
                                                            <button 
                                                                @click.prevent="$router.push(`/users/${user.id}`)" 
                                                                type="button" 
                                                                class="btn btn-light"
                                                            ><i class="ri-pencil-line"></i></button>
                                                            <button 
                                                                v-if="!user.email_verified_at"
                                                                @click.prevent="showSendConfirmationMail(user)" 
                                                                type="button" 
                                                                class="btn btn-success"
                                                                data-bs-toggle="modal" 
                                                                
                                                            ><i class="ri-mail-send-fill"></i></button>
                                                            <button 
                                                                v-if="authUser.permissions.users"
                                                                @click.prevent="showhPermissionsModal(user)" 
                                                                type="button" 
                                                                class="btn btn-info"
                                                                data-bs-toggle="modal" 
                                                            ><i class="ri-key-fill"></i></button>
                                                            <button 
                                                                @click.prevent="showModalDelete(user)" 
                                                                type="button" 
                                                                class="btn btn-danger"
                                                                data-bs-toggle="modal" 
                                                                
                                                            ><i class="ri-delete-bin-line"></i></button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <Paginator 
                                :page="users_current_page"
                                :last_page="users_last_page"
                                :dispatchEvent="'getUsers'"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <Modal 
                v-if="isShowDeleteModal"
                :id="`userDeleteModal`"
                :title="'Excluir Item'"
                :text="`Deseja realmente excluir o item <b>${toDelete.name}</b>?`"
                :closeText="'Não'"
                :confirmText="'Sim'"
                @confirm="confirmDelete(toDelete)"
                @close="hideModalDelete"
        />

        </template>

        <Modal 
            v-if="isShowSendConfirmatioMailModal"
            :id="`userSendConfirmationMailModal`"
            :title="'Enviar email de confirmação '"
            :text="`Deseja enviar uma mensagem de confirmação para <b>${toConfirmMail.name} - ${toConfirmMail.email}</b>?`"
            :closeText="'Não'"
            :confirmText="'Sim'"
            @confirm="confirmMail(toConfirmMail)"
            @close="hideSendConfirmatioMail"
        />

        <Permissions 
            v-if="isShowPermissionsModal && toEditPermissions"
            :modalId="`userPermissionsModal`"
            :modalTitle="'Editar Permissões do Usuário'"
            :user="toEditPermissions"
            @confirm="confirmPermissions($event)"
            @close="hidePermissionsModal"
        />

    </div>
</div>
</template>
<script>
import Axios from 'axios'
import Modal from './../Modal'
import User from './User'
import Permissions from './Permissions'
import Paginator from './../Paginator'
import {dateTimeToLocaleString} from '../../../../assets/helpers'

export default {
    name: 'Users',
    components: {
        User,
        Modal,
        Permissions,
        Paginator
    },
    computed: {
        users(){
            return this.$store.getters.users.data
        },
        users_current_page(){
            return this.$store.getters.users.current_page
        },
        users_last_page(){
            return this.$store.getters.users.last_page
        },
        authUser(){
            return this.$store.getters.user
        }
    },
    data(){
        return {
            assets: window.assets,
            toDelete: null,
            toConfirmMail: null,
            toEditPermissions: null, 
            isShowDeleteModal: false,
            isShowSendConfirmatioMailModal: false,
            isShowPermissionsModal: false,
        }
    },
    methods: {
        dateTimeToLocaleString: dateTimeToLocaleString,
        showModalDelete(user){
            if (user) {
                this.isShowDeleteModal = true
                this.toDelete = Object.assign({}, user)
                setTimeout( () => {$(`#userDeleteModal`).modal('show')})
            }
        },
        hideModalDelete(){
             setTimeout( () => {
               $(`#userDeleteModal`).modal('hide')
               this.isShowDeleteModal = false
               this.toDelete = null
            })
        },
        confirmDelete(user){
             if (user) {
                Axios.delete(`${window.cmsApiBaseUrl}/users`, {params: {id: user.id}})
                .then(({data}) => this.afterDelete(data.success))
                .catch(() => this.afterDelete(false) )
                return
            }
        },
        afterDelete(success = true){
            this.$store.dispatch("getUsers")
            this.hideModalDelete()
            if(!success) {
                this.$root.$emit('showMessage', {
                    type: "error", 
                    title: "Erro ao Excluir",
                    message: "Ocorreu um erro ao tentar o excluir item!"
                })
            }
        },
        showSendConfirmationMail(user){
            if (user && user.email_verified_at === null) {
                this.isShowSendConfirmatioMailModal = true
                this.toConfirmMail = Object.assign({}, user)
                setTimeout( () => {$(`#userSendConfirmationMailModal`).modal('show')})
            }
        },
        hideSendConfirmatioMail(){
            setTimeout( () => {
               $(`#userSendConfirmationMailModal`).modal('hide')
               this.isShowSendConfirmatioMailModal = false
               this.toConfirmMail = null
            })
        },
        confirmMail(user){
             if (user) {
                Axios.get(`${window.cmsApiBaseUrl}/users/send-confirm-mail/${user.id}`,)
                .then(({data}) => this.afterConfirmaMail(data.success))
                .catch(() => this.afterConfirmaMail(false) )
                return
            }
        },
        afterConfirmaMail(success = true){
            this.$store.dispatch("getUsers")
            this.hideSendConfirmatioMail()
            if(!success) {
                this.$root.$emit('showMessage', {
                    type: "error", 
                    title: "Erro ao confirmar email",
                    message: "Ocorreu um erro ao tentar o confirmar email do usuário!"
                })
            }
        },
        showhPermissionsModal(user){
            if (user) {
                this.isShowPermissionsModal = true
                this.toEditPermissions = Object.assign({}, user)
                setTimeout( () => {$(`#userPermissionsModal`).modal('show')})
            }
        },
        hidePermissionsModal(){
            setTimeout( () => {
               $(`#userPermissionsModal`).modal('hide')
               this.isShowPermissionsModal = false
               this.toEditPermissions = null
            })
        },
        confirmPermissions(user){
             if (user) {
                Axios.post(`${window.cmsApiBaseUrl}/users/permissions`, this.toEditPermissions.permissions)
                .then(({data}) => this.afterConfirmPermissions(data.success))
                .catch(() => this.afterConfirmPermissions(false) )
                return
            }
        },
        afterConfirmPermissions(success = true){
            this.$store.dispatch("getUsers")
            this.hidePermissionsModal()
            if(!success) {
                this.$root.$emit('showMessage', {
                    type: "error", 
                    title: "Erro ao editar as permissões",
                    message: "Ocorreu um erro ao tentar o editar as permissões do usuário!"
                })
            }
        },
        activeUser(user){
            if (user) {
                Axios.post(`${window.cmsApiBaseUrl}/users`, user)
                .then(() => this.$store.dispatch("getUsers"))
                .catch(() => this.$store.dispatch("getUsers"))
            }
        },
    },
    mounted(){
        if (!this.authUser.permissions.users && !this.$route.params.hasOwnProperty('id')) return this.$router.push('/')
        this.$store.dispatch("getUsers")
    }
}
</script>