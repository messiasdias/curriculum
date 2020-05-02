<template>
<div id="app" >

    <div class="main">
        <Left/>
        <Right/>
    </div>

    <Buttons/>
    <Msg/>
</div>    
</template>
<script>
import Left from "./layout/left.vue"
import Right from "./layout/right.vue"
import Buttons from "./layout/buttons.vue"
import Msg from "./layout/msg.vue"
import {mapState} from "vuex"

 export default{
    name : "Curriculum",

    computed: {
        ...mapState({
            msg: state => state.msg,
        })
    },

    components :{
         Left,
         Right,
         Buttons,
         Msg,
     },
 }   
</script>