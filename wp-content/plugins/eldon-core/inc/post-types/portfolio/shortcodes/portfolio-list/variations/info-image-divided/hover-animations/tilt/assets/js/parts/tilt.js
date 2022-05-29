(function ($) {
	"use strict";

	// qodefCore.shortcodes.eldon_core_portfolio_list = {};
	
	$(document).ready(function () {
		qodefTiltInfoDivided.init();
		qodefSkewInfoDivided.init();
	});

	$(document).on(
		'eldon_trigger_get_new_posts',
		function () {
			qodefTiltInfoDivided.init();
		}
	);

	var qodefTiltInfoDivided = {
		init: function () {
			var $gallery = $('.qodef-portfolio-list.qodef-item-layout--info-image-divided.qodef-hover-animation--tilt');

			if ($gallery.length && qodefCore.windowWidth > 1024) {
				$gallery.each(function () {
					var $this = $(this);

					$this.find('.qodef-e .qodef-e-image-tilt').each(function () {
						var $tiltHolder = $(this).find('.js-tilt-glare');

						if ( $tiltHolder.length === 0 ) {
							$(this).tilt({
								maxTilt: 25,
								perspective: 3000,
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
	
	var qodefSkewInfoDivided = {
		init: function () {
			var $gallery = $('.qodef-portfolio-list.qodef-item-layout--info-image-divided');
			
			if ($gallery.length && qodefCore.windowWidth > 1024) {
				$gallery.each(function () {
					var $this = $(this);
					const maxSkew = 15;
					const maxRotate = 10;
					let currentPosition = window.pageYOffset;
					
					requestAnimationFrame(animate);

					function animate() {
						//_scrollY = window.scrollY;  //for mobile only?
						const newPosition = window.pageYOffset;
						const dif = newPosition - currentPosition;
						
						let skew = dif * 0.8;
						let rotate = dif * 0.2;
						if (skew > maxSkew || skew < -maxSkew) {
							if (skew > 0) {
								skew = maxSkew;
							} else if (skew < 0) {
								skew = -maxSkew;
							}
						}
						if (rotate > maxRotate || rotate < -maxRotate) {
							if (rotate > 0) {
								rotate = maxRotate;
							} else if (skew < 0) {
								rotate = -maxRotate;
							}
						}

						$this.find('.qodef-e-image').each(function () {
							var $item= $(this);
							
							$item.css({
								'transform': `skewY(${skew}deg) rotateY(${rotate}deg)`,
							});

						});
						
						currentPosition = newPosition;
						
						requestAnimationFrame(animate);
					}
				});
			}
		}
	};

	qodefCore.shortcodes.eldon_core_portfolio_list.qodefTiltInfoDivided = qodefTiltInfoDivided;
	qodefCore.shortcodes.eldon_core_portfolio_list.qodefSkewInfoDivided = qodefSkewInfoDivided;
	
})(jQuery);