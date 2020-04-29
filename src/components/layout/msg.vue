<template>
 <!-- start .msg-->
<div v-if="msg" class="msg"  >

    <div class="content" >
        <fontawesome icon="times" id="close" @click="toggleMsg()"  />
        <span class=""></span> 
        
        <div  class="box">
            <p class="typed"> </p>
        </div>
        
        <img src="img/eu.png" alt="">
        
    </div>
</div>
<!-- end .msg-->
</template>
<script>
import {mapState, mapActions } from "vuex"

 export default{
    name : "Msg",

    mounted: function(){
        this.toggleMsg(true)
    },

    computed: {
        ...mapState({
            msg: state => state.msg,
        })
    },

    methods: {

        ...mapActions ({
            toggleMsg: 'toggleMsg',
        }),

    },
    //end methods

}   
</script>