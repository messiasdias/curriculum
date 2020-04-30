<template>
<!-- start .left-->
<div class="left">
    
    <div class="img-content">  <img :src="euImage"> </div>
               
    <div class="item" >
        <h3> <fontawesome class="icon" icon="address-book" /> Contatos</h3>
        <p><a target="_blank" href="https://api.whatsapp.com/send?phone=5581983538086&text=Ol%C3%A1%20Messias!"> 81983538086</a></p>
        <p><a target="_blank" href="mailto:messiasdias.ti@gmail.com">messiasdias.ti@gmail.com</a></p>
    </div>

    <div class="item" >
        <h3><fontawesome class="icon" icon="network-wired" /> Social</h3>
        <p><a target="_blank" href="https://linkedin.com/in/messiasdias"> linkedin.com/in/messiasdias</a> </p>
    </div>

    <div class="item" >
        <h3><fontawesome class="icon" icon="code-branch" /> Code Repositórios</h3>
        <p><a target="_blank" href="https://github.com/messiasdias">github.com/messiasdias</a></p>
        <p><a target="_blank" href="https://bitbucket.org/messiasdias">bitbucket.org/messiasdias</a></p>
    </div>

    <div class="item" >
        <h3><fontawesome class="icon" icon="info" />  Informações Relevantes</h3>
        <p>Inglês Técnico - Básico</p> 
        <p>Habilitação AB</p>
        <p>Disponibilidade para Viagens</p>    
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