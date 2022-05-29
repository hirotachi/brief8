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
