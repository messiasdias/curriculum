<template>
<div>
    <h6 class="mt-4">Notificar</h6>
    <small>Notificar contatos listados a cada mensagem de entrada</small>

    <div v-if="notifiables.length > 0" class="mt-4 mb-4">
        <div v-for="notifiable in notifiables" :key="notifiable.id" class="d-flex">
            <!-- To-do Future -->
                <!-- <img class="d-flex me-3 rounded-circle" :src="`${assets}admin/images/users/avatar-2.jpg`"
                alt="Generic placeholder image" height="36">  -->
            <div class="row">
                <div class="col-11 flex-1 chat-user-box overflow-hidden">
                    <p class="user-title m-0">{{notifiable.name}}</p>
                    <p class="text-muted text-truncate">{{notifiable.email}}</p>
                </div>
                <div class="col-1 d-flex justify-content-start align-items-center actions">
                    <div class="btn-group me-2 mb-2 mb-sm-0">
                        <a @click.prevent="" href="#" class="waves-light waves-effect dropdown-toggle"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical ms-2"></i>
                        </a>
                        <div class="dropdown-menu">
                            <a @click.prevent="showModalAddAndEdit(notifiable)" class="dropdown-item text-primary" href="#">
                                <i class="fa fa-edit"> </i>&nbsp; Editar
                            </a>
                            <a @click.prevent="showModalDelete(notifiable)" class="dropdown-item text-danger" href="#">
                                <i @click="showModalDelete(notifiable)" class="fa fa-trash text-danger "> </i>&nbsp; Excluir
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div v-else class="d-flex mt-4 mb-4">
        <div class="flex-1 chat-user-box overflow-hidden">
            <p class="user-title">Nenhum contato na lista atualmente</p>
        </div>
    </div>

    <div class="flex-1 chat-user-box overflow-hidden">
        <button @click.prevent="showModalAddAndEdit()" class="btn btn-primary">Adicionar Novo</button>
    </div>

    <Modal 
        v-if="isShowAddEndEditModal"
        :id="`notificationModalAddAndEdit`"
        :size="'modal-md'"
        :title="`${toEdit ? 'Editar' : 'Adicionar'} Contato`"
        @confirm="confirmAddAndEdit()"
        @close="hideModalAddAndEdit"
    >
        <template slot="body">
            <div class="row">
                <div class="row mb-3">
                    <label for="name" class="col-sm-4 col-form-label">Nome</label>
                    <div class="col-sm-8">
                        <input class="form-control" type="text" placeholder="John Santos" id="name" v-model="form.name"> 
                         <ul v-if="help.name" class="parsley-errors-list filled" id="parsley-name" aria-hidden="false">
                            <li class="parsley-minlength">{{help.name}}</li>
                        </ul>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-sm-4 col-form-label">Email</label>
                    <div class="col-sm-8">
                        <input required class="form-control" type="email" placeholder="john@exemplo.com" id="email" v-model="form.email"> 
                         <ul v-if="help.email" class="parsley-errors-list filled" id="parsley-email" aria-hidden="false">
                            <li class="parsley-minlength">{{help.email}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </template>
        <template slot="footer">
             <button 
                type="button" 
                class="btn btn-light waves-effect"
                :disabled="validate"
                @click.prevent="hideModalAddAndEdit()"
            >Cancelar</button>
            <button 
                type="button"
                class="btn btn-primary waves-effect waves-light"
                :disabled="!formModified || !validate"
                @click.prevent="confirmAddAndEdit()"
            >Salvar</button>
        </template>
    </Modal>

    <Modal 
        v-if="isShowDeleteModal"
        :id="`notificationModalDelete`"
        :title="'Excluir Contato'"
        :text="`Deseja realmente excluir o contato <b>${toDelete.name} </b>?`"
        :closeText="'Não'"
        :confirmText="'Sim'"
        @confirm="confirmDelete(toDelete)"
        @close="hideModalDelete"
    />
</div>
</template>
<script>
import Axios from 'axios'
import DefaultForm from './../../../commom/DefaultForm'
import Modal from './../Modal'
export default {
    name: 'Notifiable',
    extends: DefaultForm,
    components: {Modal},
    computed: {
        validations() {
            return {
                id: () => {
					let isValid = (!!this.toEdit && !!this.form.id) || (!this.toEdit && !this.form.id)
					return this.setHelp('id', isValid, "O ID do contato deve ser válido.");
				},
                name: () => this.defaultValidations.name("O campo nome do contato deve conter ao menos 4 caracteres."),
                email: () => this.defaultValidations.email("O campo email de conter um endereço válido."),
                phone: () => this.defaultValidations.brPhoneNumber("O telefone deve ser válido.", true),
            }
        }
    },
    data(){
        return {
            assets: window.assets,
            notifiables: [],
            isShowAddEndEditModal: false,
            isShowDeleteModal: false,
            toEdit: null, 
            toDelete: null,
            notificable: {
                id: null,
                name: null,
                email: null,
                phone: null,
                allow_notify_to_email: true,
                allow_notify_to_email: true,
            },
            form: {
                id: null,
                name: null,
                email: null,
                phone: null,
                allow_notify_to_email: true,
                allow_notify_to_email: true,
            },
            help: {
                id: null,
                name: null,
                email: null,
                phone: null,
                form: null
            }
        }
    },
    methods: {
        getNotifiables(){
            Axios.get(`${window.cmsApiBaseUrl}/notifiables`)
            .then(({data}) => this.notifiables = data)
            .catch(() => this.notifiables = [])
        },
        showModalAddAndEdit(notifiable = null){
            if (notifiable) {
                this.toEdit = Object.assign({}, notifiable)
                this.resetFormDefault(this.toEdit)
            } else {
                this.resetFormDefault({
                    id: null,
                    name: null,
                    email: null,
                    phone: null,
                    allow_notify_to_email: true,
                    allow_notify_to_email: true,
                })
            }
            this.isShowAddEndEditModal = true
            setTimeout( () => {$(`#notificationModalAddAndEdit`).modal('show')})
        },
        hideModalAddAndEdit(){
            setTimeout(() => {
                $(`#notificationModalAddAndEdit`).modal('hide')
                this.isShowAddEndEditModal = false
                this.toEdit = null
                this.resetFormDefault({
                    id: null,
                    name: null,
                    email: null,
                    phone: null,
                    allow_notify_to_email: true,
                    allow_notify_to_email: true,
                })
            })
        },
        confirmAddAndEdit(){
            if (this.validate) {
                let form = Object.assign({}, this.form)
                if (!this.toEdit) delete form.id
                Axios.post(`${window.cmsApiBaseUrl}/notifiables`, form)
                .then((response) => this.afterAddAndEdit(response.data.success))
                .catch((err) => {
                    if (err?.response.data.errors) return this.setHelps(err?.response.data.errors)
                    this.afterAddAndEdit(false) 
                })
                return
            }
        },
        afterAddAndEdit(success = true){
            this.getNotifiables()
            this.hideModalAddAndEdit()
            if(!success) {
                this.$root.$emit('showMessage', {
                    type: "error", 
                    title: "Erro ao Salvar",
                    message: "Ocorreu um erro ao tentar o salvar os dados do contato!"
                })
            }
        },
        showModalDelete(notifiable){
            if (notifiable) {
                this.isShowDeleteModal = true
                this.toDelete = Object.assign({}, notifiable)
                setTimeout( () => {$(`#notificationModalDelete`).modal('show')})
            }
        },
        hideModalDelete(){
             setTimeout( () => {
               $(`#notificationModalDelete`).modal('hide')
               this.isShowDeleteModal = false
               this.toDelete = null
            })
        },
        confirmDelete(){
            if (this.toDelete) {
                Axios.delete(`${window.cmsApiBaseUrl}/notifiables`, {params: {id: this.toDelete.id}})
                .then((response) => this.afterDelete(response.data.success))
                .catch(() => this.afterDelete(false) )
                return
            }
        },
        afterDelete(success = true){
            this.getNotifiables()
            this.hideModalDelete()
            if(!success) {
                this.$root.$emit('showMessage', {
                    type: "error", 
                    title: "Erro ao Excluir",
                    message: "Ocorreu um erro ao tentar o excluir contato!"
                })
            }
        },
    },
    beforeMount(){
        this.getNotifiables()
        this.resetFormDefault({
            id: null,
            name: null,
            email: null,
            phone: null,
            allow_notify_to_email: true,
            allow_notify_to_email: true,
        })
    }
}
</script>