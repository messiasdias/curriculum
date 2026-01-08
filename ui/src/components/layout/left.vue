<template>
<!-- start .left-->
<div class="left">
    
    <div class="img-content"><img :src="euImage"></div>
               
    <div class="item" >
        <h3><fontawesome class="icon" icon="address-book" /> Contatos</h3>
        <p class="link" v-if="metadados.wp_phone" ><a rel="noopener"  target="_blank" :href="getWpLink(metadados.wp_phone, metadados.wp_message)"> {{metadados.wp_phone}} <fontawesome :icon="['fab', 'whatsapp']"  /> </a></p>
        <p class="link" v-if="metadados.wp_phone2" ><a rel="noopener"  target="_blank" :href="getWpLink(metadados.wp_phone2, metadados.wp_message)"> {{metadados.wp_phone2}} <fontawesome :icon="['fab', 'whatsapp']"  /> </a></p>
        <p class="link" v-if="metadados.email" ><a rel="noopener"  target="_blank" @click="mailTo()">{{metadados.email}}<fontawesome icon="at" /></a></p>
    </div>

     <div class="item" v-if="metadados?.endereco" >
        <h3><fontawesome class="icon" icon="location-arrow" /> Endereço</h3>
        <p class="link" ><a rel="noopener"  target="_blank" @click="() => {}">{{metadados.endereco}}<fontawesome icon="search-location" /></a></p>
     </div>

    <div class="item" >
        <h3><fontawesome class="icon" icon="network-wired" /> Social</h3>
        <social-link 
            v-for="rede in redes_sociais" 
            :key="`link-social-${rede.id}`" 
            :provider="rede.provider"
            :username="rede.username"
            :descricao="rede.descricao"
            :extra="rede.extra"
        />
    </div>

    <div class="item" >
        <h3><fontawesome class="icon" icon="code-branch" /> Code Repositórios</h3>
        <social-link 
            v-for="repositorio in repositorios" 
            :key="`link-repositorio-${repositorio.id}`" 
            :provider="repositorio.provider"
            :username="repositorio.username"
            :descricao="repositorio.descricao"
        />
    </div>

    <div v-if="informacoes_extra.length"  class="item" >
        <h3><fontawesome class="icon" icon="info" /> Informações Relevantes</h3>
        <p v-for="(informacao, id) in informacoes_extra" :key="id">{{informacao}}</p> 
    </div>

    <div class="item" > 
        <h3><fontawesome class="icon" icon="code-branch" />Projetos Open-Source por diversão :)</h3>
        <template v-for="projeto in projetos" >
            <p :key="`projeto-${projeto.id}-noprint`" class="link link-noprint" ><a rel="noopener"  target="_blank" :href="projeto.link">{{projeto.nome}}<fontawesome icon="link" /></a></p>
            <p :key="`projeto-${projeto.id}-print`" class="link-print" ><a rel="noopener"  target="_blank" :href="projeto.link">{{projeto.link.replace('https://', '')}}<fontawesome icon="link" /></a></p>
        </template>
    </div>

</div>
<!-- end .left-->
</template>
<script>
import {mapState, mapActions} from 'vuex'
import socialLink from './social-link'

 export default{
    name : "Left",
    components: {'social-link': socialLink},
    computed: {
        ...mapState({
           euImage: state => state.euImage,
           metadados: state => state.metadados,
           redes_sociais: state => state.redes_sociais,
           repositorios: state => state.repositorios,
           projetos: state => state.projetos,
           informacoes_extra: state => state.informacoes_extra,
        })
    },
    methods: {
        ...mapActions({
           mailTo: 'mailTo'
        }),
        getWpLink(phone = "", message = "") {
            let wp_phone = phone
                    .replaceAll('(', '')
                    .replaceAll(')', '')
                    .replaceAll(' ', '')
                    .trim()

            return `https://api.whatsapp.com/send?phone=55${wp_phone}&text=${encodeURI(message)}`
        }
    }
 }   
</script>