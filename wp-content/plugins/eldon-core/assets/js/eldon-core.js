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

(function ( $ ) {
	'use strict';

	$( document ).ready(
	    function () {
            qodefBackToTop.init();
        }
	);

	var qodefBackToTop = {
		init: function () {
			this.holder = $( '#qodef-back-to-top' );

			if ( this.holder.length ) {
				// Scroll To Top
				this.holder.on(
					'click',
					function ( e ) {
						e.preventDefault();
						qodefBackToTop.animateScrollToTop();
					}
				);

				qodefBackToTop.showHideBackToTop();
			}
		},
		animateScrollToTop: function () {
			var startPos = qodef.scroll,
				newPos   = qodef.scroll,
				step     = .9,
				animationFrameId;

			var startAnimation = function () {
				if ( newPos === 0 ) {
					return;
				}

				newPos < 0.0001 ? newPos = 0 : null;

				var ease = qodefBackToTop.easingFunction( (startPos - newPos) / startPos );
				$( 'html, body' ).scrollTop( startPos - (startPos - newPos) * ease );
				newPos = newPos * step;

				animationFrameId = requestAnimationFrame( startAnimation );
			};
			startAnimation();
			$( window ).one(
				'wheel touchstart',
				function () {
					cancelAnimationFrame( animationFrameId );
				}
			);
		},
		easingFunction: function ( n ) {
			return 0 == n ? 0 : Math.pow( 1024, n - 1 );
		},
		showHideBackToTop: function () {
			$( window ).scroll(
				function () {
					var $thisItem = $( this ),
						b         = $thisItem.scrollTop(),
						c         = $thisItem.height(),
						d;

					if ( b > 0 ) {
						d = b + c / 2;
					} else {
						d = 1;
					}

					if ( d < 1e3 ) {
						qodefBackToTop.addClass( 'off' );
					} else {
						qodefBackToTop.addClass( 'on' );
					}
				}
			);
		},
		addClass: function ( a ) {
			this.holder.removeClass( 'qodef--off qodef--on' );

			if ( a === 'on' ) {
				this.holder.addClass( 'qodef--on' );
			} else {
				this.holder.addClass( 'qodef--off' );
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( window ).on(
		'load',
		function () {
			qodefUncoverFooter.init();
		}
	);

	var qodefUncoverFooter = {
		holder: '',
		init: function () {
			this.holder = $( '#qodef-page-footer.qodef--uncover' );

			if ( this.holder.length && ! qodefCore.html.hasClass( 'touchevents' ) ) {
				qodefUncoverFooter.addClass();
				qodefUncoverFooter.setHeight( this.holder );

				$( window ).resize(
					function () {
						qodefUncoverFooter.setHeight( qodefUncoverFooter.holder );
					}
				);
			}
		},
		setHeight: function ( $holder ) {
			$holder.css( 'height', 'auto' );

			var footerHeight = $holder.outerHeight();

			if ( footerHeight > 0 ) {
				$( '#qodef-page-outer' ).css(
					{
						'margin-bottom': footerHeight,
						'background-color': qodefCore.body.css( 'backgroundColor' )
					}
				);

				$holder.css( 'height', footerHeight );
			}
		},
		addClass: function () {
			qodefCore.body.addClass( 'qodef-page-footer--uncover' );
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefFullscreenMenu.init();
		}
	);

	var qodefFullscreenMenu = {
		init: function () {
			var $fullscreenMenuOpener = $( 'a.qodef-fullscreen-menu-opener' ),
				$menuItems            = $( '#qodef-fullscreen-area nav ul li a' );

			// Open popup menu
			$fullscreenMenuOpener.on(
				'click',
				function ( e ) {
					e.preventDefault();
					var $thisOpener = $( this );

					if ( ! qodefCore.body.hasClass( 'qodef-fullscreen-menu--opened' ) ) {
						qodefFullscreenMenu.openFullscreen( $thisOpener );

						$( document ).keyup(
							function ( e ) {
								if ( e.keyCode === 27 ) {
									qodefFullscreenMenu.closeFullscreen( $thisOpener );
								}
							}
						);
					} else {
						qodefFullscreenMenu.closeFullscreen( $thisOpener );
					}
				}
			);

			//open dropdowns
			$menuItems.on(
				'tap click',
				function ( e ) {
					var $thisItem = $( this );

					if ( $thisItem.parent().hasClass( 'menu-item-has-children' ) ) {
						e.preventDefault();
						qodefFullscreenMenu.clickItemWithChild( $thisItem );
					} else if ( $thisItem.attr( 'href' ) !== 'http://#' && $thisItem.attr( 'href' ) !== '#' ) {
						qodefFullscreenMenu.closeFullscreen( $fullscreenMenuOpener );
					}
				}
			);
		},
		openFullscreen: function ( $opener ) {
			$opener.addClass( 'qodef--opened' );
			qodefCore.body.removeClass( 'qodef-fullscreen-menu-animate--out' ).addClass( 'qodef-fullscreen-menu--opened qodef-fullscreen-menu-animate--in' );
			qodefCore.qodefScroll.disable();
		},
		closeFullscreen: function ( $opener ) {
			$opener.removeClass( 'qodef--opened' );
			qodefCore.body.removeClass( 'qodef-fullscreen-menu--opened qodef-fullscreen-menu-animate--in' ).addClass( 'qodef-fullscreen-menu-animate--out' );
			qodefCore.qodefScroll.enable();
			$( 'nav.qodef-fullscreen-menu ul.sub_menu' ).slideUp( 200 );
		},
		clickItemWithChild: function ( thisItem ) {
			var $thisItemParent  = thisItem.parent(),
				$thisItemSubMenu = $thisItemParent.find( '.sub-menu' ).first();

			if ( $thisItemSubMenu.is( ':visible' ) ) {
				$thisItemSubMenu.slideUp( 300 );
				$thisItemParent.removeClass( 'qodef--opened' );
			} else {
				$thisItemSubMenu.slideDown( 300 );
				$thisItemParent.addClass( 'qodef--opened' ).siblings().find( '.sub-menu' ).slideUp( 400 );
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefHeaderScrollAppearance.init();
		}
	);

	var qodefHeaderScrollAppearance = {
		appearanceType: function () {
			return qodefCore.body.attr( 'class' ).indexOf( 'qodef-header-appearance--' ) !== -1 ? qodefCore.body.attr( 'class' ).match( /qodef-header-appearance--([\w]+)/ )[1] : '';
		},
		init: function () {
			var appearanceType = this.appearanceType();

			if ( appearanceType !== '' && appearanceType !== 'none' ) {
				qodefCore[appearanceType + 'HeaderAppearance']();
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
	    function () {
            qodefMobileHeaderAppearance.init();
        }
	);

	/*
	 **	Init mobile header functionality
	 */
	var qodefMobileHeaderAppearance = {
		init: function () {
			if ( qodefCore.body.hasClass( 'qodef-mobile-header-appearance--sticky' ) ) {

				var docYScroll1   = qodefCore.scroll,
					displayAmount = qodefGlobal.vars.mobileHeaderHeight + qodefGlobal.vars.adminBarHeight,
					$pageOuter    = $( '#qodef-page-outer' );

				qodefMobileHeaderAppearance.showHideMobileHeader( docYScroll1, displayAmount, $pageOuter );

				$( window ).scroll(
				    function () {
                        qodefMobileHeaderAppearance.showHideMobileHeader( docYScroll1, displayAmount, $pageOuter );
                        docYScroll1 = qodefCore.scroll;
                    }
				);

				$( window ).resize(
				    function () {
                        $pageOuter.css( 'padding-top', 0 );
                        qodefMobileHeaderAppearance.showHideMobileHeader( docYScroll1, displayAmount, $pageOuter );
                    }
				);
			}
		},
		showHideMobileHeader: function ( docYScroll1, displayAmount, $pageOuter ) {
			if ( qodefCore.windowWidth <= 1024 ) {
				if ( qodefCore.scroll > displayAmount * 2 ) {
					//set header to be fixed
					qodefCore.body.addClass( 'qodef-mobile-header--sticky' );

					//add transition to it
					setTimeout(
						function () {
							qodefCore.body.addClass( 'qodef-mobile-header--sticky-animation' );
						},
						300
					); //300 is duration of sticky header animation

					//add padding to content so there is no 'jumping'
					$pageOuter.css( 'padding-top', qodefGlobal.vars.mobileHeaderHeight );
				} else {
					//unset fixed header
					qodefCore.body.removeClass( 'qodef-mobile-header--sticky' );

					//remove transition
					setTimeout(
						function () {
							qodefCore.body.removeClass( 'qodef-mobile-header--sticky-animation' );
						},
						300
					); //300 is duration of sticky header animation

					//remove padding from content since header is not fixed anymore
					$pageOuter.css( 'padding-top', 0 );
				}

				if ( (qodefCore.scroll > docYScroll1 && qodefCore.scroll > displayAmount) || (qodefCore.scroll < displayAmount * 3) ) {
					//show sticky header
					qodefCore.body.removeClass( 'qodef-mobile-header--sticky-display' );
				} else {
					//hide sticky header
					qodefCore.body.addClass( 'qodef-mobile-header--sticky-display' );
				}
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefNavMenu.init();
		}
	);

	var qodefNavMenu = {
		init: function () {
			qodefNavMenu.dropdownBehavior();
			qodefNavMenu.wideDropdownPosition();
			qodefNavMenu.dropdownPosition();
		},
		dropdownBehavior: function () {
			var $menuItems = $( '.qodef-header-navigation > ul > li' );

			$menuItems.each(
				function () {
					var $thisItem = $( this );

					if ( $thisItem.find( '.qodef-drop-down-second' ).length ) {
						$thisItem.waitForImages(
							function () {
								var $dropdownHolder      = $thisItem.find( '.qodef-drop-down-second' ),
									$dropdownMenuItem    = $dropdownHolder.find( '.qodef-drop-down-second-inner ul' ),
									dropDownHolderHeight = $dropdownMenuItem.outerHeight();

								if ( navigator.userAgent.match( /(iPod|iPhone|iPad)/ ) ) {
									$thisItem.on(
										'touchstart mouseenter',
										function () {
											$dropdownHolder.css(
												{
													'height': dropDownHolderHeight,
													'overflow': 'visible',
													'visibility': 'visible',
													'opacity': '1',
												}
											);
										}
									).on(
										'mouseleave',
										function () {
											$dropdownHolder.css(
												{
													'height': '0px',
													'overflow': 'hidden',
													'visibility': 'hidden',
													'opacity': '0',
												}
											);
										}
									);
								} else {
									if ( qodefCore.body.hasClass( 'qodef-drop-down-second--animate-height' ) ) {
										var animateConfig = {
											interval: 0,
											over: function () {
												setTimeout(
													function () {
														$dropdownHolder.addClass( 'qodef-drop-down--start' ).css(
															{
																'visibility': 'visible',
																'height': '0',
																'opacity': '1',
															}
														);
														$dropdownHolder.stop().animate(
															{
																'height': dropDownHolderHeight,
															},
															400,
															'linear',
															function () {
																$dropdownHolder.css( 'overflow', 'visible' );
															}
														);
													},
													100
												);
											},
											timeout: 100,
											out: function () {
												$dropdownHolder.stop().animate(
													{
														'height': '0',
														'opacity': 0,
													},
													100,
													function () {
														$dropdownHolder.css(
															{
																'overflow': 'hidden',
																'visibility': 'hidden',
															}
														);
													}
												);

												$dropdownHolder.removeClass( 'qodef-drop-down--start' );
											}
										};

										$thisItem.hoverIntent( animateConfig );
									} else {
										var config = {
											interval: 0,
											over: function () {
												setTimeout(
													function () {
														$dropdownHolder.addClass( 'qodef-drop-down--start' ).stop().css( { 'height': dropDownHolderHeight } );
													},
													150
												);
											},
											timeout: 150,
											out: function () {
												$dropdownHolder.stop().css( { 'height': '0' } ).removeClass( 'qodef-drop-down--start' );
											}
										};

										$thisItem.hoverIntent( config );
									}
								}
							}
						);
					}
				}
			);
		},
		wideDropdownPosition: function () {
			var $menuItems = $( '.qodef-header-navigation > ul > li.qodef-menu-item--wide' );

			if ( $menuItems.length ) {
				$menuItems.each(
					function () {
						var $menuItem        = $( this );
						var $menuItemSubMenu = $menuItem.find( '.qodef-drop-down-second' );
						var $passepartoutWidth = 0;

						if ( qodefCore.body.hasClass( 'qodef--passepartout' ) ) {
							$passepartoutWidth = parseInt( $( '.qodef--passepartout' ).css( 'padding-left' ) );
						}

						if ( $menuItemSubMenu.length ) {
							$menuItemSubMenu.css( 'left', 0 );

							var leftPosition = $menuItemSubMenu.offset().left;

							if ( qodefCore.body.hasClass( 'qodef--boxed' ) ) {
								//boxed layout case
								var boxedWidth = $( '.qodef--boxed #qodef-page-wrapper' ).outerWidth();
								leftPosition   = leftPosition - (qodefCore.windowWidth - boxedWidth) / 2;
								$menuItemSubMenu.css( { 'left': -leftPosition, 'width': boxedWidth } );

							} else if ( qodefCore.body.hasClass( 'qodef-drop-down-second--full-width' ) ) {
								//wide dropdown full width case
								$menuItemSubMenu.css( { 'left': -leftPosition + $passepartoutWidth, 'width': qodefCore.windowWidth - 2 * $passepartoutWidth } );
							} else {
								//wide dropdown in grid case
								$menuItemSubMenu.css( { 'left': -leftPosition + (qodefCore.windowWidth - $menuItemSubMenu.width()) / 2 } );
							}
						}
					}
				);
			}
		},
		dropdownPosition: function () {
			var $menuItems = $( '.qodef-header-navigation > ul > li.qodef-menu-item--narrow.menu-item-has-children' );

			if ( $menuItems.length ) {
				$menuItems.each(
					function () {
						var $thisItem         = $( this ),
							menuItemPosition  = $thisItem.offset().left,
							$dropdownHolder   = $thisItem.find( '.qodef-drop-down-second' ),
							$dropdownMenuItem = $dropdownHolder.find( '.qodef-drop-down-second-inner ul' ),
							dropdownMenuWidth = $dropdownMenuItem.outerWidth(),
							menuItemFromLeft  = $( window ).width() - menuItemPosition;

						if ( qodef.body.hasClass( 'qodef--boxed' ) ) {
							//boxed layout case
							var boxedWidth   = $( '.qodef--boxed #qodef-page-wrapper' ).outerWidth();
							menuItemFromLeft = boxedWidth - menuItemPosition;
						}

						var dropDownMenuFromLeft;

						if ( $thisItem.find( 'li.menu-item-has-children' ).length > 0 ) {
							dropDownMenuFromLeft = menuItemFromLeft - dropdownMenuWidth;
						}

						$dropdownHolder.removeClass( 'qodef-drop-down--right' );
						$dropdownMenuItem.removeClass( 'qodef-drop-down--right' );
						if ( menuItemFromLeft < dropdownMenuWidth || dropDownMenuFromLeft < dropdownMenuWidth ) {
							$dropdownHolder.addClass( 'qodef-drop-down--right' );
							$dropdownMenuItem.addClass( 'qodef-drop-down--right' );
						}
					}
				);
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( window ).on(
		'load',
		function () {
			qodefParallaxBackground.init();
		}
	);

	/**
	 * Init global parallax background functionality
	 */
	var qodefParallaxBackground = {
		init: function ( settings ) {
			this.$sections = $( '.qodef-parallax' );

			// Allow overriding the default config
			$.extend( this.$sections, settings );

			var isSupported = ! qodefCore.html.hasClass( 'touchevents' ) && ! qodefCore.body.hasClass( 'qodef-browser--edge' ) && ! qodefCore.body.hasClass( 'qodef-browser--ms-explorer' );

			if ( this.$sections.length && isSupported ) {
				this.$sections.each(
					function () {
						qodefParallaxBackground.ready( $( this ) );
					}
				);
			}
		},
		ready: function ( $section ) {
			$section.$imgHolder  = $section.find( '.qodef-parallax-img-holder' );
			$section.$imgWrapper = $section.find( '.qodef-parallax-img-wrapper' );
			$section.$img        = $section.find( 'img.qodef-parallax-img' );

			var h           = $section.height(),
				imgWrapperH = $section.$imgWrapper.height();

			$section.movement = 100 * (imgWrapperH - h) / h / 2; //percentage (divided by 2 due to absolute img centering in CSS)

			$section.buffer       = window.pageYOffset;
			$section.scrollBuffer = null;


			//calc and init loop
			requestAnimationFrame(
				function () {
					$section.$imgHolder.animate( { opacity: 1 }, 100 );
					qodefParallaxBackground.calc( $section );
					qodefParallaxBackground.loop( $section );
				}
			);

			//recalc
			$( window ).on(
				'resize',
				function () {
					qodefParallaxBackground.calc( $section );
				}
			);
		},
		calc: function ( $section ) {
			var wH = $section.$imgWrapper.height(),
				wW = $section.$imgWrapper.width();

			if ( $section.$img.width() < wW ) {
				$section.$img.css(
					{
						'width': '100%',
						'height': 'auto',
					}
				);
			}

			if ( $section.$img.height() < wH ) {
				$section.$img.css(
					{
						'height': '100%',
						'width': 'auto',
						'max-width': 'unset',
					}
				);
			}
		},
		loop: function ( $section ) {
			if ( $section.scrollBuffer === Math.round( window.pageYOffset ) ) {
				requestAnimationFrame(
					function () {
						qodefParallaxBackground.loop( $section );
					}
				); //repeat loop

				return false; //same scroll value, do nothing
			} else {
				$section.scrollBuffer = Math.round( window.pageYOffset );
			}

			var wH   = window.outerHeight,
				sTop = $section.offset().top,
				sH   = $section.height();

			if ( $section.scrollBuffer + wH * 1.2 > sTop && $section.scrollBuffer < sTop + sH ) {
				var delta = (Math.abs( $section.scrollBuffer + wH - sTop ) / (wH + sH)).toFixed( 4 ), //coeff between 0 and 1 based on scroll amount
					yVal  = (delta * $section.movement).toFixed( 4 );

				if ( $section.buffer !== delta ) {
					$section.$imgWrapper.css( 'transform', 'translate3d(0,' + yVal + '%, 0)' );
				}

				$section.buffer = delta;
			}

			requestAnimationFrame(
				function () {
					qodefParallaxBackground.loop( $section );
				}
			); //repeat loop
		}
	};

	qodefCore.qodefParallaxBackground = qodefParallaxBackground;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefSideArea.init();
		}
	);

	var qodefSideArea = {
		init: function () {
			var $sideAreaOpener = $( 'a.qodef-side-area-opener' ),
				$sideAreaClose  = $( '#qodef-side-area-close' ),
				$sideArea       = $( '#qodef-side-area' );

			qodefSideArea.openerHoverColor( $sideAreaOpener );

			// Open Side Area
			$sideAreaOpener.on(
				'click',
				function ( e ) {
					e.preventDefault();

					if ( ! qodefCore.body.hasClass( 'qodef-side-area--opened' ) ) {
						qodefSideArea.openSideArea();

						$( document ).keyup(
							function ( e ) {
								if ( e.keyCode === 27 ) {
									qodefSideArea.closeSideArea();
								}
							}
						);
					} else {
						qodefSideArea.closeSideArea();
					}
				}
			);

			$sideAreaClose.on(
				'click',
				function ( e ) {
					e.preventDefault();
					qodefSideArea.closeSideArea();
				}
			);

			if ( $sideArea.length && typeof qodefCore.qodefPerfectScrollbar === 'object' ) {
				qodefCore.qodefPerfectScrollbar.init( $sideArea );
			}
		},
		openSideArea: function () {
			var $wrapper      = $( '#qodef-page-wrapper' );
			var currentScroll = $( window ).scrollTop();

			$( '.qodef-side-area-cover' ).remove();
			$wrapper.prepend( '<div class="qodef-side-area-cover"/>' );
			qodefCore.body.removeClass( 'qodef-side-area-animate--out' ).addClass( 'qodef-side-area--opened qodef-side-area-animate--in' );

			$( '.qodef-side-area-cover' ).on(
				'click',
				function ( e ) {
					e.preventDefault();
					qodefSideArea.closeSideArea();
				}
			);

			$( window ).scroll(
				function () {
					if ( Math.abs( qodefCore.scroll - currentScroll ) > 400 ) {
						qodefSideArea.closeSideArea();
					}
				}
			);
		},
		closeSideArea: function () {
			qodefCore.body.removeClass( 'qodef-side-area--opened qodef-side-area-animate--in' ).addClass( 'qodef-side-area-animate--out' );
		},
		openerHoverColor: function ( $opener ) {
			if ( typeof $opener.data( 'hover-color' ) !== 'undefined' ) {
				var hoverColor    = $opener.data( 'hover-color' );
				var originalColor = $opener.css( 'color' );

				$opener.on(
					'mouseenter',
					function () {
						$opener.css( 'color', hoverColor );
					}
				).on(
					'mouseleave',
					function () {
						$opener.css( 'color', originalColor );
					}
				);
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';
	
	$( document ).ready(
		function () {
			qodefSpinner.init();
		}
	);
	
	$( window ).on(
		'load',
		function () {
			qodefSpinner.windowLoaded = true;
			
			if (document.visibilityState === 'visible') {
				qodefSpinner.fadeOutLoader();
			} else {
				document.addEventListener("visibilitychange", function() {
					if (document.visibilityState === 'visible') {
						qodefSpinner.fadeOutLoader();
					}
				});
			}
		}
	);
	
	$( window ).on(
		'elementor/frontend/init',
		function () {
			var isEditMode = Boolean( elementorFrontend.isEditMode() );
			
			if ( isEditMode ) {
				qodefSpinner.init( isEditMode );
			}
		}
	);
	
	var qodefSpinner = {
		holder: '',
		windowLoaded: false,
		init: function ( isEditMode ) {
			this.holder = $( '#qodef-page-spinner:not(.qodef--custom-spinner)' );
			
			if ( this.holder.length ) {
				qodefSpinner.animateSpinner( isEditMode );
				qodefSpinner.fadeOutAnimation();
			}
		},
		animateSpinner: function ( isEditMode ) {
			if ( isEditMode ) {
				qodefSpinner.fadeOutLoader();
			}
		},
		fadeOutLoader: function ( speed, delay, easing ) {
			speed  = speed ? speed : 600;
			delay  = delay ? delay : 3800;
			easing = easing ? easing : 'swing';
			
			var $holder = qodefSpinner.holder.length ? qodefSpinner.holder : $( '#qodef-page-spinner:not(.qodef--custom-spinner)' ),
				mainRevHolder = $('#qodef-main-rev-holder'),
				smiley = $('.qodef-m-smiley');
			
			if(smiley.length){
				setTimeout(function() {
					smiley.removeClass('qodef--animated');

					gsap.to(".qodef-m-smiley-holder", {
						duration: 1.1,
						y: '71vH',
						scaleY: 1.1,
						scaleX: 1.3,
						rotation: 740,
						delay: .2
					});
				}, delay - 500);
			}
			
			setTimeout(function() {
				$holder.addClass('qodef-animate-out');
			}, delay - 500);
			
			if(mainRevHolder.length){
				setTimeout(function() {
					mainRevHolder.find('rs-module').revstart();
				}, delay - 500);
			}
			
			$holder.delay( delay ).fadeOut( speed, easing );
			
			$( window ).on(
				'bind',
				'pageshow',
				function ( event ) {
					if ( event.originalEvent.persisted ) {
						$holder.fadeOut( speed, easing );
					}
				}
			);
		},
		fadeOutAnimation: function () {
			
			// Check for fade out animation
			if ( qodefCore.body.hasClass( 'qodef-spinner--fade-out' ) ) {
				var $pageHolder = $( '#qodef-page-wrapper' ),
					$linkItems  = $( 'a' );
				
				// If back button is pressed, than show content to avoid state where content is on display:none
				window.addEventListener(
					'pageshow',
					function ( event ) {
						var historyPath = event.persisted || (typeof window.performance !== 'undefined' && window.performance.navigation.type === 2);
						if ( historyPath && ! $pageHolder.is( ':visible' ) ) {
							$pageHolder.show();
						}
					}
				);
				
				$linkItems.on(
					'click',
					function ( e ) {
						var $clickedLink = $( this );
						
						if (
							e.which === 1 && // check if the left mouse button has been pressed
							$clickedLink.attr( 'href' ).indexOf( window.location.host ) >= 0 && // check if the link is to the same domain
							! $clickedLink.hasClass( 'remove' ) && // check is WooCommerce remove link
							$clickedLink.parent( '.product-remove' ).length <= 0 && // check is WooCommerce remove link
							$clickedLink.parents( '.woocommerce-product-gallery__image' ).length <= 0 && // check is product gallery link
							typeof $clickedLink.data( 'rel' ) === 'undefined' && // check pretty photo link
							typeof $clickedLink.attr( 'rel' ) === 'undefined' && // check VC pretty photo link
							! $clickedLink.hasClass( 'lightbox-active' ) && // check is lightbox plugin active
							(typeof $clickedLink.attr( 'target' ) === 'undefined' || $clickedLink.attr( 'target' ) === '_self') && // check if the link opens in the same window
							$clickedLink.attr( 'href' ).split( '#' )[0] !== window.location.href.split( '#' )[0] // check if it is an anchor aiming for a different page
						) {
							e.preventDefault();
							
							$pageHolder.fadeOut(
								600,
								'easeOutSine',
								function () {
									window.location = $clickedLink.attr( 'href' );
								}
							);
						}
					}
				);
			}
		}
	};
	
})( jQuery );
(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.eldon_core_button = {};

	$( document ).ready(
		function () {
			qodefButton.init();
		}
	);

	var qodefButton = {
		init: function () {
			this.buttons = $( '.qodef-button' );

			if ( this.buttons.length ) {
				this.buttons.each(
					function () {
						qodefButton.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			qodefButton.buttonHoverColor( $currentItem );
			qodefButton.buttonHoverBgColor( $currentItem );
			qodefButton.buttonHoverBorderColor( $currentItem );
		},
		buttonHoverColor: function ( $button ) {
			if ( typeof $button.data( 'hover-color' ) !== 'undefined' ) {
				var hoverColor    = $button.data( 'hover-color' );
				var originalColor = $button.css( 'color' );

				$button.on(
					'mouseenter touchstart',
					function () {
						qodefButton.changeColor( $button, 'color', hoverColor );
					}
				);
				$button.on(
					'mouseleave touchend',
					function () {
						qodefButton.changeColor( $button, 'color', originalColor );
					}
				);
			}
		},
		buttonHoverBgColor: function ( $button ) {
			if ( typeof $button.data( 'hover-background-color' ) !== 'undefined' ) {
				var hoverBackgroundColor    = $button.data( 'hover-background-color' );
				var originalBackgroundColor = $button.css( 'background-color' );

				$button.on(
					'mouseenter touchstart',
					function () {
						qodefButton.changeColor( $button, 'background-color', hoverBackgroundColor );
					}
				);
				$button.on(
					'mouseleave touchend',
					function () {
						qodefButton.changeColor( $button, 'background-color', originalBackgroundColor );
					}
				);
			}
		},
		buttonHoverBorderColor: function ( $button ) {
			if ( typeof $button.data( 'hover-border-color' ) !== 'undefined' ) {
				var hoverBorderColor    = $button.data( 'hover-border-color' );
				var originalBorderColor = $button.css( 'borderTopColor' );

				$button.on(
					'mouseenter touchstart',
					function () {
						qodefButton.changeColor( $button, 'border-color', hoverBorderColor );
					}
				);
				$button.on(
					'mouseleave touchend',
					function () {
						qodefButton.changeColor( $button, 'border-color', originalBorderColor );
					}
				);
			}
		},
		changeColor: function ( $button, cssProperty, color ) {
			$button.css( cssProperty, color );
		}
	};

	qodefCore.shortcodes.eldon_core_button.qodefButton = qodefButton;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.eldon_core_cards_gallery = {};

	$( document ).ready(
		function () {
			qodefCardsGallery.init();
		}
	);

	var qodefCardsGallery = {
		init: function () {
			this.holder = $( '.qodef-cards-gallery' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefCardsGallery.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			qodefCardsGallery.initCards( $currentItem );
			qodefCardsGallery.initBundle( $currentItem );
		},
		initCards: function ( $holder ) {
			var $cards = $holder.find( '.qodef-m-card' );
			$cards.each(
				function () {
					var $card = $( this );

					$card.on(
						'click',
						function () {
							if ( ! $cards.last().is( $card ) ) {
								$card.addClass( 'qodef-out qodef-animating' ).siblings().addClass( 'qodef-animating-siblings' );
								$card.detach();
								$card.insertAfter( $cards.last() );

								setTimeout(
									function () {
										$card.removeClass( 'qodef-out' );
									},
									200
								);

								setTimeout(
									function () {
										$card.removeClass( 'qodef-animating' ).siblings().removeClass( 'qodef-animating-siblings' );
									},
									1200
								);

								$cards = $holder.find( '.qodef-m-card' );

								return false;
							}
						}
					);
				}
			);
		},
		initBundle: function ( $holder ) {
			if ( $holder.hasClass( 'qodef-animation--bundle' ) && ! qodefCore.html.hasClass( 'touchevents' ) ) {
				$holder.appear(
					function () {
						$holder.addClass( 'qodef-appeared' );
						$holder.find( 'img' ).one(
							'animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd',
							function () {
								$( this ).addClass( 'qodef-animation-done' );
							}
						);
					},
					{ accX: 0, accY: -100 }
				);
			}
		}
	};

	qodefCore.shortcodes.eldon_core_cards_gallery.qodefCardsGallery = qodefCardsGallery;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.eldon_core_countdown = {};

	$( document ).ready(
		function () {
			qodefCountdown.init();
		}
	);

	var qodefCountdown = {
		init: function () {
			this.countdowns = $( '.qodef-countdown' );

			if ( this.countdowns.length ) {
				this.countdowns.each(
					function () {
						qodefCountdown.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			var $countdownElement = $currentItem.find( '.qodef-m-date' ),
				options           = qodefCountdown.generateOptions( $currentItem );

			qodefCountdown.initCountdown( $countdownElement, options );
		},
		generateOptions: function ( $countdown ) {
			var options  = {};
			options.date = typeof $countdown.data( 'date' ) !== 'undefined' ? $countdown.data( 'date' ) : null;

			options.weekLabel       = typeof $countdown.data( 'week-label' ) !== 'undefined' ? $countdown.data( 'week-label' ) : '';
			options.weekLabelPlural = typeof $countdown.data( 'week-label-plural' ) !== 'undefined' ? $countdown.data( 'week-label-plural' ) : '';

			options.dayLabel       = typeof $countdown.data( 'day-label' ) !== 'undefined' ? $countdown.data( 'day-label' ) : '';
			options.dayLabelPlural = typeof $countdown.data( 'day-label-plural' ) !== 'undefined' ? $countdown.data( 'day-label-plural' ) : '';

			options.hourLabel       = typeof $countdown.data( 'hour-label' ) !== 'undefined' ? $countdown.data( 'hour-label' ) : '';
			options.hourLabelPlural = typeof $countdown.data( 'hour-label-plural' ) !== 'undefined' ? $countdown.data( 'hour-label-plural' ) : '';

			options.minuteLabel       = typeof $countdown.data( 'minute-label' ) !== 'undefined' ? $countdown.data( 'minute-label' ) : '';
			options.minuteLabelPlural = typeof $countdown.data( 'minute-label-plural' ) !== 'undefined' ? $countdown.data( 'minute-label-plural' ) : '';

			options.secondLabel       = typeof $countdown.data( 'second-label' ) !== 'undefined' ? $countdown.data( 'second-label' ) : '';
			options.secondLabelPlural = typeof $countdown.data( 'second-label-plural' ) !== 'undefined' ? $countdown.data( 'second-label-plural' ) : '';

			return options;
		},
		initCountdown: function ( $countdownElement, options ) {
			var $weekHTML   = '<span class="qodef-digit-wrapper"><span class="qodef-digit">%w</span><span class="qodef-label">' + '%!w:' + options.weekLabel + ',' + options.weekLabelPlural + ';</span></span>';
			var $dayHTML    = '<span class="qodef-digit-wrapper"><span class="qodef-digit">%d</span><span class="qodef-label">' + '%!d:' + options.dayLabel + ',' + options.dayLabelPlural + ';</span></span>';
			var $hourHTML   = '<span class="qodef-digit-wrapper"><span class="qodef-digit">%H</span><span class="qodef-label">' + '%!H:' + options.hourLabel + ',' + options.hourLabelPlural + ';</span></span>';
			var $minuteHTML = '<span class="qodef-digit-wrapper"><span class="qodef-digit">%M</span><span class="qodef-label">' + '%!M:' + options.minuteLabel + ',' + options.minuteLabelPlural + ';</span></span>';
			var $secondHTML = '<span class="qodef-digit-wrapper"><span class="qodef-digit">%S</span><span class="qodef-label">' + '%!S:' + options.secondLabel + ',' + options.secondLabelPlural + ';</span></span>';

			$countdownElement.countdown(
				options.date,
				function ( event ) {
					$( this ).html( event.strftime( $weekHTML + $dayHTML + $hourHTML + $minuteHTML + $secondHTML ) );
				}
			);
		}
	};

	qodefCore.shortcodes.eldon_core_countdown.qodefCountdown = qodefCountdown;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.eldon_core_custom_font                    = {};
	qodefCore.shortcodes.eldon_core_custom_font.qodefInlinePageStyle = qodefCore.qodefInlinePageStyle;

	$(document).ready(function () {
		qodefCustomFont.init();
	});

	var qodefCustomFont = {
		init: function () {
			var $holder = $('.qodef-custom-font.qodef--has-appear');

			if ($holder.length) {
				$holder.each(function () {
					var $thisHolder = $(this);

					qodefCustomFont.addAnimatedPosition($thisHolder);
					qodefCustomFont.togleAppearClass($thisHolder);
				});
			}
		},
		addAnimatedPosition : ( holder ) =>{
			var $animatedText = holder.find('.qodef-animated-text-holder');

			if ($animatedText.length) {
				$animatedText.each( function(i) {
					var $thisAnimatedText = $(this);

					$thisAnimatedText.find('.qodef-animated-text-duplicate').css('--qodef-animated-index', i);
				})
			}
		},
		togleAppearClass : ( holder ) =>{
			qodefCore.qodefIsInViewport.check(
				holder,
				function () {
					holder.addClass('qodef-appear');
				}, false,
				function () {
					holder.removeClass('qodef-appear');
				}
			);
		}
	};

	qodefCore.shortcodes.eldon_core_custom_font.qodefCustomFont = qodefCustomFont;
})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.eldon_core_frame_slider = {};

	$( document ).ready(
		function () {
			qodefFrameSlider.init();
		}
	);

	var qodefFrameSlider = {
		init: function () {
			this.holder = $( '.qodef-frame-slider-holder' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefFrameSlider.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $holder ) {
			var $swiperHolder = $holder.find( '.qodef-m-swiper' ),
				$sliderHolder = $holder.find( '.qodef-m-items' ),
				$pagination   = $holder.find( '.swiper-pagination' );

			var $swiper = new Swiper(
				$swiperHolder,
				{
					slidesPerView: 'auto',
					centeredSlides: true,
					spaceBetween: 0,
					autoplay: {
						delay: 2500,
						disableOnInteraction: false,
					},
					loop: true,
					speed: 900,
					pagination: {
						el: $pagination,
						type: 'bullets',
						clickable: true,
					},
					on: {
						init: function () {
							setTimeout(
								function () {
									$sliderHolder.addClass( 'qodef-swiper--initialized' );
								},
								500
							);
						}
					},
				}
			);
			
			$( document ).on(
				'eldon_trigger_skin_switch',
				function () {
					$swiper.update();
					$swiper.slideNext();
				}
			);
		}
	};

	qodefCore.shortcodes.eldon_core_frame_slider.qodefFrameSlider = qodefFrameSlider;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.eldon_core_google_map = {};

	$( document ).ready(
		function () {
			qodefGoogleMap.init();
		}
	);

	var qodefGoogleMap = {
		init: function () {
			this.holder = $( '.qodef-google-map' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefGoogleMap.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			if ( typeof window.qodefGoogleMap !== 'undefined' ) {
				window.qodefGoogleMap.init( $currentItem.find( '.qodef-m-map' ) );
			}
		},
	};

	qodefCore.shortcodes.eldon_core_google_map.qodefGoogleMap = qodefGoogleMap;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.eldon_core_icon = {};

	$( document ).ready(
		function () {
			qodefIcon.init();
		}
	);

	var qodefIcon = {
		init: function () {
			this.icons = $( '.qodef-icon-holder' );

			if ( this.icons.length ) {
				this.icons.each(
					function () {
						qodefIcon.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			qodefIcon.iconHoverColor( $currentItem );
			qodefIcon.iconHoverBgColor( $currentItem );
			qodefIcon.iconHoverBorderColor( $currentItem );
		},
		iconHoverColor: function ( $iconHolder ) {
			if ( typeof $iconHolder.data( 'hover-color' ) !== 'undefined' ) {
				var spanHolder    = $iconHolder.find( 'span' ).length ? $iconHolder.find( 'span' ) : $iconHolder;
				var originalColor = spanHolder.css( 'color' );
				var hoverColor    = $iconHolder.data( 'hover-color' );

				$iconHolder.on(
					'mouseenter',
					function () {
						qodefIcon.changeColor(
							spanHolder,
							'color',
							hoverColor
						);
					}
				);
				$iconHolder.on(
					'mouseleave',
					function () {
						qodefIcon.changeColor(
							spanHolder,
							'color',
							originalColor
						);
					}
				);
			}
		},
		iconHoverBgColor: function ( $iconHolder ) {
			if ( typeof $iconHolder.data( 'hover-background-color' ) !== 'undefined' ) {
				var hoverBackgroundColor    = $iconHolder.data( 'hover-background-color' );
				var originalBackgroundColor = $iconHolder.css( 'background-color' );

				$iconHolder.on(
					'mouseenter',
					function () {
						qodefIcon.changeColor(
							$iconHolder,
							'background-color',
							hoverBackgroundColor
						);
					}
				);
				$iconHolder.on(
					'mouseleave',
					function () {
						qodefIcon.changeColor(
							$iconHolder,
							'background-color',
							originalBackgroundColor
						);
					}
				);
			}
		},
		iconHoverBorderColor: function ( $iconHolder ) {
			if ( typeof $iconHolder.data( 'hover-border-color' ) !== 'undefined' ) {
				var hoverBorderColor    = $iconHolder.data( 'hover-border-color' );
				var originalBorderColor = $iconHolder.css( 'borderTopColor' );

				$iconHolder.on(
					'mouseenter',
					function () {
						qodefIcon.changeColor(
							$iconHolder,
							'border-color',
							hoverBorderColor
						);
					}
				);
				$iconHolder.on(
					'mouseleave',
					function () {
						qodefIcon.changeColor(
							$iconHolder,
							'border-color',
							originalBorderColor
						);
					}
				);
			}
		},
		changeColor: function ( iconElement, cssProperty, color ) {
			iconElement.css(
				cssProperty,
				color
			);
		}
	};

	qodefCore.shortcodes.eldon_core_icon.qodefIcon = qodefIcon;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.eldon_core_image_gallery                    = {};
	qodefCore.shortcodes.eldon_core_image_gallery.qodefSwiper        = qodef.qodefSwiper;
	qodefCore.shortcodes.eldon_core_image_gallery.qodefMasonryLayout = qodef.qodefMasonryLayout;
	qodefCore.shortcodes.eldon_core_image_gallery.qodefMagnificPopup = qodef.qodefMagnificPopup;

})( jQuery );
(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.eldon_core_image_with_text                    = {};
	qodefCore.shortcodes.eldon_core_image_with_text.qodefMagnificPopup = qodef.qodefMagnificPopup;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.eldon_core_interactive_link_showcase = {};

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.eldon_core_single_image                    = {};
	qodefCore.shortcodes.eldon_core_single_image.qodefMagnificPopup = qodef.qodefMagnificPopup;
	qodefCore.shortcodes.eldon_core_single_image.qodefControlImage  = qodefCore.qodefControlImage;
})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.eldon_core_swapping_image_gallery = {};

	$( document ).ready(
		function () {
			qodefSwappingImageGallery.init();
		}
	);

	var qodefSwappingImageGallery = {
		init: function () {
			this.holder = $( '.qodef-swapping-image-gallery' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						var $thisHolder = $( this );
						qodefSwappingImageGallery.createSlider( $thisHolder );
					}
				);
			}
		},
		createSlider: function ( $holder ) {
			var $swiperHolder     = $holder.find( '.qodef-m-image-holder' );
			var $paginationHolder = $holder.find( '.qodef-m-thumbnails-holder .qodef-grid-inner' );
			var spaceBetween      = 0;
			var slidesPerView     = 1;
			var centeredSlides    = false;
			var loop              = false;
			var autoplay          = false;
			var speed             = 300;

			var $swiper = new Swiper(
				$swiperHolder,
				{
					slidesPerView: slidesPerView,
					centeredSlides: centeredSlides,
					spaceBetween: spaceBetween,
					autoplay: autoplay,
					loop: loop,
					pagination: {
						el: $paginationHolder,
						type: 'custom',
						clickable: true,
						bulletClass: 'qodef-m-thumbnail',
					},
					effect: 'fade',
					speed: speed,
					on: {
						init: function () {
							$swiperHolder.addClass( 'qodef-swiper--initialized' );
							$paginationHolder.find( '.qodef-m-thumbnail' ).eq( 0 ).addClass( 'qodef--active' );
						},
						slideChange: function slideChange() {
							var swiper      = this;
							var activeIndex = swiper.activeIndex;
							$paginationHolder.find( '.qodef--active' ).removeClass( 'qodef--active' );
							$paginationHolder.find( '.qodef-m-thumbnail' ).eq( activeIndex ).addClass( 'qodef--active' );
						}
					},
				}
			);
			
			$( document ).on(
				'eldon_trigger_skin_switch',
				function () {
					$swiper.update();
				}
			);
		}
	};

	qodefCore.shortcodes.eldon_core_swapping_image_gallery.qodefSwappingImageGallery = qodefSwappingImageGallery;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.eldon_core_tabs = {};

	$( document ).ready(
		function () {
			qodefTabs.init();
		}
	);

	var qodefTabs = {
		init: function () {
			this.holder = $( '.qodef-tabs' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefTabs.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			$currentItem.children( '.qodef-tabs-content' ).each(
				function ( index ) {
					index = index + 1;

					var $that    = $( this ),
						link     = $that.attr( 'id' ),
						$navItem = $that.parent().find( '.qodef-tabs-navigation li:nth-child(' + index + ') a' ),
						navLink  = $navItem.attr( 'href' );

					link = '#' + link;

					if ( link.indexOf( navLink ) > -1 ) {
						$navItem.attr(
							'href',
							link
						);
					}
				}
			);

			$currentItem.addClass( 'qodef--init' ).tabs();
		}
	};

	qodefCore.shortcodes.eldon_core_tabs.qodefTabs = qodefTabs;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.eldon_core_video_button                    = {};
	qodefCore.shortcodes.eldon_core_video_button.qodefMagnificPopup = qodef.qodefMagnificPopup;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( window ).on(
		'load',
		function () {
			qodefStickySidebar.init();
		}
	);

	var qodefStickySidebar = {
		init: function () {
			var info = $( '.widget_eldon_core_sticky_sidebar' );

			if ( info.length && qodefCore.windowWidth > 1024 ) {
				info.wrapper = info.parents( '#qodef-page-sidebar' );
				info.offsetM = info.offset().top - info.wrapper.offset().top;
				info.adj     = 15;

				qodefStickySidebar.callStack( info );

				$( window ).on(
					'resize',
					function () {
						if ( qodefCore.windowWidth > 1024 ) {
							qodefStickySidebar.callStack( info );
						}
					}
				);

				$( window ).on(
					'scroll',
					function () {
						if ( qodefCore.windowWidth > 1024 ) {
							qodefStickySidebar.infoPosition( info );
						}
					}
				);
			}
		},
		calc: function ( info ) {
			var content = $( '.qodef-page-content-section' ),
				headerH = qodefCore.body.hasClass( 'qodef-header-appearance--none' ) ? 0 : parseInt( qodefGlobal.vars.headerHeight, 10 );

			// If posts not found set content to have the same height as the sidebar
			if ( qodefCore.windowWidth > 1024 && content.height() < 100 ) {
				content.css( 'height', info.wrapper.height() - content.height() );
			}

			info.start = content.offset().top;
			info.end   = content.outerHeight();
			info.h     = info.wrapper.height();
			info.w     = info.outerWidth();
			info.left  = info.offset().left;
			info.top   = headerH + qodefGlobal.vars.adminBarHeight - info.offsetM;
			info.data( 'state', 'top' );
		},
		infoPosition: function ( info ) {
			if ( qodefCore.scroll < info.start - info.top && qodefCore.scroll + info.h && info.data( 'state' ) !== 'top' ) {
				gsap.to(
					info.wrapper,
					.1,
					{
						y: 5,
					}
				);
				gsap.to(
					info.wrapper,
					.3,
					{
						y: 0,
						delay: .1,
					}
				);
				info.data( 'state', 'top' );
				info.wrapper.css(
					{
						'position': 'static',
					}
				);
			} else if ( qodefCore.scroll >= info.start - info.top && qodefCore.scroll + info.h + info.adj <= info.start + info.end &&
				info.data( 'state' ) !== 'fixed' ) {
				var c = info.data( 'state' ) === 'top' ? 1 : -1;
				info.data( 'state', 'fixed' );
				info.wrapper.css(
					{
						'position': 'fixed',
						'top': info.top,
						'left': info.left,
						'width': info.w,
					}
				);
				gsap.fromTo(
					info.wrapper,
					.2,
					{
						y: 0
					},
					{
						y: c * 10,
						ease: Power4.easeInOut
					}
				);
				gsap.to(
					info.wrapper,
					.2,
					{
						y: 0,
						delay: .2,
					}
				);
			} else if ( qodefCore.scroll + info.h + info.adj > info.start + info.end && info.data( 'state' ) !== 'bottom' ) {
				info.data( 'state', 'bottom' );
				info.wrapper.css(
					{
						'position': 'absolute',
						'top': info.end - info.h - info.adj,
						'left': 'auto',
						'width': info.w,
					}
				);
				gsap.fromTo(
					info.wrapper,
					.1,
					{
						y: 0
					},
					{
						y: -5,
					}
				);
				gsap.to(
					info.wrapper,
					.3,
					{
						y: 0,
						delay: .1,
					}
				);
			}
		},
		callStack: function ( info ) {
			this.calc( info );
			this.infoPosition( info );
		}
	};

})( jQuery );

(function ($) {
	"use strict";

	$( window ).on(
		'load',
		function () {
			qodefSwitcher.init();
		}
	);

	var qodefSwitcher = {
		init: function () {
			var switcher = $( 'input.switch__input' );
			if (switcher.length) {

				switcher.each(
					function () {
						var $thisSwitcher        = $( this );
						$thisSwitcher[0].checked = false;
						if (qodefCore.body.hasClass( 'qodef-skin--white' )) {
							$thisSwitcher[0].checked = true;
						}
						$thisSwitcher[0].addEventListener(
							'change',
							function(event){
								if (event.target.checked) {
									qodefCore.body.removeClass( "qodef-skin--black" ).addClass( "qodef-skin--white" );
									qodef.body.trigger(
										'eldon_trigger_skin_switch',
										[]
									);
								} else {
									qodefCore.body.removeClass( "qodef-skin--white" ).addClass( "qodef-skin--black" );
									qodef.body.trigger(
										'eldon_trigger_skin_switch',
										[]
									);
								}
							}
						);
					}
				);
			}
		},
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	var shortcode = 'eldon_core_blog_list';

	qodefCore.shortcodes[shortcode] = {};

	if ( typeof qodefCore.listShortcodesScripts === 'object' ) {
		$.each(
			qodefCore.listShortcodesScripts,
			function ( key, value ) {
				qodefCore.shortcodes[shortcode][key] = value;
			}
		);
	}

	qodefCore.shortcodes[shortcode].qodefResizeIframes = qodef.qodefResizeIframes;

})( jQuery );

(function ($) {
	"use strict";

	$( document ).ready(
		function () {
			qodefBottomHeader.init();
		}
	);

	$( window ).resize(
		function () {
			qodefBottomHeader.init();
		}
	);

	var qodefBottomHeader = {
		$headerHolder: $( '#qodef-page-header' ),

		init: function () {
			if (qodefCore.body.hasClass( 'qodef-header--bottom' )) {
				var $sliderHolder = $( '#qodef-slider-holder' );

				if ($sliderHolder.length) {
					qodefBottomHeader.calculateAndSetVars( $sliderHolder );
				}
			}
		},
		calculateAndSetVars: function ($sliderHolder) {
			var sliderHeight = '';

			if (qodef.windowWidth <= 782) {
				if (0 !== qodefGlobal.vars.adminBarHeight) {
					sliderHeight = qodefCore.windowHeight - qodefGlobal.vars.mobileHeaderHeight - 42;
				} else {
					sliderHeight = qodefCore.windowHeight - qodefGlobal.vars.mobileHeaderHeight;
				}
			} else if (qodef.windowWidth <= 1024) {
				sliderHeight = qodefCore.windowHeight - qodefGlobal.vars.mobileHeaderHeight - qodefGlobal.vars.adminBarHeight;
			} else {
				if ( qodef.body.hasClass( 'qodef--passepartout' ) ) {
					var passepartoutWidth = parseInt( $( '.qodef--passepartout' ).css( 'padding-left' ) );

					sliderHeight = qodefCore.windowHeight - qodefGlobal.vars.headerHeight - qodefGlobal.vars.adminBarHeight - passepartoutWidth;
				} else {
					sliderHeight = qodefCore.windowHeight - qodefGlobal.vars.headerHeight - qodefGlobal.vars.adminBarHeight;
				}
			}

			$sliderHolder.height( sliderHeight );
			qodefBottomHeader.$headerHolder.css( 'margin-top', parseInt( sliderHeight ) + 'px' );

			qodefBottomHeader.setMenuDirection();

			$( window ).scroll(
				function () {
					qodefBottomHeader.setMenuDirection();
				}
			);
		},
		setMenuDirection: function () {
			var subMenu = qodefBottomHeader.$headerHolder.find( '.qodef-drop-down-second' );

			if (qodefCore.body.offset().top - qodefCore.body.outerHeight() > qodefCore.scroll || qodefCore.scroll > 300) {
				subMenu.removeClass( 'qodef-sub-upwards' );
			} else {
				subMenu.addClass( 'qodef-sub-upwards' );
			}
		},
	};

	window.qodefBottomHeader = qodefBottomHeader;
})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefVerticalNavMenu.init();
		}
	);

	/**
	 * Function object that represents vertical menu area.
	 * @returns {{init: Function}}
	 */
	var qodefVerticalNavMenu = {
		initNavigation: function ( $verticalMenuObject ) {
			var $verticalNavObject = $verticalMenuObject.find( '.qodef-header-vertical-navigation' );

			if ( $verticalNavObject.hasClass( 'qodef-vertical-drop-down--below' ) ) {
				qodefVerticalNavMenu.dropdownClickToggle( $verticalNavObject );
			} else if ( $verticalNavObject.hasClass( 'qodef-vertical-drop-down--side' ) ) {
				qodefVerticalNavMenu.dropdownFloat( $verticalNavObject );
			}
		},
		dropdownClickToggle: function ( $verticalNavObject ) {
			var $menuItems = $verticalNavObject.find( 'ul li.menu-item-has-children' );

			$menuItems.each(
				function () {
					var $elementToExpand = $( this ).find( ' > .qodef-drop-down-second, > ul' );
					var menuItem         = this;
					var $dropdownOpener  = $( this ).find( '> a' );
					var slideUpSpeed     = 'fast';
					var slideDownSpeed   = 'slow';

					$dropdownOpener.on(
						'click tap',
						function ( e ) {
							e.preventDefault();
							e.stopPropagation();

							if ( $elementToExpand.is( ':visible' ) ) {
								$( menuItem ).removeClass( 'qodef-menu-item--open' );
								$elementToExpand.slideUp( slideUpSpeed );
							} else if ( $dropdownOpener.parent().parent().children().hasClass( 'qodef-menu-item--open' ) && $dropdownOpener.parent().parent().parent().hasClass( 'qodef-vertical-menu' ) ) {
								$( this ).parent().parent().children().removeClass( 'qodef-menu-item--open' );
								$( this ).parent().parent().children().find( ' > .qodef-drop-down-second' ).slideUp( slideUpSpeed );

								$( menuItem ).addClass( 'qodef-menu-item--open' );
								$elementToExpand.slideDown( slideDownSpeed );
							} else {

								if ( ! $( this ).parents( 'li' ).hasClass( 'qodef-menu-item--open' ) ) {
									$menuItems.removeClass( 'qodef-menu-item--open' );
									$menuItems.find( ' > .qodef-drop-down-second, > ul' ).slideUp( slideUpSpeed );
								}

								if ( $( this ).parent().parent().children().hasClass( 'qodef-menu-item--open' ) ) {
									$( this ).parent().parent().children().removeClass( 'qodef-menu-item--open' );
									$( this ).parent().parent().children().find( ' > .qodef-drop-down-second, > ul' ).slideUp( slideUpSpeed );
								}

								$( menuItem ).addClass( 'qodef-menu-item--open' );
								$elementToExpand.slideDown( slideDownSpeed );
							}
						}
					);
				}
			);
		},
		dropdownFloat: function ( $verticalNavObject ) {
			var $menuItems = $verticalNavObject.find( 'ul li.menu-item-has-children' );
			var $allDropdowns = $menuItems.find( ' > .qodef-drop-down-second > .qodef-drop-down-second-inner > ul, > ul' );

			$menuItems.each(
				function () {
					var $elementToExpand = $( this ).find( ' > .qodef-drop-down-second > .qodef-drop-down-second-inner > ul, > ul' );
					var menuItem         = this;

					if ( Modernizr.touch ) {
						var $dropdownOpener = $( this ).find( '> a' );

						$dropdownOpener.on(
							'click tap',
							function ( e ) {
								e.preventDefault();
								e.stopPropagation();

								if ( $elementToExpand.hasClass( 'qodef-float--open' ) ) {
									$elementToExpand.removeClass( 'qodef-float--open' );
									$( menuItem ).removeClass( 'qodef-menu-item--open' );
								} else {
									if ( ! $( this ).parents( 'li' ).hasClass( 'qodef-menu-item--open' ) ) {
										$menuItems.removeClass( 'qodef-menu-item--open' );
										$allDropdowns.removeClass( 'qodef-float--open' );
									}

									$elementToExpand.addClass( 'qodef-float--open' );
									$( menuItem ).addClass( 'qodef-menu-item--open' );
								}
							}
						);
					} else {
						//must use hoverIntent because basic hover effect doesn't catch dropdown
						//it doesn't start from menu item's edge
						$( this ).hoverIntent(
							{
								over: function () {
									$elementToExpand.addClass( 'qodef-float--open' );
									$( menuItem ).addClass( 'qodef-menu-item--open' );
								},
								out: function () {
									$elementToExpand.removeClass( 'qodef-float--open' );
									$( menuItem ).removeClass( 'qodef-menu-item--open' );
								},
								timeout: 300
							}
						);
					}
				}
			);
		},
		verticalAreaScrollable: function ( $verticalMenuObject ) {
			return $verticalMenuObject.hasClass( 'qodef-with-scroll' );
		},
		initVerticalAreaScroll: function ( $verticalMenuObject ) {
			if ( qodefVerticalNavMenu.verticalAreaScrollable( $verticalMenuObject ) && typeof qodefCore.qodefPerfectScrollbar === 'object' ) {
				qodefCore.qodefPerfectScrollbar.init( $verticalMenuObject );
			}
		},
		init: function () {
			var $verticalMenuObject = $( '.qodef-header--vertical #qodef-page-header' );

			if ( $verticalMenuObject.length ) {
				qodefVerticalNavMenu.initNavigation( $verticalMenuObject );
				qodefVerticalNavMenu.initVerticalAreaScroll( $verticalMenuObject );
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefVerticalNavMenu.init();
		}
	);

	var qodefVerticalNavMenu = {
		init: function () {
			var $verticalMenuObject = $( '.qodef-header--vertical-minimal #qodef-page-header' );
			var $verticalNavObject  = $verticalMenuObject.find( '.qodef-header-vertical-navigation' );
			var $verticalMenuItem   = $verticalNavObject.find( '.menu-item a' );

			$verticalMenuItem.each(
				function () {
					$( this ).on(
						'click',
						function () {
							var $verticalMenuItemText = $( this ).find( '.qodef-menu-item-text-holder' );

							$verticalMenuItemText.addClass( 'qodef--active' );
							$( this ).closest( '.menu-item' ).siblings().find( '.qodef-menu-item-text-holder' ).removeClass( 'qodef--active' );
						}
					)
				}
			)
		}
	}

})( jQuery );

(function ( $ ) {
	'use strict';

	var fixedHeaderAppearance = {
		showHideHeader: function ( $pageOuter, $header ) {
			if ( qodefCore.windowWidth > 1024 ) {
				if ( qodefCore.scroll <= 0 ) {
					qodefCore.body.removeClass( 'qodef-header--fixed-display' );
					$pageOuter.css( 'padding-top', '0' );
					$header.css( 'margin-top', '0' );
				} else {
					qodefCore.body.addClass( 'qodef-header--fixed-display' );
					$pageOuter.css( 'padding-top', parseInt( qodefGlobal.vars.headerHeight + qodefGlobal.vars.topAreaHeight ) + 'px' );
					$header.css( 'margin-top', parseInt( qodefGlobal.vars.topAreaHeight ) + 'px' );
				}
			}
		},
		init: function () {

			if ( ! qodefCore.body.hasClass( 'qodef-header--vertical' ) ) {
				var $pageOuter = $( '#qodef-page-outer' ),
					$header    = $( '#qodef-page-header' );

				fixedHeaderAppearance.showHideHeader( $pageOuter, $header );

				$( window ).scroll(
					function () {
						fixedHeaderAppearance.showHideHeader( $pageOuter, $header );
					}
				);

				$( window ).resize(
					function () {
						$pageOuter.css( 'padding-top', '0' );
						fixedHeaderAppearance.showHideHeader( $pageOuter, $header );
					}
				);
			}
		}
	};

	qodefCore.fixedHeaderAppearance = fixedHeaderAppearance.init;

})( jQuery );

(function ( $ ) {
	'use strict';

	var stickyHeaderAppearance = {
		header: '',
		docYScroll: 0,
		init: function () {
			var displayAmount = stickyHeaderAppearance.displayAmount();

			// Set variables
			stickyHeaderAppearance.header 	  = $( '.qodef-header-sticky' );
			stickyHeaderAppearance.docYScroll = $( document ).scrollTop();

			// Set sticky visibility
			stickyHeaderAppearance.setVisibility( displayAmount );

			$( window ).scroll(
				function () {
					stickyHeaderAppearance.setVisibility( displayAmount );
				}
			);
		},
		displayAmount: function () {
			if ( qodefGlobal.vars.qodefStickyHeaderScrollAmount !== 0 ) {
				return parseInt( qodefGlobal.vars.qodefStickyHeaderScrollAmount, 10 );
			} else {
				return parseInt( qodefGlobal.vars.headerHeight + qodefGlobal.vars.adminBarHeight, 10 );
			}
		},
		setVisibility: function ( displayAmount ) {
			var isStickyHidden = qodefCore.scroll < displayAmount;

			if ( stickyHeaderAppearance.header.hasClass( 'qodef-appearance--up' ) ) {
				var currentDocYScroll = $( document ).scrollTop();

				isStickyHidden = (currentDocYScroll > stickyHeaderAppearance.docYScroll && currentDocYScroll > displayAmount) || (currentDocYScroll < displayAmount);

				stickyHeaderAppearance.docYScroll = $( document ).scrollTop();
			}

			stickyHeaderAppearance.showHideHeader( isStickyHidden );
		},
		showHideHeader: function ( isStickyHidden ) {
			if ( isStickyHidden ) {
				qodefCore.body.removeClass( 'qodef-header--sticky-display' );
			} else {
				qodefCore.body.addClass( 'qodef-header--sticky-display' );
			}
		},
	};

	qodefCore.stickyHeaderAppearance = stickyHeaderAppearance.init;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefSideAreaMobileHeader.init();
		}
	);

	var qodefSideAreaMobileHeader = {
		init: function () {
			var $holder = $( '#qodef-side-area-mobile-header' );

			if ( $holder.length && qodefCore.body.hasClass( 'qodef-mobile-header--side-area' ) ) {
				var $navigation = $holder.find( '.qodef-m-navigation' );

				qodefSideAreaMobileHeader.initOpenerTrigger( $holder, $navigation );
				qodefSideAreaMobileHeader.initNavigationClickToggle( $navigation );

				if ( typeof qodefCore.qodefPerfectScrollbar === 'object' ) {
					qodefCore.qodefPerfectScrollbar.init( $holder );
				}
			}
		},
		initOpenerTrigger: function ( $holder, $navigation ) {
			var $openerIcon = $( '.qodef-side-area-mobile-header-opener' ),
				$closeIcon  = $holder.children( '.qodef-m-close' );

			if ( $openerIcon.length && $navigation.length ) {
				$openerIcon.on(
					'tap click',
					function ( e ) {
						e.stopPropagation();
						e.preventDefault();

						if ( $holder.hasClass( 'qodef--opened' ) ) {
							$holder.removeClass( 'qodef--opened' );
						} else {
							$holder.addClass( 'qodef--opened' );
						}
					}
				);
			}

			$closeIcon.on(
				'tap click',
				function ( e ) {
					e.stopPropagation();
					e.preventDefault();

					if ( $holder.hasClass( 'qodef--opened' ) ) {
						$holder.removeClass( 'qodef--opened' );
					}
				}
			);
		},
		initNavigationClickToggle: function ( $navigation ) {
			var $menuItems = $navigation.find( 'ul li.menu-item-has-children' );

			$menuItems.each(
				function () {
					var $thisItem        = $( this ),
						$elementToExpand = $thisItem.find( ' > .qodef-drop-down-second, > ul' ),
						$dropdownOpener  = $thisItem.find( '> .qodef-menu-item-arrow' ),
						slideUpSpeed     = 'fast',
						slideDownSpeed   = 'slow';

					$dropdownOpener.on(
						'click tap',
						function ( e ) {
							e.preventDefault();
							e.stopPropagation();

							if ( $elementToExpand.is( ':visible' ) ) {
								$thisItem.removeClass( 'qodef-menu-item--open' );
								$elementToExpand.slideUp( slideUpSpeed );
							} else if ( $dropdownOpener.parent().parent().children().hasClass( 'qodef-menu-item--open' ) && $dropdownOpener.parent().parent().parent().hasClass( 'qodef-vertical-menu' ) ) {
								$thisItem.parent().parent().children().removeClass( 'qodef-menu-item--open' );
								$thisItem.parent().parent().children().find( ' > .qodef-drop-down-second' ).slideUp( slideUpSpeed );

								$thisItem.addClass( 'qodef-menu-item--open' );
								$elementToExpand.slideDown( slideDownSpeed );
							} else {

								if ( ! $thisItem.parents( 'li' ).hasClass( 'qodef-menu-item--open' ) ) {
									$menuItems.removeClass( 'qodef-menu-item--open' );
									$menuItems.find( ' > .qodef-drop-down-second, > ul' ).slideUp( slideUpSpeed );
								}

								if ( $thisItem.parent().parent().children().hasClass( 'qodef-menu-item--open' ) ) {
									$thisItem.parent().parent().children().removeClass( 'qodef-menu-item--open' );
									$thisItem.parent().parent().children().find( ' > .qodef-drop-down-second, > ul' ).slideUp( slideUpSpeed );
								}

								$thisItem.addClass( 'qodef-menu-item--open' );
								$elementToExpand.slideDown( slideDownSpeed );
							}
						}
					);
				}
			);
		},
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefSearchCoversHeader.init();
		}
	);

	var qodefSearchCoversHeader = {
		init: function () {
			var $searchOpener = $( 'a.qodef-search-opener' ),
				$searchForm   = $( '.qodef-search-cover-form' ),
				$searchClose  = $searchForm.find( '.qodef-m-close' );

			if ( $searchOpener.length && $searchForm.length ) {
				$searchOpener.on(
					'click',
					function ( e ) {
						e.preventDefault();
						qodefSearchCoversHeader.openCoversHeader( $searchForm );
					}
				);
				$searchClose.on(
					'click',
					function ( e ) {
						e.preventDefault();
						qodefSearchCoversHeader.closeCoversHeader( $searchForm );
					}
				);
			}
		},
		openCoversHeader: function ( $searchForm ) {
			qodefCore.body.addClass( 'qodef-covers-search--opened qodef-covers-search--fadein' );
			qodefCore.body.removeClass( 'qodef-covers-search--fadeout' );

			setTimeout(
				function () {
					$searchForm.find( '.qodef-m-form-field' ).focus();
				},
				600
			);
		},
		closeCoversHeader: function ( $searchForm ) {
			qodefCore.body.removeClass( 'qodef-covers-search--opened qodef-covers-search--fadein' );
			qodefCore.body.addClass( 'qodef-covers-search--fadeout' );

			setTimeout(
				function () {
					$searchForm.find( '.qodef-m-form-field' ).val( '' );
					$searchForm.find( '.qodef-m-form-field' ).blur();
					qodefCore.body.removeClass( 'qodef-covers-search--fadeout' );
				},
				300
			);
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefSearchFullscreen.init();
		}
	);

	var qodefSearchFullscreen = {
		init: function () {
			var $searchOpener = $( 'a.qodef-search-opener' ),
				$searchHolder = $( '.qodef-fullscreen-search-holder' ),
				$searchClose  = $searchHolder.find( '.qodef-m-close' );

			if ( $searchOpener.length && $searchHolder.length ) {
				$searchOpener.on(
					'click',
					function ( e ) {
						e.preventDefault();
						if ( qodefCore.body.hasClass( 'qodef-fullscreen-search--opened' ) ) {
							qodefSearchFullscreen.closeFullscreen( $searchHolder );
						} else {
							qodefSearchFullscreen.openFullscreen( $searchHolder );
						}
					}
				);
				$searchClose.on(
					'click',
					function ( e ) {
						e.preventDefault();
						qodefSearchFullscreen.closeFullscreen( $searchHolder );
					}
				);

				//Close on escape
				$( document ).keyup(
					function ( e ) {
						if ( e.keyCode === 27 && qodefCore.body.hasClass( 'qodef-fullscreen-search--opened' ) ) { //KeyCode for ESC button is 27
							qodefSearchFullscreen.closeFullscreen( $searchHolder );
						}
					}
				);
			}
		},
		openFullscreen: function ( $searchHolder ) {
			qodefCore.body.removeClass( 'qodef-fullscreen-search--fadeout' );
			qodefCore.body.addClass( 'qodef-fullscreen-search--opened qodef-fullscreen-search--fadein' );

			setTimeout(
				function () {
					$searchHolder.find( '.qodef-m-form-field' ).focus();
				},
				900
			);

			qodefCore.qodefScroll.disable();
		},
		closeFullscreen: function ( $searchHolder ) {
			qodefCore.body.removeClass( 'qodef-fullscreen-search--opened qodef-fullscreen-search--fadein' );
			qodefCore.body.addClass( 'qodef-fullscreen-search--fadeout' );

			setTimeout(
				function () {
					$searchHolder.find( '.qodef-m-form-field' ).val( '' );
					$searchHolder.find( '.qodef-m-form-field' ).blur();
					qodefCore.body.removeClass( 'qodef-fullscreen-search--fadeout' );
				},
				300
			);

			qodefCore.qodefScroll.enable();
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefSearch.init();
		}
	);

	var qodefSearch = {
		init: function () {
			this.search = $( 'a.qodef-search-opener' );

			if ( this.search.length ) {
				this.search.each(
					function () {
						var $thisSearch = $( this );

						qodefSearch.searchHoverColor( $thisSearch );
					}
				);
			}
		},
		searchHoverColor: function ( $searchHolder ) {
			if ( typeof $searchHolder.data( 'hover-color' ) !== 'undefined' ) {
				var hoverColor    = $searchHolder.data( 'hover-color' ),
					originalColor = $searchHolder.css( 'color' );

				$searchHolder.on(
					'mouseenter',
					function () {
						$searchHolder.css( 'color', hoverColor );
					}
				).on(
					'mouseleave',
					function () {
						$searchHolder.css( 'color', originalColor );
					}
				);
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefProgressBarSpinner.init();
		}
	);

	$( window ).on(
		'load',
		function () {
			qodefProgressBarSpinner.windowLoaded = true;
			qodefProgressBarSpinner.completeAnimation();
		}
	);

	$( window ).on(
		'elementor/frontend/init',
		function () {
			var isEditMode = Boolean( elementorFrontend.isEditMode() );

			if ( isEditMode ) {
				qodefProgressBarSpinner.init( isEditMode );
			}
		}
	);

	var qodefProgressBarSpinner = {
		holder: '',
		windowLoaded: false,
		percentNumber: 0,
		init: function ( isEditMode ) {
			this.holder = $( '#qodef-page-spinner.qodef-layout--progress-bar' );

			if ( this.holder.length ) {
				qodefProgressBarSpinner.animateSpinner( this.holder, isEditMode );
			}
		},
		animateSpinner: function ( $holder, isEditMode ) {
			var $numberHolder = $holder.find( '.qodef-m-spinner-number-label' ),
				$spinnerLine  = $holder.find( '.qodef-m-spinner-line-front' );

			$spinnerLine.animate(
				{ 'width': '100%' },
				10000,
				'linear'
			);

			var numberInterval = setInterval(
				function () {
					qodefProgressBarSpinner.animatePercent( $numberHolder, qodefProgressBarSpinner.percentNumber );

					if ( qodefProgressBarSpinner.windowLoaded ) {
						clearInterval( numberInterval );
					}
				},
				100
			);

			if ( isEditMode ) {
				qodefProgressBarSpinner.fadeOutLoader( $holder );
			}
		},
		completeAnimation: function () {
			var $holder = qodefProgressBarSpinner.holder.length ? qodefProgressBarSpinner.holder : $( '#qodef-page-spinner.qodef-layout--progress-bar' );

			var numberIntervalFastest = setInterval(
				function () {

					if ( qodefProgressBarSpinner.percentNumber >= 100 ) {
						clearInterval( numberIntervalFastest );

						$holder.find( '.qodef-m-spinner-line-front' ).stop().animate(
							{ 'width': '100%' },
							500
						);

						$holder.addClass( 'qodef--finished' );

						setTimeout(
							function () {
								qodefProgressBarSpinner.fadeOutLoader( $holder );
							},
							600
						);
					} else {
						qodefProgressBarSpinner.animatePercent(
							$holder.find( '.qodef-m-spinner-number-label' ),
							qodefProgressBarSpinner.percentNumber
						);
					}
				},
				6
			);
		},
		animatePercent: function ( $numberHolder, percentNumber ) {
			if ( percentNumber < 100 ) {
				percentNumber += 5;
				$numberHolder.text( percentNumber );

				qodefProgressBarSpinner.percentNumber = percentNumber;
			}
		},
		fadeOutLoader: function ( $holder, speed, delay, easing ) {
			speed  = speed ? speed : 600;
			delay  = delay ? delay : 0;
			easing = easing ? easing : 'swing';

			$holder.delay( delay ).fadeOut( speed, easing );

			$( window ).on(
				'bind',
				'pageshow',
				function ( event ) {
					if ( event.originalEvent.persisted ) {
						$holder.fadeOut( speed, easing );
					}
				}
			);
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	/*
	 **	Re-init scripts on gallery loaded
	 */
	$( document ).on(
		'yith_wccl_product_gallery_loaded',
		function () {

			if ( typeof qodefCore.qodefWooMagnificPopup === 'function' ) {
				qodefCore.qodefWooMagnificPopup.init();
			}
		}
	);

})( jQuery );

(function ( $ ) {
	'use strict';

	var shortcode = 'eldon_core_product_list';

	qodefCore.shortcodes[shortcode] = {};

	if ( typeof qodefCore.listShortcodesScripts === 'object' ) {
		$.each(
			qodefCore.listShortcodesScripts,
			function ( key, value ) {
				qodefCore.shortcodes[shortcode][key] = value;
			}
		);
	}

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefDropDownCart.init();
		}
	);

	var qodefDropDownCart = {
		init: function () {
			var $holder = $( '.qodef-woo-dropdown-cart' );

			if ( $holder.length ) {
				$holder.each(
					function () {
						var $thisHolder = $( this ),
							$items      = $thisHolder.find( '.qodef-woo-dropdown-items' );

						qodefDropDownCart.addItemsClass( $items );

						qodefCore.body.on(
							'added_to_cart',
							function () {
								qodefDropDownCart.addItemsClass( $thisHolder.find( '.qodef-woo-dropdown-items' ) );
							}
						);
					}
				);
			}
		},
		addItemsClass: function ( $items ) {
			if ( $items.length && $items.children().length > 4 ) {
				$items.addClass( 'qodef--scrollable' );
			} else if ( $items.hasClass( 'qodef--scrollable' ) ) {
				$items.removeClass( 'qodef--scrollable' );
			}
		},
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefSideAreaCart.init();
		}
	);

	var qodefSideAreaCart = {
		init: function () {
			var $holder = $( '.qodef-woo-side-area-cart' );

			if ( $holder.length ) {
				$holder.each(
					function () {
						var $thisHolder = $( this );

						if ( qodefCore.windowWidth > 680 ) {
							qodefSideAreaCart.trigger( $thisHolder );
							qodef.body.addClass( 'qodef-side-cart--initialized' );

							qodefCore.body.on(
								'added_to_cart',
								function () {
									if ( ! qodef.body.hasClass( 'qodef-side-cart--initialized' ) ) {
										qodefSideAreaCart.trigger( $thisHolder );
									}
								}
							);
						}
					}
				);
			}
		},
		trigger: function ( $holder ) {

			// Open Side Area
			$( '.qodef-woo-side-area-cart' ).on(
				'click',
				'.qodef-m-opener',
				function ( e ) {
					e.preventDefault();

					var $items = $holder.find( '.qodef-m-items' );

					if ( ! $holder.hasClass( 'qodef--opened' ) ) {
						qodefSideAreaCart.openSideArea( $holder );
						if ( $items.length && typeof qodefCore.qodefPerfectScrollbar === 'object' ) {
							qodefCore.qodefPerfectScrollbar.init( $items );
						}

						$( document ).keyup(
							function ( e ) {
								if ( e.keyCode === 27 ) {
									qodefSideAreaCart.closeSideArea( $holder );
								}
							}
						);
					} else {
						qodefSideAreaCart.closeSideArea( $holder );
					}
				}
			);

			$( '.qodef-woo-side-area-cart' ).on(
				'click',
				'.qodef-m-close',
				function ( e ) {
					e.preventDefault();
					qodefSideAreaCart.closeSideArea( $holder );
				}
			);
		},
		openSideArea: function ( $holder ) {
			qodefCore.qodefScroll.disable();

			$holder.addClass( 'qodef--opened' );
			$( '#qodef-page-wrapper' ).prepend( '<div class="qodef-woo-side-area-cart-cover"/>' );

			$( '.qodef-woo-side-area-cart-cover' ).on(
				'click',
				function ( e ) {
					e.preventDefault();

					qodefSideAreaCart.closeSideArea( $holder );
				}
			);
		},
		closeSideArea: function ( $holder ) {
			if ( $holder.hasClass( 'qodef--opened' ) ) {
				qodefCore.qodefScroll.enable();

				$holder.removeClass( 'qodef--opened' );
				$( '.qodef-woo-side-area-cart-cover' ).remove();
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.eldon_core_instagram_list = {};

	$( document ).ready(
		function () {
			qodefInstagram.init();
		}
	);

	var qodefInstagram = {
		init: function () {
			this.holder = $( '.sbi.qodef-instagram-swiper-container' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefInstagram.initSlider( $( this ) );
					}
				);
			}
		},
		initSlider: function ( $currentItem, $initAllItems ) {
			var sliderOptions   = $currentItem.parent().attr( 'data-options' ),
				$instagramImage = $currentItem.find( '.sbi_item.sbi_type_image' ),
				$imageHolder    = $currentItem.find( '#sbi_images' );

			$currentItem.attr( 'data-options', sliderOptions );

			$imageHolder.addClass( 'swiper-wrapper' );

			if ( $instagramImage.length ) {
				$instagramImage.each(
					function () {
						$( this ).addClass( 'qodef-e qodef-image-wrapper swiper-slide' );
					}
				);
			}

			if ( typeof qodef.qodefSwiper === 'object' ) {

				if ( false === $initAllItems ) {
					qodef.qodefSwiper.initSlider( $currentItem );
				} else {
					qodef.qodefSwiper.init( $currentItem );
				}
			}
		},
	};

	qodefCore.shortcodes.eldon_core_instagram_list.qodefInstagram = qodefInstagram;
	qodefCore.shortcodes.eldon_core_instagram_list.qodefSwiper    = qodef.qodefSwiper;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.eldon_core_portfolio_fullscreen_showcase = {};
	
	$( document ).ready(
		function () {
			qodefPortfolioFullscreenShowcase.init();
		}
	);

	var qodefPortfolioFullscreenShowcase = {
		init: function () {
			var holder = $( '.qodef-portfolio-fullscreen-showcase' );

			if ( holder.length ) {
				holder.each(
					function () {
						var thisHolder = $( this );

						qodefPortfolioFullscreenShowcase.initSwiper( thisHolder );
					}
				);
			}
		},
		initSwiper: function ( $holder ) {
			var $swiperInstance = $holder[0].swiper,
				scrollStart     = false;

			$holder.on(
				'mousewheel',
				function ( e ) {
					e.preventDefault();

					if ( ! scrollStart ) {
						scrollStart = true;

						if ( e.deltaY < 0 ) {
							$swiperInstance.slideNext();
						} else {
							$swiperInstance.slidePrev();
						}

						setTimeout(
							function () {
								scrollStart = false;
							},
							1000
						);
					}
				}
			);
			
			$swiperInstance.on(
				'slideChangeTransitionStart', function(){
					if ($swiperInstance.activeIndex - $swiperInstance.previousIndex < 0){
						$holder.addClass('qodef-swiping-backwards');
					} else {
						$holder.removeClass('qodef-swiping-backwards');
					}
				}
			)
		}
	};
	qodefCore.shortcodes.eldon_core_portfolio_fullscreen_showcase.qodefSwiper = qodef.qodefSwiper;
	qodefCore.shortcodes.eldon_core_portfolio_fullscreen_showcase.qodefPortfolioFullscreenShowcase = qodefPortfolioFullscreenShowcase;

})( jQuery );


(function ( $ ) {
	'use strict';
	
	qodefCore.shortcodes.eldon_core_portfolio_horizontal             = {};
	
	$(document).ready( function () {
		qodefPortfolioListHorizontal.init();
	});
	
	$( window ).resize( function () {
		qodefPortfolioListHorizontal.init();
	});
	
	var qodefPortfolioListHorizontal = {
		init: function () {
			var holder = $('.qodef-portfolio-list-horizontal-holder');
			
			if (holder.length) {
				holder.each(function () {
					var $thisHolder = $(this);
					
					if ( qodefCore.windowWidth > 1024 ) {
						$thisHolder.addClass( 'qodef-fullscreen' );
					}
					
					qodefPortfolioListHorizontal.animate($thisHolder);
				});
			}
		},
		
		animate: function (holder) {
			holder.inner      = $( '.qodef-portfolio-list-horizontal-inner' );
			holder.static     = $( '.qodef-ptfh-static' );
			holder.movingText = $( '.qodef-moving-text' );
			holder.area       = -holder.inner.outerWidth() + holder.width();
			holder.step       = 50;
			holder.coeff      = 0.55;
			holder.deltaX     = 0;
			holder.dX         = 0;
			holder.clickedX   = false;
			holder.x          = 0;
			holder.buffer     = 0;
			holder.locked     = false;
			
			qodefPortfolioListHorizontal.initItems(holder);
		},
		
		addAnimatedPosition : (holder) =>{
			var $animatedText = holder.find('.qodef-animated-text-holder');
			
			if ($animatedText.length) {
				$animatedText.each( function(i) {
					var $thisAnimatedText = $(this);
					
					$thisAnimatedText.find('.qodef-animated-text-duplicate').css('--qodef-animated-index', i);
				})
			}
		},
		initItems: function (holder) {
			var translate = function (val) {
				if ( qodefCore.windowWidth > 1024 ) {
					if (val !== 0) {
						setTimeout(
							function(){
								holder.static.css( {'opacity': '0'} );
								holder.static.removeClass('qodef--reset-animation');
								holder.static.addClass('qodef--remove-animation');
							},
							100
						);
					} else {
						setTimeout(
							function(){
								holder.static.css( {'opacity': '1'} );
								holder.static.addClass('qodef--reset-animation');
								holder.static.removeClass('qodef--remove-animation');
							},
							200
						);
					}
				}
				holder.inner.css(
					{
						'transform': 'translate3d(' + val + 'px, 0px, 0px)'
					}
				);
				holder.movingText.css(
					{
						'transform': 'translate3d(' + val + 'px, 0px, 0px)'
					}
				);
				
				holder.buffer = val;
			};
			
			var movement = function () {
				holder.dX += holder.deltaX < 0 ? Math.min( holder.deltaX * holder.coeff, -holder.step ) : Math.max( holder.deltaX * holder.coeff, holder.step );
				holder.dX  = Math.min( Math.max( holder.area, holder.dX ), 0 );
				translate( holder.dX );
			};
			
			var mouseWheel = function (e) {
				e.preventDefault();
				holder.deltaX = -e.deltaY;
				requestAnimationFrame(
					function () {
						movement();
					}
				);
			};
			
			if (holder.length) {
				holder.hasClass( 'qodef-fullscreen' ) && qodefPortfolioListHorizontal.calcHeight(holder);
				holder.hasClass( 'qodef-fullscreen' ) && document.documentElement.classList.add( 'qodef-overflow' );
				holder.hasClass( 'qodef-fullscreen' ) && qodefPortfolioListHorizontal.calcWidth(holder);
				holder.addClass( 'qodef-loaded' );
				qodefPortfolioListHorizontal.appearAnimation(holder);
				//scroll support
				qodefCore.windowWidth > 1024 && holder[0].addEventListener( 'wheel', mouseWheel );
				
				qodefPortfolioListHorizontal.addAnimatedPosition(holder);
			}
		},
		calcWidth: function (holder) {
			var items    = holder.find( '.qodef-plh-item' ),
				widthVal = 0;
			
			items.each(
				function () {
					widthVal += Math.ceil( $( this ).outerWidth( true ) );
				}
			);
			
			holder.inner.css(
				{
					'width': widthVal + parseInt( holder.inner.css( 'paddingLeft' ) ),
				}
			);
			holder.area = -holder.inner.outerWidth() + holder.width();
		},
		appearAnimation: function (holder) {
			holder.find( '.qodef-plh-item' ).each(
				function(i) {
					var thisItem = $( this );
					setTimeout(
						function() {
							thisItem.addClass( 'qodef--appear' );
						},
						i * 100
					);
				}
			);
		},
		calcHeight: function (holder) {
			var adj    = Math.max( holder.movingText.outerHeight(), 0 ),
				stat   = Math.max( holder.static.outerHeight(), 0 ),
				offset = $( '.qodef-page-content-section .elementor-section-wrap > section' ).length == 1 ? holder.offset().top : 0;
			
			if (qodefCore.windowWidth > 1024) {
				holder.inner.css(
					{
						'height': qodef.windowHeight - adj - offset
					}
				);
			} else if (qodefCore.windowWidth < 681 && qodefCore.windowWidth > 480) {
				holder.inner.css(
					{
						'height': qodef.windowHeight - offset - 20
					}
				);
			} else {
				holder.inner.css(
					{
						'height': qodef.windowHeight - offset - 20
					}
				);
			}
		},
		resize: function (holder) {
			holder.deltaX   = 0;
			holder.dX       = 0;
			holder.clickedX = false;
			holder.x        = 0;
			holder.buffer   = 0;
		}
	}
	
	qodefCore.shortcodes.eldon_core_portfolio_horizontal.qodefPortfolioListHorizontal = qodefPortfolioListHorizontal;
	qodefCore.shortcodes.eldon_core_portfolio_horizontal.qodefSmileyCursor = qodefCore.qodefSmileyCursor;
	
})( jQuery );

(function ( $ ) {
	'use strict';
	
	var shortcode = 'eldon_core_portfolio_list';
	
	qodefCore.shortcodes[shortcode] = {};
	
	if (typeof qodefCore.listShortcodesScripts === 'object') {
		$.each(
			qodefCore.listShortcodesScripts,
			function (key, value) {
				qodefCore.shortcodes[shortcode][key] = value;
			}
		);
	}
	
	$(document).ready( function () {
		qodefCustomSlider.init();
	});
	
	// $( window ).resize( function () {
	// 	qodefCustomSlider.init();
	// });
	
	var qodefCustomSlider = {
		init: function () {
			var holder = $('.qodef-portfolio-list.qodef--custom-slider-behavior.qodef-swiper-container');
			
			if (holder.length) {
				holder.each(function (index) {
					var $thisHolder = $(this);
					
					qodefCore.body.addClass('qodef--overflow-y-hidden');
					$thisHolder.removeClass('qodef-swiper--initialized');
					
					qodefCustomSlider.animate($thisHolder, index);
				});
			}
		},
		
		animate: function ($holder, index) {
			var $slider = $holder[0].swiper,
				autoplayEnabled = $holder.data('options').autoplay,
				autoplayReversed = $holder.data('options').reverseDirection,
				scrollStart     = false;
			
			$holder.addClass('qodef-swiper--initialized');
			
			if (autoplayEnabled) {
				$slider.autoplay.stop();
				setTimeout(function(){
					$slider.autoplay.start();
				}, index * 250);
			}
			
			qodefCore.body.on(
				'mousewheel',
				function ( e ) {
					
					if ( ! scrollStart ) {
						scrollStart = true;
						
						
						if (e.deltaY < 0) {
							setTimeout(function () {
								if ( !autoplayReversed ) {
									$slider.slideNext();
								} else {
									$slider.slidePrev();
								}
							}, index * 150);
						} else {
							setTimeout(function () {
								if ( !autoplayReversed ) {
									$slider.slidePrev();
								} else {
									$slider.slideNext();
								}
							}, index * 150);
						}
						
						setTimeout(
							function () {
								scrollStart = false;
							},
							1000
						);
					}
				},
			);
		}
	}
	
	qodefCore.shortcodes[shortcode].qodefCustomSlider = qodefCustomSlider;
	qodefCore.shortcodes[shortcode].qodefSmileyCursor = qodefCore.qodefSmileyCursor;
	qodefCore.shortcodes[shortcode].qodefImageBlur = qodef.qodefImageBlur;
	qodefCore.shortcodes[shortcode].qodefControlImage = qodefCore.qodefControlImage;
	
})( jQuery );

(function ( $ ) {
	'use strict';

	var shortcode = 'eldon_core_team_list';

	qodefCore.shortcodes[shortcode] = {};

	if ( typeof qodefCore.listShortcodesScripts === 'object' ) {
		$.each(
			qodefCore.listShortcodesScripts,
			function ( key, value ) {
				qodefCore.shortcodes[shortcode][key] = value;
			}
		);
	}

})( jQuery );

(function ($) {
	"use strict";

	qodefCore.shortcodes.eldon_core_testimonials_list = {};

	$( window ).on(
		'load',
		function(){
			qodefTestimonials.init();
		}
	);

	var qodefTestimonials = {
		init: function () {
			var $holder = $( '.qodef-testimonials-list.qodef-swiper-container.qodef-swiper--initialized' );

			if ($holder.length) {
				$holder.each(
					function () {
						var $thisHolder = $( this );

						qodefTestimonials.calcMinHeight( $thisHolder );

						$( window ).on(
							'resize',
							function () {
								qodefTestimonials.calcMinHeight( $thisHolder );
							}
						);
					}
				)
			}
		},
		calcMinHeight: function($holder) {
			var thisSwiper  = $holder[0].swiper,
				maxHeight   = 100,
				swiperSlide = $holder.find( '.qodef-e-inner' );
			
			swiperSlide.each(
				function(i) {
					if ($( this ).height() > maxHeight) {
						maxHeight = $( this ).outerHeight( true );
					}
					
					if (i === swiperSlide.length - 1){
						maxHeight = parseInt( maxHeight ) + 'px';
						
						$holder.css( 'max-height', maxHeight );
						
						thisSwiper.update();
					}
				}
			);
		}
	}

	qodefCore.shortcodes.eldon_core_testimonials_list.qodefSwiper       = qodef.qodefSwiper;
	qodefCore.shortcodes.eldon_core_testimonials_list.qodefTestimonials = qodefTestimonials;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefInteractiveLinkShowcaseInteractiveList.init();
		}
	);

	var qodefInteractiveLinkShowcaseInteractiveList = {
		init: function () {
			this.holder = $( '.qodef-interactive-link-showcase.qodef-layout--interactive-list' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefInteractiveLinkShowcaseInteractiveList.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			var $links            = $currentItem.find( '.qodef-m-item' ),
				x                 = 0,
				y                 = 0,
				currentXCPosition = 0,
				currentYCPosition = 0;

			if ( $links.length ) {
				$links.on(
					'mouseenter',
					function () {
						$links.removeClass( 'qodef--active' );
						$( this ).addClass( 'qodef--active' );
					}
				).on(
					'mousemove',
					function ( event ) {
						var $thisLink         = $( this ),
							$followInfoHolder = $thisLink.find( '.qodef-e-follow-content' ),
							$followImage      = $followInfoHolder.find( '.qodef-e-follow-image' ),
							$followImageItem  = $followImage.find( 'img' ),
							followImageWidth  = $followImageItem.width(),
							followImagesCount = parseInt( $followImage.data( 'images-count' ), 10 ),
							followImagesSrc   = $followImage.data( 'images' ),
							$followTitle      = $followInfoHolder.find( '.qodef-e-follow-title' ),
							itemWidth         = $thisLink.outerWidth(),
							itemHeight        = $thisLink.outerHeight(),
							itemOffsetTop     = $thisLink.offset().top - qodefCore.scroll,
							itemOffsetLeft    = $thisLink.offset().left;

						x = (event.clientX - itemOffsetLeft) >> 0;
						y = (event.clientY - itemOffsetTop) >> 0;

						if ( x > itemWidth ) {
							currentXCPosition = itemWidth;
						} else if ( x < 0 ) {
							currentXCPosition = 0;
						} else {
							currentXCPosition = x;
						}

						if ( y > itemHeight ) {
							currentYCPosition = itemHeight;
						} else if ( y < 0 ) {
							currentYCPosition = 0;
						} else {
							currentYCPosition = y;
						}

						if ( followImagesCount > 1 ) {
							var imagesUrl    = followImagesSrc.split( '|' ),
								itemPartSize = itemWidth / followImagesCount;

							$followImageItem.removeAttr( 'srcset' );

							if ( currentXCPosition < itemPartSize ) {
								$followImageItem.attr( 'src', imagesUrl[0] );
							}

							// -2 is constant - to remove first and last item from the loop
							for ( var index = 1; index <= (followImagesCount - 2); index++ ) {
								if ( currentXCPosition >= itemPartSize * index && currentXCPosition < itemPartSize * (index + 1) ) {
									$followImageItem.attr( 'src', imagesUrl[index] );
								}
							}

							if ( currentXCPosition >= itemWidth - itemPartSize ) {
								$followImageItem.attr( 'src', imagesUrl[followImagesCount - 1] );
							}
						}

						$followImage.css(
							{
								'top': itemHeight / 2,
							}
						);
						$followTitle.css(
							{
								'transform': 'translateY(' + -(parseInt( itemHeight, 10 ) / 2 + currentYCPosition) + 'px)',
								'left': -(currentXCPosition - followImageWidth / 2),
							}
						);
						$followInfoHolder.css( { 'top': currentYCPosition, 'left': currentXCPosition } );
					}
				).on(
					'mouseleave',
					function () {
						$links.removeClass( 'qodef--active' );
					}
				);
			}

			$currentItem.addClass( 'qodef--init' );
		},
	};

	qodefCore.shortcodes.eldon_core_interactive_link_showcase.qodefInteractiveLinkShowcaseInteractiveList = qodefInteractiveLinkShowcaseInteractiveList;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefInteractiveLinkShowcaseList.init();
		}
	);

	var qodefInteractiveLinkShowcaseList = {
		init: function () {
			this.holder = $( '.qodef-interactive-link-showcase.qodef-layout--list' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefInteractiveLinkShowcaseList.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			var $images = $currentItem.find( '.qodef-m-image' ),
				$links  = $currentItem.find( '.qodef-m-item' );

			$images.eq( 0 ).addClass( 'qodef--active' );
			$links.eq( 0 ).addClass( 'qodef--active' );

			$links.on(
				'touchstart mouseenter',
				function ( e ) {
					var $thisLink = $( this );

					if ( ! qodefCore.html.hasClass( 'touchevents' ) || ( ! $thisLink.hasClass( 'qodef--active' ) && qodefCore.windowWidth > 680) ) {
						e.preventDefault();
						$images.removeClass( 'qodef--active' ).eq( $thisLink.index() ).addClass( 'qodef--active' );
						$links.removeClass( 'qodef--active' ).eq( $thisLink.index() ).addClass( 'qodef--active' );
					}
				}
			).on(
				'touchend mouseleave',
				function () {
					var $thisLink = $( this );

					if ( ! qodefCore.html.hasClass( 'touchevents' ) || ( ! $thisLink.hasClass( 'qodef--active' ) && qodefCore.windowWidth > 680) ) {
						$links.removeClass( 'qodef--active' ).eq( $thisLink.index() ).addClass( 'qodef--active' );
						$images.removeClass( 'qodef--active' ).eq( $thisLink.index() ).addClass( 'qodef--active' );
					}
				}
			);

			$currentItem.addClass( 'qodef--init' );
		},
	};

	qodefCore.shortcodes.eldon_core_interactive_link_showcase.qodefInteractiveLinkShowcaseList = qodefInteractiveLinkShowcaseList;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefInteractiveLinkShowcaseSlider.init();
		}
	);

	var qodefInteractiveLinkShowcaseSlider = {
		init: function () {
			this.holder = $( '.qodef-interactive-link-showcase.qodef-layout--slider' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefInteractiveLinkShowcaseSlider.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			var $images = $currentItem.find( '.qodef-m-image' );

			var $swiperSlider = new Swiper(
				$currentItem.find( '.swiper-container' ),
				{
					loop: true,
					slidesPerView: 'auto',
					centeredSlides: true,
					speed: 1400,
					mousewheel: true,
					init: false
				}
			);

			$currentItem.waitForImages(
				function () {
					$swiperSlider.init();
				}
			);

			$swiperSlider.on(
				'init',
				function () {
					$images.eq( 0 ).addClass( 'qodef--active' );
					$currentItem.find( '.swiper-slide-active' ).addClass( 'qodef--active' );

					$swiperSlider.on(
						'slideChangeTransitionStart',
						function () {
							var $swiperSlides    = $currentItem.find( '.swiper-slide' ),
								$activeSlideItem = $currentItem.find( '.swiper-slide-active' );

							$images.removeClass( 'qodef--active' ).eq( $activeSlideItem.data( 'swiper-slide-index' ) ).addClass( 'qodef--active' );
							$swiperSlides.removeClass( 'qodef--active' );

							$activeSlideItem.addClass( 'qodef--active' );
						}
					);

					$currentItem.find( '.swiper-slide' ).on(
						'click',
						function ( e ) {
							var $thisSwiperLink  = $( this ),
								$activeSlideItem = $currentItem.find( '.swiper-slide-active' );

							if ( ! $thisSwiperLink.hasClass( 'swiper-slide-active' ) ) {
								e.preventDefault();
								e.stopImmediatePropagation();

								if ( e.pageX < $activeSlideItem.offset().left ) {
									$swiperSlider.slidePrev();
									return false;
								}

								if ( e.pageX > $activeSlideItem.offset().left + $activeSlideItem.outerWidth() ) {
									$swiperSlider.slideNext();
									return false;
								}
							}
						}
					);

					$currentItem.addClass( 'qodef--init' );
				}
			);
		},
	};

	qodefCore.shortcodes.eldon_core_interactive_link_showcase.qodefInteractiveLinkShowcaseSlider = qodefInteractiveLinkShowcaseSlider;

})( jQuery );

(function ($) {
	"use strict";
	
	$( document ).ready(
		function () {
			qodefFeaturedBigSwiper.init();
		}
	);

	var qodefFeaturedBigSwiper = {
		init: function () {
			var holder = $( '.qodef-portfolio-list.qodef-item-layout--featured-big.qodef-col-num--1.qodef-swiper-container' );

			if ( holder.length ) {
				holder.each(
					function () {
						var thisHolder = $( this );

						if (qodef.windowWidth > 1024) {
							setTimeout(function(){
								qodefFeaturedBigSwiper.initSwiper( thisHolder );
							}, 100);
						}
					}
				);
			}
		},
		initSwiper: function ( $holder ) {
			var swiperInstance     = $holder[0].swiper,
				$itemInit          = $holder.find( '.qodef-e.swiper-slide-active' ),
				$contentHolderInit = $itemInit.find( '.qodef-e-inner' );//initial swiper

			$contentHolderInit.clone().addClass( 'qodef--custom-swiper qodef--visible' ).appendTo( $holder );//make duplicate of initial swiper
			qodefCore.qodefSmileyCursor.init($holder);

			swiperInstance.on(
				'slideChangeTransitionStart',
				function() {
					var $item              = $holder.find( '.qodef-e.swiper-slide-active' ),
					$holderClone           = $( '.qodef--custom-swiper' ),
					$bigImage              = $item.find( '.qodef-e-left-holder .qodef-e-media-image a' ),
					$bigImageCloneHolder   = $holderClone.find( '.qodef-e-left-holder .qodef-e-media-image' ),
					$bigImageClone         = $bigImageCloneHolder.find( 'a' ),
					$smallImage            = $item.find( '.qodef-e-media-second-image a' ),
					$smallImageCloneHolder = $holderClone.find( '.qodef-e-media-second-image' ),
					$smallImageClone       = $smallImageCloneHolder.find( 'a' ),
					$title                 = $item.find( '.qodef-e-title a' ),
					$titleCloneHolder      = $holderClone.find( '.qodef-e-title' ),
					$titleClone            = $titleCloneHolder.find( 'a' ),
					$info                  = $item.find( '.qodef-e-content-info .qodef-e-content-info-inner' ),
					$infoCloneHolder       = $holderClone.find( '.qodef-e-content-info' ),
					$infoClone             = $infoCloneHolder.find( '.qodef-e-content-info-inner' );

					$bigImageClone.removeClass( 'qodef--animate-in' ).addClass( 'qodef--animate-out' );
					$smallImageClone.removeClass( 'qodef--animate-in' ).addClass( 'qodef--animate-out' );
					$titleClone.removeClass( 'qodef--animate-in' ).addClass( 'qodef--animate-out' );
					$infoClone.removeClass( 'qodef--animate-in' ).addClass( 'qodef--animate-out' );

					if ($( '.qodef--animate-out' ).length > 1) {
						$( '.qodef--animate-out' ).not( ':last-child' ).remove();
					}

					$bigImage.clone().addClass( 'qodef--animate-in' ).appendTo( $bigImageCloneHolder );
					$smallImage.clone().addClass( 'qodef--animate-in' ).appendTo( $smallImageCloneHolder );
					$title.clone().addClass( 'qodef--animate-in' ).appendTo( $titleCloneHolder );
					$info.clone().addClass( 'qodef--animate-in' ).appendTo( $infoCloneHolder );
				}
			);
		}
	};

	qodefCore.shortcodes.eldon_core_portfolio_list.qodefFeaturedBigSwiper = qodefFeaturedBigSwiper;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefInfoFollow.init();
			qodefTiltInfoFollow.init();
		}
	);

	$( document ).on(
		'eldon_trigger_get_new_posts',
		function () {
			qodefInfoFollow.init();
			qodefTiltInfoFollow.init();
		}
	);

	var qodefInfoFollow = {
		init: function () {
			var $gallery = $( '.qodef-hover-animation--follow' );

			if ( $gallery.length ) {

				$gallery.each(
					function () {

						$( this ).append( '<div class="qodef-e-content-follow"><div class="qodef-e-top-holder"><div class="qodef-e-text"></div><div class="qodef-e-icon"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 43 30" xml:space="preserve"><polygon points="29.2,0 21.1,0 32.2,12.2 -0.1,12.2 -0.1,18.2 32.1,18.2 21.1,30 29.2,30 43,15.2 "/></svg></div></div><div class="qodef-e-bottom-holder"></div></div>' );

						var $contentFollow = $( this ).find( '.qodef-e-content-follow' ),
							$bottomHolder  = $contentFollow.find( '.qodef-e-bottom-holder' ),
							$textHolder    = $contentFollow.find( '.qodef-e-text' );

						if ( $( this ).hasClass( 'qodef-arrow-enabled' ) ) {
							if ( ! $contentFollow.hasClass( 'qodef-has-arrow' ) ) {
								$contentFollow.addClass( 'qodef-has-arrow' );
							}
						} else {
							if ( $contentFollow.hasClass( 'qodef-has-arrow' ) ) {
								$contentFollow.removeClass( 'qodef-has-arrow' );
							}
						}

						$( this ).find( '.qodef-e-inner' ).each(
							function () {
								var $thisItem = $( this );

								//info element position
								$thisItem.on(
									'mousemove',
									function ( e ) {
										if ( e.clientX + 20 + $contentFollow.width() > qodefCore.windowWidth ) {
											$contentFollow.addClass( 'qodef-right' );
										} else {
											$contentFollow.removeClass( 'qodef-right' );
										}

										$contentFollow.css(
											{
												top: e.clientY + 20,
												left: e.clientX + 20,
											}
										);
									}
								);

								//show/hide info element
								$thisItem.on(
									'mouseenter',
									function () {
										var $thisItemTopHolder  = $( this ).find( '.qodef-e-top-holder' ),
											$thisItemTextHolder = $( this ).find( '.qodef-e-text' );

										if ( $thisItemTopHolder.length ) {
											$bottomHolder.html( $thisItemTopHolder.html() );
										}

										if ( $thisItemTextHolder.length ) {
											$textHolder.html( $thisItemTextHolder.html() );
										}

										if ( ! $contentFollow.hasClass( 'qodef-is-active' ) ) {
											$contentFollow.addClass( 'qodef-is-active' );
										}
									}
								).on(
									'mouseleave',
									function () {
										if ( $contentFollow.hasClass( 'qodef-is-active' ) ) {
											$contentFollow.removeClass( 'qodef-is-active' );
										}
									}
								);
							}
						);
					}
				);
			}
		},
	};
	
	var qodefTiltInfoFollow = {
		init: function () {
			var $gallery = $('.qodef-portfolio-list.qodef-item-layout--info-follow.qodef-image-tilt');
			
			if ($gallery.length && qodefCore.windowWidth > 1024) {
				$gallery.each(function () {
					var $this = $(this);
					
					$this.find('.qodef-e-inner').each(function () {
						var $tiltHolder = $(this).find('.js-tilt-glare');
						
						if ( $tiltHolder.length === 0 ) {
							$(this).tilt({
								maxTilt: 40,
								perspective: 300,
								easing: "cubic-bezier(0.22, 0.61, 0.36, 1)",
								transition: true,
								speed: 300,
								glare: false,
							});
						}
					});
				});
			}
		}
	};

	qodefCore.shortcodes.eldon_core_portfolio_list.qodefInfoFollow = qodefInfoFollow;
	qodefCore.shortcodes.eldon_core_portfolio_list.qodefTiltInfoFollow = qodefTiltInfoFollow;

})( jQuery );

(function ($) {
	"use strict";

	// qodefCore.shortcodes.eldon_core_portfolio_list = {};
	
	$(document).ready(function () {
		qodefTiltInfoDivided.init();
		qodefSkewInfoDivided.init();
	});

	$(document).on(
		'eldon_trigger_get_new_posts',
		function () {
			qodefTiltInfoDivided.init();
		}
	);

	var qodefTiltInfoDivided = {
		init: function () {
			var $gallery = $('.qodef-portfolio-list.qodef-item-layout--info-image-divided.qodef-hover-animation--tilt');

			if ($gallery.length && qodefCore.windowWidth > 1024) {
				$gallery.each(function () {
					var $this = $(this);

					$this.find('.qodef-e .qodef-e-image-tilt').each(function () {
						var $tiltHolder = $(this).find('.js-tilt-glare');

						if ( $tiltHolder.length === 0 ) {
							$(this).tilt({
								maxTilt: 25,
								perspective: 3000,
								easing: "cubic-bezier(0.22, 0.61, 0.36, 1)",
								transition: true,
								speed: 300,
								glare: false,
							});
						}
					});
				});
			}
		}
	};
	
	var qodefSkewInfoDivided = {
		init: function () {
			var $gallery = $('.qodef-portfolio-list.qodef-item-layout--info-image-divided');
			
			if ($gallery.length && qodefCore.windowWidth > 1024) {
				$gallery.each(function () {
					var $this = $(this);
					const maxSkew = 15;
					const maxRotate = 10;
					let currentPosition = window.pageYOffset;
					
					requestAnimationFrame(animate);

					function animate() {
						//_scrollY = window.scrollY;  //for mobile only?
						const newPosition = window.pageYOffset;
						const dif = newPosition - currentPosition;
						
						let skew = dif * 0.8;
						let rotate = dif * 0.2;
						if (skew > maxSkew || skew < -maxSkew) {
							if (skew > 0) {
								skew = maxSkew;
							} else if (skew < 0) {
								skew = -maxSkew;
							}
						}
						if (rotate > maxRotate || rotate < -maxRotate) {
							if (rotate > 0) {
								rotate = maxRotate;
							} else if (skew < 0) {
								rotate = -maxRotate;
							}
						}

						$this.find('.qodef-e-image').each(function () {
							var $item= $(this);
							
							$item.css({
								'transform': `skewY(${skew}deg) rotateY(${rotate}deg)`,
							});

						});
						
						currentPosition = newPosition;
						
						requestAnimationFrame(animate);
					}
				});
			}
		}
	};

	qodefCore.shortcodes.eldon_core_portfolio_list.qodefTiltInfoDivided = qodefTiltInfoDivided;
	qodefCore.shortcodes.eldon_core_portfolio_list.qodefSkewInfoDivided = qodefSkewInfoDivided;
	
})(jQuery);