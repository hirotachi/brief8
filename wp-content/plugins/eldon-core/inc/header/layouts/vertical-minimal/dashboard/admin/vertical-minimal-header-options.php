<?php

if ( ! function_exists( 'eldon_core_add_vertical_minimal_header_options' ) ) {
	/**
	 * Function that add additional header layout options
	 *
	 * @param object $page
	 * @param array $general_header_tab
	 */
	function eldon_core_add_vertical_minimal_header_options( $page, $general_header_tab ) {

		$section = $general_header_tab->add_section_element(
			array(
				'name'       => 'qodef_vertical_minimal_header_section',
				'title'      => esc_html__( 'Vertical Minimal Header', 'eldon-core' ),
				'dependency' => array(
					'show' => array(
						'qodef_header_layout' => array(
							'values'        => 'vertical-minimal',
							'default_value' => '',
						),
					),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_vertical_header_background_color',
				'title'       => esc_html__( 'Header Background Color', 'eldon-core' ),
				'description' => esc_html__( 'Enter header background color', 'eldon-core' ),
			)
		);
	}

	add_action( 'eldon_core_action_after_header_options_map', 'eldon_core_add_vertical_minimal_header_options', 10, 2 );
}
