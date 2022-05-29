<?php

if ( ! function_exists( 'eldon_core_add_portfolio_single_variation_gallery_small' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function eldon_core_add_portfolio_single_variation_gallery_small( $variations ) {
		$variations['gallery-small'] = esc_html__( 'Gallery - Small', 'eldon-core' );

		return $variations;
	}

	add_filter( 'eldon_core_filter_portfolio_single_layout_options', 'eldon_core_add_portfolio_single_variation_gallery_small' );
}
