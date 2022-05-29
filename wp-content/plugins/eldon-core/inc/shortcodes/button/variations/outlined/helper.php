<?php

if ( ! function_exists( 'eldon_core_add_button_variation_outlined' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function eldon_core_add_button_variation_outlined( $variations ) {
		$variations['outlined'] = esc_html__( 'Outlined', 'eldon-core' );

		return $variations;
	}

	add_filter( 'eldon_core_filter_button_layouts', 'eldon_core_add_button_variation_outlined' );
}
