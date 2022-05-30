import Typed from 'typed.js'
import euImg from './assets/eu.png' 
import experiencias from './services/experiencias'

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
    experiencias: experiencias
}

let mutations = {
    msg : function (state, open=false ){
        if(  state.msg | (open == false) ) {
            state.msg =  false
            return
        }
        state.msg =  true
    },

    cookieMsg: function(state, cookie = true){
        localStorage.setItem('msg', cookie) 
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
}


export default  {
    state,
    mutations,
    actions
}



