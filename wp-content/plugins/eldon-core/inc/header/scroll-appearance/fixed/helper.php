<?php

if ( ! function_exists( 'eldon_core_add_fixed_header_option' ) ) {
	/**
	 * This function set header scrolling appearance value for global header option map
	 */
	function eldon_core_add_fixed_header_option( $options ) {
		$options['fixed'] = esc_html__( 'Fixed', 'eldon-core' );

		return $options;
	}

	add_filter( 'eldon_core_filter_header_scroll_appearance_option', 'eldon_core_add_fixed_header_option' );
}
