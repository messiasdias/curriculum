<template>
<div :class="classes">
    <div class="product-box">
        <div class="product-img">
            <img loading="lazy" :src="`${assets}${url}`" alt="img-1" class="img-fluid mx-auto d-block">
        </div>
        <div class="text-center">
            <p v-if="image && image.item_table" class="font-size-12 mb-1">{{itemsTables[image.item_table]}}</p>
            <h5 v-if="image && image.item_table" class="font-size-15"><a href="#" class="text-dark">{{getTableItem(image) ? (getTableItem(image).name || getTableItem(image).title) : image.url}}</a></h5>
        </div>
        <div class="product-actions">
            <a @click.prevent="showModalSelectImage(image)" href="#" style="margin-right: 10px;">
                <i class="ri-pencil-line text-secondary"></i>
            </a>
            <a  @click.prevent="removeImage()" href="#">
                <i class="ri-delete-bin-line text-danger"></i>
            </a>
        </div>
    </div>

    <Modal
        v-if="isShowSelectImageModal"
        :id="`selectImageModal`"
        :title="'Selecionar imagem da Categoria'"
        :closeText="'Não'"
        :confirmText="'Sim'"
        :size="'modal-lg'"
        @close="hideModalSelectImage"
    >
      <template slot="body">
        <SelectImage 
            :selected="images_id"
            :item_table="item_table" 
            :item_id="item_id" 
            @change="changeImage($event)"
        />
      </template>
      <template slot="footer">
        <button :disabled="!selectedImage" @click.prevent="confirmSelectImage(selectedImage)" class="btn btn-primary">OK</button>
      </template>
    </Modal>
</div>
</template>
<script>
import Axios from 'axios'
import Modal from './../Modal'
import SelectImage from './../images/SelectImage'
import DefaultImage from './DefaultImage'

export default {
    name: "ImageFile",
    extends: DefaultImage,
    components: {
        Modal,
        SelectImage
    },
    props: {
        images_id: {
            type: Number,
            default: null
        },
        item_table: {
            type: String,
            default: null
        },
        item_id: {
            type: Number,
            default: null
        },
        imageObj: {
            type: Number,
            default: () => null
        },
        classes: {
            type: String,
            default: "col-xl-4 col-sm-6"
        }
    },
    computed: {
        url(){
            return this.image?.url || 'admin/images/product/img-1.png'
        }
    },
    data(){
        return {
            assets: window.assets,
            image: Object.assign({}, this.imageObj) || null,
            isShowSelectImageModal: false,
            selectedImage: null,
        }
    },
    methods: {
        getImage(id = null){
            if(id) {
                Axios.get(`${window.cmsApiBaseUrl}/images/${id}`)
                .then(({data}) => {
                    this.image = data.image
                    this.$emit('image', Object.assign({}, this.image))
                })
            }
        },
        showModalSelectImage(image){
            if (image) {
                this.isShowSelectImageModal = true
                this.image = Object.assign({}, image)
                setTimeout(() => {$(`#selectImageModal`).modal('show')})
            }
        },
        hideModalSelectImage(){
            setTimeout(() => {
               $(`#selectImageModal`).modal('hide')
               this.isShowSelectImageModal = false
            })
        },
        confirmSelectImage(id){
            this.hideModalSelectImage()
            if (id) {
                return this.getImage(id)
            }
            this.$emit('image', null)
        },
        afterSelectImage(success = true){
            this.$store.dispatch("getImages")
            this.$store.dispatch("getCategories")
            this.$emit("selectImage", image)
            this.hideModalSelectImage()
            if(success == false) {
                this.$root.$emit('showMessage', {
                    type: "error", 
                    title: "Erro ao Excluir",
                    message: "Ocorreu um erro ao tentar o excluir a categoria!"
                })
            }
        },
        removeImage(){
            this.$emit('image', null)
            this.image = null
            this.selectedImage = null
        },
        changeImage(image){
            this.selectedImage = image[0]
        }
    },
    watch: {
        images_id() {
            if (this.images_id) {
                this.getImage(this.images_id)
            }
        }
    },
    mounted(){
        if(this.images_id) this.getImage(this.images_id)
    }
}
</script>