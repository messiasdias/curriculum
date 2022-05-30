<template>
<div class="page-content">
    <div class="container-fluid">

        <!-- star page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Inbox</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Contatos</a></li>
                            <li class="breadcrumb-item active">Inbox</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <!-- Left sidebar -->
                <div class="email-leftbar card">
                    <div class="mail-list mt-4">
                        <a @click.prevent="filterMessages()" href="#" class="active"><i class="mdi mdi-email-outline me-2"></i> 
                            Entrada <span v-if="inboxCount > 0" class="ms-1 float-end">({{inboxCount}})</span>
                        </a>
                        <a href="#" @click.prevent="filterMessages('star', true)"><i class="mdi mdi-star-outline me-2"></i> Com Estrela</a>
                        <a href="#" @click.prevent="filterMessages('archived', true)"><i class="mdi mdi-archive me-2"></i> Arquivadas</a>
                    </div>

                    <h6 class="mt-4">Status</h6>
                    <div class="mail-list mt-1">
                        <a href="#" @click.prevent="filterMessages('status', 'new')"><span class="mdi mdi-circle-outline text-danger float-end"></span>Novos</a>
                        <a href="#" @click.prevent="filterMessages('status', 'readed')"><span class="mdi mdi-circle-outline text-info float-end"></span>Lidos</a>
                        <a href="#" @click.prevent="filterMessages('status', 'resolved')"><span class="mdi mdi-circle-outline text-success float-end"></span>Resolvidos</a>
                    </div>

                    <Notifiable />
                </div>
                <!-- End Left sidebar -->

                <!-- Right Sidebar -->
                <div class="email-rightbar mb-3">
                    <div class="card">
                        <div class="btn-toolbar p-3" role="toolbar">
                            <template v-if="!message"> 
                                <div class="btn-group me-2 mb-2 mb-sm-0">
                                    <button 
                                        @click.prevent="() => {selecteds.length > 0 ? selecteds = [] : selecteds = messages.map(m => m.id)}"
                                        :title="selecteds.length == 0 ? 'Selecionar Todos' : 'Desfazer seleção'" 
                                        type="button" class="btn btn-primary waves-light waves-effect"
                                    >
                                        <i v-if="selecteds.length > 0" class=" far fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                    </button>

                                    <button v-if="filters.column !== 'archived'" 
                                        @click.prevent="setSelectedsAs('archived', true)" 
                                        type="button" title="Arquivar Selecionadas"
                                        class="btn btn-primary waves-light waves-effect"
                                        >
                                        <i class="mdi mdi-archive-arrow-up"></i>
                                    </button>

                                    <button v-if="filters.column === 'archived'" 
                                        @click.prevent="setSelectedsAs('archived', false)" 
                                        type="button" title="Desarquivar Selecionadas"
                                        class="btn btn-primary waves-light waves-effect"
                                        >
                                        <i class="mdi mdi-archive-arrow-down"></i>
                                    </button>

                                    <button 
                                        @click.prevent="showModalDelete()" 
                                        type="button" title="Excluir"
                                        class="btn btn-primary waves-light waves-effect"
                                    >
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </div>

                                <div v-if="messages.length" class="btn-group me-2 mb-2 mb-sm-0">
                                    <button type="button" class="btn btn-primary waves-light waves-effect dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-tag"></i> <i class="mdi mdi-chevron-down"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a v-if="selecteds.length > 0" @click.prevent="setSelectedsAs('status', 'new')" class="dropdown-item" href="#">Marcar Como Não Lida</a>
                                        <a v-if="selecteds.length > 0" @click.prevent="setSelectedsAs('status', 'readed')" class="dropdown-item" href="#">Marcar Como Lido</a>
                                        <a v-if="selecteds.length > 0" @click.prevent="setSelectedsAs('status', 'resolved')" class="dropdown-item" href="#">Marcar Como Resolvido</a>
                                        <a v-if="selecteds.length > 0" @click.prevent="setSelectedsAs('star', true)" class="dropdown-item" href="#">Adicionar Estrela</a>
                                        <a v-if="selecteds.length > 0" @click.prevent="setSelectedsAs('star', false)" class="dropdown-item" href="#">Remover Estrela</a>
                                        <a v-if="selecteds.length < messages.length" @click.prevent="selecteds = messages.map(m => m.id)" class="dropdown-item" href="#">Selecionar Todas</a>
                                        <a v-if="selecteds.length > 0" @click.prevent="selecteds = []" class="dropdown-item" href="#">Desfazer seleção</a>
                                    </div>
                                </div>
                            </template>

                            <template v-if="message"> 
                                <div class="btn-group me-2 mb-2 mb-sm-0">
                                    <router-link 
                                        to="/inbox"  type="button"
                                        class="btn btn-primary waves-light waves-effect"
                                    >
                                        <i class="fas fa-arrow-left"></i>
                                    </router-link>
                                </div>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary waves-light waves-effect dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-tag"></i> <i class="mdi mdi-chevron-down"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a  @click.prevent="setNew()" class="dropdown-item" href="#">Marcar Como Não Lida</a>
                                        <a  @click.prevent="setReaded()" class="dropdown-item" href="#">Marcar Como Lido</a>
                                        <a  @click.prevent="setResolved()" class="dropdown-item" href="#">Marcar Como Resolvido</a>
                                        <a v-if="!message.start" @click.prevent="setStar(true)" class="dropdown-item" href="#">Adicionar Estrela</a>
                                        <a v-if="message.start"  @click.prevent="setStar(false)" class="dropdown-item" href="#">Remover Estrela</a>
                                        <a v-if="!message.arquived" @click.prevent="setArchived(true)" class="dropdown-item" href="#">Arquivar</a>
                                        <a v-if="message.arquived"  @click.prevent="setArchived(false)" class="dropdown-item" href="#">Desarquivar</a>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <Messages 
                            v-if="message === null" 
                            :messages="messages"
                            :statusList="statusList"
                            :selectedMessages="selecteds"
                            @open="open($event)"
                            @selecteds="selecteds = $event"
                            @star="setSelectedsAs('star', $event)"
                        />

                        <Message
                            v-else 
                            :message="message" 
                            :statusList="statusList"
                            @readed="setReaded()"
                        />
                    </div> <!-- card -->

                    <div class="row">
                        <div class="col-7">
                            Mostrando {{current_page}} - {{last_page}} de {{total_messages}}
                        </div>
                        <div class="col-5">
                            <div class="btn-group float-end">
                                <button 
                                    v-if="current_page >= 1" 
                                    @click.prevent="$store.dispatch('getMessages', (current_page - 1))"
                                    class="btn btn-sm btn-success waves-effect" type="button" 
                                > <i class="fa fa-chevron-left"></i></button>
                                <button 
                                    v-if="last_page > current_page"
                                    class="btn btn-sm btn-success waves-effect" type="button" 
                                    @click.prevent="$store.dispatch('getMessages', (current_page + 1))"
                                ><i class="fa fa-chevron-right"></i></button>
                            </div>
                        </div>
                    </div>

                </div> <!-- end Col-9 -->
            </div>
        </div><!-- End row -->

        <Modal 
            v-if="isShowDeleteModal"
            :id="`deleteModal`"
            :title="'Excluir Item'"
            :text="`Deseja realmente excluir as ${selecteds.length} mensagens selecionadas?`"
            :closeText="'Não'"
            :confirmText="'Sim'"
            @confirm="confirmaDeleteSelecteds"
            @close="hideModalDelete"
        />

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

</template>
<script>
import Axios from 'axios'
import Notifiable from './Notifiable'
import Messages from './Messages'
import Message from './Message'
import Modal from './../Modal'
export default {
    name: 'Inbox',
    components: {
        Notifiable,
        Messages,
        Message,
        Modal
    },
    computed: {
        messages() {
            if ((!!this.filters.column && ['star', 'archived', 'status'].includes(this.filters.column)) && this.filters.value !== null) { 
               return this.$store.getters.contactsFilteds?.data?.filter(c => c[this.filters.column] == this.filters.value) || []
            }
            return this.$store.getters.contactsFilteds?.data || []
        },
        allMessages() {
           return this.$store.getters.contactsFilteds?.data || []
        },
        current_page(){
            return this.$store.getters.contacts?.current_page || 1
        },
        last_page(){
            return this.$store.getters.contacts?.last_page || 1
        },
        total_messages(){
            return this.$store.getters.contacts?.total || 0
        },
        inboxCount() {
            return this.$store.getters.contacts?.data?.filter(c => c.status === 'new').length || 0
        }
    },
    data() {
        return {
            message: null,
            selecteds: [],
            isShowDeleteModal: false,
            isShowEditModal: false,
            filters: {
                column: null,
                value: null,
            },
            statusList: {
                'new': 'Novo',
                'readed': 'Lido',
                'resolved': 'Resolvido'
            },
        }
    },
    methods: {
        async getMessage(id){
            return await Axios.get(`${window.cmsApiBaseUrl}/contacts/${id}`).then(({data}) => data.contact)
        },
        async filterMessages(column = null, value = null){
            this.filters.column = column
            this.filters.value = value
            await this.$store.dispatch("getContactsFilteds", {
                page: this.current_page,
                filterColumn: column,
                filterValue: value != null && value != 'inbox' ? value : null
            })
            setTimeout(() => this.$store.dispatch("getContacts"), 2000)
            this.open()
        },
        open(message = null) {
            this.message = message
            if (!!message) this.selecteds[this.message.id]
        },
        setNew() {
            if(this.message) {
                this.selecteds = [this.message.id]
                this.setSelectedsAs('status', 'new')
                this.selecteds = [this.message.id]
                this.setSelectedsAs('arquived', false, false)
                this.$router.push('/inbox')
            }
        },
        setReaded() {
            if(this.message) {
                this.selecteds = [this.message.id]
                this.setSelectedsAs('status', 'readed', false)
                this.$router.push('/inbox')
            }
        },
        setResolved() {
            if(this.message) {
                this.selecteds = [this.message.id]
                this.setSelectedsAs('status', 'resolved', false)
                this.$router.push('/inbox')
            }
        },
        setStar(star = true) {
            if(this.message) {
                this.selecteds = [this.message.id]
                this.setSelectedsAs('star', star)
                this.$router.push('/inbox')
            }
        },
        setArchived(archived = true) {
            if(this.message) {
                this.selecteds = [this.message.id]
                this.setSelectedsAs('archived', archived)
                this.$router.push('/inbox')
            }
        },
        setSelectedsAs(column, value, updateMessages = true) {
            if (this.selecteds.length === 0 && !!this.message){
                this.selecteds[this.message.id]
            }

            if (this.selecteds.length > 0 && !!column) { 
                if (['star', 'archived'].includes(column) && value !== null) { 
                    return Axios.post(`${window.cmsApiBaseUrl}/contacts/column/${column}`, {
                        contacts_id: this.selecteds,
                        value: value
                    }).then(({data}) => {
                        if (data.success) {
                            this.selecteds = []
                            if (updateMessages) this.filterMessages(this.filters.column, this.filters.value)
                            setTimeout(() => this.$store.dispatch("getContacts"), 1000)
                        }
                    })
                }
                if (column === 'status' && value !== null) {
                    return Axios.post(`${window.cmsApiBaseUrl}/contacts/status`, {
                        contacts_id: this.selecteds,
                        status: value
                    }).then(({data}) => {
                        if (data.success) {
                            this.selecteds = []
                            if (updateMessages) this.filterMessages(this.filters.column, this.filters.value)
                            setTimeout(() => this.$store.dispatch("getContacts"), 1000)
                        }
                    })
                }
                return
            }
            this.$root.$emit('showMessage', {
                type: "warning", 
                title: "Atenção!",
                message: "Você deve selecionar as mensagens desejadas antes de executar essa ação!"
            })
        },
        showModalDelete(){
             if (this.selecteds.length > 0) { 
                this.isShowDeleteModal = true
                return setTimeout( () => {$(`#deleteModal`).modal('show')})
            }
            this.$root.$emit('showMessage', {
                type: "warning", 
                title: "Atenção!",
                message: "Você deve selecionar as mensagens desejadas antes de executar essa ação!"
            })
        },
        hideModalDelete(){
             setTimeout( () => {
               $(`#deleteModal`).modal('hide')
               this.isShowDeleteModal = false
               this.toDelete = null
            })
        },
        confirmaDeleteSelecteds(){
            this.hideModalDelete()
            if (this.selecteds.length > 0) { 
                return Axios.delete(`${window.cmsApiBaseUrl}/contacts`, {params: {contacts_id: this.selecteds}})
                .then(({data}) => {
                    if (data.success) {
                        this.selecteds = []
                        this.filterMessages(this.filters.column, this.filters.value)
                    }
                })
            }
            this.$root.$emit('showMessage', {
                type: "warning", 
                title: "Atenção!",
                message: "Você deve selecionar as mensagens desejadas antes de executar essa ação!"
            })
        },
        async queryFilter(){
            if(this.$route.params.hasOwnProperty('messages_id')) {
                let message = await this.getMessage(this.$route.params.messages_id)
                return this.open(message)
            }
            await this.filterMessages(this.filters.column, this.filters.value)
            this.open(null)
        },
    },
    watch : {
        "$route.params"(){
            this.queryFilter() 
        },
    },
    async mounted(){
        await this.queryFilter() 
    }
}
</script>