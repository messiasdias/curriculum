<template>
<!-- start .btns-->
<div class="btn btn-fixed-lg">
    <!-- #printbtn-->
    <div :v-if="btn" class="" id="print" title="Imprimir" @click="printDoc()" >
        <fontawesome icon="print" />
    </div>

    <!-- #email-->
    <div :v-if="metadados.email" class="" id="email" title="Email" @click="mailTo()" >
        <fontawesome icon="envelope" />
    </div>

    <!-- #whatsapp-->
    <a :v-if="metadados.wp_phone"  class=""  id="whatsapp" title="Whatsapp" rel="noopener" 
        target="_blank" :href="wp_link" >
        <fontawesome :icon="['fab', 'whatsapp']"  />
    </a>
</div>
<!-- end .btns-->
</template>
<script>
import {mapState, mapMutations, mapActions} from "vuex"
 export default{
    name : "Buttons",
    computed: {
        ...mapState({
            msg: state => state.msg,
            btn: state => state.btn,
            metadados: state => state.metadados,
            wp_link: state => state.wp_link
        })
    },
    methods:{
        ...mapMutations({
            btnMut: 'btn',
        }),
        ...mapActions({
            printDoc: 'printDoc',
            mailTo: 'mailTo'
        }),
    }
 }   
</script>