import Typed from 'typed.js'
import Axios from 'axios'
import euImg from './assets/eu.png'
const apiBaseUrl = process.env.VUE_APP_API_BASE_URL

let state = {
    euImage: euImg,
    msg : false,
    cookieMsg: localStorage.getItem('msg') ? true : false,
    typed: {
        current: false,
        position: false,
        strings: [
            '' ,
            'Olá, me chamo <b>Messias Dias</b>.', 
            'Adorei saber que passou aqui! ', 
            'Clique nos Botões correspondentes para: ',
            'Imprimir ou Salvar como PDF',
            'Contato  via  Wathsapp',
            'Enviar email para <a href="mailto:messiasdias.ti@gmail.com">messiasdias.ti@gmail.com</a>',
            'Espero atender os requisitos <br> necessários pra a vaga ou projeto.',
            'E Mais uma vez...',
            'Muito <b>Obrigado</b>!',
        ],

        iconName: false,
        iconPrefix: false,
        icons: {
            4: 'fas:print',
            5: 'fab:whatsapp',
            6: 'fas:envelope',
            7: 'fas:tasks',
            9: 'fas:heart'
        }
    },
    experiencias: [],
    formacoes: [],
    conhecimentos: [],
    redes_sociais: [],
    repositorios: [],
    projetos: [],
    informacoes_extra: [],
    metadados: {},
    wp_link: null,
}

let mutations = {
    msg : function (state, open = false ){
        if( state.msg | (open == false) ) return state.msg = false
        state.msg = true
    },
    cookieMsg: function(state, msg = true){
        localStorage.setItem('msg', msg) 
    },
    experiencias: (state, experiencias = []) => {
        state.experiencias = experiencias
    },
    formacoes: (state, formacoes = []) => {
        state.formacoes = formacoes
    },
    conhecimentos: (state, conhecimentos = []) => {
        state.conhecimentos = conhecimentos
    },
    redes_sociais: (state, redes_sociais = []) => {
        state.redes_sociais = redes_sociais
    },
    repositorios: (state, repositorios = []) => {
        state.repositorios = repositorios
    },
    projetos: (state, projetos = []) => {
        state.projetos = projetos
    },
    informacoes_extra: (state, informacoes_extra = []) => {
        state.informacoes_extra = informacoes_extra
    },
    metadados: (state, metadados = []) => {
        state.metadados = metadados
    },
    wp_link: (state) => {
        state.wp_link = `https://api.whatsapp.com/send?phone=${state.metadados.wp_phone}&text=${encodeURI(state.metadados.wp_message)}`
    }
}


let actions = {
    toggleMsg: function(context){
        if( context.state.msg ){
            context.commit("msg", false)
            if(!context.state.cookieMsg){
                context.commit("cookieMsg")
            }
            return
        }

        if(!context.state.cookieMsg){
            context.commit("msg", true)
            setTimeout( function(){ context.dispatch('typedRun') }, 5000)
        }
    },

    printDoc: function(context){
        context.dispatch('toggleMsg', false)
        window.print();
    },

    mailTo: ({state}) => window.location.href = `mailto:${state.metadados.email}`,

    typedRun : function(context) {
        if(context.state.msg){
            context.state.typed.current =  new Typed('#typed', {
                strings: context.state.typed.strings,
                typeSpeed: 80,
                backSpeed: 40,
                loop: true,
                showCursor: false,
                contentType: 'html'
            })
            
            let interval = setInterval( function(){
                if(context.state.msg){
                    return context.dispatch('typedSetIcon', context.state.typed.current.arrayPos )
                }

                clearInterval(interval)
                context.dispatch('typedSetIcon', false )
            }, 100 )
        }
    },

    typedSetIcon(context, position = false ) {
        if( context.state.typed.icons[position]  ){
            context.state.typed.position = position
            context.state.iconPrefix = 'fas'
    
            if( context.state.typed.icons[position].split(':').length === 2 ){
                context.state.typed.iconPrefix = context.state.typed.icons[position].split(':')[0]
                context.state.typed.iconName = context.state.typed.icons[position].split(':')[1]
                return
            }
            context.state.typed.iconName = context.state.typed.icons[position]
            return
        }

        context.state.typed.position = false
        context.state.iconPrefix = false
        context.state.iconName = false
    },

    experiencias: (context) => {
        Axios.get(`${apiBaseUrl}/experiencias.json`)
            .then(({data}) => context.commit('experiencias', data))
            .catch(() => context.commit('experiencias'))
    },
    formacoes: (context) => {
        Axios.get(`${apiBaseUrl}/formacoes.json`)
            .then(({data}) => context.commit('formacoes', data))
            .catch(() => context.commit('formacoes'))
    },
    conhecimentos: (context) => {
        Axios.get(`${apiBaseUrl}/conhecimentos.json`)
            .then(({data}) => context.commit('conhecimentos', data))
            .catch(() => context.commit('conhecimentos'))
    },
    redes_sociais: (context) => {
        Axios.get(`${apiBaseUrl}/redes_sociais.json`)
            .then(({data}) => context.commit('redes_sociais', data))
            .catch(() => context.commit('redes_sociais'))
    },
    repositorios: (context) => {
        Axios.get(`${apiBaseUrl}/repositorios.json`)
            .then(({data}) => context.commit('repositorios', data))
            .catch(() => context.commit('repositorios'))
    },
    projetos: (context) => {
        Axios.get(`${apiBaseUrl}/projetos.json`)
            .then(({data}) => context.commit('projetos', data))
            .catch(() => context.commit('projetos'))

    },
    informacoes_extra: (context) => {
        Axios.get(`${apiBaseUrl}/informacoes_extra.json`)
            .then(({data}) => context.commit('informacoes_extra', data))
            .catch(() => context.commit('informacoes_extra'))
    },
    metadados: (context) => {
        Axios.get(`${apiBaseUrl}/metadados.json`)
            .then(async ({data}) => {
                await context.commit('metadados', data)
                context.commit('wp_link')
            })
            .catch(() => context.commit('metadados'))
    },
    loadData: async (context) => {
        await context.dispatch('metadados')
        context.dispatch('experiencias')
        context.dispatch('formacoes')
        context.dispatch('conhecimentos')
        context.dispatch('redes_sociais')
        context.dispatch('projetos')
        context.dispatch('repositorios')
        context.dispatch('informacoes_extra')
    }
}

export default  {
    state,
    mutations,
    actions
}



