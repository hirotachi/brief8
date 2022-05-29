<?php

if ( ! function_exists( 'eldon_load_page_header' ) ) {
	/**
	 * Function which loads page template module
	 */
	function eldon_load_page_header() {
		// Include header template
		echo apply_filters( 'eldon_filter_header_template', eldon_get_template_part( 'header', 'templates/header' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	add_action( 'eldon_action_page_header_template', 'eldon_load_page_header' );
}

if ( ! function_exists( 'eldon_register_navigation_menus' ) ) {
	/**
	 * Function which registers navigation menus
	 */
	function eldon_register_navigation_menus() {
		$navigation_menus = apply_filters( 'eldon_filter_register_navigation_menus', array( 'main-navigation' => esc_html__( 'Main Navigation', 'eldon' ) ) );

		if ( ! empty( $navigation_menus ) ) {
			register_nav_menus( $navigation_menus );
		}
	}

	add_action( 'eldon_action_after_include_modules', 'eldon_register_navigation_menus' );
}

if ( ! function_exists( 'eldon_get_header_logo_image' ) ) {
	/**
	 * Function that return header logo image html
	 *
	 * @return string containing html of logo image
	 */
	function eldon_get_header_logo_image() {
		$logo_image      = '<img itemprop="logo" class="qodef-header-logo-image qodef--main" src="' . esc_url( ELDON_ASSETS_ROOT . '/img/logo.png' ) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" />';
		$customizer_logo = get_custom_logo();

		if ( ! empty( $customizer_logo ) ) {
			$customizer_logo_id = get_theme_mod( 'custom_logo' );

			if ( $customizer_logo_id ) {
				$customizer_logo_id_attr = array(
					'class'    => 'qodef-header-logo-image qodef--main',
					'itemprop' => 'logo',
				);

				$image_alt = get_post_meta( $customizer_logo_id, '_wp_attachment_image_alt', true );
				if ( empty( $image_alt ) ) {
					$customizer_logo_id_attr['alt'] = get_bloginfo( 'name', 'display' );
				}

				$logo_image = wp_get_attachment_image( $customizer_logo_id, 'full', false, $customizer_logo_id_attr );
			}
		}

		return apply_filters( 'eldon_filter_header_logo_image', $logo_image );
	}
}
