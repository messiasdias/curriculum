<template>
<div class="modal fade" :id="`${id}`" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" role="dialog"
    :aria-labelledby="`${id}Label`" aria-hidden="true">
    <div class="modal-dialog" :class="size" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" :id="`${id}Label`">{{title}}</h5>
                <button  
                    type="button" 
                    class="btn-close"
                    data-bs-dismiss="modal"
                    @click.prevent="close"
                ></button>
            </div>
            <div class="modal-body">
                <slot name="body">
                    <p v-html="text"></p>
                </slot>
            </div>
            <div class="modal-footer">
                <slot name="footer">
                    <button 
                        type="button" 
                        class="btn btn-light waves-effect"
                        data-bs-dismiss="modal"
                        @click.prevent="close"
                    >{{closeText}}</button>
                    <button 
                        type="button"
                        class="btn btn-primary waves-effect waves-light"
                        @click.prevent="confirm"
                    >{{confirmText}}</button>
                </slot>
            </div>
        </div>
    </div>
</div>
</template>
<script>
export default {
    name: 'Modal',
    props: {
        id: String,
        title: String,
        text: String,
        closeText: String,
        confirmText: String,
        size: {
            type: String,
            default: ''
        },
    },
    methods:{
        confirm(){
            this.$emit("confirm")
        },
        close(){
            this.$emit("close")
        }
    }
}
</script>