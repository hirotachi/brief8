<?php

if ( ! function_exists( 'eldon_core_add_interactive_link_showcase_variation_slider' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function eldon_core_add_interactive_link_showcase_variation_slider( $variations ) {
		$variations['slider'] = esc_html__( 'Slider', 'eldon-core' );

		return $variations;
	}

	add_filter( 'eldon_core_filter_interactive_link_showcase_layouts', 'eldon_core_add_interactive_link_showcase_variation_slider' );
}
