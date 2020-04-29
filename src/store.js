import Typed from "typed.js"

let state = {
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
        console.log('state.msg', state.msg)
    },



}


let actions = {


    toggleMsg: function(context){
        if( context.state.msg ){
            context.commit("msg", false)
        }else{
            context.commit("msg", true)
            //context.dispath('typedRun')
        }
    },

    printDoc: function(context){
        context.dispath('toggleMsg', false)
        window.print();
    },

    typedRun : function(context) {

        new Typed('.typed', {
            strings: context.state.typedStrings,
            typeSpeed: 80,
            backSpeed: 40,
            loop: true,
            showCursor: false,
        })

    }
}



export default  {
    state,
    mutations,
    actions
}



