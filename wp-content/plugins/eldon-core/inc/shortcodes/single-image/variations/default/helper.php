<?php

if ( ! function_exists( 'eldon_core_add_single_image_variation_default' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function eldon_core_add_single_image_variation_default( $variations ) {
		$variations['default'] = esc_html__( 'Default', 'eldon-core' );

		return $variations;
	}

	add_filter( 'eldon_core_filter_single_image_layouts', 'eldon_core_add_single_image_variation_default' );
}
