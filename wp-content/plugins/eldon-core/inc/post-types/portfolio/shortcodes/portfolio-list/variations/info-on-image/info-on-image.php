<?php

if ( ! function_exists( 'eldon_core_add_portfolio_list_variation_info_on_image' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function eldon_core_add_portfolio_list_variation_info_on_image( $variations ) {
		$variations['info-on-image'] = esc_html__( 'Info On Image', 'eldon-core' );

		return $variations;
	}

	add_filter( 'eldon_core_filter_portfolio_list_layouts', 'eldon_core_add_portfolio_list_variation_info_on_image' );
}
