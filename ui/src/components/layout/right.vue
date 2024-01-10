<template>
<!-- start .right-->
<div class="right">
    <div class="img-content"><img alt="Foto Messias"  :src="euImage"></div>

    <div class="item">
        <h1>Messias Wagner da Silva Dias</h1> 
    </div>

    <div class="item" >
        <h3><fontawesome icon="graduation-cap" /> Formação</h3>
        <p>Análise e Desenvolvimento de Softwares - Universo | <small>2021-2023 (Interrompido)</small></p>
        <p>Tecnólogo em Rede de Computadores - IFPE | <small>2013-2014 (Interrompido)</small></p>
        <p>Técnico em Informática para a Internet - Faculdade Joaqui Nabuco | <small>2015-2016</small></p>
    </div>

    <div class="item" >
        <h3><fontawesome :icon="['fab', 'leanpub']"  /> Conhecimentos</h3>
        <ul>
            <li>Front-End
                <p>HTML, CSS com pré compilador Sass e Frameworks Bootstrap e Materialize, JavaScript e Frameworks como VueJs, React, e Next.JS</p>
            </li>
            <li>Back-End
                <p>PHP com Framework Laravel, Slim, Symfony e CMS Wordpress</p>
            </li>
            <li>Banco de Dados 
                <p>Mysql e MariaDB</p>
            </li>
            <li>Ferramentas
                <p>Git, Npm, Composer, Linux Ubuntu/Debian</p>
            </li>
        </ul>              
    </div>

    <div class="item" >
        <h3 class="no-print"><fontawesome icon="briefcase" /> Experiências Anteriores</h3>
        <ul class="experiencias">
            <li v-for="(xp, i) in experiencias" :key="i" :class="{'no-print': i > 0}" > 
                <h4>{{xp.empresa.toUpperCase()}}</h4>
                <h5>{{xp.cargo}} | <small>{{xp.periodo}}</small> </h5>
                <p v-for="(descricao, d) in xp.descricao" :key="d">{{descricao}}</p>
            </li>
        </ul>
        <small class="no-screen">Para mais acesse:<br/> <b>messiasdias.github.io/curriculum</b></small>            
    </div>

    <div class="item" >
        <h3><fontawesome icon="dollar-sign" /> Pretenção Salarial</h3>
        <p>A combinar, Compativel com o Cargo e Mercado.</p>
    </div> 

    <div class="item" >
        <h3><fontawesome icon="bullseye" /> Objetivo</h3>
        <p>
            Tenho como objetivo desempenhar com o máximo de qualidade, profissionalismo e comprometimento o cargo Desenvolvedor Web. <br>
        </p>
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
            experiencias: state => state.experiencias
        })
     }
 }   
</script>