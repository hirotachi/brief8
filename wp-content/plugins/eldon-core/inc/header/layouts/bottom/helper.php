<?php

if ( ! function_exists( 'eldon_core_add_bottom_header_global_option' ) ) {
	/**
	 * This function set header type value for global header option map
	 */
	function eldon_core_add_bottom_header_global_option( $header_layout_options ) {
		$header_layout_options['bottom'] = array(
			'image' => ELDON_CORE_HEADER_LAYOUTS_URL_PATH . '/bottom/assets/img/bottom-header.png',
			'label' => esc_html__( 'Bottom', 'eldon-core' ),
		);

		return $header_layout_options;
	}

	add_filter( 'eldon_core_filter_header_layout_option', 'eldon_core_add_bottom_header_global_option' );
}

if ( ! function_exists( 'eldon_core_register_bottom_header_layout' ) ) {
	function eldon_core_register_bottom_header_layout( $header_layouts ) {
		$header_layout = array(
			'bottom' => 'EldonCore_Bottom_Header',
		);

		$header_layouts = array_merge( $header_layouts, $header_layout );

		return $header_layouts;
	}

	add_filter( 'eldon_core_filter_register_header_layouts', 'eldon_core_register_bottom_header_layout' );
}

if ( ! function_exists( 'eldon_core_header_bottom_include_slider_template' ) ) {
	function eldon_core_header_bottom_include_slider_template() {
		if ( 'bottom' === eldon_core_get_post_value_through_levels( 'qodef_header_layout' ) ) {
			if ( ! empty( eldon_core_get_post_value_through_levels( 'qodef_bottom_header_slider' ) ) ) {
				eldon_core_template_part( 'header', 'layouts/bottom/templates/slider' );
			}
		}
	}

	add_action( 'eldon_action_after_page_wrapper', 'eldon_core_header_bottom_include_slider_template' );
}

if ( ! function_exists( 'eldon_core_header_bottom_hide_top_area' ) ) {
	function eldon_core_header_bottom_hide_top_area( $options ) {
		$options[] = 'bottom';

		return $options;
	}

	add_filter( 'eldon_core_filter_top_area_hide_option', 'eldon_core_header_bottom_hide_top_area' );
}

if ( ! function_exists( 'eldon_core_header_bottom_hide_scroll_appearance' ) ) {
	function eldon_core_header_bottom_hide_scroll_appearance( $options ) {
		$options[] = 'bottom';

		return $options;
	}

	add_filter( 'eldon_core_filter_header_scroll_appearance_hide_option', 'eldon_core_header_bottom_hide_scroll_appearance' );
}
