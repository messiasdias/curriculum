<template>
    <Page :pageId="parseInt($route.params.pageId)" :user="user" />
</template>
<script>
import Page from './Page.vue'
export default {
    name: "Pages",
    components:{
        Page
    },
    props: {
        user: {
            type: Object,
            default : () => null
        }
    },
}
</script>