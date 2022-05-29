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
