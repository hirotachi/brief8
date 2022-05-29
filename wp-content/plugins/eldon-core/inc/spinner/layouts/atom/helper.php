<?php

if ( ! function_exists( 'eldon_core_add_atom_spinner_layout_option' ) ) {
	/**
	 * Function that set new value into page spinner layout options map
	 *
	 * @param array $layouts - module layouts
	 *
	 * @return array
	 */
	function eldon_core_add_atom_spinner_layout_option( $layouts ) {
		$layouts['atom'] = esc_html__( 'Atom', 'eldon-core' );

		return $layouts;
	}

	add_filter( 'eldon_core_filter_page_spinner_layout_options', 'eldon_core_add_atom_spinner_layout_option' );
}
