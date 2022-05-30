<template>
<div class="case-galery" :class="classes">
    <div class="row col-12 items">
        <div class="product-detail">
            <div class="row">
                <div class="col-3">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                        aria-orientation="vertical">
                        <a 
                            v-for="item in galeryItems" :key="item.id"
                            class="nav-link active" 
                            id="product-1-tab" 
                            role="tab"
                            data-bs-toggle="pill"
                            :href="`#image-${item.id}`" 
                            @click="selecteImageItem(item)"
                        >
                            <img 
                                alt="img-1" 
                                loading="lazy"
                                class="img-fluid mx-auto d-block tab-img rounded"
                                :src="item.image ? `${assets}${item.image.url}` : ''"
                            >
                        </a>
                    </div>
                </div>
                <div class="col-md-8 col-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div 
                            v-for="item in galeryItems" 
                            class="tab-pane fade" 
                            :class="{'show active' : showGaleryImage == `image-${item.id}`}"
                            :key="item.id"
                            :id="`image-${item.id}`" 
                            role="tabpanel"
                        >
                            <div class="product-img">
                                <img 
                                    loading="lazy"
                                    alt="Imagem da Galeria"
                                    class="img-fluid mx-auto d-block"
                                    :src="item.image ? `${assets}${item.image.url}` : ''" 
                                    :data-zoom="item.image ? `${assets}${item.image.url}` : ''"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="row text-center mt-2">
                        <div class="col-sm-6">
                            <div class="d-grid">
                                <button 
                                    type="button"  
                                    class="btn btn-primary waves-effect waves-light mt-2"
                                    @click.prevent="showModalAddImage(selectedGaleryImage)"
                                >
                                    <i class="fa fa-plus text-white"></i> Adicionar imagem 
                                </button>
                            </div>
                        </div>
                        <div v-if="galeryItems.length" class="col-sm-6">
                            <div class="d-grid">
                                <button 
                                    type="button"
                                    class="btn btn-danger waves-effect  mt-2 waves-light"
                                    @click="showModalRemoveImage(selectedGaleryImage)"
                                >
                                    <i class="ri-delete-bin-line text-white"></i> Remover Imagem
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <Modal
        v-if="isShowAddImageModal"
        :id="`addImageModal`"
        :title="'Selecionar imagens para a galeria'"
        :closeText="'Não'"
        :confirmText="'Sim'"
        :size="'modal-lg'"
        @close="hideModalAddImage"
    >
      <template slot="body">
        <SelectImage
            :item_table="item_table" 
            :item_id="item_id" 
            :multiSelect="true"
            :exceptImageIds="galeryItems.map(it => it.image.id)"
            @change="changeImage($event)"
        />
      </template>
      <template slot="footer">
        <button :disabled="!toAddImages.length" @click.prevent="confirmAddImage()" class="btn btn-primary">OK</button>
      </template>
    </Modal>

    <Modal
        v-if="isShowRemoveImageModal"
        :id="`removeImageModal`"
        :title="'Remover imagem da galeria'"
        :closeText="'Não'"
        :confirmText="'Sim'"
        :size="'modal-md'"
        @confirm="confirmRemoveImage"
        @close="hideModalRemoveImage"
    >
    <template slot="body"> 
        <p>Deseja realmente remover a imagem da galeria?</p>
    </template>
    </Modal>
</div>
</template>
<script>
import Axios from 'axios'
import Modal from './../Modal'
import SelectImage from './../images/SelectImage'
export default {
    name: 'CaseGalery',
    components: {
        Modal,
        SelectImage
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
        cases_id: {
            type: String,
            default: null
        },
        galeryItems: {
            type: Array,
            default: () => []
        },
        classes: {
            type: String,
            default: "col-xl-4 col-sm-6"
        }
    },
    data(){
        return {
            assets: window.assets,
            selectedGaleryImage: this.galeryItems[0] || null,
            toAddImages: [],
            isShowAddImageModal: false,
            isShowRemoveImageModal: false,
            showGaleryImage: 'image-1',
        }
    },
    methods: {
        autoSelectImageItem(){
            setTimeout(() => {
                if(this.galeryItems[0]) this.selecteImageItem(this.galeryItems[0], 2000)
            })
        },
        selecteImageItem(item = null){
            this.selectedGaleryImage = item
            this.showGaleryImage = `image-${item.id}`
        },
        showModalAddImage(){
            this.isShowAddImageModal = true
            setTimeout(() => {$(`#addImageModal`).modal('show')})
        },
        hideModalAddImage(){
            setTimeout(() => {
               $(`#addImageModal`).modal('hide')
               this.isShowAddImageModal = false
            })
        },
        confirmAddImage(){
            this.hideModalAddImage()
            if (this.toAddImages.length >= 1) {
                Axios.post(`${window.cmsApiBaseUrl}/cases/galery`, {
                    cases_id: this.item_id,
                    images: this.toAddImages
                })
                .then(() => this.$emit('getCaseItem'))
            } 
        },
        showModalRemoveImage(){
             if(this.selectedGaleryImage) {
                this.isShowRemoveImageModal = true
                setTimeout(() => {$(`#removeImageModal`).modal('show')})
            }
        },
        hideModalRemoveImage(){
            setTimeout(() => {
               $(`#removeImageModal`).modal('hide')
               this.isShowRemoveImageModal = false
            })
        },
        confirmRemoveImage(){
            this.hideModalRemoveImage()
            if (this.selectedGaleryImage) {
                Axios.delete(`${window.cmsApiBaseUrl}/cases/galery`, {params: {id: this.selectedGaleryImage.id}})
                .then(() => this.$emit('getCaseItem'))
            } 
        },
        changeImage(images){
            this.toAddImages = images
        }
    },
    watch: {
        "galeryItems"(){
            this.autoSelectImageItem()
        }
    },
    mounted(){
       this.autoSelectImageItem()
    }
}
</script>