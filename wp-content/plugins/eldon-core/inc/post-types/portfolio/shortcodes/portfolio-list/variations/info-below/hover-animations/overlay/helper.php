<?php

if ( ! function_exists( 'eldon_core_filter_portfolio_list_info_below_overlay' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function eldon_core_filter_portfolio_list_info_below_overlay( $variations ) {
		$variations['overlay'] = esc_html__( 'Overlay', 'eldon-core' );

		return $variations;
	}

	add_filter( 'eldon_core_filter_portfolio_list_info_below_animation_options', 'eldon_core_filter_portfolio_list_info_below_overlay' );
}
