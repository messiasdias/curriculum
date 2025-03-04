<template>
<div id="app" >
    <div id="avatar" > </div>
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
            euNome: state => state.metadados.nome_curto,
            euNomeCompleto: state => state.metadados.nome_completo
        })
    },
    components :{
        Left,
        Right,
        Buttons,
        Msg,
    },
    metaInfo: {
        title: process.env.VUE_APP_DEV_NAME,
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
                content:  'Messias Dias - Curriculum versão web, construído com Vue.js.',
            },
            {
                vmid: 'keywords',
                name: 'keywords',
                content:  `curriculum,vitae,web,html,html5,css,css3,Sass,vuejs,vue.js,Vue,vue,Vue.js,desenvolvedor,dev,developer,front-end,back-end,front,back,end,`+
                'formação,formacao,conhecimentos,pretensao salarial,objetivo,contatos,social,repositórios,git',
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
                template: chunk => `${chunk} - ${process.env.VUE_APP_DEV_NAME} | Curriculum Vitae'`,
                vmid: 'og:title'
            }
        ],
        link: [
            { rel: 'manifest', href: 'manifest.webmanifest' },
            { rel: 'favicon', href: 'favicon.ico' },
            { rel:"apple-touch-icon", href: 'img/icons/icon-192x192.png' }
         ],
    },
    mounted(){
        this.$store.dispatch('loadData')
    }
 }   
</script>