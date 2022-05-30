<template>
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Páginas Personalizadas</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Gerenciador de Páginas</a></li>
                            <li class="breadcrumb-item active">Páginas Personalizadas</li>
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
                          
                        <h4 class="card-title">Páginas</h4>
                        <p class="card-title-desc">Lista de páginas personalizadas</p>
                        
                        <button 
                            type="button" 
                            class="btn btn-primary waves-effect waves-light mb-3" 
                            data-bs-toggle="modal" 
                            data-bs-target="#myModal"
                            @click.prevent="$router.push('/pages/0')"
                        >
                            Nova Página
                        </button>
                  

                        <div class="table-rep-plugin mt-3">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="tech-companies-1" class="table">
                                    <thead>
                                        <tr>
                                            <th data-priority="1">#</th>
                                            <th data-priority="1">Nome</th>
                                            <th data-priority="1">Slug (Apelido)</th>
                                            <th data-priority="3">Texto Slogan</th>
                                            <th data-priority="3">Mostrar Layout padrão</th>
                                            <th data-priority="3">Mostrar Barra de Título</th>
                                            <th data-priority="3">Visualização</th>
                                            <th data-priority="1">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(page, p) in pages" :key="page.id">
                                            <th>{{p + 1}}</th>
                                            <th><span class="co-name"><router-link :to="`/pages/${page.id}`">{{page.name}}</router-link></span></th>
                                            <td><a :href="`/pagina/${page.slug}`" target="_blanck">{{page.slug}}</a></td>
                                            <td>{{page.breadcrumb}}</td>
                                            <td>{{page.breadcase ? 'Sim' : 'Não'}}</td>
                                            <td>{{page.show_home ? 'Sim' : 'Não'}}</td>
                                            <td>
                                                <div class="form-check form-switch col-12 col-md-4" dir="ltr">
                                                    <input 
                                                        type="checkbox" 
                                                        class="form-check-input" 
                                                        :id="`page${page.id}`" 
                                                        v-model="page.active"
                                                        @change="activePage(page)"
                                                    > 
                                                    <label 
                                                        class="form-check-label" 
                                                        :for="`page${page.id}`"
                                                    >
                                                        {{page.active ? 'Ativa' : 'Inativa'}}
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                 <div class="col-md-6">
                                                    <div class="btn-group mt-4 mt-md-0" role="group" aria-label="Ações">
                                                        <button 
                                                            @click.prevent="$router.push(`/pages/${page.id}`)" 
                                                            type="button" 
                                                            class="btn btn-light"
                                                        ><i class="ri-pencil-line"></i></button>
                                                        <button 
                                                            @click.prevent="showModalDeletePage(page)" 
                                                            type="button" 
                                                            class="btn btn-danger"
                                                            data-bs-toggle="modal" 
                                                            
                                                        ><i class="ri-delete-bin-line"></i></button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <Paginator 
                            :page="current_page"
                            :last_page="last_page"
                            :dispatchEvent="'getPages'"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <Modal 
        v-if="isShowDeleteModal"
        :id="`pageModal${toDeletePage.id}`"
        :title="'Excluír Página'"
        :text="`Deseja realmente excluír a página '${toDeletePage.name}'?`"
        :closeText="'Não'"
        :confirmText="'Sim'"
        @confirm="confirmDeletePage(toDeletePage)"
        @close="hideModalDeletePage"
    />
</div>
</template>
<script>
import Axios from 'axios'
import Modal from './../Modal'
import Paginator from './../Paginator'
export default {
    name: 'CustomPages',
    components: {
        Modal,
        Paginator
    },
    computed: {
        pages(){
            return this.$store.getters.pages?.data?.filter(page => !page.is_default_page) || []
        },
        current_page(){
            return this.$store.getters.pages?.current_page || 1
        },
        last_page(){
            return this.$store.getters.pages?.last_page || 1
        }
    },
    data(){
        return {
            toDeletePage: null,
            isShowDeleteModal: false
        }
    },
    methods: {
        activePage(page){
            if (page) {
                Axios.post(`${window.cmsApiBaseUrl}/pages`, page)
                .then((response) => this.$store.dispatch("getPages"))
                .catch(() => this.$store.dispatch("getPages"))
            }
        },
        showModalDeletePage(page){
            if (page) {
                this.isShowDeleteModal = true
                this.toDeletePage = Object.assign({}, page)
                let modalId = `pageModal${page.id}`
                setTimeout( () => {$(`#${modalId}`).modal('show')})
            }
        },
        hideModalDeletePage(){
            let modalId = `pageModal${this.toDeletePage.id}`
             setTimeout( () => {
               $(`#${modalId}`).modal('hide')
               this.isShowDeleteModal = false
               this.toDeletePage = null
            })
        },
        confirmDeletePage(page){
             if (page) {
                Axios.delete(`${window.cmsApiBaseUrl}/pages`, {params: {id: page.id}})
                .then((response) => this.afterDeletePage(response.data.success))
                .catch(() => this.afterDeletePage(false) )
                return
            }
        },
        afterDeletePage(success = true){
            this.$store.dispatch("getPages")
            this.hideModalDeletePage()
            if(!success) {
                this.$root.$emit('showMessage', {
                    type: "error", 
                    title: "Erro ao Excluír",
                    message: "Ocorreu um erro ao tentar o excluír a página!"
                })
            }
        }
    },
    mounted(){
        this.$store.dispatch("getPages")
    }
}
</script>