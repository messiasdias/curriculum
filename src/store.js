import Typed from 'typed.js'
import euImg from './assets/eu.png' 

let state = {
    euImage: euImg,
    msg : false,
    cookieMsg: localStorage.getItem('msg') ? true : false,
    typed: {
        current: false,
        position: false,
        strings: [
            "" ,
            "Olá!, Sou <b>Messias Dias</b>.", 
            "Que bom ter você aqui! ",
            "Esse é o meu Curriculum.",
            "... Clique nos Botões correspondentes Abaixo para: ",
            'Imprimir ou Salvar como PDF; ',
            'Contato  via  Wathsapp;',
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
            8: 'fas:tasks',
            10: 'fas:heart'
        }
    },
    experiencias: [
        /*
        {
            empresa: 'Vertice Digital',
            cargo: 'Desenvolvedor FullStack JR',
            periodo: 'Jan/2021 - Abr/2021',
            descricao: [
              'Desenvolvimento de interfaces web com Vue.js',
              'Manuteção em aplicações híbridas Laravel e Slim Framework (PHP)'
            ]
        },
        */
        {
            empresa: 'KEVI | Retenção de Cliente',
            cargo: 'Desenvolvedor FullStack JR',
            periodo: 'Mai/2021 - Atualmente',
            descricao: [
              'Desenvolvimento de interfaces web com Vue.js',
              'Manuteção em aplicações híbridas Slim Framework e Proprietário (PHP)',
              'Testes JS com Jest e PHP com Php Unit'
            ]
        },
        {
          empresa: 'Vértice Digital',
          cargo: 'Desenvolvedor FullStack JR',
          periodo: 'Jan/2021 - Abr/2021',
          descricao: [
            'Desenvolvimento de interfaces web com Vue.js',
            'Manuteção em aplicações híbridas Laravel e Slim Framework (PHP)'
          ]
        },
        {
          empresa: 'FUTURA DES. DE PROGRAMAS EIRELI',
          cargo: 'Desenvolvedor Front-End JR',
          periodo: 'Jun/2020 - Jan/2021',
          descricao: [
            'Desenvolvimento de interfaces web com Vue.js e Materialize'
          ]
        },
        {
          empresa: 'SETEV',
          cargo: 'Analista de Suporte JR',
          periodo: 'Fev/2018 - Set/2019',
          descricao: [
            'Administração de Servidores Linux Ubuntu/Debian',
            'NovoSGA - Implantação do Sistema de Gerenciamento de Atendimento',
            'NovoSGA - Desenvolvimento Front-End de Painel de Atendimento exclusivo'
          ]
        }
    ]
}

let mutations = {
    msg : function (state, open=false ){
        if(  state.msg | (open == false) ) {
            state.msg =  false
        }else{
            state.msg =  true
        }
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

        }else{
            if(!context.state.cookieMsg){
                context.commit("msg", true)
                setTimeout( function(){ context.dispatch('typedRun') }, 5000)
            }
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



