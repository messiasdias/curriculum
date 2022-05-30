<template>
    <div>
        <!-- start page title -->
        <div v-if="caseItem" class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{caseItem.name}}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><router-link to="/cases">Cases</router-link></li>
                            <li class="breadcrumb-item active">Item de Case</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{caseItem && caseItem.id ? 'Editar' : 'Novo'}} Item de Case</h4>

                        <p class="card-title-desc">Modifique as informações do item de case </p>
    
                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Nome do Item</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" placeholder="Caso de Sucesso" id="name" v-model="form.name"> 
                                 <ul v-if="help.name" class="parsley-errors-list filled" id="parsley-name" aria-hidden="false">
                                    <li class="parsley-minlength">{{help.name}}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="categories_id" class="col-sm-2 col-form-label">Categoria</label>
                            <div class="col-sm-3">
                                <select class="form-select" id="categories_id" v-model="form.categories_id"> 
                                    <option :value="null">Selecione uma Categoria</option>
                                    <option 
                                        v-for="categorie in categories" 
                                        :key="categorie.id"
                                        :value="categorie.id"
                                    >
                                        {{categorie.name}}
                                    </option>
                                </select>
                                <ul v-if="help.categories_id" class="parsley-errors-list filled" id="parsley-categories_id" aria-hidden="false">
                                    <li class="parsley-minlength">{{help.categories_id}}</li>
                                </ul>
                            </div>
                      
                            <label for="localization" class="col-sm-2 col-form-label">Localização</label>
                            <div class="col-sm-5">
                                <input class="form-control" type="text" placeholder="Cascavel, Paraná" id="localization" v-model="form.localization"> 
                                <ul v-if="help.localization" class="parsley-errors-list filled" id="parsley-localization" aria-hidden="false">
                                    <li class="parsley-minlength">{{help.localization}}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="text" class="col-sm-2 col-form-label">Texto Personalizado</label>
                            <div class="col-sm-10">
                                <vue-editor  v-model="form.text" />
                                <ul v-if="this.help.text" class="parsley-errors-list filled" id="parsley-text" aria-hidden="false">
                                    <li class="parsley-minlength">{{this.help.text}}</li>
                                </ul>
                            </div>
                        </div>

                        <div v-if="caseItem.id" class="row mb-3">
                            <div class="col-12 col-12 col-md-4">
                                <label for="name" class="col-12 col-form-label">Imagem destaque</label>
                                <ImageFile
                                    :classes="'col-12 mt-4'"
                                    :images_id="caseItem.images_id" 
                                    :item_table="'cases'" 
                                    :item_id="caseItem.id"
                                    @image="confirmSelectImage($event)"
                                />
                            </div>
                    
                            <div name="galery" class="col-12 col-12 col-md-7 mb-4">
                                <label for="galery" class="col-12 col-form-label">Galeria</label>
                                <CaseGalery 
                                    :classes="'col-12 mt-4'"
                                    :item_table="'cases'" 
                                    :item_id="caseItem.id"
                                    :galeryItems="caseItem.galery"
                                    @getCaseItem="getCase()"
                                />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="video" class="col-sm-2 col-form-label">Video URL</label>
                            <div class="col-sm-8">
                                <input class="form-control col-6" type="url" placeholder="https://www.youtube.com/embed/JTqz_xzozl0" id="video" v-model="form.video"> 
                                <ul v-if="help.video" class="parsley-errors-list filled" id="parsley-video" aria-hidden="false">
                                    <li class="parsley-minlength">{{help.video}}</li>
                                </ul>

                                <div v-if="form.video" class="mt-4 mb-4 col-12 vídeos">
                                    <iframe 
                                        width="100%" 
                                        height="280" 
                                        :src="form.video" 
                                        title="YouTube video player" 
                                        frameborder="0" 
                                        allowfullscreen
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    ></iframe>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
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
                                @click.prevent="saveCase()" 
                                :disabled="disableSaveBtn" 
                                type="submit" 
                                class="btn btn-primary waves-effect waves-light me-1 pull-left"
                            >
                                Salvar
                            </button>
                            <button 
                                @click.prevent="getCase()"  
                                :disabled="disableSaveBtn" 
                                type="reset" 
                                class="btn btn-secondary waves-effect me-1 pull-left"
                            >
                                Cancelar
                            </button>
                            <button 
                                @click.prevent="$router.push(`/cases`)" 
                                type="button" 
                                class="btn btn-light waves-effect me-1 pull-right"
                            >
                               Voltar à lista
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <!-- end row -->
    </div>
</template>
<script>
import Axios from 'axios'
import DefaultForm from './../../../commom/DefaultForm'
import ImageFile from './../images/Image'
import CaseGalery from './CaseGalery'
import { VueEditor } from "vue2-editor";
export default {
    name: 'CaseItem',
    extends: DefaultForm,
    components: {
        ImageFile,
        CaseGalery,
        'vue-editor': VueEditor
    },
    props: {
        caseItemId: {
            type: Number,
            default: 0
        },
        user: {
            type: Object,
            default: () => null
        }
    },
    data(){
        return {
            caseItem: {
                id: null,
                categories_id: null,
                name: 'Novo Item',
                localization: null,
                text: null,
                images_id: null,
                video: null,
                active: false
            },
            form: {
                id: null,
                name: null,
                categories_id: null,
                localization: null,
                text: null,
                images_id: null,
                video: null,
                active: false
            },
            help: {
                name: null,
                categories_id: null,
                localization: null,
                text: null,
                images_id: null,
                video: null,
                form: null
            }
        }
    },
    computed: {
        categories(){
            return this.$store.getters.categories.data || []
        },
        validations(){
			return {
				name: () => {
					let isValid = !!this.form.name && this.form.name.length >= 2
					this.help.name = !isValid ? "O nome do case deve conter ao menos 2 caracteres." : null
					return isValid;
				},
                localization: () => {
					let isValid = !!this.form.localization && this.form.localization.length >= 4
					this.help.localization = !isValid ? "A localização do case deve conter ao menos 4 caracteres." : null
					return isValid
				},
                text: () => {
					let isValid = !!this.form.text && this.form.text.length >= 4 || !this.form.text
					this.help.text = !isValid ? "O texto da case deve conter ao menos 4 caracteres." : null
                    if(isValid && !!this.form.text) this.is_default_page = false
					return isValid;
				},
                categories_id: () => {
                    let isValid = !!this.form.categories_id && parseInt(this.form.categories_id) >= 1
					this.help.categories_id = !isValid ? "A categoria do case deve conter ser selecionada." : null
					return isValid;
                },
                video: () => {
                    let isValid = !!this.form.video && this.form.video.length >= 4 || !this.form.video
					this.help.video = !isValid ? "A url do video do case deve conter ao menos 4 caracteres e ser válida." : null
					return isValid;
                }
			}
		},
    },
    methods: {
        resetForm(){
            this.caseItem = {
                id: null,
                categories_id: null,
                name: 'Novo Case',
                localization: null,
                text: null,
                images_id: null,
                video: null
            },

            this.resetFormDefault({
                id: null,
                name: null,
                categories_id: null,
                localization: null,
                text: null,
                images_id: null,
                video: null,
                active: false
            })
        },
        getCase(){
            if(!!this.caseItemId && this.caseItemId > 0) {
                Axios.get(`${window.cmsApiBaseUrl}/cases/${this.caseItemId}`)
                .then((response) => {
                    this.caseItem = response.data.caseItem
                    this.setFormDefault(this.caseItem)
                })
                .catch(() => {
                    this.$root.$emit('showMessage', {
                        type: "error", 
                        title: "Não Encontrado",
                        message:"Item não Encontrado!"
                    })
                    this.$router.push(`/cases`)
                })
                return
            }

            if (this.caseItemId === null) {
                this.$router.push({path: '/'})
            }

            if(this.caseItemId === 0) {
                this.resetForm()
            }
        },
        saveCase(){
            if (this.validate) {
                 Axios.post(`${window.cmsApiBaseUrl}/cases`, this.form)
                .then((response) => {
                    this.caseItem = response.data.caseItem
                    this.setFormDefault(this.caseItem)
                    if(response.data.success){
                        this.$root.$emit('showMessage', {
                            type: "success", 
                            title: "Salvo",
                            message:"Dados salvos com sucesso!"
                        })
                        this.$store.dispatch("getCases")
                        if(!this.caseItem.id) this.$router.push(`/cases`)
                        else this.getCase()
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
        reloadCase(){
            this.resetForm()
            this.getCase()
        },
        confirmSelectImage(image){
            this.form.images_id = image?.id || null
            if(!image) this.caseItem.images_id = null
        },
    },
    mounted(){
        this.reloadCase()
    },
    watch :{
        caseItemId(){
            this.reloadCase()
        },
        "$route.path"(){
            this.reloadCase()
        }
    }
}
</script>