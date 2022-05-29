<?php

if ( ! function_exists( 'eldon_core_add_countdown_variation_simple' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function eldon_core_add_countdown_variation_simple( $variations ) {
		$variations['simple'] = esc_html__( 'Simple', 'eldon-core' );

		return $variations;
	}

	add_filter( 'eldon_core_filter_countdown_layouts', 'eldon_core_add_countdown_variation_simple' );
}
