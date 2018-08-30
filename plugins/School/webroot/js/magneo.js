jQuery(document).ready(function() {
	/*
    jQuery('#ei-slider').eislideshow({
        animation: 'sides',
        autoplay: true,
        speed: 1000,
        titlespeed: 2000,
        slideshow_interval: 5000,
        titlesFactor: 0.6
    });
	
    jQuery('.ei-slider-picture').eislideshow({
        animation: 'sides',
        autoplay: true,
        speed: 1000,
        titlespeed: 2000,
        slideshow_interval: 5000,
        titlesFactor: 0.6
    });
	*/
    jQuery(".text-accord").accordion({
    });



    jQuery('.category-slider').mouseenter(function() {
        jQuery('a#next5').css("right", "35px");
    });

    jQuery('.category-slider').mouseleave(function() {
        jQuery('a#next5').css("right", "-30px");
    });
    jQuery('.category-slider').mouseenter(function() {
        jQuery('a#prev5').css("left", "35px");
    });
    jQuery('.category-slider').mouseleave(function() {
        jQuery('a#prev5').css("left", "-30px");
    });
    jQuery('.social-connect').hide();

    jQuery('.show-social').hover(function() {
        jQuery('.social-connect').show("slow");
    });
    jQuery('.sf-menu li').mouseenter(function() {
        jQuery(this).find('div>ul').slideDown('slow');
    });
    jQuery('.sf-menu>li').mouseleave(function() {
        jQuery(this).css("background", "transparent");
        jQuery(this).find('div>ul').slideUp('slow');
    });

    jQuery('#primary-menu').superfish({
    });
    jQuery('#secondary-menu').superfish({
    });
    jQuery("ul.sf-menu").superfish({
        animation: {height: 'show'},
        animationOut: {height: 'hide'},
        delay: 100               // 0.1 second delay on mouseout
    });

    jQuery('#primary-menu').tinyNav({
        header: jQuery('.text_select_main_menu').val() // Writing any title with this option triggers the header
    });
    jQuery('#secondary-menu').tinyNav({
        header: 'Top Menu' // Writing any title with this option triggers the header
    });
    jQuery('.carodiv').carouFredSel({
        responsive: true,
        auto: false,
        prev: '.prev',
        next: '.next',
        mousewheel: true,
        swipe: {
            onMouse: true,
            onTouch: true
        },
        width: '100%',
        height: '200px',
        scroll: 2,
        items: {
            width: 300, visible: {
                min: 1,
                max: 4
            }
        }
    });

    jQuery('.slider-caro').carouFredSel({
        items: 1,
        direction: "down",
        prev: '#next-sc',
        next: '#prev-sc',
        auto: {
            duration: 1000,
            timeoutDuration: 2000,
            pauseOnHover: true
        }
    });

    jQuery('.sidecaro').carouFredSel({
        responsive: true,
        auto: false,
        width: '100%',
        prev: '#prev4',
        next: '#next4',
        scroll: {
            duration: 750,
            pauseOnHover: true,
        },
        items: {
            width: 160, visible: {
                min: 1,
                max: 1

            }
        }
    });
    jQuery('.review-home').carouFredSel({
        responsive: true,
        auto: false,
        width: '100%',
        prev: '#prev-rv',
        next: '#next-rv',
        scroll: {
            duration: 750,
            pauseOnHover: true,
        },
        items: {visible: {
                min: 1,
                max: 1

            }
        }
    });

    jQuery('.review-two').carouFredSel({
        responsive: true,
        auto: false,
        width: '100%',
        prev: '#prev-rt',
        next: '#next-rt',
        scroll: {
            duration: 750,
            pauseOnHover: true,
        },
        items: {visible: {
                min: 2,
                max: 2

            }
        }
    });

    jQuery('.cat-slider').carouFredSel({
        responsive: true,
        auto: false,
        width: '100%',
        prev: '#prev5',
        next: '#next5',
        scroll: {
            duration: 750,
            timeoutDuration: 3000,
            pauseOnHover: true,
        },
        items: {
            visible: {
                min: 1,
                max: 1

            }
        }
    });
    jQuery('.breakcaro').carouFredSel({
        responsive: true,
        auto: true,
        width: '100%',
        scroll: {
            duration: 750,
            pauseOnHover: true,
        },
        items: {
            width: 160,
            visible: {
                min: 2,
                max: 2

            }
        }
    });
    jQuery('.videoflexslider').flexslider({
        animation: "slide",
        animationLoop: false,
        itemWidth: 200,
        itemMargin: 10,
        minItems: 2,
        maxItems: 3,
        start: function(slider) {
            jQuery('body').removeClass('loading');
        }
    });

    jQuery(".top-first ul > li:last-child")
            .css({
                "margin-right": "0"
            });
    jQuery(".three-cat-cover ul > li:last-child")
            .css({
                "margin-right": "0"
            });
    jQuery(".two-cat-cover ul > li:last-child")
            .css({
                "margin-right": "0"
            });
    jQuery(".sideboxes ul li:nth-child(2n)")
            .css({
                "margin-right": "0"
            });
    jQuery(".top-rest ul li:nth-child(2n)")
            .css({
                "margin-right": "0"
            });
    jQuery('#flexnav').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemWidth: 200,
        itemMargin: 5,
        asNavFor: '#mainslider'
    });

    jQuery('#mainslider').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        sync: "#flexnav"
    });




});