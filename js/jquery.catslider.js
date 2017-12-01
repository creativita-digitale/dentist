console.log(js_object.ajax_url);
                        
;( function( $, window, undefined ) {
	
	'use strict';
	window.onload = function() {
            if(!window.location.hash) {
                window.location = window.location + '#loaded';
                window.location.reload();
            }
        }
	
	$.CatSlider = function( options, element ) {
		this.$el = $( element );
		this._init( options );
	};

	$.CatSlider.prototype = {

		_init : function( options ) {
			
			this.cookie = this._getCookieData();
                        console.log('inside ------------> this.cookie.wizard_product_id = ' + this.cookie.wizard_product_id);
                        console.log('inside ------------> this.cookie.wizard_cat_id = ' + this.cookie.wizard_cat_id);
                       
			// the categories (ul)
			this.$categories = this.$el.children( 'ul' );
			// the navigation
			this.$navcategories = this.$el.find( 'nav > a' );
			var animEndEventNames = {
				'WebkitAnimation' : 'webkitAnimationEnd',
				'OAnimation' : 'oAnimationEnd',
				'msAnimation' : 'MSAnimationEnd',
				'animation' : 'animationend'
			};
			// animation end event name
			this.animEndEventName = animEndEventNames[ Modernizr.prefixed( 'animation' ) ];
			// animations and transforms support
			this.support = Modernizr.csstransforms && Modernizr.cssanimations;
			// if currently animating
			this.isAnimating = false;
			
			
			switch( this.cookie.wizard_cat_id ) {
				case js_object.spazzolini_id:
					this.currentStart = 0;
					break;
				case js_object.kit_id:
					this.currentStart = 1;
					break;
				case js_object.scovolini_id:
					this.currentStart = 2;
					break;
						
				default:
                                    if (this.currentStart === 0){
			console.log("qualcosa non va");
			}
					this.currentStart = 0;
                                        
			} 
			
			
			if (typeof console !== 'undefined' && console.error) {
                    //console.log('____________ raw: ' + js_object.cookie_cat_id_raw + ' cookie_cat_id: ' + js_object.cookie_cat_id + '_______________');
            }
			
			// current category
			this.current = this.currentStart;
			
				var $currcat = this.$categories.eq( this.currentStart );
			
			
			
			if( !this.support ) {
				this.$categories.hide();
				$currcat.show();
			}
			else {
				if (this.currentStart !== 0){
					$currcat.addClass( 'mi-current  mi-moveFromLeft' );
					this.$categories.not(':eq(' + this.currentStart +')').addClass( 'mi-moveToRight' ); 
				}else{
				$currcat.addClass( 'mi-current' );
				}
				
				
				$(document).trigger('classGiven');
			}
			// current nav category
			this.$navcategories.eq( this.currentStart ).addClass( 'mi-selected' ); 
			
			// initialize the events
			this._initEvents();
			

		},
		_initEvents : function() {
			
			var self = this;
			this.$navcategories.on( 'click.catslider', function() {
				self.showCategory( $( this ).index() );
				//self.showCategory( 3 );
				
				return false;
			} );

			// reset on window resize..
			/*$( window ).on( 'resize', function() {
				self.$categories.removeClass().eq( 0 ).addClass( 'mi-current' );
				self.$navcategories.eq( self.current ).removeClass( 'mi-selected' ).end().eq( 0 ).addClass( 'mi-selected' );
				self.current = 0;
				$(document).trigger('classGiven');
			} );
			*/

		},
		_getCookieData: function () {
			//window.alert('siiii');
             var cookie = Cookies.get('wiz');
			
			
            if (cookie) {
                cookie = decodeURIComponent(cookie);
                console.log(cookie);
                if (strpos(cookie, "=", 0)) {
                    this.cookieContent = parseQuery(cookie);

                }
            } else {
                this.cookieContent = {wizard_user_id: false, wizard_product_id: false, wizard_cat_id:false};
            }
			
			//console.log(this.cookieContent);
			
            return this.cookieContent; 
               /*  $.ajax({
                    url: js_object.ajax_url,
                    data: {
                        'action': 'wiz_get_cookie'
                    },
                    success: function (data) {
                    // window.alert('siiii');
                    cookie = decodeURIComponent(data);
                    //window.alert(cookie);
                        return cookie;
                        
                    }, error: function (){
                        window.alert('nooooo');
                    }*/
           // });
        },
		
		showCategory : function( catidx ) {

			if( catidx === this.current || this.isAnimating ) {
				return false;
			}
			this.isAnimating = true;
			// update selected navigation
			this.$navcategories.eq( this.current ).removeClass( 'mi-selected' ).end().eq( catidx ).addClass( 'mi-selected' );

			var dir = catidx > this.current ? 'right' : 'left',
				toClass = dir === 'right' ? 'mi-moveToLeft' : 'mi-moveToRight',
				fromClass = dir === 'right' ? 'mi-moveFromRight' : 'mi-moveFromLeft',
				// current category
				$currcat = this.$categories.eq( this.current ),
				// new category
				$newcat = this.$categories.eq( catidx ),
				$newcatchild = $newcat.children(),
				lastEnter = dir === 'right' ? $newcatchild.length - 1 : 0,
				self = this;

			if( this.support ) {

				$currcat.removeClass().addClass( toClass );
				
				setTimeout( function() {

					$newcat.removeClass().addClass( fromClass );
					$newcatchild.eq( lastEnter ).on( self.animEndEventName, function() {

						$( this ).off( self.animEndEventName );
						$newcat.addClass( 'mi-current' );
						$(document).trigger('classGiven');
						self.current = catidx;
						var $this = $( this );
						// solve chrome bug
						self.forceRedraw( $this.get(0) );
						self.isAnimating = false;

					} );

				}, $newcatchild.length * 90 );

			}
			else {

				$currcat.hide();
				$newcat.show();
				this.current = catidx;
				this.isAnimating = false;

			}

		},
		// based on http://stackoverflow.com/a/8840703/989439
		forceRedraw : function(element) {
			if (!element) { return; }
			var n = document.createTextNode(' '),
				position = element.style.position;
			element.appendChild(n);
			element.style.position = 'relative';
			setTimeout(function(){
				element.style.position = position;
				n.parentNode.removeChild(n);
			}, 25);
		}

	},

	$.fn.catslider = function( options ) {
		var instance = $.data( this, 'catslider' );
		if ( typeof options === 'string' ) {
			var args = Array.prototype.slice.call( arguments, 1 );
			this.each(function() {
				instance[ options ].apply( instance, args );
			});
		}
		else {
			this.each(function() {
				instance ? instance._init() : instance = $.data( this, 'catslider', new $.CatSlider( options, this ) );
			});
		}
		return instance;
	};

} )( jQuery, window );

jQuery(function() {
    jQuery('#mi-slider').catslider( );
});