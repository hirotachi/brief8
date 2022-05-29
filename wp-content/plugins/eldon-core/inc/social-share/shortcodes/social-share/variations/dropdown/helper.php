<?php

if ( ! function_exists( 'eldon_core_add_social_share_variation_dropdown' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function eldon_core_add_social_share_variation_dropdown( $variations ) {
		$variations['dropdown'] = esc_html__( 'Dropdown', 'eldon-core' );

		return $variations;
	}

	add_filter( 'eldon_core_filter_social_share_layouts', 'eldon_core_add_social_share_variation_dropdown' );
}
