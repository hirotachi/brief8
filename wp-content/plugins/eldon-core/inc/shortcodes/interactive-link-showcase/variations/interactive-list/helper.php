<?php

if ( ! function_exists( 'eldon_core_add_interactive_link_showcase_variation_interactive_list' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function eldon_core_add_interactive_link_showcase_variation_interactive_list( $variations ) {
		$variations['interactive-list'] = esc_html__( 'Interactive List', 'eldon-core' );

		return $variations;
	}

	add_filter( 'eldon_core_filter_interactive_link_showcase_layouts', 'eldon_core_add_interactive_link_showcase_variation_interactive_list' );
}
