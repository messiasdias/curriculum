<template>
<!-- start .right-->
<div class="right">
    <div class="img-content"><img alt="Foto Messias"  :src="euImage"></div>

    <div class="item">
        <h1>{{metadados.nome_completo}}</h1> 
    </div>

    <div class="item" >
        <h3><fontawesome icon="graduation-cap" /> Formação</h3>
        <p v-for="(formacao, id) in formacoes" :key="id" >
            {{formacao.nivel_de_ensino}} em {{formacao.curso}} - {{formacao.instituicao}} | 
            <small> {{formacao.periodo_inicio}}-{{formacao.periodo_final}} 
            <template v-if="formacao.situacao">({{formacao.situacao}})</template></small>
        </p>
    </div>

    <div class="item" >
        <h3><fontawesome :icon="['fab', 'leanpub']"/>Conhecimentos</h3>
        <ul>
            <li v-for="(conhecimento, id) in conhecimentos" :key="id">
                {{conhecimento.titulo}}
                <p>{{conhecimento.descricao}}</p>
            </li>
        </ul>              
    </div>

    <div class="item" >
        <h3 class="no-print"><fontawesome icon="briefcase" /> Experiências Anteriores</h3>
        <ul class="experiencias">
            <div v-for="(xp, i) in experiencias" :key="i" :class="{'no-print': i > 0}" > 
                <li v-if="(!viewMoreExp && i <= 2)|| viewMoreExp">
                    <h4>{{xp.empresa.toUpperCase()}}</h4>
                    <h5>{{xp.cargo}} | {{xp.periodo_inicio}} - {{xp.periodo_final}} | {{xp.modalidade}} </h5>
                    <p v-for="(descricao, d) in xp.descricao" :key="d">{{descricao}}</p>
                </li>
            </div>
            <button class="view-all-btn no-print" @click.prevent="toggleViewMoreExp()" > {{!viewMoreExp ? 'Ver Mais &plus;' : 'Ver menos &minus;'}}</button>
        </ul>
        <small class="no-screen">Para mais acesse:<br/> <b>{{baseUrl}}</b></small>            
    </div>

    <div class="item" >
        <h3><fontawesome icon="dollar-sign" />Pretensão Salarial</h3>
        <p>{{metadados.pretencao_salarial}}</p>
    </div> 

    <div class="item" >
        <h3><fontawesome icon="bullseye" />Objetivo</h3>
        <p>{{metadados.objetivo}}</p>
    </div>
</div>
<!-- end .right-->
</template>
<script>
import {mapState} from 'vuex'
 export default{
    name : "Right",
    computed: {
       ...mapState({
           euImage: state => state.euImage,
           experiencias: state => state.experiencias,
           formacoes: state => state.formacoes,
           conhecimentos: state => state.conhecimentos,
           metadados: state => state.metadados
       }),
       baseUrl: () => process.env.VUE_APP_BASE_URL.replace('http://', '').replace('https://', '') || ""
    },
    data() {
        return {
            viewMoreExp: false
        }
    },  
    methods: {
        toggleViewMoreExp() {
            this.viewMoreExp = !this.viewMoreExp
        }
    }
 }   
</script>