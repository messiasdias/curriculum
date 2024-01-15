<template>
    <p class="link" >
        <a 
            rel="noopener" 
            target="_blank" 
            :href="linkWithHttps"
            :title="descricao"
        > 
            {{linkWithOutHttps}} 
            <small v-if="extra">{{extra}}</small> 
            <fontawesome icon="link" />
        </a> 
    </p>
</template>
<script>
export default{
    name: 'social_link',
    props: {
        username: null,
        provider: null,
        descricao: null,
        link: null,
        extra: null
    },
    computed: {
        linkWithHttps(){
            if(this.link) return this.link 
            return this[this.provider]()
        },
        linkWithOutHttps(){
            return this.linkWithHttps
                .replace('https://', '')
                .replace('www.', '')
                .replace('/videos', '')
        }
    },
    methods: {
        linkedin() {
            return `https://linkedin.com/in/${this.username}`
        },
        youtube() {
            return `https://www.youtube.com/@${this.username}/videos`
        },
        facebook() {
            return `https://www.facebook.com/${this.username}`
        },
        github() {
            return `https://github.com/${this.username}`
        },
        bitbucket() {
            return `https://bitbucket.org/${this.username}`
        }
    }
}
</script>
