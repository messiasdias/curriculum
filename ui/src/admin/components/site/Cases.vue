<template>
<div class="container">
	<div class="row lista-cases">
        <template  v-for="categorie in categories">
            <div 
                v-if="categorie.active"
                :key="categorie.id" 
                class="col-lg-4 d-flex"
            >
                <a  
                    @click.prevent="selectCategorie(categorie.id)"
                    :title="`Cases ${categorie.name}`" href="#" 
                    :class="{'select': !!categorieSelected && categorieSelected.includes(categorie.id)}" 
                >
                    <img 
                        loading="lazy" 
                        class="mr-3" 
                        v-if="categorie.image" 
                        :src="`${assets}${categorie.image.url}`" 
                        :alt="`Imagem da Categoria ${categorie.name}`"
                    > 
                    {{categorie.name}}
                </a>
            </div>
        </template>
	</div>

	<div class="row exibe-cases">
        <template v-for="(caseItem, i) in caseItems" >
            <div 
                v-if="show >= (i + 1) && caseItem.active"
                :key="caseItem.id" 
                class="col-lg-4 mb-5"
            >
                <a :href="`/cases/${caseItem.id}`" class="card-case" :title="caseItem.name">
                    <img loading="lazy" v-if="caseItem.image" :src="`${assets}${caseItem.image.url}`" alt="">
                </a>
                <a :href="`/cases/${caseItem.id}`" :title="caseItem.name"><h2>{{caseItem.name}}</h2></a>
                <p><i class="fa fa-map-marker mr-2"></i>{{caseItem.localization}}</p>
            </div>
        </template>
	</div>

    <div class="row d-flex justify-content-center">
        <button :disabled="show >= caseItems.length" @click.prevent="showMore()" class="site-btn" id="enviar_mensagem">
            <i class="fa fa-plus mr-2"></i> Ver mais
        </button>
    </div>
</div>
</template>
<script>
import Axios from 'axios'
export default {
    name: 'cases',
    data(){
        return {
            assets: window.assets,
            categories: [],
            caseItems: [],
            categorieSelected: null,
            caseItemSelected: null,
            show: 6,
            showIncrement: 3,
        }
    },
    async beforeMount(){
        await this.getCategories()
    },
    methods: {
        getCategories(){
             Axios.get(`${window.cmsApiBaseUrl}/categories`)
            .then(({data}) => {
                this.categories = data.data
                this.selectCategorie()
            })
            .catch(() => this.categories = [])
        },
        async selectCategorie(categorie = null){
            if (categorie && (!this.categorieSelected || !this.categorieSelected.includes(categorie))) {
                if(!this.categorieSelected || this.categorieSelected.length === 0) this.categorieSelected = []
                if(categorie) this.categorieSelected.push(categorie)
            } else {
                if(categorie) this.categorieSelected = this.categorieSelected.filter(c => c != categorie)
            }

            this.caseItems = []
            this.categories.forEach(cat => {
                if (cat.active) {
                    if (!this.categorieSelected || this.categorieSelected.length === 0  || this.categorieSelected.includes(cat.id)) {
                        cat.cases.forEach(cs => this.caseItems.push(cs))
                    }
                }
            })
        },
        showMore(){
            if (this.show < this.caseItems.length) this.show += this.showIncrement;
        }
    }
}
</script>