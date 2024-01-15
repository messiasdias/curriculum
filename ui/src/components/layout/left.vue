<template>
<!-- start .left-->
<div class="left">
    
    <div class="img-content"><img alt="Foto Messias"  :src="euImage"></div>
               
    <div class="item" >
        <h3><fontawesome class="icon" icon="address-book" /> Contatos</h3>
        <p class="link" :v-if="metadados.wp_phone" ><a rel="noopener"  target="_blank" :href="wp_link"> {{metadados.wp_phone_text || metadados.wp_phone}} <fontawesome icon="mobile-alt" /> </a></p>
        <p class="link" :v-if="metadados.email" ><a rel="noopener"  target="_blank" @click="mailTo()">{{metadados.email}}<fontawesome icon="at" /></a></p>
    </div>

    <div class="item" >
        <h3><fontawesome class="icon" icon="network-wired" /> Social</h3>
        <sociallink 
            v-for="rede in redes_sociais" 
            :key="`link-${rede.id}`" 
            :provider="rede.provider"
            :username="rede.username"
            :descricao="rede.descricao"
            :extra="rede.extra"
        />
    </div>

    <div class="item" >
        <h3><fontawesome class="icon" icon="code-branch" /> Code Repositórios</h3>
        <sociallink 
            v-for="repositorio in repositorios" 
            :key="`link-${repositorio.id}`" 
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
import link from './social/link'

 export default{
    name : "Left",
    components: {'sociallink': link},
    computed: {
       ...mapState({
           euImage: state => state.euImage,
           wp_link: state => state.wp_link,
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
    }
 }   
</script>