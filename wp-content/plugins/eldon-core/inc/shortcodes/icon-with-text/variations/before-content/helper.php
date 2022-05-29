<?php

if ( ! function_exists( 'eldon_core_add_icon_with_text_variation_before_content' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function eldon_core_add_icon_with_text_variation_before_content( $variations ) {
		$variations['before-content'] = esc_html__( 'Before Content', 'eldon-core' );

		return $variations;
	}

	add_filter( 'eldon_core_filter_icon_with_text_layouts', 'eldon_core_add_icon_with_text_variation_before_content' );
}
