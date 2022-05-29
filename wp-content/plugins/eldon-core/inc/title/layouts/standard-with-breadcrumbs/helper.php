<?php

if ( ! function_exists( 'eldon_core_register_standard_with_breadcrumbs_title_layout' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $layouts
	 *
	 * @return array
	 */
	function eldon_core_register_standard_with_breadcrumbs_title_layout( $layouts ) {
		$layouts['standard-with-breadcrumbs'] = 'EldonCore_Standard_With_Breadcrumbs_Title';

		return $layouts;
	}

	add_filter( 'eldon_core_filter_register_title_layouts', 'eldon_core_register_standard_with_breadcrumbs_title_layout' );
}

if ( ! function_exists( 'eldon_core_add_standard_with_breadcrumbs_title_layout_option' ) ) {
	/**
	 * Function that set new value into title layout options map
	 *
	 * @param array $layouts - module layouts
	 *
	 * @return array
	 */
	function eldon_core_add_standard_with_breadcrumbs_title_layout_option( $layouts ) {
		$layouts['standard-with-breadcrumbs'] = esc_html__( 'Standard with breadcrumbs', 'eldon-core' );

		return $layouts;
	}

	add_filter( 'eldon_core_filter_title_layout_options', 'eldon_core_add_standard_with_breadcrumbs_title_layout_option' );
}
