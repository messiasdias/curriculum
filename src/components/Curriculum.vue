<template>
<div id="app" >
    <img id="avatar" alt="Foto Messias"  :src="euImage">
    
    <div class="main">
        <Left/>
        <Right/>
    </div>

    <Buttons/>
    <Msg/>
</div>    
</template>
<script>
import Left from "./layout/left.vue"
import Right from "./layout/right.vue"
import Buttons from "./layout/buttons.vue"
import Msg from "./layout/msg.vue"
import {mapState} from "vuex"

 export default{
    name : "Curriculum",

    computed: {
        ...mapState({
            msg: state => state.msg,
            euImage: state => state.euImage,
        })
    },

    components :{
         Left,
         Right,
         Buttons,
         Msg,
     },


    metaInfo: {

        title: 'Messias Dias',
        titleTemplate: '%s | Curriculum Vitae',
        
        htmlAttrs: {
            lang: 'pt-Br',
            amp: true
        },
      
        meta: [
            { charset: 'utf-8' },

            {
                vmid: 'description',
                name: 'description',
                content:  'Meu Curriculum Vitae Versão Web. Construido com Vue.js, Html5 e Css3/Sass.',
            },

            {
                vmid: 'keywords',
                name: 'keywords',
                content:  'Messias Dias,messiasdias,messias,dias,curriculum,vitae,web,html,html5,css,css3,Sass,vuejs,vue.js,Vue,vue,Vue.js,desenvolvedor,dev,developer,front-end, back-end,front,back,end,'+
                'formação,formacao,conhecimentos,pretençõa salarial,objetivo,contatos,social,repositórios,git,github,laravel,NovoSGA,novo sga,sga,likedin',
            },

            {
                'name': 'viewport',
                'content': 'width=device-width,initial-scale=1'
            },

            {
                'name': 'robots',
                'content': 'index, follow'
            },

             {
                'name': 'theme-color',
                'content': '#055ab4'
            },

            //CEO Social

            {
                property: 'og:title',
                content: 'Home',
                template: chunk => `${chunk} - Messias Dias | Curriculum Vitae'`,
                vmid: 'og:title'
            },
            
            {
                property: 'og:title',
                content: 'Home',
                template: chunk => `${chunk} - Messias Dias | Curriculum Vitae'`,
                vmid: 'og:title'
            },

        
        ],

        link: [
            { rel: 'manifest', href: 'manifest.webmanifest' },
            { rel: 'favicon', href: 'favicon.ico' },
            { rel:"apple-touch-icon", href: 'img/icons/icon-192x192.png' }
         ],

       
    
    },

 }   
</script>