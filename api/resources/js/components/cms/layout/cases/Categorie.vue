<template>
    <div>
        <!-- start page title -->
        <div v-if="categorie" class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Categorias</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><router-link to="/categories">Items</router-link></li>
                            <li class="breadcrumb-item active">{{categorie.name}}</li>
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
                        <h4 class="card-title">{{categorie && categorie.id ? 'Editar' : 'Novo'}} Item de Categorie</h4>

                        <p class="card-title-desc">Modifique as informações do item de case </p>
                        <div class="row">

                            <div v-if="categorie.id" class="col-12 col-sm-6">
                                <div class="row mb-3">
                                    <ImageFile
                                        :classes="'col-12'"
                                        :images_id="categorie.images_id" 
                                        :item_table="'categories'" 
                                        :item_id="categorie.id"
                                        @image="confirmSelectImage($event)"
                                    />
                                </div>
                            </div>
                            

                            <div class="col-12 col-sm-6">
                                <div class="row mb-3">
                                    <label for="name" class="col-12 col-sm-4 col-form-label">Nome da Categoria</label>
                                    <div class="col-12 col-sm-8">
                                        <input class="form-control" type="text" placeholder="Caso de Sucesso" id="name" v-model="form.name"> 
                                        <ul v-if="help.name" class="parsley-errors-list filled" id="parsley-name" aria-hidden="false">
                                            <li class="parsley-minlength">{{help.name}}</li>
                                        </ul>
                                    </div>
                                </div>
                            

                                <div class="row mb-3">
                                <label for="type" class="col-12 col-sm-4 col-form-label">Visualização</label>
                                    <div class="col-12 col-sm-8 form-switch-content d-flex justify-content-start mt-2">
                                        <div class="form-check form-switch" dir="ltr">
                                            <input type="checkbox" class="form-check-input" id="active" v-model="form.active" >
                                            <label class="form-check-label" for="active">Ativo / Inativo</label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="mb-0 mt-3">
                            <button 
                                @click.prevent="saveCategorie()" 
                                :disabled="disableSaveBtn" 
                                type="submit" 
                                class="btn btn-primary waves-effect waves-light me-1 pull-left"
                            >
                                Salvar
                            </button>
                            <button 
                                @click.prevent="getCategorie()"  
                                :disabled="disableSaveBtn" 
                                type="reset" 
                                class="btn btn-secondary waves-effect me-1 pull-left"
                            >
                                Cancelar
                            </button>
                            <button 
                                @click.prevent="$router.push(`/categories`)" 
                                type="button" 
                                class="btn btn-light waves-effect me-1 pull-right"
                            >
                                Voltar à lista
                            </button>
                        </div>

                    </div>
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
    name: 'Categorie',
    extends: DefaultForm,
    components: {ImageFile},
    props: {
        categorieId: {
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
            categorie: {
                id: null,
                name: 'Nova Categoria',
                images_id: null,
                active: false,
            },
            form: {
                id: null,
                name: null,
                images_id: null,
                active: false,
            },
            help: {
                name: null,
                images_id: null,
                form: null
            },
            isShowSelectImageModal: false,
        }
    },
    computed: {
        validations(){
			return {
				name: () => {
					let isValid = !!this.form.name && this.form.name.length >= 2
					this.help.name = !isValid ? "O nome da categoria deve conter ao menos 2 caracteres." : null
					return isValid;
				}
			}
		},
    },
    methods: {
        resetForm(){
            this.categorie = {
                id: null,
                name: 'Nova Categoria',
                images_id: null,
                active: false
            },

            this.resetFormDefault({
                id: null,
                name: null,
                images_id: null,
                active: false
            })
        },
        getCategorie(){
            if(!!this.categorieId && this.categorieId > 0) {
                Axios.get(`${window.cmsApiBaseUrl}/categories/${this.categorieId}`)
                .then((response) => {
                    this.categorie = response.data.categorie
                    this.setFormDefault(this.categorie)
                })
                .catch(() => {
                    this.$root.$emit('showMessage', {
                        type: "error", 
                        title: "Não Encontrado",
                        message:"Categoria não Encontrada!"
                    })
                    this.$router.push(`/categories`)
                })
                return
            }

            if (this.categorieId === null) {
                this.$router.push({path: '/'})
            }

            if(this.categorieId === 0) {
                this.resetForm()
            }
        },
        saveCategorie(){
            if (this.validate) {
                 Axios.post(`${window.cmsApiBaseUrl}/categories`, this.form)
                .then((response) => {
                    this.categorie = response.data.case
                    this.setFormDefault(this.categorie)

                    if(response.data.success){
                        this.$root.$emit('showMessage', {
                            type: "success", 
                            title: "Salvo",
                            message:"Dados salvos com sucesso!"
                        })
                        this.$store.dispatch("getCategories")
                        if(!this.categorie.id) this.$router.push(`/categories`)
                        else this.getCategorie()
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
                        this.$router.push(`/categories`)
                    }
                })
            }
        },
        reloadCategorie(){
            this.resetForm()
            this.getCategorie()
        },
        confirmSelectImage(image){
            this.form.images_id = image?.id || null
            if(!image) this.categorie.images_id = null
        },
        afterSelectImage(success = true){
            this.$store.dispatch("getImages")
            this.$store.dispatch("getCategories")
            setTimeout(() => $(`#selectImageModal`).modal('hide'))

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
        this.reloadCategorie()
    },
    watch :{
        categorieId(){
            this.reloadCategorie()
        },
        "$route.path"(){
            this.reloadCategorie()
        }
    }
}
</script>