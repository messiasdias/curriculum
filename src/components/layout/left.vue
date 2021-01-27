<template>
<!-- start .left-->
<div class="left">
    
    <div class="img-content"><img alt="Foto Messias"  :src="euImage"></div>
               
    <div class="item" >
        <h3><fontawesome class="icon" icon="address-book" /> Contatos</h3>
        <p class="link" ><a rel="noopener"  target="_blank" href="https://api.whatsapp.com/send?phone=5581983538086&text=Ol%C3%A1%20Messias!">(81) 983538086  <fontawesome icon="mobile-alt" /> </a></p>
        <p class="link" ><a rel="noopener"  target="_blank" href="mailto:messiasdias.ti@gmail.com">messiasdias.ti@gmail.com <fontawesome icon="at" /></a></p>
    </div>

    <div class="item" >
        <h3><fontawesome class="icon" icon="network-wired" /> Social</h3>
        <p class="link" ><a rel="noopener"  target="_blank" href="https://linkedin.com/in/messiasdias"> linkedin.com/in/messiasdias  <fontawesome icon="link" /></a> </p>
        <p class="link" ><a rel="noopener"  target="_blank" href="https://www.facebook.com/messiasw.dias/"> facebook.com/messiasw.dias  <fontawesome icon="link" /></a> </p>
    </div>

    <div class="item" >
        <h3><fontawesome class="icon" icon="code-branch" /> Code Repositórios</h3>
        <p class="link" ><a rel="noopener"  target="_blank" href="https://github.com/messiasdias">github.com/messiasdias <fontawesome icon="link" /></a></p>
        <p class="link" ><a rel="noopener" title="Perfil Pessoal para contanto"  target="_blank" href="https://bitbucket.org/messiasdias">bitbucket.org/messiasdias <fontawesome icon="link" /></a></p>
    </div>

    <div class="item" >
        <h3><fontawesome class="icon" icon="info" /> Informações Relevantes</h3>
        <p>Inglês Técnico - Básico</p> 
        <p>Trabalho Remoto</p>
        <p>PJ/MEI</p>
    </div>

    <div class="item" >
        <h3><fontawesome class="icon" icon="code-branch" />Projetos Open-Source por diversão :)</h3>
        <p class="link" ><a rel="noopener"  target="_blank" href="https://github.com/basicis/basicis">Basicis Framework - Projeto<fontawesome icon="link" /></a></p>
        <p class="link" ><a rel="noopener"  target="_blank" href="https://github.com/basicis/core">Basicis - Core Lib<fontawesome icon="link" /></a></p>
        <p class="link-print" ><a rel="noopener"  target="_blank" href="https://github.com/basicis/basicis">https://github.com/basicis/basicis <fontawesome icon="link" /></a></p>
        <p class="link-print" ><a rel="noopener"  target="_blank" href="https://github.com/basicis/core">https://bitbucket.org/basicis/core <fontawesome icon="link" /></a></p>
    </div> 

</div>
<!-- end .left-->
</template>
<script>
import {mapState} from 'vuex'

 export default{
     name : "Left",
     computed: {
         ...mapState({
             euImage: state => state.euImage 
         })
     }
 }   
</script>