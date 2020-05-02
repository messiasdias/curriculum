import Typed from 'typed.js'
import euImg from './images/eu.png'  

let state = {
    euImage: euImg,
    btn: false,
    msg : false,
    main : {
        opacity : "0.1",
    },

    typed: {
        current: false,
        position: false,


        strings: [ "" ,
        "Olá!, Sou <b>Messias Dias</b>.", 
        "Que bom ter você aqui! ",
        "Esse é o meu Curriculum.",
        "...Clique nos Icones correspondentes Abaixo: ",
        'Para imprimir ou salvar como PDF; ',
        'Se preferir contato  via  Wathsapp;',
        'Enviar email para <a href="mailto:messiasdias.ti@gmail.com">messiasdias.ti@gmail.com</a>',
        "Espero atender os requisitos <br> necessários pra a vaga ou projeto.",
        "E Mais uma vez...",
        "Muito <b>Obrigado</b> por está aqui!",
        ],

        iconName: false,
        iconPrefix: false,
        icons: {
            5: 'fas:print',
            6: 'fab:whatsapp',
            7: 'fas:envelope',
            8: 'fas:heart'
        }
    },


}

let mutations = {

    msg : function (state, open=false ){
        if(  state.msg | (open == false) ) {
            state.btn = false
            state.msg =  false
            state.main.opacity = "1.0"
        }else{
            state.btn = true
            state.msg =  true
            state.main.opacity = "0.1"
        }
    },


    btn : function (state){
        if( state.btn ) {
            state.btn = false
        }else{
            state.btn = true
        }
    },


}


let actions = {


    toggleMsg: function(context){
        if( context.state.msg ){
            context.commit("msg", false)
        }else{
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
                    context.dispatch('typedSetIcon', context.state.typed.current.arrayPos )
                }else{
                    clearInterval(interval)
                    context.dispatch('typedSetIcon', false )
                }
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
            }else{
                context.state.typed.iconName = context.state.typed.icons[position]
            }
  
        }else{
            context.state.typed.position = false
            context.state.iconPrefix = false
            context.state.iconName = false
        }

    },





}



export default  {
    state,
    mutations,
    actions
}



