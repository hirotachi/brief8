<?php

if ( ! function_exists( 'eldon_core_add_portfolio_fullscreen_showcase_variation_inverted_color_title' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function eldon_core_add_portfolio_fullscreen_showcase_variation_inverted_color_title( $variations ) {

		$variations['inverted-color-title'] = esc_html__( 'Inverted Color Title', 'eldon-core' );

		return $variations;
	}

	add_filter( 'eldon_core_filter_portfolio_fullscreen_showcase_layouts', 'eldon_core_add_portfolio_fullscreen_showcase_variation_inverted_color_title' );
}
