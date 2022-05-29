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
