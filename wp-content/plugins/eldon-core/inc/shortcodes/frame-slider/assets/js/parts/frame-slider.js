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
