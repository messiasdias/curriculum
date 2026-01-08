<template>
  <!-- start .right-->
  <div class="right">
    <div class="img-content"><img alt="Foto Messias" :src="euImage" /></div>

    <div class="item">
      <h1>{{ metadados.nome_completo }}</h1>
    </div>

    <div class="item">
      <h3><fontawesome icon="graduation-cap" /> Formação</h3>
      <p v-for="(formacao, id) in formacoes" :key="id">
        {{ formacao.nivel_de_ensino }} em {{ formacao.curso }} -
        {{ formacao.instituicao }} |
        <small>
          {{ formacao.periodo_inicio }}-{{ formacao.periodo_final }}
          <template v-if="formacao.situacao"
            >({{ formacao.situacao }})</template
          ></small
        >
      </p>
    </div>

    <div class="item">
      <h3><fontawesome :icon="['fab', 'leanpub']" />Conhecimentos</h3>
      <ul>
        <li v-for="(conhecimento, id) in conhecimentos" :key="id">
          {{ conhecimento.titulo }}
          <p>{{ conhecimento.descricao }}</p>
        </li>
      </ul>
    </div>

    <div class="item">
      <h3 class="no-print">
        <fontawesome icon="briefcase" /> Experiências Anteriores
        <fontawesome 
          title="Filtrar áreas das experiências anteriores"
          @click="toggleXpsFilter" 
          class="no-print filter" 
          icon="filter" 
        />
      </h3>

      <div 
        v-if="showXpsFilter" 
        class="xps-filter"
      >
        <span 
          v-for="(tag, i) in allTags"
          @click="selectTag(tag)"
          :key="`tag-${i}`" 
          :class="`badge ${selectedTags.includes(tag) ? 'selected' : ''}`"
        >{{ tag }} </span>

        <button class="badge-btn" @click="parseTagsToUrl" >Filtrar</button>
      </div>

      <ul class="experiencias" id="exp">
        <div
          v-for="(xp, i) in experiencias?.filter(xp => filterTags(xp.tags))"
          :key="i"
          :class="{ 'no-print': i > 0 }"
         
        >
          <li
            v-if="
              ((!viewMoreExp && i <= viewCount) || viewMoreExp)
            "
          >
            <h4>{{ xp.empresa.toUpperCase() }}</h4>
            <h5>
              {{ xp.cargo }} | {{ xp.periodo_inicio }} -
              {{ xp.periodo_final }} | {{ xp.modalidade }}
            </h5>
            <p v-for="(descricao, d) in xp.descricao" :key="d">
              {{ descricao }}
            </p>
            <p class="no-print exp-tags">
              <b 
                v-for="(tag, i) in xp.tags"
                @click="() => {
                  selectTag(tag)
                  toggleXpsFilter(true)
                }"
                :key="`tag-${i}-xp-${xp.id}`" 
                :class="`no-print badge  ${selectedTags.includes(tag) ? 'selected' : ''}`"
                style="font-size: .55rem; margin-right: 2px;"
              >#{{ tag }}</b>
            </p>
          </li>
        </div>
        <button
          v-if="experiencias?.filter(xp => filterTags(xp.tags))?.length >= (viewCount + 1)"
          class="view-all-btn no-print"
          @click.prevent="toggleViewMoreExp()"
        >
          {{ !viewMoreExp ? "Ver Mais &plus;" : "Ver menos &minus;" }}
        </button>
      </ul>
      <small class="no-screen"
        >Para mais acesse:<br />
        <a :src="baseUrl" target="_blank">{{ baseUrl }}</a></small
      >
    </div>

    <div class="item">
      <h3><fontawesome icon="dollar-sign" />Pretensão Salarial</h3>
      <p>{{ metadados.pretencao_salarial }}</p>
    </div>

    <div class="item">
      <h3><fontawesome icon="bullseye" />Objetivo</h3>
      <p>{{ metadados.objetivo }}</p>
    </div>
  </div>
  <!-- end .right-->
</template>
<script>
import { mapState } from "vuex"
import query from "./../../assets/js/query"

export default {
  name: "Right",
  computed: {
    ...mapState({
      euImage: (state) => state.euImage,
      experiencias: (state) => state.experiencias,
      formacoes: (state) => state.formacoes,
      conhecimentos: (state) => state.conhecimentos,
      metadados: (state) => state.metadados,
    }),
    baseUrl: () => process.env.VUE_APP_BASE_URL.replace("http://", "").replace("https://", "") || "",
    allTags(){
      let tags = []
      this.experiencias?.map(xp => xp.tags)
        ?.forEach(tag => {tag.forEach(t => {if(!tags.includes(t)){tags.push(t)}})})
      return tags
    }
  },
  data() {
    return {
      viewCount: 2,
      viewMoreExp: false,
      showXpsFilter: false,
      selectedTags: JSON.parse(localStorage.getItem('selectedTags')) || [],
    }
  },
  methods: {
    toggleViewMoreExp() {this.viewMoreExp = !this.viewMoreExp;},
    toggleXpsFilter(open=null){this.showXpsFilter = open !== null ? open : !this.showXpsFilter},
    selectTag(tag){
      if (!this.selectedTags?.includes(tag)) {this.selectedTags.push(tag)} 
      else {this.selectedTags = this.selectedTags.filter(t => tag != t)}
      localStorage.setItem('selectedTags', JSON.stringify(this.selectedTags))
    },
    parseTagsToUrl() {
      let href = `${window.location.pathname}`
      if(this.selectedTags?.length) {href += `?tags=${this.selectedTags.join(',')}`}
      window.location.href = href
      this.showXpsFilter = false
    }, 
    filterTags: (tgs) => tgs?.length && query?.tags?.map(tg => tgs?.includes(tg))?.includes(true) || !query?.tags?.length,
    filterXps: (xps = []) => xps?.filter(xp => this.filterTags(xp.tags)) || [],
  }
};
</script>