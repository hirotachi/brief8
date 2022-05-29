<?php

if ( ! function_exists( 'eldon_core_add_portfolio_single_variation_slider_big' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function eldon_core_add_portfolio_single_variation_slider_big( $variations ) {
		$variations['slider-big'] = esc_html__( 'Slider - Big', 'eldon-core' );

		return $variations;
	}

	add_filter( 'eldon_core_filter_portfolio_single_layout_options', 'eldon_core_add_portfolio_single_variation_slider_big' );
}
