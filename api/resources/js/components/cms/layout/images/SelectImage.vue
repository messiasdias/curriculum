<template>
<div class="row">
    <div class="card">
        <div class="card-body">
            <div>
                <div class="row g-0">
                    <template v-if="images.length > 0" >
                        <div 
                            class="col-xl-4 col-sm-6"
                            v-for="image in images" 
                            :key="image.id"
                            @click.prevent="changeSelectedImage(image.id)"
                        >
                            <div class="product-box" :class="{'active': selectedImage.includes(image.id)}">
                                <div class="product-img">
                                    <div v-if="selectedImage.includes(image.id)" class="product-ribbon badge bg-info">Selecionado</div>
                                    <img loading="lazy" :src="`${assets}${image.url}`" alt="img-1"
                                        class="img-fluid mx-auto d-block">
                                </div>
                                <div class="text-center">
                                    <p v-if="image.item_table" class="font-size-12 mb-1">{{itemsTables[image.item_table]}}</p>
                                    <h5 v-if="image.item_table" class="font-size-15"><a href="#" class="text-dark">{{getTableItem(image) ? getTableItem(image).name : image.url}}</a></h5>
                                </div>
                            </div>
                        </div>

                        <Paginator 
                            :page="current_page"
                            :last_page="last_page"
                            :dispatchEvent="'getImages'"
                        />
                    </template>
                    <strong v-else >
                        {{ 
                            item_table === null ? 
                            'Nenhuma imagem encontrada até o momento' :
                            'Nenhuma imagem encontrada de acordo com os filtros' 
                        }}
                    </strong>
                </div>
                
                <div class="col-12 row mb-3 mt-5">
                    <label for="image" class="col-sm-12 col-form-label">Enviar Imagem</label>
                    <div class="col-sm-6">
                        <input @change="setUploadFile" class="form-control" type="file" placeholder="" ref="uploadFileInput"> 
                         <ul v-if="help.image" class="parsley-errors-list filled" id="parsley-image" aria-hidden="false">
                            <li class="parsley-minlength">{{help.image}}</li>
                        </ul>
                    </div>
                    <div class="col-sm-2">
                        <button :disabled="!validate" @click.prevent="uploadFile()" class="btn btn-primary">
                            Enviar
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</template>
<script>
import Paginator from './../Paginator'
import DefaultImage from './DefaultImage'
import Axios from 'axios'

export default {
    name: 'SelectImage',
    extends: DefaultImage,
    components: {
        Paginator
    },
    props: {
        item_table: {
            type: String,
            default: null
        },
        item_id: {
            type: Number,
            default: null
        },
        selected: {
            type: Number,
            default: null
        },
        multiSelect: {
            type: Boolean,
            default: false
        },
        exceptImageIds: {
            type : Array,
            default: () => []
        }
    },
    computed: {
        images(){
            return this.$store.getters.images?.data?.filter(img => !this.exceptImageIds.includes(img.id)) || []
        },
        current_page(){
            return this.$store.getters.images.current_page
        },
        last_page(){
            return this.$store.getters.images.last_page
        },
        refImage(){
            return this.$refs.image
        },
        validations(){
			return {
				image: () => {
					let isValid = !!this.toUploadFile
                    this.help.image = !isValid ? "Uma imagem deve ser selecionada." : null
					return isValid;
				},
            }
        }
    },
    data(){
        return {
            assets: window.assets,
            selectedImage: [],
            toUploadFile: null,
            help: {
                image: null,
            },
            form: {
                image: null,
            }
        }
    },
     methods: {
        setUploadFile(){
            if(this.$refs.uploadFileInput.files.length >= 1) {
                return this.toUploadFile = this.$refs.uploadFileInput.files[0]
            }
            this.toUploadFile = null
        },
        uploadFile(){
            if(this.validate) {
                let formData = new FormData()
                formData.append('image', this.toUploadFile)

                if(!!this.item_table && !!this.item_id) {
                    formData.append('item_table', this.item_table)
                    formData.append('item_id', this.item_id)
                }

                Axios.post(
                    `${window.cmsApiBaseUrl}/images`,
                    formData,
                    {headers: {'Content-Type': 'multipart/form-data'}}
                ).then(() => {
                    this.$store.dispatch('getImages')
                    this.toUploadFile = null
                    this.$refs.uploadFileInput.value = null
                    this.help.image = null
                })
                .catch((err) => {
                    let erros = err?.response?.data?.errors
                    if(erros && erros.image) this.help.image = erros.image
                })
            }
        },
        changeSelectedImage(id = null){
            if (this.multiSelect || (!this.multiSelect && this.selectedImage.length == 0)) {
                if (!this.selectedImage.includes(id)) this.selectedImage.push(id)
                else this.selectedImage = this.selectedImage.filter(i => i !== id)
                this.$emit("change", this.selectedImage)
                return
            }
            this.selectedImage = [id]
            this.$emit("change", this.selectedImage)
        }
    },
    mounted(){
        this.selectedImage = []
        if(this.selected) this.selectedImage.push(this.selected)
        this.resetFormDefault(this.form)
        this.$store.dispatch('getImages')
    }
}
</script>