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
