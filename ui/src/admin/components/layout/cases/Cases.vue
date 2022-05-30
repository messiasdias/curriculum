<template>
<div class="page-content">
    <div class="container-fluid">
        <template v-if="$route.params.hasOwnProperty('id')" >
            <Case :caseItemId="parseInt($route.params.id)"/>
        </template>

        <template  v-else >
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Cases</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Lista</a></li>
                            <li class="breadcrumb-item active"><router-link to="/cases">Lista de itens</router-link></li>
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
                          
                        <h4 class="card-title">Itens do Case</h4>
                        <p class="card-title-desc">Lista de itens do Case</p>
                        
                        <button 
                            type="button" 
                            class="btn btn-primary waves-effect waves-light mb-3" 
                            @click.prevent="$router.push('/cases/0')"
                        >
                            Novo Item
                        </button>
                  
                        <div class="table-rep-plugin mt-3">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="tech-companies-1" class="table">
                                    <thead>
                                        <tr>
                                            <th data-priority="1">#</th>
                                            <th data-priority="1">Imagem</th>
                                            <th data-priority="1">Nome</th>
                                            <th data-priority="2">Localização</th>
                                            <th data-priority="1">Categoria</th>
                                            <th data-priority="3">Criada em</th>
                                            <th data-priority="3">Atualizada em</th>
                                            <th data-priority="3">Visualização</th>
                                            <th data-priority="1">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(caseItem, c) in cases" :key="caseItem.id">
                                            <th>{{c + 1}}</th>
                                            <td> 
                                                <router-link :to="`/cases/${caseItem.id}`">
                                                    <img loading="lazy" class="header-profile-user" :src="caseItem.image ? `${assets}${caseItem.image.url}` : `${assets}admin/images/authentication-bg.jpg`"/> 
                                                </router-link>
                                            </td>
                                            <th><span class="co-name"><router-link :to="`/cases/${caseItem.id}`">{{caseItem.name}}</router-link></span></th>
                                            <th><span class="co-localization">{{caseItem.localization}}</span></th>
                                            <th><span class="co-localization">{{caseItem.categorie.name}}</span></th>
                                            <td>{{dateTimeToLocaleString(caseItem.created_at) || '-'}}</td>
                                            <td>{{dateTimeToLocaleString(caseItem.updated_at) || '-'}}</td>
                                            <td>
                                                <div class="form-check form-switch col-12 col-md-4" dir="ltr">
                                                    <input 
                                                        type="checkbox" 
                                                        class="form-check-input" 
                                                        :id="`caseItem${caseItem.id}`" 
                                                        v-model="caseItem.active"
                                                        @change="activeCase(caseItem)"
                                                    > 
                                                    <label 
                                                        class="form-check-label" 
                                                        :for="`caseItem${caseItem.id}`"
                                                    >
                                                        {{caseItem.active ? 'Ativo' : 'Inativo'}}
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                 <div class="col-md-6">
                                                    <div class="btn-group mt-4 mt-md-0" role="group" aria-label="Ações">
                                                        <button 
                                                            @click.prevent="$router.push(`/cases/${caseItem.id}`)" 
                                                            type="button" 
                                                            class="btn btn-light"
                                                        ><i class="ri-pencil-line"></i></button>
                                                        <button 
                                                            @click.prevent="showModalDelete(caseItem)" 
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
                            :page="cases_current_page"
                            :last_page="cases_last_page"
                            :dispatchEvent="'getCases'"
                        />
                    </div>
                </div>
            </div>
        </div>

        <Modal 
            v-if="isShowDeleteModal"
            :id="`caseItemModal${toDelete.id}`"
            :title="'Excluir Item'"
            :text="`Deseja realmente excluir o item <b>${toDelete.name}</b>?`"
            :closeText="'Não'"
            :confirmText="'Sim'"
            @confirm="confirmDelete(toDelete)"
            @close="hideModalDelete"
        />

        </template>
    </div>
</div>
</template>
<script>
import Axios from 'axios'
import Modal from './../Modal'
import Case from './Case'
import Paginator from './../Paginator'
import {dateTimeToLocaleString} from './../../../../assets/helpers'

export default {
    name: 'Cases',
    components: {
        Case,
        Modal,
        Paginator
    },
    computed: {
        cases(){
            return this.$store.getters.cases.data
        },
        cases_current_page(){
            return this.$store.getters.cases.current_page
        },
        cases_last_page(){
            return this.$store.getters.cases.last_page
        }
    },
    data(){
        return {
            assets: window.assets,
            toDelete: null,
            isShowDeleteModal: false
        }
    },
    methods: {
        dateTimeToLocaleString: dateTimeToLocaleString,
        showModalDelete(caseItem){
            if (caseItem) {
                this.isShowDeleteModal = true
                this.toDelete = Object.assign({}, caseItem)
                let modalId = `caseItemModal${caseItem.id}`
                setTimeout( () => {$(`#${modalId}`).modal('show')})
            }
        },
        hideModalDelete(){
            let modalId = `caseItemModal${this.toDelete.id}`
             setTimeout( () => {
               $(`#${modalId}`).modal('hide')
               this.isShowDeleteModal = false
               this.toDelete = null
            })
        },
        activeCase(caseItem){
            if (caseItem) {
                Axios.post(`${window.cmsApiBaseUrl}/cases`, caseItem)
                .then((response) => this.$store.dispatch("getCases"))
                .catch(() => this.$store.dispatch("getCases"))
            }
        },
        confirmDelete(caseItem){
             if (caseItem) {
                Axios.delete(`${window.cmsApiBaseUrl}/cases`, {params: {id: caseItem.id}})
                .then((response) => this.afterDelete(response.data.success))
                .catch(() => this.afterDelete(false) )
                return
            }
        },
        afterDelete(success = true){
            this.$store.dispatch("getCases")
            this.hideModalDelete()
            if(!success) {
                this.$root.$emit('showMessage', {
                    type: "error", 
                    title: "Erro ao Excluir",
                    message: "Ocorreu um erro ao tentar o excluir item!"
                })
            }
        },
    },
    mounted(){
        this.$store.dispatch("getCases")
    }
}
</script>