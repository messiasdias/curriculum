<template>
<!-- About section -->
<div class="about-section">
    <div class="overlay"></div>
    <!-- card section -->
    <div class="card-section">
        <div class="container">
            <div class="row">
                <!-- single card -->
                <div 
                    class="col-lg-4 col-12"
                    v-for="box in boxes"
                    :key="box.id"
                >
                    <div class="lab-card">
                        <div class="icon">
                            <img loading="lazy" :src="box.image ? `${assets}${box.image.url}` : ''" alt="">
                        </div>

                        <div class="texto" v-html="box.title" />
                       
                        <div class="">
                            <a 
                                class="site-btn"
                                v-if="box.link_url && box.link_text" 
                                :href="box.link_url" 
                                :title="box.link_text"
                            >
                                {{box.link_text}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <slot name="investir_home" />
        </div>
    </div>
</div>
</template>
<script>
import Axios from 'axios'
export default {
    name: 'HomeBoxes',
    data(){
        return {
            assets: window.assets,
            boxes: [],
        }
    },
    async mounted(){
        await this.getSliders()
    },
    methods: {
        getSliders(){
             Axios.get(`${window.cmsApiBaseUrl}/sliders/broadcasting/box`)
            .then(({data}) => this.boxes = data)
            .catch(() => this.boxes = [])
        }
    }
}
</script>