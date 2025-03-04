import Typed from 'typed.js'
import Axios from 'axios'
import euImg from './assets/img/eu.png'
const apiBaseUrl = process.env.NODE_ENV === "production" ? process.env.VUE_APP_API_BASE_URL : '/api'

let state = {
    euImage: euImg,
    msg: false,
    cookieMsg: localStorage.getItem('msg') ? true : false,
    experiencias: [],
    formacoes: [],
    conhecimentos: [],
    redes_sociais: [],
    repositorios: [],
    projetos: [],
    informacoes_extra: [],
    metadados: {}
}

let mutations = {
    msg: (state, open = false) => {
        if(state.msg | (open == false)) {
            localStorage.removeItem('msg') 
            return state.msg = false
        }
        state.msg = true
    },
    cookieMsg: (state, msg = true) => {
        state.cookieMsg = msg
        if(msg) return localStorage.setItem('msg', msg) 
        localStorage.removeItem('msg')
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
    metadados: (state, metadados = {}) => {
        state.metadados = metadados
    }
}


let actions = {
    toggleMsg: async (context) => {
        if(context.state.msg){
            context.commit("msg", false)
            if(!context.state.cookieMsg) context.commit("cookieMsg")
            return
        }

        if(!context.state.cookieMsg){
            await context.commit("msg", true)
            context.dispatch('typedRun')
        }
    },

    printDoc: (context) => {
        context.dispatch('toggleMsg', false)
        window.print();
    },

    mailTo: ({state}) => window.location.href = `mailto:${state.metadados.email}`,

    typedRun : (context) =>  {
        if(context.state.msg && context.state.metadados.typed){
            context.state.metadados.typed.current = new Typed('#typed', {
                strings: context.state.metadados.typed.strings,
                typeSpeed: 80,
                backSpeed: 40,
                loop: true,
                showCursor: false,
                contentType: 'html'
            })
            
            let interval = setInterval( function(){
                if(context.state.msg){
                    return context.dispatch('typedSetIcon', context.state.metadados.typed.current.arrayPos)
                }

                clearInterval(interval)
                context.dispatch('typedSetIcon', localStorage.removeItem('msg') )
            }, 100 )
        }
    },

    typedSetIcon(context, position = false) {
        if(context.state.metadados.typed.icons[position]){
            context.state.metadados.typed.position = position
            context.state.iconPrefix = 'fas'
    
            if( context.state.metadados.typed.icons[position].split(':').length === 2 ){
                context.state.metadados.typed.iconPrefix = context.state.metadados.typed.icons[position].split(':')[0]
                context.state.metadados.typed.iconName = context.state.metadados.typed.icons[position].split(':')[1]
                return
            }
            context.state.metadados.typed.iconName = context.state.metadados.typed.icons[position]
            return
        }

        context.state.metadados.typed.position = false
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
            .then(({data}) => context.commit('metadados', data))
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
        setTimeout(() => context.dispatch('toggleMsg'), 3000)
    }
}

export default  {
    state,
    mutations,
    actions
}



