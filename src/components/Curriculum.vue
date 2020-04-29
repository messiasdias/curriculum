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

 export default{
     name : "Curriculum",
     components :{
         Left,
         Right,
         Buttons,
         Msg,
     }
 }   
</script>