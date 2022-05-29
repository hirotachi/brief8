<?php

if ( ! function_exists( 'eldon_core_add_portfolio_single_variation_custom' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function eldon_core_add_portfolio_single_variation_custom( $variations ) {
		$variations['custom'] = esc_html__( 'Custom', 'eldon-core' );

		return $variations;
	}

	add_filter( 'eldon_core_filter_portfolio_single_layout_options', 'eldon_core_add_portfolio_single_variation_custom' );
}
