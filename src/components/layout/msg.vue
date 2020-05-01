<template>
 <!-- start .msg-->
<div v-if="msg" class="msg"  >

    <div draggable class="content" >
        <fontawesome icon="times" id="close" @click="toggleMsg()"  />
        <span class=""></span> 
        
        <div  class="box">
            <p  id="typed">...</p>
        </div>
        
        <img v-bind:src="euImage" alt="">
        
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
            euImage: state => state.euImage 
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