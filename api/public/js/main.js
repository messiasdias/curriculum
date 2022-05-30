/* =================================
------------------------------------
	Labs - Design Studio
	Version: 1.0
 ------------------------------------ 
 ====================================*/

'use strict';

/*------------------
	Preloder
--------------------*/
function loader() {
	$(window).on('load', function() { 
		$(".loader").fadeOut(); 
		$("#preloder").delay(400).fadeOut("slow");
	});
}



/*------------------
	Navigation
--------------------*/
function responsive() {
	// Responsive 
	$('.responsive').on('click', function(event) {
		$('.menu-list').toggleClass('menuOpen');
		event.preventDefault();
	});
}


/*------------------
	Video Popup
--------------------*/
function videoPopup() {
	$('.video-popup').magnificPopup({
		type: 'iframe',
		autoplay : true
	});
}



/*------------------
	Testimonial
--------------------*/
function testimonial() {
	// testimonial Carousel 
	$('#testimonial-slide').owlCarousel({
		loop:true,
		autoplay:true,
		margin:30,
		nav:false,
		dots: true,
		responsive:{
			0:{
				items:1
			},
			600:{
				items:2
			},
			800:{
				items:2
			},
			1000:{
				items:2
			}
		}
	});
}



/*------------------
	Progress bar
--------------------*/
function progressbar() {

	$('.progress-bar-style').each(function() {
		var progress = $(this).data("progress");
		var prog_width = progress + '%';
		if (progress <= 100) {
			$(this).append('<div class="bar-inner" style="width:' + prog_width + '"><span>' + prog_width + '</span></div>');
		}
		else {
			$(this).append('<div class="bar-inner" style="width:100%"><span>' + prog_width + '</span></div>');
		}
	});
}



/*------------------
	Accordions
--------------------*/
function accordions() {
	$('.panel').on('click', function (e) {
		$('.panel').removeClass('active');
		var $this = $(this);
		if (!$this.hasClass('active')) {
			$this.addClass('active');
		}
		e.preventDefault();
	});
}


/*------------------
	Progress Circle
--------------------*/
function progressCircle() {
	//Set progress circle 1
	$("#progress1").circleProgress({
		value: 0.75,
		size: 175,
		thickness: 5,
		fill: "#2be6ab",
		emptyFill: "rgba(0, 0, 0, 0)"
	});
	//Set progress circle 2
	$("#progress2").circleProgress({
		value: 0.83,
		size: 175,
		thickness: 5,
		fill: "#2be6ab",
		emptyFill: "rgba(0, 0, 0, 0)"
	});
	//Set progress circle 3
	$("#progress3").circleProgress({
		value: 0.25,
		size: 175,
		thickness: 5,
		fill: "#2be6ab",
		emptyFill: "rgba(0, 0, 0, 0)"
	});
	//Set progress circle 4
	$("#progress4").circleProgress({
		value: 0.95,
		size: 175,
		thickness: 5,
		fill: "#2be6ab",
		emptyFill: "rgba(0, 0, 0, 0)"
	});

}

function mainInit(){
	loader();
	responsive();
	testimonial();
	progressbar();
	videoPopup();
	accordions();
	progressCircle();
}

(function($) {
	// Call all functions
	mainInit()
	setTimeout(() => mainInit(), 30)
})(jQuery);