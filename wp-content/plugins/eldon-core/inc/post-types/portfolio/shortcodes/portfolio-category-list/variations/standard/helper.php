<?php

if ( ! function_exists( 'eldon_core_add_portfolio_category_list_variation_standard' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function eldon_core_add_portfolio_category_list_variation_standard( $variations ) {
		$variations['standard'] = esc_html__( 'Standard', 'eldon-core' );

		return $variations;
	}

	add_filter( 'eldon_core_filter_portfolio_category_list_layouts', 'eldon_core_add_portfolio_category_list_variation_standard' );
}
