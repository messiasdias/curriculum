<template>
    <div>
        <!-- start page title -->
        <div v-if="solution" class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{solution.title}}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><router-link to="/solutions">Soluções</router-link></li>
                            <li class="breadcrumb-item active">{{solution.title}}</li>
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
                        <h4 class="card-title">{{solution && solution.id ? 'Editar' : 'Novo'}} Item de Solução</h4>

                        <p class="card-title-desc">Modifique as informações do item de solução </p>

                        <div class="row mb-3">
                            <ImageFile
                                v-if="solution.id"
                                :classes="'col-12 col-sm-4 mt-4'"
                                :images_id="solution.images_id" 
                                :item_table="'solutions'" 
                                :item_id="solution.id"
                                @image="confirmSelectImage($event)"
                            />
                        </div>

                        <div class="row mb-3">
                            <label for="title" class="col-sm-2 col-form-label">Título</label>
                            <div class="col-sm-4">
                                <input class="form-control" type="text" placeholder="Análise de energia" id="title" v-model="form.title"> 
                                 <ul v-if="help.title" class="parsley-errors-list filled" id="parsley-title" aria-hidden="false">
                                    <li class="parsley-minlength">{{help.title}}</li>
                                </ul>
                            </div>
                        </div>
                        

                        <div class="row mb-3">
                            <label for="text" class="col-sm-2 col-form-label">Texto</label>
                            <div class="col-sm-4">
                                <textarea 
                                    class="form-control" 
                                    placeholder="Temos como missão trazer a melhor tecnologia, eficiência e economia aos nossos clientes. Onde você estiver, a hora precisar, conte conosco!" 
                                    name="text" 
                                    v-model="form.text"
                                    rows="10" cols="50"
                                >
                                </textarea>
                                <ul v-if="help.text" class="parsley-errors-list filled" id="parsley-text" aria-hidden="false">
                                    <li class="parsley-minlength">{{help.text}}</li>
                                </ul>
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
                                @click.prevent="saveSolution()" 
                                :disabled="disableSaveBtn" 
                                type="submit" 
                                class="btn btn-primary waves-effect waves-light me-1 pull-left"
                            >
                                Salvar
                            </button>
                            <button 
                                @click.prevent="getSolution()"  
                                :disabled="disableSaveBtn" 
                                type="reset" 
                                class="btn btn-secondary waves-effect me-1 pull-left"
                            >
                                Cancelar
                            </button>
                            <button 
                                @click.prevent="$router.push(`/solutions`)" 
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
    name: 'Solution',
    extends: DefaultForm,
    components: {ImageFile},
    props: {
        solutionId: {
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
            solution: {
                id: null,
                title: 'Nova Solução',
                text: null,
                images_id: null,
                active: false
            },
            form: {
                id: null,
                title: null,
                text: null,
                images_id: null,
                active: false
            },
            help: {
                title: null,
                text: null,
                images_id: null,
                form: null
            }
        }
    },
    computed: {
        validations(){
			return {
				title: () => {
					let isValid = !!this.form.title && this.form.title.length >= 2
					this.help.title = !isValid ? "O título da solução deve conter ao menos 2 caracteres." : null
					return isValid;
				},
                text: () => {
					let isValid = !!this.form.text && this.form.text.length >= 4
					this.help.text = !isValid ? "O texto da solução deve conter ao menos 4 caracteres." : null
					return isValid
				}
			}
		},
    },
    methods: {
        resetForm(){
            this.solution = {
                id: null,
                title: 'Nova Solução',
                text: null,
                images_id: null,
                active: false
            },

            this.resetFormDefault({
                id: null,
                title: null,
                text: null,
                images_id: null,
                active: false
            })
        },
        getSolution(){
            if(!!this.solutionId && this.solutionId > 0) {
                Axios.get(`${window.cmsApiBaseUrl}/solutions/${this.solutionId}`)
                .then((response) => {
                    this.solution = response.data.solution
                    this.setFormDefault(this.solution)
                })
                .catch(() => {
                    this.$root.$emit('showMessage', {
                        type: "error", 
                        title: "Não Encontrado",
                        message:"Item não Encontrado!"
                    })
                    this.$router.push(`/solutions`)
                })
                return
            }

            if (this.solutionId === null) {
                this.$router.push({path: '/'})
            }

            if(this.solutionId === 0) {
                this.resetForm()
            }
        },
        saveSolution(){
            if (this.validate) {
                 Axios.post(`${window.cmsApiBaseUrl}/solutions`, this.form)
                .then((response) => {
                    this.solution = response.data.solution
                    this.setFormDefault(this.solution)
                    if(response.data.success){
                        this.$root.$emit('showMessage', {
                            type: "success", 
                            title: "Salvo",
                            message:"Dados salvos com sucesso!"
                        })
                        this.$store.dispatch("getSolutions")
                        this.$router.push(`/solutions`)
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
        reloadSolution(){
            this.resetForm()
            this.getSolution()
        },
        confirmSelectImage(image){
            this.form.images_id = image?.id || null
            if(!image) this.solution.images_id = null
        },
    },
    mounted(){
        this.reloadSolution()
    },
    watch :{
        solutionId(){
            this.reloadSolution()
        },
        "$route.path"(){
            this.reloadSolution()
        }
    }
}
</script>