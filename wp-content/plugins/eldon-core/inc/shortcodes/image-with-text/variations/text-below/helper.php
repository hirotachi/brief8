<?php

if ( ! function_exists( 'eldon_core_add_image_with_text_variation_text_below' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function eldon_core_add_image_with_text_variation_text_below( $variations ) {
		$variations['text-below'] = esc_html__( 'Text Below', 'eldon-core' );

		return $variations;
	}

	add_filter( 'eldon_core_filter_image_with_text_layouts', 'eldon_core_add_image_with_text_variation_text_below' );
}
