<?php

if ( ! function_exists( 'eldon_core_add_vertical_minimal_header_global_option' ) ) {
	/**
	 * This function set header type value for global header option map
	 */
	function eldon_core_add_vertical_minimal_header_global_option( $header_layout_options ) {
		$header_layout_options['vertical-minimal'] = array(
			'image' => ELDON_CORE_HEADER_LAYOUTS_URL_PATH . '/vertical-minimal/assets/img/vertical-minimal-header.png',
			'label' => esc_html__( 'Vertical Minimal', 'eldon-core' ),
		);

		return $header_layout_options;
	}

	add_filter( 'eldon_core_filter_header_layout_option', 'eldon_core_add_vertical_minimal_header_global_option' );
}

if ( ! function_exists( 'eldon_core_register_vertical_minimal_header_layout' ) ) {
	/**
	 * Function which add header layout into global list
	 *
	 * @param array $header_layouts
	 *
	 * @return array
	 */
	function eldon_core_register_vertical_minimal_header_layout( $header_layouts ) {
		$header_layout = array(
			'vertical-minimal' => 'EldonCore_vertical_minimal_Header',
		);

		$header_layouts = array_merge( $header_layouts, $header_layout );

		return $header_layouts;
	}

	add_filter( 'eldon_core_filter_register_header_layouts', 'eldon_core_register_vertical_minimal_header_layout' );
}

if ( ! function_exists( 'eldon_core_vertical_minimal_header_nav_menu_grid' ) ) {
	/**
	 * Function which set grid class name for current header layout
	 *
	 * @param string $grid_class
	 *
	 * @return string
	 */
	function eldon_core_vertical_minimal_header_nav_menu_grid( $grid_class ) {
		$header = eldon_core_get_post_value_through_levels( 'qodef_header_layout' );

		if ( 'vertical-minimal' === $header ) {
			return false;
		}

		return $grid_class;
	}

	add_filter( 'eldon_core_filter_drop_down_grid', 'eldon_core_vertical_minimal_header_nav_menu_grid' );
}

if ( ! function_exists( 'eldon_core_vertical_minimal_header_hide_top_area' ) ) {
	/**
	 * Function that set dependency option value for specific module layout
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	function eldon_core_vertical_minimal_header_hide_top_area( $options ) {
		$options[] = 'vertical-minimal';

		return $options;
	}

	add_filter( 'eldon_core_filter_top_area_hide_option', 'eldon_core_vertical_minimal_header_hide_top_area' );
}

if ( ! function_exists( 'eldon_core_vertical_minimal_header_hide_scroll_appearance' ) ) {
	/**
	 * Function that set dependency option value for specific module layout
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	function eldon_core_vertical_minimal_header_hide_scroll_appearance( $options ) {
		$options[] = 'vertical-minimal';

		return $options;
	}

	add_filter( 'eldon_core_filter_header_scroll_appearance_hide_option', 'eldon_core_vertical_minimal_header_hide_scroll_appearance' );
}
