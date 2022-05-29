<?php

if ( ! function_exists( 'eldon_core_add_portfolio_fullscreen_showcase_variation_info_bottom_left' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function eldon_core_add_portfolio_fullscreen_showcase_variation_info_bottom_left( $variations ) {

		$variations['info-bottom-left'] = esc_html__( 'Info Bottom Left', 'eldon-core' );

		return $variations;
	}

	add_filter( 'eldon_core_filter_portfolio_fullscreen_showcase_layouts', 'eldon_core_add_portfolio_fullscreen_showcase_variation_info_bottom_left' );
}
