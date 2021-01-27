<template>

<!-- start .right-->
<div class="right">
    
    <div class="img-content"><img alt="Foto Messias"  :src="euImage"></div>

    <div class="item">
        <h1>Messias Wagner da Silva Dias</h1> 
    </div>

    <div class="item" >
            <h3><fontawesome icon="graduation-cap" /> Formação</h3>
            <p>Tecnólogo em Rede de Computadores | <small>2013-2014 (Interrompido)</small></p>
            <p>Técnico em Informática para a Internet | <small>2015-2016</small></p>
    </div>

    <div class="item" >
        <h3><fontawesome :icon="['fab', 'leanpub']"  /> Conhecimentos</h3>

        <ul>
            <li>Font-End
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
        <h3><fontawesome icon="briefcase" /> Experiências Anteriores</h3>
        <ul>
            <li>FUTURA DES. DE PROGRAMAS EIRELI - Desenvolvedor Front-End | <small>Jun/2020 - Jan/2021 </small>
                <p>Desenvolvimento de interfaces web com Vue.js e Materialize</p>
            </li>
            <li>SETEV - Analista de Suporte JR | <small>Fev/2018 - Set/2019 </small>
                <p>Administração de Servidores Linux Ubuntu/Debian</p> 
                <p>NovoSGA - Implantação do Sistema de Gerenciamento de Atendimento</p>
                <p>NovoSGA - Desenvolvimento Front-End de Painel de Atendimento exclusivo</p>
            </li>
        </ul>                 
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
             euImage: state => state.euImage 
         })
     }
 }   
</script>