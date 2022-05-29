<?php

if ( ! function_exists( 'eldon_core_add_button_variation_filled' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function eldon_core_add_button_variation_filled( $variations ) {
		$variations['filled'] = esc_html__( 'Filled', 'eldon-core' );

		return $variations;
	}

	add_filter( 'eldon_core_filter_button_layouts', 'eldon_core_add_button_variation_filled' );
}
