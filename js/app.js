
        function btnActive(active=true){
            var elements = document.getElementsByClassName("btn");
            var keys = Object.keys(elements);
            for(var i=0; i < keys.length ; i++){
                if(active){
                    elements[i].classList.add("active");
                }else{
                    elements[i].classList.remove("active");
                }
            }
        }

        function toggle(open = false){

            if( open ) {
                btnActive(true);
                document.getElementById('msg').style.display = 'flex';
                document.getElementsByClassName("main")[0].style.opacity = "0.1";
            }else{
                btnActive(false);
                document.getElementById('msg').style.display = 'none';
                document.getElementsByClassName("main")[0].style.opacity  = "1.0";
            }
        }


        function printDoc(){
            toggle(false);
            window.print();
        }


        var typedStrings =  [ "" ,
            "<b>Olá!,</b>  Sou <b>Messias Dias</b>", 
            "Que bom ter você aqui! ",
            "Esse é o meu Curriculum.",
            'Para imprimir ou salvar como PDF <br> clique no icone <b><i  class="fas fa-print"></i></b>; ',
            'Se preferir um contato direto: <br>Via  Wathsapp, clique no icone <b><i class="fab fa-whatsapp"></i></b>;',
            'Via email clique aqui  <br> <a href="mailto:messiasdias.ti@gmail.com">messiasdias.ti@gmail.com</a><br> ou no icone <b><i class="fas fa-envelope"></i></b>.',
            "Espero atender os requisitos <br> necessários pra a vaga ou projeto  <b>:)</b>",
            "E Mais uma vez...",
            "Muito <b>Obrigado</b> por está aqui!",
         ]

        var typed = new Typed('.typed', {
            strings: typedStrings,
            typeSpeed: 80,
            backSpeed: 40,
            loop: true,
            showCursor: false,
          });

        toggle(true);