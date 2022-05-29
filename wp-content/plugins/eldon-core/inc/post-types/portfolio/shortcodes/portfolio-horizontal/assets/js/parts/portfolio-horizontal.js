
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
