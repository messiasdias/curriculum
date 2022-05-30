<template>
<div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="timeline">

                <div class="timeline-item timeline-left">
                    <div class="timeline-block">
                        <div class="time-show-btn mt-0">
                            <a @click.prevent href="#" class="btn btn-danger btn-rounded w-lg">{{currentYear}}</a>
                        </div>
                    </div>
                </div>
                
                <template v-for="(event, e) in timeline" >        
                    <div v-if="(e + 1) <= showing" :key="e" class="timeline-item" :class="{'timeline-left' : e % 2 !== 0}">
                        <div class="timeline-block">
                            <div class="timeline-box card">
                                <div class="card-body">
                                    <span class="timeline-icon"></span>

                                    <div class="timeline-date">
                                        <i class="mdi mdi-circle-medium circle-dot"></i> {{dateTimeToLocaleMoment(event.updated_at)}}
                                    </div>

                                     <i class="mdi mdi-circle-medium circle-dot"></i>
                                    <h5 class="mt-3 foont-size-15">
                                         <i v-if="event.is_new" class="fas fa-calendar-plus"></i>
                                         <i v-else class="fas fa-calendar-alt"></i>
                                         <span v-html="event.title"></span>
                                    </h5>
                                    <div v-html="event.text" class="text-muted"></div>

                                    <div v-if="event.item && event.item.image" class="mb-2 mt-4">
                                        <img class="rounded avatar-lg" :src="`${assets}${event.item.image.url}`" alt="small img-2">
                                    </div>

                                    <div v-if="event.item && event.item.galery" class="timeline-album">
                                        <a v-for="image in event.item.galery" :key="image.id" @click.prevent href="#" class="me-1">
                                            <img :src="`${assets}${image.url}`" alt="small img-3">
                                        </a>
                                    </div>

                                    <router-link class="btn btn-light btn-sm mt-4" :to="getItemLink(event)" >Detalhes do Item</router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

             <div v-if="timeline.length > 0 && timeline.length > showing" class="row text-center mt-5">
                    <div class="timeline-block">
                        <div class="time-show-btn mt-10">
                            <a @click.prevent="viewMore()" href="#" class="btn btn-primary btn-rounded w-lg">Ver Mais</a>
                        </div>
                    </div>
             </div>
        </div>
    </div>
    <!-- end row -->
</template>
<script>
import moment from 'moment'
import {dateTimeToLocaleMoment} from './../../../../assets/helpers'
export default {
    name: "Timeline",
    props: {
        timeline: {
            type: Array,
            default: () => []
        } 
    },
    computed: {
        currentYear(){
            return this.timeline.length > 0 ? moment(this.timeline[0].updated_at).format("YYYY") :  moment().format("YYYY")
        }
    },
    data(){
        return {
            assets: window.assets,
            showing: 1,
        }
    },
    methods: {
        dateTimeToLocaleMoment: dateTimeToLocaleMoment,
        getPageURL(page, item){
            let url = !page.is_default_page ? `/pagina/${page.slug}` : `/${page.slug}`
            if (page.slug === 'interna-cases') url = `/cases/${item.id}`
            return url
        },
        getItemLink(event){
            if (event.type === 'contact') return `/inbox/${event.item.id}`
            if (event.type === 'case') return `/cases/${event.item.id}`
            if (event.type === 'categorie') return `/categories/${event.item.id}`
            if (event.type === 'slider') return `/sliders/${event.item.id}`
            if (event.type === 'solution') return `/solutions/${event.item.id}`
            if (event.type === 'page') return `/pages/${event.item.id}`
            if (event.type === 'user') return `/users/${event.item.id}`
            return "/"
        },
        viewMore(){
            if (this.timeline.length > this.showing) this.showing += 5
        }
    },
}
</script>