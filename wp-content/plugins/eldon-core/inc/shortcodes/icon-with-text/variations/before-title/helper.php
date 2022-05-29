<?php

if ( ! function_exists( 'eldon_core_add_icon_with_text_variation_before_title' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function eldon_core_add_icon_with_text_variation_before_title( $variations ) {
		$variations['before-title'] = esc_html__( 'Before Title', 'eldon-core' );

		return $variations;
	}

	add_filter( 'eldon_core_filter_icon_with_text_layouts', 'eldon_core_add_icon_with_text_variation_before_title' );
}
