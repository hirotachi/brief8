<?php

if ( ! function_exists( 'eldon_core_add_portfolio_single_variation_masonry_small' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function eldon_core_add_portfolio_single_variation_masonry_small( $variations ) {
		$variations['masonry-small'] = esc_html__( 'Masonry - Small', 'eldon-core' );

		return $variations;
	}

	add_filter( 'eldon_core_filter_portfolio_single_layout_options', 'eldon_core_add_portfolio_single_variation_masonry_small' );
}

if ( ! function_exists( 'eldon_core_include_masonry_for_portfolio_single_variation_masonry_small' ) ) {
	/**
	 * Function that include masonry scripts for current module layout
	 *
	 * @param string $post_type
	 *
	 * @return string
	 */
	function eldon_core_include_masonry_for_portfolio_single_variation_masonry_small( $post_type ) {
		$portfolio_template = eldon_core_get_post_value_through_levels( 'qodef_portfolio_single_layout' );

		if ( 'masonry-small' === $portfolio_template ) {
			$post_type = 'portfolio-item';
		}

		return $post_type;
	}

	add_filter( 'eldon_filter_allowed_post_type_to_enqueue_masonry_scripts', 'eldon_core_include_masonry_for_portfolio_single_variation_masonry_small' );
}
