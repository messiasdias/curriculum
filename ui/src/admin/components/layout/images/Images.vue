<template>
<div class="page-content">
    <div class="container-fluid">
        <!-- start image title -->
        <div class="row">
            <div class="col-12">
                <div class="image-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Gerenciador de Imagens</h4>
                    <div class="image-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Gerenciador de Imagens</a></li>
                            <li class="breadcrumb-item active">Imagens</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end image title -->

        <div class="row">
            
            <div class="col-xl-3 col-lg-4">
                <div class="card">
                    <div class="card-header bg-transparent border-bottom">
                        <h5 class="mb-0">Filtros</h5>
                    </div>

                    <div class="card-body">
                        <div class="accordion ecommerce" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <i class="mdi mdi-desktop-classic font-size-16 align-middle me-2"></i>
                                        Tabela de Itens
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <ul class="list-unstyled categories-list mb-0">
                                            <li :class="{'active': !filters.table}"><a @click.prevent="filters.table = null" href="#"><i class="mdi mdi-circle-medium me-1"></i> Todas</a></li>
                                            <li 
                                                v-for="(table_name, key) in itemsTables" :key="key" 
                                                :class="{'active': filters.table === key}"
                                            >
                                                <a @click.prevent="filters.table = key" href="#"><i class="mdi mdi-circle-medium me-1"></i> {{table_name}}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion d-flex justify-content-end" >
                            <button 
                                type="button" 
                                class="btn btn-primary waves-effect waves-light mt-3 mb-3 text-right" 
                                data-bs-toggle="modal" 
                                data-bs-target="#myModal"
                                @click.prevent="showModalUploadImage()"
                            >
                                Enviar Imagens
                            </button>
                        </div>
                    </div>

                </div>
            </div> 

            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <div class="row g-0">
                                <template v-if="images && images.length > 0" >
                                    <div 
                                        v-for="image in images" :key="image.id" 
                                        class="col-xl-4 col-sm-6"
                                    >
                                        <div class="product-box">
                                            <div class="product-img">
                                                <div v-if="image.isUsed" class="product-ribbon badge bg-info">Em Uso</div>
                                                <img
                                                     @click.prevent="showModalEditImage(image)" 
                                                    :src="`${assets}${image.url}`" alt="Imagem Enviada" loding="lazy"
                                                    class="img-fluid mx-auto d-block"
                                                >
                                            </div>

                                            <div class="text-center">
                                                <p v-if="image.item_table" class="font-size-12 mb-1">{{itemsTables[image.item_table]}}</p>
                                                <h5 v-if="image.item_table" class="font-size-15"><a href="#" class="text-dark">{{getTableItem(image) ?  (getTableItem(image).name || getTableItem(image).title) : image.url}}</a></h5>
                                            </div>

                                            <div class="product-actions">
                                                <a @click.prevent="showModalEditImage(image)" href="#">
                                                    <i class="ri-pencil-line text-secondary"></i>
                                                </a>
                                                 <a v-if="!image.isUsed" @click.prevent="showModalDeleteImage(image)" href="#">
                                                    <i class="ri-delete-bin-line text-danger"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <strong v-else >
                                    {{ 
                                        filters.table === null ? 
                                        'Nenhuma imagem encontrada até o momento' :
                                        'Nenhuma imagem encontrada de acordo com os filtros' 
                                    }}
                                </strong>
                            </div>
                            
                            <Paginator 
                                :page="current_page"
                                :last_page="last_page"
                                :dispatchEvent="'getImages'"
                            />
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <Modal 
        v-if="isShowUploadModal"
        :id="image ? `imageUploadModal${image.id}` : `imageUploadModal`"
        :title="'Enviar Imagens'"
        :size="'modal-xl'"
        @close="hideModalUploadImage"
    >
        <template slot="body"> 
           <div class="row">
               <div class="col">
                    <!-- <h4 class="card-title">Dropzone</h4>
                    <p class="card-title-desc">DropzoneJS is an open source library
                        that provides drag’n’drop file uploads with image previews.
                    </p> -->
                    <div>
                        <form action="#" class="dropzone">
                            <div class="fallback">
                                <input @change="setUploadFiles('toUploadFiles')" ref="toUploadFiles" name="file" type="file" multiple="multiple" >
                            </div>
                            <div class="dz-message needsclick">
                                <div class="mb-3">
                                    <i class="display-4 text-muted ri-upload-cloud-2-line"></i>
                                </div>
                                <h4>Solte imagens aqui ou clique para enviar.</h4>
                            </div>
                        </form>
                    </div>
                    <ul v-if="help.image" class="parsley-errors-list filled" id="parsley-name" aria-hidden="false">
                        <li class="parsley-minlength">{{help.image}}</li>
                    </ul>
               </div>
           </div>
        </template>
        <template slot="footer">
            <div class="text-center mt-4">
                <button :disabled="!toUploadFiles" @click.prevent="uploadFiles('toUploadFiles', hideModalUploadImage)" type="button" class="btn btn-primary waves-effect waves-light">Eviar Imagens</button>
            </div>
        </template>
    </Modal>

    <Modal 
        v-if="isShowEditModal"
        :id="`imageEditModal${image.id}`"
        :title="'Editar de Imagem'"
        @close="hideModalEditImage"
    >
        <template slot="body"> 
           <div class="row">
               <div class="col">
                    <img loding="lazy" class=" mb-4  img-fluid mx-auto d-block" :src="`${assets}${image.url}`" /><br>
                    <strong>ID:</strong> {{image.id}} <br>
                    <strong v-if="!!image.item_table">Tabela:</strong> {{itemsTables[image.item_table]}} <br>
                    <strong v-if="!!image.item_table && getTableItem(image)">Item:</strong> {{getTableItem(image) ? (getTableItem(image).name || getTableItem(image).title) : ""}} <br>
                    <strong>URL:</strong> <small><a :href="`/${image.url}`" target="_blank">{{image.url}}</a></small> <br>
               </div>

               <div class="col-12 mt-5">
                   <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Modificar Arquivo</label>
                        <div class="col-sm-10">
                            <input class="form-control" @change="setUploadFiles('toUploadFiles2')" ref="toUploadFiles2" name="file" type="file" multiple="multiple" >
                            <ul v-if="help.image" class="parsley-errors-list filled" id="parsley-image" aria-hidden="false">
                                <li class="parsley-minlength">{{help.image}}</li>
                            </ul>
                        </div>
                    </div>

                   <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Tabela</label>
                        <div class="col-sm-10">
                            <select class="form-select select2" id="item_table" v-model="form.item_table">
                                <option :value="null">Nenhuma Tabela</option>
                                <option 
                                    v-for="(table_name, key) in itemsTables" 
                                    :key="key"  
                                    :value="key"
                                >
                                    {{table_name}}
                                </option>
                            </select> 
                            <ul v-if="help.item_table" class="parsley-errors-list filled" id="parsley-item_table" aria-hidden="false">
                                <li class="parsley-minlength">{{help.item_table}}</li>
                            </ul>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Item</label>
                        <div class="col-sm-10">
                            <select class="form-select" id="item_id" v-model="form.item_id">
                                <option :value="null">Nenhum Item</option>
                                <option 
                                    v-for="item in itemsTablesList" 
                                    :key="item.id"  
                                    :value="item.id"
                                    v-html="item.title || item.name"
                                >
                                </option>
                            </select> 
                             <ul v-if="help.item_id" class="parsley-errors-list filled" id="parsley-item_id" aria-hidden="false">
                                <li class="parsley-minlength">{{help.item_id}}</li>
                            </ul>
                        </div>
                    </div>
               </div>
           </div>
        </template>
        <template slot="footer">
            <div class="text-center mt-4">
                <button :disabled="!validate" @click.prevent="cancelEditImage()" type="button" class="btn btn-secondary waves-effect waves-light">Cancelar</button>
                <button :disabled="!validate" @click.prevent="submitEditImage()" type="button" class="btn btn-primary waves-effect waves-light">Salvar</button>
            </div>
        </template>
    </Modal>

    <Modal 
        v-if="isShowDeleteModal"
        :id="`imageDeleteModal${image.id}`"
        :title="'Excluír Imagem'"
        :text="`Deseja realmente excluír a imagem '${image.url}'?`"
        :closeText="'Não'"
        :confirmText="'Sim'"
        @confirm="confirmDeleteImage(image)"
        @close="hideModalDeleteImage"
    />
</div>
</template>
<script>
import Axios from 'axios'
import Modal from './../Modal'
import Paginator from './../Paginator'
import DefaultImage from './DefaultImage'
import './../../.././../../../public/admin/libs/dropzone/min/dropzone.min.css'

export default {
    name: 'Images',
    extends:  DefaultImage,
    components: {
        Modal,
        Paginator,
    },
    computed: {
        images(){
            let images = this.$store.getters.images?.data?.filter(img => img.item_table != 'users') || []
            if (this.filters.table !== null) images = images.filter(img => img.item_table === this.filters.table)
            return images
        },
        current_page(){
            return this.$store.getters.images.current_page
        },
        last_page(){
            return this.$store.getters.images.last_page
        },
        itemsTablesList(){
            return this.$store.getters[this.form.item_table] && this.form.item_table != 'users' ? this.$store.getters[this.form.item_table].data : []
        },
        itemSelected(){
            return this.form.item_table && this.form.item_id
        },
        validations(){
			return {
				image: () => {
                    this.help.item_table = null
                    this.help.item_id = null

					let isValid = true 
                    if(this.itemSelected) {
                        isValid = this.itemSelected 
                    } else {
                        if (!!this.form.item_id && !this.form.itfilesem_table) this.help.item_table = "Uma tabela deve ser selecionada."
                        if (!!this.form.item_table && !this.form.item_id) this.help.item_id = "Um item deve ser selecionado."
                    }

                    this.help.image = !isValid ? "Uma imagem deve ser selecionada." : null
					return isValid;
				},
            }
        }
    },
    data(){
        return {
            assets: window.assets,
            toUploadFiles: null,
            uploadError: null,
            isShowDeleteModal: false,
            isShowUploadModal: false,
            isShowEditModal: false,
            filters: {
                table: null,
            },
            image: null,
            form: {
                id: null,
                item_table: null,
                item_id: null,
                url: null,
            },
            help: {
                item_table: null,
                item_id: null,
                image: null,
                form: null
            }
        }
    },
    methods: {
        activeImage(image){
            if (image) {
                Axios.post(`${window.cmsApiBaseUrl}/images`, image)
                .then((response) => this.$store.dispatch("getImages"))
                .catch(() => this.$store.dispatch("getImages"))
            }
        },
        showModalUploadImage(image = null){
            this.isShowUploadModal = true
            if(image) this.image = Object.assign({}, image)
            let modalId = image ? `imageUploadModal${image.id}` : `imageUploadModal`
            setTimeout(() => {$(`#${modalId}`).modal('show')})
        },
        hideModalUploadImage(){
            let modalId = this.image ? `imageUploadModal${this.image.id}` : `imageUploadModal`
            setTimeout( () => {
                $(`#${modalId}`).modal('hide')
                this.isShowEditModal = false
                if (this.image) this.image = null
            })
        },
        setUploadFiles(ref = "toUploadFiles"){
            this.help.image = null
            if(this.$refs[ref].files.length >= 1) {
                return this.toUploadFiles = this.$refs[ref].files
            }
            this.toUploadFiles = null
        },
        async uploadFiles(ref = "toUploadFiles", hideModal = () => {}) {
            if(this.validate) {
                let formData = new FormData();
                if(this.toUploadFiles) formData.append('image', this.toUploadFiles[0])

                if(this.image) {
                    formData.append('id', this.form.id)
                    formData.append('item_table', this.form.item_table)
                    formData.append('item_id', this.form.item_id)
                    formData.append('url', this.form.url)
                }
                
                return await Axios.post(
                    `${window.cmsApiBaseUrl}/images`,
                    formData,
                    {headers: {'Content-Type': 'multipart/form-data'}}
                ).then(({data}) => {
                    this.$store.dispatch('getImages', this.current_page)
                    hideModal()
                    this.toUploadFiles = null
                    this.$refs.toUploadFiles.value = null
                    return data.success && returnImageObject ? data.image : null
                })
                .catch((err) => {
                    let erros = err?.response?.data?.errors
                    if (erros) {
                        if(erros.image) {
                            this.uploadError = erros.image[0]
                            this.toUploadFiles = null
                        }
                    }
                    return null
                })
            }
            return null
        },
        showModalEditImage(image){
            if (image) {
                this.isShowEditModal = true
                this.image = Object.assign({}, image)
                this.setFormDefault(this.image)
                let modalId = `imageEditModal${image.id}`
                setTimeout(() => {
                    if($(`#${modalId}`).length > 0) $(`#${modalId}`).modal('show')
                })
            }
        },
        hideModalEditImage(){
            if (this.image) {
                let modalId = `imageEditModal${this.image.id}`
                setTimeout( () => {
                    if($(`#${modalId}`).length > 0) $(`#${modalId}`).modal('hide')
                    this.isShowEditModal = false
                    this.image = null
                })
            }
        },
        showModalDeleteImage(image){
            if (image && !image.isUsed) {
                this.isShowDeleteModal = true
                this.image = Object.assign({}, image)
                let modalId = `imageDeleteModal${image.id}`
                setTimeout( () => {$(`#${modalId}`).modal('show')})
            }
        },
        async submitEditImage(){
            await this.uploadFiles('toUploadFiles2')
            this.hideModalEditImage()
        },
        cancelEditImage(){
            this.hideModalEditImage()
        },
        hideModalDeleteImage(){
            if (this.image) {
                let modalId = `imageDeleteModal${this.image.id}`
                setTimeout( () => {
                    if($(`#${modalId}`).length > 0) $(`#${modalId}`).modal('hide')
                    this.isShowDeleteModal = false
                    this.image = null
                })
            }
        },
        confirmDeleteImage(image){
             if (image) {
                Axios.delete(`${window.cmsApiBaseUrl}/images`, {params: {id: image.id}})
                .then((response) => this.afterDeleteImage(response.data.success))
                .catch(() => this.afterDeleteImage(false) )
                return
            }
        },
        afterDeleteImage(success = true){
            this.$store.dispatch("getImages")
            this.hideModalDeleteImage()
            if(!success) {
                this.$root.$emit('showMessage', {
                    type: "error", 
                    title: "Erro ao Excluír",
                    message: "Ocorreu um erro ao tentar o excluír a imagem!"
                })
            }
        },
        queryFilter(){
            if(this.$route.query.hasOwnProperty('filters.table')) {
                this.filters.table = this.$route.query['filters.table']
            } else{
                this.filters.table = null
            }
        }
    },
    watch: {
        "$route.query"(){
            this.queryFilter() 
        },
        "form.item_table"(){
            if(!this.form.item_table) this.form.item_id = null
        }
    },
    async mounted(){
        await this.$store.dispatch("getImages")
       this.queryFilter() 
    }
}
</script>