<?php

if ( ! function_exists( 'eldon_core_add_blog_list_variation_minimal' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function eldon_core_add_blog_list_variation_minimal( $variations ) {
		$variations['minimal'] = esc_html__( 'Minimal', 'eldon-core' );

		return $variations;
	}

	add_filter( 'eldon_core_filter_blog_list_layouts', 'eldon_core_add_blog_list_variation_minimal' );
}
