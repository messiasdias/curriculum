<template>
<div class="page-content">
    <div class="container-fluid">
        <template v-if="$route.params.hasOwnProperty('id')" >
            <Slider 
                :sliderTypes="sliderTypes"
                :sliderId="parseInt($route.params.id)"
            />
        </template>

        <template  v-else >
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Home Slider</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Lista</a></li>
                            <li class="breadcrumb-item active"><router-link to="/sliders">Lista de Slides</router-link></li>
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
                          
                        <h4 class="card-title">Itens do Slider</h4>
                        <p class="card-title-desc">Lista de itens do Slider</p>
                        
                        <button 
                            type="button" 
                            class="btn btn-primary waves-effect waves-light mb-3" 
                            @click.prevent="$router.push('/sliders/0')"
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
                                            <th data-priority="1">Título</th>
                                            <th data-priority="2">Subtítulo</th>
                                            <th data-priority="1">Tipo</th>
                                            <th data-priority="3">Início da Veiculação</th>
                                            <th data-priority="3">Final da Veiculação</th>
                                            <th data-priority="3">Criada em</th>
                                            <th data-priority="3">Atualizada em</th>
                                            <th data-priority="3">Visualização</th>
                                            <th data-priority="1">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(slider, c) in sliders" :key="slider.id">
                                            <th>{{c + 1}}</th>
                                            <td> 
                                                <router-link :to="`/sliders/${slider.id}`">
                                                    <img class="header-profile-user" :src="slider.image ? `${assets}${slider.image.url}` : `${assets}admin/images/authentication-bg.jpg`"/>
                                                </router-link> 
                                            </td>
                                            <th><span><router-link :to="`/sliders/${slider.id}`" v-html="slider.title"></router-link></span></th>
                                            <th><span v-html="slider.subtitle"></span></th>
                                            <th><span>{{sliderTypes[slider.type]}}</span></th>
                                            <td>{{dateTimeToLocaleString(slider.broadcast_start) || '-'}}</td>
                                            <td>{{dateTimeToLocaleString(slider.broadcast_end) || '-'}}</td>
                                            <td>{{dateTimeToLocaleString(slider.created_at) || '-'}}</td>
                                            <td>{{dateTimeToLocaleString(slider.updated_at) || '-'}}</td>
                                            <td>
                                                <div class="form-check form-switch col-12 col-md-4" dir="ltr">
                                                    <input 
                                                        type="checkbox" 
                                                        class="form-check-input" 
                                                        :id="`slider${slider.id}`" 
                                                        v-model="slider.active"
                                                        @change="activeSlider(slider)"
                                                    > 
                                                    <label 
                                                        class="form-check-label" 
                                                        :for="`slider${slider.id}`"
                                                    >
                                                        {{slider.active ? 'Ativo' : 'Inativo'}}
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                 <div class="col-md-6">
                                                    <div class="btn-group mt-4 mt-md-0" role="group" aria-label="Ações">
                                                        <button 
                                                            @click.prevent="$router.push(`/sliders/${slider.id}`)" 
                                                            type="button" 
                                                            class="btn btn-light"
                                                        ><i class="ri-pencil-line"></i></button>
                                                        <button 
                                                            @click.prevent="showModalDelete(slider)" 
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
                            :page="sliders_current_page"
                            :last_page="sliders_last_page"
                            :dispatchEvent="'getSliders'"
                        />
                    </div>
                </div>
            </div>
        </div>

        <Modal 
            v-if="isShowDeleteModal"
            :id="`sliderModal${toDelete.id}`"
            :title="'Excluir Slide'"
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
import Slider from './Slider'
import Paginator from './../Paginator'
import {dateTimeToLocaleString} from '../../../../assets/helpers'

export default {
    name: 'Sliders',
    components: {
        Slider,
        Modal,
        Paginator
    },
    computed: {
        sliders(){
            return this.$store.getters.sliders.data
        },
        sliders_current_page(){
            return this.$store.getters.sliders.current_page
        },
        sliders_last_page(){
            return this.$store.getters.sliders.last_page
        }
    },
    data(){
        return {
            assets: window.assets,
            toDelete: null,
            isShowDeleteModal: false,
            sliderTypes: {
                "slider": 'Slider',
                "box": 'Box'
            }
        }
    },
    methods: {
        dateTimeToLocaleString: dateTimeToLocaleString,
        showModalDelete(slider){
            if (slider) {
                this.isShowDeleteModal = true
                this.toDelete = Object.assign({}, slider)
                let modalId = `sliderModal${slider.id}`
                setTimeout( () => {$(`#${modalId}`).modal('show')})
            }
        },
        hideModalDelete(){
            let modalId = `sliderModal${this.toDelete.id}`
             setTimeout( () => {
               $(`#${modalId}`).modal('hide')
               this.isShowDeleteModal = false
               this.toDelete = null
            })
        },
        activeSlider(slider){
            if (slider) {
                Axios.post(`${window.cmsApiBaseUrl}/sliders`, slider)
                .then((response) => this.$store.dispatch("getSliders"))
                .catch(() => this.$store.dispatch("getSliders"))
            }
        },
        confirmDelete(slider){
             if (slider) {
                Axios.delete(`${window.cmsApiBaseUrl}/sliders`, {params: {id: slider.id}})
                .then((response) => this.afterDelete(response.data.success))
                .catch(() => this.afterDelete(false) )
                return
            }
        },
        afterDelete(success = true){
            this.$store.dispatch("getSliders")
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
        this.$store.dispatch("getSliders")
    }
}
</script>