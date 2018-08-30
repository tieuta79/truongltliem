(function( window, jQuery, undefined ) {
	
	/*
	* smartresize: debounced resize event for jQuery
	*
	* latest version and complete README available on Github:
	* https://github.com/louisremi/jquery.smartresize.js
	*
	* Copyright 2011 @louis_remi
	* Licensed under the MIT license.
	*/

	var jQueryevent = jQuery.event, resizeTimeout;

	jQueryevent.special.smartresize 	= {
		setup: function() {
			jQuery(this).bind( "resize", jQueryevent.special.smartresize.handler );
		},
		teardown: function() {
			jQuery(this).unbind( "resize", jQueryevent.special.smartresize.handler );
		},
		handler: function( event, execAsap ) {
			// Save the context
			var context = this,
				args 	= arguments;

			// set correct event type
			event.type = "smartresize";

			if ( resizeTimeout ) { clearTimeout( resizeTimeout ); }
			resizeTimeout = setTimeout(function() {
				jQuery.event.handle.apply( context, args );
			}, execAsap === "execAsap"? 0 : 100 );
		}
	};

	jQuery.fn.smartresize 			= function( fn ) {
		return fn ? this.bind( "smartresize", fn ) : this.trigger( "smartresize", ["execAsap"] );
	};
	
	jQuery.Slideshow 				= function( options, element ) {
	
		this.jQueryel			= jQuery( element );
		
		/***** images ****/
		
		// list of image items
		this.jQuerylist			= this.jQueryel.find('ul.ei-slider-large');
		// image items
		this.jQueryimgItems		= this.jQuerylist.children('li');
		// total number of items
		this.itemsCount		= this.jQueryimgItems.length;
		// images
		this.jQueryimages		= this.jQueryimgItems.find('img:first');
		
		/***** thumbs ****/
		
		// thumbs wrapper
		this.jQuerysliderthumbs	= this.jQueryel.find('ul.ei-slider-thumbs').hide();
		// slider elements
		this.jQuerysliderElems	= this.jQuerysliderthumbs.children('li');
		// sliding div
		this.jQuerysliderElem	= this.jQuerysliderthumbs.children('li.ei-slider-element');
		// thumbs
		this.jQuerythumbs		= this.jQuerysliderElems.not('.ei-slider-element');
		
		// initialize slideshow
		this._init( options );
		
	};
	
	jQuery.Slideshow.defaults 		= {
		// animation types:
		// "sides" : new slides will slide in from left / right
		// "center": new slides will appear in the center
		animation			: 'sides', // sides || center
		// if true the slider will automatically slide, and it will only stop if the user clicks on a thumb
		autoplay			: false,
		// interval for the slideshow
		slideshow_interval	: 3000,
		// speed for the sliding animation
		speed			: 800,
		// easing for the sliding animation
		easing			: '',
		// percentage of speed for the titles animation. Speed will be speed * titlesFactor
		titlesFactor		: 0.60,
		// titles animation speed
		titlespeed			: 800,
		// titles animation easing
		titleeasing			: '',
		// maximum width for the thumbs in pixels
		thumbMaxWidth		: 150
    };
	
	jQuery.Slideshow.prototype 		= {
		_init 				: function( options ) {
			
			this.options 		= jQuery.extend( true, {}, jQuery.Slideshow.defaults, options );
			
			// set the opacity of the title elements and the image items
			this.jQueryimgItems.css( 'opacity', 0 );
			this.jQueryimgItems.find('div.ei-title > *').css( 'opacity', 0 );
			
			// index of current visible slider
			this.current		= 0;
			
			var _self			= this;
			
			// preload images
			// add loading status
			this.jQueryloading		= jQuery('<div class="ei-slider-loading">Loading</div>').prependTo( _self.jQueryel );
			
			jQuery.when( this._preloadImages() ).done( function() {
				
				// hide loading status
				_self.jQueryloading.hide();
				
				// calculate size and position for each image
				_self._setImagesSize();
				
				// configure thumbs container
				_self._initThumbs();
				
				// show first
				_self.jQueryimgItems.eq( _self.current ).css({
					'opacity' 	: 1,
					'z-index'	: 10
				}).show().find('div.ei-title > *').css( 'opacity', 1 );
				
				// if autoplay is true
				if( _self.options.autoplay ) {
				
					_self._startSlideshow();
				
				}
				
				// initialize the events
				_self._initEvents();
			
			});
			
		},
		_preloadImages		: function() {
			
			// preloads all the large images
			
			var _self	= this,
				loaded	= 0;
			
			return jQuery.Deferred(
			
				function(dfd) {
			
					_self.jQueryimages.each( function( i ) {
						
						jQuery('<img/>').load( function() {
						
							if( ++loaded === _self.itemsCount ) {
							
								dfd.resolve();
								
							}
						
						}).attr( 'src', jQuery(this).attr('src') );
					
					});
					
				}
				
			).promise();
			
		},
		_setImagesSize		: function() {
			
			// save ei-slider's width
			this.elWidth	= this.jQueryel.width();
			
			var _self	= this;
			
			this.jQueryimages.each( function( i ) {
				
				var jQueryimg	= jQuery(this);
					imgDim	= _self._getImageDim( jQueryimg.attr('src') );
					
				jQueryimg.css({
					width		: imgDim.width,
					height		: imgDim.height,
					marginLeft	: imgDim.left,
					marginTop	: imgDim.top
				});
				
			});
		
		},
		_getImageDim		: function( src ) {
			
			var jQueryimg    = new Image();
							
			jQueryimg.src    = src;
					
			var c_w		= this.elWidth,
				c_h		= this.jQueryel.height(),
				r_w		= c_h / c_w,
				
				i_w		= jQueryimg.width,
				i_h		= jQueryimg.height,
				r_i		= i_h / i_w,
				new_w, new_h, new_left, new_top;
					
			if( r_w > r_i ) {
				
				new_h	= c_h;
				new_w	= c_h / r_i;
			
			}
			else {
			
				new_h	= c_w * r_i;
				new_w	= c_w;
			
			}
					
			return {
				width	: new_w,
				height	: new_h,
				left	: ( c_w - new_w ) / 2,
				top		: ( c_h - new_h ) / 2
			};
		
		},
		_initThumbs			: function() {
		
			// set the max-width of the slider elements to the one set in the plugin's options
			// also, the width of each slider element will be 100% / total number of elements
			this.jQuerysliderElems.css({
				'max-width' : this.options.thumbMaxWidth + 'px',
				'width'		: 100 / this.itemsCount + '%'
			});
			
			// set the max-width of the slider and show it
			this.jQuerysliderthumbs.css( 'max-width', this.options.thumbMaxWidth * this.itemsCount + 'px' ).show();
			
		},
		_startSlideshow		: function() {
		
			var _self	= this;
			
			this.slideshow	= setTimeout( function() {
				
				var pos;
				
				( _self.current === _self.itemsCount - 1 ) ? pos = 0 : pos = _self.current + 1;
				
				_self._slideTo( pos );
				
				if( _self.options.autoplay ) {
				
					_self._startSlideshow();
				
				}
			
			}, this.options.slideshow_interval);
		
		},
		// shows the clicked thumb's slide
		_slideTo			: function( pos ) {
			
			// return if clicking the same element or if currently animating
			if( pos === this.current || this.isAnimating )
				return false;
			
			this.isAnimating	= true;
			
			var jQuerycurrentSlide	= this.jQueryimgItems.eq( this.current ),
				jQuerynextSlide		= this.jQueryimgItems.eq( pos ),
				_self			= this,
				
				preCSS			= {zIndex	: 10},
				animCSS			= {opacity	: 1};
			
			// new slide will slide in from left or right side
			if( this.options.animation === 'sides' ) {
				
				preCSS.left		= ( pos > this.current ) ? -1 * this.elWidth : this.elWidth;
				animCSS.left	= 0;
			
			}	
			
			// titles animation
			jQuerynextSlide.find('div.ei-title > h2')
					  .css( 'margin-right', 50 + 'px' )
					  .stop()
					  .delay( this.options.speed * this.options.titlesFactor )
					  .animate({ marginRight : 0 + 'px', opacity : 1 }, this.options.titlespeed, this.options.titleeasing )
					  .end()
					  .find('div.ei-title > h3')
					  .css( 'margin-right', -50 + 'px' )
					  .stop()
					  .delay( this.options.speed * this.options.titlesFactor )
					  .animate({ marginRight : 0 + 'px', opacity : 1 }, this.options.titlespeed, this.options.titleeasing )
			
			jQuery.when(
				
				// fade out current titles
				jQuerycurrentSlide.css( 'z-index' , 1 ).find('div.ei-title > *').stop().fadeOut( this.options.speed / 2, function() {
					// reset style
					jQuery(this).show().css( 'opacity', 0 );	
				}),
				
				// animate next slide in
				jQuerynextSlide.css( preCSS ).stop().animate( animCSS, this.options.speed, this.options.easing ),
				
				// "sliding div" moves to new position
				this.jQuerysliderElem.stop().animate({
					left	: this.jQuerythumbs.eq( pos ).position().left
				}, this.options.speed )
				
			).done( function() {
				
				// reset values
				jQuerycurrentSlide.css( 'opacity' , 0 ).find('div.ei-title > *').css( 'opacity', 0 );
					_self.current	= pos;
					_self.isAnimating		= false;
				
				});
				
		},
		_initEvents			: function() {
			
			var _self	= this;
			
			// window resize
			jQuery(window).on( 'smartresize.eislideshow', function( event ) {
				
				// resize the images
				_self._setImagesSize();
			
				// reset position of thumbs sliding div
				_self.jQuerysliderElem.css( 'left', _self.jQuerythumbs.eq( _self.current ).position().left );
			
			});
			
			// click the thumbs
			this.jQuerythumbs.on( 'click.eislideshow', function( event ) {
				
				if( _self.options.autoplay ) {
				
					clearTimeout( _self.slideshow );
					_self.options.autoplay	= false;
				
				}
				
				var jQuerythumb	= jQuery(this),
					idx		= jQuerythumb.index() - 1; // exclude sliding div
					
				_self._slideTo( idx );
				
				return false;
			
			});
			
		}
	};
	
	var logError 				= function( message ) {
		
		if ( this.console ) {
			
			console.error( message );
			
		}
		
	};
	
	jQuery.fn.eislideshow			= function( options ) {
	
		if ( typeof options === 'string' ) {
		
			var args = Array.prototype.slice.call( arguments, 1 );

			this.each(function() {
			
				var instance = jQuery.data( this, 'eislideshow' );
				
				if ( !instance ) {
					logError( "cannot call methods on eislideshow prior to initialization; " +
					"attempted to call method '" + options + "'" );
					return;
				}
				
				if ( !jQuery.isFunction( instance[options] ) || options.charAt(0) === "_" ) {
					logError( "no such method '" + options + "' for eislideshow instance" );
					return;
				}
				
				instance[ options ].apply( instance, args );
			
			});
		
		} 
		else {
		
			this.each(function() {
			
				var instance = jQuery.data( this, 'eislideshow' );
				if ( !instance ) {
					jQuery.data( this, 'eislideshow', new jQuery.Slideshow( options, this ) );
				}
			
			});
		
		}
		
		return this;
		
	};
	
})( window, jQuery );