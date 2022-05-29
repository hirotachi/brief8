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
