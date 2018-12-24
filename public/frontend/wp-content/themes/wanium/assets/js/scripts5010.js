(function($){
    "use strict";

/* GLOBAL VARIABLES - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
    var $window = $(window), tlg_nav_show = false, tlg_nav_hide = false, tlg_nav_fixed = false, 
    tlg_nav, tlg_nav_height, tlg_first_section_height, tlg_top_offset = 0;

/* EQUAL HEIGHT - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */

    var tlg_content_heights = function() {
        var w = jQuery(window).width();
        jQuery('.row.equal-height, .vc_row.equal-height').each(function() {
            if ( w > 768 ) {
                jQuery(this).find( '.row >.wpb_column >.vc_column-inner' ).equalHeights();
            } else {
                jQuery(this).find( '.row >.wpb_column >.vc_column-inner' ).equalHeightsRemove();
            }
        });
        jQuery('.metro-grid .products').each(function() {
            if ( w > 768 ) {
                jQuery(this).find( '.product' ).equalHeights();
            } else {
                jQuery(this).find( '.product' ).equalHeightsRemove();
            }
        });
    };
    $window.on( 'load resize', tlg_content_heights );
    $window.one( 'scroll', tlg_content_heights );

    jQuery(window).resize(function() { // RESIZE EVENT
        tlg_vc_spacer();
        tlg_content_heights();
    });

    jQuery(window).load(function() { // LOADED EVENT
        "use strict";

/* PRELOADER - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
        if ( jQuery( '#tlg_preloader' ).length ) {
            jQuery( 'body' ).removeClass( 'loading' );
            tlg_preloader();
        }

/* MANSORY - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
        if ( jQuery( '.masonry' ).length ) {
            var mans = document.querySelectorAll('.masonry'), i;
            for (i = 0; i < mans.length; ++i) {
                var container = mans[i];
                var masonry_init = new Masonry(container, { itemSelector: '.masonry-item', isResizable : true });

                masonry_init.on( 'layoutComplete', function() {
                    jQuery( '.masonry' ).addClass( 'fadeIn' );
                    jQuery( '.masonry-loader' ).addClass( 'fadeOut' );
                    if (jQuery( '.masonry-show' ).length) {
                        tlg_masonry_show();
                    }
                });
                masonry_init.layout();
            }
        }

/* PROJECT FILTER - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
        jQuery('.project-content').each(function() {
            var $grid = jQuery(this);
            var $gridID = jQuery(this).attr('id');
            $grid.isotope({
                itemSelector: '.project',
                percentPosition: true,
                masonry: {columnWidth : '.grid-sizer'}
            });
            jQuery("ul[data-project-id='"+$gridID+"'] li").click(function (e) {
                e.preventDefault();
                $grid.addClass('is_fillter');
                jQuery("ul[data-project-id='"+$gridID+"'] li").removeClass('active');
                jQuery(this).addClass('active');
                $grid.isotope({ 
                    filter: jQuery(this).attr('data-group'), 
                    itemSelector: '.project',
                    percentPosition: true,
                    masonry: {columnWidth : '.grid-sizer'} 
                });
            });
        });
    }); 

    jQuery(document).ready(function() { // READY EVENT
        "use strict";

        jQuery('input[type="date"]').each(function() {
            var el = this, type = jQuery(el).attr('type');
            if (jQuery(el).val() == '') jQuery(el).attr('type', 'text');
            jQuery(el).focus(function() {
                jQuery(el).attr('type', type);
                el.click();
            });
            jQuery(el).blur(function() {
                if (jQuery(el).val() == '') jQuery(el).attr('type', 'text');
            });
        });
        

/* NAVIGATION - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
        tlg_nav = jQuery('body .nav-container nav:first');
        jQuery('.nav-container').addClass('visible');
        jQuery('.mega-menu ul').removeClass('menu').unwrap().unwrap().unwrap().wrap('<li />');
        if (!jQuery('nav').hasClass('fixed') && !jQuery('nav').hasClass('absolute')) {
            jQuery('.nav-container').css('min-height', jQuery('nav').outerHeight(true));
            jQuery(window).resize(function() { jQuery('.nav-container').css('min-height', jQuery('nav').outerHeight(true)); });
            if (jQuery(window).width() > 768) {
                jQuery('.parallax:nth-of-type(1) .background-content').css('top', -(jQuery('nav').outerHeight(true)*2));
                jQuery('.fullscreen.parallax.header-single:nth-of-type(1) .background-content').css('top', -jQuery('nav').outerHeight(true));
                jQuery('section.fullscreen:nth-of-type(1)').css('height', (jQuery(window).height() - jQuery('nav').outerHeight(true)));
            }
        } else {
            jQuery('body').addClass('menu-overlay');
            var firstProjectParallax = jQuery('section.image-bg.parallax.project-parallax:nth-of-type(1) .background-content');
            if (firstProjectParallax.length == 1) {
                var firstProjectOffset = firstProjectParallax.offset();
                firstProjectParallax.css('top', -(firstProjectOffset.top/2 + jQuery('nav').outerHeight(true)*2));
            }
        }
        if (jQuery(window).width() > 768) {
            jQuery('#home + .vc_row.parallax .background-content').css('top', -(jQuery('nav').outerHeight(true)*2));
            jQuery('.wpb_wrapper').each(function() {
                var backgroundContent = jQuery(this).find('section.fullscreen.parallax .background-content');
                if (backgroundContent.length == 1) {
                    var parallaxOffset = backgroundContent.offset();
                    backgroundContent.css('top', -parallaxOffset.top/2);
                }
            });

            jQuery( '.mega-menu, .subnav' ).mouseover(function() {
                jQuery( this ).parents( '.menu > .menu-item' ).addClass( 'current-hover' );
            }).mouseout(function() {
                jQuery( '.menu-item' ).removeClass( 'current-hover' );
            });
        }
        if (jQuery('nav').hasClass('bg-dark')) jQuery('.nav-container').addClass('bg-dark');

        if (jQuery(window).width() > 990) {
            if (!jQuery('.nav-container').hasClass('vertical-menu')) {
                jQuery('nav .megamenu-item > ul').removeClass('subnav').addClass('mega-menu');
            }
            var didScroll = false;
             
            $(window).scroll(function() {
                didScroll = true;
            });
            setInterval(function() {
                if ( didScroll ) {
                    didScroll = false;
                    tlg_update_nav();
                }
            }, 250);
            window.addEventListener( "scroll", tlg_update_nav, false );
        }

        jQuery('.nav-container:not(.full-menu) .menu > li > ul').each(function() {
            var menu = jQuery(this).offset();
            var menuright = menu.left + jQuery(this).outerWidth(true);
            if (menuright > jQuery(window).width() && !jQuery(this).hasClass('mega-menu')) {
                jQuery(this).addClass('right-0');
            } else if (menuright > jQuery(window).width() && jQuery(this).hasClass('mega-menu')) {
                if (jQuery(window).width() > 990 && jQuery('body').hasClass('frame-layout')) {
                    jQuery(this).css('margin-left', -(jQuery(this).outerWidth(true) - jQuery(window).width() + menu.left + 82));
                } else {
                    jQuery(this).css('margin-left', -(jQuery(this).outerWidth(true) - jQuery(window).width() + menu.left + 44));
                }
            }
        });

        if (jQuery('nav .menu-item').hasClass('menu-item-btn')) {
            jQuery( '.nav-bar' ).addClass( 'nav-full' );
        }

/* MOBILE NAVIGATION - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
        jQuery('.mobile-toggle').click(function() {
            jQuery('.nav-bar').toggleClass('nav-open');
            jQuery(this).toggleClass('active');
            if (!tlg_nav_fixed) { tlg_nav_fixed = true; tlg_nav.addClass('fixed'); }
        });
        if (jQuery(window).width() < 991) {
            jQuery('.menu li').click(function(e) {
                if (!e) e = window.event; e.stopPropagation();
                if (jQuery(this).find(">a").is('[href*="#"]') || jQuery(this).hasClass("menu-item-has-children")) {
                    e.preventDefault();
                }
                if (jQuery(this).find('ul').length) jQuery(this).toggleClass('toggle-sub');
                else jQuery(this).parents('.toggle-sub').removeClass('toggle-sub');
            });
        }
        jQuery('.module.widget-wrap').click(function() {
            jQuery(this).toggleClass('toggle-widget-wrap');
        });
        jQuery('.module.widget-wrap .search a').click(function(e) {
            e.preventDefault();
        });
        jQuery('.search-widget-wrap .search-form input').click(function(e){
            if (!e) e = window.event; e.stopPropagation();
        });
        
/* OFFCANVAS NAVIGATION - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
        if(jQuery('.offcanvas-toggle').length) jQuery('body').addClass('has-offcanvas-nav');
        else jQuery('body').removeClass('has-offcanvas-nav');
        jQuery('.offcanvas-toggle').click(function() {
            jQuery('.main-container').toggleClass('offcanvas-show');
            jQuery('nav').toggleClass('offcanvas-show');
            jQuery('.offcanvas-container').toggleClass('offcanvas-show');
        });
        jQuery('.main-container').click(function() {
            if(jQuery(this).hasClass('offcanvas-show')) {
                jQuery(this).removeClass('offcanvas-show');
                jQuery('.offcanvas-container').removeClass('offcanvas-show');
                jQuery('nav').removeClass('offcanvas-show');
            }
        });
        jQuery('.offcanvas-container .close-nav a').click(function(e) {
            e.preventDefault();
            jQuery('.offcanvas-container').removeClass('offcanvas-show');
            jQuery('.main-container').removeClass('offcanvas-show');
            jQuery('nav').removeClass('offcanvas-show');
        });

/* VERTICAL NAVIGATION - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
        jQuery('.vertical-menu .has-dropdown > a').after('<i class="ti-angle-right"></i>');
        jQuery('.nav-container').on('click', '.subnav-icon, .menu-item a[href="#"]', function(e) {
            e.preventDefault();
            jQuery(this).parent( '.menu-item' ).toggleClass( 'subnav-show' ).find( '.subnav:first' ).slideToggle( "slow" );
        });
        if(jQuery('.side-menu').length) {
            jQuery('.side-menu').mCustomScrollbar({ theme:"minimal-dark", mouseWheelPixels: 250 });            
        }
        if(jQuery('.offcanvas-container').length) {
            jQuery('.offcanvas-container').mCustomScrollbar({ theme:"minimal-dark", mouseWheelPixels: 250 });
        }

/* ONEPAGE NAVIGATION - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
        jQuery('.menu-item a[href*="#"]:not([href="#"])').bind('click',function () {
            if ( jQuery("a[id*=" + this.hash.substring(1) + "]").length > 0 ) {
                jQuery('.current-menu').removeClass('current-menu');
                jQuery(this).parent('li').addClass('current-menu');
            }else{
                jQuery('.current-menu').removeClass('.current-menu');
            }
        });

/* HEADER SLIDE - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
        setTimeout(function() {
            jQuery('.header-single > .container, .header-slider > .container').each(function() {
                jQuery(this).addClass('visible');
            });
            jQuery('.shop-carousel, .shop-carousel-rtl, .blog-carousel, .blog-carousel-rtl, .post-slider, .carousel-padding-item, .carousel-padding-item-rtl').each(function() {
                jQuery(this).addClass('visible');
            });
        }, 200);

/* BACKGROUND IMAGE CONTENT - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
        jQuery('.background-content').each(function() {
            var imgSrc = jQuery(this).children('img').attr('src');
            jQuery(this).css({
                'background-image': 'url("' + imgSrc + '")',
                'background-position': '50% 50%',
                'background-size': 'cover'
            });
            jQuery(this).children('img').hide();
        });
        setTimeout(function() {
            jQuery('.background-content').each(function() {
                jQuery(this).addClass('visible');
            });
        }, 200);        

/* VC ROW DEVIDER COLOR - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
        jQuery('.row, .vc_row, .vc_column-inner').each(function() {
            if( jQuery(this).is('[class*="vc_custom_"]') ) {
                jQuery(this).find( '.divider-wrap, .legend' ).addClass( ' ' + jQuery(this).attr("class").match(/bg-[\w-]*\b/) + ' ' + jQuery(this).attr("class").match(/vc_custom_[\w-]*\b/) + ' ' );
            } else {
                if( jQuery(this).hasClass('bg-light') ) jQuery(this).find( '.divider-wrap, .legend' ).addClass( 'bg-light' );
                if( jQuery(this).hasClass('bg-secondary') ) jQuery(this).find( '.divider-wrap, .legend' ).addClass( 'bg-secondary' );
                if( jQuery(this).hasClass('bg-dark') ) jQuery(this).find( '.divider-wrap, .legend' ).addClass( 'bg-dark' );
                if( jQuery(this).hasClass('bg-primary') ) jQuery(this).find( '.divider-wrap, .legend' ).addClass( 'bg-primary' );
            }
        });

/* SCROLLER - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
        
        // SCROLL TO TOP
        var $to_top = jQuery('.back-to-top');
        $window.on('scroll', function() {
            if ( $to_top.length > 0 ) {
                if( jQuery(window).scrollTop() > 80 ) $to_top.stop().animate({bottom: 17, opacity: 1}, 700);
                else $to_top.stop().animate({bottom: -17, opacity: 0}, 700);
            }
            if( jQuery(window).scrollTop() > (jQuery(window).height() / 8 ) ) {
                jQuery('body').addClass('site-scrolled');
            } else {
                jQuery('body').removeClass('site-scrolled');
            }
        });
        $to_top.click(function (e) { 
            e.preventDefault();
            jQuery('html, body').animate({scrollTop: 0}, 800);
            return false;
        });

        // SCROLL INNER LINKS
        if( $(window).width() >= 991 ) {
            jQuery('a[href*="#"]').smoothScroll({ speed: 800 });
        } else {
            jQuery('a[href^="#"]').smoothScroll({ speed: 800 });
        }
        jQuery(document).on('click', 'li.vc_tta-tab a,li.vc_tta-tab,.vc_tta-panel-title', function(){
             $('html, body').stop();
        });

        // VARIABLE: TOP OFFSET
        addEventListener('scroll', function() { tlg_top_offset = window.pageYOffset; }, false);

/* SOCIAL SHARE TOGGLE - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
        jQuery('.ssc-share-toogle').unbind('click').bind('click touchend', function(e) {
            e.preventDefault();
            jQuery(this).toggleClass('active');
            jQuery(this).siblings('.ssc-share-group').toggle('slow');
        });
        jQuery('.ssc-share-group a').unbind('click').bind('click touchend', function(e) {
            e.preventDefault();
            var popup = window.open($(this).prop('href'), '', 'height=340,width=800');
            if (window.focus) popup.focus(); return false;
        });
        
/* FLICKR - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
        if(jQuery('.flickr-feed').length) {
           jQuery('.flickr-feed').each(function() {
               var userID = jQuery(this).attr('data-user-id'), number = jQuery(this).attr('data-number');
               jQuery(this).flickrPhotoStream({ id: userID, max: number, container: '<li/>' });
           });
        }
        
/* LIKE ACTION - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
        jQuery('.tlg-likes').live('click', function() {
            var link = jQuery(this);
            var id = link.attr('id');
            if( link.hasClass('active') ) return false;
            jQuery.post(wp_data.wanium_ajax_url, { action:'tlg-likes', likes_id:id }, function(data) {
                link.html(data).addClass('active');
            });
            return false;
        });
        if( jQuery('body.ajax-tlg-likes').length ) {
            jQuery('.tlg-likes').each(function() {
                var id = jQuery(this).attr('id');
                jQuery(this).load(wp_data.wanium_ajax_url, { action:'tlg-likes', post_id:id });
            });
        }

/* ACCORDION - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
        jQuery('.accordion').each(function(){
            jQuery('li', this).eq(0).addClass('active');
        });
        jQuery('.accordion li').click(function() {
            var active_accordion = jQuery(this);
            if (active_accordion.closest('.accordion').hasClass('accordion-auto-close')) {
                active_accordion.closest('.accordion').find('li').removeClass('active');
                active_accordion.addClass('active');
            } else {
                active_accordion.toggleClass('active');
            }
        });

/* TABBED CONTENT - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
        jQuery('.tabs-content').each(function() {
            jQuery('li', this).eq(0).addClass('active');
            jQuery(this).append('<ul class="tabs-content-text"></ul>');
        });
        setTimeout(function() {
            jQuery('.tabs-content').each(function() {
                jQuery(this).addClass('visible');
            });
        }, 200);
        jQuery('.tabs li').each(function() {
            var active_tab = jQuery(this), active_tab_class = '';
            if (active_tab.is('.tabs > li:first-child')) active_tab_class = ' class="active"';
            var content_tab = active_tab.find('.tab-content').detach().wrap('<li' + active_tab_class + '></li>').parent();
            active_tab.closest('.tabs-content').find('.tabs-content-text').append(content_tab);
        });
        jQuery('.tabs li').click(function() {
            var active_tab = jQuery(this);
            active_tab.closest('.tabs').find('li').removeClass('active');
            active_tab.addClass('active');
            active_tab.closest('.tabs-content').find('.tabs-content-text>li').removeClass('active');
            active_tab.closest('.tabs-content').find('.tabs-content-text>li:nth-of-type(' + (active_tab.index() + 1) + ')').addClass('active');
        });

/* PROGRESS BARS - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
        if( $(window).width() >= 768 ) {
            $('.progress-bars .meter > span').each(function() {
                $(this).waypoint(function() {
                    if (!$(this).hasClass('progress-showed')) {
                        $(this).data('origWidth', $(this).width()).width(0).animate({
                            width: $(this).data("origWidth")
                        }, 1200);
                        $(this).addClass('progress-showed');
                    } else return false;
                }, { offset: '100%' });
            });
        }

/* COUNTER - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
        if(jQuery('.counter-number').length){
            jQuery('.counter-number').counterUp({ delay: 10, time: 3000 });
        }

/* CAROUSEL - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
        jQuery('.blog-carousel.four-columns').owlCarousel({nav: false, dots: false, loop: true, responsive:{ 0:{items:1}, 700:{items:2}, 1100:{items:3}, 1600:{items:4} }});
        jQuery('.blog-carousel.three-columns').owlCarousel({nav: false, dots: false, loop: true, responsive:{ 0:{items:1}, 700:{items:2}, 1100:{items:3}, 1600:{items:3} }});
        jQuery('.blog-carousel.two-columns').owlCarousel({nav: false, dots: false, loop: true, responsive:{ 0:{items:1}, 700:{items:2}, 1100:{items:2}, 1600:{items:2} }});
        jQuery('.blog-carousel-rtl.four-columns').owlCarousel({rtl: true, nav: false, dots: false, loop: true, responsive:{ 0:{items:1}, 700:{items:2}, 1100:{items:3}, 1600:{items:4} }});
        jQuery('.blog-carousel-rtl.three-columns').owlCarousel({rtl: true, nav: false, dots: false, loop: true, responsive:{ 0:{items:1}, 700:{items:2}, 1100:{items:3}, 1600:{items:3} }});
        jQuery('.blog-carousel-rtl.two-columns').owlCarousel({rtl: true, nav: false, dots: false, loop: true, responsive:{ 0:{items:1}, 700:{items:2}, 1100:{items:2}, 1600:{items:2} }});
        
        jQuery('.shop-carousel.four-columns').owlCarousel({nav: false, dots: false, loop: true, responsive:{ 0:{items:1}, 700:{items:2}, 1100:{items:3}, 1600:{items:4} }});
        jQuery('.shop-carousel.three-columns').owlCarousel({nav: false, dots: false, loop: true, responsive:{ 0:{items:1}, 700:{items:2}, 1100:{items:3}, 1600:{items:3} }});
        jQuery('.shop-carousel-rtl.four-columns').owlCarousel({rtl: true, nav: false, dots: false, loop: true, responsive:{ 0:{items:1}, 700:{items:2}, 1100:{items:3}, 1600:{items:4} }});
        jQuery('.shop-carousel-rtl.three-columns').owlCarousel({rtl: true, nav: false, dots: false, loop: true, responsive:{ 0:{items:1}, 700:{items:2}, 1100:{items:3}, 1600:{items:3} }});
        
        jQuery('.carousel-one-item').owlCarousel({ nav: true, navigation : false, singleItem : true, loop: true, addClassActive: true, responsive:{ 0:{items:1}, 700:{items:1}, 1100:{items:1}, 1600:{items:1} },
            onInitialized: function() { jQuery('.owl-item').find('video').each(function() {this.play();}); },
        });
        jQuery('.carousel-one-item-rtl').owlCarousel({ rtl: true, nav: true, navigation : false, singleItem : true, loop: true, addClassActive: true, responsive:{ 0:{items:1}, 700:{items:1}, 1100:{items:1}, 1600:{items:1} },
            onInitialized: function() { jQuery('.owl-item').find('video').each(function() {this.play();}); },
        });
        
        jQuery('.carousel-one-item-fade').owlCarousel({ nav: true, navigation : false, singleItem : true, loop: true, addClassActive: true, animateOut: 'fadeOut', animateIn: 'fadeIn', mouseDrag: false, touchDrag: false, responsive:{ 0:{items:1}, 700:{items:1}, 1100:{items:1}, 1600:{items:1} },
            onInitialized: function() { jQuery('.owl-item').find('video').each(function() {this.play();}); },
        });
        jQuery('.carousel-one-item-fade-rtl').owlCarousel({ rtl: true, nav: true, navigation : false, singleItem : true, loop: true, addClassActive: true, animateOut: 'fadeOut', animateIn: 'fadeIn', mouseDrag: false, touchDrag: false, responsive:{ 0:{items:1}, 700:{items:1}, 1100:{items:1}, 1600:{items:1} },
            onInitialized: function() { jQuery('.owl-item').find('video').each(function() {this.play();}); },
        });

        jQuery('.carousel-one-item-autoplay').owlCarousel({ autoplay:true, autoplayTimeout:3000, autoplayHoverPause:true, nav: true, navigation : false, singleItem : true, loop: true, addClassActive: true, animateOut: 'fadeOut', animateIn: 'fadeIn', mouseDrag: false, touchDrag: false, responsive:{ 0:{items:1}, 700:{items:1}, 1100:{items:1}, 1600:{items:1} },
            onInitialized: function() { jQuery('.owl-item').find('video').each(function() {this.play();}); },
        });
        jQuery('.carousel-one-item-autoplay-rtl').owlCarousel({ rtl: true, autoplay:true, autoplayTimeout:3000, autoplayHoverPause:true, nav: true, navigation : false, singleItem : true, loop: true, addClassActive: true, animateOut: 'fadeOut', animateIn: 'fadeIn', mouseDrag: false, touchDrag: false, responsive:{ 0:{items:1}, 700:{items:1}, 1100:{items:1}, 1600:{items:1} },
            onInitialized: function() { jQuery('.owl-item').find('video').each(function() {this.play();}); },
        });

        jQuery('.carousel-padding-item').owlCarousel({ stagePadding: 200, loop:true, margin:10, nav: false, navigation : false, singleItem : false, responsive:{ 0:{ items:1, stagePadding: 60 }, 600:{ items:1, stagePadding: 100 }, 1000:{ items:1, stagePadding: 200 }, 1200:{ items:1, stagePadding: 250 }, 1400:{ items:1, stagePadding: 300 }, 1600:{ items:1, stagePadding: 350 }, 1800:{ items:1, stagePadding: 400 } }})
        jQuery('.carousel-padding-item-rtl').owlCarousel({ rtl: true, stagePadding: 200, loop:true, margin:10, nav: false, navigation : false, singleItem : false, responsive:{ 0:{ items:1, stagePadding: 60 }, 600:{ items:1, stagePadding: 100 }, 1000:{ items:1, stagePadding: 200 }, 1200:{ items:1, stagePadding: 250 }, 1400:{ items:1, stagePadding: 300 }, 1600:{ items:1, stagePadding: 350 }, 1800:{ items:1, stagePadding: 400 } }})
        
        jQuery('.logo-carousel-owl').owlCarousel({ nav: false, navigation : false, singleItem : false, loop: true, addClassActive: true, responsive:{ 0:{items:1}, 700:{items:3}, 1100:{items:5}, 1600:{items:5} }});
        jQuery('.logo-carousel-owl-rtl').owlCarousel({ rtl: true, nav: false, navigation : false, singleItem : false, loop: true, addClassActive: true, responsive:{ 0:{items:1}, 700:{items:3}, 1100:{items:5}, 1600:{items:5} }});
        
        jQuery('.logo-carousel .slides').owlCarousel({autoplay: 3000, autoplaySpeed: 500, stopOnHover: false, nav: false, dots: false, loop: true, responsive:{ 0:{items:1}, 700:{items:3}, 1100:{items:5}, 1600:{items:5} }});        
        jQuery('.logo-carousel-rtl .slides').owlCarousel({rtl: true, autoplay: 3000, autoplaySpeed: 500, stopOnHover: false, nav: false, dots: false, loop: true, responsive:{ 0:{items:1}, 700:{items:3}, 1100:{items:5}, 1600:{items:5} }});
        
        jQuery('.slider-rotator').flexslider({ animation: "slide", directionNav: false, controlNav: false });
        jQuery('.slider-rotator-rtl').flexslider({ rtl:true, animation: "slide", directionNav: false, controlNav: false });

        jQuery('.slider-thumb .slides li').each(function() { jQuery(this).attr('data-thumb', jQuery(this).find('img').attr('src')); });
        jQuery('.slider-thumb-rtl .slides li').each(function() { jQuery(this).attr('data-thumb', jQuery(this).find('img').attr('src')); });

        jQuery('.slider-thumb').flexslider({ animation: 'slide', controlNav: 'thumbnails', directionNav: true });
        jQuery('.slider-thumb-rtl').flexslider({ rtl:true, animation: 'slide', controlNav: 'thumbnails', directionNav: true });

/* VIDEO PLAYER - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */        
        if(jQuery('.player').length){
            jQuery('section').closest('body').find('.player').each(function() {
                jQuery(this).closest('section').find('.container').addClass('fadeOut');
                jQuery(this).attr('data-property', "{videoURL:'http://youtu.be/" + jQuery(this).attr('data-video-id') + "',containment:'self',autoPlay:true, mute:true, startAt:" + jQuery(this).attr('data-start-at') + ", opacity:1, showControls:false}");
            });
            jQuery('.player').each(function(){
                var section = jQuery(this).closest( 'section' );
                var player = section.find( '.player' );
                player.YTPlayer();
                player.on('YTPStart',function(e){
                    section.find('.container').removeClass('fadeOut');
                    section.find('.masonry-loader').addClass('fadeOut');
                });
            });
        }
        
/* LIGHTBOX - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
        if (jQuery('.lightbox-gallery').length) {
            jQuery('.lightbox-gallery li a').each(function(){
                jQuery(this).attr('data-lightbox', jQuery(this).closest('.lightbox-gallery').attr('data-gallery-title'));
            });
        }
        
/* MODALS - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
        if (jQuery('.md-trigger').length) {
            jQuery('.md-trigger').each(function(i) {
                var modal = jQuery( '#' + jQuery(this).data( 'modal' ) ),
                    close = modal.find( '.md-close' ),
                    overlay = jQuery( '.md-overlay' ),
                    src = modal.find('iframe').attr('src'),
                    param = '?';
                if ( src && src.indexOf("?") >= 0 ) {
                    param = '&';
                }
                function removeModal() {
                    jQuery(this).closest( '.image-bg' ).addClass( 'z-index' );
                    modal.removeClass( 'md-show' );
                    modal.find('iframe').attr('src', src);
                }
                jQuery(this).bind('click touchend', function(e) {
                    e.preventDefault();
                    jQuery(this).closest( '.image-bg' ).removeClass( 'z-index' );
                    modal.addClass( 'md-show' );
                    modal.find('iframe').attr('src', src + param + "autoplay=1&showinfo=0");
                    overlay.bind('click touchend', removeModal);
                });
                close.bind('click touchend', function(e) {
                    jQuery(this).closest( '.image-bg' ).addClass( 'z-index' );
                    e.preventDefault();
                    removeModal();
                });
            } );
            jQuery(document).keyup(function(e) {
                if ( e.keyCode == 27 ) { // ESCAPE KEY
                    jQuery('.md-modal').removeClass( 'md-show' );
                }
            });
        }
        if (jQuery(window).width() >= 991) {
            jQuery('.modal-fixed').css('height', jQuery(window).height());
            jQuery('.modal-fixed-action').click(function(e) {
                e.preventDefault();
                var modalID = jQuery(this).attr('data-modal');
                jQuery('#' + modalID).addClass('active');
                jQuery('body').addClass('modal-show');
                if ( jQuery('body').hasClass('blur_overlay') ) {
                    setTimeout(function() { jQuery('body').addClass('blur-bg'); }, 500);
                }
            });
            jQuery('.modal-fixed-close').click(function(e) {
                e.preventDefault();
                jQuery('.modal-fixed').removeClass('active');
                if ( jQuery('body').hasClass('blur_overlay') ) {
                    setTimeout(function() { jQuery('body').removeClass('modal-show').removeClass('blur-bg'); }, 350);
                }
            });
        }
        
        

/* COUNTDOWN - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
        if (jQuery('.countdown').length) {
            jQuery('.countdown').each(function() {
                var date = jQuery(this).attr('data-date');
                var day = jQuery(this).attr('data-day');
                jQuery(this).countdown(date, function(event) {
                    jQuery(this).text( event.strftime('%D '+day+' %H:%M:%S') );
                });
            });
        }
        if (jQuery('.countdown-legacy').length) {
            jQuery('.countdown-legacy').each(function() {
                var date = jQuery(this).attr('data-date');
                var week = jQuery(this).attr('data-week');
                var day = jQuery(this).attr('data-day');
                var hour = jQuery(this).attr('data-hour');
                var minute = jQuery(this).attr('data-minute');
                var second = jQuery(this).attr('data-second');
                jQuery(this).countdown(date, function(event) {
                    jQuery(this).html(event.strftime(''
                        + '<div class="countdown-part">%w <span>'+week+'</span></div>'
                        + '<div class="countdown-part">%d <span>'+day+'</span></div>'
                        + '<div class="countdown-part">%H <span>'+hour+'</span></div>'
                        + '<div class="countdown-part">%M <span>'+minute+'</span></div>'
                        + '<div class="countdown-part">%S <span>'+second+'</span></div>'));
                });
            });
        }

/* OTHER SCRIPTS - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */

        /* Spacer */
        tlg_vc_spacer();
        
        /* Responsive iframe */
        fluidvids.init({selector: ['iframe', 'object']});

        /* Tooltip */
        jQuery('[data-toggle="tooltip"]').tooltip();

        /* Enable parallax */
        jsparallax_init('.parallax > .background-content');

        /* Disable parallax on mobile */
        if ((/Android|iPhone|iPad|iPod|BlackBerry|Windows Phone/i).test(navigator.userAgent || navigator.vendor || window.opera)) { jQuery('section').removeClass('parallax'); }

        /* Set global variable */
        tlg_nav_height              = jQuery('body .nav-container nav:first').outerHeight();
        tlg_first_section_height    = jQuery('.main-container section:nth-of-type(1)').outerHeight(true);

        if ( jQuery('.wpb_content_element').hasClass('wpb_layerslider_element') ) {
            tlg_first_section_height    = jQuery('.wpb_layerslider_element:nth-of-type(1)').outerHeight(true);
        }
        if( jQuery('.wpb_content_element').hasClass('wpb_revslider_element') ) {
            tlg_first_section_height    = jQuery('.wpb_revslider_element:nth-of-type(1)').outerHeight(true);
        }
        if( jQuery('[id*="rev_slider"]').hasClass('rev_slider_wrapper') ) {
            tlg_first_section_height    = jQuery('.rev_slider_wrapper:nth-of-type(1)').outerHeight(true);
        }

        if(jQuery('.masonry-flip').length) {
            new AnimOnScroll( document.getElementById( 'masonry-flip' ), {
                minDuration : 0.4,
                maxDuration : 0.7,
                viewportFactor : 0.2
            } );
        }

        if(jQuery('.masonry-flip-photoswipe').length) {
            var initPhotoSwipeFromDOM = function(gallerySelector) {
                // parse slide data (url, title, size ...) from DOM elements 
                // (children of gallerySelector)
                var parseThumbnailElements = function(el) {
                    var thumbElements = el.childNodes,
                        numNodes = thumbElements.length,
                        items = [],
                        figureEl,
                        linkEl,
                        size,
                        item;

                    for(var i = 0; i < numNodes; i++) {

                        figureEl = thumbElements[i]; // <figure> element

                        // include only element nodes 
                        if(figureEl.nodeType !== 1) {
                            continue;
                        }

                        linkEl = figureEl.children[0]; // <a> element

                        size = linkEl.getAttribute('data-size').split('x');

                        // create slide object
                        item = {
                            src: linkEl.getAttribute('href'),
                            w: parseInt(size[0], 10),
                            h: parseInt(size[1], 10)
                        };



                        if(figureEl.children.length > 1) {
                            // <figcaption> content
                            item.title = figureEl.children[1].innerHTML; 
                        }

                        if(linkEl.children.length > 0) {
                            // <img> thumbnail element, retrieving thumbnail url
                            item.msrc = linkEl.children[0].getAttribute('src');
                        } 

                        item.el = figureEl; // save link to element for getThumbBoundsFn
                        items.push(item);
                    }

                    return items;
                };

                // find nearest parent element
                var closest = function closest(el, fn) {
                    return el && ( fn(el) ? el : closest(el.parentNode, fn) );
                };

                // triggers when user clicks on thumbnail
                var onThumbnailsClick = function(e) {
                    e = e || window.event;
                    e.preventDefault ? e.preventDefault() : e.returnValue = false;

                    var eTarget = e.target || e.srcElement;

                    // find root element of slide
                    var clickedListItem = closest(eTarget, function(el) {
                        return (el.tagName && el.tagName.toUpperCase() === 'LI');
                    });

                    if(!clickedListItem) {
                        return;
                    }

                    // find index of clicked item by looping through all child nodes
                    // alternatively, you may define index via data- attribute
                    var clickedGallery = clickedListItem.parentNode,
                        childNodes = clickedListItem.parentNode.childNodes,
                        numChildNodes = childNodes.length,
                        nodeIndex = 0,
                        index;

                    for (var i = 0; i < numChildNodes; i++) {
                        if(childNodes[i].nodeType !== 1) { 
                            continue; 
                        }

                        if(childNodes[i] === clickedListItem) {
                            index = nodeIndex;
                            break;
                        }
                        nodeIndex++;
                    }



                    if(index >= 0) {
                        // open PhotoSwipe if valid index found
                        openPhotoSwipe( index, clickedGallery );
                    }
                    return false;
                };

                // parse picture index and gallery index from URL (#&pid=1&gid=2)
                var photoswipeParseHash = function() {
                    var hash = window.location.hash.substring(1),
                    params = {};

                    if(hash.length < 5) {
                        return params;
                    }

                    var vars = hash.split('&');
                    for (var i = 0; i < vars.length; i++) {
                        if(!vars[i]) {
                            continue;
                        }
                        var pair = vars[i].split('=');  
                        if(pair.length < 2) {
                            continue;
                        }           
                        params[pair[0]] = pair[1];
                    }

                    if(params.gid) {
                        params.gid = parseInt(params.gid, 10);
                    }

                    return params;
                };

                var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
                    var pswpElement = document.querySelectorAll('.pswp')[0],
                        gallery,
                        options,
                        items;

                    items = parseThumbnailElements(galleryElement);

                    // define options (if needed)
                    options = {

                        // define gallery index (for URL)
                        galleryUID: galleryElement.getAttribute('data-pswp-uid'),

                        getThumbBoundsFn: function(index) {
                            // See Options -> getThumbBoundsFn section of documentation for more info
                            var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
                                pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                                rect = thumbnail.getBoundingClientRect(); 

                            return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
                        }

                    };

                    // PhotoSwipe opened from URL
                    if(fromURL) {
                        if(options.galleryPIDs) {
                            // parse real index when custom PIDs are used 
                            // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
                            for(var j = 0; j < items.length; j++) {
                                if(items[j].pid == index) {
                                    options.index = j;
                                    break;
                                }
                            }
                        } else {
                            // in URL indexes start from 1
                            options.index = parseInt(index, 10) - 1;
                        }
                    } else {
                        options.index = parseInt(index, 10);
                    }

                    // exit if index not found
                    if( isNaN(options.index) ) {
                        return;
                    }

                    if(disableAnimation) {
                        options.showAnimationDuration = 0;
                    }

                    // Pass data to PhotoSwipe and initialize it
                    gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
                    gallery.init();
                };

                // loop through all gallery elements and bind events
                var galleryElements = document.querySelectorAll( gallerySelector );

                for(var i = 0, l = galleryElements.length; i < l; i++) {
                    galleryElements[i].setAttribute('data-pswp-uid', i+1);
                    galleryElements[i].onclick = onThumbnailsClick;
                }

                // Parse URL and open gallery if it contains #&pid=3&gid=1
                var hashData = photoswipeParseHash();
                if(hashData.pid && hashData.gid) {
                    openPhotoSwipe( hashData.pid ,  galleryElements[ hashData.gid - 1 ], true, true );
                }
            };

            // execute above function
            initPhotoSwipeFromDOM('.masonry-flip-photoswipe');
        }

    }); // END READY

/* FUNCTION: PRELOADER - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
    function tlg_preloader() {
        jQuery('#tlg_preloader').css('opacity', 0);
        setTimeout(function() { jQuery('#tlg_preloader').hide(); }, 500);
    }

/* FUNCTION: MANSORY SHOW UP TRANSITION - - - - - - - - - - - - - - - - - - - - - - - - - - */
    function tlg_masonry_show() {
        var $items  = jQuery('.masonry-show .masonry-item');
        var time    = 0;
        $items.each(function() {
            var item = jQuery(this);
            setTimeout(function() {
                item.addClass('fadeIn');
            }, time);
            time += 350;
        });
    }

/* FUNCTION: UPDATE NAVIGATION - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
    function tlg_update_nav() {
        if (jQuery(window).width() > 990) {
            var tlg_section = tlg_nav.hasClass('transparent') ? parseInt(tlg_first_section_height) - parseInt(wp_data.wanium_menu_height) : parseInt(tlg_first_section_height) + parseInt(wp_data.wanium_menu_height);
            if (tlg_top_offset <= 0) {
                if (tlg_nav_fixed) { tlg_nav_fixed = false; tlg_nav.removeClass('fixed'); }
                if (tlg_nav_hide) { tlg_nav_hide = false; tlg_nav.removeClass('nav-hide'); }
                if (tlg_nav_show) { tlg_nav_show = false; tlg_nav.removeClass('nav-show'); }
                return;
            }
            if (tlg_top_offset > tlg_section) {
                if (!tlg_nav_show) { tlg_nav_show = true; tlg_nav.addClass('nav-show'); return; }
            } else {
                if (tlg_top_offset > tlg_nav_height) {
                    if (!tlg_nav_fixed) { tlg_nav_fixed = true;  tlg_nav.addClass('fixed'); }
                    if (tlg_top_offset > tlg_nav_height * 2) { if (!tlg_nav_hide) { tlg_nav_hide = true; tlg_nav.addClass('nav-hide'); } } 
                    else if (tlg_nav_hide) { tlg_nav_hide = false; tlg_nav.removeClass('nav-hide'); }
                } else { 
                    if (tlg_nav_fixed) { tlg_nav_fixed = false; tlg_nav.removeClass('fixed'); }
                    if (tlg_nav_hide) { tlg_nav_hide = false; tlg_nav.removeClass('nav-hide'); }
                }
                if (tlg_nav_show) { tlg_nav_show = false; tlg_nav.removeClass('nav-show'); }
            }
        }
        if (jQuery(window).width() <= 990) {
           if (!tlg_nav_fixed) { tlg_nav_fixed = true;  tlg_nav.addClass('fixed'); }
        }
    }

/* FUNCTION: VC SPACER - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */
    function tlg_vc_spacer() {
        jQuery('.tlg-spacer').each(function(i,e){
            var body_width = jQuery(window).width();
            var height_mobible = jQuery(e).data('height-mobile');
            var height_tablet = jQuery(e).data('height-tablet');
            var height = jQuery(e).data('height');
            if(body_width <= 768){
                jQuery(this).height(height_mobible);
            } else if (body_width >= 768 && body_width <= 1024){
                jQuery(this).height(height_tablet);
            } else if (body_width >= 1024){
                jQuery(this).height(height);
            }
        });
    }

})(jQuery); // END SCRIPT