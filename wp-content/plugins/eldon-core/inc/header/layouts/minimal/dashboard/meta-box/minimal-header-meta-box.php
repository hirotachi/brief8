<?php

if ( ! function_exists( 'eldon_core_add_minimal_header_meta' ) ) {
	/**
	 * Function that add additional header layout meta box options
	 *
	 * @param object $page
	 */
	function eldon_core_add_minimal_header_meta( $page ) {

		$section = $page->add_section_element(
			array(
				'name'       => 'qodef_minimal_header_section',
				'title'      => esc_html__( 'Minimal Header', 'eldon-core' ),
				'dependency' => array(
					'show' => array(
						'qodef_header_layout' => array(
							'values'        => 'minimal',
							'default_value' => '',
						),
					),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'    => 'select',
				'name'          => 'qodef_minimal_header_in_grid',
				'title'         => esc_html__( 'Content in Grid', 'eldon-core' ),
				'description'   => esc_html__( 'Set content to be in grid', 'eldon-core' ),
				'default_value' => '',
				'options'       => eldon_core_get_select_type_options_pool( 'no_yes' ),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_minimal_header_height',
				'title'       => esc_html__( 'Header Height', 'eldon-core' ),
				'description' => esc_html__( 'Enter header height', 'eldon-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px', 'eldon-core' ),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_minimal_header_side_padding',
				'title'       => esc_html__( 'Header Side Padding', 'eldon-core' ),
				'description' => esc_html__( 'Enter side padding for header area', 'eldon-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px or %', 'eldon-core' ),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_minimal_header_background_color',
				'title'       => esc_html__( 'Header Background Color', 'eldon-core' ),
				'description' => esc_html__( 'Enter header background color', 'eldon-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px', 'eldon-core' ),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_minimal_header_border_color',
				'title'       => esc_html__( 'Header Border Color', 'eldon-core' ),
				'description' => esc_html__( 'Enter header border color', 'eldon-core' ),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_minimal_header_border_width',
				'title'       => esc_html__( 'Header Border Width', 'eldon-core' ),
				'description' => esc_html__( 'Enter header border width size', 'eldon-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px', 'eldon-core' ),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'select',
				'name'        => 'qodef_minimal_header_border_style',
				'title'       => esc_html__( 'Header Border Style', 'eldon-core' ),
				'description' => esc_html__( 'Choose header border style', 'eldon-core' ),
				'options'     => eldon_core_get_select_type_options_pool( 'border_style' ),
			)
		);
	}

	add_action( 'eldon_core_action_after_page_header_meta_map', 'eldon_core_add_minimal_header_meta' );
}
