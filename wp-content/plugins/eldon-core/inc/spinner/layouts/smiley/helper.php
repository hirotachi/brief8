<?php

if ( ! function_exists( 'eldon_core_add_smiley_spinner_layout_option' ) ) {
	/**
	 * Function that set new value into page spinner layout options map
	 *
	 * @param $layouts array - module layouts
	 *
	 * @return array
	 */
	function eldon_core_add_smiley_spinner_layout_option( $layouts ) {
		$layouts['smiley'] = esc_html__( 'Smiley', 'gracey-core' );
		
		return $layouts;
	}
	
	add_filter( 'eldon_core_filter_page_spinner_layout_options', 'eldon_core_add_smiley_spinner_layout_option' );
}

if ( ! function_exists( 'eldon_core_set_smiley_spinner_layout_as_default_option' ) ) {
	/**
	 * Function that set default value for page spinner layout options map
	 *
	 * @param string $default_value
	 *
	 * @return string
	 */
	function eldon_core_set_smiley_spinner_layout_as_default_option( $default_value ) {
		return 'smiley';
	}
	
	add_filter( 'eldon_core_filter_page_spinner_default_layout_option', 'eldon_core_set_smiley_spinner_layout_as_default_option' );
}
