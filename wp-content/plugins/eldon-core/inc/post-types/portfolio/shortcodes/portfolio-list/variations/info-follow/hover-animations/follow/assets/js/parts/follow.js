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
