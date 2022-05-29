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
