<template>
<!-- start .btns-->
<div class="btn">
     <!-- #email-->
    <div class="" id="email" title="Email" onclick="window.location.href='mailto:messiasdias.ti@gmail.com';" >
        <fontawesome icon="envelope" />
    </div>

    <!-- #whatsapp-->
    <a class=""  id="whatsapp" title="Whatsapp" target="_blank" href="https://api.whatsapp.com/send?phone=5581983538086&text=Ol%C3%A1%20Messias!" >
        <!-- fab fa-whatsapp -->
        <fontawesome :icon="['fab', 'whatsapp']"  />
    </a>
    
    <!-- #printbtn-->
    <div class="" id="print" title="Imprimir" @click="printDoc()" >
         <!-- fas fa-print -->
        <fontawesome icon="print" class="active"  />
    </div>
</div>
<!-- end .btns-->
</template>
<script>
import {mapState, mapMutations} from "vuex"
 export default{
     name : "Buttons",
    computed: {
        ...mapState({
            msg: state => state.msg,
        })
    },

    methods:{
        ...mapMutations({
            printDoc: 'printDoc',
        })
    }
 }   
</script>