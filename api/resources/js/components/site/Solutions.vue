<template>
<div class="container">
    <template  v-for="solution in solutions" >
        <div
            v-if="solution.active"
            :key="solution.id"  
            class="row no-gutters d-flex align-items-center"
        >
            <div v-if="solution.id % 2 != 0" class="col-lg-6 d-flex justify-content-end">
                <img loading="lazy" :src="`${assets}${solution.image.url}`" :alt="`Imagem solução ${solution.title}`">
            </div>
            <div class="col-lg-6" :class="{'left': solution.id % 2 == 0, 'right': solution.id % 2 != 0}">
                <h2>{{solution.title}}</h2>
                <p>{{solution.text}}</p>
            </div>
            <div v-if="solution.id % 2 == 0" class="col-lg-6">
                <img loading="lazy" :src="`${assets}${solution.image.url}`" :alt="`Imagem solução ${solution.title}`">
            </div>
        </div>
    </template>
</div>
</template>
<script>
import Axios from 'axios'
export default {
    name: 'solutions',
    data(){
        return {
            assets: window.assets,
            solutions: []
        }
    },
    methods: {
        getSolutions(){
             Axios.get(`${window.cmsApiBaseUrl}/solutions`)
            .then(({data}) => {
                this.solutions = data.data
            })
            .catch(() => this.solutions = [])
        },
    },
    beforeMount(){
        this.getSolutions()
    }
}
</script>