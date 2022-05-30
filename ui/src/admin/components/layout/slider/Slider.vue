<template>
    <div>
        <!-- start page title -->
        <div v-if="slider" class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{slider.name}}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><router-link to="/sliders">Sliders</router-link></li>
                            <li class="breadcrumb-item active">Item de Slide</li>
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
                        <h4 class="card-title">{{slider ? 'Editar' : 'Novo'}} Item de Slide</h4>

                        <p class="card-title-desc">Modifique as informações do item de slide </p>

                        <div class="row mb-3">
                            <ImageFile
                                v-if="slider.id"
                                :classes="'col-12 col-sm-4 mt-4'"
                                :images_id="slider.images_id" 
                                :item_table="'sliders'" 
                                :item_id="slider.id"
                                @image="confirmSelectImage($event)"
                            />
                        </div>
    
                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Titulo do Slide</label>
                            <div class="col-sm-10">
                                 <vue-editor  v-model="form.title" />
                                 <ul v-if="help.title" class="parsley-errors-list filled" id="parsley-title" aria-hidden="false">
                                    <li class="parsley-minlength">{{help.title}}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="categories_id" class="col-sm-2 col-form-label">Subitítulo do Slide</label>
                            <div class="col-sm-10">
                                <vue-editor  v-model="form.subtitle" />
                                <ul v-if="help.subtitle" class="parsley-errors-list filled" id="parsley-subtitle" aria-hidden="false">
                                    <li class="parsley-minlength">{{help.subtitle}}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row mb-0"> 
                            <label for="link_text" class="col-sm-2 col-form-label">Link do Slide</label>
                        </div>

                        <div class="row mb-3"> 
                            <label for="link_text" class="col-sm-2 col-form-label">Texto</label>
                            <div class="col-sm-3">
                                <input class="form-control" type="text" placeholder="Texto do Link" id="link_text" v-model="form.link_text"> 
                                <ul v-if="help.link_text" class="parsley-errors-list filled" id="parsley-link_text" aria-hidden="false">
                                    <li class="parsley-minlength">{{help.link_text}}</li>
                                </ul>
                            </div>
                       
                            <label for="link_url" class="col-sm-2 col-form-label">URL</label>
                            <div class="col-sm-5">
                                <input class="form-control" type="link_url" placeholder="/url-do-link" id="link_url" v-model="form.link_url"> 
                                <ul v-if="help.link_url" class="parsley-errors-list filled" id="parsley-link_url" aria-hidden="false">
                                    <li class="parsley-minlength">{{help.link_url}}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="row mb-3">
                          <label for="broadcast_start" class="col-sm-2 col-form-label">Veiculação do Slide</label>
                        </div>

                        <div class="row mb-3">
                            <label for="broadcast_start" class="col-sm-2 col-form-label">Início</label>
                            <div class="col-sm-3">
                                <input 
                                    :disabled="dateTimeCompare(form.broadcast_start, nowString) == 2"
                                    v-model="form.broadcast_start"
                                    class="form-control col-6" type="datetime-local" 
                                    placeholder="00/00/0000 00:00" id="broadcast_start"
                                > 
                                <ul v-if="help.broadcast_start" class="parsley-errors-list filled" id="parsley-broadcast_start" aria-hidden="false">
                                    <li class="parsley-minlength">{{help.broadcast_start}}</li>
                                </ul>
                            </div>
                
                            <label for="broadcast_end" class="col-sm-2 col-form-label">Final</label>
                            <div class="col-sm-3">
                                <input 
                                    :disabled="dateTimeCompare(form.broadcast_end, nowString) == 2"
                                    v-model="form.broadcast_end"
                                    class="form-control col-6" type="datetime-local" 
                                    placeholder="00/00/0000 00:00" id="broadcast_end"
                                > 
                                <ul v-if="help.broadcast_end" class="parsley-errors-list filled" id="parsley-broadcast_end" aria-hidden="false">
                                    <li class="parsley-minlength">{{help.broadcast_end}}</li>
                                </ul>
                            </div>
                        </div>

                         <div class="row mb-3">
                            <label for="type" class="col-sm-2 col-form-label">Tipo do Slide</label>
                            <div class="col-sm-3">
                                <select class="form-control form-select col-6" id="type" v-model="form.type"> 
                                    <option v-for="(name, type) in sliderTypes" :key="type" :value="type">{{name}}</option>
                                </select>
                                <ul v-if="help.type" class="parsley-errors-list filled" id="parsley-type" aria-hidden="false">
                                    <li class="parsley-minlength">{{help.type}}</li>
                                </ul>
                            </div>
                
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
                                @click.prevent="saveSlide()" 
                                :disabled="disableSaveBtn" 
                                type="submit" 
                                class="btn btn-primary waves-effect waves-light me-1 pull-left"
                            >
                                Salvar
                            </button>
                            <button 
                                @click.prevent="getSlide()"  
                                :disabled="disableSaveBtn" 
                                type="reset" 
                                class="btn btn-secondary waves-effect me-1 pull-left"
                            >
                                Cancelar
                            </button>
                            <button 
                                @click.prevent="$router.push(`/sliders`)" 
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
import { VueEditor } from "vue2-editor";
import { dateTimeCompare, nowString } from './../../../../assets/helpers'
export default {
    name: 'Slider',
    extends: DefaultForm,
    components: {
        ImageFile,
        'vue-editor': VueEditor
    },
    props: {
        sliderId: {
            type: Number,
            default: 0
        },
        sliderTypes: {
            type: Object,
            default: () => []
        },
    },
    data(){
        return {
            slider: {
                id: null,
                subtitle: null, 
                images_id: null, 
                link_url: null, 
                link_text: null, 
                broadcast_start: null,
                broadcast_end: null, 
                type: 'slider',
                active: true,
            },
            form: {
                id: null,
                title: null, 
                subtitle: null, 
                images_id: null, 
                link_url: null, 
                link_text: null, 
                broadcast_start: null ,
                broadcast_end: null, 
                type: 'slider',
                active: true,
            },
            help: {
                title: null, 
                subtitle: null, 
                images_id: null, 
                link_url: null, 
                link_text: null, 
                broadcast_start: null ,
                broadcast_end: null, 
                type: null,
                form: null
            },
            nowString: nowString,
        }
    },
    computed: {
        categories(){
            return this.$store.getters.categories.data || []
        },
        validations(){
			return {
				title: () => {
					let isValid = !!this.form.title && this.form.title.length >= 2
					this.help.title = !isValid ? "O título do slide deve conter ao menos 4 caracteres." : null
					return isValid;
				},
                subtitle: () => {
					let isValid = !!this.form.subtitle && this.form.subtitle.length >= 2 || !this.form.subtitle
					this.help.subtitle = !isValid && !!this.form.subtitle ? "O subtítulo do slide deve conter ao menos 4 caracteres ou ser vazio." : null
					return isValid;
				},
                type: () => {
					let isValid = Object.keys(this.sliderTypes).includes(this.form.type)
					this.help.type = !isValid && !!this.form.type ? "O slide deve ter um tipo selecionado." : null
					return isValid;
				},
                link_text: () => {
					let isValid = !!this.form.link_text && this.form.link_text.length >= 4 || !this.form.link_text
					this.help.link_text = !isValid && !!this.form.link_text ? "A texto do link para o slide deve conter ao menos 4 caracteres ou vazio." : null
					return isValid
				},
                link_url: () => {
					let isValid = !!this.form.link_url && this.form.link_url.length >= 4 || !this.form.link_url
					this.help.link_url = !isValid && !!this.form.link_url ? "A url do link para o slide deve conter ao menos 4 caracteres e ser válida ou vazio." : null
					return isValid;
				},
                broadcast_start: () => {
                    if (!!this.form.id && dateTimeCompare(this.form.broadcast_start, nowString) == 2) return true
                    let isValid = (dateTimeCompare(this.form.broadcast_start, nowString) + dateTimeCompare(this.form.broadcast_start, this.form.broadcast_end)) === 3 || !this.form.broadcast_start
                    if (!!this.form.id) isValid = dateTimeCompare(this.form.broadcast_start, nowString) == 1 || !this.form.broadcast_start
					this.help.broadcast_start = !isValid && !!this.form.broadcast_start ? "O momento de início da veiculação deve ser uma data válida ou vazia." : null
					return isValid;
                },
                broadcast_end: () => {
                    if (!!this.form.id && dateTimeCompare(this.form.broadcast_end, nowString) == 2) return true
                    let isValid = (dateTimeCompare(this.form.broadcast_end, nowString) + dateTimeCompare(this.form.broadcast_end, this.form.broadcast_start)) === 2 || !this.form.broadcast_end
					if (!!this.form.id) isValid = dateTimeCompare(this.form.broadcast_end, nowString) == 1 || !this.form.broadcast_end
                    this.help.broadcast_end = !isValid && !!this.form.broadcast_end ? "O momento para o fim da veiculação deve ser uma data válida ou vazia.." : null
					return isValid;
                }
			}
		},
    },
    methods: {
        dateTimeCompare: dateTimeCompare,
        resetForm(){
            this.slider = {
                id: null,
                title: null, 
                subtitle: null, 
                images_id: null, 
                link_url: null, 
                link_text: null, 
                broadcast_start: null ,
                broadcast_end: null, 
                type: 'slider',
                active: true,
            },

            this.resetFormDefault({
                id: null,
                title: null, 
                subtitle: null, 
                images_id: null, 
                link_url: null, 
                link_text: null, 
                broadcast_start: null ,
                broadcast_end: null, 
                type: 'slider',
                active: true,
            })
        },
        getSlide(){
            if(!!this.sliderId && this.sliderId > 0) {
                Axios.get(`${window.cmsApiBaseUrl}/sliders/${this.sliderId}`)
                .then((response) => {
                    this.slider = response.data.slide
                    this.setFormDefault(this.slider)
                })
                .catch(() => {
                    this.$root.$emit('showMessage', {
                        type: "error", 
                        title: "Não Encontrado",
                        message:"Item não Encontrado!"
                    })
                    this.$router.push(`/sliders`)
                })
                return
            }

            if (this.sliderId === null) {
                this.$router.push({path: '/'})
            }

            if(this.sliderId === 0) {
                this.resetForm()
            }
        },
        saveSlide(){
            if (this.validate) {
                 Axios.post(`${window.cmsApiBaseUrl}/sliders`, this.form)
                .then((response) => {
                    this.slider = response.data.slider
                    this.setFormDefault(this.slider)
                    if(response.data.success){
                        this.$root.$emit('showMessage', {
                            type: "success", 
                            title: "Salvo",
                            message:"Dados salvos com sucesso!"
                        })
                        this.$store.dispatch("getSliders")
                        if(!this.form?.id) this.$router.push(`/sliders`)
                        else this.getSlide()
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
        reloadSlide(){
            this.resetForm()
            this.getSlide()
        },
        confirmSelectImage(image){
            this.form.images_id = image?.id || null
            if(!image) this.slider.images_id = null
        },
    },
    mounted(){
        this.reloadSlide()
        this.setFormDefault()
    },
    watch :{
        sliderId(){
            this.reloadSlide()
        },
        "$route.path"(){
            this.reloadSlide()
        },
        "form": {
            deep: true,
            handler(){
                if (!!this.form.broadcast_start) this.form.broadcast_start = this.form.broadcast_start.replace(" ", "T")
                if (!!this.form.broadcast_end) this.form.broadcast_end = this.form.broadcast_end.replace(" ", "T")
            }
        }
    }
}
</script>