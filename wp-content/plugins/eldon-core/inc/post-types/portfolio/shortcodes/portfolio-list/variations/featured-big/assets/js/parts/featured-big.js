(function ($) {
	"use strict";
	
	$( document ).ready(
		function () {
			qodefFeaturedBigSwiper.init();
		}
	);

	var qodefFeaturedBigSwiper = {
		init: function () {
			var holder = $( '.qodef-portfolio-list.qodef-item-layout--featured-big.qodef-col-num--1.qodef-swiper-container' );

			if ( holder.length ) {
				holder.each(
					function () {
						var thisHolder = $( this );

						if (qodef.windowWidth > 1024) {
							setTimeout(function(){
								qodefFeaturedBigSwiper.initSwiper( thisHolder );
							}, 100);
						}
					}
				);
			}
		},
		initSwiper: function ( $holder ) {
			var swiperInstance     = $holder[0].swiper,
				$itemInit          = $holder.find( '.qodef-e.swiper-slide-active' ),
				$contentHolderInit = $itemInit.find( '.qodef-e-inner' );//initial swiper

			$contentHolderInit.clone().addClass( 'qodef--custom-swiper qodef--visible' ).appendTo( $holder );//make duplicate of initial swiper
			qodefCore.qodefSmileyCursor.init($holder);

			swiperInstance.on(
				'slideChangeTransitionStart',
				function() {
					var $item              = $holder.find( '.qodef-e.swiper-slide-active' ),
					$holderClone           = $( '.qodef--custom-swiper' ),
					$bigImage              = $item.find( '.qodef-e-left-holder .qodef-e-media-image a' ),
					$bigImageCloneHolder   = $holderClone.find( '.qodef-e-left-holder .qodef-e-media-image' ),
					$bigImageClone         = $bigImageCloneHolder.find( 'a' ),
					$smallImage            = $item.find( '.qodef-e-media-second-image a' ),
					$smallImageCloneHolder = $holderClone.find( '.qodef-e-media-second-image' ),
					$smallImageClone       = $smallImageCloneHolder.find( 'a' ),
					$title                 = $item.find( '.qodef-e-title a' ),
					$titleCloneHolder      = $holderClone.find( '.qodef-e-title' ),
					$titleClone            = $titleCloneHolder.find( 'a' ),
					$info                  = $item.find( '.qodef-e-content-info .qodef-e-content-info-inner' ),
					$infoCloneHolder       = $holderClone.find( '.qodef-e-content-info' ),
					$infoClone             = $infoCloneHolder.find( '.qodef-e-content-info-inner' );

					$bigImageClone.removeClass( 'qodef--animate-in' ).addClass( 'qodef--animate-out' );
					$smallImageClone.removeClass( 'qodef--animate-in' ).addClass( 'qodef--animate-out' );
					$titleClone.removeClass( 'qodef--animate-in' ).addClass( 'qodef--animate-out' );
					$infoClone.removeClass( 'qodef--animate-in' ).addClass( 'qodef--animate-out' );

					if ($( '.qodef--animate-out' ).length > 1) {
						$( '.qodef--animate-out' ).not( ':last-child' ).remove();
					}

					$bigImage.clone().addClass( 'qodef--animate-in' ).appendTo( $bigImageCloneHolder );
					$smallImage.clone().addClass( 'qodef--animate-in' ).appendTo( $smallImageCloneHolder );
					$title.clone().addClass( 'qodef--animate-in' ).appendTo( $titleCloneHolder );
					$info.clone().addClass( 'qodef--animate-in' ).appendTo( $infoCloneHolder );
				}
			);
		}
	};

	qodefCore.shortcodes.eldon_core_portfolio_list.qodefFeaturedBigSwiper = qodefFeaturedBigSwiper;

})( jQuery );
