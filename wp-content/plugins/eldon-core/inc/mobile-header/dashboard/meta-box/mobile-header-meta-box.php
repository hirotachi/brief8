<?php

if ( ! function_exists( 'eldon_core_add_page_mobile_header_meta_box' ) ) {
	/**
	 * Function that add general meta box options for this module
	 *
	 * @param object $page
	 */
	function eldon_core_add_page_mobile_header_meta_box( $page ) {

		if ( $page ) {
			$mobile_header_tab = $page->add_tab_element(
				array(
					'name'        => 'tab-mobile-header',
					'icon'        => 'fa fa-cog',
					'title'       => esc_html__( 'Mobile Header Settings', 'eldon-core' ),
					'description' => esc_html__( 'Mobile header layout settings', 'eldon-core' ),
				)
			);

			$mobile_header_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_mobile_header_layout',
					'title'       => esc_html__( 'Mobile Header Layout', 'eldon-core' ),
					'description' => esc_html__( 'Choose a mobile header layout to set for your website', 'eldon-core' ),
					'args'        => array( 'images' => true ),
					'options'     => eldon_core_header_radio_to_select_options( apply_filters( 'eldon_core_filter_mobile_header_layout_option', array() ) ),
				)
			);

			$mobile_header_tab->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_mobile_header_in_grid',
					'title'         => esc_html__( 'Content in Grid', 'eldon-core' ),
					'description'   => esc_html__( 'Set content to be in grid', 'eldon-core' ),
					'default_value' => '',
					'options'       => eldon_core_get_select_type_options_pool( 'no_yes' ),
				)
			);

			// Hook to include additional options after module options
			do_action( 'eldon_core_action_after_page_mobile_header_meta_map', $mobile_header_tab );
		}
	}

	add_action( 'eldon_core_action_after_general_meta_box_map', 'eldon_core_add_page_mobile_header_meta_box' );
}

if ( ! function_exists( 'eldon_core_add_general_mobile_header_meta_box_callback' ) ) {
	/**
	 * Function that set current meta box callback as general callback functions
	 *
	 * @param array $callbacks
	 *
	 * @return array
	 */
	function eldon_core_add_general_mobile_header_meta_box_callback( $callbacks ) {
		$callbacks['mobile-header'] = 'eldon_core_add_page_mobile_header_meta_box';

		return $callbacks;
	}

	add_filter( 'eldon_core_filter_general_meta_box_callbacks', 'eldon_core_add_general_mobile_header_meta_box_callback' );
}
