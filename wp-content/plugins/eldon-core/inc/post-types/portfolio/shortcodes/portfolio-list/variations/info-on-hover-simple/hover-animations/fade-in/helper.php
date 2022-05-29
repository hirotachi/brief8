<?php

if ( ! function_exists( 'eldon_core_filter_portfolio_list_info_on_hover_fade_in' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function eldon_core_filter_portfolio_list_info_on_hover_fade_in( $variations ) {
		$variations['fade-in'] = esc_html__( 'Fade In', 'eldon-core' );

		return $variations;
	}

	add_filter( 'eldon_core_filter_portfolio_list_info_on_hover_animation_options', 'eldon_core_filter_portfolio_list_info_on_hover_fade_in' );
}
