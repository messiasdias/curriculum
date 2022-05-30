<template>
<div class="page-content">
    <div class="container-fluid">
        <template v-if="$route.params.hasOwnProperty('id')" >
            <Categorie :categorieId="parseInt($route.params.id)"/>
        </template>

        <template  v-else >
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Categorias</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Lista</a></li>
                            <li class="breadcrumb-item active"><router-link to="/categories">Lista de Categorias</router-link></li>
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
                          
                        <h4 class="card-title">Categorias</h4>
                        <p class="card-title-desc">Lista de Categorias de Cases</p>
                        
                        <button 
                            type="button" 
                            class="btn btn-primary waves-effect waves-light mb-3" 
                            data-bs-toggle="modal" 
                            data-bs-target="#myModal"
                            @click.prevent="$router.push('/categories/0')"
                        >
                            Nova Categoria
                        </button>
                  

                        <div class="table-rep-plugin mt-3">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="tech-companies-1" class="table">
                                    <thead>
                                        <tr>
                                            <th data-priority="1">#</th>
                                            <th data-priority="1">Imagem</th>
                                            <th data-priority="1">Nome</th>
                                            <th data-priority="3">Criada em</th>
                                            <th data-priority="3">Atualizada em</th>
                                            <th data-priority="3">Visualização</th>
                                            <th data-priority="1">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(categorie, c) in categories" :key="categorie.id">
                                            <th>{{c + 1}}</th>
                                            <td> 
                                                <router-link :to="`/categories/${categorie.id}`">
                                                    <img loading="lazy" class="header-profile-user" :src="!!categorie.image ? `${assets}${categorie.image.url}` : `${assets}admin/images/authentication-bg.jpg`"/> 
                                                </router-link>
                                            </td>
                                            <th><span class="co-name"><router-link :to="`/categories/${categorie.id}`">{{categorie.name}}</router-link></span></th>
                                            <td>{{ dateTimeToLocaleString(categorie.created_at) || '-'}}</td>
                                            <td>{{ dateTimeToLocaleString(categorie.updated_at) || '-'}}</td>
                                            <td>
                                                <div class="form-check form-switch col-12 col-md-4" dir="ltr">
                                                    <input 
                                                        type="checkbox" 
                                                        class="form-check-input" 
                                                        :id="`categorie${categorie.id}`" 
                                                        v-model="categorie.active"
                                                        @change="activeCategorie(categorie)"
                                                    > 
                                                    <label 
                                                        class="form-check-label" 
                                                        :for="`categorie${categorie.id}`"
                                                    >
                                                        {{categorie.active ? 'Ativa' : 'Inativa'}}
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                 <div class="col-md-6">
                                                    <div class="btn-group mt-4 mt-md-0" role="group" aria-label="Ações">
                                                        <button 
                                                            @click.prevent="$router.push(`/categories/${categorie.id}`)" 
                                                            type="button" 
                                                            class="btn btn-light"
                                                        ><i class="ri-pencil-line"></i></button>
                                                        <button 
                                                            @click.prevent="showModalDeleteCategorie(categorie)" 
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
                            :page="categories_current_page"
                            :last_page="categories_last_page"
                            :dispatchEvent="'getCategories'"
                        />
                    </div>
                </div>
            </div>
        </div>

        <Modal 
            v-if="isShowDeleteModal"
            :id="`categorieModal${toDelete.id}`"
            :title="'Excluir Categoria'"
            :text="`Deseja realmente excluir a categoria <b>${toDelete.name}</b>?`"
            :closeText="'Não'"
            :confirmText="'Sim'"
            @confirm="confirmDeleteCategorie(toDelete)"
            @close="hideModalDeleteCategorie"
        />

        </template>
    </div>
</div>
</template>
<script>
import Axios from 'axios'
import Modal from './../Modal'
import Categorie from './Categorie'
import Paginator from './../Paginator'
import {dateTimeToLocaleString} from './../../../../assets/helpers'

export default {
    name: 'CaseCategories',
    components: {
        Modal,
        Categorie,
        Paginator
    },
    computed: {
        categories(){
            return this.$store.getters.categories.data
        },
        categories_current_page(){
            return this.$store.getters.categories.current_page
        },
        categories_last_page(){
            return this.$store.getters.categories.last_page
        },
    },
    data(){
        return {
            assets: window.assets,
            toDelete: null,
            isShowDeleteModal: false,
        }
    },
    methods: {
        dateTimeToLocaleString: dateTimeToLocaleString,
        showModalDeleteCategorie(categorie){
            if (categorie) {
                this.isShowDeleteModal = true
                this.toDelete = Object.assign({}, categorie)
                let modalId = `categorieModal${categorie.id}`
                setTimeout( () => {$(`#${modalId}`).modal('show')})
            }
        },
        hideModalDeleteCategorie(){
            let modalId = `categorieModal${this.toDelete.id}`
             setTimeout(() => {
               $(`#${modalId}`).modal('hide')
               this.isShowDeleteModal = false
               this.toDelete = null
            })
        },
        confirmDeleteCategorie(categorie){
             if (categorie) {
                Axios.delete(`${window.cmsApiBaseUrl}/categories`, {params: {id: categorie.id}})
                .then((response) => {this.afterDeleteCategorie(response.data.success)})
                .catch(() => this.afterDeleteCategorie(false) )
                return
            }
        },
        activeCategorie(categorie){
            if (categorie) {
                Axios.post(`${window.cmsApiBaseUrl}/categories`, categorie)
                .then((response) => this.$store.dispatch("getCategories"))
                .catch(() => this.$store.dispatch("getCategories"))
            }
        },
        afterDeleteCategorie(success = true){
            this.$store.dispatch("getCategories")
            this.hideModalDeleteCategorie()
            if(success == false) {
                this.$root.$emit('showMessage', {
                    type: "error", 
                    title: "Erro ao Excluir",
                    message: "Ocorreu um erro ao tentar o excluir a categoria!"
                })
            }
        }
    },
    mounted(){
        this.$store.dispatch("getCategories")
    }
}
</script>