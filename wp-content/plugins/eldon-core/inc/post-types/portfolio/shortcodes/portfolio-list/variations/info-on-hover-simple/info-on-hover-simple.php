<?php

if ( ! function_exists( 'eldon_core_add_portfolio_list_variation_info_on_hover_simple' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function eldon_core_add_portfolio_list_variation_info_on_hover_simple( $variations ) {
		$variations['info-on-hover-simple'] = esc_html__( 'Info On Hover Simple', 'eldon-core' );

		return $variations;
	}

	add_filter( 'eldon_core_filter_portfolio_list_layouts', 'eldon_core_add_portfolio_list_variation_info_on_hover_simple' );
}
