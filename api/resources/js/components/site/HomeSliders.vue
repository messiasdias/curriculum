<template>
  <div class="hero-section">
    <div v-show="sliders.length > 0" id="hero-slider" class="owl-carousel">
      <div
        class="hero-item item"
        v-for="(slide, s) in sliders"
        :key="slide.id"
        :style="`background-image: url(${assets}${slide.image ? slide.image.url : ''})`"
      >
        <div
          class="hero-content"
          :class="{ style1: s % 2 != 0, style2: s % 2 == 0 }"
        >
          <div class="hero-center">
            <div 
              class="texto"
              v-html="`${slide.title}${slide.subtitle}`" 
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Axios from "axios";
export default {
  name: "HomeSliders",
  data() {
    return {
        assets: window.assets,
        sliders: [],
        time: 7,
	    progressBar: null,
	    bar: null, 
	    isPause: null, 
	    tick: null,
	    percentTime: null,
    };
  },
  mounted() {
    this.getSliders();
  },
  methods: {
	onInitialized(){    
		this.buildProgressBar();
		this.start();
	},
	buildProgressBar(){
		this.progressBar = $("<div>", {id:"progressBar"});
		this.bar = $("<div>", {id:"bar"});
		this.progressBar.prepend(this.bar).prependTo($("#hero-slider"));
	},
	start() {
		this.percentTime = 0;
		this.isPause = false;
		this.tick = setInterval(this.interval, 10);
	},
    interval(){
		if(this.isPause === false){
			this.percentTime += 1 / this.time;
			this.bar.css({width: this.percentTime+"%"});
			if(this.percentTime >= 100){
				$("#hero-slider").trigger("next.owl.carousel");
				this.percentTime = 0;
			}
		}
	},
	pauseOnDragging(){
		this.isPause = true;
	},
	moved(){
		clearTimeout(this.tick);
		this.start();
	},
    getSliders() {
      Axios.get(`${window.cmsApiBaseUrl}/sliders/broadcasting/slider`)
        .then(({ data }) => {
            this.sliders = data;

            setTimeout( () => {
                $('.hero-item').height($('body').height());

                $('#hero-slider').owlCarousel({
                    loop: true,
                    nav: true,
                    items: 1,
                    autoHeight: true,
                    animateOut: 'fadeOut',
                    animateIn: 'fadeIn',
                    navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                    onInitialized: this.onInitialized,
                    onTranslated: this.moved,
                    onDrag: this.pauseOnDragging
                });
            }, 10)

        })
        .catch(() => (this.sliders = []));
    },
  },
};
</script>