(function(){"use strict";var t={7366:function(t,e,n){n(6992),n(8674),n(9601),n(7727);var o=n(144),i=n(629),s=n(7356),a=n(7810),r=n(8947),c=n(1436),u=n(1417);r.vI.add(u.vnX,c.IBq,c.nNP,c.YHc,c.NBC,c.wf8,c.m6i,c.A8,c.Mzg,c.FU$,c.scR,c.bJI,c.HXv,c.mh3,c.egO,c.hVn,c.kXW,c.Xf_);var l=a.GN,m=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{attrs:{id:"app"}},[n("div",{attrs:{id:"avatar"}}),n("div",{staticClass:"main"},[n("Left"),n("Right")],1),n("Buttons"),n("Msg")],1)},d=[],p=n(4648),f=(n(2222),function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"left"},[n("div",{staticClass:"img-content"},[n("img",{attrs:{alt:"Foto Messias",src:t.euImage}})]),n("div",{staticClass:"item"},[n("h3",[n("fontawesome",{staticClass:"icon",attrs:{icon:"address-book"}}),t._v(" Contatos")],1),n("p",{staticClass:"link",attrs:{"v-if":t.metadados.wp_phone}},[n("a",{attrs:{rel:"noopener",target:"_blank",href:t.wp_link}},[t._v(" "+t._s(t.metadados.wp_phone_text||t.metadados.wp_phone)+" "),n("fontawesome",{attrs:{icon:"mobile-alt"}})],1)]),n("p",{staticClass:"link",attrs:{"v-if":t.metadados.email}},[n("a",{attrs:{rel:"noopener",target:"_blank"},on:{click:function(e){return t.mailTo()}}},[t._v(t._s(t.metadados.email)),n("fontawesome",{attrs:{icon:"at"}})],1)])]),n("div",{staticClass:"item"},[n("h3",[n("fontawesome",{staticClass:"icon",attrs:{icon:"network-wired"}}),t._v(" Social")],1),t._l(t.redes_sociais,(function(t){return n("social-link",{key:"link-social-"+t.id,attrs:{provider:t.provider,username:t.username,descricao:t.descricao,extra:t.extra}})}))],2),n("div",{staticClass:"item"},[n("h3",[n("fontawesome",{staticClass:"icon",attrs:{icon:"code-branch"}}),t._v(" Code Repositórios")],1),t._l(t.repositorios,(function(t){return n("social-link",{key:"link-repositorio-"+t.id,attrs:{provider:t.provider,username:t.username,descricao:t.descricao}})}))],2),t.informacoes_extra.length?n("div",{staticClass:"item"},[n("h3",[n("fontawesome",{staticClass:"icon",attrs:{icon:"info"}}),t._v(" Informações Relevantes")],1),t._l(t.informacoes_extra,(function(e,o){return n("p",{key:o},[t._v(t._s(e))])}))],2):t._e(),n("div",{staticClass:"item"},[n("h3",[n("fontawesome",{staticClass:"icon",attrs:{icon:"code-branch"}}),t._v("Projetos Open-Source por diversão :)")],1),t._l(t.projetos,(function(e){return[n("p",{key:"projeto-"+e.id+"-noprint",staticClass:"link link-noprint"},[n("a",{attrs:{rel:"noopener",target:"_blank",href:e.link}},[t._v(t._s(e.nome)),n("fontawesome",{attrs:{icon:"link"}})],1)]),n("p",{key:"projeto-"+e.id+"-print",staticClass:"link-print"},[n("a",{attrs:{rel:"noopener",target:"_blank",href:e.link}},[t._v(t._s(e.link.replace("https://",""))),n("fontawesome",{attrs:{icon:"link"}})],1)])]}))],2)])}),v=[],h=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("p",{staticClass:"link"},[n("a",{attrs:{rel:"noopener",target:"_blank",href:t.linkWithHttps,title:t.descricao}},[t._v(" "+t._s(t.linkWithOutHttps)+" "),t.extra?n("small",[t._v(t._s(t.extra))]):t._e(),n("fontawesome",{attrs:{icon:"link"}})],1)])},g=[],_=(n(9254),n(4916),n(5306),{name:"social_link",props:{username:null,provider:null,descricao:null,link:null,extra:null},computed:{linkWithHttps:function(){return this.link?this.link:this[this.provider]()},linkWithOutHttps:function(){return this.linkWithHttps.replace("https://","").replace("www.","").replace("/videos","")}},methods:{linkedin:function(){return"https://linkedin.com/in/".concat(this.username)},youtube:function(){return"https://www.youtube.com/@".concat(this.username,"/videos")},facebook:function(){return"https://www.facebook.com/".concat(this.username)},github:function(){return"https://github.com/".concat(this.username)},bitbucket:function(){return"https://bitbucket.org/".concat(this.username)}}}),b=_,w=n(3736),k=(0,w.Z)(b,h,g,!1,null,null,null),x=k.exports,y={name:"Left",components:{"social-link":x},computed:(0,p.Z)({},(0,i.rn)({euImage:function(t){return t.euImage},wp_link:function(t){return t.wp_link},metadados:function(t){return t.metadados},redes_sociais:function(t){return t.redes_sociais},repositorios:function(t){return t.repositorios},projetos:function(t){return t.projetos},informacoes_extra:function(t){return t.informacoes_extra}})),methods:(0,p.Z)({},(0,i.nv)({mailTo:"mailTo"}))},C=y,j=(0,w.Z)(C,f,v,!1,null,null,null),I=j.exports,Z=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"right"},[n("div",{staticClass:"img-content"},[n("img",{attrs:{alt:"Foto Messias",src:t.euImage}})]),n("div",{staticClass:"item"},[n("h1",[t._v(t._s(t.metadados.nome_completo))])]),n("div",{staticClass:"item"},[n("h3",[n("fontawesome",{attrs:{icon:"graduation-cap"}}),t._v(" Formação")],1),t._l(t.formacoes,(function(e,o){return n("p",{key:o},[t._v(" "+t._s(e.nivel_de_ensino)+" em "+t._s(e.curso)+" - "+t._s(e.instituicao)+" | "),n("small",[t._v(" "+t._s(e.periodo_inicio)+"-"+t._s(e.periodo_final)+" "),e.situacao?[t._v("("+t._s(e.situacao)+")")]:t._e()],2)])}))],2),n("div",{staticClass:"item"},[n("h3",[n("fontawesome",{attrs:{icon:["fab","leanpub"]}}),t._v("Conhecimentos")],1),n("ul",t._l(t.conhecimentos,(function(e,o){return n("li",{key:o},[t._v(" "+t._s(e.titulo)+" "),n("p",[t._v(t._s(e.descricao))])])})),0)]),n("div",{staticClass:"item"},[n("h3",{staticClass:"no-print"},[n("fontawesome",{attrs:{icon:"briefcase"}}),t._v(" Experiências Anteriores")],1),n("ul",{staticClass:"experiencias"},t._l(t.experiencias,(function(e,o){return n("li",{key:o,class:{"no-print":o>0}},[n("h4",[t._v(t._s(e.empresa.toUpperCase()))]),n("h5",[t._v(t._s(e.cargo)+" | "+t._s(e.periodo_inicio)+" - "+t._s(e.periodo_final))]),t._l(e.descricao,(function(e,o){return n("p",{key:o},[t._v(t._s(e))])}))],2)})),0),n("small",{staticClass:"no-screen"},[t._v("Para mais acesse:"),n("br"),t._v(" "),n("b",[t._v(t._s(t.baseUrl))])])]),n("div",{staticClass:"item"},[n("h3",[n("fontawesome",{attrs:{icon:"dollar-sign"}}),t._v("Pretenção Salarial")],1),n("p",[t._v(t._s(t.metadados.pretencao_salarial))])]),n("div",{staticClass:"item"},[n("h3",[n("fontawesome",{attrs:{icon:"bullseye"}}),t._v("Objetivo")],1),n("p",[t._v(t._s(t.metadados.objetivo))])])])},M=[],S={name:"Right",computed:(0,p.Z)((0,p.Z)({},(0,i.rn)({euImage:function(t){return t.euImage},experiencias:function(t){return t.experiencias},formacoes:function(t){return t.formacoes},conhecimentos:function(t){return t.conhecimentos},metadados:function(t){return t.metadados}})),{},{baseUrl:function(){return"https://messiasdias.github.io/curriculum".replace("http://","").replace("https://","")||0}})},O=S,T=(0,w.Z)(O,Z,M,!1,null,null,null),P=T.exports,W=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"btn btn-fixed-lg"},[n("div",{attrs:{"v-if":t.btn,id:"print",title:"Imprimir"},on:{click:function(e){return t.printDoc()}}},[n("fontawesome",{attrs:{icon:"print"}})],1),n("div",{attrs:{"v-if":t.metadados.email,id:"email",title:"Email"},on:{click:function(e){return t.mailTo()}}},[n("fontawesome",{attrs:{icon:"envelope"}})],1),n("a",{attrs:{"v-if":t.metadados.wp_phone,id:"whatsapp",title:"Whatsapp",rel:"noopener",target:"_blank",href:t.wp_link}},[n("fontawesome",{attrs:{icon:["fab","whatsapp"]}})],1)])},B=[],N={name:"Buttons",computed:(0,p.Z)({},(0,i.rn)({msg:function(t){return t.msg},btn:function(t){return t.btn},metadados:function(t){return t.metadados},wp_link:function(t){return t.wp_link}})),methods:(0,p.Z)((0,p.Z)({},(0,i.OI)({btnMut:"btn"})),(0,i.nv)({printDoc:"printDoc",mailTo:"mailTo"}))},E=N,H=(0,w.Z)(E,W,B,!1,null,null,null),R=H.exports,$=function(){var t=this,e=t.$createElement,n=t._self._c||e;return t.msg?n("div",{staticClass:"msg"},[n("div",{staticClass:"content",attrs:{draggable:""}},[n("fontawesome",{attrs:{icon:"times",alt:"Close",id:"close"},on:{click:function(e){return t.toggleMsg()}}}),n("span",{}),n("div",{staticClass:"box"},[t.typed.position?n("fontawesome",{attrs:{icon:[t.typed.iconPrefix,t.typed.iconName],id:t.typed.iconName}}):t._e(),n("p",{staticClass:"typed",attrs:{id:"typed"}},[t._v("...")])],1),n("img",{attrs:{src:t.euImage,alt:""}})],1)]):t._e()},D=[],V={name:"Msg",computed:(0,p.Z)({},(0,i.rn)({msg:function(t){return t.msg},euImage:function(t){return t.euImage},typed:function(t){return t.metadados.typed}})),methods:(0,p.Z)({},(0,i.nv)({toggleMsg:"toggleMsg"}))},F=V,L=(0,w.Z)(F,$,D,!1,null,null,null),U=L.exports,X={name:"Curriculum",computed:(0,p.Z)({},(0,i.rn)({msg:function(t){return t.msg},euImage:function(t){return t.euImage},euNome:function(t){return t.metadados.nome_curto},euNomeCompleto:function(t){return t.metadados.nome_completo}})),components:{Left:I,Right:P,Buttons:R,Msg:U},metaInfo:{title:"Messias Dias",titleTemplate:"%s | Curriculum Vitae",htmlAttrs:{lang:"pt-Br",amp:!0},meta:[{charset:"utf-8"},{vmid:"description",name:"description",content:"Meu Curriculum Vitae Versão Web. Construido com Vue.js, Html5 e Css3/Sass."},{vmid:"keywords",name:"keywords",content:"curriculum,vitae,web,html,html5,css,css3,Sass,vuejs,vue.js,Vue,vue,Vue.js,desenvolvedor,dev,developer,front-end,back-end,front,back,end,formação,formacao,conhecimentos,pretençõa salarial,objetivo,contatos,social,repositórios,git"},{name:"viewport",content:"width=device-width,initial-scale=1"},{name:"robots",content:"index, follow"},{name:"theme-color",content:"#055ab4"},{property:"og:title",content:"Home",template:function(t){return"".concat(t," - ").concat("Messias Dias"," | Curriculum Vitae'")},vmid:"og:title"}],link:[{rel:"manifest",href:"manifest.webmanifest"},{rel:"favicon",href:"favicon.ico"},{rel:"apple-touch-icon",href:"img/icons/icon-192x192.png"}]},mounted:function(){this.$store.dispatch("loadData")}},A=X,z=(0,w.Z)(A,m,d,!1,null,null,null),q=z.exports,G=n(6835),J=n(8534),Y=(n(3123),n(3614)),K=n.n(Y),Q=n(5121),tt=n.p+"img/eu.e6e57fd0.png",et="https://messiasdias.github.io/curriculum/api",nt={euImage:tt,msg:!1,cookieMsg:!!localStorage.getItem("msg"),experiencias:[],formacoes:[],conhecimentos:[],redes_sociais:[],repositorios:[],projetos:[],informacoes_extra:[],metadados:{},wp_link:null},ot={msg:function(t){var e=arguments.length>1&&void 0!==arguments[1]&&arguments[1];if(t.msg|0==e)return localStorage.removeItem("msg"),t.msg=!1;t.msg=!0},cookieMsg:function(t){var e=!(arguments.length>1&&void 0!==arguments[1])||arguments[1];if(t.cookieMsg=e,e)return localStorage.setItem("msg",e);localStorage.removeItem("msg")},experiencias:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:[];t.experiencias=e},formacoes:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:[];t.formacoes=e},conhecimentos:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:[];t.conhecimentos=e},redes_sociais:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:[];t.redes_sociais=e},repositorios:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:[];t.repositorios=e},projetos:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:[];t.projetos=e},informacoes_extra:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:[];t.informacoes_extra=e},metadados:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};t.metadados=e,null!==e&&void 0!==e&&e.wp_phone&&(t.wp_link="https://api.whatsapp.com/send?phone=".concat(t.metadados.wp_phone,"&text=").concat(encodeURI(t.metadados.wp_message)))}},it={toggleMsg:function(){var t=(0,J.Z)((0,G.Z)().mark((function t(e){return(0,G.Z)().wrap((function(t){while(1)switch(t.prev=t.next){case 0:if(!e.state.msg){t.next=4;break}return e.commit("msg",!1),e.state.cookieMsg||e.commit("cookieMsg"),t.abrupt("return");case 4:if(e.state.cookieMsg){t.next=8;break}return t.next=7,e.commit("msg",!0);case 7:e.dispatch("typedRun");case 8:case"end":return t.stop()}}),t)})));function e(e){return t.apply(this,arguments)}return e}(),printDoc:function(t){t.dispatch("toggleMsg",!1),window.print()},mailTo:function(t){var e=t.state;return window.location.href="mailto:".concat(e.metadados.email)},typedRun:function(t){if(t.state.msg){t.state.metadados.typed.current=new(K())("#typed",{strings:t.state.metadados.typed.strings,typeSpeed:80,backSpeed:40,loop:!0,showCursor:!1,contentType:"html"});var e=setInterval((function(){if(t.state.msg)return t.dispatch("typedSetIcon",t.state.metadados.typed.current.arrayPos);clearInterval(e),t.dispatch("typedSetIcon",localStorage.removeItem("msg"))}),100)}},typedSetIcon:function(t){var e=arguments.length>1&&void 0!==arguments[1]&&arguments[1];if(t.state.metadados.typed.icons[e])return t.state.metadados.typed.position=e,t.state.iconPrefix="fas",2===t.state.metadados.typed.icons[e].split(":").length?(t.state.metadados.typed.iconPrefix=t.state.metadados.typed.icons[e].split(":")[0],void(t.state.metadados.typed.iconName=t.state.metadados.typed.icons[e].split(":")[1])):void(t.state.metadados.typed.iconName=t.state.metadados.typed.icons[e]);t.state.metadados.typed.position=!1,t.state.iconPrefix=!1,t.state.iconName=!1},experiencias:function(t){Q.Z.get("".concat(et,"/experiencias.json")).then((function(e){var n=e.data;return t.commit("experiencias",n)})).catch((function(){return t.commit("experiencias")}))},formacoes:function(t){Q.Z.get("".concat(et,"/formacoes.json")).then((function(e){var n=e.data;return t.commit("formacoes",n)})).catch((function(){return t.commit("formacoes")}))},conhecimentos:function(t){Q.Z.get("".concat(et,"/conhecimentos.json")).then((function(e){var n=e.data;return t.commit("conhecimentos",n)})).catch((function(){return t.commit("conhecimentos")}))},redes_sociais:function(t){Q.Z.get("".concat(et,"/redes_sociais.json")).then((function(e){var n=e.data;return t.commit("redes_sociais",n)})).catch((function(){return t.commit("redes_sociais")}))},repositorios:function(t){Q.Z.get("".concat(et,"/repositorios.json")).then((function(e){var n=e.data;return t.commit("repositorios",n)})).catch((function(){return t.commit("repositorios")}))},projetos:function(t){Q.Z.get("".concat(et,"/projetos.json")).then((function(e){var n=e.data;return t.commit("projetos",n)})).catch((function(){return t.commit("projetos")}))},informacoes_extra:function(t){Q.Z.get("".concat(et,"/informacoes_extra.json")).then((function(e){var n=e.data;return t.commit("informacoes_extra",n)})).catch((function(){return t.commit("informacoes_extra")}))},metadados:function(t){Q.Z.get("".concat(et,"/metadados.json")).then((function(e){var n=e.data;return t.commit("metadados",n)})).catch((function(){return t.commit("metadados")}))},loadData:function(){var t=(0,J.Z)((0,G.Z)().mark((function t(e){return(0,G.Z)().wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,e.dispatch("metadados");case 2:e.dispatch("experiencias"),e.dispatch("formacoes"),e.dispatch("conhecimentos"),e.dispatch("redes_sociais"),e.dispatch("projetos"),e.dispatch("repositorios"),e.dispatch("informacoes_extra"),setTimeout((function(){return e.dispatch("toggleMsg")}),3e3);case 10:case"end":return t.stop()}}),t)})));function e(e){return t.apply(this,arguments)}return e}()},st={state:nt,mutations:ot,actions:it},at=n(9755),rt=n.n(at),ct={large:1024,medium:786,small:468},ut={scroolIsSml:function(t){return rt()(document).scrollTop()<t},scroolIsBig:function(t){return rt()(document).scrollTop()>=t},isSmall:function(){return window.innerWidth<ct.medium},isMedium:function(){return window.innerWidth>=ct.medium&&window.innerWidth<ct.large},isLarge:function(){return window.innerWidth>=ct.large},avatar:function(){ut.isSmall()&&ut.scroolIsBig(200)&&ut.scroolIsSml(rt()(".right").height())?rt()("#avatar").is(":visible")||(rt()("#avatar").html(rt()(".right>.img-content").html()),rt()("#avatar").show()):rt()("#avatar").hide()},btn:function(){ut.isSmall()&&(ut.scroolIsBig(800)|ut.scroolIsBig(rt()(".right").height())?(rt()(".btn").removeClass("btn-fixed-lg"),rt()(".btn").removeClass("btn-fixed-md"),rt()(".btn").addClass("btn-relative")):(rt()(".btn").removeClass("btn-fixed-lg"),rt()(".btn").removeClass("btn-relative"),rt()(".btn").addClass("btn-fixed-md"))),ut.isMedium()&&(rt()(".btn").addClass("btn-fixed-lg"),ut.scroolIsSml(200)&&(rt()(".btn").removeClass("btn-relative"),rt()(".btn").removeClass("btn-fixed-md"))),ut.isLarge()&&(rt()(".btn").removeClass("btn-fixed-md"),rt()(".btn").removeClass("btn-relative"),rt()(".btn").addClass("btn-fixed-lg"))}};rt()(document).ready((function(){setTimeout((function(){rt()(this).scrollTop(0)}),10),ut.btn(),ut.avatar()})),rt()(document).scroll((function(){ut.avatar(),ut.btn()})),rt()(window).resize((function(){ut.avatar(),ut.btn()}));o.Z.use(i.ZP),o.Z.use(s.Z),o.Z.component("fontawesome",l),new o.Z({store:new i.ZP.Store(st),render:function(t){return t(q)}}).$mount("#app")}},e={};function n(o){var i=e[o];if(void 0!==i)return i.exports;var s=e[o]={exports:{}};return t[o].call(s.exports,s,s.exports,n),s.exports}n.m=t,function(){var t=[];n.O=function(e,o,i,s){if(!o){var a=1/0;for(l=0;l<t.length;l++){o=t[l][0],i=t[l][1],s=t[l][2];for(var r=!0,c=0;c<o.length;c++)(!1&s||a>=s)&&Object.keys(n.O).every((function(t){return n.O[t](o[c])}))?o.splice(c--,1):(r=!1,s<a&&(a=s));if(r){t.splice(l--,1);var u=i();void 0!==u&&(e=u)}}return e}s=s||0;for(var l=t.length;l>0&&t[l-1][2]>s;l--)t[l]=t[l-1];t[l]=[o,i,s]}}(),function(){n.n=function(t){var e=t&&t.__esModule?function(){return t["default"]}:function(){return t};return n.d(e,{a:e}),e}}(),function(){n.d=function(t,e){for(var o in e)n.o(e,o)&&!n.o(t,o)&&Object.defineProperty(t,o,{enumerable:!0,get:e[o]})}}(),function(){n.g=function(){if("object"===typeof globalThis)return globalThis;try{return this||new Function("return this")()}catch(t){if("object"===typeof window)return window}}()}(),function(){n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)}}(),function(){n.r=function(t){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})}}(),function(){n.p="/curriculum/"}(),function(){var t={143:0};n.O.j=function(e){return 0===t[e]};var e=function(e,o){var i,s,a=o[0],r=o[1],c=o[2],u=0;if(a.some((function(e){return 0!==t[e]}))){for(i in r)n.o(r,i)&&(n.m[i]=r[i]);if(c)var l=c(n)}for(e&&e(o);u<a.length;u++)s=a[u],n.o(t,s)&&t[s]&&t[s][0](),t[s]=0;return n.O(l)},o=self["webpackChunkui"]=self["webpackChunkui"]||[];o.forEach(e.bind(null,0)),o.push=e.bind(null,o.push.bind(o))}();var o=n.O(void 0,[998],(function(){return n(7366)}));o=n.O(o)})();
//# sourceMappingURL=app-legacy.1c5e82f9.js.map