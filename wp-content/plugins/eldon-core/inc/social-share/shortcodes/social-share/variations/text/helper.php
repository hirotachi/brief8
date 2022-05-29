<?php

if ( ! function_exists( 'eldon_core_add_social_share_variation_text' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function eldon_core_add_social_share_variation_text( $variations ) {
		$variations['text'] = esc_html__( 'Text', 'eldon-core' );

		return $variations;
	}

	add_filter( 'eldon_core_filter_social_share_layouts', 'eldon_core_add_social_share_variation_text' );
}
