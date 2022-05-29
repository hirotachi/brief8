(function ( $ ) {
	'use strict';

	// This case is important when theme is not active
	if ( typeof qodef !== 'object' ) {
		window.qodef = {};
	}

	window.qodefCore                = {};
	qodefCore.shortcodes            = {};
	qodefCore.listShortcodesScripts = {
		qodefSwiper: qodef.qodefSwiper,
		qodefPagination: qodef.qodefPagination,
		qodefFilter: qodef.qodefFilter,
		qodefMasonryLayout: qodef.qodefMasonryLayout,
		qodefJustifiedGallery: qodef.qodefJustifiedGallery,
	};

	qodefCore.body         = $( 'body' );
	qodefCore.html         = $( 'html' );
	qodefCore.windowWidth  = $( window ).width();
	qodefCore.windowHeight = $( window ).height();
	qodefCore.scroll       = 0;

	$( document ).ready(
		function () {
			qodefCore.scroll = $( window ).scrollTop();
			qodefInlinePageStyle.init();
			qodefControlImage.init();
			qodefSmileyCursor.init();
			qodefRevMouseMove.init();
		}
	);

	$( window ).resize(
		function () {
			qodefCore.windowWidth  = $( window ).width();
			qodefCore.windowHeight = $( window ).height();
		}
	);

	$( window ).scroll(
		function () {
			qodefCore.scroll = $( window ).scrollTop();
		}
	);
	
	$( document ).on(
		'eldon_trigger_get_new_posts',
		function () {
			qodefSmileyCursor.init();
		}
	);

	var qodefScroll = {
		disable: function () {
			if ( window.addEventListener ) {
				window.addEventListener(
					'wheel',
					qodefScroll.preventDefaultValue,
					{ passive: false }
				);
			}
			
			document.onkeydown = qodefScroll.keyDown;
		},
		enable: function () {
			if ( window.removeEventListener ) {
				window.removeEventListener(
					'wheel',
					qodefScroll.preventDefaultValue,
					{ passive: false }
				);
			}
			window.onmousewheel = document.onmousewheel = document.onkeydown = null;
		},
		preventDefaultValue: function ( e ) {
			e = e || window.event;
			if ( e.preventDefault ) {
				e.preventDefault();
			}
			e.returnValue = false;
		},
		keyDown: function ( e ) {
			var keys = [37, 38, 39, 40];
			for ( var i = keys.length; i--; ) {
				if ( e.keyCode === keys[i] ) {
					qodefScroll.preventDefaultValue( e );
					return;
				}
			}
		}
	};

	qodefCore.qodefScroll = qodefScroll;

	var qodefPerfectScrollbar = {
		init: function ( $holder ) {
			if ( $holder.length ) {
				qodefPerfectScrollbar.qodefInitScroll( $holder );
			}
		},
		qodefInitScroll: function ( $holder ) {
			var $defaultParams = {
				wheelSpeed: 0.6,
				suppressScrollX: true
			};

			var $ps = new PerfectScrollbar(
				$holder[0],
				$defaultParams
			);

			$( window ).resize(
				function () {
					$ps.update();
				}
			);
		}
	};

	qodefCore.qodefPerfectScrollbar = qodefPerfectScrollbar;

	var qodefInlinePageStyle = {
		init: function () {
			this.holder = $( '#eldon-core-page-inline-style' );

			if ( this.holder.length ) {
				var style = this.holder.data( 'style' );

				if ( style.length ) {
					$( 'head' ).append( '<style type="text/css">' + style + '</style>' );
				}
			}
		}
	};

	qodefCore.qodefInlinePageStyle = qodefInlinePageStyle;
	
	/**
	 * Check element to be in the viewport
	 */
	var qodefIsInViewport = {
		check: function ( $element, callback, onlyOnce, callbackIfFalse = false ) {
			if ( $element.length ) {
				var offset = typeof $element.data( 'viewport-offset' ) !== 'undefined' ? $element.data( 'viewport-offset' ) : 0.1; // When item is 10% in the viewport
				
				var observer = new IntersectionObserver(
					function ( entries ) {
						// isIntersecting is true when element and viewport are overlapping
						// isIntersecting is false when element and viewport don't overlap
						if ( entries[0].isIntersecting === true ) {
							callback.call( $element );
							
							// Stop watching the element when it's initialize
							if ( onlyOnce !== false ) {
								observer.disconnect();
							}
						} else if ( callbackIfFalse !== false ){
							callbackIfFalse.call( $element );
						}
					},
					{ threshold: [offset] }
				);
				
				observer.observe( $element[0] );
			}
		},
	};
	
	qodefCore.qodefIsInViewport = qodefIsInViewport;

	var qodefControlImage = {
		init: function () {
			this.holder = $('.qodef--mouse-control-holder');

			if (this.holder.length && !Modernizr.touch && qodefCore.windowWidth > 1024) {
				this.holder.each(function () {
					var $holder = $(this);
					
					qodefControlImage.initMove($holder);
				});
			}
		},
		initMove: function ($holder) {
			var $items = $holder.find('.qodef--mouse-control-item'),
				mouse = {},
				limit = $holder.data('move-limit')? $holder.data('move-limit') : 50,
				speed = $holder.data('move-limit')? 7 : 5;
			
			var handleMove = function (e) {
				mouse = {
					x: e.pageX,
					y: e.pageY,
				}
			};

			var controlItems = function () {
				$items.each(function () {
					var $item = $(this);
						// $inner = $item.children(),
						// limit = 20;

					var cX, cY, w, h, x, y, inRange; //position variables

					var updatePosition = function () {
						cX = mouse.x;
						cY = mouse.y;
						w = $item.width();
						h = $item.height();
						x = $item.offset().left + w / 2;
						y = $item.offset().top + h / 2;
						inRange = Math.abs(x - cX) < w && Math.abs(y - cY) < h;
					}

					var coords = function () {
						return {
							x: Math.abs(cX - x) < limit ? cX - x : limit * (cX - x) / Math.abs(cX - x),
							y: Math.abs(cY - y) < limit ? cY - y : limit * (cY - y) / Math.abs(cY - y)
						}
					}

					var moveItem = function () {
						$item.addClass('qodef-moving');
						var deltaX = 0,
							deltaY = 0,
							dX = coords().x,
							dY = coords().y;

						var transformItem = function () {
							deltaX += (coords().x - dX) / speed;
							deltaY += (coords().y - dY) / speed;

							deltaX.toFixed(2) !== dX.toFixed(2) &&
							$item.css({
								'transform': 'translate3d(' + deltaX + 'px, ' + deltaY + 'px, 0)',
								'transition': 'none'
							});

							dX = deltaX;
							dY = deltaY;

							requestAnimationFrame(function () {
								inRange && transformItem();
							});
							
						}

						transformItem();
					}

					var resetItem = function () {
						$item
							.removeClass('qodef-moving')
							.css({
								'transition': 'transform .4s',
								'transform': 'translate3d(0px, 0px, 0px)'
							})
							.one(qodef.transitionEnd, function () {
								$item.removeClass('qodef-controlled');
								$item.css({
									'transition': 'none'
								});
							});
					}

					var setState = function () {
						updatePosition();

						if (inRange) {
							!$item.hasClass('qodef-moving') && moveItem(); //start move
						} else {
							$item.hasClass('qodef-moving') && resetItem(); //end move
						}

						requestAnimationFrame(setState);
					}

					requestAnimationFrame(setState);
				});
			};

			controlItems();
			$(window).on('mousemove', handleMove);
		},
	};
	
	qodefCore.qodefControlImage = qodefControlImage;
	
	var qodefRevMouseMove = {
		init: function () {
			this.holder = $('.qodef-rev-custom-shake-animation');
			
			if (this.holder.length && !Modernizr.touch && qodefCore.windowWidth > 1024) {
				this.holder.each(function () {
					var $holder = $(this);
					
					qodefRevMouseMove.addClass($holder);
				});
			}
		},
		addClass: function ($holder) {
			var timer,
				mouseStopped = function(){
					$holder.removeClass('qodef--moving');
				}
			
			$holder[0].addEventListener("mousemove",function(){
				$holder.addClass('qodef--moving');
				clearTimeout(timer);
				timer = setTimeout(mouseStopped,300);
			})
		},
	};
	
	qodefCore.qodefRevMouseMove = qodefRevMouseMove;
	
	var qodefSmileyCursor = {
		init: function () {
			this.holder = $(' .qodef-portfolio-list:not(.qodef-item-layout--featured-big).qodef--smiley-hover , .qodef-portfolio-list.qodef-item-layout--featured-big.qodef--smiley-hover, .qodef-portfolio-list-horizontal-holder.qodef--smiley-hover, .qodef--smiley-hover-custom-holder');
			
			if (this.holder.length && !Modernizr.touch && qodefCore.windowWidth > 1024) {
				this.holder.each(function () {
					var $holder = $(this);
					
					qodefSmileyCursor.initSmiley($holder);
				});
			}
		},
		initSmiley: function(holder) {
			if (!($('.qodef-e-smiley')).length) {
				qodefCore.body.append('<div class="qodef-e-smiley-holder"><div class="qodef-e-smiley"></div></div>');
			}
			
			var $contentFollow = $('.qodef-e-smiley-holder'),
				holderIsList = holder.hasClass('qodef-portfolio-list') || holder.hasClass('qodef-portfolio-list-horizontal-holder');
			
			
			function moveItem(e) {
				var mouseX = e.clientX,
					mouseY = e.clientY;
				
				gsap.to($contentFollow, {
					top: mouseY,
					left: mouseX,
					duration: .7,
				})
			}
			
			if (!holderIsList) {
				//info element position
				holder.on(
					'mousemove',
					function (e) {
						moveItem(e);
					}
				);
				
				//show/hide info element
				holder.on(
					'mouseenter',
					function () {
						if (!$contentFollow.hasClass('qodef-is-active')) {
							$contentFollow.addClass('qodef-is-active');
						}
					}
				).on(
					'mouseleave',
					function () {
						if ($contentFollow.hasClass('qodef-is-active')) {
							$contentFollow.removeClass('qodef-is-active');
						}
					}
				)
				
				if (holder.find('.qodef-image-with-text').length){
					var hideCursor = holder.find('.qodef-m-content');
					
					
					hideCursor.on(
						'mouseenter',
						function () {
							if ($contentFollow.hasClass('qodef-is-active')) {
								$contentFollow.removeClass('qodef-is-active');
							}
						}
					).on(
						'mouseleave',
						function () {
							if (!$contentFollow.hasClass('qodef-is-active')) {
								$contentFollow.addClass('qodef-is-active');
							}
						}
					)
					
				}
			} else {
				var item = holder.find('.qodef--custom-swiper .qodef-e-left-holder, .qodef--custom-swiper .qodef-e-media-second-image, .qodef-e-image, .qodef-plh-item');
				
				item.each(
					function () {
						var $thisItem = $(this);
						
						//info element position
						$thisItem.on(
							'mousemove',
							function (e) {
								moveItem(e);
							}
						);
						
						//show/hide info element
						$thisItem.on(
							'mouseenter',
							function () {
								if (!$contentFollow.hasClass('qodef-is-active')) {
									$contentFollow.addClass('qodef-is-active');
								}
							}
						).on(
							'mouseleave',
							function () {
								if ($contentFollow.hasClass('qodef-is-active')) {
									$contentFollow.removeClass('qodef-is-active');
								}
							}
						);
					}
				);
			}
		}
	}
	
	qodefCore.qodefSmileyCursor = qodefSmileyCursor;

})( jQuery );
