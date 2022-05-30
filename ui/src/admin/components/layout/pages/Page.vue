<template>
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div v-if="page" class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{page.name}}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><router-link to="/pages">Gerenciador de Páginas</router-link></li>
                            <li class="breadcrumb-item active">{{page.name}}</li>
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
                        <h4 class="card-title">{{page && page.id ? 'Editar' : 'Nova'}} Página</h4>

                        <p class="card-title-desc">Modifique as informações da página </p>

                                
                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Nome da Página</label>
                            <div class="col-sm-4">
                                <input class="form-control" type="text" placeholder="Casos de Sucesso" id="name" v-model="form.name"> 
                                 <ul v-if="this.help.name" class="parsley-errors-list filled" id="parsley-name" aria-hidden="false">
                                    <li class="parsley-minlength">{{this.help.name}}</li>
                                </ul>
                            </div>
                       
                            <label for="breadcrumb" class="col-sm-2 col-form-label">Frase Slogan</label>
                            <div class="col-sm-4">
                                <input class="form-control" type="text" placeholder="A Speel tem a solução ideal para você" id="breadcrumb" v-model="form.breadcrumb"> 
                                <ul v-if="this.help.breadcrumb" class="parsley-errors-list filled" id="parsley-breadcrumb" aria-hidden="false">
                                    <li class="parsley-minlength">{{this.help.breadcrumb}}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="content" class="col-sm-2 col-form-label">Counteúdo Personalizado</label>
                            <div class="col-sm-10">
                                <vue-editor  v-model="form.content" :editor-toolbar="customToolbar" />
                                <ul v-if="this.help.content" class="parsley-errors-list filled" id="parsley-content" aria-hidden="false">
                                    <li class="parsley-minlength">{{this.help.content}}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="row col-12 col-sm-12 mb-5 mt-5 form-switch-content">
                            <div class="form-check form-switch col-12 col-md-4" dir="ltr">
                                <input type="checkbox" class="form-check-input" id="breadcase" v-model="form.breadcase" > 
                                <label class="form-check-label" for="breadcase">Mostrar Layout Padrão</label>
                            </div>

                            <div class="form-check form-switch col-12 col-md-4" dir="ltr">
                                <input type="checkbox" class="form-check-input" id="show_home" v-model="form.show_home" >
                                <label class="form-check-label" for="show_home">Mostrar Barra de Título</label>
                            </div>

                            <div class="form-check form-switch col-12 col-md-4" dir="ltr">
                                <input type="checkbox" class="form-check-input" id="active" v-model="form.active" >
                                <label class="form-check-label" for="active">Visualização (Ativa / Inativa)</label>
                            </div>
                        </div>

                        <div class="mb-0 mt-3">
                            <button 
                                @click.prevent="savePage" 
                                :disabled="disableSaveBtn" 
                                type="submit" 
                                class="btn btn-primary waves-effect waves-light me-1 pull-left"
                            >
                                Salvar
                            </button>
                            <button 
                                @click.prevent="getPage()"  
                                :disabled="disableSaveBtn" 
                                type="reset" 
                                class="btn btn-secondary waves-effect me-1 pull-left"
                            >
                                Cancelar
                            </button>
                            <button 
                                v-if="!page.is_default_page" 
                                @click.prevent="$router.push(`/pages`)" 
                                type="button" 
                                class="btn btn-light waves-effect me-1 pull-right"
                            >
                                Páginas Personalizadas
                            </button>
                        </div>

                    </div>
                </div>

            </div> <!-- end col-12 slot="content" -->
        </div>
        <!-- end row -->

    </div> <!-- container-fluid -->
</div>
</template>
<script>
import Axios from 'axios'
import DefaultForm from './../../../commom/DefaultForm'
import { VueEditor } from "vue2-editor";

export default {
    name: 'page',
    extends: DefaultForm,
    components: {
        'vue-editor': VueEditor
    },
    props: {
        pageId: {
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
            customToolbar: [
      ["bold", "italic", "underline"],
      [{ list: "ordered" }, { list: "bullet" }],
      ["image", "code-block"]
    ],
            page: {
                id: null,
                name: null,
                slug: null,
                breadcrumb: null,
                breadcase: true,
                show_home: true,
                active: false,
                content: null,
                is_default_page: false
            },
            form: {
                name: null,
                slug: null,
                breadcrumb: null,
                breadcase: true,
                show_home: true,
                active: false,
                content: null,
                is_default_page: false
            },
            help: {
                name: null,
                content: null,
                breadcrumb: null,
                form: null
            }
        }
    },
    computed: {
        validations(){
			return {
				name: () => {
					let isValid = !!this.form.name && this.form.name.length >= 2
					this.help.name = !isValid ? "O nome da página deve conter ao menos 2 caracteres." : null
					return isValid;
				},
                content: () => {
					let isValid = !!this.form.content && this.form.content.length >= 4 || !this.form.content
					this.help.content = !isValid ? "O conteúdo da página deve conter ao menos 4 caracteres." : null
                    if(isValid && !!this.form.content) this.is_default_page = false
					return isValid;
				},
                breadcrumb: () => {
					let isValid = !this.form.breadcrumb || !!this.form.breadcrumb && this.form.breadcrumb.length >= 4
					this.help.breadcrumb = !isValid ? "A frase slogan da página deve conter ao menos 4 caracteres." : null
					return isValid;
				},
			}
		},
    },
    methods: {
        resetForm(){
            this.page = {
                id: null,
                name: null,
                slug: null,
                breadcrumb: null,
                breadcase: true,
                show_home: true,
                active: false,
                content: null
            },

            this.resetFormDefault({
                name: null,
                slug: null,
                breadcrumb: null,
                breadcase: true,
                show_home: true,
                active: false,
                content: null,
                is_default_page: false
            })
        },
        getPage(){
            if(!!this.pageId && this.pageId > 0) {
                Axios.get(`${window.cmsApiBaseUrl}/pages/${this.pageId}`)
                .then((response) => {
                    this.page = response.data.page
                    this.setFormDefault(this.page)
                })
                .catch(() => {
                    this.$root.$emit('showMessage', {
                        type: "error", 
                        title: "Não Encontrado",
                        message:"Página Não Encontrada!"
                    })
                    if(this.page.is_default_page) this.$router.push("/pages")
                    else this.$router.push({path: '/'})
                })
                return
            }

            if (this.pageId === null) {
                this.$router.push({path: '/'})
            }

            if(this.pageId === 0) {
                this.resetForm()
            }
        },
        savePage(){
            if (this.validate) {
                 Axios.post(`${window.cmsApiBaseUrl}/pages`, this.form)
                .then((response) => {
                    this.page = response.data.page
                    this.setFormDefault( Object.assign(this.page, {
                        active: this.page.active == 1 || this.page.active,
                        breadcase: this.page.breadcase == 1 || this.page.breadcase,
                        is_default_page: this.page.is_default_page == 1 ||  this.page.is_default_page,
                        show_home: this.page.show_home == 1 ||  this.page.show_home
                    }))

                    if(response.data.success){
                        this.$root.$emit('showMessage', {
                            type: "success", 
                            title: "Salvo",
                            message:"Dados salvos com sucesso!"
                        })
                        this.$store.dispatch("getPages")
                        if(!this.page.is_default_page) this.$router.push("/pages")
                    }
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
        formatSlug(name){
            return name.toLowerCase().trim().replaceAll(' ', '-')
        },
        reloadPage(){
            this.resetForm()
            this.getPage()
        }
    },
    mounted(){
        this.reloadPage()
    },
    watch :{
        "form.name"(){
            if (!this.isDefaultPage && !!this.form.name){
                this.form.slug = this.formatSlug(this.form.name)
            }
        },
        "form.content"(){
            if (!!this.form.content){
                this.form.show_home = false
            }
        },
        pageId(){
            this.reloadPage()
        },
        "$route.path"(){
            this.reloadPage()
        },
    }
}
</script>