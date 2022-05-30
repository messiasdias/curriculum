<template>
<div class="card-body" style="min-height: 50vh;">
    <div class="d-flex mb-4">
        <img class="me-3 rounded-circle avatar-sm" :src="`${assets}admin/images/users/avatar-2.jpg`"
            alt="Generic placeholder image">
        <div class="flex-1">
            <h5 class="font-size-14 my-1">{{message.name}}</h5>
            <small class="text-muted">{{message.email}}</small>
        </div>
    </div>

    <h4 class="mt-0 font-size-16">{{message.subject}}</h4>
    <p>{{message.message}}</p>
</div>
</template>
<script>
export default {
    name: "Message",
    props: {
        message: {
            type: Object,
            default: () => {
                return {
                    name: null,
                    email: null,
                    subject: null,
                    message: null,
                    phone: null,
                    created_at: null,
                    status: null,
                    start: false,
                    archived: false,
                }
            }
        },
        statusList: {
            type: Object,
            default: () => null
        }
    },
    data(){
        return {
            assets: window.assets,
        }
    },
    mounted(){
        if (this.message.status === 'new') setTimeout(() => this.$emit('readed'), 6000)
    }
}
</script>