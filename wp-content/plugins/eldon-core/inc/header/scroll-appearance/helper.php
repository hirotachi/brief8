<?php

if ( ! function_exists( 'eldon_core_dependency_for_scroll_appearance_options' ) ) {
	/**
	 * Function which return dependency values for global module options
	 *
	 * @return array
	 */
	function eldon_core_dependency_for_scroll_appearance_options() {
		return apply_filters( 'eldon_core_filter_header_scroll_appearance_hide_option', $hide_dep_options = array() );
	}
}
