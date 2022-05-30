<template>
<div v-if="msg" class="msg" >
    <div draggable class="content" >
        <fontawesome icon="times" alt="Close" id="close" @click="toggleMsg()"  />
        <span class=""></span> 
        <div  class="box">
            <fontawesome v-if="typed.position"  :icon="[typed.iconPrefix, typed.iconName]" :id="typed.iconName" />
            <p id="typed" class=".typed" >...</p>
        </div>
        <img v-bind:src="euImage" alt=""> 
    </div>
</div>
</template>
<script>
import {mapState, mapActions } from "vuex"

 export default{
    name : "Msg",
    active(){
        this.toggleMsg(true)
    },
    computed: {
        ...mapState({
            msg: state => state.msg,
            euImage: state => state.euImage,
            typed: state => state.typed  
        })
    },
    methods: {
        ...mapActions ({
            toggleMsg: 'toggleMsg',
        }),
    },
}   
</script>