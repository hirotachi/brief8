<?php

if ( ! function_exists( 'eldon_core_filter_portfolio_list_info_image_divided' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function eldon_core_filter_portfolio_list_info_image_divided( $variations ) {
		$variations['tilt'] = esc_html__( 'Tilt', 'oraiste-core' );
		
		return $variations;
	}
	
	add_filter( 'eldon_core_filter_portfolio_list_info_image_divided_animation_options', 'eldon_core_filter_portfolio_list_info_image_divided' );
}