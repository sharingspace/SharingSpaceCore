(function (window, document, $) {
	"use strict";
	
	$(window).on('load', function () {
		/* loader */
		$(".noo-spinner").fadeOut(500, function(){
			$(".noo-spinner").remove();
		});
	});
	
	/* On resize */
	$(window).on('resize', function () {
	});
	
	/* On scroll */
	$(window).on('scroll', function () {
		if ($(this).scrollTop() > 100) {
			$("#backtotop").addClass("show");
		} else {
			$("#backtotop").removeClass("show");
		}
	});
	
	$(document).ready(function($) {
							   
		//fullscreen
		introHeight();
		
		//Progress Bars
		ProgressBar();
		
		//scroll to top
		$('body').on('click', '#backtotop', function() {
			$("html, body").animate({
				scrollTop: 0
			}, 800);
			return false;
		});
		
		//popup video
		$('.popup-video').magnificPopup({
			type: 'iframe',
			iframe: {
				patterns: {
					youtube: {
						index: 'youtube.com/', 
						id: function(url) {        
							var m = url.match(/[\\?\\&]v=([^\\?\\&]+)/);
							if ( !m || !m[1] ) return null;
							return m[1];
						},
						src: '//www.youtube.com/embed/%id%?autoplay=1'
					},
					vimeo: {
						index: 'vimeo.com/', 
						id: function(url) {        
							var m = url.match(/(https?:\/\/)?(www.)?(player.)?vimeo.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/);
							if ( !m || !m[5] ) return null;
							return m[5];
						},
						src: '//player.vimeo.com/video/%id%?autoplay=1'
					}
				}
			}
		});
		
		//Gallery
		if ($(".gallery-item").length > 0) {
			$('.gallery-item').magnificPopup({
				gallery: {
					enabled: true
				}
			});
		}
		
		//rotate box background image
		$('.rotate-box.style-1').each(function() {
			if($(this).find(".front").attr("data-image") != "") {
				$(this).find(".front").css('background-image', 'url("' + $(this).find(".front").attr("data-image") + '")');	
			}
		});
		
		//Owl Carousel
		OwlCarousel();
		
		//Headroom Menu
		if($(".left-menu-content").length == 0) {
			$(".header").headroom();
		}
		
		//Main content margin bottom
		if($(".footer").length > 0) {
			var height = $(".footer").innerHeight();
			$("#main").css("margin-bottom", height);
		}
		
		//toggle mini cart
		$('#mini-cart').on('click', function() {
			$(this).toggleClass("open");
		});
		
		//search button
		$('.btn-open-popup-search').on('click',function(){
			$(this).toggleClass("show-search");
			$('.header-search').toggleClass("show-search");
			$('body').toggleClass('show-search');
		});
		//Toggle Search
		$('.search-close').on('click', function() {
			$('body').toggleClass('show-search');
		});
		
		//scroll to anchor
		$(".smooth-scroll-link").on('click', function(event) {

			// Make sure this.hash has a value before overriding default behavior
			if (this.hash !== "") {
			  // Prevent default anchor click behavior
			  event.preventDefault();
		
			  // Store hash
			  var hash = this.hash;
			  $('html, body').animate({
				scrollTop: $(hash).offset().top
			  }, 800, function(){
		   
				// Add hash (#) to URL when done scrolling (default click behavior)
				window.location.hash = hash;
			  });
			} // End if
		});
		
		//counter
		$( '.counter-item' ).each( function() {
			var $numbers = $(this).find('.number');
			var animation = $(this).data('animation') ? $(this).data('animation') : 'counterUp';
	
			if (animation === 'odometer') {
				var _number = $numbers.html();
				var od      = new Odometer({
					el   : $numbers[0],
					value: 0
				});
				od.render();
	
				$(this).waypoint(function() {
					od.update(_number);
				}, {
					offset     : '90%',
					triggerOnce: true
				});
			} else {
				$numbers.counterUp({
					delay: 10,
					time : 1000
				});
			}
		});
		
		/* Show Main Navigation for Header v4*/
		$("#page-open-main-menu").on('click', function () {
			$("#toggle-menu").toggleClass('open');
		});
		$("#hide-mainnav").on('click', function () {
			$("#toggle-menu").removeClass('open');
		});
		$('.cms-menu-toggle').on('click', function () {
			if($(this).prev().hasClass('submenu-open')) {
				$(this).prev().toggleClass('submenu-open');	
			} else {
				$('.sub-menu').removeClass('submenu-open');
				$(this).prev().toggleClass('submenu-open');
				$(this).parent('li').parent('.sub-menu').addClass('submenu-open');
			}
		});
		
		//Tab Process in tab mode
		$(".tab-process ul.nav-tabs li").on('click', function () {
			
		  $(".tab-process .tab-pane").hide();
		  var activeTab = $(this).children('a').attr("rel"); 
		  $("#"+activeTab).fadeIn();		
			
		  $(".tab-process ul.nav-tabs li").removeClass("active");
		  $(this).addClass("active");
	
		  $(".tab-pane-heading").removeClass("active");
		  $(".tab-pane-heading[rel^='"+activeTab+"']").addClass("active");
		  
		});
		
		//Tab Process in drawer mode
		$(".tab-pane-heading").on('click', function () {
			if(!$(this).hasClass("active")) {
				$('.tab-pane-heading').removeClass("active");
				$(this).addClass("active");
				$('.tab-pane').removeClass("show").slideUp(1000);
				var id = $(this).attr('rel');
				$('#' + id).addClass("show").slideDown(1000);
			}
		});
		
		//Toggle Accordion
		$(document).on('show.bs.collapse hide.bs.collapse', '.accordion', function(e) {
			var $target = $(e.target)
			if (e.type == 'show')
				$('.accordion-header').removeClass('active');
				$target.prev('.accordion-header').addClass('active');
			if (e.type == 'hide')
				$target.prev('.accordion-header').removeClass('active');
		});
		
		//fitvids
		if ($('.media').length > 0) $('.media').fitVids();
		
		//Typed Text
		if ($("#typed").length > 0) {
			$("#typed").typed({
				stringsElement: $("#typed-strings"),
				typeSpeed: 30,
				backDelay: 500,
				loop: true,
				contentType: "html", // or text
				loopCount: false,
				cursorChar: "|",
			});
		}
		
		//Presentation Slide
		if($("#presentation").length > 0) {
			preSlider();
		}
		
		/* split slider */
		if($('#multiScroll').length > 0) {
			$('#multiScroll').multiscroll({
				sectionsColor: [],
				menu: false,
				navigation: true,
				loopBottom: true,
				loopTop: true,
				navigationPosition: 'right',
			});
			$('#multiscroll-nav > ul > li ').each(function(index) {
				$(this).children('a').attr('href', 'javascript:void()');
			});
		}
		
		/* portfolio fullscreen slider center */
		if ($('.portfolio-fullscreen-slider-center').length > 0) {
			initPortfolioFullscreenCenterSlider();
		}
		
		/* background marque */
		marqueBackground();
		
		//Google Map
		googleMap();
		
		/* countdown */
		Countdown();
		
		//Toggle Mobile Menu
		$('.page-open-mobile-menu, .page-close-mobile-menu').on('click',function(){
			$('.page-mobile-main-menu').toggleClass('open');
		});
		$('.toggle-sub-menu').on('click',function(){
			if($(this).parent("a").next().hasClass('open')) {
				$(this).parent("a").next().toggleClass('open');
				$(this).toggleClass('open');
			} else {
				$('.sub-menu').removeClass('open');
				$(this).parent("a").next().toggleClass('open');
				$(this).parent("a").parent('li').parent('.sub-menu').addClass('open');
				
				$('.toggle-sub-menu').removeClass('open');
				$(this).parent('a').parent('li').parent('.sub-menu').siblings('a').children('.toggle-sub-menu').toggleClass('open');
				$(this).toggleClass('open');
			}
		});
		
		/* init revolution slider */
		if ($("#rev_slider").length > 0) {
			RevolutionInit();
		}
		if ($("#rev_slider_2").length > 0) {
			RevolutionInit2();
		}
		if ($("#rev_slider_3").length > 0) {
			RevolutionInit3();
		}
		if ($("#rev_slider_4").length > 0) {
			RevolutionInit4();
		}
		if ($("#rev_slider_5").length > 0) {
			RevolutionInit5();
		}
		if ($("#rev_slider_6").length > 0) {
			RevolutionInit6();
		}
	});

})(window, document, jQuery);


/*=================================================================
	owl carousel
===================================================================*/
function OwlCarousel() {
	//Testimonial Slider
	if ($(".testimonials-slider").length > 0) {
		$(".testimonials-slider").each(function() {
			var autoplay = ($(this).attr("data-auto-play") === "true") ? true : false;
			$(this).owlCarousel({
				items: $(this).attr("data-desktop"),
				loop: true,
				mouseDrag: true,
				navigation: false,
				dots: false,
				pagination: true,
				autoPlay: autoplay,
				autoplayTimeout: 5000,
				autoplayHoverPause: true,
				smartSpeed: 1000,
				autoplayHoverPause: true,
				transitionStyle : "backSlide",
				navigationText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
				itemsDesktop: [1199, $(this).attr("data-desktop")],
				itemsDesktopSmall: [1024, $(this).attr("data-laptop")],
				itemsTablet: [768, $(this).attr("data-tablet")],
				itemsMobile: [479, $(this).attr("data-mobile")]
			});
		});
	}
	if ($(".partner-slider").length > 0) {
		$(".partner-slider").each(function(){
			var autoplay = ($(this).attr("data-auto-play") === "true") ? true : false;
			$(this).owlCarousel({
				items: $(this).attr("data-desktop"),
				loop: true,
				mouseDrag: false,
				navigation: false,
				dots: false,
				pagination: false,
				autoPlay: autoplay,
				autoplayTimeout: 5000,
				autoplayHoverPause: true,
				smartSpeed: 1000,
				autoplayHoverPause: true,
				itemsDesktop: [1199, $(this).attr("data-desktop")],
				itemsDesktopSmall: [979, $(this).attr("data-laptop")],
				itemsTablet: [768, $(this).attr("data-tablet")],
				itemsMobile: [479, $(this).attr("data-mobile")]
			});
		});
	}
	if ($(".boxicon-slider").length > 0) {
		$(".boxicon-slider").each(function(){
			var autoplay = ($(this).attr("data-auto-play") === "true") ? true : false;
			$(this).owlCarousel({
				items: $(this).attr("data-desktop"),
				loop: true,
				mouseDrag: true,
				navigation: true,
				dots: false,
				pagination: false,
				autoPlay: autoplay,
				autoplayTimeout: 5000,
				autoplayHoverPause: true,
				smartSpeed: 1000,
				autoplayHoverPause: true,
				navigationText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
				itemsDesktop: [1199, $(this).attr("data-desktop")],
				itemsDesktopSmall: [979, $(this).attr("data-laptop")],
				itemsTablet: [768, $(this).attr("data-tablet")],
				itemsMobile: [479, $(this).attr("data-mobile")]
			});
		});
	}
	if ($(".boxicon-slider-2").length > 0) {
		$(".boxicon-slider-2").each(function(){
			var autoplay = ($(this).attr("data-auto-play") === "true") ? true : false;
			$(this).owlCarousel({
				items: $(this).attr("data-desktop"),
				loop: true,
				mouseDrag: true,
				navigation: false,
				dots: true,
				pagination: true,
				autoPlay: autoplay,
				autoplayTimeout: 5000,
				autoplayHoverPause: true,
				smartSpeed: 1000,
				autoplayHoverPause: true,
				itemsDesktop: [1199, $(this).attr("data-desktop")],
				itemsDesktopSmall: [979, $(this).attr("data-laptop")],
				itemsTablet: [768, $(this).attr("data-tablet")],
				itemsMobile: [479, $(this).attr("data-mobile")]
			});
		});
	}
	if ($(".image-slider").length > 0) {
		$(".image-slider").each(function(){
			var autoplay = ($(this).attr("data-auto-play") === "true") ? true : false;
			$(this).owlCarousel({
				items: $(this).attr("data-desktop"),
				loop: true,
				mouseDrag: false,
				navigation: true,
				dots: false,
				pagination: false,
				autoPlay: autoplay,
				autoplayTimeout: 5000,
				autoplayHoverPause: true,
				smartSpeed: 1000,
				autoplayHoverPause: true,
				navigationText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
				itemsDesktop: [1199, $(this).attr("data-desktop")],
				itemsDesktopSmall: [979, $(this).attr("data-laptop")],
				itemsTablet: [768, $(this).attr("data-tablet")],
				itemsMobile: [479, $(this).attr("data-mobile")]
			});
		});
	}
	if ($(".process-slider").length > 0) {
		$(".process-slider").each(function(){
			var autoplay = ($(this).attr("data-auto-play") === "true") ? true : false;
			$(this).owlCarousel({
				items: $(this).attr("data-desktop"),
				loop: true,
				mouseDrag: false,
				navigation: false,
				dots: false,
				pagination: true,
				autoPlay: autoplay,
				autoplayTimeout: 5000,
				autoplayHoverPause: true,
				smartSpeed: 1000,
				autoplayHoverPause: true,
				itemsDesktop: [1199, $(this).attr("data-desktop")],
				itemsDesktopSmall: [979, $(this).attr("data-laptop")],
				itemsTablet: [768, $(this).attr("data-tablet")],
				itemsMobile: [479, $(this).attr("data-mobile")]
			});
		});
	}
	if ($(".portfolio-slider").length > 0) {
		$(".portfolio-slider").each(function(){
			var autoplay = ($(this).attr("data-auto-play") === "true") ? true : false;
			$(this).owlCarousel({
				items: $(this).attr("data-desktop"),
				loop: true,
				mouseDrag: false,
				navigation: true,
				dots: false,
				pagination: false,
				autoPlay: autoplay,
				autoplayTimeout: 5000,
				autoplayHoverPause: true,
				smartSpeed: 1000,
				autoplayHoverPause: true,
				navigationText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
				itemsDesktop: [1199, $(this).attr("data-desktop")],
				itemsDesktopSmall: [979, $(this).attr("data-laptop")],
				itemsTablet: [768, $(this).attr("data-tablet")],
				itemsMobile: [479, $(this).attr("data-mobile")]
			});
		});
	}
	if ($(".team-slider").length > 0) {
		$(".team-slider").each(function(){
			var autoplay = ($(this).attr("data-auto-play") === "true") ? true : false;
			$(this).owlCarousel({
				items: $(this).attr("data-desktop"),
				loop: true,
				mouseDrag: false,
				navigation: true,
				dots: false,
				pagination: false,
				autoPlay: autoplay,
				autoplayTimeout: 5000,
				autoplayHoverPause: true,
				smartSpeed: 1000,
				autoplayHoverPause: true,
				navigationText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
				itemsDesktop: [1199, $(this).attr("data-desktop")],
				itemsDesktopSmall: [979, $(this).attr("data-laptop")],
				itemsTablet: [768, $(this).attr("data-tablet")],
				itemsMobile: [479, $(this).attr("data-mobile")]
			});
		});
	}
	if ($(".categories-slider").length > 0) {
		$(".categories-slider").each(function(){
			var autoplay = ($(this).attr("data-auto-play") === "true") ? true : false;
			$(this).owlCarousel({
				items: $(this).attr("data-desktop"),
				loop: true,
				mouseDrag: false,
				navigation: true,
				dots: false,
				pagination: false,
				autoPlay: autoplay,
				autoplayTimeout: 5000,
				autoplayHoverPause: true,
				smartSpeed: 1000,
				autoplayHoverPause: true,
				navigationText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
				itemsDesktop: [1199, $(this).attr("data-desktop")],
				itemsDesktopSmall: [979, $(this).attr("data-laptop")],
				itemsTablet: [768, $(this).attr("data-tablet")],
				itemsMobile: [479, $(this).attr("data-mobile")]
			});
		});
	}
	if ($(".blog-slider").length > 0) {
		$(".blog-slider").each(function(){
			var autoplay = ($(this).attr("data-auto-play") === "true") ? true : false;
			$(this).owlCarousel({
				items: $(this).attr("data-desktop"),
				loop: true,
				mouseDrag: true,
				navigation: false,
				dots: true,
				pagination: true,
				autoPlay: autoplay,
				autoplayTimeout: 5000,
				autoplayHoverPause: true,
				smartSpeed: 1000,
				autoplayHoverPause: true,
				itemsDesktop: [1199, $(this).attr("data-desktop")],
				itemsDesktopSmall: [979, $(this).attr("data-laptop")],
				itemsTablet: [768, $(this).attr("data-tablet")],
				itemsMobile: [479, $(this).attr("data-mobile")]
			});
		});
	}
	if ($('#product-detail-slider').length > 0) {
		$("#product-detail-slider").each(function(){
			var autoplay = ($(this).attr("data-auto-play") === "true") ? true : false;
			$(this).owlCarousel({
				items: $(this).attr("data-desktop"),
				loop: true,
				mouseDrag: false,
				navigation: true,
				dots: false,
				pagination: false,
				autoPlay: autoplay,
				autoplayTimeout: 5000,
				autoplayHoverPause: true,
				smartSpeed: 1000,
				autoplayHoverPause: true,
				navigationText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
				itemsDesktop: [1199, $(this).attr("data-desktop")],
				itemsDesktopSmall: [979, $(this).attr("data-laptop")],
				itemsTablet: [768, $(this).attr("data-tablet")],
				itemsMobile: [479, $(this).attr("data-mobile")]
			});
		});
		
		$('.item-img:first-child').addClass('t-active');

		$(".images").on("click", ".item-img", function(e) {
			e.preventDefault();
			$('.item-img').removeClass('t-active');
			$(this).addClass('t-active');
			var number = $('.item-img').index(this);
			$('#product-detail-slider').trigger("owl.goTo", number);
		});

		$('.owl-next').on("click", function() {
			$('.item-img').removeClass('t-active');
			var $index = $(".owl-item").index($(".active"));
			$('.item-img').eq($index).addClass('t-active');
		});

		$('.owl-prev').on("click", function() {
			$('.item-img').removeClass('t-active');
			var $index = $(".owl-item").index($(".active"));
			$('.item-img').eq($index).addClass('t-active');
		});
	}
}

/*=================================================================
	fullscreen
===================================================================*/
function introHeight() {
	var wh = $(window).height();
	$('.section-fullscreen').css({ height: wh });
	$('.fullheight').css({ height: wh });
}

/*=================================================================
	presentation slide
===================================================================*/
function preSlider() {
	var $container  = $('#presentation');
	$('#presentation').fullpage({
		sectionsColor: ['#fff', '#fff', '#1a237e', '#fff', '#fff'],
		anchors: ['section-introduction', 'section-about-us', 'section-our-services', 'section-our-projects', 'section-contact-us'],
		menu: '#presentation-menu',
		slidesNavigation: true,
		slidesToSections: true,
		responsiveWidth: 900,
		responsiveSlides: true,
		responsiveSlidesKey: 'YWx2YXJvdHJpZ28uY29tX3RoVWNtVnpjRzl1YzJsMlpWTnNhV1JsY3c9PUVZdg==',
		afterLoad : function( anchorLink, index ) {
			  var $currentRow = $container.children('.active');
			  var skin        = $currentRow.attr( 'data-skin' );
			  $('body').attr( 'data-row-skin', skin );
		  }
	});
}

/*=================================================================
	progressbar
===================================================================*/
function ProgressBar() {
	$('.group-progressbar').each(function() {
		var $this = $(this);
		var waypoint = $this.waypoint({
			handler: function(direction) {
				$this.find('.progressbar').progressbar({ display_text: 'center' });
			},
			offset: "80%"
		});
	});
}


/*=================================================================
	revolution slider function
===================================================================*/
function RevolutionInit() {
	$("#rev_slider").show().revolution({
		sliderType:"standard",
		jsFileLocation:"js/",
		sliderLayout:"fullwidth",
		dottedOverlay:"none",
		delay:9000,
		navigation: {
			onHoverStop:"off",
		},
		responsiveLevels:[1240,1024,778,480],
		visibilityLevels:[1240,1024,778,480],
		gridwidth:[1240,1024,778,480],
		gridheight:[1080,768,960,720],
		lazyType:"none",
		parallax: {
			type:"mouse",
			origo:"enterpoint",
			speed:400,
			speedbg:0,
			speedls:0,
			levels:[5,10,15,20,25,30,35,40,45,46,47,48,49,50,51,55],
			disable_onmobile:"on"
		},
		shadow:0,
		spinner:"spinner3",
		stopLoop:"off",
		stopAfterLoops:-1,
		stopAtSlide:-1,
		shuffle:"off",
		autoHeight:"off",
		disableProgressBar:"on",
		hideThumbsOnMobile:"off",
		hideSliderAtLimit:0,
		hideCaptionAtLimit:0,
		hideAllCaptionAtLilmit:0,
		debugMode:false,
		fallbacks: {
			simplifyAll:"off",
			nextSlideOnWindowFocus:"off",
			disableFocusListener:false,
		}
	});
}

function RevolutionInit2() {
	$("#rev_slider_2").show().revolution({
		sliderType:"standard",
		jsFileLocation:"js/",
		sliderLayout:"fullwidth",
		dottedOverlay:"none",
		delay:9000,
		navigation: {
			keyboardNavigation:"off",
			keyboard_direction: "horizontal",
			mouseScrollNavigation:"off",
						mouseScrollReverse:"default",
			onHoverStop:"off",
			arrows: {
				style:"uranus",
				enable:true,
				hide_onmobile:false,
				hide_onleave:true,
				hide_delay:200,
				hide_delay_mobile:1200,
				tmp:'',
				left: {
					h_align:"left",
					v_align:"center",
					h_offset:50,
					v_offset:0
				},
				right: {
					h_align:"right",
					v_align:"center",
					h_offset:50,
					v_offset:0
				}
			}
		},
		responsiveLevels:[1240,1024,778,480],
		visibilityLevels:[1240,1024,778,480],
		gridwidth:[1440,1024,778,480],
		gridheight:[1080,768,960,720],
		lazyType:"none",
		parallax: {
			type:"mouse",
			origo:"enterpoint",
			speed:400,
			speedbg:0,
			speedls:0,
			levels:[5,10,15,20,25,30,35,40,45,46,47,48,49,50,51,55],
			disable_onmobile:"on"
		},
		shadow:0,
		spinner:"spinner3",
		stopLoop:"off",
		stopAfterLoops:-1,
		stopAtSlide:-1,
		shuffle:"off",
		autoHeight:"off",
		disableProgressBar:"on",
		hideThumbsOnMobile:"off",
		hideSliderAtLimit:0,
		hideCaptionAtLimit:0,
		hideAllCaptionAtLilmit:0,
		debugMode:false,
		fallbacks: {
			simplifyAll:"off",
			nextSlideOnWindowFocus:"off",
			disableFocusListener:false,
		}
	});
}
function RevolutionInit3() {
	$("#rev_slider_3").show().revolution({
		sliderType:"standard",
		jsFileLocation:"js/",
		sliderLayout:"fullscreen",
		dottedOverlay:"none",
		delay:9000,
		navigation: {
			onHoverStop:"off",
		},
		responsiveLevels:[1240,1024,778,480],
		visibilityLevels:[1240,1024,778,480],
		gridwidth:[1440,1024,778,480],
		gridheight:[1080,768,960,720],
		lazyType:"none",
		shadow:0,
		spinner:"spinner3",
		stopLoop:"off",
		stopAfterLoops:-1,
		stopAtSlide:-1,
		shuffle:"off",
		autoHeight:"off",
		fullScreenAutoWidth:"off",
		fullScreenAlignForce:"off",
		fullScreenOffsetContainer: "",
		fullScreenOffset: "",
		disableProgressBar:"on",
		hideThumbsOnMobile:"off",
		hideSliderAtLimit:0,
		hideCaptionAtLimit:0,
		hideAllCaptionAtLilmit:0,
		debugMode:false,
		fallbacks: {
			simplifyAll:"off",
			nextSlideOnWindowFocus:"off",
			disableFocusListener:false,
		}
	});
}
function RevolutionInit4() {
	$("#rev_slider_4").show().revolution({
		sliderType:"standard",
		jsFileLocation:"js/",
		sliderLayout:"fullwidth",
		dottedOverlay:"none",
		delay:9000,
		navigation: {
			keyboardNavigation:"off",
			keyboard_direction: "horizontal",
			mouseScrollNavigation:"off",
						mouseScrollReverse:"default",
			onHoverStop:"off",
			arrows: {
				style:"uranus",
				enable:true,
				hide_onmobile:false,
				hide_onleave:true,
				hide_delay:200,
				hide_delay_mobile:1200,
				tmp:'',
				left: {
					h_align:"left",
					v_align:"center",
					h_offset:50,
					v_offset:0
				},
				right: {
					h_align:"right",
					v_align:"center",
					h_offset:50,
					v_offset:0
				}
			}
		},
		responsiveLevels:[1240,1024,778,480],
		visibilityLevels:[1240,1024,778,480],
		gridwidth:[1440,1024,778,480],
		gridheight:[800,768,960,720],
		lazyType:"none",
		shadow:0,
		spinner:"spinner3",
		stopLoop:"off",
		stopAfterLoops:-1,
		stopAtSlide:-1,
		shuffle:"off",
		autoHeight:"off",
		disableProgressBar:"on",
		hideThumbsOnMobile:"off",
		hideSliderAtLimit:0,
		hideCaptionAtLimit:0,
		hideAllCaptionAtLilmit:0,
		debugMode:false,
		fallbacks: {
			simplifyAll:"off",
			nextSlideOnWindowFocus:"off",
			disableFocusListener:false,
		}
	});
}
function RevolutionInit5() {
	$("#rev_slider_5").show().revolution({
		sliderType:"standard",
		jsFileLocation:"js/",
		sliderLayout:"fullwidth",
		dottedOverlay:"none",
		delay:9000,
		navigation: {
			keyboardNavigation:"off",
			keyboard_direction: "horizontal",
			mouseScrollNavigation:"off",
						mouseScrollReverse:"default",
			onHoverStop:"off",
			tabs: {
				style:"moody-tab-01",
				enable:true,
				width:293,
				height:100,
				min_width:100,
				wrapper_padding:0,
				wrapper_color:"transparent",
				tmp:'<div class="tp-tab-content">  <span class="tp-tab-number">{{param1}}</span>  <span class="tp-tab-title">{{title}}</span></div>',
				visibleAmount: 4,
				hide_onmobile: true,
				hide_under:1006,
				hide_onleave:false,
				hide_delay:200,
				direction:"horizontal",
				span:true,
				position:"outer-bottom",
				space:0,
				h_align:"center",
				v_align:"bottom",
				h_offset:0,
				v_offset:0
			}
		},
		viewPort: {
			enable:true,
			outof:"wait",
			visible_area:"80%",
			presize:false
		},
		responsiveLevels:[1240,1024,778,480],
		visibilityLevels:[1240,1024,778,480],
		gridwidth:[1230,1024,778,480],
		gridheight:[700,700,800,800],
		lazyType:"none",
		shadow:0,
		spinner:"spinner3",
		stopLoop:"off",
		stopAfterLoops:-1,
		stopAtSlide:-1,
		shuffle:"off",
		autoHeight:"off",
		disableProgressBar:"on",
		hideThumbsOnMobile:"off",
		hideSliderAtLimit:0,
		hideCaptionAtLimit:0,
		hideAllCaptionAtLilmit:0,
		debugMode:false,
		fallbacks: {
			simplifyAll:"off",
			nextSlideOnWindowFocus:"off",
			disableFocusListener:false,
		}
	});
}
function RevolutionInit6() {
	$("#rev_slider_6").show().revolution({
		sliderType:"standard",
		jsFileLocation:"js/",
		sliderLayout:"auto",
		dottedOverlay:"none",
		delay:9000,
		navigation: {
			keyboardNavigation:"off",
			keyboard_direction: "horizontal",
			mouseScrollNavigation:"off",
						mouseScrollReverse:"default",
			onHoverStop:"off",
			arrows: {
				style:"uranus",
				enable:true,
				hide_onmobile:false,
				hide_onleave:false,
				tmp:'',
				left: {
					h_align:"left",
					v_align:"center",
					h_offset:20,
					v_offset:0
				},
				right: {
					h_align:"right",
					v_align:"center",
					h_offset:20,
					v_offset:0
				}
			}
		},
		viewPort: {
			enable:true,
			outof:"wait",
			visible_area:"80%",
			presize:false
		},
		responsiveLevels:[1240,1024,778,480],
		visibilityLevels:[1240,1024,778,480],
		gridwidth:[1440,1024,778,480],
		gridheight:[650,550,400,350],
		lazyType:"none",
		shadow:0,
		spinner:"spinner3",
		stopLoop:"off",
		stopAfterLoops:-1,
		stopAtSlide:-1,
		shuffle:"off",
		autoHeight:"off",
		disableProgressBar:"on",
		hideThumbsOnMobile:"off",
		hideSliderAtLimit:0,
		hideCaptionAtLimit:0,
		hideAllCaptionAtLilmit:0,
		debugMode:false,
		fallbacks: {
			simplifyAll:"off",
			nextSlideOnWindowFocus:"off",
			disableFocusListener:false,
		}
	});
}


/*=================================================================
	portfolio fullscreen slider center
===================================================================*/

function initPortfolioFullscreenCenterSlider() {
	var $slider = $( '#fullscreen-center-slider' );
	var $sliderContainer = $slider.children( '.swiper-container' ).first();

	var $swiperPrev = $slider.find( '.swiper-button-prev' );
	var $swiperNext = $slider.find( '.swiper-button-next' );

	$pageContent = $( '.swiper-background-fade-wrapper .inner' );


	var swiper = new Swiper( $sliderContainer, {
		nextButton: $swiperNext,
		prevButton: $swiperPrev,
		slidesPerView: 1,
		speed: 1500,
		spaceBetween: 0,
		mousewheelControl: true,
		loop: true,
		loopedSlides: 1,
		onSlideChangeStart: function( swiper ) {
			slideChangeCallback( swiper, $pageContent );
		},
		onSlideChangeEnd: function( swiper ) {
		}
	} );

	$slider.find( '.panr' ).each( function() {

		var $work = $( this ), $img = $( 'img', $work ), scaleLimit = 1.05;

		$img.panr( {
			moveTarget: $work,
			sensitivity: 50,
			scale: false,
			scaleOnHover: true,
			scaleTo: scaleLimit,
			scaleDuration: .8,
			panDuration: 3,
			resetPanOnMouseLeave: false
		} );
	} );
}

function slideChangeCallback( swiper, $pageContent ) {
	var $counterPrev = $( swiper.wrapper )
		.parent()
		.siblings( '.swiper-navigation-wrap' )
		.find( '.swiper-button-prev' );

	var $counterNext = $( swiper.wrapper )
		.parent()
		.siblings( '.swiper-navigation-wrap' )
		.find( '.swiper-button-next' );

	var total = $( swiper.wrapper )
		.find( '.swiper-slide:not(.swiper-slide-duplicate)' ).length;

	var prevText = swiper.realIndex + '/' + total;

	var nextText = swiper.realIndex + 2 + '/' + total, firstClass = '', lastClass = '';

	if ( (
			 swiper.realIndex
		 ) < 1 ) {
		firstClass = 'first';
		prevText = total + '/' + total;
	}

	if ( (
			 swiper.realIndex + 2
		 ) > total ) {
		lastClass = 'last';
		nextText = '1/' + total;
	}

	$counterPrev.removeClass( 'first' ).addClass( firstClass ).find( '.counter' ).text( prevText );
	$counterNext.removeClass( 'last' ).addClass( lastClass ).find( '.counter' ).text( nextText );

	if ( swiper.previousIndex > swiper.activeIndex ) {
		$( swiper.wrapper ).removeClass( 'swiper-to-next-slide' ).addClass( 'swiper-to-prev-slide' );
	} else {
		$( swiper.wrapper ).removeClass( 'swiper-to-prev-slide' ).addClass( 'swiper-to-next-slide' );
	}

	$pageContent.css( 'backgroundImage', 'url(' + $( swiper.wrapper )
		.find( '.swiper-slide' )
		.eq( swiper.activeIndex )
		.find( '.portfolio-item' )
		.data( 'background' ) + ')' );
}

/*=================================================================
	background marque
===================================================================*/

function marqueBackground() {
	$( '.background-marque' ).each( function() {
		var $el = $( this );
		var x = 0;
		var step = 1;
		var speed = 10;

		if ( $el.hasClass( 'to-left' ) ) {
			step = - 1;
		}

		$el.css( 'background-repeat', 'repeat-x' );

		var loop = setInterval( function() {
			x += step;
			$el.css( 'background-position-x', x + 'px' );
		}, speed );
	});
}

/*=================================================================
	google map
===================================================================*/
function googleMap() {
	if ($("#googleMap").length > 0) {
		$obj = $("#googleMap");
		var myCenter = new google.maps.LatLng($obj.data("lat"), $obj.data("lon"));
		var myMaker = new google.maps.LatLng($obj.data("lat"), $obj.data("lon"));
		function initialize() {
			var mapProp = {
				center: myCenter,
				zoom: 16,
				scrollwheel: false,
				mapTypeControlOptions: {
					mapTypeIds: [ google.maps.MapTypeId.ROADMAP, "map_style" ]
				}
			};
			var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
			var marker = new google.maps.Marker({
				position: myMaker,
				icon: $obj.data("icon")
			});
			marker.setMap(map);
		}
		google.maps.event.addDomListener(window, "load", initialize);
	}
	
	
	if ($('#map').length > 0) {
		if ($('#map').attr('data-marker-image') != undefined) {
			marker_image = $('#map').attr('data-marker-image')
		}
		google.maps.event.addDomListener(window, 'load', init);
	}

	function init() {
		// Basic options for a simple Google Map
		// For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
		var mapOptions = {
			// How zoomed in you want the map to start at (always required)
			zoom: 11,
			scrollwheel: false,

			// The latitude and longitude to center the map (always required)
			center: new google.maps.LatLng(40.6700, -73.9400), // New York

			// How you would like to style the map.
			// This is where you would paste any style found on Snazzy Maps.
			styles: [{
				"featureType": "water",
				"elementType": "geometry.fill",
				"stylers": [{ "color": "#d3d3d3" }]
			}, {
				"featureType": "transit",
				"stylers": [{ "color": "#808080" }, { "visibility": "off" }]
			}, {
				"featureType": "road.highway",
				"elementType": "geometry.stroke",
				"stylers": [{ "visibility": "on" }, { "color": "#b3b3b3" }]
			}, {
				"featureType": "road.highway",
				"elementType": "geometry.fill",
				"stylers": [{ "color": "#ffffff" }]
			}, {
				"featureType": "road.local",
				"elementType": "geometry.fill",
				"stylers": [{ "visibility": "on" }, { "color": "#ffffff" }, { "weight": 1.8 }]
			}, {
				"featureType": "road.local",
				"elementType": "geometry.stroke",
				"stylers": [{ "color": "#d7d7d7" }]
			}, {
				"featureType": "poi",
				"elementType": "geometry.fill",
				"stylers": [{ "visibility": "on" }, { "color": "#ebebeb" }]
			}, {
				"featureType": "administrative",
				"elementType": "geometry",
				"stylers": [{ "color": "#a7a7a7" }]
			}, {
				"featureType": "road.arterial",
				"elementType": "geometry.fill",
				"stylers": [{ "color": "#ffffff" }]
			}, {
				"featureType": "road.arterial",
				"elementType": "geometry.fill",
				"stylers": [{ "color": "#ffffff" }]
			}, {
				"featureType": "landscape",
				"elementType": "geometry.fill",
				"stylers": [{ "visibility": "on" }, { "color": "#efefef" }]
			}, {
				"featureType": "road",
				"elementType": "labels.text.fill",
				"stylers": [{ "color": "#696969" }]
			}, {
				"featureType": "administrative",
				"elementType": "labels.text.fill",
				"stylers": [{ "visibility": "on" }, { "color": "#737373" }]
			}, {
				"featureType": "poi",
				"elementType": "labels.icon",
				"stylers": [{ "visibility": "off" }]
			}, {
				"featureType": "poi",
				"elementType": "labels",
				"stylers": [{ "visibility": "off" }]
			}, {
				"featureType": "road.arterial",
				"elementType": "geometry.stroke",
				"stylers": [{ "color": "#d6d6d6" }]
			}, {
				"featureType": "road",
				"elementType": "labels.icon",
				"stylers": [{ "visibility": "off" }]
			}, {}, { "featureType": "poi", "elementType": "geometry.fill", "stylers": [{ "color": "#dadada" }] }]
		};

		// Get the HTML DOM element that will contain your map
		// We are using a div with id="map" seen below in the <body>
		var mapElement = document.getElementById('map');
		// Create the Google Map using our element and options defined above
		var map = new google.maps.Map(mapElement, mapOptions);

		// Let's also add a marker while we're at it
		var marker = new google.maps.Marker({
			position: new google.maps.LatLng(40.6000, -73.9400),
			map: map,
			title: 'Megatron',
			icon: marker_image
		});

		var marker2 = new google.maps.Marker({
			position: new google.maps.LatLng(40.6800, -73.8000),
			map: map,
			title: 'Megatron',
			icon: marker_image
		});

		var marker3 = new google.maps.Marker({
			position: new google.maps.LatLng(40.7300, -74.1280),
			map: map,
			title: 'Megatron',
			icon: marker_image
		});

	}
}

/*=================================================================
	countdown function
===================================================================*/
function Countdown() {
	if ($(".pl-clock").length > 0) {
		$(".pl-clock").each(function() {
			var time = $(this).attr("data-time");
			$(this).countdown(time, function(event) {
				var $this = $(this).html(event.strftime('' + '<div class="countdown-item"><div class="countdown-item-value">%D</div><div class="countdown-item-label">Days</div></div>' + '<div class="separator"><span>:</span></div>' + '<div class="countdown-item"><div class="countdown-item-value">%H</div><div class="countdown-item-label">Hours</div></div>' + '<div class="separator"><span>:</span></div>' + '<div class="countdown-item"><div class="countdown-item-value">%M</div><div class="countdown-item-label">Minutes</div></div>' + '<div class="separator"><span>:</span></div>' + '<div class="countdown-item"><div class="countdown-item-value">%S</div><div class="countdown-item-label">Seconds</div></div>'));
			});
		});
	}
}