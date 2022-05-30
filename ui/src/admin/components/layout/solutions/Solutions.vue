<template>
<div class="page-content">
    <div class="container-fluid">
        <template v-if="$route.params.hasOwnProperty('id')" >
            <Solution :solutionId="parseInt($route.params.id)"/>
        </template>

        <template  v-else >
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Soluções</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><router-link to="/solutions">Lista</router-link></li>
                            <li class="breadcrumb-item active">Lista de Soluções</li>
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
                          
                        <h4 class="card-title">Itens de Solução</h4>
                        <p class="card-title-desc">Lista de itens de Solução</p>
                        
                        <button 
                            type="button" 
                            class="btn btn-primary waves-effect waves-light mb-3" 
                            @click.prevent="$router.push('/solutions/0')"
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
                                            <th data-priority="1">Títutlo</th>
                                            <th data-priority="3">Criada em</th>
                                            <th data-priority="3">Atualizada em</th>
                                            <th data-priority="3">Visualização</th>
                                            <th data-priority="1">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(solution, c) in solutions" :key="solution.id">
                                            <th>{{c + 1}}</th>
                                            <td> 
                                                <router-link :to="`/solutions/${solution.id}`">
                                                    <img loading="lazy" class="header-profile-user" :src="!!solution.image ? `${assets}${solution.image.url}` : `${assets}admin/images/authentication-bg.jpg`"/>
                                                </router-link>
                                            </td>
                                            <th><span class="co-title"><router-link :to="`/solutions/${solution.id}`">{{solution.title}}</router-link></span></th>
                                            <td>{{dateTimeToLocaleString(solution.created_at) || '-'}}</td>
                                            <td>{{dateTimeToLocaleString(solution.updated_at) || '-'}}</td>
                                            <td>
                                                <div class="form-check form-switch col-12 col-md-4" dir="ltr">
                                                    <input 
                                                        type="checkbox" 
                                                        class="form-check-input" 
                                                        :id="`solution${solution.id}`" 
                                                        v-model="solution.active"
                                                        @change="activeSolution(solution)"
                                                    > 
                                                    <label 
                                                        class="form-check-label" 
                                                        :for="`solution${solution.id}`"
                                                    >
                                                        {{solution.active ? 'Ativa' : 'Inativa'}}
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                 <div class="col-md-6">
                                                    <div class="btn-group mt-4 mt-md-0" role="group" aria-label="Ações">
                                                        <button 
                                                            @click.prevent="$router.push(`/solutions/${solution.id}`)" 
                                                            type="button" 
                                                            class="btn btn-light"
                                                        ><i class="ri-pencil-line"></i></button>
                                                        <button 
                                                            @click.prevent="showModalDelete(solution)" 
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
                            :page="solutions_current_page"
                            :last_page="solutions_last_page"
                            :dispatchEvent="'getSolutions'"
                        />
                    </div>
                </div>
            </div>
        </div>

        <Modal 
            v-if="isShowDeleteModal"
            :id="`solutionModal${toDelete.id}`"
            :title="'Excluir Item'"
            :text="`Deseja realmente excluir o item <b>${toDelete.title}</b>?`"
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
import Solution from './Solution'
import Paginator from './../Paginator'
import {dateTimeToLocaleString} from './../../../../assets/helpers'

export default {
    name: 'Solutions',
    components: {
        Solution,
        Modal,
        Paginator
    },
    computed: {
        solutions(){
            return this.$store.getters.solutions.data
        },
        solutions_current_page(){
            return this.$store.getters.solutions.current_page
        },
        solutions_last_page(){
            return this.$store.getters.solutions.last_page
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
        showModalDelete(solution){
            if (solution) {
                this.isShowDeleteModal = true
                this.toDelete = Object.assign({}, solution)
                let modalId = `solutionModal${solution.id}`
                setTimeout( () => {$(`#${modalId}`).modal('show')})
            }
        },
        hideModalDelete(){
            let modalId = `solutionModal${this.toDelete.id}`
             setTimeout( () => {
               $(`#${modalId}`).modal('hide')
               this.isShowDeleteModal = false
               this.toDelete = null
            })
        },
        confirmDelete(solution){
             if (solution) {
                Axios.delete(`${window.cmsApiBaseUrl}/solutions`, {params: {id: solution.id}})
                .then((response) => this.afterDelete(response.data.success))
                .catch(() => this.afterDelete(false) )
                return
            }
        },
        activeSolution(solution){
            if (solution) {
                Axios.post(`${window.cmsApiBaseUrl}/solutions`, solution)
                .then((response) => this.$store.dispatch("getSolutions"))
                .catch(() => this.$store.dispatch("getSolutions"))
            }
        },
        afterDelete(success = true){
            this.$store.dispatch("getSolutions")
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
        this.$store.dispatch("getSolutions")
    }
}
</script>