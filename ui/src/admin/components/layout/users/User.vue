<template>
    <div>
        <!-- start page title -->
        <div v-if="user" class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{user.title}}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><router-link to="/users">Users</router-link></li>
                            <li class="breadcrumb-item active">{{user.name}}</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12" slot="content">

                <div class="card">
                    <form class="card-body" autocomplete="none">
                        <h4 class="card-title">{{user && user.id ? 'Editar' : 'Novo'}} usuário</h4>

                        <p class="card-title-desc">Modifique as informações do usuário</p>

                        <div class="row mb-3">
                            <ImageFile
                                v-if="user.id && authUser.id === user.id"
                                :classes="'col-12 col-sm-4 mt-4'"
                                :images_id="user.images_id" 
                                :item_table="'users'" 
                                :item_id="user.id"
                                @image="confirmSelectImage($event)"
                            />
                        </div>

                        <div v-if="authUser.id === user.id || authUser.permissions.users" class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Nome</label>
                            <div class="col-sm-4">
                                <input class="form-control" type="text" placeholder="Evandro Andrade" id="name" v-model="form.name"> 
                                 <ul v-if="help.name" class="parsley-errors-list filled" id="parsley-name" aria-hidden="false">
                                    <li class="parsley-minlength">{{help.name}}</li>
                                </ul>
                            </div>
                        </div>

                        <div v-if="authUser.id === user.id || authUser.permissions.users" class="row mb-3">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-4">
                                <div v-if="!user.email_verified_at" class="input-group">
                                    <input autocomplete="none" class="form-control" type="text" placeholder="evandro@exemplo.com" id="email" v-model="form.email"> 
                                    <div @click.prevent="sendConfirmationMail()" class="input-group-append">
                                        <span class="input-group-text text-success">
                                            <i class="ri-mail-send-fill"></i>
                                        </span>
                                    </div>
                                </div>
                                <input v-else class="form-control" type="text" placeholder="evandro@exemplo.com" id="email" v-model="form.email"> 
                                <ul v-if="help.email" class="parsley-errors-list filled" id="parsley-email" aria-hidden="false">
                                    <li class="parsley-minlength">{{help.email}}</li>
                                </ul>
                            </div>
                        </div>

                        <div v-if="(!user.id && authUser.permissions.users) || authUser.id === user.id" class="row mb-3">
                            <label for="password" class="col-sm-2 col-form-label">Senha</label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input autocomplete="none" class="form-control" :type="showPassword ? 'text' : 'password'" placeholder="*******" id="password" v-model="form.password"> 
                                    <div @click.prevent="showPassword = !showPassword" class="input-group-append">
                                        <span class="input-group-text text-warning">
                                            <i v-if="showPassword" class="fa fa-unlock-alt"></i>
                                            <i v-else class="fa fa-lock"></i>
                                        </span>
                                    </div>
                                </div>
                                 <ul v-if="help.password" class="parsley-errors-list filled" id="parsley-password" aria-hidden="false">
                                    <li class="parsley-minlength">{{help.password}}</li>
                                </ul>
                            </div>
                        </div>

                        <div v-if="authUser.id !== user.id && authUser.permissions.users" class="row mb-3">
                           <label for="type" class="col-sm-2 col-form-label">Visualização</label>
                            <div class="col-sm-4 form-switch-content d-flex justify-content-start mt-2">
                                <div class="form-check form-switch" dir="ltr">
                                    <input type="checkbox" class="form-check-input" id="active" v-model="form.active" >
                                    <label class="form-check-label" for="active">Ativo / Inativo</label>
                                </div>
                            </div>
                        </div>


                        <div class="mb-0 mt-3">
                            <button 
                                @click.prevent="saveUser()" 
                                :disabled="disableSaveBtn" 
                                type="submit" 
                                class="btn btn-primary waves-effect waves-light me-1 pull-left"
                            >
                                Salvar
                            </button>
                            <button 
                                @click.prevent="getUser()"  
                                :disabled="disableSaveBtn" 
                                type="reset" 
                                class="btn btn-secondary waves-effect me-1 pull-left"
                            >
                                Cancelar
                            </button>
                            <button 
                                v-if="authUser.permissions.users && authUser.id !== user.id"
                                @click.prevent="$router.push(`/users`)" 
                                type="button" 
                                class="btn btn-light waves-effect me-1 pull-right"
                            >
                                Voltar à lista
                            </button>
                            <button 
                                v-if="authUser.id === user.id"
                                @click.prevent="$router.push(`/`)" 
                                type="button" 
                                class="btn btn-light waves-effect me-1 pull-right"
                            >
                                Voltar a Dashboard
                            </button>
                        </div>

                    </form>
                </div>

            </div> <!-- end col-12 slot="content" -->
        </div>
        <!-- end row -->

    </div>
</template>
<script>
import Axios from 'axios'
import DefaultForm from './../../../commom/DefaultForm'
import ImageFile from './../images/Image'
export default {
    name: 'User',
    extends: DefaultForm,
    components: {ImageFile},
    props: {
        userId: {
            type: Number,
            default: 0
        },
    },
    data(){
        return {
            showPassword: false,
            user: {
                id: null,
                name: null,
                email: null,
                password: null,
                images_id: null,
                active: true
            },
            form: {
                id: null,
                name: null,
                email: null,
                password: null,
                images_id: null,
                active: true
            },
            help: {
                name: null,
                email: null,
                password: null,
                images_id: null,
                form: null
            }
        }
    },
    computed: {
        authUser(){
            return this.$store.getters.user
        },
        validations(){
			return {
                name: () => this.defaultValidations.name("O campo nome deve conter um endereço válido."),
                email: () => this.defaultValidations.email("O campo email deve conter um endereço válido." ),
                password: () => {
                    if (!!this.form.id && !this.form.password) return true; 
                    return this.defaultValidations.password("O campo senha não pode ser vazio.", 8)
                },
			}
		},
    },
    methods: {
        resetForm(){
            this.user = {
                id: null,
                name: null,
                email: null,
                password: null,
                images_id: null,
                active: true
            },

            this.resetFormDefault({
                id: null,
                name: null,
                email: null,
                password: null,
                images_id: null,
                active: true
            })
        },
        getUser(){
            if(!!this.userId && this.userId > 0) {
                Axios.get(`${window.cmsApiBaseUrl}/users/${this.userId}`)
                .then((response) => {
                    this.user = response.data.user

                    if (!this.authUser.permissions.users && this.user.id !== this.authUser.id) {
                        return this.$router.push('/')
                    }

                    this.setFormDefault(this.user)
                })
                .catch(() => {
                    this.$root.$emit('showMessage', {
                        type: "error", 
                        title: "Não Encontrado",
                        message:"Item não Encontrado!"
                    })
                    this.$router.push(`/users`)
                })
                return
            }

            if (this.userId === null) {
                this.$router.push({path: '/'})
            }

            if(this.userId === 0) {
                this.resetForm()
            }
        },
        saveUser(){
            if (this.validate) {
                 Axios.post(`${window.cmsApiBaseUrl}/users`, this.form)
                .then((response) => {
                    this.user = response.data.user
                    this.setFormDefault(this.user)

                    if(response.data.success){
                        this.$root.$emit('showMessage', {
                            type: "success", 
                            title: "Salvo",
                            message:"Dados salvos com sucesso!"
                        })
                        this.$store.dispatch("getUsers")
                        if (this.user.id != this.authUser.id) {
                            this.$router.push(`/users`)
                        } else {
                            this.$store.dispatch('getUser')
                        } 
                    }

                    if(response.data.errors) this.setHelps(response.data.errors)
                })
                .catch((error) => {
                    if(error?.response.data.errors) {
                        this.setHelps(error?.response.data.errors)
                    } else {
                        this.$root.$emit('showMessage', {
                            type: "error", 
                            title: "Não Salvo",
                            message: "Ocorreu um erro ao tentar salvar os dados!"
                        })
                    }
                })
            }
        },
        reloadUser(){
            this.resetForm()
            this.getUser()
        },
        confirmSelectImage(image){
            this.form.images_id = image?.id || null
            if(!image) this.user.images_id = null
        },
        sendConfirmationMail(){
            this.$emit('sendConfirmationMail', this.user)
        }
    },
    mounted(){
        this.reloadUser()
    },
    watch :{
        userId(){
            this.reloadUser()
        },
        "$route.path"(){
            this.reloadUser()
        }
    }
}
</script>