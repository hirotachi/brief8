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
