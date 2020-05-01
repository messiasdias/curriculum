import Typed from 'typed.js'
import euImg from './images/eu.png'  
import $ from 'jquery'

let state = {
    euImage: euImg,
    btn: false,
    msg : false,
    main : {
        opacity : "0.1",
    },

    typedStrings: [ "" ,
                "<b>Olá!,</b>  Sou <b>Messias Dias</b>", 
                "Que bom ter você aqui! ",
                "Esse é o meu Curriculum.",
                'Para imprimir ou salvar como PDF <br> clique no icone <b><i  class="fas fa-print"></i></b>; ',
                'Se preferir um contato direto: <br>Via  Wathsapp, clique no icone <b><i class="fab fa-whatsapp"></i></b>;',
                'Via email clique aqui  <br> <a href="mailto:messiasdias.ti@gmail.com">messiasdias.ti@gmail.com</a><br> ou no icone <b><i class="fas fa-envelope"></i></b>.',
                "Espero atender os requisitos <br> necessários pra a vaga ou projeto  <b>:)</b>",
                "E Mais uma vez...",
                "Muito <b>Obrigado</b> por está aqui!",
    ],

    typedString: '',


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

        console.log('state.btn', state.btn)
    },


}


let actions = {


    toggleMsg: function(context){
        if( context.state.msg ){
            context.commit("msg", false)
        }else{
            context.commit("msg", true)
            setTimeout( function(){ context.dispatch('typedRun2') }, 5000)
        }
    },

    printDoc: function(context){
        context.dispatch('toggleMsg', false)
        window.print();
    },

    typedRun : function(context) {

        if(context.state.msg){
            let typed =  new Typed('#typed', {
                strings: context.state.typedStrings,
                typeSpeed: 80,
                backSpeed: 40,
                loop: true,
                showCursor: false,
            })

            console.log(typed)
        }

    },


    typedRun2 : function(context) {
        
        if(context.state.msg){
            console.log('Start runTyped2() ...')
            let i=0 
            let keys = Object.keys(context.state.typedStrings)
            let typedStrings = context.state.typedStrings
           
            $('#typed').html('')
            console.log($('#typed'), keys.length, typedStrings.length )

            while( i < keys.length ) {
              //  $('#typed').html(strings[i])
              setTimeout( function(){
                console.log('element:',  i, typedStrings[i] )
              }, 3000)

              i++
            }

        }else{
            console.log('$state.msg is False!')
        }

    }



}



export default  {
    state,
    mutations,
    actions
}



